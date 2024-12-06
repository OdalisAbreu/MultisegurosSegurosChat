    <div class="row">
        <div class="col-lg-12"  style="margin-top: -8px;">
            <h2 class="page-header"><b>Estadisticas de Ventas</b></h2>
        </div>
    </div>

      
     <div class="row">
     	<div class="col-lg-12" id="RepVent">
        </div>
     </div>
<script>
    function GetVentas(){
        $("#RepVent").html('');
        CargarAjax2('Admin/Sist.Distribuidor/Inicio/chart/rep_ventas.php','','GET','RepVent');
		
    }
	
	GetVentas();
  </script>

  
            