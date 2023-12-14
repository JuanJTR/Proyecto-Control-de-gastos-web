<?php
require_once('modelo.php');
class todo extends ModeloBD
{
    public function __construct()
    {
        parent::__construct();
    }

    // query para LOGIN  de usuario
    public function validar_usuario($usr,$pwd) {
        $instruccion = "CALL sp_validar_usuarios('".$usr."','".$pwd."')"; //procedimiento almacenado

        $consulta=$this->_DB->query($instruccion);
        $res = $consulta->fetch_all(MYSQLI_ASSOC);
        if (!$res) {
            echo 'ERROR QUERY';
            return 'ERROR';
        } else {
            return $res;
            $res->close();
            $this->_DB->close();
        }
    }

    // query Selecciona CATEGORIA || no uso
    public function get_category($categoria){
        $query = "SELECT * FROM gastos WHERE categoria='$categoria'";
        $consulta = $this->_DB->query($query);
        $res = $consulta->fetch_all(MYSQLI_ASSOC);
        if (!$res) {
            echo 'ERROR QUERY';
            return 'ERROR';
        } else {
            return $res;
            $res->close();
            $this->_DB->close();
        }
    }

    // query para home o inicio
    public function get_ranking()
    {
        // $query = "SELECT categoria, 
        // MONTH(STR_TO_DATE(fecha, '%d/%m/%Y')) AS mes, 
        // ROUND(SUM(monto), 2) AS total_montos
        // FROM gastos
        // GROUP BY categoria, mes
        // ORDER BY mes DESC, total_montos DESC";
        $query = "CALL sp_sumagastos_ordenado()"; //procedimiento almacenado
        $consulta = $this->_DB->query($query);
        $res = $consulta->fetch_all(MYSQLI_ASSOC);
        if (!$res) {
            echo 'ERROR QUERY';
            return 'ERROR';
        } else {
            return $res;
            $res->close();
            $this->_DB->close();
        }
    }

    // query Selecciona CATEGORIA ordenada || en uso
    public function get_category_Alim($categoriamenu){
        // $query = " 
        // SELECT * , ROUND(monto, 2) AS monto_red
        // FROM gastos 
        // WHERE categoria='$categoriamenu'
        // ORDER BY STR_TO_DATE(fecha, '%d/%m/%Y') DESC";
        $query = "CALL sp_select_categoria_ordenado('$categoriamenu')"; //procedimiento almacenado
        $consulta = $this->_DB->query($query);
        $res = $consulta->fetch_all(MYSQLI_ASSOC);
        ?>
        <script>
        alert("categoria" + <?php echo json_encode($categoria."--".$query."--".$res); ?>);
        </script>
        <?php
        if (!$res) {
            echo 'ERROR QUERY';
            return 'ERROR';
        } else {
            return $res;
            $res->close();
            $this->_DB->close();
        }
    }

    // query para EDITAR registro
    public function edit($id,$categoria,$detalle,$monto,$fecha)
    {
        // $query = "UPDATE gastos
        //         SET categoria = '$categoria', detalle = '$detalle', monto = '$monto', fecha = '$fecha'
        //         WHERE id = $id";
        $query = "CALL sp_update_gasto($id, '$categoria', '$detalle', $monto, '$fecha')";//procedimiento almacenado
        $consulta = $this->_DB->query($query);
        // Ejecuta la consulta
        if ($consulta) {
            return true;
        } else {
            echo "Error: " . $query . "<br>" . $this->_DB->error;
            return false; // Indica que hubo un error al ejecutar la consulta
        }
    }

    // query para INSERTAR registro
    public function insert_new($categoria,$detalle,$monto,$fecha)
    {
        //echo "Entro a insert_new()";
        // $query = "INSERT INTO gastos (categoria, detalle, monto, fecha) values ('$categoria', '$detalle', '$monto', '$fecha')";
        $query = "CALL sp_insert_gasto('$categoria', '$detalle', $monto, '$fecha')"; //procedimiento almacenado
        $consulta = $this->_DB->query($query);
        // Ejecuta la consulta
        if ($consulta) {
            return true;
        } else {
            echo "Error: " . $query . "<br>" . $this->_DB->error;
            return false; // Indica que hubo un error al ejecutar la consulta
        }
    }

    // query para BORRAR registro
    public function delete($id)
    {
        //echo "Entro a insert_new()";
        // $query = " DELETE FROM gastos WHERE id = $id;";
        $query = "CALL sp_delete_gasto($id)"; //procedimiento almacenado
        $consulta = $this->_DB->query($query);
        // Ejecuta la consulta
        if ($consulta) {
            return true;
        } else {
            echo "Error: " . $query . "<br>" . $this->_DB->error;
            return false; // Indica que hubo un error al ejecutar la consulta
        }
    }
}
