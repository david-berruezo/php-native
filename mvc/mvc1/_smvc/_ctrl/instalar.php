<?php
/**
 * Smvc - Simple MVC
 * @package SMVC
 * @author Paulo Rocha
 * @copyright 2009 - 2009 Ahcor Design
 * @license		http://smvc.tk/manual/license.html
 * @link		http://smvc.tk
 * @since		Version 0.01
 * @filesource	http://smvc.tk/download
 * @category	Instalar
 * @uses		Default controller (in the install). This controllers is used for: Install, Configurations and Management of aplication.
 */
class Instalar extends Smvc
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{		
		$this->view("_instalar/splash");
	}
	
	function manual($valor="")
	{
		$this->view("_instalar/manual");
	}
	
	function criar()
	{
		$this->view("_instalar/criar");
	}
	function configurar()
	{
		$this->view("_instalar/configurar");
	}	

}

?>