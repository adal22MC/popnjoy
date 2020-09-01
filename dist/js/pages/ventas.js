const procesarVenta = document.getElementById('procesarVenta');
const modalSelectClient = document.getElementById('formSeleccionarCliente');

/* Guardamos los datos de los productos que se van a vender */
var idProductsVentas = [];
var totalAPagar = 0;



/* ========================================================
   Funcion que pide datos del producto qeu se vendera
   para posteriormente llamas a la funcion addProductVentas
  ========================================================== */

$('.tablaProductos').on('click', '.btnAdd', async (e) => {
    e.preventDefault();

    try {
        
        let idProduct = new FormData();
            idProduct.append('idProduct', e.target.id);

        let peticion = await fetch('apis/apisProducto.php', {
            method : 'POST',
            body : idProduct
        })

        let resjson = await peticion.json();
        addProductListVentas(resjson);

    } catch (error) {
        console.log(error);
    }
    
})


/* =======================================================
    Funcion que se encarga de agregar un producto a la 
    lista de producto a vender
 =========================================================*/
function addProductListVentas(product){

    Swal.fire({
        title: 'Ingresa la cantidad a vender',
        input: 'text',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Agregar',
    }).then( cantidad => {
        if(cantidad.value){
            let can = parseInt( cantidad.value );
            let stock = parseInt( product.stock );
            
            if(can <= stock){

                /*  =====================================================
                    Validamos si el usuario quiere agregar de nuevo
                    el mismo producto
                   ======================================================*/
                
                let ban = validarProductoRepetido(product);

                if(ban == true){

                    // Total por producto
                    let totalPorProducto = can * product.precio_venta;

                    $('.listProductVenta').find('tbody').append(`
                        <tr>
                            <td>
                                <button class="btn btn-sm btn-danger btnEliminar" id="${product.id_producto}">ELIMINAR</button>
                            </td>
                            <td>${product.nombre}</td>
                            <td>${can}</td>
                            <td>${totalPorProducto}</td>
                        </tr>
                    `);

                    // Agregamos el producto a nuestro objeto
                    idProductsVentas.push({
                        id : product.id_producto,
                        cantidad : can,
                        total : totalPorProducto
                    });

                    
                    totalAPagar =  calcularTotalApagar() ;
                    if( totalAPagar == 0){
                        document.getElementById('totalApagar').innerHTML = '<b>Lista de productos a vender</b>';
                    }else{
                        document.getElementById('totalApagar').innerHTML = '<b>Total de la venta $ '+totalAPagar+'</b>';
                    }
                    


                }else{
                    notificarError('¡Este producto ya esta agregado, si desea agregar más eliminado y agregalo de nuevo!');
                }

                console.log(idProductsVentas);
            }else{
                notificarError('¡No hay suficiente stock!');
            }
        }
    })  

}


/* =============================================================
  Funcion que elimina el producto de la lista vender y del JSON
 =============================================================== */
$('.listProductVenta').on('click', '.btnEliminar', (e) => {
    console.log('Eliminando ...');

    let pos = 0;
    
    for( let item of idProductsVentas){
        if(item == undefined){}
        else{
            if( parseInt( item.id ) == parseInt( e.target.id ) ){
                console.log('ENTRO A ELIMINAR');
                delete idProductsVentas[pos];
            }
        }
        pos = pos + 1;
    }
    


    
    console.log(e.target.id);
    console.log(idProductsVentas);
    e.target.parentNode.parentNode.remove();


    totalAPagar = calcularTotalApagar() ;
    if( totalAPagar  == 0){
        document.getElementById('totalApagar').innerHTML = '<b>Lista de productos a vender</b>';
    }else{
        document.getElementById('totalApagar').innerHTML = '<b>Total de la venta $ '+totalAPagar+'</b>';
    }
});

function calcularTotalApagar(){
    let total = 0;

    for(let item of idProductsVentas){
        if(item == undefined){

        }else{
            total = total + item.total ;
        }
    }

    console.log('El total hasta ahora es ' + total)
    return total;
}

/* ==========================================================
   Funcion que valida si al agregar otra vez un mismo producto
   este tiene ya esta agregado
  ===========================================================*/

function validarProductoRepetido(product){

    let id = parseInt ( product.id_producto);
    
    for( let item of idProductsVentas){
        if(item == undefined){}
        else{
            if( parseInt( item.id ) == id){
                return false;
            }
        }
    }

    return true;

}

/* =================================================
    Cuando se presiona el boton Procesar venta
 ===================================================*/

procesarVenta.addEventListener('click', async (e) => {
    let contador = 0;
    // Validamos si por lo menos hay un producto en la lista
    for(item of idProductsVentas){
        if(item == undefined){}
        else{
            contador = contador + 1;
        }
    }


    if(contador == 0){
        notificarError('No has agregado productos a lista');
    }else{
    
        /* LLenamos el select con los nombres delos clientes */
        try {
            let form = new FormData();
            form.append('getAllClients', 'ok');

            let peticion = await fetch('apis/apisCliente.php', {
                method:'POST', 
                body : form
            })

            let resjson = await peticion.json();
            console.log(resjson);
            llenarSelectClients(resjson);
            

        } catch (error) {
            console.log(error);
        }


        // Hacemos visible el modal
        $('#modalSeleccionarCliente').modal('show');

     }
 })


 modalSelectClient.addEventListener('submit', async (e) => {
     console.log("Se inicio el submit....")
     e.preventDefault();

     if(document.getElementById('selectCliente').value == "clienteDefault"){
        notificarError('¡Selecciona un cliente!')
     }else{
        console.log('Procesando venta');
        console.log(document.getElementById('selectCliente').value);


        let listaVentas = [];

        // Limpiamos la lista de ventas de los undefined
        for(item of idProductsVentas){
            if(item == undefined){}
            else{
                listaVentas.push({
                    id : item.id,
                    cantidad : item.cantidad,
                    total : item.total
                });
            }
        }


        listaVentas.unshift({
            idCliente : document.getElementById('selectCliente').value
        })
        

        try {
            
            
            let peticion = await fetch('apis/apisVenta.php', {
                method:'POST', 
                body : JSON.stringify(listaVentas),
                headers : {
                    'Content-Type' :  'application/json'
                }
            })

            console.log('Datos en la lista');
            console.log(listaVentas);
            console.log('Respuesta del servidor ...');
            let resjson = await peticion.json();

            console.log(resjson);

            if(resjson.respuesta == "BIEN"){
                Swal.fire(
                    'Venta Genereda',
                    'Execelente',
                    'success'
                ).then( r => {
                   window.location = "plantilla_pdf.php?idVenta="+resjson.idVenta;
                })
            }else{
                notificarError(resjson.respuesta);
            }

        } catch (error) {
            //console.log('Entro en este error');
            console.log(error);
        }
        
     }
     
 })


/* ================================================================
 Funcion que llena el select de clientes con todos los nombre
 de los clientes de la BD
=======================================================================*/

function llenarSelectClients(cliente){

    var select = document.getElementById('selectCliente');

    while(select.length > 0){
        select.remove(0);
    }

    let optionDef = document.createElement('option');
    optionDef.text = "Seleccione un cliente";
    optionDef.value = "clienteDefault";
    optionDef.selected;
    select.add(optionDef);

   // <option value="clienteDefault">Seleccione un cliente</option>

    for(let item of cliente){
        let option = document.createElement('option');
        option.text = item.nombre;
        option.value = item.id;
        select.add(option);
    }
    
}


function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}