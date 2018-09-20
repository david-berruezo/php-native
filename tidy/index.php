<?php
$html = '<p>test</I>';
$tidy = tidy_parse_string($html);
$tidy->cleanRepair();
echo $tidy;
var_dump($tidy);
echo $tidy->value;
?>
