// Para que los labels no esten vacios y se agregue el atributo required
$("[class='form-control'],[class='form-control excluded']").siblings("label").each( function()
{
    var data_texto = $(this).attr("data-texto");

    $(this).text(data_texto);

    if ( data_texto.indexOf("*") > -1 )
        $(this).next().attr("required", "true");
}); //  =>  each

//  =>   <Select> e <input> pertenecen a '.form-control'
//  =>   Estos dos elementos necesitan ser 'required'
$("[class='form-control'][required]").on(
{
    change: function()
    {
        if ( $(this).val().length == 0 )
        {
            var obj_label_ayuda = $("label[id='texto-ayuda']");

            obj_label_ayuda.text("El campo " + $(this).siblings("label").attr("data-texto") + " no puede estar vacio.");
            $(this).css("border-color", "red");
            $(this).focus();

        }
    },   // Fin de la funcion change
    focus: function()
    {
        $(this).css("border-color", "#ccc");
    },  //  =>  Funcion focus
    blur: function()
    {
        if ( $(this).val().length == 0 )
        {
            var obj_label_ayuda = $("label[id='texto-ayuda']");

            obj_label_ayuda.text("El campo " + $(this).siblings("label").attr("data-texto") + " no puede estar vacio.");
            $(this).css("border-color", "red");
            $(this).focus();
        }
    }  //  =>  Funcion blur
}); //Fin de la funcion on

function checarCamposRequire()
{
    var form_elements = $("form input[required], form select[required]");
    var bandera = true;

    form_elements.each( function()
    {
        var div_control = $(this).closest("div[class='form-group']");

        if ( $(this).val().length == 0 )
        {
            div_control.addClass("has-error");
            bandera = false;
        }
        else
        {
            div_control.removeClass("has-error");
        }
    });//    =>  Funcion each

    return bandera;
}   //  =>  Funcion checarCamposRequire


//  =>  Especifico de formulario

//  =>  Formulario 'Registrar precio'
$("select[name='articulo']").on("change", rellenarCamposArticulo);
$("select[name='proveedor']").on("change", rellenarCamposArticulo);
$("form[id='precioXproveedor']").one("mouseover", function()
{
    selectProveedor();
    selectArticulo();
    rellenarCamposArticulo();
});  //  =>  Funcion one

//  =>  Clic en <select> cliente
function selectCliente()
{
    var mi_obj = {
        campos : "idCliente, nombre",
        order : "nombre",
        table : "cliente",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='cliente']")
}

$("select[name='cliente']").one("click", selectCliente);
$("select[name='cliente']").on("change", function()
{
    $("select[name='unidad']").empty();
});//   =>  on

//  =>  Clic en <select> cliente
function selectConsultarUnidades()
{
    var mi_obj = {
        campos : "idUnidad, unidad",
        order : "unidad",
        table : "unidad",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='unidad']" );
}

function selectConsultarUnidadesDadoCliente()
{
    var cliente =  $("select[name='cliente']").val();
    var mi_obj = {
        campos : "idUnidad, unidad",
        condicion : "cliente=" + cliente,
        order : "unidad",
        table : "unidad",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='unidad']" );
}

$("select[name='unidad']").on("click", selectConsultarUnidadesDadoCliente);

//  =>  Clic en <select> articulo
function selectArticulo()
{
    var mi_obj = {
        campos : "idArticulo, nombre",
        table : "articulo",
        order : "nombre",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='articulo']" );
}

// => Consulta los proveedores y los inserta en el select
function selectProveedor()
{
    var mi_obj = {
        campos : "idProveedor, nombre",
        table : "proveedor",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='proveedor']" );
}

function peticionConsultarOpcionesParaSelect( mi_url, select_name )
{
    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : mi_url,
        success : function(result, status, xhr)
        {
            var mi_select = $( select_name );
            var obj = JSON.parse(result);

            mi_select.empty();

            for (var i = 0; i < obj.length; i++)
                mi_select.append(obj[i]);
        }
    }); //  =>  ajax 
}

function rellenarCamposArticulo()
{
    var id_articulo = $("[name='articulo']").val();
    var id_proveedor = $("[name='proveedor']").val();
    URLArgs("clear");
    URLArgs("append", $("[name='articulo']").attr("name") + "=" + id_articulo);
    URLArgs("append", "&" + $("[name='proveedor']").attr("name") + "=" + id_proveedor);
    URLArgs("append", "&table=precioprov");
    URLArgs("append", "&operacion=checar-combinacion-articulo-proveedor");
    var mi_url = URLArgs("get");
    URLArgs("clear");

    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : mi_url,
        success : function(result, status, xhr)
        {
            var obj = JSON.parse(result);

            for( key in obj )
            {
                if (obj[key] === "")
                    obj[key] = "NINGUNA";

                if ( key === "combinacion" )
                    textoAyuda( obj[key] );

                $("[name='" + key + "']").val(obj[key]);
            }
        }
    }); //  =>  ajax
}

function esNumeroDeTelefono()
{
    if ( this.value.search( /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im )  < 0 )
    {
        textoAyuda("El formato del número teléfonico no es válido", "", "Error");
        this.value = "";
    }
    else
        textoAyuda("");
}

function mostrarFormatoNumeroTelefonico()
{
    textoAyuda("Ingrese un número con el siguiente formato: (xxx) xxx-xxxx");
}

function mostrarFormatoNumeroTelefonico()
{
    textoAyuda("Ingrese un número con el siguiente formato: (xxx) xxx-xxxx");
}

function soloNumeros()
{
    if ( this.value.search( /\D/ ) > 0 )
    {
        textoAyuda( "Ingrese unicamente digitos" );
        this.value = "";
    }
    else
        textoAyuda( "" );
}

function palabra(texto)
{
    if ( texto.search( /^[A-Z][a-z]+$/ )  < 0 ) 
        return false;

    return true;
}

function myTrim( texto )
{
  return texto.replace(/^\s+|\s+$/gm,'');
}

function soloPalabras()
{
    var texto = this.value;
    var palabras = [];

    texto = myTrim( texto );
    palabras = texto.split(" ");

    for ( var i = 0; i < palabras.length; i++ )
    {
        if ( !palabra( palabras[ i ] ) )
        {
            textoAyuda( "La palabra: \"" + palabras[ i ] + "\" no cumple con el formato de nombre válido" );
            this.value = "";

            break;
        }
    }
}

function estaEnRango()
{
    var mi_numero = ( isNaN( this.value ) ) ? -1 : Number( this.value );
    var min = Number( this.min );
    var max = Number( this.max );

    if ( isNaN( this.value ) || ( mi_numero < min ) || ( mi_numero > max ) )
    {
        textoAyuda( "El número debe estar dentro del rango ( " + this.min + " , " + this.max + " ). Por seguridad su valor será cambiado al mínimo valor permitido ( " + this.min + " )" );
        this.value = min;
    }
    else
        textoAyuda( "" );
}

function rfc()
{
    if ( this.value.search( /([A-Z]{3} [0-9]{6}) [A-Z]{3}$/ ) == -1 )
    {
        this.value = "";
        textoAyuda( "Formato de RFC inválido, use letras mayúsculas" );
    }
    else
        textoAyuda( "" );
}