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

<div class="row" >
    <div class="col-lg-12" style="margin-top:-33px">
        <h3 class="page-header">Listados de venta de Seguros de <?=ClientePers($_GET['op'])?> </h3>
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

	
	CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_trans_pers.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1&op=<?=$_GET['op']?>','','GET','cargaajax');
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
                            <th>Asegurado</th>
                            <th>Cedula</th>
                            <th>Monto</th>
                            <th>Ganancia</th>
                            <!--<th>Fecha Inicio</th>-->
                            <th>Vigencia</th>
                            <th>Vehiculo</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	$w_user = "(
	user_id='".$_GET['op']."'"; 
	
	// PUNTOS DE VENTAS
	$quer1 = mysql_query("
	SELECT id FROM personal WHERE id ='".$_GET['op']."'");
	while($u=mysql_fetch_array($quer1)){
	
		$w_user .= " OR user_id='".$u['id']."'";
	
		$quer2 = mysql_query("
		SELECT id FROM personal WHERE id_dist ='".$u['id']."'"); 
		while($u2=mysql_fetch_array($quer2)){
		$w_user .= " OR user_id='".$u2['id']."'";	
		}
	
	}
	$w_user .= " )";
	
$query=mysql_query("
   SELECT * 
   FROM seguro_transacciones 
   WHERE $w_user $wFecha order by id ASC");

  while($row=mysql_fetch_array($query)){
	  $total +=$row['monto'];
	  $ganancia += $row['ganancia2'];
	  $fh1		= explode(' ',$row['fecha']);
	  
	  $polizaNum		= GetPrefijo($row['id_aseg'])."-".str_pad($row['id_poliza'],6, "0", STR_PAD_LEFT);

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$fh1[0]?></td>
    <td><?=Clientepers($row['user_id'])?></td>
    <td><?=ClienteRepS($row['id_cliente'])?>
    <br><font style="font-size:12px; color:#0B197C"><?=$polizaNum?></font></td>
    <td><?=Cedula($row['id_cliente'])?></td>
    <td><?="$".FormatDinero($row['monto'])?></td>
    <td><?="$".FormatDinero($row['ganancia2'])?></td>
   <!-- <td><?=Fecha($row['fecha_inicio'])?></td>-->
    <td><?=Vigencia($row['vigencia_poliza'])?></td>
    <td><?=Vehiculo($row['id_vehiculo'])?></td>
</tr>
  <? } ?>
  
  
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
    <td colspan="7" rowspan="2"></td>
    <!-- <td></td>-->
    <td><strong>Total</strong></td>
    <td><strong><?="$".FormatDinero($total)?></strong></td>
</tr>
 <tr>
    <!--<td></td>-->
    <td><strong>Ganancia</strong></td>
    <td><strong><?="$".FormatDinero($ganancia)?></strong></td>
</tr>

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