<?
//exit(); 
	set_time_limit(0);
	ini_set('display_errors',1);
	session_start();
	@include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	@include("../../../../incluidos/info.profesores.php");
	@include("../../../../incluidos/fechas.func.php");
	//@include('../../../../../incluidos/auditoria.func.php');
	
 
	// -------------------------------------------	
	if($_GET['dist_id']){ 
		//$_GET['dist_id'] = LimpiarCampos($_GET['dist_id']);
		$dist_id = $_GET['dist_id']; 
	}else{
		$dist_id = $_SESSION['user_id']; }
	
	// --------------------------------------------	
	if($_GET['fecha1']){
		//$_GET['fecha1'] = LimpiarCampos($_GET['fecha1']);
		$fecha1 = $_GET['fecha1'];
	}else{
		$fecha1 = fecha_despues(''.date('d/m/Y').'',-0);
	}
	//echo $fecha1;
	// --------------------------------------------
	if($_GET['fecha2']){
		//$_GET['fecha2'] = LimpiarCampos($_GET['fecha2']);
		$fecha2 = $_GET['fecha2'];
	}else{
		$fecha2 = fecha_despues(''.date('d/m/Y').'',0);
	}

	?>
<div class="row" >
    <div class="col-lg-10" style="margin-top:-30px;">
        <h3 class="page-header">Ventas por grupos </h3> 
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
                        
                        
                 
						<label>Grupo:</label>
						
						  
                          
                          
                          
                            <select name="id_grupo" id="id_grupo" class="input-mini" style="width: 145px; padding:10px;">
                                    
                                    <? 
                        $resprov3 = mysql_query("
                        SELECT id, nombres from grupos WHERE activo !='no' order by id DESC");
                            while ($prov = mysql_fetch_array($resprov3)) {
                                    $c 		= $prov['nombres'];
                                    $c_id 	= $prov['id'];
                                  
								  if($_GET['id_grupo']==$c_id){
									   echo "<option value=\"$c_id\" selected>$c</option>"; 
								  }else{
								    
                                    echo "<option value=\"$c_id\">$c</option>"; 
								  }

                                } ?>
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
	var id_grupo 	= $('#id_grupo').val();
	
	CargarAjax2('Admin/Sist.Administrador/Grupos/Reportes/ventas_por_grupos_V2.php?fecha1='+fecha1+'&fecha2='+fecha2+'&id_grupo='+id_grupo+'&dist_id=<?=$_SESSION['user_id']?>&consul=1','','GET','cargaajax');
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
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Ventas</th>
                            <th>Ganancias</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	
	  $wFecha = "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00'";
	
	// BUSCANDO grupo:
if($_GET['consul']=='1'){
	
	$qgrupo = mysql_query("SELECT id,id_pers FROM grupos
	WHERE id = ".$_GET['id_grupo']." ");
	$rgrupo=mysql_fetch_array($qgrupo);
		
 
  $query=mysql_query("select sum(monto) as monto,user_id,sum(ganancia) as ganancia from seguro_transacciones WHERE dist_id ='".$_SESSION['user_id']."'
  $wFecha  AND user_id IN (".$rgrupo['id_pers'].") 
  GROUP BY user_id
  order by user_id ASC "); 

  while($row=mysql_fetch_array($query)){

?>
<tr>
    <td><?=$row['user_id'];?></td>
    <td><?=ClientePers($row['user_id']);?></td>
    <td><span class="label label-warning">$<?
            print FormatDinero($row['monto']);
            $totalGral += $row['monto'];?></span>
     </td>
    <td><span class="label label-warning">$<?
    echo FormatDinero($row['ganancia']);
	$TotalGanc = $TotalGanc + $row['ganancia'];
	?></span></td>
</tr>
  <? }
  
}?>
   <tr>
    <td colspan="2" rowspan="2"></td> 
    <!-- <td></td>-->
    <td><strong>Total</strong></td>
    <td><strong><?="$".FormatDinero($total)?></strong></td>
</tr>
 <tr>
    <!--<td></td>-->
    <td><strong>Ganancia</strong></td>
    <td><strong><?="$".FormatDinero($ganancia)?></strong></td>
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