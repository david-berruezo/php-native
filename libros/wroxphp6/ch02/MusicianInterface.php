<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 04/06/2016
 * Time: 11:47
 */
interface Musician {
    public function addInstrument(Instrument $instrument);
    public function getInstruments();
    public function assignToBand(Band $band);
    public function getMusicianType();
}
?>