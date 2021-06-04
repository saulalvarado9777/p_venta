$(document).ready(function()
{
    buscar_cliente();
    var funcion;
    $('#form-crear').submit(e=>
    {
            let nombre= $('#nombre').val();//asignamos a las nuevas varibles, los datos del html de la vista adm_proveedor
            let correo= $('#correo').val();//los datos son obtenidos del formulario para crear un cliente
            let telefono= $('#telefono').val();
            funcion='crear'   
            $.post('../controlador/cliente_controller.php',{nombre, correo,telefono,funcion},(Response)=>// estos parametros son los de las variables que asignamos del html
            {
                console.log(Response);
                if(Response=='agregado')
                {
                    $('#agregado').hide('slow');
                    $('#agregado').show(1000);
                    $('#agregado').hide(2000);
                    $('#form-crear').trigger('reset');
                    buscar_cliente();
                }
                if(Response=='noeditado')
                {
                    $('#noagregado').hide('slow');
                    $('#noagregado').show(1000);
                    $('#noagregado').hide(2000);
                    $('#form-crear').trigger('reset');
                }
            })
            e.preventDefault();
    });

    function buscar_cliente(consulta) 
    {
        funcion='buscar';
        $.post('../controlador/cliente_controller.php',{consulta,funcion},(Response)=>// estos parametros son los de las variables que asignamos del html
        {
            //console.log(Response);
            const clientes = JSON.parse(Response);
            let template='';
            clientes.forEach(cliente => 
            {
                template+=`
                        <div CliId="${cliente.id}" CliNombre="${cliente.nombre}" CliCorreo="${cliente.correo}" CliTelefono="${cliente.telefono}"
                        class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch mt-3">
                        <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0">
                            <h1 class="badge badge-primary">Cliente</h1>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b>${cliente.nombre}</b></h2>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>Dirección: ${cliente.correo}</li>
                                    <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-phone "></i></span>Teléfono: ${cliente.telefono}</li>

                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <img src="../img/avatar5.png" alt="" class="img-circle img-fluid">
                            </div>  
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button class="editar btn btn-sm bg-success" type="button" data-toggle="modal" data-target="#editarcliente">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>

                                <button class="eliminar btn btn-sm bg-danger" title="borrar cliente">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        </div>
                    </div>
                    `;
            });
            $('#clientes').html(template);
        });
    }
    $(document).on('keyup','#buscar_cliente',function()
    {
        let valor =$(this).val();
        if(valor!='')
        {
            buscar_cliente(valor);
        }
        else
        {
            buscar_cliente();
        }
    });
    $(document).on('click','.editar',(e)=>{
        const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        console.log(elemento);
        let correo =$(elemento).attr('CliCorreo');//el attr srive para seleccioner un atributo el trabuoito lo taremos del template
        let telefono =$(elemento).attr('CliTelefono');//el attr srive para seleccioner un atributo el trabuoito lo taremos del template
        let id =$(elemento).attr('CliId');//el attr srive para seleccioner un atributo el trabuoito lo taremos del template
//      //depues de yatener los datos alojados los tenemos que mandar al modal con el siguiente codigo
        $('#correo_edit').val(correo); //mandamos el atributo correo al input de correo en el formulario
        $('#telefono_edit').val(telefono);
        $('#id_cliente').val(id);
    })
    $('#form-editar').submit(e=>
    {
                let id= $('#id_cliente').val();//asi obtenemos el contenido de los inputs del formulario
                let correo= $('#correo_edit').val();//asi obtenemos el contenido de los inputs del formulario
                let telefono= $('#telefono_edit').val();
                funcion='editar'   
                $.post('../controlador/cliente_controller.php',{id,correo,telefono,funcion},(Response)=>// estos parametros son los de las variables que asignamos del html
                {
                    console.log(Response);
                    //console.log(nombre+correo+telefono);
                    if(Response=='editado')
                    {
                        $('#editado').hide('slow');
                        $('#editado').show(1000);
                        $('#editado').hide(2000);
                        $('#form-editar').trigger('reset');
                        buscar_cliente();
                    }
                    if(Response=='noeditado')
                    {
                        $('#noeditado').hide('slow');
                        $('#noeditado').show(1000);
                        $('#noeditado').hide(2000);
                        $('#form-editar').trigger('reset');
                    }
                })
                e.preventDefault();
        });
        $(document).on('click','.eliminar',(e)=>
        {
        funcion='borrar';
        let elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        let id=$(elemento).attr('CliId');
        let nombre=$(elemento).attr('CliNombre');
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
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controlador/cliente_controller.php',{id,funcion},(Response)=>
                {
                    //edit=false;
                    //console.log(Response);
                    if(Response=='borrado')
                    {
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El cliente '+nombre+' fue eliminado',
                            'success'
                          )
                          buscar_cliente();
                    }
                    else
                    {
                        swalWithBootstrapButtons.fire(
                            'No se elimino!',
                            'El cliente '+nombre+' no fue eliminado esta disponible en stock',
                            'error'
                          ) 
                    }
                });
            } 
            else if (result.dismiss === Swal.DismissReason.cancel) 
            {
              swalWithBootstrapButtons.fire(
                'Cancelar',
                'El proveedor '+nombre+' no fue eliminado',
                'error'
              )
            }
          })
    });
})