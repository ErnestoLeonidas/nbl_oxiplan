<?php
require_once '../db/conexion.php';

class Plano{
  const TABLA="Planos";

  private $id;
  private $idUsuario;
  private $idUEN;
  private $idZona;
  private $idUnidades;
  private $idEspecialidades;
  private $idPlantas;
  private $numCorrelativo;
  private $descripcion;
  private $numPlano;
  private $fecha;
  private $dibujo;
  private $aprobo;
  private $revision;
  private $numPlanoAnterior;
  private $rotulosVar;
  private $tipo;
  private $archivo;
  private $codCAD;
  private $aproboExtra;
  private $dibujoExtra;

  public function __construct(){}

  public function setId($id){ $this->id=$id; }
  public function getId(){ return $this->id; }

  public function setIdUsuario($idUsuario){ $this->idUsuario=$idUsuario; }
  public function getIdUsuario(){ return $this->idUsuario; }

  public function setIdUEN($idUEN){ $this->idUEN=$idUEN; }
  public function getIdUEN(){ return $this->idUEN; }

  public function setIdZona($idZona){ $this->idZona=$idZona; }
  public function getIdZona(){ return $this->idZona; }

  public function setIdUnidades($idUnidades){ $this->idUnidades=$idUnidades; }
  public function getIdUnidades(){ return $this->idUnidades; }

  public function setIdEspecialidades($idEspecialidades){ $this->idEspecialidades=$idEspecialidades; }
  public function getIdEspecialidades(){ return $this->idEspecialidades; }

  public function setIdPlantas($idPlantas){ $this->idPlantas=$idPlantas; }
  public function getIdPlantas(){ return $this->idPlantas; }

  public function setNumCorrelativo($numCorrelativo){ $this->numCorrelativo=$numCorrelativo; }
  public function getNumCorrelativo(){ return $this->numCorrelativo; }

  public function setDescripcion($descripcion){ $this->descripcion=$descripcion; }
  public function getDescripcion(){ return $this->descripcion; }

  public function setNumPlano($numPlano){ $this->numPlano=$numPlano; }
  public function getNumPlano(){ return $this->numPlano; }

  public function setFecha($fecha){ $this->fecha=$fecha; }
  public function getFecha(){ return $this->fecha; }

  public function setDibujo($dibujo){ $this->dibujo=$dibujo; }
  public function getDibujo(){ return $this->dibujo; }

  public function setAprobo($aprobo){ $this->aprobo=$aprobo; }
  public function getAprobo(){ return $this->aprobo; }

  public function setRevision($revision){ $this->revision=$revision; }
  public function getRevision(){ return $this->revision; }

  public function setNumPlanoAnterior($numPlanoAnterior){ $this->numPlanoAnterior=$numPlanoAnterior; }
  public function getNumPlanoAnterior(){ return $this->numPlanoAnterior; }

  public function setRotulosVar($rotulosVar){ $this->rotulosVar=$rotulosVar; }
  public function getRotulosVar(){ return $this->rotulosVar; }

  public function setTipo($tipo){ $this->tipo=$tipo; }
  public function getTipo(){ return $this->tipo; }

  public function setArchivo($archivo){ $this->archivo=$archivo; }
  public function getaArchivo(){ return $this->archivo; }

  public function setCodCAD($codCAD){ $this->codCAD=$codCAD; }
  public function getCodCAD(){ return $this->codCAD; }

  public function setAproboExtra($aproboExtra){ $this->aproboExtra=$aproboExtra; }
  public function getAproboExtra(){ return $this->aproboExtra; }

  public function setDibujoExtra($dibujoExtra){ $this->dibujoExtra=$dibujoExtra; }
  public function getDibujoExtra(){ return $this->dibujoExtra; }

