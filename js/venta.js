$(document).ready(function(){
    mostrar_consultas();
    listar_ventas();
    var datatable;
    function mostrar_consultas()
    {
      let funcion='mostrar_consultas';
      $.post('../controlador/ventas_controller.php',{funcion},(Response)=>//peticion ajax de jquery
      {
        //console.log(Response);
        const vistas = JSON.parse(Response);
        $('#venta_dia_vendedor').html((vistas.venta_dia_vendedor*1).toFixed(2));//agregamos la funcion tofixed para que solo me muestre los valores con dos decimales
        $('#venta_diaria').html((vistas.venta_diaria*1).toFixed(2));//los valores que tiene vistas.diaria son cadenas
        $('#venta_mensual').html((vistas.venta_mensual*1).toFixed(2));//y para convertilas a numero,
        $('#venta_anual').html((vistas.venta_anual*1).toFixed(2));//multiplicamos por uno
        $('#venta_anual').html((vistas.venta_anual*1).toFixed(2));//multiplicamos por uno
      });
    }
    function listar_ventas() {
      funcion='listar';
      datatable = $('#tabla_ventas').DataTable( {
          "ajax": {
              "url":"../controlador/ventas_controller.php",
              "method":"POST",
              "data":{funcion:funcion}
          },
          "columns": [
              { "data": "id_ventas" },
              { "data": "cliente" },
              { "data": "total" },
              { "data": "vendedor" },
              { "data": "fecha"},
              { "defaultContent":`<button class="imprimir btn btn-outline-secondary"><i class="fas fa-print"></i></button>
                                  <button class="ver btn btn-outline-success" type="button" data-toggle="modal" data-target="#vista_venta"><i class="fas fa-search"></i></button>
                                  <button class="borrar btn btn-outline-danger"><i class="fas fa-window-close"></i></button>`}
          ],
          "destroy":true,
          "language": espanol
      } );
    }

    $('#tabla_ventas tbody').on('click','.ver',function(){
        let datos=datatable.row($(this).parents()).data();
        let id=datos.id_ventas;
        funcion="ver";
        $('#codigo_venta').html(datos.id_ventas);
        $('#cliente').html(datos.cliente);
        $('#total').html(datos.total);
        $('#vendedor').html(datos.vendedor);
        $('#fecha').html(datos.fecha);
        //$('#dni').html(datos.dni);
        $.post('../controlador/ventaproducto_controller.php',{funcion,id},(Response)=>
        {
            //console.log(Response);
            let registros =JSON.parse(Response);
            let template="";
            $('#registros').html(template);
            registros.forEach(registro => {
                template+=`
                <tr>
                    <td>${registro.cantidad}</td>
                    <td>${registro.pre_out}</td>
                    <td>${registro.producto}</td>
                    <td>${registro.unidad}</td>
                    <td>${registro.presentacion}</td>
                    <td>${registro.categoria}</td>
                    <td>${registro.subtotal}</td>
                </tr>
                `;
                $('#registros').html(template);
            });
        });
    })
    $('#tabla_ventas tbody').on('click','.borrar',function(){
        let datos=datatable.row($(this).parents()).data();
        let id=datos.id_ventas;
        funcion="borrar_venta";
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success m-1',
              cancelButton: 'btn btn-danger m-1'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            title: 'Esta seguro que desea eliminar la venta: '+id+'?',
            text: "No podras revertir la acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, borra esto!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/detalle_venta_controller.php',{funcion,id},(Response)=>{
                    //console.log(Response);
                    if(Response=='delete')
                    {
                      swalWithBootstrapButtons.fire(
                        'Eliminado!',
                        'La venta: '+id+' ha sido eliminada.',
                        'success'
                      ) 
                      listar_ventas();
                    }
                    else if(Response=='nodelete')
                    {
                      swalWithBootstrapButtons.fire(
                        'No eliminado',
                        'No puede eliminar esta venta:)',
                        'error'
                      )
                    }
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) 
            {
              swalWithBootstrapButtons.fire(
                'No eliminado',
                'La venta no se elimino :)',
                'error'
              )
            }
          })
        
    })
    $('#tabla_ventas tbody').on('click','.imprimir',function(){
      let datos=datatable.row($(this).parents()).data();
      let id=datos.id_ventas;
      //console.log(id);
      $.post('../controlador/pdf_controller.php',{id},(Response)=>{
        console.log(Response);
        window.open('../pdf/pdf-'+id+'.pdf','_blank');
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