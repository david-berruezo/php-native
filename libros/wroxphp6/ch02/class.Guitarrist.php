<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 04/06/2016
 * Time: 11:49
 */
require_once('MusicianInterface.php');
class Guitarist implements Musician {
    private $last;
    private $first;
    private $musicianType;
    private $instruments;
    private $bandReference;
    function __construct($first, $last) {
        $this->last         = $last;
        $this->first        = $first;
        $this->instruments  = array();
        $this->musicianType = "guitarist";
    }
    public function getName() {
        return $this->first . " " . $this->last;
    }
    public function addInstrument(Instrument $instrument) {
        array_push($this->instruments, $instrument);
    }
    public function getInstruments() {
        return $this->instruments;
    }
    public function getBand() {
        return $this->bandReference;
    }
    public function assignToBand(Band $band) {
        $this->bandReference = $band;
    }
    public function getMusicianType() {
        return $this->musicianType;
    }
    public function setMusicianType($musicianType) {
        $this->musicianType = $musicianType;
    }
}
?>