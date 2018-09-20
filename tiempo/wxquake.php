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
// Version 1.01 - 07-Jul-2013 - fixed links for new EC website design
require_once("Settings.php");
require_once("common.php");
############################################################################
$TITLE= $SITE['organ'] . " - Earthquakes";
$showGizmo = true;  // set to false to exclude the gizmo
include("top.php");
############################################################################
?>
<style type="text/css">
.quake {
  width: 640px;
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
  $doIncludeQuake = true;
  include_once("quake-Canada.php");
  if ($SITE['lang'] == 'fr') {$LC = 'fra'; } else {$LC = 'eng'; } 
?>
  <h2><?php echo $LC=='fra'?
  "le Canada Séismes des derniers 30 jours":"Canada Earthquakes of the last 30 days"; ?></h2>
 <p><a href="http://earthquakescanada.nrcan.gc.ca/recent_eq/maps/index-<?php echo $LC; ?>.php?tpl_region=canada"
   title="Click to visit Natural Resource Canada website">
   <img src="http://earthquakescanada.nrcan.gc.ca/recent_eq/maps/images/canada_e30d.jpg" 
   alt="Last 30 days Canadian Earthquake activity"
  width="431" height="366" style="border: none;"/></a><br/>
  <img src="http://earthquakescanada.nrcan.gc.ca/recent_eq/maps/images/eqlegend_<?php echo substr($LC,0,1); ?>.jpg" 
  height="66" width="434" alt="Earthquake map legend" /></p>
  <p><a href="http://earthquakescanada.nrcan.gc.ca/recent_eq/maps/index-<?php echo $LC; ?>.php?tpl_region=canada">
  <?php echo $LC=='fra'?"Ressources naturelles Canada":"Natural Resources Canada"; ?></a></p>
 </div>
</div><!-- end main-copy -->

<?php
############################################################################
include("footer.php");
############################################################################
# End of Page
############################################################################
?>