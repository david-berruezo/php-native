<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 04/06/2016
 * Time: 11:50
 */
class RockBand implements Band {
    private $bandName;
    private $bandGenre;
    private $musicians;
    function __construct($bandName) {
        $this->bandName = $bandName;
        $this->musicians = array();
        $this->bandGenre = "rock";
    }
    public function getName() {
        return $this->bandName;
    }
    public function getGenre(){
        return $this->bandGenre;
    }
    public function addMusician(Musician $musician){
        array_push($this->musicians, $musician);
        $musician->assignToBand($this);
    }
    public function getMusicians() {
        return $this->musicians;
    }
}
?>