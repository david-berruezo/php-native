<?php
class db{
   var $error;
   var $conn;

   function db($host, $username, $pass, $database){

      $this->conn = @mysql_pconnect($host, $username, $pass);
      if (!$this->conn){$this->error .= "<br>Couldn't log in to DB";}
      if (!@mysql_select_db($database)){$this->error .= "<br>Couldn't connect to DB";}
      
      //Test
      //echo "Connection to $host, $database OK";
   } 
}
?>