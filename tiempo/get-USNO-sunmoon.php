<?php
if (isset($_REQUEST['sce']) && strtolower($_REQUEST['sce']) == 'view' ) {
   //--self downloader --
   $filenameReal = __FILE__;
   $download_size = filesize($filenameReal);
   header('Pragma: public');
   header('Cache-Control: private');
   header('Cache-Control: no-cache, must-revalidate');
   header("Content-type: text/plain");
   header("Accept-Ranges: bytes");
   header("Content-Length: $download_size");
   header('Connection: close');
   
   readfile($filenameReal);
   exit;
}

function getUSNOsunmoon() {
/*
Function: get-USNO-sunmoon()
Purpose: fetch and cache the sun/moon data for one day from the US Naval Observatory, 
    using a GET request to http://api.usno.navy.mil/rstt/oneday?
    parse the returned JSON, and return data in the an array compatible with the V1.x
	of the script.

Calling sequence:

    $array = getUSNOsunmoon();

Returned array contents like:

    $Data['beginciviltwilight'] => 06:52
    $Data['beginciviltwilightdate'] => 01/18/2011
    $Data['sunrise'] => 07:20
    $Data['sunrisedate'] => 01/18/2011
    $Data['suntransit'] => 12:18
    $Data['suntransitdate'] => 01/18/2011
    $Data['sunset'] => 17:17
    $Data['sunsetdate'] => 01/18/2011
    $Data['endciviltwilight'] => 17:46
    $Data['endciviltwilightdate'] => 01/18/2011
    $Data['moonriseprior'] => 15:13
    $Data['moonrisepriordate'] => 01/17/2011
    $Data['moonset'] => 06:16
    $Data['moonsetdate'] => 01/18/2011
    $Data['moonrise'] => 16:21
    $Data['moonrisedate'] => 01/18/2011
    $Data['moontransit'] => 23:45
    $Data['moontransitdate'] => 01/18/2011
    $Data['moonsetnext'] => 07:02
    $Data['moonsetnextdate'] => 01/19/2011
    $Data['moonphase'] => Waxing Gibbous
    $Data['illumination'] => 98%
    $Data['hoursofpossibledaylight'] => 09:57
	
	Note: the moonriseprior and moonrisenext may not always appear in the data from the USNO
	

Author: Ken True - webmaster@saratoga-weather.org
*/
//  Version 1.00 - 18-Jan-2011 - initial release
//  Version 1.01 - 23-Mar-2011 - added code for missing moonrise/moonset due to prior/next day times
//  Version 1.02 - 03-Dec-2011 - fixed moonset date if for following day
//  Version 2.00 - 29-Jul-2015 - changes to use new JSON API call for aa.usno.navy.mil
//  Version 2.01 - 29-Jul-2015 - added conditionals for moon-prior/moon-next vars (may not be in JSON)
//  Version 2.02 - 31-Jul-2015 - fixed issue with missing JSON fracillum/curphase data
//  Version 2.03 - 01-Aug-2015 - added illum. value for missing JSON fracillum data
//  Version 2.04 - 11-Nov-2015 - use specific local date request instead of relying on date=today
$Version = 'get-USNO-sunmoon.php - Version 2.04 - 11-Nov-2015';
// -----------local settings-------------------
$ourTZ = "America/Los_Angeles";     //NOTE: this *MUST* be set correctly to
// translate UTC times to your LOCAL time for the displays.
//  set to station latitude/longitude (decimal degrees)
$myLat  = 37.27153397;             //North=positive, South=negative decimal degrees
$myLong = -122.02274323;           //East=positive, West=negative decimal degrees
// The above settings are for saratoga-weather.org location
$myCity = 'Saratoga';              // my city name
$useMDY = true;                    // true=use mm/dd/yyyy for dates, false=use dd/mm/yyyy for dates
$cacheFileDir = './';              // default cache file directory
$cacheName = "USNO-moondata.txt";  // used to store the file so we don't have to fetch from USNO website
$refetchSeconds = 3600;            // refetch every nnnn seconds 3600=1 hour
// -----------end local settings --------------

// overrides from Settings.php if available
global $SITE;
if (isset($SITE['latitude'])) 	{$myLat = $SITE['latitude'];}
if (isset($SITE['longitude'])) 	{$myLong = $SITE['longitude'];}
if (isset($SITE['tz'])) {$ourTZ = $SITE['tz']; }
if (isset($SITE['location'])) {$myCity = $SITE['location'];}
if (isset($SITE['WDdateMDY']))  {$useMDY = $SITE['WDdateMDY'];}
if(isset($SITE['cacheFileDir']))     {$cacheFileDir = $SITE['cacheFileDir']; }
// end of overrides from Settings.php

global $Debug, $doDebug;
$Debug = "<!-- $Version -->\n";
$Data = array();

# Set timezone in PHP5/PHP4 manner
  if (!function_exists('date_default_timezone_set')) {
	putenv("TZ=" . $ourTZ);
#	$Debug .= "<!-- using putenv(\"TZ=$ourTZ\") -->\n";
    } else {
	date_default_timezone_set("$ourTZ");
#	$Debug .= "<!-- using date_default_timezone_set(\"$ourTZ\") -->\n";
   }
   
if(isset($_REQUEST['force']) or isset($_REQUEST['cache']) ) {
	$refetchSeconds = 1;
}

if (file_exists($cacheName) and date("Ymd",filemtime($cacheName)) !== date("Ymd")) {
	$Debug .= "<!-- local date changed v.s. cache date .. reloading from USNO -->\n";
	$refetchSeconds = 1;
}
$Debug .= "<!-- refetch seconds=$refetchSeconds -->\n";

$doDebug = false;
if(isset($_REQUEST['debug'])) {$doDebug = true;}

$myTZOffset = date('Z')/3600; // difference of our time from UTC in hours
$lclToday = date("m/d/Y");
$USNOUrl = "http://api.usno.navy.mil/rstt/oneday?date=$lclToday&coords=$myLat,$myLong&tz=$myTZOffset";

$cacheName = $cacheFileDir.$cacheName;

// either load the cached html page or fetch and cache a new html page
if (file_exists($cacheName) and filemtime($cacheName) + $refetchSeconds > time()) {
      $Debug .= "<!-- using Cached version of $cacheName -->\n";
      $html = implode('', file($cacheName));
    } else {
      $Debug .= "<!-- loading $cacheName from $USNOUrl -->\n";
      $html = get_sunmoon_fetchUrlWithoutHanging($USNOUrl);
      $fp = fopen($cacheName, "w");
      if ($fp) {
        $write = fputs($fp, $html);
        fclose($fp);
      } else {
            $Debug .= "<!-- unable to write cache file $cacheName -->\n";
      }
      $Debug .= "<!-- loading finished. -->\n";
	}

  $i = strpos($html,"\r\n\r\n");
  $headers = substr($html,0,$i-1);
  $content = substr($html,$i+4);
  if(preg_match('|Transfer-Encoding: chunke|Ui',$headers)) {
	  $Debug .= "<!-- unchunking response -->\n"; 
	  $Debug .= "<!-- in=".strlen($html);
      $content = trim(get_sunmoon_unchunk_content($content));
	  $Debug .= " out=".strlen($html). " bytes -->\n";
	}
  $Debug .= "<!-- processing JSON entries for Moon data -->\n";

  $rawJSON = $content; // kludge.. our unchunking removed this
  if($doDebug) {
	  $Debug .= "<!-- rawJSON size is ".strlen($rawJSON). " bytes -->\n";
  	  $Debug .= "<!-- rawJSON is '".$rawJSON."' -->\n";
  }

//  $rawJSON = WU_prepareJSON($rawJSON);
  $MoonJSON = json_decode($rawJSON,true); // get as associative array
  $Debug .= get_sunmoon_decode_JSON_error();
  if($doDebug) {$Debug .= "<!-- JSON\n".print_r($MoonJSON,true)." -->\n";}

/*
USNO returns info like:

{
      "error":false,
      "apiversion":"1.0",
      "year":2015,
      "month":7,
      "day":28,"datechanged":false,
      "lon":-122.02,
      "lat":37.67,
      "tz":-7,
      
   "sundata":[
   
            {"phen":"BC", "time":"05:39"},
            {"phen":"R", "time":"06:08"},
            {"phen":"U", "time":"13:15"},
            {"phen":"S", "time":"20:20"},
            {"phen":"EC", "time":"20:50"}
            ],
            "moondata":[
            
            {"phen":"S", "time":"03:25"},
            {"phen":"R", "time":"17:57"},
            {"phen":"U", "time":"23:09"} ]
               , "nextmoondata":[{"phen":"S","time":"04:22"}]
      , "closestphase":{
         "phase":"Full Moon",
         "date":"July 31, 2015",
         "time":"03:43"
      }
            , "fracillum":"91%"
               , "curphase":"Waxing Gibbous" }
			  
Which we decode as:

<!-- JSON
Array
(
    [error] => 
    [apiversion] => 1.0
    [year] => 2015
    [month] => 7
    [day] => 28
    [datechanged] => 
    [lon] => 0
    [lat] => 0
    [tz] => 0
    [sundata] => Array
        (
            [0] => Array
                (
                    [phen] => BC
                    [time] => 05:41
                )

            [1] => Array
                (
                    [phen] => R
                    [time] => 06:03
                )

            [2] => Array
                (
                    [phen] => U
                    [time] => 12:07
                )

            [3] => Array
                (
                    [phen] => S
                    [time] => 18:10
                )

            [4] => Array
                (
                    [phen] => EC
                    [time] => 18:32
                )

        )

    [moondata] => Array
        (
            [0] => Array
                (
                    [phen] => S
                    [time] => 03:00
                )

            [1] => Array
                (
                    [phen] => R
                    [time] => 15:29
                )

            [2] => Array
                (
                    [phen] => U
                    [time] => 21:42
                )

        )

    [nextmoondata] => Array
        (
            [0] => Array
                (
                    [phen] => S
                    [time] => 03:55
                )

        )

    [closestphase] => Array
        (
            [phase] => Full Moon
            [date] => July 31, 2015
            [time] => 10:43
        )

    [fracillum] => 89%
    [curphase] => Waxing Gibbous
)
 -->

*/

// now slice the page for the main times for the sun and moon
$phen_name = array(
    'BC' => 'Begin civil twilight',
    'R' => 'Rise',
    'U' => 'Upper Transit',
    'S' => 'Set',
    'EC' => 'End civil twilight',
    'L' => 'Lower Transit (above the horizon)',
    '**' => 'object continuously above the horizon',
    '--' => 'object continuously below the horizon',
    '^^' => 'object continuously above the twilight limit',
    '~~' => 'object continuously below the twilight limit',
);
$phen_lookup = array(
    'BC' => 'beginciviltwilight',
    'R' => 'rise',
    'U' => 'transit',
    'S' => 'set',
    'EC' => 'endciviltwilight',
    'L' => 'Lower Transit (above the horizon)',
    '**' => 'object continuously above the horizon',
    '--' => 'object continuously below the horizon',
    '^^' => 'object continuously above the twilight limit',
    '~~' => 'object continuously below the twilight limit',
);
/*  Targeted output is:
USNOdata returns
Array
(
    [beginciviltwilight] => 05:40
    [beginciviltwilightdate] => 07/28/2015
    [sunrise] => 06:09
    [sunrisedate] => 07/28/2015
    [suntransit] => 13:15
    [suntransitdate] => 07/28/2015
    [sunset] => 20:19
    [sunsetdate] => 07/28/2015
    [endciviltwilight] => 20:48
    [endciviltwilightdate] => 07/28/2015
    [moonriseprior] => 17:00
    [moonrisepriordate] => 07/27/2015
    [moonset] => 03:26
    [moonsetdate] => 07/28/2015
    [moonrise] => 17:56
    [moonrisedate] => 07/28/2015
    [moontransit] => 23:09
    [moontransitdate] => 07/28/2015
    [moonsetnext] => 04:23
    [moonsetnextdate] => 07/29/2015
    [moonphase] => Waxing Gibbous
    [illumination] => 91%
    [hoursofpossibledaylight] => 14:10
)

*/


$Data = array();

$useDateFormat = $useMDY?"m/d/Y":"d/m/Y";
$dateprior = date($useDateFormat,strtotime("-1 day"));
$datenow   = date($useDateFormat);
$datenext  = date($useDateFormat,strtotime("+1 day"));

$mtype = 'sun';
foreach ($MoonJSON['sundata'] as $n => $d) {
	$mt = $mtype . $phen_lookup[$d['phen']];
	if(preg_match('|civil|i',$mt)) {
		$mt = $phen_lookup[$d['phen']]; // no 'sun' in civil entries
	}
	$Data[$mt] = $d['time'];
	$Data[$mt.'date'] = $datenow;
}
$mtype = 'moon';
foreach ($MoonJSON['moondata'] as $n => $d) {
	$mt = $mtype . $phen_lookup[$d['phen']];
	$Data[$mt] = $d['time'];
	$Data[$mt.'date'] = $datenow;
}

$mtype = 'moon';
if(isset($MoonJSON['nextmoondata']) ) {
  foreach ($MoonJSON['nextmoondata'] as $n => $d) {
	$mt = $mtype . $phen_lookup[$d['phen']] . 'next';
	$Data[$mt] = $d['time'];
	$Data[$mt.'date'] = $datenext;
  }
}

$mtype = 'moon';
if(isset($MoonJSON['prevmoondata']) ) {
  foreach ($MoonJSON['prevmoondata'] as $n => $d) {
	$mt = $mtype . $phen_lookup[$d['phen']] . 'prior';
	$Data[$mt] = $d['time'];
	$Data[$mt.'date'] = $dateprior;
  }
}

									

if(isset($MoonJSON['curphase']))  { $Data['moonphase'] = $MoonJSON['curphase']; }

if(!isset($Data['moonphase']) and isset($MoonJSON['closestphase']['phase']) ) {
	$Data['moonphase'] = $MoonJSON['closestphase']['phase'];
	$Debug .= "<!-- note: 'curphase' not in JSON.  Used 'closestphase' instead. -->\n";
}

if(isset($MoonJSON['fracillum'])) {	
  $Data['illumination'] = $MoonJSON['fracillum']; 
} elseif (isset($Data['moonphase'])) {
	if(preg_match('|full|i',$Data['moonphase'])) {$Data['illumination'] = '100%'; }
	if(preg_match('|quarter|i',$Data['moonphase'])) {$Data['illumination'] = '50%'; }
	if(preg_match('|new|i',$Data['moonphase'])) {$Data['illumination'] = '0%'; }
	if(isset($Data['illumination']) ) {
		$Debug .= "<!-- note: 'fracillum' not in JSON, 'illumination' set to '" .
		$Data['illumination'] . "' based on moon phase of '" . $Data['moonphase'] . "'. -->\n";
	}
} else {
  $Debug .= "<!-- note: 'fracillum' not in JSON, no 'illumination' is available. -->\n";
}

if(isset($Data['sunrise']) and isset($Data['sunset'])) {
	$diff =	strtotime($Data['sunset'])-strtotime($Data['sunrise']);
	$diffh = intval($diff/3600); // hours
	$diffm = intval(($diff / 60) % 60);
	$Data['hoursofpossibledaylight'] = sprintf("%02d:%02d",$diffh,$diffm);
}


if( !isset($Data['moonrise']) and isset($Data['moonriseprior']) ) {
	$Debug .= "<!-- moonrise missing.. using moonriseprior -->\n";
	$Data['moonrise'] = $Data['moonriseprior'];
	$Data['moonrisedate'] = $Data['moonrisepriordate'];
}

if( !isset($Data['moonset']) and isset($Data['moonsetnext']) ) {
	$Debug .= "<!-- moonset missing.. using moonsetnext -->\n";
	$Data['moonset'] = $Data['moonsetnext'];
	$Data['moonsetdate'] = $Data['moonsetnextdate'];
}

$Debug .= "<!-- USNOdata\n".print_r($Data,true) . " -->\n";

print $Debug;

return($Data);
} // end of getUSNOsunmoon function

