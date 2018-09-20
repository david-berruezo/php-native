/**
 * David Berruezo
 */
$(document).ready(function(){
    // Object var
    var elemento   = $("#form1");
    var elemento1  = document.getElementById("form1");
    var request    = new XMLHttpRequest();
    /*
     * Primer ejemplo le pasamos el formulario
     */
    /*
    request.open("POST", "submit.php");
    request.send(new FormData(elemento1));
    */


    /*
     * Multiple files
     */
    var form          = document.forms.namedItem("filemultiple");
    var oData         = new FormData();
    var oReq          = new XMLHttpRequest();
    var oOutput       = document.getElementById("salida");
    var contenedor    = document.getElementById("contenedorFiles");
    var elementos     = form.elements;
    var vector        = new Array();
    form.addEventListener('submit', function(ev) {
        for (var i = 0; i < elementos.length; i++){
            if (elementos.item(i).type == 'file') {
                var file = elementos.item(i);
                console.log("name:"+file.files[0]);
                if (file.files[0] != undefined){
                    var idimagen = file.getAttribute("data-idimagen");
                    var objeto = {
                        "idimagen": idimagen
                    }
                    vector.push(objeto);
                    oData.append("file[]", elementos.item(i).files[0]);
                }
            }
        }
        var json = JSON.stringify(vector);
        oData.append("objeto", json);
        oReq.open("POST", "submit.php", true);
        oReq.onload = function(oEvent) {
            if (oReq.status == 200) {
                oOutput.innerHTML = "Uploaded!";
            } else {
                oOutput.innerHTML = "Error " + oReq.status + " occurred when trying to upload your file.<br \/>";
            }
        };
        oReq.send(oData);
        ev.preventDefault();

    });


    /*
    var fav_count = document.getElementByName('fav[]');
    var is_checked = false;

    for (var i = 0; i < fav_count; i++) {
        if (document.myform.elements['fav[]'].checked) {
            is_checked = true;
            break;
        }
    }

    for (var i = 0; i < p_ids.length; i++) {
        document.write(files[i].name);
    }
    */
    //console.log("files: "+document.getElementById('file[]').files.length);
    /*
    form.addEventListener('submit', function(ev) {
        var oOutput = document.querySelector("div"),
            oData   = new FormData(form);
            //ins     = document.getElementById('file[]').files.length;
        //oData.append("CustomField", "This is some extra data");
        //oData.append("userfile", filelabel.files[0]);
        //for (var x = 0; x < ins; x++) {
            //oData.append("file[]", document.getElementById('file[]').files[0]);
        //}
        //for (var i = 0;i < p_ids.length; i++){
          //  console.log("i"+i);
            //oData.append("file[]", document.getElementById('file[]').files[0]);
        //}

        //for (var i = 0, len = p_ids.length; i < len; i++) {
            //alert(p_ids[i].value);
            //oData.append("file[]", document.getElementById('file[]').files[0]);
        //}

        var oReq = new XMLHttpRequest();
        oReq.open("POST", "submit.php", true);
        oReq.onload = function(oEvent) {
            if (oReq.status == 200) {
                oOutput.innerHTML = "Uploaded!";
            } else {
                oOutput.innerHTML = "Error " + oReq.status + " occurred when trying to upload your file.<br \/>";
            }
        };
        oReq.send(oData);
        ev.preventDefault();
    }, false);
    */


    /*
     *
     */
    /*
    $.ajax({
        type: "POST",
        //dataType: "json",
        url: "submit.php", //Relative or absolute path to response.php file
        data: elemento,
        processData: false,  // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
        success: function(data) {
            if (data.response == false) {
                console.log('No se ha podido actualizar');
            } else if (data.response == true) {
                console.log("perfecto");
            }
        }

    },'json');
    */
});