<?php
/**
  *	@author Michele Castellucci <ghiaccio84@gmail.com>
  *
  * questo file contiene la classe HTMLForm  e una funzioni esterna
  */

		define("REGEXP_NOTNULL","/^(.|\\n|\\r|\\r\\n)+$/"); //vale per le text e le textarea (ritorni a capo)
		define("REGEXP_NUMREAL","/^-{0,1}((\d{1,})|(\d{1,}\.\d{1,}))$/");
		define("REGEXP_NUMINT","/^-{0,1}\d{1,}$/");
		define("REGEXP_DATE","/^\d{2}\/\d{2}\/\d{4}$/");
		define("REGEXP_DATE_MY","/^\d{2}\/\d{4}$/");
		define("REGEXP_EMAIL","/^.{1,}@.{1,}\..{1,}$/");		
		define("REGEXP_IMAGE","/^.+\.((gif)|(jpg)|(png))$/");
		define("REGEXP_FILE","/^.+\..{2,4}$/");	
		define("REGEXP_NUMSTRING","/^\d+$/");
	
	
		
/**
  * Questa classe consente di costruire 
  *	un form XHTML accessibile con metodi avanzati di validazione dati Javascript. Il form costruito è inserito in una tabella di 2 colonne.		
  */
  		
class HTMLForm
{
	/**
  	* Contiene il codice XHTML del form creato 
  	* @var string    	
	*/
	var $result="";
	/**
  	* nome del form
	* @var string 
  	*/	
	var $name;
	/**
  	* La largezza della prima colonna della tabella del form
  	* @var int 
	*/		
	var $width1;
	/**
  	* La largezza della seconda colonna della tabella del form
  	* @var int 
	*/		
	var $width2;	
	/**
  	* Contiene il codice JavaScript di validazione del form
  	* @var string 
	*/		
	var $validateFunction="";
	/**
  	* Array contenente come indici i nomi di tutti gli input inseriti
 	* @var array  
  	*/	
	var $input=array();
	/**
  	* Distanza orizzontale tra un input e il successivo, in poche parole l'altezza della riga vuota tra 2 input
  	* @var int 
	*/		
	var $horizSpace;
	/**
  	* Booleano che indica se i paramentri iniziali sono stati reimpostati dopo l'istanziamento della classe
  	* @var boolean 
	*/			
	var $params_redefined=false;

	/**
  	* Contiene il codice XHTML del form creato da aggiungere in coda. 
  	* @var string    	
	*/				
	var $result_end="";
	/**
  	* Contiene il codice JavaScript di validazione del form da aggiungere in coda
  	* @var string 
	*/		
	var $validateFunction_end="";
	/**
  	* Contiene il nome dell'input focalizzato
  	* @var string 
	*/		
	var $focused_field="";
	/**
  	* Contiene il messaggio abbinato all'input focalizzato
  	* @var string 
	*/		
	var $focused_msg="";
	/**
  	* Contiene un booleano che indica se visualizzare i label degli input e gli input su una nuova riga
  	* @var boolean 
	*/		
	var $ever_new_line=false;
	/**
  	* Contiene la lingua con cui si stampa il form
  	* @var string 
	*/		
	var $lang=array();
	

	var $removeServerValidation='';
	var $noNameNum=0;

	var $HTMLtextEditor=false; //di tipo textEditorContainer	
	
	
	
	var $tabInfo=array("standardLabel"=>"","allLabel"=>"Seleziona una scheda:","elems"=>array(),"mode"=>"tabs"); 
	
	var $defaultInputStyle=array('text'=>"width:75%;","textarea"=>"width:100%;height:100px");
	
	/**
		Definisce $field (aggiunto o da aggiungere tramite addInput ) come un campo ‘focused’ ovvero come un campo in cui è impostato automaticamente il focus. Inoltre inserisce $msg sulla riga di spaziatura della tabella situata sopra l’input.
		Il focus e l’inserimento del messaggio vengono effettuati tramite una funzione javascript associata all’evento onload della finestra. Il javascript viene aggiunto ALLA FINE di tutto l’output generato da HTMLForm.  
	*/		
	
	function disableDefaultInputStyle()	{ $this->defaultInputStyle=array(); }
	
	function setFocused($field,$msg)
	{
		$this->focused_field=$field;
		$this->focused_msg=$msg;
	}
	
	/** Imposta la lingua dei testi del form */
	function setLanguage($lang)
	{
		$lang=strtolower($lang);
		$this->lang['languageName']=$lang;
		
		if ($lang=='english')
		{
			$this->lang['insertPassword']="Insert new password";
			$this->lang['passwordsDifferent']="Inserted passwords are different";
			$this->lang['authorizeTreatment']="You must authorize personal data treatment";
			$this->lang['insertVerifyCode']="You must insert verify code";	
			$this->lang['day']="day";
			$this->lang['month']="month";
			$this->lang['year']="year";
			$this->lang['old']="Old";
			$this->lang['rewrite']="Rewrite";
			$this->lang['new']="New";
			$this->lang['missingInformation']="Missing information";
			$this->lang['notValidNumber']="This is not a valid number";
			$this->lang['notValidInt']="This is not a valid int number";
			$this->lang['notDate']="This is not a date";
			$this->lang['notValidEmail']="This is not a valid E-mail address";
			$this->lang['notImage']="Selected file is not an image";
			$this->lang['notFile']="Selected file is not valid";	
			$this->lang['incompleteInformation']="Incomplete information";
			$this->lang['deleteCurrent']="Delete current";	
			$this->lang['selectAnOption']="Select an option";													
			$this->lang['selectTheOption']="Select the option";	
			$this->lang['selectTheOption']="Select at least one option";	
			$this->lang['notNumericString']="This is not a numeric string";													
			
					
		}else
		{
			$this->lang['insertPassword']="Inserire la nuova password";
			$this->lang['passwordsDifferent']="Le password inserite sono differenti";
			$this->lang['authorizeTreatment']="Devi autorizzare il trattamento personale dei dati";	
			$this->lang['insertVerifyCode']="Devi inserire il codice di verifica";
			$this->lang['day']="giorno";
			$this->lang['month']="mese";
			$this->lang['year']="anno";
			$this->lang['old']="Vecchia";
			$this->lang['rewrite']="Riscrivi";
			$this->lang['new']="Nuova";
			$this->lang['missingInformation']="Informazione mancante";
			$this->lang['notValidNumber']="Il valore inserito non è un numero";
			$this->lang['notValidInt']="Il valore inserito non è un numero valido";
			$this->lang['notDate']="Il valore non è una data";
			$this->lang['notValidEmail']="Il valore inserito non è un indirizzo E-mail valido";
			$this->lang['notImage']="Il file selezionato non è una immagine";
			$this->lang['notFile']="Il file selezionato non è valido";	
			$this->lang['incompleteInformation']="Informazione incompleta";
			$this->lang['deleteCurrent']="Elimina corrente";
			$this->lang['selectAnOption']="Selezione una opzione";													
			$this->lang['selectTheOption']="Seleziona l'opzione";	
			$this->lang['selectOneOption']="Seleziona almeno una opzione";	
			$this->lang['notNumericString']="Il valore inserito non è una stringa numerica";														
		}
	}
	
