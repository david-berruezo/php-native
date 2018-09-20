<?php
############################################################################
# A Project of TNET Services, Inc. and Saratoga-Weather.org (Canada-ML template set)
############################################################################
#
#	Project:	Sample Included Website Design
#	Module:		Settings.php
#	Purpose:	Provides the Site Settings Used Throughout the Site
# 	Authors:	Kevin W. Reed <kreed@tnet.com>
#				TNET Services, Inc.
#
# 	Copyright:	(c) 1992-2007 Copyright TNET Services, Inc.
############################################################################
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA
############################################################################
#	This document uses Tab 4 Settings
############################################################################
// Version 1.01 - 01-Oct-2011 - added support for animated condition/forecast icons
// Version 1.02 - 12-May-2013 - added support for ec-forecast V2.16+ settings
// Version 1.03 - 15-Oct-2016 - added support for ec-lightning V1.00 setting
$SITE 			= array();

############################################################################
# Sitewide configuration - website style and features
############################################################################

$SITE['CSSscreen']		= 'weather-screen-blue-narrow.css'; // Default screen 800px design
//   Note: $SITE['CSSscreen'] will be overridden if the Theme Switch (below) is enabled.
//   To lock your site to use only one CSS as specified in $SITE['CSSscreen'], just
//   turn off the Theme Switcher.
$SITE['CSSprint']		= 'weather-print-php.css';
#
#$SITE['CSSscreen']		= 'weather-screen.css'; // Classic design
#$SITE['CSSprint']		= 'weather-print.css';

# Mike Challis' Theme Switch configuration
$SITE['allowThemeSwitch']   = true;  // set to false to disable the use of Theme Switcher 
$SITE['CSSscreenDefault'] = 'weather-screen-blue.css'; // leave -narrow or -wide off this .. just change color here
$SITE['CSSwideOrNarrowDefault'] = 'narrow'; // 'narrow' or 'wide'
# CSSsettings_mode
# sets allowable user style select options:
# 1 user can select style and screen width (show style select and screen width select)
# 2 user can select styles only (hide screen width select)
# 3 user can select screen width only (hide style select)
$SITE['CSSsettings_mode'] = 1;  // set to 1, 2 or 3

$SITE['flyoutmenu'] = true; // set to false to use the menu list inside menubar.php instead

$SITE['charset']		= 'ISO-8859-1'; // default character set for webpages (iso-8859-1=latin)
#
# Multilanguage support 
#
$SITE['lang'] = 'en';                // default language for website to use
$SITE['allowLanguageSelect'] = true; // set to false to disable the use of language selector
$SITE['useLanguageFlags'] = true;    // true=show flags, false=show language 2-char abbreviations
$SITE['languageSelectDropdown'] = true; // true=show dropdown list for languages, false=show linear flags list
$SITE['languageSelectButton'] = false;  // true=show 'Set' button for language select, false=use onchange to submit
$SITE['langavail'] = array('en',     // select languages to offer here.
// array('en', should be first entry on line above
// other languages with the Canada set can be enabled by installing language packs
//  'af',  // afrikaans
//  'ct', // 'catalan',
//  'dk', // 'danish',
//  'nl', // 'dutch',
//  'fi', // 'finnish',
  'fr', // 'french',
//  'de', // 'german',
//  'el', // 'greek',
//  'it', // 'italian',
//  'no', // 'norwegian',
//  'pl', // 'polish',
// 'pt', // 'portuguese',
//  'es', // 'spanish',
//  'se', // 'swedish',
);
// if your software uploads almanac dates using a language OTHER THAN English, please put the month
// names in your language to replace the English ones below.  This is used primarily by the
// wxastronomy.php page for the local dates of moon phases, solistices, and equinoxes
$SITE['monthNames'] = array(  // for wxastronomy page .. replace with month names in your language 
'January','February','March','April','May','June',
'July','August','September','October','November','December'
);
// example:
//$SITE['monthNames'] = array(  // French for wxastronomy page .. replace with month names in your language
// "janvier","février","mars","avril","mai","juin",
// 	"juillet","août","septembre","octobre","novembre","décembre"
//);

############################################################################
# Sitewide configuration - Station location, identity and date/time info
############################################################################

