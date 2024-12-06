<?
	ini_set('display_errors', 1);
	session_start();
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
	set_time_limit(0);
	include('../../../incluidos/bd_manejos.php');
	include('../../../incluidos/auditoria.func.php');
	
	
	

	
	

	$acc1 = $_POST['accion'].$_GET['action'];
	if($_GET['action']=='eliminar'){
		$_GET['id'] =limpiarCampos($_GET['id']);
		$id=$_GET['id'];
		$query=mysql_query("UPDATE grupos SET activo ='no' where id='$id'");
		// MARCAMOS PARA AUDITORIA
		Auditoria($_SESSION['user_id'],$id,'desact_grupo','Se desactivo este grupo.',$campus_id);
		// MARCAMOS PARA AUDITORIA
	
	echo '<script>
				$("#recargar").fadeOut(0);
				$("#recargar2").fadeOut(0);
				$("#modal-simple").modal("hide");
				$("#actul").fadeIn(0); $("#actul").fadeOut(10000);
				</script>';
	}

	// EDITAR
	if($_POST['accion']=='editar'){
		EditarForm('grupos');
		// MARCAMOS PARA AUDITORIA
		Auditoria($_SESSION['user_id'],$id=$_POST['id'],'edito_grupo','Se edito este grupo.',$campus_id);
		// MARCAMOS PARA AUDITORIA	
		
		echo'<script>
				$("#recargar").fadeOut(0);
				$("#recargar2").fadeOut(0);
				$("#modal-simple").modal("hide");
				$("#actul").fadeIn(0); $("#actul").fadeOut(10000);
				</script>';
		
	}
	
	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		Insert_form('grupos');
			
		// MARCAMOS PARA AUDITORIA
		Auditoria($_SESSION['user_id'],$id,'registro_grupo','Se registro este grupo.',$campus_id);
		// MARCAMOS PARA AUDITORIA
		
		echo'<script>
				$("#recargar").fadeOut(0);
				$("#recargar2").fadeOut(0);
				$("#modal-simple").modal("hide");
				$("#actul").fadeIn(0); $("#actul").fadeOut(10000);
				</script>';
		
		
		
	}
?>
<ul class="breadcrumb">
	<li>Tu estas Aqui</li>
	<li class="divider"></li>
	<li>Dependientes</li>
	<li class="divider"></li>
	<li>Grupos</li>
</ul>

<h2>Listados de grupos</h2>
			<? if($acc1=='eliminar'){?>
           <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este grupo se ha desabilitado correctamente</span>
             <? }else if($acc1=='editar'){?>
               <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este grupo se ha editado correctamente</span>
             <? }else if($acc1=='registrar'){?>
               <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este grupo se ha registrado correctamente</span>
             <? } ?>
	<!-- Widget -->
  <div class="innerLR">
	<div class="widget widget-heading-simple widget-body-gray">
		<div class="widget-body">
		
			<!-- Table -->
			<table class="dynamicTable tableTools table-hover table table-striped table-bordered table-primary table-white">
			
				<!-- Table heading -->
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre</th>
                        <th>Fecha</th>
                        <th>Fecha  Actualizaci&oacute;n</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<!-- // Table heading END -->
				
				<!-- Table body -->
				<tbody>
				<? 
  
 




	// ************************
  $query=mysql_query("select * from grupos WHERE id_dist = '".$_SESSION['user_id']."' AND nombres !=''  AND activo !='no' order by id DESC");
  while($row=mysql_fetch_array($query)) {?>
  
  <!-- Table row -->
  <tr class="gradeX">
      <td><?  echo $row['id']; ?></td>
      <td style="text-transform:capitalize;"><? echo $row['nombres']; ?></td>
      <td><? echo $row['fecha']; ?></td>
      <td><? echo $row['fecha_update']; ?></td>
      <td>
            <!--editar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Grupos/Edit/editar-registar.php?id=<? echo $row['id']; ?>','','GET');" data-toggle="tooltip" data-title="Editar" data-placement="bottom" class="btn-action glyphicons pencil btn-default"><i></i></a>
            <!--editar -->
            
            <!--eliminar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Grupos/List/listado.php?action=eliminar&id=<? echo $row['id']; ?>','','GET','cargaajax'); }" data-toggle="tooltip" data-title="Eliminar" data-placement="bottom" class="btn-action glyphicons remove_2 btn-default"><i></i></a>
            <!--eliminar -->
            
          
       
        </td>
    </tr>
					<? } ?>
				</tbody>
				<!-- // Table body END -->
			</table>
			<!-- // Table END -->
		</div>
	</div>
  </div>
		<!-- // Content END -->