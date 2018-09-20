<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/07/2016
 * Time: 11:01
 */

/*
 * Array de FILES es
 */

$vector = array(
    "file1" => array(
        "name"     => "MyFile.txt (comes from the browser, so treat as tainted)",
        "type"     => "text/plain  (not sure where it gets this from - assume the browser, so treat as tainted)",
        "tmp_name" => "tmp/php/php1h4j1o (could be anywhere on your system, depending on your config settings, but the user has no control, so this isn't tainted)",
        "error"    => "UPLOAD_ERR_OK  (= 0)",
        "size"     => "123   (the size in bytes)"
    )
);
?>