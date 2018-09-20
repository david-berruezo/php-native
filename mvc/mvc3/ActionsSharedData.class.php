<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		ActionSharedData.class.php
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
 * This class control actions shared data (it's singleton)
 *
 * @name ActionsSharedData
 * @version 1.0.0
 * @package web.framework
 * @subpackage Actions
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class ActionsSharedData {
	private static
		$objThis = null;
		
	private
		$arrVars = array();
		
	/**
	 * The class constructor (private)
	 *
	 * @access private	 
	 */
	private function __construct() {}

	/**
	 * Make or return instance of this class
	 *
	 * @access private
	 * @static 
	 * @return ActionsSharedData obiekt klasy
	 */
	public static function construct() {
		if (isset(self::$objThis)) {
			return self::$objThis;
		} else {
			self::$objThis = new self();
		}		
		
		return self::$objThis;
	}

	/**
	 * Add new variable to shared data
	 *
	 * @access public
	 * @param mixed name of variable or array (array('name'=>'value', 'name2'=>'value2'))
	 * @param mixed value
	 */
	public function addData($mixVar, $mixValue=null) {
		if (is_array($mixVar)) {
			foreach ($mixVar as $key=>$val) {
				if (strlen($key)>0) {
					$this->arrVars[$key] = $val;
				}
			}
		} else {
			if (strlen($mixVar)>0) {
				$this->arrVars[$mixVar] = $mixValue;
			}
		}		
	}
	
	/**
	 * Insert into array $strVar new element
	 *
	 * @access public
	 * @param string array name
	 * @param mixed value to insert
	 * @throws WF_Exception
	 */
	public function insertData($strVar, $mixValue=null) {
		if (!is_string($strVar)) {
			throw new WF_Exception(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['STRING_PARAM']);
		}

		if (!isset($this->arrVars[$strVar])) {
			$this->arrVars[$strVar] = array();
		}
			
		$this->arrVars[$strVar][] = $mixValue;
	}
	
	/**
	 * Return all data from shared data as array
	 *
	 * @access public
	 * @return array array with all data from shared data
	 */
	public function getAllData() {
		return $this->arrVars;
	}
	
	/**
	 * Return data
	 *
	 * @access public
	 * @param string name of data
	 * @return mixed value
	 */
	public function getData($strName) {
		if (isset($this->arrVars[$strName])) {
			return $this->arrVars[$strName];
		} else {
			return null;
		}
	}
}
?>