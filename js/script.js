// let Edicion = false;
var editando = 0;

// Verificar si se hizo clic en el botón con nombre 'btngasto'
document.querySelector('[name="btngasto"]').addEventListener('click',function () {
    var Titelmodal = document.getElementById('modalTitle');
    Titelmodal.innerText = "Agregar Nuevo Gasto";
    editando=0;
    Edicion = fun_editar(editando);;
    const submitButton = document.getElementById("btn-submit-form");
    submitButton.textContent = "Guardar Gasto";
});


document.addEventListener('DOMContentLoaded', function () {
    // Seleccionar todos los botones de edición por clase
    var editButtons = document.querySelectorAll('.btn-edit');
    // Asignar evento de clic a cada botón de edición
    editButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // pushmodal();
            var modalTitle = document.getElementById('modalTitle');

            // Extraer datos del botón/card
            var id = this.getAttribute('data-id');
            var categoria = this.getAttribute('data-categoria');
            var detalle = this.getAttribute('data-detalle');
            var monto = this.getAttribute('data-monto');
            var fecha = this.getAttribute('data-fecha');
            
            var fechaFormateada = convertirFecha(fecha);
            
            // Seleccionar elementos del formulario del modal
            var idInput = document.getElementById('id-modal')
            var categoriaInput = document.getElementById('categoriaselct-modal');
            var detalleInput = document.getElementById('detalles-modal');
            var montoInput = document.getElementById('monto-modal');
            var fechaInput = document.getElementById('fecha-modal');
            
            // Ingresa los datos de la card en el formulario para editar
            idInput.value = id;
            categoriaInput.value = categoria;
            detalleInput.value = detalle;
            montoInput.value = monto;
            fechaInput.value = fechaFormateada;
            // pushmodal();
            console.log(id+"||"+categoria+"||"+detalle+"||"+monto+"||"+fecha);
            // location.reload();
            // cambia el titulo del modal para edicion
            //indica que se esta editando
            modalTitle.innerText = "Editar Gasto";
            editando=1;
            Edicion = fun_editar();
            const submitButton = document.getElementById("btn-submit-form");
            submitButton.textContent ="Editar Gasto";
            
        });
    });
    

    // Otras funciones o código relacionado con el modal
});

function fun_editar() {
    if (editando == 0) {
        edit = false;
        console.log(edit);
        return edit;
    } else {
        edit = true;
        console.log(edit);
        return edit;
    }
}

function convertirFecha(fecha) {
    // Dividir la cadena de fecha en día, mes y año
    var partes = fecha.split('/');
    
    // Crear una nueva cadena en formato "yyyy-mm-dd"
    var fechaFormateada = partes[2] + '-' + partes[1] + '-' + partes[0];

    return fechaFormateada;
}

// const modal = document.getElementById("form-modal");

function ResetModal() {
    document.getElementById("form-modal").reset();
}