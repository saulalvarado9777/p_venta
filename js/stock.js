$(document).ready(function()
{
    var funcion;
    buscar_lote();
    function buscar_lote(consulta)
    {
        funcion='buscar';
        $.post('../controlador/stock_controller.php',{consulta,funcion},(Response)=>
        {
            //console.log(Response);
            const lotes = JSON.parse(Response);
            let template='';
            lotes.forEach(lote=>
            {   
             template+=`
             <div StockId="${lote.id}" StockLote="${lote.stock}" StockNombre="${lote.nombre}"  StockCategoria="${lote.categoria}" 
             StockProveedor="${lote.proveedor}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch mt-3">
             <div class="card bg-light">
             <div class="card-header text-muted border-bottom-0">
                 <p>Código ${lote.id}</p>
                 <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
             </div>
             <div class="card-body pt-0">
                 <div class="row">
                 <div class="col-7">
                     <h2 class="lead"><b>${lote.nombre}</b></h2>
                     <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-calendar-alt"></i></span>Fecha: ${lote.fecha} </li>
                        <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-truck"></i></span>Proveedor: ${lote.proveedor} </li>
                        <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-folder"></i></span>Categoria: ${lote.categoria}</li>
                     </ul>
                 </div>
                 <div class="col-5 text-center">
                     <img src="../img/avatar5.png" alt="" class="img-circle img-fluid">
                 </div>
                 </div>
             </div>
             <div class="card-footer">
                 <div class="text-right">
                     <button class="editar btn btn-sm bg-success" type="button" data-toggle="modal" data-target="#editarstock">
                         <i class="fas fa-pencil-alt"></i>
                     </button>
                     <button class="eliminar btn btn-sm bg-danger">
                         <i class="fas fa-trash-alt"></i>
                     </button>
                 </div>
             </div>
             </div>
         </div>
                `;
            });
            $('#lotes').html(template);
        });
    }
    $(document).on('keyup','#buscar-stock',function()
    {
        let valor =$(this).val();
        if(valor!="")
        {
            //console.log(valor);
            buscar_lote(valor); 
        }
        else
        {
            
           //console.log(valor);
            buscar_lote(); 
        }
    });
    $(document).on('click','.editar',(e)=>
    {
        const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('StockId');     //estas constantes la traemos del template, dentro del elemento de tr
        const stock=$(elemento).attr('StockLote');
        //console.log(laboratorio+' '+tipo+' '+presentacion);
        $('#id_stock_producto').val(id); //estos identificadores lo traemos del html de productos y ponemos el valo del id del template
        $('#stock').val(stock);
        $('#codigo-stock').html(id);

    });
    $('#form-editar-stock').submit(e=>
        {
            let id = $('#id_stock_producto').val();
            let stock = $('#stock').val();
            funcion='editar';
            $.post('../controlador/stock_controller.php',{id,stock,funcion},(Response)=>
            {
                console.log(Response);
                if(Response=='editar')
                {
                    $('#editar').hide('slow');
                    $('#editar').show(1000);
                    $('#editar').hide(2000);
                    $('#form-editar-stock').trigger('reset');
                }
                buscar_lote();
            });
            e.preventDefault();
        });
    $(document).on('click','.eliminar',(e)=>
    {
            funcion='borrar';
            const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
            const id=$(elemento).attr('StockId');
            //console.log(id+nombre);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success mr-1',
                  cancelButton: 'btn btn-danger mr-1'
                },
                buttonsStyling: false
              })
              
              swalWithBootstrapButtons.fire({
                title: 'Desea eliminar '+id+'?',
                text: "No podras revertir esta acción!",
                showCancelButton: true,
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
              }).then((result) => {
                if (result.value) {
                    $.post('../controlador/stock_controller.php',{id,funcion},(Response)=>
                    {
                        //console.log(Response);
                        if(Response!='borrado')
                        {
                            swalWithBootstrapButtons.fire(
                                'Eliminado!',
                                'El stock '+id+' fue eliminado',
                                'success'
                              )
                              buscar_lote();
                            }
                        else
                        {
                            swalWithBootstrapButtons.fire(
                                'No se elimino!',
                                'El stock '+id+' no fue eliminado, esta siendo usado',
                                'error'
                              ) 
                        }
                    });
                } 
                else if (result.dismiss === Swal.DismissReason.cancel) 
                {
                  swalWithBootstrapButtons.fire(
                    'Cancelar',
                    'El stock'+id+' no fue eliminado',
                    'error'
                  )
                }
              })
        });   
});