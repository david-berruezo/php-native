<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 05/09/2016
 * Time: 11:54
 */
namespace clases;
class Pez extends Multicurl{
    // Vectores
    private $home = array(
        "http://www.pezcenter.com"
    );
    //private $categorias;
    private $fabricantes         = array();
    private $categoriasNameUrl   = array();
    // Objeto Dom
    private $dom;
    public function __construct()
    {
        // Multi Curl
        parent::__construct($this->home);
        $this->setContentAndOptions();
        $content = $this->getContent();
        // Dom Object
        $this->dom = new Dom($content);
    }
    public function getCategorias(){
        $vector        = $this->dom->getElementsByTagClassNameOther("ul","menuMadre");
        $contadorPadre = 0;
        $contadorHijo  = 0;
        foreach ($vector as $productList){
            if ($productList->length > 0){
                $ul = $productList->item(0);
                foreach($ul->childNodes as $li){
                   $anchors = $li->getElementsByTagName("a");
                   $uls     = $li->getElementsByTagName("ul");
                    if ($anchors->length > 0){
                        $anchor = $anchors->item(0);
                    }
                   $categoria  = $anchor->nodeValue;
                   var_dump($anchor);
                   if ($uls->length > 0){
                     foreach($uls as $ulMenu){
                         foreach($ulMenu->childNodes as $liSubmenu){
                             $anchor = $liSubmenu->firstChild;
                             $this->categoriasNameUrl[$contadorPadre]["hijos"]["name"] = $liSubmenu->nodeValue;
                             $this->categoriasNameUrl[$contadorPadre]["hijos"]["url"]  = $liSubmenu->getAttribute("href");
                             var_dump($liSubmenu);
                         }
                     }
                   }else{
                       $this->categoriasNameUrl[$contadorPadre]["name"] = "";
                       $this->categoriasNameUrl[$contadorPadre]["url"]  = $li->firstChild->getAttribute("href");
                   }
                   $contadorPadre++;
                }
            }
        }
        var_dump($this->categoriasNameUrl);
    }
}
?>