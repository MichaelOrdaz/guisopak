<?php
    session_start();
?>

<form id="precioXproveedor" role="form">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="* Proveedor"></label>
                <select class="form-control" name="proveedor" value="" required="true" data-tabla-objetivo="table=proveedor" data-campo-objetivo="campo=nombre">
                    <option></option>
                </select>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Articulo"></label>
                <select class="form-control" name="articulo" value="" required="true" data-tabla-objetivo="table=articulo" data-campo-objetivo="campo=nombre">
                    <option></option>
                </select>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Precio"></label>
                <input class="form-control" name="costo" value="" required="true">
                <p class="help-block">El precio que aparece, es el precio por de la Presentación y en caso de no tener presentación es el precio por Unidad de Medida</p>
            </div>
            <div class="form-group">
                <label data-texto="* Presentación"></label>
                <input class="form-control" name="unidadA" value="" required="true" disabled="true">
                <p class="help-block">Utilice unidad de medida "Ninguna" para asignar un precio a un producto en su Unidad de Medida Original</p>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="Unidad de medida"></label>
                <input class="form-control excluded" name="unidad" value="" disabled="true" type="text">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Cantidad de unidades en la presentación" required></label>
                <input class="form-control" name="factor" value="" required="true" disabled="true">
                <p class="help-block">Si la cantidad de unidades permanece en cero (0); la presentación se considerará como "Ninguna"</p>
            </div>
            <div class="form-group">
                <label data-texto="Información adicional"></label>
                <input class="form-control" name="info" value="" disabled="true">
                <p class="help-block"></p>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src=<?php echo $_SESSION['__js_form__'];?> ></script>