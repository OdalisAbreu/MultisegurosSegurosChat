<?
	session_start();
	ini_set('display_errors',0);
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

<div class="row">
    <div class="col-lg-12" style="margin-top: -33px;">
        <h3 class="page-header">Reporte de Ventas por agencias </h3>
    </div>
</div>

		
  <? if($_GET['consul'] !=='1'){?>
   <center>
  	<div id="div_ultimo_acc2" class="alert alert-success" style=" font-size:14px; width:95%;" align="center" >
    	<strong>Por favor proporcionar la fecha que desea buscar</strong>
		<script>setTimeout(function(){$("#div_ultimo_acc2").fadeOut(3000); },20000);</script>
	</div>
	</center><? } ?>    
    
    
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

	
	CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_agencia.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 
	
	
		 
		  // CODIGO PARA SACAR CALENDARIO
		  // ****************************
		$(function() {
			$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
			$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
		});
	  </script>

      
   
			</div>
       <? if($_GET['consul']=='1'){ ?>      
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      
                      <tbody>
  <? 


function Ventas($id){
	global $fecha1, $fecha2;
	 
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 		= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 		= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 		= "fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
	 }
	 
	 $w=mysql_query("SELECT * FROM seguro_transacciones WHERE user_id = '".$id."' AND $wFecha");
	while($e=mysql_fetch_array($w)){
		
	if((substr_count($reversadas,"[".$e['id']."]")>0)){
		 
		 $TotalAnul +=  $e['monto'];
		
      }else{
		  
	  	$TotalVent  +=  $e['monto'];
	  	$Tganancia   +=  $e['ganancia2'];
		
	  }
	  
	 
	  
	}
	
	 return $TotalVent."|".$Tganancia."|".$TotalAnul;
	
}
 	
$query=mysql_query("SELECT id,razon_social FROM agencia_via WHERE 
user_id='".$_SESSION['user_id']."'  order by razon_social ASC");
while($row=mysql_fetch_array($query)){
	  
?>
<tr>
    <td colspan="7"> <b>Nombre de Agencia:</b> <?=$row['razon_social']?></td>
</tr>
<?
	$q=mysql_query("SELECT * FROM personal WHERE id_dist ='".$_SESSION['user_id']."' 
	AND id_agencia = '".$row['id']."' ");
	while($r=mysql_fetch_array($q)){
		$result 	= explode("|", Ventas($r['id']));
		
 		$MontoVenta = $result[0];
		$MontoGanan = $result[1];
		$MontoAnula = $result[2]; 
		
		$MontoVents 	= $MontoVenta + $MontoAnula;
		$Tmonto += $MontoVenta;
		$Tanul  += $anul;
		$Tventa += $venta;
		
		 
	  
	  
		
		if($MontoVenta>0){ 
?>
<tr>
    <td width="65">#<?=$r['id']?></td>
    <td><?=$r['nombres']?></td>
    <td><b>Total Venta</b><br>$<?=FormatDinero($MontoVents)?></td>
    <td><b>Total Anulado</b><br>$<?=FormatDinero($MontoAnula)?></td>
    <td><b>Ventas Neta</b><br>$<?=FormatDinero($MontoVenta)?></td>
    <td><b>Total Ganancia</b><br>$<?=FormatDinero($MontoGanan)?></td>
    
    <td><a class="btn btn-social-icon btn-dropbox" onClick="CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_trans_pers.php?op=<?=$r['id']?>&fecha1=<?=$_GET['fecha1']?>&fecha2=<?=$_GET['fecha2']?>&consul=1','','GET','cargaajax');">Transacciones</a>
                                </td>
</tr>

  <? } } } ?>
   <tr>
    <td colspan="2"><strong>Total</strong></td>
    <td><strong><?="$".FormatDinero($Tmonto)?></strong></td>
    <td><strong><?="$".FormatDinero($Tanul)?></strong></td>
    <td><strong><?="$".FormatDinero($Tventa)?></strong></td>
    <td><strong><?="$".FormatDinero($Tmonto)?></strong></td>
    
    <td>&nbsp;</td> 
    
</tr>
    </tbody>
</table>
 </div>
</div>
<? } ?>       
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>