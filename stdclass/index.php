<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 7/11/17
 * Time: 6:01
 */

$severalBooks      = array();

$book              = new stdClass;
$book->id          = 1;
$book->title       = "Harry Potter and the Prisoner of Azkaban";
$book->author      = "J. K. Rowling";
$book->publisher   = "Arthur A. Levine Books";
$book->amazon_link = "http://www.amazon.com/dp/0439136369/";

echo "primer objeto<br>";
print_r($book);
echo "<br><br>";
array_push($severalBooks,$book);

$book              = new stdClass;
$book->id          = 2;
$book->title       = "El corro de la patata";
$book->author      = "Mendiluce";
$book->publisher   = "La mangrana";
$book->amazon_link = "http://www.amazon.com/dp/0439136369/";

echo "segundo objeto<br>";
print_r($book);
echo "<br><br>";
array_push($severalBooks,$book);

echo "todo el vector<br>";
print_r($severalBooks);
echo "<br><br>";

$vector_del_array = array();

$array = array(
    "title" => "Harry Potter and the Prisoner of Azkaban",
    "author" => "J. K. Rowling",
    "publisher" => "Arthur A. Levine Books",
    "amazon_link" => "http://www.amazon.com/dp/0439136369/"
);

array_push($vector_del_array,$array);

$array = array(
    "title" => "Harry Potter and the Prisoner of Azkaban",
    "author" => "J. K. Rowling",
    "publisher" => "Arthur A. Levine Books",
    "amazon_link" => "http://www.amazon.com/dp/0439136369/"
);

array_push($vector_del_array,$array);

//$books = (object) $array;
$books = (object) $vector_del_array;

echo "books<br>";
print_r($books);
echo "<br><br>";

foreach($books as $book){
    echo "El libro: <br>";
    print_r($book);
    echo "<br><br>";
}
?>