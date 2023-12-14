<?php

require_once('config.php');
class ModeloBD{

    protected $id;
    protected $categoria;
    protected $detalle;
    protected $monto;
    protected $fecha;
    
    protected $_DB;

    public function __construct(){
        $this->_DB=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->_DB->connect_errno) {
            echo "fallo al conectar a la base de datos ".$this->DB->connect_errno;
            return;
        }
    }
}

?>