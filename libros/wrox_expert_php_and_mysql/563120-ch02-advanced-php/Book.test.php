<?php

include('Book.class.php');

$database = new MySQLi('localhost', 'root', NULL, 'bookclub');

$book = new Book( $database );
$book->id = 3;

$book->delete();

?>
