<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../../../incluidos/bd_manejos.php');
	include("../../../../incluidos/fechas.func.php");
	
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

	//$actual = $_POST['actual'].$_GET['actual'];  
	 $acc1 = $_POST['accion'].$_GET['action'];
	 
	$consul = $_GET['consul'].$_POST['consul'];
		
	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		Insert_form('seguro_costos_backup');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){
		EditarForm('seguro_costos_backup');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Listados de Tarifas de costo de seguros BACKUP</h3>
    </div>
</div>




   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
        
        <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                    	<td>
        <label class="control-label">Aseguradora: </label>
            <select name="aseguradora" id="aseguradora" style="display: inline; width: 200px;" class="form-control">
                        <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT id, nombre from seguros order by nombre ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$nombre = $cat2['nombre'];
			$id 		= $cat2['id'];
            
			if($_GET['aseguradora'] == $id){
				echo "<option value=\"$id\"  selected>$nombre</option>";
			}else{
				echo "<option value=\"$id\" >$nombre</option>"; 
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
	var aseguradora 	= $('#aseguradora').val();
	
	CargarAjax2('Admin/Sist.Administrador/Tarifas_backup/List/Costolistado.php?aseguradora='+aseguradora+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 


	$('#bt_buscar').fadeIn(0); 
	$(function() {
		$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
		$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
	});
	  </script>

      
   
			</div>
            
            
                <div class="panel-heading">
                    Registros actualmente 
         </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>3 Meses</th>
                            <th>6 Meses</th>
                            <th>12 Meses</th>
                            <th style="width:172px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	if($consul=='1'){
	
 $query=mysql_query("SELECT * FROM seguro_costos_backup WHERE id_seg ='".$_GET['aseguradora']."' order by id ASC");
 //echo "SELECT * FROM seguro_costos_backup WHERE id_seg ='".$_GET['aseguradora']."' order by id ASC";
  while($row=mysql_fetch_array($query)){ 

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['nombre']?> [<?=$row['veh_tipo']?>]</td>
    <td>$<?=FormatDinero($row['3meses'])?></td>
    <td>$<?=FormatDinero($row['6meses'])?></td>
    <td>$<?=FormatDinero($row['12meses'])?></td>
    
    <td>
    
     <!--editar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Tarifas_backup/Edit/Costoeditar-registar.php?id=<?=$row['id']?>&aseg=<?=$_GET['aseguradora']?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg"></i>  
            </a>
    <!--editar --> 
    
     
  
    
      
      
    </td>
  </tr>
  <? } 
  
	}?>
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