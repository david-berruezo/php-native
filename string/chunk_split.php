<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 19:09
 */

/*
 * Split the string after each character and add a "." after each split:
 */
$str = "Hello world!";
echo chunk_split($str,1,".");
echo "<br>";

/*
 * Split the string after each sixth character and add a "..." after each split:
 */
$str = "Hello world!";
echo chunk_split($str,6,"...");
echo "<br>";
