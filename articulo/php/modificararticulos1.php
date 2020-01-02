<?php

include '../../db/conexion.php';

$nombre=$_POST['nombre'];

$cont=0;

$consulta = "SELECT idArticulo,linea,unidad,unidadA,factor,minimo,maximo,info FROM articulo  WHERE nombre = '$nombre' ";

$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1) {
$json='{"idArticulo": "'.$columna['idArticulo'].'","linea": "'.$columna['linea'].'","unidad": "'.$columna['unidad'].'","unidadA": "'.$columna['unidadA'].'",
"factor": "'.$columna['factor'].'","minimo": "'.$columna['minimo'].'","maximo": "'.$columna['maximo'].'","info": "'.$columna['info'].'"}';
}
if ($cont>1) {
$json.=',{"idArticulo": "'.$columna['idArticulo'].'","linea": "'.$columna['linea'].'","unidad": "'.$columna['unidad'].'","unidadA": "'.$columna['unidadA'].'",
"factor": "'.$columna['factor'].'","minimo": "'.$columna['minimo'].'","maximo": "'.$columna['maximo'].'","info": "'.$columna['info'].'"}';
}
}

echo json_encode($json);
?>