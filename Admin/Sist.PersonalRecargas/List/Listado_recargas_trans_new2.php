<?
	session_start();
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	
	include('../../../incluidos/bd_manejos.php');
	include("../../../incluidos/info.profesores.php");
	//include("../../../incluidos/Func/NombreCliente.php");
	include("../../../incluidos/Func/NombreBanco.php");
	include("../../../incluidos/fechas.func.php");
	Conectarse();
	
	
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
	// -------------------------------------------
	
   	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde = $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta = $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	
	
	
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
	
	var url = 'Admin/Sist.PersonalRecargas/List/Listado_recargas_trans_new2.php?fecha1='+fecha1+'&fecha2='+fecha2+'&impr=1&consul=1';
	var ops = "status=yes,scrollbars=yes,width=830,height=650,top=" + (screen.height / 2 - 130) + ",left=" + (screen.width / 2 - 430);

    window.open(url, "", ops);
	});
	
	$('#bt_buscar').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();

	
	CargarAjax2('Admin/Sist.PersonalRecargas/List/Listado_recargas_trans_new2.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
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
             <? } 
			 
			 
		 ?>
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

if($_GET['consul']==1){	

	 // --------------------- Index ID ------------------------ //
	$qIndex = mysql_query("SELECT id_inicio FROM index_dep_cred WHERE fecha ='".$fDesde."' ");
 	$Index	= mysql_fetch_array($qIndex);
	  if($Index['id_inicio']){
	     $wIndexId = "(id > ".$Index['id_inicio'].") AND ";
	   }
	// -------------------------------------------------------
	
	// --------------------- Index ID ------------------------ //
	$qIndex2 = mysql_query("SELECT id_inicio FROM index_dep_cont WHERE fecha ='".$fDesde."' ");
 	$Index2= mysql_fetch_array($qIndex2);
	  if($Index2['id_inicio']){
	     $wIndexId2 = "(id > ".$Index2['id_inicio'].") AND ";
	   }
	// -------------------------------------------------------
	
		// --------------------- Index ID ------------------------ //
	$qIndex3 = mysql_query("SELECT id_inicio FROM index_retiros WHERE fecha ='".$fDesde."' ");
 	$Index3 = mysql_fetch_array($qIndex3);
	  if($Index3['id_inicio']){
	     $wIndexId3 = "(id > ".$Index3['id_inicio'].") AND ";
	   }
	// -------------------------------------------------------
	

	
  $query=mysql_query(" 
  
  SELECT id,fecha,id_pers,monto, 0 AS cod,comentario,cuenta_banco,autorizada_por
  FROM recarga_balance_cuenta 
  WHERE $wIndexId2  fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00' 
  AND realizado_por = '".$_SESSION['user_id']."'
  
  UNION
  
  SELECT id,fecha,id_pers,monto, 1 AS cod,comentario,id_banco AS cuenta_banco,autorizada_por
  FROM retiro_balance_cuenta
  WHERE $wIndexId3 fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00' 
  AND autorizada_por2 = '".$_SESSION['user_id']."'
  
  UNION
  
  SELECT id,fecha,id_pers,monto, 2 AS cod,nota,id_banco AS cuenta_banco,tipo
  FROM credito2
  WHERE $wIndexId fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00' 
  AND tipo='credito' 
  AND realizado_por2 = '".$_SESSION['user_id']."'
  
  UNION
  
  SELECT id,fecha,id_pers,monto, 3 AS cod,nota,id_banco AS cuenta_banco,tipo
  FROM credito2
  WHERE $wIndexId fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00' 
  AND tipo='abono_credito' 
  AND realizado_por2 = '".$_SESSION['user_id']."'
  
  order by fecha ASC
  ");
 
  while($row=mysql_fetch_array($query)){ 
	 
	 if($row['cod'] =='0'){ $tContado += $row['monto'];  $cod="<font color='#0000FF'>Contado</font>"; }
	 if($row['cod'] =='1'){ $tRetiro  += $row['monto'];  $cod="<font color='#FF0000'>Retiro</font>"; }
	 if($row['cod'] =='2'){ $tCredito += $row['monto'];  $cod="<font color='#FF6600'>Credito</font>"; }
	 if($row['cod'] =='3'){ $tIngreso += $row['monto'];  $cod="<font color='#006633'>Ingreso</font>"; }
	 
	$SumTotal = $tContado + $tCredito;

	
  ?>
 
   <tr>
      <td><?=$row['id']?></td>
  	  <td><?=$row['fecha']?></td>
      <td>
	  <?=InfoProfeNombre($row['id_pers'])."<br>";
		
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
      <td><?=FormatDinero($row['monto'])?></td>
      <td>
      
      <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/List/editar-registar.php?id=<? echo $row['id']; ?>&cuenta_banco=<?=$row['cuenta_banco']?>','','GET');" class="icon-editar" title="Editar">
      <?
      if(!$row['cuenta_banco']){ echo "No tiene comentario"; }else{ echo NombreBanco($row['cuenta_banco']); }
	  
	  ?>
      </a>
      
      
    
    </td>
      <td><?="<font color='#006699'>$cod</font>";?> </td>
  </tr>
  <? if($row['comentario'] !==''){ ?>
  <tr>
  	<td colspan="6"><strong>Comentario:</strong> <?=$row['comentario']; ?>  
    </td>
  </tr>
  
  <? }  } }
 
  ?> 
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
							<td class="right strong"><span class="label label-success">$<? echo FormatDinero($monto_contado);?></span></td>
						</tr>
						<tr>
							<td class="right"><b>Credito:</b></td>
							<td class="right strong"><span class="label label-success">$<?  echo FormatDinero($monto_credito_rec);?></span></td>
						</tr>
						<tr>
							<td class="right"><b>Ingreso:</b></td>
							<td class="right strong"><span class="label label-success">$<?  echo FormatDinero($monto_credito);?></span></td>
						</tr>
                        <tr>
							<td class="right"><b>Retirado:</b></td>
							<td class="right strong"><span class="label label-important">$<?  echo FormatDinero($monto_retirado);?></span></td>
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