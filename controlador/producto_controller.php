<?php
include_once '../modelo/producto.php';//incluimos la clase producto
require_once ('../vendor/autoload.php');
//require_once __DIR__ . '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\FiLL;
use PhpOffice\PhpSpreadsheet\Writer\Border;
use Facturapi\Facturapi;

$producto= new producto(); //instanciamos un objeto de la clase producto
if($_POST['funcion']=='crear')
{       
        $codigo= $_POST['codigo'];
        $nombre = $_POST['nombre'];//hace el post hacia el archivo productos js la variables del post deben de ser iguales 
        $inventario_min = $_POST['inventario_min'];
        $precio_in = $_POST['precio_in'];
        $precio_out = $_POST['precio_out'];
        $presentacion= $_POST['presentacion'];
        $unidad = $_POST['unidad'];
        $categoria = $_POST['categoria'];
        $producto->crear($codigo,$nombre,$inventario_min,$precio_in,$precio_out,$presentacion,$unidad,$categoria);//hacemos la llamada a la funcion crear con lo parametrod del post
}

if($_POST['funcion']=='buscar')
{
    $producto->buscar(); //instaniamos productos y llamamos a la funcion buscar
    $json=array();
    foreach($producto->objetos as $objeto)
    {
        
        $producto->obtener_stock($objeto->id_productos);
        foreach($producto->objetos as $obj)
        {
            $total = $obj->total; 
        }

        $json[]=array(
            'id'=>$objeto->id_productos,
            'codigo'=>$objeto->codigo,
            'nombre'=>$objeto->nombre,
            'inventario_min'=>$objeto->inv_min,
            'precio_in'=>$objeto->pre_in,
            'precio_out'=>$objeto->pre_out,
            'stock'=>$total,
            'presentacion'=>$objeto->presentacion,
            'unidad'=>$objeto->unidad,
            'categoria'=>$objeto->categoria,
            'categoria_id'=>$objeto->fk_categoria,
       );
        
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='editar')
{   
        $id_productos =$_POST['id'];
        $codigo= $_POST['codigo'];
        $nombre = $_POST['nombre'];//hace el post hacia el archivo productos js la variables del post deben de ser iguales 
        $inventario_min = $_POST['inventario_min'];
        $precio_in = $_POST['precio_in'];
        $precio_out = $_POST['precio_out'];
        $presentacion = $_POST['presentacion'];
        $unidad = $_POST['unidad'];
        $id_categoria = $_POST['categoria'];
        $producto->editar($id_productos,$codigo,$nombre,$inventario_min,$precio_in,$precio_out,$presentacion,$unidad,$id_categoria);//hacemos la llamada a la funcion crear con lo parametrod del post
}
if($_POST['funcion']=='buscar_id')
{
    $id=$_POST['id_producto'];
    $producto->buscar_id($id); //instaniamos productos y llamamos a la funcion buscar
    $json=array();
    foreach($producto->objetos as $objeto)
    {
        $producto->obtener_stock($objeto->id_productos);
        foreach($producto->objetos as $obj)
        {
            $total= $obj->total; 

        }
        $json[]=array(
            'id'=>$objeto->id_productos,
            'nombre'=>$objeto->nombre,
            'inventario_min'=>$objeto->inv_min,
            'precio_in'=>$objeto->pre_in,
            'precio_out'=>$objeto->pre_out,
            'stock'=>$total,
            'presentacion'=>$objeto->presentacion,
            'unidad'=>$objeto->unidad,
            'categoria'=>$objeto->categoria,
            'categoria_id'=>$objeto->fk_categoria,
        );
    }
    $jsonstring=json_encode($json[0]);//cuNDO traemos los datos en masa no se utilizan los corchetes
    echo $jsonstring;
}
if($_POST['funcion']=='borrar')
{
    $id=$_POST['id'];
    $producto->borrar($id);
}

if($_POST['funcion']=='verificar_stock')
{
    $error=0;
    $productos=json_decode($_POST['productos']);//lista de prodiuctos
    foreach ($productos as $objeto)//hacemos el foeach para ahacer el recorrido 
    {
        $producto->obtener_stock($objeto->id);
        foreach($producto->objetos as $obj)
        {
            $total=$obj->total;
        }
        if($total>=$objeto->cantidad && $objeto->cantidad>0)
        {
            $error=$error+0;
        }
        else
        {
            $error=$error+1;
        }
    }
    echo $error;
}
if($_POST['funcion']=='traer_productos')
{
    $html="";
    $productos=json_decode($_POST['productos']);//lista de prodiuctos
    foreach ($productos as $resultado) {
        # code...
        $producto->buscar_id($resultado->id);
        //var_dump($producto);
        foreach ($producto->objetos as $objeto) {
            # code...
            $subtotal=$objeto->pre_out*$resultado->cantidad;
            $producto->obtener_stock($objeto->id_productos);
            foreach($producto->objetos as $obj)
            {
                $stock=$obj->total;
            }
            $html.="
            <tr ProdId='$objeto->id_productos' ProdPrecio_out='$objeto->pre_out'>
                <td>$objeto->nombre</td>
                <td>$stock</td>
                <td class='precio'>
                    <input type='number' min='10' class='form-control pre' style='width:70px' value='$objeto->pre_out'>
                </td><!-verificar bien->
                <td>$objeto->presentacion</td>
                <td>$objeto->unidad</td>
                <td>$objeto->categoria</td>
                <td>
                    <input type='number' min='10' class='form-control cantidad' style='width:70px' value='$resultado->cantidad'>
                </td>
                <td class='subtotales'>
                    <h6 style='margin-top:5px'>$$subtotal</h6>
                </td> 
                <td><button class='borrar-producto btn btn-danger'><i class='fas fa-times-circle' </button></td>
            </tr>
            ";
        }
    }
    echo $html;
}
if($_POST['funcion']=='reporte_productos')
{
    date_default_timezone_set('America/Mexico_City');
    $fecha= date('Y-m-d H:i:s');
    $html='
        <header>
            <div id="logo">
                <img src="../img/logo.jpeg" width="60" height="60">
            </div>
            <h1>Reporte de productos</h1>
            <div id="project">
                <div>
                    <span>Fecha y hora </span>'.$fecha.'
                </div>
            </div>
        </header>
        <table>
            <thead>
                <tr>
                    <th>N*</th>
                    <th>Producto</th>
                    <th>Inv_Min</th>
                    <th>Stokc</th>
                    <th>Precio</th>
                    <th>Presentación</th>
                    <th>Unidad</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>


    ';//con esta parte del codigo creamos el pdf
    $producto->reporte_productos();
    $contador=0;
    foreach ($producto->objetos as $objeto) {
        # code...
        $contador++;
        $producto->obtener_stock($objeto->id_productos);
        foreach($producto->objetos as $obj)
        {
            $stock=$obj->total;
        }
        $html.='
        <tr>
            <td class="servic">'.$contador.'</td>
            <td class="servic">'.$objeto->nombre.'</td>
            <td class="servic">'.$objeto->inv_min.'</td>
            <td class="servic">'.$stock.'</td>
            <td class="servic">'.$objeto->pre_out.'</td>
            <td class="servic">'.$objeto->presentacion.'</td>
            <td class="servic">'.$objeto->unidad.'</td>
            <td class="servic">'.$objeto->categoria.'</td>
        </tr>
        
        ';
    }
    $html.='

            </tbody>
        </table>
    ';
    $css=file_get_contents("../css/pdf.css");
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);//PARA ENVIAR EL CSS AL ARCHIVO PDF
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);//para enviar la estrctura html
    $mpdf->Output("../pdf/pdf-".$_POST['funcion'].".pdf","F");
}

