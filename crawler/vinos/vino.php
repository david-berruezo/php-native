<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aplicación</title>
    <script src="jquery-2.2.3.min.js"></script>
    <script src="funciones.js"></script>
    <script src="html2canvas.js"></script>
</head>
<body>
<div id="content"></div>
</body>
</html>
<?php
/*
 * Clase Registro para bajar
 * datos de mil anuncios
 */

class Vino{
    private $url		= "";
    private $host   	= "";
    private $path   	= "";
    private $scheme     = "";
    // DomDocument
    private $document	= "";
    private $xpath	    = "";
    private $pageSource = "";
    public function __construct($urls)
    {
        $contador = 0;
        foreach($urls as $url){
            ${"ch{$contador}"} = curl_init();
            curl_setopt(${"ch{$contador}"}, CURLOPT_URL, $url);
            curl_setopt(${"ch{$contador}"}, CURLOPT_HEADER, 0);
            curl_setopt (${"ch{$contador}"}, CURLOPT_RETURNTRANSFER, 1);
            $contador++;
        }
        $contador = 0;
        $mh       = curl_multi_init();
        foreach($urls as $url){
            curl_multi_add_handle($mh,${"ch{$contador}"});
            $contador++;
        }
        $active   = null;
        $contador = 0;
        /*
        do {
            $mrc = curl_multi_exec($mh, $active);
            var_dump($mrc);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        */
        $contador = 0;
        /*
        foreach($urls as $url){
            curl_multi_remove_handle($mh, ${"ch{$contador}"});
            $contador++;
        }
        curl_multi_close($mh);
        */
        $contador = 0;
        foreach($urls as $url){
            $response = curl_multi_getcontent(${"ch{$contador}"});
            var_dump($response);
            $contador++;
        }

        /*
        $this->url		  = $url;
        libxml_use_internal_errors(true);
        $urlarr 		  = parse_url($url);
        //$this->scheme 	  = $urlarr['scheme'];
        //$this->host   	  = $urlarr['host'];
        //$this->path  	  = $urlarr['path'];
        $curl             = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        $content          = curl_exec ($curl);
        $this->document   = new DOMDocument();
        $this->document->loadHTMLFile($this->url);
        $this->xpath      = new DOMXpath($this->document);
        */

    }

}

/*
class Vino
{
    // file_getcontents
    private $url		= "";
    private $host   	= "";
    private $path   	= "";
    private $scheme     = "";
    // DomDocument
    private $document	= "";
    private $xpath	    = "";
    private $pageSource = "";

    public function __construct($url)
    {
        $this->url		  = $url;
        libxml_use_internal_errors(true);
        $urlarr 		  = parse_url($url);
        //$this->scheme 	  = $urlarr['scheme'];
        //$this->host   	  = $urlarr['host'];
        //$this->path  	  = $urlarr['path'];
        $curl             = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        $content          = curl_exec ($curl);
        $this->document   = new DOMDocument();
        $this->document->loadHTMLFile($this->url);
        $this->xpath      = new DOMXpath($this->document);
    }
    public function getDomain($url)
    {
        return substr($this->url,0,strrpos($this->url,"/"));
    }
    public function hasProtocol()
    {
        return strpos($this->url,"//");
    }
    //Convert the link as It should be
    function convertLink($domain,$url,$link)
    {
        if($this->hasProtocol($link))
        {
            return $link;
        }elseif (($link=='#')||($link=="/")){
            return $url;
        }else if(substr($link,0,1)=="/"){
            return $domain.$link;
        }else{
            return $domain."/".$link;
        }
    }
    public function getImages(){
        //Read the images that is between <a> tag
        $domain=$this->getDomain($this->url);
        $atags = $this->xpath->evaluate("//a");		//Read all a tags
        $index=0;
        for ($i = 0; $i < $atags->length; $i++)
        {
            $atag = $atags->item($i);			//select an a tag
            $imagetags=$atag->getElementsByTagName("img");//get img tag
            $imagetag=$imagetags->item(0);
            if(sizeof($imagetag)>0)//if img tag exists
            {
                $imagelinked['src'][$index]=$imagetag->getAttribute('src');//save image src
                $imagelinked['link'][$index]=$atag->getAttribute('href');//save image link
                $index=$index+1;
            }
        }
        //Read all image
        //Betweem <img> tag
        $imagetags = $this->xpath->evaluate("//img");	//Read all img tags
        $index=0;
        $indexlinked=0;
        for ($i = 0; $i < $imagetags->length; $i++)
        {
            $imagetag = $imagetags->item($i);
            $imagesrc=$imagetag->getAttribute('src');
            $image['link'][$index]=null;
            if($imagesrc==$imagelinked['src'][$indexlinked])//check wheather this image has link
            {
                $image['link'][$index]=$this->convertLink($domain,$this->url,$imagelinked['link'][$indexlinked]);
                $indexlinked=$indexlinked+1;
            }
            $image['src'][$index]=$this->convertLink($domain,$this->url,$imagesrc);
            $index=$index+1;
        }
        return $image;
    }
    public function getLinks()
    {
        $domain=$this->getDomain($this->url);
        $hrefs = $this->xpath->evaluate("//a");//get all a tags
        for ($i = 0; $i < $hrefs->length; $i++)
        {
            $href = $hrefs->item($i);//select an a tag
            $links['link'][$i]=$this->convertLink($domain,$this->url,$href->getAttribute('href'));
            $links['text'][$i]=$href->nodeValue;
        }
        return  $links;
    }
    public function getElementsByClassName($cssname){
        $elements = $this->xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $cssname ')]");
        return $elements;
    }
    public function getElementsByTagName($tagname)
    {
        $elementos = $this->document->getElementsByTagName($tagname);
        return $elementos;
    }
    public function getElementsByClassNameTag($tag,$class){
        $elements = $this->xpath->query("//".$tag."[contains(concat(' ',@class, ' '), ' ".$class." ')]");
        return $elements;
    }
    public function getElementsByClassNameTagQuery($tag,$class){
        $elementos = $this->xpath->query('//'.$tag.'[@class="'.$class.'"]');
        return $elementos;
    }
    public function getElementsByClassNameTagChildnodes($tag,$class,$childnode){
        $elementos = $this->xpath->query('//'.$tag.'[@class="'.$class.'"]/'.$childnode);
        return $elementos;
    }
}
*/
?>