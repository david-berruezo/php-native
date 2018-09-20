$(document).ready(function(){

    /*
     * Coge idiomas por http
     * y paginas por http
     */
    var idioma     = "esp";
    var encontrado = false;
    var pagina     = "index";
    var str        = location.href;
    var n          = str.search("esp");
    if (n != -1){
        idioma = "esp";
    }else{
        idioma = "cat"
    }
    n              = str.search("negocio");
    if (n != -1) {
        pagina     = "negocio";
    }
    n              = str.search("repartidor");
    if (n != -1) {
        pagina     = "repartidor";
    }
    n              = str.search("index");
    if (n != -1) {
        pagina     = "index";
    }

    /*
     * Coge eventos
     * idiomas por ajax
     */
     $(".idiomacatalan").click(function(event){
         console.log("cat");
         idioma = "cat";
        cambiarIdioma();
     });

     $(".idiomaespanol").click(function(event){
         console.log("esp");
         idioma = "esp";
         cambiarIdioma();
     });


    /*
     * Creamos el video
     * y le damos tamaño a la capa
     */
    function video(){
        var width         = window.outerWidth;
        var height        = window.outerHeight;
        var widthBotones  = (width - 208) / 2;
        var heightBotones = (height - 59) / 2;
        var widthWebapp   = (width - 56) / 2;
        var heightWebapp  = (height - 25.5) / 2 -70;
        var widthMoviles  = width - (477);
        //widthMoviles      = 600;
        $('#video').css({ width: width + 'px', height: height + 'px' });
        $('.contenedorVideo').css({ width: width + 'px', height: height + 'px' });
        $('body').css({width: width + 'px', height: height + 0 + 'px' });
        $('.contenedorBotones').css({left:widthBotones+'px',top:heightBotones});
        $('.webapp').css({left:widthWebapp+'px',top:heightWebapp,display:'block'});
        $('.contenedorMoviles').css({width:widthMoviles+"px"});
        $('.contenedorMoviles li').css({marginRight:'100px'});
        $('.contenedorTextos').css({width:widthMoviles+"px"});
        $('.contenedorTextos li').css({marginRight:'100px'});
        $(window).resize(function(){
            width         = window.outerWidth;
            height        = window.outerHeight;
            widthBotones  = (width - 208) / 2;
            heightBotones = (height - 59) / 2;
            widthWebapp   = (width - 56) / 2;
            heightWebapp  = (height - 25.5) / 2 -70;
            widthMoviles  = width - (477);
            $('.contenedorVideo').css({ width: width + 'px', height: height + 'px' });
            $('#video').css({ width: width + 'px', height: height + 'px' });
            $('body').css({width: width + 'px', height: height + 'px' });
            $('.contenedorBotones').css({left:widthBotones+'px',top:heightBotones});
            $('.webapp').css({left:widthWebapp+'px',top:heightWebapp});
            $('.contenedorMoviles').css({width:widthMoviles+'px'});
            $('.contenedorMoviles li').css({marginRight:'100px'});
            $('.contenedorTextos').css({width:widthMoviles+'px'});
            $('.contenedorTextos li').css({marginRight:'100px'});
            $('.webapp').css({left:widthWebapp+'px',top:heightWebapp,display:'block'});
        });
        /*
        // Load the IFrame Player API code asynchronously.
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // Replace the 'ytplayer' element with an <iframe> and
        // YouTube player after the API code downloads.
        var player;
        function onYouTubePlayerAPIReady() {
            player = new YT.Player('video', {
                height: '360',
                width: '640',
                videoId: '757I7a-UNrI'
            });
        }
        */
    }

    /*
     * Creamos validaciones de los formularios
     */
    function crearValidaciones(){
        /*
         $("#indexForm").click(function(event){
         event.preventDefault();
         });
         */

        // Validaciones
        $("#enviarIndex").click(function(event){
            if ($("#name").val() == ""){
                if (idioma =="esp"){
                    $("#messagename").text("Debes de escribir un nombre");
                }else{
                    $("#messagename").text("Deus de escriure un nom");
                }
                encontrado = true;
            }
            if ($("#responsable").val() == ""){
                if (idioma == "esp"){
                    $("#messageresponsable").text("Debes de escribir un responsable");
                }else{
                    $("#messageresponsable").text("Deus de escriure un responsable");
                }
                encontrado = true;
            }
            if ($("#email").val() == ""){
                if (idioma == "esp"){
                    $("#messageemail").text("Debes de escribir un email");
                }else{
                    $("#messageemail").text("Deus de escriure un email");
                }
                encontrado = true;
            }
            if ($("#telefono").val() == ""){
                if (idioma == "esp"){
                    $("#messagetelefono").text("Debes de escribir un teléfono");
                }else{
                    $("#messagetelefono").text("Deus de escriure un teléfon");
                }
                encontrado = true;
            }
            if ($("#explicacion").val() == ""){
                if (idioma == "esp"){
                    $("#messageexplicacion").text("Debes de escribir como quieres colaborar con nosotros");
                }else{
                    $("#messageexplicacion").text("Deus de escriure com vols colaborar amb nosaltres");
                }
                encontrado = true;
            }
            if (encontrado == false){
                $("#indexForm").submit();
            }
        });

        $("#enviarRepartidor").click(function(event){
            var encontrado = false;
            if ($("#name").val() == ""){
                if (idioma == "esp"){
                    $("#messagename").text("Debes de escribir un nombre");
                }else{
                    $("#messagename").text("Deus de escriure un nom");
                }
                encontrado = true;
            }
            if ($("#email").val() == ""){
                if (idioma == "esp"){
                    $("#messageemail").text("Debes de escribir un email");
                }else{
                    $("#messageemail").text("Deus de escriure un email");
                }
                encontrado = true;
            }
            if ($("#telefono").val() == ""){
                if (idioma == "esp") {
                    $("#messagetelefono").text("Debes de escribir un teléfono");
                }else{
                    $("#messagetelefono").text("Deus de escriure un teléfon");
                }
                encontrado = true;
            }
            if ($("#message").val() == ""){
                if (idioma == "esp") {
                    $("#messagemessage").text("Debes de escribir un mensaje");
                }else{
                    $("#messagemessage").text("Deus de escriure un missatge");
                }
                encontrado = true;
            }
            if (encontrado == false){
                $("#enviarRepartidor").submit;
            }
        });
    }

    /*
     * Funciones ajax
     */
     function cambiarIdioma(){
         var data = {
             "idioma":idioma,
             "pagina":pagina
         }
         $.ajax({
             type: "GET",
             dataType: "json",
             url: "/objects/application.php", //Relative or absolute path to response.php file
             data: data,
             success: function (data) {
                 if (data.response == false) {
                     console.log('No se ha podido actualizar');
                     alert("Adios");
                 } else if (data.response == true) {
                     alert("Hola");
                     console.log('Se ha podido actualizar');
                 }
             }
         }, 'json');
     }


    /*
     * Llamada a funciones
     */
    video();
    crearValidaciones();
});
