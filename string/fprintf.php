<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 01/07/2016
 * Time: 12:03
 */

/*
 * Escribir una cadena con formato a una secuencia
 * en este caso a un fichero
 */

class Printear{
    public function ejemplo1(){
        $number = 9;
        $str = "Beijing";
        $file = fopen("test.txt","w");
        echo fprintf($file,"There are %u million bicycles in %s.",$number,$str);
    }
    public function ejemplo2(){
        $number = 123;
        echo fprintf("With 2 decimals: %1\$.2f
        <br>With no decimals: %1\$u",$number);
    }
    public function ejemplo3(){
        $num1 = 123456789;
        $num2 = -123456789;
        $char = 50; // The ASCII Character 50 is 2
        // Note: The format value "%%" returns a percent sign
        echo fprintf("%%b = %b",$num1)."<br>"; // Binary number
        echo fprintf("%%c = %c",$char)."<br>"; // The ASCII Character
        echo fprintf("%%d = %d",$num1)."<br>"; // Signed decimal number
        echo fprintf("%%d = %d",$num2)."<br>"; // Signed decimal number
        echo fprintf("%%e = %e",$num1)."<br>"; // Scientific notation (lowercase)
        echo fprintf("%%E = %E",$num1)."<br>"; // Scientific notation (uppercase)
        echo fprintf("%%u = %u",$num1)."<br>"; // Unsigned decimal number (positive)
        echo fprintf("%%u = %u",$num2)."<br>"; // Unsigned decimal number (negative)
        echo fprintf("%%f = %f",$num1)."<br>"; // Floating-point number (local settings aware)
        echo fprintf("%%F = %F",$num1)."<br>"; // Floating-point number (not local sett aware)
        echo fprintf("%%g = %g",$num1)."<br>"; // Shorter of %e and %f
        echo fprintf("%%G = %G",$num1)."<br>"; // Shorter of %E and %f
        echo fprintf("%%o = %o",$num1)."<br>"; // Octal number
        echo fprintf("%%s = %s",$num1)."<br>"; // String
        echo fprintf("%%x = %x",$num1)."<br>"; // Hexadecimal number (lowercase)
        echo fprintf("%%X = %X",$num1)."<br>"; // Hexadecimal number (uppercase)
        echo fprintf("%%+d = %+d",$num1)."<br>"; // Sign specifier (positive)
        echo fprintf("%%+d = %+d",$num2)."<br>"; // Sign specifier (negative)
    }
    public function ejemplo4(){
        $number = 9;
        $str = "Beijing";
        $file = fopen("test.txt","w");
        echo fprintf($file,"There are %u million bicycles in %s.",$number,$str);
    }
}
$objetoPrintear = new Printear();
$objetoPrintear->ejemplo1();
