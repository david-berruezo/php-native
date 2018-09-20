<?php

/** @author Michele Castellucci <ghiaccio84@gmail.com>  */

/** This class is used to embed the creation procedures of a web HTML text formatter (editor WYSWYG) based on Javascript.<br /><br />
  * <br /><br />
  * The class define the interface to allow the comunication with an HTMLForm class object in the way that the latter can 
  * use whatever HTML text Formatter by having an Extension of this class.
  * <br /><br />
  * ITALIAN:<br /> Questa classe serve ad inglobare le procedure di creazione di un formattatore HTML di testi basato su Javascript.<br /><br />
  * Essa definisce l'interfaccia necessaria per consentire la comunicazione con un oggetto HTMLForm in modo che quest'ultimo possa
  * disporre di formattatore HTML semplicemente avendo a disposizione una estenzione di questa classe.
  *
  *
  *	@author Michele Castellucci <ghiaccio84@gmail.com>
  */
 

abstract class TextEditorContainer
{
	private $initCodePrinted=false;
	
	/** Print the HTML code to allow the formatters on an HTML page doing their work 
	  * (for example an inclusion of javascript file or embedded javascript code).
	  * It is called once by {@link getHTMLInstance} (when the first formatter is printed).
	  * <br /><br />
	  * ITALIAN:<br /> Stampa il codice HTML necessario per il funzionamento dei vari formattatori su una pagina HTML 
	  * (ad esempio inclusione di file javascript).<br />
	  *  Viene richiamato solo una volta da {@link getHTMLInstance} (quando si stampa il primo formattatore)
	  */
	protected function printInitCode()
	{}
	
	/** Call this method every time you need to print an HTML istance of the formatter.<br /><br />
	  * When this method his rewritten due to the inheritance, it is required the following code:
	  * <code>parent::getHTMLInstance($id,$value,$class);</code>
	  * <br /><br />
	  * ITALIAN:<br /> Questo metodo viene richiamato ogni volta che si vuole stampare una istanta HTML del formattatore.<br /><br />
	  *  Quando si riscrive questo metodo è necessario richiamare:
	  *	<code>parent::getHTMLInstance($id,$value,$class);</code>
	  *	
	  *	@param string nome identificativo del formattatore
	  *	@param string valore testuale (HTML) da inserire all'nterno del formattare
	  *	@param string nome della classe del foglio di stile
	  *	@return string codice HTML (ed eventuale javascript) necessario al funzionamento dell'area di testo
	  */
	function getHTMLInstance($id,$value,$class)
	{
		if (!$initCodePrinted)
		{
			$this->printInitCode();
			$initCodePrinted=true;
		}
	}

	/** Set the parameters related to the creation of the formatter instances<br />
	  *
	  * Calling this method is required to print the first instance of the HTML formatter before 
	  * calling {@link getHTMLInstance}.<br />
	  *
	  *  If you wanna get more formatters with differents parameters , this method has to be called everytime
	  *  before calling {@link getHTMLInstance()}.
	  *
      * <br /><br />
	  * ITALIAN:<br /> 	  
	  * Imposta i parametri relativi alla creazione delle instanze del formattatore.<br />
 	  * <br /><br />
	  * Per stampare la prima istanta HTML del formattatore è necessario richiamare questo metodo 
	  * e poi il metodo {@link getHTMLInstance}.<br />
	  *
	  *  Se si vogliono ottenere molte formatters ognuna con diversi parametri, questo metodo dev'essere richiamato 
	  *  ogni volta prima di richiamare {@link getHTMLInstance()}, altrimenti è sufficiente richiamarlo una sola volta.
	  *
	  * @param array An associative array that contain configuration values<br /> 
	  *              For example we can give: <code> $params=array("configParam1"=>true,"configParam2"=>23); </code>
	  *				 Gived array values have to be handled in the redefinition of the method in the extended class.
	  *
	  *              <br /><br />ITALIAN:
	  *              un array associativo in cui sono contenuti i valori per la configurazione<br />
	  *              ad esempio  <code> $params=array("configParam1"=>true,"configParam2"=>23); </code>
	  *				 I valori passati nell'array devono essere gestiti nella ridefinizione di questo metodo nella classe estesa.
	  */
	function setParams($array)
	{}

	/** @return string javascript code needed to prepare the data inside the formatter to be sended via GET or POST before 
	  *							  by the form submit.
	  *                			  <br />ITALIAN: il codice javascript necessario a predisporre i dati presenti nel formattatore 
	  * 							  prima dell'invio via GET o POST effettuato dal form 
	  */
	function getSaveInstructions($id)
	{}

	/** @return string a javascript boolean condition (without;) that will be placed inside a javascript IF instruction
	  *				   to test if the formatter is empty.<br />This is necessary for required fields validation.	
	  *                <br />ITALIAN: Una condizione booleana javascript (senza ;) che sarà inserita dentro una istruzione IF 
	  *				   per controllare se il formattatore è vuoto.<br /> Questo è necessario per la validazione dei campi obbligatori
	  */
	function getIsEmptyCondition($id)
	{}
}

?>