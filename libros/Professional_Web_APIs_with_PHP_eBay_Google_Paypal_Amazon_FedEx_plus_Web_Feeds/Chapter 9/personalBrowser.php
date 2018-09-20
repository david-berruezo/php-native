<html>
<head>
<title>Personal eBay Navigator</title>
<style tyle="text/css">
div.topbar
{
  width: 100%;
  font-family: verdana;
  border: thin solid black;
  align: left;
}
span.mainTitle
{
  font-weight: bold;
  font-size: 150%;
  align: right;
}

div.resultHeading
{
  width: 100%;
  font-family: verdana;
  border: thin solid black;
  align: left;
}

.catTitle
{
  font-weight: bold;
  text-decoration: none;
  display: block;
}

a.viewItems
{
  font-style: italic;
  text-decoration: none;
}
div.itemListingEven
{
  border: thin solid black;
  margin: 2px;
  padding: 3px;
}
div.itemListingOdd
{
  border: thin solid black;
  margin: 2px;
  padding: 3px;
  background-color: EEEEFF;
}
</style>
</head>
<body>
<div class="topbar">
  <span class="mainTitle" display="block">Personal eBay Browser</span>  <span class="searchBox"><form method="get">Perform a Search: <input type="text" name="query"><input type="submit"></form></span>
</div>
<?php
error_reporting(E_ALL);
require('eBayCaller.php');

echo '';
if (isset($_GET['loadCat']))
{
  displayCatagoryListings($_GET['loadCat']);
}elseif(isset($_GET['listCategory']) && ctype_digit($_GET['listCategory']))
{
  getCategoryListings($_GET['listCategory']);
}elseif(isset($_GET['searchcategory']))
{
  doCategorySearch($_GET['query'], $_GET['searchcategory']);
}elseif (isset($_GET['query']))
{
	doBasicSearch($_GET['query']);
}else
{
	displayCatagoryListings();
	exit;
}
	
function getSimpleTime()
{
  global $version, $devID, $appID, $cert, $token;
  $call = "GeteBayOfficialTime";
  $message = <<< XMLBLOCK
<?xml version="1.0" encoding="utf-8"?> 
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema"  
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
  <soapenv:Header> 
    <RequesterCredentials soapenv:mustUnderstand="0" xmlns="urn:ebay:apis:eBLBaseComponents"> 
       <eBayAuthToken>$token</eBayAuthToken> 
       <ns:Credentials xmlns:ns="urn:ebay:apis:eBLBaseComponents"> 
        <ns:DevId>$devID</ns:DevId> 
        <ns:AppId>$appID</ns:AppId> 
        <ns:AuthCert>$cert</ns:AuthCert> 
       </ns:Credentials> 
    </RequesterCredentials> 
  </soapenv:Header> 
  <soapenv:Body> 
  <GeteBayOfficialTimeRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
  <ns1:Version xmlns:ns1="urn:ebay:apis:eBLBaseComponents">$version</ns1:Version> 
  </GeteBayOfficialTimeRequest> 
  </soapenv:Body> 
</soapenv:Envelope>
XMLBLOCK;
  $RAWxml = calleBay($call, $message, TRUE);
  echo $RAWxml;
  $xml = simplexml_load_string($RAWxml);
  echo "<pre>";
  print_r($xml);
  
  echo "Time: " . $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children('urn:ebay:apis:eBLBaseComponents')->GeteBayOfficialTimeResponse->Timestamp . "\n";
  $nestedXML = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children('urn:ebay:apis:eBLBaseComponents');
  print_r($nestedXML);
  echo "</pre>";
}

function getTime()
{
  $call = "GeteBayOfficialTime"; 
  $body = 
  '<soapenv:Body> 
  <GeteBayOfficialTimeRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
  <ns1:Version xmlns:ns1="urn:ebay:apis:eBLBaseComponents">425</ns1:Version> 
  </GeteBayOfficialTimeRequest> 
  </soapenv:Body>';
  $message = generateRequest($body);
  echo $message;
  $xml =  calleBay($call, $message, TRUE);
  $xml = simplexml_load_string($xml);
  echo "Time: " . $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children('urn:ebay:apis:eBLBaseComponents')->GeteBayOfficialTimeResponse->Timestamp . "\n";
} 


