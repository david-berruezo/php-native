<?php

 /** @author Michele Castellucci <ghiaccio84@gmail.com> */
 
 /** This class allow to create an HTML formatter (using an IFRAME within desing mode).<br />
   * One feature of this formatter is that it don't need external images for buttons.
   * <br /><br />
   * ITALIAN:<br /> Questa classe permette di creare un formattatore HTML (utilizzando un IFRAME in modalità design).<br />
   * Una caratteristica di questo formattatore è che non usa immagini aggiuntive per i pulsanti del formattatore
   */
 
class Adv_TextArea extends TextEditorContainer
{ 

	/** An associative array containing ALL the options about the formatter */
	var $params; 
	
	/**
	  *  Fill the associative <b>param</b> array with the default values 
	  *	 <br /><br />
	  *	 ITALIAN:<br /> Inserisce nell'array associativo <b>param</b> i valori di default
	  */
	function Adv_TextArea() 
	{ 
		$this->params=array("bold"=>true,"italic"=>true,"underline"=>true,"ulist"=>true,"jleft"=>true
							,"jcenter"=>true,"jright"=>true,"link"=>true,"unformat"=>true
							,"selectFont"=>false,"fontSize"=>false
							,"filesPath"=>'',"bodyStyleOrCSS"=>false,"style"=>'width:100%;'
							);	
		
	}
	
	/** Insert or update the associative param array of the class with values founded in $paramArray
	  * <br /><br />
	  * ITALIAN:<br /> Inserisce o aggiorna l'array associativo <b>param</b> con i valori trovati in $paramArray
	  *
	  * @param array associative array with some accepted (optional) elements named by the following array keys: <br />
	  *              <ul>
	  *					<li><b>bold</b> - indicate if bold button must be present or not<br /></li>
	  *					<li><b>italic</b> - indicate if italic button must be present or not<br /></li>
	  *					<li><b>underline</b> - indicate if underline button must be present or not<br /></li>
	  *					<li><b>ulist</b> - indicate if unordered-list button must be present or not<br /></li>
	  *					<li><b>jleft</b> - indicate if justify-left button must be present or not<br /></li>
	  *					<li><b>jcenter</b> - indicate if justify-center button must be present or not<br /></li>
	  *					<li><b>jright</b> - indicate if justify-right button must be present or not<br /></li>
	  *					<li><b>unformat</b> - indicate if unformat button must be present or note<br /></li>
	  *					<li><b>selectFont</b> - indicate if select-font button must be present or not<br />
	  *                                         Moreover this element can contain an array that has allowable Font names as values</li>
	  *					<li><b>fontSize</b> - indicate if font-size button must be present or not<br /></li>
	  *					<li><b>filesPath</b> - indicate the relative path where are images and files to be embedded in the HTML text<br />
	  *										  Moreover this element can contain a 2-element array with 'start' and 'end' keys 
	  *										  containing the numeric values that delimit an interval of the possible selectables font-sizes
	  *										  <br /></li>
	  *					<li><b>bodyStyleOrCSS</b> - As a matter of fact, the editable area of the formatter is a real HTML document.<br />
	  *                     With this param, you can specify the content of the style attribute in his body tag <br />
	  *						or indicate the path of a CSS file so the HTML document will apply those CSS rules on the text 
	  *                     <br /></li>
	  *					<li><b>style</b> - content of the style attribute of the IFRAME that contains the formatter<br /></li>
	  *              </ul>
	  *
	  *				<br /><br /> ITALIAN:<br /> 	
	  * 			Array associativo con alcuni elementi accettati (opzionali) nominati dalle seguenti chiavi: <br />
	  *              <ul>
	  *					<li><b>bold</b> - indica se deve essere presente il tasto grassetto<br /></li>
	  *					<li><b>italic</b> - indica se deve essere presente il tasto corsivo<br /></li>
	  *					<li><b>underline</b> - indica se deve essere presente il tasto sottolinea<br /></li>
	  *					<li><b>ulist</b> - indica se deve essere presente il tasto elenco puntato<br /></li>
	  *					<li><b>jleft</b> - indica se deve essere presente il tasto allinea a sinistra<br /></li>
	  *					<li><b>jcenter</b> - indica se deve essere presente il tasto allinea al centro<br /></li>
	  *					<li><b>jright</b> - indica se deve essere presente il tasto allinea a destra<br /></li>
	  *					<li><b>unformat</b> - indica se deve essere presente il tasto elimina formatttazione<br /></li>
	  *					<li><b>selectFont</b> - indica se deve essere presente il tasto seleziona font<br />
	  *                                         Inoltre questo elemento può contenere un array che abbbia come valori i nomi
	  *                                         dei font disponibili per la selezione</li>
	  *					<li><b>fontSize</b> - indica se deve essere presente il tasto seleziona dimensione font.<br />
	  *										  Inoltre questo elemento può contenere un array di due elementi con chiavi 'start' ed 'end' 
	  *										  contenenti i valori numerici che delimitano un intervallo delle possibili dimensioni di font
	  *										  selezionabili<br /></li>
	  *					<li><b>filesPath</b> - indica il path relativo in cui risiedono immagini e file da inserire nel testo HTML<br /></li>
	  *					<li><b>bodyStyleOrCSS</b> - Essendo l'area editabile del formattatore un vero documento HTML.<br />
	  *                     Con questo parametro si può specificare il contenuto dell'attributo style sul suo tag body<br />
	  *						oppure indicare il path di un file CSS in modo tale che il documento HTML applichi quelle regole CSS 
	  *						sul testo in modifica<br /></li>
	  *					<li><b>style</b> - il contenuto dell'attributo style dell'IFRAME che contiene il formattatore <br /></li>
	  *              </ul>	
	  */	
	function setParams($paramArray=false) //da sistemare per bene...
	{
		//per compatibilità (vecchi moduli webedit) si consente il passaggio dei 2 vecchi valori....absolute non serve più!
		if (isset($paramArray['relative']) )  
			$paramArray['filesPath']=$paramArray['relative'];
		if (isset($paramArray['imagesPath']['relative']) )  
			$paramArray['filesPath']=$paramArray['relative'];

		if (is_array($paramArray))
			foreach ($paramArray as $k=>$v)
				$this->params[$k]=$v;

	}
	
