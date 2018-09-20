/**
 * Created by David on 14/07/2016.
 */

$(document).ready(function(){
    console.log("Hola funciones");
    /**
     * Guardamos un producto a la cesta temporal falta guardar en la bd
     * Asi si que si se pierde la sesión se pierde el producto
     */
    $('.detallespedidoadministrdor').click(function(event){
        event.preventDefault();
        $idpedido = $(this).data('idpedido');
        $idtienda = $(this).data('idtienda');
        var data = {
            "idpedido"  : $idpedido,
            "idtienda"  : $idtienda,

        };

        $total  = 0;
        // Crear cesta de la compra
        $cadena = '<div class="detallePedido" style="display:block;">';
        $cadena+= '<div class="cart" style="display:block;">';
        $cadena+= '<div class="cart" style="display:block;">';
        $cadena+= '<h3>Productos en el pedido</h3>';
        $cadena+= '<table class=".table" style="width:100%;" border="1">';
        $cadena+= '<tr align="left"><th align="left">Cantidad</th><th align="left">Nombre</th><th align="left">Precio</th><th align="left">Sub-Total</th></tr>';

        $producto = '';

        var contadorPedidos = 0;

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "verPedidoDetalleAdmin", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                // Data response and objects
                for (var key in data){
                    // Pedidos
                    if (key == 'pedidos'){
                        var pedidos = data[key];
                        //console.log("Pedidos:"+pedidos);
                        $producto = '';
                        $total 	  = 0;
                        for (var indicePedidos in pedidos){
                            //console.log("Clave pedidos:"+indicePedidos);
                            //console.log("Value pedidos:"+pedidos[indicePedidos]);
                            var objeto = pedidos[indicePedidos];
                            $producto += '<tr>';
                            for (var indiceObjeto in objeto) {
                                //console.log("Clave pedido:" + indiceObjeto);
                                //console.log("Value pedido:" + objeto[indiceObjeto]);
                                if (indiceObjeto != 'id' && indiceObjeto != 'idtienda' && indiceObjeto != 'id_producto') {
                                    $producto += '<td style="text-align: left;">'
                                    $producto += objeto[indiceObjeto];
                                    $producto += '</td>';
                                    if (indiceObjeto == 'cantidad') {
                                        $cantidad = objeto[indiceObjeto];
                                    }
                                    if (indiceObjeto == 'precio') {
                                        $cantidad = objeto[indiceObjeto] * $cantidad;
                                    }
                                } // End if
                            } // End for
                            $producto += '<td style="text-align: left;">';
                            $producto += $cantidad;
                            $total = $total + $cantidad;
                            $producto += '</td>';
                            $producto += '</tr>';
                        } // End for
                        $cadena+=$producto;
                    }// End if
                } // End for
                $cadena+='<td colspan="2" style="text-align:right;margin-right:20px;font-weight:bold;">Total</td>';
                $cadena+='<td style="text-align:left;">';
                $cadena+=$total;
                $cadena+='</td>';
                $cadena+='</table>';
                $cadena+='</div>';
                $cadena+='</div>';
                $cadena+='</div>';
                var pedidoAbuscar =  'pedido'+$idpedido;
                //console.log('El pedido a buscar es: '+pedidoAbuscar);
                $('*[data-nombre = "'+pedidoAbuscar+'"]').each(function(index){
                    //console.log('Encontrado');
                    $(this).html($cadena);

                    contadorPedidos++;
                });
            } // End success
        },'json');

    });

});