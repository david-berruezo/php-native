<?php

include_once("EmailLinker.class.php");
$linker = new EmailLinker();

$linker->redirectIfNeeded();

$javascript = $linker->getJavascript();

$content = <<<__CONTENT__
<html>
  <head>
    <title>Email linker test</title>
    $javascript
  </head>
  <body>
    <p>This paragraph contains an email: security@php.net</p>
  </body>
</html>
__CONTENT__;

echo $linker->link( $content )."\n";

?>
