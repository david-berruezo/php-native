<?php

namespace Crawler\Extractors;

class LinkExtractor {
    private static $excludes = array(
        '.png', '.gif', '.jpg', '.jpeg', '.svg', '.mp3', '.mp4', '.avi', '.mpeg', '.ps', '.swf', '.webm', '.ogg', '.pdf',
        '.3gp', '.apk', '.bmp', '.flac', '.gz', '.gzip', '.jpe', '.kml', '.kmz', '.m4a', '.mov', '.mpg', '.odp', '.oga', '.ogv', '.pps', '.pptx', '.qt', '.tar', '.tif', '.wav', '.wmv', '.zip',

        // Removed '.js', '.coffee', '.css', '.less', '.csv', '.xsl', '.xsd', '.xml', '.html', '.html', '.php', '.txt', '.atom', '.rss'

        // Implement later ?
        '.doc', '.docx', '.ods', '.odt', '.xls', '.xlsx',
    );

    private static $excludedDomains = array(
        '.google.', '.facebook.', '.bing.'
    );

    private static function _getBaseUrl($parsed_url) {
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '//';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';

        return strtolower("$scheme$host$port");
    }

    public static function extract(\Crawler\Engine\Spider $spider) {
        $parsed = parse_url(strtolower($spider->getUrl()));
        if (!isset($parsed['scheme'])) {
            $parsed['scheme'] = 'http';
        }

        $base = self::_getBaseUrl($parsed);
        $host_length = strlen($parsed['host']);

        preg_match_all("/(href|src)=[\'\"]?([^\'\">]+)/i", $spider->getSource(), $out);
        $linkPattern = '/^(?:[;\/?:@&=+$,]|(?:[^\W_]|[-_.!~*\()\[\] ])|(?:%[\da-fA-F]{2}))*$/';

        $urls = array();
        if (is_array($out) && isset($out[2])) {
            foreach ($out[2] as $key=>$url) {
                if (substr($url, 0, 2) === '#!') {
                    // see https://developers.google.com/webmasters/ajax-crawling/docs/getting-started
                    $url = $base.$parsed['path'].'?_escaped_fragment_='.substr($url, 2);
                } else if (substr($url, 0, 2) === '//') { // generic scheme
                    $url = $parsed['scheme'].'://'.$url;
                } else if (substr($url, 0, 1) === '/') { // generic scheme
                    $url = $base.$url;
                } else if (substr($url, 0, 4) !== 'http') {
                    continue;
                }

                if (strlen($url) > 250) continue; // We ignore too long urls

                $urll = strtolower($url);

                $parsed_url = parse_url($url);
                if ($parsed_url === false) continue; // We ignore invalid urls
                if (preg_match($linkPattern, $urll) !== 1) continue;

                $isExcluded = false;
                foreach (self::$excludes as $exclude) {
                    if (substr($urll, strlen($exclude) * -1) === $exclude) {
                        $isExcluded = true;
                        break;
                    }
                }

                foreach (self::$excludedDomains as $exclude) {
                    if (strpos($urll, $exclude) !== false) {
                        $isExcluded = true;
                        break;
                    }
                }

                if ($isExcluded) continue; // We ignore some extensions
                if (\Crawler\Models\LinkModel::isPresent($url)) continue; // We don't add a link that is already present
                if (\Crawler\RobotsTxtParser::disallowed($url)) continue; // We respect robots.txt

                $urls[$url] = true;
            }
        }

        return array_keys($urls);
    }
}