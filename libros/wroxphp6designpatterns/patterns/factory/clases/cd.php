<?php
namespace clases;
class Cd
{
    private $title  = "";
    private $band   = "";
    private $tracks = array();
    public function __construct()
    {
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setBand($band)
    {
        $this->band = $band;
    }
    public function addTrack($track)
    {
        $this->tracks[] = $track;
    }
}
?>