$SITE['organ']			= 'Canada Multilingual Website with PHP &amp; AJAX';
$SITE['copyr']			= '&copy; ' . gmdate("Y",time()) . ', Your Weather Website';
$SITE['location']       = 'Somewhere, Some Province, Canada';
$SITE['email']			= 'mailto:somebody@somemail.org';
# Station location: latitude, longitude, cityname
$SITE['latitude']		= '37.27153397';    //North=positive, South=negative decimal degrees
$SITE['longitude']		= '-122.02274323';  //East=positive, West=negative decimal degrees
$SITE['cityname']		= 'Saratoga';

$SITE['tz'] 			= 'America/Los_Angeles'; //NOTE: this *MUST* be set correctly to
// translate UTC times to your LOCAL time for the displays.
//  http://us.php.net/manual/en/timezones.php  has the list of timezone names
//  pick the one that is closest to your location and put in $SITE['tz'] like:
//    $SITE['tz'] = 'America/Los_Angeles';  // or
//    $SITE['tz'] = 'Europe/Brussels';
// note: date format used for PHP parts only.  Weather software dates are not processed
// except on the astronomy page
// $SITE['timeFormat'] = 'D, d-M-Y g:ia T';  // Day, 31-Mar-2006 6:35pm Tz  (USA Style)
// $SITE['timeFormat'] = 'm/d/Y g:ia';      // USA  format 03/31/2006 14:03
$SITE['timeFormat'] = 'd/m/Y H:i';       // Euro format 31/03/2006 14:03
// $SITE['timeFormat'] = 'Y-m-d H:i';       // ISO  format 2006-03-31 14:03

// $SITE['timeOnlyFormat'] = 'g:ia';          // USA format h:mm[am|pm\
$SITE['timeOnlyFormat'] = 'H:i';          // Euro format hh:mm  (hh=00..23);
$SITE['dateOnlyFormat'] = 'd/m/Y';        // for 31-Mar-2008 or 'j/n/Y' for Euro format

############################################################################
# Sitewide configuration - support scripts configuration
############################################################################

###########################################################################
# These values should reflect the units-of-measure your weather station
# uses to report the weather data when processing weather tags.
# Note: if you change them here, make sure to make the corresponding
#   changes in the ajax[WXname]wx.js AJAX script also.
###########################################################################
// Canada Settings 
$SITE['WDdateMDY'] = false; // for weather software date format of month/day/year.  =false for day/month/year
$SITE['uomTemp'] = '&deg;C';  // ='&deg;C', ='&deg;F'
$SITE['uomBaro'] = ' hPa';    // =' hPa', =' mb', =' inHg'
$SITE['uomWind'] = ' km/h';   // =' km/h', =' kts', =' m/s', =' mph'
$SITE['uomRain'] = ' mm';     // =' mm', =' in'
$SITE['uomSnow'] = ' cm';     // =' cm', =' in'
$SITE['uomDistance'] = ' km';  // or ' miles' -- used for Wind Run display
$SITE['uomPerHour'] = '/hr';
//
$SITE['imagesDir'] = './ajax-images/';  // directory for ajax-images with trailing slash
// 
$SITE['cacheFileDir']   =  './cache/';   // directory to use for scripts cache files .. use './' for doc.root.dir
// 
$SITE['UVscript']		= 'get-UV-forecast-inc.php'; // worldwide forecast script for UV Index
//	comment out above line to exclude UV forecast from dashboard, gizmo and wxuvforecast.php page
//
// if you have WXSIM installed set $SITE['WXSIM'] = true; otherwise set it to false
$SITE['WXSIM']			= true;  // Set to false if you have not installed WXSIM
$SITE['WXSIMscript'] 	= 'plaintext-parser.php'; // script for decoding plaintext.txt into icons
$SITE['defaultlang']	= 'en';   // 'en' for English (WXSIM plaintext-parser.php)

# fcsturlEC is for Environment Canada forecast (ec-forecast.php)
$SITE['fcsturlEC']		= 'http://weatheroffice.gc.ca/city/pages/on-107_metric_e.html';
 
