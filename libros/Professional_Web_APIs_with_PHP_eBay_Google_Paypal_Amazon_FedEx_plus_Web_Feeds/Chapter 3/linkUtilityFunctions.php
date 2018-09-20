<?php

function getPathOnly($path)
{
  if(substr($path, -1, 1) == "/")
  {
    return $path; 
  }else
  {
    $pathComponents = explode("/", $path);
    $count = count($pathComponents);
    $last = $pathComponents[$count - 1];
    if (substr_count($last, ".") > 0)
    {
       array_pop($pathComponents);
    }
    $final = implode("/", $pathComponents);
    return $final . "/";
  }
}
function relativeToAbsolute($sourceURL, $link)
{
 $sup = parse_url($sourceURL);
 if (!isset($sup['scheme']))
 {
  $sourceURL = "http://" . $sourceURL;
  $sup = parse_url($sourceURL);
 }
 $sourceURL = $sup['scheme'] . "://" . $sup['host'] . getPathOnly($sup['path']);
 $start = substr($link, 0, 1);
 if($start == '.')
 {
  if (substr($link, 0, 2) == "./")
  {
     $final = $sourceURL . substr($link, 2);
  }else if (substr($link, 0, 3) == "../")
  {
    $sup = parse_url($sourceURL);
    $pathParts = explode("/", $sup['path']);
    array_pop($pathParts); 
    while ((substr($link, 0, 3) == "../") & (count($pathParts) > 0))
    {
      $x = array_pop($pathParts);
      $link = substr($link, 3); 
    }
     $final =  $sup['scheme'] . "://" . $sup['host'] . implode("/", $pathParts) "/"        . $link;
  }else
  {
    $final = $sourceURL . $link;
  }
 }else if ($start == "/")
 {
  $final =  $sup['scheme'] . "://" . $sup['host'] . $link;
 }else if (substr_count($link, "/") == 0)
 {
  $final = $sourceURL . $link; 
 }else
 {
  $final = $link; 
 } 
 return $final; 
}


$processedFeed = preg_replace('/<img\s+.*?src="([^\"\' >]*)"\s?(width="([0-9]*)")?\s?(height="([0-9]*)")?[^>]*>/ie',
             "cleanImage('$sourceURL', '\\0','\\1','\\2','\\3','\\4', ‘\\5\)",
             $feed);
function cleanImage($sourceURL, $entireMatch, $link, $widthE, $w, $heightE, $h)
{
   $link = relativeToAbsolute($sourceURL, $link);
   return "<img src=\"$link\" height=\"$h\" width=\"$w\">";
}

function replaceImages($sourceURL, $entireMatch, $link, $widthE, $w, $heightE, $h)
{
   $link = relativeToAbsolute($sourceURL, $link);
   return "<a href=\"$link\" title=\"Inline Image\">(image)</a>";  
}

function retreiveImages($sourceURL, $entireMatch, $link, $widthE, $w, $heightE, $h)
{
  $localSavePath = "/www/domains/feedimages.preinheimer.com/";
  $localImageURL = "http://feedimages.preinheimer.com/";
  $link = relativeToAbsolute($sourceURL, $link);
  $image = file_get_contents($link);
  $filename = md5($link);
  $filepath = $localSavePath . $filename;
  file_put_contents($filepath, $image);
  $image = null; 
  @list($lwidth, $lheight, $ltype, $lattr) = getimagesize($filepath);
  if ($lwidth * $lheight == 0)
  {
   return "";
  }else
  {
  if ($w < 1)
  {
    $w = $lwidth;
  }  
  if ($h < 1)
  {
    $h = $lheight; 
  }
  //Original
  return "<img src=\"" . $localImageURL . $filename . "\" width=\"$w\" height=\"$h\" alt=\"Original Source: $link\">";
  
  /* Confirming it's an image, then deleting it
    unlink($filepath);
	  return "<img src=\"" . $link . "\" width=\"$w\" height=\"$h\">";
  */
}

$teststring = preg_replace('/<a\s+.*?href=[\"\']?([^\"\' 
  >]*)[\"\']?\s?(title=[\"\']?([^\"\'>]*)[\"\']?)?[^>]*>(.*?)<\/a>/ie',
             "cleanHREF('$sourceURL', '\\1', '\\3', '\\4')",
             $teststring);
             
function cleanHREF($sourceURL, $link, $title, $name)
{
   $link = relativeToAbsolute($sourceURL, $link);
   return "<a href=\"$link\" title=\"$title\">$name</a>";
}

function cleanAndDisplayHREF($sourceURL, $link, $title, $name)
{
   $link = relativeToAbsolute($sourceURL, $link);
   return "<a href=\"$link\" title=\"$title\">$name</a> ($link)";
}





?>