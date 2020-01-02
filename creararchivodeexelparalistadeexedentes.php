<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
<link rel="stylesheet" href="css1/style.css">
<link rel="stylesheet" href="css2/style.css">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="color: #337ab7;">Generación de Archivos de Exedentes</h1>
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


                <div class="row" style="margin-top: 20px;">
                <div class="col-md-2">
                <label style="color: #337ab7;padding-left: 200px;margin-top: 8px;">*Cliente:</label>
                </div>
                <div class="col-md-8 col-sm-12">
                <select class="form-control" id="rol" style="width: 100%;margin-left: 40px;">
                    <option disabled selected> -- Selecione Cliente -- </option>
                    <option>Administrador</option>
                    <option>Usuario</option>
                </select>
                </div>
                </div>

                <div class="row" style="margin-top: 20px;">
                <div class="col-md-2">
                <label style="color: #337ab7;padding-left: 200px;margin-top: 8px;">*Unidad:</label>
                </div>
                <div class="col-md-8 col-sm-12">
                <select class="form-control" id="rol" style="width: 100%;margin-left: 40px;">
                    <option disabled selected> -- Selecione Unidad -- </option>
                    <option>Administrador</option>
                    <option>Usuario</option>
                </select>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                <button style="margin-left: 700px;margin-top: 100px;margin-bottom: 100px;font-size: 18px;" class="btn btn-default"><b>Generaciòn de Archivo</b></button>
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