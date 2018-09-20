<?php	
/** 
 *	This class allow to insert in a database table data contained inside the global array $_POST and 
 *  save files described by $_FILES.
 *	It build an inserting/editing SQL query and perform file uploads.
 *
 *  <br /><br />ITALIAN:<br />
 *	La classe consente di inserire su una tabella di database i dati contenuti nell'array globale $_POST e 
 *  salvare i file descritti da $_FILES.
 *	Costruisce una query SQL di inserimento o modifica ed effettua l'upload dei file.
 *	
 *
 *	@author Michele Castellucci <ghiaccio84@gmail.com>  
 */

 
class HTMLPostProcessor
{
	var $lastExecutionResult;
 	var $fileNameCriteria="*tb*_*pk*_*cn*.*ext*";   //"*fn*.*ext*";

	function HTMLPostProcessor(){}

	function setFileSavePath($v)
	{
		$this->fileSavePath=$v;	
	} 

	function setResizeImageDimension($v)
	{
		$this->resizeImg=$v;	
	} 

	function keepOriginalImages($v)
	{
		$this->keepOriginal=$v;		
	} 
	 
	function setFileNameCriteria ($p) 
	{
		$this->fileNameCriteria=$p;
	}
	
	private function getFinalFileName($table,$primaryKey,$uploadName,$fieldName)
	{//*tb*_*pk*_*cn*.*ext*
	
		$ext=strtolower(substr($uploadName,(strlen($uploadName)-3),3)); //prende le ultime 4 lettere
		$fileName=substr($uploadName,0,-4);
		
		$return=$this->fileNameCriteria;
		$return=str_replace("*tb*",$table,$return);
		$return=str_replace("*pk*",$primaryKey,$return);
		$return=str_replace("*cn*",$fieldName,$return);
		$return=str_replace("*fn*",$fileName,$return);
		$return=str_replace("*ext*",$ext,$return);
		
		return $return;
		
		
		
	}
 

 	
 	function act($table,$submit_button,$primaryKey='id')
	{

		if (!isset($_POST[$submit_button]))  return 0; else unset($_POST[$submit_button]);
	/*	echo"<pre>";
		print_r($_POST);
		echo "</pre><br /><br />";*/
		
	
		if (!isset($_POST['edit_'.$table]) || $_POST['edit_'.$table]=='0') //oppure la chiave primaria è una stringa... 
		$edit=0; else $edit=1;
		//unset($_POST['edit_'.$table]);
		
		
		$query=$edit==1?"UPDATE $table SET ":"INSERT INTO $table {{{}}} VALUES {{{}}}";
		
		//print_r($_FILES);
	
		$fieldList=explode(",",$_POST['fieldList']);
		
		$POST=$_POST;
		//cerca la corrispondenza tra i post inviati e quelli non inviati ma presenti nel form
		foreach ($fieldList as $v)
			if (   !isset($POST[$v]) 
				&& !isset($POST[$v."_ifr"]) 
				&& !isset($POST[$v."_day"])
				&& !isset($POST[$v."_mon"])
				&& !isset($POST[$v."_yea"])						
				&& substr($v,0,1)!='@') $POST[$v]='';
		
		foreach($POST as $nome=>$valore)
		{	
			if ($valore=='ignore_this_post') continue;
			if ($nome==$primaryKey) continue;
			if ($nome=='fieldList') continue;
	
	
			//if ($valore==='') continue; ///IL VALORe stringa vuota non viene considerato e viene inserito il valore di default del campo! (????ma de che)
	
	
			if (substr($nome,strlen($nome)-4,4)=="_day") {$data_generica=$valore;continue;}
			if (substr($nome,strlen($nome)-4,4)=="_mon") {$data_generica=$valore."-".$data_generica;continue;}
			if (substr($nome,strlen($nome)-4,4)=="_yea") {$valore=$valore."-".$data_generica; $nome=substr($nome,0,strlen($nome)-4);}
				
			if (is_array($valore)) //set 
			$valore=implode(",",$valore);
				
			if ($nome=="verification_code" && $_SESSION['verification_string']!=$valore) return array("wrong_vercode",$nome);//codice di verifica errato
						
						
			if (substr($nome,0,7)=="verify_") //verifica via php della compilazione dei campi
			{
				$field_to_verify=substr($nome,7);//campo da verificare
				
				/*echo "<pre>".print_r($_POST,true)."</pre>";*/
				
				if (!isset($_POST[$field_to_verify]) && !isset($_FILES[$field_to_verify])) //si tratta della data che è divisa in 3 POST oppure di enum che non effettua il submit
				{
					if (isset($_POST[$field_to_verify."_day"]))//data
					$_POST_field_to_verify=$_POST[$field_to_verify."_day"]."/".$_POST[$field_to_verify."_mon"]."/".$_POST[$field_to_verify."_yea"];
					else 
					if (isset($_POST[$field_to_verify."_ifr"]))//iframe
					$_POST_field_to_verify=$_POST[$field_to_verify."_ifr"];
					else //ENUM e SET
					return array('format_conflict',$field_to_verify);
				}
				else
				if (isset($_POST[$field_to_verify])) 
				$_POST_field_to_verify=$_POST[$field_to_verify];
				else
				if (isset($_FILES[$field_to_verify])) 
				$_POST_field_to_verify=$_FILES[$field_to_verify]['name'];
				
				$valore=stripslashes($valore);
				
				if ($valore==1) $valore=REGEXP_NOTNULL; //
			
				//controllo valori
				if ($valore===REGEXP_NOTNULL)
				{
					if (trim(strip_tags($_POST_field_to_verify))!="")
					$ok=true;
					else $ok=false;
				}
				else
				if (preg_match($valore,strtolower($_POST_field_to_verify))==1)
				$ok=true;
				else
				$ok=false; 
				
				if ($ok==true) continue; else 
				//die ($field_to_verify."---".$_POST_field_to_verify);
				return array('format_conflict',$field_to_verify);
				
			}
			
			if (substr($nome,strlen($nome)-4,4)=="_ifr")
			{ 
				$nome=substr($nome,0,strlen($nome)-4);
				$valore=str_replace("\n"," ",$valore); //elimina carattere di ritorno a capo
				$valore=str_replace("\r","",$valore); //elimina carattere di ritorno a capo
				$valore=str_replace("<P>","",$valore);
				$valore=str_replace("</P>","",$valore);	
				$valore=str_replace("<BR>","<br />",$valore);
				$valore=str_replace("<br>","<br />",$valore);		
				$valore=str_replace("STRONG>","strong>",$valore);
				$valore=str_replace("EM>","em>",$valore);
				$valore=str_replace("UL>","ul>",$valore);
				$valore=str_replace("LI>","li>",$valore);
				$valore=str_replace("U>","u>",$valore);
				$valore=str_replace("A>","a>",$valore);
				$valore=str_replace("<A","<a",$valore);
				$valore=str_replace("onclick=window.open(this.href);return false","onclick=\"window.open(this.href);return false\"",$valore);
				$valore=autochiudi_tag("img",$valore);
				$valore=autochiudi_tag("br",$valore);
				$valore=autochiudi_tag("IMG",$valore);
				$valore=autochiudi_tag("BR",$valore);
				$valore=autochiudi_tag("hr",$valore);
				$valore=autochiudi_tag("HR",$valore);
			}
			else
			{			
				//$valore=str_replace('"',"'",$valore);
				//$valore=str_replace("\n","<br />",$valore);	
				
				//SOSTITUZIONE CARATTERI PARTICOLARI
				//(&) -in visualizzazione deve essere scritta &amp;
				//    -in modifica deve essere scritta &amp; (per scrivere letteralmente "&amp;" bisogna avere "&amp;mp;")
				//    -quindi viene memorizzato come &amp;
				$valore=str_replace("&","&amp;",$valore);
				//(>) -in visualizzazione deve essere scritta &gt;
				//    -in modifica (textbox) deve essere scritta &gt;
				//    -quindi viene memorizzato come &gt;
				//	lo stesso vale per (<)
				$valore=str_replace(">","&gt;",$valore);
				$valore=str_replace("<","&lt;",$valore);				
				//(") -in visualizzazione può essere scritto " o &quot; 
				//    -in modifica deve essere scritta &quot;
				//     ma sulle textarea però può anche essere scritta "
				//    -quindi viene memorizzato come " e rimpiazzato in &quot; solo in fase di modifica
				// si potrebbe memorizzare qui solo &quot; ma per maggiore flessibilità non si fa
				
				//tutte queste considerazioni non valgono per la textarea con IFRAME che gestisce tutto autonomamente 
				
				//QUESTE SOSTITUZIONI VENGO APPLICATE ANCHE IN FASE DI RICERCA NEL DBNAVIGATOR - funzione convertSpecialChars!!! 
				//PER TROVARE I CARATTERI EFFETTIVAMENTE MEMORIZZATI
			}
				
	
	
	//////////////////////////////////////////CHECK COLUMN EXISTENCE
			$founded=false;
			
			$result=mysql_query("DESCRIBE $table");  	
			while ($row=mysql_fetch_array($result))
			{
			
				if ($row['Field']==$nome || strpos($nome,'delete_')!==false) //..
				{
					$founded=true;
									
					if ($row['Key']=="UNI") //controllo chiavi uniche
					{
						if (is_array($_POST[$primaryKey])) return array('query_error',"Si è inviato un input di un campo univoco in un form di modifica di più record");
						
						//controllo se esiste un record con un campo con lo stesso valore
						$result2=mysql_query("SELECT * FROM {$table} WHERE {$primaryKey}!='".$_POST[$primaryKey]."' AND {$nome}=\"{$valore}\"") 
								 or die ('errore controllo univocità '.mysql_error());	
						if (mysql_num_rows($result2)>0) return array('key_conflict',$nome);	
					}
					
					break;			
				  }		
			 }	
			  
			if ($founded==false) continue; //se non c'è un campo della tabella con nome=al post allora ignora il post MANCA SU _FILES
	///////////////////////////////////////////////////////////////
	
			if ($edit==1) //query di aggiornamento
			{	
			
				if (strpos($nome,'delete_')!==false) //ELIMINA FILE CORRENTE
				{
					if (is_array($_POST[$primaryKey])) return array('query_error',"Si è inviato un input di eliminazione file in un form di modifica di più record");
					
					$nome=substr($nome,7,strlen($nome));
					$valore="";
					//echo "-->".$nome."<--";
					$row=mysql_fetch_array(mysql_query("SELECT $nome FROM $table WHERE $primaryKey='{$_POST[$primaryKey]}'"));
					if ($row[$nome]!="" && file_exists($this->fileSavePath."/".$row[$nome]))
					{
						
						unlink($this->fileSavePath."/".$row[$nome]); //elimina il file
						if (file_exists($this->fileSavePath."/small_".$row[$nome])) unlink($this->fileSavePath."/small_".$row[$nome]); //se è un'immagine elimina anche quella piccola
					}			
				}
	
				if ($nome==$primaryKey) continue;
				$query.="`$nome`='$valore', ";
				
						
			}
			else //query di inserimento
			{
				//die('ciao');
				if ($nome==$primaryKey && (int)($_POST[$primaryKey])) $valore=""; //se la chiave primaria è intera mettila a '' per fare l'autoincrement
				
				$exp=explode("}}}",$query);
				$exp[0].="`".$nome."`,";
				$exp[1].="'".$valore."',";
				$query=implode("}}}",$exp);
				
			}
		}
		
		if (!is_array($_POST[$primaryKey])) //non si assegnano più file ad un record
		foreach ($_FILES as $nome=>$file)
		{
			//print_r($_FILES);
			//die('');
			if ($file['error']==1) return array('file_too_big',$nome);	
	
			if (!$file['size']>0) continue;	
			$file['name']=str_replace(array('"',"'"," ","&"),"_",stripslashes($file['name'])); //sostituisce i caratteri non ammessi con _
	
	
	
			if (!file_exists($this->fileSavePath)) mkdir($this->fileSavePath,0777); //CREA LA DIRECTORY PER SALVARE I FILE

			
			
			$result=mysql_query("SELECT $nome FROM $table WHERE $primaryKey!='{$_POST[$primaryKey]}'");	
			while ($row=mysql_fetch_array($result))
			{
				//controllo se esiste un record con un file collegato con lo stesso nome
				if ($row[$nome]==$file['name']) return array('file_conflict',$nome);
			}
					
			if ($edit==1) //query di aggiornamento
			{
				if ($nome==$primaryKey) continue;
				$row=mysql_fetch_array(mysql_query("SELECT $nome FROM $table WHERE $primaryKey='{$_POST[$primaryKey]}'"));
				if ($row[$nome]!="" && file_exists($this->fileSavePath."/".$row[$nome]))
				{
					unlink($this->fileSavePath."/".$row[$nome]); //elimina il file precedente
					if (file_exists($this->fileSavePath."/small_".$row[$nome])) unlink($this->fileSavePath."/small_".$row[$nome]); //se è un'immagine elimina anche quella piccola
				}
				
				$query.="$nome='".$this->getFinalFileName($table,$_POST[$primaryKey],$file['name'],$nome)."', ";//----<<<<	
			}
			else //query di inserimento
			{
/*				if ($nome==$primaryKey && (int)($_POST[$primaryKey])) $valore=""; //se la chiave primaria è intera mettila a '' per fare l'autoincrement
				$exp=explode("}}}",$query);
				$exp[0].="`".$nome."`,";
				$exp[1].="'".$this->getFinalFileName($table,$_POST[$primaryKey],$file['name'],$nome)."',";  //----<<<< $_POST[$primaryKey] non c'è su insert
				$query=implode("}}}",$exp);*/
			}
				
		}	
	
		
		// ELIMINA LE VIRGOLE FINALI
		if ($edit==1)
		{
			if ($query=="UPDATE $table SET ") //nessuna modifica ai campi
			return 1;
			else
			{
				if (is_array($_POST[$primaryKey]))
				{
					foreach($_POST[$primaryKey] as $id)
					$cond[]="{$primaryKey}=\"{$id}\"";
					
					$cond=implode (" OR ",$cond);
				}
				else
				$cond="`$primaryKey`='{$_POST[$primaryKey]}'";
			
				$query=substr($query,0,strlen($query)-2);
				$query.=" WHERE ".$cond;
			}
		}
		else
		{
			$exp=explode("}}}",$query);
			$exp[0]=substr($exp[0],0,count($exp[0])-2);
			$exp[1]=substr($exp[1],0,count($exp[1])-2);
			$query=implode(")",$exp);
			$query=str_replace("{{{","(",$query);
		}
		//////
	
	/*	print_r($_POST);
	
		die($query);*/
	
		if (!mysql_query($query)) //le 2 condizioni finali servono x query "vuote" (senza campi) 
		{
		
			//echo "ERRORE QUERY: ".$query;		
			return array('query_error',mysql_error()."($query)");
		}
		
		if ($edit==1)
			$rowID=$_POST[$primaryKey];
		else
			$rowID=mysql_insert_id();
			
		$updatefieldlist=array();
		foreach ($_FILES as $nome=>$file)//COPIA FISICA DEI FILE per evitare upload inutili
		{
			if (!$file['size']>0) continue;	
			$file['name']=str_replace(array('"',"'"," ","&"),"_",stripslashes($file['name'])); //sostituisce i caratteri non ammessi con _
				
			$ext=strtolower(substr($file['name'],(strlen($file['name'])-4),4)); //prende le ultime 4 lettere
			
			if ( intval($this->resizeImg)!=0 && ($ext==".gif" || $ext==".jpg" || $ext==".png") )
			{
				resize_img($file['tmp_name'],$this->resizeImg,$this->resizeImg
						   ,$this->fileSavePath."/small_".$this->getFinalFileName($table,$rowID,$file['name'],$nome)); //----<<<<
			}
			
			if ( $this->keepOriginal || intval($this->resizeImg)==0) 
				copy($file['tmp_name'],$this->fileSavePath."/".$this->getFinalFileName($table,$rowID,$file['name'],$nome));  //----<<<<	
				
			$updatefieldlist[]="{$nome}=\"".$this->getFinalFileName($table,$rowID,$file['name'],$nome)."\"";
		}	
		
		if ($edit==0 && count($updatefieldlist)>0) //inserimento => aggiorno i valori dei campi di tipo immagine con l'id corretto
			mysql_query("UPDATE {$table} SET ".implode(", ",$updatefieldlist)." WHERE {$primaryKey}='{$rowID}'") or die("errore nell'aggionamento campi immagine");
		
		
		return 1;	
	}


}

