<?php

/** @author Michele Castellucci <ghiaccio84@gmail.com>  */



/** This class allows to manage the operation on a MYSQL database, building a graphic interface
  * in automatic manner (a way like to phpMyAdmin) with a * great range of configurations. <br />
  * 
  * Essentially, the data an object DBNavigator can work on, are indicated with a normal query SQL.
  * Throught a <b> testual scanning of the query</b>, are pointed out the involved tables, the data types
  * of the selected fields and the eventual relations between fields of differentes tables (joined by JOIN).
  *
  * Other information which are not directly locatabled by the databes structure can be pointed out
  * by using {@link setMailField()} , {@link setFileField()} , {@link setImageField()} ,
  * {@link setPasswordField()},  {@link setNumericStringField()} and  {@link setMonthYearField()} methods.
  * <br /><br /> 
  * 
  * The HTML contents automatically generated can be graphically personalized by creating
  * your own papers in CSS style and associating
  * the styles using function {@link setTableRowStyle()} , {@link setTableCellStyle()}, {@link setTableBorderStyles()} 
  * ,{@link addTableContainer()} and {@link setClassForFormInput()}	.
  * <br /><br />
  * 
  * You can choose to open the AJAX form through the {@link useAjax()} method to obtain improvements in the graphic interface
  * related to utilization and speed.
  * <br /><br />
  *
  * The interaction main functionality with DBNavigator database are:
  * <ul>
  *
  * <li> <b>INSERTION/EDITING</b><br /><br />
  * an appropriate form HTML is automatically built including all the necessary  validations
  * of the fields both the server side and the client side (javascript).<br /><br />
  *
  * It is possible to use DBNavigator simply for a single insertion through {@link go_only_for_form()} method
  * (EX: forum registration).
  *
  * Specifying a rescue path, is managed the memorization of generic files or images.
  * Moreover, in the case of image alterations, is automatically shown a preview inside the form.
  *
  * In the case of password, the form will include the additional input for the re-typing. 
  * Those passwords will be memorized using the MD5 coding.
  *
  *  Gaining access to the object{@link HTMLForm} member of DBNavigator through the method {@link getEditForm()}, 
  *  it is possible <b>to further personalize ulteriormente the form HTML</b>.<br /> 
  *  For example you can add to the form a simple  anti-hacking verifying code(<b>immagine CAPTCHA</b>)<br />
  *  otherwise to replace the format HTML of default with another as long as that you will incorporate that format in a class PHP 
  *  that will extend the  abstact class {@link TextEditorContainer} (see the method {@link getEditForm()} for further details).<br /><br />
  *
  * Simultaneus alterations made by some  users are blocked through a simple workings of <b>mutua esclusione</b> on the record.
  *  <br /><br />
  *
  *	 MYSQL FIEDS ON HTML EDIT INTERFACE<br /><br />
  *  Here it is a mapping between MySql fields and HTML inputs binded in an automatic way during the building process of edit interface:<br /><br />
  *  <ul>
  *  <li>CHAR/VARCHAR : text input. On this field can be used
  *						{@link setMailField()} , {@link setFileField()} , {@link setImageField()} ,
  * 				    {@link setPasswordField()},  {@link setNumericStringField()}.</li>
  *  <li>DATE : 3 select input (day, month, year). On this field can be used {@link setMonthYearField()}</li>
  *  <li>INT/BIGINT : text input with validation check about integer number format</li>
  *  <li>DOUBLE : text input with validation check about double number format</li>
  *  <li>ENUM : radio input or select input if there are many possible values</li>
  *  <li>SET : checkboxes or select input with multiple choose if there are many possible values</li>
  *  <li>TEXT/TINYTEXT : textarea input</li>
  *  <li>MEDIUMTEXT/LONGTEXT : HTML formatter. See {@link getEditForm()} to change the default.</li>
  *  <li>EXTERNAL KEYS WITH INTEGER TYPE: select input that allow to choose one record of the externat table</li>
  *  </ul>
  *  <br /><br />
  *  
  *  </li>
  *
  * <li> <b>DISPLAYING </b><br /><br />
  * the subject matter of the selected field is shown through an HTML table or in a way completely definable by the class user.
  * 
  * You can choose to enable or not the possibility to insert ({@link canInsert()}), alterate ({@link canEdit()}) 
  * or eliminate elements. In this case the necessary interface is added to the table.
  *
  * Using the standard table visualization, it is possible to add special additional line through functions
  * {@link addDataCol()}, {@link addLinkCol()}, {@link addFreeCol()} and {@link addSwitchCol()}.<br /> 
  * It is important the function {@link addLinkCol()} to allow to link every record to an inside page where are managed data related
  * to that single record. Typical is the example where the inside page uses another DBNavigator to manage data memorized in the database
  * in relation 1 a n.
  *
  * In table form, the web page user can order data in growing or  decreasing form for each visualized field.
  * The default disposition has not to be indicated in the query but through the {@link setDefaultOrd()} method.
  * <br /><br /> 
  * </li>
  *
  * <li> <b>SPECIAL ACTIONS </b><br /><br />
  * Through the form {@link canMultipleEditDelete()} can be enabled the possibility to make special actions.<br />
  * These actions are based on the general table of visualization, which will include the checkbox (checkbox) for an underwhole selection
  * of the visualized elements.<br /><br />
  *
  * The <b>elimination of the party</b>  allows to eliminate in a single step all the selected.<br />
  * The <b>modification sequential</b> allows to alterate one by one the selected elements,
  * without choosing the following one at each modification.<br />
  * The <b>modification simultaneous</b> is very special action which allows to alterate only some fields selected by the user.
  * The alteration of these fields is made on the elements previously selected.
  * <br /><br />
  * </li>
  *
  * <li> <b>DATA SEARCHS</b><br /><br />
  * 
  * The class owns a mechanism which allows to define some fields such as searching fields using
  * the method {@link setSearchField()}.<br /><br />
  *
  * Using the information proceeds from the <b>textual scanning of the initial query</b>, is
  * automatically set up the graphic interface in the way to let the user make a search
  * with the suitable checks, based on the type of the field to be searched.<br /><br />
  * 
  * For researches on textual fields, the search field is furnished with a useful system of automatic auto-finishing
  * based on Ajax (<b>AJAX based auto-complete suggestions</b>).<br />
  * this way are suggested the texts limited in the database to make researches easier and faster.    *  <br /><br />
  *
  * Another additional functionality is related to the exportation of data which can be applied to the entire set of data or
  * to an underwhole locked up by researching criteria.<br />
  * Data can be exported in CSV format simple or in format
  * <b>XML compatible with the browsing by Microsoft Excel ed OpenOffice Calc</b>.
  *
  * </li>
  * </ul>
  *   
  *  <br /><br />
  *  <b>REQUIRED METHODS</b><br /><br />
  *  The class is started up with the method {@link go()} or with {@link go_only_for_form()}<br /><br />
  *
  *  The compulsory and necessary method to be recalled is {@link setPrimaryTable()}.<br />
  *  For the method {@link go()} is <b>compulsory to recall</b> also methods {@link setDefaultOrd()} and {@link setRowName()}.<br /> 
  *	 Besides if you use methods {@link setImageField()} and/or {@link setFileField()} is compulsory to recall {@link setFilePath()}.
  *
  *	<br /><br /><b>MIND OUT!</b> ________________________________________________________________<br />
  * The class need a PHP version 5 configurated within <b>magic_quotes_gpc = On</b>.<br />
  * If you can't have it, try <code>ini_set("magic_quotes_gpc" , "On");</code> 
  * in every script that is expected to do some database modification using DBNavigator.<br />
  * ________________________________________________________________________________<br /><br /><br />
  *
  * 
  *
  * <br /><br />*************************** <b>ITALIAN DOC.</b>***************************<br />
  *
  *
  * Questa classe consente di gestire le operazioni su di un database MYSQL, costruendo un'intefaccia grafica 
  * in modo automatico (in modo simile a phpMyAdmin) con 	una  vasta gamma di configurazioni.<br />
  *
  * Fondamentalmente, i dati su cui può lavorare un oggetto DBNavigator, vengono indicati tramite una normale query SQL.
  * Attraverso una <b>scansione testuale della query</b>, vengono rilevate le tabelle coinvolte, i tipi dei 
  * dati dei campi selezionati e le eventuali relazioni tra i campi di tabelle diverse (unite da un JOIN).
  *
  * Altre informazioni non reperibili direttamente dalla struttura del database possono essere indicate 
  * tramite i metodi {@link setMailField()} , {@link setFileField()} , {@link setImageField()} ,
  * {@link setPasswordField()},  {@link setNumericStringField()} e  {@link setMonthYearField()}.
  * <br /><br />
  *
  * I contenuti HTML generati automaticamente possono essere personalizzati graficamente tramite creando 
  * i propri fogli di stile CSS ed associando 
  * gli stili tramite le funzioni {@link setTableRowStyle()} , {@link setTableCellStyle()}, {@link setTableBorderStyles()} 
  * ,{@link addTableContainer()} e {@link setClassForFormInput()}	.
  * <br /><br />
  *	
  *	Si può scegliere di attivare la modalità AJAX attraverso il metodo {@link useAjax()} per ottenere miglioramenti dell'interfaccia grafica 
  * in termini di usabilità e velocità.
  * <br /><br />
  *
  * Le funzionalità principali di interazione con il database di DBNavigator sono:
  * <br /><br />
  * <ul>
  *
  * <li> <b>INSERIMENTO/MODIFICA</b><br /><br />
  *  viene costruito automaticamente un form HTML appropriato con incluse le necessarie validazioni 
  *  dei campi sia lato server che lato client (javascript).<br /><br />
  *  
  *	 E' possibile usare	DBNavigator semplicemente per un inserimento singolo attraverso il metodo {@link go_only_for_form()} 
  *  (ES: registrazione ad un forum).<br /><br />
  *
  *  Specificando un path di salvataggio, viene gestita la memorizzazione di file generici o immagini.
  *  Inoltre nel caso di modifiche ad immagini, viene automaticamente mostrata una preview all'interno del form.<br /><br />
  *
  *	 Nel caso di password, il form conterrà l'input aggiuntivo per la ri-digitazione. Tali passord verranno memorizzate 
  *  utilizzando la codifica MD5.<br /><br />
  *
  *  Accedendo all'oggetto {@link HTMLForm} membro di DBNavigator tramite il metodo {@link getEditForm()}, 
  *  è possibile <b>personalizzare ulteriormente il form HTML</b>.<br /> 
  *  Ad esempio si può aggiungere al form un semplice codice di verifica anti-hacking (<b>immagine CAPTCHA</b>)<br />
  *  oppure sostituire il formattatore HTML di default con un altro a patto che si inglobi tale formattatore in una classe PHP 
  *  che estenda la classe astratta {@link TextEditorContainer} (si veda il metodo {@link getEditForm()} per ulteriori dettagli).<br /><br />
  *
  *  Modifiche simultanee da parte di più utenti vengono bloccate attraverso un semplice meccanismo di <b>mutua esclusione</b> sui record.
  *  <br /><br />
  *
  *	 CAMPI MYSQL SU INTERFACCIA HTML DI MODIFICA<br /><br />
  *  Ecco una corrispondenza tra i campi MySql ed i controlli HTML automaticamente associati nella costruzione dell'interfaccia di modifica:<br /><br />
  *  <ul>
  *  <li>CHAR/VARCHAR : text input. Su questo tipo di campo è possibile usare 
  *						{@link setMailField()} , {@link setFileField()} , {@link setImageField()} ,
  * 				    {@link setPasswordField()},  {@link setNumericStringField()}.</li>
  *  <li>DATE : 3 select input (giorno,mese,anno). Su questo tipo di campo è possibile usare {@link setMonthYearField()}</li>
  *  <li>INT/BIGINT : text input con validazione di controllo per il formato numero intero</li>
  *  <li>DOUBLE : text input con validazione di controllo per il formato numero con virgola</li>
  *  <li>ENUM : radio input oppure select input se i valori possibili sono molti</li>
  *  <li>SET : checkboxes oppure select input a scelta multipla se i valori possibili sono molti</li>
  *  <li>TEXT/TINYTEXT : textarea input</li>
  *  <li>MEDIUMTEXT/LONGTEXT : formattatore HTML. Vedere {@link getEditForm()} per cambiare qullo di default </li>
  *  <li>CHIAVI ESTERNE DI TIPO NUMERICO: select input che consentira di scegliere uno dei record della tabella esterna</li>
  *  </ul>
  *
  *	 <br /><br />	 
  *  </li>
  *
  *
  * <li> <b>VISUALIZZAZIONE </b><br /><br />
  * Viene mostrato il contenuto dei campi selezionati attraverso una tabella HTML oppure 
  * in maniera completamente definibile dall'utente della classe.<br /><br />
  *  
  * Si può scegliere di abilitare o meno la possibilità di inserire ({@link canInsert()}), modificare({@link canEdit()}) 
  * o eliminare ({@link canDelete()}) elementi. In questo caso viene aggiunta alla tabella l'interfaccia necessaria.<br /><br />
  * 
  * Usando la visualizzazione tabellare standard, è possibile aggiungere delle colonne speciali aggiuntive tramite le funzioni
  * {@link addDataCol()}, {@link addLinkCol()}, {@link addFreeCol()} e {@link addSwitchCol()}.<br />
  * E' importante la funzione {@link addLinkCol()} per permettere di linkare ogni record ad una pagina interna in cui si gestiscono dati relativi 
  * a quel singolo record. Tipico è esempio in cui la pagina interna usa un altro DBNavigator per poter gestire dati memorizzati nel database
  * in relazione 1 a n.<br /><br />
  *
  *
  * In modalità tabellare, l'utente della pagina web ha la possibilità di ordinare i dati in modalità crescente o decescente per ogni campo visualizzato.
  * L'ordinamento di default non deve essere indicato nella query ma attraverso il metodo {@link setDefaultOrd()}
  * <br /><br />
  * </li>
  *
  * <li> <b>AZIONI SPECIALI </b><br /><br />
  * Tramite il metodo {@link canMultipleEditDelete()} può essere abilitata la possibilità di compiere azioni di speciali.<br />
  * Queste azioni si basano sulla tabella generale di visualizzazione, che conterrà delle caselle di scelta (checkbox) per la selezione di un sottoinsieme
  * degli elementi visualizzati.<br /><br />
  *
  * L' <b>eliminazione di gruppo</b> permette di eliminare in solo passo tutti gli elementi selezionati.<br />
  * La <b>modifica sequenziale</b> permette di modificare uno alla volta gli elementi selezionati, 
  * senza dover scegliere il successivo ad ogni modifica.<br />
  * La<b> modifica simultanea</b> è un'azione molto particolare che permette di modificare solo alcuni campi scelti dall'utente. 
  * La modifica di questi campi viene effettuata sugli elementi selezionati in precedenza.
  * <br /><br />
  * </li>
  *
  * <li> <b>RICERCHE TRA I DATI</b><br /><br />
  * 
  * La classe possiede un meccanismo che permette di definire alcuni campi  come campi di ricerca utilizzando
  * il metodo {@link setSearchField()}.<br /><br />
  *
  * Utilizzando le informazioni ricavate dalla <b>scansione testuale della query</b> iniziale, viene 
  * predisposta automaticamente l'interfaccia grafica in modo tale da consentire all'utente di effettuare una ricerca 
  * con gli adeguati controlli, in base al tipo di campo da ricercare.<br /><br />
  *
  * Per ricerche su campi testuali, il campo di ricerca viene corredato da un'utile sistema di auto-completamento automatico 
  * basato su Ajax (<b>AJAX based auto-complete suggestions</b>).<br />
  * Vengono così suggeriti i testi che sono contenuti nel database per facilitare e velocizzare le ricerche.    *  <br /><br />
  *
  * Un'altra funzionalità aggiuntiva riguarda l'esportazione dei dati che può essere applicata all'intero set di dati oppure 
  * ad un sottoinsieme vincolato da parametri di ricerca.<br />
  * I dati possono essere esportati in formato CSV semplice oppure in formato 
  * <b>XML compatibile per la lettura da parte di Microsoft Excel ed OpenOffice Calc</b>.
  *
  * </li>
  * </ul>
  *
  *  <br /><br />
  *  <b>METODI NECESSARI</b><br /><br />
  *  La classe viene attivata col metodo {@link go()} oppure con {@link go_only_for_form()}<br /><br />
  *
  *  Il metodo obbligatoriamente necessario da richiamare è {@link setPrimaryTable()}.<br />
  *  Per il metodo {@link go()} è <b>obbligario richiamare</b> anche i metodi {@link setDefaultOrd()} e {@link setRowName()}.<br /> 
  *	 Inoltre se si usano i metodi {@link setImageField()} e/o {@link setFileField()} è obbligatorio richiamare {@link setFilePath()}.
  *  
  *
  *
  *	<br /><br /><b>NOTA IMPORTANTE</b> ____________________________________________________________<br />
  * La classe ha bisogno di PHP versione 5 configurata con <b>magic_quotes_gpc = On</b>.<br />
  * If you can't have it, try <code>ini_set("magic_quotes_gpc" , "On");</code> 
  * in every script that is expected to do some database modification using DBNavigator.
  * _________________________________________________________________________________<br /><br /><br /> 
  *   
  *  @author Michele Castellucci <ghiaccio84@gmail.com> 
  */	
		
	

class DBNavigator
{


	/// ------ INSTANCE VARIABLES  ------ ///


	/** La query SQL di costruzione della classe
	  * @var string */ 
	private $query="";
	
	/** Il nome della tabella principale tra quelle presenti nella query SQL di costruzione
	  * @see setPrimaryTable
	  * @var string */ 
	private $originalPrimaryTable="";
	
	/** Il nome dell'alias della tabella principale
	  * @see setPrimaryTable
	  * @var string */ 
	private $primaryTable="";
	
	/**  Il nome della chiave primaria della tabella principale 
	  *  @var string */ 
	private $originalPrimaryKey="";
	
	/**  Il nome dell'alias (definito dalla query) della chiave primaria della tabella principale 
	  *  @var string */ 
	private $primaryKey="";
	
	/**  Il nome generico singolare di ogni riga della tabella
	  *  @see setRowName()
	  *  @var string */ 
	private $rowName="";
	
	/**  Informazioni sull'ordinamento: ordinamento di default, ordinamento corrente, desc corrente
	  *  da applicare alla query
	  *  @see setDefaultOrd()
	  *  @var string */ 
	private $orderInfo=array();
	
	/**  Contiene le definizioni dei campi della/e tabella/e richiamate dalla query
	  *  @see scanTable()
	  *  @var array */ 
	private $field=array();
	
	/**  Contiene informazioni sui campi di altre tabelle collegati alla tabella principale
	  *  @see scanTable()
	  *  @var array */ 
	private $externalData=array();
	
	/**  Contiene i nomi dei campi della tabella principale impostati come indirizzi email.
	  *  A tali campi verrà applicata una validazione Javascript e PHP nel form generato in fase di modifica/inserimento
	  *  @see setMailField()
	  *  @var array */
	private $mailField=array();
	
	/**  Contiene i nomi dei campi della tabella principale impostati come password.
	  *  A tali campi verrà applicata una validazione Javascript e PHP nel form generato in fase di modifica/inserimento
	  *  @see setPasswordField()
	  *  @var array */
	private $passwordField=array();
	
	/**  Contiene i nomi dei campi della tabella principale impostati come immagini
	  *  A tali campi verrà applicata una validazione Javascript e PHP nel form generato in fase di modifica/inserimento
	  *  Essa consente in particolare di inserire solo file GIF, JPG, PNG
	  *  @see setPhotoField()
	  *  @var array */
	private $photoField=array('_Resize_'=>"","_KeepOriginal_"=>"");
	
	/**  Contiene i nomi dei campi della tabella principale impostati come file
	  *  A tali campi verrà applicata una validazione Javascript e PHP nel form generato in fase di modifica/inserimento
	  *  @see setPhotoField()
	  *  @var array */
	private $fileField=array();
	
	/**  Contiene il percorso relativo della directory in cui salvare immagini e file
	  *  @see setFilePath()
	  *  @var string */
	private $filePath="";
	
	/**  Contiene il codice esadecimale del colore da applicare come sfondo all'intestazione della tabella di visualizzazione dei dati
	  *  @see setTableRowStyle()
	  *  @var string */
	private $tableHeaderCSS="";
	
	/**  Contiene il codice esadecimale del colore da applicare come sfondo al corpo della tabella di visualizzazione dei dati
	  *  @see setTableRowStyle() 
	  *  @var string */
	private $tableRowContentCSS="";
	
	/**  Valore di margin (cellspacing) della tabella di visualizzazione dati
	  *  @see setTableCellSpacing() 
	  *  @var int */
	private $tableCS=3;
	
	/**  Indica se mostrare o meno la chiave primaria della tabella principale
	  *  @see hidePrimaryKey()
	  *  @var boolean */ 
	private $hidePrimaryKey=false;
	
	/** Indica se e' consentito eliminare record dalla tabella
      * Questa variabile può essere un array che indica gli id dei record di cui è consentita l'eliminazione	
	  * @see canDelete(),canEditDelete(),canMultipleEditDelete(),canInsert()
	  * @var boolean */ 
	private $canDelete=false;
	
	/** Indica se e' consentito modificare record dalla tabella
      * Questa variabile può essere un array che indica gli id dei record di cui è consentita la modifica
	  * @see canDelete(),canEditDelete(),canMultipleEditDelete(),canInsert()
	  * @var boolean */ 
	private $canEdit=false;
	
	/** Indica se e' consentito inserire record nella tabella
	  * @see canDelete(),canEditDelete(),canMultipleEditDelete(),canInsert()
	  * @var boolean */ 
	private $canInsert=false;
	
	
	/** Indica se e' consentito visualizzare i record dalla tabella per la stampa
	  * Se abilitata, viene stampato aggiunto un tasto che apre una nuova finestra contenente i soli dati del record. 
	  * @see canEdit(),canEditDelete()
	  * @var boolean */ 
	private $canViewForPrint=false;
	
	
	/**  Contiene un array contenente i nomi delle 4 classi del foglio di stile da applicare a link e celle della tabella
	  *  1) classe CSS per le celle 'normali' contenenti dati
	  *  2) classe CSS per le celle contenenti i tasti di modifica/insermento
	  *  3) classe CSS per le celle della prima riga della tabella contenenti le intestazioni
	  *  4) classe CSS per le celle contenenti i link aggiunti tramite  {@link addLinkCol()}
	  *  @see setTableStyle() 
	  *  @var array */
	private $style=array('TD'=>'','fieldLink'=>'','headerTD'=>'','editDeleteTD'=>'');

	
	/**  Contiene i nomi (gia' inseriti nel tag: class="nome_classe") delle classi del foglio di stile da applicare a link e celle della tabella.
	  *  @see setTableStyle(),$style 
	  *  @var array */
	private $classTag=array('TD'=>'','fieldLink'=>'','headerTD'=>'','editDeleteTD'=>'');
	
	/**  Contiene un array dove ogni elemento è un array contenete informazioni sulle colonne link aggiuntive 
	  *  stampate nella tabella di visualizzazione dati aggiunte con {@link addLinkCol()}.
	  *  Ad esempio se il link apre una nuova pagina, mantiene gli argomenti GET o viene determinato solo su determinate condizioni
	  *  @see addDataCol(),addLinkCol(),addFreeCol(),addSwitchCol()
	  *  @var array */ 
	private $linkCol=array();

	/**  Contiene un array dove ogni elemento corrisponde ad un attributo che ha due possibili valori
	  *  Ogni elemento corrispondente all'attributo possiede a sua volta informazioni sulle due immagini da associare ai due valori sull'interfaccia.
	  *  @see addDataCol(),addLinkCol(),addFreeCol(),addSwitchCol()
	  *  @var array */ 
	private $switchCol=array();
	
	/**  Contiene un array dove ogni elemento è un array contenente informazioni sulle colonne di dati aggiuntive 
	  *  stampate nella tabella di visualizzazione dati aggiunte con {@link addDataCol()}.
	  *  @see addDataCol(),addLinkCol(),addFreeCol(),addSwitchCol()
	  *  @var array */ 
	private $dataCol=array();
	
	/**  Contiene un array dove ogni elemento è un array contenente informazioni sulle colonne "libere" aggiuntive 
	  *  stampate nella tabella di visualizzazione dati aggiunte con {@link addFreeCol()}.
	  *  @see addDataCol(),addLinkCol(),addFreeCol(),addSwitchCol()
	  *  @var array */ 
	private $freeCol=array();
	
	/**  Contiene i nomi dei campi da rimuovere nel form di inserimento/modifica.
	  *  tali campi non potranno quindi essere modificati/inseriti
	  *  @see removeInput()
	  *  @var array */ 
	private $removeInput=array();
	
	/**  Contiene i nomi dei campi da rimuovere nella tabella di visualizzazione dati standard
	  *  tali campi non saranno visibili in visualizzazione ma potranno essere modificati/inseriti
	  *  @see removeDisplaying()
	  *  @var array */ 
	private $removeDisplaying=array();
	
	/**  Contiene la lista dei campi definiti come campi di ricerca
	  *  @see setSearchField()
	  *  @var array */ 
	private $searchField=array();
	
	/**  Indica se il form di ricerca è stato stampato o meno
	  *  @see search_form()
	  *  @var boolean */ 
	private $search_form_printed=false;
	
	/**  Contiene informazioni sulla cancellazione di righe ricorsiva e linkata ad un'altra tabella
	  *  @see setDeleteRecursive()
	  *  @var array */ 
	private $deleteRecursive=array();
	
	/**  Contiene una istanza della classe HTMLForm che costruisce il form di inserimento/modifica dei record
	  *  @see DBNavigator(),buildForm()
	  *  @var HTMLForm */ 
	private $editForm;
	
	/**  Contiene i 3 nomi delle classi del foglio di stile da associare agli input dell' HTMLForm
	  *  1) classe CSS per textbox/select 
	  *  2) classe CSS per pulsanti 
	  *  3) classe CSS per textarea e textarea con iframe 
	  *  @see setClassForFormInput()
	  *  @var array */ 
	private $classForFormInput=array("inputs"=>"mini","buttons"=>"mini_btn","textareas"=>"mini_txa");
	
	/**  Contiene l'intestazione indicata manualmente del form di inserimento/modifica
	  *  @see setFormHeading()
	  *  @var string */ 
	private $formHeading="";
	
	/**  Indica se visualizzare tutti i record su una pagina (senza paginazione) o meno
	  *  @see showAllElements()
	  *  @var boolean */ 
	private $showAll=false;
	
	/**  Contiene il percorso delle immagini da usare nella visualizzazione tabellare per i tasti (nuovo,stampa,modifica,elimina)
	  *  e degli script (javascript) necessari per la classe.
	  *  @see setImagesAndScriptsPath(), DBNavigator()
	  *  @var string */ 
	private $imagesAndScriptsPath="";
	
	/**  Indica se è stato già richiamato il metodo scanTable (deve essere richiamato una volta sola)
	  *  @see scanTable()
	  *  @var boolean */ 
	private $tableScanned=false;
	
	/**  Contiene i due valori percentuali della dimensione delle 2 colonne del form di inserimento/modifica
	  *  @see setFormWidth()
	  *  @var array */ 
	private $formWidth=array();
	
	/**  Contiene il numero di righe della tabella considerando anche gli eventuali parametri di ricerca correnti
	  *  @see get_rowsNum(), set_rowsNum()
	  *  @var int */ 
	private $rowsNum;
	
	/**  Contiene le stringhe di testo usate all'interno della classe nella lingua impostata  
	  *  @see setLanguage()
	  *  @var array */ 
	private $lang=array();
	

	/**  Indica il numero di caratteri oltre il quale tagliare il valore di un campo nella visualizzazione tabellare
	  *  @see setTextCutLength()
	  *  @var int */ 	
	private $cutLength=150;

	/**  Indica il numero di default di record per pagina da visualizzare
	  *  @see setResultsPerPage()
	  *  @var int */ 		
	private $resultsPerPage=10;

	/**  Indica se visualizzare record senza effettuare una ricerca
	  *  @see setViewResultWithoutSearch()
	  *  @var boolean */ 		
	private $viewResults=true;

	/**  Indica se visualizzare tutte le opzioni degli input SELECT nel form di ricerca 
	  *  indipendentemente dalla presenza del database di record con quei valori
	  *  @see setViewAllSearchOptions()
	  *  @var boolean */ 	
	private $viewAllSearchOptions=false;

	/**  Raccoglie il codice Javascript che sarà inseritò all'interno del metodo window.onload 
	  *  @var string */ 		
	private $JS_onLoad="";

	/**  Indica se utilizzare la tecnologia AJAX per la navigazione (ordinamento/modifica/inserimento)
	  *  @see useAjax()
	  *  @var boolean */ 		
	private $useAjax=false;				
	
	/** Indica se e' consentita la modifica multipla e la mofica contemporanea dei record 
	  * @see canDelete(),canEditDelete(),canMultipleEditDelete(),canInsert()
	  * @var boolean */ 			
	private $canMultipleEditDelete=true;

	/** Contiene un array di due elementi di cui il primo è la data più bassa disponibile, il secondo la più alta
	  * Le date sono selezionabili nel form di inserimento/modifica per i campi definiti DATE nella tabella del database
	  * @see setDateInterval
	  * @var array */ 				
	private $dateInterval=array();

	/** Contiene un array di due elementi corrispondenti al path assoluto (elemento con chiave 'absolute') 
	  * e relativo (elemento con chiave 'relative') dal quale la textarea HTML (con IFRAME) cerca le immagini da inserire sulla textarea stessa.
	  * @see setHTMLTextareaParams()
	  * @var array */ 			
	private $HTMLTextareaParams=array();


	/** Contiene tutte le condizioni (indicate manualmente) per cui una riga deve essere evidenziata
	  * La condizione è una stringa contenente un'espressione booleana PHP.
	  * @see setHighlighting()
	  * @var array */ 		 	
	private $highlighting=array();
	
	/** Contiene le impostazioni riguardanti gli input radio
	  * @see setRadioSettings()
	  * @var array */ 		 	
	private $radioSettings=array('maxOptions'=>8,'maxOptionsInOneLine'=>3);

	/** Contiene le impostazioni riguardanti le checkbox
	  * @see setCheckboxesSettings()
	  * @var array */ 		 	
	private $checkboxesSettings=array('maxCheckboxes'=>10,'multipleSelectSize'=>15);		

	/** Contiene il nome della funzione aggiuntiva da eseguire alla cancellazione di un record
	  * @see setExtraDeletingFunction()
	  * @var string */ 		 	
	private $extraDeletingFunction='';		
	
	/** Contiene la massima dimensione espressa in pixel che una immagine può avere, per altezza o larghezza, nella visualizzazione generale dei dati
	  * @see setImageScaleDimension()
	  * @var int */ 		 		
	private $imageScaleDim=70;

	/** Contiene un nome che descriva il set di dati considerato
	  * @see setDatasetName()
	  * @var String */ 		 		
	private $datasetName="";

	/** Contiene i valori relativi all'abilitazione/disabilitazione degli elementi appartenenti all'interfaccia di navigazione tra pagine.
	  * @see setPageBrowsing()
	  * @var array */ 	
	private $pageBrowsingConfig=array('bylink'=>true,'byselect'=>true,'selectrpp'=>true,'navigationPanelCSS'=>'');

	/** Contiene i nomi delle classi css che sono abbinati ai div contenitori esterni della tabella di visualizzazione generale dei dati
	  * @see addTableContainer()
	  * @var array */ 	
	private $tableContainer=array();


	/** Contiene i nomi delle classi css che sono abbinati alla celle esterne della tabella (ai bordi)
	  * @see setTableBorderStyles()
	  * @var array */ 	
	private $tableBorderStyle=array();

	/** Contiene un oggetto TextEditorContainer che rappresenta il formattatore di testo HTML usato nei form
	  * @see HTMLForm.setHTMLtextEditor()
	  * @var TextEditorContainer */ 	
	private $HTMLtextEditor=false;
	
	/** Indica se mostrare le preview delle immagini nella tabella generale.  
      * @var boolean */	
	private $imageIcon=false;
	
	
	
	  /// -------------------------------   ///
	 /// ------ INSTANCE METHODS  ------  ///
	/// ------------------------------- ///
	
	/** @return string the name of the table definded as primary <br /><br />ITALIAN:<br /> il nome della tabella definita come primaria */
	function getPrimaryTable() { return $this->originalPrimaryTable; }


