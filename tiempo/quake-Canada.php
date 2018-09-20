<?php
// PHP script by Ken True, webmaster@saratoga-weather.org
// 
// Version 1.00 - 12-Mar-2008 -- Initial Release
// Version 1.01 - 26-Apr-2008 -- fixed possible UTC-to-timezone conversion issue on some webservers
// Version 1.02 - 20-Jan-2009 -- added support for lang=fr language selection
// Version 1.03 - 28-Mar-2009 -- fix for minor EC website change
// Version 1.04 - 03-Jul-2009 -- PHP5 support for timezone set
// Version 1.05 - 23-Oct-2009 -- added missing lat/long settings from Settings.php if available
// Version 1.06 - 26-Jan-2011 -- added support for $cacheFileDir global setting
// Version 1.07 - 20-Nov-2011 -- fixes for major EC website changes
// Version 1.08 - 06-Mar-2012 -- fixes for EC website changes
// Version 1.09 - 21-May-2013 -- fixes for EC website changes
// Version 1.10 - 06-Jul-2013 -- fixes for EC website changes (thanks to George at hamiltonweatheronline.net)
// Version 1.11 - 30-Dec-2013 -- fixes for EC website changes
// Version 1.12 - 10-Mar-2016 -- fixes for EC website changes (thanks Ray at tzweather.org) 
//
  $Version = 'quake-Canada.php V1.12 - 10-Mar-2016';
//
// you may copy/modify/use this script as you see fit,
// no warranty is expressed or implied.
//
// Customized for: Quakes reported by Canada Geological Survey (
//   http://earthquakescanada.nrcan.gc.ca/recent_eq/maps/index_e.php?tpl_region=canada
//
//
// output: creates XHTML 1.0-Strict HTML page (default)
// Options on URL:
//      tablesonly=Y    -- returns only the body code for inclusion
//                         in other webpages.  Omit to return full HTML.
//      magnitude=N.N   -- screens results looking for Richter magnitudes of
//                          N.N or greater.
//      distance=MMM    -- display quakes with epicenters only within 
//                         MMM km of your location
//      lang=[en|fr]    -- language English or French
// example URL:
//  http://your.website/quake-Canada.php?tablesonly=Y&magnitude=2.1&distance=45
//  would return data without HTML header/footer for earthquakes of
//  magnitude 2.1 or larger within a 45 mile radius of your location.
//
// Usage:
//  you can use this webpage standalone (customize the HTML portion below)
//  or you can include it in an existing page:
/*
//            <?php $doIncludeQuake = true;
//                  include("quake-Canada.php");
//            ?> 
*/
//  no parms:    include("quake-Canada.php"); 
//  parms:    include("http://your.website/quake-Canada.php?tableonly=Y&magnitude=2.0&distance=50");
//
//
// settings:  
//  set $ourTZ to your time zone
//    other settings are optional
//
// cacheName is name of file used to store cached USGS webpage
// 
//
  $ourTZ = "America/Toronto";  //NOTE: this *MUST* be set correctly to
// translate UTC times to your LOCAL time for the displays.
//  http://saratoga-weather.org/timezone.txt  has the list of timezone names
//  pick the one that is closest to your location and put in $ourTZ
// also available is the list of country codes (helpful to pick your zone
//  from the timezone.txt table
//  http://saratoga-weather.org/country-codes.txt : list of country codes

 $myLat = '43.2';
 $myLong = '-79.25';

 $highRichter = "3.0"; //change color for quakes >= this magnitude
 $distanceKM = 500;   // earthquakes within 500 km
 
//  pick a format for the time to display ..uncomment one (or make your own)
  $timeFormat = 'D, Y-m-d H:i:s T';  // Fri, 2006-03-31 14:03:22 TZone
//$timeFormat = 'D, Y-M-d H:i:s T';  // Fri, 31-Mar-2006 14:03:22 TZone
//$timeFormat = 'H:i:s T D, d-M-y';  // 14:03:22 TZone Fri, 31-Mar-06
  $cacheFileDir = './';   // default cache file directory
  $cacheName = "quakesCanada.txt";  // used to store the file so we don't have to
  //                          fetch it each time
  $refetchSeconds = 1800;     // refetch every nnnn seconds
  
  $defaultLang = 'en';  // set to 'fr' for french default language
