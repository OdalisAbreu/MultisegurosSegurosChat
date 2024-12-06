<?
	session_start();
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
?>
<ul class="breadcrumb">
	<li>Tu estas Aqui</li>
	<li class="divider"></li>
	<li>Dependientes</li>
	<li class="divider"></li>
	<li>Puntos de venta</li>
</ul>
<h2>Listados de Cierres de Caja</h2>
			<? if($acc1=='eliminar'){?>
           <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este punto de venta se ha desabilitado correctamente</span>
             <? }else if($acc1=='editar'){?>
               <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este punto de venta se ha editado correctamente</span>
             <? }else if($acc1=='registrar'){?>
               <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este punto de venta se ha registrado correctamente</span>
             <? } ?>
	<!-- Widget -->
  <div class="innerLR">
	<div class="widget widget-heading-simple widget-body-gray">
		<div class="widget-body">
			<!-- Table -->
<table class="dynamicTable tableTools table-hover table table-striped table-bordered table-primary table-white">
    <!-- Table heading -->
    <thead>  
      <tr>
        <th width="0">No.:</th>
        <th width="0">Fecha Ultimo Cierre: </th>
        <th width="0">Fecha Cierre: </th>
        <th width="0">Monto Recargado:</th>
        <th width="0">Diferencia:</th>
        <th width="0">Opciones</th>
      </tr>
   </thead>
  <?
  	$w_user ="AND user_id= '".$_SESSION['user_id']."'";

	$conf['limit'] = 5;
	$total = mysql_num_rows(mysql_query("
	SELECT id from cierre_de_caja WHERE id !='' $w_user"));
   $actual = $_GET['actual'];
   if(empty($actual)){ $actual = 0; }
  
   if($actual == 0){
   $desde = $actual; }
   else{
   $desde = $actual * $conf['limit'];
   }
   $totalpaginas1 = $total / $conf['limit']; 
   $totalpaginas = round($totalpaginas1); // Total de paginas Redondeada...
   $paginar = "LIMIT $desde,".$conf['limit'].""; // variable ya definida para paginar...
   
	
  $query=mysql_query("
  SELECT id,fecha,fecha_ult_cierre,sum(total_recargado) AS total_recargado,
  sum(diferencia) AS diferencia FROM cierre_de_caja WHERE id_cuenta !='' $w_user
  GROUP BY fecha
  ORDER BY id DESC $paginar");
  while($row=mysql_fetch_array($query)){
	$fech		= explode(' ',$row['fecha']);
	$f			= explode('/',$fech[0]);
	$f_1		= $f[2].$f[1].$f[0];
  ?>
  <tr >
    <td width="0">000<? echo $row['id']; ?></td>
    <td width="0"><? echo FechaAud($row['fecha_ult_cierre']); ?></td>
    <td width="0"><? echo FechaAud($row['fecha']); ?></td>
    <td width="0"><? echo FormatDinero($row['total_recargado']); ?></td>
	<td width="0"><? echo FormatDinero($row['diferencia']); ?></td>
    <td width="0"><a href="#" class="btn btn-default" onclick="CargarAjax2('Admin/Sist.PersonalRecargas/List/CuadreBancos_Detalle.php?fecha=<?=$row['fecha']?>&id=<?=$row['id']?>','','GET','cargaajax');">Detalle</a></td>
  </tr>
  <? }  ?>
  
  <tr>
    <td colspan="6" align="right" style="text-align:right !important;">
  <? if($actual >= 1){ $ant_url = "$actual" - 1; ?>
   <button type="button" class="btn btn-default" onclick="CargarAjax2('Admin/Sist.PersonalRecargas/List/Listado_Cuadres.php?actual=<?=$ant_url?>','','GET','cargaajax')"><i class="icon-chevron-left"></i></button>
    <? } if ($pat_actual >= $totalpaginas){ echo""; }else{ $sit_url = "$actual" + 1; ?>
   <button type="button"  class="btn btn-default"  
  onclick="CargarAjax2('Admin/Sist.PersonalRecargas/List/Listado_Cuadres.php?actual=<?=$sit_url?>','','GET','cargaajax')"><i class="icon-chevron-right"></i></button> 
        <? } $ordenactual = $_GET['ordenar']; $pat_actual = "$actual" + 1 ; ?>
          </td>
        </tr>
        
  </table>