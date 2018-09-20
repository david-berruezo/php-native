<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		IsNumeric.tester.class.php
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
 * Finds whether a form value is a number
 *
 * @name IsNumeric
 * @version 1.0.0
 * @package web.framework
 * @subpackage Validators 
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class IsNumeric implements ITester {
	/**
	 * This is tester's main method
	 *
	 * @param string web form value
	 * @param array tester's setting array - array('name'=>'value')
	 * @return boolean true - text is a number, false - text isn't a number
     */
	public function execute($strValue, $arrParameters) {
		return is_numeric($strValue);
	}
}
?>