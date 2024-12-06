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
		$_GET['id'] =LimpiarCampos($_GET['id']);
		$id=$_GET['id'];
		$query=mysql_query("UPDATE grupos SET activo ='' where id='$id'");
		
		Auditoria($_SESSION['user_id'],$id,'reactivando_grupo','Se reactivo este grupo.',$campus_id);
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script>';
	}
?>
<ul class="breadcrumb">
	<li>Tu estas Aqui</li>
	<li class="divider"></li>
	<li>Dependientes</li>
	<li class="divider"></li>
	<li>Grupo</li>
	<li class="divider"></li>
	<li>Deshabilitados</li>
</ul>
<h2>Grupo Deshabilitados</h2>
<? if($acc1=='eliminar'){?>
    <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este grupo se ha activado correctamente</span>
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
              <th>Acciones</th>
          </tr>
      </thead>
      <!-- // Table heading END -->
      <!-- Table body -->
      <tbody>  
	<? 
      $query=mysql_query("
      SELECT * FROM grupos WHERE nombres !='' AND activo ='no' AND id_dist ='".$_SESSION['user_id']."' order by nombres");
      while($row=mysql_fetch_array($query))
     {?>
  <!-- Table row -->
    <tr class="gradeX">
        <td><?  echo $row['id']; ?></td>
        <td style="text-transform:capitalize;"><? echo $row['nombres']; ?></td>
        <td>
        <a href="javascript:" onclick="if(confirm('Seguro que desea Habilitarlo\n&iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Grupos/List/deshabilitados.php?action=eliminar&id=<? echo $row['id']; ?>','','GET','cargaajax'); }" data-toggle="tooltip" data-title="Habilitar" data-placement="bottom" class="btn-action glyphicons refresh btn-success"><i></i></a>
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