<?php
$strDSN = "pgsql:dbname=chaptersix;host=localhost;port=5432;user=chaptersix;password=chaptersix";

// Let's connect
try {
  $objPDO = new PDO($strDSN);
  print "Successfully connected ....\n";
} catch (PDOException $e) {
  echo "An error occured connecting: " . $e->getMessage() . "\n";
  exit(0);
}

// Let's disconnect
$objPDO = NULL;
print "Successfully disconnected.\n";

?>