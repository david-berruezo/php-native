<?php

class company {
  public $id, $name, $website;
};

class companies {
  public $id;

  protected function _getDatabase() {
    static $conn = false;
    if ( $conn === false ) {
      $conn = mysql_connect("user", "test", "password");
      mysql_select_db("testing", $conn );
    }
    return $conn;
  }

  public function __construct( $id ) {
    $this->id = $id;
  }

  public function delete( ) {
    $conn = $this->_getDatabase();

    mysql_query("DELETE FROM `companies` WHERE `id`=".(int)$this->id, $conn);

    if ( mysql_affected_rows($conn) == 0 )
      throw new RestException("File Not Found",404);

    return true;
  }

  public function edit( $data ) {

    $conn = $this->_getDatabase();

    $name = mysql_real_escape_string($data['name'], $conn);
    $website = mysql_real_escape_string($data['website'], $conn);

    if ( $this->id > 0 )
      mysql_query("UPDATE `companies` SET `name`='$name', `website`='$website'".
                  " WHERE `id`=".(int)$id, $conn);
    else {
      mysql_query("INSERT INTO `companies` (`name`,`website`) VALUES('$name','$website')");
      $this->id = mysql_insert_id($conn);
    }

    if ( mysql_affected_rows($conn) == 0 )
      throw new RestException("File Not Found",404);

    return $this->view();
  }

  public function view( ) {
    $res = mysql_query("SELECT * FROM `companies`".
                      ($this->id > 0 ? " WHERE `id`=".(int)$this->id : ""),
                       $this->_getDatabase());
   
    $companies = array();
 
    while ( $row = mysql_fetch_assoc($res) ) {
      $company = new company();
      $company->name = $row["name"];
      $company->website = $row["website"];
      $company->id = $row["id"];
      $companies[] = $company;
    }

    if ( count($companies) == 0 ) { 
      throw new RestException("File Not Found",404);
    }

    return (count($companies) == 1 ? $companies[0] : $companies );
  }

  public function format( $data, $format ) {

    if ( is_array($data) && $format == "xml" ) {
   
      $result = ""; 
      foreach ( $data as $company )
        $result .= $this->format($company, $format);
  
      return "<companies>$result</companies>" ;
    }

    if ( $format == "json" ) {
      header("Content-type: application/json");
      return json_encode($data);
    } else if ( $format == "xml" ) {
      header("Content-type: application/xml");
      if ( $data instanceof company )
        return "<company><id>{$data->id}</id><name>{$data->name}</name><website>{$data->website}</website></company>";
      else
        return '<result>'.(string)$data.'</result>';
    } else {
      header("Accept: application/xml, application/json"); 
      throw new RestException("Not Acceptable", 406 );
    }
  }


};

include("RestController.class.php");

$controller = RestController::getInstance();

echo $controller->execute();
?>
