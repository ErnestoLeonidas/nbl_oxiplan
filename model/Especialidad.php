<?php
require_once '../db/conexion.php';

class Especialidad{
    const TABLA="Especialidades";

    private $id;
    private $codigo;
    private $nombre;
    private $estado;

    public function __construct(){
    }

    public function setId($id){ $this->id=$id; }
    public function getId(){ return $this->id; }

    public function setCodigo($codigo){ $this->codigo=$codigo; }
    public function getCodigo(){ return $this->codigo; }
    
    public function setNombre($nombre){ $this->nombre=$nombre; }
    public function getNombre(){ return $this->nombre; }

    public function setEstado($estado){ $this->estado=$estado; }
    public function getEstado(){ return $this->estado; }

    public function buscarTodos(){
        $conexion = new Conexion();
        $conexion->query("SET NAMES 'UTF8'");
		$consulta = $conexion->prepare(
            "SELECT 
                id as id,
                codigo as codigo,
                nombre as nombre 
            FROM Especialidades 
            ORDER BY nombre");
		$consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        
        /*
        *
        * PARA SELECTPICKER: echo json_encode($resultado, true);
        *
        * PARA DATATABLE: echo json_encode($data, true);
        *
        */


        $data = array('data' => $resultado );
        echo json_encode($resultado, true);
    }



}
?>