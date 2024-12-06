<?
	session_start();
	ini_set('display_errors',1);
	 
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
	include("../../../incluidos/fechas.func.php");
	include("../../../incluidos/nombres.func.php"); 
	
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
<br>
<div class="row" >
    <div class="col-lg-12">
        <h3 class="page-header" style="margin-top: 5px;">Listados de saldos recargados / retirados / creditos / ingresos </h3>
    </div>
    <? if($_GET['id']){?>
    <div class="col-lg-12">
        <h3 class="page-header" style="margin-top: 5px; text-align:center !important"><?=ClientePers($_GET['id'])?></h3>
    </div>
    <? } ?>
</div>

		
    
    
    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
        <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                    	<td>
                        
                        <label>Desde:</label>
                        <input type="text" name="fecha1" id="fecha1" class="input-mini " value="<?=$fecha1?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        
                        <label style="margin-left:5px;">Hasta:</label>
                        <input type="text" name="fecha2" id="fecha2" class="input-mini " value="<?=$fecha2?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        
                        <label class="control-label">Tipo</label>
								  
                                        
                            
                            <select name="tipo" id="tipo" style="display: inline; width: 140px;" class="form-control">
                        <option value="99">- Todos - </option>
                        <option value="1"  <? if($_GET['tipo']=='1'){?>selected<? } ?>>Contado</option>
                        <option value="2"  <? if($_GET['tipo']=='2'){?>selected<? } ?>>Credito</option> 
                        <option value="3"  <? if($_GET['tipo']=='3'){?>selected<? } ?>>Retiro</option> 
                        <option value="4"  <? if($_GET['tipo']=='4'){?>selected<? } ?>>Ingresos</option> 
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
	var tipo 	= $('#tipo').val();
	
	CargarAjax2('Admin/Sist.PersonalRecargas/Opciones/recargadosPers.php?fecha1='+fecha1+'&fecha2='+fecha2+'&tipo='+tipo+'&id=<?=$_GET['id'];?>','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 
	
	
		  // CODIGO PARA SACAR CALENDARIO
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
                            <th>Concepto</th>
                            <th>Banco</th>
                            <th>Monto</th>
                            <th>Credito Act.</th>
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
	
	if($_GET['tipo'] !=='99'){
		
		if($_GET['tipo']=='1')
			$t = "Contado";
		
		if($_GET['tipo']=='2')
		$t = "Credito";
		
		if($_GET['tipo']=='3')
		$t = "Retiro";
		
		if($_GET['tipo']=='4')
		$t = "Ingreso";
			
		
		$tipo = "AND tipo ='".$t."' ";
	}
	
$query=mysql_query("
	SELECT * FROM recarga_retiro
    WHERE rec_id ='".$_SESSION['user_id']."' $wFecha $id_pers $tipo
	ORDER BY id DESC
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
    <td>
	<? if($row['tipo']=='Contado' || $row['tipo']=='Ingreso'){?>
		<?=NombreBanco($row['banco'])?>
     <? } ?>   
     </td>
    <td>$<?=FormatDinero($row['monto'])?></td>
    <td>$<?=FormatDinero($row['cred_actual'])?></td> 
    
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
             <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>