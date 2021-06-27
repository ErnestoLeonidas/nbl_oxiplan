$(document).ready(function() {

    /* tabla(); */
    tablaReporte();
    
 
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
                { "data": "revision" },
                { "data": "codCAD" },
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
        /*'buttons': [
                    'excelHtml5',
                    'csvHtml5'
        ],*/
        'buttons':[
            {
            'extend':    'excelHtml5',
            'titleAttr': 'Excel',
            'className': 'btn btn-success'
            },
            {
            'extend':    'csvHtml5',
            'titleAttr': 'Csv',
            'className': 'btn btn-success'
            }, 
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
}


//caracteristica del selectpicker AGREGAR
$('.selectpicker').selectpicker({
    style: 'input input-lg ml-2 btn-outline-dark'
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
    $("#buscarPlanos").on("click", function () {

        //capturar variables

        $idUEN = $('#idUEN').val();
        $idZona = $('#idZona').val();
        $idPlantas = $('#idPlantas').val();
        $idUnidades = $('#idUnidades').val();
        $idEspecialidades = $('#idEspecialidades').val();
        $descripcion = $('#descripcion').val();
        $codCAD = $('#codCAD').val();

        $consulta = '../controller/buscarPlanos.php?'
                    +'idUEN='+$idUEN
                    +'&idZona='+$idZona
                    +'&idPlantas='+$idPlantas
                    +'&idUnidades='+$idUnidades
                    +'&idEspecialidades='+$idEspecialidades
                    +'&descripcion='+$descripcion
                    +'&codCAD='+$codCAD;

        console.log( $consulta );


        //actualiza la url para consultar
        tablita.ajax.url($consulta).load();
    });
}

