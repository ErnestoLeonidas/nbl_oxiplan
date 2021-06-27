$(document).ready(function() {

    /* tabla(); */
    tablaReporte();
    agregarCombos();
    
} );
 
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
                { "data": "numPlano" },
                { "data": "numPlanoAnterior" },
                { "data": "codCAD" },
                { "data": "revision" },
                { "data": "descripcion" },
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
            { 'visible': false, 'targets': [0,1] },
            { 'width': 50, 'targets': 3 },
            { 'width': 100, 'targets': [0,1,2] },
            //Doy nombre a las columnas para ser usadas mas adelante .noVis
           // { 'targets': [7,8,9,10] , 'className': 'noVis'}
        ],
        /*'buttons': [
                    'excelHtml5',
                    'csvHtml5'
        ],*/
        //orden de las tablas
        'order' : [[ 2, "desc" ]],

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
    actualizarBusquedaPlanos(tablita);

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

var actualizarBusquedaPlanos = function(tablita){
    /*
    *   cmbZONA - Registrar
    *   Cuando cambie de estado búscara los últimos 8 planos registrados
    *   y actualizará la tabla según la zona seleccionada.
    */ 
   $( "#cmbZona" ).change(function () {
        //selecciono el id seleccionado select
        $nombreLocalidad = $('#cmbZona option:selected').text();
        $_Valores = obtenerValores($nombreLocalidad);

        //acción a ejecutar
        $accion = 'ultimosPlanos';
        
        //cargo la tabla con los últimos 8 planosS
        $consulta = '../controller/controllerPlanos.php?'
                    +'&idZona='+$_Valores['_ID_Zona']
                    +'&codCAD='+$_Valores['codigo_Plano']
                    +'&accion='+$accion;
        // console.log( $consulta );

        //actualiza la tabla para consultar
        tablita.ajax.url($consulta).load();
    });
}

var registrarPlanos = function () {
    $("#btnRegistrarPlano").on("click", function () {
        //validar campos
        if (validarCmbZona() && validarCmbEspecialidades()
            && validarTxtProyecto() && validarTxtDescripcion) {
            
            $nombreLocalidad = $('#cmbZona option:selected').text();
            // variables a registrar
            // idUsuario en la sesion
            $_Valores = obtenerValores($nombreLocalidad); // $_idZona['_ID_Zona']
            $_idEspecialidad = $("#cmbEspecialidades").val(); // 2

            //console.log( 'el id de especialidad es: ' + $_idEspecialidad );

            $_descripcion_proyecto = $('#txtProyecto').val();
            $_descripcion_descripcion = $('#txtDescripcion').val();
            $_fecha = moment().format('YYYY-MM-DD h:mm:ss');

            $accion = 'registrarPlano';
            
            /* PARA SABER Y UTILIZAR EN FUTURO id Y value
            $( "#cmbZona" ).children(':selected').each((idx, el) => {
                // Obtenemos los atributos que necesitamos
                $_idZona = el.id;
                $codigoZona = el.value;
            }); */

            cargarPlano(
                $_Valores['_ID_Zona'], // 1
                $_idEspecialidad, // 2
                $_Valores['_Descripcion_Zona'], //titulo zona, para armar
                $_descripcion_proyecto,
                $_descripcion_descripcion,
                $_fecha, 
                $_Valores['ruta_Zona'], //archivo

                $_Valores['codigo_Plano'], //codCAD TM CE SA
                $_Valores['codigo_UEN'],
                $_Valores['_ID_UEN'],
                $_Valores['codigo_Zona'], 
                    
                $accion
                );
            /*
            //actualiza la url para consultar
            tablita.ajax.url($consulta).load(); 
            */
                
        } else {
            console.log( 'FALTAN DATOS' );
        } //fin IF
    });
  }

function cargarPlano(idZona, idEspecialidad, descripcion_zona, descripcion_proyecto,
    descripcion_descripcion, fecha, archivo, codigo_Plano,
    codigo_UEN, idUEN, codigo_Zona, accion) {

    var parametros = {
        "idZona" : idZona,
        "idEspecialidades" : idEspecialidad,
        "descripcion_zona" : descripcion_zona,
        "descripcion_proyecto" : descripcion_proyecto,
        "descripcion_descripcion" : descripcion_descripcion,
        "fecha" : fecha,
        "archivo" : archivo,
        "codigo_Plano" : codigo_Plano,
        "codigo_UEN" :  codigo_UEN,
        "id_UEN" :  idUEN,
        "codigo_Zona" :  codigo_Zona,
        "accion" : accion
    };
    $.ajax({
        data:  parametros, //datos que se envian a traves de ajax
        url:   '../controller/controllerPlanos.php', //archivo que recibe la peticion
        type:  'get', //método de envio
        beforeSend: function () {
                //$("#resultado").html("Procesando, espere por favor...");
                // tiempo para lanzar timing
            console.log( 'Procesando, espere por favor...' );

            //$('#myModalExito').modal('hide'); // cerrar
            //setTimeout($('#myModal').modal('hide'),3000);
        },
        success: function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                //$("#resultado").html(response);
                
            console.log( 'Lanzar modal de cargado ' + response );
        }
    });                   
}

