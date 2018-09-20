<?php
include('QueryBuilderImproved.class.php');

class Book{
  private static $methods = null;
  private static $builder;

  private $database;

  public $id;
  public $authors;
  public $title;
  public $publisher;

  public function __construct( $database ) { $this->database = $database; }

  public function __call($name, $params) {
    if ( !is_array(self::$methods) ) self::init();

    if ( array_key_exists($name, self::$methods) ) {
      array_unshift($params, $this->id);
      $query = call_user_func_array( self::$methods[$name], $params );
      return $this->database->query( $query );
    }
  }

  private static function init() {
    self::$builder = new QueryBuilderImproved();
    self::$methods = array(
      'delete' => self::$builder->getQueryObject("DELETE FROM {books} WHERE id=%d")
    );
  }
}
?>
