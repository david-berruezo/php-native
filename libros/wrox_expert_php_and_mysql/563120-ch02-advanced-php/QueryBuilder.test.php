<?php

include('QueryBuilder.class.php');

$builder = new QueryBuilder('foo');
echo $builder->build("SELECT * FROM {books}")."\n";

?>
