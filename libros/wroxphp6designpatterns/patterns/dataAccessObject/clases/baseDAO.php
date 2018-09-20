<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 8:45
 */
namespace clases;
abstract class baseDAO
{
    private $__connection;

    public function __construct()
    {
        $this->__connectToDB(DB_USER, DB_PASS, DB_HOST, DB_DATABASE);
    }

    private function __connectToDB($user, $pass, $host, $database)
    {
        $this->__connection = mysqli_connect($host, $user, $pass, $database);
        if (!$this->__connection) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL."<br>\n";
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL."<br>\n";
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL."<br>\n";
            exit;
        }
        echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL ."<br>\n";
        echo "Host information: " . mysqli_get_host_info($this->__connection) . PHP_EOL."<br>\n";
    }

    public function fetch($value, $key = NULL)
    {
            if (is_null($key)) {
                $key = $this->_primaryKey;
            }
            $query = "select * from {$this->_tableName} where {$key} = '{$value}'";
            echo $query."<br>";
            if ($result = mysqli_query($this->__connection,$query)){
                $rows = array();
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                    $rows[] = $row;
                    var_dump ($rows);
                }
                /* liberar la serie de resultados */
                mysqli_free_result($result);
                return $rows;
            }else{
                printf("Error: %s\n", mysqli_error($this->__connection));
            }
    }

    public function update($keyedArray)
    {
            $sql     = "update {$this->_tableName} set ";
            $updates = array();
            foreach ($keyedArray as $column=>$value) {
                    $updates[] = "{$column} = '{$value}'";
            }
            $sql .= implode(',', $updates);
            $sql .= " where {$this->_primaryKey} = '{$keyedArray[$this->_primaryKey]}'";
            echo $sql;
            if ($result = mysqli_query($this->__connection,$sql)){
                echo "Record updated successfully"."<br>\n";
            } else {
                echo "Error updating record: " . $this->__connection->error."<br>\n";
            }
    }
}
?>