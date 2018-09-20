<?php
############################################################################
# A Project of TNET Services, Inc. and Saratoga-Weather.org (Canada template set)
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
require_once("Settings.php");
require_once("common.php");
############################################################################
$TITLE = langtransstr($SITE['organ']) . " - " .langtransstr('Home');
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
	<div class="column-dark">
		<div align="center">
			<?php 
			// fetch fresh national radar image if needed .. you can chang it to
			// 'NAT' = National radar view
			// 'PAC' = Pacific region
			// 'WRN' = Praries region
			// 'ONT' = Ontario
			// 'QUE' = Quebec
			// 'ERN' = Atlantic region
			  $_REQUEST['site'] = 'NAT'; // one of the sites above, or your radar designator
			  $doPrint = false;
			  include_once("ec-radar.php");
			?>
			<img src="<?php echo $radarDir . 'radar-' . $_REQUEST['site'] . '-0.png'; ?>" 
			alt="Radar, courtesy of Environment Canada"
			title="Radar, courtesy of Environment Canada" /> 
		</div><!-- end align center -->
	</div><!-- end column-dark -->
<div class="column-dark">
	<img src="<?php echo $SITE['imagesDir']; ?>spacer.gif" alt="spacer"
	height="2" width="620" style="padding:0; margin:0; border: none" />
	<div align="center">
	<?php if(isset($SITE['ajaxDashboard']) and file_exists($SITE['ajaxDashboard']))
	 { include_once($SITE['ajaxDashboard']);
	   } else {
		print "<p>&nbsp;</p>\n";
		print "<p>&nbsp;</p>\n";
		print "<p>Note: ajax-dashboard not included since weather station not yet specified.</p>\n";
        for ($i=0;$i<10;$i++) { print "<p>&nbsp;</p>\n"; }
	}?>
	</div>
</div><!-- end column-dark -->

</div><!-- end main-copy -->

<?php
############################################################################
include("footer.php");
############################################################################
# End of Page
############################################################################
?>