<?php
//extract data from the post
//set POST variables
//$url = 'http://domain.com/get-post.php';
$url = 'http://localhost/php/php/curl/form_two/get-post.php';

$fields = array(
	'lname' => urlencode($_POST['last_name']),
	'fname' => urlencode($_POST['first_name']),
	'title' => urlencode($_POST['title']),
	'company' => urlencode($_POST['institution']),
	'age' => urlencode($_POST['age']),
	'email' => urlencode($_POST['email']),
	'phone' => urlencode($_POST['phone'])
);
echo "fields recogidos por get.php<br>";
print_r($fields);
echo "<br><br>";
//url-ify the data for the POST
foreach($fields as $key=>$value) { 
    $fields_string .= $key.'='.$value.'&'; 
}
rtrim($fields_string, '&');
echo "fields_string construido<br>";
print_r($fields_string);
echo "<br><br>";
// open connection
$ch = curl_init();
// set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
// execute post
$result = curl_exec($ch);
// close connection
curl_close($ch);
?>