//  =>   Respalda todos los datos ACTUALES de la tabla
function respaldarTabla()
{
  //  =>   Todas las celdas dentro de la tabla
  $("div[data-respaldo]").each( function()
  {
    //  =>   Respalda el dato de esta celda
    $(this).attr("data-respaldo", $(this).text());
    $(this).attr("data-editado", "false");
  });   //  =>  each

  switch ( __contenedor_menu__.attr("data-menu-actual") )
  {
    case "menu-base":
    case "menu-grupo":
    case "menu-linea":
    case "menu-precioprov":
      $("body").on("click", "tr td:nth-child(2) > div", function()
      {
        $(this).attr("contenteditable", "true");
      });

      $("body").on("keyup", "tr td:nth-child(2) > div",function(event)
      {
        if ( $(this).attr("data-respaldo") != $(this).text() )
        {
          $(this).attr("data-editado", "true");
          $(this).css("background-color", "#ffff00");
          $(this).closest("tr").attr("data-editado", "true");
          $(this).closest("tr").css("background-color", "#ffff99");
        }
      });

      textoAyuda("Solo los datos de la segunda columna pueden ser modificados");

    break;

    case "menu-cliente":
    case "menu-proveedor":
      $("body").on("dblclick", "tr :not(td:nth-child(1)) > div", function()
      {
        $(this).attr("contenteditable", "true");
      });

      $("body").on("keyup", "tr :not(td:nth-child(1)) > div",function(event)
      {
        if ( $(this).attr("data-respaldo") != $(this).text() )
        {
          $(this).attr("data-editado", "true");
          $(this).css("background-color", "#ffff00");
          $(this).closest("tr").attr("data-editado", "true");
          $(this).closest("tr").css("background-color", "#ffff99");
        }
      });

      textoAyuda("Los datos de la columna clave no pueden ser modificados");
    break;

    case "menu-subunidad":
    case "menu-unidad":
      $("body").on("dblclick", "tr td:nth-child(3) > div", function()
      {
        $(this).attr("contenteditable", "true");
      });

      $("body").on("keyup", "tr :not(td:nth-child(1)) > div",function(event)
      {
        if ( $(this).attr("data-respaldo") != $(this).text() )
        {
          $(this).attr("data-editado", "true");
          $(this).css("background-color", "#ffff00");
          $(this).closest("tr").attr("data-editado", "true");
          $(this).closest("tr").css("background-color", "#ffff99");
        }
      });

      textoAyuda("Solo los datos de la tercera columna pueden ser modificados");
    break;
  }
} //  =>  respaldarTabla

//  =>   Restablece los datos RESPALDADOS de la tabla
function restaurarRespaldo()
{
  //  =>   Todas las celdas dentro de la tabla
  $("div[data-respaldo]").each( function()
  {
    //  =>   Cargar respaldo
    $(this).text( $(this).attr("data-respaldo") );
  
    //  =>   Editado : No
    $(this).attr("data-editado", "false");

    //  =>   Editado : No
    $(this).closest("tr").attr("data-editado", "false");
    $(this).closest("tr").css("background-color", "#fefefe");
    $(this).css("background-color", "#fefefe");
  });
} //  =>  restaurarRespaldo

$("div[id='contenedor-args-busqueda']").show();


// $("body").on("keyup", ".td_data", function()
// {
//             hola();
//               // if( (event.which == 13 ) || ( event.which == 27) )
//               // {
//                 // $(this).attr("contenteditable", "false");
//                 if ( $(this).attr("data-respaldo") != $(this).text() )
//                 {
//                   $(this).attr("data-editado", "true");
//                   $(this).css("background-color", "#ffff00");
//                   $(this).closest("tr").attr("data-editado", "true");
//                   $(this).closest("tr").css("background-color", "#ffff99");
//                 }
// }); //  =>  on

// $("body").on("keyup", ".td_data",function(event)
// {
  //   if( (event.which == 13 ) || ( event.which == 27) )
  //   {
  //     $(this).attr("contenteditable", "false");
  //     if ( $(this).attr("data-respaldo") != $(this).text() )
  //     {
  //       $(this).attr("data-editado", "true");
  //       $(this).css("background-color", "#ffff00");
  //       $(this).closest("tr").attr("data-editado", "true");
  //       $(this).closest("tr").css("background-color", "#ffff99");
  //     }
  // }
// });

respaldarTabla();