<?

/**
* About author:
*  vivekanandan
* email: vivekanandan8@gmail.com
*
* If you want to any help on spider ot any thing in php just mail me 
*
* About class:
*  WebSpider    -  constructor set the domain & url to map it   
*  
*   processTagInPageData() 	- it process the anchor tag & frame tag as googlebot does
*   fetchURLPageData() 		- it returns the html page content for the given URL
* 	isURLExists()			- it checks wheather the given url is added in DB  
*   displayDomainRecords    - it displays teh records  from DB    
* 	StoreUniqueURL 			- it stores the unique url in DB 
* 	processSpecificTagbyType-  it parse each & every tag & truncate the parsed tag from the string 
*/


include "spider_simple.class.php";
ini_set("display_errors",1); 
 
 
/* table structure 

CREATE TABLE `spider` (
  `id` bigint(20) NOT NULL auto_increment,
  `domain` varchar(150) NOT NULL,
  `url` varchar(2000) NOT NULL,
  `parentid` int(11) NOT NULL,
  `visitflag` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `level` mediumint(9) NOT NULL,
  PRIMARY KEY  (`id`)
)
*/


 
$vDomain = "test";
$vURL 	 = "www.google.co.in";
$oWebSpider = new WebSpider($vDomain, 0,$vURL); 
$oWebSpidermDBHost		= "localhost";
$oWebSpider->mDBUserName  = "dbuser";
$oWebSpider->mDBPassword  = "pass";
$oWebSpider->mDBDatabase  = "test";	
$oWebSpider->ProcessSpiderInit();
$oWebSpider->fetchURLDataandParseURL();

$oWebSpider->displayDomainRecords($vDomain); 


?>