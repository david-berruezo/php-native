<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 01/07/2016
 * Time: 11:02
 */


/*
 * The echo() function outputs one or more strings.
 * Note: The echo() function is not actually a function, so you are not required to use parentheses with it.
 * However, if you want to pass more than one parameter to echo(), using parentheses will generate a parse error.
 * Tip: The echo() function is slightly faster than print().
 * Tip: The echo() function also has a shortcut syntax. Prior to PHP 5.4.0, this syntax only works
 * with the short_open_tag configuration setting enabled.
 */

/*
 * Concatenamos valores
 */
$str1="Hello world!";
$str2="What a nice day!";
echo $str1 . " " . $str2;

/*
 * Ponemos echo de varias linias
 */
echo "This text
spans multiple
lines.";

/*
 * Ponemos echo en multiples parametros
 */
echo 'This ','string ','was ','made ','with multiple parameters.';


/*
 * Diferencia entre single o doble quotes
 */
$color = "red";
echo "Roses are $color";
echo "<br>";
echo 'Roses are $color';
?>

<?php
/*
 * Solo trabajara con show open tags enabled
 */
$color = "red";
?>
<p>Roses are <?=$color?></p>
