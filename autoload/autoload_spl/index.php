<?php
spl_autoload_register( 'simplarity_autoloader' ); // Register autoloader

function simplarity_autoloader( $class_name ) {

    if ( false !== strpos( $class_name, 'pisos' ) ) {
        echo "Hola";
        /*
        $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'pisos' . DIRECTORY_SEPARATOR;
        $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_name ) . '.php';
        require_once $classes_dir . $class_file;
        */
    }
}
?>