$SITE['fcsticonsdir'] = './forecast/images/'; // NOAA-style icons for NWS, WU, WXSIM forecast scripts
$SITE['fcsticonstype']= '.jpg'; // default type='.jpg' -- use '.gif' for animated icons from http://www.meteotreviglio.com/
$SITE['fcsticonsdirEC'] = './ec-icons/';      // EC forecast icons for Canada (ec-forecast.php)
//
# --- new settings with ec-forecast.php V2.16+
$SITE['ECiconDayDate'] = false;        // =false; Icon names = day of week. =true; icon names as Day dd Mon
$SITE['ECdetailDayDate'] = false;      // =false; for day name only, =true; detail day as name, nn mon. 
$SITE['ECiconType'] = '.gif';            // ='.gif' or ='.png' for ec-icons file type 
// Note: for .png, make sure you have installed the PNG icons in the $SITE['fcsticonsdirEC'] directory
//
// The optional multi-city forecast .. make sure the first entry is for the $SITE['fcsturlEC'] location
//*
$SITE['ECforecasts'] = array(
 // Location|forecast-URL  (separated by | character)
'St. Catharines, ON|http://weather.gc.ca/city/pages/on-107_metric_e.html', // St. Catharines, ON
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
); 

//*/ 
# --- end of new settings with ec-forecast.php V2.16+
 
// in the following section, enable settings for ONE primary forecast organization
// pick which script AND org are to be used for your forecast here: (last uncommented pair will
// be the ones used on the wxforecast.php page and in your dashboard

$SITE['fcstscript']   = 'ec-forecast.php';    // Canada forecasts from Environment Canada
$SITE['fcstorg']		= 'EC';    // set to 'EC' for Environment Canada

// Uncomment the two lines below to use WXSIM as the ONLY forecast script to use
// $SITE['fcstscript']	= 'plaintext-parser.php';    // WXSIM forecast (if only forecast script)
// $SITE['fcstorg']		= 'WXSIM';    // set to 'WXSIM' for WXSIM forecast

// radar settings for wxradar.php page
$SITE['ecradar']    = 'WKR';  // set to default Site for ec-radar (same as id=xxx on EC website)
//                               set to 'NAT' for Canada national composite map

# new setting with ec-lightning.php V1.00
$SITE['eclightningID'] = 'ONT'; // set to default Site for lightning (same as id=xxx on EC website)
//                              // available sites: NAT ARC PAC WRN ONT QUE ATL

##########################################################################
# end of configurable settings
##########################################################################
#
# Multilanguage support constants - please do NOT change the settings below
#DO NOT CHANGE THESE SETTINGS
$SITE['installedLanguages'] = array (
  'af' => 'Afrikaans',
  'bg' => '&#1073;&#1098;&#1083;&#1075;&#1072;&#1088;&#1089;&#1082;&#1080; &#1077;&#1079;&#1080;&#1082;',
  'ct' => 'Catal&agrave;',
  'dk' => 'Dansk',
  'nl' => 'Nederlands',
  'en' => 'English',
  'fi' => 'Suomi',
  'fr' => 'Fran&ccedil;ais',
  'de' => 'Deutsch',
  'el' => '&Epsilon;&lambda;&lambda;&eta;&nu;&iota;&kappa;&#940;',
  'ga' => 'Gaeilge',
  'hu' => 'Magyar',
  'it' => 'Italiano',
  'no' => 'Norsk',
  'pl' => 'Polski',
  'pt' => 'Portugu&ecirc;s',
  'ro' => 'limba rom&#00226;n&#00259;',
  'es' => 'Espa&ntilde;ol',
  'se' => 'Svenska',
);
# DO NOT CHANGE THESE SETTINGS
$SITE['ISOLang'] = array ( // ISO 639-1 2-character language abbreviations from country domain 
  'af' => 'af',
  'bg' => 'bg',
  'ct' => 'ca',
  'dk' => 'da',
  'nl' => 'nl',
  'en' => 'en',
  'fi' => 'fi',
  'fr' => 'fr',
  'de' => 'de',
  'el' => 'el',
  'ga' => 'ga',
  'it' => 'it',
  'hu' => 'hu',
  'no' => 'no',
  'pl' => 'pl',
  'pt' => 'pt',
  'ro' => 'ro',
  'es' => 'es',
  'se' => 'sv',
);
# DO NOT CHANGE THESE SETTINGS
$SITE['langCharset'] = array( // for languages that DON'T use ISO-8859-1 (latin) set
 'bg' => 'ISO-8859-5',
 'el' => 'ISO-8859-7',
 'hu' => 'ISO-8859-2',
 'ro' => 'ISO-8859-2',
 'pl' => 'ISO-8859-2',
 'ru' => 'UTF-8',
 'gr' => 'UTF-8'
);
# DO NOT CHANGE THESE SETTINGS
$SITE['WULanguages'] = array ( // for WeatherUnderground forecast supported languages
  'af' => 'afrikaans',
  'bg' => 'bulgarian',
  'ct' => 'catalan',
  'dk' => 'danish',
  'nl' => 'dutch',
  'en' => 'english',
  'fi' => 'finnish',
  'fr' => 'french',
  'de' => 'deutsch',
  'el' => 'greek',
  'ga' => 'gaelic',
  'hu' => 'hungarian',
  'it' => 'italian',
  'no' => 'norwegian',
  'pl' => 'polish',
  'pt' => 'portuguese',
  'ro' => 'romanian',
  'es' => 'espanol',
  'se' => 'swedish',
);
# End - multilanguage support constants
# Now prune the installedLanguages based on langavail selection
$tarray = array(); 
foreach ($SITE['langavail'] as $n => $k) {
  if(isset($SITE['installedLanguages'][$k])) {
    $tarray[$k] = $SITE['installedLanguages'][$k];
  }
}
$SITE['installedLanguages'] = $tarray;
# end prune the installedLanguages based on langavail selection
#
# set the Timezone abbreviation automatically based on $SITE['tzname'];
# Set timezone in PHP5/PHP4 manner
  if (!function_exists('date_default_timezone_set')) {
	 putenv("TZ=" . $SITE['tz']);
//	 print "<!-- using putenv(\"TZ=". $SITE['tz']. "\") -->\n";
    } else {
	 date_default_timezone_set($SITE['tz']);
//	 print "<!-- using date_default_timezone_set(\"". $SITE['tz']. "\") -->\n";
   }

