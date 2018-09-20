<?php
$temp = create_function( '$match',
        'return (preg_match(\'/^{(.*)}$/\',$match[1],$m) ? "foo_$m[1]" : $match[1]);');
$query = 'SELECT * FROM {books}';
$regExp = '/([^{"\']+|\'(?:\\\\\'.|[^\'])*\'|"(?:\\\\"|[^"])*"|{[^}{]+})/';
echo preg_replace_callback($regExp, $temp, $query);
?>
