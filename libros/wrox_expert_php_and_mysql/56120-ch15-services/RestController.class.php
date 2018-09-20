<?php

include("RestException.class.php");

class RestController {

  public $resource;
  private $_post, $_urn, $_query, $_method, $_format;

  public function __construct( $method, $urn, $query, $post ) {
    $this->_method = $method;
    $this->_urn = $urn;
    $this->_query = $query;
    $this->_post = $post;
  
    $matches = array();

    preg_match('/([^\/]+)(?:\/([^.]+))?\.(.+)$/', $urn, $matches);
    $this->resource = new $matches[1]($matches[2]);

    $this->_format = $matches[3];
  }

  public static function getInstance( ) {
    $method = $_SERVER['REQUEST_METHOD'];
    $urn = $_GET['_urn'];
    return new RestController( $method, $urn, $_GET, $_POST );
  }

  public function execute() {
    $parameters = array();

    switch ( $this->_method ) {
      case 'GET':
        $method = 'view';
        break;
      case 'DELETE':
        $method = 'delete';
        break;
      case 'POST':
      case 'PUT':
        $method = 'edit';
        $parameters = array( $this->_post );
        break;
      default:
	    header('Allow: GET, POST, PUT, DELETE');
        throw new RestException('Method Not Allowed', 405);
    }
  
    try {
      $response = call_user_func_array( array($this->resource, $method),
                                        $parameters );
      return $this->resource->format( $response, $this->_format );
      
    } catch ( RestException $e ) {
      header("HTTP/1.1 ".$e->getCode()." ".$e->getMessage());
      exit;
    } catch ( Exception $e ) { 
      header('HTTP/1.1 500 Internal Server Error');
      exit;
    }
  }
};

?>
