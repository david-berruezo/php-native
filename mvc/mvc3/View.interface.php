<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		View.interface.php
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
 * This interface must be implemented by any view
 *
 * @name IView
 * @version 1.0.0
 * @package web.framework
 * @subpackage View
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
interface IView {
	/**
	 * This is main function of a view (this function will be execute by framework after execute action)
	 *
	 * @access public
	 * @param string name of action which execute this view
	 * @param string view name from forward
	 * @param mixed action execute result
	 * @param ITemplate templates object (or null)
	 */
	public function display($strActionName, $strForwardName, $mixActionResult, $objTemplate=null);
}
?>