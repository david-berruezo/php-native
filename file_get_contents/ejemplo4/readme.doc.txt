class.finfo.php
---------------
 public $no_magic    <-- built in magic
 public $flags       <-- finfo flags
 public $magic_file  <-- path to magic file
 
    Extra methods are not implmented in php's own 'finfo'
    .....................................................

    Set or overwrite/override magic file description
    set_magicDescription($key, $array);
 
    mime_class/sub_type
    get_mime_class()
    get_mime_subtype();
    
    Returns true if mime class is "text", also returns true on XML, CSS, JS, RTF, PHP.
    isTextualData();
 ----------------------------------------------------------------
 About me: http://ukj.pri.ee ukj@ukj.pri.ee