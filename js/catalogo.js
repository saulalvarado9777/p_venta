$(document).ready(function(){
    $('#carrito').show();
    buscar_producto();
    function buscar_producto(consulta)
    {
        funcion='buscar';
        $.post('../controlador/catalogo_controller.php',{consulta,funcion},(Response)=>
        {
            //console.log(Response);
            const productos = JSON.parse(Response);
            let template='';
            productos.forEach(producto=>
            {   
             template+=`
                    <div ProdId="${producto.id}" ProdStock="${producto.stock}" ProdNombre="${producto.nombre}" ProdInventario_min="${producto.inventario_min}" 
                        ProdPrecio_in="${producto.precio_in}" ProdPrecio_out="${producto.precio_out}" ProdStock="${producto.stock}" ProdPresentacion="${producto.presentacion}" ProdUnidad="${producto.unidad}" 
                        ProdId_categoria="${producto.categoria_id}"  class="col-12 col-sm-7 col-md-5 d-flex align-items-stretch">
                        <div class="card  bg-${producto.estado}"style="height:125px; width:400px; margin-top:-17px">
                            <div class="card-header text-muted mt-0 border-bottom-1"  >
                                <i class="fas fa-lg fa-cubes mr-1"></i>${producto.stock}
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                <div class="col-7">
                                    <h2 class="lead" style="font-size:15px"><b>${producto.nombre}</b></h2>
                                    <h2 class="lead" style="font-size:15px"><b>$${producto.precio_out}</b></h2>
                                </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button class="carrito btn btn-sm bg-primary">
                                        <i class="fas fa-plus-square"></i>Agregar al carrito
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
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
    });
});