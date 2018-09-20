<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 18:34
 */
//error_reporting(E_ERROR & E_PARSE);
$variable = "Pepe";
$str = addslashes('What does "yolo" mean?<br>');
//echo($str);
$str = addslashes('Que pasa "Pepe" como estas ?<br>');
//echo($str);
$str = addslashes("Que pasa \Golfo\ como estas ?<br>");
//echo($str);
$cadena = "http://" .$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
//echo "La cadena es: ".$cadena;
//var_dump($_POST);
if (isset($_POST["submit"])) {
    var_dump($_POST);
    $pass  = $_POST["exampleInputPassword1"];
    $user  = $_POST["exampleInputEmail1"];
    $texto = $_POST["texto"];
    echo "Usuario: " .$user. " Password: " .$pass. " texto: " .$texto. "<br>" ;
    $_POST["exampleInputPassword1"] = addslashes($_POST["exampleInputPassword1"]);
    $_POST["exampleInputEmail1"]    = addslashes($_POST["exampleInputEmail1"]);
    $_POST["texto"]                 = addslashes($_POST["texto"]);
    $pass  = $_POST["exampleInputPassword1"];
    $user  = $_POST["exampleInputEmail1"];
    $texto = $_POST["texto"];
    echo "Usuario: " .$user. " Password: " .$pass. " texto: " .$texto. "<br>" ;
}else{
    echo("No hay post");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="../bootstrap/jquery/jquery-2.2.3.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap-theme.min.css">
    <script src="../bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
     <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-md-12">
            <form name="form1" id="form1" role="form" method="post" action="<?=$_SERVER['PHP_SELF']?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="exampleInputEmail1" id="exampleInputEmail1" placeholder="Email">
                    <input type="text" name="texto" id="texto" value="Hola que tal">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="exampleInputPassword1" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" id="exampleInputFile" name="exampleInputFile">
                    <p class="help-block">Example block-level help text here.</p>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Check me out
                    </label>
                </div>
                <button type="submit" name="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
     </div>
    </div>
</body>
</html>
