<?php
require("../common_db.php");
//Plug in authentication function here, remember to escape strings if the
//  destination function doesn't do it for you.
if (!checkUser(mysql_escape_string($_GET['username']), mysql_escape_string($_GET['password'])))
{
	echo <<< endquote
<response>
  <error no="1">Invalid Username or Password</error>
</response>
endquote;
	exit;
}

//Plug in throttling function here if desired
if (userThrottled($_GET['username']))
{
echo <<< endquote
<response>
  <error no="2">Query limit reached, please try again tommorow</error>
</response>
endquote;
	exit;
}


//Set up your own array functions here
$API = array();

/* Example:
$expectedValues = array("name", "title");
$optionalValues = array("year", "publisher");
$API[] = array("lookup", "lookupCall", $expectedValues, $optionalValues);

$expectedValues = array("keyword");
$optionalValues = array();
$API[] = array("search", "searchCall", $expectedValues, $optionalValues);
describeAPI($API);
*/



//Framework iterates through array looking to match the requested method
//  with a service the framework provides
$error = array();
$matchedMethod = false;
$validRequestFormat = false;
foreach($API as $item)
{
  if ($item[0] == $_GET['method'])
  {
     $matchedMethod = true;
     $validRequestFormat = checkValues($_GET, $item[2], $item[3], &$error);
     break;
  }
}

//Framework was unable to match method, return an error
if ($matchedMethod == false)
{
  	echo <<< endquote
<response>
  <error no="100">Unknown or missing method</error>
</response>
endquote;
		exit;
}else if ($validRequestFormat == false)
{
	echo "<response>\n" . implode("\n",$error) . "</response>";	
	exit;   
}

//Method was matched, and contained required paramaters, call the apropriate
//  function
call_user_func($item[1], $_GET);


function checkValues($request, $required, $optional, &$error)
{
  $required[] = "method";
  $required[] = "username";
  $required[] = "password";
	// Ensure all elements passed are either requied or optional
	$requestTemp = array();
	$requestTemp = array_diff(array_keys($request), $optional);
	$requestTemp = array_diff($requestTemp, $required);
  if (count($requestTemp) > 0)
  {  
    print_r($requestTemp);
    foreach ($requestTemp as $unknownElement => $unknownValue)
    {
    	// *SECURITY ISSUE* 
    	// Failing to escape the user data present in $unknownElement could
    	// expose your site to a XSS vulnerability
    	
    	//Original:
      //$error[] = "<error no=\"101\">Unknown Element: $unknownElement</error>";
      
      //Corrected:
      $error[] = "<error no=\"101\">Unknown Element: " . htmlentities($unknownElement) . "</error>";
    }	
  }
	
	// Ensure all requied elements are present
	$requiredTemp = array();
	$requiredTemp = array_diff($required, array_keys($request));
  if (count($requiredTemp) > 0)
  {
    foreach ($requiredTemp as $missingElement)
    {
      $error[] = "<error no=\"102\">Missing required element: $missingElement</error>";
    }
  }
  if (count($error) == 0)
  {
    return true;	
  }else 
  {
    return false;
  }
}

function describeAPI($API)
{
  foreach($API as $service)
  {
    echo "<b>Method Name:</b> {$service[0]} <br>";
    echo "<b>Requried Parameters:</b> " . implode(",", $service[2]) . "<br>";
    echo "<b>Optional Parameters:</b> " . implode(",", $service[3]) . "<br><br>";
  }
  exit;
}

function checkUser($username, $password)
{
	return true;	
}

function searchCall($request)
{
  echo "SearchCall has been called, I will handle the request as best I can!"; 
}

function userThrottled($username)
{
  return false;  
}

?>