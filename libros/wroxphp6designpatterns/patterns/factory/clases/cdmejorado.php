<?php
namespace clases;
class cdmejorado
{
    private $title  = "";
    private $band   = "";
    private $tracks = array();
    public function __construct()
    {
        $this->tracks[] = "DATA TRACK";
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