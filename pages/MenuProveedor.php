
<div class="mt-20-px"></div>
<div class="row my-1">
    <div class="col-xs-12">
        
        <div id="panel-1-contenedor" class="panel panel-default">
            
            <div class="panel-heading text-white bg-coral">Menú proveedor</div>

            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li>
                        <a data-toggle="tab" data-texto="Menú proveedor: Registrar" data-archivo="RegistrarProveedor.php" data-botones="Limpiar:limpiarForm() Registrar:registrar()">Registrar</a>
                    </li>
                    <li>
                        <a data-toggle="tab" data-texto="Menú proveedor: Eliminar" data-archivo="Eliminar.php" data-botones="Eliminar:eliminar()" data-contexto="eliminar">Eliminar</a>
                    </li>
                    <li>
                        <a data-toggle="tab" data-texto="Menú proveedor: Consultar" data-archivo="Consultar.php" data-contexto="consultar">Consultar</a>
                    </li>
                    <li>
                        <a data-toggle="tab" data-texto="Menú proveedor: Modificar" data-archivo="Modificar.php" data-botones="Cancelar:cancelar() Guardar-cambios:guardarCambios()" data-contexto="modificar">Modificar</a>
                    </li>
                    <li>
                        <a data-toggle="tab" data-menu="menu-precioprov" data-archivo="MenuListaPrecios.php">Precios</a>
                    </li>
                </ul>

                <div class="row">
                    <div id="contenedor-args-busqueda" class="col-xs-12 text-right text-white">
                        <!-- <div class="form-group"> -->
                            <!-- <form action="" class="form-inline"> -->
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
                                    <option>Inválido</option>
                                </select>
                                <label>Pagina</label>
                                <select class="text-dark" id="arg-3" name="desface">
                                    <option>Inválido</option>
                                </select>
                            <!-- </form> -->
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

    </div>
</div>


<script>
    $('.nav-tabs').on('click', 'a[data-toggle="tab"]', function(ev){

    });
</script>