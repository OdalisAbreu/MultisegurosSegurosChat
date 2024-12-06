<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../../../incluidos/bd_manejos.php');
	include("../../../../incluidos/nombres.func.php");
	

	// DETERMINAR SI ES GET O POST
	//$actual = $_POST['actual'].$_GET['actual'];
	 $acc1 = $_POST['accion'].$_GET['action'];
	// DESACTIVAR
	if($_GET['action']=='eliminar'){
		//unset($_POST['actual']);
		$id=$_GET['id'];
		$query=mysql_query("UPDATE grupos SET activo ='no' WHERE id='$id'");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}

	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		//unset($_POST['actual']);
		Insert_form('grupos');
		echo mysql_error();
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){
		//unset($_POST['actual']);
		EditarForm('grupos');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	//echo $_SESSION['user_id'];
?>

<div class="row" >
                <div class="col-lg-10" style="margin-top:-35px;">
                    <h3 class="page-header">Listados de Grupos </h3>
                </div>
                <div class="col-lg-1" style=" margin-top:10px;">
            <button name="acep" type="button" id="acep" class="btn btn-info" onClick="CargarAjax2('Admin/Sist.Administrador/Grupos/List/listado.php','','GET','cargaajax');">Listado</button>
            </div>
            <div class="col-lg-1" style=" margin-top:10px;">
            <button name="acep" type="button" id="acep" class="btn btn-primary" onClick="CargarAjax_win('Admin/Sist.Administrador/Grupos/Edit/editar-registar.php?accion=registrar','','GET','cargaajax');">Agregar</button>
            </div>
                <!-- /.col-lg-12 -->
            </div>


			<? if($acc1=='eliminar'){?>
           <span class="alert alert-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este grupo se ha desabilitado correctamente</span>
             <? }else if($acc1=='Editar'){?>
               <span class="alert alert-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este grupo se ha editado correctamente</span>
             <? }else if($acc1=='registrar'){?>
               <span class="alert alert-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este grupo se ha registrado correctamente</span>
             <? } ?>
	
    
    
    
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
                            <th>Actualizado</th>
                            <th>nombre</th>
                            <th style="width:172px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	
	
 $query=mysql_query("SELECT * FROM grupos WHERE activo != 'no' AND id_dist ='".$_SESSION['user_id']."' order by id ASC");
  while($row=mysql_fetch_array($query)){ 

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=FechaList($row['fecha'])?></td>
    <td><?=FechaList($row['fecha_update'])?></td>
    <td><?=$row['nombres']?></td>
    <td>
    
     <!--editar usuario-->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Grupos/Edit/editar-registar.php?id=<? echo $row['id']; ?>','','GET','cargaajax');" data-toggle="tooltip" data-title="Editar" data-placement="bottom" >
            <span class="fa-stack fa-lg" style="float:left;">
  <i class="fa fa-square-o fa-stack-2x"></i>
  <i class="fa fa-pencil fa-stack-1x"></i>
</span>
            </a>
    <!--editar usuario-->
    
    <!--eliminar usuario-->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?action=eliminar&id=<? echo $row['id']; ?>','','GET','cargaajax'); }" data-toggle="tooltip" data-title="Deshabilitar" data-placement="bottom">
            
            <span class="fa-stack fa-lg" style="float:left;">
  <i class="fa fa-square-o fa-stack-2x"></i>
  <i class="fa fa-trash-o fa-stack-1x"></i>
</span>
            </a>
    <!--eliminar usuario-->
      
      
      
    
    
      
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