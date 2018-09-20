<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Validator.class.php
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
 * Class (singleton) support validations
 *
 * @name Validator
 * @version 1.0.0
 * @package web.framework
 * @subpackage Validators 
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 * @todo Walidator tablicy konfiguracyjnej??
 */
class Validator {
	private static
		$objThis = null;
		
	private
		$strParser = '', 
		$strValidatorFileName = '', 
		$strValidatorExtension = '',
		$strValidatorClsssName = '';
		
	protected
		$arrConfiguration = array(),
		$objHTTPRequest = null;
		
	protected
		$arrTesters = array();

	/**
	 * The class constructor (private)
	 *
	 * @access private
	 * @param HTTPRequest żądania HTTP
	 * @param string name of validator's configuration parser
	 * @param string file extension of validator's configuration files
	 */
	private function __construct(HTTPRequest $objHTTPRequest, $strParser, $strValidatorExtension='.validator.xml') {			
		$this->strParser = $strParser;
		$this->strValidatorExtension = $strValidatorExtension;
		$this->objHTTPRequest = $objHTTPRequest;
				
	}	
	
	/**
	 * The class constructor (singleton)
	 *
	 * @access public
	 * @static 
	 * @param HTTPRequest HTTP requests
	 * @param string name of validator's configuration parser
	 * @param string file extension of validator's configuration files
	 * @return Validator object of Validator class (self)
	 */
	public static function construct(HTTPRequest $objHTTPRequest, $strParser, $strValidatorExtension='.validator.xml') {
		if (isset(self::$objThis)) {
			return self::$objThis;
		} else {
			self::$objThis = new self($objHTTPRequest, $strParser, $strValidatorExtension);			
		}		
		
		return self::$objThis;
	}
	
