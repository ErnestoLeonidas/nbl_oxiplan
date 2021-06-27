<?php
    session_start();

    if(isset($_SESSION['id_Usuario'])){

        //Si esxiste asigna la variable, sino, null.
        $accion = isset($_GET['accion']) ? $_GET['accion'] : null;

        switch ($accion) {
            case "buscarPlanos":        _busquedaPlanos();              break;
            case "ultimosPlanos":       _busquedaUltimosPlanos();       break;
            case "numeroCorrelativo":   _busquedaNumeroCorrelativo();   break;
            case "registrarPlano":      _registrarPlano();              break;
        }

    }else{
        _botar();
    }

    
    function _busquedaPlanos(){
        require_once '../model/Plano.php';

        $idUEN = isset($_GET['idUEN']) ?  $_GET['idUEN'].'%' : '%%';
        $idZona = isset($_GET['idZona']) ? $_GET['idZona'].'%' : '%%';
        $idPlantas = isset($_GET['idPlantas']) ? $_GET['idPlantas'].'%' : '%%';
        $idUnidades = isset($_GET['idUnidades']) ? $_GET['idUnidades'].'%' : '%%';
        $idEspecialidades = isset($_GET['idEspecialidades']) ? $_GET['idEspecialidades'].'%' : '%%';
        $descripcion = isset($_GET['descripcion']) ? '%'.$_GET['descripcion'].'%' : '%%';
        $codCAD = isset($_GET['codCAD']) ? '%'.$_GET['codCAD'].'%' : '%%';
    
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

    function _busquedaUltimosPlanos(){
        require_once '../model/Plano.php';

        $idZona = isset($_GET['idZona']) ? $_GET['idZona'] : null;
        $codCAD = isset($_GET['codCAD']) ?'%'.$_GET['codCAD'].'%' : '%%';
    
        $busqueda = new Plano();
        $busqueda->setIdZona($idZona);
        $busqueda->setCodCAD($codCAD);
        $busqueda->buscarUltimosPlanos();
    }
    
    function _busquedaNumeroCorrelativo($NC_idZona, $NC_idEspecialidades){
        require_once '../model/Plano.php';

        $NC_sql = new Plano();
        $NC_sql->setIdZona($NC_idZona);
        $NC_sql->setIdEspecialidades($NC_idEspecialidades);
        $NC_Resultado = $NC_sql->buscarNumeroCorrelativo();
      
        if (count($NC_Resultado) == 1) {
      
        $corr = $NC_Resultado[0]['numCorrelativo'];
        $corr = $corr+1;

            switch (strlen($corr)) {
                case 1:
                    $value = "00" . strval($corr);
      
                    return $value;
                    break;
                case 2:
                    $value = "0" . strval($corr);
      
                    return $value;
                    break;
                case 3:
                    $value = strval($corr);
      
                    return $value;
                    break;
                default:
                    $value = "001";
      
                    return $value;
                    break;
            }
        } else {
            $value = "001";
      
            return $value;
        }

    }

    function _registrarPlano(){
    //falta completar y validar los demas campos
        require_once '../model/Plano.php';

        $idUsuario = $_SESSION['id_Usuario'];

        $idZona = isset($_GET['idZona']) ? $_GET['idZona'] : null;
        
        $idEspecialidades = isset($_GET['idEspecialidades']) ? $_GET['idEspecialidades'] : null;
        
        $_descripcion_zona = isset($_GET['descripcion_zona']) ? $_GET['descripcion_zona'] : null;
        $_descripcion_proyecto = isset($_GET['descripcion_proyecto']) ? $_GET['descripcion_proyecto'] : null;
        $_descripcion_descripcion = isset($_GET['descripcion_descripcion']) ? $_GET['descripcion_descripcion'] : null;

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;

        $id_UEN = isset($_GET['id_UEN']) ? $_GET['id_UEN'] : null;
        
        $AR_ruta_zona = isset($_GET['archivo']) ? $_GET['archivo'] : null; //ruta_zona armar
        $codCAD = ''; //armar

        $_codigo_Plano = isset($_GET['codigo_Plano']) ? $_GET['codigo_Plano'] : null;
        $_Codigo_UEN = isset($_GET['codigo_UEN']) ? $_GET['codigo_UEN'] : null;
        $_CodigoZona = isset($_GET['codigo_Zona']) ? $_GET['codigo_Zona'] : null;
        $_Codigo_Planta = '18';
        $_Codigo_Unidad = '00';
        $_Codigo_Especialidad = codigoEspecialidad($idEspecialidades);

        $_nombreZona = $_descripcion_zona;

        $correlativo = _busquedaNumeroCorrelativo($idZona, $idEspecialidades);

        $numPlano = '0'.$id_UEN . $_CodigoZona . $_Codigo_Planta . $_Codigo_Unidad . '.' . $_Codigo_Especialidad . $correlativo;

        $descripcion =  $_descripcion_zona . ' ; ' .
                        $_descripcion_proyecto . ' ; ' .
                        $_descripcion_descripcion;

        $codCAD = _ultimoCodigoCAD($_codigo_Plano);

        $AR_Epecialidad = rutaEspecialidad($idEspecialidades);
        $archivo = $AR_ruta_zona .'\\'. $AR_Epecialidad .'\\'. $codCAD .'revA.dwg';

        $rotulosVar = "TITULO1= " . $_descripcion_zona . "#SEP#" .
                        "TITULO2= " . $_descripcion_proyecto . "#SEP#" .
                        "TITULO3= " . $_descripcion_descripcion . "#SEP#" .
                        "DESTINO= #SEP#" .
                        "ESCALA= #SEP#" .
                        "PROYECTO= #SEP#" .
                        "NRO._PLANO_COM.= #SEP#" .
                        "DIBUJO= #SEP#" .
                        "PROBO= P.M.S.#SEP#" .
                        "FECHA= #SEP#" .
                        "NRO_DE_PLANO= " . $numPlano . "#SEP#" .
                        "REVISION:= A#SEP#" .
                        "CODIGO= " . $codCAD;

        $busqueda = new Plano();
        $busqueda->setIdUsuario($idUsuario);                    // ok
        $busqueda->setIdZona($idZona);                          // ok
        $busqueda->setIdEspecialidades($idEspecialidades);      // ok
        $busqueda->setNumCorrelativo($correlativo);             // ok
        $busqueda->setDescripcion($descripcion);                // ok
        $busqueda->setNumPlano($numPlano);                      // ok
        $busqueda->setFecha($fecha);                            // ok
        $busqueda->setRotulosVar($rotulosVar);                  // ok
        $busqueda->setArchivo($archivo);                        // ok
        $busqueda->setCodCAD($codCAD);                          // ok
        $busqueda->guardar();

        //retorna el ultimo codigo CAD, va al javascript
        echo $codCAD;
    }

    function codigoEspecialidad($id){
        switch ($id) {
            case 1 : return '00';
            case 2 : return '01';
            case 3 : return '02';
            case 4 : return '03';
            case 5 : return '04';
            case 6 : return '05';
            case 7 : return '06';
            case 8 : return '07';
            case 9 : return '08';
            case 10 : return '09';
            case 11 : return '10';
            default: break;
        }
    }

    function rutaEspecialidad($idespecialidad){
        switch ($idespecialidad) {
            case 1 : return 'Historico';
            case 2 : return 'Flow-sheet';
            case 3 : return 'Lay-out';
            case 4 : return 'Obras civiles';
            case 5 : return 'Estructuras';
            case 6 : return 'Piping';
            case 7 : return 'Equipos';
            case 8 : return 'Eléctricos';
            case 9 : return 'Instrumentación';
            case 10 : return 'Croquis';
            case 11 : return 'Estandar';
            default: break;
        }
    }

    function _ultimoCodigoCAD($_cPlano){
        $_ultCAD = new Plano();      
        $_ultCAD->setCodCAD('%'.$_cPlano.'%'); 
        $_codCAD = $_ultCAD->ultimoCodigoCAD();
      
        if (count($_codCAD) == 1) {
          $valCAD = intval(preg_replace('/[^0-9]+/', '', $_codCAD[0]['codCAD']), 10); 
          $valCAD = $valCAD + 1;
      
          if ($valCAD <= 9)
          {
            $resultado = $_cPlano . "00" . $valCAD;
          }
          else if ($valCAD <= 99 && $valCAD > 9)
          {
            $resultado = $_cPlano . "0" . $valCAD;
          }
          else
          {
            $resultado = $_cPlano . $valCAD;
          }
          return $resultado;
      
        } else {
          $resultado = $_cPlano . '001';
          return $resultado;
        }
    }

    function _botar(){
        header("location: salir.php");
    }
?>