<?php
require_once '../db/conexion.php';
require_once '../model/Plano.php';


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
  idZona = 20
  AND codCAD LIKE '%TMP%'
ORDER BY codCAD DESC
LIMIT 8");

$consulta->execute();
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
$conexion = null;

$data = array('data' => $resultado );
echo json_encode($data, true);
var_dump($consulta->debugDumpParams());

?>