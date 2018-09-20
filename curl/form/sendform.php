<?php
include_once("CurlRequest.php");
$datos = array(
    'login_username' => 'davidberruezobernad.emexs@gmail.com',
    'secretkey'      => 'Berruezin23'
);
/*
$curl   = new CurlRequest();
$url    = "http://localhost/php/softwarephp/squirrelmail-webmail-1.4.22/src/login.php";
$method = "POST";
$curl->get($url,$method,$datos,$headers=array());
*/

/*
//Lo primerito, creamos una variable iniciando curl, pasándole la url
$ch = curl_init('http://localhost/php/softwarephp/squirrelmail-webmail-1.4.22/src/redirect.php');
//especificamos el POST (tambien podemos hacer peticiones enviando datos por GET
curl_setopt ($ch, CURLOPT_POST, 1);
//le decimos qué paramáetros enviamos (pares nombre/valor, también acepta un array)
curl_setopt ($ch, CURLOPT_POSTFIELDS, "login_username=davidberruezobernad.emexs@gmail.com&secretkey=Berruezin23");
//le decimos que queremos recoger una respuesta (si no esperas respuesta, ponlo a false)
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//recogemos la respuesta
$respuesta = curl_exec ($ch);
//o el error, por si falla
$error = curl_error($ch);
//y finalmente cerramos curl
curl_close ($ch);
*/

$ebay_user_id = "davidberruezobernad.emexs@gmail.com"; // Please set your Ebay ID
$ebay_user_password = "Berruezin23"; // Please set your Ebay Password
$cookie_file_path = "cookie"; // Please set your
$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

/*
$LOGINURL = "http://localhost/php/softwarephp/squirrelmail-webmail-1.4.22/src/login.php";
$agent    = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
$ch       = curl_init();
curl_setopt($ch, CURLOPT_URL,$LOGINURL);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
$result = curl_exec ($ch);
curl_close ($ch);
*/

$LOGINURL   = "http://localhost/php/softwarephp/squirrelmail-webmail-1.4.22/src/login.php";
$POSTFIELDS = 'login_username='. $ebay_user_id .'&secretkey='.$ebay_user_password.'&js_autodetect_results=0&just_logged_in=1&submit=Login';
$reffer     = "/redirect.php";

/*
echo $POSTFIELDS;
$ch = curl_init();
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
curl_setopt($ch, CURLOPT_URL,$LOGINURL);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTFIELDS);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_REFERER, $reffer);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
$result = curl_exec ($ch);
curl_close ($ch);
print $result;
*/

/* I'm not sure if you meant take a value from a form or fill it but here's how you could take it.. */
$content = '<input type="text" name="user" value="Killswitch" />';
preg_match('/type="text name="user" value="(.+?)"/', $content, $matches);
$user = $matches[1];

$fields = array (user => $user, hiddenvalue1 => login);

$ch = curl_init('http://www.example.com/squirrel/login.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookiefile.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiefile.txt');
$ret = curl_exec($ch);

if(strstr("Login Failed Message", $ret)) {
    echo "Login Failed!";
} else {
    /* Proceed with curl to GET inbox url */
}
?>
