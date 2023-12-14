<?php
require_once('todo.php');
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    echo
    "<script>console.log('Console: " . $id . "' );</script>";
    $obj_todo = new todo();
    $result = $obj_todo->delete($id);

    if ($result) {
        echo "Formulario procesado correctamente.";
    } else {
        echo "Hubo un error al procesar el formulario.";
    }
} else {
    echo "No se enviaron todos los datos del formulario.";
}
