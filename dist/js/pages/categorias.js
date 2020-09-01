const formAddCategoria = document.getElementById('formCategorias');
const formEditCategoria = document.getElementById('formEditCategoria');


var idEdit; // Se guarda el id de la categoria que se desea editar


document.getElementById('close').addEventListener('click', () => {
    formAddCategoria.reset();
});


/* =======================================
    Evento cuando se presiona el boton
    agregar categoria
 ==========================================*/
formAddCategoria.addEventListener('submit', async (e) => {
     e.preventDefault();

    let categoria = new FormData(formAddCategoria);
    categoria.append('addCategoria', 'ok');
    try{
        let peticion = await fetch('apis/apisCategoria.php', {
            method : 'POST',
            body : categoria
        });

        let resjson = await peticion.json();

        if(resjson.respuesta == "ALTA CORRECTA"){
            Swal.fire(
                'Alta exitosa!',
                'You Cliked the button!',
                'success'
            ).then( r => {
                document.getElementById('actualizarPaginaCategoria').click();
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: resjson.respuesta
            });
        }

    }catch(error){
        console.log(error);
    }
 });

/* =======================================
    Evento cuando se presiona el boton
    editar categoria
 ==========================================*/
 $('.tablaCategorias').on('click', '.btnEditar', async (e) => {
    e.preventDefault();
    
    let formData = new FormData();
    formData.append('getSucursalId',e.target.id);

    try {
        let peticion = await fetch('apis/apisCategoria.php', {
            method : 'POST',
            body : formData
        })

        let resjson = await peticion.json();

        document.getElementById('editDesCateogoria').value = resjson.descripcion;
        idEdit = resjson.id_categoria;
    } catch (error) {
        console.log(error);
    }
 });

 /* =======================================
    Evento cuando se presiona el boton
    guardar cambios para editar una categoria
 ========================================== */
 formEditCategoria.addEventListener('submit',async (e) => {
    e.preventDefault();
    
    let formEdit = new FormData(formEditCategoria);
    formEdit.append('idEdit', idEdit);

    let peticion = await fetch('apis/apisCategoria.php', {
        method : 'POST',
        body : formEdit
    })

    let resjson = await peticion.json();

    if(resjson.respuesta  == "MODIFICACION EXITOSA"){
        document.getElementById('closeEdit').click();
        Swal.fire(
            'CATEGORIA MODIFICADA!',
            'You clicked the button!',
            'success'
        ).then( result => {
            document.getElementById('actualizarPaginaCategoria').click();
        });
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: resjson.respuesta
        });
    }

 });

 /* =======================================
    Evento cuando se presiona el boton
    eliminar de categoria
 ==========================================*/
 $('.tablaCategorias').on('click', '.btnBorrar', async (e) => {
    e.preventDefault();
    
    try{
        
        const result = await Swal.fire({
            title: '¿ESTA SEGURO DE ELIMINAR LA CATEGORIA?',
            text: "Si no lo esta puede cancelar la acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        });

        if(result.value){
            const form = new FormData();
            form.append('deleteCategoria', e.target.id);
            const eliminar = await fetch('apis/apisCategoria.php', {
                method : 'POST',
                body : form
            })

            const resjson = await eliminar.json();
            console.log(resjson);
            if(resjson.respuesta == "ELIMINACION CORRECTA"){
                Swal.fire(
                    'Eliminación exitosa!',
                    'You Cliked the button!',
                    'success'
                ).then(r =>{
                    document.getElementById('actualizarPaginaCategoria').click();
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: resjson.respuesta
                });
            }
        }
        
    }catch(err){
        console.log(err)
    }
    
 });
 