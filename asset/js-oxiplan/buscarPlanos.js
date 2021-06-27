$(document).ready(function() {

     /* tabla(); */
     tablaReporte();
     agregarCombos();
 


} );

var tablita; // 1 - CARGAMOS LA TABLA
            // 2 - LA USAMOS CON EL MISMO NOMBRE DONDE QUERAMOS
 
var tablaReporte = function (){
    var tablita = $('#tablaBusquedaPlanos').DataTable( {

        //idioma del datatable
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "pageLength": 100,
        //ajax para sacar los datos de la query en json
       /* "ajax": {
            "url": "controlador/reportes/reporteMensual.php",
            "type": "POST"
            }, */
        //definimos el nombre de las columnas
        "columns": [
                { "data": "id" },
                { "data": "numPlano" },
                { "data": "numPlanoAnterior" },
                { "data": "codCAD" },
                { "data": "revision" },
                { "data": "descripcion" },
                { "data": "archivo" },
                { "defaultContent": "<div class='btn-group' role='group'>"
                            +"<button type='button' class='btn btn-sm btn-danger descargarPlanoPDF' data-toggle='tooltip' data-placement='top' title='Descargar Plano'>"
                                //+"<span class='glyphicon glyphicon-download-alt'></span>"
                            +"PDF</button>"
                            +"<button type='button' class='btn btn-sm btn-success descargarPlanoDWG' data-toggle='tooltip' data-placement='top' title='Descargar Plano'>"
                            //+"<span class='glyphicon glyphicon-download-alt'></span>"
                            +"DWG</button>"
                        +"</div>"
                    +"</div>"
                }
            ],
            //'dom': 'Bfrtip',
            'dom':"<'row' "
                +"<'col-sm-6 col-md-6 col-lg-6'B>"
                +"<'col-sm-6 col-md-6 col-lg-6'f>>"     
                +"<rt>"
                +"<'row' "
                +"<'col-sm-6 col-md-6 col-lg-6'l>"
                +"<'col-sm-6 col-md-6 col-lg-6'p>>",
        
        //ocultar una columna (aqui la tercera) - [0,2] -> primera y tercera
        'columnDefs' : [
            { 'visible': false, 'targets': [0,1,2] },
            { 'width': 50, 'targets': [4] },
            { 'width': 100, 'targets': [1,2,3] },
            { 'width': "20%", 'targets': [6] },
            { 'width': "10%", 'targets': [7] },
            //Doy nombre a las columnas para ser usadas mas adelante .noVis
           // { 'targets': [7,8,9,10] , 'className': 'noVis'}
        ],
        /*'buttons': [
                    'excelHtml5',
                    'csvHtml5'
        ],*/
        //orden de las tablas
        //'order' : [[ 0, "desc" ]],

        'buttons':[
            {
            'extend':    'excelHtml5',
            'titleAttr': 'Excel',
            'className': 'btn btn-success'
            },
            // {
            // 'extend':    'csvHtml5',
            // 'titleAttr': 'Csv',
            // 'className': 'btn btn-success'
            // }, 
            {
            'extend':    'colvis',
            'text':      'Columnas',
            'titleAttr': 'Ocultar',
            'className': 'btn btn-success',
            //Oculta del select las columnas definidas en .noVis
            'columns': ':not(.noVis)'
            },

            
        ]

    } );

    // Se anota aqui la funcion para que se actualice la tabla.
    formBusquedaPlanos(tablita);
    descargar_PlanoDWG(tablita);
    descargar_PlanoPDF(tablita);
}


//caracteristica del selectpicker AGREGAR
$('.selectpicker').selectpicker({
    //style: 'input input-lg ml-2 btn-outline-dark'
    //style: 'form-control form-control-sm ml-2'
});

$('#fechaInicio').datepicker({
        language: 'es',
        format: 'yyyy-mm-dd',
        ignoreReadonly: true,
        autoHide: true
    }).on('change', function(){
    $('.datepicker').hide();
});

