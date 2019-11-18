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
echo "<br>";
array_push($severalBooks,$book);

$book              = new stdClass;
$book->id          = 2;
$book->title       = "El corro de la patata";
$book->author      = "Mendiluce";
$book->publisher   = "La mangrana";
$book->amazon_link = "http://www.amazon.com/dp/0439136369/";

array_push($severalBooks,$book);

$array = array(
    "title" => "Harry Potter and the Prisoner of Azkaban",
    "author" => "J. K. Rowling",
    "publisher" => "Arthur A. Levine Books",
    "amazon_link" => "http://www.amazon.com/dp/0439136369/"
);

$books = (object) $array;

print_r($books);
echo("<br><br>");
$books = indexar_array($severalBooks,"id");
print_r($books);
echo("<br><br>");

foreach($books as $book){
    print_r($book);
}


if(!function_exists('indexar_array')){
    function indexar_array($array,$index){
        $return_array=array();
        foreach($array as $data){
            if(is_object($data))
                $return_array[$data->$index]=$data;
            else
                $return_array[$data[$index]]=$data;
        }
        return $return_array;
    }
}
?>