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
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Listados de venta de Seguros por aseguradora</h3>
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
                        
                        
                        <label class="control-label">Aseg</label>
								  
                                        
                            
                            <select name="aseguradora" id="aseguradora" style="display: inline; width: 170px;" class="form-control">
                        <option value="1aseg">- Todos - </option>
                        <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT id, nombre from seguros order by nombre ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$nombre = $cat2['nombre'];
			$id 		= $cat2['id'];
            
			if($_GET['aseguradora'] == $id){
				echo "<option value=\"$id\"  selected>$nombre</option>";
			}else{
				echo "<option value=\"$id\" >$nombre</option>"; 
			}
			 
        } ?> 
                        </select>
                         
                        
                        
         <label class="control-label">Tipo</label>
		   <select name="tipo" id="tipo" style="display: inline; width: 60px;" class="form-control">
               <option value="xls" <? if($_GET['tipo']=='xls'){?> selected<? } ?>>Excel</option>
               <!--<option value="csv" <? if($_GET['tipo']=='csv'){?> selected<? } ?>>Csv</option>
               <option value="txt" <? if($_GET['tipo']=='txt'){?> selected<? } ?>>Txt</option>-->
           </select>
           
            <label class="control-label">ID:</label>
           <input type="text" name="user_id" id="user_id" class="input-mini" value="<?=$_GET['user_id']?>" style="width: 45px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
           
          
                        
                        
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-primary" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
                        
                        
                        
                        
 
                        
 
                        </td>
                      
                       
                      </tr>
                      
                      <tr>
                      	<td>
                        
              <? if($_GET['consul']=='1'){?>
 
           <label class="control-label">Descargar:</label>           
    
	<? if($_GET['aseguradora'] =='1'){?>
            
          <? 
          //DOMINICANA DE SEGUROS
          if($_GET['tipo']=='xls'){?>  
            <a href="Admin/Sist.Administrador/Reportes/Export/Excel.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
                <i class="fa fa-file-excel-o fa-lg" title="Descargar en Excel"></i>
           </a> 
           
           <? } ?>
           
            <? if( $_GET['tipo']=='txt'){?>  
            <a href="Admin/Sist.Administrador/Reportes/Export/Txt.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
                    <i class="fa fa-file-text-o fa-lg" title="Descargar en Txt"></i>
           </a> 
           <? } ?>
           
           <? if($_GET['tipo']=='csv'){?>  
            <a href="Admin/Sist.Administrador/Reportes/Export/Csv.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
                    <i class="fa fa-file-archive-o fa-lg" title="Descargar en Csv"></i>
           </a> 
           <? } ?>
           
       <? } ?>
           
   
   <? if($_GET['aseguradora'] =='2'){?>
 
  <? 
  //SEGUROS PATRIA
  if($_GET['tipo']=='xls'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/Excel.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
    	<i class="fa fa-file-excel-o fa-lg" title="Descargar en Excel"></i>
   </a> 
   
   <? } ?>
   
    <? if( $_GET['tipo']=='txt'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/Txt.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
        	<i class="fa fa-file-text-o fa-lg" title="Descargar en Txt"></i>
   </a> 
   <? } ?>
   
   <? if($_GET['tipo']=='csv'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/Csv.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
        	<i class="fa fa-file-archive-o fa-lg" title="Descargar en Csv"></i>
   </a> 
   <? } ?>
   
   <? } ?>
   
   <? if($_GET['aseguradora'] =='3'){?>
 
  <? 
  //GENERAL DE SEGUROS
  if($_GET['tipo']=='xls'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/Excel.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
    	<i class="fa fa-file-excel-o fa-lg" title="Descargar en Excel"></i>
   </a> 
   
   <? } ?>
   
    <? if( $_GET['tipo']=='txt'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/TxtGeneral.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
        	<i class="fa fa-file-text-o fa-lg" title="Descargar en Txt"></i>
   </a> 
   <? } ?>
   
   <? if($_GET['tipo']=='csv'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/Csv.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
        	<i class="fa fa-file-archive-o fa-lg" title="Descargar en Csv"></i>
   </a> 
   <? } ?>
   
   <? } ?>
   
   
   
    <? if($_GET['aseguradora'] =='1aseg'){?>
 
  <? 
  //GENERAL DE SEGUROS
  if($_GET['tipo']=='xls'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/Excel.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
    	<i class="fa fa-file-excel-o fa-lg" title="Descargar en Excel"></i>
   </a> 
   
   <? } ?>
   
    <? if( $_GET['tipo']=='txt'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/Txt.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
        	<i class="fa fa-file-text-o fa-lg" title="Descargar en Txt"></i>
   </a> 
   <? } ?>
   
   <? if($_GET['tipo']=='csv'){?>  
    <a href="Admin/Sist.Administrador/Reportes/Export/Csv.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&aseguradora=<?=$_GET['aseguradora']?>" class="btn btn-success">
        	<i class="fa fa-file-archive-o fa-lg" title="Descargar en Csv"></i>
   </a> 
   <? } ?>
   
   <? } ?>

<? if($_GET['user_id']){ ?>   
  <label class="control-label">Documento:</label>
 
  <a href="#" onClick="CargarAjax_win('Admin/Sist.Administrador/Reportes/GenerarPeticion.php?fecha1=<?=$_GET['fecha1']?>&fecha2=<?=$_GET['fecha2']?>&user_id=<?=$_GET['user_id']?>','','GET','cargaajax');">
    <button type="button" id="descargar" class="btn btn-danger" style="margin-left:10px; margin-left:15px; margin-left:5px;" >
      Generar Descargar
    </button>
 </a> 
 
 <? }  } ?>
 
 
                        </td>
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 		= $('#fecha1').val();
	var fecha2 		= $('#fecha2').val();
	var aseguradora 	= $('#aseguradora').val();
	var tipo 		= $('#tipo').val();
	var user_id 		= $('#user_id').val();
	
	CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans_aseg.php?fecha1='+fecha1+'&fecha2='+fecha2+'&aseguradora='+aseguradora+'&tipo='+tipo+'&user_id='+user_id+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    //setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 


	
	
		
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
                            <th>Aseguradora</th>
                            <th>Asegurado</th>
                            <th>Vigencia</th>
                            <th>Vehiculo</th>
                            <th>Estado</th>
                            <th>&nbsp;</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
 
 if($_GET['consul']=='1'){
	  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	$FechaRev 	= "fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	if($_GET['aseguradora'] !='1aseg'){
		$aseg = "AND id_aseg='".$_GET['aseguradora']."' ";
	}
	
	if($_GET['user_id']){
		$user_id = " AND user_id =".$_GET['user_id']." ";
	}else{
		
	}
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE $FechaRev");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
		//$reversadas 	.= ",".$rev['id_trans'];
	 }
	 
	 
