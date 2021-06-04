$(document).ready(function()
{
    var funcion;
    var edit=false;
    $('.select2').select2(); //para activar la libreria select2
    buscar_producto();
    llenar_categorias();
    llenar_proveedores();
    function llenar_categorias() //muestra los valores de la tabla laboratorios con el select2
    {
        funcion='llenar_categorias';
        $.post('../controlador/categoria_controller.php',{funcion},(Response)=>
        {
            //console.log(Response);
            const categorias = JSON.parse(Response);
            let template='';
            categorias.forEach(categoria => {
                template+=`
                <option value="${categoria.id}">${categoria.nombre}</option>
                `;
            });
            $('#categoria').html(template);
        })
    }
    function llenar_proveedores() //muestra los valores de la tabla laboratorios con el select2
    {
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
            $('#proveedor').html(template);
        })
    }
    /*function llenar_laboratorios() //muestra los valores de la tabla laboratorios con el select2
    {
        funcion='llenar_laboratorios';
        $.post('../controlador/laboratorio_controller.php',{funcion},(Response)=>
        {
            //console.log(Response);
            const laboratorios = JSON.parse(Response);
            let template='';
            laboratorios.forEach(laboratorio => {
                template+=`
                <option value="${laboratorio.id}">${laboratorio.nombre}</option>
                `;
            });
            $('#laboratorio').html(template);
        })
    }
    function llenar_tipos() //muestra los valosres de la tabla tipos con el select2
    {
        funcion='llenar_tipos';
        $.post('../controlador/tipo_controller.php',{funcion},(Response)=>
        {
            //console.log(Response);
            const tipos = JSON.parse(Response);
            let template='';
            tipos.forEach(tipo => {
                template+=`
                <option value="${tipo.id}">${tipo.nombre}</option>
                `;
            });
            $('#tipo').html(template);
        })
    }
    function llenar_presentaciones() //muestra los valores de la tabla presentacion con el select2
    {
        funcion='llenar_presentaciones';
        $.post('../controlador/presentacion_controller.php',{funcion},(Response)=>
        {
            //console.log(Response);
            const presentaciones = JSON.parse(Response);
            let template='';
            presentaciones.forEach(presentacion => {
                template+=`
                <option value="${presentacion.id}">${presentacion.nombre}</option>
                `;
            });
            $('#presentacion').html(template);
        })
    }*/
    $('#form-crear-producto').submit(e=> //obtine los valores del formulario crear productos
    {
        let id =$('#id_edit_producto').val();
        let codigo=$('#codigo').val();
        let nombre =$('#nombre_producto').val(); //obtine los valores del formulario crear del html
        let inventario_min =$('#inventario_min').val();
        let precio_in =$('#precio_in').val();
        let precio_out =$('#precio_out').val();
        let presentacion =$('#presentacion').val();
        let unidad =$('#unidad').val();
        let categoria =$('#categoria').val();
        //console.log(nombre+""+inventario_min+""+precio_in+""+precio_out+""+presentacion+""+unidad+""+categoria)
        //funcion='crear';
        if(edit==true)
        {
            funcion="editar";
        }
        else
        {
            funcion="crear";
        }
        $.post('../controlador/producto_controller.php',{funcion,id, codigo, nombre, inventario_min, precio_in,precio_out, presentacion, unidad, categoria},(Response)=>
        {
            console.log(Response);
            if(Response=='agregado')
            {
                $('#agregado').hide('slow');
                $('#agregado').show(1000);
                $('#agregado').hide(2000);
                $('#form-crear-producto').trigger('reset');
                $('#categoria').val('').trigger('change');
                buscar_producto();
            }
            if(Response=='editado')
            {
                $('#editado').hide('slow');
                $('#editado').show(1000);
                $('#editado').hide(2000);
                $('#form-crear-producto').trigger('reset');
                $('#categoria').val('').trigger('change');
                buscar_producto();
            }
            if(Response=='noagregado'|| Response=='noeditado')
            {
                $('#noagregado').hide('slow');
                $('#noagregado').show(1000);
                $('#noagregado').hide(2000);
                $('#form-crear-producto').trigger('reset');
            }
            /*if(Response=='noeditado')
            {
                $('#noagregar-stock').hide('slow');
                $('#noagregar-stock').show(1000);
                $('#noagregar-stock').hide(2000);
                $('#form-crear-producto').trigger('reset');
            }
            edit=false;*/
        });
        e.preventDefault();
    })
    function buscar_producto(consulta)
    {
        funcion='buscar';
        $.post('../controlador/producto_controller.php',{consulta,funcion},(Response)=>
        {
            console.log(Response);
            const productos = JSON.parse(Response);
            let template='';
            productos.forEach(producto=>
            {   
             template+=`
                        <div ProdId="${producto.id}" ProdCodigo="${producto.codigo}" ProdNombre="${producto.nombre}" ProdInventario_min="${producto.inventario_min}" 
                        ProdPrecio_in="${producto.precio_in}" ProdPrecio_out="${producto.precio_out}" ProdStock="${producto.stock}" ProdPresentacion="${producto.presentacion}" ProdUnidad="${producto.unidad}" 
                        ProdId_categoria="${producto.categoria_id}"  class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch mt-3">
                        <div class="card bg-${producto.estado}">
                        <div class="card-header text-muted border-bottom-0">
                            <i class="fas fa-lg fa-cubes mr-1"></i>${producto.stock}
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b>${producto.nombre}</b></h2>
                                <h2 class="lead mt-3"><b><i class="fas fa-lg fa-dollar-sign mr-1"></i>${producto.precio_out}</b></h2>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-boxes"></i></span>Inventario_min: ${producto.inventario_min} </li>
                                    <li class="small mt-3"><span class="fa-li"><i class="fas fa-lg fa-folder"></i></span>Categoria: ${producto.categoria}</li>
                                    <li class="small mt-3"><span class="fa-li"><i class="fas fa-barcode"></i></span>Código: ${producto.codigo}</li>

                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <img src="../img/avatar5.png" alt="" class="img-circle img-fluid">
                            </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button class="editar btn btn-sm bg-success" type="button" data-toggle="modal" data-target="#crearproducto">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="stock btn btn-sm bg-primary" type="button" data-toggle="modal" data-target="#crearstock">
                                    <i class="fas fa-plus-square"></i>
                                </button>
                                <button class="eliminar btn btn-sm bg-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        </div>
                    </div> `;
            });
            $('#productos').html(template);
        });
    }
    $(document).on('keyup','#buscar-producto',function()
    {
        let valor =$(this).val();
        if(valor!="")
        {
            //console.log(valor);
            buscar_producto(valor); 
        }
        else
        {
            
           //console.log(valor);
            buscar_producto(); 
        }
    })
    $(document).on('click','.eliminar',(e)=>
    {
        funcion='borrar';
        const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('ProdId');
        const nombre=$(elemento).attr('ProdNombre');
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
                $.post('../controlador/producto_controller.php',{id,funcion},(Response)=>
                {
                    console.log(Response);
                    edit=false;
                    //console.log(Response);
                    if(Response=='borrado')
                    {
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El producto '+nombre+' fue eliminado',
                            'success'
                          )
                          buscar_producto();
                    }
                    else
                    {
                        swalWithBootstrapButtons.fire(
                            'No se elimino!',
                            'El producto '+nombre+' no fue eliminado porque tiene stock disponible',
                            'error'
                          ) 
                    }
                });
            } 
            else if (result.dismiss === Swal.DismissReason.cancel) 
            {
              swalWithBootstrapButtons.fire(
                'Cancelar',
                'El producto '+nombre+' no fue eliminado',
                'error'
              )
            }
          })
    });
    $(document).on('click','.editar',(e)=>
    {
        const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id_productos=$(elemento).attr('ProdId');     //estas constantes la traemos del template, dentro del elemento de tr
        const codigo=$(elemento).attr('ProdCodigo'); 
        const nombre=$(elemento).attr('ProdNombre');
        const inventario_min=$(elemento).attr('ProdInventario_min');
        const precio_in=$(elemento).attr('ProdPrecio_in');
        const precio_out=$(elemento).attr('ProdPrecio_out');
        const presentacion=$(elemento).attr('ProdPresentacion');
        const unidad=$(elemento).attr('ProdUnidad');
        const id_categoria=$(elemento).attr('ProdId_categoria');
        //console.log(id_categoria+' '+id_productos+' '+nombre);

        $('#id_edit_producto').val(id_productos); //estos identificadores lo traemos del html de productos y ponemos el valo del id del template
        $('#codigo').val(codigo);
        $('#nombre_producto').val(nombre);
        $('#inventario_min').val(inventario_min);
        $('#precio_in').val(precio_in);
        $('#precio_out').val(precio_out);
        $('#presentacion').val(presentacion);
        $('#unidad').val(unidad);
        $('#categoria').val(id_categoria).trigger('change');
        edit=true;
    });
    $(document).on('click','.stock',(e)=>
    {
        const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('ProdId');     //estas constantes la traemos del template, dentro del elemento de tr
        const nombre=$(elemento).attr('ProdNombre');
        $('#id_stock_producto').val(id); //estos identificadores lo traemos del html de productos y ponemos el valo del id del template
        $('#nombre_producto_stock').html(nombre);
    });
    $('#form-crear-stock').submit(e=>
    {
        let id_producto=$('#id_stock_producto').val();
        let proveedor=$('#proveedor').val();
        let stock=$('#stock').val();
        funcion='crear';
        $.post('../controlador/stock_controller.php',{funcion,id_producto,proveedor,stock,},(Response)=>
        {
                //console.log(Response);
                $('#agregar-stock').hide('slow');
                $('#agregar-stock').show(1000);
                $('#agregar-stock').hide(2000);
                $('#form-crear-stock').trigger('reset');
                buscar_producto();
        });
    });
    $(document).on('click','#button-reporte',(e)=>{
        funcion='reporte_productos';
        //console.log(funcion);
        $.post('../controlador/producto_controller.php',{funcion},(Response)=>
        {
            console.log(Response);
            window.open('../pdf/pdf-'+funcion+'.pdf','_blank')
        })
    });
    $(document).on('click','#button-reporteExcel',(e)=>{
        funcion='reporte_productosExcel';
        //console.log(funcion);
        $.post('../controlador/producto_controller.php',{funcion},(Response)=>
        {
            console.log(Response);
            //window.open('../Excel/reporte_productos.xlsx','_blank')
        })
    })

});