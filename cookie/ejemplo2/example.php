<?php
require( "cookieSession.php" );
$cs = new cookieSession();
session_start() ;

//--- Reload cart if necessary
if (!isset($HTTP_SESSION_VARS["cart"]))
{	
	$cs->readSessionCookie("cart");
	if (!isset($HTTP_SESSION_VARS["cart"]))
	{	// no cookie
		$HTTP_SESSION_VARS["cart"] = array();
	}
}

//--- Add item
if ($HTTP_POST_VARS["add"]==1)
{
	$nbItems = sizeof($HTTP_SESSION_VARS["cart"])+1;
	$HTTP_SESSION_VARS["cart"][$nbItems] = array($HTTP_POST_VARS["lib"], $HTTP_POST_VARS["qty"] );
	$cs->storeSessionCookie("cart");
}

//--- Del items
else if ($HTTP_POST_VARS["del"]==1)
{
	$HTTP_SESSION_VARS["cart"] = array();
	$cs->storeSessionCookie("cart");
}

//--- Cart display
echo "<u>Your cart :</u><br><br>";
foreach($HTTP_SESSION_VARS["cart"] as $i => $v)
{
	echo "item ".$i." : ".$v[0]." x ".$v[1]."<br>";
}

//--- Form display
echo "<br>";
echo "<form method=post>New item name <input name=lib size=10> x quantity <input name=qty size=10><br>";
echo "<input name=add type=hidden value=1><input name=sub type=submit value=add></form><br>";
echo "<form method=post><input name=del type=hidden value=1><input name=sub type=submit value='delete all'></form>";


?>