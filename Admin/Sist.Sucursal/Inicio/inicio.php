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
        CargarAjax2('Admin/Sist.Sucursal/Inicio/chart/rep_ventas.php','','GET','RepVent');
		
    }
	
	GetVentas();
	
	
	
    function GetBalancedc(){
        $("#bltemp").html('');
        CargarAjax2('incluidos/Balance/BalanceActual.php','','GET','bltemp');
		
    }
	
	GetBalancedc();
  </script>

        
        
        
              
            <!--<div class="row">
                
                <div class="col-lg-2" >
                    <a href="#" onClick="GetBalance();">
                    <div class="panel panel-primary" >
                        <div class="panel-heading">
                            Balance Actual
                        </div>
                        <div class="panel-body">
                            <span id="balancemovil" class="text-xlarge strong separator bottom">$0.00</span>
                        </div>
                        
                    </div>
                    </a>
                </div>
                <script>
    function GetBalance(){
        $("#balancemovil").html('');
        CargarAjax2('incluidos/Balance/BalanceActual.php','','GET','balancemovil');
		
    }
	
	GetBalance();
  </script>
                
            </div>-->
            