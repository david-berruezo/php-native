<?php

include('tested/BookList.class.php');

$dbConn = new mysqli('localhost', 'root', null, 'bookclub');

$booksPerPage = 3;

$bookList = new BookList($dbConn);
$bookList->booksPerPage = $booksPerPage;

unset($bookList[3]);

foreach ( $bookList as $key => $book ) {
  echo "$key = ";
  print_r($book);
}

printf("%d total books in the list after an unset.\n", count($bookList));

?>
