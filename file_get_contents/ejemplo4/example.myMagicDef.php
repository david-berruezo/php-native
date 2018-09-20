<?php

require_once('./loader.finfo.php');

$files = scandir('./dir');

$Yo = new finfo(FILEINFO_MIME_TYPE);

$magicArray = array(
    'pattern'      => '^\x7f\x45\x4c\x46',
    'mime_type'    => 'application/octet-stream',
    'inline_attachments' => false,
    'fn_extension' => array('elf','so','class','lzh','bin','lha','dms','dynlib')
    );


/*
	This is not standard 'finfo' action
	so we need to check variable/method availability.
*/
	
	if(isset($Yo->no_magic))
		$Yo->no_magic['elf'] = $magicArray;
    
    if(method_exists('set_magicDescription', 'finfo'))
		$Yo->set_magicDescription('elf', $magicArray);