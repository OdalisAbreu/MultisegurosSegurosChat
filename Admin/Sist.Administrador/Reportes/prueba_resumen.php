<?
	session_start();
	ini_set('display_errors',1);
	
	include("../../../incluidos/conexion_inc.php");
	include("../../../incluidos/nombres.func.php");
	include("../../../incluidos/fechas.func.php");
	Conectarse();
	
	// --------------------------------------------	
	if($_GET['fecha1']){
		$fecha1 = $_GET['fecha1'];
	}else{
		$fecha1 = fecha_despues(''.date('d/m/Y').'',-0);
	}
	// --------------------------------------------
	if($_GET['fecha2']){
		$fecha2 = $_GET['fecha2'];
	}else{
		$fecha2 = fecha_despues(''.date('d/m/Y').'',0);
	}
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Listados de venta x servicio opcional </h3>
    </div>
</div>

		
    
    
    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
    <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                    	<td>
                        
                        <label>Desde:</label>
                        <input type="text" name="fecha1" id="fecha1" class="input-mini" value="<?=$fecha1?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <label style="margin-left:5px;">Hasta:</label>
                        <input type="text" name="fecha2" id="fecha2" class="input-mini" value="<?=$fecha2?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
                        
                       
                        </td>
                       
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();

	
	CargarAjax2('Admin/Sist.Administrador/Reportes/prueba_resumen.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 




		 $('#bt_buscar').fadeIn(0); 
		  // CODIGO PARA SACAR CALENDARIO
		  // ****************************
		$(function() {
			$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
			$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
		});
	  </script>

      
   
			</div>
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Servicio Opcional</th>
                            <th>No. Poliza</th>
                            <th>Monto</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
 
 function Numpoliza($id){
	$sxwTVMa=mysql_query("SELECT id,id_aseg,id_poliza FROM seguro_transacciones 
	WHERE id ='".$id."' LIMIT 1");
    $RvcxTVMa=mysql_fetch_array($sxwTVMa);
	 return GetPrefijo($RvcxTVMa['id_aseg']).'-'.str_pad($RvcxTVMa['id_poliza'],6, "0", STR_PAD_LEFT);
}
 
  
  if($_GET['consul']=='1'){
	  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";


	
$query=mysql_query("SELECT * FROM seguro_trans_history WHERE tipo='serv' $wFecha order by id_serv_adc ASC");

while($row=mysql_fetch_array($query)){
	$Mtotal += $row['monto'];
	$fech	= explode(' ',$row['fecha']);
	$p++; 
	
?>
<tr>
    <td><?=$p?></td>
    <td><?=$fech[0]?></td>
    <td><?=NombreServicio($row['id_serv_adc'])?></td>
    <td><?=Numpoliza($row['id_trans'])?></td>
    <td><?="$".FormatDinero($row['monto'])?></td>
</tr>
  <?
  	 } 
  	}
  ?>
  
  
<!--  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>-->

   <tr>
    <td colspan="3" rowspan="2"></td>
    <!-- <td></td>-->
    <td><strong>Total</strong></td>
    <td><strong><?="$".FormatDinero($Mtotal)?></strong></td>
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
            </div>