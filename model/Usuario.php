<?php
require_once '../db/conexion.php';

class Usuario{
    const TABLA="Usuarios";

    private $id;
    private $nombre;
    private $apellido;
    private $user;
    private $password;
    private $estado;
    private $idPermisos;

    public function __construct(){
    }

    public function setId($id){ $this->id=$id; }
    public function getId(){ return $this->id; }
    
    public function setNombre($nombre){ $this->nombre=$nombre; }
    public function getNombre(){ return $this->nombre; }

    public function setApellido($apellido){ $this->apellido=$apellido; }
    public function getApellido(){ return $this->apellido; }

    public function setUser($user){ $this->user=$user; }
    public function getUser(){ return $this->user; }

    public function setPassword($password){ $this->password=$password; }
    public function getPassword(){ return $this->password; }

    public function setEstado($estado){ $this->estado=$estado; }
    public function getEstado(){ return $this->estado; }

    public function setIdPermisos($idPermisos){ $this->idPermisos=$idPermisos; }
    public function getIdPermisos(){ return $this->idPermisos; }

    public function buscarTodos(){
        $conexion = new Conexion();
        $conexion->query("SET NAMES 'UTF8'");
		$consulta = $conexion->prepare(
            "SELECT 
                nombre,
                apellido,
                estado 
            FROM Usuarios 
            ORDER BY nombre");
		$consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        
        $data = array('data' => $resultado );
        echo json_encode($data, true);
    }


    public function buscarCorreos(){
        $conexion = new Conexion();
        $conexion->query("SET NAMES 'UTF8'");
		$consulta = $conexion->prepare(
            'SELECT ID_USUARIO, USUARIO, PASS FROM ' . self::TABLA . ' WHERE ID_USUARIO > 1 ORDER BY USUARIO ASC');
		$consulta->execute();
		$registros = $consulta->fetchAll();
		return $registros;
    }

    public function validarLogin(){
        $conexion = new Conexion();
        $conexion->query("SET NAMES 'UTF8'");
        $consulta = $conexion->prepare(
            'SELECT 
                id,
                nombre,
                apellido
            FROM Usuarios 
            WHERE 
                user = :user 
            AND password = :password
            AND estado = 1
                ');
        $consulta->bindParam(':user', $this->user);
        $consulta->bindParam(':password', $this->password); 
        $consulta->execute(); 
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;

        return $resultado;
    }

}
?>