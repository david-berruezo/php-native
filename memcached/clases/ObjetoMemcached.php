<?php
namespace clases;
use Memcached;
class ObjetoMemcached{

    public function __construct()
    {
        $mem = new Memcached();
        $mem->addServer("127.0.0.1", 11211);
        $result = $mem->get("blah");
        if ($result) {
            echo $result;
        } else {
            echo "No matching key found.  I'll add that now!";
            $mem->set("blah", "I am data!  I am held in memcached!") or die("Couldn't save anything to memcached...");
        }
        /*
        $memcache = new Memcached();
        var_dump($memcache);
        $memcache->connect('127.0.0.1', 11211) or die ("Could not connect");
        $version = $memcache->getVersion();
        echo "Server's version: ".$version."<br/>\n";
        $tmp_object = new stdClass;
        $tmp_object->str_attr = 'test';
        $tmp_object->int_attr = 123;
        $memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
        echo "Store data in the cache (data will expire in 10 seconds)<br/>\n";
        $get_result = $memcache->get('key');
        echo "Data from the cache:<br/>\n";
        var_dump($get_result);
        */
    }
}
?>