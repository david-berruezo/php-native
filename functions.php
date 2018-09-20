<?php
/**
 * Libreria de funciones.
 * Date: 06/07/2016
 * Time: 12:01
 */


/*
 * Functions with Arbitrary Number of Arguments
 * You may already know that PHP allows you to define functions with optional arguments.
 * But there is also a method for allowing completely arbitrary number of function arguments.
 * First, here is an example with just optional arguments:
 */

// function with 2 optional arguments
function funcion1($arg1 = '', $arg2 = '') {

    echo "arg1: $arg1\n";
    echo "arg2: $arg2\n";

}


funcion1('hello','world');
/* prints:
arg1: hello
arg2: world
*/

funcion1();
/* prints:
arg1:
arg2:
*/


/*
 * Now, let's see how we can build a function that accepts any number of arguments.
 * This time we are going to utilize func_get_args():
 */
// yes, the argument list can be empty
function funcion2() {

    // returns an array of all passed arguments
    $args = func_get_args();

    foreach ($args as $k => $v) {
        echo "arg".($k+1).": $v\n";
    }

}

funcion2();
/* prints nothing */

funcion2('hello');
/* prints
arg1: hello
*/

funcion2('hello', 'world', 'again');
/* prints
arg1: hello
arg2: world
arg3: again
*/

