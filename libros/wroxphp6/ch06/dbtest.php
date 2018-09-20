<?php
$objHandle = pg_connect("host=localhost port=5432 dbname=chaptersix user=chaptersix password=chaptersix");
if (!$objHandle) {
  echo "An error occured connecting.\n";
  exit;
}
$objResult = pg_query($objHandle, "SELECT * FROM \"user\"");
if (!$objResult) {
  echo "An error occured querying.\n";
  exit;
};
$arRowHash = pg_fetch_all($objResult);
for ($i=0; $i<=sizeof($arRowHash)-1; $i++) {
        print "Row $i<br />\n";
        foreach ($arRowHash[$i] as $key => $value) {
                print " - Column $key, value $value<br />\n";
        };
};
pg_close($objHandle);
?>