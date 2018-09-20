<?php
/*
 * Cogemos variables por ajax
 */
if (isset($_GET["idioma"])){
    //echo "El idioma es: ".$_GET["idioma"]."<br>";
    $idioma  = $_GET["idioma"];
    //$vector = array("response" => true,"idioma" => $idioma);
    //echo json_encode($vector);
}else{
    //echo "El idioma es: ".$idioma."<br>";
    $idioma = "esp";

}
/*
echo "El idioma es: ".$idioma."<br>";
//return $json_encode();
if ($idioma == "esp"){
    $menu          = array();
    $paso          = array();
    $labelPasos    = array();
    $menu[0]       = "QUIERO SER REPARTIDOR";
    $menu[1]       = "FAQS";
    $menu[2]       = "TU NEGOCIO";
    $trespasos     = "En 3 pasos la compra en tu CASA !!!";
    $labelPasos[0] = "Paso 1";
    $labelPasos[1] = "Paso 2";
    $labelPasos[2] = "Paso 3";
    $paso[0]       = "Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero";
    $paso[1]       = "Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero";
    $paso[2]       = "Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero";
}else{
    $menu          = array();
    $paso          = array();
    $labelPasos    = array();
    $menu[0]       = "VULL SER REPARTIDOR";
    $menu[1]       = "FAQS";
    $menu[2]       = "EL TEU NEGOCI";
    $trespasos     = "En 3 pasos la compra a casa TEVA !!!";
    $labelPasos[0] = "Pas 1";
    $labelPasos[1] = "Pas 2";
    $labelPasos[2] = "Pas 3";
    $paso[0]       = "Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero";
    $paso[1]       = "Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero";
    $paso[2]       = "Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero";
}
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CityXerpa</title>
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <!-- Plugin CSS -->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendor/device-mockups/device-mockups.min.css">
    <!-- Theme CSS -->
    <link href="css/www-embed-player-vfltlGLpQ.css" rel="stylesheet">
    <link href="css/new-age.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <!-- Theme JavaScript -->
    <script src="js/new-age.min.js"></script>
    <!-- Theme JavaScript -->
    <script src="js/funciones.js"></script>
</head>

<div class="contenedorVideo">
    <!-- <iframe id="video"></iframe> -->
    <iframe id="video" src="//www.youtube.com/embed/Xp4rsxhZtew?autoplay=1&loop=1&controls=0&&playlist=757I7a-UNrI&modestbranding=1&playsinline=1&showinfo=0&start=1"  allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" allowfullscreen frameborder="0" width="324px;" height="324px;"></iframe>
    <!-- S0rtZvA3rXY -->
    <!--757I7a-UNrI-->
    <!--Xp4rsxhZtew-->
    <!-- ?autoplay=1&loop=1&controls=0&&playlist=757I7a-UNrI&modestbranding=1&playsinline=1&showinfo=0&start=1 -->
    <a href="#" class="webapp"><p>Iniciar WebApp</p></a>
    <div class="contenedorBotones">
        <a href="#"><img src="imagenes/googleplay.png"></a>
        <a href="#"><img src="imagenes/appstore.png"></a>
    </div>
</div>

<body id="page-top">

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="<?php $_SERVER['HTTP_HOST']; ?>index.php?idioma=<?php echo $idioma; ?>" ><!--Start Bootstrap-->
                <div class="cuadro">
                    <img src="imagenes/logosuperior.png" class="logosuperior">
                </div>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($idioma == "esp"){ ?>
                    <li class="page-scroll"><a href="<?php $_SERVER['HTTP_HOST']; ?>repartidor.php?idioma=esp">QUIERO SER REPARTIDOR</a></li>
                <?php }else{ ?>
                    <li class="page-scroll"><a href="<?php $_SERVER['HTTP_HOST']; ?>repartidor.php?idioma=cat">VULL SER REPARTIDOR</a></li>
                <?php } ?>
                <?php if ($idioma == "esp"){ ?>
                    <li class="page-scroll"><a href="<?php $_SERVER['HTTP_HOST']; ?>faq.php?idioma=esp">FAQS</a></li>
                <?php }else{ ?>
                    <li class="page-scroll"><a href="<?php $_SERVER['HTTP_HOST']; ?>faq.php?idioma=cat">FAQS</a></li>
                <?php } ?>
                <?php if ($idioma == "esp"){ ?>
                    <li class="page-scroll"><a href="<?php $_SERVER['HTTP_HOST']; ?>negocio.php?idioma=esp">TU NEGOCIO</a></li>
                <?php }else{ ?>
                    <li class="page-scroll"><a href="<?php $_SERVER['HTTP_HOST']; ?>negocio.php?idioma=cat">EL TEU NEGOCI</a></li>
                <?php } ?>
                <li class="page-scroll"><a href="<?php $_SERVER['HTTP_HOST']; ?>?idioma=cat" class="idiomacatalan"><img src="imagenes/andorrapetita.jpg"></a></li>
                <li class="page-scroll"><a href="<?php $_SERVER['HTTP_HOST']; ?>?idioma=esp" class="idiomaespanol"><img src="imagenes/espanola.jpg"></a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<header>

    <?php if ($idioma == "esp") { ?>
        <h3 class="compra">En 3 pasos la compra en tu CASA !!!</h3>
    <?php }else{ ?>
        <h3 class="compra">En 3 pasos la compra a casa TEVA !!!</h3>
    <?php }?>

    <ul class="contenedorMoviles">
        <li><img src="imagenes/movil1.png"></li>
        <li><img src="imagenes/movil2.png"></li>
        <li><img src="imagenes/movil3.png"></li>
    </ul>

    <ul class="contenedorTextos">
            <?php if ($idioma == "esp") { ?>
                <li>
                    <h3>PASO 1</h3>
                    <p>Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero</p>
                </li>
                <li>
                    <h3>PASO 2</h3>
                    <p>Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero</p>
                </li>
                <li>
                    <h3>PASO 3</h3>
                    <p>Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero</p>
                </li>
            <?php }else{ ?>
                <li>
                    <h3>PAS 1</h3>
                    <p>Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero</p>
                </li>
                <li>
                    <h3>PAS 2</h3>
                    <p>Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero</p>
                </li>
                <li>
                    <h3>PAS 3</h3>
                    <p>Lorem ipsum dolor sit amet, risus arcu ullamcorper turpis. Elit tempus convallis non mi suspendisse ipsum, rhoncus odio at pulvinar dictum egestas convallis, sociis velit elementum vel amet magna, itaque quod purus libero libero</p>
                </li>
            <?php } ?>
    </ul>

</header>

<footer>
    <!--<div class="container">-->
    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
        <div class="footer">
            <div class="page-form">
                <div class="contenedorImagenFooter">
                    <img src="imagenes/logoinferior.png" class="imagenFooter">
                </div>
                <p style="color:#ffffff;text-align:center;margin-top:10px;">© Copiright CityXerpa</p>
            </div>
            <br>
            <hr class="barraFooter"/>
            <div class="baraiconos">
                <ul class="iconlist">
                    <li><a href="https://www.facebook.com/cityxerpa/"><img src="imagenes/facebookbueno.png" style="width:25px;height:25px;"></a></li>
                    <li><a href="https://twitter.com/CityXerpa"><img src="imagenes/twitterbueno.png" style="width:25px;height:25px;"></a></li>
                    <li><a style="color:#ffffff;" href="https://plus.google.com/110098349101438449603"><img src="imagenes/googleplus.png" style="width:25px;height:25px;"></a></li>
                    <li><a href="https://www.instagram.com/cityxerpa_es/"><img src="imagenes/instagram.png" style="width:25px;height:25px;"></a></li>
                </ul>
            </div>
            <br style="clear:both;">
            <hr class="barraFooter">
        </div>
    </div>

</footer>

</body>

</html>
