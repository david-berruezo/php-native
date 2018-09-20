<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Read Products</title>
    <!-- bootstrap CSS -->
    <link href="../libs/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" media="screen" />
    <link href="../libs/css/style.css" rel="stylesheet" media="screen" />
    <!-- jQuery library -->
    <script src="../libs/js/jquery-2.2.4.js"></script>
    <script src="../libs/js/funciones.js"></script>
    <!-- bootstrap JavaScript -->
    <script src="../libs/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--<script src="libs/js/bootstrap/docs-assets/js/holder.js"></script>-->
    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- container -->
<div class="container">
    <div class='page-header'>
        <h1 id='page-title'>Read Products</h1>
        <div class='margin-bottom-1em overflow-hidden'>
            <!-- when clicked, it will show the product's list -->
            <div id='read-products' class='btn btn-primary pull-right display-none'>
                <span class='glyphicon glyphicon-list'></span> Read Products
            </div>
            <!-- when clicked, it will load the create product form -->
            <div id='create-product' class='btn btn-primary pull-right'>
                <span class='glyphicon glyphicon-plus'></span> Create Product
            </div>
            <!-- this is the loader image, hidden at first -->
            <div id='loader-image'><img src='../images/ajax-loader.gif' /></div>
        </div>
    </div>
    <br>
    <!-- Buscador -->
    <div class="container">
        <div class="row" style="padding-left:0px;padding-right:0px;">
            <div class="col-xs-4 col-md-4 col-lg-4 col-sm-4">
                <div class="input-group">
                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span id="search_concept">Filter by</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" data-buscador="all">All</a></li>
                            <li><a href="#" data-buscador="name">Name</a></li>
                            <li><a href="#" data-buscador="description">Description</a></li>
                        </ul>
                    </div>
                    <input type="hidden" name="search_param" value="all" id="search_param">
                    <input type="text" class="form-control" id="textobuscar" name="x" placeholder="Search term...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="buscador"><span class="glyphicon glyphicon-search"></span></button>
                </span>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- this is where the contents will be shown. -->
    <div id='page-content'></div>
    <!-- content will be here -->
    <div class="pagination-wrap">
    </div>
</div>
<!-- /container -->
</body>
</html>