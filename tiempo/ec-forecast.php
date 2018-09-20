<?php
// PHP script by Ken True, webmaster@saratoga-weather.org
// ec-forecast.php  version 1.00 - 10-Aug-2006
// Version 1.01 - 14-Dec-2006 - fixed script to handle changes in EC website
// Version 1.02 - 14-Dec-2006 - fixed problems with include mode/no printing.
// Version 1.03 - 14-Mar-2007 - fixed to handle changes to EC website
// Version 1.04 - 16-May-2007 - fixed to handle changes to EC website
// Version 1.05 - 15-Jun-2007 - handle printable/regular EC URL + table, debugging improvements
// Version 1.06 - 27-Jun-2007 - added parsing/printing for alerts/watches/warnings $alertstring
// Version 1.07 - 06-Aug-2007 - corrected php delim at top of file (missing php)
// Version 1.08 - 14-Dec-2007 - added optional current conditions report table $currentConditions
// Version 2.00 - 24-Jan-2008 - major rewrite to handle many changes to EC forecast website + new icons
// Version 2.01 - 26-Jan-2008 - added 'Air Quality Health Index' to optional conditions display
// Version 2.02 - 26-Feb-2008 - added support for Carterlake/WD/PHP template settings.
// Version 2.03 - 01-Mar-2008 - fixed to handle changes to EC website for conditions
// Version 2.04 - 19-Mar-2008 - fixed to handle changes to EC website for forecast
// Version 2.05 - 19-Mar-2008 - corrected extraction of Update date from EC website
// Version 2.06 - 05-Jun-2008 - fixed to handle changes to EC website for historical conditions
// Version 2.07 - 21-Dec-2008 - added printing/formatting for historical conditions
// Version 2.08 - 10-Mar-2009 - fixed to handle change to EC website for abnormal temperature trend indicator
// Version 2.09 - 09-Nov-2009 - fixed missing-space in warning titles problem
// Version 2.10 - 10-Nov-2009 - fixed to handle changes to EC website for normals conditions display
// Version 2.11 - 26-May-2010 - fixed to handle changes to EC website for humidex/wind-chill
// Version 2.12 - 19-Feb-2011 - added formatting to EC watch/warning/ended message alerts
// Version 2.13 - 30-May-2011 - fixed handling of $SITE['fcsticonsdirEC'] when used with template
// Version 2.14 - 16-Apr-2013 - fixes for changes in EC website structure
// Version 2.15 - 17-Apr-2013 - fixes for $title display with new EC website structure
// Version 2.16 - 12-May-2013 - added settings to display days of week w/o day month for icons and detail area; icon type selection for .gif/.png; added debugging code for EC website fetch; added multi-forecast capability
// Version 2.17 - 15-May-2013 - fixes for changes in EC website structure
// Version 3.00 - 17-Oct-2014 - redesign for major changes in EC website structure
// Version 3.01 - 29-Oct-2014 - fix for 'Normals' extract and text forecast
// Version 3.02 - 29-Apr-2015 - fixes for changes in EC website structure+new temps processing
// Version 3.03 - 01-Dec-2015 - fixes for current conditions based on EC website changes
// Version 3.04 - 14-Dec-2015 - fixes for changes in EC website structure (chunked+gzipped response)
// Version 3.05 - 16-Dec-2015 - fixes for changes in temperature forecast wording+extraction
// Version 4.00 - 22-Oct-2016 - major redesign for EC website changes+curl fetch
// Version 4.01 - 27-Oct-2016 - fix for conditions icon extract, yesterday data, use curl fetch for URL
//
  $Version = "V4.01 - 27-Oct-2016";

//error_reporting(E_ALL); // uncomment for checking errata in code

/* based on ORIGINAL CODE:
 * Canadian Weather Script
 * Gets Weather Information and Displays it on your Website
 *
 *  Author :   JMan
 *  HomePage : www.bedpan.ca
 *  Email :    jman@bedpan.ca
 *  issued under open-source GNU license 
 */
//  with lots of mods by Ken True - webmaster@saratoga-weather.org
//    -- use Text caching (no SQL required), 
//    -- return forecast in variables like Carterlake advforecast.php
//    -- use modified images with embedded PoP 
//    -- allow use as included program
//
//
//
// Settings:
// --------- start of settings ----------
// you need to set the $ECURL to the printable forecast for your area
//
//  Go to http://weather.gc.ca/ and select your language (sorry, I don't 
//  speak French, so these instructions are all in English)
//
//  Click on your province on the map.
//  Choose a location and click go from the menu on the right.
//
//  Select the 'Format for Print' version if available, or just copy the URL
//  of the forecast page for your city , and paste it into $ECURL 
//
$ECURL = 'http://weather.gc.ca/city/pages/on-107_metric_e.html';
//
$defaultLang = 'en';  // set to 'fr' for french default language
//                    // set to 'en' for english default language
//
$printIt = true;    // set to false if you want to manually print on your page
//
$showConditions = true; // set to true to show current conditions box
//
$imagedir = "ec-icons/";
//directory with your image icons WITH the trailing slash
//
$cacheName = 'ec-forecast.txt'; // note: will be changed to -en.txt or 
//                                  -fr.txt depending on language choice
$cacheFileDir = './';   // directory to store cache files (with trailing / )
//
$refetchSeconds = 600;  // get new forecast from EC 
//                         every 10 minutes (600 seconds)
//
//$LINKtarget = 'target="_blank"';  // to launch new link in new page
$LINKtarget = '';  // to launch new link in same page
//
$charsetOutput = 'ISO-8859-1'; // default character encoding of output
// new settings with V2.16 ------ all have Settings.php overrides available for template use
$doIconDayDate = false;        // =false; Icon names = day of week. =true; icon names as Day dd Mon
$doDetailDayDate = false;      // =false; for day name only, =true; detail day as name, nn mon. 
$iconType = '.png';            // ='.gif' or ='.png' for ec-icons file type 

// The optional multi-city forecast .. make sure the first entry is for the $ECURL location
// The contents will be replaced by $SITE['ECforecasts'] if specified in your Settings.php
/*
$ECforecasts = array(
 // Location|forecast-URL  (separated by | characters)
'Hamilton, ON|http://weather.gc.ca/city/pages/on-77_metric_e.html',
'St. Catharines, ON|http://weather.gc.ca/city/pages/on-107_metric_e.html', // St. Catharines, ON
'Lincoln, ON|http://weather.gc.ca/city/pages/on-47_metric_e.html',
'Vancouver, BC|http://weather.gc.ca/city/pages/bc-74_metric_e.html',
'Calgary, AB|http://weather.gc.ca/city/pages/ab-52_metric_e.html',
'Regina, SK|http://weather.gc.ca/city/pages/sk-32_metric_e.html',
'Winnipeg, MB|http://weather.gc.ca/city/pages/mb-38_metric_e.html',
'Ottawa (Kanata - Orléans), ON|http://weather.gc.ca/city/pages/on-118_metric_e.html',
'Montréal, QC|http://weather.gc.ca/city/pages/qc-147_metric_e.html',
'Happy Valley-Goose Bay, NL|http://weather.gc.ca/city/pages/nl-23_metric_e.html',
'St. John\'s, NL|http://weather.gc.ca/city/pages/nl-24_metric_e.html',
'Fredericton, NB|http://weather.gc.ca/city/pages/nb-29_metric_e.html',
'Halifax, NS|http://weather.gc.ca/city/pages/ns-19_metric_e.html',
'Charlottetown, PE|http://weather.gc.ca/city/pages/pe-5_metric_e.html',
'Whitehorse, YT|http://weather.gc.ca/city/pages/yt-16_metric_e.html',
'Yellowknife, NT|http://weather.gc.ca/city/pages/nt-24_metric_e.html',
'Resolute, NU|http://weather.gc.ca/city/pages/nu-27_metric_e.html',
'Iqaluit, NU|http://weather.gc.ca/city/pages/nu-21_metric_e.html',
'Placentia, NL|http://weather.gc.ca/city/pages/nl-30_metric_e.html',
'Channel-Port aux Basques, NL|http://weather.gc.ca/city/pages/nl-17_metric_e.html',
'Badger, NL|http://weather.gc.ca/city/pages/nl-34_metric_e.html',
'St. Anthony, NL|http://weather.gc.ca/city/pages/nl-37_metric_e.html',
'Mont-Tremblant, QC|http://weather.gc.ca/city/pages/qc-167_metric_e.html',
); 
//*/
// end of new settings with V2.16 ------

