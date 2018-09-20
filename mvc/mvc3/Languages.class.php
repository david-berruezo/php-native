<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Languages.class.php
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
 * Class with any messages in any supported languages (messages for exceptions and any other informations)
 *
 * @name Languages
 * @version 1.0.0
 * @package web.framework
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class Languages {
	public static
		$MESSAGES = array (
			'ENGLISH' => array (
				'EXCEPTIONS' => array (
					'CONFIGURATION' => array (
						'NOT_FOUND' => '<b>Config file (%s) not found!</b>',
						'PARSER_INSTANCE' => '<b>Parser class must implement intefrace IConfigurationParser!</b>',
						'UPDATE' => '<b>Can\'t update XML configuration file!</b>',
						'SAVE_PHP' => '<b>Can\'t save configuration file!</b>',
						'CONFIGURATION_ERROR' => '<b>Error in configuration file!</b>',
						'PARSER' => array (
							'LOAD' => '<b>Can\'t open XML config file!</b>',
							'REQUIRED' => '<b>Tag %s required %s parameters!</b>',
							'UNKNOWN_PARAM' => '<b>Unknown %s parameter in tag %s!</b>',
							'NOT_ALLOWED' => '<b>Tag %s is not allowed here!</b>',
						),
					),
					'VALIDATOR' => array (
						'NOT_FOUND' => '<b>Validator config file (%s) not found!</b>',
						'PARSER_INSTANCE' => '<b>Parser class must implement intefrace IValidatorsParser!</b>',
						'SAVE_PHP' => '<b>Can\'t save validator file!</b>',
						'TESTER_NOT_FOUND' => '<b>Tester file (%s) not found!</b>',
						'REQUIRED' => '<b>No required parameter in form!</b>',
						'TESTER_INSTANCE' => '<b>Tester class must implement intefrace ITester!</b>',
						'PARSER' => array (
							'LOAD' => '<b>Can\'t open XML config file of validator!</b>',
							'REQUIRED' => '<b>Tag %s required %s parameters (validator)!</b>',
							'NOT_ALLOWED' => '<b>Tag %s is not allowed here (validator)!</b>',
						),
					),
					'AUTHORIZATION_INTERFACE' => '<b>Authorization must implement IAuthorization!</b>',
					'NO_ACTION_FILE' => '<b>Action file not found (%s)!</b>',
					'ROUTER_INTERFACE' => '<b>Router must implement IRouter!</b>',
					'TOKEN_INTERFACE' => '<b>Token must implement IToken!</b>',
					'ACTION_INTERFACE' => '<b>Action must extend Action class!</b>',
					'URL_PARAMETER' => '<b>Undefined URL parameter (see in configuration file)!</b>',
					'NO_ACTION_IN_AC' => '<b>No actions in action chain (%s)!</b>',
					'NO_ACTION_CHAIN' => '<b>Undefined actionchain (%s)!</b>',
					'NO_ACTION' => '<b>Undefined action (%s)!</b>',
					'REQUIRED_ACTION_OR_ACTIONCHAIN' => '<b>Required action or action-chain - nothing to do!</b>',
					'UNKNOWN_VIEW' => '<b>Unknown view %s!</b>',
					'VIEW_NOT_FOUND' => '<b>View class file %s not found!</b>',

					'STRING_PARAM' => 'Required string parameter',
				),
			),
			'POLISH' => array (
				'EXCEPTIONS' => array (
					'CONFIGURATION' => array (
						'NOT_FOUND' => '<b>Nie odnaleziono pliku konfiguracyjnego (%s)!</b>',
						'PARSER_INSTANCE' => '<b>Klasa parsera musi implementować interfejs IConfigurationParser!</b>',
						'UPDATE' => '<b>Błąd podczas próby zapisu konfiguracji w postaci XML-a!</b>',
						'SAVE_PHP' => '<b>Błąd podczas próby zapisu tablicy konfiguracyjnej!</b>',
						'CONFIGURATION_ERROR' => '<b>Błąd w pliku konfiguracyjnym!</b>',
						'PARSER' => array (
							'LOAD' => '<b>Problem podczas próby otwarcia pliku konfiguracyjnego!</b>',
							'REQUIRED' => '<b>Tag %s wymaga następujących parametrów: %s!</b>',
							'UNKNOWN_PARAM' => '<b>Nieznany parametr %s w tagu %s!</b>',
							'NOT_ALLOWED' => '<b>Niespodziewane wystąpienie tagu %s!</b>',
						),
					),
					'VALIDATOR' => array (
						'NOT_FOUND' => '<b>Nie odnaleziono pliku konfiguracyjnego validatora (%s)!</b>',
						'PARSER_INSTANCE' => '<b>Klasa parsera musi implementować interfejs IValidatorsParser!</b>',
						'SAVE_PHP' => '<b>Błąd podczas próby zapisu tablicy validatora!</b>',
						'TESTER_NOT_FOUND' => '<b>Nie odnaleziono pliku testera (%s)!</b>',
						'CONFIGURATION_ERROR' => '<b>Błąd konfiguracji validatora (%s)!</b>',
						'REQUIRED' => '<b>Brak wymaganego parametru w formularzu!</b>',
						'TESTER_INSTANCE' => '<b>Tester musi implementować interfejs ITester!</b>',
						'PARSER' => array (
							'LOAD' => '<b>Problem podczas próby otwarcia pliku konfiguracji validatora!</b>',
							'REQUIRED' => '<b>Tag %s wymaga następujących parametrów: %s (validator)!</b>',
							'NOT_ALLOWED' => '<b>Niespodziewane wystąpienie tagu %s (validator)!</b>',
						),
					),
					'AUTHORIZATION_INTERFACE' => '<b>Klasa autoryzująca musi być implementacją IAuthorization!</b>',
					'ROUTER_INTERFACE' => '<b>Router musi być implementacją IRouter!</b>',
					'TOKEN_INTERFACE' => '<b>Token musi być implementacją IToken!</b>',
					'ACTION_INTERFACE' => '<b>Akcja musi dziedziczyć z klasy Action!</b>',
					'URL_PARAMETER' => '<b>Nie zdefiniowano parametru URL w konfiguracji!</b>',
					'NO_ACTION_IN_AC' => '<b>Brak akcji w łańcuchu akcji (%s)!</b>',
					'NO_ACTION_CHAIN' => '<b>Nie zdefiniowany łańcuch akcji (%s)!</b>',
					'NO_ACTION' => '<b>Nieznana akcja (%s)!</b>',
					'REQUIRED_ACTION_OR_ACTIONCHAIN' => '<b>Wymagana akcja lub łańcuch akcji!</b>',
					'UNKNOWN_VIEW' => '<b>Nieznany widok %s!</b>',
					'VIEW_NOT_FOUND' => '<b>Nie odnaleziono klasy widoku %s!</b>',

					'STRING_PARAM' => 'Wymagany parametr typu string',
				),
			),
		);
}
?>