<?php
    session_start();

    if(isset($_SESSION['id_Usuario'])){

        //Si esxiste asigna la variable, sino, null.
        $accion = isset($_GET['accion']) ? $_GET['accion'] : null;

        switch ($accion) {
            case "buscar":
                
                _buscar();

                break;
            case "agregar":
                
                _agregar();

                break;
            case "editar":

                _editar();

                break;
        }

    }else{
        _botar();
    }
    
    function _buscar(){
        require_once '../model/Zona.php';

        $zona = new Zona();
        $zona->buscarTodos();
    }

    function _botar(){
        header("location: salir.php");
    }

?>