<?php
require_once "../vendor/autoload.php";
$smarty = new Smarty();
// set a single directory where the templates are stored
$smarty->setTemplateDir('../cache');
// view the template dir chain
var_dump($smarty->getTemplateDir());
// set multiple directoríes where templates are stored
/*
$smarty->setTemplateDir(array(
    'one' => './templates',
    'two' => './templates_2',
    'three' => './templates_3',
));
*/
// view the template dir chain
var_dump($smarty->getTemplateDir());
// chaining of method calls
$smarty->setTemplateDir('../templates')
    ->setCompileDir('../templates_c')
    ->setCacheDir('../cache');
$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
if(!$smarty->isCached('index.tpl')) {
    echo "no cacheado<br>";
}else{
    echo "cacheado<br>";
}
/*
$smarty->assign('name','David');
$smarty->assign('surname','Berruezo');
$smarty->display('index.tpl');
*/
?>