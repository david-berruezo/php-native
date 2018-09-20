<?php
require_once ("Smarty.class.php"); require_once ("widgetsession.phpm");
$session = new WidgetSession(array ('phptype'  => "pgsql",
                                    'hostspec' => "localhost",
                                    'database' => "widgetworld",
                                    'username' => "wuser",
                                    'password' => "foobar"));
$session->Impress();
$smarty = new Smarty;
if ($_REQUEST["action"] == "login") {
    $session->login($_REQUEST["login_name"],$_REQUEST["login_pass"]);
    if ($session->isLoggedIn()) {
        $smarty->assign_by_ref("user", $session->getUserObject());
        $smarty->display ("main.tpl");
        exit;
    } else {
        $smarty->assign('error', "Invalid login, try again.");
        $smarty->display ("login.tpl");
        exit;
    }
} else {
    if ($session->isLoggedIn() == true) {
        $smarty->assign_by_ref("user", $session->getUserObject());
        $smarty->display ("main.tpl");
        exit;
    }
}
$smarty->display ("login.tpl");
?>