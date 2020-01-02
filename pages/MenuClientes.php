<div class="mt-20-px"></div>
<div id="panel-1-contenedor" class="panel panel-default">
    
    <div class="panel-heading text-white bg-coral">Menú Clientes</div>
    <div class="panel-body">

        <ul class="nav nav-tabs">
            <li>
                <a data-toggle="tab" data-texto="Menú Clientes: Registrar" data-archivo="RegistrarCliente.php" data-botones="Registrar:registrar()">Registrar</a>
            </li>
            <li>
                <a data-toggle="tab" data-texto="Menú Clientes: Eliminar" data-archivo="Eliminar.php" data-botones="Eliminar:eliminar()" data-contexto="eliminar">Eliminar</a>
            </li>
            <li>
                <a data-toggle="tab" data-texto="Menú Clientes: Consultar" data-archivo="Consultar.php" data-contexto="consultar">Consultar</a>
            </li>
            <li>
                <a data-toggle="tab" data-texto="Menú Clientes: Modificar" data-archivo="Modificar.php" data-botones="Guardar-cambios:guardarCambios()" data-contexto="modificar">Modificar</a>
            </li>
            <li>
                <a data-toggle="tab" data-archivo="MenuUnidad.php" data-menu="menu-unidad">Unidad</a>
            </li>
            <li>
                <a data-toggle="tab" data-archivo="MenuSubunidad.php" data-menu="menu-subunidad">Sub unidad</a>
            </li>
        </ul>
        <!-- /.nav nav-tabs -->

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

        <div id="tab-contenedor" class="tab-content"></div>
        <!-- /.tab-content -->

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