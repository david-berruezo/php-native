<?php
/**
 * function to emulate the register_globals setting in PHP
 * for all of those diehard fans of possibly harmful PHP settings <img draggable="false" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/72x72/1f642.png">
 * @author Ruquay K Calloway
 * @param string $order order in which to register the globals, e.g. 'egpcs' for default
 * @link hxxp://www.php.net/manual/en/security.globals.php#82213
 */

//register_globals();
//test_global();


// Generate a formatted list with all globals
//----------------------------------------------------
// Custom global variable $_CUSTOM
$_CUSTOM = array(
    'USERNAME' => 'john',
    'USERID'   => '18068416846'
);

$vector = array(
    "variable1" => 'Pepe'
);

// List here whichever globals you want to print
// This could be your own custom globals
$globals = array(
    '$_SERVER' => $_SERVER, '$_ENV' => $_ENV,
    '$_REQUEST' => $_REQUEST, '$_GET' => $_GET,
    '$_POST' => $_POST, '$_COOKIE' => $_COOKIE,
    '$_FILES' => $_FILES, '$_CUSTOM' => $_CUSTOM
);

print_r ("hola" . $GLOBALS['vector[variable1]'] . "<br>");

?>
<html>
<style>
    <?php // Adjust CSS formatting for your output  ?>
    .left {
        font-weight: 700;
    }
    .right {
        font-weight: 700;
        color: #009;
    }
    .key {
        color: #d00;
        font-style: italic;
    }
</style>
<body>
<?php
// Generate the output
echo '<h1>Superglobals</h1>';
foreach ($globals as $globalkey => $global) {
    echo '<h3>' . $globalkey . '</h3>';
    foreach ($global as $key => $value) {
        echo '<span class="left">' . $globalkey . '[<span class="key">\'' . $key . '\'</span>]</span> = <span class="right">' . $value . '</span><br />';
    }
}
?>
</body>
</html>

<?php
function test_global()
{
    // La mayoría de variables predefinidas no son "super" y requieren
    // 'global' para estar disponibles al ámbito local de las funciones.
    global $HTTP_POST_VARS;
    var_dump($HTTP_POST_VARS);

    echo "Hola" . $HTTP_POST_VARS['name'] . "<br>";

    // Las superglobales están disponibles en cualquier ámbito y no
    // requieren 'global'. Las superglobales están disponibles desde
    // PHP 4.1.0, y ahora HTTP_POST_VARS se considera obsoleta.
    echo $_GET['name'];
}


function register_globals($order = 'egpcs')
{
    echo('Hola<br>');
    // define a subroutine
    if(!function_exists('register_global_array'))
    {
        echo('Hola1<br>');
        function register_global_array(array $superglobal)
        {
            echo('Hola2<br>');
            foreach($superglobal as $varname => $value)
            {
                echo('Hola3<br>');
                global $$varname;
                $$varname = $value;
            }
        }
    }

    $order = explode("\r\n", trim(chunk_split($order, 1)));
    foreach($order as $k)
    {
        switch(strtolower($k))
        {
            case 'e':    register_global_array($_ENV);      break;
            case 'g':    register_global_array($_GET);      break;
            case 'p':    register_global_array($_POST);     break;
            case 'c':    register_global_array($_COOKIE);   break;
            case 's':    register_global_array($_SERVER);   break;
        }
    }
}


/**
 * Undo register_globals
 * @author Ruquay K Calloway
 * @link hxxp://www.php.net/manual/en/security.globals.php#82213
 */
function unregister_globals() {
    if (ini_get(register_globals)) {
        $array = array('_REQUEST', '_SESSION', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