//                      // set to 'en' for english default language

// end of settings


// overrides from Settings.php if available
global $SITE;
if (isset($SITE['latitude'])) 	{$myLat = $SITE['latitude'];}
if (isset($SITE['longitude'])) 	{$myLong = $SITE['longitude'];}
if (isset($SITE['tz'])) {$ourTZ = $SITE['tz']; }
if (isset($SITE['timeFormat'])) {$timeFormat = $SITE['timeFormat'];}
if (isset($SITE['defaultlang'])) 	{$defaultLang = $SITE['defaultlang'];}
if(isset($SITE['cacheFileDir']))     {$cacheFileDir = $SITE['cacheFileDir']; }
// end of overrides from Settings.php

// ------ start of code -------
// Check parameters and force defaults/ranges
if ( ! isset($_REQUEST['tablesonly']) ) {
        $_REQUEST['tablesonly']="";
}
if (isset($doIncludeQuake) and $doIncludeQuake ) {
  $tablesOnly = "Y";
} else {
  $tablesOnly = $_REQUEST['tablesonly']; // any nonblank is ok
}

if ($tablesOnly) {$tablesOnly = "Y";}

if ( ! isset($_REQUEST['distance']) )
        $_REQUEST['distance']="$distanceKM";
$maxDistance = $_REQUEST['distance'];
if (! preg_match("/^\d+$/",$maxDistance) ) {
   $maxDistance = "$distanceKM"; // default for bad data input
}
if ($maxDistance <= "10") {$maxDistance = "10";}
if ($maxDistance >= "8000") {$maxDistance = "8000";}		
// for testing only 
if ( isset($_REQUEST['lat']) ) { $myLat = $_REQUEST['lat']; }
if ( isset($_REQUEST['lon']) ) { $myLong = $_REQUEST['lon']; }

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
if(isset($_REQUEST['lang'])) {
  $Lang = strtolower($_REQUEST['lang']);
} else {
  $Lang = '';
}
if (isset($doLang)) {$Lang = $doLang;};
if (! $Lang) {$Lang = $defaultLang;};

if ($Lang == 'fr') {
  $LMode = 'fr';
  $ECNAME = "Ressources naturelles Canada";
  $ECHEAD = 'le Canada séismes des derniers 30 jours';
  $ECMORE = 'Séismes Canada/Rapports sur les derniers séismes importants';
} else {
  $Lang = 'en';
  $LMode = 'en';
  $ECNAME = "Natural Resources Canada";
  $ECHEAD = 'Canada Earthquakes of the last 30 days';
  $ECMORE = 'Recent News/Recent Significant Earthquake Reports';
}

// support both french and english caches
//$ECURL = preg_replace('|city_.\.html|',"city_$LMode.html",$ECURL);
// Constants
// don't change $fileName or script may break ;-)
//  $fileName = "http://earthquakescanada.nrcan.gc.ca/recent_eq/maps/index_$LMode.php?tpl_region=canada";
//  $fileName = "http://seismescanada.rncan.gc.ca/recent_eq/maps/index_$LMode.php?tpl_region=canada";
//  $fileName = "http://www.earthquakescanada.nrcan.gc.ca/recent_eq/maps/index_$LMode.php?tpl_region=canada";
//  $fileName = "http://www.earthquakescanada.nrcan.gc.ca/recent/maps-cartes/index-$LMode.php?tpl_region=canada";
$fileName = "http://www.earthquakescanada.nrcan.gc.ca/recent/maps-cartes/index-$LMode.php?maptype=30d&CHIS_SZ=canada";
  
// end of constants
$cacheName = $cacheFileDir . $cacheName;
$cacheName = preg_replace('|.txt$|',"-$Lang.txt",$cacheName);