// ---------- end of settings -----------
// overrides from Settings.php if available
global $SITE;
if (isset($SITE['fcsturlEC']))      {$ECURL = $SITE['fcsturlEC'];}
if (isset($SITE['defaultlang']))    {$defaultLang = $SITE['defaultlang'];}
if (isset($SITE['LINKtarget']))     {$LINKtarget = $SITE['LINKtarget'];}
if (isset($SITE['fcsticonsdirEC'])) {$imagedir = $SITE['fcsticonsdirEC'];} 
if (isset($SITE['charset']))        {$charsetOutput = strtoupper($SITE['charset']); }
// following overrides are new with V2.16
if (isset($SITE['ECiconType']))     {$iconType = $SITE['ECiconType']; }         // new with V2.16
if (isset($SITE['ECiconDayDate']))  {$doIconDayDate = $SITE['ECiconDayDate']; } // new with V2.16
if (isset($SITE['ECdetailDayDate'])){$doDetailDayDate = $SITE['ECdetailDayDate']; } // new with V2.16
if (isset($SITE['ECforecasts']))    {$ECforecasts = $SITE['ECforecasts']; }     // new with V2.16
if (isset($SITE['cacheFileDir']))   {$cacheFileDir = $SITE['cacheFileDir']; }   // new with V2.16
// end of overrides from Settings.php if available
//------------------------------------------------
//
// The program will return with bits of the forecast items in various 
// PHP variables:
//  $i = 0 to 4  with 0=now, 1=next day, 2=day+2, 3=day+3, 4=day+4
//
// $forecasttitles[$i] = Day/night day of week for forecast
// $forecasticon[$i] = <img> statement for forecast icon
// $forecasttemp[$i] = Red Hi, Blue Lo temperature(s)
// $forecasttext[$i] = Summary of forecast for icon
//
// $forecastdays[$n] = Day/night day of week for detail forecast
// $forecastdetail[$n] = detailed forecast text
//
// Also returned are these useful variables filled in:
// $title = updated/issued text in language selected
// $textfcsthead = 'Current Forecast' or 'Textes des prévisions'
//
// $weather = fully formed html table with one row of Icons and text 
// $textforecast = fully formed <div> with text forecast as <dl>
//
// $alertstring = styled box with hotlinks to advisories/warnings
// $currentConditions = table with current conditions at EC forecast site
//
// so, you can set $printIT = false; and just echo/print the variables above
//  in your page to precisely position them.  Or use $forecast[$i] to
//  print just one of the items where you need it.
// 
//  I'd recommend you NOT change any of the main code.  You can do styling
//  for the results by using CSS.  See the companion test page
//  ec-forecast-testpage.php to demonstrate CSS styling of results.
//
// ---------- main code -----------------
if (isset($_REQUEST['sce']) and strtolower($_REQUEST['sce']) == 'view' ) {
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
if (! isset($PHP_SELF) ) { $PHP_SELF = $_SERVER['PHP_SELF']; }
if(!function_exists('langtransstr')) {
	// shim function if not running in template set
	function langtransstr($input) { return($input); }
}

$t = pathinfo($PHP_SELF);  // get our program name for the HTML comments
$Program = $t['basename'];
$Status = "<!-- ec-forecast.php - $Version -->\n";

if (! isset($doInclude)) { $doInclude = false ; }
if( (isset($_REQUEST['inc']) and strtolower($_REQUEST['inc']) == 'y') or 
    $doInclude )
 {$printIt = false;}

if(isset($doPrint)) { $printIt = $doPrint; }
if(!isset($_REQUEST['lang'])) { $_REQUEST['lang'] = '';}

if(isset($_REQUEST['lang'])) {
  $Lang = strtolower($_REQUEST['lang']);
} else {
  $Lang = '';
}
if (isset($doLang)) {$Lang = $doLang;};
if (! $Lang) {$Lang = $defaultLang;};

$doDebug = (isset($_REQUEST['debug']) and strtolower($_REQUEST['debug']) == 'y')?true:false;

if ($Lang == 'fr') {
  $LMode = 'f';
  $ECNAME = "Environnement Canada";
  $ECHEAD = 'Prévisions';
  $abnormalString = '<p class="ECforecast"><strong>*</strong> - Indique une tendance inverse de la température.</p>' . "\n";
} else {
  $Lang = 'en';
  $LMode = 'e';
  $ECNAME = "Environment Canada";
  $ECHEAD = 'Forecast';
  $abnormalString = '<p class="ECforecast"><strong>*</strong> - Denotes an abnormal temperature trend.</p>' . "\n";
}

// get the selected forecast location code
$haveIndex = '0';
if (!empty($_GET['z']) && preg_match("/^[0-9]+$/i", htmlspecialchars($_GET['z']))) {
  $haveIndex = htmlspecialchars(strip_tags($_GET['z']));  // valid zone syntax from input
} 

if(!isset($ECforecasts[0])) {
	// print "<!-- making NWSforecasts array default -->\n";
	$ECforecasts = array("|$ECURL"); // create default entry
}
//  print "<!-- ECforecasts\n".print_r($ECforecasts,true). " -->\n";
// Set the default zone. The first entry in the $SITE['ECforecasts'] array.
list($Nl,$Nn) = explode('|',$ECforecasts[0].'|||');
$FCSTlocation = $Nl;
$ECURL = $Nn;

if(!isset($ECforecasts[$haveIndex])) {
	$haveIndex = 0;
}

// locations added to the drop down menu and set selected zone values
$dDownMenu = '';
for ($m=0;$m<count($ECforecasts);$m++) { // for each locations
  list($Nlocation,$Nname) = explode('|',$ECforecasts[$m].'|||');
  $seltext = '';
  if($haveIndex == $m) {
    $FCSTlocation = $Nlocation;
    $ECURL = $Nname;
	$seltext = ' selected="selected" ';
  }
  $dDownMenu .= "     <option value=\"$m\"$seltext>".langtransstr($Nlocation)."</option>\n";
}

// build the drop down menu
$ddMenu = '';
// create menu if at least two locations are listed in the array
if (isset($ECforecasts[0]) and isset($ECforecasts[1])) {
	$ddMenu .= '<table style="border:none;width:99%"><tr align="center">
      <td style="font-size: 14px; font-family: Arial, Helvetica, sans-serif">
      <script type="text/javascript">
        <!--
        function menu_goto( menuform ){
         selecteditem = menuform.logfile.selectedIndex ;
         logfile = menuform.logfile.options[ selecteditem ].value ;
         if (logfile.length != 0) {
          location.href = logfile ;
         }
        }
        //-->
      </script>
     <form action="" method="get">
     <p><select name="z" onchange="this.form.submit()">
     <option value=""> - '.langtransstr('Select Forecast').' - </option>
' . $dDownMenu .
		$ddMenu . '     </select></p>
     <div><noscript><pre><input name="submit" type="submit" value="'.langtransstr('Get Forecast').'" /></pre></noscript></div>
     </form>
    </td>
   </tr>
 </table>
';
}


// support both french and english caches
//$ECURL = preg_replace('|city_.\.html|',"city_$LMode.html",$ECURL);
$ECURL = preg_replace('|weatheroffice|i','weather',$ECURL); // autochange Old EC URL if present
$ECURL = preg_replace('|_.\.html|',"_$LMode.html",$ECURL);
$cacheName = preg_replace('|\.txt|is',"-$haveIndex-$Lang.txt",$cacheName); // unique cache per language used
$cacheName = $cacheFileDir.$cacheName;
$cacheAge = (file_exists($cacheName))?time()-filemtime($cacheName):9999999;
// force refresh of cache
if (isset($_REQUEST['cache'])) { $refetchSeconds = 1; }

// refresh cached copy of page if needed
// fetch/cache code by Tom at carterlake.org
if($Lang == 'fr' and preg_match('|weather.gc.ca|i',$ECURL)) {
	$ECURL = str_replace('weather.gc.ca','meteo.gc.ca',$ECURL);
	$Status .= "<!-- using $ECURL for French forecast instead of weather.gc.ca -->\n";
}
if($Lang == 'en' and preg_match('|meteo.gc.ca|i',$ECURL)) {
	$ECURL = str_replace('meteo.gc.ca','weather.gc.ca',$ECURL);
	$Status .= "<!-- using $ECURL for English forecast instead of meteo.gc.ca -->\n";
}

$total_time = 0.0;
if (file_exists($cacheName) and $cacheAge < $refetchSeconds) {
      $Status .= "<!-- using Cached version from $cacheName age=$cacheAge seconds old -->\n";
      $site = implode('', file($cacheName));
    } else {
      $Status .= "<!-- refreshing $cacheName age=$cacheAge seconds old -->\n";
      $time_start = ECF_fetch_microtime();
      $rawhtml = ECF_fetch_URL($ECURL,false);
	  $time_stop = ECF_fetch_microtime();
	  $total_time += ($time_stop - $time_start);
	  $time_fetch = sprintf("%01.3f",round($time_stop - $time_start,3));
      $RC = '';
	  if (preg_match("|^HTTP\/\S+ (.*)\r\n|",$rawhtml,$matches)) {
	    $RC = trim($matches[1]);
	  }
	  $Status .= "<!-- time to fetch: $time_fetch sec ($RC) -->\n";
	  
	  if(preg_match('|30\d |i',$RC)) { //oops.. a redirect.. retry the new location
		sleep(2); // wait two seconds and retry
		preg_match('|Location: (.*)\r\n|',$rawhtml,$matches);
		if(isset($matches[1])) {$ECURL = $matches[1];} // update the URL
		$time_start = ECF_fetch_microtime();
		$rawhtml = ECF_fetch_URL($ECURL,false);
		$time_stop = ECF_fetch_microtime();
		$total_time += ($time_stop - $time_start);
		$time_fetch = sprintf("%01.3f",round($time_stop - $time_start,3));
		$RC = '';
		if (preg_match("|^HTTP\/\S+ (.*)\r\n|",$rawhtml,$matches)) {
		  $RC = trim($matches[1]);
		}
		$Status .= "<!-- second time to fetch: $time_fetch sec ($RC) -->\n";
	  }

      $i = strpos($rawhtml,"\r\n\r\n");
	  $headers = substr($rawhtml,0,$i);
	  $content = substr($rawhtml,$i+2);
	  if(preg_match('|Transfer-Encoding: chunke|Ui',$headers)) {
		$Status .= "<!-- unchunking response -->\n";
		//$Status .= "<!-- content before='".bin2hex($content).". -->\n";
		$Status .= "<!-- in=".strlen($content); 
		$content = EC_fetch_unchunk($content); 
		$Status .= " out=".strlen($content). " bytes -->\n";
	  }
	  if(preg_match('|Content-Encoding: gzip|Ui',$headers)) {
		  $Status .= "<!-- Webserver returned gzipped data, unzipping response -->\n";
		  // $Status .= "<!-- content='".$content."' -->\n";
		  $err = 'None';
		  $html = trim(ECF_fetch_gzdecode($content,$err));
		  //$html = gzdecode($content);
		  $Status .= "<!-- ECF_fetch_gzdecode err='$err' -->\n";
		  if($err <> 'None') {
		     $Status .= "<!-- contentX='".bin2hex($html).". -->\n";
		  }
	  } else {
	      $html = trim($content);  
	  }
	  
      $site = $headers . "\r\n\r\n" . $html; // put it back together as one long string
	  if($doDebug) {$Status .= "<!-- headers returned:\n$headers\n -->\n";}

      if(preg_match('|200|',$RC)) { // good return so save off the cache	  
	  
		$fp = fopen($cacheName, "w");
		if ($fp) {
		  // $site = utf8_decode($site); // convert to ISO-8859-1 for use (like old EC site)
		  $write = fputs($fp, $site);
		  fclose($fp);  
		  $Status .= "<!-- cache saved to $cacheName -->\n";
		} else {
		  $Status .= "<!-- unable to open $cacheName for writing .. cache not saved -->\n";
		}
	  } else {
		  $Status .= "<!-- headers returned:\n$headers\n -->\n";
		  $Status .= "<!-- using Cached version from $cacheName due to unsucessful fetch(s); age=$cacheAge seconds old -->\n";
		  $site = implode('', file($cacheName));
	  } // end of cache save
	} // end of get contents into $site string.
	

$conditions = array();

  preg_match('|charset="{0,1}([^"]+)"{0,1}|i',$site,$matches);
  
  if (isset($matches[1])) {
    $charsetInput = strtoupper($matches[1]);
  } else {
    $charsetInput = 'UTF-8';
  }
  
 $doIconv = ($charsetInput == $charsetOutput)?false:true; // only do iconv() if sets are different
 
 $Status .= "<!-- using charsetInput='$charsetInput' charsetOutput='$charsetOutput' doIconv='$doIconv' -->\n";

$site = str_replace("	", "", $site);
$site = str_replace("  ", " ", $site);
$site = str_replace("\n", "", $site);
$site = str_replace("\r", "", $site);

// get current conditions (which may vary in format based on region)
$obsGroups = array(
// English
            'Currently' => 'obs',
            'Yesterday' => 'yday', 
            'Normals' => 'norms',
            'Today' => '',
// French
			'Conditions actuelles' => 'obs',
            'Hier' => 'yday',
            'Normales' => 'norms',
            "Soleil (aujourd'hui)" => ''
			);
$obsTypes = array(
/*
            [0] => Observed at
            [1] => Date
            [2] => Wind
            [3] => Wind Chill
            [4] => Observed at
            [5] => Date
            [6] => Condition
            [7] => Pressure
            [8] => Tendency
            [9] => Visibility
            [10] => Temperature
            [11] => Dewpoint
            [12] => Humidity
            [13] => Wind
            [14] => Wind Chill
*/
// English
      'Condition' => 'citycondition',
	  'Date' => 'obsdate',
	  'Observed at' => 'cityobserved',	  
      'Temperature' => 'temperature',
      'Pressure' => 'pressure',
	  'Tendency' => 'tendency',
      'Humidity' => 'humidity',
      'Wind Chill' => 'windchill',
	  'Humidex' => 'humidex',
	  'Visibility' => 'visibility',
      'Dew point' => 'dewpoint',
      'Wind' => 'wind',
	  'Air Quality Health Index' => 'aqhi',
      'Max' => 'maxtemp',
      'Min' => 'mintemp',
	  'Normals' => 'maxmin',
      'Total Precipitation' => 'precip',
      'Rainfall' => 'precip',
	  'Snowfall' => 'snow',
	  
      'Sunrise' => 'sunrise',
      'Sunset' => 'sunset',
      'Moonrise' => 'moonrise',
      'Moonset' => 'moonset',
	  
// French
/*
            [0] => Enregistrées à 
            [1] => Date 
            [2] => Vent 
            [3] => Refr. éolien 
            [4] => Enregistrées à 
            [5] => Date 
            [6] => Condition 
            [7] => Pression 
            [8] => Tendance 
            [9] => Visibilité 
            [10] => Température 
            [11] => Point de rosée 
            [12] => Humidité 
            [13] => Vent 
            [14] => Refr. éolien 
*/	  
      'Condition' => 'citycondition',
	  'Date' => 'obsdate',
	  'Enregistrées à' => 'cityobserved',
      'Température' => 'temperature',
      'Pression' => 'pressure',
	  'Tendance' => 'tendency',
      'Humidité' => 'humidity',
      'Refr. éolien' => 'windchill',
	  'Humidex' => 'humidex',
	  'Visibilité' => 'visibility',
      'Point de rosée' => 'dewpoint',
      'Vent' => 'wind',
	  'Cote air santé' => 'aqhi',
	  'Normales' => 'maxmin',
      'Max' => 'maxtemp',
      'Min' => 'mintemp',
      'Précipitation totale' => 'precip',
      'Pluie' => 'precip',
	  'Neige' => 'snow',
      'Lever' => 'sunrise',
      'Coucher' => 'sunset',
      'Lever de la lune' => 'moonrise',
      'Coucher de la lune' => 'moonset',
	  
	  );
if($doIconv) { // put keys in UTF-8 also
  $TobsTypes = array();
  foreach ($obsTypes as $key => $val) {
	  $nkey = iconv('ISO-8859-1','UTF-8//TRANSLIT',$key);
	  $TobsTypes[$nkey] = $val;
  }
  $obsTypes = $TobsTypes;
  $Status .= "<!-- converted lookup keys to UTF-8 -->\n";
  // $Status .= "<!-- obsTypes:\n".print_r($obsTypes,true)."\n-->\n";
}

//----------- grab the city conditions -----------------------------------------

$startgrab = strpos($site, 'id="mainContent"');
$start = strpos($site, '<section>',$startgrab);
$finish = strpos($site, '</details>',$start);
$length = $finish-$start;
$code = substr($site, $start, $length);
if($doDebug) { $Status .= "<!-- city conditions area startgrab=$startgrab start=$start finish=$finish length=$length codelen=".strlen($code)." -->\n";
   //$Status .= "<div style=\"display:none\">\n $code\n </div>\n";
}

//append the 'normals' and section from later in the page
$startgrab = strpos($site, '<dl class="dl-horizontal wxo-normals"');
$start = strpos($site, '<dl',$startgrab);
$finish = strpos($site, '</section>',$start);
$length = $finish-$start;
$code .= substr($site, $start, $length);
if($doDebug) { $Status .= "<!-- normals area startgrab=$startgrab start=$start finish=$finish length=$length codelen=".strlen($code)." -->\n";
   //$Status .= "<div style=\"display:none\">\n $code\n </div>\n";
}

$code = preg_replace('|<span class="wxo-imperial[^>]+>.*</span>|Uis','',$code); // remove imperial stuff
$code = strip_tags($code,"<dd><dt><img>");
$code = preg_replace('|\s+\:|Uis',':',$code); // fix French extra spaces if need be
preg_match_all('!<dt>\s*(\S[^\:]+)\s*:\s*</dt>\s+<dd[^>]*>(.*)</dd>!Uis',$code,$matches);  // get current conds
  if ($doDebug) {$Status .= "<!-- maincontent matches \n" . print_r($matches,true) . "-->\n";}
  foreach ($matches[1] as $key => $val) {
	  $obsType = $obsTypes[trim($val)];
	  $t = trim($val) . ': <strong>' . strip_tags(trim($matches[2][$key]))  . '</strong>';
	  if ($obsType == 'citycondition') {
		$t = '<strong>' . trim(strip_tags($matches[2][$key])). '</strong>';
	  }
	  $conditions[$obsType] = $t;
  }

preg_match('!src="/weathericons/(.*)"!Uis',$code,$matches); // snag the current icon

if($doDebug) {$Status .= "<!-- weathericons matches \n" . print_r($matches,true) . "-->\n"; }
if(isset($matches[1])) {
  $conditions['icon'] = preg_replace('|.gif|',$iconType,$matches[1]);
 } else {
  $conditions['icon'] = '';
}

//process the 'yesterday' section from later in the page
$startgrab = strpos($site, '<section class="mrgn-tp-lg">');
$startgrab = strpos($site, '<section class="mrgn-tp-lg">',$startgrab+1);
$startgrab = strpos($site, '<section class="mrgn-tp-lg">',$startgrab+1);
$start = strpos($site, '<summary',$startgrab);
$finish = strpos($site, '</details>',$start);
$length = $finish-$start;
$code = substr($site, $start, $length);
if($doDebug) { $Status .= "<!-- yesterday area startgrab=$startgrab start=$start finish=$finish length=$length codelen=".strlen($code)." -->\n";
   $Status .= "<div style=\"display:none\">\n $code\n </div>\n";
}

preg_match('|<h2>(.*)</h2>|Uis',$code,$matches);
if(isset($matches[1])) {
	$conditions['ydayheading'] = trim($matches[1]);
}

$code = preg_replace('|<span class="wxo-imperial[^>]+>.*</span>|Uis','',$code); // remove imperial stuff
$code = strip_tags($code,"<dd><dt><img>");
$code = preg_replace('|\s+\:|Uis',':',$code); // fix French extra spaces if need be
preg_match_all('!<dt>\s*(\S[^\:]+)\s*:\s*</dt>\s+<dd[^>]*>(.*)</dd>!Uis',$code,$matches);  // get current conds
  if ($doDebug) {$Status .= "<!-- maincontent matches \n" . print_r($matches,true) . "-->\n";}
  foreach ($matches[1] as $key => $val) {
	  $obsType = 'yday'.$obsTypes[trim($val)];
	  $t = trim($val) . ': <strong>' . strip_tags(trim($matches[2][$key]))  . '</strong>';
	  $conditions[$obsType] = $t;
  }


// -------------------------------------------------------------------------
    if($doIconv) {
		foreach ($conditions as $key => $val) {
			$conditions[$key] = iconv($charsetInput,$charsetOutput.'//TRANSLIT',$val);
		}
	}

  	$Status .= "<!-- conditions\n" . print_r($conditions,true) . " -->\n";
/* new so far
(
    [cityobserved] => Observed at: <strong>Montréal-Trudeau Int'l Airport</strong>
    [obsdate] => Date: <strong>1:00 PM EDT Thursday 27 October 2016</strong>
    [citycondition] => <strong>Mostly Cloudy</strong>
    [pressure] => Pressure: <strong>102.9 kPa</strong>
    [tendency] => Tendency: <strong>Falling</strong>
    [temperature] => Temperature: <strong>4.8&deg;C</strong>
    [dewpoint] => Dew point: <strong>-2.3&deg;C</strong>
    [humidity] => Humidity: <strong>60%</strong>
    [wind] => Wind: <strong>E 22 km/h</strong>
    [visibility] => Visibility: <strong>24 km</strong>
    [maxmin] => Normals: <strong>Max 9&deg;C. Min 1&deg;C.</strong>
    [sunrise] => Sunrise: <strong>7:27 EDT</strong>
    [sunset] => Sunset: <strong>17:49 EDT</strong>
    [icon] => 03.png
    [ydayheading] => Yesterday's Data
    [ydaymaxtemp] => Max: <strong>3.4&deg;C</strong>
    [ydaymintemp] => Min: <strong>-0.8&deg;C</strong>
    [ydayprecip] => Rainfall: <strong>Trace</strong>
    [ydaysnow] => Snowfall: <strong>0.1 cm</strong>
	
Note: moonrise/moonset, aqhi no longer available
*/
    $nC = 3;
	$currentConditions = '';
	
if (isset($conditions['cityobserved']) ) { // only generate if we have the data
	if (! $conditions['icon'] ) { $nC = 2; };
	
	
	$currentConditions = '<table class="ECforecast" cellpadding="3" cellspacing="3" style="border: 1px solid #909090;">' . "\n";
	
	$currentConditions .= '
  <tr><td colspan="' . $nC . '" align="center"><small>' . $conditions['cityobserved'] .
  '<br/>'. $conditions['obsdate'] . 
  '</small></td></tr>' . "\n<tr>\n";
    if ($conditions['icon']) {
    $currentConditions .= '
    <td align="center" valign="middle">' . 
"    <img src=\"$imagedir" . $conditions['icon'] . "\"\n" .
               "     height=\"51\" width=\"60\" \n" . 
			   "     alt=\"" . strip_tags($conditions['citycondition']) . "\"\n" .
			   "     title=\"" . strip_tags($conditions['citycondition']) . "\" /> <br/>" . 
			   $conditions['citycondition'] . "\n";
	$currentConditions .= '    </td>
';
    } // end of icon
    $currentConditions .= "
    <td valign=\"middle\">\n";

	if (isset($conditions['temperature'])) {
	  $currentConditions .= 
	  $conditions['temperature'] . "<br/>\n";
	}
	if (isset($conditions['windchill'])) {
	  $currentConditions .=
	  $conditions['windchill'] . "<br/>\n";
	}
	if (isset($conditions['humidex'])) {
	  $currentConditions .=
	  $conditions['humidex'] . "<br/>\n";
	}
	$currentConditions .= 
	$conditions['wind'] . "<br/>\n" .
	$conditions['humidity'] . "<br/>\n" .
	$conditions['dewpoint'] . "<br/>\n";
	
	if (isset($conditions['precip'])) {
	  $currentConditions .=
	  $conditions['precip'] . "<br/>\n";
	}
	
	$currentConditions .= 
	$conditions['pressure'] . "<br/>\n";
	
	if (isset($conditions['tendency'])) {
	  $currentConditions .=
	  $conditions['tendency'] . "<br/>\n" ;
	}
	if (isset($conditions['aqhi'])) {
	  $currentConditions .=
	  $conditions['aqhi'] . "<br/>\n" ;
	}
	if (isset($conditions['visibility'])) {
	  $currentConditions .=
	  $conditions['visibility'] . "\n" ;
	}
	$currentConditions .= '	   </td>
';
	$currentConditions .= '    <td valign="middle">
';
	if(isset($conditions['sunrise']) and isset($conditions['sunset']) ) {
	  $currentConditions .= 
	  $conditions['sunrise'] . "<br/>\n" .
	  $conditions['sunset'] . "<br/>\n" ;
	}
	if (isset($conditions['moonrise']) and isset($conditions['moonset']) ) {
  	  $currentConditions .=
	  $conditions['moonrise'] . "<br/>\n" .
	  $conditions['moonset'] ;
	}
    if(isset($conditions['maxmin'])  ) {
		$currentConditions .= str_replace(':',':<br/>',$conditions['maxmin']) . "<br/>\n";
	}
    if(isset($conditions['ydayheading']) and 
	   isset($conditions['ydaymaxtemp']) and
	   isset($conditions['ydaymintemp']) ) {
		$currentConditions .= $conditions['ydayheading'] . "<br/>\n" .
		'&nbsp;&nbsp;' . $conditions['ydaymaxtemp'] . "<br/>\n" .
		'&nbsp;&nbsp;' . $conditions['ydaymintemp'] . "<br/>\n";
		if(isset($conditions['ydayprecip'])) {
			$currentConditions .= 
		'&nbsp;&nbsp;' . $conditions['ydayprecip'] . "<br/>\n";
		}
		if(isset($conditions['ydaysnow'])) {
			$currentConditions .= 
		'&nbsp;&nbsp;' . $conditions['ydaysnow'] . "<br/>\n";
		}
		$currentConditions .= "<br/>\n";
	}
	$currentConditions .= '
	</td>
  </tr>
';
	$currentConditions .= '
</table>
';
} // end of if isset($conditions['cityobserved'])
// end of current conditions mods

// -----------------------------------------------------------------
// locate the forecast icons information -- now in 2-rows of data
$startgrab = strpos($site , '<details class="panel panel-default wxo-fcst"');
$start = strpos($site , '<table', $startgrab);
$finish = strpos($site , '</table>', $start) + 8;
$length = $finish-$start;
$code=Substr($site , $start, $length);
//
if($doDebug) { $Status .= "<!-- forecast icons area startgrab=$startgrab start=$start finish=$finish length=$length codelen=".strlen($code)." -->\n";
 //  $Status .= "<div style=\"display:none\">\n $code\n </div>\n";
}

#$code = str_replace('Â ','',$code); // remove odd utf-8 'blank' space
$code = preg_replace('|<span class="\S+ wxo-imperial[^>]+>.*</span>|Uis','',$code); // remove imperial
// slice up the icons, hi/low/pop and summary
preg_match_all('|<t[dh][^>]*>(.*?)</t[dh]>|is', $code, $matches);
//  $Status .= "<!-- matches \n" . print_r($matches,true) . "-->\n";
$fcsts = $matches[1];
if($doDebug) {$Status .= "<!-- forecast area matches\n" . print_r($fcsts,true) . " -->\n";}
/*
Array
(
    [0] =>        <a href="/forecast/hourly/sk-32_metric_e.html">        <strong title="Thursday">Thu</strong>        <br>27Â <abbr title="October">Oct</abbr>       </a>      
    [1] =>        <strong title="Friday">Fri</strong>       <br>28Â <abbr title="October">Oct</abbr>      
    [2] =>        <strong title="Saturday">Sat</strong>       <br>29Â <abbr title="October">Oct</abbr>      
    [3] =>        <strong title="Sunday">Sun</strong>       <br>30Â <abbr title="October">Oct</abbr>      
    [4] =>        <strong title="Monday">Mon</strong>       <br>31Â <abbr title="October">Oct</abbr>      
    [5] =>        <strong title="Tuesday">Tue</strong>       <br>1Â <abbr title="November">Nov</abbr>      
    [6] =>        <strong title="Wednesday">Wed</strong>       <br>2Â <abbr title="November">Nov</abbr>      
    [7] => <img width="60" height="51" src="/weathericons/10.gif" alt="Cloudy" class="center-block" title="Cloudy"><p class="mrgn-bttm-0"><span class="high wxo-metric-hide" title="max">14&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Cloudy</p>      
    [8] => <img width="60" height="51" src="/weathericons/12.gif" alt="Periods of rain" class="center-block" title="Periods of rain"><p class="mrgn-bttm-0"><span class="high wxo-metric-hide" title="max">6&deg;<abbr title="Celsius">C</abbr><span class="abnTrend">*</span></span></span></p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Periods of rain</p>      
    [9] => <img width="60" height="51" src="/weathericons/00.gif" alt="Sunny" class="center-block" title="Sunny"><p class="mrgn-bttm-0"><span class="high wxo-metric-hide" title="max">6&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Sunny</p>      
    [10] => <img width="60" height="51" src="/weathericons/00.gif" alt="Sunny" class="center-block" title="Sunny"><p class="mrgn-bttm-0"><span class="high wxo-metric-hide" title="max">11&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Sunny</p>      
    [11] => <img width="60" height="51" src="/weathericons/02.gif" alt="A mix of sun and cloud" class="center-block" title="A mix of sun and cloud"><p class="mrgn-bttm-0"><span class="high wxo-metric-hide" title="max">7&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">A mix of sun and cloud</p>      
    [12] => <img width="60" height="51" src="/weathericons/02.gif" alt="A mix of sun and cloud" class="center-block" title="A mix of sun and cloud"><p class="mrgn-bttm-0"><span class="high wxo-metric-hide" title="max">9&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">A mix of sun and cloud</p>      
    [13] => <img width="60" height="51" src="/weathericons/00.gif" alt="Sunny" class="center-block" title="Sunny"><p class="mrgn-bttm-0"><span class="high wxo-metric-hide" title="max">12&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Sunny</p>      
    [14] => Tonight
    [15] =>  Night
    [16] =>  Night
    [17] =>  Night
    [18] =>  Night
    [19] =>  Night
    [20] => Â 
    [21] => <img width="60" height="51" src="/weathericons/12.gif" alt="Chance of showers" class="center-block" title="Chance of showers"><p class="mrgn-bttm-0"><span class="low wxo-metric-hide" title="min">6&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small> 30%</small>       </p>       <p class="mrgn-bttm-0">Chance of showers</p>      
    [22] => <img width="60" height="51" src="/weathericons/12.gif" alt="Chance of showers" class="center-block" title="Chance of showers"><p class="mrgn-bttm-0"><span class="low wxo-metric-hide" title="min">0&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small> 60%</small>       </p>       <p class="mrgn-bttm-0">Chance of showers</p>      
    [23] => <img width="60" height="51" src="/weathericons/30.gif" alt="Clear" class="center-block" title="Clear"><p class="mrgn-bttm-0"><span class="low wxo-metric-hide" title="min">2&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Clear</p>      
    [24] => <img width="60" height="51" src="/weathericons/32.gif" alt="Cloudy periods" class="center-block" title="Cloudy periods"><p class="mrgn-bttm-0"><span class="low wxo-metric-hide" title="min">1&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Cloudy periods</p>      
    [25] => <img width="60" height="51" src="/weathericons/30.gif" alt="Clear" class="center-block" title="Clear"><p class="mrgn-bttm-0"><span class="low wxo-metric-hide" title="min">-2&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Clear</p>      
    [26] => <img width="60" height="51" src="/weathericons/30.gif" alt="Clear" class="center-block" title="Clear"><p class="mrgn-bttm-0"><span class="low wxo-metric-hide" title="min">-1&deg;<abbr title="Celsius">C</abbr>        </span>       </p>       <p class="mrgn-bttm-0 pop text-center" title="Chance of Precipitation">        <small>Â </small>       </p>       <p class="mrgn-bttm-0">Clear</p>      
    [27] => Â 
)
*/
$forecasticons = array();
$forecasttemp  = array();
$forecasttempHigh  = array();
$forecasttempLow  = array();
$forecastpop   = array();
$forecasttitles = array();
$forecast = array();
$forecastshortdayname = array();
$forecastlongdayname = array();
$forecasticonrealday = array();	 

$updated = '';
$i = 0;
$foundAbnormal = 0;
// assemble into a forecast period-sequenced list 
$rawFcst = array();
if (count($fcsts) > 7){
  for ($b=0;$b<count($fcsts)/4;$b++){ // preprocess the selection into forecast days
	$tPeriod = $fcsts[$b];
	// <strong title="Friday">Fri</strong>       <br>21 <abbr title="October">Oct</abbr>      

	preg_match(  // find day, date
	'!<strong title="([^"]+)"[^>]*>(\S+)</strong>.*<br>(\d+).*title="([^"]+).*>(\S+)</abbr>!is',
	$tPeriod,$tM);
    if(isset($tM[5])) {
    //if($doDebug) {$Status .= "<!-- tM $b='". print_r($tM,true). "' -->\n"; }
      $tPeriod = $tM[1].'|'.$tM[2].'|'.$tM[3].' '.$tM[5]; //longday|shortday|dd mon
	}
	$tDetails =$fcsts[$b+7];
	// find current conditons icon/text
	preg_match('/\/weathericons\/(.*?)".*?alt="(.*?)"/', $tDetails, $tFC);
    //if($doDebug) {$Status .= "<!-- tFC \n" . print_r($tFC,true) . "-->\n";}
    if(isset($tFC[2])) {
		$tC = $tFC[1].'|'.$tFC[2];
	} else {
		$tC = '|';
	}
	// find min or max temp and value
	//<span class="low wxo-metric-hide" title="min">9&deg;<abbr title="Celsius">C</abbr>        </span>
	preg_match('|<span class="(\S+) wxo-metric-hide" title="([^"]+)">([^<]+)<|Uis',$tDetails,$tTM);
    //if($doDebug) {$Status .= "<!-- tTM \n" . print_r($tTM,true) . "-->\n";}
	$tABN = (strpos($tDetails,'class="abnTrend"') !== false)?'*':'';
	if($tABN <> '') { $foundAbnormal++; }
	if(isset($tTM[3])) {
		$tT = $tTM[1].'|'.$tTM[2].': '.$tTM[3].'C'.$tABN;
	} else {
		$tT = '|';
	}
	
	// find PoP
	// pop text-center" title="Chance of Precipitation">        <small> </small>
	preg_match('| pop text-center" title="([^"]+)">\s+<small>([^<]*)</small>|Uis',
	  $tDetails,$tMP);
    //if($doDebug) {$Status .= "<!-- tMP \n" . print_r($tMP,true) . "-->\n";}
	if(isset($tMP[2])) {
		$tP = $tMP[1].'|'.trim($tMP[2]);
	} else {
		$tP = '|';
	}

	$rawFcst[] = $tPeriod . "|" . $tC .'|'.$tT.'|'.$tP.'|';
	
	// process lower icon entry ----------------------------------
	if ($b == 0 and isset($tM[5])) {
		$tPeriod = $fcsts[$b+14] . '|' . $tM[2].'|'.$tM[3].' '.$tM[5]; // special case for 'tonight'
	} elseif (strlen($fcsts[$b+14]) > 3 and isset($tM[5])) {
		$tPeriod = $tM[1] . $fcsts[$b+14] .'|' . $tM[2]. $fcsts[$b+14].'|'.$tM[3].' '.$tM[5]; // add day name before 'nite'
	} else {
		$tPeriod = trim(strip_tags($fcsts[$b+14])) .'||';
	}
	$tDetails = trim($fcsts[$b+21]);
	// find current conditons icon/text
	preg_match('/\/weathericons\/(.*?)".*?alt="(.*?)"/', $tDetails, $tFC);
    //if($doDebug) {$Status .= "<!-- tFC \n" . print_r($tFC,true) . "-->\n";}
    if(isset($tFC[2])) {
		$tC = $tFC[1].'|'.$tFC[2];
	} else {
		$tC = '|';
	}

	// find min or max temp and value
	//<span class="low wxo-metric-hide" title="min">9&deg;<abbr title="Celsius">C</abbr>        </span>
	preg_match('|<span class="(\S+) wxo-metric-hide" title="([^"]+)">([^<]+)<|Uis',$tDetails,$tTM);
    //if($doDebug) {$Status .= "<!-- tTM \n" . print_r($tTM,true) . "-->\n";}
	$tABN = (strpos($tDetails,'class="abnTrend"') !== false)?'*':'';
	if($tABN <> '') { $foundAbnormal++; }
	if(isset($tTM[3])) {
		$tT = $tTM[1].'|'.$tTM[2].': '.$tTM[3].'C'.$tABN;
	} else {
		$tT = '|';
	}

	// find PoP
	// pop text-center" title="Chance of Precipitation">        <small> </small>
	preg_match('| pop text-center" title="([^"]+)">\s+<small>([^<]*)</small>|Uis',
	  $tDetails,$tMP);
    //if($doDebug) {$Status .= "<!-- tMP \n" . print_r($tMP,true) . "-->\n";}
	if(isset($tMP[2])) {
		$tP = $tMP[1].'|'.trim($tMP[2]);
	} else {
		$tP = '|';
	}

	$rawFcst[] = $tPeriod . "|" . $tC .'|'.$tT.'|'.$tP.'|';
	
  }
  if($doIconv) {
	  foreach ($rawFcst as $b => $rec) {
        $rawFcst[$b] = iconv($charsetInput,$charsetOutput.'//TRANSLIT',$rec);
	  }
  }
  
  if($doDebug) {$Status .= "<!-- rawFcst\n".print_r($rawFcst,true)." -->\n"; }
  
 
/*
rawFcst
Array
(
    [0] => Thursday|Thu|27 Oct|10.gif|Cloudy|high|max: 14&deg;C|Chance of Precipitation| |
    [1] => Tonight|Thu|27 Oct|12.gif|Chance of showers|low|min: 6&deg;C|Chance of Precipitation|30%|
    [2] => Friday|Fri|28 Oct|12.gif|Periods of rain|high|max: 6&deg;C*|Chance of Precipitation| |
    [3] => Friday Night|Fri Night|28 Oct|12.gif|Chance of showers|low|min: 0&deg;C|Chance of Precipitation|60%|
    [4] => Saturday|Sat|29 Oct|00.gif|Sunny|high|max: 6&deg;C|Chance of Precipitation| |
    [5] => Saturday Night|Sat Night|29 Oct|30.gif|Clear|low|min: 2&deg;C|Chance of Precipitation| |
    [6] => Sunday|Sun|30 Oct|00.gif|Sunny|high|max: 11&deg;C|Chance of Precipitation| |
    [7] => Sunday Night|Sun Night|30 Oct|32.gif|Cloudy periods|low|min: 1&deg;C|Chance of Precipitation| |
    [8] => Monday|Mon|31 Oct|02.gif|A mix of sun and cloud|high|max: 7&deg;C|Chance of Precipitation| |
    [9] => Monday Night|Mon Night|31 Oct|30.gif|Clear|low|min: -2&deg;C|Chance of Precipitation| |
    [10] => Tuesday|Tue|1 Nov|02.gif|A mix of sun and cloud|high|max: 9&deg;C|Chance of Precipitation| |
    [11] => Tuesday Night|Tue Night|1 Nov|30.gif|Clear|low|min: -1&deg;C|Chance of Precipitation| |
    [12] => Wednesday|Wed|2 Nov|00.gif|Sunny|high|max: 12&deg;C|Chance of Precipitation| |
    [13] =>  |||||||||

or

   [0] => |||||||
    [1] => Tonight|||12.gif|Periods of rain|low|min: 9&deg;C|Chance of Precipitation||
    [2] => Friday|Fri|21 Oct|12.gif|Chance of showers|high|max: 11&deg;C|Chance of Precipitation|60%|
    [3] => Friday Night|Fri Night|21 Oct|36.gif|Chance of showers|low|min: 3&deg;C|Chance of Precipitation|30%|
    [4] => Saturday|Sat|22 Oct|02.gif|A mix of sun and cloud|high|max: 11&deg;C|Chance of Precipitation||
    [5] => Saturday Night|Sat Night|22 Oct|32.gif|Cloudy periods|low|min: 6&deg;C|Chance of Precipitation||
    [6] => Sunday|Sun|23 Oct|02.gif|A mix of sun and cloud|high|max: 14&deg;C|Chance of Precipitation||
    [7] => Sunday Night|Sun Night|23 Oct|10.gif|Cloudy|low|min: 7&deg;C|Chance of Precipitation||
    [8] => Monday|Mon|24 Oct|02.gif|A mix of sun and cloud|high|max: 12&deg;C|Chance of Precipitation||
    [9] => Monday Night|Mon Night|24 Oct|32.gif|Cloudy periods|low|min: 2&deg;C|Chance of Precipitation||
    [10] => Tuesday|Tue|25 Oct|02.gif|A mix of sun and cloud|high|max: 9&deg;C|Chance of Precipitation||
    [11] => Tuesday Night|Tue Night|25 Oct|32.gif|Cloudy periods|low|min: 2&deg;C|Chance of Precipitation||
    [12] => Wednesday|Wed|26 Oct|02.gif|A mix of sun and cloud|high|max: 10&deg;C|Chance of Precipitation||
    [13] => |||||||||

)
*/

// now carve up the icon/conds/text one icon at a time
  $i=0;
  foreach ($rawFcst as $b => $rec) {
	//if(strlen($rec) < 30) { continue; }
	//Wednesday|Wed|26 Oct|02.gif|A mix of sun and cloud|high|max: 10&deg;C|Chance of Precipitation||
    list($tDay,$tDayS,$tDate,$tIcon,$tCond,$tHL,$tTemp,$tPOPTxt,$tPoP) = explode('|',$rec.'||||||');
	
	if (strlen($tPOPTxt) < 1) {	 continue; }
	
/* 

*/
// put it all together
// forecasticons for icon link and text
// forecasttemp for temperature (hi/low)
// forecastpop for Prob of Precipitation
// forecasttitles for legend (today, tonight or day of week)

   $forecastshortdayname[$i] = trim($tDay); // just the day name
   $forecastlongdayname[$i] = trim("$tDayS<br/>$tDate"); // day, date
   $forecasttitles[$i] = ($doIconDayDate)?$forecastlongdayname[$i]:$forecastshortdayname[$i];
   $forecasticonrealday[$i] = $forecastshortdayname[$i];
	 
   $forecasticon[$i] = $tIcon;
   $forecasttext[$i] = ucfirst($tCond);
   $forecastpop[$i] = $tPoP;
   $forecastpop[$i] = preg_replace('|[^\d]+|i','',$forecastpop[$i]);
	 // select PoP Icon if needed
   $forecasticon[$i] = ECF_replace_icon($forecasticon[$i],$forecastpop[$i]); 
	 //$forecasttempHigh[$i] = preg_replace('|[^\d\*\-]+|i','',$ptemp[2][3]);
	 //$forecasttempLow[$i] = preg_replace('|[^\d\*\-]+|i','',$ptemp[2][4]);
   $tTemp = ucfirst($tTemp);
   if(strpos($tTemp,'*') !== false) {
	   $tTemp = substr($tTemp,0,strpos($tTemp,'*'));
	   $tABN = '<b>*</b>';
   } else {
	   $tABN = '';
   }
   if($tHL == 'high') {
	   $forecasttemp[$i] = str_replace(' ',' <span style="color: #f00"><b>',$tTemp."</b></span>$tABN<br/>\n");
   } else {
	   $forecasttemp[$i] = str_replace(' ',' <span style="color: #00f"><b>',$tTemp."</b></span>$tABN<br/>\n");
   }
     $i++;
  } // end foreach loop for icon construction
} // end if fcsts

if(false and $doDebug) {
	//$Status .= "<!-- forecastshortdayname \n".print_r($forecastshortdayname,true)." -->\n";
	//$Status .= "<!-- forecastlongdayname \n".print_r($forecastlongdayname,true)." -->\n";
	$Status .= "<!-- forecasttitles \n".print_r($forecasttitles,true)." -->\n";
	$Status .= "<!-- forecasticon \n".print_r($forecasticon,true)." -->\n";
	$Status .= "<!-- forecastpop \n".print_r($forecastpop,true)." -->\n";
	$Status .= "<!-- forecasttemp \n".print_r($forecasttemp,true)." -->\n";
}


// calc the width percentage based on number of icons to display
$wdth = intval(100/(count($forecasticon)/2));
 	
//-----------------------------------------------------------------------------	

// Extract the text forecast details (new with V2.04 and EC site design change)
$startgrab = strpos($site,'wxo-detailedfore"');
$start = strpos($site , '<table', $startgrab+0); 
$finish = strpos($site , '</table>', $start) + 8;
$length = $finish-$start;
$code=Substr($site , $start, $length);
if($doDebug) { 
  $Status .= "<!-- forecast details area startgrab=$startgrab start=$start finish=$finish length=$length codelen=".strlen($code)." -->\n";
}

$t = $code;
$t = strip_tags($t,'<tr><td><strong><abbr>');
$t = preg_replace("|Hauteur|","Quantité",$t);  // Ray's correction
if($doDebug) { $Status .= "<!-- t(after)='$t' -->\n"; }

// slice up the text forecast days and summary text
preg_match_all('|<tr[^>]*>\s+<td([^>]*)>(.*?)</td>\s+<td>(.*?)</td>\s+</tr>|is', $t, $matches);

$forecastdetail = $matches[3];
foreach ($matches[2] as $k => $rec) {
	preg_match('|title="([^"]+)"|i',$rec,$tM);
	if(isset($tM[1])) {
		$forecastdays[$k] = trim($tM[1]);
	} else {
		$forecastdays[$k] = $forecastdays[$k-1] . ' ' . strtolower(trim($rec));
	}
}

if($doDebug) {$Status .= "<!-- text forecast matches \n" . print_r($matches,true) . "-->\n";}
/*
    [0] => Array
        (
            [0] => <tr class="pdg-btm-0">         <td>                     <strong title="Thursday">Today</strong>                   </td>         <td>Rain. Amount 10 to 15 mm. Wind becoming northeast 20 km/h gusting to 40 this afternoon. Temperature steady near 13.</td>        </tr>
            [1] => <tr class="pdg-tp-0">         <td>          <strong title="Thursday night">Tonight</strong>         </td>         <td>Periods of rain ending overnight then cloudy with 30 percent chance of showers. Amount 5 to 10 mm. Wind northeast 20 km/h gusting to 40. Low 8.</td>        </tr>
            [2] => <tr class="pdg-btm-0">         <td class="uniform_width">          <strong>           <abbr title="Friday">Fri</abbr>,Â 21Â <abbr title="October">Oct</abbr>          </strong>         </td>         <td>Cloudy with 30 percent chance of showers. Wind north 30 km/h gusting to 50. High 11.</td>        </tr>
            [3] => <tr class="pdg-tp-0">         <td class="uniform_width" title="Friday night"> Night</td>         <td>Cloudy periods. Low plus 3.</td>        </tr>
            [4] => <tr class="pdg-btm-0">         <td class="uniform_width">          <strong>           <abbr title="Saturday">Sat</abbr>,Â 22Â <abbr title="October">Oct</abbr>          </strong>         </td>         <td>A mix of sun and cloud. Windy. High 10.</td>        </tr>
            [5] => <tr class="pdg-tp-0">         <td class="uniform_width" title="Saturday night"> Night</td>         <td>Cloudy periods. Windy. Low plus 5.</td>        </tr>
            [6] => <tr class="pdg-btm-0">         <td class="uniform_width">          <strong>           <abbr title="Sunday">Sun</abbr>,Â 23Â <abbr title="October">Oct</abbr>          </strong>         </td>         <td>A mix of sun and cloud. Windy. High 14.</td>        </tr>
            [7] => <tr class="pdg-tp-0">         <td class="uniform_width" title="Sunday night"> Night</td>         <td>Cloudy periods. Low 7.</td>        </tr>
            [8] => <tr class="pdg-btm-0">         <td class="uniform_width">          <strong>           <abbr title="Monday">Mon</abbr>,Â 24Â <abbr title="October">Oct</abbr>          </strong>         </td>         <td>A mix of sun and cloud. High 11.</td>        </tr>
            [9] => <tr class="pdg-tp-0">         <td class="uniform_width" title="Monday night"> Night</td>         <td>Cloudy periods. Low plus 2.</td>        </tr>
            [10] => <tr class="pdg-btm-0">         <td class="uniform_width">          <strong>           <abbr title="Tuesday">Tue</abbr>,Â 25Â <abbr title="October">Oct</abbr>          </strong>         </td>         <td>A mix of sun and cloud. High 9.</td>        </tr>
            [11] => <tr class="pdg-tp-0">         <td class="uniform_width" title="Tuesday night"> Night</td>         <td>Cloudy periods. Low plus 2.</td>        </tr>
            [12] => <tr class="pdg-btm-0">         <td class="uniform_width">          <strong>           <abbr title="Wednesday">Wed</abbr>,Â 26Â <abbr title="October">Oct</abbr>          </strong>         </td>         <td>A mix of sun and cloud. High 9.</td>        </tr>
        )

    [1] => Array
        (
            [0] => 
            [1] => 
            [2] =>  class="uniform_width"
            [3] =>  class="uniform_width" title="Friday night"
            [4] =>  class="uniform_width"
            [5] =>  class="uniform_width" title="Saturday night"
            [6] =>  class="uniform_width"
            [7] =>  class="uniform_width" title="Sunday night"
            [8] =>  class="uniform_width"
            [9] =>  class="uniform_width" title="Monday night"
            [10] =>  class="uniform_width"
            [11] =>  class="uniform_width" title="Tuesday night"
            [12] =>  class="uniform_width"
        )

    [2] => Array
        (
            [0] =>                      <strong title="Thursday">Today</strong>                   
            [1] =>           <strong title="Thursday night">Tonight</strong>         
            [2] =>           <strong>           <abbr title="Friday">Fri</abbr>,Â 21Â <abbr title="October">Oct</abbr>          </strong>         
            [3] =>  Night
            [4] =>           <strong>           <abbr title="Saturday">Sat</abbr>,Â 22Â <abbr title="October">Oct</abbr>          </strong>         
            [5] =>  Night
            [6] =>           <strong>           <abbr title="Sunday">Sun</abbr>,Â 23Â <abbr title="October">Oct</abbr>          </strong>         
            [7] =>  Night
            [8] =>           <strong>           <abbr title="Monday">Mon</abbr>,Â 24Â <abbr title="October">Oct</abbr>          </strong>         
            [9] =>  Night
            [10] =>           <strong>           <abbr title="Tuesday">Tue</abbr>,Â 25Â <abbr title="October">Oct</abbr>          </strong>         
            [11] =>  Night
            [12] =>           <strong>           <abbr title="Wednesday">Wed</abbr>,Â 26Â <abbr title="October">Oct</abbr>          </strong>         
        )

    [3] => Array
        (
            [0] => Rain. Amount 10 to 15 mm. Wind becoming northeast 20 km/h gusting to 40 this afternoon. Temperature steady near 13.
            [1] => Periods of rain ending overnight then cloudy with 30 percent chance of showers. Amount 5 to 10 mm. Wind northeast 20 km/h gusting to 40. Low 8.
            [2] => Cloudy with 30 percent chance of showers. Wind north 30 km/h gusting to 50. High 11.
            [3] => Cloudy periods. Low plus 3.
            [4] => A mix of sun and cloud. Windy. High 10.
            [5] => Cloudy periods. Windy. Low plus 5.
            [6] => A mix of sun and cloud. Windy. High 14.
            [7] => Cloudy periods. Low 7.
            [8] => A mix of sun and cloud. High 11.
            [9] => Cloudy periods. Low plus 2.
            [10] => A mix of sun and cloud. High 9.
            [11] => Cloudy periods. Low plus 2.
            [12] => A mix of sun and cloud. High 9.
        )

)
*/

$forecasttemptxt = array();
$forecastrealday = array();
//<h3 class="h5"><span class="wb-inv">Detailed Forecast</span>Issued: 11:00 AM EDT Thursday 20 October 2016</h3>
preg_match_all('|<h3 class="h5"><span.*</span>([^<]+)</h3>|Ui',$site,$matches);
//  $Status .= "<!-- matches \n" . print_r($matches,true) . "-->\n";

$updated = $matches[1][0];

if($doIconv) {
   $updated = iconv($charsetInput,$charsetOutput.'//TRANSLIT',$updated);	
}

$weather7days = 'Extended Forecast';
//  if ($Lang == 'fr') {$weather7days = 'Pronostics étendus'; }
  if ($Lang == 'fr') {$weather7days = 'Prévisions'; }  
  
// now make the table
  $weather = '<div class="ECforecast">'."\n";
  $weather .= '<table class="ECtable">'."\n";
  $weather .= "<tr>\n";
  $weather .= '<td colspan="7" class="table-top">&nbsp;'.$weather7days." - $ECNAME</td>\n";
  $weather .= "</tr>\n";

  $weather .= "<tr>\n";
  
  $tweather = array();
  
  foreach ($forecasticon as $i => $v) {
	//if(isset($doIconDayDate) and !$doIconDayDate and isset($forecastlongdayname[$i])) {
	//	$forecasttitles[$i] = $forecastlongdayname[$i];
	//}
		
	if($doIconv) {
	   $forecasttitles[$i] = iconv($charsetInput,$charsetOutput.'//TRANSLIT',$forecasttitles[$i]);
	}
	$tweather[$i] = '<!-- '.$i.' --><td style="width: '.$wdth.'%; text-align: center; vertical-align: top;"><b>'.
	      $forecasttitles[$i]."</b>\n";
    $alttext = strip_tags($forecasttext[$i]);
    if ($forecastpop[$i] <> '') {
      $alttext .= " (" . $forecastpop[$i] ."%)";
    }
    $forecasticon[$i] = "    <img src=\"$imagedir" . $forecasticon[$i] . 
               "\"\n" .
               "     height=\"51\" width=\"60\" \n" . 
			   "     alt=\"$alttext\"\n" .
			   "     title=\"$alttext\" /> <br/>\n";
   $tweather[$i] .= "<br/>" . $forecasticon[$i] . "\n";
   $tweather[$i] .= "    " . $forecasttext[$i] . "<br/>\n";
   $tweather[$i] .= "    " . $forecasttemp[$i] . "\n";
   $tweather[$i] .= "  </td>\n";
   
   $forecast[$i] = $forecasttitles[$i] . "<br/>\n" .
                   $forecasticon[$i] . "<br/>\n" .
				   $forecasttext[$i] . "<br/>\n" .
				   $forecasttemp[$i] . "\n";

   }
   // now loop over the $tweather array to build the two table rows with icons
   
   if(strlen($rawFcst[0]) < 30) { $iStart = -1; } else { $iStart = 0; }
   
   for ($i=0;$i<=count($tweather);$i=$i+2) {
	   if(isset($tweather[$i+$iStart])) {
		   $weather .= $tweather[$i+$iStart];
	   } else {
		   $weather .= '<td style="width: '.$wdth.'%; text-align: center; vertical-align: top;">';
		   $weather .= "&nbsp;\n</td>\n";
	   }
   }
   
   $weather .= "</tr>\n<tr>\n";

   for ($i=1;$i<=count($tweather);$i=$i+2) {
	   if(isset($tweather[$i+$iStart])) {
		   $weather .= $tweather[$i+$iStart];
	   } else {
		   $weather .= '<td style="width: '.$wdth.'%; text-align: center; vertical-align: top;">';
		   $weather .= "&nbsp;\n</td>\n";
	   }
   }
   
   
   
  $weather .= "</tr>\n</table>\n";
  $weather .= "</div>\n\n";


//
// grab and slice alerts
$start = strpos($site , '<main role="main"');
$finish = strpos($site , '<div id="mainContent">', $start) + 8;
$length = $finish-$start;
$code=substr($site , $start, $length);
//$Status .= "<!-- code='$code' -->\n";

// find Forecast for <name>
preg_match_all('|<h1 id="wb-cont" property="name">(.*)</h1>|',$code,$matches);
// $Status .= "<!-- title matches".print_r($matches,true)." -->\n";
$title = '';
if(isset($matches[1][0])) {
	$title = trim(strip_tags($matches[1][0]));
	if($doIconv) {$title = iconv($charsetInput,$charsetOutput.'//TRANSLIT',$title); }
}
$Status .= "<!-- title='$title' -->\n";

// find watches/warnings/ended alerts
preg_match_all('!<div id="(watch|warning|statement)"[^>]*>(.*?)</div>!is',$code,$matches);
if($doDebug) {$Status .= "<!-- alert div matches\n" . print_r($matches,true) . "-->\n"; }
if (isset($matches[1])) {
  $alerttype = $matches[1];
  $alerts = $matches[2];
} else {
  $alerttype = array();
  $alerts = array();
}
if($doDebug) {
	$Status .= "<!-- alerttype\n" . print_r($alerttype,true) . "-->\n";
    $Status .= "<!-- alerts\n" . print_r($alerts,true) . "-->\n";
}

if (isset($alerts[0])) {
  foreach($alerts as $i => $testtext) {
    preg_match_all("'<h2>\s*<a href=\"(.*)\">([^<]+)</a>\s*</h2>'Uis",$testtext,$matches);
//     $Status .= "<!-- alert testtext matches\n" . print_r($matches,true) . "-->\n";
    $alertlinks[$i] = $matches[1];
    $alertlinkstext[$i] = $matches[2];
  }
} else {
  $alertlinks = array();
  $alertlinkstext = array();
}
if($doDebug) { 
   $Status .= "<!-- alertlinks\n" . print_r($alertlinks,true) . "-->\n";
   $Status .= "<!-- alertlinkstext\n" . print_r($alertlinkstext,true) . "-->\n";
}
// Alert testing parameters
//  $alertlinks = '1';
//  $alertlinkstext[0] = "This is an alert and this is where the thext of that alert would appear";

if (count($alertlinks) > 0) {

  $alertstyles = array(
    'warning' => 'color: white; background-color: #bb0000; border: 2px solid black;',
    'watch'   => 'color: black; background-color: #ffff00; border: 2px solid black;',
	'statement' => 'color: white; background-color: #707070; border: 2px solid black;',
    'ended'   => 'color: white; background-color: #339966; border: 2px solid black;'
  );

/* note: finish styling of alert links in your .css by adding:
 
.ECwarning a:link,
.ECstatement a:link,
.ECended a:link,
.ECended a:visited
{
	color:white !important;
}
.ECwarning a:hover,
.ECended a:hover {
	color:black !important;
}

.ECwarning a:visited,
.ECstatement a:visited
{
	color:white !important;
}

.ECwatch a:link,
.ECwatch a:visited
{
	color:black !important;
}

.ECstatement a:hover,
.ECwatch a:hover {
	color:red !important;
}

*/
  $ECURLPARTS = parse_url($ECURL);
  $ECHOST = $ECURLPARTS['host'];
  $alertstring = '';
  foreach ($alerttype as $i => $atype) { 
    $alertstring .= '<p class="ECforecast EC'.$atype.'" 
    style="'.$alertstyles[$atype].' padding: 5px;text-align: center;">'."\n";
	
    foreach ($alertlinks[$i] as $g => $alks ) {
	  if($doIconv) { 
	    $alertlinkstext[$i][$g] = 
		   iconv($charsetInput,$charsetOutput.'//TRANSLIT',$alertlinkstext[$i][$g]);
	  }

      $alertstring .= '<b><a ' . $LINKtarget . 
	  ' href="http://' . $ECHOST . $alertlinks[$i][$g] . '">  ' . $alertlinkstext[$i][$g] . '  </a></b><br/>'."\n";
    }
    $alertstring .= "</p><!-- finished for type='$atype' alerts -->\n";
  }
  
} else {
  $alertstring = '';
}
// ---- end of alerts mods---

// convert character set if needed
if($doIconv) { 
  for ($g=0;$g < count($forecastdays);$g++) {
	   
     $forecastdays[$g] = iconv($charsetInput,$charsetOutput.'//TRANSLIT',$forecastdays[$g]);
	 //$Status .= "<!-- in  forecastdetail[$g]='".$forecastdetail[$g]."' -->\n";
	 $forecastdetail[$g] = preg_replace('|é|s','Ã©',$forecastdetail[$g]); // fix weird ISO-8859-1 character in UTF-8 string
	 $trans = iconv($charsetInput,$charsetOutput.'//TRANSLIT',$forecastdetail[$g]);
	 $forecastdetail[$g] = (empty($trans))?$forecastdetail[$g]:$trans;	
	 //$Status .= "<!-- out forecastdetail[$g]='".$forecastdetail[$g]."' -->\n";
   }
}


$textfcsthead = $ECHEAD;
// assemble the text forecast as a definition list
$textforecast = '<div class="ECforecast"><h2>'.$textfcsthead.'</h2>'."\n<h5>$title ($updated)</h5>\n<dl>\n";

if($doDebug) {
	$Status .= "<!-- forecastdays\n".print_r($forecastdays,true)." -->\n";
	$Status .= "<!-- forecastdetail\n".print_r($forecastdetail,true)." -->\n";
}

for ($g=0;$g < count($forecastdays);$g++) {
   $textforecast .= "  <dt><b>" . $forecastdays[$g] ."</b></dt>\n";
   $textforecast .= "  <dd>" . $forecastdetail[$g] . "</dd>\n";
}
$textforecast .= "</dl>\n";
$textforecast .= "</div>\n";

// print it out:
if ($printIt and  ! $doInclude ) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charsetOutput; ?>" />
<title><?php print "$ECHEAD - $ECNAME"; ?></title>
<style type="text/css">
/* styling for EC alert boxes */ 
.ECwarning a:link,
.ECstatement a:link,
.ECended a:link,
.ECended a:visited
{
	color:white !important;
}
.ECwarning a:hover,
.ECended a:hover {
	color:black !important;
}

.ECwarning a:visited,
.ECstatement a:visited
{
	color:white !important;
}

.ECwatch a:link,
.ECwatch a:visited
{
	color:black !important;
}

.ECstatement a:hover,
.ECwatch a:hover {
	color:red !important;
}
</style>
</head>
<body>
<?php 
}
if ($printIt) {
  $ECURL = preg_replace('|&|Ui','and',$ECURL); // make link XHTML compatible
  print $Status;
  print $alertstring;
  print $ddMenu;
  if ($showConditions) {
	print "<table border=\"0\" width=\"99%\"><tr><td align=\"center\">\n";
    print $currentConditions;
	print "</td></tr></table>\n";
  }
  print $weather;
  if ($foundAbnormal > 0) {print $abnormalString; }
  print $textforecast;
  print "<p><a $LINKtarget href=\"$ECURL\">$ECNAME</a></p>\n";
}
if ($printIt  and ! $doInclude ) {?>
</body>
</html>
<?php
}

