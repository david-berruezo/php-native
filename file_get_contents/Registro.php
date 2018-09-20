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
class Registro{
	// Referente a la dirección
	public $url;
	public $document;
	public $xpath;
	public $nRegistros = 0;
	public $urlDetalle = "http://www.milanuncios.com/datos-contacto/?id=";
	// Referente al producto
	public $id;
	public $nameEspecie; // categoria
	// Datos
	public $provincia   = array();
	public $titulo 		= array();
	public $descripcion = array();
	public $precio 		= array();
	public $linkFotos   = array();
	public $tipoAnuncio = array();
	public $imagenes 	= array();
	// Csv
	public $datos		= array();
	
	public function __construct($url,$nameEspecie,$tipoAnuncio){
		$this->url 	   	   = $url;
		$this->nameEspecie = $nameEspecie;
		//$this->tipoAnuncio = $tipoAnuncio;
		$this->guardarDatosHtml();
		$this->guardar();
		$this->borrarFichero();
		echo ("--------- Valores guardados ----------<br>");
		for ($i=0;$i<count($this->provincia);$i++){
			echo("Registro n�".$i."<br>");
			echo("provincia".$this->provincia[$i]."<br>");
			echo("titulo".$this->titulo[$i]."<br>");
			echo("descripcion".$this->descripcion[$i]."<br>");
			echo("precio".$this->precio[$i]."<br>");
			echo("linkFotos".$this->linkFotos[$i]."<br>");
			echo("tipoAnuncio".$this->tipoAnuncio[$i]."<br><br><br><br>");
		}
		echo ("--------- Fin Valores guardados ----------<br>");
		$this->guardarUrlImagenes();
		//$this->prepararVectorCsv();
		var_dump($this->imagenes);
	}
	
	public function borrarFichero(){
		$fichero = $this->nameEspecie.'.html';
		echo("nombre fichero es:".$fichero.'<br>');
		unlink($fichero);
	}
	
	public function guardarDatosHtml(){
		libxml_use_internal_errors(true);
		$homepage = file_get_contents($this->url);
		file_put_contents($this->nameEspecie.'.html', $homepage);
		$this->document = new DOMDocument();
		$this->document->loadHTMLFile($this->url);
		$this->xpath = new DOMXpath($this->document);
	}
	
	public function guardarUrlImagenes(){
		$contadorFotos = 0;

		/*
		for ($i=0;$i<count($this->linkFotos);$i++){
				if ($this->linkFotos[$i] != "No hay link"){
					$ruta = "http://www.milanuncios.com".$this->linkFotos[$i];
					//echo("La ruta es: ".$ruta."<br>");
					$homepage = file_get_contents($ruta);
					file_put_contents($i.'.html', $homepage);
					$this->document = new DOMDocument();
					$this->document->loadHTMLFile($ruta);
					$this->xpath = new DOMXpath($this->document);
					$classnameFotos = "pagAnuFoto";
					$fotos = $this->xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classnameFotos ')]");
					echo("-------- fichero ".$i."-------- <br>");
					foreach($fotos as $foto){
						$imagenes = $foto->getElementsByTagName("img");
						foreach($imagenes as $imagen){
							$url = $imagen->getAttribute("src");
							$this->imagenes[$i][$contadorFotos] = $url;
							echo("url: ".$url."<br>");
							$contadorFotos++;
						}
						//echo("fotos".$foto->nodeValue."<br>");
					}
					$contadorFotos = 0;
					echo("--------------------------------<br>");
					unlink($i.'.html');
				}
		}
		*/
	}
	
	public function prepararVectorCsv(){
		escribirCsv($this->provincia,$this->titulo,$this->descripcion,$this->precio,$this->linkFotos,$this->tipoAnuncio,$this->imagenes);
	}

