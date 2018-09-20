<?php
/*
 * Escribir idiomas
 */
// Espanol
getMonth('es_ES');
getDay('es_ES');
// Ruso
getMonth('en_US');
getDay('en_US');

/*
 * Return mont and day by language
 */
function getMonth($local)
{
    setlocale(LC_ALL,$local);
    echo (strftime('%B',time())."<br>");
}

function getDay($local)
{
    setlocale(LC_ALL, $local);
    echo (strftime('%A',time())."<br>");
}
?>