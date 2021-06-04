$(document).ready(function()
{
    buscar_tipo();
    var funcion;
    var edit=false;
    $('#form-crear-tipo').submit(e=>
    {
        let nombre_tipo= $('#nombre-tipo').val(); 
        let id_editado= $('#id_editar_tip').val();
        if(edit==false)
        {
            funcion='crear'
        } 
        else
        {
            funcion='editar'
        }
        $.post('../controlador/tipo_controller.php',{nombre_tipo,id_editado,funcion},(Response)=>
        {
            //console.log(Response);
            if(Response=='agregado')
            {
              $('#agregado-tipo').hide('slow');
              $('#agregado-tipo').show(1000);
              $('#agregado-tipo').hide(2000);
              $('#form-crear-tipo').trigger('reset');
              buscar_tipo();
            }
            if(Response=='noagregado')
            {
                $('#noagregado-tipo').hide('slow');
                $('#noagregado-tipo').show(1000);
                $('#noagregado-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
            }
            if(Response=='edit')
            {
                $('#edit-tipo').hide('slow');
                $('#edit-tipo').show(1000);
                $('#edit-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tipo();
            }
            edit=false;
        });
        e.preventDefault();
    });
    function buscar_tipo(consulta)
    {
        funcion='buscar';
        $.post('../controlador/tipo_controller.php',{consulta,funcion},(Response)=>
        {
            //console.log(Response);
            const tipos = JSON.parse(Response);
            let template='';
            tipos.forEach(tipo => 
            {
                template+=`
                    <tr tipId="${tipo.id}" tipNombre="${tipo.nombre}">
                        <td>${tipo.nombre}</td>
                        <td>
                            <button class="editar-tip btn btn-success" title="Editar laboratorio" type="button" data-toggle="modal" data-target="#crear-tipo">
                                <i class="fas fa-pencil-alt">
                            </i></button>
                            <button class="eliminar-tip btn btn-danger" title="Eliminar laboratorio">
                                <i class="fas fa-trash-alt">
                            </i></button>
                        </td>
                    </tr>
                    `;
            });
            $('#tipos').html(template);
        });
    }
    $(document).on('keyup','#buscar-tipo',function(){
        let valor = $(this).val();
        if(valor!="")
        {
            buscar_tipo(valor);
        }
        else
        {
            buscar_tipo();
        }
    });
    $(document).on('click','.eliminar-tip',(e)=>
    {
        funcion='borrar';
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('tipId');
        const nombre=$(elemento).attr('tipNombre');
        //console.log(id+nombre);
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
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controlador/tipo_controller.php',{id,funcion},(Response)=>
                {
                    edit=false;
                    //console.log(Response);
                    if(Response=='borrado')
                    {
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El tipo '+nombre+' fue eliminado',
                            'success'
                          )
                          buscar_tipo();
                    }
                    else
                    {
                        swalWithBootstrapButtons.fire(
                            'No se elimino!',
                            'El tipo '+nombre+' no fue eliminado porque es usado por un producto',
                            'error'
                          ) 
                    }
                });
            } 
            else if (result.dismiss === Swal.DismissReason.cancel) 
            {
              swalWithBootstrapButtons.fire(
                'Cancelar',
                'El tipo '+nombre+' no fue eliminado',
                'error'
              )
            }
          })
    });
    $(document).on('click','.editar-tip',(e)=>
    {
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('tipId');
        const nombre=$(elemento).attr('tipNombre');
        $('#id_editar_tip').val(id);
        $('#nombre-tipo').val(nombre);
        edit=true;

    });
});