<?php
require_once('todo.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {        
        $categoria = $_POST["categoriagasto"];
        $detalle = $_POST["detallegasto"];
        $monto = $_POST["montogasto"];
        $fecha = $_POST["fechagasto"];

        $fecha = date("d/m/Y", strtotime($fecha)); // Convierte la fecha al formato(dd/mm/yyyy)
        
        $obj_todo = new todo();
        $result = $obj_todo->insert_new($categoria,$detalle,$monto,$fecha);
        if ($result) {
            // echo "Formulario procesado correctamente.";
            // echo "$categoria <br>$detalle<br> $monto<br> $fecha";
        }
    } catch (\Throwable $th) {
        echo "Hubo un error al procesar el formulario.";
        echo "$categoria <br>$detalle<br> $monto<br> $fecha";
    }
} else {
    echo "Debe completar todos los datos del formulario.";
    echo "$categoria <br>$detalle<br> $monto<br> $fecha";
}

?>