$('#fechaTermino').datepicker({
    language: 'es',
    format: 'yyyy-mm-dd',
    ignoreReadonly: true,
    autoHide: true
})

var formBusquedaPlanos = function (tablita) {
    //btnBuscarPlanos - Buscar

    $("#buscarPlanos").on("click", function () {

        //capturar variables
        $idUEN = $('#cmbUEN').val();
        $idZona = $('#cmbZonas').val();
        $idPlantas = $('#cmbPlantas').val();
        $idUnidades = $('#cmbUnidades').val();
        $idEspecialidades = $("#cmbEspecialidades").val();
        $descripcion = $('#txtDescripcion').val();
        $codCAD = $('#txtCodCAD').val();

        //acción a ejecutar
        $accion = 'buscarPlanos';

        // console.log( $idUEN );
        // console.log( $idZona );
        // console.log( $idPlantas );
        // console.log( $idUnidades );
        // console.log( $idEspecialidades );

        $consulta = '../controller/controllerPlanos.php?'
                    +'idUEN='+$idUEN
                    +'&idZona='+$idZona
                    +'&idPlantas='+$idPlantas
                    +'&idUnidades='+$idUnidades
                    +'&idEspecialidades='+$idEspecialidades
                    +'&descripcion='+$descripcion
                    +'&codCAD='+$codCAD
                    +'&accion='+$accion;
        //console.log( $consulta );

        //actualiza la url para consultar
        tablita.ajax.url($consulta).load();
    });
}


// Carga los combos con los valores
var agregarCombos = function() {

    // Cargar combo UEN
    $.ajax({
        url: '../controller/controllerUEN.php?accion=buscar',
        dataType: 'json',
        type: 'GET',
        success: function(data){   
            $.each(data,function(key, registro) {
                
                /* SE CAMBIO EL id Y EL value PARA IDETIFICAR EL QUE CORRESPONDE AL BUSCAR */
                // $("#cmbPlantas").append('<option id="' + registro.id + '" value="' + registro.value + '">' + registro.nombre + '</option>');

                $("#cmbUEN").append('<option id="' + registro.value + '" value="' + registro.id + '">' + registro.nombre + '</option>');
                // console.log( data );
            });

            $('.selectpicker').selectpicker('refresh');
        //console.log( "solicito" );
        },
            error: function(data) {
            alert('error');
        }
    });

    // Cargar combo Zona
    $.ajax({
        url: '../controller/controllerZonas.php?accion=buscar',
        dataType: 'json',
        type: 'GET',
        success: function(data){   
            $.each(data,function(key, registro) {
               $("#cmbZonas").append('<option id="' + registro.value + '" value="' + registro.id + '">' + registro.nombre + '</option>');
                // console.log( data );
            });

            $('.selectpicker').selectpicker('refresh');
        //console.log( "solicito" );
        },
            error: function(data) {
            alert('error');
        }
    });

    // Cargar combo Plantas
    $.ajax({
        url: '../controller/controllerPlantas.php?accion=buscar',
        dataType: 'json',
        type: 'GET',
        success: function(data){   
            $.each(data,function(key, registro) {
               $("#cmbPlantas").append('<option id="' + registro.value + '" value="' + registro.id + '">' + registro.nombre + '</option>');
                // console.log( data );
            });

            $('.selectpicker').selectpicker('refresh');
        //console.log( "solicito" );
        },
            error: function(data) {
            alert('error');
        }
    });

    // Cargar combo Unidades
    $.ajax({
        url: '../controller/controllerUnidades.php?accion=buscar',
        dataType: 'json',
        type: 'GET',
        success: function(data){   
            $.each(data,function(key, registro) {
               $("#cmbUnidades").append('<option id="' + registro.value + '" value="' + registro.id + '">' + registro.nombre + '</option>');
                // console.log( data );
            });

            $('.selectpicker').selectpicker('refresh');
        //console.log( "solicito" );
        },
            error: function(data) {
            alert('error');
        }
    });

    // Cargar combo Especialidades
    $.ajax({
        url: '../controller/controllerEspecialidades.php?accion=buscar',
        dataType: 'json',
        type: 'GET',
        success: function(data){   
            $.each(data,function(key, registro) {
               $("#cmbEspecialidades").append('<option id="' + registro.value + '" value="' + registro.id + '">' + registro.nombre + '</option>');
                // console.log( data );
            });

            $('.selectpicker').selectpicker('refresh');
        //console.log( "solicito" );
        },
            error: function(data) {
            alert('error');
        }
    });
}


