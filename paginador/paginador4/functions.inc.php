<?php

function data_odierna()
{

		return giorno_italiano(date("D")).", ".date("j")." ".mese_italiano(date("F"))." ".date("Y");

}


function data_europea($data)
{
	$exp=explode("-",$data);
	return $exp[2]."/".$exp[1]."/".$exp[0];

}

function data_ora_europea($data)
{
	$exp=explode(" ",$data);
	$exp2=explode("-",$exp[0]);
	return $exp2[2]."/".$exp2[1]."/".$exp2[0]." ".$exp[1];

}


function mese_italiano($month)
{
	switch ($month)
	{
		case "January": return "Gennaio";
		case "February": return "Febbraio";
		case "March": return "Marzo";
		case "April": return "Aprile";
		case "May": return "Maggio";
		case "June": return "Giugno";
		case "July": return "Luglio";
		case "August": return "Agosto";
		case "September": return "Settembre";
		case "October": return "Ottobre";
		case "November": return "Novembre";
		case "December": return "Dicembre";
	}
}

function giorno_italiano($day)
{
	switch ($day)
	{
		case "Mon": return "Luned&igrave;";
		case "Tue": return "Marted&igrave;";
		case "Wed": return "Mercoled&igrave;";
		case "Thu": return "Gioved&igrave;";
		case "Fri": return "Venerd&igrave;";
		case "Sat": return "Sabato";
		case "Sun": return "Domenica";
	}
}

/** Elimina tutti i tag ( XHTML oppure XML ) $tag dalla stringa $stringa in modo ricorsivo.
  *	Ritorna una stringa che e' la stringa originale modificata senza tag $tag.
  * @param string $tag nome del tag da rimuovere in tutte le istanze di $stringa
  * @param string $stringa nome della stringa da cui eliminare tutti i tag $tag
  *	@return string  
  */
function elimina_tag($tag,$stringa)
{
	
	$pos=strpos($stringa,"<$tag"); //posizione carattere di apertura del tag (<)  
	if ($pos===false) return $stringa;
	$temp=substr($stringa,$pos); //stringa dal carattere di apertura del tag in poi
	$pos2=strpos($temp,">"); //posizione carattere di fine tag (>) ,sulla stringa dal < in poi
	$pos2=$pos2+$pos+1; //posizione carattere di fine tag, su tutta la stringa
	//echo "....posizione apertura=$pos, posizione chiusura={$pos2}";
	$stringa_prima=substr($stringa,0,$pos);
	$stringa_dopo=substr($stringa,$pos2);

	$stringa2=str_replace("</$tag>","",$stringa_prima.$stringa_dopo);	//ELIMINA TUTTE LE CHIUSURE DEI TAG
	
	return elimina_tag($tag,$stringa2);	
}


/** Elimina tutti i tag ( XHTML oppure XML ) $tag dalla stringa $stringa in modo ricorsivo.
  *	Ritorna una stringa che e' la stringa originale modificata senza tag $tag.
  * @param string $tag nome del tag da rimuovere in tutte le istanze di $stringa
  * @param string $stringa nome della stringa da cui eliminare tutti i tag $tag
  *	@return string  
  */
function elimina_ogni_tag($stringa)
{
	
	while (true)	
	{
		$pos=strpos($stringa,"<"); //posizione carattere di apertura del tag (<)  
		if ($pos===false) break;
		
		$temp=substr($stringa,$pos); //stringa dal carattere di apertura del tag in poi
		$pos2=strpos($temp,">"); //posizione carattere di fine tag (>) ,sulla stringa dal < in poi
		if ($pos2===false) break;
		
		$pos2=$pos2+$pos+1; //posizione carattere di fine tag, su tutta la stringa
		
	
		$stringa_prima=substr($stringa,0,$pos);
		$stringa_dopo=substr($stringa,$pos2);
	
		//echo "....posizione apertura=$pos, posizione chiusura={$pos2}<br />";	
		$stringa=$stringa_prima.$stringa_dopo;	
	}
	
	return $stringa;	
}

function autochiudi_tag($tag,$stringa,$offset=0)
{
	if ($offset<strlen($stringa))
	{
		$pos=strpos($stringa,"<$tag",$offset); //posizione carattere di apertura del tag (<)  
		if ($pos===false) return $stringa;
		$temp=substr($stringa,$pos); //stringa dal carattere di apertura del tag in poi
		$pos2=strpos($temp,">"); //posizione carattere di fine tag (>) ,sulla stringa dal < in poi
		
		if ($temp{($pos2-1)}!="/")
		{ 
	
			$stringa_prima=substr($stringa,0,$pos);
			$stringa_centrale=substr($temp,0,$pos2)." />"; //si sovrascrive ">" con l'auto-chiusura "/ >"
			$stringa_dopo=substr($stringa,$pos+$pos2+1);
			return autochiudi_tag($tag,$stringa_prima.$stringa_centrale.$stringa_dopo,++$pos);	
	
		}
		else	return autochiudi_tag($tag,$stringa,++$pos);	
	}else	return $stringa;
	
}



