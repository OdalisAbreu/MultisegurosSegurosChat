<?
	session_start();
	ini_set('display_errors',1);
	
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	
	// --------------------------------------------	
	if($_GET['cedula']){
		$cedula = $_GET['cedula'];
	}else{
		$cedula = "";
	}
	
	
	
	


?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Verificar poliza personal </h3>
    </div>
</div>

		
    
    
    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
    <div class="filter-bar">
  
<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
  <tr>
    <td>
     <label>Tipo:</label>
    <select name="tipo" id="tipo"  class="form-control" style="width:13%; display:inline">
    	<option value="nombre" <? if($_GET['tipo'] == 'nombre'){?> selected <? } ?>>Nombre</option>
        <option value="cedula" <? if($_GET['tipo'] == 'cedula'){?> selected <? } ?>>Cedula</option>
        <option value="chassis" <? if($_GET['tipo'] == 'chassis'){?> selected <? } ?>>Chassis</option>
        <option value="matricula" <? if($_GET['tipo'] == 'matricula'){?> selected <? } ?>>Matricula</option> 
    </select>
    
    <label>Info:</label>
    <input type="text" name="info" id="info" class="input-mini" value="<?=$_GET['info']?>" style="width: 135px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
    
    <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
    Actualizar   
    </button>
   
    </td>
  </tr>
</table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var tipo 	= $('#tipo').val();	
	var info 	= $('#info').val();
	
	CargarAjax2('Admin/Sist.Administrador/Revisiones/Poliza/VerificarPolizaPersonal.php?info='+info+'&tipo='+tipo+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
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
                            <th>Vigencia</th>
                            <th>Vehiculo</th>
                            <th>Estado</th>
                            <th>&nbsp;</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  
if($_GET['consul']=='1'){
	
$tipo = $_GET['tipo'];
$info = $_GET['info'];
 
	
if($tipo == 'cedula'){
	
	$rs2 = mysql_query("SELECT * FROM seguro_clientes WHERE asegurado_cedula = '".$info."' ");
	while($numU = mysql_fetch_array($rs2)){
		$ced .= $numU['id'].",";
	}

	$ced =  substr($ced, 0, -1);

	if($ced > 0){
		$consult = "id_cliente IN ($ced)";
	}
}

if($tipo == 'nombre'){

	$rs2 = mysql_query("SELECT * FROM seguro_clientes WHERE asegurado_nombres = '".$info."' ");
	while($numU = mysql_fetch_array($rs2)){
		$ced .= $numU['id'].",";
	}

	$ced =  substr($ced, 0, -1);

	if($ced > 0){
		$consult = "id_cliente IN ($ced)";
	}
}

if($tipo == 'chassis'){
	
	$rs2 = mysql_query("SELECT * FROM seguro_vehiculo WHERE veh_chassis = '".$info."' ");
	while($numU = mysql_fetch_array($rs2)){
		$ced .= $numU['id'].",";
	}

	$ced =  substr($ced, 0, -1);

	if($ced > 0){
		$consult = "id_vehiculo IN ($ced)";
	}
}

if($tipo == 'matricula'){

	$rs2 = mysql_query("SELECT * FROM seguro_vehiculo WHERE veh_matricula = '".$info."' ");
	while($numU = mysql_fetch_array($rs2)){
		$ced .= $numU['id'].",";
	}

	$ced =  substr($ced, 0, -1);

	if($ced > 0){
		$consult = "id_vehiculo IN ($ced)";
	}
}

	
$rs2 = mysql_query("SELECT * FROM seguro_transacciones WHERE $consult ");
while($row = mysql_fetch_array($rs2)){

$p++;
	  
	  if((substr_count($reversadas,"[".$row['id']."]")>0)){
		 $mensaje =  "<b style='color:#F40408'>Anulado</b>";
	  }else{
		$mensaje =  "<b style='color:#0A22F2'>Vendido</b>";
	  }
	  
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
    <td><?=$Client?><br><?=Cedula($row['id_cliente'])?></td>
    <td><?=Vigencia($row['vigencia_poliza'])?></td>
    <td><?=Vehiculo($row['id_vehiculo'])?></td>
    
    <td>
    <?
		echo $mensaje;
		echo "<br>C: ".FormatDinero($row['totalpagar']);
		echo "<br>M: ".FormatDinero($row['monto']);
	?>
    
    </td>
    
    <td> <a href="javascript:void(0)" onclick=" CargarAjax_win('Admin/Sist.Administrador/Revisiones/Imprimir/Accion/poliza.php?id_trans=<?=$row['id']?>','','GET','cargaajax'); " data-title="Visualizar"  class="btn btn-danger">
             <i class="fa fa-eye fa-lg"></i> 
            </a></td>
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