function newGetTime()
{
	$call = "GeteBayOfficialTime";
	$queryInfo = array();
	$queryInfo["Version"] = 425;
	$myRequest = generateBody($call, $queryInfo);
	$message = generateRequest($myRequest);
	$xml =  calleBay($call, $message, FALSE);
	echo "In eBay World the time is: " . $xml->GeteBayOfficialTimeResponse->Timestamp . "\n";
}

function doBasicSearch($query)
{
  $call = "GetSearchResults";
  $attributes = array();
  $attributes['Version'] = 425;
  $attributes['Query'] = $query;
  $myRequest = generateBody($call, $attributes);
  $message = generateRequest($myRequest);
  $xml =  calleBay($call, $message, FALSE);
  echo "<div class=\"resultHeading\">";
  echo "<span class=\"resultHeader\">Search Results for: $query</span>";
  echo "</div>";
  if ($xml->GetSearchResultsResponse->PaginationResult->TotalNumberOfEntries == 0)
  {
    echo "Sorry, there are no results to display";
  }else
  {
    $results = array();
    foreach($xml->GetSearchResultsResponse->SearchResultItemArray->SearchResultItem AS $searchResult)
    {
      $results[] = $searchResult->Item;
    }
    displayItems($results);
  }
}

function doCategorySearch($query, $category)
{
  $call = "GetSearchResults";
  $attributes = array();
  $attributes['Version'] = 425;
  $attributes['Query'] = $query;
  $attributes['CategoryID'] = $category;
  $myRequest = generateBody($call, $attributes);
  $message = generateRequest($myRequest);
  $xml =  calleBay($call, $message, FALSE);
  echo "<div class=\"resultHeading\">";
  echo "<span class=\"resultHeader\">Search Results for: $query</span>";
  echo "</div>";
  if ($xml->GetSearchResultsResponse->PaginationResult->TotalNumberOfEntries == 0)
  {
    echo "Sorry, there are no results to display, <a href=\"?query=$query\">Search all of eBay</a>";
  }else
  {
    $results = array();
    foreach($xml->GetSearchResultsResponse->SearchResultItemArray->SearchResultItem AS $searchResult)
    {
      $results[] = $searchResult->Item;
    }
    displayItems($results);
  }
}

function getCategories($parent = -1)
{
  $call = "GetCategories";
  $attributes = array();
  $attributes['Version'] = 425;
  $attributes['CategorySiteID'] = 0;
  
  if ($parent != -1)
  {
    $attributes['CategoryParent'] = $parent;
  }else 
  {
    $attributes['LevelLimit'] = 1;  
  }
    
  $myRequest = generateBody($call, $attributes);
  $message = generateRequest($myRequest);
  $breifXML = simplexml_load_string(calleBay($call, $message, TRUE));
  //print_r($breifXML);
  $lastUpdated = $parent . "." . $breifXML->children('http://schemas.xmlsoap.org/soap/envelope/')->children('urn:ebay:apis:eBLBaseComponents')->GetCategoriesResponse->UpdateTime . ".xml";
  
  if (file_exists("/tmp/$lastUpdated"))
  { 
    echo "<!-- CACHE --!>\n";
    $xml = simplexml_load_file("/tmp/$lastUpdated");
  }else
  {
    echo "<!-- NEW --!>\n";
    $attributes['DetailLevel'] = 'ReturnAll';
    $myRequest = generateBody($call, $attributes);
    $message = generateRequest($myRequest);
    $xml = calleBay($call, $message, TRUE); 
    file_put_contents("/tmp/$lastUpdated", $xml);
    $xml = simplexml_load_string($xml);
  }
  
  $xml = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children('urn:ebay:apis:eBLBaseComponents');
  return $xml;
}

