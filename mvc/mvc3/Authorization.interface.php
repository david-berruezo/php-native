<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Authorization.interface.php
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
 * This interface must be implement by any authorization classes
 *
 * @name IAuthorization
 * @version 1.0.0
 * @package web.framework
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
interface IAuthorization {
	/**
	 * The class constructor
	 *
	 * @access public
	 * @param HTTPRequest object of HTTP request class
	 * @param Session Session object
	 */
	public function __construct(HTTPRequest $objRequest, Session $objSession);

	/**
	 * Check access
	 *
	 * @access public
	 * @param string current action name
	 * @param string current action chain name
	 * @param string info form configuration file (<action ... authorization="info" ...>)
	 */
	public function check($strAction, $strActionChain, $strInfo);
}
?>