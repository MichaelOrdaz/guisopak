
<div class="mt-20-px"></div>
<div id="panel-1-contenedor" class="panel panel-default">

    <div class="panel-heading text-white bg-coral">Menú Subunidades</div>

    <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li>
                <a data-toggle="tab" data-texto="Menú subunidades: Agregar" data-archivo="RegistrarSubnidad.php" data-botones="Registrar:registrarPrecio()">Registrar</a>
            </li>
            <li>
                <a data-toggle="tab" data-texto="Menú subunidades: Eliminar" data-archivo="Eliminar.php" data-botones="Eliminar:eliminarPrecio()" data-contexto="eliminar">Eliminar</a>
            </li>
            <li>
                <a data-toggle="tab" data-texto="Menú subunidades: Consultar" data-archivo="Consultar.php" data-contexto="consultar">Consultar</a>
            </li>
            <li>
                <a data-toggle="tab" data-texto="Menú subunidades: Modificar" data-archivo="Modificar.php" data-botones="Guardar-cambios:guardarCambiosPrecio()" data-contexto="modificar">Modificar</a>
            </li>
            <li>
                <a data-toggle="tab" data-menu="menu-cliente" data-archivo="MenuClientes.php">Cliente</a>
            </li>
        </ul>

        <div class="row">
            <div id="contenedor-args-busqueda"class="col-xs-12 text-right">
                <!-- <div class="form-group"> -->
                    <label>Filas:</label>
                    <select class="text-dark" id="arg-1" name="filas">
                        <option>5</option>
                        <option>10</option>
                        <option>15</option>
                        <option>20</option>
                    </select>
                <!-- </div> -->
                <!-- <div class="form-group"> -->
                    <label>Ordenar por:</label>
                    <select class="text-dark" id="arg-2" name="criterio">
                        <option value="nombre">Nombre</option>
                        <option value="idProveedor">Clave</option>
                    </select>
                    <label>Pagina</label>
                    <select class="text-dark" id="arg-3" name="desface">
                        <option>1</option>
                    </select>
                <!-- </div> -->
            </div>
        </div>

        <!-- Tab panes -->
        <div id="tab-contenedor" class="tab-content"></div>

    </div>
    <!-- /.panel-body -->

    <div class="panel-footer" style="display:none;">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div id="texto-ayuda"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div id="botones"></div>
            </div>
        </div>
    </div>
    <!-- /.panel-footer -->

</div>