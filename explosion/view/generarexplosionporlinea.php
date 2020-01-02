<!-- <div class="row">
  <div class="col-xs-12">
      <h3 class="page-header">Creación de lista de explosión de artículos</h3>
  </div>
</div> -->


<div class="row mt-20-px">
  
  <div class="col-xs-12">
    
    <div class="panel panel-default">
      <div class="panel-heading bg-coral text-white">
        Explosión de Artículos por Linea
      </div>
      
      <div class="panel-body text-blue">
        
        <form action="explosion/bomLinea" target="_blank" method="get" name="form_fechas" id="form_fechas">
          
          <div class="row">
              <div class="col-xs-12">
                  <div class="form-group">
                      <label for="linea">Linea *</label>
                      <select name="linea" id="linea" class="form-control" required >
                          <option value="" selected>Selecciona una línea</option>
                      </select>
                  </div>
              </div>
          </div>

          <div class="row">
          
            <!-- <div class="col-sm-6">
              <div class="form-group">
                <label>Fecha Inicial</label>
                <div class="input-group">
                  <input type="text" name="start" placeholder="Fecha Inicial" class="form-control" id="start"  />
                  <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Fecha Inicial</label>
                <div class="input-group">
                  <input type="text" name="end" placeholder="Fecha Inicial" class="form-control" id="end"  />
                  <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                </div>
              </div>
            </div> -->

            <div class="col-xs-12">
              Seleccione el rango de fechas para la explosión
              <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="form-control" name="start" id="start" placeholder="Fecha Inicial" readonly />
                <span class="input-group-addon"> hasta </span>
                <input type="text" class="form-control" name="end" id="end" placeholder="Fecha Final" readonly />
              </div>

              <!-- <div id="datepicker"></div>
              <input type="hidden" id="my_hidden_input"> -->

            </div>
            
          
          </div>
        
          <div class="row">
            <div class="col-md-6 my-1">
              <button type="submit" id="sinExcedente" class="btn btn-primary btn-block" name="excedente" value="0"> Explosión de materiales sin Excedentes </button>
            </div>
            <div class="col-md-6 my-1">
              <button type="submit" id="conExcedente" class="btn btn-primary btn-block" name="excedente" value="1"> Explosión de materiales con Excedentes </button>
            </div>
          </div>

        </form>

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

(function(){

  var form_fechas = document.form_fechas;
  
  $('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    language: 'es',
    autoclose: true,
    // endDate: '0d',
  });


  $.post('explosion/php/Linea.php', {method: 'getLineas'}, function(data, textStatus, xhr) {
    console.log(data);

    var frag = document.createDocumentFragment();
    for( let item of data ){
        let option = document.createElement('option');
        option.value = item.idLinea;
        option.textContent = item.descripcion;
        frag.appendChild(option);
    }
    form_fechas.linea.appendChild(frag);
  }, 'json');



  form_fechas.addEventListener('submit', function(ev){

    if( this.start.value === '' || this.end.value === '' ){
      ev.preventDefault();
      Swal.fire('Las Fechas son requeridas', '', 'info');
    }

  });

})();
  

</script>