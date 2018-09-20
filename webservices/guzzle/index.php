<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 20/11/17
 * Time: 6:17
 */
require 'vendor/autoload.php';
use GuzzleHttp\Client;
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://httpbin.org',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);
// Send a request to https://foo.com/api/test
//$response = $client->request('GET', 'test');
// Send a request to https://foo.com/root
//$response = $client->request('GET', '/root');
//print_r($response);
$response = $client->get('http://httpbin.org/get');
print_r($response);
echo "<br><br>";
$response = $client->delete('http://httpbin.org/delete');
print_r($response);
echo "<br><br>";
$response = $client->head('http://httpbin.org/get');
print_r($response);
echo "<br><br>";
$response = $client->options('http://httpbin.org/get');
print_r($response);
echo "<br><br>";
$response = $client->patch('http://httpbin.org/patch');
print_r($response);
echo "<br><br>";
$response = $client->post('http://httpbin.org/post');
print_r($response);
echo "<br><br>";
$response = $client->put('http://httpbin.org/put');
print_r($response);
echo "<br><br>";
print_r($client);
?>