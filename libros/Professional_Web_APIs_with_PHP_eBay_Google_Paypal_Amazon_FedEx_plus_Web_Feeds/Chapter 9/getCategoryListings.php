<?php
function getCategoryListings($category)
{
  $call = "GetCategoryListings";
  $attributes = array();
  $attributes['Version'] = 425;
  $attributes['CategoryID'] = $category;
  $myRequest = generateBody($call, $attributes);
  $message = generateRequest($myRequest);
  $xml = calleBay($call, $message, FALSE); 
  echo "<h3>Listings in {$xml->GetCategoryListingsResponse->Category->
    CategoryName}</h3>\n";
  $parentID = getCatagoryID($xml->GetCategoryListingsResponse->Category->
    CategoryID);
  echo "Return to <a href=\"?loadCat={$parentID}\">Categories</a> Listing\n"; 

  if (isset($xml->GetCategoryListingsResponse->ItemArray->Item))
  {
    foreach($xml->GetCategoryListingsResponse->ItemArray->Item AS $item)
    {
      echo "<a href=\"?{$item->ItemID}\">{$item->Title}</a> currently has a high 
        bid of $ {$item->SellingStatus->CurrentPrice} after a total of {$item->
        SellingStatus->BidCount} bids\n";
    }
  }else 
  {
    echo "No listings, Sorry\n"; 
  }

  if (isset($xml->GetCategoryListingsResponse->SubCategories->Category))
  {
    echo "<h3>Sub-Categories</h3>";
    foreach($xml->GetCategoryListingsResponse->SubCategories->Category AS 
      $category)
    {
       echo "<a href=\"?listCategory={$category->CategoryID}\">{$category->
       CategoryName}</a> has {$category->NumOfItems} items listed\n";
    }
  }
}
?>