	/**
  	* Definisce i parametri generali del form, VEDI COSTRUTTORE
	*/		
	function defineParams($name,$target,$width1,$width2,$summary="",$method="post",$horizSpace=14,$ever_new_line=false)
	{
		if (!$this->params_redefined) //può ridefinire i paramentri solo una volta
		{
			$this->ever_new_line=$ever_new_line;
			$this->horizSpace=$horizSpace;
			$this->name=$name;
			$this->width1=$width1;
			$this->width2=$width2;			

			$this->formOpenTag="<form method=\"$method\" action=\"$target\" id=\"$name\" enctype=\"multipart/form-data\">";
			$this->tableOpenTag="<table summary=\"$summary\" border=\"0\" style=\"width:".($this->width1+$this->width2)."%\" cellspacing=\"0\" cellpadding=\"0\"  >";
			
			$this->params_redefined=true;
		}
	}		
	/*
	 *	Costruttore della classe: $width1 e $width2 sono la larghezza delle 2 colonne della tabella in percentuale. 
	 *	$horizSpace è il valore in pixel della distanza inserita tra un input ed un altro.
	 *	La spaziatura avviene ad ogni esecuzione del metodo addInput() inserendo una riga vuota della tabella, a tale riga viene associato un id che consenta di poterla identificare per inserire un messaggio su un input impostato a ‘focused’: vedi metodo setFocused() .
	*/
	function HTMLForm($name,$target,$width1,$width2,$summary="",$method="post",$horizSpace=14,$ever_new_line=false)
	{
		$this->ever_new_line=$ever_new_line;
		$this->horizSpace=$horizSpace;
		$this->name=$name;
		$this->width1=$width1;
		$this->width2=$width2;
		
		$this->formOpenTag="<form method=\"$method\" action=\"$target\" id=\"$name\" enctype=\"multipart/form-data\">";
		$this->tableOpenTag="<table summary=\"$summary\" border=\"0\" style=\"width:".($this->width1+$this->width2)."%\" cellspacing=\"0\" cellpadding=\"0\"  >";

		$this->setLanguage("italiano");
		
		$this->HTMLtextEditor=new Adv_TextArea();
		
		echo "
		<script type=\"text/javascript\">
		<!--
		
		if(typeof switchTab != 'function') //funziona anche senza?
		function switchTab()
		{
		
			
			for(var i=1; i<arguments.length; i++) 
				document.getElementById(arguments[i]).style.display='none';
			
			document.getElementById(arguments[0]).style.display='block'; //alla fine visualizza questo disabilitando gli altri (anche se c'è lui stesso)
		}
	
		-->
		</script>
		
		";
		
		//$this->HTMLtextEditor=new ns_texteditor();
	}

	/** Imposta la classe che rappresenta il formattatore di testo HTML usato nei form.<br />
	  * La classe deve implementare l'interfaccia {@link TextEditorContainer()}
	  * @param TextEditorContainer oggetto di tipo {@link TextEditorContainer()} */ 	
	function setHTMLtextEditor($TextEditorContainer) 
	{
		$this->HTMLtextEditor=$TextEditorContainer;
	}
	
	/** Imposta la suddivisione dei campi del form in schede, specificando il contenuto di una scheda.
	  * I campi che non fanno parte di nessuna delle schede impostate, vengono inseriti all'interno scheda separata.
	  * @param nome univoco della scheda (div id)
	  * @param String testo corrispondente al comando che attiva la visualizzazione della scheda
	  * @param array lista di stringhe corrispondendti ai nomi dei campi da includere all'interno della scheda
	  */ 	
	function addTab($name,$label,$fieldArr) 
	{
		if(!is_array($fieldArr)) //è un solo valore stringa
			$fieldArr=array($fieldArr);

		$this->tabInfo['elems'][$name]= array( "label"=>$label , "field"=>$fieldArr );
	}

	function addGroup($name,$label,$fieldArr) 
	{
		$this->tabInfo['mode']="groups";
		$this->addTab($name,$label,$fieldArr);
	}

	/** Imposta il testo corrispondente al comando che attiva la visualizzazione la scheda generale dei campi.
	  * Inoltre è possibile specificare come secondo parametro l'etichetta descrittiva di tutti i link di attivazione delle schede
	  * @param String testo
	  * @param String testo */ 	
	function setStandardTabLabel($name,$standardLabel,$allLabel=false) 
	{
		$this->tabInfo['mainName']=$name; //era $this->name."_maintab"
		$this->tabInfo['standardLabel']=$standardLabel;
		$this->tabInfo['allLabel']=$allLabel;
	}
	
	
	
	/*
 	 *	Aggiunge alla tabella del form una cella con testo $text arbitrario.
 	 */	
	function addExternalContent($text,$at_end=false,$name='')
	{
		
		
		if ($name=='')
		{
			$this->noNameNum++;
			$name="noname".$this->noNameNum;
		}
		
		$this->input[$name]['name']=$name;
		$this->input[$name]['html']="<tr>
														<td colspan=\"2\" style=\"height:".$this->horizSpace."px;\"></td>
												   </tr>
												   <tr>
												   		<td colspan=\"2\">{$text}</td>
												   </tr>";
		
		$this->input[$name]['atEnd']=$at_end;
		$this->input[$name]['validateFunction']='';		
	}	
	
	/*
 	 *	Aggiunge alla tabella del form una cella con testo $text arbitrario.
 	 */	
	function addExternalValidation($js,$at_end=false)
	{
		$this->noNameNum++;
		$this->input["noname".$this->noNameNum]['name']='';
		$this->input["noname".$this->noNameNum]['html']="";
		$this->input["noname".$this->noNameNum]['atEnd']=$at_end;
		$this->input["noname".$this->noNameNum]['validateFunction']=$js;
	}		
	
