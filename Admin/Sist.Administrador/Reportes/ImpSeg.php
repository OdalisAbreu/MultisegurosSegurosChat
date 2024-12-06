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
	
	if()
	
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Impresion de Seguros </h3>
    </div>
</div>

		
    
    
    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
    <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                    	<td>
                        
                <form name="formulario" method="post" action="ejemploPost.php">     
                        <label style="margin-left:5px;">Cedula:</label>
                        <input type="text" name="cedula" id="cedula" class="input-mini" value="<?=$cedula?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
            </form>
                        </td>
                       
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();

	
	CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 



	$('#descargar').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val(); 
	var aseguradora 	= $('#aseguradora').val();
	
	//CargarAjax2('Admin/Sist.Administrador/Reportes/Export/listado_trans.php?fecha1='+fecha1+'&fecha2='+fecha2+'&aseguradora='+aseguradora+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    
});

		 $('#bt_buscar').fadeIn(0); 
		  // CODIGO PARA SACAR CALENDARIO
		  // ****************************
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
  
  if($_GET['consul']=='1'){
	  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00'";
	
$query=mysql_query("
   SELECT id,fecha,id_cliente,fecha_inicio,vigencia_poliza,id_vehiculo,user_id,monto,ganancia
   FROM seguro_transacciones 
   WHERE user_id !='' $wFecha order by id ASC");

  while($row=mysql_fetch_array($query)){
	  $total +=$row['monto'];
	  $ganancia += $row['ganancia'];
	  $fh1		= explode(' ',$row['fecha']);
	  $Cliente = explode("|", Cliente($row['id_cliente']));
	  $Client = str_replace("|", "", $Cliente[0]);
	  
	  $i++;
?>
<tr>
    <td><?=$i?></td>
    <td><?=$fh1[0]?></td>
    <td><?=Clientepers($row['user_id'])?></td>
    <td><?=$Client?></td>
    <td><?=Cedula($row['id_cliente'])?></td>
    <td><?="$".FormatDinero($row['monto'])?></td>
    <td><?="$".FormatDinero($row['ganancia'])?></td>
   <!-- <td><?=Fecha($row['fecha_inicio'])?></td>-->
    <td><?=Vigencia($row['vigencia_poliza'])?></td>
    <td><?=Vehiculo($row['id_vehiculo'])?></td>
</tr>
  <?
  	 } 
  	}
  ?>
  
  
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
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>