// omit HTML <HEAD>...</HEAD><BODY> if only tables wanted	
// --------------- customize HTML if you like -----------------------
if (! $tablesOnly) {
	header("Content-type: text/html; charset=iso-8859-1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $ECNAME.' - ' .$ECHEAD; ?></title>
</head>
<body style="background-color:#FFFFFF;">
<?php
}

// ------------- code starts here -------------------

// Establish timezone offset for time display
# Set timezone in PHP5/PHP4 manner
  if (!function_exists('date_default_timezone_set')) {
	putenv("TZ=" . $ourTZ);
#	$Status .= "<!-- using putenv(\"TZ=$ourTZ\") -->\n";
    } else {
	date_default_timezone_set("$ourTZ");
#	$Status .= "<!-- using date_default_timezone_set(\"$ourTZ\") -->\n";
   }
 print("<!-- $Version -->\n");
 print("<!-- server lcl time is: " . date($timeFormat) . " -->\n");
 print("<!-- server GMT time is: " . gmdate($timeFormat) . " -->\n");
 print("<!-- server timezone for this script is: " . getenv('TZ')." -->\n");
 $timediff = date("Z");
 print "<!-- TZ Delta = $timediff seconds (" . $timediff/3600 . " hours) -->\n";

 if(isset($_REQUEST['cache'])) {$refetchSeconds = 1; }
 
// refresh cached copy of page if needed
// fetch/cache code by Tom at carterlake.org

if (file_exists($cacheName) and filemtime($cacheName) + $refetchSeconds > time()) {
      echo "<!-- using Cached version of $cacheName -->\n";
      $html = implode('', file($cacheName));
    } else {
      echo "<!-- loading $cacheName from $fileName -->\n";
      $html = fetchUrlWithoutHangingQCAN($fileName);
      $fp = fopen($cacheName, "w");
      if ($fp) {
        $write = fputs($fp, $html);
        fclose($fp);
      } else {
            print "<!-- unable to write cache file $cacheName -->\n";
      }
      echo "<!-- loading finished. -->\n";
	}
	
/*

New Format: 30-Dec-2013

<table class='table-medium span-6' summary='Event list'>
<tr>
  <th id='date'>Date</th>
  <th id='time'>Time</th>
  <th id='lat'><abbr title='Latitude'>Lat</abbr></th>
  <th id='lon'><abbr title='Longitude'>Lon</abbr></th>
  <th id='depth'>Depth</th>
  <th id='mag'><abbr title='Magnitude'>Mag</abbr></th>
  <th id='felt'>Felt?</th>
  <th id='region'>Region</th>
</tr>

<tr>
  <td headers='date'>2013/12/27</td>
  <td headers='time'>07:58:56</td>
  <td headers='lat'>65.19</td>
  <td headers='lon'>-134.12</td>
  <td headers='depth'>0.0</td>
  <td headers='mag'>3.6</td>
  <td headers='felt'><span style="color:#666">No</span></td>
  <td headers='region'>250 km S   of Fort McPherson,NT</td>
</tr>
...
</tr>
</table>

<dl id="gcwu-date-mod" role="contentinfo">


*/
// Select the middle part of the page for processing
//  preg_match_all('|summary=\'listing of data\'>(.*)</table>\s+<!-- tplout|is',$html,$betweenspan);
  preg_match_all('/summary=[\'"][Event|Liste][^>]+>(.*)<\/table>\s+<dl/is',$html,$betweenspan);
  // print "<!-- betweenspan \n" . print_r($betweenspan,true) . " -->\n";
  preg_match_all('|<tr>(.*)</tr>|Uis',$betweenspan[1][0],$matches);
  // print " <!-- matches ".print_r($matches,true)." -->\n";
  $rows = $matches[1]; // just the <td>...</td> elements for a quake in each entry.
  
  print "<!-- rows count is " . count($rows) . " -->\n";
 
  $quakesFound = 0;
  $doneHeader = false;
// scan the results and process by 1s 
  foreach ($rows as $n => $row) {
	  
	  preg_match_all('|<td[^>]*>(.*)</td>|Uis',$row,$matches);
	  $quake = $matches[1];
/* 
<!-- quake Array
(
    [0] => 2013/05/20
    [1] => 06:41:03
    [2] => 49.70
    [3] => -127.35
    [4] => 22.5
    [5] => 1.6
    [6] => <span style="color:#666">No</span>
    [7] => 90 km W   of Gold R.,BC
)
	
 */	  
   if (count($quake) < 7) { continue; }

   // print "<!-- quake ".print_r($quake,true)." -->\n";
   
   $utcdate = trim($quake[0]);
   $utcdate = preg_replace('|/|','-',$utcdate);
   $utctime = trim($quake[1]);
// $utctime = preg_replace('|\s|is',':',$utctime);

   $quaketime = date($timeFormat, strtotime("$utcdate $utctime UTC"));
   
   $latitude = trim($quake[2]);  // all of Canada is North Latitude = default of '+'
   $longitude = trim($quake[3]); 
   $magnitude = trim($quake[5]);
   $location =  trim($quake[7]);
   // print "<!-- time='$quaketime' lat='$latitude' lon='$longitude' mag='$magnitude' loc='$location' -->\n";
   // provide highlighting for quakes >= $highRichter
   if ($magnitude >= $highRichter) {
	 $magnitude = "<span style=\"color: red\">$magnitude</span>";
	 $location = "<span style=\"color: red;\">$location</span>";
   }
   
   $distanceM = round(distance($myLat,$myLong,$latitude,$longitude,"M"));
   $distanceK = round(distance($myLat,$myLong,$latitude,$longitude,"K"));

   
   if ($distanceK <= $maxDistance) { // only print 'close' ones
	  $quakesFound++;    // keep a tally of quakes for summary
	  } else {
	    continue;
   }
 
   if (! $doneHeader) {  // print the header if needed
// --------------- customize HTML if you like -----------------------
	    print "
<table class=\"quake\" cellpadding=\"1\" cellspacing=\"1\" border=\"0\">
<tr><th colspan=\"4\" align=\"center\">$ECHEAD (<= $maxDistance km)</th></tr>\n";
if ($Lang == 'fr') {
	print "<tr><th>Region</th><th>Grandeur</th><th>Distance à<br/>l'épicentre</th><th>Heure locale</th></tr>\n";
} else { 
	print "<tr><th>Region</th><th>Magnitude</th><th>Distance to <br />Epicenter</th><th>Local Time</th></tr>\n";
}
	    $doneHeader = true;
	  } // end doneHeader
// --------------- customize HTML if you like -----------------------
	    print "
<tr>
  <td>$location</td>
  <td align=\"center\"><b>$magnitude</b></td>
  <td align=\"left\" nowrap=\"nowrap\"><b>$distanceK</b> km (<b>$distanceM</b> mi)</td>
  <td align=\"left\" nowrap=\"nowrap\">$quaketime</td>
</tr>\n";

  } // end foreach loop

// finish up.  Write trailer info
 
	  if ($doneHeader) {
// --------------- customize HTML if you like -----------------------
        if($Lang=='fr') {
		 print "</table><p>Au cours des derniers 30 jours $quakesFound activités séismiques furent enregistrées à l'intérieur de la zone de $maxDistance km.</p>\n";
		} else {
	     print "</table><p>In the last 30 days $quakesFound earthquakes were recorded in the $maxDistance km zone.</p>\n";
		}
	  
	  } else {
// --------------- customize HTML if you like -----------------------
        if ($Lang == 'fr') {
			print "<p>Au cours des derniers 30 jours aucune activité séismique n'a été enregistré à l'intérieur de la zone de $maxDistance km.</p>\n"; 
		} else {
	        print "<p>No Canadian Earthquakes within $maxDistance km recorded for the last 30 days.</p>\n";
		}
	  
	  }	
	  print '<p><a href="'.$fileName.'">'.$ECNAME.'</a></p>' . "\n"; 
	  print '<p><a href="http://www.earthquakescanada.nrcan.gc.ca/index-'.$LMode.'.php?CHIS_SZ=canada">';
	  print $ECMORE."</a></p>\n";
	  

// print footer of page if needed    
// --------------- customize HTML if you like -----------------------
if (! $tablesOnly ) {   
?>

</body>
</html>

<?php
}

// ----------------------------functions ----------------------------------- 
 
 function fetchUrlWithoutHangingQCAN($url) // thanks to Tom at Carterlake.org for this script fragment
   {
   // Set maximum number of seconds (can have floating-point) to wait for feed before displaying page without feed
   $numberOfSeconds=4;   

   // Suppress error reporting so Web site visitors are unaware if the feed fails
   error_reporting(0);

   // Extract resource path and domain from URL ready for fsockopen

   $url = str_replace("http://","",$url);
   $urlComponents = explode("/",$url);
   $domain = $urlComponents[0];
   $resourcePath = str_replace($domain,"",$url);

   // Establish a connection
   $socketConnection = fsockopen($domain, 80, $errno, $errstr, $numberOfSeconds);

   if (!$socketConnection)
       {
       // You may wish to remove the following debugging line on a live Web site
         print("<!-- Network error: $errstr ($errno) -->");
       }    // end if
   else    {
       $xml = '';
       fputs($socketConnection, "GET $resourcePath HTTP/1.0\r\nHost: $domain\r\n\r\n");
   
       // Loop until end of file
       while (!feof($socketConnection))
           {
           $xml .= fgets($socketConnection, 4096);
           }    // end while

       fclose ($socketConnection);

       }    // end else

   return($xml);

   }    // end function
   
// ------------ distance calculation function ---------------------
   
    //**************************************
    //     
    // Name: Calculate Distance and Radius u
    //     sing Latitude and Longitude in PHP
    // Description:This function calculates 
    //     the distance between two locations by us
    //     ing latitude and longitude from ZIP code
    //     , postal code or postcode. The result is
    //     available in miles, kilometers or nautic
    //     al miles based on great circle distance 
    //     calculation. 
    // By: ZipCodeWorld
    //
    //This code is copyrighted and has
	// limited warranties.Please see http://
    //     www.Planet-Source-Code.com/vb/scripts/Sh
    //     owCode.asp?txtCodeId=1848&lngWId=8    //for details.    //**************************************
    //     
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*:: :*/
    /*:: This routine calculates the distance between two points (given the :*/
    /*:: latitude/longitude of those points). It is being used to calculate :*/
    /*:: the distance between two ZIP Codes or Postal Codes using our:*/
    /*:: ZIPCodeWorld(TM) and PostalCodeWorld(TM) products. :*/
    /*:: :*/
    /*:: Definitions::*/
    /*::South latitudes are negative, east longitudes are positive:*/
    /*:: :*/
    /*:: Passed to function::*/
    /*::lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees) :*/
    /*::lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees) :*/
    /*::unit = the unit you desire for results:*/
    /*::where: 'M' is statute miles:*/
    /*:: 'K' is kilometers (default):*/
    /*:: 'N' is nautical miles :*/
    /*:: United States ZIP Code/ Canadian Postal Code databases with latitude & :*/
    /*:: longitude are available at http://www.zipcodeworld.com :*/
    /*:: :*/
    /*:: For enquiries, please contact sales@zipcodeworld.com:*/
    /*:: :*/
    /*:: Official Web site: http://www.zipcodeworld.com :*/
    /*:: :*/
    /*:: Hexa Software Development Center © All Rights Reserved 2004:*/
    /*:: :*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    function distance($lat1, $lon1, $lat2, $lon2, $unit) { 
    $theta = $lon1 - $lon2; 
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
    $dist = acos($dist); 
    $dist = rad2deg($dist); 
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    if ($unit == "K") {
    return ($miles * 1.609344); 
    } else if ($unit == "N") {
    return ($miles * 0.8684);
    } else {
    return $miles;
    }
  }
  
//To calculate the delta between the local time and UTC:
function tzdelta ( $iTime = 0 )
{
   if ( 0 == $iTime ) { $iTime = time(); }
   $ar = localtime ( $iTime );
   $ar[5] += 1900; $ar[4]++;
   $iTztime = gmmktime ( $ar[2], $ar[1], $ar[0],
       $ar[4], $ar[3], $ar[5], $ar[8] );
   return ( $iTztime - $iTime );
}
  
// --------------end of functions ---------------------------------------


?>
