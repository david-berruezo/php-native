<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		DefaultConfigurationParser.class.php
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
 * Class of default configuration's file parser
 *
 * @name DefaultConfigurationParser
 * @version 1.0.0
 * @package web.framework
 * @subpackage Configuration
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class DefaultConfigurationParser implements IConfigurationParser {
	const
		ACTIONS = 0,
		ORDERACTIONS = 1;

	private
		$objXML = null,
		$arrConfiguration = array();

	private
	   $strConfigFileName = null,
	   $strConfigExtension = null;
	/**
	 * Parse configuration into PHP's array class
	 *
	 * @access public
	 * @param string patch to configuration file (with file name, but without file extension)
	 * @param string configuration file extension (with begin dot)
	 * @return array array with configuration
	 * @throws WF_ParseConfig_Exception
	 */
	public function &parse($strConfigFileName, $strConfigExtension='.xml') {
		$this->strConfigFileName = $strConfigFileName;
		$this->strConfigExtension = $strConfigExtension;

		$objXML = simplexml_load_file($strConfigFileName.$strConfigExtension);

		if ($objXML===false) {
			throw new WF_ConfigurationParser_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['LOAD']);
		}

		/*
		 * action
		 */
		$arrPreActions = array();
		$arrActions = array();
		$arrActionChain = array();
		$arrPostActions = array();
		foreach ($objXML->actions->children() as $strTag=>$objActions) {
			if (strcmp($strTag, 'pre-actions')==0) {
				$arrPreActions = array_merge($arrPreActions, $this->parsePreActions($objActions));
			} elseif (strcmp($strTag, 'post-actions')==0) {
				$arrPostActions = array_merge($arrPostActions, $this->parsePostActions($objActions));
			} elseif (strcmp($strTag, 'action')==0) {
				$arrActions = array_merge($arrActions, $this->parseAction($objActions, self::ACTIONS));
			} elseif(strcmp($strTag, 'action-chain')==0) {
				$arrActionChain = array_merge($arrActionChain, $this->parseActionChain($objActions));
			}
		}
		if (!empty($arrPreActions)) {
			$this->arrConfiguration['preactions'] = $arrPreActions;
		}
		if (!empty($arrPostActions)) {
			$this->arrConfiguration['postactions'] = $arrPostActions;
		}
		if (!empty($arrActions)) {
			$this->arrConfiguration['actions'] = $arrActions;
		}
		if (!empty($arrActionChain)) {
			$this->arrConfiguration['actionchain'] = $arrActionChain;
		}

		/*
		 * Settings
		 */
		$arrSettings = array();
		foreach ($objXML->settings->children() as $strTag=>$objSettings) {
			if (strcmp($strTag, 'set-property')==0)	{
				$arrSettings = array_merge($arrSettings, $this->parseSetting($objSettings));
			}
		}
		if (!empty($arrSettings)) {
			$this->arrConfiguration['settings'] = $arrSettings;
		}

		/*
		 * Template
		 */
		$arrTemplate = array();
		if (isset($objXML->template)) {
    		foreach ($objXML->template->children() as $strTag=>$objParams) {
    			if (strcmp($strTag, 'param')==0) {
    				$arrTemplate = array_merge($arrTemplate, $this->parseParam($objParams));
    			}
    		}
    		if (!empty($arrTemplate)) {
    			$this->arrConfiguration['template'] = $arrTemplate;
    		}
		}

		/*
		 * Token
		 */
		$arrToken = array();
		if (isset($objXML->token)) {
    		foreach ($objXML->token->children() as $strTag=>$objParams) {
    			if (strcmp($strTag, 'param')==0) {
    				$arrToken = array_merge($arrToken, $this->parseParam($objParams));
    			}
    		}
    		//if (!empty($arrToken)) {
    			$this->arrConfiguration['token'] = $arrToken;
    		//}
		}

		/*
		 * Authorization
		 */
		$arrAuthorization = array();
		if (isset($objXML->authorization)) {
    		foreach ($objXML->authorization->children() as $strTag=>$objParams) {
    			if (strcmp($strTag, 'param')==0) {
    				$arrAuthorization = array_merge($arrAuthorization, $this->parseParam($objParams));
    			}
    		}
    		if (!empty($arrAuthorization)) {
    			$this->arrConfiguration['authorization'] = $arrAuthorization;
    		}
		}


		/*
		 * Datasources
		 */
		$arrDatasources = array();
		if (isset($objXML->datasources)) {
    		foreach ($objXML->datasources->children() as $strTag=>$objDatasource) {
    			if (strcmp($strTag, 'datasource')==0) {
    				$arrDatasources = array_merge($arrDatasources, $this->parseDatasource($objDatasource));
    			}
    		}
    		if (!empty($arrDatasources)) {
    			$this->arrConfiguration['datasources'] = $arrDatasources;
    		}
		}

		return $this->arrConfiguration;
	}

	/**
	 * Parse <datasource...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseDatasource(SimpleXMLElement $objXML) {
		$arrRet = array();

		$strType = '';
		if (isset($objXML['type'])) {
			$arrRet[(string)$objXML['type']] = array();
			$strType = $objXML['type'];
		} else {
			throw new SimpleXMLElement(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'datasource', 'type'));
		}

		/*
		 * sub tags
		 */
		$arrParameters = array();
		foreach($objXML->children() as $strTag=>$objActions) {
			if (strcmp($strTag, 'param')==0) {
				$arrParameters = array_merge($arrParameters, $this->parseParam($objActions));
			} else {
				throw new WF_ParseConfig_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['NOT_ALLOWED'], $strTag));
			}
		}
		$arrRet[(string)$strType]['params'] = $arrParameters;

		return $arrRet;
	}

	/**
	 * Parse <param...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseParam(SimpleXMLElement $objXML) {
		$arrRet = array();
		if (isset($objXML['name']) || isset($objXML['value'])) {
			$arrRet[(string)$objXML['name']] = (string)$objXML['value'];
		} else {
			throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'param', 'name, value'));
		}

		return $arrRet;
	}

	/**
	 * Parse <settings...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseSetting(SimpleXMLElement $objXML) {
		$arrRet = array();

		if (isset($objXML['property']) && isset($objXML['value'])) {
			$arrRet[(string)$objXML['property']] = (string)$objXML['value'];
		} else {
			throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'set-property', 'property, value'));
		}

		return $arrRet;
	}

	/**
	 * Parse <action...> blocks from <except-for...> bloks
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseExceptAction(SimpleXMLElement $objXML) {
		$arrRet = array();
		if (isset($objXML['path'])) {
			$arrRet[(string)$objXML['path']] = true;
		} else {
			throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'action (except-for)', 'path'));
		}

		return $arrRet;
	}

	/**
	 * Parse <pre-actions...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parsePreActions(SimpleXMLElement $objXML) {
		$arrRet = array();
		/*
		 * tags
		 */
		$arrActions = array();
		$arrExceptAction = array();
		foreach ($objXML->children() as $strTag=>$objTag) {
			if (strcmp($strTag, 'action')==0) {
				$arrActions = array_merge($arrActions, $this->parseAction($objTag, self::ORDERACTIONS));
			} elseif(strcmp($strTag, 'except-for')==0) {
				foreach ($objTag as $strExceptTag=>$objExceptTag) {
					if (strcmp($strExceptTag, 'action')==0) {
						if (!isset($arrExceptAction['actions'])) {
							$arrExceptAction['actions'] = array();
						}

						$arrExceptAction['actions'] = array_merge($arrExceptAction['actions'], $this->parseExceptAction($objExceptTag));
					} elseif (strcmp($strExceptTag, 'action-chain')==0) {
						if (!isset($arrExceptAction['actionchain'])) {
							$arrExceptAction['actionchain'] = array();
						}

						$arrExceptAction['actionchain'] = array_merge($arrExceptAction['actionchain'], $this->parseExceptAction($objExceptTag));
					}
				}
			}
		}

		if (!empty($arrActions)) {
			$arrRet['actions'] = $arrActions;
		}
		if (!empty($arrExceptAction)) {
			$arrRet['excepts'] = $arrExceptAction;
		}

		return $arrRet;
	}

	/**
	 * Parse <post-actions...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parsePostActions(SimpleXMLElement $objXML) {
		$arrRet = array();
		/*
		 * tags
		 */
		$arrActions = array();
		$arrExceptAction = array();
		foreach ($objXML->children() as $strTag=>$objTag) {
			if (strcmp($strTag, 'action')==0) {
				$arrActions = array_merge($arrActions, $this->parseAction($objTag, self::ORDERACTIONS));
			} elseif (strcmp($strTag, 'except-for')==0) {
				foreach ($objTag as $strExceptTag=>$objExceptTag) {
					if (strcmp($strExceptTag, 'action')==0) {
						if (!isset($arrExceptAction['actions'])) {
							$arrExceptAction['actions'] = array();
						}

						$arrExceptAction['actions'] = array_merge($arrExceptAction['actions'], $this->parseExceptAction($objExceptTag));
					} elseif (strcmp($strExceptTag, 'action-chain')==0) {
						if (!isset($arrExceptAction['actionchain'])) {
							$arrExceptAction['actionchain'] = array();
						}

						$arrExceptAction['actionchain'] = array_merge($arrExceptAction['actionchain'], $this->parseExceptAction($objExceptTag));
					}
				}
			}
		}

		if (!empty($arrActions)) {
			$arrRet['actions'] = $arrActions;
		}
		if (!empty($arrExceptAction)) {
			$arrRet['excepts'] = $arrExceptAction;
		}

		return $arrRet;
	}

	/**
	 * Parse <actions...> blocks
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseAction(SimpleXMLElement $objXML, $intInside=0) {
		$arrRet = array();
		/*
		 * parametry
		 */
		$strType = '';
		if (isset($objXML['path']) && isset($objXML['type'])) {
			$arrRet[(string)$objXML['path']] = array();
			$strType = $objXML['path'];
		} else {
			throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'action', 'path, type'));
		}

		foreach ($objXML->attributes() as $strName=>$strValue) {
			if (in_array($strName, array('type', 'validator', 'classpath', 'visible', 'authorization'))) {
				$arrRet[(string)$strType][(string)$strName] = (string)$strValue;
			} elseif(strcmp($strName, 'info')==0) {
				$arrRet[(string)$strType][(string)$strName] = (string)urlencode((string)$strValue);
			} elseif(strcmp($strName, 'path')!=0) {
				throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['UNKNOWN_PARAM'], $strName, 'action'));
			}
		}

		/*
		 * sub tags
		 */
		$arrForwards = array();
		$arrValidators = array();
		foreach ($objXML->children() as $strTag=>$objActions) {
			if (strcmp($strTag, 'forward')==0) {
				$arrForwards = array_merge($arrForwards, $this->parseForward($objActions));
			} elseif (strcmp($strTag, 'validator')==0) {
				$arrValidators = array_merge($arrValidators, $this->parseValidator($objActions));
			} else {
				throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['NOT_ALLOWED'], $strTag));
			}
		}

		if (!empty($arrForwards)) {
			$arrRet[(string)$strType]['forwards'] = $arrForwards;
		}
		if (!empty($arrValidators)) {
			$arrRet[(string)$strType]['validators'] = $arrValidators;
		}

		return $arrRet;
	}

	/**
	 * Parse <action-chain...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseActionChain(SimpleXMLElement $objXML) {
		$arrRet = array();

		/*
		 * parameters
		 */
		if (isset($objXML['path'])) {
			$arrRet[(string)$objXML['path']] = array();
			$strType = $objXML['path'];
		} else {
			throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'actionchain', 'path'));
		}

		/*
		 * sub tags
		 */
		$arrActions = array();
		$arrForwards = array();
		$arrCall = array();
		foreach ($objXML->children() as $strTag=>$objActions) {
			if (strcmp($strTag, 'action')==0) {
				$arrActions = array_merge($arrActions, $this->parseAction($objActions, self::ORDERACTIONS));
			} elseif (strcmp($strTag, 'forward')==0) {
				$arrForwards = array_merge($arrForwards, $this->parseForward($objActions));
			} elseif (strcmp($strTag, 'call')==0) {
				$arrCall = array_merge($arrCall, $this->parseCall($objActions));
			} else {
				throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['NOT_ALLOWED'], $strTag));
			}
		}

		if (!empty($arrActions)) {
			$arrRet[(string)$strType]['actions'] = $arrActions;
		}
		if (!empty($arrForwards)) {
			$arrRet[(string)$strType]['forwards'] = $arrForwards;
		}
		if (!empty($arrCall)) {
			$arrRet[(string)$strType]['calls'] = $arrCall;
		}

		return $arrRet;
	}

	/**
	 * Parse <call...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseCall(SimpleXMLElement $objXML) {
		$arrRet = array();

		/*
		 * parametry
		 */
		$strFName = '';
		if (isset($objXML['action-chain'])) {
			$arrRet[] = array('action-chain' => (string)$objXML['action-chain']);
		} elseif (isset($objXML['action'])) {
			$arrRet[] = array('action' => (string)$objXML['action']);
		} else {
			throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'call', 'action/action-chain'));
        }

		return $arrRet;
	}

	/**
	 * Parse <forward...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseForward(SimpleXMLElement $objXML) {
		$arrRet = array();

		/*
		 * parameters
		 */
		$strFName = '';
		if (isset($objXML['name'])) {
			$arrRet[(string)$objXML['name']] = array();
			$strFName = $objXML['name'];
		} else {
			throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'forward', 'type, view'));
		}

		foreach ($objXML->attributes() as $strName=>$strValue) {
			if (in_array($strName, array('classpath', 'view'))) {
				$arrRet[(string)$strFName][(string)$strName] = (string)$strValue;
			} elseif (strcmp($strName, 'name')!=0) {
				throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['UNKNOWN_PARAM'], $strName, 'forward'));
            }
		}

		return $arrRet;
	}

	/**
	 * Parse <validator...> block
	 *
	 * @access private
	 * @param SimpleXMLElement XML object with block to parsing
	 * @return array array with configuration
	 */
	private function parseValidator(SimpleXMLElement $objXML) {
		$arrRet = array();

		/*
		 * parameters
		 */
		$strFName = '';
		if (isset($objXML['name'])) {
			$arrRet[(string)$objXML['name']] = array();
			$strFName = $objXML['name'];
		} else {
			throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[Controller::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['REQUIRED'], 'validator', 'name'));
		}

		foreach ($objXML->attributes() as $strName=>$strValue) {
			if (in_array($strName, array('configpath'))) {
				$arrRet[(string)$strFName][(string)$strName] = (string)$strValue;
			} elseif(strcmp($strName, 'name')!=0) {
				throw new WF_ConfigurationParser_Exception(sprintf(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['PARSER']['UNKNOWN_PARAM'], $strName, 'forward'));
			}
		}

		return $arrRet;
	}

	/**
	 * Write new configuration array to XML-file
	 *
	 * @access public
	 * @param array with a new configuration
	 * @throws WF_Configuration_Exception
	 */
	public function update($arrNewConfiguration) {
		/*
		 * Make XML DOM object
		 */
		$objDOM = new DOMDocument('1.0', 'UTF-8');

		/*
		 * main tags
		 */
		$objConfigurationXML = $objDOM->createElement('webframework');

		$objComment = $objDOM->createComment("\nGeneratet by web.framework\nVersion ".WebFramework::$intMajorVersion.'.'.WebFramework::$intMinorVersion.'.'.WebFramework::$intUpdateVersion."\ngenerated ".date('d.m.Y \a\t H:i:s')."\n");
		$objDOM->appendChild($objComment);

		$objDOM->appendChild($objConfigurationXML);

		/*
		 * settings
		 */
		if (isset($arrNewConfiguration['settings'])) {
			$objComment = $objDOM->createComment('Settings');
			$objConfigurationXML->appendChild($objComment);

			$objSettingsXML = $objDOM->createElement('settings');
			$objConfigurationXML->appendChild($objSettingsXML);

			foreach ($arrNewConfiguration['settings'] as $strProperty=>$strValue) {
				$objPropertyXML = $objDOM->createElement('set-property');
				$objPropertyXML->setAttribute('property', $strProperty);
				$objPropertyXML->setAttribute('value', $strValue);
				$objSettingsXML->appendChild($objPropertyXML);
			}

			$objDOM->formatOutput = true;
		}

		/*
		 * template
		 */
		if (isset($arrNewConfiguration['template'])) {
			$objComment = $objDOM->createComment('Template');
			$objConfigurationXML->appendChild($objComment);

			$objTemplateXML = $objDOM->createElement('template');
			$objConfigurationXML->appendChild($objTemplateXML);

			foreach ($arrNewConfiguration['template'] as $strName=>$strValue) {
				$objParamXML = $objDOM->createElement('param');
				$objParamXML->setAttribute('name', $strName);
				$objParamXML->setAttribute('value', $strValue);
				$objTemplateXML->appendChild($objParamXML);
			}

			$objDOM->formatOutput = true;
		}

		/*
		 * token
		 */
		if (isset($arrNewConfiguration['token'])) {
			$objComment = $objDOM->createComment('Token');
			$objConfigurationXML->appendChild($objComment);

			$objTokenXML = $objDOM->createElement('token');
			$objConfigurationXML->appendChild($objTokenXML);

			foreach ($arrNewConfiguration['token'] as $strName=>$strValue) {
				$objParamXML = $objDOM->createElement('param');
				$objParamXML->setAttribute('name', $strName);
				$objParamXML->setAttribute('value', $strValue);
				$objTokenXML->appendChild($objParamXML);
			}

			$objDOM->formatOutput = true;
		}

		/*
		 * Authorization
		 */
		if (isset($arrNewConfiguration['authorization'])) {
			$objComment = $objDOM->createComment('Authorization');
			$objConfigurationXML->appendChild($objComment);

			$objAuthorizationXML = $objDOM->createElement('authorization');
			$objConfigurationXML->appendChild($objAuthorizationXML);

			foreach ($arrNewConfiguration['authorization'] as $strName=>$strValue) {
				$objParamXML = $objDOM->createElement('param');
				$objParamXML->setAttribute('name', $strName);
				$objParamXML->setAttribute('value', $strValue);
				$objAuthorizationXML->appendChild($objParamXML);
			}

			$objDOM->formatOutput = true;
		}

		/*
		 * datasources
		 */
		if (isset($arrNewConfiguration['datasources'])) {
			$objComment = $objDOM->createComment('Datasources');
			$objConfigurationXML->appendChild($objComment);

			$objDatasourcesXML = $objDOM->createElement('datasources');
			$objConfigurationXML->appendChild($objDatasourcesXML);

			foreach ($arrNewConfiguration['datasources'] as $strDatasource=>$arrDatasource) {
				$objDatasourceXML = $objDOM->createElement('datasource');
				$objDatasourceXML->setAttribute('type', $strDatasource);

				if (isset($arrDatasource['params'])) {
					foreach ($arrDatasource['params'] as $strName=>$strValue) {
						$objParamXML = $objDOM->createElement('param');
						$objParamXML->setAttribute('name', $strName);
						$objParamXML->setAttribute('value', $strValue);
						$objDatasourceXML->appendChild($objParamXML);
					}
				}

				$objDatasourcesXML->appendChild($objDatasourceXML);
			}
		}

		/*
		 * actions
		 */
		$objActions = $objDOM->createElement('actions');
		$objComment = $objDOM->createComment('Actions');
		$objConfigurationXML->appendChild($objComment);

		/*
		 *    - action
		 */
		if( isset($arrNewConfiguration['actions'])) {
			$objComment = $objDOM->createComment('Action');
			$objActions->appendChild($objComment);

			foreach ($arrNewConfiguration['actions'] as $strAction=>$arrAction) {
				$objAction = $objDOM->createElement('action');
				$objAction->setAttribute('path', $strAction);

				foreach ($arrAction as $strKey=>$mixValue) {
					if (in_array($strKey, array('classpath', 'type', 'info', 'visible'))) {
						$objAction->setAttribute($strKey, $mixValue);
					} elseif (strcmp($strKey, 'forwards')==0) {
						/*
						 * forward
						 */
						foreach ($mixValue as $strKey=>$strValue) {
							$objForward = $objDOM->createElement('forward');
							$objForward->setAttribute('name', $strKey);
							$objForward->setAttribute('view', $strValue['view']);
							if (isset($strValue['classpath'])) {
								$objForward->setAttribute('classpath', $strValue['classpath']);
							}

							$objAction->appendChild($objForward);
						}
					} elseif (strcmp($strKey, 'validators')==0) {
						foreach ($mixValue as $strKey=>$arrValue) {
							$objValidator = $objDOM->createElement('validator');
							$objValidator->setAttribute('name', $strKey);
							$objValidator->setAttribute('configpath', $arrValue['configpath']);
							$objAction->appendChild($objValidator);
						}
					}
				}

				$objActions->appendChild($objAction);
			}
		}
		/*
		 *    - actionchain
		 */
		if (isset($arrNewConfiguration['actionchain'])) {
			$objComment = $objDOM->createComment('Action-chain');
			$objActions->appendChild($objComment);

			foreach ($arrNewConfiguration['actionchain'] as $strActionChain=>$arrVlues) {
				$objActionChain = $objDOM->createElement('action-chain');
				$objActionChain->setAttribute('path', $strActionChain);
				if (isset($arrVlues['actions'])) {
					foreach ($arrVlues['actions'] as $strAction=>$arrAction) {
						$objAction = $objDOM->createElement('action');
						$objAction->setAttribute('path', $strAction);

						foreach ($arrAction as $strKey=>$mixValue) {
							if (in_array($strKey, array('classpath', 'type', 'info', 'visible'))) {
								$objAction->setAttribute($strKey, $mixValue);
							} elseif (strcmp($strKey, 'forwards')==0) {
								/*
								 * forward
								 */
								foreach ($mixValue as $strKey=>$strValue) {
									$objForward = $objDOM->createElement('forward');
									$objForward->setAttribute('name', $strKey);
									$objForward->setAttribute('view', $strValue['view']);
									if (isset($strValue['classpath'])) {
										$objForward->setAttribute('classpath', $strValue['classpath']);
									}

									$objAction->appendChild($objForward);
								}
							} elseif (strcmp($strKey, 'validators')==0) {
								foreach ($mixValue as $strKey=>$arrValue) {
									$objValidator = $objDOM->createElement('validator');
									$objValidator->setAttribute('name', $strKey);
									$objValidator->setAttribute('configpath', $arrValue['configpath']);
									$objAction->appendChild($objValidator);
								}
							}
						}
						$objActionChain->appendChild($objAction);
					}
				}
				if (isset($arrVlues['calls'])) {
					foreach ($arrVlues['calls'] as $strKey=>$arrCall) {
						$objCall = $objDOM->createElement('call');
						if (isset($arrCall['action-chain'])) {
							$objCall->setAttribute('action-chain', $arrCall['action-chain']);
						} else {
							$objCall->setAttribute('action', $arrCall['action']);
						}

						$objActionChain->appendChild($objCall);
					}
				}
				$objActions->appendChild($objActionChain);
			}
		}

		/*
		 *    - preactions
		 */
		if (isset($arrNewConfiguration['preactions'])) {
			$objComment = $objDOM->createComment('Pre-actions');
			$objActions->appendChild($objComment);

			$objPreActions = $objDOM->createElement('pre-actions');

			if (isset($arrNewConfiguration['preactions']['actions'])) {
				foreach( $arrNewConfiguration['preactions']['actions'] as $strAction=>$arrAction) {
					$objAction = $objDOM->createElement('action');
					$objAction->setAttribute('path', $strAction);

					foreach ($arrAction as $strKey=>$mixValue) {
						if (in_array($strKey, array('classpath', 'type', 'info', 'visible'))) {
							$objAction->setAttribute($strKey, $mixValue);
						} elseif (strcmp($strKey, 'forwards')==0) {
							/*
							 * forward
							 */
							foreach ($mixValue as $strKey=>$strValue) {
								$objForward = $objDOM->createElement('forward');
								$objForward->setAttribute('name', $strKey);
								$objForward->setAttribute('view', $strValue['view']);
								if (isset($strValue['classpath'])) {
									$objForward->setAttribute('classpath', $strValue['classpath']);
								}

								$objAction->appendChild($objForward);
							}
						} elseif (strcmp($strKey, 'validators')==0) {
							foreach ($mixValue as $strKey=>$arrValue) {
								$objValidator = $objDOM->createElement('validator');
								$objValidator->setAttribute('name', $strKey);
								$objValidator->setAttribute('configpath', $arrValue['configpath']);
								$objAction->appendChild($objValidator);
							}
						}
					}

					$objPreActions->appendChild($objAction);
				}
			}
			if (isset($arrNewConfiguration['preactions']['excepts']['actions']) || isset($arrNewConfiguration['preactions']['excepts']['actionchain'])) {
				$objExcept = $objDOM->createElement('except-for');
				//$objExceptActions = $objDOM->createElement('post-actions');
				if (isset($arrNewConfiguration['preactions']['excepts']['actions'])) {
					foreach ($arrNewConfiguration['preactions']['excepts']['actions'] as $strAction=>$arrAction) {
						$objAction = $objDOM->createElement('action');
						$objAction->setAttribute('path', $strAction);
						$objExcept->appendChild($objAction);
					}
					$objPreActions->appendChild($objExcept);
				}
				if (isset($arrNewConfiguration['preactions']['excepts']['actionchain'])) {
					foreach ($arrNewConfiguration['preactions']['excepts']['actionchain'] as $strAction=>$arrAction) {
						$objAction = $objDOM->createElement('action-chain');
						$objAction->setAttribute('path', $strAction);
						$objExcept->appendChild($objAction);
					}
					$objPreActions->appendChild($objExcept);
				}
			}
			$objActions->appendChild($objPreActions);
		}

		/*
		 *    - preactions
		 */
		if (isset($arrNewConfiguration['postactions'])) {
			$objComment = $objDOM->createComment('Post-actions');
			$objActions->appendChild($objComment);

			$objPostActions = $objDOM->createElement('post-actions');
			if (isset($arrNewConfiguration['postactions']['actions'])) {
				foreach ($arrNewConfiguration['postactions']['actions'] as $strAction=>$arrAction) {
					$objAction = $objDOM->createElement('action');
					$objAction->setAttribute('path', $strAction);

					foreach ($arrAction as $strKey=>$mixValue) {
						if (in_array($strKey, array('classpath', 'type', 'info', 'visible'))) {
							$objAction->setAttribute($strKey, $mixValue);
						} elseif (strcmp($strKey, 'forwards')==0) {
							/*
							 * forward
							 */
							foreach ($mixValue as $strKey=>$strValue) {
								$objForward = $objDOM->createElement('forward');
								$objForward->setAttribute('name', $strKey);
								$objForward->setAttribute('view', $strValue['view']);
								if (isset($strValue['classpath'])) {
									$objForward->setAttribute('classpath', $strValue['classpath']);
								}

								$objAction->appendChild($objForward);
							}
						} elseif (strcmp($strKey, 'validators')==0) {
							foreach ($mixValue as $strKey=>$arrValue) {
								$objValidator = $objDOM->createElement('validator');
								$objValidator->setAttribute('name', $strKey);
								$objValidator->setAttribute('configpath', $arrValue['configpath']);
								$objAction->appendChild($objValidator);
							}
						}
					}

					$objPostActions->appendChild($objAction);
				}
			}

			if (isset($arrNewConfiguration['postactions']['excepts']['actions']) || isset($arrNewConfiguration['postactions']['excepts']['actionchain'])) {
				$objExcept = $objDOM->createElement('except-for');
				//$objExceptActions = $objDOM->createElement('post-actions');
				if ($arrNewConfiguration['postactions']['excepts']['actions']) {
					foreach ($arrNewConfiguration['postactions']['excepts']['actions'] as $strAction=>$arrAction) {
						$objAction = $objDOM->createElement('action');
						$objAction->setAttribute('path', $strAction);
						$objExcept->appendChild($objAction);
					}
					$objPreActions->appendChild($objExcept);
				}
				if (isset($arrNewConfiguration['postactions']['excepts']['actionchain'])) {
					foreach ($arrNewConfiguration['postactions']['excepts']['actionchain'] as $strAction=>$arrAction) {
						$objAction = $objDOM->createElement('action-chain');
						$objAction->setAttribute('path', $strAction);
						$objExcept->appendChild($objAction);
					}
					$objPostActions->appendChild($objExcept);
				}
			}

			$objActions->appendChild($objPostActions);
		}
		$objConfigurationXML->appendChild($objActions);

		if (is_writeable($this->strConfigFileName.$this->strConfigExtension)) {
			$objDOM->formatOutput = true;
			if ($objDOM->save($this->strConfigFileName.$this->strConfigExtension)===false) {
				throw new WF_Configuration_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['UPDATE']);
			}
		} else {
			throw new WF_Configuration_Exception(Languages::$MESSAGES[WebFramework::$strLanguage]['EXCEPTIONS']['CONFIGURATION']['SAVE_PHP']);
		}


		/*echo '<pre>';
		echo htmlspecialchars($objDOM->saveXML());
		echo '</pre>';*/
	}

}
?>