  public function buscarPlano(){
    $conexion = new Conexion();
    $conexion->query("SET NAMES 'UTF8'");
    $consulta = $conexion->prepare(
      "SELECT 
      id,
      numPlano,
      numPlanoAnterior,
      codCAD,
      revision,
      descripcion,
      archivo
    FROM 
      Planos
    WHERE 
          idUEN LIKE :idUEN
      AND idZona LIKE :idZona
      AND idPlantas LIKE :idPlantas
      AND idUnidades LIKE :idUnidades
      AND idEspecialidades LIKE :idEspecialidades
      AND descripcion LIKE :descripcion
      AND codCAD LIKE :codCAD
      ORDER BY id DESC
      
      ");
  
    $consulta->bindParam(':idUEN', $this->idUEN, PDO::PARAM_STR);
    $consulta->bindParam(':idZona', $this->idZona, PDO::PARAM_STR);
    $consulta->bindParam(':idPlantas', $this->idPlantas, PDO::PARAM_STR);
    $consulta->bindParam(':idUnidades', $this->idUnidades, PDO::PARAM_STR);
    $consulta->bindParam(':idEspecialidades', $this->idEspecialidades, PDO::PARAM_STR);
    $consulta->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
    $consulta->bindParam(':codCAD', $this->codCAD, PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $conexion = null;
    
    $data = array('data' => $resultado );
    echo json_encode($data, true);
  }

  public function buscarUltimosPlanos(){
    $conexion = new Conexion();
    $conexion->query("SET NAMES 'UTF8'");
    $consulta = $conexion->prepare(
      "SELECT 
      numPlano,
      numPlanoAnterior,
      codCAD,
      revision,
      descripcion
    FROM 
      Planos
    WHERE 
      idZona = :idZona
      AND codCAD LIKE :codCAD
    ORDER BY id DESC
    LIMIT 8");
  
    $consulta->bindParam(':idZona', $this->idZona, PDO::PARAM_STR);
    $consulta->bindParam(':codCAD', $this->codCAD, PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $conexion = null;

    $data = array('data' => $resultado );
    echo json_encode($data, true);
    //var_dump($consulta->debugDumpParams());
  }

  public function buscarNumeroCorrelativo(){
    $conexion = new Conexion();
    $conexion->query("SET NAMES 'UTF8'");
    $consulta = $conexion->prepare(
      "SELECT numCorrelativo
      FROM Planos
      WHERE idZona = :idZona
        AND idPlantas = 18
        AND idUnidades = 1
        AND idEspecialidades = :idEspecialidades
      ORDER BY numCorrelativo DESC 
      LIMIT 1");
  
    $consulta->bindParam(':idZona', $this->idZona, PDO::PARAM_STR);
    $consulta->bindParam(':idEspecialidades', $this->idEspecialidades, PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $conexion = null;

    /* RETORNARA EL NÚMERO CORRELATIVO */
    //return $resultado[0]['numCorrelativo'];
    //var_dump($consulta->debugDumpParams());
    return $resultado;
  }

  public function guardar(){
    $conexion = new Conexion();
    $conexion->query("SET NAMES 'UTF8'");
    $consulta = $conexion->prepare(
      "INSERT INTO Planos
      (
      `idUsuario`,
      `idUEN`,
      `idZona`,
      `idUnidades`,
      `idEspecialidades`,
      `idPlantas`,
      `numCorrelativo`,
      `descripcion`,
      `numPlano`,
      `fecha`,
      `dibujo`,
      `aprobo`,
      `revision`,
      `numPlanoAnterior`,
      `rotulosVar`,
      `tipo`,
      `archivo`,
      `codCAD`,
      `aproboExtra`)
      VALUES
      (
        :idUsuario,
        2,
        :idZona,
        1,
        :idEspecialidades,
        18,
        :numCorrelativo,
        :descripcion,
        :numPlano,
        :fecha,
        0,
        30,
        'A',
        '',
        :rotulosVar,
        2,
        :archivo,
        :codCAD,
        'P.M.S.'
      )
      ");
  
    $consulta->bindParam(':idUsuario', $this->idUsuario, PDO::PARAM_STR);
    $consulta->bindParam(':idZona', $this->idZona, PDO::PARAM_STR);
    $consulta->bindParam(':idEspecialidades', $this->idEspecialidades, PDO::PARAM_STR);
    $consulta->bindParam(':numCorrelativo', $this->numCorrelativo, PDO::PARAM_STR);
    $consulta->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
    $consulta->bindParam(':numPlano', $this->numPlano, PDO::PARAM_STR);
    $consulta->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
    $consulta->bindParam(':rotulosVar', $this->rotulosVar, PDO::PARAM_STR);
    $consulta->bindParam(':archivo', $this->archivo, PDO::PARAM_STR);
    $consulta->bindParam(':codCAD', $this->codCAD, PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $conexion = null;

    //debugear sql
    //var_dump($consulta->debugDumpParams());
    //return true;
  }

  public function ultimoCodigoCAD(){
    $conexion = new Conexion();
    $conexion->query("SET NAMES 'UTF8'");
    $consulta = $conexion->prepare(
      "SELECT
        codCAD
      FROM 
        Planos
      WHERE 
        codCAD LIKE :codCAD
      ORDER BY id DESC
      LIMIT 1");
  
    $consulta->bindParam(':codCAD', $this->codCAD, PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $conexion = null;

    /* RETORNARA EL ÚLTIMO COD */
    //return $resultado[0]['codCAD'];
    return $resultado;
  }

}

?>