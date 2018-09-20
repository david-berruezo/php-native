<?php
include('QueryBuilder.class.php');

class QueryBuilderImproved extends QueryBuilder {

  public function getQueryObject($query) {
    $self = $this;
    return function() use ($self,$query) {
      $argv = func_get_args();
      foreach ( $argv as $i => $arg )
        $argv[$i] = mysql_escape_string($arg);
      array_unshift($argv, $self->build($query));
      return call_user_func_array( "sprintf", $argv);
    };
  }
};

?>
