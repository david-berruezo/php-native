<?php
class Mysql {
	
	private $con;
	
	function __construct(){
		$this->cfg =&	$GLOBALS['cfg'];
		if(!$this->con=$this->connect()){exit("Não foi possível conectar ao Banco de Dados");}
	}
	
	function connect(){				
		$r=mysql_pconnect(	$this->cfg->db->mysql->host,
								$this->cfg->db->mysql->user,
								$this->cfg->db->mysql->pass);
		mysql_set_charset($this->cfg->db->mysql->char);
		mysql_select_db($this->cfg->db->mysql->database);
		return $r;
	}
	
	function prepare($sql="",$nome="sql"){
		if(isset($this->{$nome})){echo "erro - prepare";return false;}
		$this->{$nome}=$sql;		
	}
	
	function bind($nome,$var,$val,$exec=false){
		if(!isset($this->{$nome})){echo "erro - bind";return false;}
		if(!is_array($var)){
			str_replace($var,$val,$this->{$nome});
		}else{
			$ci=0;
			foreach($var as $key=>$val){
				${"val$ci"}=$val;
				str_replace($key,${"val$ci"},$this->{$nome});
				$ci++;				
				}		
			}
    	if($exec==true){return $this->execute($nome);}
	}
	
	function execute($nome){
		unset($this->res);
		if(!isset($this->{$nome})){return false;}
		$r=mysql_query($this->{$nome});
		while($x=mysql_fetch_object($r)){$this->res[]=$x;}
		$this->num_rows=mysql_num_rows($r);
		if(!isset($this->res)){return array();}else{return $this->res;}
	}
		
	function query($sql=""){
		unset($this->res);
		if($r=mysql_query($sql)){		
			while($x=mysql_fetch_object($r)){$this->res[]=$x;}
			$this->num_rows=mysql_num_rows($r);
			mysql_free_result($r);
		}
		if(!isset($this->res)){return array();}else{return $this->res;}		
	}
}
?>