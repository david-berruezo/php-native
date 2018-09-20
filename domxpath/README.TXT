	  SaxOPHONE
	  =========

           0OOOOON                                                 
    NNX00kdk0KXKdl0N                                           
  cccllxKXX    0oxkxX                                         
                OdkOO                                    
                 OdxdO             
                  KxookN                
                   kxloxN                          
                   NdoldxX    KK0KK0O0d
                    kooclo0  0ldc;;coodkK
                     oxloo:X OkX0dc;cok0K                                      
                     XoxcxocNk0X0OxoxN                                         
                      XddcxooxO0OkxoX                                          
                       Xxdloc,:kxollxK                                         
                        Oxoodc:lxc:clN                                         
                        Koxldd:;ooxxdlkN                                       
                         0xocddxkk0Okok                                        
                          XddOOxxO0OxdO                                        
                           0kodkOkxxkX                                         
                             dlkO0N 

 * @author Juraj Puchký - Devtech <sjurajpuchky@seznam.cz>
 * @license GPLv3
 * @homepage http://www.devtech.cz
 * @copy (c) 2013 Juraj Puchký - Devtech

Intro:
  Saxophone is simple stream xml parser with optional configuration support. You no need more than 1MB memory to process XML file.
  Is fast as possible and access interface is integrated into file stream support, that means you can access XML file from any where
  and process directly. Saxophone is licensed under GPLv3 any time you wish use in commercial application, kindly contact me and we will
  discuss commerce non exclusive developer license and conditions related with copyright rights.

How to use:
===========

At first you have to include Saxophone.php class file.
Configure options global variable as well.

  $GLOBALS["xmlopt"] = array( 
     "encoding" => "utf-8", 
     "object" => "//*/SHOPITEM", 
     "type" => "XPATH",         // TAG,XPATH,TAGSLIST 
     "fields" => array( 
         "productName" => "//*/SHOPITEM/PRODUCT" 
     )  
 ); 
       
Specify encoding
================
encoding - specify which encoding should be as target encoding for parsing XML file default is UTF-8.

Specify object
==============
object - specifies tag name or xpath of object which encapsule required fields.

Types parser point of view
==========================
TAG      - Tags are separed and identified by TAG NAME only.
XPATH    - Tags are separed and identified by XPATH.
TAGSLIST - Result object has filled public supportedTags variable with array of exisiting tags.

Ignition of stream
==================
  /- File handler
  |            /- Saxophone protocol
  |            |     /- global variable name of processed object accessor
  |            |     |     /- function name to post process parsed object
  |            |     |     |         /- function name to post process tag
  |            |     |     |         |          /- Url of XML File 
  |            |     |     |         |          |          /- global variable of saxophone parser options 
  |            |     |     |         |          |          |
 $fp = fopen("sax://xml;xprocess;xprocesstag;sample.xml;xmlopt","rb",true); 
 // Load fuel till end by 4096 bytes
 while(!feof($fp)) { fread($fp,4096);} 
 // Close fire
 fclose($fp); 
 // Mision completed we are on the orbit
