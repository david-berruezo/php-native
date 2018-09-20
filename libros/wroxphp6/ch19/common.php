<?php
require_once ("../../../../settings.php");
require_once ("./lib/widgetsession.phpm");
require_once ($GLOBALS["smarty-path"].'Smarty.class.php'); $smarty = new Smarty;
$session = new WidgetSession(array ('phptype'  => $GLOBALS["db-type"],
                                    'hostspec' => $GLOBALS["db-hostname"],
                                    'database' => $GLOBALS["db-name"],
                                    'username' => $GLOBALS["db-username"],
                                    'password' => $GLOBALS["db-password"]));
$session->Impress();
/*
 * require login
 */
$scriptname = end(explode("/", $_SERVER["REQUEST_URI"]));
if ($scriptname <> "index.php") {
    if ($session->isLoggedIn() == false) {
        Header ("Location: index.php");
    }
}

?>