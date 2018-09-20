<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Action.class.php
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
 * This class must be extends by any Actions
 *
 * @name Action
 * @version 1.0.0
 * @package web.framework
 * @subpackage Actions
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
abstract class Action {
	public
		$objActionsSharedData = null,
		$objTemplate = null,
		$arrValidatorsResults = array(),
		$objConfiguration = null,
		$objToken = null;

	protected
		$strInfo = null,
		$strChain = null,
		$strPath = '';

	/**
	 * The class constructor (private)
	 *

	 * @access public
	 * @param string action name (path="name" in configuration file)
	 * @param ActionsSharedData shared data object
	 * @param Token token cass
	 * @param array result from validators (array('validator name')=>result, 'validator2 name'=>result, ...))
	 * @param Configuration framework configuration object
	 * @param ITemplate template driver object (or null)
	 * @param string information form configuration file (info="information to action")
	 * @param string nazwa action chain name or null
	 */
	public function __construct($strPath, ActionsSharedData $objASD, $objToken, $arrValidatorResult, $objConfiguration, $objTemplate, $strInfo=null, $strChain=null) {
		$this->objActionsSharedData = $objASD;
		$this->objConfiguration = $objConfiguration;
		$this->objToken = $objToken;

		$this->strInfo = $strInfo;
		$this->strChain = $strChain;
		$this->strPath = $strPath;

		$this->arrValidatorsResults = $arrValidatorResult;

		if($objTemplate == null)
			unset($this->objTemplate);
		else
			$this->objTemplate = $objTemplate;
	}

	/**
	 * Return information from configuration file (info="information to action")
	 *
	 * @access public
	 * @return string information from configuration file or null
	 */
	public function getInfo() {
		return urldecode($this->strInfo);
	}

	/**
	 * Return action chain name
	 *
	 * @access public
	 * @return string action chain name or null
	 */
	public function getChain() {
		return $this->strChain;
	}

	/**
	 * Path from configuration name (path="nazwa" in tag <action...> in configuration)
	 *
	 * @string nazwa
	 */
	public function getPath() {
		return $this->strPath;
	}

	/**
	 * This is main function of Action
	 *
	 * @access public
	 * @param HTTPRequest object of HTTP request class
	 * @param IHTTPResponse object of HTTP response class
	 * @param Session Session object
	 * @return array array <br>array(<br>  'View'=>'view name from forward',<br>  'Response'=>'action response to view',<br>  'Action'=>'action name to execute after this action or null', // not suuport jet<br>  'Errors'=>'array with exception to display in view' // not suuport jet<br>);<br>View and Response ar required! Action and Errors are not supported jet
	 */
	abstract public function execute(HTTPRequest $objRequest, IHTTPResponse $objResponse, Session $objSession);
}
?>