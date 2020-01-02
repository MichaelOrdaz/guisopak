<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
<link rel="stylesheet" href="css1/style.css">
<link rel="stylesheet" href="css2/style.css">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="color: #337ab7;">Generación de oc general</h1>
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

                    <div class="col-md-6" style="margin-top: 20px;">
                    <div id="calendar">
                    <b>*Fecha inicio:</b>
                    <br>
                    <br>
                    <div id="calendar_header"><i class="icon-chevron-left"></i><h1></h1><i class="icon-chevron-right"></i></div>
                    <div id="calendar_weekdays"></div>
                    <div id="calendar_content"></div>
                    </div>
                    </div>

                    <div class="col-md-6" style="margin-top: 20px;">
                    <div id="calendar1">
                    <b>*Fecha final:</b>
                    <br>
                    <br>
                    <div id="calendar_header1"><i class="icon-chevron-left"></i><h1></h1><i class="icon-chevron-right"></i></div>
                    <div id="calendar_weekdays1"></div>
                    <div id="calendar_content1"></div>
                    </div>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                </div>

                <div class="row">

                    <div class="col-md-6" style="margin-top: 30px;padding-left: 40px;margin-bottom: 20px;">
                    </div>

                    <div class="col-md-6" style="margin-top: 30px;padding-left: 40px;margin-bottom: 29px;">
                    <button class="btn btn-primary btn-lg btn-block">Generar O.C. sin presentación</button>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
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