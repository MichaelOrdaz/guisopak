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
$db->query("DELETE FROM bom");//limpiamos bom

$sql = "SELECT art.idArticulo, art.linea, me.unidad, me.cliente, art.unidadA, reart.cantidad, art.costo, re.porciones, mr.personas FROM articulo AS art INNER JOIN recetaart AS reart ON reart.articulo = art.idArticulo INNER JOIN receta AS re ON re.idReceta=reart.receta INNER JOIN menurec AS mr ON mr.receta=re.nombre INNER JOIN menu AS me ON me.idMenu=mr.idMenu WHERE (mr.fecha >= '{$fechaI}') AND (mr.fecha <= '{$fechaF}' ) AND me.activo = '1' ORDER BY me.cliente, me.unidad, mr.receta, me.grupo, mr.fecha";

$rslt = $db->query( $sql );

$db->affected_rows > 0 or die('No hay información en el periodo solicitado');

//instanciamos el objeto 
$spreadsheet = new Spreadsheet();

while( $item = $rslt->fetch_object() ){

  $cantidad = ($item->cantidad / $item->porciones) * $item->personas;
  // $costoT = $cantidad * $item->costo;

  $sql = "INSERT INTO bom ( fechaI, fechaF, cliente, unidad, articulo, linea, cantidad, presentacion, costoU) VALUES ( '{$fechaI}', '{$fechaF}', '{$item->cliente}', '{$item->unidad}', '{$item->idArticulo}', '{$item->linea}', '{$cantidad}', '{$item->unidadA}', '{$item->costo}' )";
  $db->query($sql);

}


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


//segunda parte
//segunda parte
//segunda parte

//recuperar todo lo que se guardo en bom
$sql = "SELECT unidad, cliente, articulo, linea, SUM(cantidad) AS cantidad, presentacion, costoU FROM bom GROUP BY articulo, unidad ORDER BY unidad, linea";
$rslt = $db->query($sql);
$hojaAnt = $clienteAnt = $unidadAnt = $idarticuloAnt = '';
$itemsBom = [];
$hoja = 0;

while( $item = $rslt->fetch_object() ){

  // $hoja         = $item->hoja;
  $cliente      = $item->cliente;
  $unidad       = $item->unidad;
  $idArticulo   = $item->articulo;
  $linea        = $item->linea;
  $cantidad     = $item->cantidad;
  $presentacion = $item->presentacion;
  $costoU       = $item->costoU;

  //cada que cambie de unidad se crea una hoja de excel
  //se checa que no sea nueva hoja

  //cada que cambia unidad, se crea una nueva hoja
  if( $unidad != $unidadAnt ){
    //como es una unidad nueva, agregamos una nueva hoja
    
    if( $unidadAnt !== '' ){//solo cuando unidadAnt, sea vacio, osea la primera vez, no creamos hoja, ya que ya existe
      $spreadsheet->createSheet();//crea una nueva hoja de calculo

      $indexRow++;//agrega un nuevo renglon
      //coloca el total
      $sheet->setCellValue("F{$indexRow}", 'Total B:' );
      $sheet->setCellValue("G{$indexRow}", $costoUTotLin );
      $sheet->setCellValue("H{$indexRow}", $costoTTotLin );
    }
    else{
      //aqui se que unidadAnt es diferente de vacio y que la unidad anteriro cambio
      ////entonces puedo decir que aqui debo hacer la sumatoria de la ultima linea de la hoja anterior
  
    }

    //establecemos la hoja de calculo activa
    $spreadsheet->setActiveSheetIndex( $hoja );
    $sheet = $spreadsheet->getActiveSheet();

    $unidadAnt = $unidad;//hacemos el cambio de variable
    $lineaAnt = $linea;//aqui como sabemos que es una hoja nueva, es linea nueva.

    $costoUTotLin = $costoTTotLin = 0;//inicialimaos la suma de las lineas

    $hoja++;//controlador de la Hoja

    //get nombre cliente
    $sql = "SELECT idCliente, nombre FROM cliente WHERE idCliente = '{$cliente}' LIMIT 1";
    $rslt2 = $db->query($sql);
    $clienteNombre = $rslt2->fetch_object()->nombre;

    //get name unidad
    $sql = "SELECT idUnidad, cliente, unidad FROM unidad WHERE idUnidad = '{$unidad}' AND cliente = '{$cliente}' LIMIT 1";
    $rslt2 = $db->query($sql);
    $unidadNombre = $rslt2->fetch_object()->unidad;

    //creamos cabecera de la hoja
    $indexRow = 0;//comenzamos los renglones en 0 en cada nueva hoja
    headerExcel( $clienteNombre, $unidadNombre, $indexRow );

  }


  //cuando la linea cambie debemos hacer la sumatoria de esa linea
  if( $linea != $lineaAnt ){//cuando la linea del articulo sea diferente, se realiza la sumatoria y se coloca el nombre de la linea

    // if( $indexRow > 9 ){//si el indice de la fila es mayor a 8, se añade la sumatoria, ya que puede entrar aqui cuando inicia la hoja

      $indexRow++;//agrega un nuevo renglon
      //coloca el total
      $sheet->setCellValue("F{$indexRow}", 'Total A:' );
      $sheet->setCellValue("G{$indexRow}", $costoUTotLin );
      $sheet->setCellValue("H{$indexRow}", $costoTTotLin );

      $indexRow++;//agrega un nuevo renglon para la siguiente linea
      $costoUTotLin = $costoTTotLin = 0;//resetea los valores de las sumatorias

    // }

    // $sheet->setCellValue("A{$indexRow}", $linea );

  }

  $lineaAnt = $linea;

  ///ahora añadimos los articulos
  $costoT = $costoU * $cantidad;
  if( $costoT < 0 )
    $costoT = 0;

  //del articulo se trae su nombre y su unidad y se trae el nombre de la linea de ese articulo
  $sql = "SELECT nombre, unidad, (SELECT descripcion FROM linea WHERE idLinea = linea) AS linea FROM articulo WHERE idArticulo = '{$idArticulo}' LIMIT 1";
  $rslt2 = $db->query($sql);
  $rslt2 = $rslt2->fetch_object();
  $articulo = $rslt2->nombre;
  $unidadM  = $rslt2->unidad;
  $linea    = $rslt2->linea;

  //abreviamos
  $unidadM = getUnidadM($unidadM);
  $presentacion = getUnidadM($presentacion);

  $cantidad = number_format($cantidad, 2, '.', '');

  //colocamos los valores
  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", $linea );
  $sheet->setCellValue("B{$indexRow}", $idArticulo );
  $sheet->setCellValue("C{$indexRow}", $articulo );
  $sheet->setCellValue("D{$indexRow}", $presentacion );
  $sheet->setCellValue("E{$indexRow}", $unidadM );
  $sheet->setCellValue("F{$indexRow}", $cantidad );
  $sheet->setCellValue("G{$indexRow}", $costoU );
  $sheet->setCellValue("H{$indexRow}", $costoT );

  $sheet->getStyle("A{$indexRow}:H{$indexRow}")->getAlignment()->setWrapText(true);

  $costoUTotLin += $costoU;//ponemos la sumatoria
  $costoTTotLin += $costoT;

}

//esto es para la ultima sumatoria
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

