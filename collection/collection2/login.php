<?php
//Login mechanism
//Keeping it simple here.

session_start();
require_once("classes/Templater.php");

//Deal with form submissions
if ($_POST['username'] == "admin" && $_POST['password'] == "password"){
   $_SESSION['username'] = "admin";
}

//Redirect if successful or show login form.
if ($_SESSION['username'] != "admin"){
   $out['msg'] = "Please log in.";
   $t = new ms_template("templates/login.htm", $out, "<!--::", "::-->");
   $t->parse();
   $t->display();
} else {
   header("Location: manage_links.php");
   exit;
}
?>