<?

/**
* About author:
*  vivekanandan
* email: vivekanandan8@gmail.com
*
* If you want to any help on spider ot any thing in php just mail me 
*
* About class:
*  WebSpider    -  constructor set the domain & url to map it, set the db host,user name,database in the constructor  
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

class URLParser {

    //This function removes the protocol string for the given URL  
	function removeProtocolString($pmSiteURL){
	
		$vProtocolSep = "//";
		$vProtocolPosition = strpos($pmSiteURL, $vProtocolSep);	
		if($vProtocolPosition == false) { 	   
			return $pmSiteURL;
		}else{	
			$vProtocolPosition  = $vProtocolPosition + strlen($vProtocolSep);
			$vSiteURL 			=  substr($pmSiteURL, $vProtocolPosition, strlen($pmSiteURL)-$vProtocolPosition);
			return array("protocol"=>substr($pmSiteURL,0,$vProtocolPosition),"LinkPath"=>$vSiteURL);
		}
	} 

   //checks for the given link is full qualified url (http://www.sample.com/ssl/index.php) 
	function isPtotocolStr($pmStr) {
	
	 if(substr($pmStr,0,1)=='/'){
		 return true;
	 }
	
	if(strpos($pmStr,"http:")===false)  
		return false;
	else
		return true; 
	}




   //if given url is relative path like (../index.php), convert to the full qualified URL as http://www.sample.com/index.php 
	function getURLfromLinks($pmDomainName, $pmSiteURL, $pmLinks){

	  
	  //if the path mention starts from the root, then add the domain  name 
	  if($pmLinks[0] == '/') { 
		   return  $pmDomainName .$pmLinks;       

	  }
	
	  $aSiteURLInfo     		=  $this->removeProtocolString($pmSiteURL);
	  $vSiteURL = $aSiteURLInfo['LinkPath'];
	  
	 if($this->isPtotocolStr($pmLinks)) { 	 
			 return  $pmLinks;  		 
		 }else{ 	  
		  
		  $aLink = explode("../",$pmLinks);
		  $vTotalLink = count($aLink);  
		  $aSitePath = explode('/', $vSiteURL,-$vTotalLink);  
		  $vSitePath = implode("/",$aSitePath).'/'.str_replace("../",'',$pmLinks);	  
		   return $aSiteURLInfo['protocol'].$vSitePath;
		  }	  


	} 
	

   //This will get the link from the given tag with its attribute   
	function fetchLinkfromTag($pmData, $pmTagName, $pmAtributeName){  
	
		$vPos = strpos($pmData, $pmTagName);
		if($vPos === false){
			return false; // if no link found stop search 
		}
		// copy the substring which starts from current tag ending, 
		//so that on next tag search is it wont availavle & makes speed up search
		$vPos += strlen($pmTagName); 	
		$vSubStr = substr($pmData,$vPos); 
		
		//get the string for the  tag attribute value like <a tag as href atrtribute 
		$vHrefPos = strpos($vSubStr, $pmAtributeName);
		$vSubStr = substr($vSubStr,  $vHrefPos);         	
		  
		$url = explode('"',$vSubStr);	 
		return array("url"=>$url[1],"str"=>$vSubStr);
		
	}
	 
}


class WebSpider extends URLParser { 

var $mMaxDepth;
var $mDomain;
var $mDBHost;
var $mDBUserName;
var $mDBPassword;
var $mDBDatabase;
var $mURLPageData;
var $mURL;


	function WebSpider($pmDomain, $pmDepth, $pmURL, $pmHost, $pmDBUserName, $pmDBPwd, $pmDBName  ) { 
	
		$this->mDomain		= $pmDomain;
		$this->mMaxDepth	= $pmDepth;
		$this->mURL			= $pmURL;
		$this->mDBHost		= $pmHost;
		$this->mDBUserName  = $pmDBUserName;
		$this->mDBPassword  = $pmDBPwd;
		$this->mDBDatabase  =  $pmDBName; 
	}
	
	//it just checks for the url is already  exist or not 
	function isURLExists($pmDomain, $pmURL) {  

		mysql_connect($this->mDBHost,$this->mDBUserName,$this->mDBPassword);
		mysql_select_db($this->mDBDatabase);  
		
		$vSQL  = "SELECT count( id ) AS cnt FROM spider
					WHERE  domain = '$pmDomain' and url = '$pmURL'";
		$rs = mysql_query($vSQL); 
		$oRecord = mysql_fetch_assoc($rs);

		return $oRecord['cnt'];
		
    }

     // this will display the result from the DB
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
	
	
	//This will stored the url in DB
	function StoreUniqueURL($pmDomain, $pmURL, $pmParentId=0, $pmLevel,$pmType){
	
		mysql_connect($this->mDBHost,$this->mDBUserName,$this->mDBPassword);
		mysql_select_db($this->mDBDatabase);  		 
	
		$pmURL = mysql_real_escape_string($pmURL); 
		if($this->isURLExists($pmDomain,$pmURL)==0) {  	
			$vURLSQL = " INSERT INTO `spider` ( domain, `url` , `parentid` , `visitflag` , `type` , `level` )
							VALUES ('$pmDomain' , '$pmURL', '$pmParentId', '0', '$pmType', '$pmLevel' )";				
			mysql_query($vURLSQL); 	
			mysql_close();
		}
		
	}

    //This will get get the  html page content for the given url
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
			$pmData = $aResult['str']; //get the unparsed string & parse it    			
			  			
			$vURL 	= $aResult['url'];			
			$vSiteLinks  =  $this->getURLfromLinks($this->mDomain,  $this->mURL , $vURL);     			
			$aURL[] = $vSiteLinks;        						
			$vIndex++;    			 
			
	 }while($pmData);	 
	 
	 return $aURL;   	 
   
   }   

    //this copy  all the url to DB
	function copyArraytoDB($pmArrURLs, $pmParentId=0, $pmLevel, $pmType){ 
		
		foreach($pmArrURLs as $vURL){   
			if($vURL) {  
				$this->StoreUniqueURL($this->mDomain, $vURL , $pmParentId,  $pmLevel, $pmType);  		
			 } 
		 }	
	}

	//this is the string fucntion  for manuplating the urls    
   function processTagInPageData($pmData) {  
   
   	   $aURL1 =  $this->processSpecificTagbyType($pmData,'<a',"href=");  
       $aURL2 =  $this->processSpecificTagbyType($pmData,'<frame', "src=");       
	    
	   $this->copyArraytoDB($aURL1, 1, 1, 'anc'); 
	   $this->copyArraytoDB($aURL2, 1, 1, 'frame');        
	    
   }
   
   
   function fetchURLDataandParseURL() { 

	  $vData   = $this->fetchURLPageData($this->mURL);  	
   	  $this->processTagInPageData($vData);  	  
   }		
  
}



?>