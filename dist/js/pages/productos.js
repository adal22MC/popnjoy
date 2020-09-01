const formAddProduct = document.getElementById('formAddProduct');
const formEditProduct = document.getElementById('formEditPrduct');

var idProductoEdit;



formAddProduct.addEventListener('submit', (e) => {
    e.preventDefault();

    // Filtro para verificar que selecciono una categoria
    if(document.getElementById('selectCategoria').value == "Seleccione una categoria"){
        notifacionError("Selecciona una cateogoria!");
    }else{
        // Preparemos los datos
        let datosProducto = new FormData(formAddProduct);
        datosProducto.append('addProduct', 'ok');

        if(datosProducto.get('stockProducto') < 0){
            notifacionError("El stock no puede ser negativo!");
        }else if(datosProducto.get('stockMinimo') < 0){
            notifacionError("El stock minimo no puede ser negativo!");
        }else if(datosProducto.get('stockMaximo') < 0){
            notifacionError("El stock maximo no puede ser negativo!");
        }else{
            console.log('Enviando datos ...');
            guardarProducto(datosProducto);
        }
    }
})

async function guardarProducto(datosProducto){
    try {
        
        let peticion= await fetch('apis/apisProducto.php', {
            method : 'POST',
            body : datosProducto
        })

        let resjson = await peticion.json();

        if(resjson.respuesta == "ALTA CORRECTA"){
            document.getElementById('closeInsertProduct').click();
            notificacionExitosa('ALTA CORRECTA!');
        }else{
            notifacionError(resjson.respuesta);
        }

    } catch (error) {
        console.log(error)
    }
}

/* ================================================================
    Cuando se presiona el boton editar de la tabla pruductos
  ================================================================= */
$('.tablaProductos').on('click', '.btnEditar', async (e) =>{
    console.log(e.target.id);

    let idProduct = new FormData();
    idProduct.append('idProduct', e.target.id);

    try {

        let peticion = await fetch('apis/apisProducto.php', {
            method : 'POST',
            body : idProduct
        });

        let resjson = await peticion.json();
        console.log(resjson);

        document.getElementById('nombreProducto').value = resjson.nombre;
        document.getElementById('idselectCategoria').value = resjson.categoria;
        document.getElementById('stockProducto').value = resjson.stock;
        document.getElementById('stockMinimo').value = resjson.stock_min;
        document.getElementById('stockMaximo').value = resjson.stock_max;
        document.getElementById('precioVenta').value = resjson.precio_venta;
        document.getElementById('precioCompra').value = resjson.precio_compra;
        document.getElementById('observaciones').value = resjson.observaciones;

        idProductoEdit = resjson.id_producto;

    } catch (error) {
        console.log(error);
    }
});

/* ==========================================================
    Envento cuando se guardan los cambios de un producto
  ============================================================*/
formEditProduct.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Filtro para verificar que selecciono una categoria
    if(document.getElementById('idselectCategoria').value == "Seleccione una categoria"){
        notifacionError("Selecciona una cateogoria!");
    }else{
        // Preparemos los datos
        let datosProducto = new FormData(formEditProduct);
        datosProducto.append('editProduct', idProductoEdit);

        if(datosProducto.get('stockProducto') < 0){
            notifacionError("El stock no puede ser negativo!");
        }else if(datosProducto.get('stockMinimo') < 0){
            notifacionError("El stock minimo no puede ser negativo!");
        }else if(datosProducto.get('stockMaximo') < 0){
            notifacionError("El stock maximo no puede ser negativo!");
        }else{
            console.log('Enviando datos ...');
            editarProducto(datosProducto);
        }
    }
    
});

async function editarProducto(datosProducto){
    try {
        
        let peticion= await fetch('apis/apisProducto.php', {
            method : 'POST',
            body : datosProducto
        })

        let resjson = await peticion.json();

        if(resjson.respuesta == "MODIFICACION CORRECTA"){
            document.getElementById('closeInsertProduct').click();
            notificacionExitosa('MODIFICACIÓN CORRECTA!');
        }else{
            notifacionError(resjson.respuesta);
        }

    } catch (error) {
        console.log(error)
    }
}

$('.tablaProductos').on('click', '.btnBorrar', async (e) => {
    try{
        
        const result = await Swal.fire({
            title: '¿ESTA SEGURO DE ELIMINAR EL PRODUCTO?',
            text: "Si no lo esta puede cancelar la acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        });

        if(result.value){
            const form = new FormData();
            form.append('deleteProduct', e.target.id);
            const eliminar = await fetch('apis/apisProducto.php', {
                method : 'POST',
                body : form
            })

            const resjson = await eliminar.json();
            
            if(resjson.respuesta == "ELIMINACION CORRECTA"){
                notificacionExitosa('ELIMADO CORRECTAMENTE!');
            }else{
                notifacionError(resjson.respuesta);
            }
        }
        
    }catch(err){
        console.log(err)
    }
});


function notifacionError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        'You clicked the button!',
        'success'
    ).then(result => {
        document.getElementById('actualizarPaginaProductos').click();
    });
}