<?php
function getVectorLabelProductos()
{
    $vectorProductosLabel = array(
        "ID",
        "Active",
        "Name",
        "Categories",
        "Price",
        "Tax",
        "Wholesale price",
        "OnSale",
        "Discount",
        "DiscountPercent",
        "DiscountFrom",
        "DiscountTo",
        "Reference",
        "SupplierReference",
        "Supplier",
        "Manufacturer",
        "Ean13",
        "Upc",
        "Ecotax",
        "Width",
        "Height",
        "Depth",
        "Weight",
        "Quantity",
        "MinimalQuantity",
        "Visibility",
        "AdditionalShippingCost",
        "Unity",
        "UnityPrice",
        "ShortDescription",
        "Description",
        "Tags",
        "Metatitle",
        "MetaKeywords",
        "MetaDescription",
        "UrlRewritten",
        "TextStock",
        "TextBackorder",
        "Avaiable",
        "ProductAvaiableDate",
        "ProductCreationDate",
        "ShowPrice",
        "ImageUrls",
        "DeleteExistingImages",
        "Feature",
        "AvaiableOnline",
        "Condition",
        "Customizable",
        "Uploadable",
        "TextFields",
        "OutStock",
        "IdNameShop",
        "AdvancedStockManagement",
        "DependsOnStock",
        "Warehouse"
    );
    return $vectorProductosLabel;
}
    $vectorProductos = array();
    $output          = fopen('prueba_import.csv', 'w');
    for ($i=0;$i<30000;$i++){
        $producto = getVectorLabelProductos();
        array_push($vectorProductos,$producto);
    }
    foreach ($vectorProductos as $campo) {
        fputcsv($output, $campo,';');
    }
    fclose($output);
?>