/** Costruisce una query string con tutti i valori di $_GET.
  * accetta un numero ARBITRARIO di paramentri stringa, che sono interpretati
  * come i GET (valori delle chiavi dell'array $_GET) da ESCLUDERE nella costruzione
  * della query string  
  * @param string $arg_1 
  * @param string $arg_2 
  * @param string $arg_3 
  *	@return string 
  */
function buildQueryString()
{
	$except=func_get_args();
		$query_string="";
		foreach($_GET as $name=>$value)
		{
			$continue=false;
			foreach ($except as $val) if ($val==$name){$continue=true;break;}
			if ($continue) continue;
			
			if (is_array($value))
			{
				foreach($value as $key=>$val)
				$query_string.="&amp;".$name."[".urlencode(stripslashes($key))."]=".urlencode(stripslashes($val));			
			}
			else
			$query_string.="&amp;".$name."=".urlencode(stripslashes($value));
		}
		return $query_string;
}

function getImageXY($imagePath)
{
	$exp=explode("/",$imagePath);
			
	$ext=strtolower(substr($exp[count($exp)-1],(strlen($exp[count($exp)-1])-4),4)); //prende le ultime 4 lettere

	switch ($ext)
	{
		case '.jpg':$pic = imagecreatefromjpeg($imagePath); break;
		case '.gif':$pic = imagecreatefromgif($imagePath); break;
		case '.png':$pic = imagecreatefrompng($imagePath); break;							
	}
			
	return array('x'=>imagesx($pic),'y'=>imagesy($pic));
}

function getXScaled($imagePath,$y)
{
	$size=getImageXY($imagePath);
	return $size['x']*$y/$size['y']; //$size['x']:$size['y']=X:$y
}

function getYScaled($imagePath,$x)
{
	$size=getImageXY($imagePath);
	return $size['y']*$x/$size['x']; //$size['x']:$size['y']=$x:X
}


function getImageResizedValues($imagePath,$new_sizex,$new_sizey,$returnArray=false,$stretch=false)
{
			$size=getImageXY($imagePath);
			
			if (($size['x'] > $new_sizex) || ($size['y'] > $new_sizey) || $stretch) 
			{
				
					if($size['x']>$size['y']) 
					{ 
						$s0x = $new_sizex ;
						$s0y = (($new_sizex * $size['y'])/$size['x']); //$size['x']:$new_sizex=$size['y']:X
						settype ($s0y, "integer")  ;
					} 
					 else
					if ($size['x']<$size['y']) 
					{
						$s0y = $new_sizey ;
						$s0x = (($new_sizey * $size['x'])/$size['y']) ;//$size['y']:$new_sizey=$size['x']:X
						settype ($s0x, "integer")  ;
					} else 
					{
							$s0x = $new_sizex ;
							$s0y = $new_sizey ;
					}
					
					if ($returnArray==true)
					return array('width'=>$s0x,'height'=>$s0y);
					else				
					return "width:{$s0x}px;height:{$s0y}px";
			}
			else 
			return false;
	
	
}

