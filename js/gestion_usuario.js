$(document).ready(function()
{
    var tipo_usuario= $('#tipo_usuario').val();
    //console.log(tipo_usuario)
   if(tipo_usuario==2)
    {
        $('#button-crear').hide();
    }
    buscar_datos();
    var funcion;
    function buscar_datos(consulta) 
    {
        funcion='buscar_usuarios_adm';
        $.post('../controlador/usuario_controller.php',{consulta, funcion},(Response)=>
        {
            //console.log(Response);
            const usuarios = JSON.parse(Response);
            let template='';
            usuarios.forEach(usuario => {
                template+= `
                <div usuarioId="${usuario.id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch mt-3">
              <div class="card bg-light">`;
              if(usuario.tipo_usuario==1)
              {
                template+=`
                <div class="card-header text-muted border-bottom-0">
                  <h5>Administrador</h5>
                </div>`;
              }
              else
              {
                template+=`
                <div class="card-header text-muted border-bottom-0">
                  <h5>Vendedor</h5>
                </div>`;
                
              }
              template+=`<div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>${usuario.nombre} ${usuario.apellido_pat} ${usuario.apellido_mat} </b></h2>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-card"></i></span> DNI: ${usuario.nombre_usuario}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Correo: ${usuario.correo}</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="../img/avatar5.png" alt="" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">`;
                    if(tipo_usuario==1)
                    {
                        if(usuario.tipo_usuario!=1)
                        {
                            template+=`
                            <button class="borrar-usuario btn btn-outline-danger" type="button" data-toggle="modal" data-target="#confirmar">
                                <i class="fas fa-window-close mr-1"> </i> Eliminar
                            </button> 
                            `;
                        }
                    }
                    else
                    {
                        if(tipo_usuario==2 && usuario.tipo_usuario!=1 && usuario.tipo_usuario!=2)
                        {
                            template+=`
                            <button class="borrar-usuario btn btn-outline -danger" type="button" data-toggle="modal" data-target="#confirmar">
                                <i class="fas fa-window-close mr-1"> </i> Eliminar
                            </button> 
                            `;
                        }
                    }
                    template+=`
                  </div>
                </div>
              </div>
            </div>
                `;
            });
            $('#usuarios').html(template);
        });
    }
    $(document).on('keyup','#buscar',function()
    {
        let valor =$(this).val();
        if(valor!="")
        {
            //console.log(valor);
            buscar_datos(valor); 
        }
        else
        {
            
            //console.log(valor);
            buscar_datos(); 
        }
    });
    $('#form-crear').submit(e=>
    {
        let nombre = $('#nombre').val();
        let apellido_pat = $('#apellido_pat').val();
        let apellido_mat = $('#apellido_mat').val();
        let email = $('#email').val();
        let nombre_usuario = $('#nombre_usuario').val();
        let pass = $('#contrasena').val();
        funcion='crear_usuario';
        $.post('../controlador/usuario_controller.php',{nombre,apellido_pat,apellido_mat,email,nombre_usuario,pass,funcion},(Response)=>{
          //console.log(Response);
          if(Response=='agregado')
          {
              $('#agregado').hide('slow');
              $('#agregado').show(1000);
              $('#agregado').hide(2000);
              $('#form-crear').trigger('reset');
              buscar_datos();
          }
          else
          {
              $('#noagregado').hide('slow');
              $('#noagregado').show(1000);
              $('#noagregado').hide(2000);
              $('#form-crear').trigger('reset');
          }
        });
        e.preventDefault();
    });
    $(document).on('click','.borrar-usuario',(e)=>
    {
      const elemento= $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      //console.log(elemento);
      const id= $(elemento).attr('usuarioId');
      //console.log(id);
      funcion='borrar_usuario';
      $('#id_user').val(id);
      $('#funcion').val(funcion);
    });
    $('#form-confirmar').submit(e=>
    {
      let pass =$('#oldpass').val();
      let id_usuario=$('#id_user').val();
      funcion=$('#funcion').val();
      /*console.log(pass);
      console.log(id_usuario);
      console.log(funcion);*/
      $.post('../controlador/usuario_controller.php',{pass,id_usuario,funcion},(Response)=>
      {
        console.log(Response);
        if(Response=='borrado')
          {
              $('#confirmado').hide('slow');
              $('#confirmado').show(1000);
              $('#confirmado').hide(2000);
              $('#form-confirmar').trigger('reset');
          }
          else
          {
              $('#rechazado').hide('slow');
              $('#rechazado').show(1000);
              $('#rechazado').hide(2000);
              $('#form-confirmar').trigger('reset');
          }
          buscar_datos();
      });
      e.preventDefault();
    })
})