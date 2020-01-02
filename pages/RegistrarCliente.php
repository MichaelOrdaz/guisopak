<?php
    session_start();
?>

<form role="form">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="* Nombre o razón"></label>
                <input id="nombre" class="form-control" name="nombre" value="" required autofocus="true" maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* RFC"></label>
                <input class="form-control" name="rfc" value="" maxlength="14" placeholder="ABC 123456 ABC">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Dirección"></label>
                <input class="form-control" name="direccion" value="" maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Teléfono"></label>
                <input class="form-control" name="telefono" value="" maxlength="14" onchange="esNumeroDeTelefono(this.value)" placeholder="Formato (xxx) xxx-xxxx">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Nombre del contacto"></label>
                <input class="form-control" name="contacto" value="" maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Plazo"></label>
                <input class="form-control" type="number" name="plazo" maxlength="4" size="4" max="60" min="0" value="0" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 13 ? true : !isNaN(Number(event.key))"/>
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="Crédito"></label>
                <input class="form-control" type="number" name="credito" maxlength="4" size="4" max="45" min="0" value="0" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 13 ? true : !isNaN(Number(event.key))"/>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Correo"></label>
                <input class="form-control" name="correo" value="" maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Estado"></label>
                <input class="form-control" name="estado" value="" maxlength="16">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Cidudad"></label>
                <input class="form-control" name="ciudad" value="" maxlength="16">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Código postal"></label>
                <input class="form-control" name="cp" value="" maxlength="5" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 13 ? true : !isNaN(Number(event.key))">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Información adicional"></label>
                <input class="form-control" name="info" value="" maxlength="32">
                <p class="help-block"></p>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src=<?php echo $_SESSION['__js_form__'];?>></script>
<script type="text/javascript">
    $("[name='telefono']").on({change : esNumeroDeTelefono, focus : mostrarFormatoNumeroTelefonico});
    $("[name='cp']").on({change : soloNumeros});
    $("[name='nombre']").on({change : soloPalabras});
    $("[name='estado']").on({change : soloPalabras});
    $("[name='info']").on({change : soloPalabras});
    $("[name='ciudad']").on({change : soloPalabras});
    $("[name='plazo']").on({change : estaEnRango});
    $("[name='credito']").on({change : estaEnRango});
    $("[name='rfc']").on({change : rfc});
</script>