<?php
class Product{
    // database connection and table name
    private $conn;
    private $table_name     = "products";
    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $created;
    public $url;

    // Paginador
    public $start            = 0;
    public $records_per_page = 5;
    // Busqueda
    public $busqueda;
    public $opcionBusqueda;

    /*
     * Construye el objeto
     */
    public function __construct($db){
        $this->conn = $db;
    }

    /*
     * Lee todos los productos
     */
    function readAll(){
        // select all query
        $query = "SELECT id, name, description, price, url,created FROM " . $this->table_name . " ORDER BY id ASC";
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // execute query
        $stmt->execute();
        return $stmt;
    }

    /*
     * Lee un solo producto
     */
    function readOne(){
        // query to read single record
        $query = "SELECT name, price, description,url FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        // prepare query statement
        $stmt  = $this->conn->prepare( $query );
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
        // execute query
        $stmt->execute();
        // get retrieved row
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        // set values to object properties
        $this->name        = $row['name'];
        $this->price       = $row['price'];
        $this->description = $row['description'];
        $this->url         = $row['url'];
    }

    /*
     * Crea un producto
     */
    function create(){
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, price=:price, description=:description, created=:created,url=:url";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // posted values
        $this->name         = htmlspecialchars(strip_tags($this->name));
        $this->price        = htmlspecialchars(strip_tags($this->price));
        $this->description  = htmlspecialchars(strip_tags($this->description));
        $this->created      = htmlspecialchars(strip_tags($this->created));
        $this->url          = htmlspecialchars(strip_tags($this->url));
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":url", $this->url);
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Actualiza un producto
     */
    function update(){
        // update query
        $query = "UPDATE " . $this->table_name . " SET name = :name, price = :price, description = :description, url = :url WHERE id = :id";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // posted values
        $this->name        = htmlspecialchars(strip_tags($this->name));
        $this->price       = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->url         = htmlspecialchars(strip_tags($this->url));
        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':url', $this->url);

