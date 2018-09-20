<?php
/**
 * Smvc - Simple MVC
 * @package SMVC
 * @author Paulo Rocha - http://paulorocha.tk
 * @copyright 2009 - 2009 Ahcor Design
 * @license		http://smvc.tk/manual/license.html
 * @link		http://smvc.tk
 * @since		Version 0.0.2
 * @filesource	http://smvc.tk/download
 * @category	Index
 * @uses		Enter point for SMVC
 */

class Smvc {

	public 	$db;
	public	$cfg;
	public 	$model;
	
	function __construct(){
		$this->cfg =&$GLOBALS['cfg'];
		$this->_startDb();
		//echo "<br>Carregou SMVC.";
	}
		
	function _startDb(){
		//Carrega Database (se estiver com auto load...)
		if(trim($this->cfg->db->active)!=""){
			$db = ucfirst(trim((string)$this->cfg->db->active));
			$this->db = new $db;
			}			
	}
	
	function view($view="index",$data=array(),$ret=false){
		if(file_exists($this->cfg->path.$this->cfg->core_path.$this->cfg->view.$view.'.php')){
			extract($data); //transforma as chaves do array em variaveis;
			ob_start();
			include($this->cfg->path.$this->cfg->core_path.$this->cfg->view.$view.'.php');
			
			if ($ret === TRUE){		
			$buffer = ob_get_contents();
			@ob_end_clean();
			return $buffer;}
			
			ob_end_flush();			
			}else{return false;}		
		}
	
}
//=================================================================================================
@session_start();
@$_SESSION['login']='20100050';
@define('URL','http://'.$_SERVER['HTTP_HOST']."/".$cfg->no_uri);
@trigger_error("");
@error_reporting(E_ALL);
//@ini_set("display_errors","0");
set_error_handler("trata_erros");
//resolve URI
$uri = str_replace($cfg->no_uri,"",$cfg->uri);
$uri = urldecode($uri);
$uri = explode("/",trim($uri,"/") );
//Controller	
if(!isset($uri[0]) || trim($uri[0])=="") {
//controller default
    $controller=ucfirst(trim((string)$cfg->default->ctrl));
    //checando e carregando o controller
    if(file_exists($cfg->path.$cfg->core_path.$cfg->ctrl.strtolower($controller).'.php')) {
        require_once($cfg->path.$cfg->core_path.$cfg->ctrl.strtolower($controller).'.php');
        $ctrl = new $controller;
		if((string)$cfg->default->func!=""){
		$ctrl->{(string)$cfg->default->func}();}else{trigger_error("Fun��o default n�o configurada!");}
    }
    else {trigger_error("Controller ('$controller') n�o encontrado.");}

}else {
//controller da url
    $controller=ucfirst(trim($uri[0]));
    //checando e carregando o controller
    if(file_exists($cfg->path.$cfg->core_path.$cfg->ctrl.strtolower($controller).'.php')) {
        require_once($cfg->path.$cfg->core_path.$cfg->ctrl.strtolower($controller).'.php');
        $ctrl = new $controller;
    }
    else {trigger_error("Controller ('$controller') n�o encontrado.");}
    //Function
    array_shift($uri);
    if(count($uri)==0) {
    //function default
        $function=(string)$cfg->default->func;
        if(method_exists($ctrl,trim($function))) {
        //chama a fun��o default se existir
            $ctrl->$function();}
        else {trigger_error("Fun��o ('$function') n�o encontrada.");}
    }else {
    //function designada na url
        if(method_exists($ctrl,trim($uri[0]))) {
            $cfg->default->func=$uri[0];
            $function=(string)$cfg->default->func;
        }else {trigger_error("Fun��o ('$uri[0]') n�o encontrada.");}
        //Argumentos
        array_shift($uri);
        if(count($uri)==0) {
        //sem argumentos - chama a fun��o
            if(method_exists($ctrl,$function)) {$ctrl->$function();}else {trigger_error("Fun��o ('$function') n�o encontrada.");}
        }else {
            if(method_exists($ctrl,$function)) {
                call_user_func_array(array($ctrl,$function),$uri);}else {trigger_error("Fun��o ('$function') n�o encontrada.");}
        }
}// fim function
}//	fim controller 
//=================================================================================================
//Fun��es que carregam as classes automaticamente.
function __autoload($class_name) {includeclass($class_name);}
function includeclass($class_name) {
    $cfg =& $GLOBALS['cfg'];
    $l=array($cfg->view,$cfg->model,$cfg->library,$cfg->driver,$cfg->db->drv,"");
    foreach($l as $loc) {
    //echo "<br> : ".$x->path.$x->core_path.$loc.strtolower($class_name).'.php';
        if(file_exists($cfg->path.$cfg->core_path.$loc.strtolower($class_name).'.php')) {
            require_once($cfg->path.$cfg->core_path.$loc.strtolower($class_name).'.php');
            return;
		}	
    }
    trigger_error("Classe n�o encontrada.");
    unset($X);
    return false;
}
//Fun��o de tratamento de erros - grava um log de erro e sinaliza no browser(fase de depura��o).
function trata_erros($num,$msg,$file,$line)//captura os erros do sistema:
{
    if($msg=="") {return false;}
    $data=date("d/m/y");
    $hora=date("H:i:s");
    $cfg =& $GLOBALS['cfg'];
	if(isset($_SESSION['login'])){$login=$_SESSION['login'];}else{$login=" - ";}
	$log="$data|$hora|$num|$msg|$line|$file|$login\n";
    if($cfg->erro_log=="1"){file_put_contents($cfg->path.$cfg->core_path."/log.txt",$log,FILE_APPEND);}
    if($cfg->erro_view=="1"){
		echo "<p style=\"text-align:right; width:100%; padding:1px 20px; margin:0; background:#FFF; position:fixed; bottom:0; left:0; right:0; color:#F00; font-size:8px; font-family:Verdana,Tahoma;\">ERRO=$num | $msg | $file - ($line)<p>";
		}
	if($cfg->erro_mail=="1"){
		$mail=new mail();
		$mail->Subject = "ERRO - GEDOC";
		$mail->From ="aplicativos@getesb.com.br";
		$mail->FromName="Getesb - Desenvolvimento";
		$mail->Host = "smtp2.aguasbr.com.br";
		$mail->Mailer = "smtp";
		$mail->ContentType="text/html";
		$mail->Body= $log;
		$mail->AddAddress("aplicativos@getesb.com.br");
		$mail->Send();
	}
    exit();
}
//mostra o uso de mem�ria e tempo de execu��o total - setar a constante STATUS habilitar� a exibi��o.
if($cfg->status=="1") {
    echo '<p align="right" style="padding:1px 20px; margin:0; background:#F9F9F9; position:fixed; bottom:0; left:0; right:0; color:#555; font-size:8px; font-family:Verdana,Tahoma;">Mem.: '.number_format(intval(memory_get_usage()/1000), 0, ',', '.').' Kb ( M�x.: '.number_format(intval(memory_get_peak_usage()/1000),0,',','.').' Kb) | Tempo: ';
    echo number_format((microtime()-$mark1),3,',','.').' Seg.</p>';
}
?>