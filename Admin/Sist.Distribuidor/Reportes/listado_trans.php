<?
	session_start();
	ini_set('display_errors',0);
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
    <div class="col-lg-12">
        <h3 class="page-header">Listados de venta de Seguros </h3>
    </div>
</div>

		
  <? if($_GET['consul'] !=='1'){?>
   <center>
  	<div id="div_ultimo_acc2" class="alert alert-success" style=" font-size:14px; width:95%;" align="center" >
    	<strong>Por favor proporcionar la fecha que desea buscar</strong>
		<script>setTimeout(function(){$("#div_ultimo_acc2").fadeOut(3000); },20000);</script>
	</div>
	</center><? } ?>    
    
    
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
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar
                        </button>
                        
<? if($_GET['consul']){?>
 
  <a href="#" onClick="CargarAjax_win('Admin/Sist.Distribuidor/Reportes/GenerarPeticion.php?fecha1=<?=$_GET['fecha1']?>&fecha2=<?=$_GET['fecha2']?>&user_id=<?=$_SESSION['user_id']?>','','GET','cargaajax');">
    <button type="button" id="descargar" class="btn btn-danger" style="margin-left:10px; margin-left:15px; margin-left:5px;" >
      Generar Descargar
    </button>
 </a>  
                      
 <? } ?>
 
                        </td>
                       
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();

	
	CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_trans.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 
	
	
		 
		  // CODIGO PARA SACAR CALENDARIO
		  // ****************************
		$(function() {
			$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
			$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
		});
	  </script>

      
   
			</div>
       <? if($_GET['consul']=='1'){ ?>      
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th style="width: 82px;">#</th>
                            <th>Nombre</th>
                            <th>Asegurado</th>
                            <th>Monto</th>
                            <th>Ganancia</th>
                            <!--<th>Fecha Inicio</th>-->
                            <th>Vigencia</th>
                            <th>Vehiculo</th>
                            <th>Opcion</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	//echo $_SESSION['dist_id'];
	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
	 }
	 
   $query=mysql_query("
   SELECT * FROM seguro_transacciones 
   WHERE ( dist_id='".$_SESSION['user_id']."'  ) $wFecha order by id ASC");

  while($row=mysql_fetch_array($query)){	  
	  
	  $fh1		= explode(' ',$row['fecha']);
	  $polizaNum		= GetPrefijo($row['id_aseg'])."-".str_pad($row['id_poliza'],6, "0", STR_PAD_LEFT);
	  $p++;
?>
<tr>
    <td><?=$row['id']?><br><font style="font-size:12px; color:#0B197C"><?=$fh1[0]?></font></td>
    <td><?=Clientepers($row['user_id'])?>
    
    </td>
    <td><?=ClienteRepS($row['id_cliente'])?>
    <br><font style="font-size:12px; color:#0B197C"><?=$polizaNum?></font></td>
    <td><?="$".FormatDinero($row['monto'])?></td>
    <td><?="$".FormatDinero($row['ganancia2'])?></td>
    <td><?=Vigencia($row['vigencia_poliza'])?></td>
    <td><?=Vehiculo($row['id_vehiculo'])?></td>
    <td>
    <?
    
	 if((substr_count($reversadas,"[".$row['id']."]")>0)){
		 $TotalAnul +=  $row['monto'];
		 $TganAnul  +=  $row['ganancia2'];
		 $TcostAnul 	+=  $row['totalpagar']; 
		$mensaje 	=  "<b style='color:#F40408'>Anulado</b>";
		
      }else{
	  	$TotalVent  +=  $row['monto'];
	  	$ganancia   +=  $row['ganancia2'];
		$costo 		+=  $row['totalpagar'];
		$mensaje 	=   "<b style='color:#0A22F2'>Vendido</b>";
		?>
         <a href="javascript:void(0)" onclick=" CargarAjax_win('Admin/Sist.Administrador/Revisiones/Imprimir/Accion/poliza.php?id_trans=<?=$row['id']?>','','GET','cargaajax'); " data-title="Visualizar"  class="btn btn-danger">
             <i class="fa fa-eye fa-lg"></i> 
            </a>
    <?    
	  }
	  echo $mensaje;
	  $TotalVentas = $TotalAnul + $TotalVent;
	  $Tganancia = $ganancia - $TganAnul;
	?>
    
     
            </td>
</tr>
  <? } ?>
   <? if($TotalVentas>0){?>  
    <tr>
    	<td rowspan="6" colspan="6">Total de transacciones<br><b><?=$p?></b></td>
        <td align="right"><b>Total Venta</b></td>
        <td><b><?=formatDinero($TotalVentas)?></b></td>
      </tr>
  <? } ?>
  
  <? if($TotalAnul>0){?>
     <tr>
        <td align="right"><b>Total Anulado</b></td>
        <td><b><?=formatDinero($TotalAnul)?></b></td>
      </tr>
  <? } ?>
  
  <? if($TotalVent>0){?>
     <tr>
        <td align="right"><b>Ventas Neta</b></td>
        <td><b><?=formatDinero($TotalVent)?></b></td>
      </tr>
  <? } ?>
  
  <? if($Tganancia>0){?>
    <tr>
        <td align="right"><b>Total Ganancia</b></td>
        <td><b><?=formatDinero($Tganancia)?></b></td>
      </tr>
  <? } ?>
    </tbody>
</table>
 </div>
                            <!-- /.table-responsive -->
                        </div>
                 <? } ?>       
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>