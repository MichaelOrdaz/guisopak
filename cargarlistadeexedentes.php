<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
<link rel="stylesheet" href="css1/style.css">
<link rel="stylesheet" href="css2/style.css">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="color: #337ab7;">Carga de Exedentes</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="text-align: right; background-color: #EE7561;height: 40px;">
            </div>
            <div class="panel-body">

                <div class="row">
                <div class="col-md-12">
                <button style="margin-left: 550px;margin-top: 100px;margin-bottom: 15px;font-size: 18px;" class="btn btn-default"><b>Carga de Exedentes</b></button>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                <button style="margin-left: 552px;margin-top: 15px;margin-bottom: 30px;font-size: 18px;" class="btn btn-default"><b>Eliminar Exedentes</b></button>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12" style="padding-left: 365px;">
                para generar la carga de exedentes se deve de colocar el archivo exedentes.xls en la carpeta jace 
                </div>
                </div>

                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

$("#consultar").click(function(){
$("#contenedor").load('consultarusuarios.php');
});

$("#modificar").click(function(){
$("#contenedor").load('modificarusuarios.php');
});

$("#eliminar").click(function(){
$("#contenedor").load('eliminarusuarios.php');
});

$("#agregar").click(function(){
$.ajax({
type: 'POST',
url: 'formusuario.php',
data:{
nombre:$("#nombre").val(),
usuario:$("#usuario").val(),
contrasena:$("#contrasena").val(),
rol:$("#rol").val(),
direccion:$("#direccion").val(),
teléfono:$("#telefono").val()
},
success: function(data){
}
});
});

</script>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js1/index.js"></script>
<script src="js2/index.js"></script>