var _modal = function (){
    $('#myModal').modal('show'); // abrir

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

//Obtiene el código cad
function obtenerValores(localidad){
    switch (localidad) {
        case 'Cliente Externo':  
            array = {
                    codigo_Zona : "12",
                    _ID_Zona : 13,
                    codigo_Plano : "CE",
                    _ID_UEN : 4,
                    codigo_UEN : "04",
                    ruta_Zona : "Cliente Externo",
                    _Descripcion_Zona : "CLIENTE EXTERNO"
                    };
            return array;
        case 'Concepción - Planta Resinas':
            array = { 
                    codigo_Zona : "03",
                    _ID_Zona : 4,
                    codigo_Plano : "RC",
                    _ID_UEN : 1,
                    codigo_UEN : "01",
                    ruta_Zona : "Concepción",
                    _Descripcion_Zona : "PLANTA RESISNAS CONCEPCION"
                    };
            return array;
        case 'Concepción - Terminal Marítimo': 
            array = { 
                    codigo_Zona : "03",
                    _ID_Zona : 4,
                    codigo_Plano : "TE",
                    _ID_UEN : 2,
                    codigo_UEN : "02",
                    ruta_Zona : "Concepción",
                    _Descripcion_Zona : "TERMINAL MARITIMO ESCUADRON"
                };
            return array;
        case 'Mejillones':  
            array = { 
                    codigo_Zona : "14",
                    _ID_Zona : 15,
                    codigo_Plano : "TMM",
                    _ID_UEN : 2,
                    codigo_UEN : "02",
                    ruta_Zona : "Mejillones",
                    _Descripcion_Zona : "TERMINAL MARITIMO MEJILLONES"
                };
            return array;
        case 'Perú':  
            array = { 
                    codigo_Zona : "19",
                    _ID_Zona : 20,
                    codigo_Plano : "TMP",
                    _ID_UEN : 4,
                    codigo_UEN : "04",
                    ruta_Zona : "Perú",
                    _Descripcion_Zona : "TERMINAL PERU"
                };
            return array;
        case 'Puerto Montt':
            array = { 
                    codigo_Zona : "09",
                    _ID_Zona : 10,
                    codigo_Plano : "PM",
                    _ID_UEN : 4,
                    codigo_UEN : "04",
                    ruta_Zona : "Puerto Montt",
                    _Descripcion_Zona : "SEDE PUERTO MONTT"
                };
            return array;
        case 'Quintero':  
            array = { 
                    codigo_Zona : "02",
                    _ID_Zona : 3,
                    codigo_Plano : "TQ",
                    _ID_UEN : 2,
                    codigo_UEN : "02",
                    ruta_Zona : "Quintero",
                    _Descripcion_Zona : "TERMINAL MARITIMO QUINTERO"
                };
            return array;
        case 'Santiago - Los Conquistadores': 
            array = { 
                    codigo_Zona : "17",
                    _ID_Zona : 18,
                    codigo_Plano : "LC",
                    _ID_UEN : 9,
                    codigo_UEN : "09",
                    ruta_Zona : "Santiago-Los Conquistadores",
                    _Descripcion_Zona : "LOS CONQUISTADORES"
                };
            return array;
        case 'Santiago - Quilicura': 
            array = { 
                    codigo_Zona : "04",
                    _ID_Zona : 5,
                    codigo_Plano : "SA",
                    _ID_UEN : 4,
                    codigo_UEN : "04",
                    ruta_Zona : "Santiago-Quilicura",
                    _Descripcion_Zona : "SEDE PANAMERICANA NORTE"
                };
            return array;
        case 'Santiago - Santa María': 
            array = { 
                codigo_Zona : "11",
                _ID_Zona : 12,
                codigo_Plano : "SM",
                _ID_UEN : 9,
                codigo_UEN : "09",
                ruta_Zona : "Santiago-Santa María",
                _Descripcion_Zona : "AV. SANTA MARIA"
                };
            return array;
        case 'Standar':  
            array = { 
                codigo_Zona : "15",
                _ID_Zona : 16,
                codigo_Plano : "STD",
                _ID_UEN : 9,
                codigo_UEN : "09",
                ruta_Zona : "Standar",
                _Descripcion_Zona : "STANDARD OXIQUIM"
                };
            return array;
        default:
            break;
    }
}

function validarTxtDescripcion(){
    txtDescripcion = document.getElementById("txtDescripcion").value;
    if( txtDescripcion == null || txtDescripcion.length == 0 || /^\s+$/.test(txtDescripcion) ) {
        return false;
    } else {
        return true;
    }
}

function validarTxtProyecto() {
    txtProyecto = document.getElementById("txtProyecto").value;
    if( txtProyecto == null || txtProyecto.length == 0 || /^\s+$/.test(txtProyecto) ) {
        return false;
    } else {
        return true;
    }
}

function validarCmbZona() {
    cmbZona = document.getElementById("cmbZona").selectedIndex;
    if( cmbZona == null || cmbZona == 0 ) {
        return false;
    } else {
        return true;
    }
}

function validarCmbEspecialidades() {
    cmbEspecialidades = document.getElementById("cmbEspecialidades").selectedIndex;
    if( cmbEspecialidades == null || cmbEspecialidades == 0 ) {
        return false;
    } else {
        return true;
    }
}