	/** Enables or closes down the visualization of the elements belonging to the interface of navigation between pages 
	  * 
	  * <br /><br />ITALIAN:<br /> 
	  * Abilita o disabilità la visualizzazione degli elementi appartenenti all'interfaccia di navigazione tra pagine.
	  *
	  * @param bool enables the navigation between pages like a link for each page 
	  *             <br /><br />ITALIAN:<br /> abilita la navigazione tra pagine sotto forma di link per ogni pagina
	  *
	  * @param bool enables the navigation between pages like a square of selection containing all the pages to jump to 
	  *             <br /><br />ITALIAN:<br /> abilita la navigazione tra pagine sotto forma di una casella di selezione contenente tutte le pagine a cui saltare
	  *
	  * @param bool if true enables the selection of results for pages 
	  *             <br /><br />ITALIAN:<br /> abilita la selezione di risultati per pagine
	  *
	  * @param string is the name of the class CSS for the container of all  navigation checks 
	  *               <br /><br />ITALIAN:<br /> nome della classe CSS per il contenitore di tutti i controlli di navigazione
	  */ 	
	function setPageBrowsingConfig($bylink,$byselect,$selectrpp,$navigationPanelCSS='')
	{
		$this->pageBrowsingConfig=array('bylink'=>$bylink,'byselect'=>$byselect,'selectrpp'=>$selectrpp,'navigationPanelCSS'=>$navigationPanelCSS);	
	}
	


	/** Comes back the class that builds the form HTML.<br />
	  * This method can be used to modify the behaviour of that object.<br />
	  * For example you can add a CAPCTHA code<br />
	  * <code> $DBNavigator->getEditForm()->addVerificationCode().</code> <br />
	  * or modify the class wich builds the test format
	  * <code> $DBNavigator->getEditForm()->setHTMLtextEditor(new MY_HTML_FORMATTER_CLASS()).</code> <br />
	  * MY_HTML_FORMATTER_CLASS must upgrade the interface {@link TextEditorContainer} 
	  *
	  * <br /><br />ITALIAN:<br /> 
	  * Ritorna la classe che costruisce il form HTML.<br />
	  * Questo metodo può essere usato per modificare il comportamento di tale oggetto.<br />
	  * Ad esempio si può aggiungere un codice CAPCTHA:<br />
	  * <code> $DBNavigator->getEditForm()->addVerificationCode().</code> <br />
	  *	o modificare la classe che costruisce il formattatore testi HTML :<br />
	  * <code> $DBNavigator->getEditForm()->setHTMLtextEditor(new MY_HTML_FORMATTER_CLASS()).</code> <br />
	  * MY_HTML_FORMATTER_CLASS deve implementare l'interfaccia {@link TextEditorContainer} 
	  * 
	  * @see HTMLForm::setHTMLtextEditor(), TextEditorContainer*/ 	
	function getEditForm() 
	{
		return $this->editForm;
	}


	/** Sets up the names of CSS classes to combine to outside cells of the table of data visualization.
	  * This allows to realize a border graphically elaborated to the general table of data.
	  *
	  * <br /><br />ITALIAN:<br /> 
	  * Imposta i nomi delle classi css da abbinare alle celle esterne della tabella di visualizzazione dati. 
	  * Questo consente di realizzare un bordo graficamente elaborato alla tabella generale dei dati.
	  *
	  * @param string CSS class for the left superior corner cell of the table of data visualization 
	  *				  <br /><br />ITALIAN:<br /> classe CSS per la cella dell' angolo superiore sinistro della tabella di visualizzazione dati.
	  *					  
	  * @param string CSS class for cells of the superior corner of the table of data visualization 
	  *               <br /><br />ITALIAN:<br />classe CSS per le celle del bordo superiore della tabella di visualizzazione dati.
	  *
	  * @param string CSS class for the right superior corner cell of the table of data visualization 
	  * 			  <br /><br />ITALIAN:<br /> per la cella dell' angolo superiore destro della tabella di visualizzazione dati.
	  *
	  * @param string CSS class for right border cells of the table of data visualization 
	  * 			  <br /><br />ITALIAN:<br /> per le celle del bordo destro della tabella di visualizzazione dati.
	  *
	  * @param string CSS class for the right inferior corner cell of the table of data visualization 
	  * 	          <br /><br />ITALIAN:<br /> per la cella dell' angolo inferiore destro della tabella di visualizzazione dati.
	  *
	  * @param string CSS class for inferior berder cells of the table of data visualization 
	  *				  <br /><br />ITALIAN:<br /> per le celle del bordo inferiore della tabella di visualizzazione dati.
	  *
	  * @param string CSS class for the left inferior border cell of the table of data visualization 
	  *				  <br /><br />ITALIAN:<br /> per la cella dell' angolo inferiore sinistro della tabella di visualizzazione dati.
	  *
	  * @param string CSS class for left border cells of the table of data visualization 
	  *				  <br /><br />ITALIAN:<br /> per le celle del bordo sinistro della tabella di visualizzazione dati. 
	  */ 		
	function setTableBorderStyles($topsx,$top,$topdx,$dx,$botdx,$bot,$botsx,$sx)
	{
		$this->tableBorderStyle['topsx']=$topsx;
		$this->tableBorderStyle['top']=$top;
		$this->tableBorderStyle['topdx']=$topdx;
		$this->tableBorderStyle['dx']=$dx;
		$this->tableBorderStyle['botdx']=$botdx;
		$this->tableBorderStyle['bot']=$bot;
		$this->tableBorderStyle['botsx']=$botsx;
		$this->tableBorderStyle['sx']=$sx;
	}	   	



	/** Adds a div container for the table of general data visualization. 
	  * This container can be added to beauty purposes to apply with properties CSS.
	  *
	  * <br /><br />ITALIAN:<br /> 
	  * Aggiunge un div contenitore per la tabella di visualizzazione generali dei dati.
	  * Questo contenitore può essere aggiunto per finalità estetiche da applicare con proprietà CSS.
	  *  
	  * @param string the name of the CSS class to combine to div container. 
	  *			      <br /><br />ITALIAN:<br /> il nome della classe CSS da abbinare al div contenitore.
      */ 		
	function addTableContainer($cssclass)
	{
		$this->tableContainer[]=$cssclass;
	}	   		

	/** Enables or closes down the visualization of elements which compose the navigation interface related to the breakdown into pages of the elements 
	  *
	  * <br /><br />ITALIAN:<br /> 
	  * Abilita o disabilita la visualizzazione degli elementi che compongono l'interfaccia di navigazione relativa alla suddivisione in pagine degli elementi.
	  *
	  * @param boolean enables/closes down the visualization of page choice through link 
	  *				    <br /><br />ITALIAN:<br /> abilita/disabilita la visualizzazione della scelta pagine tramite link
	  *
	  * @param boolean enables/closes down the visualization of page choice through a selection square 
	  *                <br /><br />ITALIAN:<br /> abilita/disabilita la visualizzazione della scelta pagine tramite casella di selezione
	  *
	  * @param boolean enables/closes down the visualization of the choice of the number of results for page 
	  *                 <br /><br />ITALIAN:<br /> abilita/disabilita la visualizzazione della scelta del numero di risultati per pagina
      */ 		
	function setPageBrowsing($byselect,$bylink,$selectrpp)
	{
		$this->pageBrowsingConfig['byselect']=$byselect;
		$this->pageBrowsingConfig['bylink']=$bylink;
		$this->pageBrowsingConfig['selectrpp']=$selectrpp;
	}	   		


	/** Sets up a name which identify the data set considered.
	  * That value is actually used to build the {@link PageNavigator} embedded object.
	  *
	  * <br /><br />ITALIAN:<br />
	  * Imposta un nome identificativo del set di dati considerato. 
	  * Tale valore è attualmente utilizzato per la costruzione dell'oggetto interno {@link PageNavigator}.
	  *
	  * @param String name to identify, and for example students, products, invoices, books, etc. 
	  *				  <br /><br />ITALIAN:<br /> nome identificativo, ed esempio studenti, prodotti, fatture, libri ecc.
	  */ 		
	function setDatasetName($val){$this->datasetName=$val;}	   		


	/** 
	  * @param int represents the maxim pixel dimension with which an image is shownin preview in the table of visualization of general data <br />
	  *            The image is therefore  visualized in the way to be contained in a square box of this dimension: <br />
	  *            The biggest dimension of the image takes up the indicated value while the other one is proportionally browsed.
	  *
	  *			   <br /><br />ITALIAN:<br /> 
	  *			   rappresenta la massima dimensione in pixel con cui una immagine viene mostrata in preview nella tabella visualizzazione generale dei dati.<br />
	  *            L'immagine viene quindi visualizzata in modo da essere contenuta in un box quadrato di questa dimensione: <br />
	  *            la dimensione più grande dell'immagine assume il valore indicato mentre l'altra viene scalata in modo proporzionale. 
	  */ 		
	function setImageScaleDimension($val){$this->imageScaleDim=$val;}	   		


	/**  @param function the name of a function to be performed at the record cancellation and applied on the same record 
	  *				     This way to act is equivalent to a trigger SQL of type ON DELETE. <br />
	  *                  The function must accept a parameter conaining an associative array (obtained from mysql_fetch_array()) 
	  *                  containing the record fields to be deleted.
	  *					 <br /><br />ITALIAN:<br /> 
	  *					 il nome di una funzione da eseguire alla cancellazione di un record e applicata sul record stesso.<br />
	  *         		 Questo modo di agire è acquivalente ad un trigger SQL di tipo ON DELETE. <br />
	  *                  La funzione deve accettare un parametro contenente un array associativo (ricavato da mysql_fetch_array()) 
	  *					 contenente i campi del record da cancellare.
      */ 	
	function setExtraDeletingFunction($function){$this->extraDeletingFunction=$function;}	


	/**  @param boolean Enable or disable the using of Ajax technology for data browsing
	  *                 <br /><br />ITALIAN:<br /> Abilita o meno l'utilizzo della tecnologia AJAX per la navigazione tra i dati */ 	
	function useAjax($bool){$this->useAjax=$bool;}	

	/** Sets up the parameters to go to class {@link TextEditorContainer}.
	  *
	  * <br /><br />ITALIAN:<br /> 
	  * Imposta i parametri da passare alla classe {@link TextEditorContainer} (textarea HTML) 
	  *
	  * @param mixed it depends on the {@link TextEditorContainer} object used. See the doc. for default class (AdvTextarea): {@link Adv_TextArea::setParams()}
	  *              <br /><br />ITALIAN:<br /> 
	  *              dipende dall'oggetto {@link TextEditorContainer} usato. Vedere la doc. per la classe di default (AdvTextarea): {@link Adv_TextArea::setParams()}
	  *  
	  * @see Adv_TextArea::setParams(), TextEditorContainer::setParams()
	  */ 		
	function setHTMLTextareaParams($arr){ $this->HTMLTextareaParams=$arr; }


	/**  @param int number of default of elements for page to print in the  data visualization 
	  *            <br /><br />ITALIAN:<br /> numero di default di elementi per pagina da stampare nella visualizzazione dati  */ 	
	function setResultsPerPage($rpp) { $this->resultsPerPage=$rpp; }


	/**  @param string Name of the language to be used for the file texts shown by the class.<br />
	  *                italian and english texts are availavable. Values to be used are 'english' or 'italian' 
	  *                <br /><br />ITALIAN:<br /> 
	  *                Nome della lingua da usare per i di testo mostrati dalla classe.<br />
	  *                sono disponibili testi in italiano e inglese. I valori da usare sono 'english' o 'italian'. */ 	
	function setLanguage($lang)
	{
		$lang=strtolower($lang);		
		$this->lang['languageName']=$lang;

		if ($lang=='english')
		{
			$this->lang['selection']="Selection";
			$this->lang['edit']="Edit";
			$this->lang['delete']="Delete";
			$this->lang['print']="Print";
			$this->lang['reallyDelete']="Really delete this {$this->rowName} ?";
			$this->lang['insertNew']="Insert new {$this->rowName}";	
			$this->lang['searchOn']="Search for {$this->rowName} according to...";
			$this->lang['ifSelected']="If selected";
			$this->lang['selectAll']="Select all";
			$this->lang['unselectAll']="Unselect all";
			$this->lang['reallyDeleteMultiple']="Really delete selected objects ?";	
			$this->lang['editRecord']="Edit data {$this->rowName}";
			$this->lang['backToData']="Back to general data display";		
			$this->lang['editing']="Editing";
			$this->lang['of']="of";
			$this->lang['select']="Select";	
			$this->lang['errorSended']="Information about error have been sended via e-amil to the admin.";	
			$this->lang['errorFileConflict']="Selected file has a name used by another, rename it.";
			$this->lang['errorKeyConflict']="Inserted data is already present in the archive (value must be unique)";
			$this->lang['errorFormatConflict']="Inserted data isn't in the correct format";
			$this->lang['errorWrongVerCode']="Verify code is wrong";
			$this->lang['errorWrongPassword']="Old inserted value is not correct";	
			$this->lang['find']="Find";
			$this->lang['confirmData']="&nbsp;:: Confirm data ::&nbsp;";
			$this->lang['all']="All";
			$this->lang['noImage']="No image";
			$this->lang['noFile']="No file";
			$this->lang['current']="Current";		
			$this->lang['noResults']="No results";	
			$this->lang['errorFileTooBig']="Selected file is too big for upload";	
			$this->lang['from']="from";
			$this->lang['to']="to";
			$this->lang['goBack']="Go back";
			$this->lang['warningRecordOccupied']="Warning: another user (administrator) is modifying selected record.<br /><br />
												  Wait on this page for the automatic access to the record or"; 
			$this->lang['ascendingOrder']="Ascending order";
			$this->lang['descendantOrder']="Descendant order";
			$this->lang['multipleEditingHeading']="CONTEMPORARY EDITING FOR *** ELEMENTS";
			$this->lang['fieldEnablingControlHeading']="Uncheck fields that you don't want to edit for selected elements";
			$this->lang['errorAvailability']="One or more selected elements is assigned to another user, retry";
			$this->lang['recordHasBeenDeleted']="This element has been deleted";

			 									  				
		}else
		{
			$this->lang['selection']="Selezione";
			$this->lang['edit']="Modifica";
			$this->lang['delete']="Elimina";
			$this->lang['print']="Stampa";
			$this->lang['reallyDelete']="Eliminare veramente questo/a {$this->rowName} ?";
			$this->lang['insertNew']="Inserisci nuovo/a {$this->rowName}";	
			$this->lang['searchOn']="Ricerca {$this->rowName} in base a...";
			$this->lang['ifSelected']="Se selezionati";
			$this->lang['selectAll']="Seleziona tutti";
			$this->lang['unselectAll']="Deseleziona tutti";
			$this->lang['reallyDeleteMultiple']="Eliminare veramente gli oggetti selezionati ?";	
			$this->lang['editRecord']="Modifica dati {$this->rowName}";
			$this->lang['backToData']="Torna alla visualizzazione generale dei dati";
			$this->lang['editing']="Modifica";
			$this->lang['of']="di";
			$this->lang['select']="Selezionare";
			$this->lang['errorSended']="i dati relativi dell'errore sono stati inviati via mail all'amministratore.";	
			$this->lang['errorFileConflict']="Il file selezionato ha un nome utilizzato da un altro file, rinominarlo";
			$this->lang['errorKeyConflict']="il dato inserito è già presente nell'archivio (il valore deve essere univoco)";
			$this->lang['errorFormatConflict']="il dato inserito non è nel formato corretto";
			$this->lang['errorWrongVerCode']="Il codice di verifica è errato";
			$this->lang['errorWrongPassword']="il vecchio valore inserito non è corretto";			
			$this->lang['find']="Cerca";
			$this->lang['confirmData']="&nbsp;:: Conferma dati ::&nbsp;";		
			$this->lang['all']="Tutti";
			$this->lang['noImage']="Nessuna immagine";
			$this->lang['noFile']="Nessun file";
			$this->lang['current']="Corrente";
			$this->lang['noResults']="Nessun risultato";
			$this->lang['errorFileTooBig']="Il file selezionato è troppo grande per eseguire l'upload";
			$this->lang['from']="da";
			$this->lang['to']="a";
			$this->lang['goBack']="Torna indietro";
			$this->lang['warningRecordOccupied']="Attenzione: Un altro utente (amministratore) sta modificando il record selezionato.<br /><br />
												  Attendi su questa pagina l'accesso automatico al record oppure"; 
			$this->lang['ascendingOrder']="Ordine ascendente";
			$this->lang['descendantOrder']="Ordine discendente";
			$this->lang['multipleEditingHeading']="MODIFICA CONTEMPORANEA A *** ELEMENTI";
			$this->lang['fieldEnablingControlHeading']="Selezionare i campi che si desidera modificare per gli elementi selezionati";
			$this->lang['errorAvailability']="Uno o più dei record selezionati è assegnato ad un altro utente, ritentare";	
			$this->lang['recordHasBeenDeleted']="Questo elemento è stato eliminato";											  
		}
		$this->editForm->setLanguage($this->lang['languageName']);
	}

	  
	/**  Sets up a state which stated lined must be highlighted 
	  *  
	  * <br /><br />ITALIAN:<br /> 
	  * Imposta una condizione per cui determinate righe devono evidenziarsi
	  *
	  *  @param string boolean PHP expression which will be valuted through eval().<br /> 
	  *                In the expression you can refer to the field X of every record with {{{X}}}. For example "{{{status}}}=='active'"     
	  *                
	  *                <br /><br />ITALIAN:<br /> espressione booleana PHP che sarà valutata tramite eval(). <br />
	  *				   Nell'espressione ci si può riferire al campo X di ogni record con {{{X}}}. Ad esempio "{{{status}}}=='active'" 
	  *                This parameter is for example of type: 'class="foo" style="color:#F00"'       
	  *
	  *  @param string string containing the definition of the cells tag (their attributes) which containing 
      *                 data of the element founded to be highlighted in the table of data general visualization
	  *
	  *                <br /><br />ITALIAN:<br /> stringa contenente la definizione dei tag delle celle (i loro attributi) che contengono
	  *         	   i dati dell'elemento rilevato come da evidenziare nella tabella di visualizzazione genrale. 
	  *			       Questo paramentro è ad esempio del tipo: 'class="foo" style="color:#F00"'       
	  */ 	
	function setHighlighting($condition,$TDAttributes) { $this->highlighting[]=array('condition'=>$condition,'TDAttributes'=>$TDAttributes); }
	
	/**  @param string text of heading for the action of 'record modify' in thye table of data visualization 
	  *                <br /><br />ITALIAN:<br /> testo di intestazione per l'azione di 'modifica record' nella tabella di visualizzazione dei dati */
	function setEditColHeading($heading) {$this->lang['edit']=$heading;}
	
	/**  @param string text of heading for the action of 'delete record' in the table of data visualization 
	  *                <br /><br />ITALIAN:<br /> testo di intestazione per l'azione di 'elimina record' nella tabella di visualizzazione dei dati */
	function setDeleteColHeading($heading) {$this->lang['delete']=$heading;}
	
	/**  @param string text of heading for the action of 'print visualization' in the table of data visualization 
	  *         <br /><br />ITALIAN:<br /> testo di intestazione per l'azione di 'visualizzazione per la stampa' nella tabella di visualizzazione dei dati */
	function setPrintColHeading($heading) {$this->lang['print']=$heading;}
	
	/**  @param string text of heading for the action of 'record insertion' 
	  *         <br /><br />ITALIAN:<br /> testo di intestazione per l'azione di 'insermento record */
	function setInsertNewHeading($heading) {$this->lang['insertNew']=$heading;}
	
	/**  @param string text of heading for the box of data research 
	  *                <br /><br />ITALIAN:<br /> testo di intestazione per il box di ricerca dati */
	function setSearchHeading($searchHeading) {$this->lang['searchOn']=$searchHeading;}
	
	/**  @param string entry text shown when the research doesn't get results 
	  *                <br /><br />ITALIAN:<br /> testo sentinella mostrato quando la ricerca non produce risultati */
	function setNoResultString($str) {$this->lang['noResults']=$str;}
	
	/**  Sets up the heading keys of modification/elimination multiple of records in the table of data visualization 
	  *  <br /><br />ITALIAN:<br /> Imposta le intestazione dei tasti di modifica/eliminazione multipla dei record nella tabella di visualizzazione dei dati*/
	function setMultipleEditDeleteHeading($ifSelected,$selectAll,$unselectAll,$alertOnDelete) 
	{
		$this->lang['ifSelected']=$ifSelected;
		$this->lang['selectAll']=$selectAll;
		$this->lang['unselectAll']=$unselectAll;
		$this->lang['reallyDeleteMultiple']=$alertOnDelete;
	}

	/**  @param string text of heading for the action of selection in the table of data visualization 
	  *         <br /><br />ITALIAN:<br /> testo di intestazione per l'azione di selezione nella tabella di visualizzazione dei dati */
	function setActionColumnHeader($str) {$this->lang['actionColumnHeader']=$str;}
		
	
	
	
	/** Sets up the break of selectionable dates in the form of insertion/modification for the fields defined DATE in the table of database 
	  *  <br /><br />ITALIAN:<br /> Imposta l'intervallo di date selezionabili nel form di inserimento/modifica per i campi definiti DATE nella tabella del database
	  *
	  * @param int The lowest date which you want to make available <br /><br />ITALIAN:<br /> La data più bassa che si vuole rendere disponibile 
	  * @param int The higher date you want to make available <br /><br />ITALIAN:<br /> La data più alta che si vuole rendere disponibile  */ 	
	function setDateInterval($bottom,$top)
	{
		$bottomFirst=$bottom{0};
		if ($bottomFirst=="+")
		$this->dateInterval[0]=date("Y")+(int)(substr($bottom,1));
		else
		if ($bottomFirst=="-")
		$this->dateInterval[0]=date("Y")-(int)(substr($bottom,1));
		else
		$this->dateInterval[0]=$bottom;
	
		$topFirst=$top{0};
		if ($topFirst=="+")
		$this->dateInterval[1]=date("Y")+(int)(substr($top,1));
		else
		if ($topFirst=="-")
		$this->dateInterval[1]=date("Y")-(int)(substr($top,1));
		else
		$this->dateInterval[1]=$top;
		
	}
	
	/**  Sets up the two dimension in lenght percentual of the form of record insertion/modification .<br />  
	  *  The sum of the two values must be 100(%) 
	  *  
	  *  <br /><br />ITALIAN:<br /> 
	  *  Imposta le 2 dimensioni in percentuale di larghezza del form di inserimento/modifica record.<br />
	  *  La somma dei due valori deve essere 100(%)  
	  *
	  *  @param int 
	  *  @param int */
	function setFormWidth($w1,$w2) {$this->formWidth=array($w1,$w2);}
	
	/**  @param string text of the 'submit' key present in the formof insertion/modification 
					   <br /><br />ITALIAN:<br /> testo del tasto di 'submit' presente nei form di inserimento/modifica */
	function setConfirmFormMsg($m)
	{
		if ($m!="")
		{
			$this->lang['confirmData']=addslashes(str_replace(array("\r","\n")," ",$m)); //eliminate the return back from the beginning <br /><br />ITALIAN:<br /> elimina ritorni a capo
		}
	}


	/**  @param string alert message of confirmation for a record elimination 
	  *         <br /><br />ITALIAN:<br /> messaggio alert di conferma per l'eliminazione di un record */
	function setAlertOnDelete($alert)
	{
		if ($alert!="")
		{
			$this->lang['reallyDelete']=addslashes(str_replace(array("\r","\n")," ",$alert)); //eliminate the return back from the beginning <br /><br />ITALIAN:<br /> elimina ritorni a capo
		}
	}
	
	/**  Used to obtain a string which describes the actual state of  the class 
	  *  This can be useful to make printing actions or other ones in regard to the actual state of the class
	  *  For example <code> if ($OBJ->status=='inserting') echo 'inserting user message';</code>
	  *
	  *  <br /><br />ITALIAN:<br />
	  *  Serve ad ottenere una stringa che descrive lo stato attuale della classe.<br />
      *  Questo può essere utile per poter effettuare azioni di stampa o altro rispetto allo stato attuale della classe.<br />
	  *  Ad esempio <code> if ($OBJ->status=='inserting') echo 'inserting user message';</code>
	  *
	  *  @return string String containing one of these values: inserting, editing, deleting, editingMany, viewing
	  *                 <br /><br />ITALIAN:<br /> Stringa contenente uno di questi valori: inserting, editing, deleting, editingMany, viewing */
	function status()
	{
	
		$pm='_'.$this->originalPrimaryTable;
		
		if (isset($_GET['edit'.$pm]) && $_GET['edit'.$pm]=="") unset($_GET['edit'.$pm]);//get unused <br /><br />ITALIAN:<br /> inutilizzato
	
		if (isset($_GET['del'.$pm]))	return 'deleting';
	
		
		if (isset($_POST['edit'.$pm]) && $_POST['edit'.$pm]==='0') return 'inserting';
		if (isset($_POST['edit'.$pm]) && $_POST['edit'.$pm]==='1') return 'editing';
		
		if (isset($_GET['edit'.$pm]))
		{
			if ($_GET['edit'.$pm]==='0') return 'inserting';
							else return 'editing';	 
		}
		
		if (isset($_GET['action'.$pm]) && isset($_GET['selected'.$pm]) && count($_GET['selected'.$pm])!=0)
		{
			if ($_GET['action'.$pm]=='editMany') return 'editingMany';
			if ($_GET['action'.$pm]=='edit')     return 'editing';
			if ($_GET['action'.$pm]=='delete')   return 'deleting';
		}
		
		return 'viewing';
	}
	
	
	/** @param string name of the field set up as a password.<br />
	  * 			 The field will be published with two fields during the insertion phase (password repeat password)
	  * 			 and 3 fields during the modification phase (old password, new password, repeat new password). <br />
	  * 			 Besides all this data will be memorized usig the MD5 coding.	
	  *
	  *               <br /><br />ITALIAN:<br /> 
	  *   			  nome del campo impostato come una password.<br /> 
	  *               Il campo sarà editabile con 2 campi in fase di inserimento (password,ripeti password)
	  *               e 3 campi in fase di modifica (vecchia password,nuova password,ripeti nuova password).<br />
	  *                Inoltre questi dati saranno memorizzati usando la codifica MD5.
	  * 
	  */
	function setPasswordField($field) {$this->passwordField[$field]="yes";}
	
	/** @param boolean means if in the visualization table must be visualized all records without paging 
	  *        <br /><br />ITALIAN:<br /> indica se nella tabella di visualizzazione devono essere visualizzati TUTTI i record senza paginazione */ 
	function showAllElements($all=true) {$this->showAll=$all;}
	
	/** @param string heading of the insert/modification form  <br /><br />ITALIAN:<br /> intestazione del form di inserimento/modifica
	  * @param string text of the link on the way back to the table of general data visualization <br /><br />ITALIAN:<br /> testo del link di ritorno alla tabella di visualizzazione generale dei dati */
	function setFormHeading($heading,$backLink="")
	{
		$this->formHeading=$heading;
		$this->lang['backToData']=$backLink==""?$this->lang['backToData']:$backLink;
	}
	

	
	/** sets up a linked and/or recursive deletion for records.<br /><br /> 
	  * His effect can be equivalent to the integrity constraint ON DELETE CASCADE but this method will also delete files, stored in the server,
	  * wich are related to the deleted records.
	  *
	  * <br /><br />ITALIAN:<br />
	  * Imposta la cancellazione linkata e/o ricorsiva dei record.<br /><br />
	  * Il suo effetto può essere ecquivalente al vincolo di integrità referenziale ON DELETE CASCADE ma questo metodo eliminerà anche i file, memorizzati
	  * sul server, che sono collegati ai record eliminati.
	  *
	  *	@param string name of the field with which is considered the autojoin of the main table on itself.
	  *				  <br /><br />ITALIAN:<br />nome del campo con cui si considera l'autojoin della tabella principale su se stessa. 
	  *
	  * @param DBNavigator DBNavigator object where is a join between its own main table 
	  *                    and the main table of DBNavigator on which is recalled this method.
	  *                    For join is meant a join in the costruction query.
	  *					   <br /><br />ITALIAN:<br /> oggetto DBNavigator in cui c'è un join tra la propria tabella principale.
	  * 				   e la tabella principale del DBNavigator su cui si richiama questo metodo. 
	  *                    Per join si intende un join nelle query di costruzione. 
	  *					   
	  * @param string warning message to be visualized when you want to eliminate a record that will cause
	  *               the cancellation of other records because of the application of this method.
	  *               <br /><br />ITALIAN:<br />messaggio di avvertimento da visualizzare quando si vuole eliminare un record che provocherà
	  *               la cancellazione di altri record a causa dell'applicazione di questo metodo. 
	  */
	function setDeleteRecursive($chiave_collegata_a_se_stessa,$DBNavigator_esterno=false,$alert="")
	{
		if ($chiave_collegata_a_se_stessa) $this->deleteRecursive['key'][]=$chiave_collegata_a_se_stessa;
		if ($DBNavigator_esterno) $this->deleteRecursive['DBNavigator'][]=$DBNavigator_esterno;
		if ($alert!="") $this->setAlertOnDelete($alert);
	}
	
	/** @param string name of the field that won't be published in the form of insertion/modification
	  *               <br /><br />ITALIAN:<br /> nome del campo che non potrà essere editato nel form di inserimento/modifica.
	  * @see removeDisplaying() */
	function removeInput($inputName){$this->removeInput[$inputName]="yes";}
	
	/** 
	  * Sets up the fields of the table which musn't be shown in the general data visualization specifying the names.<br />
	  * This method accepts a VARIABLE NUMBER OF ARGUMENTS.
	  *
	  * <br /><br />ITALIAN:<br />
	  * Imposta i campi della tabella che non devono essere mostrati nella visualizzazione generale dei dati specificandone i nomi.<br />
	  * Questo metodo accetta un NUMERO VARIABILE DI ARGOMENTI.
	  */
	function removeDisplaying()
	{
		$arg=func_get_args();
		foreach ($arg as $val)
			if (is_string($val))
				$this->removeDisplaying[$val]="yes";
		
	}
	
