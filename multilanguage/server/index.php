<?php include_once("config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manejo de idiomas con sesiones</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css"></link>
    <style>
        .footer{
            left:0;
            position:fixed;
            bottom:10px;
            text-align:center;
            color:white;
            width:100%;
            height:20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">
            <li class"nav-item">
                <a href="#" class="nav-link" href="#"><?php echo $lang["home"]; ?></a>            
            </li>
            <li class"nav-item">
                <a href="#" class="nav-link" href="#"><?php echo $lang["pricing"]; ?></a>            
            </li>
            <li class"nav-item">
                <a href="#" class="nav-link" href="#"><?php echo $lang["contact"]; ?></a>            
            </li>
        </ul>
    </nav>
    <div class="container" style="margin-top:100px;">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3 text-center">
                <h1><?php echo $lang["title"]; ?></h1>
                <p>
                <?php echo $lang["description"]; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="footer bg-dark">
        <a href="<?php echo $_SERVER['PHP_SELF']."?lang=en";?>">English</a> | <a href="<?php echo $_SERVER['PHP_SELF']."?lang=es";?>">Spanish</a>
    </div>
</body>
</html>