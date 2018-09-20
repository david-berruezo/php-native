<?php
namespace clases;
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/12/16
 * Time: 20:03
 */
use SimpleXMLElement;
use SimpleXMLIterator;
class ObjetoXml{
    private $ficheroXml  = "";
    private $propiedades = array();

    public function __construct()
    {
        //$this->ficheroXml = simplexml_load_file('http://portal.apinmo.com/xml/334fys77/3377-web.xml');
        $this->ficheroXml = simplexml_load_file('http://localhost/php/php/decoding/FileZilla.xml');
    }

    public function leerXml(){
        $contador = 0;
        //foreach($this->ficheroXml->children() as $propiedad){
        foreach($this->ficheroXml->Servers->Server as $propiedad){
            var_dump($propiedad);
            //$str = ;
            echo "Password: ".base64_decode($propiedad->Pass)."<br>";
            //echo $propiedad[$contador]->Pass."<br>";
            $contador++;
            /*
            $this->propiedades[$contador] = array(
                "id"                => $propiedad->id->__toString(),
                "numagencia"        => $propiedad->numagencia->__toString(),
                "destacado"         => $propiedad->destacado->__toString(),
                "antiguedad"        => $propiedad->antiguedad->__toString(),
                "Tipo oferta"       => $propiedad->tipo_ofer->__toString(),
                "keypromo"          => $propiedad->keypromo->__toString(),
                "opcioncompra"      => $propiedad->opcioncompra->__toString(),
                "latitud"           => $propiedad->latitud->__toString(),
                "altitud"           => $propiedad->altitud->__toString(),
                "aseos"             => $propiedad->aseos->__toString(),
                "banyos"            => $propiedad->banyos->__toString(),
                "carpinteria"       => $propiedad->carpinteria->__toString(),
                "carpinext"         => $propiedad->carpinext->__toString(),
                "comunidadincluida" => $propiedad->comunidadincluida->__toString(),
                "tbano"             => $propiedad->tbano->__toString(),
                "tcocina"           => $propiedad->tcocina->__toString(),
                "tfachada"          => $propiedad->tfachada->__toString(),
                "tpostigo"          => $propiedad->tpostigo->__toString(),
                "tinterior"         => $propiedad->tinterior->__toString(),
                "distmar"           => $propiedad->distmar->__toString(),
                "conservacion"      => $propiedad->conservacion->__toString(),
                "habdobles"         => $propiedad->habdobles->__toString(),
                "habitaciones"      => $propiedad->habitaciones->__toString(),
                "m_cons"            => $propiedad->m_cons->__toString(),
                "m_parcela"         => $propiedad->m_parcela->__toString(),
                "m_uties"           => $propiedad->m_uties->__toString(),
                "m_cocina"          => $propiedad->m_cocina->__toString(),
                "m_comedor"         => $propiedad->m_comedor->__toString(),
                "m_terraza"         => $propiedad->m_terraza->__toString(),
                "numplanta"         => $propiedad->numplanta->__toString(),
                "orientacion"       => $propiedad->orientacion->__toString(),
                "salon"             => $propiedad->salon->__toString(),
                "suelo"             => $propiedad->suelo->__toString(),
                "precioinmo"        => $propiedad->precioinmo->__toString(),
                "precioalq"         => $propiedad->precioalq->__toString(),
                "ref"               => $propiedad->ref->__toString(),
                "accion"            => $propiedad->accion->__toString(),
                "ciudad"            => $propiedad->ciudad->__toString(),
                "cp"                => $propiedad->cp->__toString(),
                "zona"              => $propiedad->zona->__toString(),
                "adaptadominus"     => $propiedad->adaptadominus->__toString(),
                "airecentral"       => $propiedad->airecentral->__toString(),
                "aire_con"          => $propiedad->aire_con->__toString(),
                "alarma"            => $propiedad->alarma->__toString(),
                "alarmaincendio"    => $propiedad->alarmaincendio->__toString(),
                "alarmarobo"        => $propiedad->alarmarobo->__toString(),
                "arma_empo"         => $propiedad->arma_empo->__toString(),
                "ascensor"          => $propiedad->ascensor->__toString(),
                "balcon"            => $propiedad->balcon->__toString(),
                "bar"               => $propiedad->bar->__toString(),
                "barbacoa"          => $propiedad->barbacoa->__toString(),
                "cajafuerte"        => $propiedad->cajafuerte->__toString(),
                "calefacentral"     => $propiedad->calefacentral->__toString(),
                "calefaccion"       => $propiedad->calefaccion->__toString(),
                "chimenea"          => $propiedad->chimenea->__toString(),
                "cocina_inde"       => $propiedad->cocina_inde->__toString(),
                "descalcificador"   => $propiedad->descalcificador->__toString(),
                "diafano"           => $propiedad->diafano->__toString(),
                "electro"           => $propiedad->electro->__toString(),
                "esquina"           => $propiedad->esquina->__toString(),
                "galeria"           => $propiedad->galeria->__toString(),
                "plaza_gara"        => $propiedad->plaza_gara->__toString(),
                "garajedoble"       => $propiedad->garajedoble->__toString(),
                "gasciudad"         => $propiedad->gasciudad->__toString(),
                "gimnasio"          => $propiedad->gimnasio->__toString(),
                "habjuegos"         => $propiedad->habjuegos->__toString(),
                "hidromasaje"       => $propiedad->hidromasaje->__toString(),
                "jacuzzi"           => $propiedad->jacuzzi->__toString(),
                "lavanderia"        => $propiedad->lavanderia->__toString(),
                "linea_tlf"         => $propiedad->linea_tlf->__toString(),
                "luminoso"          => $propiedad->luminoso->__toString(),
                "muebles"           => $propiedad->muebles->__toString(),
                "ojobuey"           => $propiedad->ojobuey->__toString(),
                "parking"           => $propiedad->parking->__toString(),
                "patio"             => $propiedad->patio->__toString(),
                "piscina_com"       => $propiedad->piscina_com->__toString(),
                "piscina_prop"      => $propiedad->piscina_prop->__toString(),
                "preinstaacc"       => $propiedad->preinstaacc->__toString(),
                "primera_line"      => $propiedad->primera_line->__toString(),
                "puerta_blin"       => $propiedad->puerta_blin->__toString(),
                "satelite"          => $propiedad->satelite->__toString(),
                "sauna"             => $propiedad->sauna->__toString(),
                "solarium"          => $propiedad->solarium->__toString(),
                "sotano"            => $propiedad->sotano->__toString(),
                "tv"                => $propiedad->tv->__toString(),
                "terraza"           => $propiedad->terraza->__toString(),
                "terrazaacris"      => $propiedad->terrazaacris->__toString(),
                "todoext"           => $propiedad->todoext->__toString(),
                "trastero"          => $propiedad->trastero->__toString(),
                "urbanizacion"      => $propiedad->urbanizacion->__toString(),
                "vestuarios"        => $propiedad->vestuarios->__toString(),
                "video_port"        => $propiedad->video_port->__toString(),
                "vistasalmar"       => $propiedad->vistasalmar->__toString(),
                "energialetra"      => $propiedad->energialetra->__toString(),
                "energiarecibido"   => $propiedad->energiarecibido->__toString(),
                "descrip1"          => $propiedad->descrip1->__toString(),
                "titulo1"           => $propiedad->titulo1->__toString(),
                "titulo2"           => $propiedad->titulo2->__toString(),
                "descrip2"          => $propiedad->descrip2->__toString(),
                "numfotos"          => $propiedad->numfotos->__toString(),
                "foto1"             => $propiedad->foto1->__toString(),
                "foto2"             => $propiedad->foto2->__toString(),
            );
            */

            /*
            echo "id: ".$propiedad->id."<br>";
            echo "numagencia: ".$propiedad->numagencia."<br>";
            echo "destacado: ".$propiedad->destacado."<br>";
            echo "antiguedad: ".$propiedad->antiguedad."<br>";
            echo "Tipo oferta: ".$propiedad->tipo_ofer."<br>";
            echo "keypromo: ".$propiedad->keypromo."<br>";
            echo "opcioncompra: ".$propiedad->opcioncompra."<br>";
            echo "latitud: ".$propiedad->latitud."<br>";
            echo "altitud: ".$propiedad->altitud."<br>";
            echo "aseos: ".$propiedad->aseos."<br>";
            echo "banyos: ".$propiedad->banyos."<br>";
            echo "carpinteria: ".$propiedad->carpinteria."<br>";
            echo "carpinext: ".$propiedad->carpinext."<br>";
            echo "comunidadincluida: ".$propiedad->comunidadincluida."<br>";
            echo "tbano: ".$propiedad->tbano."<br>";
            echo "tcocina: ".$propiedad->tcocina."<br>";
            echo "tfachada: ".$propiedad->tfachada."<br>";
            echo "tpostigo: ".$propiedad->tpostigo."<br>";
            echo "tinterior: ".$propiedad->tinterior."<br>";
            echo "distmar: ".$propiedad->distmar."<br>";
            echo "conservacion: ".$propiedad->conservacion."<br>";
            echo "habdobles: ".$propiedad->habdobles."<br>";
            echo "habitaciones: ".$propiedad->habitaciones."<br>";
            echo "m_cons: ".$propiedad->m_cons."<br>";
            echo "m_parcela: ".$propiedad->m_parcela."<br>";
            echo "m_uties: ".$propiedad->m_uties."<br>";
            echo "m_cocina: ".$propiedad->m_cocina."<br>";
            echo "m_comedor: ".$propiedad->m_comedor."<br>";
            echo "m_terraza: ".$propiedad->m_terraza."<br>";
            echo "numplanta: ".$propiedad->numplanta."<br>";
            echo "orientacion: ".$propiedad->orientacion."<br>";
            echo "salon: ".$propiedad->salon."<br>";
            echo "suelo: ".$propiedad->suelo."<br>";
            echo "precioinmo: ".$propiedad->precioinmo."<br>";
            echo "precioalq: ".$propiedad->precioalq."<br>";
            echo "ref: ".$propiedad->ref."<br>";
            echo "accion: ".$propiedad->accion."<br>";
            echo "ciudad: ".$propiedad->ciudad."<br>";
            echo "cp: ".$propiedad->cp."<br>";
            echo "zona: ".$propiedad->zona."<br>";
            echo "adaptadominus: ".$propiedad->adaptadominus."<br>";
            echo "airecentral: ".$propiedad->airecentral."<br>";
            echo "aire_con: ".$propiedad->aire_con."<br>";
            echo "alarma: ".$propiedad->alarma."<br>";
            echo "alarmaincendio: ".$propiedad->alarmaincendio."<br>";
            echo "alarmarobo: ".$propiedad->alarmarobo."<br>";
            echo "arma_empo: ".$propiedad->arma_empo."<br>";
            echo "ascensor: ".$propiedad->ascensor."<br>";
            echo "balcon: ".$propiedad->balcon."<br>";
            echo "bar: ".$propiedad->bar."<br>";
            echo "barbacoa: ".$propiedad->barbacoa."<br>";
            echo "cajafuerte: ".$propiedad->cajafuerte."<br>";
            echo "calefacentral: ".$propiedad->calefacentral."<br>";
            echo "calefaccion: ".$propiedad->calefaccion."<br>";
            echo "chimenea: ".$propiedad->chimenea."<br>";
            echo "cocina_inde: ".$propiedad->cocina_inde."<br>";
            echo "descalcificador: ".$propiedad->descalcificador."<br>";
            echo "diafano: ".$propiedad->diafano."<br>";
            echo "electro: ".$propiedad->electro."<br>";
            echo "esquina: ".$propiedad->esquina."<br>";
            echo "galeria: ".$propiedad->galeria."<br>";
            echo "plaza_gara: ".$propiedad->plaza_gara."<br>";
            echo "garajedoble: ".$propiedad->garajedoble."<br>";
            echo "gasciudad: ".$propiedad->gasciudad."<br>";
            echo "gimnasio: ".$propiedad->gimnasio."<br>";
            echo "habjuegos: ".$propiedad->habjuegos."<br>";
            echo "hidromasaje: ".$propiedad->hidromasaje."<br>";
            echo "jacuzzi: ".$propiedad->jacuzzi."<br>";
            echo "lavanderia: ".$propiedad->lavanderia."<br>";
            echo "linea_tlf: ".$propiedad->linea_tlf."<br>";
            echo "luminoso: ".$propiedad->luminoso."<br>";
            echo "muebles: ".$propiedad->muebles."<br>";
            echo "ojobuey: ".$propiedad->ojobuey."<br>";
            echo "parking: ".$propiedad->parking."<br>";
            echo "patio: ".$propiedad->patio."<br>";
            echo "piscina_com: ".$propiedad->piscina_com."<br>";
            echo "piscina_prop: ".$propiedad->piscina_prop."<br>";
            echo "preinstaacc: ".$propiedad->preinstaacc."<br>";
            echo "primera_line: ".$propiedad->primera_line."<br>";
            echo "puerta_blin: ".$propiedad->puerta_blin."<br>";
            echo "satelite: ".$propiedad->satelite."<br>";
            echo "sauna: ".$propiedad->sauna."<br>";
            echo "solarium: ".$propiedad->solarium."<br>";
            echo "sotano: ".$propiedad->sotano."<br>";
            echo "tv: ".$propiedad->tv."<br>";
            echo "terraza: ".$propiedad->terraza."<br>";
            echo "terrazaacris: ".$propiedad->terrazaacris."<br>";
            echo "todoext: ".$propiedad->todoext."<br>";
            echo "trastero: ".$propiedad->trastero."<br>";
            echo "urbanizacion: ".$propiedad->urbanizacion."<br>";
            echo "vestuarios: ".$propiedad->vestuarios."<br>";
            echo "video_port: ".$propiedad->video_port."<br>";
            echo "vistasalmar: ".$propiedad->vistasalmar."<br>";
            echo "energialetra: ".$propiedad->energialetra."<br>";
            echo "energiarecibido: ".$propiedad->energiarecibido."<br>";
            echo "descrip1: ".$propiedad->descrip1."<br>";
            echo "titulo1: ".$propiedad->titulo1."<br>";
            echo "titulo2: ".$propiedad->titulo2."<br>";
            echo "descrip2: ".$propiedad->descrip2."<br>";
            echo "numfotos: ".$propiedad->numfotos."<br>";
            echo "foto1: ".$propiedad->foto1."<br>";
            echo "foto2: ".$propiedad->foto2."<br>";
            echo "foto3: ".$propiedad->foto3."<br>";
            */
        }
        echo "El numero total son: ".$contador."<br>";
    }

