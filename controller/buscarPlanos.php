<?php
    session_start();

    if(isset($_SESSION['id_Usuario'])){

        _busquedaPlanos();

    }else{
        header("location: salir.php");
    }
    

    function _busquedaPlanos(){
        require_once '../model/Plano.php';

        $idUEN = isset($_GET['idUEN']) ? '%'.$_GET['idUEN'].'%' : '%%';
        $idZona = isset($_GET['idZona']) ?'%'.$_GET['idZona'].'%' : '%%';
        $idPlantas = isset($_GET['idPlantas']) ?'%'.$_GET['idPlantas'].'%' : '%%';
        $idUnidades = isset($_GET['idUnidades']) ?'%'.$_GET['idUnidades'].'%' : '%%';
        $idEspecialidades = isset($_GET['idEspecialidades']) ?'%'.$_GET['idEspecialidades'].'%' : '%%';
        $descripcion = isset($_GET['descripcion']) ?'%'.$_GET['descripcion'].'%' : '%%';
        $codCAD = isset($_GET['codCAD']) ?'%'.$_GET['codCAD'].'%' : '%%';
    
        $busqueda = new Plano();
        $busqueda->setIdUEN($idUEN);
        $busqueda->setIdZona($idZona);
        $busqueda->setIdPlantas($idPlantas);
        $busqueda->setIdUnidades($idUnidades);
        $busqueda->setIdEspecialidades($idEspecialidades);
        $busqueda->setDescripcion($descripcion);
        $busqueda->setCodCAD($codCAD);
    
        $busqueda->buscarPlano();
    }


?>