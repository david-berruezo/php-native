<?php

require_once ("lib/phpunit/phpunit.php");

class WidgetSession {

    public function __construct ($one, $two) {}
    public function login() {}
    public function isLoggedIn()     { return null; }
    public function getUser() {
        return new WidgetUser();
    }
}

class WidgetUser {
    public $first_name = "";
    public $last_name = "";
    public $email = "";

    public function isSalesPerson()  { return null; }
    public function isSalesManager() { return null; }
    public function isAccountant()   { return null; }
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
}
$suite = new TestSuite;
$suite->addTest(new TestWidgetSession("testValidLogin"));
$suite->addTest(new TestWidgetSession("testInvalidLogin"));
$suite->addTest(new TestWidgetSession("testUser"));
$suite->addTest(new TestWidgetSession("testAuthorization"));
$testRunner = new TestRunner();
$testRunner->run( $suite );
?>