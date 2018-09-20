<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		WebFramework.class.php
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
 * The main class
 *
 * @name WebFramework
 * @version 1.0.0
 * @package web.framework
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class WebFramework {
	public static
		$strLanguage = 'ENGLISH';

	public static
		$intMajorVersion = 1,
		$intMinorVersion = 0,
		$intUpdateVersion = 0;

	private
		$objConfiguration = null,
		$arrConfiguration = array();

	private
		$objValidator = null;

	private
		$arrActionsResponses = array(),
		$objActionForm = null,
		$objRouter = null,
		$objHTTPResponse = null,
		$objHTTPRequest = null,
		$objSession = null,
		$objActionsSharedData = null,
		$objTemplate = null,
		$objToken = null,
		$objAuthorization = null;

	private
		$blnTokenRespone = false,
		$strNewToken = null;

	/**
	 * The class constructor
	 *
	 * @access public
	 */
	public function __construct() {
		/*
		 * Configuration reading - it's this place web.framework can discard ill-looking (PHP standard) throw
		 */
		if (defined(WEBFRAMEWORK_CONFIGURATION_PARSER)) {
			$this->objConfiguration = Configuration::construct(WEBFRAMEWORK_CONFIGURATION_PARSER, WEBFRAMEWORK_CONFIGURATION_FILE_DIR, WEBFRAMEWORK_CONFIGURATION_FILE_EXTENSION);
		} else {
			$this->objConfiguration = Configuration::construct('DefaultConfigurationParser', WEBFRAMEWORK_CONFIGURATION_FILE_DIR, WEBFRAMEWORK_CONFIGURATION_FILE_EXTENSION);
		}

		$this->arrConfiguration = $this->objConfiguration->getConfiguration();
	}

	/**
	 * Application start
	 *
	 * @access public
	 * @throws WF_Exception
	 */
	public function run() {
		try {
			if (!isset($this->arrConfiguration['settings']['URL'])) {
				throw new WF_Exception(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['URL_PARAMETER']);
			}

			if (isset($this->arrConfiguration['settings']['defaultLanguage'])) {
				self::$strLanguage = $this->arrConfiguration['settings']['defaultLanguage'];
			}

			/*
			 * Router
			 */
			if (isset($this->arrConfiguration['settings']['router'])) {
				require_once(WEBFRAMEWORK_CORE_DIR.'Context'.DIRECTORY_SEPARATOR.'Router'.DIRECTORY_SEPARATOR.'Routers'.DIRECTORY_SEPARATOR.$this->arrConfig['settings']['router'].'class.php');
				$this->objRouter = new $this->arrConfig['settings']['router']($this->arrConfiguration['settings']['URL'], self::$strLanguage);
				if(!($this->objRouter instanceof IRouter ))
					throw new WF_Exception(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['ROUTER_INTERFACE']);
			} else {
				$this->objRouter = new DefaultRouter($this->arrConfiguration['settings']['URL'], self::$strLanguage);
			}

			/*
			 * Session
			 */
			$objSessionHandler = null;
			if (isset($this->arrConfiguration['settings']['sessionHandler'])) {
				require_once(WEBFRAMEWORK_CORE_DIR.'Context'.DIRECTORY_SEPARATOR.'Session'.DIRECTORY_SEPARATOR.'SessionHandlers'.DIRECTORY_SEPARATOR.$this->arrConfig['settings']['sessionHandler'].'class.php');
				$objSessionHandler = new $this->arrConfig['settings']['sessionHandler']();
			}
			$this->objSession = new Session($objSessionHandler);

			/*
			 * session start
			 */
			if (isset($this->arrConfiguration['settings']['autoStartSession']) && strcmp($this->arrConfiguration['settings']['autoStartSession'], 'true')==0) {
				$this->objSession->start();
			}

			/*
			 * HTTPResponse
			 */
			if (isset($this->arrConfiguration['settings']['HTTPResponse'])) {
				require_once(WEBFRAMEWORK_CORE_DIR.'Context'.DIRECTORY_SEPARATOR.'Response'.DIRECTORY_SEPARATOR.'Responses'.DIRECTORY_SEPARATOR.$this->arrConfiguration['settings']['HTTPResponse'].'.class.php');
				$this->objHTTPResponse = new $this->arrConfiguration['settings']['HTTPResponse']($this->objSession);
			} else {
				$this->objHTTPResponse = new GZipResponse($this->objSession);
			}

			/*
			 * HTTPRequest
			 */
			$this->objHTTPRequest = new HTTPRequest($this->objRouter);

			/*
			 * ActionsSharedData
			 */
			$this->objActionsSharedData = ActionsSharedData::construct();


			/*
			 * Token
			 */
			$this->objToken = null;
			if (isset($this->arrConfiguration['token'])) {

				$strTokenFormName = (isset($this->arrConfiguration['token']['tokenName'])) ?
										$this->arrConfiguration['token']['tokenName'] :
										'webframework_token_ID_name';

				if (isset($this->arrConfiguration['token']['method'])) {
					$intTokenSendMethod = (strcmp($this->arrConfiguration['token']['method'], 'POST')==0) ? HTTPRequest::POST : HTTPRequest::GET;
				} else {
					$intTokenSendMethod = HTTPRequest::POST;
				}

				if (isset($this->arrConfiguration['token']['tokenDriver'])) {
					$this->objToken = new Token($strTokenFormName, $intTokenSendMethod, $this->objHTTPRequest, $this->objSession, $this->arrConfiguration['token']['tokenDriver']);
				} else {
					$this->objToken = new Token($strTokenFormName, $intTokenSendMethod, $this->objHTTPRequest, $this->objSession);
				}
			}

			/*
			 * Authorization
			 */
			if (isset($this->arrConfiguration['authorization']) &&
				isset($this->arrConfiguration['authorization']['driver']) &&
				isset($this->arrConfiguration['authorization']['accessDenitedView'])) {

				$strDriverPath = isset($this->arrConfiguration['authorization']['driverPath']) ?
									$this->arrConfiguration['authorization']['driverPath'] :
									WEBFRAMEWORK_CORE_DIR.'Authorization'.DIRECTORY_SEPARATOR.'AuthorizationDrivers'.DIRECTORY_SEPARATOR;

				require_once($strDriverPath.$this->arrConfiguration['authorization']['driver'].'.class.php');
				$this->objAuthorization = new $this->arrConfiguration['authorization']['driver']($this->objHTTPRequest, $this->objSession);

				if (!($this->objAuthorization instanceof IAuthorization)) {
					throw new WF_Exception(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['AUTHORIZATION_INTERFACE']);
				}
				//TODO: all
				// - tworzenei klasy autoryzacyjnej
				// - sprawdzenie instancji klasy (IAuthorization)
			}

			/*
			 * Templates
			 */
			if (isset($this->arrConfiguration['template'])
				&& isset($this->arrConfiguration['template']['templateDir'])
				&& isset($this->arrConfiguration['template']['cacheDir'])
				&& isset($this->arrConfiguration['template']['compileDir'])) {

				$strTplClass = 'WebTemplate_File';
				if (isset($this->arrConfiguration['template']['template'])) {
					$strTplClass = $this->arrConfiguration['template']['template'];
				}

				$this->objTemplate = new $strTplClass($this->arrConfiguration['template']['templateDir'], $this->arrConfiguration['template']['cacheDir'], $this->arrConfiguration['template']['compileDir']);
				//echo 'in';
			}


			/*
			 * pre-actions
			 */
			if (isset($this->arrConfiguration['preactions']['actions']) && $this->chackPrePostAction(1)) {
				foreach ($this->arrConfiguration['preactions']['actions'] as $strActionName=>$arrAction) {
					$this->executeAction($strActionName, $arrAction);
				}
			}

			/*
			 * main action or action-chain handling
			 */
			if ($this->objRouter->getAction()!==null) { /* Action */
				$strActionName = $this->objRouter->getAction();
				if (isset($this->arrConfiguration['actions'][$strActionName])) {
					$this->executeAction($strActionName, $this->arrConfiguration['actions'][$strActionName]);
				} else {
					throw new WF_Exception404(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['NO_ACTION'], $strActionName));
				}
			} elseif ($this->objRouter->getActionChain()!==null) { /* ActionChain */
				$strActionChain = $this->objRouter->getActionChain();
				if(isset($this->arrConfiguration['actionchain'][$strActionChain])) {
						$this->executeActionChain($strActionChain, $this->arrConfiguration['actionchain'][$strActionChain]);
				} else {
					throw new WF_Exception404(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['NO_ACTION_CHAIN'], $strActionChain));
				}
			} elseif (isset($this->arrConfiguration['settings']['defaultAction'])) { /* Default action */
				$strActionName = $this->arrConfiguration['settings']['defaultAction'];
				if (isset($this->arrConfiguration['actions'][$strActionName])) {
					$this->executeAction($strActionName, $this->arrConfiguration['actions'][$strActionName]);
				} else {
					throw new WF_Exception404(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['NO_ACTION'], $strActionName));
				}
			} elseif(isset($this->arrConfiguration['settings']['defaultActionChain'])) { /* Default action */
				$strActionChain = $this->arrConfiguration['settings']['defaultActionChain'];
				if (isset($this->arrConfiguration['actionchain'][$strActionChain])) {
						$this->executeActionChain($strActionChain, $this->arrConfiguration['actionchain'][$strActionChain]);
				} else {
					throw new WF_Exception(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['NO_ACTION_CHAIN'], $strActionChain));
				}
			} else
				throw new WF_Exception(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['REQUIRED_ACTION_OR_ACTIONCHAIN']);

			/*
			 * post-actions
			 */
			if (isset($this->arrConfiguration['postactions']['actions']) && $this->chackPrePostAction(2)) {
				foreach ($this->arrConfiguration['postactions']['actions'] as $strActionName=>$arrAction) {
					$this->executeAction($strActionName, $arrAction);
				}
			}
		} catch (Exception $e) {
			if (isset($this->arrConfiguration['settings']['applicationErrorAction']) && isset($this->arrConfiguration['actions'][$this->arrConfiguration['settings']['applicationErrorAction']])) {
				$this->objActionsSharedData->addData('exception', $e);
				$this->executeAction($this->arrConfiguration['settings']['applicationErrorAction'], $this->arrConfiguration['actions'][$this->arrConfiguration['settings']['applicationErrorAction']]);
			} else {
				$this->objHTTPResponse->cleanOutput();
				echo 'Exception '.$e->getMessage().' in file '.$e->getFile().' at line '.$e->getLine().'.<br>';
			}
		}

		$this->objHTTPResponse->flush();
	}

	/**
	 * This method check if can execute pre- or post- action for current action or current action-chain
	 *
	 * @access private
	 * @param integer 1 - pre-actions, 2 - post-actions
	 * @return true - execute post- or pre- action is allowed, false - execute post- or pre- action is forbid
	 * @throws WF_Exception
	 */
	private function chackPrePostAction($intPrePost) {
		$strPrePost = $intPrePost==1 ? 'preactions' : 'postactions';

		if (!isset($this->arrConfiguration[$strPrePost]['excepts'])) {
			return true;
		}

		$strACName = '';
		$strActionOrChain = '';
		if ($this->objRouter->getAction()!==null) {
			$strACName = $this->objRouter->getAction();
			$strActionOrChain = 'actions';
		} elseif ($this->objRouter->getActionChain()!==null) {
			$strACName = $this->objRouter->getActionChain();
			$strActionOrChain = 'actionchain';
		} elseif (isset($this->arrConfiguration['settings']['defaultAction'])) {
			$strACName = $this->arrConfiguration['settings']['defaultAction'];
			$strActionOrChain = 'actions';
		} elseif (isset($this->arrConfiguration['settings']['defaultActionChain'])) {
			$strACName = $this->arrConfiguration['settings']['defaultActionChain'];
			$strActionOrChain = 'actionchain';
		} else {
			throw new WF_Exception(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['REQUIRED_ACTION_OR_ACTIONCHAIN']);
		}

		if (isset($this->arrConfiguration[$strPrePost]['excepts'][$strActionOrChain][$strACName])) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Execute action-chain
	 *
	 * @access private
	 * @param string action-chain name
	 * @param array array with action-chain configuration
	 * @throws WF_Exception
	 */
	private function executeActionChain($strName, $arrAChain) {
		if (isset($arrAChain['actions'])) {
			foreach ($arrAChain['actions'] as $strAction=>$arrAction) {
				$this->executeAction($strAction, $arrAction, $strName);
			}
		} else {
			throw new WF_Exception(printf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['URL_PARAMETER'], $strName));
		}

		if (isset($arrAChain['calls'])) {
			foreach ($arrAChain['calls'] as $strCall=>$arrCall) {
				if (isset($arrCall['action-chain'])) {
					if (isset($this->arrConfiguration['actionchain'][$arrCall['action-chain']])) {
						$this->executeActionChain($arrCall['action-chain'], $this->arrConfiguration['actionchain'][$arrCall['action-chain']]);
					} else {
						throw new WF_Exception(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['NO_ACTION_CHAIN'], $arrCall['action-chain']));
					}
				} elseif(isset($arrCall['action'])) {
					if (isset($this->arrConfiguration['actions'][$arrCall['action']])) {
						$this->executeAction($arrCall['action'], $this->arrConfiguration['actions'][$arrCall['action']], $strName);
					} else {
						throw new WF_Exception(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['NO_ACTION'], $arrCall['action']));
					}
				}
			}
		}
	}

	/**
	 * Execute action
	 *
	 * @access private
	 * @param string action name
	 * @param array array with action configuration
	 * @param string name of action-chain which execute this action (or null)
	 * @throws WF_Exception
	 */
	private function executeAction($strName, $arrAction, $strAChain=null) {
		$strActionPath = WEBFRAMEWORK_ACTIONS_DIR;
		if (isset($arrAction['classpath'])) {
			$strActionPath .= $arrAction['classpath'];
		}

		if (!file_exists($strActionPath.$arrAction['type'].'.class.php')) {
			throw new WF_Exception(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['NO_ACTION_FILE'], $strName));
		}

		// W akcji!!
		// - sprawdzenei czy akcja wymaga autoryzacji
		// - jeśli tak sprawdzenie czy user ma dostęp do danej akcji



	/**
	 * Execute view
	 *
	 * @access private
	 * @param string name of action which execute this view
	 * @param string view name
	 * @param array array with view configuration
	 * @param mixed action execute result
	 * @throws WF_Exception
	 */
		/*
		 * Authorization chceck
		 */
		if (isset($arrAction['authorization'])) {
			if (!$this->objAuthorization->check($strName, $strAChain, $arrAction['authorization'])) {
				if (isset($this->arrConfiguration['authorization']['accessDenitedViewPath'])) {
					$arrViewConfiguration['classpath'] = $this->arrConfiguration['authorization']['accessDenitedViewPath'];
				}
				$arrViewConfiguration['view'] = $this->arrConfiguration['authorization']['accessDenitedView'];

				$this->executeView($strName, $this->arrConfiguration['authorization']['accessDenitedView'], $arrViewConfiguration, $arrAction['authorization']);
				return;
			}
		}

		require_once($strActionPath.$arrAction['type'].'.class.php');

		/*
		 * validators - read settings and execute
		 */
		$arrValidatorsResults = array();
		if (isset($arrAction['validators'])) {
			foreach ($arrAction['validators'] as $strValidator=>$arrValidator) {
				$mixResult = $this->executeValidator($strValidator, $arrValidator);
				if ($mixResult!==null) {
					$arrValidatorsResults[$strValidator] = $mixResult;
				}
			}
		} else {
			$arrValidatorsResults = null;
		}

		/*
		 * Execute action
		 */
		$strInfo = null;
		if(isset($arrAction['info'])) {
			$strInfo = $arrAction['info'];
		}

		$objAction = new $arrAction['type']($strName, $this->objActionsSharedData, $this->objToken, $arrValidatorsResults, $this->objConfiguration, $this->objTemplate, $strInfo, $strAChain);

		if (!($objAction instanceof Action)) {
			throw new WF_Exception(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['ACTION_INTERFACE']);
		}

		//	abstract public function execute(HTTPRequest $objRequest, IHTTPResponse $objResponse, Session $objSession);
		/*
		RETURN:
			array(
				'View'		=> 'name of view from forward - see configuration file',
				'Response'	=> 'response from action to view',
				'Action'	=> 'action name to execute after this action or null', // not suuport jet
				'Errors'	=> 'array with exception to display in view' // not suuport jet
			);
		 */
		$arrResult = $objAction->execute($this->objHTTPRequest, $this->objHTTPResponse, $this->objSession);

		/*
		 * execute View
		 */
		if (isset($arrResult['View'])) {
			if (isset($arrAction['forwards'][$arrResult['View']])) {
				$this->executeView($strName, $arrResult['View'], $arrAction['forwards'][$arrResult['View']], isset($arrResult['Response']) ? $arrResult['Response'] : null);
			} else {
				throw new WF_Exception(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['UNKNOWN_VIEW'], $arrResult['View']));
			}
		}
	}

	/**
	 * Execute validator
	 *
	 * @access private
	 * @param string validator name
	 * @param array array with validator configuration
	 */
	private function executeValidator($strName, $arrSettings) {
		if (is_null($this->objValidator)) {
			if(defined(WEBFRAMEWORK_VALIDATORS_PARSER)) {
				$this->objValidator = Validator::construct($this->objHTTPRequest, WEBFRAMEWORK_VALIDATORS_PARSER, WEBFRAMEWORK_VALIDATORS_FILE_EXTENSION);
			} else {
				$this->objValidator = Validator::construct($this->objHTTPRequest, 'DefaultValidatorsParser', WEBFRAMEWORK_VALIDATORS_FILE_EXTENSION);
			}
		}

		$strValidatorsSubPath = '';
		if(isset($arrSettings['configpath'])) {
			$strValidatorsSubPath = $arrSettings['configpath'];
		}

		return $this->objValidator->validate(WEBFRAMEWORK_VALIDATORS_DIR.$strValidatorsSubPath.$strName);
	}

	/**
	 * Execute view
	 *
	 * @access private
	 * @param string name of action which execute this view
	 * @param string view name
	 * @param array array with view configuration
	 * @param mixed action execute result
	 * @throws WF_Exception
	 */
	private function executeView($strActionName, $strNameView, $arrView, $mixActionResult) {
		//echo "<br><br>$strActionName, $strView, $mixActionResult<br><br>";
		//print_r($arrView);
		$strViewPath = WEBFRAMEWORK_VIEWS_DIR;
		if (isset($arrView['classpath'])) {
			$strViewPath .= $arrView['classpath'];
		}

		if (!file_exists($strViewPath.$arrView['view'].'.class.php')) {
				throw new WF_Exception(sprintf(Languages::$MESSAGES[self::$strLanguage]['EXCEPTIONS']['VIEW_NOT_FOUND'], $arrView['view']));
		}

		require_once($strViewPath.$arrView['view'].'.class.php');

		$objView = new $arrView['view']();
		$objView->display($strActionName, $strNameView, $mixActionResult, $this->objTemplate);
	}
}


/**
 * Exception's web.frameworku
 * @package web.framework
 * @subpackage exceptions
 */
class WF_Exception extends Exception {}

/**
 * Exception's web.frameworku - no page (404)
 * @subpackage exceptions
 */
class WF_Exception404 extends Exception {}
?>