	/** @param string name of the field that won't be published in the form multiple modification
	  *               <br /><br />ITALIAN:<br /> nome del campo che non potrà essere editato nel form di modifica multipla. .*/	
	function removeMultipleEditingInput($inputName){$this->removeMultipleEditingInput[$inputName]="yes";}
	
	
	/** 
	  * Set up fields to be search fields, giving their names.<br /><br /> 
	  *
	  * The first parameter is a  string like "tablename.fieldname" while the second (optional or to be left blank)
	  * is a string that specifies the name to be visualized in the search form of search fot that field.
	  * If indicated without the name of the table, the field will be considered relative to an aggregation sql like COUNT(*) AS fieldname
	  * and in researches will be insert between HAVING clauses.<br /><br/>
	  *
	  * This method accept a VARIABLE NUMBER OF ARGUMENTS: the two topics can be repeated in pair
	  * setSearchField(F1a,F1b,F2a,F2b,F3a,....)
      *
	  * <br /><br />ITALIAN:<br />
	  * Imposta i campi come campi di ricerca specificandone i nomi.<br /><br />
	  *
	  * Il primo parametro è una stringa del tipo "nometabella.nomecampo" mentre il secondo (opzionale o da lasciare vuoto) 
	  *	è una stringa che specifica il nome da visualizzare nel form di ricerca per tale campo il campo.
	  *	Se indicato senza il nome della tabella, il campo sarà considerato relativo ad una di aggregazione sql come COUNT(*) AS nomecampo
	  *	e nelle ricerche sarà inserito tra le clausole HAVING.<br /><br />
	  *	
	  * Questo metodo accetta un NUMERO VARIABILE DI ARGOMENTI: i due argomenti possono essere ripetuti a coppie 
	  * setSearchField(F1a,F1b,F2a,F2b,F3a,....)
	  *
   	  */
	function setSearchField()
	{
		$func_args=func_get_args();
		
		$i=$j=0;
		$bool=true;
		foreach ($func_args as $key=>$val) //costruisco l'array con i parametri della funzione
		{
			switch ($j)
			{
				case 0: $arg[$i]['fullField']=$val; break;
				case 1: $arg[$i]['alias']=$val; break;
				case 2: $arg[$i]['domainType']=$val; break;
				case 3: $arg[$i]['domainValue']=$val; break;								
			}
			
			$j++;
			if ($j==4) 
			{
				$i++; //indice dell'array di memorizzazione
				$j=0; //indice della scansione dei 4 settaggi
			}
			
		}
		

		foreach ($arg as $key=>$val)
		{				
			
			$exp=explode(".",$val['fullField']);
				
			if (count($exp)==1)//clause su funzioni di aggregazione sql come COUNT(*), CONCAT(.... 
			{
				$arg[$key]['field']=$exp[0]; 
				$arg[$key]['table']="Having";
			}else
			{
				$arg[$key]['table']=$exp[0]; //viene cambiato se presente alias
				$arg[$key]['field']=$exp[1];
			}	
			
			$arg[$key]['table_alias']=$arg[$key]['table']; 
				
		
			if (isset($val['alias']) && $val['alias']!="") $arg[$key]['field_alias']=$val['alias'];
			else
			//if (is_int(strpos($this->query," ".$fullField." AS "))) //CERCA l'[ALIAS DEL CAMPO] !!!!
			if (preg_match("/ {$val['fullField']} AS( |\\n|\\r|\\r\\n)/",$this->query,$pattern)!=false)
			{
				//$exp=explode(" ".$fullField." AS ",$this->query);
				$exp=explode($pattern[0],$this->query);
				$exp2=preg_split("/(,| ){1}/",$exp[1]);
				$arg[$key]['field_alias']=$exp2[0];	
			}
			else $arg[$key]['field_alias'] = $arg[$key]['field'];
		
			if (strpos($this->query," AS ".$arg[$key]['table']." ")!=false) //CERCA l'[ALIAS DELLA TABELLA] per modificare eventualmente table_alias!!!!
			{
				$exp=explode(" AS ".$arg[$key]['table']." ",$this->query);
				$exp2=explode(" ",$exp[0]);
				$arg[$key]['table']=$exp2[count($exp2)-1];						
			} //////////////////////////////////////////////////////////////////////////////////

		}
		
		/*/////////////////////N  O  T  E////////////////////////////////////////////////////////////
			
			Il formato di $fullField deve essere 
			- tabella.campo    
			- alias_tabella.campo
			
			ricavare l'alias DEL CAMPO serve solo a fini di visualizzazione in quanto 
			---> le condizioni where ed having nella query non si devono riferire all'alias di un campo 
				
		*/////////////////////////////////////////////////
		
		if (count($arg)==1)
		{
			$field=$arg[0]['field'];
			$field_alias=$arg[0]['field_alias'];
			$table=$arg[0]['table'];
			$table_alias=$arg[0]['table_alias'];
			$fullField=$arg[0]['fullField'];
			$domainType=$arg[0]['domainType'];
			$domainValue=$arg[0]['domainValue'];										
		}
		else
		for ($i=0; $i < count($arg) ; $i++)
		{
			$field[]=$arg[$i]['field'];
			$field_alias[]=$arg[$i]['field_alias'];
			$table[]=$arg[$i]['table'];
			$table_alias[]=$arg[$i]['table_alias'];
			$fullField[]=$arg[$i]['fullField'];
			$domainType[]=$arg[$i]['domainType'];
			$domainValue[]=$arg[$i]['domainValue'];									
		}
		
		$this->searchField[]=array('field'=>$field,'field_alias'=>$field_alias,'table'=>$table,'table_alias'=>$table_alias,'fullField'=>$fullField,
								   'domainType'=>$domainType,'domainValue'=>$domainValue);		
								   	
	}
	
	/** Removes all fields set up like researching fields
	  * <br /><br />ITALIAN:<br /> Rimuove tutti i campi impostati come campi di ricerca  */
	function clearSearchFields() {$this->searchField=array();}
	
	/** @param mixed String or string array where ther're no HTML entities 
	  *              <br /><br />ITALIAN:<br /> Stringa o array di stringhe in cui non ci sono entità HTML
	  * @return mixed the initial value with which the appropariate characters are replaced with HTML entities ('&amp;' , '&gt;' e '&lt;')
	  *               <br /><br />ITALIAN:<br /> Il valore iniziale in cui i caratteri appropriati vengono sostituiti da entità HTML ('&amp;' , '&gt;' e '&lt;') */
	private function convertSpecialChars($value)
	{	
		if (is_array($value))
		foreach($value as $key=>$val)
		{
			$value[$key]=str_replace("&","&amp;",$value[$key]);
			$value[$key]=str_replace(">","&gt;" ,$value[$key]);
			$value[$key]=str_replace("<","&lt;" ,$value[$key]);
		}
		else 
		{
			$value=str_replace("&","&amp;",$value);
			$value=str_replace(">","&gt;" ,$value);
			$value=str_replace("<","&lt;" ,$value);
		}
	
		return $value;
	
	}
	
	/**
      * Aggiunge una colonna nominata $colName alla tabella della visualizzazione generale dei dati.
	  * Tale colonna avrà come icona $image e linkerà alla pagina corrente se non specificato il parametro $page.	
	  *
	  * <br /><br />ITALIAN:<br />
	  * Adds a column named $colName at data general visualization table.
	  * That column will have as icon $image and will link at the current page if not specified the parameter $page.
	  *
	  *	@param string intestazione della colonna <br /><br />ITALIAN:<br /> heading of the column
	  *	@param string name of the GET parameter to which will be assigned the id of each record 
	  *               <br /><br />ITALIAN:<br /> nome del parametro GET a cui sarà assegnato l'id di ogni record
	  *	@param string  path of the icon image <br /><br />ITALIAN:<br />percorso dell'immagine icona
	  *	@param boolean indicates if the linked page will have to keep the sunbjects GET of the page
	  *                <br /><br />ITALIAN:<br /> indica se la pagina linkata dovrà mantenere gli argomenti GET della pagina.
	  *	@param boolean indicates if the linking page will have to open up in a new window. 
	  *                <br /><br />ITALIAN:<br /> indica se la pagina linkata dovrà aprirsi in una nuova finestra.
	  *	@param mixed string that indicates the linking page. false value indicates the current page 
	  *              <br /><br />ITALIAN:<br /> stringa indicante la pagina linkata. il valore false indica la pagina corrente 
	  *	@param string contains a booleana expression PHP that will be evalueted as condition of the visualization link. Works as {@link setHighlighting()} 
	  *               <br /><br />ITALIAN:<br /> 
	  *               contiene un'espressione booleana PHP che sarà valutata come condizione di visualizzazione del link. Funziona come {@link setHighlighting()}
	  *	@param array contains all field names of the selection SQL where to apply the link in the visualization table. 
	  *              <br /><br />ITALIAN:<br /> contiene tutti i nomi dei campi della selezione SQL a cui applicare il link nella tabella di visualizzazione.
	  */
	function addLinkCol($colName,$arg,$image,$keepGet='',$newWindow=false,$page='',$condition="",$fieldToLink=false)
	{
		if ($page=='') $page=$_SERVER['PHP_SELF'];
		$this->linkCol[]=array('colName'=>$colName,'arg'=>$arg,'image'=>$image,"keepGet"=>$keepGet,"newWindow"=>$newWindow,"page"=>$page,"condition"=>$condition
		,'fieldToLink'=>$fieldToLink);
	}

	/**
	  * Adds a column named $colName at data general visualization table.
	  * The column  corresponds to an attribute in two possible values and the interface will contain the link that will allow to change the value
	  * The link will be active on the image that is shown and that corresponds to the current value of the attribute
	  *
	  * <br /><br />ITALIAN:<br />
	  * Aggiunge una colonna nominata $colName alla tabella della visualizzazione generale dei dati.
	  * La colonna corrisponde ad un attributo a due possibili valori e l'interfaccia conterrà un link che permetterà di cambiarne il valore.
	  * Il link sarà attivo sull'immagine che viene mostrata e che corrisponde al valore corrente dell'attributo
      *
	  *	@param string name of the field of two values <br /><br />ITALIAN:<br /> nome del campo a due valori
	  *	@param string path of the image corresponding to the first value of the attribute
	  *               <br /><br />ITALIAN:<br /> path dell'immagine corrispondente al primo valore dell'attributo
	  *	@param string path of the image corresponding to the second value of the attribute
	  *               <br /><br />ITALIAN:<br /> path dell'immagine corrispondente al secondo valore dell'attributo
	  */  
	function addSwitchCol($colName,$image1,$image2)
	{
		$this->switchCol[$colName]=array('image1'=>$image1,'image2'=>$image2);
	}
	
	/** 
	  * Avoids to show the  contents of the field $field in the general visualization table.<br />
	  * At the place of the contents, is shown a state flage that is an image which simply indicates if the field
	  * is empty or not.
	  * The application in fields set up like images causes the not visualization of the preview.
	  *
	  * <br /><br />ITALIAN:<br />
	  * Evita di mostrare il contenuto del campo $field nella tabella di visualizzazione generale.<br />
	  * Al posto del contenuto, viene mostrato un indicatore di stato ovvero una immagine che segnala semplicemente se il campo 
	  * è vuoto oppure no.
	  * L'Applicazione a campi impostati come immagini ne causa la non visualizzazione della preview.
	  *
	  * @param string the path containing the image that indicates on the field there's an image (the field is full)
	  *               <br /><br />ITALIAN:<br /> il path contenente l'immagine che indica che sul campo è presente una immagine (il campo è pieno) 
	  * @param string the path containing the image that indicates on the field there's not an image (the field is empty)
	  *               <br /><br />ITALIAN:<br /> il path contenente l'immagine che indica che sul campo non è presente una immagine (il campo è vuoto)  
	  */
	function setFieldStatusIndicator($field,$on,$off)
	{
		$this->imageIcon[$field]=array('on'=>$on,'off'=>$off);
	}	
	
	/** 
	  * Adds a column named $colName at the data general visualization table.
	  * That column will have as contents the HTML contained in the parameter $content in which you'll can refer to the current id
	  * with the string '%current_row_id%'.
      *
	  * <br /><br />ITALIAN:<br />
	  * Aggiunge una colonna nominata $colName alla tabella della visualizzazione generale dei dati.
	  * Tale colonna avrà come contenuto l'HTML contenuto nel paramentro $content in cui ci si potrà riferire all'id corrente 
	  * con la stringa '%current_row_id%'.
	  *
	  *	@param string heading of the column  <br /><br />ITALIAN:<br /> intestazione della colonna
	  *	@param string HTML code (with eventual Javascript) of each cell. %current_row_id% is replaced with the id of each record 
	  *               <br /><br />ITALIAN:<br />codice HTML (con eventuale Javascript) di ogni cella. %current_row_id% viene sostituito dall'id di ogni record
	  */
	function addFreeCol($colName,$content)
	{
		$this->freeCol[]=array('colName'=>$colName,'content'=>$content);
	}
	
	/** 
	  * Adds a column named $colName at the data general visualization table.
	  * That column will contain the data got executing the query $query where will have to be present the string '%current_row_id%'
	  * indicating the id of the current record.
	  * That query could be the type defined as $type. Available types are:<br /><br />
	  *
	  * - LINKED_RECORDS simply performs the query which will tipically apply the join with other
	  * tables, unically visualizing the first selected field for each resulting string (lines separated by a back return)<br /><br />
	  *
	  * - RECURSIVE will execute the query in the resorting way through the method {@link query_ricorsiva()} counting the number
	  * of record resortively selected and visualizing that numeric value in the column.<br />
	  * This type of query is tipically used to count elements memorized in tree structures.<br /><br />
	  *
	  * - CALCULATION  asks that the subject query is an array. <br />
	  * In particular each element of that array will have to be an array of two elements with key 'operand' and 'query'.
	  * operand is a string of a character containing a mathematic operator of PHP (+,-,*,/),
	  *query is the query that will have to have a numeric field as first field (also here %current_row_id% will be replaced with the current id).
	  * The class will find the way to execute all the query contained in the array and to link together with their own operand operator. Visualizing the final result
	  * Notice: you can obtain the same result applying sub-queries (subqueries) to the select of initail query. 
	  *
	  *
	  * <br /><br />ITALIAN:<br />
      *
	  * Aggiunge una colonna nominata $colName alla tabella della visualizzazione generale dei dati.
	  * Tale colonna conterrà dei dati ottenuti eseguendo la query $query in cui dovrà essere presente la stringa '%current_row_id%'
	  * indicante l'id del record corrente.
	  * Tale query potrà essere del tipo definito in $type. I tipi disponibili sono:<br /><br />
	  *
	  * - LINKED_RECORDS esegue semplicemente la query che tipicamente applicherà dei join con altre
	  * tabelle, visualizzando unicamente il primo campo selezionato per ogni riga risultante (righe separate da un ritorno a capo)<br /><br />
	  *	  
	  * - RECURSIVE eseguira la query in modo ricorsivo tramite il metodo {@link query_ricorsiva()} contando il numero
	  * di record ricorsivamente selezionati e visualizzando tale valore numerico nella colonna.<br />
	  * Questo tipo di query è tipicamente usato per contare elementi memorizzati in strutture ad albero.<br /><br />
	  *
	  * - CALCULATION richiede che l'argomento query sia un array. <br />
	  * In particolare ogni elemento di tale array dovrà essere a sua volta una array di due elementi con chiavi 'operand' e 'query'. 
	  * operand è una stringa di un carattere contenente un'operatore matematico di PHP (+,-,*,/), 
	  * query è la query che dovra avere un campo numerico come primo campo (anche qui %current_row_id% sarà sostituito dall'id corrente).
	  * La classe fara in modo di eseguire tutte le query contenute nell'array e concatenarle con il loro operatore operand. Visualizzando il risultato finale
	  * Nota: si può ottenere lo stesso risultato applicando delle sotto-query (subqueries) alla select della query iniziale.
	  *	  
	  *	@param string heading of the column <br /><br />ITALIAN:<br /> intestazione della colonna
	  *	@param string query containing the string %current_row_id% which is replaced with the id of each record 
	  *               <br /><br />ITALIAN:<br /> query contenente la stringa %current_row_id% che viene sostituita dall'id di ogni record
	  *	@param string query type <br /><br />ITALIAN:<br /> tipo della query
	  */
	function addDataCol($colName,$query,$type)
	{
		$this->dataCol[]=array('colName'=>$colName,'query'=>$query,'type'=>strtoupper($type));
	}
	
	/** @param boolean Enables/closes down the possibility of multiple modifications/eliminations and contemporary modifications.<br />
	  *                That set is effectively relevant if  the modification and elimination is enabled trough {@link canEdit()} e {@link canDelete()}
	  *                <br /><br />ITALIAN:<br /> 
	  * 			   Abilita/disabilita la possibilità di modifiche/eliminazioni multiple e modifiche contemporanee.<br />
	  * 			   Tale impostazione ha effettivamente rilevanza se è abilitata la modificazione ed eliminazione tramite {@link canEdit()} e {@link canDelete()}
	  */
	function canMultipleEditDelete($apply){$this->canMultipleEditDelete=$apply;}

	/**  @param int number of the maximum characters to be visualized for each field in the general visualization table
	  *             <br /><br />ITALIAN:<br /> numero di caratteri massimi da visualizzare per ogni campo nella tabella di visualizzazione generale */	
	function setTextCutLength($cutLength=150){$this->cutLength=$cutLength;}


	/**  @param boolean indicates if the record visualization must happen even without any research. Default is true. 
	  *                 <br /><br />ITALIAN:<br /> indica se la visualizzazione dei record deve avvenire anche senza effettuare alcuna ricerca. Di default è true 
	  */
	function setViewResultWithoutSearch($bool){$this->viewResults=$bool;}

	/**  @param boolean indicates if visualize all the possible options in the input SELECT of the researching form
	  *                  independently from the presence of the record database with those values or without 
	  *                  <br /><br />ITALIAN:<br /> 
	  *					indica se visualizzare tutte le opzioni possibile negli input SELECT dei form di ricerca
	  *					indipendentemente dalla presenza del database di record con quei valori o meno
	  */	
	function setViewAllSearchOptions($bool){$this->viewAllSearchOptions=$bool;}
	
	/**  @param string path where you can find all the script and images requires from the class.
	  *                The path is searched automatically in pre-defined runs at the moment of an object installation of the class	
	  * 			   but if files are not in those paths, is necessary to recall this method.
	  *                <br /><br />ITALIAN:<br /> 
	  *                path in cui si trovano tutti gli script ed immagini richieste dalla classe.
	  *  			   Il path viene cercato automaticamente in dei percorsi predefiniti al momento dell'instanziazione di un oggetto della classe (nel costruttore)
	  *  			   ma se i file non si trovano in tali path, è necessario richiamare questo metodo. 
      */			
	function setImagesAndScriptsPath($path){ $this->imagesAndScriptsPath=$path; }


	/** 
	  * Sets up the maximum number of radio options that can have a fixed choice field as first paramenter, and
	  * the maximum number of radio options that can have in just one line, as second.
	  * A field which has a number of elements greater than the fisrt parameter, will be published with a select input (instead of radio).
	  * A field which has a number of elements greater than the second parameter, will be visualized with a radio option for each line.
	  *
	  * <br /><br />ITALIAN:<br />
	  * Imposta il numero massimo di opzioni radio che può avere un campo a scelta fissa come primo parametro, e 
	  * il numero massimo di opzioni radio che può avere su una sola riga, come secondo.
	  * Un campo che ha un numero di elementi maggiore del primo parametro, sarà editabile con una select input (anziche dei radio).
	  * Un campo che ha un numero di elementi maggiore del secondo parametro, sarà visualizzato con una opzione radio per riga.	
	  *
	  *
	  * @param int maximum number of options that can have a fixed choice field 
	  *            <br /><br />ITALIAN:<br /> numero massimo di opzioni che può avere un campo a scelta fissa
	  * @param int maximum number of options that can have an input radio in just one line
	  *            <br /><br />ITALIAN:<br /> numero massimo di opzioni che può avere un input radio su una sola riga
	  */ 		 	
	function setRadioSettings($maxOptions,$maxOptionsInOneLine=3)
	{
		$this->radioSettings['maxOptions']=$maxOptions;
		$this->radioSettings['maxOptionsInOneLine']=$maxOptionsInOneLine;
	}