$query=mysql_query("
   SELECT * FROM seguro_transacciones 
   WHERE $wFecha $aseg  $user_id order by id ASC");

  while($row=mysql_fetch_array($query)){
	  
	  $p++;
	  
	  if((substr_count($reversadas,"[".$row['id']."]")>0)){
		 $Rtotal +=$row['totalpagar']; 
		 $mensaje =  "<b style='color:#F40408'>Anulado</b>";
	  }else{
	  	$total +=$row['monto'];
	  	$ganancia += $row['ganancia'];
		$costo += $row['totalpagar'];
		$mensaje =  "<b style='color:#0A22F2'>Vendido</b>";
	  }
	  
	  $fh1		= explode(' ',$row['fecha']);
	  $Cliente = explode("|", Cliente($row['id_cliente']));
	  $Client = str_replace("|", "", $Cliente[0]);
	  $i++;
	  
	  $pref = GetPrefijo($row['id_aseg']);
	  $idseg = str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
	  $prefi = $pref."-".$idseg;

?>
<tr>
    <td><b><?=$row['id']?></b>
    <br><?=FechaList($fh1[0])?></td>
    <td><b><?=NombreSeguroS($row['id_aseg'])?></b>
    <br><?=$prefi?></td>
    <td><?=$Client?><br><?=Cedula($row['id_cliente'])?></td>
    <td><?=Vigencia($row['vigencia_poliza'])?></td>
    <td><?=Vehiculo($row['id_vehiculo'])?></td>
    
    <td>
    <?
		echo $mensaje;
		echo "<br>C: ".FormatDinero($row['totalpagar']);
		echo "<br>M: ".FormatDinero($row['monto']);
	?>
    
    </td>
    
    <td> <a href="javascript:void(0)" onclick=" CargarAjax_win('Admin/Sist.Administrador/Revisiones/Imprimir/Accion/poliza.php?id_trans=<?=$row['id']?>','','GET','cargaajax'); " data-title="Visualizar"  class="btn btn-danger">
             <i class="fa fa-eye fa-lg"></i> 
            </a></td>
</tr>
  <? 
 	 	}
 	}
?>
  



<? if($total>0){?>  
    <tr>
    	<td colspan="3" rowspan="4">Total de transacciones<br><b><?=$p?></b></td>
        <td colspan="3" align="right"><b>Total Vendido</b></td>
        <td><b><?=formatDinero($total)?></b></td>
      </tr>
  <? } ?>
  
  <? if($ganancia>0){?>
    <tr>
        <td colspan="3" align="right"><b>Total Ganancia</b></td>
        <td><b><?=formatDinero($ganancia)?></b></td>
      </tr>
  <? } ?>
  
   <? if($costo>0){?>
    <tr>
        <td colspan="3" align="right"><b>Total Costo</b></td>
        <td><b><?=formatDinero($costo)?></b></td>
      </tr>
  <? } ?>
  
  <? if($Rtotal>0){?>
     <tr>
        <td colspan="3" align="right"><b>Total Anulado</b></td>
        <td><b><?=formatDinero($Rtotal)?></b></td>
      </tr>
  <? } ?> 
  
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