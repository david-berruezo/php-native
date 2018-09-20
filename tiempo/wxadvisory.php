<?php
############################################################################
# A Project of TNET Services, Inc. and Saratoga-Weather.org (WD-Canada-ML template set)
############################################################################
#
#   Project:    Sample Included Website Design
#   Module:     sample.php
#   Purpose:    Sample Page
#   Authors:    Kevin W. Reed <kreed@tnet.com>
#               TNET Services, Inc.
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
// Version 1.01 - 18-Apr-2013 - fixes for new EC website design
// Version 1.02 - 06-Jul-2013 - fix for all-Canada warnings image display
require_once("Settings.php");
require_once("common.php");
############################################################################
$TITLE= $SITE['organ'] . " - Watches/Warnings/Advisories";
$showGizmo = true;  // set to false to exclude the gizmo
include("top.php");
############################################################################
?>
<style type="text/css">
/* styling for EC alert boxes */ 
.ECwarning a:link,
.ECended a:link,
.ECended a:visited
{
	color:white;
}
.ECwarning a:hover,
.ECended a:hover {
	color:black !important;
}

.ECwarning a:visited
{
	color:white;
}

.ECwatch a:link,
.ECwatch a:visited
{
	color:black;
}

.ECwatch a:hover {
	color:red;
}
</style>
</head>
<body>
<?php
############################################################################
include("header.php");
############################################################################
include("menubar.php");
############################################################################
?>

<div id="main-copy">
  
  
  <div align="center">       
	<?php 
		 $doInclude	   = true; // handle ec-forecast and WXSIM include also
		 $doPrint	   = false; //  ec-forecast.php setting
		 include_once($SITE['fcstscript']);
		 if ($alertstring <> '') { 
		 print $alertstring; // will produce alert box with link if advisories found
		 } else { 
		 print "<p class=\"advisoryBox\">".langtransstr("No watches or warnings in effect for")." $title.</p>\n"; 
		 }
	?>
<?php 
if(preg_match('|narrow|',$SITE['CSSscreen'])) {
	$wtext = 'width="610" height="523"'; 
} else {
	$wtext = 'width="852" height="731"'; 
}
if($SITE['lang'] == 'fr') {$L = 'f'; } else {$L = 'e'; } ?>
<a href="http://weather.gc.ca/warnings/index_<?php echo $L; ?>.html" style="border: none">
<img src="http://weather.gc.ca/data/download/canada_<?php echo $L; ?>.png" style="border:none;" <?php echo $wtext; ?> alt="national advisories"/></a>
<?php if($SITE['lang'] == 'fr') { $legend = 'CanadaLegend-fr.gif'; } else { $legend = 'CanadaLegend-en.gif'; } ?>
<img src="<?php echo $legend;?>" alt="National Advisory Legend" title="National Advisory Legend"/>
<?php print "<p><a href=\"$ECURL\">$ECNAME</a></p>\n"; ?>
  </div>
  
  
</div><!-- end main-copy -->

<?php
############################################################################
include("footer.php");
############################################################################
# End of Page
############################################################################
?>