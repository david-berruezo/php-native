<?php
namespace clases;
/**
 * Created by PhpStorm.
 * User: David
 * Date: 26/08/2016
 * Time: 16:59
 */
class CD
{
    public $band      = "";
    public $title     = "";
    public $trackList = array();
    public function __construct($id)
    {
        /*
         * Comprobamos en base de datos
         * y obtenemos la banda y titulo
         * y solamente consultamos una
         * vez a la base de datos luego
         * ampliamos la información del objeto
         * con la clonación del objeto
         */

        $handle = mysqli_connect("localhost", "root", "Berruezin23", "designpatterns");
        if (!$handle) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL."<br>\n";
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL."<br>\n";
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL."<br>\n";
            exit;
        }
        echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL ."<br>\n";
        echo "Host information: " . mysqli_get_host_info($handle) . PHP_EOL."<br>\n";
        $query = "select band, title from prototype where id={$id}";
        echo $query."<br>";
        $result = mysqli_query($handle,$query,MYSQLI_ASSOC);
        if($result){
            // Cycle through results
            while ($row = $result->fetch_assoc()){
                $this->band  = $row['band'];
                $this->title = $row['title'];
                echo "La banda es: ".$this->band." y el titulo es: ".$this->title."<br>\n";
            }
            // Free result set
            $result->close();
        }else{
            printf("Error: %s\n", mysqli_error($handle));
        }
        echo "Objeto Inicial: <br>";
        var_dump($this);
    }
    public function buy()
    {
        //cd buying magic here
        var_dump($this);
    }
}
?>