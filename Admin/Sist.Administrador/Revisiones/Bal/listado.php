<?
	//ini_set("session.cookie_lifetime","7200");
	//ini_set("session.gc_maxlifetime","7200");
	//ini_set('session.cache_expire','3000'); 
	session_start();
	ini_set('display_errors',1);
	
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../../incluidos/fechas.func.php");
	
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
	
	if($_GET['id']){
		$id = $_GET['id'];
		$user = "AND user_id = '".$_GET['id']."' ";
		$Mnombre = "de <b style='color:#110CD4'>".ClientePers($_GET['id'])."</b>";
	}else{
		$id = "";
	}
	
	if($_GET['id']){
		
			$w_user = "(
		user_id='".$_GET['id']."'";
		
		// PUNTOS DE VENTAS
		$quer1 = mysql_query("
		SELECT id FROM personal WHERE id_dist ='".$_GET['id']."'");
		while($u=mysql_fetch_array($quer1)){
		
			$w_user .= " OR user_id='".$u['id']."'";
		
			$quer2 = mysql_query("
			SELECT id FROM personal WHERE id_dist ='".$u['id']."'"); 
			while($u2=mysql_fetch_array($quer2)){
			$w_user .= " OR user_id='".$u2['id']."'";	
			}
		
		}
		$w_user .= " )";
		
	}
	
	
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Revision de balance <?=$Mnombre?></h3>
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
                        
                        
                        <label class="control-label">ID</label>
						<input type="text" name="id" id="id" class="input-mini" value="<?=$id?>" style="width: 83px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;" autocomplete="off">		  
                                        
                        
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
	var id 	= $('#id').val();

	if(id ==''){
		alert("Debes de digitar un ID de cliente!");	
	}
	
	if(id !==''){
	CargarAjax2('Admin/Sist.Administrador/Revisiones/Bal/listado.php?fecha1='+fecha1+'&fecha2='+fecha2+'&id='+id+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	}
	
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
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Monto</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
 
 if($_GET['consul']=='1'){
	  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 23:59:59'";
	
	
		// VERIFICAR EL BALANCE A LA CUAL SE AUDITA
	$queryBAL=mysql_query("SELECT *  FROM corte_de_balance 
    WHERE user_id ='".$_GET['id']."' AND fecha >= '$fDesde 00:00:00' AND fecha < '$fDesde 23:59:59' 
	order by id desc LIMIT 1");
	$rowBAL=mysql_fetch_array($queryBAL);
	$balActual = $rowBAL['balance'];
	// VERIFICAR EL BALANCE A LA CUAL SE AUDITA
	
	  $fecha3 = date_create(''.$fHasta.'');
	  $fecha3 = date_add($fecha3, date_interval_create_from_date_string('1 days'));
	  $fecha_desp = date_format($fecha3, 'Y-m-d');
	  $wFecha_desp23 = "fecha >= '$fecha_desp 00:00:00' AND fecha < '$fecha_desp 23:59:59'";
	
	  // BALANCE CON QUE TERMINO:
	  $qCorteBal2=mysql_query("
		  SELECT * FROM corte_de_balance WHERE 
		  $wFecha_desp23 AND user_id = ".$_GET['id']." LIMIT 1");
	  $corte2 = mysql_fetch_array($qCorteBal2);
	  $balCorte = $corte2['balance'];
	?>
    <?  
	  
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    //$reversadas .= "[".$rev['id_trans']."]";
		$reversadas 	.= ",".$rev['id_trans'];
	 }
	 
	 
$query=mysql_query("
   SELECT id,fecha,user_id AS id_pers,totalpagar AS monto,1 AS tipo FROM seguro_transacciones 
   WHERE $w_user AND $wFecha AND id NOT IN($reversadas)
   
   UNION
   
   SELECT id,fecha,id_pers AS id_pers,monto,2 AS tipo FROM recarga_retiro 
   WHERE $wFecha AND id_pers = ".$_GET['id']." AND tipo='Contado' 
   
   UNION
   
   SELECT id,fecha,id_pers AS id_pers,monto,3 AS tipo FROM recarga_retiro 
   WHERE $wFecha AND id_pers = ".$_GET['id']." AND tipo='Retiro'
   
    UNION
   
   SELECT id,fecha,id_pers AS id_pers,monto,4 AS tipo FROM recarga_retiro 
   WHERE $wFecha AND id_pers = ".$_GET['id']." AND tipo='NC'
   
   UNION
   
   SELECT id,fecha,id_pers AS id_pers,monto,5 AS tipo FROM recarga_retiro 
   WHERE $wFecha AND autorizada_por = ".$_GET['id']." AND tipo='Contado' 
   
   UNION
   
   SELECT id,fecha,id_pers AS id_pers,monto,6 AS tipo FROM recarga_retiro 
   WHERE $wFecha AND autorizada_por = ".$_GET['id']." AND tipo='Retiro'
   
   order by id ASC");

  while($row=mysql_fetch_array($query)){

if($row['tipo'] =='1'){ 
	$tipo="<font style='color:#006633; font-size:12px;'>Venta</font>"; 
	$venta += $row['monto'];
}

if($row['tipo'] =='2'){ 
	$tipo="<font style='color:#0000FF; font-size:12px;'>Contado</font>";
	$Contado += $row['monto'];
}

if($row['tipo'] =='3'){ 
	$tipo="<font style='color:#FF0000; font-size:12px;'>Retiro</font>"; 
	$Retiro += $row['monto'];
}

if($row['tipo'] =='4'){ 
	$tipo="<font style='color:#FF0000; font-size:12px;'>Nota de Credito</font>"; 
	$NC += $row['monto'];
}


if($row['tipo'] =='5'){ 
	$tipo="<font style='color:#0000FF; font-size:12px;'>Contado operador</font>";
	$ContadoOper += $row['monto'];
}

if($row['tipo'] =='6'){ 
	$tipo="<font style='color:#FF0000; font-size:12px;'>Retiro operador</font>"; 
	$RetiroOper += $row['monto'];
}

?>
<tr>
    <td><b><?=$row['id']?></b></td>
    <td><?=$row['fecha']?></td>
    <td><?=$tipo?></td>
    <td><?=FormatDinero($row['monto'])?></td>
</tr>
  <? 
 	 	}
 	}
?>
 
 <tr>
    <td><b style='color:#110CD4'><?=$rowBAL['id']?></b></td>
    <td><b style='color:#110CD4'>Balance al <?=$fDesde?></b></td>
    <td><b style='color:#110CD4'><?=FormatDinero($balActual)?></b></td>
    <td></td>
</tr>

<? if($Contado>0){?>  
    <tr>
    	<td>&nbsp;</td>
        <td class="right" align="left"><b style='color:#069C14'>Recarga Contado: (+)</b></td>
        <td class="right strong"><b style='color:#069C14'>$<?=FormatDinero($Contado)?></b></td>
        <td>&nbsp;</td>
    </tr>
<? } ?>
  
  <? if($NC>0){?>  
    <tr>
    	<td>&nbsp;</td>
        <td class="right" align="left"><b style='color:#069C14'>Nota de Credito: (+)</b></td>
        <td class="right strong"><b style='color:#069C14'>$<?=FormatDinero($NC)?></b></td>
        <td>&nbsp;</td>
    </tr>
<? } ?>

  <tr>
    	<td>&nbsp;</td>
        <td class="right" align="left"><b>Total Disponible:</b></td>
        <td class="right strong"><b>$<?=FormatDinero($Contado+$balActual+$NC)?></b></td>
        <td>&nbsp;</td>
    </tr>
    
    
   <tr>
    	<td colspan="4">&nbsp;</td>
        
    </tr>
  
 <? if($venta>0){
	 $Tventa = $venta;
	 ?>  
    <tr>
    	<td>&nbsp;</td>
        <td class="right"  align="left"><b style='color:#D3800F'>Total Ventas: (-)</b></td>
        <td class="right strong"><b style='color:#D3800F'>$<?=FormatDinero($venta)?></b></td>
        <td>&nbsp;</td>
    </tr>
<? }else{ $Tventa = 0; } ?>
   
 <? if($Retiro>0){?>  
    <tr>
    	<td>&nbsp;</td>
        <td class="right" align="left"><b style='color:#F30408'>Retiro Balance: (-)</b></td>
        <td class="right strong"><b style='color:#F30408'>$<?=FormatDinero($Retiro)?></b></td>
        <td>&nbsp;</td>
    </tr>
<? } ?>

<? if($ContadoOper>0){?>  
    <tr>
    	<td>&nbsp;</td>
        <td class="right" align="left"><b style='color:#F30408'>Transf. a Operadores: (-)</b></td>
        <td class="right strong"><b style='color:#F30408'>$<?=FormatDinero($ContadoOper)?></b></td>
        <td>&nbsp;</td>
    </tr>
<? } ?>

 <tr>
    	<td>&nbsp;</td>
        <td class="right" align="left"><b>Total Descuento:</b></td>
        <td class="right strong"><b>$<?=FormatDinero($venta+$Retiro+$ContadoOper)?></b></td>
        <td>&nbsp;</td>
    </tr>
    
  <tr>
    <td colspan="4">&nbsp;</td>
   </tr>
 <?
 $TotalDisponible = $Contado+$balActual+$NC;
 $TotalDescuento = $venta+$Retiro+$ContadoOper;
 
 $TotalCalculo = $TotalDisponible - $TotalDescuento;
 

 
 ?>
 <tr>
    <td><b style='color:#110CD4'><?=$corte2['id']?></b></td>
    <td><b style='color:#110CD4'>Balance al <?=$fecha_desp?></b></td>
    <td><b>BD:</b> <b style='color:#110CD4'><?=FormatDinero($balCorte)?> </b>&nbsp; <b>/</b> &nbsp; <b>Sist:</b> <b style='color:#110CD4'><?=FormatDinero($TotalCalculo)?></b></td>
    <td><b style='color:#110CD4'></b></td>
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