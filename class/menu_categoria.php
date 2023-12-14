<?php
require_once('todo.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    if (isset($_POST['Alimentos'])) {
        $categoriamenu = $_POST['categoria'];
        $obj_todo = new todo();
        $result = $obj_todo->get_category_Alim($categoriamenu);
        echo "Consulta ejecutada para la categoría: ";
        // Devuelve los datos como JSON
        // echo json_encode($result);
    } else {
        echo "No se proporcionó la categoría.";
    }
} else {
    echo "Solicitud no válida.";
}
?>