if($_POST['funcion']=='reporte_productosExcel')
{
    $nombre_archivo='reporte_productos.xlsx';
    $producto->reporte_productos();
    $contador=0;
    foreach ($producto->objetos as $objeto) {
        # code...
        $contador++;
        $producto->obtener_stock($objeto->id_productos);
        foreach($producto->objetos as $obj)
        {
            $stock=$obj->total;
        }
        $json[]=array(
            'N'=>$contador,
            'nombre'=>$objeto->nombre,
            'inventario_min'=>$objeto->inv_min,
            'stock'=>$stock,
            'precio_out'=>$objeto->pre_out,
            'presentacion'=>$objeto->presentacion,
            'unidad'=>$objeto->unidad,
            'categoria'=>$objeto->categoria,
        );
    }
    //var_dump($json);

    $spreadsheet = new Spreadsheet();
    $sheet= $spreadsheet->getActiveSheet();
    $sheet->setTitle('Reporte de productos');
    $sheet->setCellValue('A1','Reporte de productos');
    $sheet->getStyle('A1')->getFont()->setSize(17);
    $sheet->fromArray(array_keys($json[0]),NULL,'A4');
    $sheet->getStyle('A4:I4')
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('2D9F39');
    $sheet->getStyle('A4:I4')
    ->getFont()
    ->getColor()
    ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
    foreach ($json as $key => $producto) {
        # code...
        $celda=(int)$key+5;
        if($producto['inventario_min']==$producto['stock'])
        {
            $sheet->getStyle('A'.$celda.':I'.$celda)
            ->getFont()
            ->getColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        }
        $sheet->setCellValue('A'.$celda,$producto['N']);
        $sheet->setCellValue('B'.$celda,$producto['nombre']);
        $sheet->setCellValue('C'.$celda,$producto['inventario_min']);
        $sheet->setCellValue('D'.$celda,$producto['stock']);
        $sheet->setCellValue('E'.$celda,$producto['precio_out']);
        $sheet->setCellValue('F'.$celda,$producto['presentacion']);
        $sheet->setCellValue('G'.$celda,$producto['unidad']);
        $sheet->setCellValue('H'.$celda,$producto['categoria']);
    }
    foreach (range('B','I') as $col ) {
        # code...
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('../Excel/'.$nombre_archivo);
}
if($_POST['funcion']=='obtener_productos')
    {
        $producto->obtener_productos();
        $json=array();
        foreach ($producto->objetos as $objeto)
        {
            $json[] = array(
                'nombre'=>$objeto->id_productos.'|'.$objeto->nombre.'|'.$objeto->inv_min.'|'.$objeto->pre_in.'|'.$objeto->pre_out.'|'.$objeto->presentacion.'|'.$objeto->unidad.'|'.$objeto->categoria
            );
        }
        $jsonstring=json_encode($json);
        echo $jsonstring;
    }
?>