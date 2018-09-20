/**
 * David
 * Funciones front end
 */

$(document).ready(function(){
    /*
     * Declaramos variables
     */
    var pagina         = 1;
    var opcionBuscador = "all";
    var textoBuscar    = "";
    var estado         = "products";

    /*
     * Recogemos parametros todos
     * por QueryString
     *
     */
    function QueryString() {
        // This function is anonymous, is executed immediately and
        // the return value is assigned to QueryString!
        var query_string = {};
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            // If first entry with this name
            if (typeof query_string[pair[0]] === "undefined") {
                query_string[pair[0]] = decodeURIComponent(pair[1]);
                // If second entry with this name
            } else if (typeof query_string[pair[0]] === "string") {
                var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
                query_string[pair[0]] = arr;
                // If third or later entry with this name
            } else {
                query_string[pair[0]].push(decodeURIComponent(pair[1]));
            }
        }
        return query_string;
    };

    /*
     * Leemos paginas del html
     * pagination mediante tags data-page
     * y se lo pasamos a showProducts
     */
    function leerPaginas(){
        $(".pagination a").each(function (index) {
            var $this = $(this);
            $this.on("click", function (event) {
                event.preventDefault();
                pagina = $(this).data("page");
                if (estado == "products"){
                    showProducts(pagina);
                }else if (estado == "buscador"){
                    buscarAjax(pagina);
                }
            });
        });

    }

    /*
     * Leemos funciones
     * 1.- Mostrar Productos
     * 2.- Leer opciones busqueda
     */
    $('#loader-image').show();
    //var parametros = QueryString();
    //showProducts(parametros);
    showProducts(pagina);
    buscar();

    /*
     * 1.- Leemos los productos por el método load == read.php == product->readAll
     * 2.- Cambiamos el titulo de la cabecera
     * 3.- Cambiamos el titulo de la pagina o documento
     */
    function showProducts(parametros){
        // change page title
        changePageTitle('Proyectos');
        // fade out effect first
        $('#page-content').fadeOut('slow', function(){
            var data = {
                //"page_no":parametros.page_no
                "page_no":pagina
            };
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "admin/read.php", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                    if(data.response == false){
                        console.log('No se ha podido actualizar');
                    }else if(data.response == true){
                        $cadena = '<table class="table table-bordered table-hover">';
                        $cadena+= '<tr>';
                        $cadena+= '<th class="width-30-pct">Name</th>';
                        $cadena+= '<th class="width-30-pct">Description</th>';
                        $cadena+= '<th>Url</th>';
                        $cadena+= '<th>Created</th>';
                        $cadena+= '<th style="display:none;"></th>';
                        $cadena+= '</tr>';
                        for (var i=0;i<data.productos.length;i++){
                            //console.log("objeto"+data.productos[i]+" indice: "+i);
                            $cadena+= '<tr>';
                            $cadena+= '<td>'+data.productos[i].name+'</td>';
                            $cadena+= '<td>'+data.productos[i].description+'</td>';
                            $cadena+= '<td>'+data.productos[i].url+'</td>';
                            $cadena+= '<td>'+data.productos[i].created+'</td>';
                            $cadena+= '<td style="text-align:center;display:none;">';
                            $cadena+= '<div class="product-id display-none">'+data.productos[i].id+'</div>';
                            $cadena+= '</td>';
                            $cadena+= '</tr>';
                        }
                        $cadena+= '</table>';
                    }
                    $('#page-content').html($cadena);
                    $('.pagination-wrap').empty();
                    $('.pagination-wrap').html(data.valor);
                    $('#loader-image').hide();
                    $('#page-content').fadeIn('slow');
                    leerPaginas();
                }
            },'json');
        });
    }

    /*
     * Funcion de búsqueda
     */
    function buscar(){
        /*
         * Evento click buscar
         */
        $(".dropdown-menu a").each(function (index) {
            var $this = $(this);
            $this.on("click", function (event) {
                event.preventDefault();
                opcionBuscador = $(this).data("buscador");
                //showProducts(pagina);
                //console.log("opcionBuscador"+opcionBuscador);
            });
        });

        /*
         * Leer texto
         */
        $("#buscador").click(function(event){
            event.preventDefault();
            // change page title
            changePageTitle('Look for Projects');
            if ( $("#textobuscar") != "" ){
                buscarAjax();
            }
        });
    }

    /*
     * Enviar buscar ajax
     */
    function buscarAjax(){
        var data = {
            "opcionBuscador":opcionBuscador,
            "texto": $("#textobuscar").val(),
            "page_no":pagina
        }
        $('#page-content').fadeOut('slow', function() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "admin/search.php", //Relative or absolute path to response.php file
                data: data,
                success: function (data) {
                    if (data.response == false) {
                        console.log('No se ha podido actualizar');
                    } else if (data.response == true) {
                        $cadena = '<table class="table table-bordered table-hover">';
                        $cadena += '<tr>';
                        $cadena += '<th class="width-30-pct">Name</th>';
                        $cadena += '<th class="width-30-pct">Description</th>';
                        $cadena += '<th>Url</th>';
                        $cadena += '<th>Created</th>';
                        $cadena += '</tr>';
                        for (var i = 0; i < data.productos.length; i++) {
                            //console.log("objeto"+data.productos[i]+" indice: "+i);
                            $cadena += '<tr>';
                            $cadena += '<td>' + data.productos[i].name + '</td>';
                            $cadena += '<td>' + data.productos[i].description + '</td>';
                            $cadena += '<td>' + data.productos[i].url + '</td>';
                            $cadena += '<td>' + data.productos[i].created + '</td>';
                            $cadena += '<td style="text-align:center;display:none;">';
                            $cadena += '<div class="product-id display-none">' + data.productos[i].id + '</div>';
                            $cadena += '</td>';
                            $cadena += '</tr>';
                        }
                        $cadena += '</table>';
                    }
                    $('#page-content').html($cadena);
                    $('.pagination-wrap').empty();
                    $('.pagination-wrap').html(data.valor);
                    $('#loader-image').hide();
                    $('#page-content').fadeIn('slow');
                    estado = "buscador";
                    leerPaginas();
                }
            }, 'json');
        });
    }

    /*
     * Cambiamos titulo de la pagina
     */
    function changePageTitle(page_title){
        // change page title
        $('#page-title').text(page_title);

        // change title tag
        document.title = page_title;
    }

    /*
     * Apretamos el boton de leer productos
     */
    $('#read-products').click(function(){

        // show a loader img
        $('#loader-image').show();

        // show create product button
        $('#create-product').show();

        // hide read products button
        $('#read-products').hide();

        // show products
        estado = "products";
        showProducts(pagina);
    });

});