<?php
if (php_sapi_name() !== 'cli') exit(1);

require_once(__DIR__.'/../init.php');

define('WORKER_LIMIT_INSTANCES', 200);
define('CRAWLER_MAX_DEPTH', 10000);
define('CRAWLER_MAX_HIGH_URLS', 100);

use \Pheanstalk\Pheanstalk;
use \Crawler\Models\LinkModel;

$pheanstalk = new Pheanstalk('127.0.0.1');

$reloadedInitialTime = filemtime(__DIR__.'/../reloaded');
fwrite(STDOUT, "Started new instance of script (".$reloadedInitialTime.").\n");

$loopCounter = 0;
while (true) {
    clearstatcache();

    // Script to stop the service
    if (intval(file_get_contents(__DIR__.'/../breakworker')) === 1 ) exit(1);

    // We check if we need to stop this worker (code update?)
    $autoReloadSystem = filemtime(__DIR__.'/../reloaded');
    if ($reloadedInitialTime !== $autoReloadSystem) {
        fwrite(STDOUT, "New update - Reloading script.\n");
        exit(0);
    }

    usleep(500000); // Give it some slack ; 1/2 second

    $loopCounter++;
    if ($loopCounter > WORKER_LIMIT_INSTANCES) break; // We count on Supervisord to reload workers

    // grab the next job off the queue and reserve it
    $job = $pheanstalk->watch(QUEUE_NAME)
        ->ignore('default')
        ->reserve();

    // remove the job from the queue
    $pheanstalk->delete($job);

    $data = json_decode($job->getData(), true);
    if (is_null($data)) {
        fwrite(STDERR, "[FATAL] Invalid Job data : ".$job->getData()."\n");
    }

    if (!isset($data['retries']))  $data['retries'] = 0;
    if (!isset($data['priority'])) $data['priority'] = \Crawler\Engine\Spider::MEDIUM_PRIORITY;

    if ($data['priority'] == \Crawler\Engine\Spider::LOW_PRIORITY) {
        // Normally, only new links are in low priority
        $data['priority'] = \Crawler\Engine\Spider::MEDIUM_PRIORITY;
    }

    /*
     * The "Spider" goes to the website using a basic CURL request
     * It also pre-fetch the robots.txt the first request to ensure we respect it
     * With the following CURL rules :
     *  CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_FORBID_REUSE   => true,
        CURLOPT_FRESH_CONNECT  => true,
        CURLOPT_HEADER         => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_ENCODING       => ''
     */
    $spider = new \Crawler\Engine\Spider($data['url']);
    $duration = $spider->exec();

    // First, we ensure that we are not black-listed
    // So we analyze the status code
    // For 401, 403 and 404, we retry once
    // For 408, 429 and 503, we retry 3 times, with increasing wait between requests

    if (in_array($spider->getStatusCode(), array(401, 403, 404, 408, 429, 503))) {
        $data['retries']++;
        if ((in_array($spider->getStatusCode(), array(401, 403, 404)) && $data['retries'] <= 1) // Only one retry
            ||
            (in_array($spider->getStatusCode(), array(408, 429, 503)) && $data['retries'] <= 3) // 3 retries
        ) {
            $pheanstalk->putInTube(QUEUE_NAME, json_encode($data), $data['priority'], $data['retries'] * 30);
            continue;
        }

        // We are here (and not in the "if" section) when the status code is in the array
        // but the retries are reached, that mean we stop for this url
        // So the next step will be to add it in the Link database and stop the data.
    }

    // We update the url in the database to indicate it has been crawled
    LinkModel::update($data['url'], true);
    if (strtolower($data['url']) !== strtolower($spider->getUrl())) {
        // We were redirected, so we add a new URL also marked as being crawled, with $data['url'] being the origin
        $jobId = LinkModel::add($spider->getUrl(), true, $data['url']);
        // We remove the job of the redirect url because we had it already in queue
        if (!is_null($jobId)) {
            // We catch exception in case the url has already been processed
            try {
                $job = $pheanstalk->peek($jobId);
                $pheanstalk->delete($job);
            } catch (\Exception $e) {}
        }
    }

    $domainName = $spider->getUrlParts(PHP_URL_HOST);
    $domainName = strtolower($domainName['host']);

    // Here's the code I do to index the webpages
    // I removed it because it's not interesting in our case
    // But in general, if you are looking for a similar work, you can implement your need here :)

    // This code extract all the links in the page to add them in the queue
    $links = \Crawler\Extractors\LinkExtractor::extract($spider);

    // And we add them now :
    $priority = $data['priority'];
    foreach ($links as $link) {
        $parsedDomain = strtolower(parse_url($link, PHP_URL_HOST));

        $jobsData = array(
            'url' => $link,
            'retries' => 0,
            'referer' => $spider->getUrl()
        );

        $jobsData['delay'] = ceil($duration * (rand(1, 10)/10000)); // Delay between 0.1 and 1 seconds x $duration of the request
        if ($jobsData['delay'] > 5) $jobsData['delay'] = 5;

        // We increase the time to wait per number of links for this specific domain
        $jobsData['delay'] = $jobsData['delay'] + LinkModel::countQueued($parsedDomain);

        if (\Crawler\Engine\Spider::HIGH_PRIORITY) {
            // Allow 5 simultaneous request on high priority
            $jobsData['delay'] = floor($jobsData['delay'] / 10);
        }

        $iCountCrawledUrls = LinkModel::countTotal($parsedDomain);
        if ($iCountCrawledUrls > CRAWLER_MAX_DEPTH) break; // We stop crawling this domain

        if ($domainName === $parsedDomain) {
            if ($priority === \Crawler\Engine\Spider::HIGH_PRIORITY && $iCountCrawledUrls > CRAWLER_MAX_HIGH_URLS) {
                $priority = \Crawler\Engine\Spider::MEDIUM_PRIORITY;
            }
            $jobsData['priority'] = $priority;
        } else {
            $jobsData['priority'] = \Crawler\Engine\Spider::LOW_PRIORITY;
        }

        $jobId = $pheanstalk->putInTube(QUEUE_NAME, json_encode($jobsData), $jobsData['priority'], $jobsData['delay']);

        // The add method checks if the url is already present in the database
        // To avoid adding multiple time the same url (and going in loop in case two sites links to each others !)
        LinkModel::add($link, false, null, $jobId);
    }
}