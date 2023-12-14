
<?php
session_start();
if (isset($_REQUEST['usuario']) && isset($_REQUEST['clave'])) {
    $usuario = $_REQUEST['usuario'];
    $clave = $_REQUEST['clave'];

    $salt = substr($usuario,0,2);
    $clave_crypt = crypt($clave, $salt);

    require_once('class/todo.php');

    $obj_usuarios = new todo();
    $usuario_validado = $obj_usuarios->validar_usuario($usuario ,$clave_crypt);

    foreach ($usuario_validado as $array_resp) {
        foreach ($array_resp as $value) {
            $nfilas=$value;
        }
    }

    if ($nfilas > 0) {
        $usuario_validado = $usuario;
        $_SESSION['usuario_validado']=$usuario_validado;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="js/script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>

    <script>
        // funciones AJAX
        // Funcion para controlar envio del formulario del modal
        function SubmitForm() {
            const formData = new FormData(document.getElementById('form-modal')); //se crea para poder manejar
            console.log("edit es: "+edit);
            if (edit) {
                fetch('class/edit.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert("Gasto ¡EDITADO! correctamente " + data); // Muestra el mensaje de respuesta del servidor
                    var myModal = new bootstrap.Modal(document.getElementById("gastoModal"));
                    myModal.hide(); // Oculta el modal
                    document.getElementById("form-modal").reset(); //vacia el formulario
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                
                fetch('class/procesaformulario.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert("Gasto GUARDADO correctamente " + data); // Muestra el mensaje de respuesta del servidor
                    var myModal = new bootstrap.Modal(document.getElementById("gastoModal"));
                    myModal.hide(); // Oculta el modal
                    document.getElementById("form-modal").reset(); //vacia el formulario
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("ERROR al crear la Tarea\n" + error);
                });
            }
        }

        // Funcion para controlar seleccion de categoria barra lateral
        function selectCat() {
            const formData = new FormData(document.getElementById('form-categoria')); //se crea para poder manejar
            fetch('class/menu_categoria.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("Categoria Alimentos " + data); // Muestra el mensaje de respuesta del servidor
                // var myModal = new bootstrap.Modal(document.getElementById("gastoModal"));
                // myModal.hide(); // Oculta el modal
                // document.getElementById("form-modal").reset(); //vacia el formulario
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert("ERROR al cargar la categoria ALIMENTOS\n" + error);
            });
        }

        function Delete(id) {

            fetch('class/delete.php?id=' + id, {
                    method: 'GET',
                })
                .then(response => response.text())
                .then(data => {
                    alert("Gasto ¡ELIMINADO! correctamente "); // Muestra el mensaje de respuesta del servidor
                    // hideTaskModal();
                    location.reload()
                    // Oculta el modal después de enviar el formulario
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function pushmodal() {
            
        }
        </script>
</head>

<body>
    
    <style>
        body {
            font-family: 'Trebuchet MS';
            background-color: #dadada;
        }
        .offcanvas.show {
            position: fixed;
            overflow-y: auto;
            max-height: 100%;
        }

        /* estilo para formulario LOGIN */
        .div-login{
            height: 100%;
            width: 100%;
            display:flex;
            justify-content:center;
            align-items: center;
            /* border:1px solid ; */
        }
        .div-form-login{
            box-shadow: 0px 0px 60px rgb(247, 215, 6); /*sombra */
            background-color:white;
            margin:80px;
            padding:10px;
            padding-top:30px;
            padding-left: 50px;
            padding-right:50px;
            width: 500px;
            border:2px solid rgb(247, 215, 6);
            border-radius:10px;
            /* height: 600px; */
        }
        .div-titulo-login{
            display:flex;
            justify-content:center;
            margin-bottom:5px;
            font-size:30px;
            font-weight:bold;
        }
        .container-img-form{
            display:flex;
            justify-content:center;
            margin-bottom:10px;
        }
        #div-img-form {
            width: 200px; /* Ajusta el ancho*/
            height: 200px; 
            overflow: hidden; 
            border:1px solid white;
            border-radius: 50%;
        }
        
        .img-form {
            width: 100%;
            height: 100%; /* Ajusta al 100% para llenar el contenedor cuadrado */
            object-fit: cover; /* Ajusta la imagen para cubrir completamente el contenedor */
            display: block;
            border: 2px solid rgb(213, 212, 212); 
            border-radius: 50%;
        }
        #label-login{
            font-size:20px;
            padding-left:10px;
        }
        .div-btn-login{
            display: flex;
            justify-content:center;
            margin-bottom:40px;
        }
        #btn-login{
            border:2px solid #0d6efd;
            padding-right:20px !important;
            padding-left: 20px !important;
        }
        #btn-login:hover{
            border:2px solid #0b5ed7;
        }
        #btn-login:active{
            border:2px solid white !important;
            border-radius: 8px;
        }

        /* color al navbar */
        nav,
        .offcanvas {
            background-color: #1e293b;
        }

        #btn-menu-cat{
            padding-right: 180px;
            padding-left: 10px;
            color:  rgb(248, 248, 248);
            font-size: 24px;
            font-weight: bold;
        }
        #btn-menu-cat-l{
            padding-right: 120px;
            padding-left: 10px;
            color:  rgb(248, 248, 248);
            font-size: 24px;
            font-weight: bold;
        }
        #btn-menu-cat:hover,#btn-menu-cat-l:hover{
            font-size: 25px;
            /* font-weight: bold; */
            color:  rgb(6, 40, 75);
        }

        #div-btn-navbar{
            width: 100px;
            display: flex;
            justify-content:flex-start;
        }

        .btn-gasto-bar{
            margin-left: 15px;
        }

        .nav-item a.nav-link {
            color: white; /* Cambia #ff0000 al color que desees */
        }

        .categoria-div{
            padding-left: 15px;
            display: flex;
            align-items: center;
        }

        /* BOTON MENU(toggler)*/

        /* Ocultar Borde de boton menu*/
        /* Mueve el botón del toggler al lado izquierdo */
        /* .navbar-toggler {
            order: -1;
        } */

        .navbar-toggler {
            margin-left: 10px;
            padding: 4px;
            border: 2px solid #1e293b;
        }

        /* deshabilita el estilo por defecto */
        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        .navbar-toggler:hover {
            border: 2px solid #aaaaaa;
        }

        .navbar-toggler:active {
            border: 1px solid #0dcaf0;
        }

        /* boton "X" cerrar menu*/
        .btn-close:focus {
            outline: none;
            box-shadow: none;
        }

        .btn-close:hover {
            border: 2px solid #aaaaaa;
        }

        .btn-close:active {
            border: 1px solid #0dcaf0;
        }

        .btn-close {
            padding: 4px;
            border: 2px solid #1e293b;
        }

        /* color de ocpion de menu seleccionada */
        @media (min-width: 10px) {}

        .navbar-nav>li:hover {
            background-color: #0dcaf0;
        }

        .navbar-nav>li>a {
            color: #ffffff;
        }

        .navbar-nav>li>a:hover {
            color: #1e293b;
        }

        .navbar-brand {
            font-size: 28px;
            font-weight: bold;
        }

        .btn {
            padding: 4px;
            font-size: 20px;
            font-weight: bold;
        }

        .card-body {
            padding-left: 10px;
            padding-right: 10px;
            display: flex;
            justify-content: space-between;
        }

        #img-card-all{
            padding: 10px;
            border-right:2px solid rgb(248, 248, 248);
        }

        .cont-card{
            margin-top: 10px;
        }

        .divs-card{
            display: inline-block;
            justify-content: space-around;
        }
        
        .div-btn-card{
            
            display: flex;
            justify-content:space-around;
            flex-direction: column;
        }
        .btns-card{
            border: solid 2px #fff;
            background-color: #fff;
        }
        .btns-card:hover{
            border: solid 2px;
            border-radius:5px;
            background-color: #fff;
        }
        button[name="btnedit"]:hover{
            color: rgb(242, 205, 22);
        }
        button[name="btndlt"]:hover{
            
            color: rgb(214, 20, 20);
        }
        button[name="btnedit"]:active{
            color: white;
            background-color: rgb(242, 205, 22);
        }
        button[name="btndlt"]:active{
            color:white ;
            background-color: rgb(214, 20, 20);
        }
        .card-element{
            display: flex;
            justify-content: flex-start;
            color:red;
            
        }
        #card-regis{
            max-width: 410px;;
        }
        .divs-cards-datos{
            margin-top: 0px;
            padding-left: 10px;
            font-size: 18px;;
        }
        .div-title-cards{
            margin-top:10px;
            text-transform: uppercase;
            display:flex;
            justify-content: center;
        }
        .card-custom {
            max-width: calc(540px + 70px);
            /* height: calc(100px + 50px);  */
        }
        .mesdivi{
            max-width: 65px;
            margin-left: auto;
            margin-bottom: -40px;
            color: dimgrey;
        }

        .div-btn-modal{
            di
        }

        .modal-footer {
            display: flex !important;
            justify-content: space-between !important;
        }

        #id-modal{
            visibility: hidden;
            /* color: black; */
            border:none;
            padding:0px;
        }
        /* boton limpiar modal */
        #btn-clean-form{
            border:2px solid rgb(214, 20, 20);
            background-color: #fff;
            color:rgb(214, 20, 20);
        }
        #btn-clean-form:hover{
            box-shadow: 0px 0px 8px rgb(214, 20, 20); /* Agrega una sombra en el hover */
        }
        #btn-clean-form:active{
            border:0px solid rgb(214, 20, 20);
            background-color: rgb(214, 20, 20);
            color:white;
            box-shadow: 0px 0px 0px rgb(214, 20, 20); /*sombra */
        }

        /* boton guardar o editar modal*/
        #btn-submit-form{
            border:1px solid rgb(0,  176, 44);
            background-color: rgb(0, 176, 44);
        }
        #btn-submit-form:hover{
            border:1px solid rgb(1, 147, 37);
            background-color: rgb(1, 147, 37);
        }
        #btn-submit-form:active{
            border:0px solid rgb(1, 147, 37);
            background-color: rgb(1, 133, 34);
        }

        #card-custom{
            box-shadow: 0px 0px 60px rgb(247, 215, 6) !important; /*sombra */
        }
    </style>
        <?php
    if (isset($_SESSION['usuario_validado'])) {
        //echo ($_SESSION['usuario_validado']);
    ?>

        <!-- Barra de menu lateral -->
    <!-- MENU START  -->
    <nav class="navbar navbar-dark">
        <!-- NAV CONTAINER START -->
        <div class="navbar navbar-dark container-fluid d-flex justify-content-center align-items-center">

            <!-- NAV BUTTON  -->
            <div class="col-2 text-left">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"
                    data-bs-backdrop="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- titulo -->
            <div class="col-7 text-center">
                <a id="titulo" href="" class="navbar-brand">TUS GASTOS</a>
            </div>
            
            <div class="col-8 text-right" id = "div-btn-navbar">

                
                <!-- boton mas -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mas
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-start" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                    </ul>
                </div>

                <!-- boton agrgar gasto-->
                <div class="btn-gasto-bar">
                    <button type="button" class="btn btn-outline-info" name="btngasto" data-bs-toggle="modal" data-bs-target="#gastoModal">+Gasto</button>
                </div>

            </div>

            <!-- Modal para agregar gasto -->
            <div class="modal fade" id="gastoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- titulo modal -->
                            <h5 class="modal-title" id="modalTitle">Agregar</h5>
                            <!-- boton cerrar modal X -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick= "ResetModal()"></button>
                        </div>
                        <div class="modal-body">
                            <!-- FORMULARIO -->
                            <!-- Contenido del modal, formulario para agregar gasto -->
                            <form id="form-modal" method="POST" onsubmit="SubmitForm(); return false;">
                                <div class="mb-3">
                                    <!-- <input type="text" id="id-modal" name="categoriaid"> -->
                                    <!-- <input type="text" id="id-modal"> -->
                                    <!-- categorias -->
                                    <div class="mb-3">
                                        <label for="categoriagastos" class="form-label">Selecciona Categoría de gasto</label>
                                        <select class="form-select" id="categoriaselct-modal" name="categoriagasto" required>
                                            <option value=""> selecciona gasto</option>
                                            <option value="Alimentos">Alimentos</option>
                                            <option value="Comida">Comida</option>
                                            <option value="Entretenimiento">Entretenimiento</option>
                                            <option value="Pagos y Cuentas">Pagos y Cuentas</option>
                                            <option value="Ropa y Calzado">Ropa y Calzado</option>
                                            <option value="Salud">Salud</option>
                                            <option value="Transporte">Transporte</option>
                                            <option value="Otros">Otros</option>
                                        </select>
                                    </div>
                                    <!-- detalles gastos -->
                                    <label for="detalle" class="form-label">Detalles</label>
                                    <input type="text" class="form-control" id="detalles-modal" name="detallegasto" placeholder="detalles de gasto (45 caracteres max)" maxlength="45" required>
                                    <!-- monto gasto -->
                                    <label for="monto" class="form-label">Monto de gasto $</label>
                                    <input type="number" class="form-control" id="monto-modal" name="montogasto" placeholder="Ingrese el monto" step="0.01" required>
                                    <!-- fecha gasto -->
                                    <div class="mb-3">
                                        <label for="fecha" class="form-label">Fecha del gasto</label>
                                        <input type="date" class="form-control" id="fecha-modal" name="fechagasto" required>
                                    </div>
                                    <!-- ID de registro -->
                                    <input type="text" id="id-modal" name="idgasto">
                                    <!-- <input type="text" id="id-modal"> -->
                                </div>
                                <div class="modal-footer">
                                    <!-- boton guardar gasto -->
                                    <button type="submit" id="btn-submit-form" class="btn btn-primary">Guardar</button>
                                    <!-- boton limpiar formulario -->
                                    <button type="submit" id="btn-clean-form" class="btn " onclick= "ResetModal()">Limpiar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- MENU LATERAL -->
            <section class="offcanvas offcanvas-start show" data-bs-scroll="true" id="menuLateral" tabindex="-1" data-bs-backdrop="false">
                <!-- TITULO -->
                <div class="offcanvas-header" data-bs-backdrop="dark">
                    <h5 class="offcanvas-title text-info">CATEGORIAS</h5>
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="offcanvas"></button>
                </div>
                <!-- OPCIONES MENU LATERAL-->
                <div class="offcanvas-body d-flex flex-column justify-content-between px-0">
                    
                    <form id="form-categoria" method="POST"  onsubmit="SelectCat(); return false;">
                        <ul class="navbar-nav fs-5 justify-content-evenly">
                            
                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-house-door-fill"></i><input type="submit" id="btn-menu-cat" class="nav-link" name="Home" value="HOME">
                                </div>
                            </li>
                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-cart3"></i><input type="submit" id="btn-menu-cat-l" class="nav-link" name="Alimentos" value="ALIMENTOS">
                                </div>
                            </li>
                                    <!-- <input type="submit" id="btn-menu" class="nav-link" name="Otros" value="OTROS"> -->

                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-cup-hot"></i><input type="submit" id="btn-menu-cat" class="nav-link" name="Comida" value="COMIDA">
                                </div>
                            </li>
                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-puzzle"></i><input type="submit" id="btn-menu-cat-l" class="nav-link" name="Entretenimiento" value="ENTRETENIMIENTO">
                                </div>
                            </li>
                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-cash-coin"></i><input type="submit" id="btn-menu-cat-l" class="nav-link" name="PagosyCuentas" value="PAGOS Y CUENTAS">
                                </div>
                            </li>
                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-tags"></i><input type="submit" id="btn-menu-cat-l" class="nav-link" name="RopayCalzado" value="ROPA Y CALZADO">
                                </div>
                            </li>
                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-heart-pulse"></i><input type="submit" id="btn-menu-cat" class="nav-link" name="Salud" value="SALUD">
                                </div>
                            </li>
                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-train-front"></i><input type="submit" id="btn-menu-cat" class="nav-link" name="Transporte" value="TRANSPORTE">
                                </div>
                            </li>
                            <li class="nav-item p-3 py-md-1" id="btn-menu-cat">
                                <div class="categoria-div">
                                    <i class="bi bi-plus-circle"></i><input type="submit" id="btn-menu-cat" class="nav-link" name="Otros" value="OTROS">
                                </div>
                            </li>
                            <!-- <li class="nav-item p-3 py-md-1"><a method="POST" onclick="EnviarDato(); return false;" class="nav-link" name="cat">{{m.name}}</a></li> -->
                        </ul>
                        
                    </form>
                    <!-- enlaces redes sociales ICONOS-->
                    <div class=" align-self-center py-3">
                        <a href=""><i class="bi bi-twitter px-2 text-info fs-2"></i></a>
                        <a href=""><i class="bi bi-facebook px-2 text-info fs-2"></i></a>
                        <a href=""><i class="bi bi-github px-2 text-info fs-2"></i></a>
                        <a href=""><i class="bi bi-whatsapp px-2 text-info fs-2"></i></a>
                    </div>
                </div>
            </section>
            <!-- OFFCANVAS MAIN CONTAINER END  -->
        </div>
    </nav>
    
    <!-- CARD -->
    <!-- CARD -->
    <div class="cont-card container-fluid">
            <?php
            require_once('class/todo.php');
            $todo = new todo();
            $categoriaselected = true;
            switch (true) {
                case isset($_POST['Alimentos']):
                    $categoriamenu = $_POST['Alimentos'];
                    $categoriaselected = false;
                    $categoriaimg='https://cdn-icons-png.flaticon.com/512/3082/3082011.png';
                    break;
                case isset($_POST['Comida']):
                    $categoriamenu = $_POST['Comida'];
                    $categoriaselected = false;
                    $categoriaimg='https://cdn-icons-png.flaticon.com/512/6269/6269329.png';
                    break;
                case isset($_POST['Entretenimiento']):
                    $categoriamenu = $_POST['Entretenimiento'];
                    $categoriaselected = false;
                    $categoriaimg='https://cdn-icons-png.flaticon.com/512/993/993686.png';
                    break;
                case isset($_POST['PagosyCuentas']):
                    $categoriamenu = 'Pagos y Cuentas';
                    $categoriaselected = false;
                    $categoriaimg='https://cdn-icons-png.flaticon.com/512/2331/2331941.png';
                    break;
                case isset($_POST['RopayCalzado']):
                    $categoriamenu = 'Ropa y Calzado';
                    $categoriaselected = false;
                    $categoriaimg='https://cdn-icons-png.flaticon.com/512/1655/1655798.png';
                    break;
                case isset($_POST['Salud']):
                    $categoriamenu = $_POST['Salud'];
                    $categoriaselected = false;
                    $categoriaimg='https://cdn-icons-png.flaticon.com/512/1142/1142172.png';
                    break;
                case isset($_POST['Transporte']):
                    $categoriamenu = $_POST['Transporte'];
                    $categoriaselected = false;
                    $categoriaimg='https://cdn-icons-png.flaticon.com/512/3061/3061557.png';
                    break;
                case isset($_POST['Otros']):
                    $categoriamenu = $_POST['Otros'];
                    $categoriaselected = false;
                    $categoriaimg='https://cdn-icons-png.flaticon.com/512/4677/4677564.png';
                    break;
                default :
                    $categoriaselected = true;
                    break;
                // Agrega más casos según sea necesario
            }


            if ($categoriaselected == false) {
                $list = $todo->get_category_Alim($categoriamenu);
                foreach ($list as $valor) {

                    $id = $valor['id'];
                    $categoria = $valor['categoria'];
                    $monto = $valor['monto_red'];
                    $detalle = $valor['detalle'];
                    $fecha = $valor['fecha'];
                    ?>

                    <div class="col-md-6 mb-3 offset-md-5">
                        <div class="card card-custom" id="card-custom">
                            <div class="row g-0" id="card-all">
                                <!-- Contenido de la tarjeta -->
                                <div class="card-element">
                                    <!-- Imagen -->
                                    <div id="img-card" class="col-md-3 d-flex align-items-center">
                                        <img id="img-card-all" src="<?php echo $categoriaimg;?>"
                                            class="img-fluid rounded-start" alt="img moneda">
                                    </div>
                                    <!-- datos de Registro -->
                                    <div class="col-md-8" id="card-regis">
                                        <!-- titulo -->
                                        <div class="div-title-cards"><h5 class='card-title'><strong><?php echo $categoria; ?></strong></h5></div>
                                        <!-- datos -->
                                        <div class="divs-cards-datos">
                                            <p class='card-text'>
                                                <!-- <strong>Categoría:</strong> <?php echo $categoria; ?><br> -->
                                                <strong>Descripción:</strong> <?php echo $detalle; ?><br>
                                                <strong>Monto:</strong> <?php echo $monto; ?><br>
                                                <strong>Fecha:</strong> <?php echo $fecha; ?><br>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Botón con el icono de lápiz y basurero -->
                                    <div class="div-btn-card">
                                        <!-- <button type="submit" class="btns-card" name="btnedit" data-bs-toggle="modal" data-bs-target="#gastoModal" data-id="<?php echo $id; ?>"
                                            data-categoria="<?php echo $categoria; ?>" data-detalle="<?php echo $detalle; ?>" data-monto="<?php echo $monto; ?>" data-fecha="<?php echo $fecha; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button> -->

                                        <!-- boton editar -->
                                        <button type="submit" class="btns-card btn-edit" name="btnedit" data-bs-toggle="modal" data-bs-target="#gastoModal"
                                            data-id="<?php echo $valor['id']; ?>" data-categoria="<?php echo $valor['categoria']; ?>"
                                            data-detalle="<?php echo $valor['detalle']; ?>" data-monto="<?php echo $valor['monto_red']; ?>"
                                            data-fecha="<?php echo $valor['fecha']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
    
                                        <!-- boton borrar -->
                                        <button type="submit" class="btns-card" name="btndlt" onclick="Delete(<?php echo $id; ?>)" data-id="<?php echo $id; ?>"
                                            data-categoria="<?php echo $categoria; ?>" data-detalle="<?php echo $detalle; ?>" data-monto="<?php echo $monto; ?>" data-fecha="<?php echo $fecha; ?>">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }else {
                
                $list = $todo->get_ranking();
                // $list = $todo->get_todo();
                $mes_actual = null;
                foreach ($list as $valor) {
                    // $id = $valor['id'];
                    // $categoria = $valor['categoria'];
                    // $monto = $valor['monto'];
                    // $detalle = $valor['detalle'];
                    // $fecha = $valor['fecha'];
    
                    $categoria = $valor['categoria'];
                    $monto = $valor['total_montos'];
                    // $mes = $valor['mes'];
                    $mes = '';
                    switch ($valor['mes']) {
                        
                        case 1:$mes = "ENE";break;
                        case 2:$mes = 'FEB';break;
                        case 3:$mes = "MAR";break;
                        case 4:$mes = 'ABR';break;
                        case 5:$mes = 'MAY';break;
                        case 6:$mes = 'JUN';break;
                        case 7:$mes = 'JUL';break;
                        case 8:$mes = 'AGO';break;
                        case 9:$mes = 'SEP';break;
                        case 10:$mes = 'OCT';break;
                        case 11:$mes = 'NOV';break;
                        case 12:$mes = 'DIC';break;
                    }
                    // Comprueba si el mes actual es diferente al mes del elemento actual
                    if ($mes_actual !== $mes) {
                        // Imprime la línea divisoria
                        // echo '<hr>';
                        // echo "<h2 id='mesdivi'>{$mes}</h2>";
                        ?>
                        <hr>
                        <h2 class="mesdivi"><?php echo $mes; ?></h2>
                        <?php
                        // Actualiza el mes actual
                        $mes_actual = $mes;
                    }
                    ?>
                    <div class="col-md-6 mb-3 offset-md-5">
                        <div class="card card-custom">
                            <div class="row g-0">
                                <div id="img-card" class="col-md-3 d-flex align-items-center">
                                    <!-- Imagen -->
                                    <img id="img-card-home" src="https://img.freepik.com/vector-premium/billetes-dolar-monedas-oro_660013-1184.jpg"
                                        class="img-fluid rounded-start" alt="img moneda">
                                </div>
                                <div class="col-md-8">
                                    <!-- Contenido de la tarjeta -->
                                    <div class="card-body">
                                        <!-- <h5 class='card-title'><strong><?php echo $categoria; ?></strong></h5>
                                        <p class='card-text'>
                                            <strong>Categoría:</strong> <?php echo $categoria; ?><br>
                                            <strong>Descripción:</strong> <?php echo $detalle; ?><br>
                                            <strong>Monto:</strong> <?php echo $monto; ?><br>
                                            <strong>Fecha:</strong> <?php echo $fecha; ?><br>
                                        </p> -->
    
                                        <div class="divs-card">
                                            <h4 class='card-text'>
                                                <p></p>
                                                <div>
                                                    <strong>Categoria: </strong>
                                                </div>
                                                <br>
                                                <strong><?php echo $categoria; ?></strong>
                                            </h4>
                                        </div>
                                        <div class="divs-card">
                                            <h4 class='card-text'>
                                                <p></p>
                                                <div>
                                                    <strong>Monto: </strong>
                                                </div>
                                                <br>
                                                <strong class="montophp">$<?php echo $monto; ?></strong>
                                            </h4>
                                        </div>
                                        <div class="divs-card">
                                            <h4 class='card-text'>
                                                <p></p>
                                                <div>
                                                    <strong>Mes: </strong>
                                                </div>
                                                <br>
                                                <strong class="montophp"><?php echo "$mes"; ?></strong>
                                            </h4>
                                        </div>
                                        <!-- <a href="#" class="btn btn-primary">Button</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <script src="./js/script.js"></script>
        <!-- <link rel="stylesheet" href="css/estilo.css"> -->

    <!-- <hr> -->
    <!-- <p>[ <a href="logout.php">Desconectar</a> ]</p> -->

    <?php
    //intento de entrada fallido 
    }elseif (isset($usuario)) {
        print("<br><br\n>");
        print("<p class='center'>Acceso no autorizado </p\n>");
        print("<p class='center'>[ <a href='index.php'>Conectar</a> ]</p\n>");
    }else { //sesion no iniciada

        ?>
        <div class="div-login">
            <div class="div-form-login">
                <form CLASS='entrada' NAME='login' ACTION='index.php' METHOD='POST'>
                    <!-- img -->
                    <div class="container-img-form">
                        <div id="div-img-form" class="form-control">
                            <img class="img-form" src="https://img.freepik.com/vector-premium/grupo-personas-concepto-amistad-estilo-dibujos-animados-coloridos_3482-8504.jpg?w=360" alt="">
                        </div>
                    </div>
                    <div class="div-titulo-login">
                        <label class="form-label"  for="form2Example1">Inicio de Sesión</label>
                    </div>
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" id="label-login" for="form2Example1">Usuario</label>
                        <input type="text" id="form2Example1" class="form-control" name="usuario" placeholder="Ingresa nombre de usuario" required/>
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-4" >
                        <label class="form-label" id="label-login" for="form2Example2">Contraseña</label>
                        <input type="password" id="form2Example2" class="form-control" name="clave" placeholder="Ingresa contraseña" required/>
                    </div>
                    <!-- 2 column grid layout for inline styling -->
                    <!-- <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                <label class="form-check-label" for="form2Example31"> Remember me </label>
                            </div>
                        </div>
                        <div class="col">
                            
                            <a href="#!">Forgot password?</a>
                        </div>
                    </div> -->
                    <!-- Submit button -->
                    <div class="div-btn-login">
                        <button type="submit" class="btn btn-primary" id="btn-login">Iniciar Sesión</button>
                    </div>
                    <!-- Register buttons -->
                    <div class="text-center">
                        <P CLASS='parrafocentrado'>NOTA: si no dispone de identificacion o tiene problemas para entrar. <BR>
                        pongase en contacto con el <A HREF='MAILTO:webmaster@localhost'>administrador</A> del sitio</P>
                    </div>
                </form>
            </div>
        </div>
        <?php

    }
    ?>
<script src="./js/script.js"></script>
</body>
</html>
