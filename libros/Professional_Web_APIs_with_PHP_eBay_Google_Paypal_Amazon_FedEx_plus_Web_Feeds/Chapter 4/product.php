<?php
  header("Content-Type: text/xml");
  include("../common_db.php");
  require('Smarty.class.php');
  $smarty = new Smarty;
  $smarty->template_dir = '/www/smarty/example.preinheimer.com/templates/';
  $smarty->compile_dir = '/www/smarty/example.preinheimer.com/templates_c/';
  $smarty->config_dir = '/www/smarty/example.preinheimer.com/configs/';
  $smarty->cache_dir = '/www/smarty/example.preinheimert.com/cache/';
  
   $query = "SELECT id, name, description, category, unit, price
    FROM 03_store_products ORDER BY id";
    $tips = getAssoc($query, 2);
    
   $url = "http://example.preinheimer.com/store/index.php";
  
  
  $smarty->assign('url', $url);
  $smarty->assign('tips', $tips);
  $smarty->display('product.tpl');
?>