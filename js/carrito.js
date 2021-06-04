$(document).ready(function()//jquery evento ready dentro de el una funcion
{
    $('.select2').select2();
    obtener_clientes();
    contar();
    recuperarls_carrito();
    calcular_total();
    recuperarls_carrito_compra();
    $(document).on('click','.carrito',(e)=>//evento on cada vez que haga click en agregar al carrito y ocurra un evento va hacer un callback o una funcion
    {
        const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;//capturamos los datos del card del producto
        const id=$(elemento).attr('ProdId');     //estas constantes la traemos del template, dentro del elemento de tr
        const nombre=$(elemento).attr('ProdNombre');// el template se encuentra en catalogo js 
        const precio=$(elemento).attr('ProdPrecio_out');//todos estos elementos le pertenecen al card del producto
        const presentacion=$(elemento).attr('ProdPresentacion');
        const unidad=$(elemento).attr('ProdUnidad');
        const categoria=$(elemento).attr('ProdId_categoria');
        const stock=$(elemento).attr('ProdStock');
        //console.log(unidad+' '+presentacion);
        //console.log(id+' '+nombre+' '+precio+' '+categoria);
        const producto={//declaramos un array
            id: id, //colocamos todos sus atrubutos
            nombre: nombre,//estos atributos le pertenecen a los datos 
            precio: precio,//que traemos del card
            presentacion: presentacion,
            unidad:unidad,
            categoria: categoria,
            stock:stock,
            cantidad: 1,//como minimo a cada producto que agregamos le va dar la cantidad de 1
        }
        //acciones para verficar si el producto ya existe en el local storage si ya existe que ya no lo agregue
        let id_producto;
        let productos;
        productos = recuperarls ();//recuperamos si ya existe en el localstorage
        productos.forEach(prod => {
            if(prod.id===producto.id)//si el producto ya exixte 
            {
               id_producto=prod.id;//capturamos el id del producto de ese producto que ya existe  en id_producto
            }
        });
       if(id_producto === producto.id)/*si hay un producto con el mismo id muestra una alerta de que ya existe*/
        {
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El producto ya existe',
            })
        }
        else
        {//con la interpoalcion traemos todas las vriables a la tabla como se ve aqui abajao
            template=`
            <tr ProdId="${producto.id}"><!--para eliminar el producto del carrito del localstorage-->
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>$${producto.pre_out}</td>
                <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"</button></td><!--este boton tiene una clase con la que podemos hacer acciones sobre de el-->
            </tr>
        `;//solo agrega el codigo que escribimos en el template con append
        $('#lista').append(template);//hacemos referencia que dentro de ltbody html se va incorprar todo el template
        let contador;//despues de agregar lo productos a lista 
        agregarls(producto);//conn esta funcion los agregamos al localstorage donde le pasamos como parametro el producto que es un objeto
        contar();
        procesar_pedido();//coloque procesar pedido
        //recuperarls_carrito_compra();
        }
        ///verificar si aqui podemos agregar lo de procesar compra
        
    });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click','.borrar-producto',(e)=> //la clase de este boton es la del registro de de carrito en 
    {//esta aqui arriba
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        //console.log(elemento);
        const id =$(elemento).attr('ProdId');//recuperamos el id del producto que queremos eliminar
        elemento.remove(); //eliman el elemnto de la tabla del carrito
        eliminarls(id);//funcion para eliminar el producto del localstorage
        contar();
        calcular_total();
        //console.log(contador);
    });
    $(document).on('click','#imp',(e)=>
    {  
        productos = recuperarls();//primero recuperamos lo que tiene el local
        funcion='buscar_id';
        productos.forEach(producto => {
            id_producto=producto.id
            console.log(id_producto);
            $.post('../controlador/producto_controller.php',{funcion,id_producto},(Response)=>{//hacemos un bucle para ir marcadnp producto por producto en el carrito
                //console.log(Response);  
                let template_carrito='';
                let json= JSON.parse(Response);
                template_carrito=`
                <tr ="${json.id}">
                    <td>${json.id}</td>
                    <td>${json.nombre}</td>
                    <td>$${json.precio_out}</td>
                    <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"</button></td>
                </tr>
                `;
                $('#lista-compra').append(template_carrito);
            });
        });
    });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click','#vaciar',(e)=>//hace referencia al boton vaciar dentro del nav
    {
        $('#lista').empty();//selecciona el elemento y borra todos los elementos que esten dentro de ese elemento lista
        vaciarls();//elimanr todos los productos del localstorage
        contar();
    });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click','#procesar-pedido',(e)=>
    {
        procesar_pedido();
        //recuperarls_carrito_compra();
    });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click','#procesar-compra',(e)=>
    {
        /*const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id =$(elemento).attr('ProdId');//recuperamos el id del producto que queremos eliminar
        console.log(id);*/
        procesar_compra();

    });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function recuperarls () //nos permite recuperar los datos del localstorage
    {
        let productos;//creamos una variable la cual va hacer reotrnada
        if(localStorage.getItem('productos')===null)/*si hay una informacion en el localstorage con el nombre productos*/
        {//si llo que esta en productos esta vacio 
            productos=[];//hacemos  que la variable productos tenga un arreglo vacio si localstorage contiene nulos 
        }
        else//si contiene algo la varible productos
        {
            productos= JSON.parse(localStorage.getItem('productos')) 
        }// asiganar todos los productos del localstorage o si contiene los objetos
        return productos//retornamos productos
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function agregarls(producto)/*el parametro producto viene de la const de producto  que es objeto*/
    {
        let productos;  //declaramos productos
        productos=recuperarls();//a productos le asignamos lo que recupera del localsorage
        productos.push(producto);//introducir un objeto dentro de una lista objetos
        localStorage.setItem('productos', JSON.stringify(productos))//setItem asignar un valor a localstorage getItem para recuperar el valor 
                         ////el primer valor es el nombre el localstorage para recuperarlo y el segundo es la informacion que queremos que guarde
                        //producto es un objeto, si lo queremos meter al localstorage primero lo convertimos en un strignjson
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function recuperarls_carrito() 
    { /*esta funcion sirve para cuando queremos actualizar la pagina no se borren los productos del carrito se mantenga
        ahi, lo que hace es traer del localstorage los productos agregados */
        let productos, id_producto;//declaramos una vriable productos
        productos = recuperarls();//primero recuperamos lo que tiene el local
        funcion='buscar_id';
        productos.forEach(producto => {//producto es la vriable que va a recorrer el foreach
            id_producto=producto.id;
            //console.log(id_producto);
            $.post('../controlador/producto_controller.php',{funcion,id_producto},(Response)=>{//hacemos un bucle para ir marcadnp producto por producto en el carrito
                //console.log(Response);  
                let template_carrito='';
                let json= JSON.parse(Response);
                template_carrito=`
                <tr ="${json.id}">
                    <td>${json.id}</td>
                    <td>${json.nombre}</td>
                    <td>$${json.precio_out}</td>
                    <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"</button></td>
                </tr>
                `;
                $('#lista').append(template_carrito);
            });
        });
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function eliminarls(id)
    {
        let productos;
        productos = recuperarls();/*recupera todos los productos existentes */
        productos.forEach(function(producto,indice) {
            if(producto.id===id)/*comparamos el id del producto del localsotorage con el id del producto que queremos eliminar */
            {
                productos.splice(indice,1);//seleccionamos la lista productos con splice sirve para eliminar elementos 
            }//con su subindice y elminamos el producto de ese indice
        });
        localStorage.setItem('productos', JSON.stringify(productos));//actualizamos el localstorage despues de eliminar el objeto
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function vaciarls()
    {
        localStorage.clear();//si quiero elimnar el local storage llamo el metodo clear
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function contar() 
    {
        let productos;
        let contador=0;
        productos=recuperarls();
        productos.forEach(producto => {
            contador++;
        });
        $('#contador').html(contador);
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function procesar_pedido() 
    {
        let productos;
        productos=recuperarls();/*la variable producto contiene todos los productos del localstorage */
        if(productos.length===0)//si la variable productos esta vacia muestra un aviso
        {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El carrito esta vacio',
                })
        }
        else
        {
            //recuperarls_carrito_compra();
            location.href='../Vistas/adm_catalogo.php';
        }
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    async function recuperarls_carrito_compra()
    {
        let productos;
        productos = recuperarls();
        funcion='traer_productos';
        const Response = await fetch('../controlador/producto_controller.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'funcion='+funcion+'&&productos='+JSON.stringify(productos)//lo que le enviamos al servidor lo tenemos que codificar
        });
        let resultado = await Response.text();
        //console.log(resultado);
        $('#lista-compra').append(resultado);

    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click','#actualizar',(e)=>
    {
        let productos,precios;
        precios=document.querySelectorAll('.precio');
        productos=recuperarls();
        productos.forEach(function(producto,indice) 
        {
            producto.precio_out=precios[indice].textContent;
            console.log(productos);
        });
        localStorage.setItem('productos',JSON.stringify(productos)); /**verfificar funcion no actualiza  */
        calcular_total();  //no funciona esta funcion es como si no estuviera
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#cp').keyup((e)=>
    {
        let id, cantidad, producto, productos, montos,precio;
        producto=$(this)[0].activeElement.parentElement.parentElement;
        id = $(producto).attr('ProdId');
        //precio = $(producto).attr('ProdPrecio_out');
        precio = producto.querySelector('.pre').value;
        cantidad = producto.querySelector('.cantidad').value;//producto es la celda, seleccioamoe el input de ese eventp y obtenemos su valor
        montos = document.querySelectorAll('.subtotales');//
        //console.log(montos);
        productos = recuperarls();//recuperamos los productos del localstorage
        productos.forEach(function(prod, indice){//pa
            if(prod.id===id)
            {
                prod.cantidad=cantidad;//accedemos al campo cantidad del producto encontrado y le asignamo la cantidad "es el campo input"
                prod.precio=precio;//accedemos al campo precio del producto enconrado y le asignamo el precio "del input"
                montos[indice].innerHTML=`<h6 style="margin-top:5px">$${cantidad*precio}</h6>`//
            }
        });
        localStorage.setItem('productos',JSON.stringify(productos)); 
        calcular_total();
    });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function calcular_total() 
    {
        let productos,subtotal=0,con_igv=0,total_sin_descuento=0,cambio=0,pago=0,descuento=0;
        let total=0,igv=0.16;
        productos=recuperarls();
        productos.forEach(producto => {
            let subtotal_producto=Number(producto.precio*producto.cantidad);
            total=total+subtotal_producto;            
        });
        total_sin_descuento=total.toFixed(2);//solo toma los dos primeros decimales
        con_igv=parseFloat(total*igv).toFixed(2);//converte a float y solo toma los dos primero decimales
        subtotal=parseFloat(total-con_igv).toFixed(2);//convierte a float y solo toma los dos primeros decimales 
        
        pago=$('#pago').val();
        descuento=$('#descuento').val();
        total=total-descuento;
        cambio=pago-total;
        
        $('#subtotal').html(subtotal);//mandamos el resultado de la opracion subtotal al html con id=subtotal
        $('#con_igv').html(con_igv);
        $('#total_sin_descuento').html(total_sin_descuento);
        $('#total').html(total.toFixed(2));
        $('#cambio').html(cambio.toFixed(2));
        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function procesar_compra() 
    {
        let cliente=$('#cliente_select').val();
        if(recuperarls().length==0)//si esta vacio muestra una alerta, y recuperamos los elemntos del local storage 
        {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No hay productos seleccionados!',
              })
              .then(function()
              {
                location.href='../Vistas/adm_catalogo.php'
              })
        }
        else if(cliente=='')//si nombre esta vacio muestra una alerta que debebos de poner un nombre al cliente
        {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ingresa un cliente!',
                
              })
        }
        else//comprobamos is hay stock disponible
        {
            verificar_stock().then(error=>{
                //console.log(error);
                if(error==0)
                {
                    registrar_compra(cliente);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se realizo la compra',
                        showConfirmButton: false,
                        timer: 500
                    }).then(function()
                    {
                        vaciarls();
                        location.href='../Vistas/adm_catalogo.php'
                    })
                }
                else
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Verificar el stock de los productos!',
                      })
                }
            });
            //console.log(error);
            //verificar_stock();

        }
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    async function verificar_stock()
    {
        let productos;
        funcion='verificar_stock';
        productos=recuperarls();
        const Response = await fetch('../controlador/producto_controller.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'funcion='+funcion+'&&productos='+JSON.stringify(productos)
        });
        let error = await Response.text();
        return error;
    }
    
    function registrar_compra(cliente){
        funcion='registrar_compra';
        let total=$('#total').get(0).textContent;//recuperar el total del primer dato y accedemos al contenido con textcontent
        let productos=recuperarls();//recuperamos todos los productos que queremos vender
        let json=JSON.stringify(productos);//enviamos los productos como json
        $.post('../controlador/venta_controller.php',{funcion,total,cliente,json},(Response)=>{
            //console.log(Response);
            console.log(Response);
        });
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function obtener_clientes() {
        funcion='obtener_clientes';
        $.post('../controlador/cliente_controller.php',{funcion},(Response)=>
        {
            //console.log(Response);
            const clientes = JSON.parse(Response);
            let template='';
            clientes.forEach(cliente => {
                template+=`
                <option value="${cliente.id}">${cliente.nombre}</option>
                `;
            });
            $('#cliente_select').html(template);//es el identificador en el html del select en la vista adm_catalogo
        })
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
});