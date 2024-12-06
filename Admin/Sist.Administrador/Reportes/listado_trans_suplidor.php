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
	
	// DATOS 
	// EL EXCEL VA PARA EL SUPLIDOR DEL GRUPO NOBE (ASISTENCIA VIAL) 
	// ARCHIVO DE VENTAS
	// REMESAS
	
	// EL ARCHIVO DE CONEXION POR FTP ES PARA LA CASA DEL CONDUCTOR
	// ARCHIVO DE VENTAS 
	// REMESAS
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Listados de venta de Seguros por suplidores</h3>
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
                        
                        
                        <label class="control-label">Suplidor</label>
								  
                                        
                            
                            <select name="suplidor" id="suplidor" style="display: inline; width: 170px;" class="form-control">
                        <!--<option value="1aseg">- Todos - </option>-->
                        <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT id, nombre, id_seguro from suplidores WHERE activo ='si' AND reporte='si' order by nombre ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$nombre = $cat2['nombre'];
			$id 		= $cat2['id'];
			//$idSeg 	= $cat2['id_seguro'];
            
			if($_GET['suplidor'] == $id){
				echo "<option value=\"$id\"  selected>$id - $nombre</option>";
			}else{
				echo "<option value=\"$id\" >$id - $nombre</option>"; 
			}
			 
        } ?> 
                        </select>
                         
                        
                        
         <label class="control-label">Tipo</label>
		   <select name="tipo" id="tipo" style="display: inline; width: 60px;" class="form-control">
               <option value="xls" <? if($_GET['tipo']=='xls'){?> selected<? } ?>>Excel</option>
           </select>
                        
                        
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-primary" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
                        
 <? if($_GET['consul']=='1'){?>
  
    <a href="Admin/Sist.Administrador/Reportes/Export/ExcelSuplidor.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>&suplidor=<?=$_GET['suplidor']?>" class="btn btn-success">
    	<i class="fa fa-file-excel-o fa-lg" title="Descargar en Excel"></i>
   </a> 
   
    <? } ?> 
                        </td>
                       
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 		= $('#fecha1').val();
	var fecha2 		= $('#fecha2').val();
	var suplidor		= $('#suplidor').val();
	var tipo 		= $('#tipo').val();
	
	CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans_suplidor.php?fecha1='+fecha1+'&fecha2='+fecha2+'&suplidor='+suplidor+'&tipo='+tipo+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
}); 
	
		 $('#bt_buscar').fadeIn(0); 
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
                            <th>Suplidor</th>
                            <th>Asegurado</th>
                            <th>Cedula</th>
                            <th>Vigencia</th>
                            <th>Vehiculo</th>
                            <th>Estado</th>
                            <th>Precios</th>  
                          </tr>
                      </thead>
                      <tbody>
  <? 
 
 if($_GET['consul']=='1'){
	 
	 //"print_r: ".print_r($_GET)."<br>"; 	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	
	
	//$IDsuplidor = $_GET['suplidor'];
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
		//$reversadas 	.= ",".$rev['id_trans'];
	 }
	 
	
	
	$w_user = "(
	serv_adc LIKE '%".$_GET['suplidor']."-%'
	";
	
	$quer1 = mysql_query("
	SELECT id FROM servicios WHERE id_suplid ='".$_GET['suplidor']."'");
	while($u=mysql_fetch_array($quer1)){
	
		$w_user .= " OR serv_adc LIKE '%".$u['id']."-%'";
	
		$quer2 = mysql_query("
		SELECT id FROM servicios WHERE id_suplid ='".$u['id']."'"); 
		while($u2=mysql_fetch_array($quer2)){
		$w_user .= " OR serv_adc LIKE '%".$u2['id']."-%'";	
		}
	
	}
	$w_user .= " )";
	
	
	//UNSOLO SERVICIO ADICIONAL
	$quer4 = mysql_query("SELECT id FROM servicios WHERE id_suplid ='".$_GET['suplidor']."' LIMIT 1");
	$u4=mysql_fetch_array($quer4);
	$serv_adcs  =  $u4['id'];
$query=mysql_query("
   SELECT * FROM seguro_transacciones 
   WHERE $w_user AND $wFecha   order by id ASC");
   echo "SELECT * FROM seguro_transacciones 
   WHERE $w_user AND $wFecha   order by id ASC"; 
   
   $montoV = "";
   $montoC = "";  
  while($row=mysql_fetch_array($query)){
	  
	  if((substr_count($reversadas,"[".$row['id']."]")>0)){ 
		 $Rtotal +=$row['totalpagar']; 
	  }else{
	  	//$total +=$row['monto'];
	  	//$ganancia += $row['ganancia'];
		//$costo += $row['totalpagar'];
		
		
		
		//BUSCAR CANTIDAD DE LOS SERVICIOS ADICIONALES
		/*$porciones = explode("-", $row['serv_adc']);
		 $monto =0;
		for($i =0; $i < count($porciones); $i++){
			
			if($porciones[$i]>0){
				$serv_adcs  = ValidarServicioOpcional($_GET['suplidor'],$porciones[$i]);
				$monto 		+=  RepCostoServ($row['id'],$serv_adcs);
			}
			
		}*/
			$montoV 		=  RepMontoSeguro($row['id']);
			$montoC 		=  RepCostoServ($row['id'],$serv_adcs);
			
			//$monto = MontoServicio($IDsuplidor,$row['vigencia_poliza']);
			//$total += $monto;
		
	  }
	  
	   $totalV += $montoV;
	   $totalC += $montoC;
	  
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
    <td><?=$Client?></td>
    <td><?=Cedula($row['id_cliente'])?></td>
    <td><?=Vigencia($row['vigencia_poliza'])?></td>
    <td><?=Vehiculo($row['id_vehiculo'])?></td>
    <td>
    <?
		if((substr_count($reversadas,"[".$row['id']."]")>0)){
			echo "<b style='color:#F40408'>Anulado</b>";
		}else{
			echo "<b style='color:#0A22F2'>Vendido</b>";
		}
		
	?>
    
    </td>
    <td><?="M: ".$montoV;?><br><?="C: ".$montoC;?></td>
</tr>
  <? 
 	 	}
 	}
?>
  

<? if($totalV>0){?>  
    <tr>
        <td colspan="6" align="right"><b>Total Vendido</b></td>
        <td><b><?=formatDinero($total)?></b></td>
      </tr>
  <? } ?>
  
  <? if($ganancia>0){?>
    <tr>
        <td colspan="6" align="right"><b>Total Ganancia</b></td>
        <td><b><?=formatDinero($ganancia)?></b></td>
      </tr>
  <? } ?>
  
   <? if($totalC>0){?>
    <tr>
        <td colspan="6" align="right"><b>Total Costo</b></td>
        <td><b><?=formatDinero($costo)?></b></td>
      </tr>
  <? } ?>
  
  <? if($Rtotal>0){?>
     <tr>
        <td colspan="6" align="right"><b>Total Anulado</b></td>
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