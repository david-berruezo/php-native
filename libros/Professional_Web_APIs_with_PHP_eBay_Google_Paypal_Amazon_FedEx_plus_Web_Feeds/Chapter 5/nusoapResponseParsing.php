<?php
echo "You searched for: " . 
  $xml['Body']['LibrarySearchResponse']['RequestInfo']['keyword'] . "<br>";
echo "Here are your 
  {$xml['Body']['LibrarySearchResponse']['ResponseInfo']['ResultCount']} 
  results<br>";
foreach($xml['Body']['LibrarySearchResponse']['ResponseInfo']['Item'] AS &$item)
{
  echo "{$item['Title']} by {$item['Author']}<br>";
}
?>