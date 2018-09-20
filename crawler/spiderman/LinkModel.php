<?php

namespace Crawler\Models;

class LinkModel {
    public static function __callStatic($name, $arguments) {
        return call_user_func_array(array(self::get(), '_'.$name), $arguments);
    }

    private static $instance = null;

    public static function get() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $presentStmt = null;
    private $countQueuedStmt = null;
    private $countTotalStmt = null;

    private function __construct() {
        $this->presentStmt = \Crawler\Database::prepare('SELECT `id` FROM `urls` WHERE `url` = :url AND `executed` > (UTC_TIMESTAMP() - INTERVAL 1 MONTH) LIMIT 1;');
        $this->detailsStmt = \Crawler\Database::prepare('SELECT `job_id` AS `job` FROM `urls` WHERE `url` = :url AND `executed` > (UTC_TIMESTAMP() - INTERVAL 1 MONTH) LIMIT 1;');
        $this->insertStmt = \Crawler\Database::prepare('INSERT INTO `urls` (`url`, `is_crawled`, `executed`, `source`, `job_id`) VALUES (:url, :crawled, UTC_TIMESTAMP(), :source, :job)');
        $this->updateStmt = \Crawler\Database::prepare('UPDATE `urls` SET `is_crawled` = :crawled WHERE `url` = :url AND `executed` > (UTC_TIMESTAMP() - INTERVAL 1 MONTH) LIMIT 1;');

        $this->countQueuedStmt = \Crawler\Database::prepare('SELECT COUNT(id) AS `total` FROM `urls` WHERE (`url` LIKE :domaina OR url LIKE :domainb) AND `source` IS NULL AND `is_crawled` = 0 AND `executed` > (UTC_TIMESTAMP() - INTERVAL 1 MONTH);');
        $this->countTotalStmt = \Crawler\Database::prepare('SELECT COUNT(id) AS `total` FROM `urls` WHERE (`url` LIKE :domaina OR url LIKE :domainb) AND `source` IS NULL AND `executed` > (UTC_TIMESTAMP() - INTERVAL 1 MONTH);');
    }

    public function _isPresent($url) {
        $this->presentStmt->execute(array('url' => strtolower($url)));
        $result = $this->presentStmt->fetch(\PDO::FETCH_ASSOC);
        return is_array($result);
    }

    /**
     * crawled : The engine extracted this url
     * redirectedFrom : The url it cames from, was redirected
     *
     * In certain case, crawled != fetched. This means the $url was a redrection from an other url
     */
    public function _add($url, $crawled = false, $redirectedFrom = null, $jobId = null) {
        $url = strtolower($url);
        if (is_null($jobId)) {
            $this->detailsStmt->execute(array('url' => $url));
            $result = $this->detailsStmt->fetch(\PDO::FETCH_ASSOC);

            // We search if already exists
            if (is_array($result)) {
                $this->_update($url, $crawled);

                // And return the job id if present !
                return (empty($result['job']) ? null : $result['job']);
            }
        }

        // We insert
        $this->insertStmt->execute(array(
            'url' => $url,
            'crawled' => $crawled,
            'source' => $redirectedFrom,
            'job' => $jobId
        ));

        return null;
    }

    public function _update($url, $crawled = false) {
        $url = strtolower($url);

        $this->updateStmt->execute(array(
            'url' => $url,
            'crawled' => $crawled
        ));
    }

    public function _countQueued($domain) {
        $this->countQueuedStmt->execute(array(
            'domaina' => 'http://'.$domain.'%',
            'domainb' => 'https://'.$domain.'%',
        ));
        $result = $this->countQueuedStmt->fetch(\PDO::FETCH_ASSOC);
        if (!is_array($result)) return 0;

        return $result['total'];
    }

    public function _countTotal($domain) {
        $this->countTotalStmt->execute(array(
            'domaina' => 'http://'.$domain.'%',
            'domainb' => 'https://'.$domain.'%',
        ));
        $result = $this->countTotalStmt->fetch(\PDO::FETCH_ASSOC);
        if (!is_array($result)) return 0;

        return $result['total'];
    }
}