    /*
     * Creamos csv
     */
    public function writeCsv(){
        // csv
        $output   = fopen('post_import.csv', 'w');
        $vector   = array();
        array_push($vector,$this->getLabelCsv());
        $contador = 0;
        foreach($this->propiedades as $valor){
            $post_id        = $valor["id"];
            $post_name      = $valor['titulo1'];
            $post_author    = "editor@davidberruezo.com";
            //$post_date     = $this->convertDate($value['dia'],$value['mes']);
            //$post_date      = $value['fecha'];
            $post_date      = "";
            $post_type      = "post";
            $post_status    = "publish";
            $post_tags      = $valor["Tipo oferta"];
            $post_title     = $valor['titulo1'];
            $post_content   = $valor["descrip1"];
            $post_category  = $valor["Tipo oferta"];
            $custom_field1  = $valor["numagencia"];
            $custom_field2  = $valor["destacado"];
            $custom_field3  = $valor["antiguedad"];
            $custom_field4  = $valor["Tipo oferta"];
            $custom_field5  = $valor["keypromo"];
            $custom_field6  = $valor["opcioncompra"];
            $custom_field6  = $valor["latitud"];
            $custom_field7  = $valor["altitud"];
            $custom_field8  = $valor["aseos"];
            $custom_field9  = $valor["banyos"];
            $custom_field10 = $valor["carpinteria"];
            $custom_field11 = $valor["carpinext"];
            $custom_field12 = $valor["comunidadincluida"];
            $custom_field13 = $valor["tbano"];
            $custom_field14 = $valor["tcocina"];
            $custom_field15 = $valor["tfachada"];
            $custom_field16 = $valor["tpostigo"];
            $custom_field17 = $valor["tinterior"];
            $custom_field18 = $valor["distmar"];
            $custom_field19 = $valor["conservacion"];
            $custom_field20 = $valor["habdobles"];
            $custom_field21 = $valor["habitaciones"];
            $custom_field22 = $valor["m_cons"];
            $custom_field23 = $valor["m_parcela"];
            $custom_field24 = $valor["m_uties"];
            $custom_field25 = $valor["m_cocina"];
            $custom_field26 = $valor["m_comedor"];
            $custom_field27 = $valor["m_terraza"];
            $custom_field28 = $valor["numplanta"];
            $custom_field29 = $valor["orientacion"];
            $custom_field30 = $valor["salon"];
            $custom_field31 = $valor["suelo"];
            $custom_field32 = $valor["precioinmo"];
            $custom_field33 = $valor["precioalq"];
            $custom_field34 = $valor["ref"];
            $custom_field35 = $valor["accion"];
            $custom_field36 = $valor["ciudad"];
            $custom_field37 = $valor["cp"];
            $custom_field38 = $valor["zona"];
            $custom_field39 = $valor["adaptadominus"];
            $custom_field40 = $valor["airecentral"];
            $custom_field41 = $valor["aire_con"];
            $custom_field42 = $valor["alarma"];
            $custom_field43 = $valor["alarmaincendio"];
            $custom_field44 = $valor["alarmarobo"];
            $custom_field45 = $valor["arma_empo"];
            $custom_field46 = $valor["ascensor"];
            $custom_field47 = $valor["balcon"];
            $custom_field48 = $valor["bar"];
            $custom_field49 = $valor["barbacoa"];
            $custom_field50 = $valor["cajafuerte"];
            $custom_field51 = $valor["calefacentral"];
            $custom_field52 = $valor["calefaccion"];
            $custom_field53 = $valor["chimenea"];
            $custom_field54 = $valor["cocina_inde"];
            $custom_field55 = $valor["descalcificador"];
            $custom_field56 = $valor["diafano"];
            $custom_field57 = $valor["electro"];
            $custom_field58 = $valor["esquina"];
            $custom_field59 = $valor["galeria"];
            $custom_field60 = $valor["plaza_gara"];
            $custom_field61 = $valor["garajedoble"];
            $custom_field62 = $valor["gasciudad"];
            $custom_field63 = $valor["gimnasio"];
            $custom_field64 = $valor["habjuegos"];
            $custom_field65 = $valor["hidromasaje"];
            $custom_field66 = $valor["jacuzzi"];
            $custom_field66 = $valor["lavanderia"];
            $custom_field67 = $valor["linea_tlf"];
            $custom_field68 = $valor["luminoso"];
            $custom_field69 = $valor["muebles"];
            $custom_field70 = $valor["ojobuey"];
            $custom_field71 = $valor["parking"];
            $custom_field72 = $valor["patio"];
            $custom_field73 = $valor["piscina_com"];
            $custom_field74 = $valor["piscina_prop"];
            $custom_field75 = $valor["preinstaacc"];
            $custom_field76 = $valor["primera_line"];
            $custom_field77 = $valor["puerta_blin"];
            $custom_field78 = $valor["satelite"];
            $custom_field79 = $valor["sauna"];
            $custom_field80 = $valor["solarium"];
            $custom_field81 = $valor["sotano"];
            $custom_field82 = $valor["tv"];
            $custom_field83 = $valor["terraza"];
            $custom_field84 = $valor["terrazaacris"];
            $custom_field85 = $valor["todoext"];
            $custom_field86 = $valor["trastero"];
            $custom_field87 = $valor["urbanizacion"];
            $custom_field88 = $valor["vestuarios"];
            $custom_field89 = $valor["video_port"];
            $custom_field90 = $valor["vistasalmar"];
            $custom_field91 = $valor["energialetra"];
            $custom_field92 = $valor["energiarecibido"];
            $custom_field93 = $valor["descrip1"];
            $custom_field94 = $valor["titulo1"];
            $custom_field95 = $valor["titulo2"];
            $custom_field96 = $valor["descrip2"];
            $custom_field97 = $valor["numfotos"];
            $custom_field98 = $valor["foto1"];
            $custom_field99 = $valor["foto2"];
            //$custom_field1  = $valor['imagen'];
            //$custom_field2  = "left";
            $vectorCampos  = array($post_id,$post_name,$post_author,$post_date,$post_type,$post_status,$post_tags,$post_title,$post_content,$post_category,$custom_field1, $custom_field2, $custom_field3, $custom_field4, $custom_field5, $custom_field6, $custom_field6, $custom_field7, $custom_field8, $custom_field9, $custom_field10, $custom_field11, $custom_field12, $custom_field13, $custom_field14, $custom_field15, $custom_field16, $custom_field17, $custom_field18, $custom_field19, $custom_field20, $custom_field21, $custom_field22, $custom_field23, $custom_field24, $custom_field25, $custom_field26, $custom_field27, $custom_field28, $custom_field29, $custom_field30, $custom_field31, $custom_field32, $custom_field33, $custom_field34, $custom_field35, $custom_field36, $custom_field37, $custom_field38, $custom_field39, $custom_field40, $custom_field41, $custom_field42, $custom_field43, $custom_field44, $custom_field45, $custom_field46, $custom_field47, $custom_field48, $custom_field49, $custom_field50, $custom_field51, $custom_field52, $custom_field53, $custom_field54, $custom_field55, $custom_field56, $custom_field57, $custom_field58, $custom_field59, $custom_field60, $custom_field61, $custom_field62, $custom_field63, $custom_field64, $custom_field65, $custom_field66, $custom_field66, $custom_field67, $custom_field68, $custom_field69, $custom_field70,$custom_field71, $custom_field72, $custom_field73, $custom_field74, $custom_field75, $custom_field76, $custom_field77, $custom_field78, $custom_field79, $custom_field80, $custom_field81, $custom_field82, $custom_field83, $custom_field84, $custom_field85, $custom_field86, $custom_field87, $custom_field88, $custom_field89, $custom_field90, $custom_field91, $custom_field92, $custom_field93, $custom_field94, $custom_field95, $custom_field96, $custom_field97, $custom_field98, $custom_field99);
            array_push($vector,$vectorCampos);
            var_dump($valor);
        }
        /*
        foreach ($this->categoriaPrincipal as $value) {
            $id             = $contador + 1;
            $post_id        = $id;
            $post_name      = $value['titulo'];
            $post_author    = "editor@davidberruezo.com";
            //$post_date     = $this->convertDate($value['dia'],$value['mes']);
            $post_date      = $value['fecha'];
            $post_type      = "post";
            $post_status    = "publish";
            $post_tags      = "wordpress";
            $post_title     = $value['titulo'];
            $post_content   = $this->vectorDetalleContent[$contador];
            $post_category  = "wordpress";
            $custom_field1  = $value['imagen'];
            $custom_field2  = "left";
            $vectorCampos  = array($post_id,$post_name,$post_author,$post_date,$post_type,$post_status,$post_tags,$post_title,$post_content,$post_category,$custom_field1,$custom_field2);
            array_push($vector,$vectorCampos);
            $contador++;
        }
        */
        foreach($vector as $field){
            fputcsv($output, $field,',');
        }
        fclose($output);
        //var_dump($this->categoriaPrincipal);
    }

