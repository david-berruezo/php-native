<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 20:51
 */

/*
 * The crc32() function calculates a 32-bit CRC (cyclic redundancy checksum) for a string.
 * This function can be used to validate data integrity.
 */

$str = crc32("Hello World!");
printf("%u\n",$str);

