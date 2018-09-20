<?php
$strDSN = "pgsql:dbname=chaptersix;host=localhost;port=5432;user=chaptersix;
                        password=chaptersix";

// Let's connect
try {
  $objPDO = new PDO($strDSN);
  $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Let's interrogate the database
$i = 0;
$strQuery = "SELECT * FROM \"user\"";
$objStatement = $objPDO->prepare($strQuery);
$objStatement->execute();
while ($arRow = $objStatement->fetch(PDO::FETCH_ASSOC)) {
        print "Row $i<br />\n";
        foreach ($arRow as $key => $value) {
                print " - Column $key, value $value<br />\n";
        };
        $i++;
};

// Let's disconnect
$objPDO = NULL;

} catch (PDOException $e) {
  echo "An error occured connecting: " . $e->getMessage() . "<br />\n";
  list($strCode, $strCode2, $strInfo) = $objPDO->errorInfo();
  print "PDO: - Code was '$strCode',<br /> - Driver code was '$strCode2',<br /> -
        Info string was '$strInfo'";
  if ($objStatement instanceof PDOStatement) {
          list($strCode, $strCode2, $strInfo) = $objStatement->errorInfo();
          print "<br /><br />PDO Statement: - Code was '$strCode',<br /> - Driver
                 code was '$strCode2',<br /> - Info string was '$strInfo'";
  };
  exit(0);
}


?>