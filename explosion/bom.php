<?php
set_time_limit(600);
session_start();

if( empty( $_SESSION['usuario_comedor'] ) ):
  echo "<h1 style='text-align:center;color: #af4040;position: absolute;top: 40%;left: 50%;transform: translate(-50%, -50%) skewX(15deg);font-size: 60px;'>Acceso denegado!!</h1>";
  http_response_code(403);
  exit;
endif;

define('KEY', 'JACE');

require '../db/db.php';

require '../db/vendor/autoload.php';
//carga l libreriia con namespace
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//carga la clase para escribir el excel
use PhpOffice\PhpSpreadsheet\IOFactory;

//instanciamos el objeto 
$spreadsheet = new Spreadsheet();

//recupera las fechas que se desean consultar
$start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_STRING);
$conExcedente = filter_input(INPUT_GET, 'excedente', FILTER_VALIDATE_INT);

$start = new DateTime( $start );
$sem1 = $start->format('W');
$fechaI = $start->format('Y-m-d');

$end = new DateTime( $end );
$sem2 = $end->format('W');
$fechaF = $end->format('Y-m-d');

$semana = $sem1 === $sem2 ? $sem1 : "{$sem1} - {$sem2}";

$hoja = 0;

//borramnos la tabla bom
$db->query("DELETE FROM bom");


$sql = "SELECT DISTINCT menu.cliente, menu.unidad FROM menu INNER JOIN menurec ON menu.idMenu = menurec.idMenu WHERE ( menurec.fecha >= '{$fechaI}' ) AND ( menurec.fecha <= '{$fechaF}' ) AND ( menu.activo = '1' )";

$r = $db->query($sql);

//si no encuentra registros termina el codigo
$db->affected_rows > 0 or die('No hay información en ese periodo');


