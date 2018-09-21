<?php
function getHttpCode( $url ){
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_NOBODY, true );
    curl_exec( $ch );
    return curl_getinfo( $ch, CURLINFO_HTTP_CODE );
}
//22
$webs=[
    'https://www.mhapartments.com/',
    'http://www.avenidapalace.com/',
    'http://www.hotelterradets.com/',
    'http://hotelmiramarbarcelona.com/',
    'http://www.feelathomeapartments.com/',
    'http://www.enjoybcn.com/',
    'http://www.royalpasseigdegraciahotel.com/',
    'http://www.royalramblashotel.com/',
    'http://www.royalhotelsbcn.com/',
    'http://yurbban.com/',
    'http://www.universalholidaycentre.ru/',
    'http://www.universalholidaycentre.com/',
    'http://www.hotelduran.com/',
    'http://www.astoria7hotel.com/',
    'http://microdentsystem.com/',
    'http://umasuites.com/',
    'http://aesstrasteros.es/',
    'http://www.jardinesdenivaria.co.uk/',
    'http://entresd.es/',
    'http://www.sitgesgroup.com/',
    'http://www.hotelvillaemilia.com/',
    'http://emexs.es/',
];


for ($i = 0; $i <= 21; $i++) {
    $status = 0;
    $status = getHttpCode(strval($webs[$i]));
    sleep(rand(10,25));
    if ( $status > 400 )
    {
        $myemail = "raquel.emexs@gmail.com";
        $myemail2 = "enric.emexs@gmail.com";
        $message_to_myemail = "ERROR de carga web $webs[$i]";
        $from  = "No carga: $webs[$i]: status $status.";
        //mail($myemail, $message_to_myemail, $from);
        //mail($myemail2, $message_to_myemail, $from);
    }
    echo "El status es:".$status."<br>";
}
?>