function displayCatagoryListings($parent = -1)
{
 $xml = getCategories($parent);
 if ($parent  != -1)
 {
   echo "<div class=\"resultHeading\">";
   echo '<span class=\"resultHeader\">Search this Category: <form method="get"><input type="hidden" name="searchcategory" value="'. $parent . '"><input type="hidden" name="categoryname" value=""><input type="text" name="query"><input type="submit"></span>';
   echo "</div>";
 }
 foreach($xml->GetCategoriesResponse->CategoryArray->Category AS $category)
 {
   if ($category->CategoryID == $parent)
   {
     if ($category->CategoryLevel == 1)
     {
      echo "<h3>{$category->CategoryName}</h3>";
      echo "(<a href=\"?\">Return to parent</a>)<br>\n\n";
     }else 
     {
       echo "<h3>{$category->CategoryName}</h3>";
       echo "(<a href=\"?loadCat={$category->CategoryParentID}\">Return to parent</a>)\n";
     }
   }else
   {
     if ($category->CategoryParentID == $parent || $parent == -1)
     {
       if ($category->LeafCategory == "true")
       {
         echo "<span class=\"catTitle\">{$category->CategoryName}</span> (<a href=\"?listCategory={$category->CategoryID}\" class=\"viewItems\">view items</a>)<br>\n";
       }else 
       {
         echo "<a href=\"?loadCat={$category->CategoryID}\" class=\"catTitle\">{$category->CategoryName}</a> (<a href=\"?listCategory={$category->CategoryID}\" class=\"viewItems\">view items</a>) \n"; 
       }
     }
   }
 } 
}

function getCategoryListings($category)
{
  $call = "GetCategoryListings";
  $attributes = array();
  $attributes['Version'] = 425;
  $attributes['CategoryID'] = $category;
  $myRequest = generateBody($call, $attributes);
  $message = generateRequest($myRequest);
  $xml = calleBay($call, $message, FALSE); 
  echo "<h3>Listings in {$xml->GetCategoryListingsResponse->Category->CategoryName}</h3>\n";
  $parentID = getCatagoryID($xml->GetCategoryListingsResponse->Category->CategoryID);
  echo "Return to <a href=\"?loadCat={$parentID}\">Categories</a> Listing<br>\n";  
  if (isset($xml->GetCategoryListingsResponse->ItemArray->Item))
  {
    displayItems($xml->GetCategoryListingsResponse->ItemArray->Item);
  }else 
  {
    echo "No listings, Sorry\n"; 
  }
  if (isset($xml->GetCategoryListingsResponse->SubCategories->Category))
  {
    echo "<h3>Sub-Categories</h3>";
    foreach($xml->GetCategoryListingsResponse->SubCategories->Category AS $category)
    {
       echo "<a href=\"?listCategory={$category->CategoryID}\">{$category->CategoryName}</a> has {$category->NumOfItems} items listed<br>\n";
    }
  }
}

function displayItems($itemObject)
{
  $flipper = TRUE;
  foreach ($itemObject as $item)
  {
    $flipper = ($flipper xor 1);
    if ($flipper)
    {
      echo '<div class="itemListingEven">';  
    }else 
    {
      echo '<div class="itemListingOdd">';
    }
    echo "<a href=\"?{$item->ItemID}\">{$item->Title}</a><br>\n";
    echo "Current Bid $ {$item->SellingStatus->CurrentPrice}, {$item->SellingStatus->BidCount} bids in total<br>\n";
    echo '</div>';
  }
}

function getCatagoryID($categoryIDString)
{
  $catArray = explode(":", $categoryIDString);
  if (count($catArray) > 1)
  {
    return trim($catArray[(count($catArray) - 2)]);
  }else
  {
    return trim($catArray[0]);
  } 
}
?>
</pre>
</body>
</html>