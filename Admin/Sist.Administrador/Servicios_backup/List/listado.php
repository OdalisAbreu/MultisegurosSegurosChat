<?
	session_start();
	ini_set('display_errors',1);
	$equip = $_POST['equipamientos'];

	include("../../../../incluidos/conexion_inc.php");
	include('../../../../incluidos/bd_manejos.php');
	include('../../../../incluidos/nombres.func.php');
	Conectarse();
	
	$_POST['equipamientos'] = $equip;
	 $acc1 = $_POST['accion'].$_GET['action'];
	
	//print_r($_POST);
	// DESACTIVAR
	if($_GET['action']=='desactivar'){
		$query=mysql_query("UPDATE servicios_backup SET activo ='no' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	// ACTIVAR
	if($_GET['action']=='activar'){
		$query=mysql_query("UPDATE servicios_backup SET activo ='si' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}

	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		for($i =0; $i<count($_POST['equipamientos']); $i++){
			if($_POST['equipamientos']>1){
				$_POST['equipamiento'] .= "".$_POST['equipamientos'][$i].",";
			}
		}
		
		if(count($_POST['equipamientos'])=='0'){
			 	$_POST['equipamiento'] ='99999999';
		}
		
		
		//echo $_POST['equipamiento'];
		$idtarif = substr($_POST['equipamiento'], 0, -1);
		
		$query=mysql_query("UPDATE seguro_tarifas_backup SET id_serv =CONCAT(id_serv,'".$_POST['id']."-') WHERE id IN (".$idtarif.")  AND id_serv NOT LIKE '%".$_POST['id']."-%'");
		
		//echo "UPDATE seguro_tarifas SET id_serv =CONCAT(id_serv,'-".$_POST['id']."-') WHERE id IN (".$idtarif.")  AND id_serv NOT LIKE '%-".$_POST['id']."-%'<br>";
		
		
		
		$query=mysql_query("UPDATE seguro_tarifas_backup SET id_serv = REPLACE(id_serv,'".$_POST['id']."-','') WHERE id NOT IN (".$idtarif.")  AND id_serv LIKE '%".$_POST['id']."-%'");
		
		//echo "UPDATE seguro_tarifas SET id_serv = REPLACE(id_serv,'-".$_POST['id']."-',' ') WHERE id NOT IN (".$idtarif.")  AND id_serv LIKE '%-".$_POST['id']."-%'";
		
		
//$query=mysql_query("UPDATE seguro_tarifas SET id_serv ='' WHERE id !=''");
		unset($_POST['equipamientos']);
		unset($_POST['equipamiento']);
		
		Insert_form('servicios_backup');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){

		for($i =0; $i<count($_POST['equipamientos']); $i++){
			if($_POST['equipamientos']>1){
				$_POST['equipamiento'] .= "".$_POST['equipamientos'][$i].",";
			}
		}
		
		if(count($_POST['equipamientos'])=='0'){
			 	$_POST['equipamiento'] ='99999999';
		}
		
		
		//echo $_POST['equipamiento'];
		$idtarif = substr($_POST['equipamiento'], 0, -1);
		
		$query=mysql_query("UPDATE seguro_tarifas_backup SET id_serv =CONCAT(id_serv,'".$_POST['id']."-') WHERE id IN (".$idtarif.")  AND id_serv NOT LIKE '%".$_POST['id']."-%'");
		
		/*echo "UPDATE seguro_tarifas_backup SET id_serv =CONCAT(id_serv,'-".$_POST['id']."-') WHERE id IN (".$idtarif.")  AND id_serv NOT LIKE '%-".$_POST['id']."-%'<br>";*/
		
		
		
		$query=mysql_query("UPDATE seguro_tarifas_backup SET id_serv = REPLACE(id_serv,'".$_POST['id']."-','') WHERE id NOT IN (".$idtarif.")  AND id_serv LIKE '%".$_POST['id']."-%'");
		
		/*echo "UPDATE seguro_tarifas_backup SET id_serv = REPLACE(id_serv,'-".$_POST['id']."-',' ') WHERE id NOT IN (".$idtarif.")  AND id_serv LIKE '%-".$_POST['id']."-%'";*/
		
		
//$query=mysql_query("UPDATE seguro_tarifas SET id_serv ='' WHERE id !=''");
		unset($_POST['equipamientos']);
		unset($_POST['equipamiento']);
		
		EditarForm('servicios_backup');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
			
	}
	
	 
	
	
?>


<div class="row" >
                <div class="col-lg-10" style="margin-top:-35px;">
                    <h3 class="page-header">Listados de Servicios adicionales BACKUP</h3>
                </div>
                
            <div class="col-lg-2" style=" margin-top:10px;">
            <a onClick="CargarAjax2('Admin/Sist.Administrador/Servicios_backup/List/listado.php','','GET','cargaajax');" class="btn btn-info">
             <i class="fa fa-list fa-lg"></i></a>
            <a  onClick="CargarAjax_win('Admin/Sist.Administrador/Servicios_backup/Edit/editar-registar.php?accion=registrar','','GET','cargaajax');"  class="btn btn-primary">
             <i class="fa fa-plus fa-lg"></i>
             </a> 
             
            </div>
                <!-- /.col-lg-12 -->
            </div>

    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
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
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>3 Meses</th>
                            <th>6 Meses</th>
                            <th>12 Meses</th>
                            <th>Estado</th>
                            <th style="width:172px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	
	
 $query=mysql_query("SELECT * FROM servicios_backup WHERE id_dist ='".$_SESSION['user_id']."' order by id ASC");
  while($row=mysql_fetch_array($query)){ 

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=FechaList($row['fecha'])?></td>
    <td><font style="font-size:14px; color:#0206A2; font-weight:bold"><?=$row['nombre']?></font><br>
    <?=NombreProgS($row['id_suplid'])?></td>
    <td>$<?=FormatDinero($row['3meses'])?></td>
    <td>$<?=FormatDinero($row['6meses'])?></td>
    <td>$<?=FormatDinero($row['12meses'])?></td>
    <td>
	<? if ($row['activo']=='si'){ 
		echo "<font color='#1D0CD6'><b>".$row['activo']."</b></font>";
	   }else{
		echo "<font color='#F6060A'><b>".$row['activo']."</b></font>";
	   }
	?>
    </td>

    <td>
    
      <!--editar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Servicios_backup/Edit/editar-registar.php?id=<?=$row['id']; ?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg"></i> 

            </a>
    <!--editar -->
    
    <?
    if ($row['activo']=='si'){ ?>
	
		 <!--desactivar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Servicios_backup/List/listado.php?action=desactivar&id=<?=$row['id']; ?>','','GET','cargaajax'); }" data-title="Desactivar"  class="btn btn-danger">
            
             <i class="fa fa-trash-o fa-lg"></i> 
            </a>
    <!--desactivar -->
    
	<?   }else{ ?>
		
         <!--activar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Servicios_backup/List/listado.php?action=activar&id=<?=$row['id']; ?>','','GET','cargaajax'); }"  data-title="Activar"  class="btn btn-primary">
            
          <i class="fa fa-power-off fa-lg"></i> 
            </a>
    <!--activar -->
    
	<?   } ?>
      
      
    </td>
  </tr>
  <? } ?>
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
            
            <style>
.modal-footer {
    border-top: 0px solid #ffffff;
}
</style>