	/** Print an instance of the formatter.<br />
	  * Notice that there is an hidden input with id attribute equal to '{$id}_ifr' which is necessary 
	  * by {@link HTMLPostProcessor} class to find out that the incoming data come from the HTML formatter (and doing special actions).
	  * <br /><br />
	  *
	  * ITALIAN:<br /> Stampa una istanza del formattare.<br /> 
	  * Si noti che è presente un hidden input con attributo id uguale ad '{$id}_ifr' che è necessario 
	  * per far riconoscere alla classe {@link HTMLPostProcessor} che si tratta un dato proveniente dal formattatore HTML.
	  *
	  * @param string id of the formatter inside the Html DOM 
	  *				  <br />ITALIAN: il nome identificativo del formattatore all'interno del DOM Html
	  * @param string HTML text that is going to be placed inside the editable area of the formatter 
	  *				  <br />ITALIAN: testo HTML che deve essere contenuto nell'area editabile del formattatore
	  * @param string name of the CSS class for the formatter IFRAME 
	  *				  <br />ITALIAN: nome della classe CSS da applicare all IFRAME del formattatore
	  * @return string A string containing the HTML code which represent the formatter 
	  *				   <br />ITALIAN: 
	  *                 una stringa contenente il codice HTML che definisce un formattatore
	  */	
	function getHTMLInstance($id,$value,$class)
	{
		parent::getHTMLInstance($id,$value,$class); //richiama il codice della superclasse che stampa il codice di inizializzazione (solo una volta)
		
		
		if (!$this->params['bodyStyleOrCSS']) $this->params['bodyStyleOrCSS']="font-size:14px;font-family:Arial,Helvetica,sans serif;";
	
		$value=str_replace("\n","",$value); //$value=str_replace("\n","<br />",$value);
		$value=str_replace("\r","",$value);

		//$value=str_replace(array("\n","\r"),"<br />",$value);
		
		$button_style="style=\"color:#111111;border:1px solid #666666;margin:0px 4px 4px 0px;vertical-align:middle\"";

		if ($this->params['filesPath']!='')
		{		
			$handle=opendir($this->params['filesPath']);
			$imgDiv="";	
			$fileDiv="";
			$count=0;
			
			while (false !== ($file = readdir($handle))) 
			{
				if (is_dir($file)) continue;
				
				
				if (preg_match("/\.((gif)|(png)|(jpg)|(jpeg))$/i",$file)!=0 )
				{
					if ($count % 3 == 0 ) $clear="both"; else $clear="none";
					//notare che nel src metto il path relative e quando aggiungo tale valore (un src di img) alla textarea, viene aggiunto autom. il path assoluto
					$imgDiv.="<div style=\"margin:5px;width:100px;height:100px;float:left;text-align:center\">";
												
						$imgDiv.="<img src=\"{$this->params['filesPath']}/{$file}\" style=\"clear:{$clear};cursor:pointer;"
								.getImageResizedValues("{$this->params['filesPath']}/{$file}",100,100).";\"
								onclick=\"document.getElementById('preview_images_{$id}').style.display='none';command('{$id}','InsertImage',
								{imgSrc:this.src,float:this.parentNode.parentNode.parentNode.getElementsByTagName('select')[0].value
											   ,border:this.parentNode.parentNode.parentNode.getElementsByTagName('select')[1].value})\" 
								alt=\"{$file}\" title=\"{$file}\" />
							 </div>";
					++$count;
				}
				else //FILE NON DI IMMAGINE
				{					
					$fileDiv.="<div style=\"margin:6px\">
								    <a href=\"{$this->params['filesPath']}/{$file}\" 
									   onclick=\"document.getElementById('preview_files_{$id}').style.display='none';command('{$id}','FileLink',{url:this.href,newWindow:this.parentNode.parentNode.parentNode.getElementsByTagName('select')[0].value});return false;\">
								   	   {$file}
								    </a>																		
							   </div>";				
				}				
			}
			
			if ($imgDiv=="") $dis="alt=\"No image available\" title=\"No image available\" disabled=\"disabled\""; else $dis="$button_style";
			
			$insert_images="
					<div style=\"float:left\">
					
						<button type=\"button\" $dis onclick=\"document.getElementById('preview_images_{$id}').style.display=document.getElementById('preview_images_{$id}').style.display=='block'?'none':'block';\" _onclick=\"this.blur();command('{$id}','InsertImage',document.getElementById('choose_image_{$id}').value);\" >
							Insert Image
						</button>
						
						<div id=\"preview_images_{$id}\" style=\"display:none;position:absolute;width:350px;border:1px solid #000;background-color:#DDD;font-size:10px;font-family:Arial,Verdana\">
							<div style=\"border-bottom:1px solid #000;padding:4px\">
							Before you select an image, select the mode (float) and the border you want apply to the image.<br />
							<strong>Float:</strong> 						
								   <select style=\"font-size:10px;font-family:Arial,Verdana;margin-bottom:3px\">
									   <option value=\"none\" selected=\"selected\">none</option>
									   <option value=\"left;margin:3px 4px 3px 0px\" >Left</option>
									   <option value=\"right;margin:3px 0px 3px 4px\">Right</option>
								   </select>					
							
							<strong>Border:</strong> 						
								   <select style=\"font-size:10px;font-family:Arial,Verdana;margin-bottom:3px\">
									   <option value=\"none\" selected=\"selected\">none</option>
									   <option value=\"1px solid #000\">Black</option>
									   <option value=\"1px solid #999\">Grey</option>
		
								   </select>					
							</div>
							<div style=\"height:350px;overflow:auto\">
								{$imgDiv}
							</div>
						</div>	
						
					</div>									
					";

			if ($fileDiv=="") $dis="alt=\"No File available\" title=\"No File available\" disabled=\"disabled\""; else $dis="$button_style";
			
			$insert_file_link="
					<div style=\"float:left\">
						<button type=\"button\" $dis onclick=\"document.getElementById('preview_files_{$id}').style.display=document.getElementById('preview_files_{$id}').style.display=='block'?'none':'block';\">
							Link to Existing File
						</button>
						
						<div id=\"preview_files_{$id}\" style=\"display:none;position:absolute;border:1px solid #000;background-color:#DDD;font-size:10px;font-family:Arial,Verdana\">
							<div style=\"padding:5px\">
								
								<strong>Open link to the file in a NEW WINDOW ?</strong> 						
								 <select style=\"font-size:10px;font-family:Arial,Verdana;margin-bottom:3px\">
									 <option value=\"Yes\" selected=\"selected\">Yes</option>
									 <option value=\"No\" >No</option>
								 </select>
								 
								 <hr />{$fileDiv}
								
							</div>							
						</div>	
					</div>									
					";



		}
		else $insert_images="<br />";
		

