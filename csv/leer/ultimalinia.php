<?php
/*
 * Obtener la última linia
 */
$rows     = file('categories_import.csv');
$last_row = array_pop($rows);
$data     = str_getcsv($last_row);
var_dump($data);

/*
 * Guradamos un nuevo registro
 */
$output    = fopen('categories_import.csv', 'a');
$vectorCat = array();
$vectorCategoriasLabel = array(
    "ID",
    "Active (0/1)",
    "Name *",
    "Parent category",
    "Root category (0/1)",
    "Description",
    "Meta title",
    "Meta keywords",
    "Meta description",
    "URL rewritten",
    "Image URL"
);
array_push($vectorCat,$vectorCategoriasLabel);
foreach ($vectorCat as $campo) {
    fputcsv($output, $campo,';');
}
fclose($output);
?>