<? 
	session_start();
	ini_set('display_errors',1);
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	include("../../../../incluidos/fechas.func.php");
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
	
	if($_GET['user_id']){
		$user_id = $_GET['user_id'];	
		$user = "user_id = '".$_GET['user_id']."' AND ";
	}else{
		$user_id = "";	
	}
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Verificacion de Ventas Diarias </h3>
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
                        
            <label class="control-label">ID:</label>
           <input type="text" name="user_id" id="user_id" class="input-mini" value="<?=$user_id?>" style="width: 45px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
           
                        
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-primary" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
 
                        </td>
                      </tr>
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 		= $('#fecha1').val();
	var fecha2 		= $('#fecha2').val();
	
	CargarAjax2('Admin/Sist.Administrador/Revisiones/Ventas/VentDiarias.php?fecha1='+fecha1+'&fecha2='+fecha2+'&user_id=<?=$user_id?>&consul=1','','GET','cargaajax');
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
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>Ganacia</th>
                            <th>Diferencia</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
 
 if($_GET['consul']=='1'){
	  	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde		= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 		= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	
	$fDesde21 = $fHasta;
    $fecha21 = date_create(''.$fDesde21.'');
    date_add($fecha21, date_interval_create_from_date_string('1 days'));
    $fecha_desp1 = date_format($fecha21, 'Y-m-d');
	
	$Wfecha = "fecha >= '$fDesde' AND fecha <= '$fecha_desp1'";
	
	// BUSCANDO REVERSOS:
	$qRev = mysql_query("
	SELECT id_trans,monto FROM seguro_transacciones_reversos 
	WHERE fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'
	");
	$reversadas .= "0";
	while($rev=mysql_fetch_array($qRev)){
		$reversadas 	.= ",".$rev['id_trans'];
	}
	
	
	// --------------------- Index ID ------------------------ //
	$qIndex = mysql_query("SELECT id_inicio FROM index_transacciones WHERE fecha ='".$fDesde."' AND tipo = 'trans' ");
 	$Index	= mysql_fetch_array($qIndex);
	  if($Index['id_inicio']){
	     $wIndexId = "(id >= ".$Index['id_inicio'].") AND ";
	   }
	// -------------------------------------------------------
	
  $query = mysql_query("
	SELECT SUM(monto) AS total, SUM(ganancia) AS gantotal, fecha FROM seguro_transacciones WHERE $wIndexId $Wfecha AND id NOT IN($reversadas) GROUP BY date(fecha)
  ");
  
  echo "SELECT SUM(monto) AS total, SUM(ganancia) AS gantotal, fecha FROM seguro_transacciones WHERE $wIndexId $Wfecha AND id NOT IN($reversadas) GROUP BY date(fecha)";
  while($row = mysql_fetch_array($query)){
	  
		$Mtotal += $row['total'];
		$Mganacia += $row['gantotal'];
	
	 $cco++; 
		if(($cco%2)==0){ 
			$color = '#FFFFFF'; 
		}else{ 
			$color = '#F3F3F3'; 
		}
	  

?>

    <td align="left"><b><?=$row['id']?></b></td>
    <td align="left"><b><?=$row['fecha']?></b></td>
    <td align="left"><b><?=$row['user_id']?></b></td>
    <td align="left"><b><?=$row['total']?></b></td>
    <td align="left"><?=$row['gantotal']?></td>
    <td align="left">0.00</td>
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