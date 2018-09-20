<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Router.interface.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * You may contact the authors of web.framework by e-mail at:
 * webframe@staniszczak.pl
 *
 * The latest version of web.framework can be obtained from:
 * http://sourceforge.net/projects/webframework
 *
 * @link http://sourceforge.net/projects/webframework
 * @copyright 2005 Marcin Staniszczak
 * @author Marcin Staniszczak <marcin@staniszczak.pl>
 * @version 1.0.0
 */


/**
 * This interface must be implemented by Routers class.
 * Router class answer for control URL addreses. Class this generate 
 * URL based on PHP's array (see makeURL() method) and get variables
 * from URL (like a $_GET variable).
 *
 * @name IRouter
 * @version 1.0.0
 * @package web.framework
 * @subpackage Context
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
interface IRouter {
	/**
	 * The class constructor
	 *
	 * @access public
	 * @param string URL base (for example it's www.someurl.com from www.someurl.com/action=mypage URL)
	 * @param string default language name
	 */
	public function __construct($strURL, $strDefaultLanguage);
	
	/**
	 * Make URL based on PHP's array
	 *
	 * @access public
	 * @param array array with variables to make URL (array('foo'=>'bar', 'foo2') make URL www.someurl.com/foo=bar&foo2)
	 * @param boolean true==HTTPS, false==HTTP
	 * @return string new URL address
	 */
	public function makeURL($arrVariables, $blnSSL=false);
	
	/**
	 * Return action name (or null)
	 *
	 * @access public
	 * @return string action name, or null, when action is undefined
	 */	
	public function getAction();
	
	/**
	 * Return action chain name (or null)
	 *
	 * @access public
	 * @return string action chain name, or null, when action chain is undefined
	 */	
	public function getActionChain();
	
	/**
	 * Set new action name (for change it before use makeURL() method)
	 *
	 * @access public	 
	 * @param string new action name
	 * @return string last action name, or null, when action was undefined
	 */	
	public function setAction($strAction);
	
	/**
	 * Set new action chain name (for change it before use makeURL() method)
	 *
	 * @access public	 
	 * @param string new action chain name
	 * @return string last action chain name, or null, when action chain was undefined
	 */	
	public function setActionChain($strActionChain);
	
	/**
	 * Get language name (or null)
	 *
	 * @access public
	 * @return string language name, or null when langauge isn't set in URL and isn't set default language in constructor
	 */	
	public function getLanguage();
	
	/**
	 * Get variable from URL (like $_GET)
	 *
	 * @access public
	 * @param string key
	 * @param string default value (when key doesn't exist in URL)
	 * @return string value
	 */	
	public function get($strKey, $strDefault=null);
	
	/**
	 * Return array with all variables form URL (return $_GET array)
	 *
	 * @access public
	 * @return array all variables
	 */	
	public function getAll();
}
?>