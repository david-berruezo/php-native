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
class Registro
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
		$this->scheme 	  = $urlarr['scheme'];
		$this->host   	  = $urlarr['host'];
		$this->path  	  = $urlarr['path'];
		$this->pageSource = file_get_contents($this->url);
		$this->document   = new DOMDocument();
		$this->document->loadHTMLFile($this->url);
		$this->xpath = new DOMXpath($this->document);
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

	public function getElementsByClassName($cssname){
		$elements = $this->xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $cssname ')]");
		//$elements = $this->xpath->query("//div[@class="some-descendant"]//div[@class="some-descendant-of-that-descendant"]");
		return $elements;
	}
	public function getElementsByTagName($tagname)
	{
		$elementos = $this->document->getElementsByTagName($tagname);
		return $elementos;
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
}
?>