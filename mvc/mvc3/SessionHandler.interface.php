<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		SessionHandler.interface.php
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
 * This interface must be implemented by any sesions classes
 *
 * @name ISessionHandler
 * @version 1.0.0
 * @package web.framework
 * @subpackage Context
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
interface ISessionHandler {
	/**
	 * Start session
	 *
	 * @access public
	 * @param string path to the session's files directory
	 * @param string session's name
	 * @return boolean
	 */
	public function start($strPath, $strName);
	
	/**
	 * stop session
	 *
	 * @access public
	 * @return boolean
	 */
	public function stop();
	
	
	/**
	 * Read data from session
	 *
	 * @access public
	 * @param string session ID
	 * @return string value
	 */
	public function read($strID);
	
	/**
	 * Write data to session
	 *
	 * @access public
	 * @param string session ID
	 * @param string session data
	 * @return boolean
	 */
	public function write($strID, $strValue);
	
	/**
	 * Session destroy
	 *
	 * @access public
	 * @param string session ID
	 * @return boolean
	 */	
	public function destroy($strID);
	
	/**
	 * garbage collection
	 *
	 * @access public
	 * @param int session max life time
	 * @return boolean
	 */	
	public function gc($intMaxLifeTime);
}
?>