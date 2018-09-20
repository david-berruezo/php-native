<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		SmartyTemplate_File.class.php
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
 * This class handling Smarty (this version looking for a templates on the HDD)
 *
 * @name SmartyTemplate_File
 * @version 1.0.0
 * @package web.framework
 * @subpackage Template
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class SmartyTemplate_File implements ITemplate {
	/**
	 * @var Smarty
	 */
	private
		$objTemplate = null;

	private
		$arrVars = array();

	/**
	 * The class constructor
	 *
	 * @access public
	 */
	public function __construct($strTplDir, $strCacheDir, $strCompileDir) {
		$this->objTemplate = new Smarty();

		$this->objTemplate->compile_dir = $strCompileDir;
		$this->objTemplate->cache_dir = $strCacheDir;
		$this->objTemplate->template_dir = $strTplDir;
	}

	/**
	 * Execute template and return result (with out display it on a standard output)
	 *
	 * @access public
	 * @param string template file name
	 * @param string compile IDs (divided by |)
	 * @return string template output
	 */
	public function fetch($strTemplate, $strID=false) {
		$this->assignArrVars();
		return $this->objTemplate->fetch($strTemplate, $strID);
	}

	/**
	 * Execute template file, and display result on standard output
	 *
	 * @access public
	 * @param string template file name
	 * @param string compile IDs (divided by |)
	 */
	public function display($strTemplate, $strID=false) {
		$this->assignArrVars();
		return $this->objTemplate->display($strTemplate, $strID);
	}

	/**
	 * Clear temlate's cache
	 *
	 * @access public
	 * @param string template file name (or null - clean only by chache IDs)
	 * @param string compile IDs (divided by |)
	 */
	public function clearCache($strTemplate, $strID=false) {
		$this->objTemplate->clear_cache($strTemplate, $strID);
	}

	/**
	 * This returns true if there is a valid cache for this template
	 *
	 * @access public
	 * @param string template file name
	 * @param string compile IDs (divided by |)
	 */
	public function isCached($strTemplate, $strID=false) {
		return $this->objTemplate->is_cached($strTemplate, $strID);
	}

	/**
	 * Set templates's caching
	 *
	 * @access public
	 * @param boolean true - save executed templates into cache files, false - don't use cache
	 * @return boolena value before this change
	 */
	public function setCaching($blnCaching) {
		$blnLastCaching = $blnCaching;
		$this->objTemplate->caching = $blnCaching;

		return $blnLastCaching;
	}

	/**
	 * Return the name of the directory where template caches are stored
	 *
	 * @access public
	 * @return string the name of the directory where template caches are stored
	 */
	public function getCacheDir() {
		return $this->objTemplate->cache_dir;
	}

	/**
	 * Set the name of the directory where template caches are stored
	 *
	 * @access public
	 * @param string the name of the directory where template caches are stored
	 * @return string old name of the directory where template caches are stored (before this change)
	 */
	public function setCacheDir($strCacheDir){
		$strLastCacheDir = $this->objTemplate->cache_dir;
		$this->objTemplate->cache_dir = $strCacheDir;

		return $strLastCacheDir;
	}

	/**
	 * Rrturn the name of the directory where compiled templates are located
	 *
	 * @access public
	 * @return string the name of the directory where compiled templates are located
	 */
	public function getCompileDir() {
		return $this->objTemplate->compile_dir;
	}

	/**
	 * Set the name of the directory where compiled templates are located
	 *
	 * @access public
	 * @param string the name of the directory where compiled templates are located
	 * @return string the old name of the directory where compiled templates are located (before this change)
	 */
	public function setCompileDir($strCompileDir) {
		$strLastCompileDir = $this->objTemplate->compile_dir;
		$this->objTemplate->compile_dir = $strCompileDir;

		return $strLastCompileDir;
	}

	/**
	 * Return the name of the default template directory
	 *
	 * @access public
	 * @return string the name of the default template directory
	 */
	public function getTemplateDir() {
		return $this->objTemplate->template_dir;
	}

	/**
	 * Set the name of the default template directory
	 *
	 * @access public
	 * @param string the name of the default template directory
	 * @return string the old name of the default template directory (before this change)
	 */
	public function setTemplateDir($strTemplateDir) {
		$strLastTemplateDir = $this->objTemplate->template_dir;
		$this->objTemplate->template_dir = $strTemplateDir;

		return $strLastTemplateDir;

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
		if (!is_string($strVar)) {
			throw new WT_Exception('Smarty::insert()');
		}

		if (!isset($this->arrVars[$strVar])) {
			$this->arrVars[$strVar] = array();
		}

		$this->arrVars[$strVar][] = $mixValue;
	}

	/**
	 * Assign all variables set by insert method
	 *
	 * @access private
	 */
	private function assignArrVars() {
		static $blnAssigned = false;

		if ($blnAssigned) {
			return;
		}

		foreach ($this->arrVars as $strKey=>$mixValue) {
			$this->objTemplate->assign($strKey, $mixValue);
		}

		$blnAssigned = true;
	}
}
?>