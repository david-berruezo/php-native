<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 9:06
 */
namespace clases;
class userDAO extends baseDAO
{
    protected $_tableName = 'dataaccessobject';
    protected $_primaryKey = 'id';
    public function getUserByFirstName($name)
    {
        $result = $this->fetch($name, 'firstname');
        return $result;
    }
}
?>