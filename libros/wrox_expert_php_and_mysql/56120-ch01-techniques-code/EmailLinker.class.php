<?php
class EmailLinker {

   public function getJavascript() {
     return <<<__JS__
<script type="text/javascript" language="javascript">
function mailDecode( url ) {
  var script=document.createElement('script');
  script.src = '?mail='+url;
  document.body.appendChild(script);
}
</script>
__JS__;
  }

  public function redirectIfNeeded() {
    if ( array_key_exists('mail', $_GET) ) {
      header("Location: mailto:".base64_decode($_GET['mail']));
      exit;
    }
  }

  private function emailReplaceCallback( $matches ) {
    $encoded = base64_encode($matches[0]);
    return '<a href="?mail='.urlencode($encoded).'"'.
           ' onclick="mailDecode(\''.$encoded.'\'); return false;">'.
           'email '.$matches['user'].'</a>';
  }

  public function link( $text ) {
    $emailRegex = <<<__REGEX__
/(?P<user>
  "[\w!#$%&'*+\/=?^`{|}~.@()[\]\\;:,<>-]+" (?# quoted username )
| (?!\.)[\w!#$%&'*+\/=?^`{|}~.-]+(?<!\.)   (?# non-quoted username )
) @ (?P<host>
  (?:(?!-)[\w-]+(?<!-)\.)+(?!-)[\w-]+(?<!-) (?# host )
| \[([0-9]{1,3}\.){3}[0-9]{1,3}\] (?# host IP address )
)/x
__REGEX__;

    return preg_replace_callback($emailRegex,
             array($this,'emailReplaceCallback'), $text );
  }
}
?>
