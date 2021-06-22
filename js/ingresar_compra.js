$(document).ready(function() {
    $('.select2').select2();
    obtener_productos();
    obtener_estado();
    llenar_proveedores();
    var prods=[];
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function obtener_productos() {//la funcion manda a traes lo productos, para mostrarlos en el selec2
        funcion='obtener_productos';
        $.post('../controlador/producto_controller.php',{funcion},(Response)=>
        {
            //console.log(Response);
            const productos = JSON.parse(Response);
            let template='';
            productos.forEach(producto => {
                template+=`
                <option value="${producto.nombre}">${producto.nombre}</option>
                `;
            });
            $('#producto_select').html(template);//es el identificador en el html del select en la vista adm_catalogo
        })
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function llenar_proveedores() {//la funcion manda a traes lo productos, para mostrarlos en el selec2
    funcion='llenar_proveedores';
    $.post('../controlador/proveedor_controller.php',{funcion},(Response)=>
    {
        //console.log(Response);
        const proveedores = JSON.parse(Response);
        let template='';
        proveedores.forEach(proveedor => {
            template+=`
            <option value="${proveedor.id}">${proveedor.nombre}</option>
            `;
        });
        $('#proveedor').html(template);//es el identificador en el html del select en la vista adm_catalogo
    })
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
            $('#estado').html(template);//es el identificador en el html del select en la vista adm_catalogo
        })
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click','.agregar-producto',(e)=>{
        let producto_select2=$('#producto_select').val();
        let codigo_stock=$('#codigo_lote').val();
        let cantidad=$('#cantidad').val();
        let precio_compra=$('#precio_compra').val();
        if(producto_select2==null)
        {
            $('#error').text('Elija un producto!')
            $('#noadd-prod').hide('slow');
            $('#noadd-prod').show(1000);
            $('#noadd-prod').hide(2000);
        }
        else
        {
            if(codigo_stock=='')
            {
                $('#error').text('Ingrese un código!')
                $('#noadd-prod').hide('slow');
                $('#noadd-prod').show(1000);
                $('#noadd-prod').hide(2000);
            }
            else
            {
                if(cantidad=='')
                {
                    $('#error').text('Ingrese una cantidad!')
                    $('#noadd-prod').hide('slow');
                    $('#noadd-prod').show(1000);
                    $('#noadd-prod').hide(2000);
                }
                else
                {
                    if(precio_compra=='')
                    {
                        $('#error').text('Ingrese un precio de compra!')
                        $('#noadd-prod').hide('slow');
                        $('#noadd-prod').show(1000);
                        $('#noadd-prod').hide(2000);
                    }
                    else
                    {
                        let producto_array=producto_select2.split('|');//en este split guardamos todo lo que tremos del select2
                        //console.log(producto_array);
                        let producto ={
                            id: producto_array['0'],
                            nombre: producto_select2,
                            codigo: codigo_stock,
                            cantidad: cantidad,
                            precio_compra:precio_compra
                        }
                        prods.push(producto);
                        let template='';
                        template=`
                            <tr prodId="${producto.id}">
                                <td>${producto.nombre}</td>
                                <td>${producto.codigo}</td>
                                <td>${producto.cantidad}</td>
                                <td>${producto.precio_compra}</td>
                                <td><button class="borrar-producto btn btn-outline-danger"><i class="fas fa-times-circle"></i></button></td>
                            </tr>
                        `;
                        $('#registros_compra').append(template);
                        $('#add-prod').hide('slow');
                        $('#add-prod').show(1000);
                        $('#add-prod').hide(2000);
                        $('#producto_select').val('').trigger('change');//sirve para vaciar los input    
                        $('#codigo_lote').val('');
                        $('#cantidad').val('');//pone en vacio los imput 
                        $('#precio_compra').val('');
                    }
                }
            }
        }
    });
    $(document).on('click','.borrar-producto',(e)=>{
        //console.log(prods);
        let elemento=$(this)[0].activeElement.parentElement.parentElement;
        let id=$(elemento).attr('prodId');
        prods.forEach(function (prod,index) {
            /*console.log(index);
            console.log(prod);*/
            if(prod.id==id)//accedoa todos lo productos y si es igaul al id
            {
                prods.splice(index,1); //voy a ese producto con index, y que lo elimine 
            }
        })
        //console.log(id);
        //console.log(elemento);
        elemento.remove();//removemos la fila de la lista de los productos
    });
    $(document).on('click','.crear-compra',(e)=>{
        let codigo=$('#codigo').val();
        let fecha_compra=$('#fecha_compra').val();
        let fecha_entrega=$('#fecha_entrega').val();
        let total=$('#total').val();
        let estado=$('#estado').val();
        let proveedor=$('#proveedor').val();
        if(codigo=='')
        {
            $('#error-compra').text('Ingrese un código!')
            $('#noadd-compra').hide('slow');
            $('#noadd-compra').show(1000);
            $('#noadd-compra').hide(2000);
        }
        else
        {
            if(fecha_compra=='')
            {
                $('#error-compra').text('Ingrese una fecha de compra!')
                $('#noadd-compra').hide('slow');
                $('#noadd-compra').show(1000);
                $('#noadd-compra').hide(2000);
            }
            else
            {
                if(fecha_entrega=='')
                {
                    $('#error-compra').text('Ingrese una fecha de entrega!')
                    $('#noadd-compra').hide('slow');
                    $('#noadd-compra').show(1000);
                    $('#noadd-compra').hide(2000);
                }
                else
                {
                    if(total=='')
                    {
                        $('#error-compra').text('Ingrese total de la compra!')
                        $('#noadd-compra').hide('slow');
                        $('#noadd-compra').show(1000);
                        $('#noadd-compra').hide(2000);
                    }
                    else
                    {
                        if(estado==null)
                        {
                            $('#error-compra').text('Ingrese el estado de la compra!')
                            $('#noadd-compra').hide('slow');
                            $('#noadd-compra').show(1000);
                            $('#noadd-compra').hide(2000);
                        }
                        else
                        {
                            if(proveedor=='')
                            {
                                $('#error-compra').text('Ingrese el proveedor de la compra!')
                                $('#noadd-compra').hide('slow');
                                $('#noadd-compra').show(1000);
                                $('#noadd-compra').hide(2000);
                            }
                            else
                            {
                                if(prods=='')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No hay productos agregados!',
                                      })
                                }
                                else
                                {
                                    let descripcion={
                                        codigo: codigo,
                                        fecha_compra:fecha_compra,
                                        fecha_entrega:fecha_entrega,
                                        total:total,
                                        estado:estado,
                                        proveedor:proveedor
                                    }
                                    funcion='registrar_compra'
                                    let productos_String=JSON.stringify(prods);
                                    let descripcion_String=JSON.stringify(descripcion);
                                    $.post('../controlador/compras_controller.php',{funcion,productos_String,descripcion_String},(Response)=>{
                                        console.log(Response);
                                        if(Response=='agregado')
                                        {
                                            //insertar registros en la base de datos 
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: 'Se realizo la compra',
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(function()
                                            {
                                                location.href='../Vistas/adm_compras.php'
                                            })
                                        }
                                        else
                                        {
                                           Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Error en el servidor!',
                                            })
                                        }
                                    });

                                    
                                }
                            }
                        }
                    }
                }
            }
        }




    });

})