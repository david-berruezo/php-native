<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
// instantiate database and product object
$database = new Database();
$db       = $database->getConnection();
// initialize object
$product  = new Product($db);
// search
$product->opcionBusqueda = $_GET["opcionBuscador"];
$product->busqueda       = $_GET["texto"];
//echo ("opcion: " .$product->opcionBusqueda. " busqueda" .$product->busqueda);
$stmt  = $product->search();
$valor = $product->searchPaginatorHtml();
$num   = $stmt->rowCount();
//echo ("parametros: ".$_GET['page_no']);
// check if more than 0 record found
if($num > 0){
    $productos = array();
    $contador  = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //print_r($row);
        $productos[$contador]['id']          = $row['id'];
        $productos[$contador]['name']        = $row['name'];
        $productos[$contador]['description'] = $row['description'];
        $productos[$contador]['price']       = $row['price'];
        $productos[$contador]['created']     = $row['created'];
        $productos[$contador]['url']     = $row['url'];
        $contador++;
    }
    //$productos = json_encode($productos);
    $resp               = array();
    $resp['response']   = true;
    $resp['msg']        = "Record deleted successfully";
    $resp['productos']  = $productos;
    $resp['valor']      = $valor;
    echo json_encode($resp);
}
// tell the user if no records found
else{
    echo "<div class='alert alert-info'>No records found.</div>";
    $resp               = array();
    $resp['response']   = false;
    $resp['msg']        = "No hay productos";
    echo json_encode($resp);
}
?>