<?php
    require_once '../model/Usuario.php';
    session_start();

    $usuario = $_POST['user'];
    $pass = $_POST['password'];

    $user = new Usuario();
    $user->setUser($usuario);
    $user->setPassword($pass);

    $resultado = $user->validarLogin();

    if(count($resultado)>=1){
        //echo $resultado[0]["apellido"];

        $_SESSION['id_Usuario'] = $resultado[0]["id"];
        $_SESSION['nombre_Usuario'] = $resultado[0]["nombre"] . ' ' . $resultado[0]["apellido"];;

        header('location: ../view/buscarPlanos.php');
        //echo var_dump($resultado[1][0]);
    } else {
        $_SESSION['error'] = "Contrase«Ða incorrecta, favor ingrese nuevamente";
        header("location: ../index.php");
    }

?>