function headerExcel( $cliente, $unidad, &$indexRow ){
  global $semana, $sheet, $fechaI, $fechaF;

  $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  $drawing->setName('Logo');
  $drawing->setDescription('Logo');
  $drawing->setPath('../img/logo_guisopak.png');
  $drawing->setHeight(55);
  $drawing->setCoordinates('A1');
  // $drawing->setOffsetX(10);
  
  $sheet->mergeCells("A1:A2");
  //add logo
  $drawing->setWorksheet($sheet);

  $indexRow = 1;
  //titulo
  $sheet->mergeCells("B{$indexRow}:H{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "GUISOPAK");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  $indexRow++;
  //receta nombre
  $sheet->mergeCells("B{$indexRow}:H{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "Explosión de materiales de artículos");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("B{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

  //fecha
  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Semana:");//semana
  $sheet->setCellValue("B{$indexRow}", $semana);//semana

  $sheet->setCellValue("C{$indexRow}", "Fecha");
  $sheet->setCellValue("D{$indexRow}", $fechaI .' - ' . $fechaF);

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Cliente:" );
  $sheet->setCellValue("B{$indexRow}", $cliente );

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Unidad:" );
  $sheet->setCellValue("B{$indexRow}", $unidad );

  $indexRow += 2;
  $titulos = ['A'=> 'Línea', 'B'=> 'ID Artículo', 'C'=> 'Descripción', 'D'=> 'Presentación', 'E'=> 'Unidad', 'F'=> 'Cantidad', 'G'=> 'Costo Unidad', 'H'=> 'Costo Total'];
  $sheet->getStyle("A{$indexRow}:H{$indexRow}")->getFont()->setBold(true);
  $sheet->getStyle("A{$indexRow}:H{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

  foreach ($titulos as $key => $title){
    // $sheet->getColumnDimension($key)->setAutoSize(true);
    $sheet->getColumnDimension($key)->setWidth(16);
    $sheet->setCellValue("{$key}{$indexRow}", " $title");
    // $sheet->getStyle("{$key}{$indexRow}:{$key}")->
  }

  $indexRow++;

}

function getUnidadM($unidadM){
  switch ( $unidadM ){
    case "KILOGRAMOS":
      $unidadM = "Kgs";
      break;
    case "LITROS":
      $unidadM = "Lts";
      break;
    case "METROS":
      $unidadM = "Mts";
      break;
    case "PAQUETES":
      $unidadM = "Pqs";
      break;
    case "PIEZAS":
      $unidadM = "Pzs";
      break;
    case "OTRO":
      $unidadM = "Otr";
      break;
  }
  return $unidadM;
}

function getPresentacion($presentacion){
  switch ( $presentacion ){
    case "KILOGRAMOS":
      $presentacion = "Kgs";
      break;
    case "LITROS":
      $presentacion = "Lts";
      break;
    case "METROS":
      $presentacion = "Mts";
      break;
    case "PAQUETES":
      $presentacion = "Pqs";
      break;
    case "PIEZAS":
      $presentacion = "Pzs";
      break;
    case "OTRO":
      $presentacion = "Otr";
      break;
  }
  return $presentacion;
}


$numtimes = 0;
while( $item = $r->fetch_object() ){
  $numtimes++;
}

$sql = "SELECT menu.idMenu, menu.cliente, menu.unidad, menurec.receta, menurec.fecha, menu.grupo, menurec.personas, menurec.pos, menurec.precio FROM menu INNER JOIN menurec ON menu.idMenu = menurec.idMenu WHERE (menurec.fecha >= '{$fechaI}') AND (menurec.fecha <= '{$fechaF}' ) AND menu.activo = '1' ORDER BY menu.cliente, menu.unidad, menurec.receta, menu.grupo, menurec.fecha";
$rslt1 = $db->query($sql);


$clienteAnt = $unidadAnt = '';
//Por cada cliente y unidad se hace una hoja de excel
while( $item = $rslt1->fetch_object() ){

  $idMenu   = $item->idMenu;
  $cliente  = $item->cliente;
  $unidad   = $item->unidad;
  $receta   = $item->receta;
  $fecha    = $item->fecha;
  $grupo    = $item->grupo;
  $personas = $item->personas;
  $posicion = $item->pos;
  $costoUR  = $item->precio;

  //cuando el cliente y la unidad son diferentes cramos nueva hoja de excel
  if( $unidad != $unidadAnt || $cliente != $clienteAnt ){

    $clienteAnt = $cliente;
    $unidadAnt  = $unidad;

  //   if( $hoja !== 0 )
  //     $spreadsheet->createSheet();//crea una nueva hoja de calculo

  //   //establecemos la hoja de calculo activa como la primera
  //   $spreadsheet->setActiveSheetIndex( $hoja );
  //   $sheet = $spreadsheet->getActiveSheet();
    
    $hoja++;

  //   //get nombre cliente
  //   $sql = "SELECT idCliente, nombre FROM cliente WHERE idCliente = '{$cliente}' LIMIT 1";
  //   $rslt2 = $db->query($sql);
  //   $clienteNombre = $rslt2->fetch_object()->nombre;

  //   //get name unidad
  //   $sql = "SELECT idUnidad, cliente, unidad FROM unidad WHERE idUnidad = '{$unidad}' AND cliente = '{$cliente}' LIMIT 1";
  //   $rslt2 = $db->query($sql);
  //   $unidadNombre = $rslt2->fetch_object()->unidad;

  //   //creamos cabecera de la hoja
  //   $indexRow = 0;
  //   headerExcel( $clienteNombre, $unidadNombre, $indexRow );

  }

  //get receta
  $sql = "SELECT idReceta, nombre FROM receta WHERE nombre = '{$receta}' LIMIT 1";
  $rslt2 = $db->query($sql);
  $idReceta = $rslt2->fetch_object()->idReceta;
  //se traen las porciones de la receta
  $sql = "SELECT idReceta, porciones FROM receta WHERE idReceta = '{$idReceta}' LIMIT 1";
  $rslt2 = $db->query($sql);
  $porciones = $rslt2->fetch_object()->porciones;

  //se trae los articulos de la receta y sis cantidades
  $sql = "SELECT receta, articulo, cantidad FROM recetaart WHERE receta = '{$idReceta}'";
  $rslt2 = $db->query($sql);

  if( $db->affected_rows === 0 ) continue;

  while( $item2 = $rslt2->fetch_object() ){

    $idArticulo = $item2->articulo;
    $cantidad = $item2->cantidad;
    $cantidad = ($cantidad / $porciones ) * $personas;

    $costoU = 0;

    //se trae el costo uniotario, presetnacion y linea
    $sql = "SELECT idArticulo, costo, linea, unidadA FROM articulo WHERE idArticulo = '{$idArticulo}' LIMIT 1";
    $rslt3 = $db->query($sql);

    // echo " $sql <br> ";
    if( $db->affected_rows > 0 ){
      $rslt3 = $rslt3->fetch_object();
      $costoU = $rslt3->costo;
      $linea = $rslt3->linea;
      $presentacion = $rslt3->unidadA;
    }

    $costoT = $costoU * $cantidad;

    $idProveedor = '';
    $sql = "SELECT proveedor, articulo, precio, activo FROM precioProv WHERE articulo = '{$idArticulo}' AND precio = '{$costoU}' LIMIT 1";
    $rslt3 = $db->query($sql);

    if( $db->affected_rows > 0 )
      $idProveedor = $rslt3->fetch_object()->proveedor;


    $sql = "INSERT INTO bom ( fechaI, fechaF, hoja, cliente, unidad, articulo, linea, cantidad, proveedor, presentacion, costoU, costoT, fecha) VALUES ( '{$fechaI}', '{$fechaF}', '{$hoja}', '{$cliente}', '{$unidad}', '{$idArticulo}', '{$linea}', '{$cantidad}', '{$idProveedor}', '{$presentacion}', '{$costoU}', '{$costoT}', now() )";
    $db->query($sql);


  }


}//endWhile principal



//segunda parte
//segunda parte
//segunda parte


//recuperar todo lo que se guardo en bom
$sql = "SELECT hoja, cliente, unidad, articulo, linea, cantidad, proveedor, presentacion, costoU, costoT FROM bom ORDER BY hoja, cliente, unidad, linea, articulo";
$rslt = $db->query($sql);

$hojaAnt = $clienteAnt = $unidadAnt = $idarticuloAnt = '';

$costoUTotLin = $costoTTotLin = 0;

while( $item = $rslt->fetch_object() ){

  $hoja         = $item->hoja;
  $cliente      = $item->cliente;
  $unidad       = $item->unidad;
  $idArticulo   = $item->articulo;
  $linea        = $item->linea;
  $cantidad     = $item->cantidad;
  $idProveedor  = $item->proveedor;
  $presentacion = $item->presentacion;
  $costoU       = $item->costoU;
  $costoT       = $item->costoT;



  //cada que cambie de unidad se crea una hoja de excel
  //se checa que no sea nueva hoja

  //cuando la hoja es diferente, debeo crear un header por cada hoham debo crear una hoja, debo establecer la hoja del excel activa,
  //y debo de reealizar la suma de la linea de la hoja anterior
  if( $hoja != $hojaAnt || $unidad != $unidadAnt ){

    // $clienteAnt = $cliente;
    $unidadAnt = $unidad;
    $hojaAnt = $hoja;

    //cuando la hoja sea 0 no debe de hacer la sumatoria de la hoja anterior, ya que no existe     
    if( ( $hoja - 1 ) != 0 ){//las hojas del excel empiezan por 0, pero los libros ya crean una hoja con indice 0, por eso no se debe crear

      //cuando sea una nueva hoja y se que mi hoja es diferente de 0, osea de la hoja inicial, osea que hay hojas anteteriores, entonces debo de realizar la sumatoria de la hoja anterior que si existe, 
      $indexRow++;//añadimos un nuevo renglon al indice

      //añadimos las celdas
      $sheet->setCellValue("F{$indexRow}", 'Total:' );
      $sheet->setCellValue("G{$indexRow}", $costoUTotLin );
      $sheet->setCellValue("H{$indexRow}", $costoTTotLin );

      //$indexRow++;//no veo la razon para agregar un nuevo renglon
      $costoUTotLin = $costoTTotLin = 0;//como fue un cambio de hoja, reeteamos los valores de costos de linea, ya que cambio la hoja

    }
    else{
      //la hoja menos 1 es 0 y 0 es diferente de 0, falso, por eso entra aqui, cuando pase eso no se hace nada, creo

    }

    //si hoja es diferente de 0 creamos nueva hoja, osea que cuando hoja de la base de datos sea 1 no se crea, ( 1 - 0 != 0 => false )
    if( ( $hoja - 1 ) != 0 ){
      $spreadsheet->createSheet();//crea una nueva hoja de calculo
    }

    //establecemos la hoja de calculo activa
    $spreadsheet->setActiveSheetIndex( $hoja - 1 );
    $sheet = $spreadsheet->getActiveSheet();

    //get nombre cliente
    $sql = "SELECT idCliente, nombre FROM cliente WHERE idCliente = '{$cliente}' LIMIT 1";
    $rslt2 = $db->query($sql);
    $clienteNombre = $rslt2->fetch_object()->nombre;

    //get name unidad
    $sql = "SELECT idUnidad, cliente, unidad FROM unidad WHERE idUnidad = '{$unidad}' AND cliente = '{$cliente}' LIMIT 1";
    $rslt2 = $db->query($sql);
    $unidadNombre = $rslt2->fetch_object()->unidad;

    //creamos cabecera de la hoja
    $indexRow = 0;//comenzamos los renglones en 0
    headerExcel( $clienteNombre, $unidadNombre, $indexRow );

    $lineaAnt = '';//limpiamos la lineaAnt, ya que cambio la unidad

    ///////////////////
    ///////////////////
    ///////////////////


  }//termina cuando la hoja es diferente

  //aqui cuando la hoja sea igual

  // $hojaAnt = $hoja;
  // $clienteAnt = $cliente;
  // $unidadAnt = $unidad;

  //se verifica que no sea producto nuevo
  if( $idArticulo != $idarticuloAnt ){

    $indexRow++;

    $idarticuloAnt = $idArticulo;
    //se trae el total de articulo
    $sql = "SELECT SUM(cantidad) AS cantTot FROM bom WHERE articulo = '{$idArticulo}' AND cliente = '{$cliente}' AND unidad = '{$unidad}'";

    $rslt2 = $db->query($sql);
    if( $db->affected_rows > 0 ){
      $cantidad = $rslt2->fetch_object()->cantTot;
      $costoT = $costoU * $cantidad;
      
      if( $costoT < 0 ){
        $costoT = 0;
      }

    }

    //se trae nombre del articulo
    $sql = "SELECT idArticulo, nombre, unidad FROM articulo WHERE idArticulo = '{$idArticulo}'";
    $rslt2 = $db->query($sql);
    if( $db->affected_rows > 0 ){
      $rslt2 = $rslt2->fetch_object();
      $articulo = $rslt2->nombre;
      $unidadM = $rslt2->unidad;
    }

    $sql = "SELECT idLinea, descripcion FROM linea WHERE idLinea = '{$linea}'";
    $rslt2 = $db->query($sql);
    if( $db->affected_rows > 0 ){
      $linea = $rslt2->fetch_object()->descripcion;
    }

    // $sql = "SELECT idProveedor, nombre FROM proveedor WHERE idProveedor = '{$idProveedor}'";
    // $rslt2 = $db->query($sql);
    // if( $db->affected_rows > 0 ){
    //   $proveedor = $rslt2->fetch_object()->nombre;
    // }

    //
    // $spreadsheet->setActiveSheetIndex( $hoja - 1 );
    // $sheet = $spreadsheet->getActiveSheet();
    
    //abreviar texto
    $unidadM = getUnidadM($unidadM);
    $presentacion = getUnidadM($presentacion);

    $cantidad = number_format($cantidad, 2, '.', '');

    if( $linea != $lineaAnt ){//cuando la linea del articulo sea diferente, se realiza la sumatoria y se coloca el nombre de la linea

      if( $indexRow > 9 ){//si el indice de la fila es mayor a 8, se añade la sumatoria, ya que puede entrar aqui cuando inicia la hoja

        $sheet->setCellValue("F{$indexRow}", 'Total2:' );
        $sheet->setCellValue("G{$indexRow}", $costoUTotLin );
        $sheet->setCellValue("H{$indexRow}", $costoTTotLin );

        $indexRow++;//agrega un nuevo renglon para la siguiente linea
        $costoUTotLin = $costoTTotLin = 0;//resetea los valores de las sumatorias

      }

      $sheet->setCellValue("A{$indexRow}", $linea );

    }

    //colocamos los valores
    $sheet->setCellValue("B{$indexRow}", $idArticulo );
    $sheet->setCellValue("C{$indexRow}", $articulo );
    $sheet->setCellValue("D{$indexRow}", $presentacion );
    $sheet->setCellValue("E{$indexRow}", $unidadM );
    $sheet->setCellValue("F{$indexRow}", $cantidad );
    $sheet->setCellValue("G{$indexRow}", $costoU );
    $sheet->setCellValue("H{$indexRow}", $costoT );

    $costoUTotLin += $costoU;//ponemos la sumatoria
    $costoTTotLin += $costoT;

    $lineaAnt = $linea;

  }

}

$indexRow++;
$sheet->setCellValue("F{$indexRow}", 'Total:' );
$sheet->setCellValue("G{$indexRow}", $costoUTotLin );
$sheet->setCellValue("H{$indexRow}", $costoTTotLin );

// $indexRow++;
// $costoUTotLin = $costoTTotLin = 0;


//OUTPUT XLSX

header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=explosionPorUnidad ($fechaI - $fechaF).xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

