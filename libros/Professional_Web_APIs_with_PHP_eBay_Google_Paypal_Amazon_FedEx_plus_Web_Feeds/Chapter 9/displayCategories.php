<?php
function displayCatagoryListings($parent = -1)
{
 $xml = getCategories($parent);
 foreach($xml->GetCategoriesResponse->CategoryArray->Category AS $category)
 {
   if ($category->CategoryID == $parent)
   {
     if ($category->CategoryLevel == 1)
     {
      echo "<h3>{$category->CategoryName}</h3>";
      echo "(<a href=\"?\">Return to parent</a>)\n\n";
     }else 
     {
       echo "<h3>{$category->CategoryName}</h3>";
       echo "(<a href=\"?loadCat={$category->CategoryParentID}\">Return to parent
         </a>)\n";
     }
   }else
   {
     if ($category->CategoryParentID == $parent || $parent == -1)
     {
       if ($category->LeafCategory == "true")
       {
         echo "<span class=\"catTitle\">{$category->CategoryName}</span> 
           (<a href=\"?listCategory={$category->CategoryID}\" 
           class=\"viewItems\">view items</a>)\n";
       }else 
       {
         echo "<a href=\"?loadCat={$category->CategoryID}\" class=\"catTitle\">
        {$category->CategoryName}</a> (<a href=\"?listCategory=
        {$category->CategoryID}\" class=\"viewItems\">view items</a>) \n"; 
       }
     }
   }
 } 
}
?>