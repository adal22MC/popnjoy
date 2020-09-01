const formIngresar = document.getElementById('formIngresar');

formIngresar.addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        let ingresar = new FormData(formIngresar);

        let peticion = await fetch('apis/apisUsuario.php', {
            method : 'POST',
            body : ingresar
        });

        let resjson = await peticion.json();

        if(resjson.respuesta == "OK"){
            window.location = "admin.php";
            console.log('OK');
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: resjson.respuesta
            })
        }

        console.log(resjson);
    } catch (error) {
        console.log(error);
    }
});