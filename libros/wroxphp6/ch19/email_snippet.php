<?php
$mime_boundary = "<<<-==+X[".md5(time())."]";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed;\r\n";
$headers .= " boundary=\"".$mime_boundary."\"";
$message .= "This is a multi-part message in MIME format.\r\n";
$message .= "\r\n";
$message .= "-".$mime_boundary."\r\n";
$message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n";
$message .= "\r\n";?>