# --------- end of mainline function --------------


// get contents from one URL and return as string 
 function get_sunmoon_fetchUrlWithoutHanging($url,$useFopen=false) {
// thanks to Tom at Carterlake.org for this script fragment
  global $Debug, $doDebug, $needCookie,$timeStamp,$TOTALtime,$Version;
  $overall_start = time();
  if (! $useFopen) {
   // Set maximum number of seconds (can have floating-point) to wait for feed before displaying page without feed
   $numberOfSeconds=5;   

   // Suppress error reporting so Web site visitors are unaware if the feed fails
   error_reporting(0);

   // Extract resource path and domain from URL ready for fsockopen
   $FullUrl = $url;
   $urlParts = parse_url($url);
   
   $domain = $urlParts['host'];
   if(isset($urlParts['port'])) {
      $port   = $urlParts['port'];
   } else { 
      $port   = 80;
   }
   $resourcePath = $urlParts['path'];
   $resourcePath = preg_replace('|nocache|','?'.$timeStamp,$resourcePath);
   if(isset($urlParts['query']))    {$resourcePath .= "?" . $urlParts['query']; }
   if(isset($urlParts['fragment'])) {$resourcePath .= "#" . $urlParts['fragment']; }
   $T_start = get_sunmoon_microtime_float();
   $hostIP = gethostbyname($domain);
   $T_dns = get_sunmoon_microtime_float();
   $ms_dns  = sprintf("%01.3f",round($T_dns - $T_start,3));
   
   $Debug .= "<!-- GET $resourcePath HTTP/1.1 \n      Host: $domain  Port: $port IP=$hostIP-->\n";
//   print "GET $resourcePath HTTP/1.1 \n      Host: $domain  Port: $port IP=$hostIP\n";

   // Establish a connection
   $socketConnection = fsockopen($hostIP, $port, $errno, $errstr, $numberOfSeconds);
   $T_connect = get_sunmoon_microtime_float();
   $T_puts = 0;
   $T_gets = 0;
   $T_close = 0;
   
   if (!$socketConnection)
       {
       // You may wish to remove the following debugging line on a live Web site
       $Debug .= "<!-- Network error: $errstr ($errno) -->\n";
//       print "Network error: $errstr ($errno)\n";
       }    // end if
   else    {
       $xml = '';
	   $getString = "GET $resourcePath HTTP/1.1\r\nHost: $domain\r\nConnection: Close\r\n";
	   if (isset($needCookie[$domain])) {
	     $getString .= $needCookie[$domain] . "\r\n";
		 $Debug .=  "<!-- cookie used '" . $needCookie[$domain] . "' for GET to $domain -->\n";
	   }
	   $getString .= "User-agent: Mozilla/5.0 (get-USNO-sunmoon.php; saratoga-weather.org)\r\nAccept: text/plain,text/html\r\nAccept-Encoding: gzip;q=0,compress;q=0\r\n";
	   $getString .= "\r\n";
	   if($doDebug) {$Debug .= "<!-- Request:\n$getString\n -->\n";}
       fputs($socketConnection, $getString);
       $T_puts = get_sunmoon_microtime_float();
	   
       // Loop until end of file
	   $TGETstats = array();
	   $TGETcount = 0;
       while (!feof($socketConnection))
           {
		   $T_getstart = get_sunmoon_microtime_float();
           $xml .= fgets($socketConnection, 16384);
		   $T_getend = get_sunmoon_microtime_float();
		   $TGETcount++;
		   $TGETstats[$TGETcount] = sprintf("%01.3f",round($T_getend - $T_getstart,3));
           }    // end while
       $T_gets = get_sunmoon_microtime_float();
       fclose ($socketConnection);
       $T_close = get_sunmoon_microtime_float();
       }    // end else
   $ms_connect = sprintf("%01.3f",round($T_connect - $T_dns,3));

   if($T_close > 0) {
      $ms_puts = sprintf("%01.3f",round($T_puts - $T_connect,3));
	  $ms_gets = sprintf("%01.3f",round($T_gets - $T_puts,3));
	  $ms_close = sprintf("%01.3f",round($T_close - $T_gets,3));
	  $ms_total = sprintf("%01.3f",round($T_close - $T_start,3)); 
    } else {
       $ms_puts = 'n/a';
	  $ms_gets = 'n/a';
	  $ms_close = 'n/a';
	  $ms_total = sprintf("%01.3f",round($T_connect - $T_start,3)); 
   }

   $Debug .= "<!-- HTTP stats:  dns=$ms_dns conn=$ms_connect put=$ms_puts get($TGETcount blocks)=$ms_gets close=$ms_close total=$ms_total secs -->\n";
//   print  "HTTP stats: dns=$ms_dns conn=$ms_connect put=$ms_puts get($TGETcount blocks)=$ms_gets close=$ms_close total=$ms_total secs \n";
//   foreach ($TGETstats as $block => $mstimes) {
//     print "HTTP Block $block took $mstimes\n";
//   }
   $TOTALtime+= ($T_close - $T_start);
   $overall_end = time();
   $overall_elapsed =   $overall_end - $overall_start;
   $Debug .= "<!-- fetch function elapsed= $overall_elapsed secs. -->\n"; 
//   print "fetch function elapsed= $overall_elapsed secs.\n"; 
   return($xml);
 } else {
//   print "<!-- using file function -->\n";
   $T_start = get_sunmoon_microtime_float();

   $xml = implode('',file($url));
   $T_close = get_sunmoon_microtime_float();
   $ms_total = sprintf("%01.3f",round($T_close - $T_start,3)); 
   $Debug .= "<!-- file() stats: total=$ms_total secs -->\n";
//   print " file() stats: total=$ms_total secs.\n";
   $TOTALtime+= ($T_close - $T_start);
   $overall_end = time();
   $overall_elapsed =   $overall_end - $overall_start;
   $Debug .= "<!-- fetch function elapsed= $overall_elapsed secs. -->\n"; 
//   print "fetch function elapsed= $overall_elapsed secs.\n"; 
   return($xml);
 }

   }    // end get_sunmoon_fetchUrlWithoutHanging
