$(document).ready(function(){//
    let funcion;
    venta_mes();
    vendedor_mes();
    producto_mas_vendido();
    cliente_mes();
    async function producto_mas_vendido()
    {
        funcion='producto_mas_vendido';
        let lista=['','','','',''];
        const Response = await fetch('../controlador/ventas_controller.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'funcion='+funcion
        }).then(function(Response){
            return Response.json();
        }).then (function(productos) {
            console.log(productos)
            let i=0;
            productos.forEach(producto => {
                lista[i]=producto;
                i++;
            });
        })
        let canvasG4=$('#grafico4').get(0).getContext('2d');
        let datos={
            labels:[
                'Mes actual'
            ],
            datasets:[
                {
                    label: lista[0].nombre,
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,0.9)',
                    data: [lista[0].total]
                },
                {
                    label: lista[1].nombre,
                    backgroundColor: 'rgba(255,141,188,1)',
                    borderColor: 'rgba(255,141,188,1)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(255,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(255,141,188,1)',
                    data: [lista[1].total]
                },
                {
                    label: lista[2].nombre,
                    backgroundColor: 'rgba(0,141,188,1)',
                    borderColor: 'rgba(0,141,188,1)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(0,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(0,141,188,0)',
                    data: [lista[2].total]
                },
                {
                    label: lista[3].nombre,
                    backgroundColor: 'rgba(0,141,188,1)',
                    borderColor: 'rgba(0,141,188,1)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(0,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(0,141,188,0)',
                    data: [lista[3].total]
                },
                {
                    label: lista[4].nombre,
                    backgroundColor: 'rgba(0,141,188,1)',
                    borderColor: 'rgba(0,141,188,1)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(0,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(0,141,188,0)',
                    data: [lista[4].total]
                },
            ]
        }
        let opciones={
            responsive:true,
            maintaiAspectRatio:false,
            datasetFill:false,
        }
        let g4 = new Chart(canvasG4,{
            type:'bar',
            data:datos,
            options:opciones
        })
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    async function vendedor_mes() {
        funcion='vendedor_mes';
        let lista=['','',''];
        const Response = await fetch('../controlador/ventas_controller.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'funcion='+funcion
        }).then(function(Response){
            return Response.json();
        }).then(function(vendedores){
            //console.log(vendedores);
            let i=0;
            vendedores.forEach(vendedor => {
                lista[i]=vendedor;
                i++;
            });
        })
        //console.log(lista);
            let canvasG2=$('#grafico2').get(0).getContext('2d');
            let datos={
                labels:[
                    'Mes actual'
                ],
                datasets:[
                    {
                        label: lista[0].vendedor,
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,0.9)',
                        data: [lista[0].cantidad]
                    },
                    {
                        label: lista[1].vendedor,
                        backgroundColor: 'rgba(255,141,188,1)',
                        borderColor: 'rgba(255,141,188,1)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(255,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(255,141,188,1)',
                        data: [lista[1].cantidad]
                    },
                    {
                        label: lista[2].vendedor,
                        backgroundColor: 'rgba(0,141,188,1)',
                        borderColor: 'rgba(0,141,188,1)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(0,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(0,141,188,0)',
                        data: [lista[2].cantidad]
                    },
                ]
            }
            let opciones={
                responsive:true,
                maintaiAspectRatio:false,
                datasetFill:false,
            }
            let g2 = new Chart(canvasG2,{
                type:'bar',
                data:datos,
                options:opciones
            })
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
async function cliente_mes() {
    funcion='cliente_mes';
    let lista=['','',''];
    const Response = await fetch('../controlador/ventas_controller.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'funcion='+funcion
    }).then(function(Response){
        return Response.json();
    }).then(function(clientes){
        //console.log(vendedores);
        let i=0;
        clientes.forEach(cliente => {
            lista[i]=cliente;
            i++;
        });
    })
    //console.log(lista);
        let canvasG2=$('#grafico5').get(0).getContext('2d');
        let datos={
            labels:[
                'Mes actual'
            ],
            datasets:[
                {
                    label: lista[0].cliente,
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,0.9)',
                    data: [lista[0].cantidad]
                },
                {
                    label: lista[1].cliente,
                    backgroundColor: 'rgba(255,141,188,1)',
                    borderColor: 'rgba(255,141,188,1)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(255,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(255,141,188,1)',
                    data: [lista[1].cantidad]
                },
                {
                    label: lista[2].cliente,
                    backgroundColor: 'rgba(0,141,188,1)',
                    borderColor: 'rgba(0,141,188,1)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(0,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(0,141,188,0)',
                    data: [lista[2].cantidad]
                },
            ]
        }
        let opciones={
            responsive:true,
            maintaiAspectRatio:false,
            datasetFill:false,
        }
        let g2 = new Chart(canvasG2,{
            type:'bar',
            data:datos,
            options:opciones
        })
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    async function venta_mes()
    {
        funcion='venta_mes';
        let array=['','','','','','','','','','','',''];
        const Response = await fetch('../controlador/ventas_controller.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'funcion='+funcion
        }).then(function(Response){
            return Response.json();
        }).then (function(meses) {
            //console.log(meses);
            meses.forEach(mes => {
                if(mes.mes==1)
                {
                    array[0]=mes;
                }
                if(mes.mes==2)
                {
                    array[1]=mes;
                }
                if(mes.mes==3)
                {
                    array[2]=mes;
                }
                if(mes.mes==4)
                {
                    array[3]=mes;
                }
                if(mes.mes==5)
                {
                    array[4]=mes;
                }
                if(mes.mes==6)
                {
                    array[5]=mes;
                }
                if(mes.mes==7)
                {
                    array[6]=mes;
                }
                if(mes.mes==8)
                {
                    array[7]=mes;
                }
                if(mes.mes==9)
                {
                    array[8]=mes;
                }
                if(mes.mes==10)
                {
                    array[9]=mes;
                }
                if(mes.mes==11)
                {
                    array[10]=mes;
                }
                if(mes.mes==12)
                {
                    array[11]=mes;
                }
            });
        });
        let canvasG1=$('#grafico1').get(0).getContext('2d');
        let datos={
            labels:[
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre',
            ],
            datasets:
            [{
                data:[
                    array[0].cantidad,
                    array[1].cantidad,
                    array[2].cantidad,
                    array[3].cantidad,
                    array[4].cantidad,
                    array[5].cantidad,
                    array[6].cantidad,
                    array[7].cantidad,
                    array[8].cantidad,
                    array[9].cantidad,
                    array[10].cantidad,
                    array[11].cantidad,
                ],
                backgroundColor:[
                    '#FAFAD2',	 
                    '#D3D3D3',	 
                    '#90EE90',	 
                    '#D3D3D3',	 
                    '#FFB6C1',	 
                    '#FFA07A',	 
                    '#20B2AA',	 
                    '#87CEFA',	 
                    '#778899',	 
                    '#778899',	 
                    '#B0C4DE',	 
                    '#FFFFE0',
                ],
            }],
        }
        let opciones={
            maintaiAspectRatio:false,
            responsive:true,

        }
        let g1= new Chart(canvasG1,{
            type:'pie',
            data:datos,
            options:opciones,
        })
    }
});