// ----------------------------functions ----------------------------------- 
    
function ECF_replace_icon($icon,$pop) {
// now replace icon with spiffy updated icons with embedded PoP to
//    spruce up the dull ones from www.weatheroffice.ec.gc.ca 
  global $imagedir,$iconType;
			  
  $curicon = $icon;
  if ($pop > 0) {
	$testicon = preg_replace("|.gif|","p$pop$iconType",$curicon);
	if (file_exists("$imagedir/$testicon")) {
	  $newicon = $testicon;
	} else {
	  $newicon = $curicon;
	}
  } else {
	$newicon = $curicon;
  }
  $newicon = preg_replace("|.gif|",$iconType,$newicon); // support other icon types
  return($newicon);  
}

// ------------------------------------------------------------------
// get contents from one URL and return as string 
 function ECF_fetch_URL($url,$useFopen) {
  global $Status, $needCookie;
  $overall_start = time();
  if (! $useFopen) {
   // Set maximum number of seconds (can have floating-point) to wait for feed before displaying page without feed
   $numberOfSeconds=4;   

// Thanks to Curly from ricksturf.com for the cURL fetch functions

  $data = '';
  $domain = parse_url($url,PHP_URL_HOST);
  $theURL = str_replace('nocache','?'.$overall_start,$url);        // add cache-buster to URL if needed
  $Status .= "<!-- curl fetching '$theURL' -->\n";
  $ch = curl_init();                                           // initialize a cURL session
  curl_setopt($ch, CURLOPT_URL, $theURL);                         // connect to provided URL
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                 // don't verify peer certificate
  curl_setopt($ch, CURLOPT_USERAGENT, 
    'Mozilla/5.0 (ec-forecast.php - saratoga-weather.org)');
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $numberOfSeconds);  //  connection timeout
  curl_setopt($ch, CURLOPT_TIMEOUT, $numberOfSeconds);         //  data timeout
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);              // return the data transfer
  curl_setopt($ch, CURLOPT_NOBODY, false);                     // set nobody
  curl_setopt($ch, CURLOPT_HEADER, true);                      // include header information
  if (isset($needCookie[$domain])) {
    curl_setopt($ch, $needCookie[$domain]);                    // set the cookie for this request
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);             // and ignore prior cookies
    $Status .=  "<!-- cookie used '" . $needCookie[$domain] . "' for GET to $domain -->\n";
  }

  $data = curl_exec($ch);                                      // execute session

  if(curl_error($ch) <> '') {                                  // IF there is an error
   $Status .= "<!-- Error: ". curl_error($ch) ." -->\n";        //  display error notice
  }
  $cinfo = curl_getinfo($ch);                                  // get info on curl exec.
