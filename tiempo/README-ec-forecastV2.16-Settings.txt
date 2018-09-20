This note shows how the ec-forecast.php V2.16+ can be configured in your template Settings.php file.

ec-forecast.php V2.16 includes the following changes:
* settings to control display of dates with day names
* ability to use new transparent PNG icons in place of the older GIF icons
* improved diagnostics for HTTP fetch from weather.gc.ca website, and built-in retry for a 30x redirect
* multiple forecast locations with drop-down control selector
* support for cache files in the $SITE['CacheFileDir'] location

You can install the V2.16+ version to directly replace your older version in the template with no additional
configuration necessary.  If you would like to enable the newer features (like day/date, PNG icons, multiple
forecast locations) then copy the following to your template Settings.php and make the configuration changes
you desire.

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
