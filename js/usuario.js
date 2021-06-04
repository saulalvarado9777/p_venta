$(document).ready(function(){
    var funcion='';
    var edit=false;
    var id_usuario=$('#id_usuario').val();
    buscar_usuario(id_usuario);
    function buscar_usuario(dato) 
    {
        funcion='buscar_usuario'
        $.post('../controlador/usuario_controller.php',{dato,funcion},(Response)=>
        {
            //console.log(Response);
            let nombre ='';
            let apellido_pat ='';
            let apellido_mat ='';
            let nombre_usuario='';
            let email ='';
            const usuario = JSON.parse(Response);
            nombre+=`${usuario.nombre}`;
            apellido_pat+=`${usuario.apellido_pat}`;
            apellido_mat+=`${usuario.apellido_mat}`;
            nombre_usuario+=`${usuario.nombre_usuario}`;
            email+=`${usuario.email}`;


            $('#nombre').html(nombre);
            $('#apellido_pat').html(apellido_pat);
            $('#apellido_mat').html(apellido_mat);
            $('#nombre_usuario').html(nombre_usuario);
            $('#email').html(email);
        });
    }
    /*con esta funcion hace, que cuando, demos click en el boton editar no smande los datos del usuario al
    formulario para editar los datos*/
    $(document).on('click','.edit',(e)=>
    {
        funcion='capturar_datos';
        edit=true;
        $.post('../controlador/usuario_controller.php',{funcion,id_usuario},(Response)=>
        {
            //console.log(Response);
            const usuario = JSON.parse(Response);
            $('#correo').val(usuario.correo);

        })
    });
    $('#form-usuario').submit(e=>{
        if(edit==true)
        {
            let correo=$('#correo').val();
            funcion='editar_usuario';
            $.post('../controlador/usuario_controller.php',{id_usuario,funcion,correo},(Response)=>
            {
                if(Response=='editado')
                {
                    $('#editado').hide('slow');
                    $('#editado').show(1000);
                    $('#editado').hide(2000);
                    $('#form-usuario').trigger('reset');
                }
                edit=false;
                buscar_usuario(id_usuario);
            })
        }
        else
        {
            $('#noeditado').hide('slow');
            $('#noeditado').show(1000);
            $('#noeditado').hide(2000);
            $('#form-usuario').trigger('reset');
        }
        e.preventDefault();
    });
    $('#form-pass').submit(e=>{
        let oldpass=$('#oldpass').val();
        let newpass=$('#newpass').val();
        funcion='cambiar_contra';
        $.post('../controlador/usuario_controller.php',{id_usuario,funcion,oldpass,newpass},(Response)=>
        {
           console.log(Response);
            if(Response=='update')
            {
                $('#update').hide('slow');
                $('#update').show(1000);
                $('#update').hide(2000);
                $('#form-pass').trigger('reset');
            }
            else
            {
                $('#noupdate').hide('slow');
                $('#noupdate').show(1000);
                $('#noupdate').hide(2000);
                $('#form-pass').trigger('reset');
            }
        })
        e.preventDefault();
    })

})