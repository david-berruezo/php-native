<?php
// Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
date_default_timezone_set('Europe/Madrid');
// Imprime: July 1, 2000 is on a Saturday
// int mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int $month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )
echo "July 1, 2000 is on a " . date("l", mktime(0, 0, 0, 7, 1, 2000));
// Imprime algo como: 2006-04-05T01:02:03+00:00
echo date('c', mktime(1, 2, 3, 4, 5, 2006));
?>