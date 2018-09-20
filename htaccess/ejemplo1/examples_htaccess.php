<?
// Here are some examples for the htaccess class
// (Groups are not implemented yet! Only Passwd and htaccess)
include("htaccess.class.php");
// Initializing class htaccess as $ht
$ht = new htaccess("/var/www/.htaccess","/var/www/htpasswd");
// Adding user
$ht->addUser("username","0815");

// Changing password for User
$ht->setPasswd("username","newPassword");

// Getting all usernames from set password file
$users=$ht->getUsers();

foreach ($users as $key => $value) {
    echo $value[0]."<br>";
}

// Deleting user
$ht->delUser("username");

// Setting authenification type
// If you don't set, the default type will be "Basic"
$ht->setAuthType("Basic");

// Setting authenification area name
// If you don't set, the default name will be "Internal Area"
$ht->setAuthName("My private Area");

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// finally you have to process addLogin()
// to write out the .htaccess file
$ht->addLogin();

// To delete a Login use the delLogin function
$ht->delLogin();

?>