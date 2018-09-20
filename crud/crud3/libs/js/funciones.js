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
        changePageTitle('Read Products');
        // fade out effect first
        $('#page-content').fadeOut('slow', function(){
            var data = {
                //"page_no":parametros.page_no
                "page_no":pagina
            };
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "read.php", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                    if(data.response == false){
                        console.log('No se ha podido actualizar');
                    }else if(data.response == true){
                        $cadena = '<table class="table table-bordered table-hover">';
                        $cadena+= '<tr>';
                        $cadena+= '<th class="width-30-pct">Name</th>';
                        $cadena+= '<th class="width-30-pct">Description</th>';
                        $cadena+= '<th>Price</th>';
                        $cadena+= '<th>Url</th>';
                        $cadena+= '<th>Created</th>';
                        $cadena+= '<th style="text-align:center;">Action</th>';
                        $cadena+= '</tr>';
                        for (var i=0;i<data.productos.length;i++){
                            //console.log("objeto"+data.productos[i]+" indice: "+i);
                            $cadena+= '<tr>';
                            $cadena+= '<td>'+data.productos[i].name+'</td>';
                            $cadena+= '<td>'+data.productos[i].description+'</td>';
                            $cadena+= '<td>'+data.productos[i].price+'</td>';
                            $cadena+= '<td>'+data.productos[i].url+'</td>';
                            $cadena+= '<td>'+data.productos[i].created+'</td>';
                            $cadena+= '<td style="text-align:center;">';
                            $cadena+= '<div class="product-id display-none">'+data.productos[i].id+'</div>';
                            $cadena+= '<div class="btn btn-info edit-btn margin-right-1em">';
                            $cadena+= '<span class="glyphicon glyphicon-edit"></span> Edit';
                            $cadena+= '</div>';
                            $cadena+= '<div class="btn btn-danger delete-btn">';
                            $cadena+= '<span class="glyphicon glyphicon-remove"></span> Delete';
                            $cadena+= '</div>';
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
            changePageTitle('Look for Products');
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
                url: "search.php", //Relative or absolute path to response.php file
                data: data,
                success: function (data) {
                    if (data.response == false) {
                        console.log('No se ha podido actualizar');
                    } else if (data.response == true) {
                        $cadena = '<table class="table table-bordered table-hover">';
                        $cadena += '<tr>';
                        $cadena += '<th class="width-30-pct">Name</th>';
                        $cadena += '<th class="width-30-pct">Description</th>';
                        $cadena += '<th>Price</th>';
                        $cadena += '<th>Created</th>';
                        $cadena += '<th style="text-align:center;">Action</th>';
                        $cadena += '</tr>';
                        for (var i = 0; i < data.productos.length; i++) {
                            //console.log("objeto"+data.productos[i]+" indice: "+i);
                            $cadena += '<tr>';
                            $cadena += '<td>' + data.productos[i].name + '</td>';
                            $cadena += '<td>' + data.productos[i].description + '</td>';
                            $cadena += '<td>' + data.productos[i].price + '</td>';
                            $cadena += '<td>' + data.productos[i].url + '</td>';
                            $cadena += '<td>' + data.productos[i].created + '</td>';
                            $cadena += '<td style="text-align:center;">';
                            $cadena += '<div class="product-id display-none">' + data.productos[i].id + '</div>';
                            $cadena += '<div class="btn btn-info edit-btn margin-right-1em">';
                            $cadena += '<span class="glyphicon glyphicon-edit"></span> Edit';
                            $cadena += '</div>';
                            $cadena += '<div class="btn btn-danger delete-btn">';
                            $cadena += '<span class="glyphicon glyphicon-remove"></span> Delete';
                            $cadena += '</div>';
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
     * 1.- Pinchamos editar un producto update_form.php == product->readOne
     * 2.- Cambiamos titulo del documento en Update Product
     * 3.- Se muesta la ficha del detalle
     */
    // clicking the edit button
    $(document).on('click', '.edit-btn', function(){
        // change page title
        changePageTitle('Update Product');
        var product_id = $(this).closest('td').find('.product-id').text();
        var data = {
            "product_id":product_id
        }
        // show a loader image
        $('#loader-image').show();
        // hide create product button
        $('#create-product').hide();
        // show read products button
        $('#read-products').show();
        //$('#page-content').empty();
        // fade out effect first
        $('#page-content').fadeOut('slow', function(){
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "update_form.php", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                    //console.log("data: "+data.response);
                    if(data.response == false){
                        console.log('No se ha podido actualizar');
                    }else if(data.response == true){
                        //setTimeout(function(){ window.location.href = $url; }, 2000);
                        //console.log("datos: "+data.productos);
                        $cadena = '<table class="table table-bordered table-hover">';
                        $cadena+= '<tr>';
                        $cadena = '<form id="update-product-form" action="#" method="post" border="0">';
                        $cadena+= '<table class="table table-bordered table-hover">';
                        $cadena+= '<tr>';
                        $cadena+= '<td>Name</td>';
                        $cadena+= '<td><input type="text" name="name" class="form-control" value="'+data.productos.name+'" required /></td>';
                        $cadena+= '</tr>';
                        $cadena+= '<tr>';
                        $cadena+= '<td>Description</td>';
                        $cadena+= '<td>';
                        $cadena+= '<textarea name="description" class="form-control" required>'+data.productos.description+'</textarea>';
                        $cadena+= '</td>';
                        $cadena+= '</tr>';
                        $cadena+= '<tr>';
                        $cadena+= '<td>Price</td>';
                        $cadena+= '<td><input type="number" min="1" name="price" class="form-control" value='+data.productos.price+' required /></td>';
                        $cadena+= '</tr>';
                        $cadena+= '<tr>';
                        $cadena+= '<td>Url</td>';
                        $cadena+= '<td><input type="text" min="1" name="url" class="form-control" value='+data.productos.url+' required /></td>';
                        $cadena+= '</tr>';
                        $cadena+= '<tr>';
                        $cadena+= '<td>';
                        $cadena+= '<input type="hidden" name="id" value="'+product_id+'" />';
                        $cadena+= '</td>';
                        $cadena+= '<td>';
                        $cadena+= '<button type="submit" class="btn btn-primary">';
                        $cadena+= '<span class="glyphicon glyphicon-edit"></span> Save Changes';
                        $cadena+= '</button>';
                        $cadena+= '</td>';
                        $cadena+= '</tr>';
                        $cadena+= '</table>';
                        $cadena+= '</form>';

                        $('#page-content').html($cadena);
                        // hide loader image
                        $('#loader-image').hide();
                        // fade in effect
                        $('#page-content').fadeIn('slow');
                    }
                }
            },'json');
        });
    });


    /*
     * 1.- Pinchamos update en la ficha del producto update.php == product->update
     * 2.- Se muesta la ficha del detalle
     */
    $(document).on('submit', '#update-product-form', function() {
        // show a loader img
        $('#loader-image').show();
        // post the data from the form
        $.post("update.php", $(this).serialize())
            .done(function(data) {
                // show create product button
                $('#create-product').show();
                // hide read products button
                $('#read-products').hide();
                // 'data' is the text returned, you can do any conditions based on that
                estado = "products";
                showProducts(pagina);
            });
        return false;
    });


    /*
     * Borramos un producto
     */
    $(document).on('click', '.delete-btn', function(){
        if(confirm('Are you sure?')){
            // get the id
            var product_id = $(this).closest('td').find('.product-id').text();
            // trigger the delete file
            $.post("delete.php", { id: product_id })
                .done(function(data){
                    //console.log(data);
                    // show loader image
                    $('#loader-image').show();
                    // reload the product list
                    estado = "products";
                    showProducts(pagina);

                });
        }
    });


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



    /*
     * Creamos formulario de producto
     * Pagina == create.php
     */
    $('#create-product').click(function(){
        // change page title
        changePageTitle('Create Product');

        // show create product form
        // show a loader image
        $('#loader-image').show();

        // hide create product button
        $('#create-product').hide();

        // show read products button
        $('#read-products').show();

        // fade out effect first
        $('#page-content').fadeOut('slow', function(){
            var data = {};
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "create_form.php", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                    if(data.response == false){
                        console.log('No se ha podido actualizar');
                    }else if(data.response == true){
                        //setTimeout(function(){ window.location.href = $url; }, 2000);
                        $cadena =  '<form id="create-product-form" action="#" method="post" border="0">';
                        $cadena += '<table class="table table-hover table-responsive table-bordered">';
                        $cadena += '<tr>';
                        $cadena += '<td>Name</td>';
                        $cadena += '<td><input type="text" name="name" class="form-control" required /></td>';
                        $cadena += '</tr>';
                        $cadena += '<tr>';
                        $cadena += '<td>Description</td>';
                        $cadena += '<td><textarea name="description" class="form-control" required></textarea></td>';
                        $cadena += '</tr>';
                        $cadena += '<tr>';
                        $cadena += '<td>Price</td>';
                        $cadena += '<td><input type="number" min="1" name="price" class="form-control" required /></td>';
                        $cadena += '</tr>';
                        $cadena += '<tr>';
                        $cadena += '<td>Url</td>';
                        $cadena += '<td><input type="text" min="1" name="url" class="form-control" required /></td>';
                        $cadena += '</tr>';
                        $cadena += '<tr>';
                        $cadena += '<td></td>';
                        $cadena += '<td>';
                        $cadena += '<button type="submit" class="btn btn-primary">';
                        $cadena += '<span class="glyphicon glyphicon-plus"></span> Create Product';
                        $cadena += '</button>';
                        $cadena += '</td>';
                        $cadena += '</tr>';
                        $cadena += '</table>';
                        $cadena += '</form>';
                        $('#page-content').html($cadena);
                        // hide loader image
                        $('#loader-image').hide();
                        // fade in effect
                        $('#page-content').fadeIn('slow');
                    }
                }
            },'json');

        });
    });

    /*
     * Insertamos producto
     * Pagina == create.php
     */
    $(document).on('submit', '#create-product-form', function() {

        // show a loader img
        $('#loader-image').show();

        // post the data from the form
        $.post("create.php", $(this).serialize())
            .done(function(data) {

                // show create product button
                $('#create-product').show();

                // hide read products button
                $('#read-products').hide();

                // 'data' is the text returned, you can do any conditions based on that
                estado = "products";
                showProducts(pagina);
            });

        return false;
    });
})
