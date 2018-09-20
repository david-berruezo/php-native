<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 26/08/2016
 * Time: 17:14
 */
require_once "vendor/autoload.php";
use clases\MixtapeCD;
use clases\Cd;
$externalPurchaseInfoBandID = 1;
$bandMixProto               = new MixtapeCD($externalPurchaseInfoBandID);
$externalPurchaseInfo       = array();
$externalPurchaseInfo[]     = array('Nueva TrackList', 'Se me enamora el alma');
$externalPurchaseInfo[]     = array('Otra TrackList', 'El moreno baila');
foreach ($externalPurchaseInfo as $mixed) {
    $cd            = clone $bandMixProto;
    $cd->trackList = $mixed;
    $cd->buy();
}
?>