	/**
	  * Sets up the maximum number of checkbox for a multiple choice field (SET) as a first parameter, and
	  * the dimension (number of elements) that will have the multiple choice select if the number of elements of the field exceeds
	  * the first parameter.
	  *
	  * <br /><br />ITALIAN:<br />
	  * Imposta il numero massimo di checkbox per un campo a scelta multipla (SET) come primo parametro, e
	  * la dimensione (numero di elementi) che dovrà avere la select a scelta multipla se il numero di elementi del campo supera
	  * il primo paramentro.
	  *
	  * @param int maximum number of checkbox that can have a multiple choice field
	  *            <br /><br />ITALIAN:<br /> numero massimo di checkbox che può avere un campo a scelta multipla
	  * @param int dimension (number of elements) that will have the multiple choice select which replaces the checkbox in the case of  excess
	  *            <br /><br />ITALIAN:<br /> dimensione (numero di elementi) che dovrà avere la select a scelta multipla che rimpiazza 
	  *            le checkbox in caso di eccedenza
	  */ 		
	function setCheckboxesSettings($maxCheckboxes,$multipleSelectSize) 
	{ 
		$this->checkboxesSettings['maxCheckboxes']=$maxCheckboxes;
		$this->checkboxesSettings['multipleSelectSize']=$multipleSelectSize;  
	}		
	
	
	/** 
	  * Accepts a query of construction of the object that must contain all necessary join with which will make the following elaborations.
	  * Besides creates a table called 'busy_records' which serves
	  * to manage the conflicts of mutual exclusion in the simultaneous record modifications. <br />
	  * That table is used for all instances DBNavigator.
	  *
	  * On edit mode, if the query have some join, an input will be added to associate one of the external table records. 
	  * The <b>first field</b> of the external table in the construction query will be displayied in the form for the
	  * the selection of one external record. 
	  *	  
	  * <br /><br />ITALIAN:<br />
	  * Accetta una query di costruzione dell'oggetto che deve comprendere tutti i join necessari con cui si faranno le successive elaborazioni. <br />
	  * Inoltre crea una tabella chiamata 'busy_records' che serve
	  * a gestire i conflitti di mutua esclusione sulle modifiche simultanee ai record. <br />
	  * Tale tabella è usata per tutte le istanze di DBNavigator.
	  *
	  * In modalità di modifica, se la query di costruzione presenta dei join, verrà inserito in input che permetta di associare uno dei record 
	  * della tabella esterna. Il campo visualizzato nel form per la selezione di quest'ultimo sarà <b>il primo campo</b> della tabella esterna
	  * presente nella query di costruzione. 
	  *
      * @param string Main query.<br />
      *	              WARNING, is assumed that the main query contains ALL the key words SQL
	  *				  in capital (SELECT,FROM,WHERE,HAVING,AS...) while in the internal subqueries (subqueries), if present,
	  *				  the key words must be all small letters. <br />
	  *				  besides is assumed that the query doesn't contain the clause ORDER BY,
	  *				  the regulation field must be set up trough the apposite method {@link setDefaultOrd()}
	  *				  
	  *				  <br /><br />ITALIAN:<br />
	  *			      query principale.<br />
	  *				  ATTENZIONE, si assume che la query principale contenga TUTTE le parole chiave SQL    
	  *               in maiuscolo (SELECT,FROM,WHERE,HAVING,AS...) mentre nelle sotto-query (subqueries) interne, se presenti, 
	  *               le parole chiave dovranno essere tutte minuscole. 
	  *				  Inoltre si assume che la query non contenga la clausola ORDER BY,
	  *				  il campo di ordinamento dovrà essere impostato tramite l'apposito metodo {@link setDefaultOrd()} 
	  *				  
	  */	
	function DBNavigator($query)
	{																						
		$this->setFormWidth(25,75);
		//se non esiste crea la tabella busy_records
		mysql_query("CREATE TABLE IF NOT EXISTS `busy_records` 
		(
		  `table_name` varchar(255) NOT NULL default '',
		  `record_id` varchar(255) NOT NULL default '',
		  `user_session_id` varchar(255) NOT NULL default '',
		  `expire_time` bigint(20) NOT NULL default '0'
		) ;");
	
		mysql_query("DELETE FROM busy_records WHERE expire_time<\"".strtotime("now")."\""); //elimina le ocupazioni 'scadute'
	
	
		//////////////
		if (file_exists('DBNavigator.js')) //cartella corrente dello script
		$this->imagesAndScriptsPath='./';
		else
		if (file_exists('classes/DBNavigator.js'))
		$this->imagesAndScriptsPath='classes/';
		else
		if (file_exists('DBNavigator/DBNavigator.js'))
		$this->imagesAndScriptsPath='DBNavigator/';
		else	
		if (file_exists('webedit/classes/DBNavigator.js'))
		$this->imagesAndScriptsPath='webedit/classes/';
		//else	
		//die ("Can't find Images and Javascript libraries path");
		
		
	
	
/*		$change=array(" on "," On "," oN ");//sostituisce on in maiuscolo
		$query=str_replace($change," ON ",$query);	
		
		$change=array(" as "," As "," aS ");//sostituisce as in maiuscolo
		$query=str_replace($change," AS ",$query);	*/
		
		
		//echo($query."<br><br>");
		//$query=preg_replace("/\(SELECT(.+)\)/","SUBSELECT",$query);	///è un casino...
		//die($query);		
				
/*		$pos=strpos(strtolower($query),"group by");
		if ($pos) //sostituisce il group by in maiuscolo
		{
			$first=substr($query,0,$pos);
			$second=substr($query,$pos+8);
			$query=$first."GROUP BY".$second;	
		}
		
	
		$pos=strpos(strtolower($query),"where");
		if ($pos) //sostituisce il where in maiuscolo
		{
			$first=substr($query,0,$pos);
			$second=substr($query,$pos+5);
			$query=$first."WHERE".$second;	
		}*/
		$this->query=$query;
		$this->dateInterval[0]=date("Y")-90;
		$this->dateInterval[1]=date("Y")+30;
		$this->editForm=new HTMLForm("x","x",25,75); //creo il form a "caso" :non esiste sovraccarico dei costruttori in php4

		$this->PP=new HTMLPostProcessor();
		
		$this->ajaxCall=false;
	
	
	}
	
	/** @param string name of a database table to be considered as the main between the present ones in the construction query of the object
	  *               <br /><br />ITALIAN:<br /> nome di una tabella del database da considerarsi come principale tra quelle presenti nella 
	  *               query di costruzione dell'oggetto */
	function setPrimaryTable($primaryTable) //NECESSARIA
	{
		///echo $this->query;
	
		$this->originalPrimaryTable=$primaryTable;
		$this->primaryTable=$primaryTable; 
	
		if (isset($_GET[$this->originalPrimaryTable.'_suggestField'])) $this->retrieveSuggestOptions();	
	
	
		if (isset($_GET['ajaxCall_'.$this->originalPrimaryTable]))
		{
			$this->ajaxCall=true;
			unset($_GET['ajaxCall_'.$this->originalPrimaryTable]);
	
			if (isset($_GET['manage_record_availability'])) //se c'è questo get allora è uno script di background che sta eseguendo il file
			$this->manage_record_availability_AjaxCall($_GET['manage_record_availability'],isset($_GET['bookRecord'])?true:false);	
			
		}
		else
		$this->ajaxCall=false;
		

		//***********ESECUZIONE SWITCH PRECEDENTI*******************
		if (isset($_GET["switch_field_{$this->originalPrimaryTable}"]))
		{
/*		die("UPDATE {$this->originalPrimaryTable} 
							SET ".$_GET["switch_field_{$this->originalPrimaryTable}"]."=".$_GET["switch_value_{$this->originalPrimaryTable}"]."
							WHERE id=".$_GET["switch_id_{$this->originalPrimaryTable}"]);*/
			mysql_query("UPDATE {$this->originalPrimaryTable} 
							SET ".$_GET["switch_field_{$this->originalPrimaryTable}"]."=".$_GET["switch_value_{$this->originalPrimaryTable}"]."
							WHERE id=".$_GET["switch_id_{$this->originalPrimaryTable}"]) or die(mysql_error());
			
			unset($_GET["switch_id_{$this->originalPrimaryTable}"]);	
			unset($_GET["switch_field_{$this->originalPrimaryTable}"]);
			unset($_GET["switch_value_{$this->originalPrimaryTable}"]);															
		}			
		
		$result=mysql_query("SHOW FULL FIELDS FROM ".$this->originalPrimaryTable);
		while($row=mysql_fetch_array($result))
		{
			switch($row['Comment'])
			{
				case 'mail': $this->setMailField($row['Field']); break;
				case 'numericString': $this->setNumericStringField($row['Field']); break;
				case 'file': $this->setFileField($row['Field']); break; //non usato qui xkè c'è il campo nella tab di configurazione
				//case 'photo': $DBN->setFileField($row['Field']); break;
				case 'DATE_MY': $this->setMonthYearField($row['Field']); break;
			}
		} 	
		
				
	}  

	/**
	  * Method which serves exclusively for the AJAX script of background that questions the database to have a list of suggestions
	  * in the form textbox of research and in the one of contemporaneus modification in more records
	  *
	  * <br /><br />ITALIAN:<br />
	  * Metodo che serve esclusivamente per lo script AJAX di background che interroga il database per avere una lista di suggerimenti
	  * nelle textbox del form di ricerca ed in quello della modifica contemporanea a più record 
	  */
	  
	private function retrieveSuggestOptions()
	{
		ob_end_clean();
	
		$output=array();
		
		if (strlen($_GET[$this->originalPrimaryTable.'_suggestText'])>0)
		{
			$num_suggestions=ceil(8/count($_GET[$this->originalPrimaryTable.'_suggestField']));
			
			foreach($_GET[$this->originalPrimaryTable.'_suggestField'] as $field)
			{
				$_GET[$this->originalPrimaryTable.'_suggestText']=
				$this->convertSpecialChars(str_replace(array("%","_"),array("\%","\_"),addslashes($_GET[$this->originalPrimaryTable.'_suggestText'])));
				
				$query="SELECT {$this->originalPrimaryTable}.{$field} ".substr($this->query,strpos($this->query,"FROM"));
				
				if (strpos($query,"GROUP BY")!==false)
				{
					$query=substr($query,0,strpos($query,"GROUP BY"))." GROUP BY ".$field;
				}
				else
				{
					$query.=" GROUP BY {$field} ";
				}
				
				$query=$this->addWhereConditionToQuery($query,"{$this->originalPrimaryTable}.{$field} LIKE \"".$_GET[$this->originalPrimaryTable.'_suggestText']."%\"")
													   ." ORDER BY {$this->originalPrimaryTable}.{$field} LIMIT 0,{$num_suggestions}";
			
				//echo $query;
				
				$result=mysql_query($query) or die(mysql_error()."<br />".$query);
				while ($row=mysql_fetch_array($result))
				$output[]=$row[$field];
	
			}
			sort($output);//ordina i risultati
		}
		
		die(implode("-###-",$output));
	}

	/** @param string contents of the clause ORDER BY to be added at the main query to order data
	  *               <br /><br />ITALIAN:<br /> contenuto della clausola ORDER BY da aggiungere alla query principale per ordinare i dati */
	function setDefaultOrd($defaultOrd) {$this->orderInfo['defaultOrd']=$defaultOrd;}          //NECESSARIA
	
	/** @param string generic name with which to refer to record.<br /> Example: insert new BOOK, modify BOOK.
	  *               <br /><br />ITALIAN:<br /> nome generico con cui ci si riferisce ai record.<br />Esempio: Inserisci nuovo LIBRO, Modifica LIBRO. 
	  */
	function setRowName($rowName) 																//NECESSARIA
	{
		$this->rowName=$rowName;
	}                      

	/** @param boolean indicates if to show or not the primary key of the main table in the data visualization table.
	  *                <br /><br />ITALIAN:<br /> Indica se mostrare o meno la chiave primaria della tabella principale nella tabella di visualizzazione dei dati.
	  */
	function hidePrimaryKey($boolean) {$this->hidePrimaryKey=$boolean;}           

	/** @param string name of the field of the main table considered as containing an email address. <br />
	  * 			  In the modification/insertion form will be apply a validation that verifies the right format of the typed values.
	  *
	  * 			  <br /><br />ITALIAN:<br />
	  * 			  nome del campo della tabella principale considerato come contenente un indirizzo email. <br />
	  * 			  Nei form di modifica/inserimento verrà applicata una validazione che verifica il formato corretto dei valori digitati. 
	  */
	function setMailField($field) {$this->mailField[$field]="yes";}


	/** @param string name of the field in the main table considered as containing an information month-year.<br />
	  * 			  In the modification/insertion form will be created an interface that will allow to insert month and year trough selection cells.<br />
	  * 			  The indicated field must be like type DATE and the information on the day will be ignored.
	  *               <br /><br />ITALIAN:<br /> 
	  *               nome del campo della tabella principale considerato come contenente un'informazione mese-anno. <br />
	  *               Nei form di modifica/inserimento verrà creata una interfaccia che permetta di inserire mese ed anno tramite caselle di selezione.<br />
	  *               Il campo indicato deve essere di tipo DATE e l'informazione sul giorno verrà ignorata.
	  */
	function setMonthYearField($field) {$this->monthYearField[$field]="yes";}


	/** @param string name of the field of the main table considered as containing numeric strings
	  * 			  In the modification/insertion form will be apply then a validation that will allow to type just numbers
	  *               <br /><br />ITALIAN:<br /> 
	  *               nome del campo della tabella principale considerato come contenente stringhe numeriche.
	  *               Nei form di modifica/inserimento verrà quindi applicata una validazione che consente la digitazione di soli numeri.
	  */
	function setNumericStringField($field) {$this->numericStringField[$field]="yes";}


	/** @param mixed names of a field or an array of field names of tables where are memorized images names present in the filesystem of the server.<br />
	  * 			 In the modification/insertion form will be build an appropriate interface ( FILE input + image preview). <br />
	  * 			 The validation will allow the insertion of file of image type for the web ( GIF, JPEG, PNG ).
	  *              <br /><br />ITALIAN:<br /> 
	  *              nome di un campo o array di nomi di campo di tabelle in cui sono memorizzati nomi di immagini, presenti nel filesystem del server.<br />
	  * 		     Nei form di modifica/inserimento verrà costruita l'interfaccia appropriata ( FILE input + image preview). <br />
	  * 			 La validazione consentirà l'inserimento di file di tipo immagine per il web ( GIF, JPEG, PNG ).
	  *
	  *
	  * @param mixed the value false indicates that the image will not be reduced. <br />
	  *				 A numeric value indicates the size in pixel for which will happen the reduction.
	  *				 <br /><br />ITALIAN:<br /> 
	  *				 il valore false indica che l'immagine non verrà ridimensionata. <br />
	  * 			 Un valore numerico indica la dimensione in pixel per cui avverrà il redimensionamento. 					 
	  *				 
	  * @param boolean Indicates if the original image sent must be saved <br /><br />ITALIAN:<br /> Indica se l'immagine originale inviata deve essere salvata.
	  *
	  * @see setFileNameCriteria()
	  */
	function setImageField($field,$resizeImg=false,$keepOriginal=false) 
	{
		if (is_array($field))
			foreach ($field as $f)
				$this->photoField[$f]=false;
		else
			$this->photoField[$field]=false;
		//la chiave è rilevante, il valore dell'array potrebbe essere qualsiasi cosa
		
		$this->photoField['_Resize_']=$resizeImg;
		$this->photoField['_KeepOriginal_']=$keepOriginal;
		
		$this->PP->setResizeImageDimension($this->photoField['_Resize_']);
		$this->PP->keepOriginalImages($this->photoField['_KeepOriginal_']);
	
	}
	
	/** @see setImageField
	  * @deprecated */
	function setPhotoField($field,$resizeImg=false,$keepOriginal=false) { $this->setImageField($field,$resizeImg,$keepOriginal); }



	/** @param mixed name of a field or array of field names in tables where are memorized file names, present in the filesystem of the server.<br />
	  *              In the modification/insertion form will be build the appropriate interface ( FILE input ). <br />
	  *              <br /><br />ITALIAN:<br /> 
	  *              nome di un campo o array di nomi di campo di tabelle in cui sono memorizzati nomi di file, presenti nel filesystem del server.<br />
	  * 		     Nei form di modifica/inserimento verrà costruita l'interfaccia appropriata ( FILE input ). <br />
	  *
	  * @see setFileNameCriteria()
	  */
	function setFileField($field) 
	{
		if (is_array($field))
			foreach ($field as $f)
				$this->fileField[$f]=false;
		else
			$this->fileField[$field]=false;
	}



	/**
	  * Use this function is right just if there are specified the fields that refer to the files
	  * trough the functions {@link setFileField()} and {@link setImageField()}
	  *
	  * <br /><br />ITALIAN:<br />
	  * Usare questa funzione ha senso solo se si sono specificati i campi che si riferiscono ai file 
	  * tramite le funzioni {@link setFileField()} e {@link setImageField()}  
	  *
	  * @param string the saving path of all files managed by theinside of the filesystem of the server.
	  * 	          <br /><br />ITALIAN:<br /> 
	  *               il path di salvataggio di tutti i file gestiti all'interno del filesystem del server. 
	  *
	  *
	  * @see setFileNameCriteria()
	  */
	function setFilePath($path) 
	{
		$this->filePath=$path;
		$this->PP->setFileSavePath($path);
	} 
	

	/** @param string A symbolic string that represent the format to be used for file names while saving them into the server. Symbols are:<br />
	  *			      <b>*tb*</b> Main table name.<br />
	  *				  <b>*pk*</b> Primary key name in the main table.<br />
	  *				  <b>*cn*</b> Name of the field binded to the file to save.<br />
	  *				  <b>*fn*</b> Name of the original uploaded file.<br />
	  *				  <b>*ext*</b> Extension of the original uploaded file.<br /><br />
	  *				  
	  *				  Default is <b>*tb*_*pk*_*cn*.*ext*</b> which allow to upload as many file as you want without name conflicts.<br />
	  *				  Alternatively, to hold the original file name, use <b>*fn*.*ext*</b>
	  *
	  *  			  <br /><br />ITALIAN:<br /> 
	  *               una stringa simbolica che rappresenta il formato del nome del file da salvare. I simboli sono:<br />
	  *			      <b>*tb*</b> nome della tabella principale.<br />
	  *				  <b>*pk*</b> nome della chiave primaria nella tabella principale.<br />
	  *				  <b>*cn*</b> nome della campo della tabella principale associato al file da salvare.<br />
	  *				  <b>*fn*</b> nome del file originale.<br />
	  *				  <b>*ext*</b> estensione del file originale.<br /><br />
	  *				  
	  *				  L'impostazione di default è <b>*tb*_*pk*_*cn*.*ext*</b> in modo che non possano
	  *				  mai avvenire conflitti sui nomi dei file.<br />
	  *				  Alternativamente, per mantenere l'esatto nome originale del file, usare <b>*fn*.*ext*</b>
      *
	  * @see setFileField(), setImageField(),setFilePath() */
	function setFileNameCriteria($path) 
	{
		$this->PP->setFileNameCriteria($path);
	} 	
	
	
	/** @param string name of the CSS class to apply to the heading lines (tag TR) of the data visualization table
	  *               <br /><br />ITALIAN:<br /> nome della classe CSS da applicare alle righe (tag TR) di intestazione della tabella di visualizzazione dei dati 
	  * @param string name of the CSS class to apply to the internal lines in the data visualization table
	  *               <br /><br />ITALIAN:<br /> nome della classe CSS da applicare alle righe interne della tabella di visualizzazione dei dati  */	
	function setTableRowStyle($val1,$val2) 
	{
		$this->tableHeaderCSS=$val1; 
		$this->tableRowContentCSS=$val2; 
	}
	
	/** @param int  the 'cellspacing' of the data visualization table <br /><br />ITALIAN:<br /> il 'cellspacing' della tabella di visualizzazione dei dati */		
	function setTableCellSpacing($CS) {$this->tableCS=$CS;}
	
	/** @param int the 'cellpadding' of the data visualization table <br /><br />ITALIAN:<br /> il 'cellpadding' della tabella di visualizzazione dei dati */	
	function setTableCellPadding($CS) {$this->tableCP=$CS;}
	
	/** @param string name of the class CSS to apply to intern cells (tag TD) of the data visualization table
	  *               <br /><br />ITALIAN:<br /> 
	  *               nome della classe CSS da applicare alle celle interne (tag TD) della tabella di visualizzazione dei dati
	  * @param string name of the class CSS to apply to cells (tag TD) of the table which contains the buttons related to actions on each line
	  *               <br /><br />ITALIAN:<br />
	  *               nome della classe CSS da applicare alle celle (tag TD) della tabella che contengono i pulsanti relativi alle azioni su ogni riga
	  * @param string name of the class CSS to apply to heading cells (tag TD) of the data visualization table
	  *               <br /><br />ITALIAN:<br /> 
	  *               nome della classe CSS da applicare alle celle di intestazione (tag TD) della tabella di visualizzazione dei dati 
	  * @param string name of the class CSS to apply to links which are added inside the table, through the method {@link addLinkCol()}
	  *               <br /><br />ITALIAN:<br /> 
	  *               nome della classe CSS da applicare ai link, che vengono aggiunti all'interno della tabella, tramite il metodo  {@link addLinkCol()}
	  */		
	function setTableCellStyle($TD,$editDeleteTD,$headerTD,$fieldLink="") 
	{
		if ($TD) {$this->style['TD']=$TD; $this->classTag['TD']=" class=\"".$TD."\"";} 
		if ($editDeleteTD) {$this->style['editDeleteTD']=$editDeleteTD; $this->classTag['editDeleteTD']=" class=\"".$editDeleteTD."\"";} 
		if ($headerTD) {$this->style['headerTD']=$headerTD; $this->classTag['headerTD']=" class=\"".$headerTD."\"";} 
		if ($fieldLink) {$this->style['fieldLink']=$fieldLink; $this->classTag['fieldLink']=" class=\"".$fieldLink."\"";} 
	}
	
	/** @see setTableCellStyle()
	  * @deprecated */	
	function setTableStyle($TD,$editDeleteTD,$headerTD,$fieldLink="") { $this->setTableCellStyle($TD,$editDeleteTD,$headerTD,$fieldLink="");  }
	
	
	/** @param string name of the class CSS to apply to input of the form (tag INPUT).
	  * 			  <br /><br />ITALIAN:<br /> nome della classe CSS da applicare agli input dei form (tag INPUT). 
	  * @param string name of the class CSS to apply to form buttons. 
	  *               <br /><br />ITALIAN:<br /> nome della classe CSS da applicare ai pulsanti dei form.
	  * @param string name of the class CSS to apply to the simple textarea of the form 
	  *               <br /><br />ITALIAN:<br /> nome della classe CSS da applicare alle textarea semplici dei form (tag TEXTAREA).*/	
	function setClassForFormInput($forInputs,$forButtons="",$forTareas="")
	{
		$this->classForFormInput['inputs']=$forInputs;
		if ($forButtons) $this->classForFormInput['buttons']=$forButtons;
		if ($forTareas) $this->classForFormInput['textareas']=$forTareas;
	}	
	
	
	/** @param mixed Indicates if is allowed to eliminate record from the table (true/false)
	  *              or you can give an array of numeric id for which is allowed that action.
	  *               <br /><br />ITALIAN:<br /> 
	  *				 Indica se e' consentito eliminare record dalla tabella (true/false) 
	  *				 oppure si può fornire un array di id numerici per i quali è consentita tale azione. 
	  *				 
	  * @see canEditDelete(),canEdit(),canInsert() */
	function canDelete($boolean_or_id_array){$this->canDelete=$boolean_or_id_array;}
	
	/** @param mixed Indicates if is allowed to modify record from the table (true/false)
	  *              or you can give an array of numeric id for which is allowed that action.
	  *              <br /><br />ITALIAN:<br /> 
	  *              Indica se e' consentito modificare record dalla tabella (true/false)
	  *              oppure si può fornire un array di id numerici per i quali è consentita tale azione.
	  *
	  * @see canEditDelete(),canDelete(),canInsert() */
	function canEdit($boolean_or_id_array) {$this->canEdit=$boolean_or_id_array;}
	
	/** @param boolean Indicates if is allowed to insert record from the table (true/false)
	  *                <br /><br />ITALIAN:<br /> 
	  *                Indica se e' consentito inserire record dalla tabella (true/false) 
	  *
	  * @see canEditDelete(),canDelete(),canInsert() */
	function canInsert($boolean) {$this->canInsert=$boolean;}
	
	/** @param boolean Indicates if is allowed to eliminate and midify record from the table (true/false)
	  *                <br /><br />ITALIAN:<br /> 
	  *                Indica se e' consentito eliminare e modificare record dalla tabella (true/false) 
	  *
	  * @see canEditDelete(),canDelete(),canInsert() */
	function canEditDelete($boolean){$this->canEdit=$boolean;$this->canDelete=$boolean;}
	
	/** @param boolean Indicates if is allowed the exportation of data in format CSV and XML for Excel/OpenOffice
	  *                <br /><br />ITALIAN:<br /> 
	  *                Indica se e' consentita l'esportazione dei dati in formato CSV ed XML per Excel/OpenOffice 
	  */
	function canExport($boolean){$this->canExport=$boolean;}
	
	/** @param boolean Indicates if is allowed to singly visualize record of the table for printing
	  *                <br /><br />ITALIAN:<br />
	  *                Indica se e' consentito visualizzare singolarmente i record dalla tabella per la stampa
	  *
	  * @see canEditDelete(),canDelete() 
	  */
	function canViewForPrint($boolean) {$this->canViewForPrint=$boolean;}
	
	
	/** @param string an SQL query<br /><br />ITALIAN:<br />una query SQL 
	  * @param string an SQL boolean <br /><br />ITALIAN:<br />una condizione booleana SQL 
	  * @return string la query originaria con la condizione $cond aggiunta tra le clausola WHERE della query $query
	  *                <br /><br />ITALIAN:<br /> the originary query with the condition $cond added between the clause WHERE of the query $query
	  */	
	static function addWhereConditionToQuery($query,$cond="")
	{
		if ($cond=="") return $query;
				
				if (strstr(/*strtoupper(*/$query/*)*/,"WHERE"))
				{
					$where="AND"; 
					$exp=explode("WHERE",$query);			
					$query=$exp[0]." WHERE (".$exp[1]; //aggiunge la parentesi in tutto il where				
					$closeBracket=")"; //parentesi chiusa alla fine del where
				}
				else
				{
					$where="WHERE";
					$closeBracket="";			 
				}
				
				if (strpos($query,'GROUP BY'))
				{
					$exp=explode("GROUP BY",$query);			
					$exp[0].="{$closeBracket} $where $cond ";
					$query=implode("GROUP BY",$exp);
				}
				else 
				if (strpos($query,'ORDER BY'))
				{
					$exp=explode("ORDER BY",$query);			
					$exp[0].="{$closeBracket} $where $cond ";
					$query=implode("ORDER BY",$exp);
				}
				else 
				$query.="{$closeBracket} $where $cond ";
				
				return $query;
	}	

	/** @param string an SQL query<br /><br />ITALIAN:<br />una query SQL 
	  * @param string an SQL boolean <br /><br />ITALIAN:<br />una condizione booleana SQL 
	  * @return string la query originaria con la condizione $cond aggiunta tra le clausola HAVING della query $query
	  *                <br /><br />ITALIAN:<br /> the originary query with the condition $cond added between the clause HAVING of the query $query
	  */	
	static function addHavingConditionToQuery($query,$cond="")
	{
		if ($cond=="") return $query;
					
				if (strstr(/*strtoupper(*/$query/*)*/,"HAVING"))
				$where="AND"; 
				else 
				{
					$where="HAVING";
					if (!strpos($query,'GROUP BY')) //se non c'è il group by lo inserisce
					$query.=" GROUP BY {$this->primaryTable}.{$this->originalPrimaryKey} ";
				}	
					
				if (strpos($query,'ORDER BY'))
				{
					$exp=explode("ORDER BY",$query);			
					$exp[0].=" $where $cond ";
					$query=implode("ORDER BY",$exp);
				}
				else 				
			$query.=" $where $cond ";
					
				return $query;
	}		
	

	/** @param mixed the value true indicates if to insert the default image or is possible to indicate the path of another image
	  *              <br /><br />ITALIAN:<br /> 
	  *              il valore true indica se inserire l'immagine di default altrimenti è possibile indicare il path di un'altra immagine
	  * @param mixed the value true indicates if to use the default text as heading or is possible to indicate another text
	  *              <br /><br />ITALIAN:<br /> 
	  *              il valore true indica se usare il testo di default come intestazione altrimenti è possibile indicare un altro testo
	  * @return string the HTML code which includes the insertion button of a new element (made by an image and an heading)
	  *                <br /><br />ITALIAN:<br /> 
	  *                il codice HTML che comprende il tasto di inserimento di un nuovo elemento (costituito da immagine più didascalia)  
	  */		
	function printAddRowButton($image=true,$heading=true)
	{
		//echo $this->status();
		
		if ($this->status()!='viewing' && !$this->useAjax) return false;
		
		if (!$this->canInsert) return false;	
		
		if ($image===true) $image=$this->imagesAndScriptsPath."new.gif";		
		if ($heading===true) $heading=$this->lang['insertNew'];
		
		
		if ($this->useAjax)
		$href="javascript:DBN_{$this->originalPrimaryTable}.buildForm(0,'')";
		else
		$href="{$_SERVER['PHP_SELF']}?".buildQueryString("del_".$this->originalPrimaryTable,"edit_".$this->originalPrimaryTable)."&amp;edit_{$this->originalPrimaryTable}=0#{$this->originalPrimaryTable}_anchor";
		
		return "<a href=\"{$href}\"><img style=\"vertical-align:middle;border:none;\" src=\"".$image."\" alt=\"\" title=\"{$this->lang['insertNew']}\" /> {$heading}</a>";
	}

	/** @param mixed the value true indicates if to insert the default image or is possible to indicate the path of another image
	  *              <br /><br />ITALIAN:<br /> 
	  *              il valore true indica se inserire l'immagine di default altrimenti è possibile indicare il path di un'altra immagine
	  * @param mixed the value true indicates if to use the default text as heading or is possible to indicate another text
	  *              <br /><br />ITALIAN:<br /> 
	  *              il valore true indica se usare il testo di default come intestazione altrimenti è possibile indicare un altro testo
	  * @return string the HTML code which includes the exportation button in CSV format (made by an image and an heading)
	  *                <br /><br />ITALIAN:<br /> 
	  *                il codice HTML che comprende il tasto di esportazione dati in formato CSV (costituito da immagine più didascalia) 
	  */			
	function printCsvDownloadButton($image=true,$heading=true)
	{
		//echo $this->status();
		
		if ($this->status()!='viewing' && !$this->useAjax) return false;
			
		if (!$this->canExport) return false;	
			
		if ($image===true) $image=$this->imagesAndScriptsPath."csv.gif";
		if ($heading===true) $heading="Download ".str_replace("_"," ",$this->originalPrimaryTable)." CSV";
		
		
		return "
		<a href=\"javascript:location.href=DBN_{$this->originalPrimaryTable}.getAjaxUrl()+'&csv_{$this->originalPrimaryTable}';\">
		<img style=\"vertical-align:middle;border:none;\" src=\"".$image."\" alt=\"\" title=\"{$heading}\" />
		{$heading}
		</a>";

	}

	/** @param mixed the value true indicates if to insert the default image or is possible to indicate the path of another image
	  *              <br /><br />ITALIAN:<br /> 
	  *              il valore true indica se inserire l'immagine di default altrimenti è possibile indicare il path di un'altra immagine
	  * @param mixed the value true indicates if to use the default text as heading or is possible to indicate another text
	  *              <br /><br />ITALIAN:<br /> 
	  *              il valore true indica se usare il testo di default come intestazione altrimenti è possibile indicare un altro testo
	  * @return string the HTML code which includes the exportation button in XML format (made by an image and an heading)
	  *                <br /><br />ITALIAN:<br /> 
	  *                il codice HTML che comprende il tasto di esportazione dati in formato XML (costituito da immagine più didascalia) 	  
      */				
	function printExcelXmlDownloadButton($image=true,$heading=true)
	{
		//echo $this->status();
		
		if ($this->status()!='viewing' && !$this->useAjax) return false;
			
		if (!$this->canExport) return false;	
			
		if ($image===true) $image=$this->imagesAndScriptsPath."excel_xml.gif";
		if ($heading===true) $heading="Download ".str_replace("_"," ",$this->originalPrimaryTable)." XML for Excel/OpenOffice";
		
		return "
		<a href=\"javascript:location.href=DBN_{$this->originalPrimaryTable}.getAjaxUrl()+'&excel_xml_{$this->originalPrimaryTable}';\">
		<img style=\"vertical-align:middle;border:none;\" src=\"".$image."\" alt=\"\" title=\"{$heading}\" />
		{$heading}
		</a>";

	}	
	
	
	private function delete_autoJoinedRows_recursive($id,$autoJoinKey)
	{	
			$query="SELECT * FROM {$this->originalPrimaryTable} WHERE {$autoJoinKey}='$id'";
			$result=mysql_query($query) or die ("ERRORE ELIMINAZIONE RICORSIVA: {$query}");
			while ($row=mysql_fetch_array($result))  //seleziona le categorie figlie dirette
			{
				$this->delete($row['id'],true);		
			}			
	}
	
	private function delete_linkedTableRows($id,&$linkedDBN)
	{	
			$linkedDBN->scanTable();
	
			foreach($linkedDBN->externalJoin as $ed) //cerca la chiave collegata alla tabella da cui cancellare ricorsivamente
			{
				foreach($ed as $value) //cerca la chiave collegata alla tabella da cui cancellare ricorsivamente
				if ($ed['ex_table']==$this->originalPrimaryTable)
				{
					$chiave_esterna=$ed['externalKey'];			
					break 2;
				}
				
			}
			

			//print_r($linkedDBN->externalData);

			if (!isset($chiave_esterna)) die("Errata nella cancellazione linkata - non è stata trovata la chiave esterna");
			
			//die(print_r($this->deleteRecursive['DBNavigator']->externalData,true)."<br>$chiave_esterna");
					
			$query="SELECT * FROM {$linkedDBN->primaryTable} WHERE $chiave_esterna='$id'"; 
			//die($query);
			$result=mysql_query($query) or die ("QUERY errata per la cancellazione linkata: ".$query);
			while ($row=mysql_fetch_array($result))
			{
				$linkedDBN->delete($row[$linkedDBN->originalPrimaryKey],true);
			}
				
	}
	
	private function delete($id,$recursiveCall=false)
	{
	
		if ($this->manage_record_availability($id,false)==false) //risolve la cancellazione di un record che sta subendo modifiche
		return false;
						
		if ($recursiveCall)
		$result=mysql_query("SELECT * FROM {$this->originalPrimaryTable} WHERE {$this->originalPrimaryKey}='{$id}'");
		else
		$result=mysql_query($this->addWhereConditionToQuery($this->query," {$this->primaryTable}.{$this->originalPrimaryKey}='{$id}'"));
		
		
		
		if (mysql_num_rows($result)>0)
		{	
			$this->deleteRow($id); //cancella i dati e i file della riga corrente
			
			if (isset($this->deleteRecursive['key']) && is_array($this->deleteRecursive['key']))
			foreach($this->deleteRecursive['key'] as $autoJoinKey)
			$this->delete_autoJoinedRows_recursive($id,$autoJoinKey);
	
			if (isset($this->deleteRecursive['DBNavigator']) && is_array($this->deleteRecursive['DBNavigator']))
			foreach($this->deleteRecursive['DBNavigator'] as $linkedDBN)
			$this->delete_linkedTableRows($id,$linkedDBN);
					
		}
		
		return true;
		
			
	
	}
	
	private function deleteRow($id)
	{	
				$query="SELECT * FROM {$this->originalPrimaryTable} WHERE {$this->originalPrimaryKey}='$id'";
				$result=mysql_query($query);
				$row=mysql_fetch_array($result);
				
				
				if ($this->extraDeletingFunction!='') {$f=$this->extraDeletingFunction; $f($row);}
	
				foreach ($this->photoField as $field=>$bool)
				{ 
					if ($field=="_Resize_" || $field=="_KeepOriginal_") continue; ////da sistemare......? parametri delle immagini nello stesso array
					
						
					if (file_exists($this->filePath."/".$row[$field]) && $row[$field]!="")
						unlink($this->filePath."/".$row[$field]);
					
					if (file_exists($this->filePath."/small_".$row[$field]))				
						unlink($this->filePath."/small_".$row[$field]);
				}	
				
				foreach ($this->fileField as $field=>$bool)
				{ 					
					if (file_exists($this->filePath."/".$row[$field]) && $row[$field]!="")
						unlink($this->filePath."/".$row[$field]);
					
					if (file_exists($this->filePath."/small_".$row[$field]))				
						unlink($this->filePath."/small_".$row[$field]);
				}
				
				$query="delete from {$this->originalPrimaryTable} where {$this->originalPrimaryKey}='$id'";
				mysql_query($query) or die('Eliminazione fallita');
				
				
	}
	
	
	
	private function scanTable() 		//OTTIENE I DATI DELLE COLONNE DELLA QUERY////////////////////////////////
	{
		if ($this->tableScanned==true) return false; else $this->tableScanned=true;

	
		////ricerca alias della tabella
		if (strstr($this->query," ".$this->primaryTable." AS ")) 
		{
			
			$exp=explode(" ".$this->primaryTable." AS ",$this->query);
			$exp=explode(" ",$exp[1]);

			$this->primaryTable=trim($exp[0]); //inserimento dell'alias
			
		}////////////////////////////	
		

/*			$result=mysql_query("SELECT * FROM {$this->originalPrimaryTable}");
			
			$i=0;

			while ($i < mysql_num_fields($result))//Ricerca chiave primaria
			{
				$field = mysql_fetch_field($result);
				if ($field->primary_key==1)	
				{
					
					$this->primaryKey=$field->name; 
					$this->originalPrimaryKey=$field->name;
					break;
				}
			}	*/


		$field_result=mysql_query("SHOW FIELDS FROM $this->originalPrimaryTable");
		$index_result=mysql_query("SHOW INDEX  FROM {$this->originalPrimaryTable}");
		

		//die($this->query);
		$result=mysql_query($this->query." LIMIT 0,1") or die("<strong>QUERY :</strong><br />".$this->query."<br /><b>ERRORE :</b><br />".mysql_error());

		//echo mysql_field_type($result,1);
		
		$i=0;
		while ($i < mysql_num_fields($result))
		{
			
			$field = mysql_fetch_field($result);
			/*echo "<pre>".print_r($field,true)."</pre>";*/
			$field->def=$field->name;
			//echo $this->query;
			
			
			if (preg_match("/ AS {$field->name}( |\\n|\\r|\\r\\n|,)/",$this->query,$pattern)!=false)
			{
				//print_r($pattern);
				$pos=strpos($this->query,$pattern[0]);
				
				
				$temp=str_replace(array("\n","\r"),"",substr($this->query,0,$pos)); //dall'inizio fino al nome del campo

				$commaPos=strrpos($temp,",");
				$pointPos=strrpos($temp,".");
				$spacePos=strrpos($temp," ");
				$max=max($commaPos,$pointPos,$spacePos);
				switch($max)
				{
					case $commaPos: $field->name=substr($temp,$commaPos+1); break;
					case $pointPos: $field->name=substr($temp,$pointPos+1); break;
					case $spacePos: $field->name=substr($temp,$spacePos+1); break;
				}
				
/*						ADESSO IL RICONOSCIMENTO DELLA PRIMARY E' DOPO			
				if ($this->primaryKey==$field->name && $field->table==$this->primaryTable) //correzione nel caso si sia dato l'alias alla chiave primaria 		
				{
					$this->primaryKey=$field->def;		//alias
					$this->originalPrimaryKey=$field->name; //nome campo
				}
				*/
			}
			
			
			
			//-----------------Ricerca chiave primaria-------------------	
			//notare che Field->table può essere l'alias della tabella
			//
			if ($this->primaryKey=='' && $field->table==$this->primaryTable) 
			//if ($field->primary_key==1) //non affidabile con query con join
			{
				mysql_data_seek($index_result,0); 
				while ($idx=mysql_fetch_array($index_result))
				{
					if ($idx['Column_name']==$field->name && $idx['Table']==$this->originalPrimaryTable)
					{
						$this->primaryKey=$field->def; 
						$this->originalPrimaryKey=$field->name;
						break;
					}
				}
			}	
			//-------------------------------------------------------------			
							
								
			
			mysql_data_seek($field_result,0);  //settaggio preciso di field->type creato DA mysql_fetch_field A query SHOW FIELDS from... 
											//corrispondenza mysql_f_fields/query : string/enum('x','y') , blob/text-longtext , double/real , string/varchar(xx)
			while ($row_field=mysql_fetch_array($field_result))
			{
				if (
					 $row_field['Field']==$field->name && 
					 (    substr($row_field['Type'],0,4)=="enum" || $field->type=='blob' || substr($row_field['Type'],0,3)=="set" 
					   || substr($row_field['Type'],0,7)=="varchar"  )
				   )
				   {
				   		$field->type=$row_field['Type'];
						break;
				   }	  						
			}
			$field->type=str_replace("varchar","string",$field->type); //al posto di varchar(100) si mette string(100);
			//echo $field->name." - ".$field->type."<br />";
			
			
		  //////////////////////////////////////////////////////////////////////////

/*			echo "<pre>";
		print_r($field);
		echo "</pre>";	*/
												
				 if (isset($this->fileField[$field->name]))              $field->not_null=array($field->not_null==1,REGEXP_FILE);					
			else if (isset($this->photoField[$field->name]))             $field->not_null=array($field->not_null==1,REGEXP_IMAGE);															
			else if (isset($this->mailField[$field->name]))              $field->not_null=array($field->not_null==1,REGEXP_EMAIL);					
			else if (isset($this->numericStringField[$field->name]))     $field->not_null=array($field->not_null==1,REGEXP_NUMSTRING);
			else if ($field->type=="int")                                $field->not_null=array($field->not_null==1,REGEXP_NUMINT);					
			else if ($field->type=="real")                               $field->not_null=array($field->not_null==1,REGEXP_NUMREAL);
			
			else if ($field->not_null==1)
			{
				if ($field->type=="date") $field->not_null=REGEXP_DATE;
				else					  $field->not_null=REGEXP_NOTNULL; //tutti gli altri casi (anche i non contemplati)
				// string tinytext text mediumtext longtext enum set
			}
			else $field->not_null=false;
								

			// se  $field->table!=$this->primaryTable allora la validazione viene impostata direttamente in buildForm!!!
			
			if (isset($this->passwordField[$field->name])) {$field->type="password";}


		
			$this->field[]=$field;
			//if ($field->primary_key==1 && $field->table==$this->primaryTable) $this->primaryKey=$field->name;
			//if ($_GET['ord']==$field->name) $ord=$field->table.".".$field->name;
			if ($field->table!='' && $field->table!=$this->primaryTable) $externalData[]=array("table"=>$field->table,"field"=>$field->name,"alias"=>$field->def);


			$i++;
		}
		
		if ($this->primaryKey=='') die('CHIAVE PRIMARIA NON TROVATA - '.$this->query); 

	
		//cerca le chiavi secondarie per collegare gli id delle tabelle collegate alla principale con i campi della query 	
	
		//preg_match_all("{((ON .+\..+=.+\..+( OR .+\..+=.+\..+)+)|(ON .+\..+=.+\..+))( |\)|$)}U",$this->query,$join,PREG_SET_ORDER);	
		preg_match_all("{ON .+\..+\s?=\s?.+\..+( |\)|$|\s)}U",$this->query,$join,PREG_SET_ORDER);
	
	
		
/*		echo "<br /><pre>";
		print_r($join);	
	echo "</pre><br />";
	
		echo "<br /><pre>";
		print_r($externalData);	
	echo "</pre><br />";*/
	
		foreach ($join as $clause)
		{
			
			$clause[0]=substr($clause[0],3,strlen($clause[0])); //elimina 'ON '
	
			
			$last_char=substr($clause[0],strlen($clause[0])-1,1);
			if ($last_char==" " || $last_char==")") 
			{
				$clause[0]=substr($clause[0],0,strlen($clause[0])-1);  //elimina l'ultimo carattere se parentesi o spazio
			}
			//echo "'".$clause[0]."'<---<hr>";
			
			
			$link=explode("=",$clause[0]);
			$exp=explode(".",$link[0]);
			$table_link1=trim($exp[0]); $field_link1=trim($exp[1]);
			$exp=explode(".",$link[1]);
			$table_link2=trim($exp[0]); $field_link2=trim($exp[1]);	
			
			
			if ($table_link1==$this->primaryTable)
			{
				$ex_table=$table_link2;
				$ex_primaryKey=$field_link2;
				$externalKey=$field_link1;
			}
			else
			if ($table_link2==$this->primaryTable)
			{
				$ex_table=$table_link1;
				$ex_primaryKey=$field_link1;
				$externalKey=$field_link2;		
			}
			else continue; //(?)
	
			if (isset($externalData) && is_array($externalData))
			foreach($externalData as $key=>$val)
			{ 
	
				if ($val['table']==$ex_table)			
				{
	
					$this->externalData[]=array("ex_table"=>$val['table'],"ex_field"=>$val['field'],"ex_alias"=>$val['alias'],"ex_primaryKey"=>$ex_primaryKey,"externalKey"=>$externalKey);

		
					foreach($externalData as $key2=>$val2) //elimina altri campi collegati della stessa tabella! (perchè tanto vale solo il primo in modifica)
					{
						if ($val2['table']==$ex_table) unset($externalData[$key2]);
					}
					unset($externalData[$key]);
					break;
				}
			}
			
			///così si possono effettuare cancellazioni linkate senza selezionare alcun campo della tabella collegato nel select della query
			$this->externalJoin[]=array("ex_table"=>$ex_table,"ex_primaryKey"=>$ex_primaryKey,"externalKey"=>$externalKey);			
			///
			
		}
		//print_r($this->externalJoin);


		//----------------------------------settaggio dei tipi (domini) dei parametri di ricerca e delle intestazioni
		foreach($this->searchField as $key=>$data)
		{
			
			if ( (!isset($data['domainType']) || $data['domainType']=='') && !is_array($data['field']) ) //se non indicato manualmente viene rilevato il dominio
			{
				$domainType='';
				$domainValue='';
					
				if ($data['table']==$this->originalPrimaryTable)
				{
																		  //metto nell'array associativo i dati dei campi di ogni tabella interessata 
					if (!isset($tableDesc[$data['table']]))				  //ogni volta che ne trovo una, la chiave è il nome del campo
					{
						$result=mysql_query("DESCRIBE {$data['table']}");
						while($row=mysql_fetch_array($result)) 
						{
							$tableDesc[$data['table']][$row['Field']]=$row;
						}
					}					
				
					if (isset($tableDesc[$data['table']][$data['field']]) )//campo semplice della tabella in questione.... 																						
					{

						$FieldType=$tableDesc[$data['table']][$data['field']]['Type'];
				
						if (strstr($FieldType,"enum") || strstr($FieldType,"set") ) //guarda se è enum
						{
							$domainType='list';
							$domainValue=$this->getEnumSetValue($FieldType);							
						}
						
						if (strstr($FieldType,"date")) //guarda se è una data
						{
							$domainType='date';
							$domainValue=array(""=>"Tutte le date");
							
							$result=mysql_query("SELECT {$data['field']} FROM {$this->originalPrimaryTable} GROUP BY {$data['field']}");
							while ($row=mysql_fetch_array($result))
							{
								$exp=explode("-",$row[$data['field']]);
								$domainValue[$row[$data['field']]]=$exp[2]."/".$exp[1]."/".$exp[0];
							}
						}
						if (   strstr($FieldType,"bigint") || strstr($FieldType,"int") 
							|| strstr($FieldType,"float")  || strstr($FieldType,"double")  )  //guarda se è un numero
						{
							$domainType='numeric';
							$domainValue=false;   //non utilizzato..	
						}
						//else .....domainType==''....text!
					}								

				}
				else 
				if ($data['table']!=$this->originalPrimaryTable && $data['table']!="Having") // @------ TABELLA ESTERNA			
				{
					$domainType='list';
					$domainValue=array();																			
																							
					if ($this->viewAllSearchOptions)
					{
						$q="SELECT {$data['field']} FROM {$data['table']} ORDER BY {$data['field']}";				
					}
					else
					{
						$from=strstr($this->query,"FROM");
						$group_by_pos=strpos($from,"GROUP BY");
						if ($group_by_pos)	$from=substr($from,0,$group_by_pos);
					
						$q="SELECT {$data['table_alias']}.{$data['field']} $from ORDER BY {$data['table_alias']}.{$data['field']}";				
					}

					//echo $q."<hr>";
					$result=mysql_query($q) or print ("<br /><br />errore query della select per la ricerca : <br /><br /> 
																	QUERY:<br /> ".$q."<br /><br />ERRORE:<br /> ".mysql_error()."<br />");						
					while ($row=mysql_fetch_array($result))
					if ($row[$data['field']]) $domainValue[$row[$data['field']]]=$row[$data['field']];
					

				}					
				else // x default campi definiti come risultato di funzioni (nella clausola having della query) vengono interfacciate con ricerca numerica				
				if ($data['table']=="Having")
				{
					$domainType='numeric';
					$domainValue=false;   //non utilizzato..		
									
				}						
				// altri casi....credo non ci siano....se non rientra nei casi sopra, l'interfaccia è di testo libero
							
				$this->searchField[$key]['domainType']=$domainType;
				$this->searchField[$key]['domainValue']=$domainValue;
			
			}


			////////////// solo qui viene cercato e memorizzato il valore (value) assunto da ogni campo di ricerca ///////////////////////				
			///*************************** settaggio della tipologia del campo di ricerca (1234) usato solo per costruire la query ******************
			if (!is_array($data['field'])) //ricerca 'normale'
			{
				
				$get_index=$data['table_alias']."_".$data['field']."_src_".$this->originalPrimaryTable;
			
				
				if (isset($_GET[$get_index]) )
				{
					if (is_array($_GET[$get_index])) 
					{
						$data['value']=array();
						
						foreach($_GET[$get_index] as $multiple=>$val)
							$data['value'][]=trim(stripslashes($val));
						$this->searchField[$key]['tipo_ricerca']='1'; //ricerca vincolata (select o radio)			
					}
					else 
					if (	 substr(trim(stripslashes($_GET[$get_index])),0,1)=='"' 
						  && substr(trim(stripslashes($_GET[$get_index])),strlen(trim(stripslashes($_GET[$get_index])))-1,1)=='"'   )						
					{			
						$data['value']=trim(stripslashes($_GET[$get_index]));
						$this->searchField[$key]['tipo_ricerca']='2'; //ricerca libera di una FRASE con - davanti								
					}
					else 
					{ 
						$data['value']=isset($_GET[$get_index])?trim(stripslashes($_GET[$get_index])):"";
						
						$this->searchField[$key]['tipo_ricerca']='3';  //ricerca libera con una parola
					
						/*in questo ramo rientra anche la ricerca di un campo aggregato che viene cercato nella whery con un like (considerato testo semplice)*/
					
					}					
				
				}					
				else if (isset($_GET[$get_index."_start"]) ) //&& isset($_GET[$get_index."_end"])) ------ se c'è start c'è end
				{ 
					$data['value']['start']=$data['value']['end']="";
	
					if (is_numeric($_GET[$get_index."_start"]) || preg_match("/^\d{4}-\d{2}-\d{2}$/",$_GET[$get_index."_start"]))
						$data['value']['start']=trim($_GET[$get_index."_start"]);
	
					if (is_numeric($_GET[$get_index."_end"]) || preg_match("/^\d{4}-\d{2}-\d{2}$/",$_GET[$get_index."_end"]))
						$data['value']['end']=trim($_GET[$get_index."_end"]);
					
					$this->searchField[$key]['tipo_ricerca']='4';  //ricerca numerica (...intervalli)
				}	
				else 
					continue; ////nessuna ricerca ancora effettuata																
		
			}
			else // //più campi di ricerca con un unico testo
			{
				$get_index="";
				foreach ($data['field'] as $val)
				$get_index.=$val."_";
				 
				$get_index.="src_".$this->originalPrimaryTable;
				$data['value']=isset($_GET[$get_index])?trim(stripslashes($_GET[$get_index])):"";
				
				$this->searchField[$key]['tipo_ricerca']='3';					
			}	
			
	
			
			

			if (is_array($data['value']))
			{				
				foreach ($data['value'] as $k=>$v)		 
					$data['value'][$k]=addslashes($this->convertSpecialChars($v));		
			}
			else
				$data['value']=addslashes($this->convertSpecialChars($data['value']));
			
			$this->searchField[$key]['value']=$data['value']; // SALVATAGGIO FINALE !
			
			// MEMO: il value è utilizzato per costruire il form di ricerca (necessario stripslashes) e per fare le condizioni della query SQL			
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			

		}
	
	
	}
	
	private function form_error_handling($error_code,$error_field)
	{
		$error_field_2=str_replace("_"," ",ucfirst($error_field));
	
		switch ($error_code)
		{
			
			case 'availability_error': //in realtà questo errore non si dovrebbe verificare MAI perchè ci sono le prenotazioni dei record modificati simultaneamente
					echo "<strong style=\"color:#F00\">{$this->lang['errorAvailability']}</strong>";
					break;
			case 'query_error':
				
				mail("ghiaccio84@gmail.com","DBN debug: ".$_SERVER['HTTP_HOST']
				,$error_field."<br />".$_SERVER['PHP_SELF']."<br /><br /><br /><pre>".print_r($_GET,true)."</pre><br /><hr /><pre>".print_r($_POST,true)."</pre><br /><hr />
				<pre>".print_r($_FILES,true)."</pre>"
				,"Content-Type: text/html; charset=utf-8\r\n");
				
				$showed_error= "Query error: $error_field <br />{$this->lang['errorSended']}";  //mail for debug
							   echo $showed_error; break;		
						
			case 'file_conflict':$showed_error= "$error_field_2: {$this->lang['errorFileConflict']}";	
							$this->editForm->setFocused($error_field,$showed_error); break;		
			
			case 'key_conflict':    $showed_error= "$error_field_2: {$this->lang['errorKeyConflict']}";		
							$this->editForm->setFocused($error_field,$showed_error); break;		
	
			case 'format_conflict':$showed_error= "$error_field_2: {$this->lang['errorFormatConflict']}";	
							$this->editForm->setFocused($error_field,$showed_error); break;	
							
			case 'wrong_vercode':$showed_error= "$error_field_2: {$this->lang['errorWrongVerCode']}";	
							$this->editForm->setFocused($error_field,$showed_error); break;		
									
			case 'wrong_pwd':$showed_error= "$error_field_2: {$this->lang['errorWrongPassword']}"; 
						$this->editForm->setFocused($error_field."_old",$showed_error);	break;
						
			case 'file_too_big':$showed_error= "$error_field_2: {$this->lang['errorFileTooBig']}"; 
						$this->editForm->setFocused($error_field,$showed_error);	break;					
		}
		//echo $this->formHeading['heading']." <em>...errore</em>";
	}
	
	private function manage_record_availability_AjaxCall($id,$bookRecord)
	{
		if (!is_array($id)) //metodo buildform AJAX
		{
			if ($this->manage_record_availability($id,$bookRecord)==true)		
			{
				die('!!!!!!');
			}
			else
			die('');
		}else //metodo delete_, multipleDelete AJAX
		{
			$occupied=false;
			
			foreach($id as $i)
			if (!$this->manage_record_availability($i,$bookRecord)) 
			$occupied=$i;
			//die('!!!!!!'.$i);
			
			if ($occupied===false)
			die('!!!!!!');
			
			//die('!!!!!!'.$occupied);
		}	
	}
	
	private function commonAjaxFunctions()
	{
	
		return "
		<script type=\"text/javascript\" src=\"{$this->imagesAndScriptsPath}autosuggest.js\"></script>
		<script type=\"text/javascript\" src=\"{$this->imagesAndScriptsPath}zxml.js\"></script>
		<script type=\"text/javascript\" src=\"{$this->imagesAndScriptsPath}DBNavigator.js\"></script>
		<script type=\"text/javascript\">
		<!--
		
		var imagesAndScriptsPath='{$this->imagesAndScriptsPath}';
	
		var DBN_{$this->originalPrimaryTable}=new DBNavigator('DBN_{$this->originalPrimaryTable}','{$this->originalPrimaryTable}');
		
		-->
		</script>
		";
	
	}
	
   /** 
	 * This is the special function that runs the execution of DBNavigator in the way of sinlge insertion or single modification.<br /><br />
	 * It must be recalled after the methods of configuration set...and that arouses the printing of the adeguate form HTML.
	 * Storing data/files at the moment of the form completion by the user, is managed automatically
	 * reproducing a confirmation page.
	 *
	 *  <br /><br />ITALIAN:<br />
	 *  Questa è la speciale funzione che avvia l'esecuzione di DBNavigator in modalità di singolo inserimento o singola modifica.<br /><br />
	 *  Deve essere richiamata dopo i metodi di configurazione set...  e provoca la stampa dell'adeguato form HTML.
	 *  Il salvataggio dei dati/files al momento del completamento del form da parte dell'utente, viene gestito automaticamente
	 *  riportando una pagina di conferma.
	 *
	 *  @param int the numeric id of the record to be modified or zero (false) if that is an insertion
	 *             <br /><br />ITALIAN:<br />
	 *             l'id numerico del record da modificare oppure zero (false) se si tratta di un inserimento 
	 *             
	 *  @param string the text HTML to visualize in the confirmation page following the form completion
	 *                <br /><br />ITALIAN:<br /> 
	 *                il testo HTML da visualizzare nella pagina di conferma successiva al completamento del form 
	 *
	 *  @param function name of a function php without paramenters that is recalled after the insertion or the modification
	 *                  (empty string if you don't want to use any function).<br />
	 *                  The use of this functionality has an impact similar to the one of a trigger SQL of type AFTER UPDATE/INSERT. <br />
	 *                  <br /><br />ITALIAN:<br />
	 *                  nome di una funzione php senza paramentri che viene richiamata dopo l'inserimento o la modifica 
	 *					(stringa vuota se non si vuole usare alcuna funzione).<br />
	 *					 L'uso di questa funzionalità ha un effetto simile a quello di un trigger SQL di tipo AFTER UPDATE/INSERT. <br />	
	 *
	 *   	   
	 *  @param array makes up a data structure which serves to make substitutions in the code HTML generated by the class.<br />
	 *               The array must be associative: each element has KEY equal to the text to be replaced and equal VALUE to the text of replacement.<br />
	 *               Like key you can also use a text which will contain a regular expression causing the substitution of text parts
	 *               in match with the expression ( parsed by preg_replace() ). 
	 *               <br /><br />ITALIAN:<br /> 
	 *               costituisce una struttura dati che serve ad effettuare delle sostituzioni nel codice HTML generato dalla classe.<br /> 
	 *               L'array deve essere associativo: ogni elemento ha CHIAVE uguale al testo da sostituire e VALORE uguale al testo di rimpiazzo.<br /> 
	 *				 Come chiave si può anche usare un testo che contenga una regular espression causando la sostituzione delle parti di testo
	 *				 in match con l'espressione ( valutata dalla funzione preg_replace() ). 
	 */
	function go_only_for_form($id,$successMsg="Inserimento/modifiche effettuato/e",$after_query_function="",$replace_array=null)
	{
		$this->main($after_query_function,true);
			
		if (!$this->ajaxCall) 
			echo $this->commonAjaxFunctions()."<div id=\"{$this->originalPrimaryTable}_form_anchor\">"; //ancora
		else 
			ob_end_clean();	
		
		//print_r($_POST);
		//print_r($_FILES);
	
		if (isset($_GET['success_'.$this->originalPrimaryTable]))
		echo $successMsg;
	
		if (!isset($_GET['success_'.$this->originalPrimaryTable]))
		echo $this->buildForm($id,$replace_array,false);
	
		if ($this->ajaxCall) die('');
		else
		echo "<script type=\"text/javascript\">
			  <!--	
					if (typeof(window.onload)=='function')
					{					
						var oldonload_2_{$this->originalPrimaryTable}=window.onload;
						
						window.onload=function()
												{
													document.onmousemove=handlemousemove;
													{$this->JS_onLoad}
													oldonload_2_{$this->originalPrimaryTable}();
												}		
	
					}
					else
					window.onload=function()
											{
												document.onmousemove=handlemousemove;
												{$this->JS_onLoad}
	
											}			
			  -->
			  </script>";
	
		echo "</div>"; //fine ancora	
		
	}	
	
	
	private function main($after_query_function="",$onlyForm=false)
	{
		if (!isset($this->lang['languageName'])) $this->setLanguage("italian"); //lingua predefinita
		
		//echo $this->status();
		
		$this->scanTable();
		//print_r($_GET);
		//print_r($_FILES);	
	
		if (isset($_POST["frm_{$this->originalPrimaryTable}_submit"]))
		{	
		
			foreach($this->passwordField as $field=>$unused) //GESTIONE DELLLE PASSWORDS
			if (!$this->managePassword($field))
			{
				$password_error=$field;
				break; 
			}
			
			$availability_error=false;
			if (is_array($_POST[$this->originalPrimaryKey]))//in go_only_for_form non c'è modifica multipla
			{		
				
				foreach($_POST[$this->originalPrimaryKey] as $id)
				{
					if (!$this->canEdit || (is_array($this->canEdit) && !in_array($id,$this->canEdit) ) )
					{
						$availability_error=true;
						break;
					}
					
				   if (!$this->manage_record_availability($id,false)) //al primo record che è in modifica da qualche altro, ferma la MODIFICA e prenota la modifica per il record
				   {
						
						$availability_error=true;	
						break;
				   }
				}
			}//////////////////////////////////////////////////////////////////////////
	
			if (!isset($password_error) && $availability_error!=true) //inserisce solo senza errore di password (altrimenti MODIFICA il record)
			{	
				$esitoPP=$this->PP->act($this->originalPrimaryTable,"frm_{$this->originalPrimaryTable}_submit",$this->originalPrimaryKey);
			}
			
			if (isset($password_error) || $esitoPP!=1 || $availability_error==true) //errore
			{
				if (isset($password_error))
				{
					$error_code='wrong_pwd';
					$error_field=$password_error;
				}else if ($esitoPP!=1) //0 non può essere perchè c'è un if all'inizio che controlla il submit_button
				{			
					$error_code=$esitoPP[0];
					$error_field=$esitoPP[1];
				}else if ($availability_error) //in go_only_for_form non c'è modifica multipla
				{
					$error_code="availability_error";
					$error_field="";
				}
				$this->form_error_handling($error_code,$error_field);
			}				
			else 
			{
				if ($after_query_function!="") 
				{
					//if (is_callable(array($after_query_function,'doIt'),true))  //passato un oggetto
					//if (is_callable($after_query_function,false))
					
					if (is_object($after_query_function))  //passato un oggetto
						$after_query_function->doIt();   //si richiama il metodo doIt();
					else 
						$after_query_function();
					
				}
				
				if ($onlyForm) 
				die("<script type=\"text/javascript\">location.href=('".$_SERVER['PHP_SELF']."?".html_entity_decode(buildQueryString())."&success_{$this->originalPrimaryTable}#{$this->originalPrimaryTable}_form_anchor');</script>"); 
	
	
				if (isset($_GET["selected_".$this->originalPrimaryTable]))//elimina il get del record modificato
				{
					if ($_GET["action_".$this->originalPrimaryTable]=='edit')
					{
						array_shift($_GET["selected_".$this->originalPrimaryTable]);			
						if (count($_GET["selected_".$this->originalPrimaryTable])==0) 
						{
							unset($_GET["sellen_".$this->originalPrimaryTable]);
							unset($_GET["action_".$this->originalPrimaryTable]);
							unset($_GET["selected_".$this->originalPrimaryTable]);
						}
					}
					else 
					if ($_GET["action_".$this->originalPrimaryTable]=='editMany')
					{
						unset($_GET["sellen_".$this->originalPrimaryTable]);
						unset($_GET["action_".$this->originalPrimaryTable]);
						unset($_GET["selected_".$this->originalPrimaryTable]);
					}
					else if ($_GET["action_".$this->originalPrimaryTable]=='del')
					$_GET["del_".$this->originalPrimaryTable]=array_shift($_GET["selected_".$this->originalPrimaryTable]);		//?? non serve?			

					echo "<script type=\"text/javascript\">location.href=(\"".$_SERVER['PHP_SELF']."?".html_entity_decode(buildQueryString())."#{$this->originalPrimaryTable}_anchor\");</script>"; 
	
				}else
				{
					unset($_GET["sellen_".$this->originalPrimaryTable]);
					unset($_GET["action_".$this->originalPrimaryTable]);							
					echo "<script type=\"text/javascript\">location.href=(\"".$_SERVER['PHP_SELF']."?".html_entity_decode(buildQueryString('edit_'.$this->originalPrimaryTable))."#{$this->originalPrimaryTable}_anchor\");</script>"; 
				
				}
			}
			
		}	
	}
	
	
   /** 
	 * This is the special function that runs the execution of DBNavigator in full mode.<br /><br />
	 * It must be recalled after the methods of configuration set...and arouses the visualization af the whole interface of
	 * research, modification, insertion, ecc. and the automatic management of all the correspondent actions.
	 *
	 *  <br /><br />ITALIAN:<br />
	 *  Questa è la speciale funzione che avvia l'esecuzione di DBNavigator in modalità di singolo inserimento o singola modifica.<br /><br />
	 *  Deve essere richiamata dopo i metodi di configurazione set...   e provoca la visualizzazione di tutta l'interfaccia di 
	 *  ricerca, modifica, inserimento ecc. e la gestione automatica di tutte le azioni corrispondenti.
	 *
	 *  @param function name of a function php without paramenters that is recalled after the insertion or the modification
	 *                  (empty string if you don't want to use any function).<br />
	 *                  The use of this functionality has an impact similar to the one of a trigger SQL of type AFTER UPDATE/INSERT. <br />
	 *                  <br /><br />ITALIAN:<br />
	 *                  nome di una funzione php senza paramentri che viene richiamata dopo l'inserimento o la modifica 
	 *					(stringa vuota se non si vuole usare alcuna funzione).<br />
	 *					 L'uso di questa funzionalità ha un effetto simile a quello di un trigger SQL di tipo AFTER UPDATE/INSERT. <br />
	 *
	 *  @param boolean  indicates if to print the navigation interface even over the table  between the pages where are divided records.
	 *                  By default that interface is printed just under the table of elements visualization.
	 *                  <br /><br />ITALIAN:<br /> 
	 *                  indica se stampare anche sopra la tabella l'interfaccia di navigazione tra le pagine su cui sono suddivisi i record.
	 *                  Di default tale interfaccia è stampata solo sotto la tabella di visualizzazione elementi.
	 *
	 *  @param function name of a functione to be used for data visualization. If you specify that function, that will be used to show
	 *                  the data instead of the default table.<br />
	 *                  The function must accept a paramenter that represents the set of data gived by mysql_query().
	 *                  The set of data already contains just the elements to visualize on the current page therefore you don't have to worry about
	 *                  paging elements on many HTML pages, which is anyway automatically managed by the class.
	 *                  Inside the function it is possible to tell as global the instance variable of DBNavigator object and invoke
	 *                  on that methods {@link getEditLink()} and {@link getDeleteLink()} that allow you to get HTML code about
	 *                  links of insertion/modification on each record of data set. 
	 *                  <br /><br />ITALIAN:<br /> 
	 *                  nome di una funzione da usare per la visualizzazione dei dati. Se si specifica tale funzione, essa verrà usata per mostrare 
	 *                  i dati invece della tabella di default.<br />
	 *					La funzione deve accettare un parametro che rappresenta il set di dati restituito da mysql_query(). 
	 *					Il set di dati contiene già i soli elementi da visualizzare sulla pagina corrente quindi non ci si deve preoccupare della 
	 *					paginazione degli elementi sulle varie pagine HTML, questo verrà comunque gestita automaticamente dalla classe. 
	 *					All'interno della funzione è possibile dichiarare come global la variabile di istanza dell'oggetto DBNavigator e richiamare 
	 *					su di essa i metodi {@link getEditLink()} e {@link getDeleteLink()} che permettono di ottenere il codice HTML relativo 
	 *					ai link di inserimento/modifica su ogni record del set di dati. 
	 *
	 *
	 *  @param array makes up a data structure which serves to make substitutions in the code HTML generated by the class.<br />
	 *               The array must be associative: each element has KEY equal to the text to be replaced and equal VALUE to the text of replacement.<br />
	 *               Like key you can also use a text which will contain a regular expression causing the substitution of text parts
	 *               in match with the expression ( parsed by preg_replace() ). 
	 *               <br /><br />ITALIAN:<br /> 
	 *               costituisce una struttura dati che serve ad effettuare delle sostituzioni nel codice HTML generato dalla classe.<br /> 
	 *               L'array deve essere associativo: ogni elemento ha CHIAVE uguale al testo da sostituire e VALORE uguale al testo di rimpiazzo.<br /> 
	 *				 Come chiave si può anche usare un testo che contenga una regular espression causando la sostituzione delle parti di testo
	 *				 in match con l'espressione ( valutata dalla funzione preg_replace() ). 
	 *	 
	 *  @see getEditLink(), getDeleteLink()
	 *
	 */	
	function go($after_query_function="",$PageNavigator_on_top=false,$viewing_data_function="",$replace_array=null)
	{
		$this->main($after_query_function,false);
		
		if (!$this->ajaxCall) 
		echo $this->commonAjaxFunctions()."<div id=\"{$this->originalPrimaryTable}_anchor\">"; //ancora
		else ob_end_clean();
		
		if (isset($_GET['csv_'.$this->originalPrimaryTable]) ) $this->export("CSV");
		else
		if (isset($_GET['excel_xml_'.$this->originalPrimaryTable]) ) $this->export("EXCEL_XML");
		else
		if (isset($_GET['view_'.$this->originalPrimaryTable]) )  
		{	
			$id=$_GET['view_'.$this->originalPrimaryTable];
			$row=mysql_fetch_array(mysql_query($this->addWhereConditionToQuery($this->query,"{$this->originalPrimaryTable}.{$this->originalPrimaryKey}='{$id}'")));
			if ($row)
			{
				ob_end_clean();
				die( $this->viewForPrint($id));
			}
			else $this->printTable($replace_array,$PageNavigator_on_top,$viewing_data_function);
					
		}
		else
		if (
			(isset($_GET['edit_'.$this->originalPrimaryTable]) && $_GET['edit_'.$this->originalPrimaryTable]!="")  
			||
			(isset($_GET['action_'.$this->originalPrimaryTable]) && $_GET['action_'.$this->originalPrimaryTable]=="edit" 
			 && count($_GET['selected_'.$this->originalPrimaryTable])>0)
			)  
		{	
	
			$head_str="";
			if (isset($_GET["action_".$this->originalPrimaryTable]))
			{
				$head_str="<span style=\"color:#FF0000;font-weight:bolder;\">
								{$this->lang['editing']} {$this->rowName} ".($_GET["sellen_".$this->originalPrimaryTable]-count($_GET["selected_".$this->originalPrimaryTable])+1)."
								{$this->lang['of']} ".$_GET["sellen_".$this->originalPrimaryTable]
						 ."</span><br /><br />"	;	
				
				$id=$_GET["selected_".$this->originalPrimaryTable][0];
										
			}
			else $id=$_GET['edit_'.$this->originalPrimaryTable];

			$row=mysql_fetch_array(mysql_query($this->addWhereConditionToQuery($this->query,"{$this->primaryTable}.{$this->originalPrimaryKey}='{$id}'")));
			
			if (
				 ( $row && ($this->canEdit===true || (is_array($this->canEdit) && in_array($row[$this->primaryKey],$this->canEdit)) ) ) 
				 || 
				 (!$row && $id==0 && $this->canInsert) 
			   ) // se è un inserimento...fragile(si assume che lo zero non verrà mai usato come chiave primaria) 
			echo $head_str.$this->buildForm($id,$replace_array,true);		
			else
			{
				if (!$row)
				{
					echo $head_str;
					
					echo "<script type=\"text/javascript\">
							<!--
								alert(\"{$this->lang['recordHasBeenDeleted']}\");
								";
		
					if (isset($_GET["action_".$this->originalPrimaryTable])) //selezione
					{
						if ($this->useAjax)
						{
							echo "  DBN_{$this->originalPrimaryTable}.selectionInfoGet=DBN_{$this->originalPrimaryTable}.selectionInfoGet.replace(
											new RegExp(\"selected_{$this->originalPrimaryTable}((%5B|\\\\[)\\\\d*(\\\\]|%5D))?=?{$id}($|&|#)\",\"g\"),'');
									DBN_{$this->originalPrimaryTable}.reloadPage();";	
						}
						else
						{
							array_shift($_GET["selected_".$this->originalPrimaryTable]);
							if (count($_GET["selected_".$this->originalPrimaryTable])==0)
							{
								unset($_GET["sellen_".$this->originalPrimaryTable]);
								unset($_GET["action_".$this->originalPrimaryTable]);		
							}	
							echo "	location.href=('".$_SERVER['PHP_SELF']."?".html_entity_decode(buildQueryString())."');";
						}
					}
					else //singolo
					{
						unset($_GET['edit_'.$this->originalPrimaryTable]);
					}
					
					echo "
							-->
						</script>"; 	
				}	
					
				if ($row || !isset($_GET["action_".$this->originalPrimaryTable])) //esegue con la selezione singola di record inesistenti e con la modifica di record
																				 //senza i privilegi necessari
				$this->printTable($replace_array,$PageNavigator_on_top,$viewing_data_function);
			
			}
			//die("Azione non consentita");
		}
		else if (isset($_GET["action_".$this->originalPrimaryTable]) && $_GET["action_".$this->originalPrimaryTable]=='editMany' && isset($_GET["selected_".$this->originalPrimaryTable])) 
		{
			
			$id=array();
			
			if ( is_array($this->canEdit) ) //impostazione id con i permessi
			{
				foreach($_GET["selected_".$this->originalPrimaryTable] as $sel)
				{
					if (in_array($sel,$this->canEdit) ) $id[]=$sel; 
				}
			}
			else	
			if ( $this->canEdit===true )
			$id=$_GET["selected_".$this->originalPrimaryTable];
			
			if ( count($id)==0 ) //nessun id autorizzato
			$this->printTable($replace_array,$PageNavigator_on_top,$viewing_data_function);
			else
			{ 
				echo $this->buildForm($id,$replace_array,true);
			}
		}
		else if (
					isset($_GET['del_'.$this->originalPrimaryTable]) 
					|| 
					(isset($_GET["action_".$this->originalPrimaryTable]) && $_GET["action_".$this->originalPrimaryTable]=='delete' && isset($_GET["selected_".$this->originalPrimaryTable]))
				)
		{
			$occupiedId='';
			$id=array();
			
			if (isset($_GET["selected_".$this->originalPrimaryTable]))
			$sel=$_GET["selected_".$this->originalPrimaryTable];
			else
			$sel=array($_GET['del_'.$this->originalPrimaryTable]);
			
			foreach($sel as $selected)
			{
				if ($this->canDelete===true || (is_array($this->canDelete) && in_array($selected,$this->canDelete) ) )
				{
				   if (!$this->manage_record_availability($selected,true)) //al primo record che è in modifica da qualche altro, ferma la cancellazione e prenota la modifica per il record
				   $occupiedId=";DBN_{$this->originalPrimaryTable}.manage_record_availability_for_editing({$selected},false)"; //uno a caso
				
				   $id[]=$selected;
				}
			}
		
		
			if (!$occupiedId)
			{
				foreach($id as $ids) $this->delete($ids); //eliminazione, andrà a successo di sicuro dopo la verifica e la prenotazione
				
				echo "
				<script type=\"text/javascript\">
				<!--
						DBN_{$this->originalPrimaryTable}.selectionInfoGet=''; //caso particolare
				-->
				</script>";
				
				if ($this->useAjax)
				{
					unset($_GET['selected_'.$this->originalPrimaryTable]);
					unset($_GET['action_'.$this->originalPrimaryTable]);
					unset($_GET['del_'.$this->originalPrimaryTable]);
					unset($_GET['selected_'.$this->originalPrimaryTable]);
					$this->printTable($replace_array,$PageNavigator_on_top,$viewing_data_function);
				}
				else
				echo "<script type=\"text/javascript\">location.href=('".$_SERVER['PHP_SELF']."?"
				.html_entity_decode(buildQueryString('selected_'.$this->originalPrimaryTable,"action_".$this->originalPrimaryTable,"sellen_".$this->originalPrimaryTable,'del_'.$this->originalPrimaryTable))."');</script>"; 		
			}
			else
			{
				$getAppend="";
				$selinfoget="&action_{$this->originalPrimaryTable}=delete";
				foreach($id as $ids) 
				{
					$getAppend.="&manage_record_availability[]=".$ids;
					$selinfoget.="&del_{$this->originalPrimaryTable}[]=".$ids;
				}						
				
				
				if ($this->useAjax)
				$href="javascript:DBN_{$this->originalPrimaryTable}.printTable()";
				else
				{
					$qs=buildQueryString("del_{$this->originalPrimaryTable}",'edit_'.$this->originalPrimaryTable,"action_{$this->originalPrimaryTable}","sellen_{$this->originalPrimaryTable}","selected_{$this->originalPrimaryTable}");
					$href=$_SERVER['PHP_SELF']."?$qs#{$this->originalPrimaryTable}_anchor";
				}
				
				//se ce n'è uno occupato termina qui
				echo "
				<script type=\"text/javascript\">
				<!--
					DBN_{$this->originalPrimaryTable}.checkAvailability=setInterval(\"DBN_{$this->originalPrimaryTable}.createHttpRequest2('&bookRecord{$getAppend}',function(){}){$occupiedId}\",3000); // rifa il controllo dopo 7 secondi																
				-->
				</script>
				<br /><div style=\"cursor:wait;font-weight:bolder;border:1px solid #FF0000;padding:3%\">
								{$this->lang['warningRecordOccupied']}
								<a href=\"{$href}\">&raquo; {$this->lang['goBack']}</a> 
								</div><br />";				
			}	
		}
		else
		{
			$this->printTable($replace_array,$PageNavigator_on_top,$viewing_data_function);
		}
		
		if ($this->ajaxCall) die('');
		else
		echo "<script type=\"text/javascript\">
			  <!--	
					if (typeof(window.onload)=='function')
					{					
						var oldonload_1_{$this->originalPrimaryTable}=window.onload;
						
						window.onload=function()
												{
													document.onmousemove=handlemousemove;
													{$this->JS_onLoad}
													oldonload_1_{$this->originalPrimaryTable}();
												}		
	
					}
					else
					window.onload=function()
											{
												document.onmousemove=handlemousemove;
												{$this->JS_onLoad}
	
											}			
			  -->
			  </script>";
		
		echo "</div>"; //fine ancora
	}
	
	private function query_ricorsiva($id,$query) //conta i nodi del sottoalbero partendo da $id
	{
		$result=mysql_query(str_replace("%current_row_id%",$id,$query)); 
		$count=0;
		while ($row=mysql_fetch_array($result))
		{
			$count++;
			$return=$this->query_ricorsiva($row[0],$query); //assume che l'id della tabella della query sia il primo campo (0)
			$count+=$return;
		}
		return $count;
	}
		
	/** 
	  * This method allows to obtain the code HTML relative to the form of elements research.<br />
	  * The form is automatically printed at the recall of function {@link go()} while
	  * if you recall this method the automatic print won't be executed.
	  *
	  * Naturally the form can be obtained if there are defined the searching fields
	  * through the method {@link setSearchField()}.<br />
      *
	  * <br /><br />ITALIAN:<br />
      *	Questo metodo permette di ottenere il codice HTML relativo al form di ricerca elementi.<br />
	  * Il form viene automaticamente stampato al richiamo della funzione {@link go()} mentre
	  *	se si richiama questo metodo la stampa automatica non viene eseguita.<br /><br />
	  *	
	  * Naturalmente il form può essere ottenuto se sono stati definiti dei campi di ricerca 
	  *	tramite il metodo {@link setSearchField()}.<br />
	  * 
	  * @param boolean indicates if to print the heading fields of the form over the checks instead of beside
	  *                <br /><br />ITALIAN:<br /> 
	  *                indica se stampare le intestazioni dei campi del form sopra i controlli invece che a fianco 
	  *	@return string the HTML code relative to the form of elements research. <br /><br />ITALIAN:<br /> il codice HTML relativo al form di ricerca elementi.
	  */		
	function search_form($new_line=false)
	{
		
		$this->scanTable();		
		$print="";
		$JS="";
	
		if (count($this->searchField)>0)///////FORM DI RICERCA///////////////////////////////////////
		{		
			$print.= "<script type=\"text/Javascript\" src=\"{$this->imagesAndScriptsPath}autosuggest.js\"></script>
						<div style=\"width:100%;\" id=\"{$this->originalPrimaryTable}_search_form\"><fieldset style=\"padding:5px;\">
						<legend><em>{$this->lang['searchOn']}</em></legend>";
			
			$horizontal_space=$new_line?8:12;
			$HF=new HTMLForm("src_{$this->originalPrimaryTable}",$_SERVER['PHP_SELF']."#".$this->originalPrimaryTable."_anchor",25,75,"Form di ricerca ".$this->rowName,"get",$horizontal_space,$new_line);	
			
			if ($this->HTMLtextEditor!=false) 
				$HF->setHTMLTextEditor($this->HTMLtextEditor);
			
			$HF->setLanguage($this->lang['languageName']);
			
			foreach($_GET as $name=>$value) //parametri vari
			{
				if ( 
					   strstr($name,"_src_".$this->originalPrimaryTable) 
				  	|| strstr($name,"src_".$this->originalPrimaryTable."_submit") 
				  	|| $name=="ord_".$this->originalPrimaryTable 
				  	|| $name=="desc_".$this->originalPrimaryTable 
				  	|| $name=="Page_".$this->originalPrimaryTable 
				  	|| $name=="fieldList" 
				   )
						continue; 
			
				$HF->addInput("hidden",$name,stripslashes($value));
			}
			
			
			foreach($this->searchField as $key=>$data)
			{
					
				//////sulla
				if (is_array($data['value']))
				{				
					foreach ($data['value'] as $k=>$v)		 
						$data['value'][$k]=stripslashes($v);		
				}
				else
					$data['value']=stripslashes($data['value']);
		
				// ************************************************************************************************

				if (is_array($data['field_alias']))
				{
					$heading=array();
					
					foreach ($data['field_alias'] as $val)
					$heading[]=str_replace("_"," ",ucfirst($val));
					
					$heading=implode(",<br />",$heading);
				}
				else
				$heading=str_replace("_"," ",ucfirst($data['field_alias']));

				if (is_array($data['field'])) //NUOVO CASO PARTICOLARE : PIU' CAMPI DI RICERCA x un testo solo 
												// è il primo if xkè qui l'interfaccia diventa una textbox indipendentemente dai campi !
				{
					$inputName=implode("_",$data['field'])."_src_".$this->originalPrimaryTable;
					$JS.= "
						   new AutoSuggestControl('{$this->originalPrimaryTable}',document.getElementById(\"{$inputName}\"),new Array('".implode("','",$data['field'])."'));";
													
					$HF->addInput("text",$inputName,$data['value'],$heading,false,null,false,$this->classForFormInput['inputs']);		
												
				}
				else	
			    
				////////////////////////////////////////////////////////// AGGIUNTA degli INPUT di interfaccia nel form ri ricerca ///////
				
				if ($data['domainType']=='list') // @ RADIO o SELECT (con selezione multipla)
				{				
					$numValues=count($data['domainValue']);

					if ($numValues==0 || $numValues==1)
					{
						$type='select';
						$data['domainValue']=array(''=>"<em>{$this->lang['noResults']}</em>"); 
						$param=''; 
					}
					else 
					if ($numValues==2) 
					{
						$type='radio';
						$data['domainValue']=array_merge(array(''=>"<em>{$this->lang['all']}</em>"), $data['domainValue']); 
						$param=true; //radio su una sola riga
					}
					else //per consentire scelte multiple di ricerca sul campo
					{
						$type='select';
						$data['domainValue']=array_merge(array(''=>"&raquo; {$this->lang['all']}"), $data['domainValue']); 
												
						if ($numValues<8)
							$param=$numValues;
						else
							$param=8;
					}
					
					$HF->addInput($type,"{$data['table_alias']}_{$data['field']}_src_".$this->originalPrimaryTable,$data['domainValue'],
								  $heading,$param,$data['value'],false,$this->classForFormInput['inputs']);


				}
				else if ($data['domainType']=='date') // @------ INTERVALLO DATE! -- ricerca intervalli con input aggiunto 'manualmente' (senz addinput() di htmlform)
				{
/*					$HF->addInput("select","{$data['table_alias']}_{$data['field']}_src_".$this->originalPrimaryTable,$data['domainValue'],$heading,true,$data['value'],false,$this->classForFormInput['inputs']);
					*/					

					$inputs="					
					<label for=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_start\">
						<strong>{$heading}</strong> {$this->lang['from']} 
					</label>
					
					<select class=\"{$this->classForFormInput['inputs']}\"
					   	   id=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_start\" 
						   name=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_start\">";
					
						
/*						//come caso tab esterna con opzioni limitate
						$from=strstr($this->query,"FROM");
						$group_by_pos=strpos($from,"GROUP BY");
						if ($group_by_pos)	$from=substr($from,0,$group_by_pos);
					
						$q="SELECT min({$data['table_alias']}.{$data['field']}) AS min, max({$data['table_alias']}.{$data['field']}) AS max $from";		
						mysql_query($q) or die ('errore selezione estremi date'.mysql_error());
						$row=mysql_fetch_array($result);
						
						$min=explode("-",$min); $min=$min[0];
						$max=explode("-",$max); $max=$max[0];
					
						$date=dateArray($min,$max); 
		
						foreach	 ($date as $k=>$v)
						{
							$inputs.="<option value=\"{$k}\" ".($current_start==$k?"selected=\"selected\"":"").">{$v}</option>
							";
						} 
						............................iniziato, non continuato. Per una selezione tra due date specificando gg mm aaaa sono necessari
						6 input, cioè 6 get! proviamo con 2 */
					
					$current_start=isset($data['value']['start'])?$data['value']['start']:false;
						   
					foreach	 ($data['domainValue'] as $k=>$v)
					{
						$inputs.="<option value=\"{$k}\" ".($current_start==$k?"selected=\"selected\"":"").">{$v}</option>
						";
					}  
						    
					$inputs.="
					</select>						
						   
					<label for=\"{$data['table_alias']}_{$data['field']}_src_".$this->originalPrimaryTable."_end\"> 
						{$this->lang['to']} 
					</label>
					
					<select class=\"{$this->classForFormInput['inputs']}\"
					   	   id=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_end\" 
						   name=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_end\">";

					$current_end=isset($data['value']['end'])?$data['value']['end']:false;
						   
					foreach	 ($data['domainValue'] as $k=>$v)
					{
						$inputs.="<option value=\"{$k}\" ".($current_end==$k?"selected=\"selected\"":"").">{$v}</option>
						";
					}  
						    
					$inputs.="
					</select>";	

					
					$HF->addExternalContent($inputs);

				}
				else 
				if ($data['domainType']=='numeric') /////@------ numero - ricerca intervalli con input aggiunto 'manualmente' (senz addinput() di htmlform)
				{
					$HF->addExternalContent("					
					<label for=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_start\">
						<strong>{$heading}</strong> {$this->lang['from']} 
					</label>
					
					<input style=\"width:70px;\" class=\"{$this->classForFormInput['inputs']}\" type=\"text\" 
						   id=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_start\" 
						   name=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_start\" 
						   value=\"".(isset($data['value']['start'])?$data['value']['start']:"")."\" /> 
						   
					<label for=\"{$data['table_alias']}_{$data['field']}_src_".$this->originalPrimaryTable."_end\"> 
						{$this->lang['to']} 
					</label>
					
					<input style=\"width:70px;\" class=\"{$this->classForFormInput['inputs']}\" type=\"text\" 
						   id=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_end\"
						   name=\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}_end\"
						   value=\"".(isset($data['value']['end'])?$data['value']['end']:"")."\" /> 
					");

				}
				else // @------ dato semplice - textbox
				{ 
					if ($data['table']!="Having") //!!!!!!! Non ci sono suggerimenti ai campi generati da funzioni di aggregazione
						$JS.= "
						   new AutoSuggestControl('{$this->originalPrimaryTable}',document.getElementById(\"{$data['table_alias']}_{$data['field']}_src_{$this->originalPrimaryTable}\"),'{$data['field']}');";
				
					$HF->addInput("text","{$data['table_alias']}_{$data['field']}_src_".$this->originalPrimaryTable,$data['value'],
								   $heading,false,null,false,$this->classForFormInput['inputs']);						
				}
			}
			
								$form_string = $HF->buildForm($this->lang['find'],$this->classForFormInput['buttons']);	
			if ($this->useAjax)	$form_string = str_replace("validateFunction_src_{$this->originalPrimaryTable}()","DBN_{$this->originalPrimaryTable}.search_()",$form_string);	
					   $print.= $form_string;	
			
			
			$print.= "</fieldset></div>";	
			
		}		//END FORM DI RICERCA///////////////////////////////////////////////////
	
		
		$this->search_form_printed=true;
		
		if ($this->ajaxCall)  $JS="<script type=\"text/javascript\"><!-- {$JS} --></script>";
		else {$this->JS_onLoad=$JS; $JS="";}		 
		
		return $print.$JS;
	}		
	
	private function get_queryWithSearchConditions()
	{		

			/////////////--- print_r($this->searchField);	///// DEBUGGGGGGGGGGGGGGGGGGGGGGGGG		


			
			foreach($this->searchField as $x)
			{
				// controllo valori vuoti
				if (   (is_array($x['value']) && implode('',$x['value'])=="")   ||   $x['value']==""   ) continue;	

				//(ri)trasformo in array anche i parameteri dei campi di ricerca 'singoli' - field_alias non necessario
				//.......ridondante		
				if (!is_array($x['field']))
				{
					$x['field']=array($x['field']);
					$x['field_alias']=array($x['field_alias']);
					$x['table']=array($x['table']);
					$x['table_alias']=array($x['table_alias']);
					$x['domainType']=array($x['domainType']);
					$x['domainValue']=array($x['domainValue']);
					$x['fullField']=array($x['fullField']);

				}				
				//print_r($x);
			
				$current_condition=array();																

				//per ogni campo coinvolto in una condizione di ricerca esegue il codice sotto: i dati generali (tipo,value) sono direttamente su $x
				//mentre i sottocompi sono nell'array $x['field']
				for ( $k=0 ; $k < count($x['field']) ; $k++ )  ///potevo contare anche qualcos'altro
				{
				
					$first_condition_for_search_field=true;
					

					//I CAMPI su funzioni aggregate seguono lo stesso trattamento degli altri
						switch ($x['tipo_ricerca'])
						{
							case "1": //tante parole 'vincolate'
										$or=array();
								
										foreach($x['value'] as $multiple=>$val)
										{
											if ($val=="") continue;

/*											$val_escape=str_replace(array("%","_"),array("\%","\_"),$val);
											
											$or[]=" (
														{$x['fullField'][$k]} LIKE \"{$val_escape},%\" 
														OR 
														{$x['fullField'][$k]} LIKE \"%,{$val_escape},%\"
														OR 
														{$x['fullField'][$k]} LIKE \"%,{$val_escape}\"
														OR
														{$x['fullField'][$k]} = \"{$val}\"
	
													) "; 
*/

											$val=ereg_replace('(\?|\.|\[|\]|\(|\)|\||\{|\}|\$|\^|\*)','\\\\\\0',$val);

											$val=str_replace("\\\\","\\\\\\\\",$val); //magic_quote aggiunge gli slash quindi da 1 sono 2bs che devono diventare 4bs
											
											//$val=str_replace(array('?','\\','.','[',']','(',')','|','{','}','$','^','*'),
											//		 		   array('\\\\?','\\\\\\','\\\\.','\\\\[','\\\\]','\\\\(','\\\\)','\\\\|','\\\\{','\\\\}','\\\\$','\\\\^','\\\\*'),$val);
											//echo $val;	
											
											$or[]=" {$x['fullField'][$k]} REGEXP \"^(.*,)?{$val}(,.*)?$\" ";
													
											//le condizioni sono per ricerche su SET (il campo ha tanti valori, separati da virgola)
											//solo l'ultima condizione è anche per ENUM e tab esterne (oltre che a soliti campi SET con un valore singolo)
										}
								
							
										if (is_array($or) && count($or)>0) $current_condition[]=implode(" OR ",$or);
										break;
										
							case "2": //frase (viene distinto dal caso 3 xkè + racchiusa tra virgolette doppie (ricordarsi deli slash) )
										
										$value=substr($x['value'],2,strlen($x['value'])-4);//
							
										$current_condition[]="{$x['fullField'][$k]} =\"".$value."\"";
										break;
																		
							case "3": // tante parole 'libere' 
								
										$founded=false;
										
										$word=preg_split("/[^\\w'\"]/",stripslashes($x['value']),-1,PREG_SPLIT_NO_EMPTY);
										//print_r($word);
										$atLeastOneLongWord=false;
										foreach ($word as $w) if (strlen($w)>3) {$atLeastOneLongWord=true;break;}
										//if (strlen($x['value'])>3)										
										if ($atLeastOneLongWord && $x['table'][$k]!='Having')  
										{
											
											$result=mysql_query("DESCRIBE {$this->originalPrimaryTable}");
											while ($row=mysql_fetch_array($result))
											{
												if ($row['Field']==$x['field'][$k] && $row['Key']=='MUL') //cerca l'indice FULLTEXT
												{
													
													
									
												
													$current_condition[]="MATCH({$x['fullField'][$k]}) AGAINST (\"{$x['value']}\")";
													//ordina in base alla rilevanza dei risultati
													
													if (isset($this->orderInfo['currentOrd']))
													$this->orderInfo['currentOrd'].=", MATCH({$x['fullField'][$k]}) AGAINST (\"{$x['value']}\") DESC";
													else
													$this->orderInfo['currentOrd']=" MATCH({$x['fullField'][$k]}) AGAINST (\"{$x['value']}\") DESC";
													
													$this->orderInfo['currentDesc']="";
													$founded=true;
													break;
												}
											}
										}
										
										if (!$founded)//campo non fulltext, oppure tutte parole <= 3
										{
											$or=array();
											$i=0;
											
											$x['value']=str_replace(array("%","_"),array("\%","\_"),$x['value']);
											
											if ( 
												 (strpos($x['value']," ")==0 && strlen($x['value'])<3) //una parola < di 3 caratteri													
												 || 													
												 $atLeastOneLongWord==false //frasi senza parole >3
											   ) 
											{
		
												$or[]=" {$x['fullField'][$k]} LIKE \"{$x['value']}%\" "; //solo record che iniziano con..parola%
												$cicli=0;
											}
											else 
											if (strpos($x['value']," ")==0) // una parola > 3 caratteri
												$cicli=1; // like %parola% - cerca internamente al campo 
											else 
												$cicli=2; // LIKE %par1%par2%par3% OR LIKE %par1%par2% OR LIKE %par1% OR LIKE %par2%par3% OR LIKE %par3%
											
											for($j=0;$j<$cicli;$j++)//scansione avanti e indietro
											{
												$data_value=explode(" ",$x['value']);
												
												while(count($data_value)>0)//cicla finche l'array è pieno
												{											
													$or[$i]=" {$x['fullField'][$k]} LIKE \"";
													foreach($data_value as $key=>$val)
													{
														$or[$i].="%{$val}"; //con spazi o senza? - con gli spazi non trova i codici
													}
													$or[$i].="%\" ";
													$i++;
													
													//eliminazione elemento dall'array
													if ($j==0)//indietro
													array_pop ($data_value);
													else      //in avanti
													array_shift($data_value);
													
												}
		
											}
											
											if (is_array($or) && count($or)>0) $current_condition[]=implode(" OR ",$or);
											
											//				print_r($or);											 
										}
										
										break;	
							case "4": //intervalli numerici
										
										$exp=array();
										if (isset($x['value']['start']) && $x['value']['start']!="") $exp[]="{$x['fullField'][$k]}>=\"{$x['value']['start']}\"";
										if (isset($x['value']['end'])   && $x['value']['end']!="")   $exp[]="{$x['fullField'][$k]}<=\"{$x['value']['end']}\"";
										
										
										$current_condition[]=implode(" AND ",$exp);
										break;									
						}									
					
				}//end foreach 2
					
						
				if (count($current_condition)>0) //scelta della condizione messa su WHERE o su HAVING
				{
					$textual_current_condition=" (".implode(" OR ",$current_condition).") ";

					$allHaving=true;
					foreach($x['table'] as $val)
						if ($val!="Having")
						{
							$allHaving=false;
							break;
						}
	
					if ($allHaving)
					{
						$having_condition=isset($having_condition)?$having_condition." AND ".$textual_current_condition:$textual_current_condition;	
						
					}
					else
						$where_condition=isset($where_condition)?$where_condition." AND ".$textual_current_condition:$textual_current_condition;	
				}
				//echo $where_condition;	
	
			}// end foreach 1
				
							
			$query=$this->query;
			
			if (isset($where_condition)) 	
			$query=$this->addWhereConditionToQuery($query,$where_condition);
			
			if (isset($having_condition)) 
			$query=$this->addHavingConditionToQuery($query,$having_condition);
			
			
			/////////////--- echo $query;	///// DEBUGGGGGGGGGGGGGGGGGGGGGGGGG		
			
			
			return $query;
	}		
	
	/** @return int the number of rows resulting from the construction query of the object with the actual research parameters
	  *             <br /><br />ITALIAN:<br /> 
	  *             il numero di righe risultante dalla chiamata alla query di costruzione dell'oggetto con gli attuali parametri di ricerca.	
	  */
	function get_rowsNum()
	{
		$this->scanTable();
		$this->set_rowsNum();
		return $this->rowsNum;
	}

	/** @return string the construction query of the object with the actual research parameters 
	  *                <br /><br />ITALIAN:<br />la query di costruzione dell'oggetto con gli attuali parametri di ricerca.*/	
	function getFullQuery()
	{
		$this->scanTable();
		$this->set_rowsNum();
		return $this->query;
	}
	
	private function set_rowsNum()
	{
		if (!$this->rowsNum)
		{
			$this->query=$this->get_queryWithSearchConditions();
			
			///*******************AGGIUNTA CONDIZIONI ALLA QUERY E ORDINAMENTO*************************
			if (!isset($_GET['ord_'.$this->originalPrimaryTable]) && !isset($this->orderInfo['currentOrd']))
			{
				$ordinamento=explode(",",$this->orderInfo['defaultOrd']);
				if (count($ordinamento)>1) //se si ordina per più colonne ordina brutalmente
				{
					$this->orderInfo['currentOrd']=$this->orderInfo['defaultOrd'];
					$this->orderInfo['currentDesc']="";
				}else
				{			
					$exp=explode(" ",$this->orderInfo['defaultOrd']);
	
					$this->orderInfo['currentOrd']=$exp[0];					
					$this->orderInfo['currentDesc']=isset($exp[1])?strtoupper($exp[1]):""; //da ricontrollare per spazi ecc.....
				}			
			}
			else if (isset($_GET['ord_'.$this->originalPrimaryTable]))//l'ordinamento dei GET prevale sull'ordinamento della ricerca(impostato da get_queryWithSearchConditions)
			{
				
				$this->orderInfo['currentOrd']=isset($_GET['ord_'.$this->originalPrimaryTable])?$_GET['ord_'.$this->originalPrimaryTable]:"";
				$this->orderInfo['currentDesc']=isset($_GET['desc_'.$this->originalPrimaryTable])?$_GET['desc_'.$this->originalPrimaryTable]:"";
				
			}
			else if(isset($this->orderInfo['currentOrd']))
			{
	
				$this->orderInfo['currentOrd']=substr($this->orderInfo['currentOrd'],1);
			}
	
		
		
			$this->query.=" ORDER BY {$this->orderInfo['currentOrd']} {$this->orderInfo['currentDesc']} , {$this->primaryTable}.{$this->originalPrimaryKey}";//ordina anche per id nel caso ci siano match di rilevanza uguali
	
			
			//echo $this->query;
	
			//DA MODIFICARE PER LE PRESTAZIONI !!!!!!!!DANGER!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			if (strstr($this->query,"HAVING")===false)
			{
				$from=substr($this->query,strpos($this->query,"FROM"));
				
				$gbpos=strpos($from,"GROUP BY");
				$obpos=strpos($from,"ORDER BY");
				
	
				
				$count_query="SELECT COUNT(DISTINCT {$this->primaryTable}.{$this->originalPrimaryKey}) AS cnt ";
	
				if ($gbpos===false && $obpos===false && $lmpos===false)
				$count_query.=$from;
				else if	(is_int($gbpos))	
				$count_query.=substr($from,0,$gbpos);
				else if	(is_int($obpos))	
				$count_query.=substr($from,0,$obpos);
				else if	(is_int($lmpos))	
				$count_query.=substr($from,0,$lmpos);
				
				$row=mysql_fetch_array(mysql_query($count_query)) or die("ERRORE QUERY CONTEGGIO RISULTATI: ".$count_query."<br /><br />".mysql_error());
				
				//echo $count_query;
				
				$rowsNum=$row['cnt'];		
				//echo $count_query."<br>";
				//echo $this->query;
				$this->rowsNum=$rowsNum;
	
			}
			else 
			$this->rowsNum=mysql_num_rows(mysql_query($this->query));
	
			////////////////////////////////////		
			
		}
	}
	
	/**  @param int id of a record<br /><br />ITALIAN:<br /> id di un record 
	  *  @return string the HTML code of the button/link relative to the interface starting of element modification
	  *                 <br /><br />ITALIAN:<br /> 
	  *                 il codice HTML del tasto/link relativo all'attivazione dell'interfaccia di modifica dell'elemento 
	  *  @see go()  
	  */
	function getEditLink($id)
	{
	
		if ($this->useAjax)
		$href="javascript:DBN_{$this->originalPrimaryTable}.buildForm({$id},'')";
		else
		$href="{$_SERVER['PHP_SELF']}?edit_{$this->originalPrimaryTable}={$id}".buildQueryString("del_".$this->originalPrimaryTable,"edit_".$this->originalPrimaryTable)."#{$this->originalPrimaryTable}_anchor";
	
	
		if ($this->canEdit===true || (is_array($this->canEdit) && in_array($id,$this->canEdit)))  
		return "<a href=\"{$href}\"><img src=\"".$this->imagesAndScriptsPath."edit.png\" alt=\"Modifica dati {$this->rowName} {$id}\" title=\"Modifica dati {$this->rowName}\" style=\"border:0px;vertical-align:baseline;margin:4px\" /></a>";
		else return "";
	
	}

	/**  @param int id of a record<br /><br />ITALIAN:<br /> id di un record 
	  *  @return string the HTML code of the button/link relative to starting of the element elimination procedure
	  *                 <br /><br />ITALIAN:<br /> 
	  *                 il codice HTML del tasto/link relativo all'attivazione della procedura di eliminazione dell'elemento
	  *  @see go()  */
	function getDeleteLink($id)
	{
	
		if ($this->useAjax)
		$href="javascript:DBN_{$this->originalPrimaryTable}.delete_({$id})";
		else
		$href="{$_SERVER['PHP_SELF']}?del_{$this->originalPrimaryTable}={$id}".buildQueryString("del_".$this->originalPrimaryTable,"edit_".$this->originalPrimaryTable)."#{$this->originalPrimaryTable}_anchor";
	
	
		if ($this->canDelete===true || (is_array($this->canDelete) && in_array($id,$this->canDelete)))  
		return "<a onclick=\"return confirm('{$this->lang['reallyDelete']}')\" onkeypress=\"if (this.event.keyCode!=13) return false; else return confirm('{$this->lang['reallyDelete']}')\"
				href=\"{$href}\"><img src=\"".$this->imagesAndScriptsPath."delete.png\" alt=\"Elimina {$this->rowName} {$id}\" title=\"Elimina {$this->rowName}\" style=\"border:0px;vertical-align:baseline;margin:4px\" /></a>";
		else return "";					
	
	}
	
	private function isConditionSatisfied($condition,$row)
	{
		if ($condition=="") return true;
		
		//condizione semplicissima su un campo se è 0 o no //vecchio modo
		if (strpos($condition,"{{{")===false)
		{
			if ($row[$condition]<=0) return false; else return true;   
		}
		
		//condizione su una stringa da valutare tramite eval e contenente + condizioni....nome campo indicato con {{{nome_campo}}}
		if (is_int(strpos($condition,"{{{")))
		{
			preg_match_all( "/{{{([^}]+)}}}/", $condition, $field , PREG_PATTERN_ORDER );
	
			foreach($field[1] as $f)
			$condition=str_replace("{{{".$f."}}}",'$row[\''.$f.'\']',$condition);
			
			
			eval('$condition_passed=(boolean)('.$condition.');');
			if ($condition_passed) return true;	else return false;
		
		}
		
	}
	

	private function getLinkColLink($col,$row,$text)
	{
		if ($this->isConditionSatisfied($col['condition'],$row))
		{	
			if ($col['keepGet']!='') $qs=buildQueryString($col['arg']); else $qs="";
			
			$col['page']=strpos($col['page'],"?")===false?$col['page']."?":$col['page'];
			
			if ($col['newWindow'])
			$script="onkeypress=\"if (this.event.keyCode==13) window.open(this.href); return false;\" onclick=\"window.open(this.href); return false;\"";
			else
			$script="";
			
			return "<a {$this->classTag['fieldLink']} {$script} href=\"{$col['page']}&amp;{$col['arg']}={$row[$this->primaryKey]}$qs#{$this->originalPrimaryTable}_anchor\" >".$text."</a>";

		}
		else return false;
	}	
	
	
	private function printTable($replace_array=null,$PageNavigator_on_top=false,$viewing_data_function="")
	{		
			
		$print="";

		if ($this->search_form_printed==false && count($this->searchField)>0) $print.="<div style=\"width:40%\">".$this->search_form()."</div>";


		$rowsNum=$this->get_rowsNum();	
		
		
		if (!$this->viewResults)
		{
			if (isset($_GET["src_{$this->originalPrimaryTable}_submit"])) $this->viewResults=true; //controllo che ci sia il get del tasto del form di ricerca
			else
			foreach ($this->searchField as $v) //controllo che ci sia un GET di ricerca
			if (is_array($v['field']))
			{
				$idx="";
				foreach ($v['field'] as $v2)
				$idx.=$v2."_";
				if (isset($_GET["{$idx}src_{$this->originalPrimaryTable}"])) 
				{
					
					$this->viewResults=true;
					break;
				}
			}else if (isset($_GET["{$v['table_alias']}_{$v['field']}_src_{$this->originalPrimaryTable}"]))
			{
				
				$this->viewResults=true;
				break;		
			}
		}
		
		if (!$this->viewResults) 
		{
			$print=$this->brutalTextReplace($replace_array,$print);
			echo $print;		
			return false;
		}
		
		
		//print( $this->query); //DEBUGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG
				
		//echo $rowsNum;
	
		if ($rowsNum!=0)
		{

			$navigation='';
			if (!$this->showAll)
			{ 
				$PN=new pageNavigator($rowsNum,$this->originalPrimaryTable,$this->classForFormInput['inputs'],$this->resultsPerPage,$this->datasetName);
				$this->query.=$PN->getLimit();
				
				$PN->setlanguage($this->lang['languageName']);
				$PN->setImagesPath($this->imagesAndScriptsPath);
				
				if ($this->pageBrowsingConfig['byselect']==true)			
					$nav1=$PN->show_page_browsing(false);
				
				if ($this->pageBrowsingConfig['bylink']==true)			
					$nav2=$PN->show_page_browsing(true);
				
				if ($this->pageBrowsingConfig['selectrpp']==true)			
					$rpp=$PN->show_RPP_browsing();
				
				if ($nav1 || $nav2 || $rpp)
				{
					$navigation.= "<br />";
					$navigation.= "<div class=\"".$this->pageBrowsingConfig['navigationPanelCSS']."\" id=\"{$this->originalPrimaryTable}_navigation_bottom\">";
					$navigation.= $nav1 ? $nav1."<br />" : "";
					$navigation.= $nav2 ? $nav2."<br />" : "";
					$navigation.= $rpp;			
					$navigation.= "</div>";
				}
			}
			
			if ($PageNavigator_on_top) $print.=$navigation; //NAVIGAZIONE IN UNA VARIABILE	
	

			//print( $this->query); //DEBUGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG
			
			$result=mysql_query($this->query) or die ($this->query." : <br /><br />".mysql_error());
											   			
	
			if ($viewing_data_function=="")
			{

				$multipleContext = $this->canMultipleEditDelete==true  && 
								   (  
									 ($this->canEdit===true || is_array($this->canEdit)) 
									 || 
									 ($this->canDelete===true || is_array($this->canDelete))
								   );
				
				//**************************************INTESTAZIONE TABELLA*********************
				

				
				
				if ($multipleContext)
				{
					$print.="<form method=\"get\" action=\"{$_SERVER['PHP_SELF']}\" id=\"frm_select_{$this->originalPrimaryTable}\">";
					foreach($_GET as $name=>$value) //parametri vari
					{
						if (strstr($name,"selected_".$this->originalPrimaryTable) || strstr($name,"action_".$this->originalPrimaryTable) || strstr($name,"sellen_".$this->originalPrimaryTable))
						continue; 
						 
						if (is_array($value))
						foreach($value as $val)
						$print.= "<input type=\"hidden\" name=\"{$name}[]\" value=\"".stripslashes($val)."\" />";
						else
						$print.= "<input type=\"hidden\" name=\"$name\" value=\"".stripslashes($value)."\" />";
					}
				}
				
				
				$cont="";
				foreach($this->tableContainer as $css)
				{
				
					$cont="<div class=\"".$css."\">".$cont; //i div applicati in lista dal primo impostato fino all'ultimo
				}
				$print.=$cont;
								
				
				
				
				$print.= "<table border=\"0\"  cellpadding=\"{$this->tableCP}\" cellspacing=\"{$this->tableCS}\" 
				           style=\"width:100%;\" summary=\"Tabella riepilogativa di ogni {$this->rowName}\">";		



				
				
				$temp=array();
								
				if ($this->canEdit===true || is_array($this->canEdit)) 
					$temp[]=$this->lang['edit'];
				
				if ($this->canDelete===true || is_array($this->canDelete))
					$temp[]=$this->lang['delete'];

				if ($multipleContext) 
					$temp[]=$this->lang['selection'];
					
				
				
				$headerrow="";
				
				if (count($temp)==0) //non si possono fare azioni
				{	
					$columns=0;
					$NOACTION=true;
				}
				else
				{
					if (!isset($this->lang['actionColumnHeader']))
						$actionColumnHeader=strtolower(implode(" / ",$temp));	
					else 
						$actionColumnHeader=$this->lang['actionColumnHeader'];
		
					$headerrow.= "<td{$this->classTag['headerTD']}>".$actionColumnHeader."</td>"; //colonna di intestazione seleziona/modifica/elimina
					$columns=1;

				}
				
	

				
				foreach ($this->field as $current_field)
				{
					
					if ($this->hidePrimaryKey==true && $current_field->def==$this->primaryKey && $current_field->table==$this->originalPrimaryTable) continue; //nasconde la chiave primaria
					
					if ($current_field->type=='password') continue; //non mostra le password
														
					if (isset($this->removeDisplaying[$current_field->name])) continue; //Salto per i dati Indicati manualmente
					
					$columns++;
					
					$headerrow.= "<td{$this->classTag['headerTD']}>";
					
					///////////////
					$show="<strong>".ucfirst(str_replace("_"," ",$current_field->def))."</strong>";
					//////////////
					
				
					
					if ($this->useAjax)
					{
						$href_1="javascript:DBN_{$this->originalPrimaryTable}.set_order('{$current_field->def}',true)";
						$href_2="javascript:DBN_{$this->originalPrimaryTable}.set_order('{$current_field->def}',false)";
					}
					else
					{
						$href_1="{$_SERVER['PHP_SELF']}?ord_{$this->originalPrimaryTable}={$current_field->def}&amp;desc_{$this->originalPrimaryTable}".buildQueryString("ord_".$this->originalPrimaryTable,"desc_".$this->originalPrimaryTable,"edit_".$this->originalPrimaryTable,"del_".$this->originalPrimaryTable)."#{$this->originalPrimaryTable}_anchor";
						$href_2="{$_SERVER['PHP_SELF']}?ord_{$this->originalPrimaryTable}={$current_field->def}&amp;desc_{$this->originalPrimaryTable}=DESC".buildQueryString("ord_".$this->originalPrimaryTable,"desc_".$this->originalPrimaryTable,"edit_".$this->originalPrimaryTable,"del_".$this->originalPrimaryTable)."#{$this->originalPrimaryTable}_anchor";

					}

					$headerrow.=$show." ";// $show."<br />"; ////



				  //link di ordinamento disattivati per default...
					$asc_atagopen="<a href=\"{$href_1}\">";
					$asc_atagclose="</a>";
					$asc_im_postfix="off";
					$desc_atagopen="<a href=\"{$href_2}\">";
					$desc_atagclose="</a>";
					$desc_im_postfix="off";

					
					if ($current_field->def==$this->orderInfo['currentOrd'])  //colonna ordinata
					{	
						//....modifica solo le variabili del campo ordinato (o asc o desc)
						if ($this->orderInfo['currentDesc']=="DESC") 
						{
							$desc_atagopen="";
							$desc_atagclose="";
							$desc_im_postfix="on";
						}
						else // ASC
						{
							$asc_atagopen="";
							$asc_atagclose="";
							$asc_im_postfix="on";
						}
						

					}

					$headerrow.= $asc_atagopen."<img style=\"vertical-align:bottom;border:none;\" src=\"{$this->imagesAndScriptsPath}asc_{$asc_im_postfix}.gif\"  alt=\"{$this->lang['ascendingOrder']}\" title=\"{$this->lang['ascendingOrder']}\" />". $asc_atagclose.
								$desc_atagopen."<img style=\"vertical-align:bottom;border:none;\" src=\"{$this->imagesAndScriptsPath}desc_{$desc_im_postfix}.gif\"  alt=\"{$this->lang['descendantOrder']}\" title=\"{$this->lang['descendantOrder']}\" />". $desc_atagclose;



					//////////////////////////////////////
									
					$headerrow.= "</td>";
					
				}
				
				foreach ($this->dataCol as $col) {$columns++; $headerrow.= "<td{$this->classTag['headerTD']}>{$col['colName']}</td>";} //stampa colonne aggiuntive
				if ($this->canViewForPrint) {$columns++; $headerrow.= "<td{$this->classTag['headerTD']}>{$this->lang['print']}</td>";}
				foreach ($this->linkCol as $col) {$columns++; $headerrow.= "<td{$this->classTag['headerTD']}>{$col['colName']}</td>";} //stampa colonne aggiuntive
				foreach ($this->freeCol as $col) {$columns++; $headerrow.= "<td{$this->classTag['headerTD']}>{$col['colName']}</td>";} //stampa colonne aggiuntive
	
				////////////////--------------------------------------------------------------------------------------------------
				
				
				$print.= "<tr class=\"{$this->tableHeaderCSS}\">";

				
				if (count($this->tableBorderStyle)>0) // ..riga dedicata alle celle del bordo
				{
					$print.= "
								<td class=\"".$this->tableBorderStyle['topsx']."\"></td>
								{$headerrow}
								<td class=\"".$this->tableBorderStyle['topdx']."\"></td>
							  
							";
				}
				else
					$print.= "{$headerrow}";
							
				
				
				$print.= "</tr>";
				
				
				//**************************************TABELLA*********************				   					


				while ($row=mysql_fetch_array($result))
				{					
					
					$print.= "<tr class=\"{$this->tableRowContentCSS}\">"; 
					
					
					// ..celle del bordo
					// ..celle del bordo
					if (count($this->tableBorderStyle)>0) // ..riga dedicata alle celle del bordo
						$print.= "<td class=\"".$this->tableBorderStyle['sx']."\"></td>";	
				


					//SETTAGGIO EVIDENZIAZIONE RIGHE 
					$openTD="<td{$this->classTag['TD']}>";
					$openEditDeleteTD="<td{$this->classTag['editDeleteTD']}>";					
					foreach ($this->highlighting as $hl)
					if ($this->isConditionSatisfied($hl['condition'],$row))
					{
						$openTD=$openEditDeleteTD="<td {$hl['TDAttributes']}>";
						break;
					}
					
					
					if (!$NOACTION ) $print.= $openEditDeleteTD; //-----------colonna coi link modifica/elimina/selezione


					if ($multipleContext)
					{
					
						$print.="<label for=\"selected_{$this->primaryTable}_{$row[$this->primaryKey]}\"></label>".
						        "<input id=\"selected_{$this->primaryTable}_{$row[$this->primaryKey]}\" type=\"checkbox\" 
									   name=\"selected_{$this->primaryTable}[]\" value=\"{$row[$this->primaryKey]}\" style=\"margin:4px\" /> ";
						
					}	
					
					if ($this->canEdit===true || is_array($this->canEdit))
					{							
						$editLink=$this->getEditLink($row[$this->primaryKey]);
						if ($editLink!="") 
							$print.=$editLink;		
					}
					
					if ($this->canDelete===true || is_array($this->canDelete))
					{
						$deleteLink=$this->getDeleteLink($row[$this->primaryKey]);
						if ($deleteLink!="") 
							$print.=$deleteLink;

					}

										
					$print.= "</td>"; //-----------------------------fine colonna

	
					foreach ($this->field as $current_field) //per ogni colonna
					{
						if ($this->hidePrimaryKey==true && $current_field->def==$this->primaryKey && $current_field->table==$this->originalPrimaryTable) continue; //nasconde la chiave primaria	
						
						if ($current_field->type=='password') continue; //non mostra le password
						
						if (isset($this->removeDisplaying[$current_field->name])) continue; //Salto per i dati Indicati manualmente

						
						$print.=$openTD;
						

						$fieldText='';
												
						$TYPE=explode("(",$current_field->type);//serve per identificare gli ENUM
						
						
						///....................VISUALIZZAZIONE VALORI --- variabile $fieldText ...................................................
						
						
						if (is_array($this->imageIcon[$current_field->name])) //preview dell'immagine sulla tabella	
						{
							if ($row[$current_field->name]=='')
								$fieldText="<img src=\"".$this->imageIcon[$current_field->name]['off']."\" alt=\"\" style=\"border:none\" />";						
							else
							{
								$fieldText="<img src=\"".$this->imageIcon[$current_field->name]['on']."\" alt=\"\" style=\"border:none\" />";							
							
								//caso di file...stesso controllo fatto sotto
								if (isset($this->fileField[$current_field->name]) && $current_field->table==$this->originalPrimaryTable )
									$fieldText="<a href=\"{$this->filePath}/{$row[$current_field->name]}\" >".$fieldText."</a>";
							
							}
							
											



						}
						else if (isset($this->switchCol[$current_field->name])) //------ campo impostato come SWITCH (a 2 valori)
						{
									
							$value=array();
							foreach($this->getEnumSetValue($current_field->type) as $val=>$val2)
							{
								$value[]=$val;
							}// l'array value contenente i valori ordininati

							

							$is_on  = $row[$current_field->name]==$value[0] ? "1" : "2" ;	
							$is_off = $row[$current_field->name]==$value[0] ? "2" : "1" ;	
							
							$fieldText="<a href=\"{$_SERVER['PHP_SELF']}?switch_field_{$this->originalPrimaryTable}=".$current_field->name.
										 "&amp;switch_id_{$this->originalPrimaryTable}=".$row["id"].
										 "&amp;switch_value_{$this->originalPrimaryTable}=".$is_off. //uso del valore indice
										 "&amp;".buildQueryString("del_".$this->originalPrimaryTable,"edit_".$this->originalPrimaryTable).
										 "#{$this->originalPrimaryTable}_anchor\">";
							
							$current_value_image = $this->switchCol[$current_field->name]['image'.$is_on];
							
							
							if (file_exists($current_value_image))
								$fieldText.="<img style=\"vertical-align:top;border:none;\" src=\"".$current_value_image
											."\" alt=\"".$row[$current_field->name]."\" title=\"".$row[$current_field->name]."\" />";
							else
								$fieldText.=$row[$current_field->name];
								
								
							$fieldText.="</a>";
													
						
						}
						else						
						switch($TYPE[0])
						{	
							case "date":
									$exp=explode("-",$row[$current_field->def]);
									if (isset($this->monthYearField[$current_field->name]))
										$fieldText= "{$exp[1]}/{$exp[0]}";
									else
										$fieldText= "{$exp[2]}/{$exp[1]}/{$exp[0]}";
									
									break;
							case "datetime":
									$exp=explode(" ",$row[$current_field->def]);
									$exp2=explode("-",$exp[0]);
	
									$fieldText= "{$exp2[2]}/{$exp2[1]}/{$exp2[0]} {$exp[1]}";
									break;								
/*							case"real":
							case"int":
							case"enum":
							case"blob":	
							case"string":*/
							default: //tanto è uguale!
									 if (isset($this->photoField[$current_field->name]) && $current_field->table==$this->originalPrimaryTable)
									 {
										if ($row[$current_field->name]!="")
										{
												
											if ($this->photoField['_Resize_']) $small="small_"; else $small="";
											
											$fname=$this->filePath."/$small".$row[$current_field->name];
											
											if (file_exists($fname))
											{
												if (!is_array($this->imageIcon[$current_field->name])) //preview dell'immagine sulla tabella
													$fieldText= "<img src=\"".$fname."\" alt=\"\"
																	  style=\"".getImageResizedValues($fname,$this->imageScaleDim,$this->imageScaleDim)."\"  />";
												else//array
													$fieldText= "<img src=\"".$this->imageIcon[$current_field->name]['on']."\" alt=\"\" />";
												
											}
											else 
												$fieldText=$fname." :immagine non trovata";
										} 
										else 
										{
											if (!is_array($this->imageIcon)) //preview dell'immagine sulla tabella
												$fieldText="<em>{$this->lang['noImage']}</em>";
											else
												$fieldText= "<img src=\"".$this->imageIcon[$current_field->name]['off']."\" alt=\"\" />";
										}	
									 }
									 else if (isset($this->fileField[$current_field->name]) && $current_field->table==$this->originalPrimaryTable )
									 {
										if ($row[$current_field->name]!="")
										{
											$fieldText="<a href=\"{$this->filePath}/{$row[$current_field->name]}\" onclick=\"\">{$row[$current_field->name]}</a>";
										}
										else $fieldText="<em>{$this->lang['noFile']}</em>";
										
									 }else 	
									 {
										$fieldText=$row[$current_field->def];
										
										if (is_numeric($this->cutLength)) //taglia il testo troppo lungo eliminando i tag
										{									 										
											$fieldText=str_replace("<br />","_!_",$fieldText); 
											$fieldText=elimina_ogni_tag($fieldText);
											$fieldText=str_replace("_!_","<br />",$fieldText); 
													
			
											 
											if (strlen($fieldText)>$this->cutLength) //evitare di tagliare a meta i tags
											{
												///EVITA DI TAGLIARE UN TAG (br) A META' /////
												$cut_end=$this->cutLength;
												for($i=$this->cutLength;$i<strlen($fieldText);$i++) //cerca > dal punto in cui si taglia alla fine
												{
													if ($fieldText{$i}==">") 					   //se lo trova
													{
														for($j=$this->cutLength;$j>0;$j--) 		   //cerca < dal punto in cui si taglia fino all'inizio 
														{
															if ($fieldText{$j}=="<") 			   //se lo trova(si xkè c'è solo BR)taglia fino a lì
															{
																$cut_end=$j;
																break;
															}													
														}
														break;
													}
												}
												/////////////////////////////////////////////
												$fieldText=substr($fieldText,0,$cut_end)."<br /><strong>...[continua]</strong>";
											}
										}
										
										
									}	
										
										
										
						}


					

	
						$linkTag=false;
						
						foreach ($this->linkCol as $col)  //mette il link aggiuntivo ai campi indicati
						if (is_array($col['fieldToLink']))
						foreach ($col['fieldToLink'] as $colonna)
						{
							if ($current_field->def!=$colonna) continue;
			
							$linkTag=$this->getLinkColLink($col,$row,$fieldText);
							
							break;					
						}
						
						$print .= $linkTag ? $linkTag : $fieldText;
						
						
						
						
						$print.="</td>";
					}
					
					foreach ($this->dataCol as $col)
					{
						unset($data);
						
						switch ($col['type'])
						{
							case "RECURSIVE":	   
												    $data=$this->query_ricorsiva($row[$this->primaryKey],$col['query']); 
													break;
							case "LINKED_RECORDS": 
													$linked_result=mysql_query(str_replace("%current_row_id%",$row[$this->primaryKey],$col['query']));
													
													$data='';													
													while($linked_row=mysql_fetch_array($linked_result))
													{
														$data.="&bull; ".$linked_row[0]."<br />";//un campo solo..
													}
													break;	
							case "CALCULATION":		
													$data=0;
													foreach ($col['query'] as $q)
													{
														if (!mysql_query(str_replace("%current_row_id%",$row[$this->primaryKey],$q['query']))) echo (mysql_error());
														$tot=mysql_fetch_array(mysql_query(str_replace("%current_row_id%",$row[$this->primaryKey],$q['query'])));																									
														eval('$data=$data '.$q['operand'].'$tot[0];');	//il primo campo 
													}											
													
													break;
						}
						
						$print.=$openTD."{$data}</td>";
					}			
					
					$query_string=buildQueryString("edit_".$this->originalPrimaryTable,"del_".$this->originalPrimaryTable);			
					
					if ($this->canViewForPrint)
					{
					
						$print.= $openEditDeleteTD."<a href=\"{$_SERVER['PHP_SELF']}?view_{$this->originalPrimaryTable}={$row[$this->primaryKey]}$query_string#{$this->originalPrimaryTable}_anchor\"
						onclick=\"window.open(this.href);return false;\" onkeypress=\"if (this.event.keyCode==13) {window.open(this.href);return false;} else return false;\" >
					<img src=\"".$this->imagesAndScriptsPath."print.gif\" alt=\"Visualizza dati {$this->rowName} {$row[$this->primaryKey]}\" title=\"Visualizza dati {$this->rowName}\" style=\"border:0px\" /></a>
					</td>";
						
					}



					
					foreach ($this->linkCol as $col)
					{
						$print.= $openEditDeleteTD;
						
						$text=file_exists($col['image'])?"<img style=\"vertical-align:top;border:none;\" src=\"{$col['image']}\" alt=\"{$col['colName']}  {$this->rowName} {$row[$this->primaryKey]}\" title=\"{$col['colName']}\" />":"{$col['colName']}  {$this->rowName}";
						
						$print.=$this->getLinkColLink($col,$row,$text);	
		
						$print.= "</td>";
					
					}	
					foreach ($this->freeCol as $col)
					{
						$print.= $openEditDeleteTD.str_replace("%current_row_id%",$row[$this->primaryKey],$col['content'])."</td>";					
					}						


					// ..celle del bordo
					if (count($this->tableBorderStyle)>0) // ..riga dedicata alle celle del bordo
						$print.= "<td class=\"".$this->tableBorderStyle['dx']."\"></td>";	


										
					$print.= "</tr>";
					//$print.="<tr><td colspan=\"3\"><div style=\"visibility:visible\" id=\"form_div_{$row[$this->primaryKey]}\">".$this->buildForm($row[$this->primaryKey])."</div></td></tr>";
	
				} //end while


				if (count($this->tableBorderStyle)>0) // ..riga dedicata alle celle del bordo
				{
					$print.= "<tr>
								<td colspan=\"1\" class=\"".$this->tableBorderStyle['botsx']."\"></td>
								<td colspan=\"".$columns."\" class=\"".$this->tableBorderStyle['bot']."\"></td>
								<td colspan=\"1\" class=\"".$this->tableBorderStyle['botdx']."\"></td>
							  </tr>	
							";
				}

	
				$print.= "</table>";			
				
				
				foreach($this->tableContainer as $css)
				{
					$print.="</div>";
				}

				
				
				
				if ($multipleContext)
				{
					$print.= "
					
					
					<script type=\"text/javascript\">
					<!--
						setCheckBoxes_{$this->originalPrimaryTable}=function(val)
						{
							cb=document.forms['frm_select_{$this->originalPrimaryTable}'].elements['selected_{$this->originalPrimaryTable}[]'];
							if (typeof(cb.length)=='undefined')//solo una checkbox presente..non è un array
							cb.checked=val;
							else
							for (var i=0;i<cb.length;i++)
							cb[i].checked=val;
						}
						
						setSellen_{$this->originalPrimaryTable}=function (action)
						{
							cb=document.forms['frm_select_{$this->originalPrimaryTable}'].elements['selected_{$this->originalPrimaryTable}[]'];
							len=0;
							if (typeof(cb.length)=='undefined') //solo una checkbox presente..non è un array
							{
								if (action=='edit')
								{
									cb.checked=false;
									document.getElementById('edit_{$this->originalPrimaryTable}').value=cb.value;
								}
								len=1;
							}
							else
							{
								firstFounded=false;
								for (var i=0;i<cb.length;i++)
								{
									if (cb[i].checked==true)
									{
										len++;
										if (!firstFounded && action=='edit') //deseleziono la checkbox e imposto l'edit_ primarytable
										{
											cb[i].checked=false;
											document.getElementById('edit_{$this->originalPrimaryTable}').value=cb[i].value;
											firstFounded=true;
										}
									}
								}
							}
							document.getElementById('sellen_{$this->originalPrimaryTable}').value=len;						
						}

						getSelected_{$this->originalPrimaryTable}=function (action)
						{
							
							result=new Object();
							result.selected=Array();
							j=0;
							
							cb=document.forms['frm_select_{$this->originalPrimaryTable}'].elements['selected_{$this->originalPrimaryTable}[]'];

							len=0;
							//solo una checkbox presente..non è un array (se c'è un solo elemento nella tabella cb.value contiene l'unico id...però cb.checked è falso)
							if (typeof(cb.length)=='undefined' && typeof(cb.value)!='undefined' && cb.checked==true) 
							{
								result.selected[0]=cb.value;
							}
							else
							{
								firstFounded=false;
								for (var i=0;i<cb.length;i++)
								{
									if (cb[i].checked==true)
									{
										result.selected[j++]=cb[i].value;

									}
								}
							}

							result.action=action;
							return result;						
						}						
					-->
					</script>
					&nbsp;&nbsp;<img style=\"margin-top:10px\" src=\"".$this->imagesAndScriptsPath."puntini_orizz.png\" alt=\"\" />{$this->lang['ifSelected']} 
					
					<input type=\"hidden\" id=\"edit_{$this->originalPrimaryTable}\" name=\"edit_{$this->originalPrimaryTable}\" />
					<input type=\"hidden\" id=\"sellen_{$this->originalPrimaryTable}\" name=\"sellen_{$this->originalPrimaryTable}\" value=\"\" />";
				

					if ($this->canEdit===true || is_array($this->canEdit))
					{
						if ($this->useAjax)
						{
							$onclickKeyPress="
							onclick=\"var data=getSelected_{$this->originalPrimaryTable}('edit'); if (data.selected.length>0) DBN_{$this->originalPrimaryTable}.multipleOperation(data)\" 
							onkeypress=\"var data=getSelected_{$this->originalPrimaryTable}('edit'); if (data.selected.length>0 && this.event.keyCode==13) DBN_{$this->originalPrimaryTable}.multipleOperation(data)\"";

						}
						else
						{
							$qs="{$_SERVER['PHP_SELF']}?".buildQueryString("selected_".$this->originalPrimaryTable,"action_".$this->originalPrimaryTable,"sellen_".$this->originalPrimaryTable);
							$onclickKeyPress="
							onclick=\"var data=getSelected_{$this->originalPrimaryTable}('edit'); if (data.selected.length>0) location.href='{$qs}'+DBN_{$this->originalPrimaryTable}.getMultipleOperationParams(data)\" 
							onkeypress=\"var data=getSelected_{$this->originalPrimaryTable}('edit'); if (data.selected.length>0 && this.event.keyCode==13) location.href='{$qs}'+DBN_{$this->originalPrimaryTable}.getMultipleOperationParams(data)\"";
						}


										
						$print.= "
						<label for=\"action_{$this->originalPrimaryTable}_1\"></label>
						<button type=\"button\" {$onclickKeyPress}>
							<img src=\"".$this->imagesAndScriptsPath."edit.png\" alt=\"{$this->lang['edit']}\" />
						</button> ";
						
						if ($this->useAjax)
						{
							$onclickKeyPress="
							onclick=\"var data=getSelected_{$this->originalPrimaryTable}('editMany'); if (data.selected.length>0) DBN_{$this->originalPrimaryTable}.multipleOperation(data)\" 
							onkeypress=\"var data=getSelected_{$this->originalPrimaryTable}('editMany'); if (data.selected.length>0 && this.event.keyCode==13) DBN_{$this->originalPrimaryTable}.multipleOperation(data)\"";

						}
						else
						{
							$qs="{$_SERVER['PHP_SELF']}?".buildQueryString("selected_".$this->originalPrimaryTable,"action_".$this->originalPrimaryTable,"sellen_".$this->originalPrimaryTable);
							$onclickKeyPress="
							onclick=\"var data=getSelected_{$this->originalPrimaryTable}('editMany'); if (data.selected.length>0) location.href='{$qs}'+DBN_{$this->originalPrimaryTable}.getMultipleOperationParams(data)\" 
							onkeypress=\"var data=getSelected_{$this->originalPrimaryTable}('editMany'); if (data.selected.length>0 && this.event.keyCode==13) location.href='{$qs}'+DBN_{$this->originalPrimaryTable}.getMultipleOperationParams(data)\"";
						}
						
						
						$print.= "
						<label for=\"action_{$this->originalPrimaryTable}_3\"></label>
						<button type=\"button\" {$onclickKeyPress}\">
							<img src=\"".$this->imagesAndScriptsPath."editMany.gif\" alt=\"\" />
						</button> ";
						
						
					}

					
					if ($this->canDelete===true || is_array($this->canDelete))
					{
					
						if ($this->useAjax)
						{
							$onclickKeyPress="
							onclick=\"var data=getSelected_{$this->originalPrimaryTable}('delete'); if (data.selected.length>0 && confirm('{$this->lang['reallyDeleteMultiple']}')) DBN_{$this->originalPrimaryTable}.multipleOperation(data)\" 
							onkeypress=\"var data=getSelected_{$this->originalPrimaryTable}('delete'); if (data.selected.length>0 && confirm('{$this->lang['reallyDeleteMultiple']}') && this.event.keyCode==13) DBN_{$this->originalPrimaryTable}.multipleOperation(data)\"";

						}
						else
						{
							$qs="{$_SERVER['PHP_SELF']}?".buildQueryString("selected_".$this->originalPrimaryTable,"action_".$this->originalPrimaryTable,"sellen_".$this->originalPrimaryTable);
							$onclickKeyPress="
							onclick=\"var data=getSelected_{$this->originalPrimaryTable}('delete'); if (data.selected.length>0 && confirm('{$this->lang['reallyDeleteMultiple']}')) location.href='{$qs}'+DBN_{$this->originalPrimaryTable}.getMultipleOperationParams(data)\" 
							onkeypress=\"var data=getSelected_{$this->originalPrimaryTable}('delete'); if (data.selected.length>0 && confirm('{$this->lang['reallyDeleteMultiple']}') && this.event.keyCode==13) location.href='{$qs}'+DBN_{$this->originalPrimaryTable}.getMultipleOperationParams(data)\"";
						}
						
						
						$print.= "
						<label for=\"action_{$this->originalPrimaryTable}_3\"></label>
						<button type=\"button\" {$onclickKeyPress}\">
							<img src=\"".$this->imagesAndScriptsPath."delete.png\" alt=\"\" />
						</button> ";
						
											
					/*
					if ($this->canDelete===true || is_array($this->canDelete))
					$print.= "					
					 <label for=\"action_{$this->originalPrimaryTable}_2\"></label>
					<button type=\"submit\" name=\"action_{$this->originalPrimaryTable}\" id=\"action_{$this->originalPrimaryTable}_2\" value=\"delete\" 
					onclick=\"setSellen_{$this->originalPrimaryTable}(this.value);return confirm('{$this->lang['reallyDeleteMultiple']}')\" onkeypress=\"if (this.event.keyCode==13) {setSellen_{$this->originalPrimaryTable}(this.value);return confirm('{$this->lang['reallyDeleteMultiple']}');} else return false;\">
						<img src=\"".$this->imagesAndScriptsPath."delete.png\" alt=\"{$this->lang['edit']}\" />
					</button> ";
					*/
					}
					
					$print.= "	
					<a href=\"javascript:setCheckBoxes_{$this->originalPrimaryTable}(true)\">{$this->lang['selectAll']}</a> | 
					<a href=\"javascript:setCheckBoxes_{$this->originalPrimaryTable}(false)\">{$this->lang['unselectAll']}</a>
					</form>	
					";
					
				}
					
			}
			else
			{
			 	$print.=$viewing_data_function($result);
			}
			
			$print.=$navigation; //NAVIGAZIONE IN UNA VARIABILE			
			
		}
		else
		$print.= "<span style=\"font-size:13px;font-weight:bolder\"><em>- {$this->lang['noResults']}</em></span>";
		
		

		$print=$this->brutalTextReplace($replace_array,$print);
		
		echo $print;
	}
	
	private function brutalTextReplace($replace_array,$text) 
	{
		if (!is_array($replace_array)) return $text;																	
		
		foreach($replace_array as $search=>$replace) 														
		{
			if ($search{0}=='/' && $search{strlen($search)-1}=='/')
				$text = preg_replace($search,$replace,$text); 						
			else
				$text =  str_replace($search,$replace,$text); 						
		}
		
		return $text;		
	}
	
	private function manage_record_availability($id,$bookRecord)	
	{
		//session_start();
		//ob_end_clean();
		$row=mysql_fetch_array(mysql_query("SELECT * FROM busy_records WHERE table_name=\"{$this->originalPrimaryTable}\" AND record_id=\"{$id}\""));
		
		if ($row)
		{
			if ($row['user_session_id']==session_id()) //se il record è occupato dal client allora aggiorna l'expire_date
			{  
				mysql_query("UPDATE busy_records SET expire_time=\"".strtotime("+7 seconds")."\"  
				WHERE table_name=\"{$this->originalPrimaryTable}\" AND record_id=\"{$id}\" AND user_session_id=\"".session_id()."\"");		
				
				return true;
			}
			else 
			//die(print_r($row,true)); 
			return false;
		}
		else
		{
			if ($bookRecord)
			mysql_query("INSERT INTO busy_records(table_name,record_id,user_session_id,expire_time)
			VALUES (\"{$this->originalPrimaryTable}\",\"{$id}\",\"".session_id()."\",\"".strtotime("+7 seconds")."\")");
		
			return true;
		}
		
	}
		
	private function buildForm($id=null,$replace_array=null,$show_back_link=true)
	{

		//print_r($this->field);
		//print_r($this->externalData);
		$print="";
		
		$fieldEnablingControl="";


		$qs=buildQueryString("del_{$this->originalPrimaryTable}");//il del lo tolgo perchè si può accedere qui anche se si voleva eliminare un record usato
		$form_target=$_SERVER['PHP_SELF']."?$qs#{$this->originalPrimaryTable}_anchor";
	
		if ($show_back_link)
		{ 
			if ($this->useAjax) $back_href="javascript:DBN_{$this->originalPrimaryTable}.printTable()";
			else
			{
				$qs=buildQueryString("del_{$this->originalPrimaryTable}",'edit_'.$this->originalPrimaryTable,"action_{$this->originalPrimaryTable}","sellen_{$this->originalPrimaryTable}","selected_{$this->originalPrimaryTable}");
				$back_href=$_SERVER['PHP_SELF']."?$qs#{$this->originalPrimaryTable}_anchor";
			}
		}
		
		
		if (!is_array($id))
		{
		
			$row=mysql_fetch_array(mysql_query($this->addWhereConditionToQuery($this->query,"{$this->primaryTable}.{$this->originalPrimaryKey}='$id'")));
	
			//$print.= $this->addWhereConditionToQuery($this->query,"{$this->primaryTable}.{$this->primaryKey}='$id'");
			if ($row) //Modalità modifica
			{
				if ($this->manage_record_availability($id,true)==false)
				{
					return "<br /><div style=\"cursor:wait;font-weight:bolder;border:1px solid #FF0000;padding:3%\">
					{$this->lang['warningRecordOccupied']}
					<a href=\"".($show_back_link?$back_href:"javascript:history.back();")."\">&raquo; {$this->lang['goBack']}</a> 
					</div><br />
					
					<script type=\"text/javascript\">
					<!--
						DBN_{$this->originalPrimaryTable}.checkAvailability=setInterval(\"DBN_{$this->originalPrimaryTable}.manage_record_availability_for_editing($id,false)\",3000); // rifa il controllo dopo 7 secondi					
					-->
					</script>
					";
				}else
				{
				
					$print.="
					<script type=\"text/javascript\">
					<!--
						DBN_{$this->originalPrimaryTable}.checkAvailability=setInterval(\"DBN_{$this->originalPrimaryTable}.manage_record_availability_for_editing($id,true)\",3000); // rifa il controllo dopo 7 secondi																
					-->
					</script>
					";
				}

				
				$edit=1;			
		
				$formHeading=$this->lang['editRecord'];//." $id";
							
				
				if (is_array($this->photoField) || is_array($this->fileField)) //formattazione div contenitore per le immagini (e file)
				{
	
					foreach ($this->photoField as $field=>$bool)
					{ 
						if ($field=="_Resize_" || $field=="_KeepOriginal_") continue; ////da sistemare......? parametri delle immagini nello stesso array
						if ($row[$field]!="")
						{			
							if (!isset($div_flag)) //stampa il div una volta sola , solo se c'è qualcosa 
							{
								$print.= "<div style=\"position:relative;float:right;border:1px solid #000000;width:20%;padding:6px 0px 6px 6px;margin:10px 0px\">";
								$div_flag=true;
							}
							else $print.="<br /><br />";
								
							$print.="<strong>".$this->lang['current']." ".str_replace("_"," ",ucfirst($field))."</strong><br />";	
							
							
							
							if (  intval($this->photoField['_Resize_'])!=0 && $this->photoField['_KeepOriginal_']) //origin.+miniatura: crea il link per l'originale
							{
								
								$print.="<a href=\"{$this->filePath}/{$row[$field]}\" onclick=\"window.open(this.href);return false;\">";
								$print.="<img src=\"{$this->filePath}/small_{$row[$field]}\" style=\"".getImageResizedValues($this->filePath."/".$row[$field],130,130)
								.";border:none\" alt=\"{$row[$field]}\" /><br />".$row[$field]."</a><br /><br />";
														
							} else //solo immagine O solo miniatura
							{
								$pre= $this->photoField['_KeepOriginal_'] ? "" : "small_" ;
									
								$print.="<img src=\"{$this->filePath}/{$pre}{$row[$field]}\" 
											  style=\"".getImageResizedValues($this->filePath."/".$pre.$row[$field],130,130)."\" 
											  alt=\"{$pre}{$row[$field]}\" /><br />".str_replace("_"," ",ucfirst($row[$field]));
							}
							

							
							$this->photoField[$field]=true; ///
						}
					}
	
					foreach ($this->fileField as $field=>$bool)
					{ 
						if ($row[$field]!="")
						{
							if (!isset($div_flag))  //stampa il div una volta sola , solo se c'è qualcosa 
							{
								$print.= "<div style=\"position:relative;float:right;border:1px solid #000000;width:20%;padding:6px 0px 6px 6px;margin:10px 0px\">";
								$div_flag=true;
							}
							else $print.="<br /><br />";					
							
							$print.="<strong>".$this->lang['current']." ".str_replace("_"," ",ucfirst($field))."</strong>
							<a href=\"{$this->filePath}/{$row[$field]}\" onclick=\"window.open(this.href);return false;\"><strong>".
							str_replace("_"," ",ucfirst($row[$field]))."</strong></a><br /><br />";
							$this->fileField[$field]=true; ///
						}
					}
					if (isset($div_flag)) {
											$print.="</div>";
											$this->formWidth[1]-=25;
										  }
				}
			} else //INSERIMENTO
			{

				$edit=0; 
				
				$formHeading=$this->lang['insertNew'];
				
			}
		
		}
		else  //array di id
		{
			$edit=1; 
			
			$formHeading="<strong>".str_replace("***","<span style=\"color:#F00\">".count($id)."</span>",$this->lang['multipleEditingHeading'])."</strong>";
			
			$occupiedId=false;
			$jsArray=array();
			foreach($id as $ids)
			if ($this->manage_record_availability($ids,true)==false) 
			{
				$occupiedId=true;//un record occupato
			}
			
				
			//questa funzione mantiene la prenotazione dei record trovati disponibili, ed eventualmente chiama la funzione per ristampare il form
			//quando quello occupato diventa libero
			$print.="
			<script type=\"text/javascript\">
			<!--
				DBN_{$this->originalPrimaryTable}.checkAvailability=setInterval(\"DBN_{$this->originalPrimaryTable}.manage_record_availability_for_editing([".implode(',',$id)."],".($occupiedId?'false':'true').")\",3000); // rifa il controllo dopo 7 secondi																
			-->
			</script>
			";
			
			//se ce n'è uno occupato termina qui
			if ($occupiedId)
			return $print."<br /><div style=\"cursor:wait;font-weight:bolder;border:1px solid #FF0000;padding:3%\">
							{$this->lang['warningRecordOccupied']}
							<a href=\"".($show_back_link?$back_href:"javascript:history.back();")."\">&raquo; {$this->lang['goBack']}</a> 
							</div><br />";


		}
		///////////////Reinserimento valori nel form//////////////////
		///*************** S E M P R E !!!!!!!! ***************
		
		foreach ($_POST as $name=>$value) 
		{
			

			if (substr($name,strlen($name)-4,4)=="_ifr")
				$name=substr($name,0,strlen($name)-4);
			else
				$value=$this->convertSpecialChars($value);
			
			if (substr($name,strlen($name)-4,4)=="_day") {$data_generica=$value;continue;}
			if (substr($name,strlen($name)-4,4)=="_mon") {$data_generica=$value."-".$data_generica;continue;}
			if (substr($name,strlen($name)-4,4)=="_yea") {$value=$value."-".$data_generica; $name=substr($name,0,strlen($name)-4);}
					
				//campi della tabella principale
			foreach ($this->field as $current_field)
			{
				if ($current_field->name==$name)// || $current_field->def==$name)
				{
					//$row[$current_field->name]=stripslashes($value);
					if (is_array($value))
					$row[$current_field->def]=implode(",",$value);
					else
					$row[$current_field->def]=stripslashes($value);				
					continue 2;
				}
					
			}//end foreach
				
			//campi collegati
			foreach ($this->externalData as $ed)
			{
				$chiave=$ed["ex_primaryKey"];
				$chiave_esterna=$ed["externalKey"];
				$alias=$ed["ex_alias"];
					
				if ($chiave_esterna==$name)
				{
						$row[$chiave_esterna]=stripslashes($value); //???
						$row[$alias]=stripslashes($value);				
						continue 2;
				}
					
			}//end foreach				
				
		}//end foreach principale
		//print_r($_POST);
		//print_r($row);
		//print_r($this->externalData);
		/////////////////////////////////////////
		
///INTESTAZIONI FORM
			$print.="<div>";
			
			if ($this->formHeading=="")
			$print.= "<span style=\"font-size:18px;font-weight:bolder\">$formHeading</span>";
			else
			$print.= $this->formHeading;
			
			
			if ($show_back_link==true)
			$print.= "<h3><a href=\"$back_href\">".$this->lang['backToData']."</a></h3>";
			
			$print.="</div>";
//////////////
		
		$this->editForm->defineParams("frm_{$this->originalPrimaryTable}",$form_target,$this->formWidth[0],$this->formWidth[1],strip_tags($formHeading));		
			
			
		$this->editForm->addInput("hidden","edit_".$this->originalPrimaryTable,$edit);	
		

		//print_r($this->externalData);
		//print_r($this->field);

		foreach ($this->field as $current_field)
		{
			
			if (isset($this->removeInput[$current_field->name])) continue; //Salto per gli hiddenInput Indicati manualmente
			

			if (!isset($row[$current_field->def])) $row[$current_field->def]=''; //Evita i notice di indici di array non esistenti
																				//NB: ->def contiene sempre il nome dell'indice giusto(alias o nome se non c'è alias)
			//echo $current_field->name." - ".$current_field->def."<br />";


			if (is_array($id) && isset($this->removeMultipleEditingInput[$current_field->def])) continue; //
			
			$maxlength=explode("(",$current_field->type); //eg. field.type='string(100)'
			$maxlength=substr($maxlength[1],0,-1);
			
			if ($current_field->name==$this->originalPrimaryKey) 
			{
				$TYPE=explode("(",$current_field->type);
				if ($TYPE[0]=='string' && $edit==0) //se la chiave primaria è una stringa la fa modificare solo in inserimento -- NON TESTATO E COMPLETO
				$this->editForm->addInput("text",$this->originalPrimaryKey,$row[$current_field->name],ucfirst(str_replace("_"," ",$current_field->def))
				                          ,$maxlength,false,$current_field->not_null,$this->classForFormInput[inputs]); 
				else //altrimenti se si è in modifica aggiunge un hidden
				{
					if (!is_array($id))	
					$this->editForm->addInput("hidden",$this->originalPrimaryKey,$id);
					else
					foreach ($id as $i) //array di input per gli id
						$this->editForm->addInput("hidden",$this->originalPrimaryKey."[]",$i);	

				}
				
				
				continue;
			} /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if ($current_field->table!=$this->primaryTable ) //**CAMPI COLLEGATI A TABELLE ESTERNE
			{
			
			
				////////////////////CONTROLLO ESISTENZA CAMPO COLLEGATO
				$founded=false;
				foreach($this->externalData as $key=>$val)
				{
					if ($val['ex_table']==$current_field->table && $val['ex_field']==$current_field->name && $val['ex_alias']==$current_field->def)
					{
						$founded=$key;
						break;
					}
						
				}
				if ($founded===false) continue;  //se non esiste il collegamento salta...
				
				//if (!isset($this->externalData[$current_field->table.".".$current_field->name])) continue; //se non esiste il collegamento salta...
			
				////////////////////////////////////////////////////
			
				
				if (strpos($this->query," AS ".$current_field->table." ")!=false)  //CERCA l'[ALIAS DELLA TABELLA] !!!!
				{
					$exp=explode(" AS ".$current_field->table." ",$this->query);
					$exp2=explode(" ",$exp[0]);	
					$table=$exp2[(count($exp2)-1)];
				}
				else $table=$current_field->table;
				
				//$dato_principale=$current_field->name;
				$dato_principale=$current_field->name;
				
				//echo $dato_principale;
				$chiave=$this->externalData[$founded]["ex_primaryKey"];
				$chiave_esterna=$this->externalData[$founded]["externalKey"];
				$alias=$this->externalData[$founded]["ex_alias"];
				
				$alias_show=ucfirst(str_replace("_"," ",$alias));
				
				if (isset($this->removeInput[$chiave_esterna])) continue; //Salto per gli hiddenInput Indicati manualmente
				
				$result_esterna=mysql_query("SELECT * FROM $table ORDER BY {$chiave}"); 

				
				//print_r($this->externalData);
				
				
				$value=array(""=>$this->lang['select']." ".$alias_show);
				
				$selected="";

				while ($row_esterna=mysql_fetch_array($result_esterna))
				{
					//$print.= $row[$dato_principale];
					$value[$row_esterna[$chiave]]=$row_esterna[$dato_principale];
					//echo "\$value[{$row_esterna[$chiave]}]=\$row_esterna[{$dato_principale}]";
								
					//echo "<br />if (\$row[{$alias}(\$alias)]==\$row_esterna[{$dato_principale}(\$dato_principale) oppure {$chiave}(\$chiave)]) \$selected=\$row_esterna[{$chiave}(\$chiave)]<br />";
					if ($row[$alias]==$row_esterna[$dato_principale]) $selected=$row_esterna[$chiave]; //?? ci dovrebbe essere solo il controllo sotto?
					if ($row[$alias]==$row_esterna[$chiave]) $selected=$row_esterna[$chiave]; //per il POST		
					//if ($row[$chiave_esterna]==$row_esterna[$chiave]) $selected=$row_esterna[$chiave]; //per il POST

				}		
				
				
				$dati_chiave_esterna=mysql_fetch_field(mysql_query("Select $chiave_esterna FROM $this->originalPrimaryTable"));
				$validate=$dati_chiave_esterna->not_null==1?REGEXP_NOTNULL:false; //maremma troia! gliel'assegna qui stocazzo di validazione
				
				$added=$this->editForm->addInput("select",$chiave_esterna,$value,$alias_show,false,$selected,$validate,$this->classForFormInput['inputs']);			
				
				if (is_array($id) && $added) $fieldEnablingControl.= $this->getFieldEnablingControl('SELECT',$chiave_esterna,$alias_show);
				
			}
			else //*****CAMPI DELLA TABELLA PRINCIPALE
			{
			
				if (is_array($id)) ///i campi univoci non si modificano per + record
				{
					$describe=mysql_query("DESCRIBE ".$this->originalPrimaryTable);  	
					while ($describe_field=mysql_fetch_array($describe))
					if ($describe_field['Field']==$current_field->name && $describe_field['Key']=="UNI") continue 2; //..
				}

			 		
				$TYPE=explode("(",$current_field->type);//serve per identificare gli ENUM -- prima era l'explode con ('

				switch($TYPE[0])
				{	
					case "password":if (is_array($id)) break;
									
									if ($edit==0)
									$this->editForm->addInsertPasswordInputs($current_field->name,ucfirst(str_replace("_"," ",$current_field->def)),$this->classForFormInput['inputs']);
									else
									$this->editForm->addChangePasswordInputs($current_field->name,ucfirst(str_replace("_"," ",$current_field->def)),$this->classForFormInput['inputs']);
									break;
					case "date":

									if (isset($this->monthYearField[$current_field->name]))
										$t="DATE_MY";
									else
										$t="DATE";	
										

									$added=$this->editForm->addInput($t,"$current_field->name",array($this->dateInterval[0],$this->dateInterval[1]),ucfirst(str_replace("_"," ",$current_field->def)),true,$row[$current_field->def],$current_field->not_null,$this->classForFormInput['inputs']);

									if (is_array($id) && $added) 
										$fieldEnablingControl.= $this->getFieldEnablingControl('DATE',$current_field->name,$current_field->def);

															
								break;
					case"string":
					case"int": 		//print_r($current_field);			
					case"real":	
								
								if (isset($this->photoField[$current_field->name]) || isset($this->fileField[$current_field->name]))
								{
									if (is_array($id)) break; //foto non modificate in modo multiplo
									
									if (
										(isset($this->photoField[$current_field->name]) && $this->photoField[$current_field->name]==true)
										|| 
										(isset($this->fileField[$current_field->name]) && $this->fileField[$current_field->name]==true)
										)
									{
										if ($current_field->not_null[0]==true) $bool=false; else {$bool=true;} //do' la possibilità di eliminare il file 
																											//solo se non è un campo obbligatorio
										$current_field->not_null[0]=false; //in ogni caso, una volta che il file è stato caricato, non gli assegno
																			//una validazione obbligatoria nel form 
										
									} else
									$bool=false;

										
									$this->editForm->addInput("file",$current_field->name,$row[$current_field->def],ucfirst(str_replace("_"," ",$current_field->def)),$bool,false,$current_field->not_null,$this->classForFormInput['inputs']);
								}
								else 
								{
								
									$added=$this->editForm->addInput("text",$current_field->name,$row[$current_field->def]
																	 ,ucfirst(str_replace("_"," ",$current_field->def)),$maxlength,false,$current_field->not_null
																	 ,$this->classForFormInput['inputs']);

									if (is_array($id)  && $added) 
									{
										$JS= "
										new AutoSuggestControl('{$this->originalPrimaryTable}',document.getElementById(\"{$current_field->name}\"),\"{$current_field->name}\");
										";

										if ($this->ajaxCall) $print.="<script type=\"text/javascript\"><!-- {$JS} --></script>";
										else $this->JS_onLoad.=$JS;									
										
										$fieldEnablingControl.= $this->getFieldEnablingControl('TEXT',$current_field->name,$current_field->def);
									}
								}
								
								break;
																	
					case "longtext": 
					case "mediumtext": 
									
									$added=$this->editForm->addInput("textarea",$current_field->name,$row[$current_field->def]
										  ,ucfirst(str_replace("_"," ",$current_field->def)),$this->HTMLTextareaParams,false,$current_field->not_null
										  ,$this->classForFormInput['textareas']); 

									if (is_array($id) && $added)
										$fieldEnablingControl.= $this->getFieldEnablingControl('HTML_TEXTAREA',$current_field->name,$current_field->def);

								break;		 
					
					case "text": 
					case "tinytext":   
									
									$added=$this->editForm->addInput("textarea",$current_field->name,$row[$current_field->def]
										  ,ucfirst(str_replace("_"," ",$current_field->def)),false,false,$current_field->not_null
										  ,$this->classForFormInput['textareas']); 		 

									if (is_array($id) && $added)
										$fieldEnablingControl.= $this->getFieldEnablingControl('TEXTAREA',$current_field->name,$current_field->def);	
									
								break;
					
					case"enum": 
								$heading=ucfirst(str_replace("_"," ",$current_field->def));								
								
								$value=$this->getEnumSetValue($current_field->type);
																				
								if (count($value)>$this->radioSettings['maxOptionsInOneLine']) $bool=false; else $bool=true; //su una riga o no
								
								if (count($value)>$this->radioSettings['maxOptions']) 
								{
									$type="SELECT";
									$value=array_merge(array(''=>$this->lang['select']." ".$heading), $value); //aggiungo l'intestazione
								}
								else 
								{
									$type="RADIO";									
								}
																						
								$added=$this->editForm->addInput($type,$current_field->name,$value,$heading,$bool,$row[$current_field->def]
									  ,$current_field->not_null,$this->classForFormInput['inputs']); 
								
								if (is_array($id) && $added) 
									$fieldEnablingControl.= $this->getFieldEnablingControl($type,$current_field->name,$current_field->def);										
																	
								break;		 
					
					case"set" :	
								$heading=ucfirst(str_replace("_"," ",$current_field->def));
								
								$value=$this->getEnumSetValue($current_field->type);
								
								
								if (count($value)>$this->checkboxesSettings['maxCheckboxes'])
								{
									$type="SELECT";
									/////////////$value=array_merge(array(''=>$this->lang['select']." ".$heading), $value); //aggiungo l'intestazione
									$bool=$this->checkboxesSettings['multipleSelectSize'];
								}
								else 
								{
									$type="CHECKBOX";	
									$bool=false;								
								}								

								$added=$this->editForm->addInput($type,$current_field->name,$value,$heading,$bool,explode(",",$row[$current_field->def])
									  ,$current_field->not_null,$this->classForFormInput['inputs']); 
									  								
								if (is_array($id) && $added) 
									$fieldEnablingControl.= $this->getFieldEnablingControl($type,$current_field->name,$current_field->def,count($value));																									
								
								break;		 
				
				}//end switch
			}//end if
		} //end foreach
		
		
		if ($fieldEnablingControl!="") //intestazione
			$print.="<div style=\"border-top:1px solid #DDD;border-bottom:1px solid #DDD;padding:6px 0px;
								  margin-bottom:6px;font-weight:bolder;font-size:larger;font-style:italic\">
						{$this->lang['fieldEnablingControlHeading']}</div>";
			
		
		$editForm_string = $this->editForm->buildForm($this->lang['confirmData'],$this->classForFormInput['buttons']);		
		$editForm_string = $this->brutalTextReplace($replace_array,$editForm_string);

		if ($this->useAjax)
			$editForm_string=str_replace("<form ","<form onsubmit=\"document.getElementById('img_loading_dbn').style.display='block'\"",$editForm_string);
		
		$print.= $editForm_string;

		if ($fieldEnablingControl!="") //codice javascript ---deve essere messo DOPO il form altrimenti la rilevazione
			$print.=$fieldEnablingControl; // dello stato della textarea HTML non riesce perchè deve ancora inizializzarsi

	
		return $print;
	}	
	
	//serve per identificare i valori dell'ENUM/SET
	private function getEnumSetValue($typeDefinition)
	{
		$start_cut=strpos($typeDefinition,"('")+2;
		$value=substr($typeDefinition,$start_cut,-2);
		
		$temp=explode("','",$value);
		$value=array();	
		foreach($temp as $v)
		{
			$v=str_replace(array("''","\\\\",),array("'","\\"),$v);
			$value[$v]=ucfirst($v);
		}	
		return $value;							
	}

	private function getFieldEnablingControl($type,$name,$heading,$length=null)
	{
		$JSDisable="";
		
		if ($this->ajaxCall) $JSDisable="change_{$name}_status();";
		else $this->JS_onLoad.="
									change_{$name}_status();
								";		
			
		//stato: abilitato. link per disabilitare la modifica sul campo																								
		$enableCode="											
							a.style.color='#C00';
							a.innerHTML='[ <img style=\"border:0px\" src=\"".$this->imagesAndScriptsPath."delete.png\" /> DO NOT Edit ]&nbsp;&nbsp;&nbsp;';
													   ";
		
		//stato: disabilitato. link per abilitare la modifica sul campo																
		$disableCode="																								
							a.style.color='#060';
							a.innerHTML='[ <img style=\"border:0px\" src=\"".$this->imagesAndScriptsPath."edit.png\" /> EDIT ]&nbsp;&nbsp;&nbsp;' ;
																							
													  ";
	
													
		switch(strtoupper($type))
		{
			case 'DATE':		
								$JSFunctionBody="
												var el1=document.getElementById('frm_{$this->originalPrimaryTable}').{$name}_day; 
												var el2=document.getElementById('frm_{$this->originalPrimaryTable}').{$name}_mon;
												var el3=document.getElementById('frm_{$this->originalPrimaryTable}').{$name}_yea;
												
												container = el1.parentNode.parentNode.previousSibling.previousSibling;	
												
												//alert(container.innerHTML);
												
												
												if (el1.style.display=='none')
												{
													el1.disabled=false;
													el2.disabled=false;
													el3.disabled=false;
													
													el1.style.display='block';
													el2.style.display='block';
													el3.style.display='block';
													
													
													{$enableCode}
													
												}
												else
												{
													el1.disabled=true;
													el2.disabled=true;
													el3.disabled=true;
													
													el1.style.display='none';
													el2.style.display='none';
													el3.style.display='none';
													
													{$disableCode}

													
												}
										";	
								break;	
								
			case 'HTML_TEXTAREA':
								$JSFunctionBody="
												if (document.all)
												{
													var elDoc = window.document.frames('{$name}').document;
													var el = window.document.frames('{$name}');
												}
												else
												{
													var elDoc = document.getElementById('{$name}').contentDocument;										
													var el = document.getElementById('{$name}');										
												}
												
												container = el.parentNode;	
//alert(el.parentNode.getElementsByTagName('div')[0].innerHTML);
												
												if (elDoc.designMode=='off')
												{
													elDoc.designMode='on';
													el.style.height='auto';
													//el.parentNode.getElementsByTagName('div')[0].style.visibility='visible';
													{$enableCode}
													
												}
												else
												{
													elDoc.designMode='off';
													el.style.height='0px';
													///el.parentNode.getElementsByTagName('div')[0].style.visibility='hidden';
													{$disableCode}
													
												}
										";	
								break;	
			case 'TEXTAREA':																		
							$JSFunctionBody= "
											var el=document.getElementById('frm_{$this->originalPrimaryTable}').{$name}; 
											
											container = el.parentNode;	
																							
											if (el.style.display=='none')
											{
												el.disabled=false;
												el.style.display='block';

												//aggiungo all'input che indica i campi da modificare
												
												{$enableCode}
												
											}
											else
											{						
												el.disabled=true;																		
												el.style.display='none';

												
												{$disableCode}																																
											}											
									";
							
							break;	
															
			case 'TEXT':
			case 'SELECT':																		
							$JSFunctionBody= "
											var el=document.getElementById('frm_{$this->originalPrimaryTable}').{$name}; 
											
											container = el.parentNode.previousSibling.previousSibling;	
																							
											if (el.style.display=='none')
											{
												el.disabled=false;
												el.style.display='block';

												//aggiungo all'input che indica i campi da modificare
												
												{$enableCode}
												
											}
											else
											{						
												el.disabled=true;																		
												el.style.display='none';

												
												{$disableCode}																																
											}											
									";
							
							break;	
							
												
			case 'RADIO':
						$JSFunctionBody="
											var el=document.getElementById('frm_{$this->originalPrimaryTable}').{$name}; 
									
											container = el[0].parentNode.parentNode.parentNode.childNodes[1];	
											
									
											if (el[0].disabled==true)
											{
												
												for (i=0;i<el.length;i++) el[i].disabled=false;
												
												el[0].parentNode.parentNode.style.visibility='visible';
												{$enableCode}										
											}
											else
											{
												
												for (i=0;i<el.length;i++) el[i].disabled=true;

												el[0].parentNode.parentNode.style.visibility='hidden';
												{$disableCode}	
											}
									";
						break;
						
			case 'CHECKBOX':
						$JSFunctionBody="
											var el=document.getElementById('frm_{$this->originalPrimaryTable}').elements['{$name}[0]']; 


											container = el.parentNode.parentNode.parentNode.childNodes[1];	

											
											if (el.disabled==true)
											{
												for (i=0;i<{$length};i++) 
													document.getElementById('frm_{$this->originalPrimaryTable}').elements['{$name}['+i+']'].disabled=false;
												
												el.parentNode.parentNode.style.visibility='visible';
												{$enableCode}			
											}
											else
											{
												for (i=0;i<{$length};i++) 
													document.getElementById('frm_{$this->originalPrimaryTable}').elements['{$name}['+i+']'].disabled=true;
													
												el.parentNode.parentNode.style.visibility='hidden';
												{$disableCode}		
											}										
									";
						break;
		}

		return "
				<script type=\"text/javascript\">
					<!--
						change_{$name}_status=function()
						{
							fieldList=document.getElementById('frm_{$this->originalPrimaryTable}').fieldList;
							
							if (fieldList.value.indexOf('{$name}')!=-1) //rimuovo dall'input che indica i campi da modificare
							{
								exp=fieldList.value.split(',');
								for (i=0;i<exp.length;i++)
								if (exp[i]=='{$name}')
								{
									temp=exp[exp.length-1];
									exp[exp.length-1]=exp[i];
									exp[i]=temp;
									exp.pop();
									temp=true;
									break;
								}
								fieldList.value=exp.join(',');
								
							}
							else //da riaggiungere il nome nella field List
								fieldList.value+=',{$name}';
							
							//alert(fieldList.value);						
							
							var a=document.createElement('a');	//il nuovo elemento link che fa lo switch...
							
							{$JSFunctionBody}
		
							a.style.fontWeight='Bold';
							a.style.textDecoration='none';
							a.href='javascript:change_{$name}_status()';

														
							div=document.createElement('div');
							div.appendChild(a); 
							old = container.replaceChild(div,container.firstChild);
							
		
							if ( old.innerHTML.indexOf('<a')==0) //c'è il link come primo elemento
								div.appendChild(old.lastChild);	
							else 								//prima sostituzione ...metto l'etichetta in fondo
								div.appendChild(old);	
						}
						{$JSDisable}
						
					-->
					</script>

					";			
		
		
	}	
	
	private function viewForPrint($id=null)
	{
		$print="";

		
		$row=mysql_fetch_array(mysql_query($this->addWhereConditionToQuery($this->query,"{$this->primaryTable}.{$this->originalPrimaryKey}='$id'")));

		//$print.= $this->addWhereConditionToQuery($this->query,"{$this->primaryTable}.{$this->primaryKey}='$id'");
		if ($row) //Modalità modifica
		{
			
			
			if (is_array($this->photoField) || is_array($this->fileField)) //formattazione div contenitore per le immagini (e file)
			{

				foreach ($this->photoField as $field=>$bool)
				{ 
					if ($field=="_Resize_" || $field=="_KeepOriginal_") continue; ////da sistemare......? parametri delle immagini nello stesso array
					if ($row[$field]!="")
					{			
						if (!isset($div_flag)) //stampa il div una volta sola , solo se c'è qualcosa 
						{
							$print.= "<div style=\"position:relative;float:right;border:1px solid #000000;width:47%;padding:2% 0% 2% 2%\">";
				 			$div_flag=true;
						}
							
						if (!$this->photoField['_Resize_']) $small=""; else $small="small_";
						$print.="<h4>".ucfirst($field)." corrente</h4>";
						if ($small=="small_") $print.="<a href=\"{$this->filePath}/{$row[$field]}\" onclick=\"window.open(this.href);return false;\">";
						$print.="<img src=\"{$this->filePath}/$small{$row[$field]}\" alt=\"{$row[$field]}\" /><br />".$row[$field];
						if ($small=="small_") $print.="</a>";
						$this->photoField[$field]=true; ///
					}
				}

				foreach ($this->fileField as $field=>$bool)
				{ 
					if ($row[$field]!="")
					{
						if (!isset($div_flag))  //stampa il div una volta sola , solo se c'è qualcosa 
						{
							$print.= "<div style=\"position:relative;float:right;border:1px solid #000000;width:47%;overflow:scroll;padding:2% 0% 2% 2%\">";
				 			$div_flag=true;
						}					
						$print.="<h3>".ucfirst($field)." corrente</h3>
						<a href=\"{$this->filePath}/{$row[$field]}\" onclick=\"window.open(this.href);return false;\"><strong>{$row[$field]}</strong></a>";
						$this->fileField[$field]=true; ///
					}
				}
				if (isset($div_flag)) $print.="</div><div style=\"position:relative;float:left;width:50%\">";
			}
		} else 
		{
			die('Id errato');
		}

		$print.="
		<div style=\"font-size:15px;font-family:Arial,Verdana,sans serif\">
		<span style=\"font-size:20px\">Visualizzazione dati {$this->rowName} $id</span><br /><br />
		";


		foreach ($this->field as $current_field)
		{
			 		$TYPE=explode("(",$current_field->type);//serve per identificare gli ENUM

					switch($TYPE[0])
					{	
						case "password":$data="<em>( informazione codificata )</em>";break;
						case "date":$data=data_europea($row[$current_field->def]);break;
						case "datetime":$data=data_ora_europea($row[$current_field->def]);break;
						default:$data=$row[$current_field->def];
					}
					
					if ($data=="") $data="<em>( informazione non presente )</em>";
						
					$print.="<span style=\"font-weight:bolder;color:#000088\"><em>".ucfirst(str_replace("_"," ",$current_field->def))." : </em></span>".$data."<br /><br />";
						

		} //end foreach
		

		if (isset($div_flag))  //formattazione tabella contenitore
		{
			$print.="</div>";
		}		

		return $print."</div>";
	}	
		

	private function export($type)
	{
		 
		$validField=array();
		
		foreach ($this->field as $current_field)
		{
			if (isset($this->passwordField[$current_field->def])) continue;		
			if (isset($this->photoField[$current_field->def])) continue;					
			if (isset($this->fileField[$current_field->def])) continue;	
			if ($this->hidePrimaryKey && $current_field->def==$this->originalPrimaryKey) continue;	
			
			$list[] = strtoupper(str_replace("_"," ",$current_field->def));
			$validField[] = $current_field ;			
						
		} //end foreach


		
		
		
		$result=mysql_query($this->getFullQuery()) or die ('errore query generazione CSV '.mysql_error());
		
		
		
		
		$data=array();
		$data[0]=$list;
		
		while ($row=mysql_fetch_array($result))
		{
			$data[count($data)]=array();
			
			foreach ($validField as $field)
			{
				
									
				$TYPE=explode("(",$field->type);//serve per identificare gli ENUM

				switch($TYPE[0])
				{	
					case "date":$temp=data_europea($row[$field->def]);break;
					case "datetime":$temp=data_ora_europea($row[$field->def]);break;
					default:$temp=$row[$field->def];
				}
				
				$data[count($data)-1][]=trim(
											strip_tags(str_replace(array("<br />","<br>","<BR />","<BR>","\r","\n","&nbsp;"),array(" "," "," "," "," "," "," "),$temp))
											);			
	
			} //end foreach
			
			

		}
		
		//ob_end_clean(); //l'url col quale si accede a questo codice comprende il get che attiva la modalità ajax e cancella il buffer già nella funzione go()
		
		$filename=$this->originalPrimaryTable."__".date("d_m_Y")."__".date("H_i_s");
		
		$print="";
		
		if ($type=='CSV')
		{	
			header('Content-Type: application/vnd.ms-excel; charset=utf-8');
			header("Content-Disposition: attachment; filename=\"{$filename}.txt\"");		
				
			foreach($data as $row)
			{
				foreach ($row as $key=>$data)
				$row[$key]=html_entity_decode(str_replace('"','""',$row[$key])); //escape di " con " ("")
				
				$print.='"'.implode('","' , $row)."\"\r\n";					
			}
		}
		else
		{
		
			header('Content-Type: application/vnd.ms-excel; charset=utf-8');
			header("Content-Disposition: attachment; filename=\"{$filename}.xml\"");		
		
			// è IMPORTANTE che <?xml parta al primo carattere del file sennò OO non lo vede 
			$print.="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
			
			<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" >			
				<ss:Worksheet ss:Name=\"".$this->originalPrimaryTable."\">			
					<Table ss:ExpandedColumnCount=\"".count($validField)."\">";
			
					foreach($data as $row)
					{
						$print.='
								<Row>
								';
						
						foreach ($row as $key=>$data)
						{
							if (preg_match("/^\d+((\.|,)\d+)?$/",$row[$key]))
							{
								$datatype='Number';
								$row[$key]=str_replace(',','.',$row[$key]); //la virgola non è interpretata nei numeri.
							}
							else 
							{
								$datatype='String';
								$row[$key]=preg_replace('/(&)(([^a]|$)|a([^m]|$)|am([^p]|$)|amp([^;]|$))/','$1amp;$2',$row[$key]); //per compatib.,sostit. & con &amp;
								//considerare l'uso di <![CDATA[BROWNIES<> & CO.]]> invece di BROWNIES&gt;&lt; &amp; CO.
							}
							$print.="<Cell>
										<Data ss:Type=\"".$datatype."\">".$row[$key]."</Data>
									 </Cell>";							 
						}
						
						$print.='
								</Row>
								';
						
					}
			
			$print.='			
					</Table>
				</ss:Worksheet>
			</Workbook>';
		
		}

		die( $print );
	}	
			
	



	private function managePassword($field)
	{
	
			//unset($_POST[$field."_retyped"]);
			
			$old_password=isset($_POST[$field."_old"])?$_POST[$field."_old"]:"";
			unset($_POST[$field."_old"]);
			
			$new_password=isset($_POST[$field])?$_POST[$field]:"";
			unset($_POST[$field]);
	
			if ($field && $new_password!='')
			{
				if ($_POST['edit_'.$this->originalPrimaryTable]==='1')// fase di modifica dati
				{
					
					$row=mysql_fetch_array(mysql_query("SELECT {$field} FROM {$this->originalPrimaryTable} WHERE $this->originalPrimaryKey=\"".$_POST[$this->originalPrimaryKey]."\""));
					if ( md5($old_password)==$row[$field] || /*password vuota*/($old_password=='' && $row[$field]=='') )
					{
						$_POST[$field]=md5($new_password);
						return true;
					}
					else 
					{
						return false;
					}
				}else $_POST[$field]=md5($new_password); //fase di inserimento dati
			}
			
			return true;
	}
	
	

	
	
}

?>