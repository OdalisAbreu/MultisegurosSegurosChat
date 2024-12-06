<?
	ini_set('display_errors', 1);
	session_start();
	set_time_limit(0);
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
	include("../../../incluidos/info.profesores.php"); 
	include("../../../incluidos/fechas.func.php");
	//include("../../incluidos/ventas.func.php");
	
	// ORDENAR POR
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
	
	
	
	// INFORMACION DE LOS BANCOS:
	// --------------------------------------------
	$sqlBancos = mysql_query("SELECT id,nombre,cuenta_no FROM cuentas_bancos WHERE nombre !='' ORDER BY id DESC");
	while ($banco = mysql_fetch_array($sqlBancos)) {
		$NombreBanco[$banco['id']] = $banco['nombre'];
		$CuentaBanco[$banco['id']] = $banco['cuenta_no'];
		
	}
	
	
?>

<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Recargar Cliente</h3>
	</div>
<form action="" method="post" enctype="multipart/form-data" id="form_edit_prof">

  
  <div class="modal-body">
<DIV ID="seleccion" style="padding:15px;">
<table width="100%" border="0" cellspacing="3" cellpadding="2" class="dynamicTable tableTools table-hover table table-striped table-bordered table-primary table-white">
  
  <tr>
    <td bgcolor="#FFFFF2"><center>
      <b><font size="4">Transferencias Aplicadas a Distribuidores.</font></b>
      
    </center>
    <center>
	    <font size="2">Desde el:</font> 
	    <input name="fecha1" type="text" id="fecha1" style="font-size:12px; color:#F00; padding:3px; width:70px;" value="<? echo $fecha1;?>" size="9"/>
	    <font size="2">Hasta el :</font> 
        <input name="fecha2" type="text" id="fecha2" style="font-size:12px; color:#F00; padding:3px; width:75px;" size="9" value="<? echo $fecha2;?>"/>
        <br />
        <select name="personal_id" id="personal_id" style=" font-size:16px; padding:1px; margin:1px; border:solid 1px #039; width:120px;">
          <option value=''>Recargador: [Todos]. </option>
           <? ///  SELECCION DEL TIPO .....................................
	$rescat = mysql_query("SELECT id,nombres FROM personal WHERE funcion_id =34 ORDER BY id DESC");
    while ($cat = mysql_fetch_array($rescat)) {
			$c = $cat['nombres'];
			$c_id = $cat['id'];
            if($_GET['personal_id'] == $c_id){
				echo "<option value=\"$c_id\"  selected>$c</option>";
			}else{
				echo "<option value=\"$c_id\" >$c</option>"; 
			}
        } ?>
       </select>
       
       <select name="banco_id" id="banco_id" style=" font-size:16px; padding:1px; margin:1px; border:solid 1px #039; width:120px;">
          <option value=''>Bancos: [Todos]. </option>
  <? ///  SELECCION DEL TIPO .....................................
		$rescat = mysql_query("SELECT id,nombre,cuenta_no FROM cuentas_bancos WHERE nombre !='' ORDER BY id DESC");
		while ($cat = mysql_fetch_array($rescat)) {
			$c 		= $cat['nombre']." (".$cat['cuenta_no'].")";
			$c_id 	= $cat['id'];
            if($_GET['banco_id'] == $c_id){
				echo "<option value=\"$c_id\"  selected>$c</option>";
			}else{
				echo "<option value=\"$c_id\" >$c</option>"; 
			}
		}
