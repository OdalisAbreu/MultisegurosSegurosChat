<?
	//ini_set("session.cookie_lifetime","7200");
	//ini_set("session.gc_maxlifetime","7200");
	//ini_set('session.cache_expire','3000'); 
	session_start();
	ini_set('display_errors',1);
	
	include("../../../incluidos/conexion_inc.php");
	include("../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../incluidos/fechas.func.php");
	
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
        <h3 class="page-header">Listados de Polizas Anuladas</h3>
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
                        <input type="text" name="fecha1" id="fecha1" class="input-mini" value="<?=$fecha1?>" style="width: 83px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <label style="margin-left:5px;">Hasta:</label>
                        <input type="text" name="fecha2" id="fecha2" class="input-mini" value="<?=$fecha2?>" style="width: 83px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        
                        
                        
                        
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-primary" style="margin-left:10px; margin-left:15px; margin-left:5px;">
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
	
	CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans_anuladas.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
}); 

	 
		  // CODIGO PARA SACAR CALENDARIO
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
                            <th>Aseguradora</th>
                            <th>Vendedor</th>
                            <th>Vigencia</th>
                            <th>Vehiculo</th>
                             <th>Monto</th>
                            <th>Estado</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
 
 if($_GET['consul']=='1'){
	  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
		//$reversadas 	.= ",".$rev['id_trans'];
	 }
	 
	 
$query=mysql_query("
   SELECT id,fecha,id_cliente,fecha_inicio,vigencia_poliza,id_vehiculo,user_id,monto,ganancia,id_aseg,id_poliza,totalpagar
   FROM seguro_transacciones 
   WHERE $wFecha  order by id ASC");

  while($row=mysql_fetch_array($query)){
	  
	  if((substr_count($reversadas,"[".$row['id']."]")>0)){
		 $Rtotal +=$row['totalpagar']; 
	  
	  
	  $fh1		= explode(' ',$row['fecha']);
	  $Cliente = explode("|", Cliente($row['id_cliente']));
	  $Client = str_replace("|", "", $Cliente[0]);
	  $i++;
	  
	  $pref = GetPrefijo($row['id_aseg']);
	  $idseg = str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
	  $prefi = $pref."-".$idseg;

?>
<tr>
    <td><b><?=$row['id']?></b>
    <br><?=FechaList($fh1[0])?></td>
    <td><b><?=NombreSeguroS($row['id_aseg'])?></b>
    <br><?=$prefi?></td>
    <td><?=ClientePers($row['user_id'])?></td>
    <td><?=Vigencia($row['vigencia_poliza'])?></td>
    <td><?=Vehiculo($row['id_vehiculo'])?></td>
    <td><?="RD$ ".formatDinero($row['totalpagar'])?></td>
    <td><?="<b style='color:#F40408'>Anulado</b>"?></td>
</tr>
  <? 
	  		}
 	 	}
 	}
?>
  

<? if($total>0){?>  
    <tr>
        <td colspan="6" align="right"><b>Total Vendido</b></td>
        <td><b>RD$ <?=formatDinero($total)?></b></td>
      </tr>
  <? } ?>
  
  <? if($ganancia>0){?>
    <tr>
        <td colspan="6" align="right"><b>Total Ganancia</b></td>
        <td><b><?=formatDinero($ganancia)?></b></td>
      </tr>
  <? } ?>
  
   <? if($costo>0){?>
    <tr>
        <td colspan="6" align="right"><b>Total Costo</b></td>
        <td><b><?=formatDinero($costo)?></b></td>
      </tr>
  <? } ?>
  
  <? if($Rtotal>0){?>
     <tr>
        <td colspan="6" align="right"><b>Total Anulado</b></td>
        <td><b><?=formatDinero($Rtotal)?></b></td>
      </tr>
  <? } ?> 
  
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