    /*
     * Leemos tags csv
     */
    public function getLabelCsv(){
        $vector = array(
            "post_id",
            "post_name",
            "post_author",
            "post_date",
            "post_type",
            "post_status",
            "post_tags",
            "post_title",
            "post_content",
            "post_category",
            "numagencia",
            "destacado",
            "antiguedad",
            "Tipo oferta",
            "keypromo",
            "opcioncompra",
            "latitud",
            "altitud",
            "aseos",
            "banyos",
            "carpinteria",
            "carpinext",
            "comunidadincluida",
            "tbano",
            "tcocina",
            "tfachada",
            "tpostigo",
            "tinterior",
            "distmar",
            "conservacion",
            "habdobles",
            "habitaciones",
            "m_cons",
            "m_parcela",
            "m_uties",
            "m_cocina",
            "m_comedor",
            "m_terraza",
            "numplanta",
            "orientacion",
            "salon",
            "suelo",
            "precioinmo",
            "precioalq",
            "ref",
            "accion",
            "ciudad",
            "cp",
            "zona",
            "adaptadominus",
            "airecentral",
            "aire_con",
            "alarma",
            "alarmaincendio",
            "alarmarobo",
            "arma_empo",
            "ascensor",
            "balcon",
            "bar",
            "barbacoa",
            "cajafuerte",
            "calefacentral",
            "calefaccion",
            "chimenea",
            "cocina_inde",
            "descalcificador",
            "diafano",
            "electro",
            "esquina",
            "galeria",
            "plaza_gara",
            "garajedoble",
            "gasciudad",
            "gimnasio",
            "habjuegos",
            "hidromasaje",
            "jacuzzi",
            "lavanderia",
            "linea_tlf",
            "luminoso",
            "muebles",
            "ojobuey",
            "parking",
            "patio",
            "piscina_com",
            "piscina_prop",
            "preinstaacc",
            "primera_line",
            "puerta_blin",
            "satelite",
            "sauna",
            "solarium",
            "sotano",
            "tv",
            "terraza",
            "terrazaacris",
            "todoext",
            "trastero",
            "urbanizacion",
            "vestuarios",
            "video_port",
            "vistasalmar",
            "energialetra",
            "energiarecibido",
            "descrip1",
            "titulo1",
            "titulo2",
            "descrip2",
            "numfotos",
            "foto1",
            "foto2",
            //"Imagen",
            //"posicion"
        );
        return $vector;
    }
}
?>