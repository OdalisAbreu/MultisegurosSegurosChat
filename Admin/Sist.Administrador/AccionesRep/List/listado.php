<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../../../incluidos/bd_manejos.php');
	include('../../../../incluidos/nombres.func.php');

	// DETERMINAR SI ES GET O POST
	//$actual = $_POST['actual'].$_GET['actual'];
	 $acc1 = $_POST['accion'].$_GET['action'];
	// DESACTIVAR
	if($_GET['action']=='desactivar'){
		$query=mysql_query("UPDATE acciones_rep SET activo ='no' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	if($_GET['action']=='activar'){
		$query=mysql_query("UPDATE acciones_rep SET activo ='si' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}


	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		//unset($_POST['actual']);
		Insert_form('acciones_rep');
		echo mysql_error();
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){
		//unset($_POST['actual']);
		EditarForm('acciones_rep');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	//echo $_SESSION['user_id'];
	
	
	if($_GET['idsupli']){
		$user_id = $_GET['idsupli'];
	}else{
		$user_id = $_SESSION['user_id'];
	}
	
?>

<div class="row" >
                <div class="col-lg-10" style="margin-top:-35px;">
                    <h3 class="page-header">Listados de Generaci&oacute;n de documentos </h3>
                </div>
                <div class="col-lg-2" style=" margin-top:10px;">
            <a onClick="CargarAjax2('Admin/Sist.Administrador/AccionesRep/List/listado.php','','GET','cargaajax');" class="btn btn-info"><i class="fa fa-list fa-lg"></i></a>
            
            <a onClick="CargarAjax_win('Admin/Sist.Administrador/AccionesRep/Edit/editar-registar.php?accion=registrar&user_id=<?=$user_id?>','','GET','cargaajax');" class="btn btn-primary"> <i class="fa fa-plus fa-lg"></i></a>
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
                            <th>Actualizado</th>
                            <th>Nombre</th>
                            <th>Excel</th>
                            <th>Pdf</th>
                            <th>Txt</th>
                            <th>Estado</th>
                            <th style="width:172px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
 $query=mysql_query("SELECT * FROM acciones_rep
 WHERE user_id ='".$user_id."' order by id ASC");
  while($row=mysql_fetch_array($query)){ 

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=FechaList($row['fecha_reg'])?></td>
    <td><?=FechaList($row['fecha_up'])?></td>
    <td><?=NombreSeguroS($row['aseg_id'])?></td>
    <td><?=$row['excel']?></td>
    <td><?=$row['pdf']?></td>
    <td><?=$row['txt']?></td> 
    <td>
	<? if ($row['activo']=='si'){ 
		echo "<font color='#1D0CD6'><b>Activo</b></font>";
	   }else{
		echo "<font color='#F6060A'><b>Inactivo</b></font>";
	   }
	?>
    </td>
    <td>
    
    
      
      
      <!--editar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/AccionesRep/Edit/editar-registar.php?id=<? echo $row['id']; ?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg"></i> 
            </a>
    <!--editar -->
        
    <?
    if ($row['activo']=='si'){ ?>
		 <!--desactivar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/AccionesRep/List/listado.php?action=desactivar&id=<?=$row['id']; ?>','','GET','cargaajax'); }" data-title="Desactivar"  class="btn btn-danger">
             <i class="fa fa-trash-o fa-lg"></i> 
            </a>
    <!--desactivar -->
    
	<?   }else{ ?>
		
         <!--activar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/AccionesRep/List/listado.php?action=activar&id=<?=$row['id']; ?>','','GET','cargaajax'); }"  data-title="Activar"  class="btn btn-primary">
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