<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		Session.class.php
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
 * Session support
 *
 * @name Session
 * @version 1.0.0
 * @package web.framework
 * @subpackage Context
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class Session {
	
	/**
	 * The class constructor
	 *
	 * @access public
	 * @param ISessionHandler object implement ISessionHandler or null
	 */
	public function __construct($objSession=null) {
		if (isset($objSession) && ($objSession instanceof ISessionHandler)) {
			session_set_save_handler(array($objSession, 'start'),
									 array($objSession, 'stop'),
									 array($objSession, 'read'),
									 array($objSession, 'write'),
									 array($objSession, 'destroy'),
									 array($objSession, 'gc'));			
		}
	}

	/**
	 * Session start
	 *
	 * @access public
	 */
	public function start() {
		session_start();
	}
	
	/**
	 * Session destroy
	 *
	 * @access public
	 */
	public function destroy() {
		session_destroy();
	}
	
	/**
	 * Return session expire time
	 *
	 * @access public
	 * @return integer session expire timr
	 */
	public function getCacheExpire() {
		return session_cache_expire();
	}
	
	/**
	 * Set session expire time
	 *
	 * @access public
	 * @param integer new session expire time
	 * @return integer old (before this change) session expire time
	 */
	public function setCacheExpire($intTime) {
		return session_cache_expire($intTime);
	}
	
	/**
	 * Get the current cache limiter
	 *
	 * @access public
	 * @return string current cache limiter
	 */	
	public function getCacheLimiter() {
		return session_cache_limiter();
	}
	
	/**
	 * Set the cache limiter
	 *
	 * @access public
	 * @param string new cache limiter
	 * @return string old cache limiter (before this change)
	 */	
	public function setCacheLimiter($strLimiter) {
		return session_cache_limiter($strLimiter);
	}
	
	/**
	 * Return session ID
	 *
	 * @access public
	 * @return string current session ID
	 */	
	public function getID() {
		return session_id();
	}
	
	/**
	 * Set session ID
	 *
	 * @access public
	 * @param string new session ID
	 * @return string old session ID (before this change)
	 */	
	public function setID($strID) {
		return session_id($strID);
	}
	
	/**
	 * Get the current session module
	 *
	 * @access public
	 * @return string current session module
	 */	
	public function getModule() {
		return session_module_name();
	}
	
	/**
	 * Set the session module
	 *
	 * @access public
	 * @param string new session module
	 * @return string old session module (before this change)
	 */	
	public function setModule($strModule) {
		return session_module_name($strModule);
	}
	
	/**
	 * Return the current session name
	 *
	 * @access public
	 * @return string current session name
	 */	
	public function getName() {
		return session_name();
	}
	
	/**
	 * Set the current session name
	 *
	 * @access public
	 * @param string new session name
	 * @return string old session name (before this change)
	 */	
	public function setName($strName) {
		return session_name($strName);
	}
	
	/**
	 * Update the current session id with a newly generated one 
	 *
	 * @access public
	 */	
	public function regenerateID() {
		session_regenerate_id();
	}
	
	/**
	 * Write session data and end session
	 *
	 * @access public
	 */	
	public function commit() {
		session_commit();
	}
	
	/**
	 * Set the session cookie parameters 
	 *
	 * @access public
	 * @param integer life tiem
	 * @param string path
	 * @param string domain
	 */	
	public function setCookie($intTime, $strPath=null, $strDomain=null) {
		if (isset($strPath) && isset($strDomain)) {
			session_set_cookie_params($intTime, $strPath, $strDomain);
		} elseif (isset($strPath)) {
			session_set_cookie_params($intTime, $strPath);
		} else {
			session_set_cookie_params($intTime);
		}
	}
	
	/**
	 * Free all session variables 
	 *
	 * @access public
	 */	
	public function unsetVars() {
		session_unset();
	}
	
	/**
	 * Set session variables
	 *
	 * @access public
	 * @param mixed key or array (array('key'=>'value'))
	 * @param mixed value or null when key is an array
	 */	
	public function set($mixKey, $mixValue=null) {
		if (is_array($mixKey)) {
			foreach ($mixKey as $key=>$val) {
				if (strlen($key)>0) {
					$_SESSION[$key] = $val;
				}
			}
		} else {
			if (strlen($mixKey)>0) {
				$_SESSION[$mixKey] = $mixValue;
			}
		}
	}
	
	/**
	 * Return session variable
	 *
	 * @access public
	 * @param string key naem
	 * @return mixed value
	 */		
	public function get($strKey) {
		if (isset($_SESSION[$strKey])) {
			return $_SESSION[$strKey];
		} else {
			return null;
		}
	}
}
?>