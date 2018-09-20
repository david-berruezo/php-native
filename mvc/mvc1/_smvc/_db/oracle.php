<?php
class Oracle {
	
	private $con;
	
	function __construct(){
		$this->cfg =&	$GLOBALS['cfg'];
		if(!$this->con=$this->connect()){exit("Não foi possível conectar ao Banco de Dados");}	
	}
	
	function connect(){				
				return oci_pconnect($this->cfg->db->oci->user,
									$this->cfg->db->oci->pass,
									$this->cfg->db->oci->host,
									$this->cfg->db->oci->char);
	}
	
	function prepare($sql="",$nome="sql"){
		if(isset($this->{$nome})){echo "erro - prepare";return false;}
		$this->{$nome}=oci_parse($this->con,$sql);		
	}
	
	function bind($nome,$var,$val,$exec=false){
		if(!isset($this->{$nome})){echo "erro - bind";return false;}
		if(!is_array($var)){
			oci_bind_by_name($this->{$nome}, $var, $val);			
		}else{
			$ci=0;
			foreach($var as $key=>$val){
				${"val$ci"}=$val;
				oci_bind_by_name($this->{$nome}, $key, ${"val$ci"}); 
				$ci++;				
				}		
			}
    	if($exec==true){return $this->execute($nome);}
		}
	
	function execute($nome){
		unset($this->res);
		if(!isset($this->{$nome})){return false;}
		oci_execute($this->{$nome});
		while($x=oci_fetch_object($this->{$nome})){$this->res[]=$x;}
		$this->num_rows=oci_num_rows($this->{$nome});
		if(!isset($this->res)){return array();}else{return $this->res;}
		}
		
	function query($sql=""){
		unset($this->res);
		$y=oci_parse($this->con,$sql);
		oci_execute($y);
		
		while($x=oci_fetch_object($y)){
			$this->res[]=$x;		
			}
			$this->num_rows=oci_num_rows($y);
		if(!isset($this->res)){return array();}else{return $this->res;}		
	}
	
	function get_file($nome, $row_name, $force=false, $filename="arquivo", $ext="zip"){
		$a="";			
		if($nome){
		foreach($nome as $row){$a.= $row->{$row_name}->load();}
		}
		if($force==false){return $a;}
		else{
			$mimes = array(		'pdf'	=>	'application/pdf',
						   		'zip'	=>  'application/x-zip',
								'xls'	=>	'application/excel',
								'doc'	=>	'application/msword',
								'docx'	=>	'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
								'xlsx'	=>	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	
					if ( ! isset($mimes[$ext])){$mime = 'application/octet-stream';}
					else{$mime = $mimes[$ext];}
					
				if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){
					header('Content-Type: "'.$mime.'"');
					header('Content-Disposition: attachment; filename="'.$filename.'.'.$ext.'"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header("Content-Transfer-Encoding: binary");
					header('Pragma: public');
					header("Content-Length: ".strlen($a));}
				else{
					header('Content-Type: "'.$mime.'"');
					header('Content-Disposition: attachment; filename="'.$filename.'.'.$ext.'"');
					header("Content-Transfer-Encoding: binary");
					header('Expires: 0');
					header('Pragma: no-cache');
					header("Content-Length: ".strlen($a));}
				
				exit($a);
			}
		}


}
?>