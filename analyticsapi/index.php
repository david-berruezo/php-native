<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 20/11/17
 * Time: 10:01
 */

// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';

$analytics = initializeAnalytics();
$profile = getFirstProfileId($analytics);
$results = getResults($analytics, $profile);
printResults($results);

?>