// ------------------------------------------------------------------

function get_sunmoon_microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
// ------------------------------------------------------------------

function get_sunmoon_unchunk_content($data) {
    $fp = 0;
    $outData = "";
    while ($fp < strlen($data)) {
        $rawnum = substr($data, $fp, strpos(substr($data, $fp), "\r\n") + 2);
        $num = hexdec(trim($rawnum));
        $fp += strlen($rawnum);
        $chunk = substr($data, $fp, $num);
        $outData .= $chunk;
        $fp += strlen($chunk);
    }
    return $outData;
}
// ------------------------------------------------------------------
function get_sunmoon_decode_JSON_error() {
	
  $Status = '';
  $Status .= "<!-- json_decode returns ";
  switch (json_last_error()) {
	case JSON_ERROR_NONE:
		$Status .= ' - No errors';
	break;
	case JSON_ERROR_DEPTH:
		$Status .= ' - Maximum stack depth exceeded';
	break;
	case JSON_ERROR_STATE_MISMATCH:
		$Status .= ' - Underflow or the modes mismatch';
	break;
	case JSON_ERROR_CTRL_CHAR:
		$Status .= ' - Unexpected control character found';
	break;
	case JSON_ERROR_SYNTAX:
		$Status .= ' - Syntax error, malformed JSON';
	break;
	case JSON_ERROR_UTF8:
		$Status .= ' - Malformed UTF-8 characters, possibly incorrectly encoded';
	break;
	default:
		$Status .= ' - Unknown error, json_last_error() returns \''.json_last_error(). "'";
	break;
   } 
   $Status .= " -->\n";
   return($Status);
}


?>