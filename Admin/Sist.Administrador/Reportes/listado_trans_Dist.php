<? 
	session_start();
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	include("../../../incluidos/nombres.func.php");
	include("../../../incluidos/fechas.func.php");
	Conectarse();
	
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
        <h3 class="page-header">Listados de venta de Seguros por el distribidor <strong><?=ClientePers($_GET['dist_id'])?></strong></h3>
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
                        
           <!-- <label class="control-label">ID:</label>
           <input type="text" name="user_id" id="user_id" class="input-mini" value="<?=$_GET['user_id']?>" style="width: 45px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">-->
           
                        
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-primary" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
 
                        </td>
                      </tr>
                      <tr>
                      	<td>
                        
              <? if($_GET['consul']=='1'){?>
 
           <label class="control-label">Descargar:</label>           
    

<? if($_GET['user_id']){ ?>   
  <label class="control-label">Documento:</label>
 
  <!--<a href="#" onClick="CargarAjax_win('Admin/Sist.Administrador/Reportes/GenerarPeticion.php?fecha1=<?=$_GET['fecha1']?>&fecha2=<?=$_GET['fecha2']?>&user_id=<?=$_GET['user_id']?>','','GET','cargaajax');">
    <button type="button" id="descargar" class="btn btn-danger" style="margin-left:10px; margin-left:15px; margin-left:5px;" >
      Generar Descargar
    </button>
 </a> -->
 
 <? }  } ?>
 
 
                        </td>
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 		= $('#fecha1').val();
	var fecha2 		= $('#fecha2').val();
	
	CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans_Dist.php?fecha1='+fecha1+'&fecha2='+fecha2+'&dist_id=<?=$_GET['dist_id']?>&consul=1','','GET','cargaajax');
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
                            <th>Cedula</th>
                            <th>Vigencia</th>
                            <th>Vehiculo</th>
                            <th>Estado</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
 
 if($_GET['consul']=='1'){
	  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND  fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
	 }
	 
	
$query=mysql_query("
   SELECT * FROM seguro_transacciones 
   WHERE (dist_id = '".$_GET['dist_id']."' OR user_id = '".$_GET['dist_id']."')  $wFecha order by id ASC");
  while($row=mysql_fetch_array($query)){
	  
	  $p++;
	  
	  if((substr_count($reversadas,"[".$row['id']."]")>0)){
		 $TotalAnul +=  $row['monto']; 
		 $mensaje 	 =  "<b style='color:#F40408'>Anulado</b>";
	  }else{
	  	$TotalVent  +=  $row['monto'];
	  	$ganancia   +=  $row['ganancia2'];
		$costo 		+=  $row['totalpagar'];
		$mensaje 	=   "<b style='color:#0A22F2'>Vendido</b>";
	  }
	  
	  $fh1		= explode(' ',$row['fecha']);
	  $Cliente = explode("|", Cliente($row['id_cliente']));
	  $Client = str_replace("|", "", $Cliente[0]);
	  $i++;
	  
	  $pref = GetPrefijo($row['id_aseg']);
	  $idseg = str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
	  $prefi = $pref."-".$idseg;
	  
	  
	  $TotalVentas = $TotalAnul + $TotalVent;
	  

?>
<tr>
    <td align="left"><b><?=$row['id']?></b>
    <br><?=FechaList($fh1[0])?></td>
    <td align="left"><b><?=NombreSeguroS($row['id_aseg'])?></b>
    <br><?=$prefi?></td>
    <td align="left"><?=$Client?><br><b><?=ClientePers($row['user_id'])?></b></td>
    <td align="left"><?=Cedula($row['id_cliente'])?></td>
    <td align="left"><?=Vigencia($row['vigencia_poliza'])?></td>
    <td align="left"><?=Vehiculo($row['id_vehiculo'])?></td>
    <td align="left">
    <?
		echo $mensaje;
		echo "<br>M: ".$row['monto'];
	?>
    
    </td>
</tr>
  <? 
 	 	}
 	}
?>
  



<? if($TotalVentas>0){?>  
    <tr>
    	<td colspan="3" rowspan="4">Total de transacciones<br><b><?=$p?></b></td>
        <td colspan="3" align="right"><b>Total Venta</b></td>
        <td><b><?=formatDinero($TotalVentas)?></b></td>
      </tr>
  <? } ?>
  
  <? if($TotalAnul>0){?>
     <tr>
        <td colspan="3" align="right"><b>Total Anulado</b></td>
        <td><b><?=formatDinero($TotalAnul)?></b></td>
      </tr>
  <? } ?>
  
  <? if($TotalVent>0){?>
     <tr>
        <td colspan="3" align="right"><b>Ventas Neta</b></td>
        <td><b><?=formatDinero($TotalVent)?></b></td>
      </tr>
  <? } ?>
  
  <? if($ganancia>0){?>
    <tr>
        <td colspan="3" align="right"><b>Total Ganancia</b></td>
        <td><b><?=formatDinero($ganancia)?></b></td>
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