<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 18/07/2016
 * Time: 6:36
 */
function callback($búfer)
{
    // reemplazar todas las manzanas por naranjas
    return (str_replace("manzanas", "naranjas", $búfer));
}
ob_start("callback");
?>
<html>
<body>
    <p>Es como comparar manzanas con naranjas.</p>
</body>
</html>
<?php ob_end_flush(); ?>

