<?php
if (isset($_GET["idioma"])){
    //echo "El idioma es: ".$_GET["idioma"]."<br>";
    $idioma = $_GET["idioma"];
}else{
    $idioma = "esp";
    //echo "El idioma es: ".$idioma."<br>";
}
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
    <link href="css/new-age.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <!--
    <script src="js/jquery.js"></script>
    <script src="js/jquery-migrate-1.2.1.js"></script>
    -->
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <!-- Theme JavaScript -->
    <script src="js/new-age.min.js"></script>
    <script src="js/funciones.js"></script>
    <![endif]-->
</head>

<body id="page-top">
<!--<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" class="img-responsive" style="background-image:url('imagenes/imagen5.jpg');height:300px;background-size:cover;background-position:0px -400px;background-repeat: no-repeat;margin:0px;padding:0px;"></div> -->

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
                    <li class="page-scroll"><a class="faq" href="<?php $_SERVER['HTTP_HOST']; ?>repartidor.php?idioma=esp">QUIERO SER REPARTIDOR</a></li>
                <?php }else{ ?>
                    <li class="page-scroll"><a class="faq" href="<?php $_SERVER['HTTP_HOST']; ?>repartidor.php?idioma=cat">VULL SER REPARTIDOR</a></li>
                <?php } ?>
                <?php if ($idioma == "esp"){ ?>
                    <li class="page-scroll"><a class="faq" href="<?php $_SERVER['HTTP_HOST']; ?>faq.php?idioma=esp">FAQS</a></li>
                <?php }else{ ?>
                    <li class="page-scroll"><a class="faq" href="<?php $_SERVER['HTTP_HOST']; ?>faq.php?idioma=cat">FAQS</a></li>
                <?php } ?>
                <?php if ($idioma == "esp"){ ?>
                    <li class="page-scroll"><a class="faq" href="<?php $_SERVER['HTTP_HOST']; ?>negocio.php?idioma=esp">TU NEGOCIO</a></li>
                <?php }else{ ?>
                    <li class="page-scroll"><a class="faq" href="<?php $_SERVER['HTTP_HOST']; ?>negocio.php?idioma=cat">EL TEU NEGOCI</a></li>
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
    <div class="page-form" style="margin-top:50px;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="margin-top:30px;">
                <?php if ($idioma == "esp") { ?>
                    <h3 style="color:#000000;">FAQS</h3>
                <?php }else{ ?>
                    <h3 style="color:#000000;">FAQS</h3>
                <?php } ?>
                <hr class="barra">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <h3 style="color:#e10238;">Pregunta 1</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.
                </p>
                <h3 style="color:#e10238;">Pregunta 2</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.
                </p>
                <h3 style="color:#e10238;">Pregunta 3</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.
                </p>
                <h3 style="color:#e10238;">Pregunta 4</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.
                </p>
                <h3 style="color:#e10238;">Pregunta 5</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.

                </p>
                <h3 style="color:#e10238;">Pregunta 6</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.

                </p>
                <h3 style="color:#e10238;">Pregunta 7</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.

                </p>
                <h3 style="color:#e10238;">Pregunta 8</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.

                </p>
                <h3 style="color:#e10238;">Pregunta 9</h3>
                <p style="color:#000000;">
                    Lorem ipsum dolor sit amet, mei agam illud aliquip ne, paulo ocurreret nam id. Lorem solet eu duo, an quo animal aperiam evertitur, at vix agam vitae dolore. Legimus suscipit repudiandae ne his. Delenit labores conceptam no est, ius ei accusam atomorum, nam labore doctus ad. Ad consul alterum periculis vim. Eirmod persius no cum, iusto accusam ea per. Ea verterem temporibus usu.

                </p>
            </div>
        </div>
    </div>

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
