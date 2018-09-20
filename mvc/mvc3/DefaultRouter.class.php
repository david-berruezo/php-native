<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		DefaultRouter.class.php
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
 * Default URL driver's class
 *
 * @name DefaultRouter
 * @version 1.0.0
 * @package web.framework
 * @subpackage Context
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class DefaultRouter implements IRouter {
	private
		$strURLBase = '',
		$strDefaultLanguage = '',
		$arrGET = array();
		
	private
	   $strAction = null;
	
	/**
	 * The class constructor
	 *
	 * @access public
	 * @param string URL base (for example it's www.someurl.com from www.someurl.com/action=mypage URL)
	 * @param string default language name
	 */
	public function __construct($strURL, $strDefaultLanguage) {
		$this->strURLBase = $strURL;
		$this->strDefaultLanguage = $strDefaultLanguage;
		$this->arrGET = $_GET;

		if (isset($_GET['action'])) {
            $this->strAction = "action={$_GET['action']}";
		} elseif (isset($_GET['achain'])) {
            $this->strAction = "action={$_GET['achain']}";
		}
		
		unset($_GET);
	}
	
	/**
	 * Make URL based on PHP's array
	 *
	 * @access public
	 * @param array array with variables to make URL (array('foo'=>'bar', 'foo2') make URL www.someurl.com/foo=bar&foo2)
	 * @param boolean true==HTTPS, false==HTTP
	 * @return string new URL address
	 */
	public function makeURL($arrVariables, $blnSSL=false) {
		$strURL = $this->strURLBase.'?';
		
		if ($blnSSL && defined('_HTTPS_SUPPORT') && _HTTPS_SUPPORT) {
			$strURL = preg_replace('/^http:\/\//', 'https://', $strURL);
		}

		if ($this->strAction!==null) {
            $strURL .=$this->strAction.'&amp;';
		}
				
		if (is_array($arrVariables)) {
			foreach ($arrVariables as $strKey=>$strVal) {
				$strURL .= is_string($strKey) ? "$strKey=$strVal&amp;" : "$strVal&amp;";
			}
		}
		
		return $strURL;
	}
	
	/**
	 * Return action name (or null)
	 *
	 * @access public
	 * @return string action name, or null, when action is undefined
	 */	
	public function getAction() {
		return $this->get('action');
	}
	
	/**
	 * Return action chain name (or null)
	 *
	 * @access public
	 * @return string action chain name, or null, when action chain is undefined
	 */	
	public function getActionChain() {
		return $this->get('achain');
	}
	
	/**
	 * Set new action name (for change it before use makeURL() method)
	 *
	 * @access public	 
	 * @param string new action name
	 * @return string last action name, or null, when action was undefined
	 */	
	public function setAction($strAction) {
	    $this->strAction = "action=$strAction";
	}
	
	/**
	 * Set new action chain name (for change it before use makeURL() method)
	 *
	 * @access public	 
	 * @param string new action chain name
	 * @return string last action chain name, or null, when action chain was undefined
	 */	
	public function setActionChain($strActionChain) {
	    $this->strAction = "achain=$strActionChain";
	}
	
	/**
	 * Get language name (or null)
	 *
	 * @access public
	 * @return string language name, or null when langauge isn't set in URL and isn't set default language in constructor
	 */	
	public function getLanguage() {
		return $this->get('lang', isset($this->strDefaultLanguage) ? $this->strDefaultLanguage : null);
	}
	
	/**
	 * Get variable from URL (like $_GET)
	 *
	 * @access public
	 * @param string key
	 * @param string default value (when key doesn't exist in URL)
	 * @return string value
	 */	
	public function get($strKey, $strDefault=null) {
		return isset($this->arrGET[$strKey]) ? $this->arrGET[$strKey] : $strDefault;
	}
	
	/**
	 * Return array with all variables form URL (return $_GET array)
	 *
	 * @access public
	 * @return array all variables
	 */	
	public function getAll() {
		return $this->arrGET;
	}	
}
?>