/*
curl info sample
Array
(
[url] => http://saratoga-weather.net/clientraw.txt
[content_type] => text/plain
[http_code] => 200
[header_size] => 266
[request_size] => 141
[filetime] => -1
[ssl_verify_result] => 0
[redirect_count] => 0
  [total_time] => 0.125
  [namelookup_time] => 0.016
  [connect_time] => 0.063
[pretransfer_time] => 0.063
[size_upload] => 0
[size_download] => 758
[speed_download] => 6064
[speed_upload] => 0
[download_content_length] => 758
[upload_content_length] => -1
  [starttransfer_time] => 0.125
[redirect_time] => 0
[redirect_url] =>
[primary_ip] => 74.208.149.102
[certinfo] => Array
(
)

[primary_port] => 80
[local_ip] => 192.168.1.104
[local_port] => 54156
)
*/
  $Status .= "<!-- HTTP stats: " .
    " RC=".$cinfo['http_code'] .
    " dest=".$cinfo['primary_ip'] . 
	" port=".$cinfo['primary_port'] ;
	if(isset($cinfo['local_ip'])) {
	  $Status .= " (from sce=" . $cinfo['local_ip'] . ")";
	}
	$Status .= 
	"\n      Times:" .
    " dns=".sprintf("%01.3f",round($cinfo['namelookup_time'],3)).
    " conn=".sprintf("%01.3f",round($cinfo['connect_time'],3)).
    " pxfer=".sprintf("%01.3f",round($cinfo['pretransfer_time'],3));
	if($cinfo['total_time'] - $cinfo['pretransfer_time'] > 0.0000) {
	  $Status .=
	  " get=". sprintf("%01.3f",round($cinfo['total_time'] - $cinfo['pretransfer_time'],3));
	}
    $Status .= " total=".sprintf("%01.3f",round($cinfo['total_time'],3)) .
    " secs -->\n";

  //$Status .= "<!-- curl info\n".print_r($cinfo,true)." -->\n";
  curl_close($ch);                                              // close the cURL session
  //$Status .= "<!-- raw data\n".$data."\n -->\n"; 
  $i = strpos($data,"\r\n\r\n");
  $headers = substr($data,0,$i);
  $content = substr($data,$i+4);
  $Status .= "<!-- headers:\n".$headers."\n -->\n";  
  return $data;                                                 // return headers+contents

 } else {
//   print "<!-- using file_get_contents function -->\n";
   $STRopts = array(
	  'http'=>array(
	  'method'=>"GET",
	  'protocol_version' => 1.1,
	  'header'=>"Cache-Control: no-cache, must-revalidate\r\n" .
				"Cache-control: max-age=0\r\n" .
				"Connection: close\r\n" .
				"User-agent: Mozilla/5.0 (ec-forecast.php - saratoga-weather.org)\r\n" .
				"Accept: text/plain,text/html\r\n"
	  ),
	  'https'=>array(
	  'method'=>"GET",
	  'protocol_version' => 1.1,
	  'header'=>"Cache-Control: no-cache, must-revalidate\r\n" .
				"Cache-control: max-age=0\r\n" .
				"Connection: close\r\n" .
				"User-agent: Mozilla/5.0 (ec-forecast.php - saratoga-weather.org)\r\n" .
				"Accept: text/plain,text/html\r\n"
	  )
	);
	
   $STRcontext = stream_context_create($STRopts);

   $T_start = ECF_fetch_microtime();
   $xml = file_get_contents($url,false,$STRcontext);
   $T_close = ECF_fetch_microtime();
   $headerarray = get_headers($url,0);
   $theaders = join("\r\n",$headerarray);
   $xml = $theaders . "\r\n\r\n" . $xml;

   $ms_total = sprintf("%01.3f",round($T_close - $T_start,3)); 
   $Status .= "<!-- file_get_contents() stats: total=$ms_total secs -->\n";
   $Status .= "<-- get_headers returns\n".$theaders."\n -->\n";
//   print " file() stats: total=$ms_total secs.\n";
   $overall_end = time();
   $overall_elapsed =   $overall_end - $overall_start;
   $Status .= "<!-- fetch function elapsed= $overall_elapsed secs. -->\n"; 
//   print "fetch function elapsed= $overall_elapsed secs.\n"; 
   return($xml);
 }

}    // end ECF_fetch_URL

// ------------------------------------------------------------------

function ECF_fetch_microtime()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

?>