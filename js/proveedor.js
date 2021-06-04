$(document).ready(function()
{
    var funcion;
    var edit=false;
    buscar_prov();
    $('#form-crear').submit(e=>
    {
        let id= $('#id_edit_prov').val();
        let nombre= $('#nombre').val();//asignamos a las nuevas varibles, los datos del html de la vista adm_proveedor
        let telefono= $('#telefono').val();
        let correo= $('#correo').val();
        let direccion= $('#direccion').val();
        //funcion='crear'
        if(edit==true)
        {
            funcion='editar';
        }
        else
        {
            funcion='crear';
        }
         $.post('../controlador/proveedor_controller.php',{id,nombre,telefono,correo,direccion,funcion},(Response)=>// estos parametros son los de las variables que asignamos del html
         {
            //console.log(Response);
            if(Response=='agregado')
            {
                $('#agregado').hide('slow');
                $('#agregado').show(1000);
                $('#agregado').hide(2000);
                $('#form-crear').trigger('reset');
                buscar_prov();
            }
            if(Response=='noagregado' || Response=='noeditado')
            {
                $('#noagregado').hide('slow');
                $('#noagregado').show(1000);
                $('#noagregado').hide(2000);
                $('#form-crear').trigger('reset');
            }
            if(Response=='editado')
            {
                $('#edit').hide('slow');
                $('#edit').show(1000);
                $('#edit').hide(2000);
                $('#form-crear').trigger('reset');
                buscar_prov()
            }
            edit=false;
         });    
         e.preventDefault();
    });
    function buscar_prov(consulta) 
    {
        funcion='buscar';
        $.post('../controlador/proveedor_controller.php',{consulta,funcion},(Response)=>// estos parametros son los de las variables que asignamos del html
        {
            //  console.log(Response);
            const proveedores = JSON.parse(Response);
            let template='';
            proveedores.forEach(proveedor => 
            {
                template+=`
                        <div ProvId="${proveedor.id}" ProvNombre="${proveedor.nombre}" ProvTelefono="${proveedor.telefono}" ProvCorreo="${proveedor.correo}"
                        ProvDireccion="${proveedor.direccion}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch mt-3">
                        <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0">
                            <h1 class="badge badge-primary">Proveedor</h1>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b>${proveedor.nombre}</b></h2>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>Telefóno: ${proveedor.telefono} </li>
                                    <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span>Correo: ${proveedor.correo} </li>
                                    <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>Dirección: ${proveedor.direccion}</li>
                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <img src="../img/avatar5.png" alt="" class="img-circle img-fluid">
                            </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button class="editar btn btn-sm bg-success" type="button" data-toggle="modal" data-target="#crearproveedor">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="stock btn btn-sm bg-primary">
                                    <i class="fas fa-plus-square"></i>
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
            $('#proveedores').html(template);   
        });
    }
    $(document).on('keyup','#buscar_proveedor',function()
    {
        let valor =$(this).val();
        if(valor!='')
        {
            buscar_prov(valor);
        }
        else
        {
            buscar_prov();
        }
    });
    $(document).on('click','.eliminar',(e)=>
    {
        funcion='borrar';
        const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('ProvId');
        const nombre=$(elemento).attr('ProvNombre');
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
                $.post('../controlador/proveedor_controller.php',{id,funcion},(Response)=>
                {
                    //edit=false;
                    //console.log(Response);
                    if(Response=='borrado')
                    {
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El proveedor '+nombre+' fue eliminado',
                            'success'
                          )
                          buscar_prov();
                    }
                    else
                    {
                        swalWithBootstrapButtons.fire(
                            'No se elimino!',
                            'El proveedor '+nombre+' no fue eliminado esta disponible en stock',
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
    $(document).on('click','.editar',(e)=>
    {
        const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('ProvId');     //estas constantes la traemos del template, dentro del elemento de tr
        const nombre=$(elemento).attr('ProvNombre');
        const telefono=$(elemento).attr('ProvTelefono');
        const correo=$(elemento).attr('ProvCorreo');
        const direccion=$(elemento).attr('ProvDireccion');
        //console.log(laboratorio+' '+tipo+' '+presentacion);
        $('#id_edit_prov').val(id); //estos identificadores lo traemos del html de proveedrores y ponemos el valo del id del template
        $('#nombre').val(nombre);
        $('#telefono').val(telefono);
        $('#correo').val(correo);
        $('#direccion').val(direccion);
        edit=true;

    });
});