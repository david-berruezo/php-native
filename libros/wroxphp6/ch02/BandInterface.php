<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 04/06/2016
 * Time: 11:46
 */
interface Band {
    public function getName();
    public function getGenre();
    public function addMusician(Musician $musician);
    public function getMusicians();
}
?>
