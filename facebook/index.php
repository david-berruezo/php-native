<!-- oscar_application-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Esto es una prueba de la api de facebook</title>
    <!-- script jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>
<script>
    // Aplicación para Oscar Gaite
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '2029357454052669',
            xfbml      : true,
            version    : 'v2.12'
        });
        FB.AppEvents.logPageView();

        FB.ui({
            method: 'feed',
            link: 'https://developers.facebook.com/docs/',
            caption: 'An example caption',
        }, function(response){});
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Aplicación para David Berruezo
    /*
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '879788445536807',
            xfbml      : true,
            version    : 'v2.12'
        });
        FB.AppEvents.logPageView();

        FB.ui({
            method: 'feed',
            link: 'https://developers.facebook.com/docs/',
            caption: 'An example caption',
        }, function(response){});
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    */

    $(document).ready(function(){
        /*
        $.ajax({
            type:"GET",
            dataType:"json",
            url:"https://graph.facebook.com/aplicacion_prueba?access_token=EAACEdEose0cBADc6OAPvP8B2aHmW7PYZB1frX4sylkzmXYpMZCoz8xDHEvC6ZCXZBK1aoYrOVPrw0979AyEm2A1qGV8wGYHLemu4p7mTjk0Haq1LwAINZBMcssYDuhpxSz5NUPWLWAdQIg5AO6lJlbajptrj3smzDblOT25xF7LTiBMfY75PPbZBH0vHP3hDNqFmZBPjKipqwZDZD",
            success:function(data){
                console.log("los datos devueltos son: "+data);
            },
            error:function(){
                console.log("Ha habido un error");
            }
        })
        */
    });
</script>
<?php
/*
{
    // identificador de acceso
    "codigo" EAACEdEose0cBADc6OAPvP8B2aHmW7PYZB1frX4sylkzmXYpMZCoz8xDHEvC6ZCXZBK1aoYrOVPrw0979AyEm2A1qGV8wGYHLemu4p7mTjk0Haq1LwAINZBMcssYDuhpxSz5NUPWLWAdQIg5AO6lJlbajptrj3smzDblOT25xF7LTiBMfY75PPbZBH0vHP3hDNqFmZBPjKipqwZDZD
    "id": "1998985623505953",
    "name": "David Berruezo"
}
*/
?>
<script>

    /*
    window.fbAsyncInit = function() {
        FB.init({
            appId      : 'EAACEdEose0cBADc6OAPvP8B2aHmW7PYZB1frX4sylkzmXYpMZCoz8xDHEvC6ZCXZBK1aoYrOVPrw0979AyEm2A1qGV8wGYHLemu4p7mTjk0Haq1LwAINZBMcssYDuhpxSz5NUPWLWAdQIg5AO6lJlbajptrj3smzDblOT25xF7LTiBMfY75PPbZBH0vHP3hDNqFmZBPjKipqwZDZD',
            cookie     : true,
            xfbml      : true,
            version    : '{latest-api-version}'
        });

        FB.AppEvents.logPageView();

    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    */
</script>
<?php
include_once("vendor/autoload.php");

/*
$fb = new \Facebook\Facebook([
    'app_id' => '879788445536807',
    'app_secret' => 'ef9d13a1704339b62e170618d575ee6b',
    'default_graph_version' => 'v2.10',
    //'default_access_token' => '{access-token}', // optional
]);
*/

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();
/*
try {
    // Get the \Facebook\GraphNodes\GraphUser object for the current user.
    // If you provided a 'default_access_token', the '{access-token}' is optional.
    $response = $fb->get('/me', '{access-token}');
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
$me = $response->getGraphUser();
echo 'Logged in as ' . $me->getName();
*/
?>