$(document).ready(function () {
    listar_compras();
    $('.select2').select2();
    obtener_estado();
    var datatable;
    function obtener_estado() {//la funcion manda a traes lo productos, para mostrarlos en el selec2
        funcion='obtener_estado';
        $.post('../controlador/estado_controller.php',{funcion},(Response)=>
        {
            //console.log(Response);
            const estados = JSON.parse(Response);
            let template='';
            estados.forEach(estado => {
                template+=`
                <option value="${estado.id}">${estado.nombre}</option>
                `;
            });
            $('#estado_compra').html(template);//es el identificador en el html del select en la vista adm_catalogo
        })
    }
    function listar_compras() {
        funcion='listar_compras';
        $.post('../controlador/compras_controller.php',{funcion},(Response)=>{
            //console.log(Response);
            let datos= JSON.parse(Response);
            datatable = $('#compras').DataTable( {
                data: datos, 
                "columns": [
                    { "data": "numeracion" },
                    { "data": "codigo" },
                    { "data": "fecha_compra" },
                    { "data": "fecha_entrega" },
                    { "data": "total"},
                    { "data": "estado"},
                    { "data": "proveedor"},
                    { "defaultContent":`<button class="imprimir btn btn-outline-secondary"><i class="fas fa-print"></i></button>
                                        <button class="ver btn btn-outline-success" type="button" data-toggle="modal" data-target="#vista_compra"><i class="fas fa-search"></i></button>
                                        <button class="editar btn btn-outline-warning" type="button" data-toggle="modal" data-target="#cambiar_estado"><i class="fas fa-pencil-alt"></i></button>`}
                ],
                "destroy":true,
                "language": espanol
            } );

        });
    }
    $('#compras tbody').on('click','.editar', function() {
        let datos=datatable.row($(this).parents()).data();
        let codigo=datos.codigo;
        //console.log(codigo);
        codigo= codigo.split('|');
        let id=codigo[0];
        let estado=datos.estado;
        funcion='cambiar_estado';
        //console.log(id);
        $('#id_compra').val(id);
        $.post('../controlador/estado_controller.php',{funcion,estado},(Response)=>
        {
            let id_estado=JSON.parse(Response);
            $('#estado_compra').val(id_estado[0]['id']).trigger('change');
        });
    });
    $('#form-editar').submit(e =>{
        let id_compra=$('#id_compra').val();
        let id_estado=$('#estado_compra').val();
        funcion='editar_estado';
        $.post('../controlador/compras_controller.php',{funcion,id_compra,id_estado},(Response)=>
        {
            console.log(Response);
            if(Response=='edit')
            {
                $('#form-editar').trigger('reset');
                $('#estado_compra').val('').trigger('change');
                $('#edit').hide('slow');
                $('#edit').show(1000);
                $('#edit').hide(2000);
                listar_compras();
            }
            else
            {
                $('#noedit').hide('slow');
                $('#noedit').show(1000);
                $('#noedit').hide(2000);
            }
        });
        e.preventDefault();
    })
    $('#compras tbody').on('click','.ver',function(){
        let datos=datatable.row($(this).parents()).data();
        let codigo=datos.codigo;
        //console.log(codigo);
        codigo= codigo.split('|');
        let id=codigo[0];
        funcion="ver";
        $('#codigo_compra').html(datos.codigo);
        $('#fecha_compra').html(datos.fecha_compra);
        $('#fecha_entrega').html(datos.fecha_entrega);
        $('#estado').html(datos.estado);
        $('#proveedor').html(datos.proveedor);
        $('#total').html(datos.total);
        $.post('../controlador/stock_controller.php',{funcion,id},(Response)=>
        {
            //console.log(Response);
            let registros =JSON.parse(Response);
            let template="";
            $('#detalles').html(template);
            registros.forEach(registro => {
                template+=`
                <tr>
                    <td>${registro.numeracion}</td>
                    <td>${registro.codigo}</td>
                    <td>${registro.cantidad}</td>
                    <td>${registro.precio_compra}</td>
                    <td>${registro.producto}</td>
                    <td>${registro.categoria}</td>
                </tr>
                `;
                $('#detalles').html(template);
            });
        });
    })
    $('#compras tbody').on('click','.imprimir',function(){
        let datos=datatable.row($(this).parents()).data();
        let codigo=datos.codigo;
        codigo= codigo.split('|');
        let id=codigo[0];
        funcion='imprimir';
        $.post('../controlador/compras_controller.php',{id,funcion},(Response)=>{
          console.log(Response);
          window.open('../pdf_compra/pdf-compra-'+id+'.pdf','_blank');
        });
      });
});
let espanol={
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad"
    }
};