	/*
	 *	aggiunge al form una textarea (semplice) non editabile contenente il testo $law (tipicamente l’attuale legge sulla privacy) e una checkbox con validazione di tipo NOT_NULL con intestazione ($heading).
	 */
	function addPrivacyInput($law,$heading,$class="",$name='')
	{
		$classAttr=$class==""?"":"class=\"$class\"";

		if ($name=='')
		{
			$this->noNameNum++;
			$name="noname".$this->noNameNum;
		}


		$this->input[$name]['name']=$name;
		
		$this->input[$name]['html']="<tr><td colspan=\"2\" style=\"height:25px;\" >"; //spaziatura vert
		
		if ($law!="")
		{
			$this->input[$name]['html'].="
				<tr>
					<td colspan=\"2\" style=\"width:".($this->width1+$this->width2)."%\" >
						<label for=\"%frmName%_privacy_textarea\"></label>
						<textarea id=\"%frmName%_privacy_textarea\" {$classAttr} readonly=\"readonly\" style=\"width:".($this->width1+$this->width2)."%;height:100px\" cols=\"0\" rows=\"0\">$law</textarea>
					</td>
				</tr>";
		}
		
		$this->input[$name]['html'].="		
				<tr>
					<td colspan=\"2\" style=\"width:".($this->width1+$this->width2)."%\" >
						<input type=\"checkbox\" name=\"%frmName%_privacy_checkbox\" id=\"%frmName%_privacy_checkbox\" value=\"ignore_this_post\" />
						<label for=\"%frmName%_privacy_checkbox\"><strong>$heading</strong></label><br />
					</td>
				</tr>	
					";

		
		$this->input[$name]['atEnd']=true;
		$this->input[$name]['validateFunction']="
					
					if ( document.getElementById('%frmName%').%frmName%_privacy_checkbox.checked==false) 
					{alert('{$this->lang['authorizeTreatment']}'); document.getElementById('%frmName%').%frmName%_privacy_checkbox.focus(); return false;}
					";	
	}
	/*
 	 *  aggiunge 2 password input con validazione di tipo NOT_NULL e una aggiuntiva validazione che verifica che il contenuto del primo input sia uguale a quello del secondo. Il nome del primo input è naturamente $name, quello del secondo “{$name}_retyped” (questo dato è chiaramente inutile quindi in fase di ricezione dati deve essere eliminato)
 	 */
	function addInsertPasswordInputs($name,$heading="",$class="")
	{
		$this->addInput("password",$name,"",$heading,false,false,true,$class);
		$this->addInput("password",$name."_retyped","",$this->lang['rewrite']." ".$heading,false,false,true,$class);
		
	$this->validateFunction.="
		if ( document.getElementById('%frmName%').{$name}.value!=document.getElementById('%frmName%').{$name}_retyped.value  ) 
		{
			document.getElementById('%frmName%').{$name}.focus();
			alert(\"{$this->lang['passwordsDifferent']}\");
			return false;	
		}";
	}
	
	/*
	 *	aggiunge 3 password input “{$name}_old” , $name, “{$name}_retyped” (la vecchia password, la nuova password, la nuova password ridigitata) che permettono di modificare facoltativamente la password. Vengono inserite 2 validazioni: 
	 *	La prima effettua validazione di tipo NOT_NULL sulla nuova password, solo se si è inserito un valore per la vecchia password.
	 *	La seconda verifica che la nuova password sia uguale a quella ridigitata
	 *	sempre se si è inserito un valore per la vecchia password.	
	 */
	function addChangePasswordInputs($name,$heading="",$class="")
	{
		$this->addInput("password",$name."_old","",$this->lang['old']." ".$heading,false,false,false,$class);
		$this->addInput("password",$name,"",$this->lang['new']." ".$heading,false,false,false,$class);
		$this->addInput("password",$name."_retyped","",$this->lang['rewrite']." ".$heading,false,false,false,$class);
	
		
	$this->validateFunction.="
	
		if ( document.getElementById('%frmName%').{$name}_old.value!='' && 
			document.getElementById('%frmName%').{$name}.value==document.getElementById('%frmName%').{$name}_retyped.value  &&
			document.getElementById('%frmName%').{$name}.value==''
			) 
		{
			document.getElementById('%frmName%').{$name}.focus();
			alert(\"{$this->lang['insertPassword']}\");
			return false;	
		}
	
		if ( document.getElementById('%frmName%').{$name}_old.value!='' && document.getElementById('%frmName%').{$name}.value!=document.getElementById('%frmName%').{$name}_retyped.value  ) 
		{
			document.getElementById('%frmName%').{$name}.focus();
			alert(\"{$this->lang['passwordsDifferent']}\");
			return false;	
		}";
	
	}

	/*
	 *	aggiunge 3 password input “{$name}_old” , $name, “{$name}_retyped” (la vecchia password, la nuova password, la nuova password ridigitata) che permettono di modificare facoltativamente la password. Vengono inserite 2 validazioni: 
	 *	La prima effettua validazione di tipo NOT_NULL sulla nuova password, solo se si è inserito un valore per la vecchia password.
	 *	La seconda verifica che la nuova password sia uguale a quella ridigitata
	 *	sempre se si è inserito un valore per la vecchia password.	
	 */
	function addChangePasswordInputsWithoutOldPassword($name,$heading="",$class="")
	{
		$this->addInput("password",$name,"",$this->lang['new']." ".$heading,false,false,false,$class);
		$this->addInput("password",$name."_retyped","",$this->lang['rewrite']." ".$heading,false,false,false,$class);
	
		
	$this->validateFunction.="
	
		if ( 
			document.getElementById('%frmName%').{$name}.value!=document.getElementById('%frmName%').{$name}_retyped.value  &&
			(document.getElementById('%frmName%').{$name}.value!='' || document.getElementById('%frmName%').{$name}_retyped.value!='')
			) 
		{
			document.getElementById('%frmName%').{$name}.focus();
			alert(\"{$this->lang['passwordsDifferent']}\");
			return false;	
		}
		";
	
	}

	/*
	 *	aggiunge un input testuale con intestazione $heading e classe del foglio di stile $class ed una immagine contenente un codice di verifica. 
	 *	Tale POST verrà controllato dal metodo insertIntoDBFromPost per controllare
	 *  che il valore inserito sia uguale al codice generato, contenuto nella variabile di sessione $_SESSION['verification_string'].
	 *  L'immagine contenente il codice di verifica è generata dal file verimage.php
	 */

	function addVerificationCode($heading="",$class="",$otherHTML="")
	{
		if ($class!="") $classAttr="class=\"{$class}\"";
		if ($otherHTML!="") $otherHTML="<br />{$otherHTML}";
	
		if (file_exists("verimage.php")) //cartella corrente dello script
			$path="verimage.php";
		else 
		if (file_exists("classes/verimage.php")) //cartella corrente dello script
			$path="classes/verimage.php";
		else 
		if (file_exists("../classes/verimage.php")) //cartella superiore dello script
			$path="../classes/verimage.php";
		else 
		if (file_exists("webedit/classes/verimage.php")) //cartella webedit
			$path="webedit/classes/verimage.php";

		$this->noNameNum++;
		$this->input["noname".$this->noNameNum]['name']='';
		$this->input["noname".$this->noNameNum]['html']="
		<tr>
			<td colspan=\"2\" style=\"height:".$this->horizSpace."px;\" id=\"verification_code_message\">
			
			</td>
		</tr>
		<tr>
			<td style=\"width:".$this->width1."%\" >
				<label for=\"verification_code\"><strong>$heading</strong></label>
			</td>
			<td style=\"width:".$this->width2."%\">	
				<img src=\"".$path."\" alt=\"codice di verifica\" style=\"vertical-align:bottom;border:1px solid #FF0000;\" />
				<input id=\"verification_code\" name=\"verification_code\" {$classAttr} style=\"width:50%\" />
				{$otherHTML}
			</td>
		</tr>
			";

		$this->input["noname".$this->noNameNum]['atEnd']=true;
		$this->input["noname".$this->noNameNum]['validateFunction']="
																	if ( document.getElementById('%frmName%').verification_code.value=='') 
																	{
																		alert('{$this->lang['insertVerifyCode']}'); 
																		document.getElementById('%frmName%').verification_code.focus(); 
																		return false;
																	}";			
	}	
	
	/*
 	 * Rimpiazza l'input identificato da name con un altro completamente diverso, in maniera che si mantenga sempre nello stesso ordine all'interno del form
 	 */	
	function editInput($inputType,$name,$value,$heading="",$bool=false,$selected=null,$validate=false,$class="",$at_end=false)
	{
		$this->input[$name]['html']="tobereplaced";
		$this->addInput($inputType,$name,$value,$heading,$bool,$selected,$validate,$class,$at_end);
	}
	
	/*
 	 * Aggiunge un input al form, VEDI HTMLForm.doc per spiegazione dettagliata....ritorna true o false ad indicare se l'input è stato aggiunto (o no xkè presente)
 	 */
	function addInput($inputType,$name,$value,$heading="",$bool=false,$selected=null,$validate=false,$class="",$at_end=false)
	{
		$inputType=strtoupper($inputType);
		
		$result="";
		$validateFunction="";
		
		$isArrayInput=preg_match("/.+\[.*\]/",$name); //gli input che sono degli array input (con molti valori sul form html) 
		
		if ($this->input[$name]['html']=="tobereplaced")
			$this->input[$name]['html']='';
		else
			if (isset($this->input[$name]) && !$isArrayInput) return false; 

		$this->input[$name]['name'] = ($inputType=='FILE' || $inputType=='PASSWORD'?'@':'').$name;
		if ($class!="") $classAttr="class=\"$class\"";
		
		
	//if ($name==$this->focused_field) $heading="<span style=\"color:#FF0000\">&raquo;&raquo;</span> <em>".$heading."</em>";	
		
		
		if ($inputType!="TEXTAREA") //le virgolette possono restare così in modifica nelle textarea's
		{
			///SOSTITUZIONE " con &quot;				
			if (is_array($value))
			{			
				$oldValue=$value;
				$value=array();
				foreach ($oldValue as $key=>$val)
				$value[str_replace("\"","&quot;",$key)]=str_replace("\"","&quot;",$val);
			}
			else $value=str_replace("\"","&quot;",$value);

			if (is_array($selected))
			{				
				$oldSelected=$selected;
				$selected=array();
				foreach ($oldSelected as $key=>$val)
				$selected[str_replace("\"","&quot;",$key)]=str_replace("\"","&quot;",$val);
			}
			else $selected=str_replace("\"","&quot;",$selected);
		}	


		if ($inputType=="TEXTAREA" && ( (is_array($bool) && count($bool>0)) || $bool===true)) //bool indica la textarea avanzata	
		{
			$inputType="ADV_TEXTAREA";
			$this->validateFunction.= $this->HTMLtextEditor->getSaveInstructions($name); //SALVATAGGIO DATI IFRAME	
		}


		if ($inputType!="HIDDEN")
		{ 
			if ($name==$this->focused_field)
			{
				$focused_msg_style="color:#FF0000;padding:6px 0px 6px 0px;";
				$focused_input_style="border:1px solid #FF0000";
				$focused_msg=$this->focused_msg;
			}
			else
			{ 
				$focused_msg_style="";
				$focused_input_style="";
				$focused_msg="";
			}
			
			$result.="
			<tr>
				<td colspan=\"2\" style=\"height:".$this->horizSpace."px;{$focused_msg_style}\" id=\"{$name}_message\">
					{$focused_msg}
				</td>
			</tr>"; //aggiunge una riga vuota 
		}


		if ($inputType=="DATE" || $inputType=="DATE_MY")
		{
			$is_day_empty="(document.getElementById('%frmName%').{$name}_day.disabled=='' && document.getElementById('%frmName%').{$name}_day.value=='')";
			$is_mon_empty="(document.getElementById('%frmName%').{$name}_mon.disabled=='' && document.getElementById('%frmName%').{$name}_mon.value=='')";
			$is_yea_empty="(document.getElementById('%frmName%').{$name}_yea.disabled=='' && document.getElementById('%frmName%').{$name}_yea.value=='')";
			
			$is_day_filled="(document.getElementById('%frmName%').{$name}_day.disabled=='' && document.getElementById('%frmName%').{$name}_day.value!='')";
			$is_mon_filled="(document.getElementById('%frmName%').{$name}_mon.disabled=='' && document.getElementById('%frmName%').{$name}_mon.value!='')";
			$is_yea_filled="(document.getElementById('%frmName%').{$name}_yea.disabled=='' && document.getElementById('%frmName%').{$name}_yea.value!='')";			
		}	
	

		if ($validate || is_array($validate)) //validazione javascript
		{
			//print_r($validate);
			if (is_array($validate))
			{
				$not_null=$validate[0];
				$validate=$validate[1];
			}
			else 
			$not_null=true;
			
			if ($inputType=="DATE")
			{
				$validateCondition="($is_day_empty || $is_mon_empty || $is_yea_empty)";
				
				$validateFunction.="
				if {$validateCondition}
				{
						 if {$is_day_empty}
							{alert('$heading {$this->lang['day']}: {$this->lang['missingInformation']}'); document.getElementById('%frmName%').{$name}_day.focus(); return false;}	
					else if {$is_mon_empty}
							{alert('$heading {$this->lang['month']}: {$this->lang['missingInformation']}'); document.getElementById('%frmName%').{$name}_mon.focus(); return false;}	
					else if {$is_yea_empty}
							{alert('$heading {$this->lang['year']}: {$this->lang['missingInformation']}'); document.getElementById('%frmName%').{$name}_yea.focus(); return false;}	
				}
				";				
			}
			else if ($inputType=="DATE_MY")
			{
				$validateCondition="($is_mon_empty || $is_yea_empty)";
				
				$validateFunction.="
				if {$validateCondition}
				{
					if {$is_mon_empty}
							{alert('$heading {$this->lang['month']}: {$this->lang['missingInformation']}'); document.getElementById('%frmName%').{$name}_mon.focus(); return false;}	
					else if {$is_yea_empty}
							{alert('$heading {$this->lang['year']}: {$this->lang['missingInformation']}'); document.getElementById('%frmName%').{$name}_yea.focus(); return false;}	
				}
				";				
			}

			else if ($inputType=="RADIO")
			{
				if (count($value)>1)
				{
					$cond=array();
					$cond2=array();
					for($i=0;$i<count($value);$i++)
					{
						$cond[] ="document.getElementById('%frmName%').{$name}[$i].checked==false";
						$cond2[]="document.getElementById('%frmName%').{$name}[$i].disabled==''";
					}
					$cond=implode(" && ",$cond);
					$cond2=implode(" || ",$cond2);
				}
				else
				{
					$cond="document.getElementById('%frmName%').{$name}.checked==false";
					$cond2="document.getElementById('%frmName%').{$name}.disabled==''";
				
				}
				//se sono tutti non selezionati ed almeno uno è selezionabile, ferma il form
				$validateCondition="((".$cond.") && (".$cond2."))";
				$validateFunction.="if {$validateCondition} {alert(\"$heading: {$this->lang['selectAnOption']}\"); document.getElementById('%frmName%').{$name}[0].focus(); return false;}
				";
			} 
			else if ($inputType=="CHECKBOX")
			{
				if (!is_array($value))
				$validateFunction.="if ( document.getElementById('%frmName%').{$name}.disabled=='' && document.getElementById('%frmName%').{$name}.checked==false) {alert(\"{$this->lang['selectTheOption']}\"); document.getElementById('%frmName%').{$name}.focus(); return false;}
				";
				else
				{
					$cond=array();
					$cond2=array();
					$i=0;
					foreach($value as $val)
					{
						$cond[] ="document.getElementById('%frmName%').elements['{$name}[{$i}]'].checked==false";
						$cond2[]="document.getElementById('%frmName%').elements['{$name}[{$i}]'].disabled==''";
						$i++;
					}
					$cond=implode("  &&  ",$cond);
					$cond2=implode("  ||  ",$cond2);
					$validateCondition="((".$cond.") && (".$cond2."))";
					$validateFunction.="if {$validateCondition} {alert(\"{$heading}: {$this->lang['selectOneOption']}\"); document.getElementById('%frmName%').elements['{$name}[0]'].focus(); return false;}
					";

				}

			}
			else if ($inputType=="ADV_TEXTAREA")
			{
				$validateCondition="(".$this->HTMLtextEditor->getIsEmptyCondition($name).")";
				$validateFunction.="if {$validateCondition} 
				{					
					alert(\"$heading: {$this->lang['missingInformation']}\"); 
					return false;					  
				}"; 
			}
			else		
			{
				if (is_bool($validate)) $validate=REGEXP_NOTNULL; //Se il valore di $validate impostato a true viene usato per altri tipi di input come TEXT, PASSWORD, FILE, allora $validate viene interpretato come la costante predefinita NOT_NULL. 
			

				switch($validate)
				{
					 case REGEXP_NOTNULL:$check=".match($validate)==null"; $msg="$heading: {$this->lang['missingInformation']}"; break;
					 case REGEXP_NUMREAL: $check=".match($validate)==null"; $msg="$heading: {$this->lang['notValidNumber']}"; break;
					 case REGEXP_NUMINT: $check=".match($validate)==null"; $msg="$heading: {$this->lang['notValidInt']}"; break;
					 case REGEXP_DATE:
					 case REGEXP_DATE_MY: $check=".match($validate)==null"; $msg="$heading: {$this->lang['notDate']}"; break;
					 case REGEXP_EMAIL: $check=".match($validate)==null"; $msg="$heading: {$this->lang['notValidEmail']}"; break;
					 case REGEXP_IMAGE: $check=".toLowerCase().match($validate)==null"; $msg="$heading: {$this->lang['notImage']} (gif,jpg o png)"; break;
					 case REGEXP_FILE: $check=".toLowerCase().match($validate)==null"; $msg="$heading: {$this->lang['notFile']}"; break;
					 case REGEXP_NUMSTRING: $check=".toLowerCase().match($validate)==null"; $msg="$heading: {$this->lang['notNumericString']}"; break;					
					 default  :$check="==''"; $msg="$heading: {$this->lang['missingInformation']}.."; break;
				}
				//echo $name."-".$validate."-".$check."<br>";
				$and=$not_null===false?"&& document.getElementById('%frmName%').$name.value!=''":"";
				$validateCondition="(document.getElementById('%frmName%').$name.disabled=='' && document.getElementById('%frmName%').$name.value{$check} $and)";
				$validateFunction.=" if  {$validateCondition}
										 {alert(\"$msg\"); document.getElementById('%frmName%').$name.focus(); return false;} 
								   ";
												   
													   
			}
			if ($not_null===true) $heading.=" (*)"; //visualizza l'asterisco per i campi (strettamente) obbligatori

		}
		else //  ------  campo NON OBBLIGARIO
		if ($inputType=="DATE") //controllo che si selezionino tutte e tre le select  si seleziona giorno o mese o ora e non si seleziona giorno o mese o ora
		{
			$validateFunction.= "				
			if (
				( {$is_day_filled} || {$is_mon_filled} || {$is_yea_filled} )
					&&
				( {$is_day_empty}  || {$is_mon_empty}  || {$is_yea_empty}  )
			   )																									
			   {
					alert('$heading: {$this->lang['incompleteInformation']}'); 
					document.getElementById('%frmName%').{$name}_day.focus(); 
					return false;
			   }
			   ";			
		}
		else 
		if ($inputType=="DATE_MY") //controllo che si selezionino tutte e tre le select  si seleziona giorno o mese o ora e non si seleziona giorno o mese o ora
		{
			$validateFunction.= "				
			if (
				(  {$is_mon_filled} || {$is_yea_filled} )
					&&
				(  {$is_mon_empty}  || {$is_yea_empty}  )
			   )																									
			   {
					alert('$heading: {$this->lang['incompleteInformation']}'); 
					document.getElementById('%frmName%').{$name}_day.focus(); 
					return false;
			   }
			   ";			
		}
	
	
	
		if ($this->ever_new_line && $inputType!='HIDDEN') 
		$result.="<tr><td colspan=\"2\" style=\"width:".($this->width1+$this->width2)."%\" ><strong><label for=\"$name\">$heading</label></strong><br />";
		else
		switch($inputType) //tabella
		{
			case 'SELECT':
			case 'FILE':
			case 'PASSWORD':
			case 'TEXT':
			case 'DATE':	
			case 'DATE_MY':	
				$result.="<tr>
							<td style=\"width:{$this->width1}%\"><strong><label for=\"$name\">$heading</label></strong></td>
							<td style=\"width:{$this->width2}%\">
				";
				break;

			case 'CHECKBOX': break;
			//checkbox e radio hanno un tag label abbinato ad ogni possibile scelta (click su label = click su input ) ma checkbox crea l'intestazione dopo..
			case 'RADIO':
				$result.="<tr>
							<td style=\"width:{$this->width1}%\"><strong> $heading </strong></td>
							<td style=\"width:{$this->width2}%;{$focused_input_style}\">
				";
				break;			
			case 'TEXTAREA':
			case 'ADV_TEXTAREA':$result.="<tr><td colspan=\"2\" style=\"width:".($this->width1+$this->width2)."%\" ><strong><label for=\"$name\">$heading</label></strong><br />"; break;
			case 'HIDDEN':$result.="<tr><td colspan=\"2\" style=\"height:0px\" >
			";
		}
	
		switch($inputType) //tag input
		{
			case 'FILE':if ($bool) $script="var cb=document.getElementById('%frmName%').delete_{$name};
			if (document.getElementById('%frmName%').$name.value!='') {cb.disabled=true; cb.checked=true;}
				else {cb.disabled=false; cb.checked=false;}
				"; else $script="";
			$result.="<input {$classAttr} type=\"file\"  id=\"$name\" name=\"$name\" value=\"$value\" 
			onchange=\"$script\" onkeyup=\"$script\" />";
			if ($bool) $result.="<br /><input {$classAttr} type=\"checkbox\" value=\"1\" name=\"delete_{$name}\" style=\"{$focused_input_style}\" onchange=\"
			if (document.getElementById('%frmName%').delete_{$name}.checked==true) document.getElementById('%frmName%').$name.disabled=true;
				else document.getElementById('%frmName%').$name.disabled=false\" />{$this->lang['deleteCurrent']} $heading 
			"; 
						break;
			case 'TEXT':$result.="<input {$classAttr} style=\"{$this->defaultInputStyle['text']};{$focused_input_style}\" ".(is_numeric($bool)?"maxlength=\"{$bool}\"":"")." type=\"text\" id=\"$name\" name=\"$name\" value=\"$value\" size=\"30\" />
			"; 
					break;
			case 'PASSWORD':$result.="<input {$classAttr} style=\"{$this->defaultInputStyle['text']};{$focused_input_style}\" type=\"password\" id=\"$name\" name=\"$name\" value=\"$value\" size=\"30\" />
			"; 
						break;			
			case 'HIDDEN':$result.="<input type=\"hidden\" name=\"$name\" value=\"$value\" id=\"$name\" />";
						break;
						  
			case 'CHECKBOX':
				
						if (!is_array($value)) //checkbox semplice
						{
							if ($selected) $selected="checked=\"checked\""; 
					
							$result.="<tr>
										<td colspan=\"2\">
											<input {$classAttr} type=\"checkbox\" id=\"$name\" name=\"$name\" value=\"$value\" style=\"{$focused_input_style}\" $selected style=\"vertical-align:middle\" />
											<strong><label for=\"$name\">$heading</label></strong>
										";
						}
						else //checkbox con più scelte
						{
							//.. intestazione ...
							$result.="<tr>
										<td style=\"width:{$this->width1}%\"><strong> $heading </strong></td>
										<td style=\"width:{$this->width2}%\">
										";
							$first=true;
							$i=0;
							foreach ($value as $key=>$val)
							{
								$labelId=$name."__".str_replace(array(" ","%"),"_",$key);

								if (in_array($key,$selected)) $sel="checked=\"checked\""; else $sel="";

								$result.="<label for=\"{$labelId}\"><input type=\"checkbox\" name=\"{$name}[{$i}]\" id=\"{$labelId}\" value=\"{$key}\" {$sel} />
																	{$val}</label><br />";
								++$i;
							}							
						}						
						break;	
			case 'ADV_TEXTAREA':					
						
																				
						
						
						$this->HTMLtextEditor->setParams($bool);
												
						$result.=$this->HTMLtextEditor->getHTMLInstance($name,addslashes($value),$class);
						
						
					break;
					
			case "TEXTAREA":

						$value=str_replace("<br />","\n",$value); ////////!
						
						//if ($bool) $bool="readonly=\"readonly\""; else $bool="";
						$result.="
						<textarea {$classAttr} id=\"$name\" name=\"$name\" style=\"{$this->defaultInputStyle['textarea']};{$focused_input_style}\" cols=\"0\" rows=\"0\" >$value</textarea>
						"; 													
					break;
			
			case 'RADIO'://$result.="<FIELDSET>";

					 if ($bool) $bool="&nbsp;&nbsp;&nbsp;"; else $bool="<br />";
					 					 
					 foreach($value as $thevalue=>$hdn)
					 {
							$labelId=$name."__".str_replace(array(" ","%"),"_",$thevalue);
							
							if ((string)($thevalue)==(string)($selected))
							$checked="checked=\"checked\"";
							else $checked="";
									
							$result.="<label for=\"{$labelId}\"><input type=\"radio\" name=\"{$name}\" id=\"{$labelId}\" value=\"$thevalue\" $checked />
											$hdn</label> $bool";
					 }	
					
					 break;
			case 'SELECT':
						if (is_int($bool)) 
						{
							$mult="multiple=\"multiple\" size=\"{$bool}\""; 
							$arr="[]";
						}else
						{
							$mult=""; 
							$arr="";
						}
						
						$result.="<select {$classAttr} $mult id=\"$name\" name=\"{$name}{$arr}\" style=\"{$focused_input_style}\">
						";
								 $i=0;
								 foreach($value as $thevalue=>$hdn)
								 {
		
										if 
										( 
											(is_array($selected) && in_array((string)($thevalue),$selected)) 
										|| 
											(!is_array($selected) && (string)($thevalue)==(string)($selected) )   
										) 
										
										$sel="selected=\"selected\"";
										else 
										$sel="";					 
			
										$result.="<option value=\"$thevalue\" $sel>$hdn</option>
										";$i++;
								 }	
								 $result.="</select>
								 "; 
						
							break;
				
			case 'DATE':
			case 'DATE_MY':
						$selected=explode("-",$selected);
						$three_array=$this->dateArray($value[0],$value[1]);
						//if (strstr($heading," (*)")) $heading=substr($heading,0,strpos($heading," (*)"));
						$name_heading=str_replace("_"," ",$name);
						
						
						$result.="<div id=\"{$name}\" style=\"{$focused_input_style}\">";
						
						if ($inputType=='DATE')
						{
							$result.="<label for=\"{$name}_day\"></label>"; 	
							$result.="<select {$classAttr} id=\"{$name}_day\" name=\"{$name}_day\">
							";
									 $i=0;
									 foreach($three_array[0] as $thevalue=>$hdn)
									 {
											if (isset($selected[2]) && $thevalue==$selected[2]) $sel="selected=\"selected\""; else	$sel="";					 
											$result.="<option value=\"$thevalue\" $sel>$hdn</option>
											";$i++;
									 }	$result.="</select>
									 "; 
						}
						else// data/mese ---- il giorno viene memorizzato lo stesso nel campo data come 00				 
							$result.="<input type=\"hidden\" id=\"{$name}_day\" name=\"{$name}_day\" value=\"00\">"; 
								 
						$result.="<label for=\"{$name}_mon\"></label>"; 	
						$result.="<select {$classAttr} id=\"{$name}_mon\" name=\"{$name}_mon\">
						";
								 $i=0;
								 foreach($three_array[1] as $thevalue=>$hdn)
								 {
										if (isset($selected[1]) && $thevalue==$selected[1]) $sel="selected=\"selected\""; else	$sel="";					 
										$result.="<option value=\"$thevalue\" $sel>$hdn</option>
										";$i++;
								 }	$result.="</select>
								 "; 								 	 

						$result.="<label for=\"{$name}_yea\"></label>"; 	//intestazioni per l'accessibilità
						$result.="<select {$classAttr} id=\"{$name}_yea\" name=\"{$name}_yea\">
						";
								 $i=0;
								 foreach($three_array[2] as $thevalue=>$hdn)
								 {
										if (isset($selected[0]) && $thevalue==$selected[0]) $sel="selected=\"selected\""; else	$sel="";					 
										$result.="<option value=\"$thevalue\" $sel>$hdn</option>
										";$i++;
								 }	$result.="</select>
								 "; 							
								 
								 
					break;				
				
		}

		if (isset($not_null) && $not_null==true)
		{
			$result.="<input type=\"hidden\" id=\"verify_{$name}\" name=\"verify_{$name}\" value=\"{$validate}\" />
			";
			if (isset($validateCondition)) //aggiunge il js per disabilitare gli input già validati con js ed eliminare la validazione via php
			$this->removeServerValidation.="if (!{$validateCondition}) {document.getElementById('%frmName%').verify_{$name}.name='';}";
		}	
		
		$result.="</td></tr>";	 		
		//if ($bool) $result.="<br />";	
	
	
		//concatena il tutto perchè nel caso di input array ([]) il codice html si aggiunge di volta in volta agli el dellìarray
		$this->input[$name]['html'].=$result;
		$this->input[$name]['atEnd'].=$at_end;
		$this->input[$name]['validateFunction'].=$validateFunction;
		
		return true;
	}
	

	function buildForm($caption,$class="",$reset=true)
	{
		$fieldList=array();
		foreach($this->input as $v) 
		{		
			if ($v['name']!="") //se è vuoto, è stato aggiunto con addexternalcontent()
				$fieldList[]=preg_replace('/\[.*\]/','',$v['name']); //input hidden coi nomi di tutti gli input usati			
		}

		//:::::::::::::::::::::::::::::creazione del codice del form dall'array input della classe con SCHEDE/GRUPPI e precedenze(AT_END..)		

					
		if ( count($this->tabInfo['elems'])==0 ) //non ci sono schede impostate
		{					
			$firstFormCode="";
			$lastFormCode="";

			$firstValidateCode=""; 
			$lastValidateCode="";

			foreach($this->input as $v)
			{					
				if ($v['atEnd']==false)
				{ 
					$firstFormCode.=$v['html'];		
					$firstValidateCode.=$v['validateFunction'];
				}
				else //aggiungo gli input da mettere alla fine del form
				{
					$lastFormCode.=$v['html'];		
					$firstValidateCode.=$v['validateFunction'];
				}	
			}
			
			$this->result.=$this->tableOpenTag.$firstFormCode.$lastFormCode."</table>";	
			
			$this->validateFunction.=$firstValidateCode.$lastValidateCode; 
	
		}
		else //ci sono schede
		{
			$tabHTML=array();  //ogni elemento dell'array si riempie con il codice html relativo ad una scheda

			if ( $this->tabInfo['mode']=='tabs' ) 
			{
				$switchTabJSCall="switchTab('***'"; //costruisce una volta sola, come stringa, la chiamata alla funzione javascript che scambia le schede
				foreach ($this->tabInfo['elems'] as $tabName=>$x)
					$switchTabJSCall.= ",'".$tabName."'";
				$switchTabJSCall.=",'".$this->tabInfo['mainName']."');";
			}
			
			
			//riempie per prima cosa l'array $tabHTML per una questione di ordinamento delle schede sulla stampa
			$tabHTML[$this->tabInfo['mainName']]='';
			foreach ($this->tabInfo['elems'] as $tabName=>$x)
			$tabHTML[$tabName]="";
			///////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			//>>>>>>>>>>>>>>>>costruzione degli insiemi di strighe prima/dopo per l'html e il codice javascript di validazione
			foreach($this->input as $v)
			{
				$associatedTab=$this->tabInfo['mainName']; //se non modificato indica il nome della scheda di default
				
				foreach ($this->tabInfo['elems'] as $tabName=>$x) //controllo a cosa è associato il campo
				{
					foreach ($x['field'] as $fieldName) //per ogni campo indicato nella tab
					{	
						if ($v['name']==$fieldName
						    ||  ($v['name']{0}=='@' && substr($v['name'],1)==$fieldName)   ) //file
						{
							$associatedTab=$tabName;
							break;
						}
					}	
				}
			
				if ( $this->tabInfo['mode']=='tabs' ) 
				{
					//questo consente di attivare (e focus) la scheda contenente l'input che genera un errore di validazione
					// si sostituisce brutalmente la prima parentesi graffa del blocco di validazione
					$v['validateFunction']=str_replace("{","{".str_replace("***",$associatedTab,$switchTabJSCall),$v['validateFunction']);
				}
				
				if ($v['atEnd']==false)
				{ 
				
					$tabHTML[$associatedTab]['first'].=$v['html'];		
					$tabHTML[$associatedTab]['firstValidate'].=$v['validateFunction']; 
				}
				else //aggiungo gli input da mettere alla fine del form
				{
					$tabHTML[$associatedTab]['last'].=$v['html'];		
					$tabHTML[$associatedTab]['lastValidate'].=$v['validateFunction']; 
				}
				
			}	
			
			//>>>>>>>>>>>>>>aggiunge a this.result i div delle schede/gruppi, imposta la variabile finale di validazione, costruisce il menu selezione schede
			if ( $this->tabInfo['mode']=='tabs' ) 
				$tabMenu="<br />".$this->tabInfo['allLabel'];
			else
				$tabMenu="";
			
			foreach($tabHTML as $tabName=>$x)
			{		
			
			
				if ($tabName==$this->tabInfo['mainName']) //tab di default
				{
					$label=$this->tabInfo['standardLabel'];
					$style="";
				}	
				else
				{
					$label=$this->tabInfo['elems'][$tabName]['label'];
					$style="style=\"display:none\"";
				}	
					
				if ( $this->tabInfo['mode']=='tabs' ) 
				{					
					$tabMenu.="<a href=\"#\" onclick=\"".str_replace("***",$tabName,$switchTabJSCall).";return false;\">".$label."</a>";
					$groupLabel="";
				}
				else //gruppo
				{
					$style=""; //lo forzo a visibile
					$groupLabel="<h3>".$label."</h3>";
				}
				
				  
				$v= "<div id=\"".$tabName."\" {$style}>".
						$groupLabel. 
						$this->tableOpenTag . 
							$tabHTML[$tabName]['first'] . $tabHTML[$tabName]['last'] .
						"</table>
					</div>";
					
				if ($tabName==$this->tabInfo['mainName']) //tab di default - PRIMA
					$this->result=$v;
				else	
					$this->tabInfo['elems'][$tabName]['html']=$v;										
					
								
				$this->validateFunction .= $tabHTML[$tabName]['firstValidate'] . $tabHTML[$tabName]['lastValidate'];	

					
			}
			
			//stampa ordinata in base alla definizione delle schede
			foreach($this->tabInfo['elems'] as $tabName=>$x)
				$this->result.=$x['html'];
			
			
			$this->result =  $tabMenu . $this->result; 
		
		}//		
		//:::::::::::::::::::::::::::::
		// NOTA:
				
		$this->result = $this->formOpenTag . "<div>" . $this->result; //il div contiene TUTTO
			
		
		$this->result.="<input type=\"hidden\" name=\"fieldList\" value=\"".implode(",",$fieldList)."\" />"; //input hidden coi nomi di tutti gli input usati			
		
		$this->validateFunction.=$this->removeServerValidation;
		
		$this->result=str_replace("%frmName%",$this->name,$this->result);
		$this->validateFunction=str_replace("%frmName%",$this->name,$this->validateFunction);
				
		$this->result="
		<script type=\"text/javascript\"> 
		                <!-- 
					    validateFunction_{$this->name}=function () 
						{ 
							{$this->validateFunction}
						 
						 	return true;
						 
						} 
						//--></script> ".$this->result; //questione di estetica del codice
		
		
		if ($class!="") $classAttr="class=\"$class\"";

			$this->result.="<div id=\"{$this->name}_submittab\" style=\"text-align:center;margin-top:".($this->horizSpace*2)."px\">
								<div style=\"height:".($this->horizSpace*2)."px\" ></div>
									<input {$classAttr} type=\"submit\" name=\"{$this->name}_submit\" value=\"$caption\" 
									onclick=\"return validateFunction_{$this->name}()\" onkeypress=\"if (this.event.keyCode!=13) return false; else return validateFunction_{$this->name}()\" /> ";
									if ($reset) $this->result.="
									<input {$classAttr} type=\"reset\" name=\"{$this->name}_reset\" value=\"&nbsp;Reset&nbsp;\" />";
			    $this->result.="
								</div>
							</div><!-- contenitore di tutto  -->
						</form>";
		
		if ($this->focused_field!="") $this->result.="
		<script type=\"text/javascript\">
		
			function focus_it()
			{
				document.getElementById('{$this->focused_field}').focus();
				document.getElementById('{$this->focused_field}').style.border='1px solid #FF0000';
				document.getElementById('{$this->focused_field}_message').style.color='#FF0000';
				document.getElementById('{$this->focused_field}_message').style.paddingTop='6px';
				document.getElementById('{$this->focused_field}_message').style.paddingBottom='6px';
				document.getElementById('{$this->focused_field}_message').innerHTML=\"".str_replace('"',"'",$this->focused_msg)."\";
			}	
			
			//window.onload=new Function (\"focus_it();\");
			focus_it();
		
		</script>";
		
		return $this->result;
	}

	/*
	 *	restituisce un array di 3 elementi che a loro volta contengono un array con un numero di elementi pari rispettivamente a 31 (i giorni), 12 (i mesi), ($end_year-$start_year) (gli anni). Ogni sottoarray contiene come valore l’intestazione del dato che è diversa dalla chiave solo nel caso dei mesi (“11”=>”Novembre”) mentre negli altri casi è uguale (“1984=>”1984”)
	 */
 
	function dateArray($start_year,$end_year)
	{
		$result=array();
		if ($this->lang['languageName']=='english')
		$value=array(""=>"Day");
		else
		$value=array(""=>"Giorno");
		
		for ($i=1;$i<=31;$i++)
		{
			$j=($i<10)?"0$i":$i;
			$value[$j]=$i;
		}
		
		$result[]=$value;
		
		if ($this->lang['languageName']=='english')
		$value=array(""=>"Month");
		else
		$value=array(""=>"Mese");

		for ($i=1;$i<=12;$i++)
		{
			$j=($i<10)?"0$i":$i; 
			
			switch($i)
			{
				case "1":$show=$this->lang['languageName']=='english'?"January":"Gennaio";break;
				case "2":$show=$this->lang['languageName']=='english'?"February":"Febbraio";break;
				case "3":$show=$this->lang['languageName']=='english'?"March":"Marzo";break;
				case "4":$show=$this->lang['languageName']=='english'?"April":"Aprile";break;
				case "5":$show=$this->lang['languageName']=='english'?"May":"Maggio";break;
				case "6":$show=$this->lang['languageName']=='english'?"June":"Giugno";break;
				case "7":$show=$this->lang['languageName']=='english'?"July":"Luglio";break;
				case "8":$show=$this->lang['languageName']=='english'?"August":"Agosto";break;
				case "9":$show=$this->lang['languageName']=='english'?"September":"Settembre";break;
				case "10":$show=$this->lang['languageName']=='english'?"October":"Ottobre";break;
				case "11":$show=$this->lang['languageName']=='english'?"November":"Novembre";break;
				case "12":$show=$this->lang['languageName']=='english'?"December":"Dicembre";break;
			}
			$value[$j]=$show;
		}	
		
		$result[]=$value;
		
		if ($this->lang['languageName']=='english')
		$value=array(""=>"Year");
		else
		$value=array(""=>"Anno");

		for ($i=$start_year;$i<=$end_year;$i++)
		{
			$value[$i]=$i;
		}			
		$result[]=$value;
		
		return $result;		
	}	

}


?>
