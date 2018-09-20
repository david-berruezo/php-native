<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Configuration.class.php
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
 * This class read configuration file, and transfer it to PHP array.
 * It's singleton.
 *
 * @name Configuration
 * @version 1.0.0
 * @package web.framework
 * @subpackage Configuration
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class Configuration {
	private static
		$objThis = null,
		$objParse = null;

	private
		$strConfigFileName = '',
		$strConfigExtension = '',
		$strParser = '';

	protected
		$arrConfiguration = array();

	/**
	 * The class constructor (private)
	 *
	 * @access private
	 * @param string configuration's parser class name (this class must be placed in web.framework/Configuration/Parsers directory)
	 * @param string patch to configuration file (with file name, but without file extension)
	 * @param string configuration file extension (with begin dot)
	 * @throws WF_Config_Exception
	 */
	private function __construct($strParser, $strConfigFileName, $strConfigExtension='.xml') {
		if (!file_exists($strConfigFileName.$strConfigExtension)) {
			throw new WF_Configuration_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['NOT_FOUND'], $strConfigFileName.$strConfigExtension));
		}

		$this->strConfigFileName = $strConfigFileName;
		$this->strConfigExtension = $strConfigExtension;
		$this->strParser = $strParser;

		/*
		 * If don't exist compiled configuration, we must parse and compile it
		 */
		if (file_exists($strConfigFileName.'.php') && (filemtime($strConfigFileName.$strConfigExtension)<filemtime($strConfigFileName.'.php'))) {
			require_once($strConfigFileName.'.php');
			$this->arrConfiguration = ConfigurationFile::$arrConfiguration;

			//$this->update($this->arrConfiguration);
		} else {
			$this->arrConfiguration = $this->load();

			if (!$this->check($this->arrConfiguration)) {
				throw new WF_Configuration_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['CONFIGURATION_ERROR']);
			}

			$this->savePHP();
		}
	}

	/**
	 * Make or return instance of this class
	 *
	 * @access public
	 * @param string configuration's parser class name (this class must be placed in web.framework/Configuration/Parsers directory)
	 * @param string patch to configuration file (with file name, but without file extension)
	 * @param string configuration file extension (with begin dot)
	 * @throws WF_Config_Exception
	 */
	public static function construct($strParser, $strConfigFileName, $strConfigExtension='.xml') {
		if(isset(self::$objThis)) {
			return self::$objThis;
		} else {
			self::$objThis = new self($strParser, $strConfigFileName, $strConfigExtension);
		}

		return self::$objThis;
	}

	/**
	 * Return array witch parsed configuration
	 *
	 * @access public
	 * @return array array with configuration
	 */
	public function getConfiguration() {
		return $this->arrConfiguration;
	}

	/**
	 * Write new configuration array to XML-file
	 *
	 * @access public
	 * @param array with a new configuration
	 * @throws WF_Configuration_Exception
	 */
	public function update($arrNewConfiguration) {
		if (!$this->check($arrNewConfiguration)) {
			throw new WF_Configuration_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['CONFIGURATION_ERROR']);
		}

		$this->objParse->update($arrNewConfiguration);
	}

	/**
	 * Check configuration's array
	 *
	 * @access public
	 * @param array configuration's array to chceck
	 * @return boolean true - configuration's array is ok, flase - configuration array fail
	 */
	private function check($arrConfiguration) {
		/*
		 * Authorization
		 */
		if (isset($arrConfiguration['authorization'])) {
			if (!isset($arrConfiguration['authorization']['driver']) || !isset($arrConfiguration['authorization']['accessDenitedView'])) {
				return false;
			} else {
				return true;
			}
		}

		/*
		 * actions
		 */
		$blnActions =
		true;
		if (isset($arrConfiguration['actions'])) {
			if (count($arrConfiguration['actions'])<1)
				return false;

			foreach ($arrConfiguration['actions'] as $strKey1=>$arrVal1) {
				if (!isset($arrVal1['type'])) {
					return false;
				} elseif(!isset($arrVal1['forwards'])) {
					return false;
				} else {
					foreach ($arrVal1['forwards'] as $strKey=>$arrVal) {
						if (!isset($arrVal['view'])) {
							return false;
						}
					}
				}
			}
		} else
			$blnActions = false;

		/*
		 * pre-actions
		 */
		if(isset($arrConfiguration['preactions']['actions'])) {
			foreach($arrConfiguration['preactions']['actions'] as $strKey1=>$arrVal1) {
				if(!isset($arrVal1['type']))
					return false;
				elseif(!isset($arrVal1['forwards']))
					return false;
				else {
					foreach($arrVal1['forwards'] as $strKey=>$arrVal) {
						if(!isset($arrVal['view']))
							return false;
					}
				}
			}
		}

		/*
		 * post-actions
		 */
		if(isset($arrConfiguration['postactions']['actions'])) {
			foreach($arrConfiguration['postactions']['actions'] as $strKey1=>$arrVal1) {
				if(!isset($arrVal1['type']))
					return false;
				elseif(!isset($arrVal1['forwards']))
					return false;
				else {
					foreach($arrVal1['forwards'] as $strKey=>$arrVal) {
						if(!isset($arrVal['view']))
							return false;
					}
				}
			}
		}

		/*
		 * action-chain
		 */
		$intChains = 0;
		if(isset($arrConfiguration['actionchain'])) {
			if(count($arrConfiguration['actionchain'])<1)
				return false;

			foreach($arrConfiguration['actionchain'] as $strKeyAC=>$arrValAC) {
				$intChains++;

				if(isset($arrValAC['actions'])) {
					if(count($arrValAC['actions'])<1)
						return false;

					foreach($arrValAC['actions'] as $strKey1=>$arrVal1) {
						if(!isset($arrVal1['type']))
							return false;
						elseif(!isset($arrVal1['forwards']))
							return false;
						else {
							foreach($arrVal1['forwards'] as $strKey=>$arrVal) {
								if(!isset($arrVal['view']))
									return false;
							}
						}
					}
				} else
					return false;

				if(isset($arrValAC['calls'])) {
					if(count($arrValAC['calls'])<1)
						return false;

					foreach($arrValAC['calls'] as $strKey=>$arrVal) {
						if(!isset($arrVal['action-chain']) && !isset($arrVal['action']))
							return false;
					}
				}
			}
		}

		/*
		 * datasources
		 */
		if(isset($arrConfiguration['datasources'])) {
			foreach($arrConfiguration['datasources'] as $strKeyDS=>$arrValDS) {
				if(!isset($arrValDS['params']) || count($arrValDS['params'])<1)
					return false;
			}
		}

		if(!$blnActions && $intChains==0)
			return false;

		return true;
	}

	/**
	 * Read and parse framework configuration
	 *
	 * @access private
	 * @return array array with configuration
	 * @throws WF_Configuration_Exception
	 */
	private function load() {
		require_once('Parsers/'.$this->strParser.'.class.php');

		$this->objParse = new $this->strParser();
		if (!($this->objParse instanceof IConfigurationParser)) {
			throw new WF_Configuration_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER_INSTANCE']);
		}

		return $this->objParse->parse($this->strConfigFileName, $this->strConfigExtension);
	}

	/**
	 * Write PHP's array configuration file
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
		$strPHPCode .= "class ConfigurationFile {\n";
		$strPHPCode .= "	static\n";
		$strPHPCode .= "		\$arrConfiguration = array(\n";
		$strPHPCode .= $this->generateArrayPart($this->arrConfiguration)."\n";
		$strPHPCode .= "		);\n";
		$strPHPCode .= "}\n";
		$strPHPCode .= "?>\n";

		$resFp = @fopen($this->strConfigFileName.'.php', 'w');
		if (!$resFp) {
			throw new WF_Configuration_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['SAVE_PHP']));
		}

		fwrite($resFp, $strPHPCode);
	}

	/**
	 * Generate parts of PHP's array
	 *
	 * @access private
	 * @param array PHP array's code with configuration
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
			} else {
				if (is_integer($objArrIterator->key())) {
					$strData .= str_repeat("\t", $intIdent).$objArrIterator->key()." => '".$objArrIterator->current()."',\n";
				} else {
					$strData .= str_repeat("\t", $intIdent)."'".$objArrIterator->key()."' => '".$objArrIterator->current()."',\n";
				}
			}
			$objArrIterator->next();
		}
		$intIdent--;
		return $strData;
	}
}

/**
 * Exception of Configuration class
 * @package web.framework
 * @subpackage exceptions
 */
class WF_Configuration_Exception extends Exception {}
?>