<?
	session_start();
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../../incluidos/bd_manejos.php');
	include("../../../incluidos/info.profesores.php");
	include("../../../incluidos/Func/NombreCliente.php");
	include("../../../incluidos/Func/NombreBanco.php");
	include("../../../incluidos/fechas.func.php");
	
	
		$acc1 = $_POST['accion'].$_GET['action'];
		
	if($acc1=='editar'){
		EditarForm('recarga_balance_cuenta');
			
			echo'
			<script>
				$("#recargar").fadeOut(0);
				$("#recargar2").fadeOut(0);
				$("#modal-simple").modal("hide");
				$("#actual").fadeIn(0); $("#actual").fadeOut(10000);
			</script>
			';
	}
	
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
	if($_GET['dist_id']){ 
	$dist_id = $_GET['dist_id']; 
	}else{
	$dist_id = $_SESSION['user_id'];
	}
	
	$user_id2 = $dist_id;
	
	
function NombreClienteRec($id){	
  
  $queryconsult = mysql_query(" 
  SELECT id,nombres,funcion_id
  FROM personal
  WHERE id = '".$id."' LIMIT 1");
  
  while($rowconsult=mysql_fetch_array($queryconsult)){
	  
	  if($rowconsult['funcion_id']=='2'){ $funcion ='Dist'; }
	    elseif($rowconsult['funcion_id']=='3'){ $funcion ='Pv'; }
	  
	       return "[".$rowconsult['id']."] ".$rowconsult['nombres']." (".$funcion.")";
  }
}
	
	
 if(!$_GET['impr']){	
?>
<ul class="breadcrumb">
	<li>Tu estas Aqui</li>
	<li class="divider"></li>
	<li>Transferencia Distribuidas</li>
	<li class="divider"></li>
	<li>Transferencia distribuidas de los bancos del <? echo $fecha1; if($_GET['impr']){?> al <? echo $_GET['fecha2']; }?></li>
</ul>
<? } ?>
<h2>Transferencia distribuidas de los bancos del <? echo $fecha1;?></h2>

	<!-- Widget -->
  <div class="innerLR">
  <? if(!$_GET['impr']){ ?>
  <div class="filter-bar">
  
				<form>
					<!-- Filter -->
					<div>
						<label>Desde:</label>
						<div class="input-append">
						  <input type="text" name="fecha1" id="fecha1" class="input-mini" value="<? echo $fecha1;?>" style="width: 65px; height:24px;" />
							<!--<span class="add-on glyphicons calendar"><i></i></span>-->
						</div>
					</div>
					<!-- // Filter END -->
					
					<!-- Filter -->
					<div>
						<label>Hasta:</label>
						<div class="input-append">
						  <input type="text" name="fecha2" id="fecha2" class="input-mini" value="<? echo $fecha2;?>" style="width: 65px; height:24px;" />
							<!--<span class="add-on glyphicons calendar"><i></i></span>-->
						</div>
					</div>
					<!-- // Filter END -->
					
					<!-- Filter -->
					<div>
                    <!--<span class="add-on glyphicons calendar"><i></i></span>-->
						<button name="bt_buscar" type="button" id="bt_buscar"  class="btn btn-success" style="margin-left:10px;">
                        Actualizar
                        </button>
                        <button name="impr" type="button" id="impr"  class="btn btn-primary btn-icon glyphicons download_alt hidden-print" style="margin-left:5px;"> 
                           <i></i> Imprimir Reporte 
                         </button>
                    <div id="recargar2" style="display:none; margin-left:10px;"> Cargando&nbsp;&nbsp;<img src="images/iconos/ajax-loader_2.gif" width="32" height="32" /></div>

					</div>
					<!-- // Filter END -->
				</form>
				
 <script type="text/javascript">
	
	$('#impr').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();
	
	var url = 'Admin/Sist.PersonalRecargas/List/Listado_recargas_trans.php?fecha1='+fecha1+'&fecha2='+fecha2+'&dist_id=<? echo $_GET['dist_id'];?>&impr=1';
	var ops = "status=yes,scrollbars=yes,width=830,height=650,top=" + (screen.height / 2 - 130) + ",left=" + (screen.width / 2 - 430);

    window.open(url, "", ops);
	});
	
	$('#bt_buscar').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();

	
	CargarAjax2('Admin/Sist.PersonalRecargas/List/Listado_recargas_trans.php?fecha1='+fecha1+'&fecha2='+fecha2+'&dist_id=<? echo $_GET['dist_id'];?>','','GET','cargaajax');
	$(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#impr').fadeOut(0); $('#recargar2').fadeIn(0); ",0);
}); 
	
		  // CODIGO PARA SACAR CALENDARIO
		$(function() {
			$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
			$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
		});
		
	  </script>

	</div>
    
            <? } if($acc1=='editar'){?>
               <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Esta cuenta se ha editado correctamente</span>
             <? } ?>
	<div class="widget widget-heading-simple widget-body-gray">
		<div class="widget-body">
  <!-- Table -->
  <table class="table-hover table table-striped table-bordered table-primary table-white">
      <!-- Table heading -->
      <thead>
          <tr>
            <th>No.:</th>
            <th>Fecha / Hora.: </th>
            <th>Nombre.:</th>
            <th>Monto:</th>
            <th>Banco:</th>
            <th>&nbsp;</th>
 		 </tr>
      </thead>
    <tbody> 
