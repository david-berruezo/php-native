<?php
include('tested/BookList.class.php');
include('tested/Page.class.php');

$dbConn = new mysqli('localhost', 'root', null, 'bookclub');

$booksPerPage = 10;
$page = ( isset($_GET['page']) ? $_GET['page'] : 1 );

$bookList = new BookList($dbConn);
$bookPage = new Page($bookList, $page , $booksPerPage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> <title>Book Club List</title> </head>
<body>
  <p>
    Showing books
  <?php
    printf('%d-%d of %d', $bookPage->getFirstIndex(),
            $bookPage->getLastIndex(), count($bookList) );
  ?>
  </p>
  <table>
    <thead>
      <th>Title</th>
      <th>Author</th>
      <th>Publisher</th>
    </thead>
    <tbody>
<?php
foreach ( $bookPage as $key => $book ) {
  printf("    <tr><td>%s</td>%s</td><td>%s</td></tr>\n",
         $book['title'], $book['authors'], $book['publisher']);
}
?>
    </tbody>
  </table>
  <ul class="pages">
<?php
$totalPages = ceil(count($bookList)/$booksPerPage);
if ( $page > 1 )
  printr("    <li><a href=\"?page=%d\">Prev</a></li>\n", $page-1);

for ( $i=1; $i <= $totalPages; $i++ ) {
  if ( $i == $page )
    printf("    <li>%d</li>\n", $i);
  else
    printf("    <li><a href=“?page=%d”>%d</a></li>\n", $i, $i);
}

if ( $page < $totalPages )
  printf("    <li><a href=“?page=%d”>Next</a></li>\n", $page+1);
?>
  </ul>
  </body>
</html>
