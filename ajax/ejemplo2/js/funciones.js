$(document).ready(function(){
    /**
     * Ejemplo petición ajax.
     * por el método GET
     */
    /*
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "delete", //Relative or absolute path to response.php file
        data: data,
        success: function(data) {
            if(data.response == false){
                console.log('No se ha podido actualizar');
            }else if(data.response == true){
                setTimeout(function(){ window.location.href = $url; }, 2000);
            }
        }
    },'json');
    */

    /**
     * Ejemplo petición ajax.
     * por el método POST
     */
    /*
    $.ajax({
        type: "POST",
        url: 'savemensaje',//form.attr('action')
        data: form.serialize(),
        dataType: "json",
        success: function(data) {
            if (data.response == true){
                $('.respuesta').css('display','block');
                $('#message').css('disabled','disabled');
                $('#fecha').css('disabled','disabled');
            }

        },
    }).done(function(data) {
        //console.log(data.response);
    }).fail(function(data) {
        console.log('fail');
    });
    */
})
