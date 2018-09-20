<?php

$server = new soap_server();

$server->configureWSDL('basicwsdl', 'urn:ratingwsdl');
$server->register('movieRating',                   // Service Method
	array('name' => 'xsd:string'),                   // Expected parameters
	array('return' => 'tns:MovieReview'),
	'urn:ratingwsdl',                                // Namespace
	'urn:ratingwsdl#movieRate',                      // Soap Action
	'rpc',                                           // Style
	'encoded',                                       // Use
	'Returns a rating for the movie specified'       // Description of the service
);
$server->wsdl->addComplexType(
'MovieReview',    // Type Name
'complexType',    // What we are adding
'struct',         // Given
'all',            // Given
'',               //
array(
  'rating'   => array('name' => 'rating', 'type' => 'xsd:string'),
  'reviewer' => array('name' => 'reviewer', 'type' => 'xsd:string'),
  'stars'    => array('name' => 'stars', 'type' => 'xsd:int')
  )
);


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

function movieRating($name) 
{
  $review = array(
  'rating' => "It was great!",
  'reviewer' => "Paul",
  'stars' => "5");
  return $review;
}



?>