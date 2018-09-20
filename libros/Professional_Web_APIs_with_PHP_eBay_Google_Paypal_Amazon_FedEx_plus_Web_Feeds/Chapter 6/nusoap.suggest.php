<?php

function getSuggested($query)
{
  $suggestions = array();
  $query = explode(" ", $query);
  $linkID = db_connect();
  foreach($query AS $word)
  {
    $word = mysql_real_escape_string($word, $linkID);
    $query = "SELECT * FROM 06_google_suggest WHERE `word` = '$word'";
    $suggest  = getAssoc($query, 2);
    if (count($suggest) > 0)
    {
      foreach ($suggest as $suggestion)
      {
        $suggestions[] = $suggestion;
        echo "Added a suggestion";
      }   
    }
  }
  return $suggestions;
}

?>