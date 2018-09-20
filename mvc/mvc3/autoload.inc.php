<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		autoload.inc.php
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
 * Autoloader
 *
 * @name __autoload
 * @version 1.0.0
 * @package web.framework
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
function __autoload($strClassName) {
	static
		$arrClassesMap = array (
			'WebFramework' => 'WebFramework.class.php',
			'Languages' => 'Others/Languages.class.php',

			'Configuration' => 'Configuration/Configuration.class.php',
			'IConfigurationParser' => 'Configuration/ConfigurationParser.interface.php',
			'WF_ConfigurationParser_Exception' => 'Configuration/ConfigurationParser.interface.php',
			'DefaultConfigurationParser' => 'Configuration/Parsers/DefaultConfigurationParser.class.php',

			'IRouter' => 'Context/Router/Router.interface.php',
			'DefaultRouter' => 'Context/Router/Routers/DefaultRouter.class.php',
			'Session' => 'Context/Session/Session.class.php',
			'ISessionHandler' => 'Context/Session/SessionHandler.interface.php',
			'IHTTPResponse' => 'Context/Response/HTTPResponse.interface.php',
			'GZipResponse' => 'Context/Response/Responses/GZipResponse.class.php',
			'HTTPRequest' => 'Context/Request/HTTPRequest.class.php',

			'Action' => 'Actions/Action.class.php',
			'ActionsSharedData' => 'Actions/ActionsSharedData.class.php',

			'ITemplate' => 'Template/Template.interface.php',
			'WebTemplate_File' => 'Template/TemplateDrivers/WebTemplate_File.class.php',
			'WebTemplate_DB' => 'Template/TemplateDrivers/WebTemplate_DB.class.php',

			'IView' => 'View/View.interface.php',

			'Validator' => 'Validators/Validator.class.php',
			'IValidatorsParser' => 'Validators/ValidatorsParser.interface.php',
			'WF_ValidatorsParser_Exception' => 'Validators/ValidatorsParser.interface.php',
			'DefaultValidatorsParser' => 'Validators/Parsers/DefaultValidatorsParser.class.php',
			'ITester' => 'Validators/Tester.interface.php',

			'Token' => 'Token/Token.class.php',
			'IToken' => 'Token/Token.interface.php',
			'DefaultToken' => 'Token/Tokens/DefaultToken.class.php',

			'IAuthorization' => 'Authorization/Authorization.interface.php',
		);

	if(isset($arrClassesMap[$strClassName]))
		require(WEBFRAMEWORK_CORE_DIR.$arrClassesMap[$strClassName]);
}

?>