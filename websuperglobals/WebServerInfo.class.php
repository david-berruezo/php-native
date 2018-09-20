<?php
// uncomment the line blow if you want to have $_SERVER exported without creating obj instance in your code.
// $________this_variable_will_help_SERVER_variable_to_be_exported = new WebServerInfo();

/**
 * Interface for accessing web server properties no matter what web server
 * is used appropriate values are returned.
 * Using apache style variables and unix slashes in path.
 * Currently Supported Servers
 *   - Apache
 *   - IIS
 *
 * @package WebServerInfo
 * @author Svetoslav Marinov <svetoslavm@gmail.com>
 * @link http://seofilter.com
 * @version 1.0.0
 * @copyright November 19th, 2006
 * @access public
 */

class WebServerInfo {

    /**
     * Class Constructor
     *
     * @return WebServerInfo
     */
    function WebServerInfo() {
       /*
        REQUEST_URI
        REDIRECT_URL
        DOCUMENT_ROOT
        SERVER_SIGNATURE
        SERVER_ADDR
        SCRIPT_FILENAME
        */
        // convert to unix slashes
        $_SERVER['PATH_TRANSLATED'] = preg_replace('#[\\\\\/]+#si', '/', $_SERVER['PATH_TRANSLATED']);

        // REQUEST_URI
        if (empty($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = $_SERVER["SCRIPT_NAME"];

            if (!empty($_SERVER['QUERY_STRING'])) {
                $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
            }
        }

        // REDIRECT_URL
        if (empty($_SERVER['REDIRECT_URL'])) {
          $_SERVER['REDIRECT_URL'] = $_SERVER['REQUEST_URI'];
        }

        // SERVER_SIGNATURE
        // e.g.: Apache Server at lordspace Port 80
        if (empty($_SERVER['SERVER_SIGNATURE'])) {
          $_SERVER['SERVER_SIGNATURE'] = $_SERVER['SERVER_SOFTWARE']
              . ' Server'
              . ' at '
              . $_SERVER['SERVER_NAME']
              . ' Port '
              . $_SERVER['SERVER_PORT'];

           $_SERVER['SERVER_SIGNATURE'] = "<address>"
              . $_SERVER['SERVER_SIGNATURE']
              . "</address>";
        }

        // SCRIPT_FILENAME
        if (empty($_SERVER['SCRIPT_FILENAME'])) {
           $_SERVER['SCRIPT_FILENAME'] = preg_replace('#[\\\\]+#si', '/', $_SERVER['PATH_TRANSLATED']);
        }

        // SERVER_ADDR
        if (empty($_SERVER['SERVER_ADDR'])
              && !empty($_SERVER['LOCAL_ADDR'])) {
           $_SERVER['SERVER_ADDR'] = $_SERVER['LOCAL_ADDR'];
        }

        // DOCUMENT ROOT
        if (empty($_SERVER['DOCUMENT_ROOT'])) {
           // Document root is in path translated
           if (preg_match("#(.*?){$_SERVER['REQUEST_URI']}#si", $_SERVER['PATH_TRANSLATED'], $matches)) {

              $_SERVER['DOCUMENT_ROOT'] = $matches[1];
              $_ENV['DOCUMENT_ROOT']    = $matches[1];
           }
        }
    }

    /**
     * Returns currently requested variable depending on web server.
     * e.g. $web_server->get('DOCUMENT_ROOT');
     * @param string $key
     * @return string
     */
    function get($key) {
        // The key should be available now. :)
        if (!empty($_SERVER[$key])) {
            return $_SERVER[$key];
        }
    }
}

?>