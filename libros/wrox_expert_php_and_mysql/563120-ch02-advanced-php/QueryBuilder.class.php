<?php
class QueryBuilder {
  private $query;
  private $prefix;

  public function __construct($prefix='' ) {
    $this->query = $query;
    $this->prefix = $prefix;
  }

  public function replaceCallback( $match ) {
    return ( preg_match('/^{(.*)}$/',$match[1],$m)
      ? ( empty($this->prefix) ? $m[1] : "{$this->prefix}_$m[1]" )
      : $match[1]
    );
  }

  public function build($query) {
    static $regExp = '/([^{"\']+|\'(?:\\\\\'.|[^\'])*\'|"(?:\\\\"|[^"])*"|{[^}{]+})/';
    return preg_replace_callback($regExp, array(&$this, "replaceCallback"), $query);
  }
};
?>
