<?php
    session_start();
    $usuarioActivo = isset($_SESSION['nombre_Usuario']) ? $_SESSION['nombre_Usuario'] : header("location: ../controller/salir.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../asset/img/icon.ico" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../asset/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="../asset/bootstrap-select-1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="../asset/css/glyphicons.css"/>
    <link rel="stylesheet" type="text/css" href="../asset/css/nbl.css"/>

    <!-- CSS DATATABLE -->
    <link rel="stylesheet" type="text/css" href="../asset/dt/DataTables-1.10.18/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" type="text/css" href="../asset/dt/Buttons-1.5.4/css/buttons.bootstrap4.css"/>
    <link rel="stylesheet" type="text/css" href="../asset/dt/Responsive-2.2.2/css/responsive.bootstrap4.css"/>

    <link rel="stylesheet" type="text/css" href="../asset/datepicker/datepicker.css"/>

    <!-- JS -->
    <script src="../asset/js/jquery-3.3.1.min.js"></script>
    <script src="../asset/js/popper.min.js"></script>
    <script src="../asset/bootstrap/js/bootstrap.js"></script>
    <script src="../asset/bootstrap-select-1.13.2/js/bootstrap-select.min.js"></script>

    <script src="../asset/datepicker/datepicker.js"></script>
    <script src="../asset/datepicker/datepicker.es.js"></script>
    <script src="../asset/datepicker/moment.js"></script>

    <!-- JS DATATABLE -->
    <script type="text/javascript" src="../asset/dt/DataTables-1.10.18/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="../asset/dt/DataTables-1.10.18/js/dataTables.bootstrap4.js"></script>
    <script type="text/javascript" src="../asset/dt/Buttons-1.5.4/js/dataTables.buttons.js"></script>
    <script type="text/javascript" src="../asset/dt/jszip.min.js"></script>
    <script type="text/javascript" src="../asset/dt/Buttons-1.5.4/js/buttons.bootstrap4.js"></script>
    <script type="text/javascript" src="../asset/dt/Buttons-1.5.4/js/buttons.colVis.js"></script>
    <script type="text/javascript" src="../asset/dt/buttons.html5.js"></script>
    <script type="text/javascript" src="../asset/dt/Responsive-2.2.2/js/dataTables.responsive.js"></script>

    <title>NBL Oxiplan</title>
</head>
<body id="formBuscarPlanos" class="paleta3">

    <nav class="navbar navbar-expand-md paleta4 navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand bg-light pl-2 pr-2" href="#"><img src="../asset/img/icon.ico" alt="NBL INGENIERIA 2020" style="width:40px;"></a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="btn btn-warning mr-2" href="buscarPlanos.php">BUSCAR</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-warning" href="registrarPlanos.php">REGISTRAR</a>
                </li>
            </ul>
        </div>

        <div class="inline">
            <div class="text-white">
                <?php echo $usuarioActivo; ?>            
                <a class="btn btn-outline-danger my-2 ml-2 my-sm-0" href="../controller/salir.php">SALIR</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-2">
        <div class="card m-1">
                
            <!-- <div class="card-header ">
                <div class="row">
                    <h4>Búsqueda</h4>
                </div>
            </div> -->

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-3 font-weight-bold">

                        <div class="form-group row">
                                <label for="colFormLabel" class="col-4 col-form-label text-right">UEN:</label>
                            <div class="col-8">
                               <select id="cmbUEN" class="selectpicker form-control btn-outline-dark" data-style="btn-outline-dark" data-live-search="true" title="-- Seleccionar --"></select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-3 font-weight-bold">

                        <div class="form-group row">
                                <label for="colFormLabel" class="col-4 col-form-label text-right">Zona:</label>
                            <div class="col-8">
                                <select id="cmbZonas" class="selectpicker form-control btn-outline-dark" data-style="btn-outline-dark" data-live-search="true" title="-- Seleccionar --"></select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-3 font-weight-bold">
                    
                        <div class="form-group row">
                                <label for="colFormLabel" class="col-4 col-form-label text-right">Planta:</label>
                            <div class="col-8">
                                <select id="cmbPlantas" class="selectpicker form-control btn-outline-dark" data-style="btn-outline-dark" data-live-search="true" title="-- Seleccionar --"></select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-3 font-weight-bold">
                    
                        <div class="form-group row">
                                <label for="colFormLabel" class="col-4 col-form-label text-right">Unidades:</label>
                            <div class="col-8">
                                <select id="cmbUnidades" class="selectpicker form-control btn-outline-dark" data-style="btn-outline-dark" data-live-search="true" title="-- Seleccionar --"></select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-6 col-lg-3 font-weight-bold">

                        <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Especialidades:</label>
                            <div class="col-sm-8">
                                <select id="cmbEspecialidades" class="selectpicker form-control" data-style="btn-outline-dark" data-live-search="true" title="-- Seleccionar --"></select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-3 font-weight-bold">

                        <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Descripción:</label>
                            <div class="col-sm-8">
                                <input id="txtDescripcion" class="form-control" >
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-3 font-weight-bold">
                    
                        <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Cod CAD:</label>
                            <div class="col-sm-8">
                                <input id="txtCodCAD" class="form-control" >
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-3 font-weight-bold">
                    
                        <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Buscar:</label>
                            <div class="col-sm-8">
                                <div class="btn btn-primary" id="buscarPlanos"> BUSCAR <span class="glyphicon glyphicon-search"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="container-fluid mb-5">
        <div class="card m-1">
        
            <!-- <div class="card-header ">
                <div class="row">
                    <h4>Resultados</h4>
                </div>
            </div> -->

            <div class="card-body">
                <div class="container-fluid">
                    <table id="tablaBusquedaPlanos" class="table table-striped table-hover table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Número Plano</th>
                                <th scope="col">Plano Anterior</th>
                                <th scope="col">Código CAD</th>
                                <th scope="col">Rev</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Ruta Archivo</th>
                                <th scope="col">Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Carga el datatable -->

                            <!-- Carga el datatable -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Número Plano</th>
                                <th scope="col">Plano Anterior</th>
                                <th scope="col">Código CAD</th>
                                <th scope="col">Rev</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Ruta Archivo</th>
                                <th scope="col">Descargar</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>  
            </div>

        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="modalCargando">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Cargando...</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
                <div id="myProgress">
                    <div id="myBar"></div>
                </div>
                <!-- <div class="spinner-border text-info"></div> -->
            </div>

        </div>
    </div>
    </div>

        <!-- The Modal -->
    <div class="modal" id="modalRegistrado">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Descarga el Plano</h4>
                <button type="button" id="cerrar_modal" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
                <h1 id="ErrorPlano" class="modal-title text-danger"></h1>
                <a class="button btn-danger" id="link_archivo" href="" download>
                    <h1 id="valorRegistrado" class="modal-title text-primary"></h1>
                </a>
            </div>

        </div>
    </div>
    </div>


    <footer class="footer">
        <div class="container paleta4 text-center">
            <span class="text-white">NBL - Oxiplan 1.0</span>
        </div>
    </footer>

    <script type="text/javascript" src="../asset/js-oxiplan/buscarPlanos.js"></script>
</body>
</html>