//DescargarPlanoDWG
var descargar_PlanoDWG = function (tablita) {
    //activa el boton DESCARGAR PLANO
    $("#tablaBusquedaPlanos tbody").on("click", ".descargarPlanoDWG", function () {
        //selecciono la linea y sus datos
        var data = tablita.row($(this).parents("tr")).data();

        //cargo dato de acuerdo a lo indicado en el datatable
        _plano = data.archivo;

        //Parametros por url
        var parametros = {
            "_plano" : _plano,
        };
        $.ajax({
            data:  parametros, //datos que se envian a traves de ajax
            url:   '../descargarDWG.php', //archivo que recibe la peticion
            type:  'POST', //método de envio
            beforeSend: function () {
                //console.log( 'Procesando, espere por favor...' );

                $("#modalCargando").modal("show");
    
            },
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                //$("#resultado").html(response);

                move();
                setTimeout(function(){
                    $("#modalCargando").modal("hide");
                    $("#modalRegistrado").modal("show");
        
                    if (response != 'error') {
                        $("#link_archivo").attr('href', response);
                        $("#valorRegistrado").text(data.codCAD+'rev'+data.revision);
                        //console.log( 'Link: ' + response );
                    } else {
                        //$("#link_archivo").attr('href', response);
                        $("#ErrorPlano").text("No se encontró el plano solicitado");
                        //console.log( 'Link: ' + response );
                    }

                }, 2000); 
                //console.log( 'Link: ' + response );
                
                
            }
        });              

    }); 
}

//DescargarPlanoPDF
var descargar_PlanoPDF = function (tablita) {
    //activa el boton DESCARGAR PLANO
    $("#tablaBusquedaPlanos tbody").on("click", ".descargarPlanoPDF", function () {
        //selecciono la linea y sus datos
        var data = tablita.row($(this).parents("tr")).data();

        //cargo dato de acuerdo a lo indicado en el datatable
        _plano = data.archivo;

        //Parametros por url
        var parametros = {
            "_plano" : _plano,
        };
        $.ajax({
            data:  parametros, //datos que se envian a traves de ajax
            url:   '../descargarPDF.php', //archivo que recibe la peticion
            type:  'POST', //método de envio
            beforeSend: function () {
                //console.log( 'Procesando, espere por favor...' );

                $("#modalCargando").modal("show");
    
            },
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                //$("#resultado").html(response);

                move();
                setTimeout(function(){
                    $("#modalCargando").modal("hide");
                    $("#modalRegistrado").modal("show");
        
                    if (response != 'error') {
                        $("#link_archivo").attr('href', response);
                        $("#valorRegistrado").text(data.codCAD+'rev'+data.revision);
                        //console.log( 'Link: ' + response );
                    } else {
                        //$("#link_archivo").attr('href', response);
                        $("#ErrorPlano").text("No se encontró el plano solicitado");
                        //console.log( 'Link: ' + response );
                    }

                }, 2000); 
                //console.log( 'Link: ' + response );
                
                
            }
        });              

    }); 
}

$("#cerrar_modal").on("click", function () {
    $("#valorRegistrado").text('');
    $("#ErrorPlano").text('');
});

//barra de carga
//var i = 0;

function move() {
    i = 0;
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 1;
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
      }
    }
  }
}
