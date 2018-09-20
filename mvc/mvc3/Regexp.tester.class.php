<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Regexp.tester.class.php
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
 * Regexp test values from HTML form
* Required parameter regexp contain regexp pattern.
 *
 * @name Regexp
 * @version 1.0.0
 * @package web.framework
 * @subpackage Validators
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class Regexp implements ITester {
	/**
	 * This is tester's main method
	 *
	 * @param string web form value
	 * @param array tester's setting array - array('name'=>'value')
	 * @return boolean true - form value and setting value are are equal, false - they aren't equal
	 * @throws WF_Tester_RequiredParameter
     */
	public function execute($strValue, $arrParameters) {
		if (!isset($arrParameters['pattern'])) {
			new throw new WF_Tester_RequiredParameter();
		}

		return preg_match($arrParameters['pattern'], $strValue) ? true : false;
	}
}
?>