<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Token.interface.php
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
 * This interface must be implement by any token's class
 *
 * @name IToken
 * @version 1.0.0
 * @package web.framework
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
interface IToken {
	/**
	 * The class constructor
	 *
	 * @access public
	 * @param string token name in form
	 * @param integer token send method (HTTPRequest::GET, HTTPRequest::POST)
	 * @param HTTPRequest object of HTTP request class
	 * @param Session Session object
	 */
	public function __construct($strFormTokenName, $intTokenSendMethod, HTTPRequest $objRequest, Session $objSession);

	/**
	 * Generate new token
	 *
	 * @access public
	 * @return string new token
	 */
	public function generateToken();

	/**
	 * Current token
	 *
	 * @access public
	 * @return string current token
	 */
	public function get();

	/**
	 * Return last token
	 *
	 * @access public
	 * @return string last token
	 */
	public function getLastToken();

	/**
	 * Save current token
	 *
	 * @access public
	 */
	public function saveToken();

	/**
	 * Check current token with token from parameter
	 *
	 * @return boolean true - token from parameter was identical with saved token, false - tokens was diffrent
	 */
	public function checkToken();
}
?>