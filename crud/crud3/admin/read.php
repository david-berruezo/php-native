<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
// instantiate database and product object
$database = new Database();
$db       = $database->getConnection();
// initialize object
$product = new Product($db);
// query products
//$stmt = $product->readAll();
$stmt = $product->paging();
$valor = $product->paginglink();
$num  = $stmt->rowCount();
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
        $productos[$contador]['url']         = $row['url'];
        $contador++;
    }
    //$productos = json_encode($productos);
    $resp               = array();
    $resp['response']   = true;
    $resp['msg']        = "Record deleted successfully";
    $resp['productos']  = $productos;
    $resp['valor']      = $valor;
    echo json_encode($resp);
    // Pasado a Ajax
    /*
    echo "<table class='table table-bordered table-hover'>";
    echo "<tr>";
    echo "<th class='width-30-pct'>Name</th>";
    echo "<th class='width-30-pct'>Description</th>";
    echo "<th>Price</th>";
    echo "<th>Created</th>";
    echo "<th style='text-align:center;'>Action</th>";
    echo "</tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        echo "<tr>";
        echo "<td>{$name}</td>";
        echo "<td>{$description}</td>";
        echo "<td>{$price}</td>";
        echo "<td>{$created}</td>";
        echo "<td style='text-align:center;'>";
        echo "<div class='product-id display-none'>{$id}</div>";
        echo "<div class='btn btn-info edit-btn margin-right-1em'>";
        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
        echo "</div>";
        echo "<div class='btn btn-danger delete-btn'>";
        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
    //end table
    echo "</table>";
    */
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