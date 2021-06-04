$(document).ready(function()
{
    buscar_cat();
    var funcion;
    var edit=false;
    $('#form-crear-categoria').submit(e=>
    {   //funcion='crear';
        let nombre_categoria= $('#nombre-categoria').val(); 
        let id_editado= $('#id_editar_cat').val();
        if(edit==false)
        {
            funcion='crear'
        } 
        else
        {
            funcion='editar'
        }
        $.post('../controlador/categoria_controller.php',{nombre_categoria,id_editado,funcion},(Response)=>
        {
            //console.log(Response);
            if(Response=='agregado')
            {
              $('#agregado-categoria').hide('slow');
              $('#agregado-categoria').show(1000);
              $('#agregado-categoria').hide(2000);
              $('#form-crear-categoria').trigger('reset');
              buscar_cat();
            }
            if(Response=='noagregado')
            {
                $('#noagregado-categoria').hide('slow');
                $('#noagregado-categoria').show(1000);
                $('#noagregado-categoria').hide(2000);
                $('#form-crear-categoria').trigger('reset');
            }
            if(Response=='edit')
            {
                $('#edit-cat').hide('slow');
                $('#edit-cat').show(1000);
                $('#edit-cat').hide(2000);
                $('#form-crear-categoria').trigger('reset');
                buscar_cat();
            }
            edit=false;
        });
        e.preventDefault();
    });
    function buscar_cat(consulta)
    {
        funcion='buscar';
        $.post('../controlador/categoria_controller.php',{consulta,funcion},(Response)=>
        {
            //console.log(Response);
            const categorias = JSON.parse(Response);
            let template='';
            categorias.forEach(categoria => 
            {
                template+=`
                    <tr CatId="${categoria.id}" CatNombre="${categoria.nombre}">
                        <td>${categoria.id}</td>
                        <td>${categoria.nombre}</td>
                        <td>
                            <button class="editar btn btn-outline-success" title="Editar cat    egoria" type="button" data-toggle="modal" data-target="#crear-categoria">
                                <i class="fas fa-pencil-alt">
                            </i></button>
                            <button class="eliminar btn btn-outline-danger" title="Eliminar categoria">
                                <i class="fas fa-trash-alt">
                            </i></button>
                        </td>
                    </tr>
                    `;
            });
            $('#categorias').html(template);
        });
    }
    $(document).on('keyup','#buscar-categoria',function(){
        let valor = $(this).val();
        if(valor!="")
        {
            buscar_cat(valor);
        }
        else
        {
            buscar_cat();
        }
    });
    $(document).on('click','.eliminar',(e)=>
    {
        funcion='borrar';
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('CatId');
        const nombre=$(elemento).attr('CatNombre');
        const descripcion=$(elemento).attr('CatDescripcion');
        //console.log(id+nombre+descripcion);
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success mr-1',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            title: 'Desea eliminar '+nombre+'?',
            text: "No podras revertir esta acción!",
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controlador/categoria_controller.php',{id,funcion},(Response)=>
                {
                    edit=false;
                    //console.log(Response);
                    if(Response=='borrado')
                    {
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El categoria '+nombre+' fue eliminado',
                            'success'
                          )
                          buscar_cat();
                    }
                    else
                    {
                        swalWithBootstrapButtons.fire(
                            'No se elimino!',
                            'El categoria '+nombre+' no fue eliminado porque es usado por un producto',
                            'error'
                          ) 
                    }
                });
            } 
            else if (result.dismiss === Swal.DismissReason.cancel) 
            {
              swalWithBootstrapButtons.fire(
                'Cancelar',
                'El categoria '+nombre+' no fue eliminado',
                'error'
              )
            }
          })
    });
    $(document).on('click','.editar',(e)=>
    {
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('CatId');
        const nombre=$(elemento).attr('CatNombre');
        const descripcion=$(elemento).attr('CatDescripcion');

        $('#id_editar_cat').val(id);
        $('#nombre-categoria').val(nombre);
        $('#descripcion').val(descripcion);

        edit=true;

    });

});