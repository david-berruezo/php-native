<?php

require_once ("lib/phpunit/phpunit.php");
require("httpsession.phpm");

class WidgetSession extends HTTPSession {

    public function getUserObject() {
        $uid = $this->GetUserID(); // calling up from HTTPSession
        if ($uid == false) return null;
        // pull ourselves out of the database
        $stmt = "select * FROM \"user\" WHERE id = ".$uid;
        $result = $this->getDatabaseHandle()->query($stmt);
        return new WidgetUser($result->fetchRow());
    }

}



class WidgetUser {
    protected $contentBase = array();
    protected $dispatchFunctions = array ("role" => "getrole");

    function __construct($initdict) {
        $this->contentBase = $initdict; // copy
    }

    function __get ($key) {
        // dispatch by function first
        if (array_key_exists ($key, $this->dispatchFunctions)) {
            $funcname = $this->dispatchFunctions[$key];
            return $this->$funcname();
        }

        // otherwise return based on state
        if (array_key_exists ($key, $this->contentBase)) {
            return $this->contentBase[$key];
        }
        return null;
    }

    function __set ($key, $value) {
        if (array_key_exists ($key, $this->contentBase)) {
            $this->contentBase[$key]=$value;
        }

    }

    public function getRole() {
        switch ($this->contentBase["role"]) {
            case "s": return ("Sales Person");
            case "m": return ("Sales Manager");
            case "a": return ("Accountant");
            default: return ("");
        }
    }

   public function isSalesPerson()  { 
        if ($this->contentBase["role"] == "s") return true;
        return false;
    }

    public function isSalesManager() {
        if ($this->contentBase["role"] == "m") return true;
        return false;
    }
    public function isAccountant()   {

        if ($this->contentBase["role"] == "a") return true;
        return false;
    }
}



class TestWidgetSession extends TestCase {

    private $_session;
    function setUp() {
        $dsn = array ('phptype'  => "pgsql", 
					  'hostspec' => "localhost",
                      'database' => "widgetworld",
                      'username' => "wuser", 
                      'password' => "foobar");
        $this->_session = new WidgetSession($dsn, true);
    }

    function testValidLogin() {
        $this->_session->login("ed","12345");
        $this->assertEquals(true, $this->_session->isLoggedIn());
    }

    function testInvalidLogin() {
        $this->_session->login("ed","54321"); // fail
        $this->assertEquals(false, $this->_session->isLoggedIn());
    }

    function testUser() {
        $user = $this->_session->getUser();
        $this->assertEquals("Lecky-Thompson", $user->last_name);
        $this->assertEquals("Ed", $user->first_name);
        $this->assertEquals("ed@lecky-thompson.com", $user->email);
    }

    function testAuthorization () {
        $user = $this->_session->getUser();
        $this->assertEquals("Sales Person", $user->role);
        $this->assertEquals(true, $user->isSalesPerson());
        $this->assertEquals(false, $user->isSalesManager());
        $this->assertEquals(false, $user->isAccountant());
    }

    function testValidTravelExpenseWeek() {
        $tvi = new TravelExpenseWeek (
            array ('emp_id'             => "1",      
                   'week_start'         => "1980-01-01",
                   'comments'           => "comment",
                   'mileage_rate'       => "0.31",
                   'territory_worked'   => "Midwest" ));
        $this->assertEquals(true, $tvi->isValid(), "valid expense");
     }

     function testInvalidTravelExpenseWeek() {
        $tvi = new TravelExpenseWeek (
            array ('emp_id'             => "1", 
                   'week_start'         => "", // date required
                   'comments'           => "comment",
                   'mileage_rate'       => "0.31",
                   'territory_worked'   => "Midwest" ));
        $this->assertEquals(false, $tvi->isValid(), "valid expense");
     }

     function testTravelExpenseWeekPersistence() {
         $this->_session->getDatabaseHandle()->query("delete FROM
                 travel_expense_week WHERE emp_id = 1 and week_start
                 = '1980-01-01'"); // remove multiples
        $tvi = new TravelExpenseWeek (
            array ('emp_id'             => "1", 
                   'week_start'         => "1980-01-01",
                   'comments'           => "comment",
                   'territory_worked'   => "Midwest",
                   'mileage_rate'       => "0.31",
                   'cash_advance'       => "0"),
            $this->_session->getDatabaseHandle());
        $result = $this->_session->getDatabaseHandle()->query("select * 
                   FROM travel_expense_week WHERE emp_id = 1 and 
                   week_start = '1980-01-01'");
        $this->assertEquals(0, $result->numRows(), "pre check");
        $tvi->persist();
        $result = $this->_session->getDatabaseHandle()->query("select *
                  FROM travel_expense_week WHERE emp_id = 1 and
                  week_start = '1980-01-01'");
        $this->assertEquals(1, $result->numRows(), "persist");     }
	
	
}
$suite = new TestSuite;
$suite->addTest(new TestWidgetSession("testValidLogin"));
$suite->addTest(new TestWidgetSession("testInvalidLogin"));
$suite->addTest(new TestWidgetSession("testUser"));
$suite->addTest(new TestWidgetSession("testAuthorization"));
$testRunner = new TestRunner();
$testRunner->run( $suite );
?>