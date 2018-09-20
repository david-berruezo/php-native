<?php
function displayCatagoryListings($parent = -1)
{
 $xml = getCategories($parent);
 if ($parent != -1)
 {
   echo "<div class=\"resultHeading\">";
   echo '<span class=\"resultHeader\">Search this Category: <form method="get">
     <input type="hidden" name="categoryname" value=""><input type="text"  
     name="query"><input type="submit"></span>';
   echo "</div>";
 }
 foreach($xml->GetCategoriesResponse->CategoryArray->Category AS $category)
 {


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
    echo "Sorry, there are no results to display, <a href=\"?query=$query\">Search 
      all of eBay</a>";
  }else
  {
    $results = array();
    foreach($xml->GetSearchResultsResponse->SearchResultItemArray->SearchResultItem 
      AS $searchResult)
    {
      $results[] = $searchResult->Item;
    }
    displayItems($results);
  }
}
?>