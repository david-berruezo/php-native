<?php
include("Crawler.php");
$mycrawler=new Crawler();
$url='http://www.phpclasses.org/';
$link=$mycrawler->crawlLinks($url);
//print the result
echo "<table width=\"100%\" border=\"1\">
  <tr>
    <td width=\"30%\"><div align=\"center\"><b>Link Text </b></div></td>
    <td width=\"30%\"><div align=\"center\"><b>Link</b></div></td>
    <td width=\"40%\"><div align=\"center\"><b>Text with Link</b> </div></td>
  </tr>";
for($i=0;$i<sizeof($link['link']);$i++)
{
echo "<tr>
    <td><div align=\"center\">".$link['text'][$i]."</div></td>
    <td><div align=\"center\">".$link['link'][$i]."</div></td>
    <td><div align=\"center\"><a href=\"".$link['link'][$i]."\">".$link['text'][$i]."</a></div></td>
  </tr>";		
		
}  
echo "</table>";
?>