<?php
	//I haven't changed this file from it's original state to make it easier for you
	//  to skim code, please change the email addreses, I don't really want notification
	// from your test system when stuff fails... :)
	
//Process the IPN
  //Step 0. Record the transaction
    ob_start();
    echo date("D M j G:i:s T Y") . "\n"; 
    print_r($_SERVER);
    print_r($_POST);
    $body = ob_get_clean();
    file_put_contents("/tmp/IPN.txt", $body, FILE_APPEND);
    
  //Step 1. Verify IPN With PayPal 
  $result=verifyIPN($_POST); 
  if ($result == 0)
  {
    $subject = "FAKE IPN RECEIVED";
    $address = "paul@preinheimer.com";
    $headers = 
       "From: ipn_processor@example.com\r\n" .
       "Reply-To: donotreply@example.com\r\n" .
       "X-Mailer: PHP/" . phpversion();
    mail($address, $subject, $body, $headers);
    exit;
  }else if($result != 1)
  {
    $subject = "Unable to validate IPN";
    $body = "If this is payment notification is valid it will need to be 
        manually processed\n $result\n $body";
    $address = "paul@preinheimer.com";
    $headers = 
       "From: ipn_processor@example.com\r\n" .
       "Reply-To: donotreply@example.com\r\n" .
       "X-Mailer: PHP/" . phpversion();
    mail($address, $subject, $body, $headers);
    exit;
    
  }
  
  //Step 1.5 Check payment status
  switch ($_POST['payment_status']) 
  {
    case "Completed":
      break;
    case "Pending":
      paymentPendingThankYou($_POST['payer_email']);
      break;
    default:
      $body = "Hi, an IPN was received that wasn't a completed payment or 
        a pending payment. Please confirm this transaction against our records.";
      $body .= $post;
      $subject = "IPN Received";
      $address = "paul@preinheimer.com";
      $headers = 
        "From: ipn_processor@example.com\r\n" .
        "Reply-To: donotreply@example.com\r\n" .
        "X-Mailer: PHP/" . phpversion();
      mail($address, $subject, $body, $headers);
      exit;
    break;
  }


  //Step 2. Confirm Product Information
  $result = confirmProduct($_POST['item_number'],$_POST['item_name'],$_POST['payment_gross']);
  if ($result == false)
  {
    $subject = "Product Name/ID/Price mis-match";
    $address = "paul@preinheimer.com";
    $headers = 
       "From: ipn_processor@example.com\r\n" .
       "Reply-To: donotreply@example.com\r\n" .
       "X-Mailer: PHP/" . phpversion();
    mail($address, $subject, $body, $headers);
    exit;
  }
 
  //Step 3. Process the order
  $subject = "VALID IPN Received";
  $address = "paul@preinheimer.com";
  $headers = 
   "From: ipn_processor@example.com\r\n" .
   "Reply-To: donotreply@example.com\r\n" .
   "X-Mailer: PHP/" . phpversion();
  mail($address, $subject, $body, $headers);
  file_put_contents("/tmp/IPN.txt", "\ngood ipn\n", FILE_APPEND);
  exit;


function verifyIPN($data) 
{ 
  
  $postdata = "";
  $response = array();
  
  foreach($data as $i=>$v) 
  { 
    $postdata .= $i . "=" . urlencode($v) . "&"; 
  }
  
  $postdata.="cmd=_notify-validate"; 
  $fp=@fsockopen("ssl://www.sandbox.paypal.com" ,"443",$errnum,$errstr,30); 
  
  if(!$fp) 
  { 
      return "$errnum: $errstr";
  } else 
  { 
    
    fputs($fp, "POST /cgi-bin/webscr HTTP/1.1\r\n"); 
    fputs($fp, "Host: www.sandbox.paypal.com\r\n"); 
    fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
    fputs($fp, "Content-length: ".strlen($postdata)."\r\n"); 
    fputs($fp, "Connection: close\r\n\r\n"); 
    fputs($fp, $postdata . "\r\n\r\n"); 
    while(!feof($fp)) { $response[]=@fgets($fp, 1024); }  
    fclose($fp); 
    
  }
  $response = implode("\n", $response);
  if(eregi("VERIFIED",$response)) 
  {
    return true;
  }else
  {
    //Remember, You're likely going to want to set this to a real location
    file_put_contents("/tmp/IPN.txt", "Failed, $response", FILE_APPEND); 
    return false;
  }
}

function confirmProduct($id, $name, $amount)
{
  if (!(ctype_digit($id) && is_numeric($amount)))
  {
    return false;
  }else
  {
    $name = mysql_escape_string($name); 
  }
  $query = "SELECT id FROM products WHERE `id` = '$id' AND `p_name` = '$name' AND `cost` = '$amount' LIMIT 1"; 
  
  if (rowCount($query) == 1)
  {
    return true; 
  }else
  {
    return false;
  }
}

function processOrder($data)
{
   
   
   
}

function paymentPendingThankYou($address)
{
  $subject = "Order Received";
  $body = "Thanks for your order with Example.com!\n
    This message confirms that we have received notification from
    PayPal regarding your order. However, PayPal is still processing
    your payment at this time. Once PayPal confirms that they have completed
    processing your payment we will contact you again to confirm payment and
    include shipping details.\n\n
    If you have any questions please do not hesitate to contact us at
    support@example.com.\n\n
    We apreciate your business!";
  $headers = 
     "From: OrderConfirmation@example.com\r\n" .
     "Reply-To: support@example.com\r\n" .
     "X-Mailer: PHP/" . phpversion();
  mail($address, $subject, $body, $headers);
  exit; 
}

function unknownIPNReceived($post)
{
   $body = "Hi, an IPN was received that wasn't a completed payment or 
   a pending payment. Please confirm this transaction against our records.";
   $body .= $post;
   $subject = "IPN Received";
   $address = "paul@preinheimer.com";
   $headers = 
       "From: ipn_processor@example.com\r\n" .
       "Reply-To: donotreply@example.com\r\n" .
       "X-Mailer: PHP/" . phpversion();
    mail($address, $subject, $body, $headers);
    exit;
}

function rowCount($query)
{ 
  return 1; 
}
?>