$SITE['tzname']	= date("T",time());
if($SITE['allowThemeSwitch']) {
  # begin Color Theme Switcher Plugin by Mike Challis
  # http://www.642weather.com/weather/scripts.php
  include_once('include-style-switcher.php');
  $SITE['CSSscreen'] = validate_style_choice();
  # end Color Theme Switcher Plugin
} else {
  session_start(); // for preservation of language settings.
  if ($SITE['CSSwideOrNarrowDefault'] == 'wide') {
          $_SESSION['CSSwidescreen'] = 1;
          $CSSstyle = str_replace ('.css','-wide.css',$SITE['CSSscreenDefault']);
  } else {
          $_SESSION['CSSwidescreen'] = 0;
          $CSSstyle = str_replace ('.css','-narrow.css',$SITE['CSSscreenDefault']);
  }
  $SITE['CSSscreen'] = $CSSstyle;
}
# Automatic Info we might need
############################################################################
if(isset($_SERVER['REMOTE_ADDR']))   {$SITE['REMOTE_ADDR']	= $_SERVER['REMOTE_ADDR'];}
if(isset($_SERVER['REMOTE_HOST']))   {$SITE['REMOTE_HOST']	= $_SERVER['REMOTE_HOST'];}
if(isset($_SERVER['DOCUMENT_ROOT'])) {$SITE['WEBROOT']		= $_SERVER['DOCUMENT_ROOT'];}
if(isset($_SERVER['REQUEST_URI']))   {$SITE['REQURI']		= $_SERVER['REQUEST_URI'];}
if(isset($_SERVER['SERVER_NAME']))   {$SITE['SERVERNAME']	= $_SERVER['SERVER_NAME'];}
$SITE['remote']			= "onclick=\"window.open(this.href,'_blank');return false;\"";
$SITE['PHPversion'] = phpversion();
// default settings needed for various pages when the weather software plugin is not installed.
// do not change these
$SITE['WXsoftwareURL'] = '#';
$SITE['WXsoftwareLongName'] = '(unspecified)';
$SITE['WXtags'] = '';
# now fetch the weather software settings if it exists
if(isset($_REQUEST['wx']) and file_exists('Settings-weather-'.strtoupper($_REQUEST['wx']).'.php')) {
	include_once('Settings-weather-'.strtoupper($_REQUEST['wx']).'.php');
} elseif(file_exists("Settings-weather.php")) { 
    include_once("Settings-weather.php"); 
}
?>