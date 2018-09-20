<?php
namespace clases;
/**
 * Created by PhpStorm.
 * User: David
 * Date: 26/08/2016
 * Time: 17:02
 */
class MixtapeCD extends CD
{
    public function __clone()
    {
        $this->title = 'Mixtape';
    }
}
?>