		if ($this->params['selectFont']!=false)		
		{
			if (!is_array($this->params['selectFont']))//valori di default
			$this->params['selectFont']=array('Arial','Verdana','Georgia','Geneva','Courier new','Times new roman');
			
			$option="<option value=\"\">Font family</option>";
			
			foreach($this->params['selectFont'] as $font)
			$option.="<option value=\"{$font}\">{$font}</option>";
			
			$select_font="<select $button_style onchange=\"this.blur();command('{$id}','fontname',this.value);this.selectedIndex=0\">
						  	{$option}
						  </select>  &nbsp;
						  ";
		}
		else $select_font="";

		if ($this->params['fontSize']!=false)		
		{
			if (!is_array($this->params['fontSize']))//valori di default
			$this->params['fontSize']=array('start'=>8,'end'=>'23');
							
			$option="<option value=\"\">Font size</option>";
			for($i=$this->params['fontSize']['start'];$i<=$this->params['fontSize']['end'];$i++)
			$option.="<option value=\"{$i}\">{$i}</option>";
			
			$font_size="<select $button_style onchange=\"this.blur();command('{$id}','fontsize',this.value);this.selectedIndex=0\">
						  	{$option}
						  </select>  &nbsp;
						  ";
		}
		else $font_size="";		
		
		