?> 
          </select>
       
         <input name="bt_buscar" id="bt_buscar" value="Actualizar" class="btn btn-default"/>
	 
       

        
      </center>
    <script type="text/javascript">
	$('#bt_buscar').click(
		function(){
			var fecha1 	= $('#fecha1').val();
			var fecha2 	= $('#fecha2').val();
			var personal= $('#personal_id').val();
			var banco_id= $('#banco_id').val();
		
			CargarAjax2(
				'Admin/Sist.PersonalRecargas/List/Depositos_Cuenta_v2.php?fecha1='+fecha1+'&fecha2='+fecha2
				+'&dist_id=<? echo $_GET['dist_id'];?>&user_id=<? echo $_GET['user_id'];?>&personal_id='+personal+'&banco_id='+banco_id+'&consul=1','','GET','modal-simple'
		);
	
	}); 
	
		  // CODIGO PARA SACAR CALENDARIO
		  // ****************************
		$(function() {
			$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
			$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
		});
		
		
	function imprSelec(nombre)
	{
	
	  var ficha = document.getElementById(nombre);
	  var ventimp = window.open(' ', 'popimpr');
	  ventimp.document.write( ficha.innerHTML );
	  ventimp.document.close();
	  ventimp.print( );
	  ventimp.close();
	
	} 
		
	  </script>
      
      </td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#D6D6D6" 
	style="border: solid 1px #CCCCCC;  margin-bottom:10px; font-size:12px;" class="dynamicTable tableTools table-hover table table-striped table-bordered table-primary table-white">
  <thead>
  <tr >
    <th>Tipo:</th>
    <th>Credito:</th>
    <th>Pago:</th>
    <th>Contado:</th>
    <th>Monto:</th>
  </tr>
  </thead>
  
  
  <?
   
