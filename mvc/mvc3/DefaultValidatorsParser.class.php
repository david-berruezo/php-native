<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		DefaultValidatorsParser.class.php
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
 * Class of validator's  configuration parser
 *
 * @name DefaultValidatorsParser
 * @version 1.0.0
 * @package web.framework
 * @subpackage Validators
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class DefaultValidatorsParser implements IValidatorsParser {
	private
		$arrConfiguration = array();
	
	/**
	 * Parse XML configuration into PHP's array
	 *
	 * @access public
	 * @param string validator's configuration file name
	 * @return array array with validator's configuration
	 * @throws WF_ParseConfig_Exception
	 */
	public function &parse($strConfigFile) {
		$objXML = simplexml_load_file($strConfigFile);
		
		if ($objXML===false) {
			throw new WF_ValidatorsParser_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['PARSER']['LOAD']);
		}
			
		$arrExecuteRequest = array();
		$arrTests = array();
		foreach ($objXML->children() as $strTag=>$objTag) {
			/*
			 * execute-request
			 */			
			if (strcmp($strTag, 'execute-request')==0) {
				foreach ($objTag as $strSettings=>$objSetting) {
					if (strcmp($strSettings, 'get')==0) {
						if (!isset($arrExecuteRequest['get'])) {
							$arrExecuteRequest['get'] = array();
						}
							
						$arrExecuteRequest['get'] = array_merge($arrExecuteRequest['get'], $this->parseExecuteRequest($objSetting));
					} elseif(strcmp($strSettings, 'post')==0) {
						if (!isset($arrExecuteRequest['post'])) {
							$arrExecuteRequest['post'] = array();
						}
							
						$arrExecuteRequest['post'] = array_merge($arrExecuteRequest['post'], $this->parseExecuteRequest($objSetting));
					}
				}
				
				if (isset($objTag['else'])) {
					$arrExecuteRequest['else'] = (string)$objTag['else'];
				}
			}
			
			/*
			 * tests
			 */
			if (strcmp($strTag, 'tests')==0) {
				foreach ($objTag as $strTest=>$objTest) {
					$strIndex = '';
					if (strcmp($strTest, 'get')==0) {
						if (!isset($arrTests['get'])) {
							$arrTests['get'] = array();
							$arrTests['get']['validators'] = array();
							$strIndex = 'get';
						}
					} elseif (strcmp($strTest, 'post')==0) {
						if (!isset($arrTests['post'])) {
							$arrTests['post'] = array();
							$arrTests['post']['validators'] = array();
							$strIndex = 'post';
						}
					}
					$arrTests[$strIndex]['validators'] = array_merge($arrTests[$strIndex]['validators'], $this->parseTest($objTest));
				}				
			}			
		}
		
		if (!empty($arrExecuteRequest)) {
			$this->arrConfiguration['executeRequest'] = $arrExecuteRequest;
		}
			
		if (!empty($arrTests)) {
			$this->arrConfiguration['tests'] = $arrTests;
		}
			
		return $this->arrConfiguration;
	}
	
	/**
	 * Parsing <execute-request ...> tags 
	 *
	 * @access private
	 * @param SimpleXMLElement XML object to parse
	 * @return array array with execute-request configuration
	 */
	private function parseExecuteRequest(SimpleXMLElement $objXML) {
		$arrRet = array();
		
		if (!isset($objXML['name'])) {
			throw new WF_ValidatorsParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['PARSER']['REQUIRED'], 'get', 'name'));
		}
		
		$arrRet[(string)$objXML['name']] = isset($objXML['value']) ? (string)$objXML['value'] : '%%%%WEBFRAMEWORK_NOVALUE%%%%';
		
		return $arrRet;
	}
	
	/**
	 * Parsing <tests ...> tags 
	 *
	 * @access private
	 * @param SimpleXMLElement XML object to parse
	 * @return array array with tests configuration
	 */
	private function parseTest(SimpleXMLElement $objXML) {
		$arrRet = array();
		
		foreach ($objXML as $strValidator=>$arrValidator) {
			if (strcmp($strValidator, 'validator')==0) {
				$arrRet = array_merge($arrRet, $this->parseValidator($arrValidator));
			} else {
				throw new WF_ValidatorsParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['PARSER']['REQUIRED'], $strValidator));
			}
		}		
		
		return $arrRet;
	}
	
	/**
	 * Parsing <validator ...> tags
	 *
	 * @access private
	 * @param SimpleXMLElement XML object to parse
	 * @return array array with validator configuration
	 */
	private function parseValidator(SimpleXMLElement $objXML) {
		$arrRet = array();
		
		$strType = '';
		if (isset($objXML['name'])) {
			$arrRet[(string)$objXML['name']] = array();
			$strType = (string)$objXML['name'];
		} else {
			throw new WF_ValidatorsParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['PARSER']['REQUIRED'], 'validator', 'name'));
		}
		
		$arrVariables = array();
		$arrParams = array();
		foreach ($objXML as $strTag=>$arrTag) {
			if (strcmp($strTag, 'variable')==0) {
				$arrVariables = array_merge($arrVariables, $this->parseVariable($arrTag));
			}
			
			if (strcmp($strTag, 'param')==0) {
				$arrParams = array_merge($arrParams, $this->parseParam($arrTag));
			}
		}
		
		if (!empty($arrVariables)) {
			$arrRet[(string)$strType]['variables'] = $arrVariables;
		}
		
		if (!empty($arrParams)) {
			$arrRet[(string)$strType]['params'] = $arrParams;
		}
					
		return $arrRet;
	}
	
	/**
	 * Parsing <variable ...> tags
	 *
	 * @access private
	 * @param SimpleXMLElement XML object to parse
	 * @return array array with variable configuration
	 */
	private function parseVariable(SimpleXMLElement $objXML) {
		$arrRet = array();
		
		$strType = '';
		if (isset($objXML['name'])) {
			$arrRet[(string)$objXML['name']] = array();
			$strType = (string)$objXML['name'];
			
			if (isset($objXML['required'])) {
				$arrRet[$strType]['required'] = (string)$objXML['required'];
			}
		} else {
			throw new WF_ValidatorsParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['PARSER']['REQUIRED'], 'variable', 'name'));
		}
		
		return $arrRet;
	}
	
	/**
	 * Parse <param ...> tags
	 *
	 * @access private
	 * @param SimpleXMLElement XML object to parse
	 * @return array array with param configuration
	 */
	private function parseParam(SimpleXMLElement $objXML) {
		$arrRet = array();
		if (isset($objXML['name']) || isset($objXML['value'])) {
			$arrRet[(string)$objXML['name']] = (string)$objXML['value'];
		} else {
			throw new WF_ValidatorsParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['PARSER']['REQUIRED'], 'param', 'name, value'));
		}
		
		return $arrRet;
	}
	
}
?>