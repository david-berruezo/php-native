<?php
namespace clases;

class CDFactory
{
    public static function create($type)
    {
        $class = "clases\\".$type;
        return new $class();
    }
}
?>