function curtain_menu($type,$menu_array,$class1,$class2,$width=100,$height=25,$start=0,$depth=1)
{
	$type=strtoupper($type);

	$elem=1;
	foreach($menu_array as $id=>$content)
	{
		if ($content['father']!=$start) continue; //analizza solo i figli diretti di $start 
	

		foreach($menu_array as $content2) //rilevazione di sottomenu
		{
			if ($content2['father']==$id) //se  un figlio (diretto)
			{
				if ($depth==1 && $type=='H') $simbols="&nu;"; else $simbols="&raquo;&raquo;";
				
				$sub_menu_alerter="<div style=\"float:right;font-weight:bolder;width:auto;padding-right:3px;\">{$simbols}</div>";
				break;
			}
			$sub_menu_alerter="";
		}

		if ($depth==1) //al primo livello mett div relativi 
		{
			if ($type=="H")
			$style="style=\"z-index:10;height:{$height}px;width:{$width}px;float:left;position:relative;margin-right :5px\"";
			else
			$style="style=\"z-index:10;height:{$height}px;width:{$width}px;           position:relative;margin-bottom:5px\"";
			
			$class="class=\"{$class1}\"";
		}
		else 
		if ($depth==2) //al secondo livello mette div assoluti..... 
		{
			if ($type=="H") //......spostati sempre + bassi
			$style="style=\"z-index:11;height:{$height}px;width:{$width}px;position:absolute;left:0px;top: ".((($elem))*$height)."px;\"";
			else           //........spostati a destra e poi sempre + bassi
			$style="style=\"z-index:11;height:{$height}px;width:{$width}px;position:absolute;left :".($width+2)."px;top:".((($elem-1))*$height)."px;\"";
			
			
			$class="class=\"{$class2}\"";
		}
		else //ai livelli superiori mette div assoluti spostati in basso e a destra
		{
			$style="style=\"z-index:12;height:{$height}px;width:{$width}px;position:absolute;left:".($width+2)."px;top:".((($elem-1)*$height))."px;\"";
			$class="class=\"{$class2}\"";
		}

		$padding_top=$height/2-7;
		
		$chars=strlen($content['text']);

		define("ASSUMED_FONT_WIDTH_SIZE",9);
	
		$show=$chars>(($width/ASSUMED_FONT_WIDTH_SIZE))?"<span title=\"{$content['text']}\">".substr($content['text'],0,floor($width/ASSUMED_FONT_WIDTH_SIZE))."...</span>":$content['text']; //taglia i caratteri

	if (isset($content['url']))
	{
		$cursor="cursor:pointer;";
		$onclick="onclick=\"location.href='{$content['url']}'\"";
		$a_tag="<a style=\"display:block;\" href=\"#\" onclick=\"return false;\">";
		$a_tag_end="</a>";
		
	}else
	{
		$cursor="cursor:default;";
		$onclick="";
		$a_tag="";
		$a_tag_end="";

	}

			$value.="
			<div onmouseover=\"document.getElementById('curtain_menu_{$id}').style.display='block'\" 
				onmouseout=\"document.getElementById('curtain_menu_{$id}').style.display='none'\"
				$style >
				
				<div {$class} style=\"float:left;padding-top:{$padding_top}px;width:100%;height:".($height-$padding_top)."px;{$cursor}\" $onclick  >
					<div style=\"float:left;width:80%;padding-left:3px\">{$a_tag}$show{$a_tag_end}</div> {$sub_menu_alerter}
				</div>
				
				<div style=\"display:none;\" id=\"curtain_menu_{$id}\">";
					$value.="
					".curtain_menu($type,$menu_array,$class1,$class2,$width,$height,$id,($depth+1))."			
				</div>
				
			</div>";		
		
		
		$elem++;
	}

	return $value;
}	


class standardPostDataEmail ///usata come "after_query_function" per l'invio di email con i dati  POST, come classe per una maggiore flessibilità 
{
	var $at;	
	var $from;
	var $subject;
	var $bodyHeading;	
	var $ignored;
	
	function standardPostDataEmail($at,$from,$subject,$bodyHeading)
	{
		$this->at=$at;	
		$this->from=$from;
		$this->subject=$subject;
		$this->bodyHeading=$bodyHeading;				
	}
	
	function setIgnoredFields() //si suppone di chiamare una sola volta questa funzione
	{
		$this->ignored=func_get_args();
	}
	
	
	function doIt()
	{	
		$TEXT='<table border="1" cellpadding="5">';
		$data='';
		
		foreach($_POST as $k=>$v)
		{		
			if (substr($k,0,5)=='edit_' || substr($k,-16,16)=='privacy_checkbox' || $k=='fieldList' || $k=='id' || $k=='id_admin' 
				|| in_array($k,$this->ignored)  ) continue;
	
			if ($k=='data_inserimento') $v=data_ora_europea($v);
	
			if ($k=='provincia' && $v!='') //el. esterni
			{
				$row=mysql_fetch_array(mysql_query("SELECT * FROM Province WHERE id={$v}"));
				$v=$row['nome'];
			}
	
			if (substr($k,-3,3)=='day' || substr($k,-3,3)=='mon') { $data.=$data==''?$v:"/".$v; continue; } //data
			if (substr($k,-3,3)=='yea') 						  { $v=$data."/".$v; $data=''; $k=substr($k,0,-4); }			
			
			$TEXT.='<tr>';		
			$TEXT.="<td><strong>".str_replace("_"," ",ucfirst($k))."</strong></td>				 
					 <td>";
						
			if (is_array($v))
			{			
				foreach ($v as $mul)
					$TEXT.=str_replace("\r\n","<br />",stripslashes($mul))."<br />";									
			}
			else
				$TEXT.=str_replace("\r\n","<br />",stripslashes($v));		
	
			$TEXT.="</td>";
			$TEXT.='</tr>';
		}
	
	
		$param=array();
		$param[]= $this->at;
		$param[]= $this->subject;
		$param[]= $this->bodyHeading."<br /><hr /><br />".$TEXT."</table>";								 
		$param[]="From: ".$this->from.EOL
				."Reply-To: ".$this->from.EOL
				."Content-Type: text/html; charset=utf-8";
		
		if (ini_get("safe_mode")!=1) 
			$param[]="-f" . $this->from;//indirizzo RETURN-PATH
																
		call_user_func_array('mail',$param);

	}
			
}


?>