        $stmt->execute();
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Borra un producto
     */
    function delete(){
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Búsqueda de un producto
     */
    public function search(){
        $starting_position = 0;

        if(isset($_GET["page_no"]))
        {
            //echo("page_no: ".$_GET["page_no"]);
            $starting_position = ($_GET["page_no"]-1) * $this->records_per_page;
        }

        // select all query
        if ($this->opcionBusqueda == "all"){
            //$query = "SELECT id, name, description, price, created FROM " . $this->table_name . " WHERE MATCH(name, description) AGAINST ('LG')";
            $query = "SELECT id, name, description, price,url,created FROM " . $this->table_name . " WHERE name LIKE '%$this->busqueda%' OR description LIKE '%$this->busqueda%' limit " .$starting_position. "," .$this->records_per_page;
        }else if ($this->opcionBusqueda == "name"){
            //$query = "SELECT id, name, description, price, created FROM " . $this->table_name . " WHERE MATCH(name) against ('LG')";
            $query = "SELECT id, name, description, price,url,created FROM " . $this->table_name . " WHERE name LIKE '%$this->busqueda%' limit " .$starting_position. "," .$this->records_per_page;
        }else if ($this->opcionBusqueda == "description"){
            //$query = "SELECT id, name, description, price, created FROM " . $this->table_name . " WHERE MATCH(description) against (".$this->busqueda.")";
            $query = "SELECT id, name, description, price,url,created FROM " . $this->table_name . " WHERE description LIKE '%$this->busqueda%' limit " .$starting_position. "," .$this->records_per_page;
        }
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // execute query
        $stmt->execute();
        return $stmt;
    }

    /*
     * Búsqueda de un producto
     * Paginado
     */
    public function searchPaginatorHtml(){

        $starting_position = 0;
        if(isset($_GET["page_no"]))
        {
            $starting_position = ($_GET["page_no"]-1) * $this->records_per_page;
        }
        // select all query
        //$query = "SELECT id, name, description, price, created FROM " . $this->table_name . " limit " .$starting_position. "," .$this->records_per_page;

        if ($this->opcionBusqueda == "all"){
            //$query = "SELECT id, name, description, price, created FROM " . $this->table_name . " WHERE MATCH(name, description) AGAINST ('LG')";
            $query = "SELECT id, name, description, price,url,created FROM " . $this->table_name . " WHERE name LIKE '%$this->busqueda%' OR description LIKE '%$this->busqueda%'";
            //$queryCount = "SELECT id, name, description, price, created FROM " . $this->table_name . " ORDER BY id ASC";
        }else if ($this->opcionBusqueda == "name"){
            //$query = "SELECT id, name, description, price, created FROM " . $this->table_name . " WHERE MATCH(name) against ('LG')";
            $query = "SELECT id, name, description, price,url,created FROM " . $this->table_name . " WHERE name LIKE '%$this->busqueda%'";
        }else if ($this->opcionBusqueda == "description"){
            //$query = "SELECT id, name, description, price, created FROM " . $this->table_name . " WHERE MATCH(description) against (".$this->busqueda.")";
            $query = "SELECT id, name, description, price,url,created FROM " . $this->table_name . " WHERE description LIKE '%$this->busqueda%'";
        }

        //$self = $_SERVER['PHP_SELF'];
        $self = "index.php";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Contamos
        $total_no_of_records = $stmt->rowCount();
        //echo ("total filas: ".$total_no_of_records);


        $html = "";
        if($total_no_of_records > 0)
        {
            $html .= "<ul class='pagination'>";

            $total_no_of_pages = ceil($total_no_of_records / $this->records_per_page);
            $current_page = 1;
            if(isset($_GET["page_no"]))
            {
                $current_page = $_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous = $current_page - 1;
                //$html = "<li><a href='".$self."?page_no=1' data-page='1'>First</a></li>";
                //$html .= "<li><a href='".$self."?page_no=".$previous."' data-page='".$previous."'>Previous</a></li>";

                $html .= "<li><a href='#' data-page='1'>First</a></li>";
                $html .= "<li><a href='#' data-page='".$previous."'>Previous</a></li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    //$html .= "<li><a href='".$self."?page_no=".$i."' data-page='".$i."' style='color:red;'>".$i."</a></li>";
                    $html .= "<li><a href='#' data-page='".$i."' style='color:red;'>".$i."</a></li>";
                }
                else
                {
                    //$html .= "<li><a href='".$self."?page_no=".$i."' data-page='".$i."'>".$i."</a></li>";
                    $html .= "<li><a href='#' data-page='".$i."'>".$i."</a></li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                //$html .= "<li><a href='".$self."?page_no=".$next."' data-page ='".$next."'>Next</a></li>";
                //$html .= "<li><a href='".$self."?page_no=".$total_no_of_pages."' data-page='".$total_no_of_pages."'>Last</a></li>";
                $html .= "<li><a href='#' data-page ='".$next."'>Next</a></li>";
                $html .= "<li><a href='#' data-page='".$total_no_of_pages."'>Last</a></li>";
            }
            $html .= "</ul>";
            return $html;
        }
    }

    /*
     * Consulta sobre las paginas
     */
    public function paging()
    {
        $starting_position = 0;

        if(isset($_GET["page_no"]))
        {
            //echo("page_no: ".$_GET["page_no"]);
            $starting_position = ($_GET["page_no"]-1) * $this->records_per_page;
        }
        // select all query
        $query = "SELECT id, name, description, price,url, created FROM " . $this->table_name . " limit " .$starting_position. "," .$this->records_per_page;
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    /*
     * Devuelve html paginador ajax
     */
    public function paginglink()
    {
        $starting_position = 0;
        if(isset($_GET["page_no"]))
        {
            $starting_position = ($_GET["page_no"]-1) * $this->records_per_page;
        }
        // select all query
        $query = "SELECT id, name, description, price, ,url,created FROM " . $this->table_name . " limit " .$starting_position. "," .$this->records_per_page;
        //$self = $_SERVER['PHP_SELF'];
        $self = "index.php";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Contamos
        //$total_no_of_records = 11;
        $queryCount = "SELECT id, name, description, price, url,created FROM " . $this->table_name . " ORDER BY id ASC";
        // prepare query statement
        $stmtCount = $this->conn->prepare( $queryCount );
        // execute query
        $stmtCount->execute();
        $total_no_of_records = $stmtCount->rowCount();

        $html = "";
        if($total_no_of_records > 0)
        {
            $html .= "<ul class='pagination'>";

            $total_no_of_pages = ceil($total_no_of_records / $this->records_per_page);
            $current_page = 1;
            if(isset($_GET["page_no"]))
            {
                $current_page = $_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous = $current_page - 1;
                //$html = "<li><a href='".$self."?page_no=1' data-page='1'>First</a></li>";
                //$html .= "<li><a href='".$self."?page_no=".$previous."' data-page='".$previous."'>Previous</a></li>";

                $html .= "<li><a href='#' data-page='1'>First</a></li>";
                $html .= "<li><a href='#' data-page='".$previous."'>Previous</a></li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                   //$html .= "<li><a href='".$self."?page_no=".$i."' data-page='".$i."' style='color:red;'>".$i."</a></li>";
                    $html .= "<li><a href='#' data-page='".$i."' style='color:red;'>".$i."</a></li>";
                }
                else
                {
                    //$html .= "<li><a href='".$self."?page_no=".$i."' data-page='".$i."'>".$i."</a></li>";
                    $html .= "<li><a href='#' data-page='".$i."'>".$i."</a></li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                //$html .= "<li><a href='".$self."?page_no=".$next."' data-page ='".$next."'>Next</a></li>";
                //$html .= "<li><a href='".$self."?page_no=".$total_no_of_pages."' data-page='".$total_no_of_pages."'>Last</a></li>";
                $html .= "<li><a href='#' data-page ='".$next."'>Next</a></li>";
                $html .= "<li><a href='#' data-page='".$total_no_of_pages."'>Last</a></li>";
            }
            $html .= "</ul>";
            return $html;
        }
    }
}

