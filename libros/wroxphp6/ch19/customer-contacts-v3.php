<?php
require_once ("Smarty.class.php"); 
require_once ("widgetsession.phpm");
$session = new WidgetSession(array ('phptype'  => "pgsql",
                                    'hostspec' => "localhost",
                                    'database' => "widgetworld",
                                    'username' => "uwuser",
                                    'password' => "foobar"));
$session->Impress();
$smarty = new Smarty;
$GLOBALS["max-weekly-contacts"] = 5;

function getStartDateOffset ($i) {
    if ($i < 0) $i = 5;
    $dates = array("Sunday" => 0, "Monday" => -1, "Tuesday" => -2, 
                   "Wednesday" => -3, "Thursday" => -4, "Friday" => -5,
                   "Saturday" => -6);
    return date("Y-m-d", mktime (0,0,0,date("m"), 
           date("d")+$dates[date("l")]-(($i-5)*7),date("Y")));
}
function getCurrentStartWeek () {
    if (strlen($_REQUEST["week_start"]) >= 8) return $_REQUEST["week_start"];
    return getStartDateOffset(-1); // this sunday
}
function getStartWeeks () {
    $sudayArray = array();
    for ($i=20; $i > 0; $i-) {
        array_push($sudayArray, getStartDateOffset($i));
    }
    return ($sudayArray);
}
function persistContactVisits (&$dbh, $emp_id) {
    $dbh->query("delete from contact_visits where emp_id
                 = ".$emp_id." and week_start = '".getCurrentStartWeek()."'");
    $seq = 0;
    for ($i = 0; $i < $GLOBALS["max-weekly-contacts"]; $i++) {
         $cv = new ContactVisit (
             array ("emp_id"            => $emp_id,
                    "week_start"        => getCurrentStartWeek(),
                    "company_name"      => $_REQUEST["company_name_".$i],
                    "contact_name"      => $_REQUEST["contact_name_".$i],
                    "city"              => $_REQUEST["city_".$i],
                    "state"             => $_REQUEST["state_".$i],
                    "accomplishments"   => $_REQUEST["accomplishments_".$i],
                    "followup"          => $_REQUEST["followup_".$i],
                    "literature_request"=> $_REQUEST["literature_request_".$i]),
             $dbh);
         $cv->persist();
    }
}

function persistContact (&$dbh, $emp_id) {
    $c = new Contact (
        array ("emp_id"             => $emp_id,
               "week_start"         => getCurrentStartWeek(),
               "shop_calls"         => $_REQUEST["shop_calls"],
               "distributor_calls"  => $_REQUEST["distributor_calls"],
               "engineer_calls"     => $_REQUEST["engineer_calls"],
               "mileage"            => $_REQUEST["mileage"],
               "territory_worked"   => $_REQUEST["territory_worked"],
               "territory_comments" => $_REQUEST["territory_comments"]),
        $dbh);
    $c->persist();
}
function gatherContact (&$dbh, $emp_id) {
    $result = $dbh->query ("select * from contact where 
              emp_id = ".$emp_id." and week_start = 
              '".getCurrentStartWeek()."'");
    if (DB::isError($result)) return array();
    return new Contact ($result->fetchRow());
}
$user = $session->getUserObject();
// display
if ($_REQUEST["action"] != "persist_contact") {
    $smarty->assign_by_ref ("user", $user);
    $smarty->assign_by_ref ("contact", gatherContact(
           $session->getDatabaseHandle(), $user->id));
    $smarty->assign_by_ref ("contactVisits", gatherContactVisits(
           $session->getDatabaseHandle(), $user->id));
    $smarty->assign('start_weeks', getStartWeeks());
    $smarty->assign('current_start_week', getCurrentStartWeek());
    $smarty->assign("max_weekly_contacts", $GLOBALS["max-weekly-contacts"]);
    $smarty->display('customer-contacts.tpl');
    exit;
}
// persist contact visits
require_once ("lib/contact.phpm");
persistContact ($session->getDatabaseHandle(), $user->id);
persistContactVisits ($session->getDatabaseHandle(), $user->id);

$smarty->display('thankyou.tpl');
?>