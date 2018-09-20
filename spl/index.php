<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 23/06/2016
 * Time: 11:31
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spl</title>
</head>
<body>
<?php
// $Id$
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/';
    // Replace namespace separators with directory separators.
    // Append '.php'
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file))
    {
        require $file;
    }
});
?>
</body>
</html>