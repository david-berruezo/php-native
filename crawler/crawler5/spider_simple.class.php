<?

/**
* About author:
*  vivekanandan
* email: vivekanandan8@gmail.com
*
* If you want to any help on spider ot any thing in php just mail me 
*
* About class:
*  WebSpider    -  constructor set teh domain & url to map it 
*  
*   processTagInPageData() 	- it process the anchor tag & frame tag as googlebot does
*   fetchURLPageData() 		- it returns the html page content for the given URL
* 	isURLExists()			- it checks wheather the given url is added in DB  
*   displayDomainRecords    - it displays teh records  from DB    
* 	StoreUniqueURL 			- it stores the unique url in DB 
* 	processSpecificTagbyType-  it parse each & every tag & truncate the parsed tag from the string 
*/



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


class WebSpider {

var $mMaxDepth;
var $mDomain;
var $mDBHost;
var $mDBUserName;
var $mDBPassword;
var $mDBDatabase;
var $mURLPageData;
var $mURL;


	function WebSpider($pmDomain, $pmDepth,$pmURL) { 
	
		$this->mDomain		= $pmDomain;
		$this->mMaxDepth	= $pmDepth;
		$this->mURL			= $pmURL;
					
	}
	
	function isURLExists($pmDomain, $pmURL) {  

		mysql_connect($this->mDBHost,$this->mDBUserName,$this->mDBPassword);
		mysql_select_db($this->mDBDatabase);  
		
		$vSQL  = "SELECT count( id ) AS cnt FROM spider
					WHERE  domain = '$pmDomain' and url = '$pmURL'";
		$rs = mysql_query($vSQL); 
		$oRecord = mysql_fetch_assoc($rs);
		return $oRecord['cnt'];
		
    }

	function displayDomainRecords($pmDomain){
	
	   	mysql_connect($this->mDBHost,$this->mDBUserName,$this->mDBPassword);
		mysql_select_db($this->mDBDatabase);  		
		
		$vSQL = "select count(id) as cnt   from  spider where domain = '$pmDomain' ";
		$rsURLList = mysql_query($vSQL);
		$vCnt = mysql_fetch_assoc($rsURLList);
		
			
		$vSQL = "select *   from  spider where domain = '$pmDomain' order by id asc ";
		$rsURLList = mysql_query($vSQL);
		print "<strong>Domain</strong> : ".$pmDomain ." <strong>Total URL</strong> :".$vCnt['cnt'];
		?>
		<table width='80%'  cellspacing='2' cellpadding='2' border="1">
		  <tr>
			<td><strong>URL</strong></td>
			<td><strong>Type</strong></td>
		  </tr>
		<?
		while($aRec = mysql_fetch_assoc($rsURLList)) { ?>			
   		  <tr>
			<td><?php echo $aRec['url'] ?></td>
			<td><?php echo htmlspecialchars($aRec['type'] )?></td>

		  </tr>
     	<? }  ?> 
         </table>
        
        <? 
		

	
	}
	
	function StoreUniqueURL($pmDomain, $pmURL, $pmParentId=0, $pmLevel,$pmType){
	
		mysql_connect($this->mDBHost,$this->mDBUserName,$this->mDBPassword);
		mysql_select_db($this->mDBDatabase);  		 
	
		$pmURL = mysql_real_escape_string($pmURL); 
		if($this->isURLExists($pmDomain,$pmURL)==0) {  	
			$vURLSQL = " INSERT INTO `spider` ( domain, `url` , `parentid` , `visitflag` , `type` , `level` )
							VALUES ('$pmDomain' , '$pmURL', '$pmParentId', '0', '$pmType', '$pmLevel' )";				
			mysql_query($vURLSQL); 	
		}
		
	}


	function fetchLinkfromTag($pmData, $pmTagName, $pmAtributeName){ 
	
		$vPos = strpos($pmData, $pmTagName);
		if($vPos === false){
			return false; // if no link found stop search 
		}
		$vPos += strlen($vStr); 	
		$vSubStr = substr($pmData,$vPos);
		
		$vHrefPos = strpos($vSubStr, $pmAtributeName);
		$vSubStr = substr($vSubStr,  $vHrefPos);
	
		
		$url = explode('"',$vSubStr);	
		return array("url"=>$url[1],"str"=>$vSubStr);
		
	}




	function fetchURLPageData($vURL) { 

		$rCurlRes = curl_init();
		curl_setopt($rCurlRes, CURLOPT_URL,$vURL);		
		curl_setopt($rCurlRes, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13)');
		curl_setopt($rCurlRes, CURLOPT_REFERER, $this->mDomain);
		curl_setopt($rCurlRes, CURLOPT_AUTOREFERER, true); 	  
		curl_setopt($rCurlRes, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($rCurlRes, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1	
		$res = curl_exec($rCurlRes);
		return $res;
	}
	
   function ProcessSpiderInit() { 
         
	$this->StoreUniqueURL($this->mDomain, $this->mURL, 0,1,'index');  
	
   }
     

   function processSpecificTagbyType($pmData, $pmTagName, $pmAttribute) {
      
    do {    
			$aResult = $this->fetchLinkfromTag($pmData,$pmTagName, $pmAttribute); 			
			
			$vURL 	= $aResult['url'];
			$pmData = $aResult['str']; 			
			if($pmData) {
				$this->StoreUniqueURL($this->mDomain, $vURL , 1,  1, $pmTagName);  
			}
			$vIndex++;    			
			
	 }while($pmData);	 
   
   }   


   
   function processTagInPageData($pmData) {  
   
   	   $this->processSpecificTagbyType($pmData,'<a',"href=");  
       $this->processSpecificTagbyType($pmData,'<frame', "src=");       
   
   }
   
   
   function fetchURLDataandParseURL() { 

	  $vData   = $this->fetchURLPageData($this->mURL);  	
   	  $this->processTagInPageData($vData);  	  
  }		

}

?>