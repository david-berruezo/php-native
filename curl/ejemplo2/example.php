<?php

include "curld.class.php";

$data = array(
	array("url" => "http://s9.uploads.im/uxqIn.jpg", "saveas" => "1.jpg"),
	array("url" => "http://s9.uploads.im/uxqIn.jpg", "saveas" => "2.jpg"),
	array("url" => "http://s9.uploads.im/uxqIn.jpg", "saveas" => "3.jpg"),
	);
// First variable includes urls and paths , second variable is the number of files that you want download simultaneously . If the number of files is more than this variable then class list them and download them in order .
curld::download($data, 3);

?>