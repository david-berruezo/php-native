<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
// instantiate database and product object
$database = new Database();
$db       = $database->getConnection();
// initialize object
$product  = new Product($db);

if (!isset($_GET["productos"])) {
// Paginador
    $sqlQuery = $db->query("SELECT * FROM products");
    $count = $sqlQuery->rowCount();
    $adjacents = 2;
    $records_per_page = 5;
    $page = (int)(isset($_POST['page_id']) ? $_POST['page_id'] : 1);
    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $records_per_page;
    $next = $page + 1;
    $prev = $page - 1;
    $last_page = ceil($count / $records_per_page);
    $second_last = $last_page - 1;
    $pagination = "";
    if ($last_page > 1) {
        $pagination .= "<div class='pagination'>";
        if ($page > 1)
            $pagination .= "<a href='javascript:void(0);' onClick='change_page(1);'>&laquo; First</a>";
        else
            $pagination .= "<span class='disabled'>&laquo; First</span>";
        if ($page > 1)
            $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($prev) . ");'>&laquo; Previous&nbsp;&nbsp;</a>";
        else
            $pagination .= "<span class='disabled'>&laquo; Previous&nbsp;&nbsp;</span>";
        if ($last_page < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $last_page; $counter++) {
                if ($counter == $page)
                    $pagination .= "<span class='current'>$counter</span>";
                else
                    $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
            }
        } elseif ($last_page > 5 + ($adjacents * 2)) {
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class='current'>$counter</span>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }
                $pagination .= "...";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($second_last) . ");'> $second_last</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($last_page) . ");'>$last_page</a>";
            } elseif ($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
                $pagination .= "...";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class='current'>$counter</span>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }
                $pagination .= "..";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($second_last) . ");'>$second_last</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($last_page) . ");'>$last_page</a>";
            } else {
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
                $pagination .= "..";
                for ($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class='current'>$counter</span>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }
            }
        }
        if ($page < $counter - 1)
            $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($next) . ");'>Next &raquo;</a>";
        else
            $pagination .= "<span class='disabled'>Next &raquo;</span>";

        if ($page < $last_page)
            $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($last_page) . ");'>Last &raquo;</a>";
        else
            $pagination .= "<span class='disabled'>Last &raquo;</span>";

        $pagination .= "</div>";
    }

    $product->start             = $start;
    $product->records_per_page  = $records_per_page;
    echo $pagination;
}

if (isset($_GET["productos"]) && $_GET["productos"] == true ){
// Pasamos variables al objeto
//$product->start             = $start;
//$product->records_per_page  = $records_per_page;
//echo("start".$start);
//echo("records".$records_per_page);
// query products
$stmt     = $product->readPaination();
$num      = $stmt->rowCount();
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
    echo json_encode($resp);
    // Pasado a Ajax
}else{
    echo "<div class='alert alert-info'>No records found.</div>";
    $resp               = array();
    $resp['response']   = false;
    $resp['msg']        = "No hay productos";
    echo json_encode($resp);
}
}

/*
$records 	= $db->query("SELECT * FROM products LIMIT $start, $records_per_page");
$count  	= $records->rowCount();
$HTML='';
if($count > 0)
{
    foreach($records as $row) {
        $HTML.='<div>';
        $HTML.= $row['first_name'];
        $HTML.='</div><br/>';
    }
}else{
    $HTML='No Data Found';
}
echo $HTML;
*/
?>
