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
    <div class="col-lg-10" style="margin-top:-35px;">
        <h3 class="page-header">Cuentas por Cobrar de <?=ClientePers($_GET['id'])?></h3>
    </div>

<div class="col-lg-2" style=" margin-top:10px;">
            <button name="acep" type="button" id="acep" class="btn btn-info" onClick="CargarAjax_win('Admin/Sist.Administrador/Opciones/Acciones/Abonar.php?id=<?=$_GET['id']?>','','GET','cargaajax');">Realizar Pago</button>
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

	
	CargarAjax2('Admin/Sist.Administrador/CxC/listado.php?consul=1&fecha1='+fecha1+'&fecha2='+fecha2+'&id=<?=$_GET['id'];?>','','GET','cargaajax');
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
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th style="font-size:12px">#</th>
                            <th style="font-size:12px">FECHA</th>
                            <th style="font-size:12px">REFERENCIA</th>
                            <th style="font-size:12px">CONCEPTO</th>
                            <th style="font-size:12px">DEBITOS</th>
                            <th style="font-size:12px">CREDITOS</th>
                            <th style="font-size:12px">BALANCE ACTUAL</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
 
if($_GET['consul']=='1'){
	  	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	 $wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:59:59'";
	
$query=mysql_query("
	
	
   
      SELECT * FROM credito
      WHERE id_pers ='".$_GET['id']."' AND realizada_por ='".$_SESSION['user_id']."'  $wFecha
	  ORDER BY fecha DESC
		
		");
    
  while($row=mysql_fetch_array($query)){
	  
	  if($row['tipo']=='Credito'){
	  		$totalCred += $row['monto'];
			$concepto = 'COMPRA A CREDITO'; 
	  }elseif($row['tipo']=='Abono'){
		    $totalAbon += $row['monto']; 
			$concepto = 'PAGO RECIBIDO'; 
	  }
	  $array = array("-", " ", ":");
	  $fecha = str_replace($array, "",$row['fecha']);
?>
<tr>
    <td><?=$row['id']?></td>
	<td><?=$row['fecha']?></td>
    <td><?=$fecha?></td>
    <td><?=$concepto?></td>
    <td><?
    if($row['tipo']=='Credito'){ echo "$ ".FormatDinero($row['monto']); }?></td>
    <td><?
    if($row['tipo']=='Abono'){ echo "$ ".FormatDinero($row['monto']); }?></td>
    <td><?="$ ".FormatDinero($row['cred_actual'])?></td>
    
</tr>
  <? } 
}
?>
  
  <!--<tr>
  	<td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>-->
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4"><strong>Total</strong>:</td>
    <td><strong>$ <?=FormatDinero($totalCred)?></strong></td>
    <td><strong>$ <?=FormatDinero($totalAbon)?></strong></td>
    <td></td>
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