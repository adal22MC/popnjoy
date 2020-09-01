const addClienteform = document.getElementById('formAddCliente');
const formEditClient = document.getElementById('formEditCliente');

var idCliente; 

/* ============================================
  Se ejecuta cuando se agrega un cliente
  =============================================*/
addClienteform.addEventListener('submit', async (e) => {
    e.preventDefault();

    let formDatosCliente = new FormData(addClienteform);
    formDatosCliente.append('addCliente', 'ok');
    // formDatosCliente.append('porcentajeCliente', '0'); // Aun no manejamos le descuento

    try {
        let peticion = await fetch('apis/apisCliente.php', {
            method : 'POST',
            body : formDatosCliente
        });
    
        let resjson = await peticion.json();

        if(resjson.respuesta == "ALTA CORRECTA"){
            document.getElementById('close').click();
            Swal.fire(
                'Alta exitosa!',
                'You Cliked the button!',
                'success'
            ).then( r => {
                document.getElementById('actualizarPaginaCliente').click();
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: resjson.respuesta
            });
        }
    
        ///console.log(resjson);
    } catch (error) {
        console.log(error);
    }

})

/* ============================================
  Se ejecuta cuando se presiona el boton
  editar de la tabla clientes
  =============================================*/
$('.tablaClientes').on('click', '.btnEditar', async (e)=>{
    e.preventDefault();

    let formId = new FormData();
    formId.append('id', e.target.id);

    let datosCliente = await fetch('apis/apisCliente.php', {
        method : 'POST',
        body : formId
    });

    let resjson = await datosCliente.json();
    
    document.getElementById('nombreCliente').value = resjson.nombre;
    document.getElementById('tipoCliente').value = resjson.tipo;
    document.getElementById('correoCliente').value = resjson.email;
    document.getElementById('telefonoCliente').value = resjson.telefono;
    document.getElementById('direccionCliente').value = resjson.direccion;
    //document.getElementById('porcentajeCliente').value = resjson.porcentaje;
    idCliente = resjson.id;
})


/* ===================================================
  Cuando se presiona el boton para editar datos
  del cliente en el formulario
  ======================================================*/
formEditClient.addEventListener('submit', async (e) => {
    e.preventDefault();

    let formDatos = new FormData(formEditClient);
    formDatos.append('editClientId', idCliente);
    //f ormDatos.append('porcentajeCliente', '0'); // Aun no manejamos le descuento

    try {
        let peticion = await fetch('apis/apisCliente.php', {
            method : 'POST',
            body : formDatos
        });
    
        let resjson = await peticion.json();
    
        console.log(resjson.respuesta);
        if(resjson.respuesta == "MODIFICACION CORRECTA"){
            document.getElementById('closeEdit').click();
            Swal.fire(
                'Modificación exitosa!',
                'You Cliked the button!',
                'success'
            ).then( r => {
                document.getElementById('actualizarPaginaCliente').click();
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: resjson.respuesta
            });
        }
    } catch (error) {
        console.log(error)
    }

})


/* ====================================================
  Cuando se presiona el boton eliminar de la tabla
  clientes
 ====================================================== */
 $('.tablaClientes').on('click', '.btnBorrar', async (e) => {
    e.preventDefault();
    console.log(e.target.id);
    let deleteId = new FormData();
    deleteId.append('deleteId', e.target.id);

    const result = await Swal.fire({
        title: '¿ESTA SEGURO DE ELIMINAR ESTE CLIENTE?',
        text: "Si no lo esta puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    });

    if(result.value){
        try {

            let peticion = await fetch('apis/apisCliente.php', {
                method : 'POST',
                body : deleteId
            });
    
            let resjson = await peticion.json();
            //console.log(resjson);
    
            if(resjson.respuesta == "ELIMINACION CORRECTA"){
                Swal.fire(
                    'Eliminación exitosa!',
                    'You Cliked the button!',
                    'success'
                ).then( r => {
                    document.getElementById('actualizarPaginaCliente').click();
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: resjson.respuesta
                });
            }
    
        } catch (error) {
            console.log(error);
        }
    }

 });

