<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include('../../../../incluidos/bd_manejos.php');
	

	// DETERMINAR SI ES GET O POST
	//$actual = $_POST['actual'].$_GET['actual'];
	 $acc1 = $_POST['accion'].$_GET['action'];
	
	// DESACTIVAR
	if($_GET['action']=='desactivar'){
		$query=mysql_query("UPDATE personal SET activo ='no' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	// ACTIVAR
	if($_GET['action']=='activar'){
		$query=mysql_query("UPDATE personal SET activo ='si' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}

	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		//unset($_POST['actual']);
		Insert_form('personal');
		//$id = mysql_insert_id();
		//$query=mysql_query("UPDATE personal SET user ='".$id."' WHERE id='$id' LIMIT 1");
		//echo mysql_error();
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){
		//unset($_POST['actual']);
		EditarForm('personal');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	//echo $_SESSION['user_id'];
?>

<div class="row" >
                <div class="col-lg-10" style="margin-top:-32px;">
                    <h3 class="page-header">Listados de Representante </h3>
                </div>
                <div class="col-lg-2" style=" margin-top:10px;">
            <a onClick="CargarAjax2('Admin/Sist.Distribuidor/Personal/List/listado.php','','GET','cargaajax');" class="btn btn-info"><i class="fa fa-list fa-lg"></i></a>
            
            <a onClick="CargarAjax_win('Admin/Sist.Distribuidor/Personal/Edit/editar-registar.php?accion=registrar','','GET','cargaajax');"  class="btn btn-primary"> <i class="fa fa-plus fa-lg"></i></a>
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
                            <th>nombre</th>
                            <th>Balance</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                            <th style="width:192px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	
	
 $query=mysql_query("SELECT * FROM personal WHERE id_dist ='".$_SESSION['user_id']."' AND funcion_id ='3' order by id ASC");
  while($row=mysql_fetch_array($query)){ 

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=FechaList($row['fecha'])?></td>
    <td><?=$row['nombres']?></td>
    <td>$<?=FormatDinero($row['balance'])?></td>
      <td>
	<? if ($row['activo']=='si'){ 
		echo "<font color='#1D0CD6'><b>Activo</b></font>";
	   }else{
		echo "<font color='#F6060A'><b>Inactivo</b></font>";
	   }
	?>
    </td>
    <td>
    <div class="input-append">
    <div class="btn-group dropdown">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Seleccionar <span class="caret"></span>
</button>
        <ul class="dropdown-menu pull-right">
            <li><a href="#" onclick="CargarAjax2('Admin/Sist.Distribuidor/Opciones/recargados.php?id=<? echo $row['id']; ?>','','GET','cargaajax');">Saldos Recargados</a></li>
            
            <li><a href="#">Resumen de ventas</a></li> 
        </ul>
  </div>
</div>
    </td>
    <td>
    
     <!--editar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Distribuidor/Personal/Edit/editar-registar.php?id=<? echo $row['id']; ?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg"></i> 
            </a>
    <!--editar -->
        
    <?
    if ($row['activo']=='si'){ ?>
		 <!--desactivar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Distribuidor/Personal/List/listado.php?action=desactivar&id=<?=$row['id']; ?>','','GET','cargaajax'); }" data-title="Desactivar"  class="btn btn-danger">
             <i class="fa fa-trash-o fa-lg" title="Desactivar"></i> 
            </a>
    <!--desactivar -->
    
	<?   }else{ ?>
		
         <!--activar -->
            <a href="javascript:Elim();" onclick="if(confirm('Activar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Distribuidor/Personal/List/listado.php?action=activar&id=<?=$row['id']; ?>','','GET','cargaajax'); }"  data-title="Activar"  class="btn btn-primary">
          <i class="fa fa-power-off fa-lg" title="Activar"></i> 
            </a>
    <!--activar -->
    
	<?   } ?>
      
     
     <!--recargar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Distribuidor/Opciones/Acciones/Recargar.php?id=<?=$row['id']; ?>','','GET','cargaajax'); " data-title="Recargar Cuenta"  class="btn btn-info">
             <i class="fa fa-usd fa-lg" title="Recargar Cuenta"></i> 
            </a>
    <!--recargar -->
    
      
       <!--retirar balance -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Distribuidor/Opciones/Acciones/RetirarBal.php?id=<?=$row['id']; ?>','','GET','cargaajax'); " data-title="Retirar Balance"  class="btn btn-info">
             <i class="fa fa-ban fa-lg" title="Retirar Efectivo"></i> 
            </a>
    <!--retirar balance --> 
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