<?php
include("Crawler.php");

$mycrawler=new Crawler();
//Some site Takes too many Hidden Parameters to Login.
//So it is hard to Login complex Login
$siteloginurl='http://www.getacoder.com/users/onlogin.php';//The url of Form when action perform
$parametes='username=Yourusername&passwd=Yourpassword';//The parameters the action script need
$mycrawler->logIn($siteloginurl,$parametes);

$url='http://www.getacoder.com/users/manage.php';//The url we need to crawl.You cannot go this url before login
									//So we need to login.
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