<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		ValidatorsParser.interface.php
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
 * This interface must be implemented by any validator's parsers class
 *
 * @name IValidatorsParser
 * @version 1.0.0
 * @package web.framework
 * @subpackage Validators 
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
interface IValidatorsParser {	
	/**
	 * Parsing validator's configuration from XML file into PHP file
	 *
	 * @access public
	 * @param string validator's configuration file name
	 * @return array array with validator's configuration
	 * @throws WF_ParseConfig_Exception
	 */
	public function &parse($strConfigFile);
}

/**
 * Exception of validator's parsers class
 * @package web.framework
 * @subpackage exceptions 
 */
class WF_ValidatorsParser_Exception extends Exception {}

?>