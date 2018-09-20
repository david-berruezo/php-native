<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		HTTPRequest.class.php
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
 * GET, POST and COOKI control class
 *
 * @name HTTPRequest
 * @version 1.0.0
 * @package web.framework
 * @subpackage Context
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class HTTPRequest {
	const
		POST = 1,
		GET = 2,
		COOKIE = 3;
		
	private
		$objRouter = null,
		
		$arrPOST = array(),
		$arrCOOKIE = array();

	/**
	 * The class constructor
	 *
	 * @access public
	 * @param IRouter router object - required for support GET variables
	 */
	public function __construct(IRouter $objRouter) {
		$this->objRouter = $objRouter;
				
		if (isset($_POST)) {
			$this->arrPOST = $_POST;
			unset($_POST);
		}
		
		if (isset($_COOKIE)) {
			$this->arrCOOKIE = $_COOKIE;		
			unset($_COOKIE);
		}
	}
	
	
	/**
	 * Return all variables of given type
	 *
	 * @access public
	 * @param integer variables types: HTTPRequest::GET, HTTPRequest::POST, HTTPRequest::COOKIE
	 * @return array array witch variables
	 */
	public function getParameters($intType) {
		if ($intType==self::GET) {
			return $this->objRouter->getAll();
		} elseif ($intType==self::POST) {
			return $this->arrPOST;
		} elseif ($intType==self::COOKIE) {
			return $this->arrCOOKIE;
		} else {
			return null;
		}
	}
	
	/**
	 * Return variable of given type
	 *
	 * @access public
	 * @param string variable name
	 * @param integer variable types: HTTPRequest::GET, HTTPRequest::POST, HTTPRequest::COOKIE
	 * @return mixed value
	 */
	public function getParameter($strKey, $intType) {
		if ($intType==self::GET) {
			return $this->objRouter->get($strKey);
		} elseif ($intType==self::POST && isset($this->arrPOST[$strKey])) {
			return $this->arrPOST[$strKey];
		} elseif ($intType==self::COOKIE  && isset($this->arrCOOKIE[$strKey])) {
			return $this->arrCOOKIE[$strKey];
		} else {
			return null;
		}
	}
	
	/**
	 * Get language name (or null)
	 *
	 * @access public
	 * @return string language name, or null
	 */		
	public function getLangauge() {
	    $this->objRouter->getLanguage();
	}

	/**
	 * Make URL based on PHP's array
	 *
	 * @access public
	 * @param array array with variables to make URL (array('foo'=>'bar', 'foo2') make URL www.someurl.com/foo=bar&foo2)
	 * @param boolean true==HTTPS, false==HTTP
	 * @return string new URL address
	 */
	public function makeURL($arrVariables, $blnSSL=false) {
	    return $this->objRouter->makeURL($arrVariables, $blnSSL);
	}
	
	/**
	 * Return Router object
	 *
	 * @access public
	 * @return mixed IRouter object
	 */
	public function getRouter() {
		return $this->objRouter;
	}
}
?>