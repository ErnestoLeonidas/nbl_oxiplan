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



    <title>NBL Oxiplan</title>
</head>
<body id="registrarPlanos" class="paleta3">

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
                    <a class="btn btn-outline-warning mr-2" href="buscarPlanos.php">BUSCAR</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-warning" href="registrarPlanos.php">REGISTRAR</a>
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


    <div class="container-fluid mt-2 mb-5">
        <div class="row">

            <div class="col-md-12 col-xl-4">

                <div class="card m-1">
                    <div class="card-body">

                        <div class="row font-weight-bold">
                            <div class="col-12 m-1">

                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        Zona:
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <select id="cmbZona" class="selectpicker form-control" data-style="btn-outline-dark" data-live-search="true" title="-- Seleccionar --">
                                            <option id="13" value="12">Cliente Externo</option>
                                            <option id="4" value="03">Concepción - Planta Resinas</option>
                                            <option id="4" value="03">Concepción - Terminal Marítimo</option>
                                            <option id="15" value="14">Mejillones</option>
                                            <option id="20" value="19">Perú</option>
                                            <option id="10" value="09">Puerto Montt</option>
                                            <option id="3" value="02">Quintero</option>
                                            <option id="18" value="17">Santiago - Los Conquistadores</option>
                                            <option id="5" value="04">Santiago - Quilicura</option>
                                            <option id="12" value="11">Santiago - Santa María</option>
                                            <option id="16" value="15">Standar</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 m-1">
                            
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        Especialidades:
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <select id="cmbEspecialidades" class="selectpicker form-control" data-style="btn-outline-dark" data-live-search="true" title="-- Seleccionar --"></select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 m-1">
                                
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        Nombre Proyecto:
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <input id="txtProyecto" class="form-control" >
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 m-1">
                                
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        Descripción:
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <textarea id="txtDescripcion" class="form-control" aria-label="With textarea"></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 m-1">
                                
                                <div class="row">
                                    <div class="col text-center">
                                        <button id="btnRegistrarPlano" type="button" class="btn btn-success ">Registrar Plano</button>
                                        <div id="validar" class="text-danger mt-3 bg-warning"></div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-12 col-xl-8">   
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
                                        <th scope="col">Número Plano</th>
                                        <th scope="col">Plano Anterior</th>
                                        <th scope="col">Código CAD</th>
                                        <th scope="col">Rev</th>
                                        <th scope="col">Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Carga el datatable -->

                                    <!-- Carga el datatable -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">Número Plano</th>
                                        <th scope="col">Plano Anterior</th>
                                        <th scope="col">Código CAD</th>
                                        <th scope="col">Rev</th>
                                        <th scope="col">Descripción</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>  
                    </div>

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
                <h4 class="modal-title">Plano Registrado</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
                <h1 id="valorRegistrado" class="modal-title text-primary"></h1>
            </div>

        </div>
    </div>
    </div>



    <footer class="footer">
        <div class="container paleta4 text-center">
            <span class="text-white">NBL - Oxiplan 1.0</span>
        </div>
    </footer>
    


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
    
    <!-- PROPIOS -->
    <script type="text/javascript" src="../asset/js-oxiplan/nbloxiplan.js"></script>
</body>
</html>