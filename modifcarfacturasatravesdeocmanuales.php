<div class="row" style="margin-top: 31px;">
    <div class="col-lg-12">
        <div class="panel panel-default" style="margin-bottom: 8px;">
            <div class="panel-heading" style="text-align: center; background-color: #EE7561; color: white;">
            Modificar facturas manuales
            </div>
            <div class="panel-body" style="padding: 10px; padding-bottom: 4px;">
                    
                    <div class="row" style="margin-bottom: 5px;"> 
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">ID OC:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="rol" style="height: 28px;">
                    <option disabled selected></option>
                    <option>Administrador</option>
                    <option>Usuario</option>
                    </select>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Cliente:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="" id="nombre" style="height: 24px;">
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Semana:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="" id="nombre" style="height: 24px;">
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>
                    
                    <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Proveedor:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="rol" style="height: 28px;">
                    <option disabled selected></option>
                    <option>Administrador</option>
                    <option>Usuario</option>
                    </select>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Unidades:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="" id="nombre" style="height: 24px;">
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Fecha:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="" id="nombre" style="height: 24px;">
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>


                    <div class="row" style="margin-bottom: 5px;"> 
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Factura:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="" id="nombre" style="height: 24px;">
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
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

<div class="row" style="margin-bottom: 20px;margin-left: 5px;margin-top: 20px;">
<div class="col-md-2">
ID.Articulo                        
<select class="form-control" id="rol">
<option disabled selected> -- Selecione ID Articulo -- </option>
<option>Administrador</option>
<option>Usuario</option>
</select>
</div>
<div class="col-md-2">
Articulo
<select class="form-control" id="rol">
<option disabled selected> -- Selecione Articulo -- </option>
<option>Administrador</option>
<option>Usuario</option>
</select>
</div>
<div class="col-md-1">
Cantidad <input class="form-control">
</div>
<div class="col-md-1">
Unidad <input class="form-control">
</div>
<div class="col-md-2">
Costo Unitario<input class="form-control">
</div>
<div class="col-md-1">
Costo total<input class="form-control">
</div>
<div class="col-md-1">
<button type="submit" class="btn btn-default" style="color: #337ab7;margin-top: 20px;" id="agregar">Agregar</button>
</div>
</div>

<!-- /.row -->
<div class="row" style="margin-top: 20px;">
<div class="col-lg-12">
    <div class="panel panel-default">
        <!-- /.panel-heading -->
        <div class="panel-body" style="padding-bottom: 2px;">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>ID prod</th>
                            <th>Producto</th>
                            <th>Presentacion</th>
                            <th>presio</th>
                            <th>Unidad 1</th>
                            <th>Unidad 1</th>
                            <th>Unidad 2</th>
                            <th>Unidad 3</th>
                            <th>Unidad 4</th>
                            <th>Unidad 5</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                                   <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                                                <tr class="odd gradeX">
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                            <td style="padding: 4px;">x</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
</script>