	/**
	 * Execute file validation
	 *
	 * @access public
	 * @param string validator's file configuration (<b>without extension!</b>)
	 * @return array array with validator's configuration array(<br>'post'=>array (<br>'setting1'=>array (<br>'validator'=>'value form validator'<br>)<br>)<br>'get'=>array(<i>see post...</i>)<br>)
	 */
	public function validate($strValidatorFileName) {
		if (!file_exists($strValidatorFileName.$this->strValidatorExtension)) {
			throw new WF_Validator_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['NOT_FOUND'], $strValidatorFileName.$this->strValidatorExtension));
		}
		
		$this->strValidatorFileName = $strValidatorFileName;
		
		$this->strValidatorClsssName = preg_replace('/\W|\s/' ,'', ucfirst(basename($this->strValidatorFileName))).'ValidatorConfiguration';
		
		/*
		 * Jeśli nie istnieje skompilowana konfiguracja, kompilujemy ją w przeciwnym razie includujemy
		 */
		if (file_exists($strValidatorFileName.'.php') && (filemtime($strValidatorFileName.$this->strValidatorExtension)<filemtime($strValidatorFileName.'.php'))) {
			require_once($strValidatorFileName.'.php');
			$objConfig= new $this->strValidatorClsssName();
			$this->arrConfiguration	= $objConfig->arrConfiguration;
		} else {
			$this->arrConfiguration = $this->load();
			$this->savePHP();			
		}
		
		/*
		 * ====> validate
		 */
		
		$arrPOST = $this->objHTTPRequest->getParameters(HTTPRequest::POST);
		$arrGET = $this->objHTTPRequest->getParameters(HTTPRequest::GET);
		
		/*
		 * required parameters
		 */
		if (isset($this->arrConfiguration['executeRequest'])) {
			if (isset($this->arrConfiguration['executeRequest']['post'])) {
				foreach ($this->arrConfiguration['executeRequest']['post'] as $strName=>$strValue) {
					if (!isset($arrPOST[$strName])) {
						return (isset($this->arrConfiguration['executeRequest']['else'])) ? $this->arrConfiguration['executeRequest']['else'] : false;
					} elseif (strcmp($strValue, '%%%%WEBFRAMEWORK_NOVALUE%%%%')!=0 && strcmp($arrPOST[$strName], $strValue)!=0) {
						return (isset($this->arrConfiguration['executeRequest']['else'])) ? $this->arrConfiguration['executeRequest']['else'] : false;
					}
				}
			}
			if (isset($this->arrConfiguration['executeRequest']['get'])) {
				foreach ($this->arrConfiguration['executeRequest']['get'] as $strName=>$strValue) {
					if (!isset($arrGET[$strName])) {
						return (isset($this->arrConfiguration['executeRequest']['else'])) ? $this->arrConfiguration['executeRequest']['else'] : false;
					} elseif (strcmp($strValue, '%%%%WEBFRAMEWORK_NOVALUE%%%%')!=0 && strcmp($arrGET[$strName], $strValue)!=0) {
						return (isset($this->arrConfiguration['executeRequest']['else'])) ? $this->arrConfiguration['executeRequest']['else'] : false;
					}
				}
			}
		}
		
		/*
		 * tests
		 */
		$arrRet = array();
		if (isset($this->arrConfiguration['tests'])) {
			if (isset($this->arrConfiguration['tests']['post']['validators'])) {
				$arrRet['post'] = array();
				
				foreach ($this->arrConfiguration['tests']['post']['validators'] as $strValidator=>$arrValidator) {
					/*
					 * Making test class
					 */
					if (!isset($this->arrTesters[$strValidator])) {
						if(is_file(WEBFRAMEWORK_CORE_DIR."Validators/Testers/$strValidator.tester.class.php")) {
							require(WEBFRAMEWORK_CORE_DIR."Validators/Testers/$strValidator.tester.class.php");
							$this->arrTesters[$strValidator] = new $strValidator();
							
							if (!($this->arrTesters[$strValidator] instanceof ITester)) {
								throw new WF_Validator_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['TESTER_NOT_FOUND'], WEBFRAMEWORK_CORE_DIR."Validators/Testers/$strValidator.tester.class.php"));
							}
						} else {
							throw new WF_Validator_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['TESTER_NOT_FOUND'], WEBFRAMEWORK_CORE_DIR."Validators/Testers/$strValidator.tester.class.php"));
						}
					}
														
					if (!isset($this->arrConfiguration['tests']['post']['validators'][$strValidator]['variables'])) {
						throw new WF_Validator_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['CONFIGURATION_ERROR'], $this->strValidatorFileName));
					}
						
					$arrParams = isset($this->arrConfiguration['tests']['post']['validators'][$strValidator]['params']) ? $this->arrConfiguration['tests']['post']['validators'][$strValidator]['params'] : null;
					$mixResult = null;
					foreach ($this->arrConfiguration['tests']['post']['validators'][$strValidator]['variables'] as $strVariable=>$arrVariable) {
						if (!isset($arrRet['post'][$strVariable])) {
							$arrRet['post'][$strVariable] = array();
						}
							
						if (!isset($arrRet['post'][$strVariable][$strValidator])) {
							$arrRet['post'][$strVariable][$strValidator] = null;
						}
							
						if (isset($arrPOST[$strVariable])) {
							$arrRet['post'][$strVariable][$strValidator] = $this->arrTesters[$strValidator]->execute($arrPOST[$strVariable], $arrParams);
							
						} elseif (isset($this->arrConfiguration['tests']['post']['validators'][$strValidator]['variables'][$strVariable]['required']) && strcmp($this->arrConfiguration['tests']['post']['validators'][$strValidator]['variables'][$strVariable]['required'], 'true')==0) {
							throw new WF_Validator_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['REQUIRED']);								
						}
					}
				}
			} 
			if (isset($this->arrConfiguration['tests']['get']['validators'])) {
				$arrRet['get'] = array();
				
				foreach ($this->arrConfiguration['tests']['get']['validators'] as $strValidator=>$arrValidator) {
					/*
					 * Making test class
					 */
					if (!isset($this->arrTesters[$strValidator])) {
						if(is_file(WEBFRAMEWORK_CORE_DIR."Validators/Testers/$strValidator.tester.class.php")) {
							require(WEBFRAMEWORK_CORE_DIR."Validators/Testers/$strValidator.tester.class.php");
							$this->arrTesters[$strValidator] = new $strValidator();
							
							if (!($this->arrTesters[$strValidator] instanceof ITester)) {
								throw new WF_Validator_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['TESTER_NOT_FOUND'], WEBFRAMEWORK_CORE_DIR."Validators/Testers/$strValidator.tester.class.php"));
							}
						} else {
							throw new WF_Validator_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['TESTER_NOT_FOUND'], WEBFRAMEWORK_CORE_DIR."Validators/Testers/$strValidator.tester.class.php"));
						}
					}
														
					if (!isset($this->arrConfiguration['tests']['get']['validators'][$strValidator]['variables'])) {
						throw new WF_Validator_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['CONFIGURATION_ERROR'], $this->strValidatorFileName));
				    }
						
					$arrParams = isset($this->arrConfiguration['tests']['get']['validators'][$strValidator]['params']) ? $this->arrConfiguration['tests']['get']['validators'][$strValidator]['params'] : null;
					$mixResult = null;
					foreach($this->arrConfiguration['tests']['get']['validators'][$strValidator]['variables'] as $strVariable=>$arrVariable) {
						if (!isset($arrRet['get'][$strVariable])) {
							$arrRet['get'][$strVariable] = array();
						}
							
						if (!isset($arrRet['get'][$strVariable][$strValidator])) {
							$arrRet['get'][$strVariable][$strValidator] = null;
						}
							
						if (isset($arrGET[$strVariable])) {
							$arrRet['get'][$strVariable][$strValidator] = $this->arrTesters[$strValidator]->execute($arrGET[$strVariable], $arrParams);
							
						} elseif (isset($this->arrConfiguration['tests']['get']['validators'][$strValidator]['variables'][$strVariable]['required']) && strcmp($this->arrConfiguration['tests']['get']['validators'][$strValidator]['variables'][$strVariable]['required'], 'true')==0) {
							throw new WF_Validator_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['REQUIRED']);								
						}
					}
				}
			}
		} else {
			throw new WF_Validator_Exception();
		}
		
		
		return $arrRet;
	}

	/**
	 * Reading validator's configuration
	 *
	 * @access private
	 * @return array configuration
	 */
	private function load() {
		require_once('Parsers/'.$this->strParser.'.class.php');
		
		$objParse = new $this->strParser();
		if (!($objParse instanceof IValidatorsParser)) {
			throw new WF_Configuration_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['VALIDATOR']['PARSER_INSTANCE']);
		}

		return $objParse->parse($this->strValidatorFileName.$this->strValidatorExtension);
	}
	
	/**
	 * Write validator's configuration into PHP array
	 *
	 * @access private
	 * @throws WF_Config_Exception
	 */
	private function savePHP() {
		$strPHPCode = "<?php\n";
		$strPHPCode .= "/*\n";
		$strPHPCode .= "* Generatet by web.framework\n";
		$strPHPCode .= "* Version ".WebFramework::$intMajorVersion.'.'.WebFramework::$intMinorVersion.'.'.WebFramework::$intUpdateVersion."\n";
		$strPHPCode .= "* generated ".date('d.m.Y \a\t H:i:s')."\n";
		$strPHPCode .= "*/\n";
		$strPHPCode .= "class {$this->strValidatorClsssName} {\n";
		$strPHPCode .= "	public\n";
		$strPHPCode .= "		\$arrConfiguration = array(\n";
		$strPHPCode .= $this->generateArrayPart($this->arrConfiguration)."\n";
		$strPHPCode .= "		);\n";
		$strPHPCode .= "}\n";
		$strPHPCode .= "?>\n";

		$resFp = @fopen($this->strValidatorFileName.'.php', 'w');
		if(!$resFp) {
			throw new WF_Configuration_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['SAVE_PHP']));
		}
			
		fwrite($resFp, $strPHPCode);
	}
	
	/**
	 * Generate array with validator's configuration (recursive)
	 *
	 * @access private
	 * @param array array to change it to PHP code
	 * @return string kod PHP tablicy
	 */
	private function generateArrayPart($arrConfig) {
		static
			$intIdent = 2;
		
		$arrObject = new ArrayObject($arrConfig);
		$objArrIterator = $arrObject->getIterator();
		
		$intIdent++;
		$strData = '';
		while ($objArrIterator->valid()) {
			if (is_array($objArrIterator->current())) {
				if (is_integer($objArrIterator->key())) {
					$strData .= str_repeat("\t", $intIdent).$objArrIterator->key()." => array(\n";
				} else {
					$strData .= str_repeat("\t", $intIdent)."'".$objArrIterator->key()."' => array(\n";
				}
				
				$strData .= $this->generateArrayPart($objArrIterator->current());
				$strData .= str_repeat("\t", $intIdent)."),\n";
			} else 
				if (is_integer($objArrIterator->key())) {
					$strData .= str_repeat("\t", $intIdent).$objArrIterator->key()." => '".$objArrIterator->current()."',\n";
				} else {
					$strData .= str_repeat("\t", $intIdent)."'".$objArrIterator->key()."' => '".$objArrIterator->current()."',\n";
				}
				
			$objArrIterator->next();
		}
		$intIdent--;
		return $strData;
	}
	
}

/**
 * Exception of Validator
 * @package web.framework
 * @subpackage exceptions 
 */
class WF_Validator_Exception extends Exception {}

?>