if($_GET['consul'] =='1'){
	   

	if($_GET['personal_id']){
		$r1 = "AND realizado_por ='".$_GET['personal_id']."'";	
		$r2 = "AND realizado_por2 ='".$_GET['personal_id']."'";	
		$r3 = "AND autorizada_por2 ='".$_GET['personal_id']."'";	
	}
	
	// BANCO
	if($_GET['banco_id']){
		$wBanco = "AND banco_id ='".$_GET['banco_id']."'";	
	}
	
	// BANCO
	if($_GET['user_id']){
		$wBanco .= "AND user_id ='".$_GET['user_id']."'";	
	}
  
  
    $fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde		= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	
	$wFecha = "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00'";
  
  // BUSCANDO CODIGOS DE AUTORIZACION:
  // ----------------------------------------------
  	$sqlAutCod = mysql_query("
	SELECT nombres,id FROM aut_usuarios  ");
	while ($user = mysql_fetch_array($sqlAutCod)){
		$NombreAutUser[$user['id']] = $user['nombres'];
	}
	
  
	$sqlAutCod = mysql_query("
	SELECT user_id,codigo FROM aut_codigos WHERE fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00' ");
	while ($aut = mysql_fetch_array($sqlAutCod)) {
		$NombreAutCode[$aut['codigo']] = $NombreAutUser[$aut['user_id']];
		
	}
  
  // ----------------------------------------------
  
	
  $query = mysql_query("
  
	SELECT * FROM depositos_unicos
	WHERE fecha_reg >= '$fDesde 00:00:00' AND fecha_reg < '$fHasta 24:00:00' $wBanco 
	$r1
	ORDER BY fecha_reg DESC
  ");
  
  while($row = mysql_fetch_array($query)){
	  
	 if($row['tipo'] =='1'){
		 $tipo = "<font color='#003399'><b>Contado</b></font>";
		$RecCont += $row['monto'];
	 }
	 
	if($row['tipo'] =='2'){
		$tipo = "<font color='#FF0000'>Retiro</font>";
		$Retiro += $row['monto'];
	}
	
	if($row['tipo'] =='3'){
		$tipo = "<font color='#006633'>Credito</font>";
		$RecCred += $row['monto'];
	}
	
	
	$SumTotal = (($RecCred + $RecCont) - $Retiro);
	
	 $cco++; 
		if(($cco%2)==0){ 
			$color = '#FFFFFF'; 
		}else{ 
			$color = '#F3F3F3'; 
		}
  ?>
  
 
  <tr>
    <td bgcolor="<?php echo $color; ?>" style="border-left:none; border-top:none !important;">
      <?
		if($row['monto_reverso']){
			echo 'Reverso';
		}else
		if($row['monto_cred']){
			echo 'Credito';
		}else
		if($row['monto_pago'] && $row['monto_contado']){
			echo 'Deposito';
		}else
		if($row['monto_contado']){
			echo 'Contado';
		}else
		if($row['monto_pago']){
			echo 'Pago';
		}
	
	$row['id']?>    </td>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC;">
      <?
    if($row['monto_cred']){
		if($row['monto_reverso']>0)
			echo "<span style='color: #FF0000;'>-".FormatDinero($row['monto_cred'])."</span>";
		else
			echo "<span style='color: #0033FF;'>".FormatDinero($row['monto_cred'])."</span>";
			
		$total_creditos +=$row['monto_cred'];
	}else{
		echo "<span style='color: #999999;'>0.00</span>";	
	}
		
	?></td>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC;">
    <?
	if($row['monto_pago']){
		if($row['monto_reverso']>0)
			echo "<span style='color: #FF0000;'>-".FormatDinero($row['monto_pago'])."</span>";
		else
			echo "<span style='color: #0033FF;'>".FormatDinero($row['monto_pago'])."</span>";
		
		$total_pagos +=$row['monto_pago'];
		$total_total += $row['monto_total'];
	}else{
		echo "<span style='color: #999999;'>0.00</span>";	
	}
	?>
    </td>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC;">
    <?
	if($row['monto_contado']){
		if($row['monto_reverso']>0)
			echo "<span style='color: #FF0000;'>-".FormatDinero($row['monto_contado'])."</span>";
		else
			echo "<span style='color: #0033FF;'>".FormatDinero($row['monto_contado'])."</span>";
		
		$total_contado 	+=$row['monto_contado'];
		$total_total 	+= $row['monto_total'];
	}else{
		echo "<span style='color: #999999;'>0.00</span>";	
	}
	?>
    </td>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC;">
    <b>
    <?
    if($row['monto_reverso']>0)
		echo "<span style='color: #FF0000;'>-".FormatDinero($row['monto_total'])."</span>";
	else
		echo "<span style='color: #0033FF;'>".FormatDinero($row['monto_total'])."</span>";
	
	?>
    </b></td>
  </tr>
  <tr>
    <td colspan="5" bgcolor="<?php echo $color; ?>" style="border:solid 2px #0099CC; border-top:none !important; border-left:none !important; font-size:12px; padding-bottom:10px !important;">
	<?=date("d/m/y <b>h:i:s A</b>",strtotime($row['fecha_reg']))?> - Por: <font color="#006633"> <b> - <?=InfoProfeNombre($row['realizado_por'])?>
</b></font>
<?
		  if($row['banco_id'])
          	echo ' Banco: <span style="color:;"><b>'.$NombreBanco[$row['banco_id']].'</b></span> <em>'.$CuentaBanco[$row['banco_id']].'</em>';
          
		  if($row['aut_codigo'])
          	echo ' Aut.Por: <span style="color: #FF9933;"><b>'.$NombreAutCode[$row['aut_codigo']].'</b></span> <em>'.$row['aut_codigo'].'</em>';
          ?></td>
    </tr>
 
  <? 
	 	 }
	  }
  ?>
  	<tr>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC; color:#666">
   
    </td>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC; font-size:16px; font-weight:bold;">
      <?=number_format($total_creditos,1)?>
    </td>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC; font-size:16px; font-weight:bold;">
    <?=number_format($total_pagos,1)?>
    </td>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC; font-size:16px; font-weight:bold;">
    <?=number_format($total_contado,1)?>
    </td>
    <td bgcolor="<?php echo $color; ?>" style="border-bottom:solid 1px #CCCCCC; font-size:16px; font-weight:bold;">
    <?=number_format($total_total,1)?>
    </td>
  </tr>
  
  
    <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
</table>
</div>

<table border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td><a href="javascript:imprSelec('seleccion')"><img src="images/descargar_archivo/print.jpg" border="0"/></a></td>
    <td>
    
    <a href="Admin/Sist.SA/Export/exportar_Depositos_Cuenta.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>"><img src="images/descargar_archivo/excel.jpg" border="0"/></a>
    
    </td>
  </tr>
</table>
</div>
<div class="modal-footer" style="margin-bottom:-20px;">
	<a href="#" class="btn btn-danger" data-dismiss="modal" id="cerrar">Cerrar</a> 
	<a href="#" class="btn btn-primary" onClick="ComfRecar();" id="recargar">Recargar</a>
    <a href="#" class="btn btn-default"  id="recargar2" style="display:none">Enviando...</a>
    <div id="recargar2" style="display:none;"> Cargando&nbsp;&nbsp;<img src="images/iconos/ajax-loader.gif" width="32" height="32" /></div>
	</div>
	    
	    <input name="id" type="hidden" id="id" value="<? echo $row['id']; ?>">
	    <input name="id" type="hidden" id="id" value="<? echo $_GET['id']; ?>" />

</form>
</div>
