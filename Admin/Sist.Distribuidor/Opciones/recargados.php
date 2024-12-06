<?
	ini_set('session.cache_expire','3000');
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
	//echo $_SESSION['user_id'];
	
	
?>

<div class="row" >
    <div class="col-lg-12">
        <h3 class="page-header">Listados de saldos recargados <?="a ".ClientePers($_GET['id'])?></h3>
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
                        <input type="text" name="fecha1" id="fecha1" class="input-mini hasDatepicker" value="<?=$fecha1?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <label style="margin-left:5px;">Hasta:</label>
                        <input type="text" name="fecha2" id="fecha2" class="input-mini hasDatepicker" value="<?=$fecha2?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
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

	
	CargarAjax2('Admin/Sist.Distribuidor/Opciones/recargados.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1&id=<?=$_GET['id']?>','','GET','cargaajax');
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
       <?  if($_GET['consul']=='1'){ ?>        
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Balance Anterior</th>
                            <th>Monto</th>
                            <th>Balance Actual</th>
                            
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	 $wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:59:59'";
	
	if($_GET['id']){
		$id_pers = "AND id_pers='".$_GET['id']."' ";
	}
	
	
$query=mysql_query("
	SELECT id,fecha,id_pers,balance_anterior,balance_despues,monto,autorizada_por,tipo 
       FROM recarga_retiro
        WHERE autorizada_por ='".$_SESSION['user_id']."' $id_pers $wFecha
	  ORDER BY fecha DESC
		");
   
 
  while($row=mysql_fetch_array($query)){
	  
	  if($row['tipo']=='Contado'){
	  	$TDep += $row['monto']; 
		$concepto = "<font color='#1327C8'>Contado</font>"; 
	  }
	  
	  if($row['tipo']=='Retiro'){
	  	$TRet += $row['monto']; 
		$concepto = "<font color='#FF0000'>Retiro</font>"; 
	  }
	  
	  if($row['tipo']=='Credito'){
	  	$TCred += $row['monto']; 
		$concepto = "<font color='#000000'>Credito</font>"; 
	  }
	  
	  if($row['tipo']=='Ingreso'){
	  	$TIng += $row['monto']; 
		$concepto = "<font color='#24A01A'>Ingreso</font>"; 
	  }
	  
	  $Tnet = $TDep + $TCred;
	  
?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['fecha']?></td>
    <td><?=$concepto?></td>
    <td>$<?=FormatDinero($row['balance_anterior'])?></td>
    <td>$<?=FormatDinero($row['monto'])?></td>
    <td>$<?=FormatDinero($row['balance_despues'])?></td>
    
    
</tr>
  <? } ?>
  <? if($TDep>0){?> 
  <tr>
  	<td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Contado:</strong></td>
    <td><strong>$<?=FormatDinero($TDep)?></strong></td>
  </tr> 
  <? } ?>
 <? if($TRet>0){?>  
   <tr>
  	<td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Retirado:</strong></td>
    <td><strong>$<?=FormatDinero($TRet)?></strong></td>
  </tr> 
  <? } ?>
   <? if($TCred>0){?>  
   <tr>
  	<td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Credito:</strong></td>
    <td><strong>$<?=FormatDinero($TCred)?></strong></td>
  </tr> 
  <? } ?>
   <? if($TIng>0){?>  
   <tr>
  	<td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Ingreso:</strong></td>
    <td><strong>$<?=FormatDinero($TIng)?></strong></td>
  </tr> 
  <? } ?>
  
  <tr>
  	<td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Neto:</strong></td>
    <td><strong>$<?=FormatDinero($Tnet)?></strong></td>
  </tr>
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