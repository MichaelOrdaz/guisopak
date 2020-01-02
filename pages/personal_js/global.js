var __contenedor_menu__ = null;

function asignarFuncionesMenuTabs()
{
	// Primero asignamos las funciones que solon cargan contenido, como un formulario o una tabla
    $("div.panel-body a:not([data-menu])").click(function()
    {
    	cargarContenido( $(this) );
	});	//	=>	Funcion click

    // Segundo, asignamos las funciones que cargan un nuevo menu
	$("div.panel-body a[data-menu]").click(function()
	{
		cargarMenu( $(this).attr("data-menu"), $(this).attr("data-archivo") );
	});	//	=>	Funcion click
}

function cargarMenu(data_menu_nombre, data_menu_archivo)
{
	$.ajax(
	{
		async : false,
		url : __base_dir__ + data_menu_archivo,
		success : function(result, status, xhr)
		{
			__contenedor_menu__.remove( __contenedor_menu__.children() );
			__contenedor_menu__.html( result );
			__contenedor_menu__.attr("data-menu-actual", data_menu_nombre);
			asignarFuncionesMenuTabs();
		},
		complete : function(status, xhr)
		{
			$.getScript( __js_dir__ + "menu.js");
			var dom_a = $("div.panel-body li:first-child a");
			cargarContenido( dom_a );
		}
	});	//	=>	ajax
}

function cargarContenidoPorDefecto()
{
	var texto_pagina_inicio = "contenido-sinmenu";

	// Existe otro contenido
	if ( __contenedor_menu__.attr("data-menu-actual") != texto_pagina_inicio )
	{
		// Borrar el contenido actual
		__contenedor_menu__.empty();

		$.ajax(
		{
			async : false,
			url : "GuisoPak-Logo.php",
			success : function(result, status, xhr)
			{
				__contenedor_menu__.html( result );
				__contenedor_menu__.attr("data-menu-actual", texto_pagina_inicio);
			}
		});	//	=>	ajax
	}	//	=>	if
}	//	=>	Funcion cargarContenidoPorDefecto

function cargarContenido(_a_)
{
	if (_a_)
	{
		if (_a_.attr("data-archivo") != "")
		{
	    	var nombre_archivo = _a_.attr("data-archivo");
	    	var encabezado = $("div[class*='panel-heading']");
	    	var texto = _a_.attr("data-texto");
	    	var pie = $("div.panel-footer");
		    $( "#contenedor-args-busqueda" ).css( "display", "none" );

	    	$.ajax(
    		{
    			async : false,
    			url : __base_dir__ + nombre_archivo,
    			success : function(result, status, xhr)
    			{
			console.log( __contenedor_contenido__ );
					__contenedor_contenido__.remove( __contenedor_contenido__.children() );
					__contenedor_contenido__.html( result );
			    	$("a[class='active']").attr( "class", "" );
			    	_a_.attr("class", "active");
				    encabezado.text( texto );
				    if ( _a_.attr("data-botones") )
						anadirBotones( _a_.attr("data-botones") );
					else
						$("#botones").empty();
					pie.show("slow");
    			}
    		});	//	=>	ajax
		}
	}
}

function hola()
{
	alert( "Hola" );
}

$(document).ready( function()
{
	__contenedor_menu__ = $("div[id='contenedor']");
	__js_dir__ = "./pages/personal_js/";
	__base_dir__ = "./pages/";
	__php_dir__ = "./queries/";
	__table1__ = null;
	__table2__ = null;
	__table3__ = null;
	__iJoin__ = null;

	$("a[data-menu]").click( function()
	{
		cargarMenu($(this).attr("data-menu"), $(this).attr("data-archivo"));
	});	//	=>	clic

	// Cargar el menu por defecto
	cargarContenido();
});