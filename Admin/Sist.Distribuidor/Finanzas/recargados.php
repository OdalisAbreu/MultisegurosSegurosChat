<?
	//ini_set('session.cache_expire','3000');
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
    <div class="col-lg-12">
        <h3 class="page-header">Listados de saldos recargados / retirados / Creditos / Ingresos</h3>
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
                        
                        <label class="control-label">Tipo</label>
                            
                            <select name="tipo" id="tipo" style="display: inline; width: 140px;" class="form-control">
                        <option value="99">- Todos - </option>
                        <option value="1"  <? if($_GET['tipo']=='1'){?>selected<? } ?>>Contado</option>
                        <option value="2"  <? if($_GET['tipo']=='2'){?>selected<? } ?>>Credito</option> 
                        <option value="3"  <? if($_GET['tipo']=='3'){?>selected<? } ?>>Retiro</option> 
                        <option value="4"  <? if($_GET['tipo']=='4'){?>selected<? } ?>>Ingresos</option> 
                        <option value="5"  <? if($_GET['tipo']=='5'){?>selected<? } ?>>Nota de Credito</option>
                        </select>
                        
                        <button name="bt_buscar" type="button" id="bt_buscarrec" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar
                        </button>
                        </td>
                       
                      </tr>
                
               </table>
									
				
 <script type="text/javascript">
	$('#bt_buscarrec').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();
	var tipo 	= $('#tipo').val();
	
	CargarAjax2('Admin/Sist.Distribuidor/Finanzas/recargados.php?fecha1='+fecha1+'&fecha2='+fecha2+'&tipo='+tipo+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscarrec').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 
	
		  // CODIGO PARA SACAR CALENDARIO
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
                            <th>Banco</th>
                            <th>Monto</th>
                            <th>Balance Actual</th>
                            <th></th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	if($_GET['tipo'] !=='99'){
		
		if($_GET['tipo']=='1')
		$t = "Contado";
		
		if($_GET['tipo']=='2')
		$t = "Credito";
		
		if($_GET['tipo']=='3')
		$t = "Retiro";
		
		if($_GET['tipo']=='4')
		$t = "Ingreso";
		
		if($_GET['tipo']=='5')
		$t = "NC";
			
		
		$tipo = "AND tipo ='".$t."' ";
	}
	
$query=mysql_query("
	SELECT id,fecha,id_pers,balance_anterior,balance_despues,monto,autorizada_por, tipo 
       FROM recarga_retiro
        WHERE id_pers ='".$_SESSION['user_id']."' $wFecha $tipo
	  ORDER BY fecha DESC
		");
  
  while($row=mysql_fetch_array($query)){
	  
	  if($row['tipo']=='Deposito'){
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
	  
	  if($row['tipo']=='NC'){
	  	$TNC += $row['monto']; 
		$concepto = "<font color='#058300'>Nota de Credito</font>"; 
	  }
	  
	  $Tnet = $TDep + $TCred + $TNC;
	  
?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['fecha']?></td>
    <td><?=$concepto?></td>
    <td>
	<? if($row['tipo']=='Deposito' || $row['tipo']=='Ingreso'){?>
		<?=NombreBanco($row['banco'])?>
     <? } ?>   
     </td>
    <td>$<?=FormatDinero($row['monto'])?></td>
    <td>$<?=FormatDinero($row['balance_despues'])?></td>
    <td><a href="javascript:void(0)" onclick=" CargarAjax_win('Admin/Sist.Distribuidor/Finanzas/Detalle.php?id=<?=$row['id']?>','','GET','cargaajax'); " data-title="Visualizar detalle"  class="btn btn-danger" title="Visualizar detalle">
             <i class="fa fa-eye fa-lg"></i> 
            </a></td>
    
</tr>
  <? } ?>
  <? if($TDep>0){?> 
  <tr>
  	<td colspan="3"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Contado:</strong></td>
    <td><strong>$<?=FormatDinero($TDep)?></strong></td>
  </tr> 
  <? } ?>
 <? if($TRet>0){?>  
   <tr>
  	<td colspan="3"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Retirado:</strong></td>
    <td><strong>$<?=FormatDinero($TRet)?></strong></td>
  </tr> 
  <? } ?>
   <? if($TCred>0){?>  
   <tr>
  	<td colspan="3"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Credito:</strong></td>
    <td><strong>$<?=FormatDinero($TCred)?></strong></td>
  </tr> 
  <? } ?>
   <? if($TIng>0){?>  
   <tr>
  	<td colspan="3"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Ingreso:</strong></td>
    <td><strong>$<?=FormatDinero($TIng)?></strong></td>
  </tr> 
  <? } ?>
  
  <tr>
  	<td colspan="3"></td>
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