	public function prueba(){

		$document = new DOMDocument();
		$document->loadHTMLFile($this->urlDetalle.$this->id);
		$url = $this->urlDetalle.$this->id;
		$xpath = new DOMXpath($document);
		$busqueda = "telefonos";
		$telefono = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $busqueda ')]");
		$contacto = $document->getElementsByTagName('strong');
		echo ("El contacto " . $contacto[0]->nodeValue. "<br>");
		//echo ("El telf " . $telefono[0]->nodeValue. "<br>");
		print_r($document);
		var_dump($telefono);
		var_dump($telefono[0]);
		/*
		foreach($items as $item) {
			$headline = array();
			if($item->childNodes->length) {
				foreach($item->childNodes as $i) {
					$headline[$i->nodeName] = $i->nodeValue;
				}
			}

			$headlines[] = $headline;
		}
		/*
		var_dump($headlines);

		if(!empty($headlines)) {
			$hc = 0;

			echo '<ul>';

			foreach($headlines as $headline) {
				if(++$hc <= 3) {
					echo '<li>'
						.'<a href="'.$headline['url'].'" target="_blank">'
						.'<span>'.date('F j, Y', strtotime($headline['created'])).'</span><br />'
						.$headline['title']
						.'</a>'
						.'</li>';
				}
			}

			echo '</ul>';
		}
		*/

		/*
		$i = 0;
		while(is_object($finance = $document->getElementsByTagName("body")->item($i)))
		{
			foreach($finance->childNodes as $nodename)
			{
				echo "Hola" . $nodename->nodeName." - ".$nodename->nodeValue."<br>";
				if($nodename->hasChildNodes())
				{
					foreach($nodename->childNodes as $subNodes)
					{
						echo "Hola1".$subNodes->nodeName." - ".$subNodes->nodeValue."<br>";
					}
				}
				else
				{
					echo "Hola2".$nodename->nodeName." - ".$nodename->nodeValue."<br>";
				}
			}
			$i++;
		}
		*/
	}



