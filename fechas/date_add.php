<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/07/2016
 * Time: 18:42
 */
date_default_timezone_set('Europe/Madrid');

$diff1Day        = new DateInterval('P1D');
$diff24Hours     = new DateInterval('PT24H');
$diff1440Minutes = new DateInterval('PT1440M');
// Clocks changed at 2014-03-30 02:00:00
$d0              = new DateTime('2014-03-29 08:00:00');
$d1              = new DateTime('2014-03-29 08:00:00');
// Add 1 day - expect time to remain at 08:00
$d1->add($diff1Day);
print_r($d1);

$d2              = new DateTime('2014-03-29 08:00:00');
// Add 24 hours - expect time to be 09:00
$d2->add($diff24Hours);
print_r($d2);

$seconds         = $d1->getTimestamp() - $d0->getTimestamp();
echo "Difference in Hours: " . $seconds / (60 * 60) . "\n";
?>