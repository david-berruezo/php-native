<?php
function doBasicSearch($query)
{
  $call = "GetSearchResults";
  $attributes = array();
  $attributes['Version'] = 425;
  $attributes['Query'] = $query;
  $myRequest = generateBody($call, $attributes);
  $message = generateRequest($myRequest);
  $xml = calleBay($call, $message, FALSE);
  echo "<div class=\"resultHeading\">";
  echo "<span class=\"resultHeader\">Search Results for: $query</span>";
  echo "</div>";
  if ($xml->GetSearchResultsResponse->PaginationResult->TotalNumberOfEntries == 0)
  {
    echo "Sorry, there are no results to display";
  }else
  {

    foreach($xml->GetSearchResultsResponse->SearchResultItemArray->SearchResultItem 
    AS $searchResult)
    {
      $results = array();
      foreach($xml->GetSearchResultsResponse->SearchResultItemArray->
        SearchResultItem AS $searchResult)
      {
        $results[] = $searchResult->Item;
      }
      displayItems($results);
    }
  }
}
?>