<?
	//para el listado nuevo
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde = $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta = $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
    $wFecha = "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 23:59:59'";
	$wFecha2 = "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 23:59:59'";
	$wFecha3 = "AND fecha_inic >= '$fDesde 00:00:00' AND fecha_inic < '$fHasta 23:59:59'";
	//para el listado nuevo
	
  $query=mysql_query(" 
  SELECT id,fecha AS fecha_inic,id_pers,monto, 0 AS tipo, cuenta_banco,client_afect
  FROM recarga_balance_cuenta
  WHERE realizado_por = '".$_SESSION['user_id']."' AND autorizada_por ='6' $wFecha2 
  ORDER BY cuenta_banco,id ASC
  ");
  
  while($row=mysql_fetch_array($query)){
	if($row['monto']){
	$monto = $monto + $row['monto'];
	$totalCuentaContado[$row['cuenta_banco']] += $row['monto'];
	
  ?>
 
   <tr>
      <td><? echo $row['id'];?></td>
  	  <td><? echo FechaAud($row['fecha_inic']);?></td>
      <td>
	  <? 
	    echo NombreCliente($row['id_pers'])."<br>";
		//echo $row['client_afect'];
		
		$client = explode(",", $row['client_afect']);
		
		if(!$client['1']){
		?>
			<font style="font-size:11px; color:#06F"><? echo NombreClienteRec($client['0'])?> </font>
	<?	}else{ ?>
	    	<font style="font-size:11px; color:#06F"><? echo NombreClienteRec($client['0'])."<br>" ?> </font>
    		<font style="font-size:11px; color:#06F"><? echo NombreClienteRec($client['1']) ?> </font>
        <?
		
	}
	    
		
		
	  ?></td>
      <td><? echo FormatDinero($row['monto']); $monto_rec += $row['monto'];?></td>
      <td>
      <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/List/editar-registar.php?id=<? echo $row['id']; ?>&cuenta_banco=<?=$row['cuenta_banco']?>','','GET');" class="icon-editar" title="Editar">
	<? if(!$row['tipo']=='credito'){ echo NombreBanco($row['cuenta_banco']); }else{ echo $row['nota']; }?></a></td>
      <td>
	<?
    	if($row['tipo']=='credito'){
			echo "<font color='#336633'>Credito</font>";	
			$monto_credito_rec += $row['monto'];
		}else
		if($row['tipo']=='2'){
			echo "<font color='#009933'>Ingreso</font>";	
			$monto_credito+= $row['monto'];
		}else
		if($row['tipo']==0){
			echo "<font color='#006699'>Contado</font>";
			$monto_contado += $row['monto'];
		
		}else
		if($row['tipo']==1){
			echo "<font color='#FF0000'>Retiro</font>";
			$monto_retirado += $row['monto'];
		}
	?>
      </td>
  </tr>
  <tr>
  	<td colspan="6"><strong>Comentario:</strong> <? echo $row['comentario']; ?>  
    </td>
  </tr>
  <?  } } 
	  $queryCredito=mysql_query(" 
	  SELECT nota,id,fecha_inic,id_pers,monto,3 AS tipo,id_banco AS cuenta_banco FROM credito 
	  WHERE tipo = 'credito' $wFecha3 AND realizado_por2 = '".$_SESSION['user_id']."'
	  ORDER BY cuenta_banco DESC
	  ");
	  while($rowCredito=mysql_fetch_array($queryCredito)){ 
	  
    ?>
          <tr>
            <td><? echo $rowCredito['id']; ?></td>
            <td><? echo $rowCredito['fecha_inic']; ?></td>
            <td><? echo NombreCliente($rowCredito['id_pers']);?></td> 
            <td><? echo FormatDinero($rowCredito['monto']); $monto_rec += $rowCredito['monto'];?></td>
            <td><? if(!$rowCredito['nota']){ echo '<b>No tiene comentario</b>'; }else{ echo $rowCredito['nota']; }?></td>
            <td><? echo "<font color='#336633'>Credito</font>";	$monto_credito_rec += $rowCredito['monto'];?></td>
          </tr>
          <tr>
          	<td colspan="6"><strong>Comentario:</strong> <? echo $rowCredito['nota']; ?>
            </td>
          </tr>
  <? } 
	  $queryAbono=mysql_query(" 
	  SELECT id,fecha AS fecha_inic,id_pers,sum(monto) AS monto,2 AS tipo,id_banco AS cuenta_banco FROM credito 
	  WHERE tipo = 'abono_credito' $wFecha2 AND realizado_por2 = '".$_SESSION['user_id']."'
	  GROUP BY id_pers, fecha, fecha_inic
	  ORDER BY cuenta_banco ASC 
	  ");
	  while($rowAbono=mysql_fetch_array($queryAbono)){
	 ?>
         <tr>
           <td><? echo $rowAbono['id'];?></td>
           <td><? echo $rowAbono['fecha_inic'];?></td>
           <td><? echo NombreCliente($rowAbono['id_pers']);?></td>
           <td><? echo FormatDinero($rowAbono['monto']); $monto_rec += $rowAbono['monto'];?></td>
           <td><? echo NombreBanco($rowAbono['cuenta_banco']);?></td>
           <td><? echo "<font color='#009933'>Ingreso</font>";	$monto_credito+= $rowAbono['monto'];?></td>
         </tr>
         <tr>
         	<td colspan="6"><strong>Comentario:</strong> <? echo $rowAbono['nota']; ?>
            </td>
         </tr>
   <? }  
	 $queryret=mysql_query("SELECT id,fecha AS fecha_inic,id_pers,monto, id_banco AS cuenta_banco
  	 FROM retiro_balance_cuenta
  	 WHERE autorizada_por2 = '".$_SESSION['user_id']."' $wFecha2 ");
     while($rowret=mysql_fetch_array($queryret)){
	 $totalCuentaRetirado[$rowret['cuenta_banco']] += $rowret['monto'];
    ?>  
         <tr>
            <td><? echo $rowret['id']; ?></td>
            <td><? echo $rowret['fecha_inic']; ?></td>
            <td><? echo NombreCliente($rowret['id_pers']);?></td>
            <td><? echo FormatDinero($rowret['monto']); $monto_rec += $rowret['monto'];?></td>
            <td><? echo NombreBanco($rowret['cuenta_banco']);?></td>
            <td><? echo "<font color='#FF0000'>Retiro</font>"; $monto_retirado += $rowret['monto']; ?></td>
         </tr>
  		<tr>
        	<td colspan="6"><strong>Comentario:</strong> <? echo $rowret['comentario']; ?>
            </td>
        </tr>
  <? } ?> 
   </tbody>
</table>

<div class="separator bottom hidden-print"></div>
		<!-- Row --><div class="row-fluid">
        <? if($_GET['impr']){ ?>
<br><br>
<? } ?>
        </div>
		<div class="row-fluid">
        
        <div class="span5 hidden-print">
				<div class="">
				</div>
			</div>
			<div class="span4 offset3">
				<table class="table table-borderless table-condensed cart_total">
					<tbody>
						<tr>
							<td class="right"><b>Contado:</b></td>
							<td class="right strong"><span class="label label-primary">$<? echo FormatDinero($monto_contado);?></span></td>
						</tr>
						<tr>
							<td class="right"><b>Credito:</b></td>
							<td class="right strong"><span class="label label-important">$<?  echo FormatDinero($monto_credito_rec);?></span></td>
						</tr>
						<tr>
							<td class="right"><b>Ingreso:</b></td>
							<td class="right strong"><span class="label label-success">$<?  echo FormatDinero($monto_credito);?></span></td>
						</tr>
                        <tr>
							<td class="right"><b>Retirado:</b></td>
							<td class="right strong"><span class="label label-success">$<?  echo FormatDinero($monto_retirado);?></span></td>
						</tr>
                        <tr>
							<td class="right"><b>Monto total:</b></td>
							<td class="right strong"><span class="label label-success">$<?  $M_Tot= ($monto_contado + $monto_credito_rec + $monto_credito); echo FormatDinero($M_Tot);?></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>   
     </div>
  </div>
</div>