//  =>   El usuario da clic en una fila de la tabla
$("tbody tr").on("click", function(event)
{
  event.stopImmediatePropagation();
  $(this).toggleClass("alert alert-danger elegido");
  textoAyuda("Para eliminar los registros seleccionados, filas de color rojo, pulse el botón 'Eliminar'");
}); //  Funcion on

$("div[id='contenedor-args-busqueda']").show();