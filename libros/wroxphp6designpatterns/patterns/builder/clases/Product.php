<?php
namespace clases;
class product
{
    protected $_type = "";
    protected $_size = "";
    protected $_color = "";

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }
}
?>