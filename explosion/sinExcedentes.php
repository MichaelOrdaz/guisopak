<?php
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

//se elimina completamente la tabla bom
//no se p'or que pero se elimina
// $db->query("DELETE FROM bom");

$dt = new DateTime( $start );
$semana = $dt->format('W');

function headerExcel( $cliente, $unidad ){
  global $semana, $sheet, $start, $end;

  $indexRow = 1;
  //titulo
  $sheet->mergeCells("A{$indexRow}:H{$indexRow}");
  $sheet->setCellValue("A{$indexRow}", "GUISOPAK");
  $sheet->getStyle("A{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  $indexRow++;
  //receta nombre
  $sheet->mergeCells("A{$indexRow}:H{$indexRow}");
  $sheet->setCellValue("A{$indexRow}", "Explosión de materiales de artículos");
  $sheet->getStyle("A{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("A{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

  //fecha
  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Semana:");//semana
  $sheet->setCellValue("B{$indexRow}", $semana);//semana

  $sheet->setCellValue("C{$indexRow}", "Fecha");
  $sheet->setCellValue("D{$indexRow}", $start .' - ' . $end);

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Cliente:" );
  $sheet->setCellValue("B{$indexRow}", $cliente );

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Unidad:" );
  $sheet->setCellValue("B{$indexRow}", $unidad );

  $indexRow += 2;
  $titulos = ['A'=> 'Línea', 'B'=> 'ID Artículo', 'C'=> 'Descripción', 'D'=> 'Presentación', 'E'=> 'Unidad', 'F'=> 'Cantidad', 'G'=> 'Costo Unidad', 'H'=> 'Costo Total'];
  $sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFont()->setBold(true);
  $sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

  foreach ($titulos as $key => $title){
    $sheet->getColumnDimension($key)->setAutoSize(true);
    $sheet->setCellValue("{$key}{$indexRow}", " $title");
  }


}


//se crea el numero de paginas necesarias, con este query
// $sql = "SELECT DISTINCT menu.cliente, menu.unidad FROM menu INNER JOIN menuRec ON menu.idMenu = menuRec.idMenu WHERE menuRec.fecha BETWEEN '{$start}' AND '{$end}' AND menu.activo = 1";
// var_dump($sql);
// $r = $db->query($sql);

// empty( $db->error ) or die( 'Error obteniendo datos' );
// $clientesUnidad = $r->fetch_object();

//al parecer en visual basic lo que hace es iniciar un contador en 0
//wn un while mientras existan mas registros aumenta el contador
//al final de cuentas su contador poseera el total de registros que se obtiene del query
// $filas = $db->affected_rows;//numero de hojas que se van a crear al parecer

// var_dump($filas);


//trae  toda la informacion de menu que corresponde con el rango de fechas

$sql = "SELECT me.idMenu, 
(SELECT nombre FROM cliente WHERE idCliente = me.cliente LIMIT 1) AS cliente,
 (SELECT unidad FROM unidad WHERE idUnidad = me.unidad AND cliente = me.cliente LIMIT 1) AS unidad, 
 me.cliente AS clienteId, 
 me.unidad AS unidadId, 
 (SELECT idReceta FROM receta WHERE nombre = mr.receta LIMIT 1) AS idReceta, 
 mr.receta, 
 mr.fecha, 
 me.grupo, 
 mr.personas, 
 mr.pos, 
 mr.precio 
 FROM 
 menu AS me INNER JOIN menuRec AS mr ON mr.idMenu = me.idMenu 
 WHERE 
 mr.fecha BETWEEN '{$start}' AND '{$end}' AND me.activo = 1 
 ORDER BY me.cliente, me.unidad, mr.receta, me.grupo, mr.fecha";
 
$r = $db->query( $sql );
// var_dump($db->affected_rows);

// este trae muchos registros

//dice que por cada cliente y unidad se hace una hoja de excel

//aqui al parecer hace un bucle de la consulta anterior
//en cada iteracion


//obtejemos la hoja de calculo activa

$hoja = 0;//hoja cero seria por que ya existe una hoja de trabajo
$clienteAnt = '';
$unidadAnt = '';
while( $row = $r->fetch_object() ){
  //en cada iteracion se tra los idMenu que corrsponden al año, semana

  //idMenu, cliente (id), unidad (id), receta, fecha, grupo (id), personas (int), pos (int), precio (money)

  //tiene una condicion de que si 
  //cliente != clienteAnt || unidad != unidadAnt
  //cuando el cliente y unidad son diferentes del anterior 
  //a hoja le agrega suma uno y cambia clienteAnt con el actual 
  //unidadAnt con la actual
  //
  //luego con ese cliente

  if( $row->clienteId != $clienteAnt || $row->unidadId != $unidadAnt ){


    //aqui aparentemente crea una nueva hoja
    // agregamos el encabezado

    //si hoja es igual a cero estamos usando la hoja actual que crea por defecto spreadsheet
    //si ya no es la hoja cero, creamos una nueva hoja de calculo

    if( $hoja !== 0 )
      $spreadsheet->createSheet();//crea una nueva hoja de calculo

    //establecemos la hoja de calculo activa como la primera
    $spreadsheet->setActiveSheetIndex( $hoja );
    $sheet = $spreadsheet->getActiveSheet();

    //write en cada hoja
    // $sheet->setCellValue("A1", 'Hola');//porcion

    $hoja++;//se crea una nueva hoja, solo si se cumple la condicion de arriba
    $clienteAnt = $row->clienteId;
    $unidadAnt = $row->unidadId;

    //crea el header de cada excel
    headerExcel( $row->cliente, $row->unidad );




    //se trae el nombre del cliente
    // $sql = "SELECT idCliente, nombre FROM cliente WHERE idCliente = '{$row->cliente}'";
    // $queryClient = $db->query($sql);
    // $infoCliente = $queryClient->fetch_object();//info del cliente

    // //ahora dice que del query si
    // //si no esta vacio, 
    // if( $db->affected_rows ){
    //   $clienteNombre = $infoCliente->nombre;
    // }

    // //se trae el nombre de la unidad
    // $sql = "SELECT idUnidad, unidad, cliente FROM unidad WHERE idUnidad = '{$row->unidad}' AND cliente = '{$row->cliente}'";
    // $queryUnidad = $db->query($sql);
    // $infoUnidad = $queryUnidad->fetch_object();//info de unidad

    // if( $db->affected_rows ){
    //   $unidadNombre = $infoUnidad->unidad;
    // }


    //encabezado de la hoja de excel



  }


  //se trae el idReceta 
  $sql = "SELECT  FROM receta WHERE nombre = '{$row->receta}'";






}




// $r = $db->query("SELECT * FROM recetaart AS reat LEFT JOIN articulo AS ar ON ar.idArticulo=reat.articulo WHERE reat.receta = '{$idReceta}'");
// empty( $db->error ) or die( 'Error obteniendo articulos' );
// $articulos = [];
// while( $articulos[] = $r->fetch_object() );
// array_pop($articulos);

// //ya tengo articulos y tengo receta

// //instanciamos el objeto 
// $spreadsheet = new Spreadsheet();
// //obtejemos la hoja de calculo activa
// $sheet = $spreadsheet->getActiveSheet();

// $indexRow = 1;
// //titulo
// $sheet->mergeCells("A{$indexRow}:F{$indexRow}");
// $sheet->setCellValue("A{$indexRow}", "GUISOPAK");
// $sheet->getStyle("A{$indexRow}")->getFont()->setBold(true)->setSize(14);
// $sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// $indexRow++;
// //receta nombre
// $sheet->mergeCells("A{$indexRow}:F{$indexRow}");
// $sheet->setCellValue("A{$indexRow}", "Receta de: " . $receta->nombre);
// $sheet->getStyle("A{$indexRow}")->getFont()->setBold(true)->setSize(14);
// $sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle("A{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

// //porciones
// $indexRow++;
// $sheet->setCellValue("A{$indexRow}", "Porciones:");//porcion
// $sheet->setCellValue("B{$indexRow}", $receta->porciones);//porcion

// // $indexRow++;
// $sheet->setCellValue("C{$indexRow}", "Costo/Unidad:");//porcion
// $sheet->setCellValue("D{$indexRow}", $receta->costo);//porcion

// $sheet->setCellValue("E{$indexRow}", "Costo Total:");//porcion
// $sheet->setCellValue("F{$indexRow}", number_format( $receta->costo * $receta->porciones, 2, '.', '' ) );//porcion

// $indexRow++;
// $sheet->setCellValue("A{$indexRow}", "Tiempo:" );
// $sheet->setCellValue("B{$indexRow}", $receta->asTiempo );

// // $indexRow++;
// $sheet->setCellValue("C{$indexRow}", "Grupo:" );
// $sheet->setCellValue("D{$indexRow}", $receta->asGrupo );

// // $indexRow++;
// $sheet->setCellValue("E{$indexRow}", "Base:" );
// $sheet->setCellValue("F{$indexRow}", $receta->asBase );

// $indexRow += 2;
// $indexHeader = $indexRow;

// $titulos = ['A'=> 'ID Artículo', 'B'=> 'Artículo', 'C'=> 'Unidad', 'D'=> 'Cantidad', 'E'=> 'Costo Unitario', 'F'=> 'Costo Total'];
// $sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFont()->setBold(true);
// $sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

// foreach ($titulos as $key => $title){
//   $sheet->getColumnDimension($key)->setAutoSize(true);
//   $sheet->setCellValue("{$key}{$indexRow}", " $title");
// }


// $costoTotal = 0;
// $indexRow++;
// foreach ($articulos as $row){

//   $costoArticulo = number_format( $row->costo * $row->cantidad, 2, '.', '' );
//   $costoTotal += $costoArticulo;

//   $sheet->setCellValue("A{$indexRow}", $row->idArticulo);
//   $sheet->setCellValue("B{$indexRow}", $row->nombre);
//   $sheet->setCellValue("C{$indexRow}", $row->unidad);
//   $sheet->setCellValue("D{$indexRow}", $row->cantidad);
//   $sheet->setCellValue("E{$indexRow}", $row->costo);
//   $sheet->setCellValue("F{$indexRow}", $costoArticulo );

//   $indexRow++;

// }

// $endRowForeach = ($indexRow - 1);//la ultima fila donde se dibujaron textos

// $sheet->setCellValue("E{$indexRow}", "Total" );
// $sheet->setCellValue("F{$indexRow}", number_format( $costoTotal, 2, '.', '' ) );

// // //set autoFilter de un rango
// $sheet->setAutoFilter("A{$indexHeader}:F{$endRowForeach}");

header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=test.xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');