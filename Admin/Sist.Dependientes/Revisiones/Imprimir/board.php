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
	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00'";
	
	
	if($_GET['user']){
		$user = "user_id ='".$_GET['user']."' ";
		$user1 = $_GET['user'];
	}else{
		$user = "user_id !='' ";
	}
	
	if($_GET['tipo']=='t'){
		$tipo = "";
	}else{
		$tipo = "AND peticion ='".$_GET['tipo']."' ";
	}
	
	
	
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Board de transacciones </h3>
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
                        
                          <label style="margin-left:5px;">Usuario:</label>
                        <input type="text" name="user" id="user" class="input-mini" value="<?=$user1?>" style="width: 65px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        
                        <label style="margin-left:5px;">Tipo:</label>
                        <select class="span12" style="font-size: 18px; height: 34px; color: #000; margin-top: 15px; width: 230px;" name="tipo" id="tipo">
                <option value="t" <? if($_GET['tipo']=='t'){?> selected="selected" <? } ?> >Todos</option>
                <option value="venta_ok" <? if($_GET['tipo']=='venta_ok'){?> selected="selected" <? } ?> >Api. Venta OK</option>
                <option value="venta_error" <? if($_GET['tipo']=='venta_error'){?> selected="selected" <? } ?> >Api. Venta ERROR</option>
                <option value="balance" <? if($_GET['tipo']=='balance'){?> selected="selected" <? } ?> >Api. ver balance</option>
                <option value="imp_seguro" <? if($_GET['tipo']=='imp_seguro'){?> selected="selected" <? } ?> >Api. imprimir seguro</option>
                <option value="ver_serv" <? if($_GET['tipo']=='ver_serv'){?> selected="selected" <? } ?> >Api. ver servicio</option>
                <option value="ver_aseguradora" <? if($_GET['tipo']=='ver_aseguradora'){?> selected="selected" <? } ?> >Api. ver aseguradora</option>
                <option value="ver_modelos" <? if($_GET['tipo']=='ver_modelos'){?> selected="selected" <? } ?> >Api. ver modelo</option>
                <option value="ver_marca" <? if($_GET['tipo']=='ver_marca'){?> selected="selected" <? } ?> >Api. ver marca</option>
                <option value="ver_tarif" <? if($_GET['tipo']=='ver_tarif'){?> selected="selected" <? } ?> >Api. ver tarifa</option>
                 <option value="ver_ciudad" <? if($_GET['tipo']=='ver_ciudad'){?> selected="selected" <? } ?> >Api. ver ciudad</option>
                
                
                
            </select>
                        
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
	var user 	= $('#user').val();
	var tipo 	= $('#tipo').val();
	
	CargarAjax2('Admin/Sist.Administrador/Revisiones/List/board.php?fecha1='+fecha1+'&fecha2='+fecha2+'&user='+user+'&tipo='+tipo+'&consul=1','','GET','cargaajax');
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
                            <th>Usuario</th>
                            <th>Descripcion</th>
                            <th>Peticion</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  
  
  if($_GET['consul']=='1'){
	  	
	
	
	
	
	
$query=mysql_query("
   SELECT * FROM auditoria 
   WHERE $user $tipo $wFecha order by id DESC");
  while($row=mysql_fetch_array($query)){
	  
	  		if($row['peticion']=='venta_ok'){ 			$tipo ="Venta OK"; 			}
			if($row['peticion']=='venta_error'){ 		$tipo ="Venta ERROR"; 		}
			if($row['peticion']=='imp_seguro'){			$tipo ="imprimir seguro"; 	}
			if($row['peticion']=='ver_serv'){ 			$tipo ="ver servicio"; 		}
			if($row['peticion']=='ver_aseguradora'){ 	$tipo ="ver aseguradora"; 	}
			if($row['peticion']=='ver_modelos'){ 		$tipo ="ver modelo"; 		}
			if($row['peticion']=='ver_marca'){ 			$tipo ="ver marca"; 			}
			if($row['peticion']=='ver_tarif'){ 			$tipo ="ver tarifa"; 		}
			if($row['peticion']=='ver_ciudad'){ 			$tipo ="ver ciudad"; 		}
			if($row['peticion']=='balance'){ 			$tipo ="ver balance"; 		}
	  
?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['fecha']?></td>
    <td><?=Clientepers($row['user_id'])?></td>
    <td><?=$row['descrip']?></td>
    <td><?=$tipo?></td>
   
</tr>
  <?
  	 } 
  	}
  ?>
  
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