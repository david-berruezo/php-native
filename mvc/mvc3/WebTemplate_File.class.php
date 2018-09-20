<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		WebTemplate_File.class.php
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
 * This class handling web.template (this version looking for a templates on the HDD)
 *
 * @name WebTemplate_File
 * @version 1.0.0
 * @package web.framework
 * @subpackage Template
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class WebTemplate_File implements ITemplate {
	private 
		$objTemplate = null;
		
	/**
	 * The class constructor
	 *
	 * @access public
	 */
	public function __construct($strTplDir, $strCacheDir, $strCompileDir) {
		$this->objTemplate = new WebTemplate();
		
		$this->objTemplate->setCacheDir($strCacheDir);
		$this->objTemplate->setCompileDir($strCompileDir);
		$this->objTemplate->setTemplateDir($strTplDir);
	}
	
	/**
	 * Execute template and return result (witch out display it on a standard output)
	 *
	 * @access public
	 * @param string template file name
	 * @param string compile IDs (divided by |)
	 * @return string template output
	 */	
	public function fetch($strTemplate, $strID=false) {
		return $this->objTemplate->fetch($strTemplate, $strID);
	}
	
	/**
	 * Execute template fil, and display result on standard output
	 *
	 * @access public
	 * @param string template file name
	 * @param string compile IDs (divided by |)
	 */	
	public function display($strTemplate, $strID=false) {
		$this->objTemplate->display($strTemplate, $strID);
	}
		
	/**
	 * Clear temlate's cache
	 *
	 * @access public
	 * @param string template file name (or null - clean only by chache IDs)
	 * @param string compile IDs (divided by |)
	 */
	public function clearCache($strTemplate, $strID=false) {
		$this->objTemplate->clearCache($strTemplate, $strID);
	}
	
	/**
	 * This returns true if there is a valid cache for this template
	 *
	 * @access public
	 * @param string template file name
	 * @param string compile IDs (divided by |)
	 */	
	public function isCached($strTemplate, $strID=false) {
		return $this->objTemplate->isCached($strTemplate, $strID);
	}
	
	/**
	 * Set templates's caching
	 *
	 * @access public
	 * @param boolean true - save executed templates into cache files, false - don't use cache
	 * @return boolena value before this change
	 */
	public function setCaching($blnCaching) {
		return $this->objTemplate->setCaching($blnCaching);
	}
	
	/**
	 * Return the name of the directory where template caches are stored
	 *
	 * @access public
	 * @return string the name of the directory where template caches are stored
	 */
	public function getCacheDir() {
		return $this->objTemplate->getCahceDir();
	}
		
	/**
	 * Set the name of the directory where template caches are stored
	 *
	 * @access public
	 * @param string the name of the directory where template caches are stored
	 * @return string old name of the directory where template caches are stored (before this change)
	 */
	public function setCacheDir($strCacheDir) {
		return $this->objTemplate->setCahceDir($strCacheDir);
	}
	
	/**
	 * Rrturn the name of the directory where compiled templates are located
	 *
	 * @access public
	 * @return string the name of the directory where compiled templates are located
	 */
	public function getCompileDir() {
		return $this->objTemplate->getCompileDir();
	}
	
	/**
	 * Set the name of the directory where compiled templates are located
	 *
	 * @access public
	 * @param string the name of the directory where compiled templates are located
	 * @return string the old name of the directory where compiled templates are located (before this change)
	 */
	public function setCompileDir($strCompileDir) {
		return $this->objTemplate->setCompileDir($strCompileDir);
	}
	
	/**
	 * Return the name of the default template directory
	 *
	 * @access public
	 * @return string the name of the default template directory
	 */
	public function getTemplateDir() {
		return $this->objTemplate->getTemplateDir();
	}
	
	/**
	 * Set the name of the default template directory
	 *
	 * @access public
	 * @param string the name of the default template directory
	 * @return string the old name of the default template directory (before this change)
	 */
	public function setTemplateDir($strTemplateDir) {
		return $this->objTemplate->setTemplateDir($strTemplateDir);
	}
	
	/**
	 * Assign values to the templates
	 *
	 * @access public
	 * @param mixed name of value, or array (array('name'=>value))
	 * @param mixed value
	 */
	public function assign($mixVar, $mixVal=null) {
		$this->objTemplate->assign($mixVar, $mixVal);
	}
	
	/**
	 * Insetr into $arrVar array (it's name of template variable) new element - $minxValue
	 *
	 * @access public
	 * @param string array name
	 * @param mixed value
	 */	
	public function insert($strVar, $mixValue) {
		$this->objTemplate->insert($strVar, $mixValue);
	}
}
?>