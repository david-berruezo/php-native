<?php
/*
	author: ivi
	email: ivi@newsroot.net
	www: http://newsroot.net
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>	Rewrite Tools </title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="content-language" content="ru">
</head>
<body> 
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td >
		<table  cellspacing="0" cellpadding="0" width="100%"  border="0">
			<tr>
			  <td vAlign="top" height="100%" style="font-weight: normal; font-size: 12px; color: #000000"><b>
				  <b>Mod Rewrite rules generating Tool</b><br>
				  <span style="font-weight: normal; font-size: 12px; color: #000000">This tool helps you convert dynamic URLs into static looking html URLs.</span><br>
				  <br>		
				 <b>How to use this tool</b><br>
				 <span style="font-weight: normal; font-size: 12px; color: #000000">
				  Step #1. Enter a URL (for sample http://newsroot.net/index.php?page=456&type=456&userid=56&item=8476). <br>
				  Step #2.  You would need to create a file ".htaccess" and paste the code, Once you have created the .htacess file simply copy it into your web directory.
				 </span>
			  </td>
	  
			</tr>

		</table>			
	</td>
</tr>
</table> 
<form action="" method="post">
<table border="0">

	<tr>
		<td align="right" valign="top" style="font-size:80%; color:#ff0000;"><b>URL:</b></td>

		<td valign="top" align="left">	<textarea name="hosts"></textarea></td>
	</tr>
	<tr>

		<td align="right" valign="top"><b></b></td>
		<td valign="top" align="left">	<input name="submit" value="Generate" type="submit" /></td>
	</tr>

</table>
</form>


<?php
require_once("MRewrite.class.php");


if($_POST['hosts'])
{
	$rewrite = new Rewrite($_POST['hosts']);
	if($rewrite->error)
	{
		die("Incorrect URL");
	
	}


?>
<table cellpadding="0" cellspacing="0" border="0">
<?php
			
			/*********************************/
			$arr  = $rewrite->getType1();
			
			
			
			//dump($arr);
			
			
			$arr1  = $rewrite->getType2();
			
			//dump($arr);
			if(sizeof($arr) > 0)
			{
				
				$html1 = "
				<tr>
					<td colspan='2' valign='top' align='center'><b>Type 1 - Single Page URL </b></td>
				</tr>
				<tr>
					<td colspan='2'>
						  Generated URL<br>
						  $arr[fexpl]<br>
						  Create a .htaccess file with the code below<br>
 						  The .htaccess file needs to be placed in $rewrite->host
					</td>
				</tr>
				
				<tr>
					
			
					<td valign='top' align='left' colspan='2'>	<textarea cols='50' rows='10' name='type1' readonly>".$rewrite->getOut($arr)."</textarea></td>
				</tr>
				<tr><td height='10'></td></tr>
				<tr>
					<td colspan='2' valign='top' align='center'><b>Type 2 - Directory Type URL </b></td>
				</tr>
				<tr>
					<td colspan='2'>
						  Generated URL<br>
						  $arr1[fexpl]<br>
						  Create a .htaccess file with the code below<br>
 						  The .htaccess file needs to be placed in $rewrite->host
					</td>
				</tr>
				
				<tr>
					
			
					<td valign='top' align='left' colspan='2'>	<textarea cols='50' rows='10' name='type1' readonly>".$rewrite->getOut($arr1)."</textarea></td>
				</tr>
	
				
				";
				
				
			}

			echo $html1;
}
?>
</table> <br>

<center><a href="http://newsroot.net/projects/" style="color:black"><b>Powered by <b>News Root <span style="color:red">.NET</span></b></a></center>
</body>
</html>