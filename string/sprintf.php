<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 24/06/2016
 * Time: 16:50
 */


/*
 * % - un carácter de porcentaje literal. No se requiere argumento.
 * b - el argumento es tratado como un valor de tipo integer y presentado como un número binario.
 * c - el argumento es tratado como un valor de tipo integer y presentado como el carácter con ese valor ASCII.
 * d - el argumento es tratado como un valor de tipo integer y presentado como un número decimal (con signo).
 * e - el argumento es tratado con notación científica (e.g. 1.2e+2). El especificador de precisión indica el número de dígitos después del punto decimal a partir de PHP 5.2.1. En versiones anteriores, se tomó como el número de dígitos significativos (menos uno).
 * E - como %e pero utiliza la letra mayúscula (e.g. 1.2E+2).
 * f - el argumento es tratado como un valor de tipo float y presentado como un número de punto flotante (considerando la configuración regional).
 * F - el argumento es tratado como un valor de tipo float y presentado como un número de punto flotante (no considerando la configuración regional). Disponible desde PHP 4.3.10 y PHP 5.0.3.
 * g - lo mismo que %e y %f.
 * G - lo mismo que %E y %f.
 * o - el argumento es tratado como un valor de tipo integer y presentado como un número octal.
 * s - el argumento es tratado y presentado como un string.
 * u - el argumento es tratado como un valor de tipo integer y presentado como un número decimal sin signo.
 * x - el argumento es tratado como un valor de tipo integer y presentado como un número hexadecimal (con las letras en minúsculas).
 * X - el argumento es tratado como un valor de tipo integer y presentado como un número hexadecimal (con las letras en mayúsculas).
 */

class Printear{
    public function ejemplo1(){
        $number = 9;
        $str    = "Beijing";
        $txt    = sprintf("There are %u million bicycles in %s.",$number,$str);
        echo $txt;
    }
    public function ejemplo2(){
        $number = 123;
        $txt = sprintf("With 2 decimals: %1\$.2f
        <br>With no decimals: %1\$u",$number);
        echo $txt;
    }
    public function ejemplo3(){
        $num1 = 123456789;
        $num2 = -123456789;
        $char = 50; // The ASCII Character 50 is 2
        // Note: The format value "%%" returns a percent sign
        echo sprintf("%%b = %b",$num1)."<br>"; // Binary number
        echo sprintf("%%c = %c",$char)."<br>"; // The ASCII Character
        echo sprintf("%%d = %d",$num1)."<br>"; // Signed decimal number
        echo sprintf("%%d = %d",$num2)."<br>"; // Signed decimal number
        echo sprintf("%%e = %e",$num1)."<br>"; // Scientific notation (lowercase)
        echo sprintf("%%E = %E",$num1)."<br>"; // Scientific notation (uppercase)
        echo sprintf("%%u = %u",$num1)."<br>"; // Unsigned decimal number (positive)
        echo sprintf("%%u = %u",$num2)."<br>"; // Unsigned decimal number (negative)
        echo sprintf("%%f = %f",$num1)."<br>"; // Floating-point number (local settings aware)
        echo sprintf("%%F = %F",$num1)."<br>"; // Floating-point number (not local sett aware)
        echo sprintf("%%g = %g",$num1)."<br>"; // Shorter of %e and %f
        echo sprintf("%%G = %G",$num1)."<br>"; // Shorter of %E and %f
        echo sprintf("%%o = %o",$num1)."<br>"; // Octal number
        echo sprintf("%%s = %s",$num1)."<br>"; // String
        echo sprintf("%%x = %x",$num1)."<br>"; // Hexadecimal number (lowercase)
        echo sprintf("%%X = %X",$num1)."<br>"; // Hexadecimal number (uppercase)
        echo sprintf("%%+d = %+d",$num1)."<br>"; // Sign specifier (positive)
        echo sprintf("%%+d = %+d",$num2)."<br>"; // Sign specifier (negative)
    }
}
$objetoPrintear = new Printear();
$objetoPrintear->ejemplo1();
$objetoPrintear->ejemplo2();
$objetoPrintear->ejemplo3();