		$result="
		
		<div style=\"background-color:#EEEEEE;padding:5px;color:#000\" >
			
			".($this->params['bold']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','Bold');\" $button_style><strong>Bold</strong></button> &nbsp;":"")."
			".($this->params['italic']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','Italic');\" $button_style><em>Italic</em></button> &nbsp;":"")."
			".($this->params['underline']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','Underline');\" $button_style><span style=\"text-decoration:underline\">Underline</span></button> &nbsp;":"")."
			".($this->params['ulist']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','insertunorderedlist');\" $button_style>&bull; List</button> &nbsp;":"")."
			".($this->params['jleft']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','justifyleft');\" $button_style>Justify Left</button> &nbsp;":"")."
			".($this->params['jcenter']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','justifycenter');\" $button_style>Justify Center</button> &nbsp;":"")."
			".($this->params['jright']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','justifyright');\" $button_style>Justify Right</button> &nbsp;":"")."
			".($this->params['link']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','CreateLink');\" $button_style>&raquo;Link&laquo;</button> &nbsp;":"")."
			".($this->params['unformat']?"<button type=\"button\" onclick=\"this.blur();command('{$id}','RemoveFormat');\" $button_style><em>Un</em>Format</button> &nbsp;":"")."				
			{$select_font}			
			{$font_size}		
			<button type=\"button\" onclick=\"if (confirm('Really empty TextArea?')) {this.blur();command('{$id}','Empty')};\" $button_style >Empty</button> &nbsp;
			<button type=\"button\" onclick=\"this.blur();command('{$id}','Code');\" $button_style >View code</button> &nbsp; 		
			{$insert_images}
			{$insert_file_link}
			<div style=\"clear:both\">
				To copy and paste use [CTRL + C] and [CTRL + V]<br />
				<strong>Important:</strong> Don't paste text directly from Word, paste first into a simple editor like NotePad
			</div>
		</div>
		<iframe class=\"{$class}\" style=\"{$this->params['style']}\" id=\"{$id}\" name=\"{$id}\" ></iframe>
		<input type=\"hidden\" name=\"{$id}_ifr\" id=\"{$id}_ifr\" value=\"\" />
		

		
		<script type=\"text/javascript\">
		
		////INIZIALIZZAZIONE

		initialize_iframe('$id',\"$value\",'{$this->params['bodyStyleOrCSS']}');	

		//////////////
		
		</script>
		";
		return $result;
		
	}
	
	/** @return string javascript code needed to prepare the data inside the formatter to be sended via GET or POST before 
	  *							  by the form submit
	  *                			  <br />ITALIAN: il codice javascript necessario a predisporre i dati presenti nel formattatore 
	  * 							  prima dell'invio via GET o POST effettuato dal form 
	  */
	function getSaveInstructions($id) 
	{
		return "save_iframe_text('".$id."');";
	}


	/** @return string a javascript boolean condition (without;) that will be placed inside a javascript IF instruction
	  *				   to test if the formatter is empty.<br />This is necessary for required fields validation.	
	  *                <br />ITALIAN: Una condizione booleana javascript (senza ;) che sarà inserita dentro una istruzione IF 
	  *				   per controllare se il formattatore è vuoto.<br /> Questo è necessario per la validazione dei campi obbligatori
	  */
	function getIsEmptyCondition($id) 
	{
		return "iframe_isEmpty('".$id."')"; //senza il punto e virgola finale xkè inserito in una if..
	}
		
	/** @return string  string containing the definition of some javascript functions required for initialization,
	  * 				validation ({@link getIsEmptyCondition}), data saving in the binded hidden input 
	  *					({@link getSaveInstructions}) and execution of the formatter commands.
	  *
	  *					<br />ITALIAN: stringa contenente la definizione di alcune funzioni javascript necessarie ad effettuare l'inizializzazione,
	  * 					la validazione ({@link getIsEmptyCondition}), il salvataggio dei dati nell’hidden input 
	  * 					associato ({@link getSaveInstructions}) e l’esecuzione dei comandi di formattazione del formattatore.
 	  */
	protected function printInitCode() 
	{
		// nella stringa heredoc i caratteri \n sono backslashati come \\n altrimeni nel testo html si crea un vero ritorno a capo..
		echo <<<ENDOFSTRING
	
		<script type="text/javascript">
		<!--	
		
		initialize_iframe=function (id,value,bodyStyleOrCSS)
		{
			if (bodyStyleOrCSS.match(/.+\.(css|CSS)/))
			{
				bodyStyle='';
				css="<link rel=\"stylesheet\" type=\"text/css\" href=\""+bodyStyleOrCSS+"\" />"; 
			}
			else
			{
				bodyStyle="style='"+bodyStyleOrCSS+"'";
				css=''; 
			}
		
			iFrameDoc = (document.all)? "window.document.frames('"+id+"').document;": "document.getElementById('"+id+"').contentDocument;";
			eval(iFrameDoc).open();
			eval(iFrameDoc).write(css+"<body "+bodyStyle+">"+value+"</body>");
			eval(iFrameDoc).close();
			eval(iFrameDoc).designMode =  (document.all)? "On" : "on"; 
			
			eval(iFrameDoc).onkeydown=function () ///Solo per IE, INSERISCE BR qundo si preme invio
			{
				iFrameDoc = (document.all)? "window.document.frames('"+id+"');": "document.getElementById('"+id+"');";
			
				if (eval(iFrameDoc).event.keyCode==13)
				{
					r=eval(iFrameDoc).document.selection.createRange();
					r.pasteHTML('<br />');
					r.select();
					r.collapse(false);
					return false;
				}				
			}
			
			eval(iFrameDoc).onfocus=function () 
			{
				iFrameDoc = (document.all)? "window.document.frames('"+id+"').document;": "document.getElementById('"+id+"').contentDocument;";
			
				if (pure_text(eval(iFrameDoc).body.innerHTML)=="") eval(iFrameDoc).body.innerHTML="&nbsp;";	

			}			
		}		
		
		
		pure_text=function (res)
		{
			var temp = new Array();
			
			if (res.indexOf("<")!=-1) ///////////////////////////////////elimina i tag
			{
				//alert ('elimina_tag');
				temp = res.split('<'); res=""; 
				for (i=0;i<temp.length;i++) 
				{ 
					if ( temp[i].substr(0,3).toLowerCase()!='img' ) //le immagini vengono considerate come contenuto
						res=res+temp[i].substring(temp[i].indexOf('>')+1); 	
					else
						res=res+'<'+temp[i].substring(0,temp[i].indexOf('>')+1); 
				}
				 
				
			}	
			
			if (res.indexOf("&")!=-1)////////////////////////////////elimina le entita
			{			
				//alert ('elimina_entita');
				temp = res.split("&"); res="";  

				for (i=0;i<temp.length;i++)	{ res=res+temp[i].substring(temp[i].indexOf(';')+1); }	
			}
			
			//if (res.charAt(0)==" " && res.charAt(res.length)==" ")
			//res=res.substring(res.indexOf(" ")+1,res.lastIndexOf(" ")-1); 

			while (res.charAt(0)==" " && res.length!=0) {res=res.substring(1);} //LEFT TRIM	
			while (res.charAt(res.length)==" " && res.length!=0) {res=res.substring(0,res.length-1);} //RIGHT TRIM
			
			return res;
			
		}
		
		
		save_iframe_text=function (iframe)
		{
			var iFrameDoc = (document.all)? "document.frames(\""+iframe+"\").document\;": "document.getElementById(\""+iframe+"\").contentDocument\;";
			
			if (  eval(iFrameDoc).designMode=="on" //mozilla 
			   || eval(iFrameDoc).designMode=="On" //IE
			   )
			{
				document.getElementById(iframe+"_ifr").disabled=false;
				
				if (pure_text(eval(iFrameDoc).body.innerHTML)!="")
				document.getElementById(iframe+"_ifr").value=eval(iFrameDoc).body.innerHTML;		
				else 
				document.getElementById(iframe+"_ifr").value="&nbsp;";		
			}
			else //se è disabilitata l'iframe, disabilita l'input hidden di dati (l'input di verifica viene disabilitato col js generato da htmlform)
			{
				document.getElementById(iframe+"_ifr").disabled=true; 
			}
		}

		//true se il formattatore è pieno, altrimenti false
		iframe_isEmpty=function (iframe)
		{
			var iFrameDoc = (document.all)? "document.frames(\""+iframe+"\").document\;": "document.getElementById(\""+iframe+"\").contentDocument\;";
			var iFrameFoc = (document.all)? "document.frames(\""+iframe+"\").focus()\;": "document.getElementById(\""+iframe+"\").contentWindow.focus()\;";
			

			if (
					(    eval(iFrameDoc).designMode=="on" //mozilla 
			 	      || eval(iFrameDoc).designMode=="On" //IE
			 		)				
				   && pure_text(eval(iFrameDoc).body.innerHTML)=="" 
			   )//se non è disabilitato ed è vuoto fallisce la validazione
			{
				////alert(eval(iFrameDoc).body.innerHTML);
				eval(iFrameDoc).body.innerHTML="&nbsp;"; //pulisce :\
				eval(iFrameFoc);
				return true;
			}
			return false;
			
					
		}		
		
		
		command=function (iframe,command,param)
		{
		
			var iFrameDoc = (document.all)? "document.frames(\""+iframe+"\").document\;": "document.getElementById(\""+iframe+"\").contentDocument\;";
			var iFrameFoc = (document.all)? "document.frames(\""+iframe+"\").focus()\;": "document.getElementById(\""+iframe+"\").contentWindow.focus()\;";
		
			eval(iFrameFoc); //FOCUS - Explorer lo vuole prima del comando altrimenti non inserisce bene le immagini
		
			if (command=='CreateLink')
			{
				href=prompt("Insert full URL or command\\nEX:\\nhttp://www.cottonbit.it\\nmailto:info@cottonbit.it");
				
				if (href!=null) //se href==null è stato premuto Annulla
				{
					//if (href.indexOf('http://') != 0) {href='http://'+href;}   //aggiunge http://
					eval(iFrameDoc).execCommand("CreateLink",false,href);
					
					if (confirm("Open link in new window?"))
					{
					
						href=href.replace(/&/g,'&amp;');
						nuovo_html=eval(iFrameDoc).body.innerHTML;
						nuovo_html=nuovo_html.replace("<a href=\""+href+"\">","<a href=\""+href+"\" onclick=\"window.open(this.href);return false\">");
						nuovo_html=nuovo_html.replace("<A href=\""+href+"\">","<A href=\""+href+"\" onclick=\"window.open(this.href);return false\">");		
						eval(iFrameDoc).body.innerHTML=nuovo_html;
					}
				} 
			}
			else if (command=='FileLink') //link ad un file già caricato dall'utente
			{
					eval(iFrameDoc).execCommand("CreateLink",false,param.url);
					
					if (param.newWindow=='Yes')
					{
						param.url=param.url.replace(/&/g,'&amp;');
						nuovo_html=eval(iFrameDoc).body.innerHTML;
						nuovo_html=nuovo_html.replace("<a href=\""+param.url+"\">","<a href=\""+param.url+"\" onclick=\"window.open(this.href);return false\">");
						nuovo_html=nuovo_html.replace("<A href=\""+param.url+"\">","<A href=\""+param.url+"\" onclick=\"window.open(this.href);return false\">");		
						eval(iFrameDoc).body.innerHTML=nuovo_html;
					}

			}			
			else if (command=='InsertImage')
			{
				eval(iFrameDoc).execCommand(command,false,param.imgSrc);
				
				//param.float contiene il valore di float + l'attributo margin

				nuovo_html=eval(iFrameDoc).body.innerHTML;
				nuovo_html=nuovo_html.replace(new RegExp("<(img|IMG) src=(\")?"+param.imgSrc+"(\")?>")
											 ,"<img style=\"float:"+param.float+";border:"+param.border+"\" src=\""+param.imgSrc+"\" alt=\"\">");
				eval(iFrameDoc).body.innerHTML=nuovo_html;

			}			
			else if (command=='Code')
			{ 
				////if (eval(iFrameDoc).body.innerHTML.indexOf("\\n")!=-1) alert("Ci sono i caratteri di ritorno a capo!");
				alert(eval(iFrameDoc).body.innerHTML);
			}
			else if (command=='Empty')
			{ 
				eval(iFrameDoc).body.innerHTML='&nbsp;';			
			}
			else if (command=='fontsize')
			{ 
				eval(iFrameDoc).execCommand(command,false,2);

				nuovo_html=eval(iFrameDoc).body.innerHTML;
				nuovo_html=nuovo_html.replace("<font size=\"2\">","<span style=\"font-size:"+param+"px\">");
				nuovo_html=nuovo_html.replace("</font>","</span>");		
				nuovo_html=nuovo_html.replace("<FONT size=2>","<span style=\"font-size:"+param+"px\">");
				nuovo_html=nuovo_html.replace("</FONT>","</span>");		
				eval(iFrameDoc).body.innerHTML=nuovo_html;
				
			}									
			else	eval(iFrameDoc).execCommand(command,false,param);
			
			
			
		}
		-->
		</script>
ENDOFSTRING;
	}
}




?>