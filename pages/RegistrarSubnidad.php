<?php
    session_start();
?>
<form role="form">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label data-texto="* Id sub unidad"></label>
                <input class="form-control" name="idSUnidad" value="" required="true" autofocus="true" type="text" maxlength="4" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 13 ? true : !isNaN(Number(event.key))">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Sub unidad"></label>
                <input class="form-control" name="subUnidad" value="" type="text" maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Cliente"></label>
                <select class="form-control" name="cliente" value="" required="true" type="number">
                	<option>Inválido</option>
                </select>
            </div>
            <div class="form-group">
                <label data-texto="* Unidad"></label>
                <select class="form-control" name="unidad" value="" required="true" type="text">
                	<option>Inválido</option>
                </select>
            </div>
            <div class="form-group">
                <label data-texto="Información adicional"></label>
                <input class="form-control" name="info" value="" type="text" maxlength="32">
                <p class="help-block"></p>
            </div>
    </div>
</form>

<script type="text/javascript" src=<?php echo $_SESSION['__js_form__'];?>></script>
<script type="text/javascript">
    $("[name='idSUnidad']").on({change : soloNumeros});
    $("[name='subunidad']").on({change : soloPalabras});
    $("[name='info']").on({change : soloPalabras});
</script>