<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desconectar</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php
    //echo ($_SESSION['usuario_validado']);
    if (isset($_SESSION['usuario_validado'])) {
        session_destroy();
        print("<br><br><p aligin='center'>Conexion finalizada</p>\n");
        print("<p aligin='center'>[ <a href='index.php'>Conectar</a> ]</p\n>");
    } else {
        //session_destroy();
        print("<br><br\n>");
        print("<p aligin='center'>No existe una conexion activa</p>\n");
        print("<p aligin='center'>[ <a href='index.php'>Conectar</a> ]</p\n>");
    }
    ?>
</body>
</html>

<?php
?>
