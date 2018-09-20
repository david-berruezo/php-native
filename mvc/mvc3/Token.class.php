<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Token.class.php
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
 * This class manage tokens
 *
 * @name Token
 * @version 1.0.0
 * @package web.framework
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class Token {
	private
		$objToken = null,
		$blnCheck = false,
		$strNewToken = null,
		$strTokenFormName = null;


	/**
	 * The class constructor
	 *
	 * @param string token's form name
	 * @param integer token's send method (HTTPRequest::GET, HTTPRequest::POST)
	 * @param HTTPRequest object of HTTP request class
	 * @param Session Session object
	 * @param string token's class
	 */
	public function __construct($strTokenFormName, $intTokenSendMethod, HTTPRequest $objRequest, Session $objSession, $strTokenClassName = null) {
		$this->strTokenFormName = $strTokenFormName;
		if ($strTokenClassName !== null) {
			require_once(WEBFRAMEWORK_CORE_DIR.'Token'.DIRECTORY_SEPARATOR.'Tokens'.DIRECTORY_SEPARATOR.$strTokenClassName.'.class.php');

			$this->objToken = new $strTokenClassName($strTokenFormName, $intTokenSendMethod, $objRequest, $objSession);

			if (!$this->objToken instanceof IToken) {
				throw new WF_Exception(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['TOKEN_INTERFACE']);
			}
		} else {
			$this->objToken = new  DefaultToken($strTokenFormName, $intTokenSendMethod, $objRequest, $objSession);
		}

		$this->blnCheck = $this->objToken->checkToken();
		$this->strNewToken = $this->objToken->generateToken();
		$this->objToken->saveToken();

		//echo "Check: ".$this->blnCheck."<br> New token: ".$this->strNewToken." Session token: <br>".$objSession->get('__WEBFRAMEWORK_TOKEN_ID__')."<br> Last Token: ".$this->objToken->getLastToken();
	}

	/**
	 * Get current token
	 *
	 * @access public
	 * @return string surrent token
	 */
	public function get() {
		return $this->objToken->get();
	}

	/**
	 * Get last token
	 *
	 * @access public
	 * @return string last token
	 */
	public function getLastToken() {
		return $this->objToken->getLastToken();
	}

	/**
	 * Return token form name
	 *
	 * @access public
	 * @return string token form name
	 */
	public function getTokenFormName() {
		return $this->strTokenFormName;
	}

	/**
	 * Compare token from form with token
	 *
	 * @access public
	 * @return unknown
	 */
	public function check() {
		return $this->blnCheck;
	}
}
?>