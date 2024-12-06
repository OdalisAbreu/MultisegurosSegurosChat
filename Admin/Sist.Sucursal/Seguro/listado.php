<?php

	session_start();
	ini_set("display_errors",1);
	include("../../inc/conexion_inc.php");
	Conectarse(); 
	include('../../inc/bd_manejos.php');
	include('../../inc/Func/Marcas_func.php');
	include('../../inc/fechas.func.php');
	include('../../inc/Func/Modelos_func.php');
	include("../../idiomas/".$_SESSION['idioma'].".php");
	
	// MANEJO DE FECHAS:
	// --------------------------------------------	
	if($_GET['fecha1']){
		$fecha1 	= $_GET['fecha1'];
	}else{
		$fecha1 	= fecha_despues(''.date('d/m/Y').'',-0);
	}
	// --------------------------------------------
	if($_GET['fecha2']){
		$fecha2 	= $_GET['fecha2'];
	}else{
		$fecha2 	= fecha_despues(''.date('d/m/Y').'',0);
	}
	// -------------------------------------------
	
   	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha = "AND fecha >= '$fDesde' AND fecha < '$fHasta 24:59:59'";
	
//	******************************************** eliminar registro
	$acc1 = $_POST['accion'].$_GET['action'];
//	******************************************** eliminar registro 
	
	// ALIMINAR
	if($acc1=='eliminar'){
	
	$id=$_GET['id'];
        $query=mysql_query("DELETE FROM seguro_ventas where id='$id'");
	 echo mysql_error();	
	}


	// EDITAR
	if($_POST['accion']=='editar'){
	
		unset($_POST['accion']);
		EditarForm('servicio_ventas');
		echo mysql_error();
		echo'
		<script>
			$("#close_modal").click();
		</script>
		';
		
	}
	
	// REGISTRAR NUEVO
	if($_POST['accion']=='registrar'){
		
		//$_POST['d_fecha'] = date("Y-m-d H:i:s");
		unset($_POST['accion']);
		Insert_form('servicio_ventas');
		echo mysql_error();

		
		echo'
		<script>
		$("#close_modal").click();
		</script>
		';
		
	}
	
	// ORDENAR POR
	
	if(!$_GET['ordenar']){
		$ordenar = 'nombre ASC';
	}else{
		$ordenar = $_GET['ordenar'];
	}
	
	// BUSCAR
	if($_GET['busq']){
		$where = "AND (nombre LIKE '%".$_GET['busq']."%' or id='".$_GET['busq']."')";
	}else{
		//$where = "AND id_dist ='".$_SESSION['user_id']."'";
	}
?>


<h1 class="message-header">Seguros</h1>

<table border="0" align="center" cellpadding="0" cellspacing="0" class="sidebar_2" style="width:100%;">
  
  <tr>
    <td>
    <a href="#" class="btn large-btn" onclick="CargarAjax2('Modulos/Seguro/listado.php','','GET','');"><?=LG_LISTADO?></a>
    
    <a data-toggle="modal" data-keyboard="false" href="#myModal" class="btn large-btn orange-btn" onclick="CargarAjax2_win('Modulos/Seguro/seguro2.php?accion=registrar');"><?=LG_REGISTRAR?></a>
    </td>
    <td width="17%" valign="bottom"><div class="input-prepend">
    <span class="add-on">Fecha Desde:</span>
    <input name="fecha1" type="text" class="span2" id="fecha1" size="16" value="<?=$fecha1?>" style="width:75px;">
  </div></td>
    <td width="17%" valign="bottom"><div class="input-prepend"> <span class="add-on">Fecha Hasta:</span>
        <input name="fecha2" type="text" class="span2" id="fecha2" size="16" value="<?=$fecha2?>" style="width:75px;"/>
    </div></td>
    <td align="right" width="5%">
      <input name="bd_buscar" id="bd_buscar" type="button" value="OK" class="btn" style="font-size:12px; width:50px; float:right;">
       <script type="text/javascript">
		$('#bd_buscar').click(
			function(){
				var fecha1 		= $('#fecha1').val();
				var fecha2 		= $('#fecha2').val();
		
				CargarAjax2(
				'Modulos/Seguro/listado.php?fecha1='+fecha1+'&fecha2='+fecha2+'','','GET','');
		}); 
		 
		  // CODIGO PARA SACAR CALENDARIO
		  // ****************************
		$(function() {
			$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
			$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
		});
	  </script>
      </td>
  </tr>
</table>
<div id="cargaajax_2" style="margin-top:10px;">
  <div class="datagrid">
  <table>
<thead><tr>
   <th>ID</th>
  <th>Fecha:</th>
  <th>Banca:</th>
  <th>nombre:</th>
  <th>Marca:</th>
  <th>Vigencia:</th>
  <th>Monto:</th>
 
<tfoot><tr><td colspan="9"><div id="paging"><ul><li>
  <a href="#" onclick="CargarAjax2('Modulos/Seguro/listado.php?actual=<?=$sid_url?>','','GET','cargaajax');"><span><?=LG_ANTERIOR?></span></a></li>
  
  <li>
    
  <? // SIGUIENTE.....
   // si es menol lo muestra....
   if ($pad_actual >= $totalpaginas){ 
    	echo"";
   }
   else {
   	$sid_url = "$actual" + 1;
   }
   // si es Igual no muestra...
   
   // ANTERIOR.....
   $ordenactual = $_GET['ordenar'];
   
   if($actual >= 1){
   		$ant_url = "$actual" - 1;
   }
   
   $pad_actual = "$actual" + 1 ;
?>
    
  <a href="#" onclick=\"CargarAjax2('Modulos/Seguro/listado.php?actual=<?=$sid_url?>','','GET','cargaajax_2');"><span><?=LG_SIGUIENTE?></span></a></li></ul>
  
  <? 
   ?></td>
        </tr></tfoot>
<tbody>
<? 
	
  $query=mysql_query("
	SELECT * FROM seguro_ventas 
	WHERE id !='' $wFecha
	ORDER BY id DESC ");
  
  while($nominadep=mysql_fetch_array($query)){
	$numDisp ++;
?>

<tr<? if($alt ==1){?>class="alt"<? }?>>
   <td><font size="3"><b><?=$nominadep['id']?></b></font></td>
    <td><? echo $nominadep['fecha']; ?></td>
    <td><? echo $nominadep['banca']; ?></td>
    <td><? echo $nominadep['nombre']; ?></td>
    <td><?  
	 $veh = mysql_query("SELECT * FROM seguro_vehiculo WHERE id ='".$nominadep['id_vehiculo']."' LIMIT 1");
	 $veh_descr = mysql_fetch_array($veh);
	 echo Marcas($veh_descr['veh_marca'])." ".Modelos($veh_descr['veh_modelo'])." ".$veh_descr['veh_year'];
	
	?></td>
    <td><? echo $nominadep['vigencia_poliza']; ?> Meses</td>
    <td><? echo $nominadep['monto']; ?></td>
   
</tr>

<? 
	if($alt ==0){
		$alt =1;
	}else{
		$alt =0;	
	}
}?>

</tbody>
</table>
  </div>


</div>