	public function guardar(){
		// Busqueda
		//$busqueda  		    = "x1";
		$busqueda  		    = "products-grid";
		$productos 		    = $this->xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $busqueda ')]");
		var_dump($productos);
		$contador  		    = 0;
		echo("-------------------- El numero Total fotos por registro son: ".$productos->length." ------------------<br>");
		foreach ($productos as $product){
			//echo("------------------------ Registro N�".$contador." -------------------<br>");
			// Comprobaci�n
			$provinciaEncontrado 	= false;
			$tituloEncontrado		= false;
			$descripcionEncontrado	= false;
			$precioEncontrado		= false;
			$linkFotosEncontrado	= false;
			$tipoEncontrado			= false;
			$hijos = $product->getElementsByTagName("div");
			foreach($hijos as $hijo){
				$claseHijo = $hijo->getAttribute("class");
				//echo ("El nombre de la clase hijo es: ".$claseHijo."<br>");
				if ($claseHijo == "x4"){
					$provinciaEncontrado = true;
					$this->provincia[$contador] = utf8_decode($hijo->nodeValue);	
					//echo("provincia:".$hijo->nodeValue."<br>");
				}
				if ($claseHijo == "x7"){
					$hijosx7 = $hijo->getElementsByTagName("a");
					foreach($hijosx7 as $hijox7){
						$claseHijox7 = $hijox7->getAttribute("class");
						if ($claseHijox7 == "cti"){
							$tituloEncontrado = true;
							$this->titulo[$contador] = utf8_decode($hijox7->nodeValue);	
							//echo("titulo:".$hijox7->nodeValue."<br>");
						}
					}
				}
				if ($claseHijo == "x8"){
					echo ("La encuentra<br>\n");
					if ($hijo->hasChildNodes()) {
						foreach ($hijo->childNodes as $p){
							if ($p->hasChildNodes()) {
								echo "primera " .$p->nodeName . ' -> CHILDNODES<br>';
								if ($p->nodeName == "a"){
									echo ("href:" .$p->getAttribute("href")."<br>\n");
									$atributo = $p->getAttribute("href");
									$arrAtributo = explode("'", $atributo);
									//var_dump($arrAtributo);
									echo ("El id es: ".$arrAtributo[1]."<br>");
									$this->id = $arrAtributo[1];
									$this->prueba();
									//$fichero  = file_get_contents($this->urlDetalle.$arrAtributo[1]);
									//echo ($fichero);
									/*
									$busq  	   = "plaincontenido";
									$document = new DOMDocument();
									$document->loadHTMLFile($this->urlDetalle.$arrAtributo[1]);
									$xpath = new DOMXpath($document);
									//$datos = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $busq ')]");
									//var_dump($datos);
									$datos = $document->getElementsByTagName('div');
									echo ("El total de nodos es: ".$datos->length."<br>");
									$contador = 0;
									foreach($datos as $dato){
										//var_dump($dato);
										//echo("<br><br><br>");
										if ($dato->getAttribute("class") == "plaincontenido"){
											echo ("Nombre: ".$dato->nodeValue."<br>\n");
										}
										if ($dato->getAttribute("class") == "telefonos"){
											echo ("Telf: ".$dato->nodeValue."<br>\n");
										}
										if ($dato->hasChildNodes()){
											$telefonos = $dato->getElementsByTagName('div');
											//var_dump($telefonos);
											foreach($telefonos as $telefono){
												var_dump($telefono);
												echo("<br><br><br>");
												if ($telefono->getAttribute("class") == "telefonos"){
													echo ("telefonos: ".$telefono->nodeValue."<br>\n");
												}
											}
										}
										*/
										/*
										if ($dato->getAttribute("class") == "texto"){
											foreach($dato as $nombre){
												if ($contador == 0){
													foreach($nombre as $sunombre){
														$elnombre = $sunombre->nodeValue();
														echo ("El nombre es: ".$elnombre."<br>");
													}
												}
												if ($dato->getAttribute("class") == "telefonos"){
													$telefono = $nombre->nodeValue();
													echo ("El telefono es: ".$telefono."<br>");
												}
												$contador++;
											}

									}
									*/

									//var_dump($fichero);
									$nimagenes = $p->getAttribute("href");
								}
								foreach($p->childNodes as $img){
									echo "segunda " .$img->nodeName . ' -> CHILDNODES<br>';
									if ($img->nodeName == "img"){
										$nimagenes = $img->getAttribute("src");
										echo ("img:" .$nimagenes."<br>\n");
									}
								}
							}
						}
					}
				}
				if ($claseHijo == "x10"){
					echo("BINGO<BR>");
					if ($hijo->nodeName == "a") {
						echo("href2:" . $hijo->getAttribute("href") . "<br>\n");
					}
					if ($hijo->hasChildNodes()) {
						foreach ($hijo->childNodes as $p) {
							echo("nombre: ".$p->nodeName."<br>");
							//if ($p->hasChildNodes()) {
								echo("BINGO2<BR>");
								foreach($p->childNodes as $a){
									//if ($a->nodeName == "a") {
										echo("href2:" . $a->getAttribute("href") . "<br>\n");
									//}
								}
								/*
								if ($p->nodeName == "a") {
									echo("href1:" . $p->getAttribute("href") . "<br>\n");
								}else{
									foreach($p->childNodes as $a){
										if ($a->nodeName == "a") {
											echo("href2:" . $a->getAttribute("href") . "<br>\n");
										}
									}
								}
								*/
							//}else{
								//if ($p->nodeName == "a") {
								//	echo("href2:" . $a->getAttribute("href") . "<br>\n");
								//}
							//}
						}
					}
				}
				if ($claseHijo == "tx"){
					$descripcionEncontrado = true;
					$this->descripcion[$contador] = utf8_decode($hijo->nodeValue);
					//echo("desc:".$hijo->nodeValue."<br>");
				}
				if ($claseHijo == "vem par"){
					$tipoEncontrado = true;
					$this->tipoAnuncio[$contador] = utf8_decode($hijo->nodeValue);
					//echo("tipo Anuncio:".$hijo->nodeValue."<br>");
				}
				
				if ($claseHijo == "pr"){
					$precioEncontrado = true;
					$this->precio[$contador] = utf8_decode($hijo->nodeValue);
					//echo("precio:".$hijo->nodeValue."<br>");
				}
				
				if ($claseHijo == "vefbox"){
					$anchors = $hijo->getElementsByTagName("a");
					foreach($anchors as $anchor){
						$claseAnchor = $anchor->getAttribute("href");
						if ($claseAnchor != ""){
							//echo("direccion".$claseAnchor."<br>");
							$linkFotosEncontrado = true;	
							$this->linkFotos[$contador] = utf8_decode($claseAnchor);
						}
					}
				}
			}
			if (!$provinciaEncontrado){
				$this->provincia[$contador] = "No hay provincia";
			}
			if (!$tituloEncontrado){
				$this->titulo[$contador] = "No hay titulo";
			}
			if (!$descripcionEncontrado){
				$this->descripcion[$contador] = "No hay descripci�n";
			}
			if (!$precioEncontrado){
				$this->precio[$contador] = 0;
			}
			if (!$tipoEncontrado){
				$this->tipoAnuncio[$contador] = "No hay tipo de anuncio";
			}
			if (!$linkFotosEncontrado){
				$this->linkFotos[$contador] = "No hay link";
			}
			/*
			echo("---- valores ----- <br>");
			echo("provincia".$provincia."<br>");
			echo("titulo".$titulo."<br>");
			echo("descripcion".$descripcion."<br>");
			echo("sifotos".$sifotos."<br>");
			echo("nFotos".$nFotos."<br>");
			echo("---- fin ----- <br>");
			*/
			/*
			//$pepe as string;
			$pepe = $product->nodeValue;
			$pos    = strrpos($pepe, "verfotos");
			$pos2   = strrpos($pepe, "FOTOS");;
			$nFotos = 0;
			if ($pos !== false && $pos2 !== false){
				echo("Hay mas de 1 foto <br>");
				$longitud = $pos2 - ($pos+8) ;
				$nFotos = substr($product->nodeValue, $pos+8,$longitud);
			}else if($pos !== false && $pos2 === false){
				$nFotos = 1;
			}else{
				$nFotos = 0;
			}
			*/
			//echo("------------------------ Final registro -------------------<br><br><br>");
			$contador++;
		}
	}
	