/**
 * Questa funzione ridimensiona l'immagine con percorso $pathimage con formato $ext (estenzione) alle dimensioni $new_sizex, $new_sizey e salva l'immagine 
 * redimensionata sul percorso $dest_file. 
 */

function resize_img($pathimage, $new_sizex, $new_sizey, $dest_file) 
{
  $imagename = $pathimage;
  if(file_exists($pathimage)) 
  {
	$ext=strtolower(substr($dest_file,(strlen($dest_file)-4),4)); //prende le ultime 4 lettere

	switch ($ext)
	{
		case '.jpg':$pic = imagecreatefromjpeg($pathimage); break;
		case '.gif':$pic = imagecreatefromgif($pathimage); break;
		case '.png':$pic = imagecreatefrompng($pathimage); break;							
	}
	
	$sizex = imagesx($pic) ;
	$sizey = imagesy($pic) ;
	if (($sizex > $new_sizex) || ($sizey > $new_sizey) ) 
	{
		
			if($sizex>$sizey) 
			{ 
				$s0x = $new_sizex ;
				$s0y = (($new_sizex * $sizey)/$sizex) ;
				settype ($s0y, "integer")  ;
			} 
			 else
			if ($sizex<$sizey) 
			{
				$s0y = $new_sizey ;
				$s0x = (($new_sizey * $sizex)/$sizey) ;
				settype ($s0x, "integer")  ;
			} else 
			{
					$s0x = $new_sizex ;
					$s0y = $new_sizey ;
			}
		 
		 $gd_info=gd_info();
		 
		if(strstr($gd_info['GD Version'],"2.")) ///mmmmmmhhh....... 
		{
			$out = imagecreatetruecolor( $s0x, $s0y) ;
			imagecopyresampled ($out, $pic, 0, 0, 0, 0, $s0x, $s0y, $sizex, $sizey) ;
		}else 
		{
			$out = imagecreate( $s0x, $s0y) ;
			imagecopyresized($out, $pic, 0, 0, 0, 0, $s0x, $s0y, $sizex, $sizey) ;
		}
		
		switch ($ext)
		{
			case '.jpg':$pic = imagejpeg($out, $dest_file,100); break;
			case '.gif':$pic = imagegif($out, $dest_file) ; break;
			case '.png':$pic = imagepng($out, $dest_file) ; break;							
		}
		
		//imagedestroy($pic);
		imagedestroy($out); 
		return 1 ;
	} else //
	{
		copy($pathimage, $dest_file) ;
		return 1;
	}
  } else //!file_exists
  {
	return 0 ;
  }
}

?>