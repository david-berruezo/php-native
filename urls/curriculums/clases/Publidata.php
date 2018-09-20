<?php
namespace clases;
class Publidata{
    // var text
    private $categoria = "";
    private $nombre    = "";
    private $subtitulo = "";
    private $calle     = "";
    private $cp        = "";
    private $ciudad    = "";
    private $web       = "";
    // vectores pq tienen varios datos
    private $emails    = array();
    private $telefonos = array();
    private $equipos   = array();
    private $cargos    = array();

    /*
     * Constructor del objeto
     */
    public function __construct()
    {
        //echo "creamos objeto publidata<br>";
    }

    /*
     * Getters Setters
     */

    // Cetegorias
    public function setCategoria($_categoria){
        $this->categoria = $_categoria;
    }

    public function getCategoria(){
        return $this->categoria;
    }

    // Nombre
    public function setNombre($_nombre){
        $this->nombre = $_nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }

    // Subtitulo
    public function setSubtitulo($_subtitulo){
        $this->subtitulo = $_subtitulo;
    }

    public function getSubtitulo(){
        return $this->subtitulo;
    }

    // Calle
    public function setCalle($_calle){
        $this->calle = $_calle;
    }

    public function getCalle(){
        return $this->calle;
    }

    // Cp
    public function setCp($_cp){
        $this->cp = $_cp;
    }

    public function getCp(){
        return $this->cp;
    }

    // Ciudad
    public function setCiudad($_ciudad){
        $this->ciudad = $_ciudad;
    }

    public function getCiudad(){
        return $this->ciudad;
    }

    // Web
    public function setWeb($_web){
        $this->web = $_web;
    }

    public function getWeb(){
        return $this->web;
    }

    // Emails
    public function setEmails($_emails){
         $this->emails = $_emails;
    }

    public function getEmails(){
         return $this->emails;
    }

    // Telefonos
    public function setTelefonos($_telefonos){
        $this->telefonos = $_telefonos;
    }

    public function getTelefonos(){
        return $this->telefonos;
    }

    // Equipos
    public function setEquipos($_equipos){
        $this->equipos = $_equipos;
    }

    public function getEquipos(){
        return $this->equipos;
    }

    // Cargos
    public function setCargos($_cargos){
        $this->cargos = $_cargos;
    }

    public function getCargos(){
        return $this->cargos;
    }
}
?>