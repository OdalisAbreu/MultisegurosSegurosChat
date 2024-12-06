    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><b>Estadisticas de Ventas</b></h1>
        </div>
    </div>

      
     <div class="row">
     	<div class="col-lg-12" id="RepVent">
        </div>
     </div>
<script>
    function GetVentas(){
        $("#RepVent").html('');
        CargarAjax2('Admin/Sist.Administrador/Inicio/chart/rep_ventas.php','','GET','RepVent');
		
    }
	
	GetVentas();
  </script>

  
            