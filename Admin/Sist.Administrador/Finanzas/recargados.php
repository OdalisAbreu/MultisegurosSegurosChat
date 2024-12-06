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
        <h3 class="page-header" style="margin-top: 5px;">Listados de saldos recargados / retirados</h3>
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
                        
                        
									<label class="control-label">Recargador</label>
								  
                                        
                            
                            <select name="rec_id" id="rec_id" style="display: inline; width: 140px;" class="form-control">
                        <option value="">- Todos - </option>
                        <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT id, nombres, funcion_id from personal WHERE funcion_id = '34' AND activo ='si' order by nombres ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$nombre = $cat2['nombres'];
			$id 		= $cat2['id'];
            
			if($_GET['rec_id'] == $id){
				echo "<option value=\"$id\"  selected>$nombre</option>";
			}else{
				echo "<option value=\"$id\" >$nombre</option>"; 
			}
			 
        } ?> 
                        </select>

                 
                 <label style="margin-left:5px;">ID:</label>
                        <input type="text" name="id" id="id" class="input-mini" value="<?=$_GET['id']?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        
                              
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
	var rec_id 	= $('#rec_id').val();
	var id 		= $('#id').val();
	
	CargarAjax2('Admin/Sist.Administrador/Finanzas/recargados.php?fecha1='+fecha1+'&fecha2='+fecha2+'&rec_id='+rec_id+'&id='+id+'','','GET','cargaajax');
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
                            <th>Cliente</th>
                            <th>Monto</th>
                           
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";
	
	
	if(!$_GET['rec_id']){
		 $rec_id = "";
	 }else{
		 $rec_id = "AND rec_id = '".$_GET['rec_id']."' ";
	 }
 
 if($_GET['id']){
		$id_pers = "AND id_pers ='".$_GET['id']."' ";
	}
 
$query=mysql_query("
	SELECT * FROM recarga_retiro
    WHERE autorizada_por ='".$_SESSION['user_id']."' $rec_id $wFecha $id_pers
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
	  	$Tpago += $row['monto']; 
		$concepto = "<font color='#24A01A'>Ingreso</font>"; 
	  }
	  
	  
	  if($row['tipo']=='NC'){
	  	$TNIng += $row['monto']; 
		$concepto = "<font color='#24A01A'>Nota de Credito</font>"; 
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
    <td>
		<?=ClientePers($row['id_pers'])?><br>
    	(<font style="font-size: 13px; color: #2196F3;"><?=ClientePers($row['rec_id'])?></font>)
    </td> 
    <td>$<?=FormatDinero($row['monto'])?></td>
    
    
</tr>
<? if($row['comentario'] !==''){?>
        <tr>
            <td colspan="8"><?=$row['comentario']?></td>
        </tr>
  <? }  }?> 
 
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
   <? if($Tpago>0){?>  
   <tr>
  	<td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Pago:</strong></td>
    <td><strong>$<?=FormatDinero($Tpago)?></strong></td>
  </tr> 
  <? } ?>
    <? if($TNIng>0){?>  
   <tr>
  	<td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total Nota de Credito:</strong></td>
    <td><strong>$<?=FormatDinero($TNIng)?></strong></td>
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