<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../../../../incluidos/bd_manejos.php');
	include('../../../../../incluidos/nombres.func.php');

	// DETERMINAR SI ES GET O POST
	 $acc1 = $_POST['accion'].$_GET['action'];
	
		// DESACTIVAR
	if($_GET['action']=='desactivar'){
		$query=mysql_query("UPDATE seguro_costos SET activo ='no' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	// ACTIVAR
	if($_GET['action']=='activar'){
		$query=mysql_query("UPDATE seguro_costos SET activo ='si' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		Insert_form('seguro_costos');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){
		EditarForm('seguro_costos');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
?>

<div class="row" >
                <div class="col-lg-12" style="margin-top:-35px;">
                    <h3 class="page-header">Listados de Costos de:  <a onClick="CargarAjax2('Admin/Sist.Administrador/Seguros/Costos/List/listado.php?costo_id=<?=$_GET['costo_id']; ?>','','GET','cargaajax');" ><?=NombreSeguroS($_GET['costo_id'])?></a></h3>
                </div>
            
           <!-- <div class="col-lg-2" style=" margin-top:10px;">
            <a onClick="CargarAjax2('Admin/Sist.Administrador/Seguros/Costos/List/listado.php?costo_id=<?=$_GET['costo_id']?>','','GET','cargaajax');" class="btn btn-info">
             <i class="fa fa-list fa-lg"></i></a>
            <a  onClick="CargarAjax_win('Admin/Sist.Administrador/Seguros/Costos/Edit/editar-registar.php?accion=registrar&costo_id=<?=$_GET['costo_id']?>','','GET','cargaajax');"  class="btn btn-primary">
             <i class="fa fa-plus fa-lg"></i>
             </a> -->
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
  	
	
	$t['numTras'] = '0';
 $query=mysql_query("SELECT * FROM seguro_costos WHERE id_dist ='".$_SESSION['user_id']."' AND id_seg ='".$_GET['costo_id']."' order by id ASC");
  while($row=mysql_fetch_array($query)){ 
$t['numTras']++;
?>
<tr>
    <td><?=$t['numTras']?></td>
    <td><?=$row['nombre']?></td>
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
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Seguros/Costos/Edit/editar-registar.php?id=<?=$row['id']?>&costo_id=<?=$_GET['costo_id']?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg"></i> 
            </a>
    <!--editar -->
    
         <?
    if ($row['activo']=='si'){ ?>
		 <!--desactivar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Seguros/Costos/List/listado.php?action=desactivar&id=<?=$row['id']; ?>&costo_id=<?=$_GET['costo_id']; ?>','','GET','cargaajax'); }" data-title="Desactivar"  class="btn btn-danger">
             <i class="fa fa-trash-o fa-lg"></i> 
            </a>
    <!--desactivar -->
    
	<?   }else{ ?>
		
         <!--activar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Seguros/Costos/List/listado.php?action=activar&id=<?=$row['id']?>&costo_id=<?=$_GET['costo_id']; ?>','','GET','cargaajax'); }"  data-title="Activar"  class="btn btn-primary">
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