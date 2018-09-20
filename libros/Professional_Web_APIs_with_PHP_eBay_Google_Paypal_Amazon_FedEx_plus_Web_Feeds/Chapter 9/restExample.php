<?php
  header("Content-Type: application/xml");
  $endPoint = "http://rest.api.sandbox.ebay.com/restapi";
  $requestToken   = "oVAr7OhSbdw%3D**%2Bs1d4ta8quAac9G3rvTuhs8IPvg%3D";
  $requestUserId  = "wroxuser";
  $searchTerms = "boat";   
  $fullEndPoint = $endPoint . "?RequestToken={$requestToken}&RequestUserId={$requestUserId}&Query={$searchTerms}&CallName=GetSearchResults";
  $results =  file_get_contents($fullEndPoint);
  echo $results;
?>