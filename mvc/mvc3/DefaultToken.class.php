<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		DefaultToken.class.php
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
 * This class generate transaction's (but not only) token
 *
 * @name DefaultToken
 * @version 1.0.0
 * @package web.framework
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class DefaultToken implements IToken {
	private
		$strToken = null,
		$strLastToken = null;

	private
		$objRequest,
		$objSession;

	private
		$strFormTokenName,
		$intTokenSendMethod;

	const
		TOKEN_SESSION_ID = '__WEBFRAMEWORK_TOKEN_ID__';

	/**
	 * The class constructor
	 *
	 * @access public
	 * @param string token name in form
	 * @param integer token send method (HTTPRequest::GET, HTTPRequest::POST)
	 * @param HTTPRequest object of HTTP request class
	 * @param Session Session object
	 */
	public function __construct($strFormTokenName, $intTokenSendMethod, HTTPRequest $objRequest, Session $objSession) {
		$this->objRequest = $objRequest;
		$this->objSession = $objSession;

		$this->strFormTokenName = $strFormTokenName;
		$this->intTokenSendMethod = $intTokenSendMethod;

		$this->strLastToken = $objSession->get(self::TOKEN_SESSION_ID);
	}


	/**
	 * Generate new token
	 *
	 * @access public
	 * @return string new token
	 */
	public function generateToken() {
		$this->strToken = md5(uniqid(rand(), true));

		return $this->strToken;
	}

	/**
	 * Current token
	 *
	 * @access public
	 * @return string current token
	 */
	public function get() {
		return $this->strToken;
	}

	/**
	 * Return last token ID
	 *
	 * @access public
	 * @return string last token ID
	 */
	public function getLastToken() {
		return $this->strLastToken;
	}


	/**
	 * Save current token
	 *
	 * @access public
	 */
	public function saveToken() {
		$this->objSession->set(self::TOKEN_SESSION_ID, $this->strToken);
	}

	/**
	 * Check current token with token from parameter
	 *
	 * @access public
	 * @return boolean true - token from parameter was identical with saved token, false - tokens was diffrent
	 */
	public function checkToken() {
		$strTokenFromForm = ($this->intTokenSendMethod == HTTPRequest::GET) ? $this->objRequest->getParameter($this->strFormTokenName, HTTPRequest::GET) : $this->objRequest->getParameter($this->strFormTokenName, HTTPRequest::POST);

		//echo "<br>".$this->objRequest->getParameter($this->strFormTokenName, HTTPRequest::POST);
		return (strcmp($this->objSession->get('__WEBFRAMEWORK_TOKEN_ID__'), $strTokenFromForm)==0) ? true : false;
	}
}
?>