	public function buscarPaginasTotales(){
		
		// Si hay m�s de 3 paginas
		$classnamePaginas = "cat1";
		$paginas = $this->xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classnamePaginas ')]");
		
		foreach($paginas as $pagina){
		
			$valorTempPagina = utf8_decode($pagina->nodeValue);
		
		}
		
		if (isset($valorTempPagina)){
			
			echo($valorTempPagina."<br>");
			
			$pos = strrpos($valorTempPagina, "DE ");
			
			if ($pos !== false){
			
				echo("La posicion de la primera D de DE es:".$pos."<br>");
			
				$pos2 = strrpos($valorTempPagina, ".");
			
				if ($pos2 !== false){
						
					echo("La posicion del . es:".$pos2."<br>");
						
				}
			
				$longitud = $pos2 - ($pos + 3);
			
				$valorPaginas = substr($valorTempPagina, $pos+3,$longitud);
			
				echo("El valor de todas las paginas es: ".$valorPaginas.'<br>');
			
			}	
			
		}
		
		
	}
	
	
	public function pruebaImagen(){
		
		$nombre_fichero = "images/1.png";
		$datos = getimagesize($nombre_fichero);
		$fp = fopen($nombre_fichero, "rb");
		
		$ancho = $datos[1];
		$alto  = $datos[0];
		$tipo  = $datos['mime'];
		
		echo("------------- valores imagenes ------------<br>");
		
		$altoAquitar = $alto * 10 / 100;
		echo("Quitar alto: ".$altoAquitar."<br>");
		
		var_dump($datos);
		
		$origen  = imagecreatefromjpeg('images/2.jpg');
		$destino = imagecreatetruecolor($ancho,$alto);
		
		// Copiar
		imagecopy($destino, $origen, 0, 0, 0, $altoAquitar, $ancho, $alto);
		
		imagejpeg($destino, 'images/2-1.jpg');
		
		// Liberar memoria
		imagedestroy($destino);
		
		
		echo("------------- fin de valores ------------<br>");
		
	}
	
	
	
}

//$registro = new Registro('http://www.milanuncios.com/pajaros-en-barcelona/fisher.htm?demanda=n&vendedor=part','fischer','particular');
$registro = new Registro('http://www.vinoseleccion.com/regiones/ribera-del-duero');

/*
<select autofocus="" id="p" name="p" class="normal">
<option selected="" value="df">Seleccione...</option>
<option value="alava">�lava</option>
<option value="albacete">Albacete</option>
<option value="alicante">Alicante</option>
<option value="almeria">Almer�a</option>
<option value="asturias">Asturias</option>
<option value="avila">�vila</option>
<option value="badajoz">Badajoz</option>
<option value="baleares">Baleares</option>
<option value="barcelona">Barcelona</option>
<option value="burgos">Burgos</option>
<option value="caceres">C�ceres</option>
<option value="cadiz">C�diz</option>
<option value="cantabria">Cantabria</option>
<option value="castellon">Castell�n</option>
<option value="ceuta">Ceuta</option>
<option value="ciudad_real">Ciudad Real</option>
<option value="cordoba">C�rdoba</option>
<option value="cuenca">Cuenca</option>
<option value="girona">Girona</option>
<option value="granada">Granada</option>
<option value="guadalajara">Guadalajara</option>
<option value="guipuzcoa">Guip�zcoa</option>
<option value="huelva">Huelva</option>
<option value="huesca">Huesca</option>
<option value="baleares">Islas Baleares</option>
<option value="jaen">Ja�n</option>
<option value="la_coruna">La Coru�a</option>
<option value="la_rioja">La Rioja</option>
<option value="las_palmas">Las Palmas</option>
<option value="leon">Le�n</option>
<option value="lleida">Lleida</option>
<option value="lugo">Lugo</option>
<option value="madrid">Madrid</option>
<option value="malaga">M�laga</option>
<option value="melilla">Melilla</option>
<option value="murcia">Murcia</option>
<option value="navarra">Navarra</option>
<option value="ourense">Ourense</option>
<option value="palencia">Palencia</option>
<option value="pontevedra">Pontevedra</option>
<option value="salamanca">Salamanca</option>
<option value="segovia">Segovia</option>
<option value="sevilla">Sevilla</option>
<option value="soria">Soria</option>
<option value="tarragona">Tarragona</option>
<option value="tenerife">Tenerife</option>
<option value="teruel">Teruel</option>
<option value="toledo">Toledo</option>
<option value="valencia">Valencia</option>
<option value="valladolid">Valladolid</option>
<option value="vizcaya">Vizcaya</option>
<option value="zamora">Zamora</option>
<option value="zaragoza">Zaragoza</option>
</select>
*/
