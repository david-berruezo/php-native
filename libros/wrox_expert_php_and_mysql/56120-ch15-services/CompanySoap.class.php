<?php

class CompanySoap {

  protected function _getDatabase() {
    static $conn = false;
    if ( $conn === false ) {
      $conn = mysql_connect("localhost", "user", "password");
      mysql_select_db("testing", $conn );
    }
    return $conn;
  }

  function GetCompany( $id ) {
    $res = mysql_query("SELECT * FROM `companies` WHERE `id`=".(int)$id,
                       $this->_getDatabase());

    if ( $row = mysql_fetch_assoc($res) ) {
      $company = new StdClass();
      $company->name = $row["name"];
      $company->website = $row["website"];

      return array( $id, $company );

    } else {
      throw new SoapFault("Server","Company not found.");
    }
  }


  function EditCompany( $id, $company ) {
    $conn = $this->_getDatabase();
  
    $res = mysql_query("UPDATE `companies` SET ".
                                   "  name='".mysql_real_escape_string($company->name, $conn)."',".
                                   "  website='".mysql_real_escape_string($company->website, $conn)."'".
                                   " WHERE `id`=".(int)$id." LIMIT 1",
                       $conn);

    if ( mysql_affected_rows($conn) == 1 ) {
      return array( $id, $company );

    } else {
      throw new SoapFault("Server","Company not found.");
    }
  }

  function CreateCompany( $company ) {
    $conn = $this->_getDatabase();

    $res = mysql_query("INSERT INTO `companies` (`name`,`website`) VALUES (".
                                   "'".mysql_real_escape_string($company->name, $conn)."',".
                                   "'".mysql_real_escape_string($company->website, $conn)."')",
                       $conn );

    if ( mysql_affected_rows($conn) == 1) {
      return array( mysql_insert_id($conn), $company );

    } else {
      throw new SoapFault("Server","Company could not be created.".mysql_error());
    }
  }

  function DeleteCompany( $id ) {
    $conn = $this->_getDatabase();

    $res = mysql_query("DELETE FROM `companies` WHERE `id`=".(int)$id." LIMIT 1",
                       $conn);

    if ( mysql_affected_rows($conn) == 1 ) {
      return true;

    } else {
      throw new SoapFault("Server","Company not found.");
    }
  }
  
}
?>
