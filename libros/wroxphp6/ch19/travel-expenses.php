<?php
require_once ("lib/common.php");
require_once ("lib/expense.phpm");
// is the user logged in?
if (!$session->isLoggedIn()) {
    redirect ("index.php");
}
$user = $session->getUserObject();
$week = new TravelExpenseWeek (
    array ('emp_id'           => $user->id, 
           'week_start'       => getCurrentStartWeek(),
           'territory_worked' => $_REQUEST["territory_worked"],
           'comments'         => $_REQUEST["comments"],
           'cash_advance'     => $_REQUEST["cash_advance"],
           'mileage_rate'     => $GLOBALS["expense-mileage-travelrate"]),
    $session->getDatabaseHandle());
// display

if ($_REQUEST["action"] != "persist_expense") {

    $week->readWeek();
    $smarty->assign_by_ref ("user",       $user);
    $smarty->assign_by_ref ("week",       $week);     
    $smarty->assign('start_weeks',        getStartWeeks());
    $smarty->assign('current_start_week', getCurrentStartWeek());
    $smarty->assign_by_ref ('expenses',   $week->getExpensesMetaArray());
    $smarty->assign('travelrate',         $GLOBALS["expense-mileage-travelrate"]);
    $smarty->display('travel-expenses.tpl');
    exit();
}

// gather and persist week

$week->parse($_REQUEST);

$week->persist();
print "saved, thanks";
?>