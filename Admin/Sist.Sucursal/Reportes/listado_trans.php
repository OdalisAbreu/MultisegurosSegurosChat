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
    <div class="col-lg-12">
        <h3 class="page-header" style="margin-top: 5px;">Listados de venta de Seguros </h3>
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

	
	CargarAjax2('Admin/Sist.Sucursal/Reportes/listado_trans.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
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
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Cedula</th>
                            <th>Monto</th>
                            <th>Ganancia</th>
                            <th>Vigencia</th>
                            <th>Vehiculo</th>
                            <th>&nbsp;</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00'";
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
	 }
	 
$query=mysql_query("
   SELECT id,fecha,id_cliente,fecha_inicio,vigencia_poliza,id_vehiculo,user_id,monto,ganancia 
   FROM seguro_transacciones 
   WHERE user_id ='".$_SESSION['user_id']."' $wFecha order by id ASC");
  while($row=mysql_fetch_array($query)){
	  
	  $fh1		= explode(' ',$row['fecha']);
	  $p++;

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$fh1[0]?></td>
    <td><?=ClienteRepS($row['id_cliente'])?></td>
    <td><?=Cedula($row['id_cliente'])?></td>
    <td><?="$".FormatDinero($row['monto'])?></td>
    <td><?="$".FormatDinero($row['ganancia'])?></td>
   <!-- <td><?=Fecha($row['fecha_inicio'])?></td>-->
    <td><?=Vigencia($row['vigencia_poliza'])?></td>
    <td><?=Vehiculo($row['id_vehiculo'])?></td>
    <td> 
    
      <?
    
	 if((substr_count($reversadas,"[".$row['id']."]")>0)){
		 $TotalAnul +=  $row['monto']; 
		echo  $mensaje 	 =  "<b style='color:#F40408'>Anulado</b>";
		
      }else{
	  	$TotalVent  +=  $row['monto'];
	  	$ganancia   +=  $row['ganancia'];
		$costo 		+=  $row['totalpagar'];
		$mensaje 	=   "<b style='color:#0A22F2'>Vendido</b>";
		?>
         <a href="javascript:void(0)" onclick=" CargarAjax_win('Admin/Sist.Administrador/Revisiones/Imprimir/Accion/poliza.php?id_trans=<?=$row['id']?>','','GET','cargaajax'); " data-title="Visualizar"  class="btn btn-danger">
             <i class="fa fa-eye fa-lg"></i> 
            </a>
    <?    
	  }
	  
	  $TotalVentas = $TotalAnul + $TotalVent;
	?>
    
    </td>
</tr>
  <? } ?>
 <? if($TotalVentas>0){?>  
    <tr>
    	<td rowspan="6" colspan="7">Total de transacciones<br><b><?=$p?></b></td>
        <td align="right"><b>Total Venta</b></td>
        <td><b><?=formatDinero($TotalVentas)?></b></td>
      </tr>
  <? } ?>
  
  <? if($TotalAnul>0){?>
     <tr>
        <td align="right"><b>Total Anulado</b></td>
        <td><b><?=formatDinero($TotalAnul)?></b></td>
      </tr>
  <? } ?>
  
  <? if($TotalVent>0){?>
     <tr>
        <td align="right"><b>Ventas Neta</b></td>
        <td><b><?=formatDinero($TotalVent)?></b></td>
      </tr>
  <? } ?>
  
  <? if($ganancia>0){?>
    <tr>
        <td align="right"><b>Total Ganancia</b></td>
        <td><b><?=formatDinero($ganancia)?></b></td>
      </tr>
  <? } ?>
    </tbody>
</table>
 </div>
                            <!-- /.table-responsive -->
                        </div>
         <? } ?>               
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>