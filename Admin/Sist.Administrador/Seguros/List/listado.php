<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../../../incluidos/bd_manejos.php');
	include('../../../../incluidos/nombres.func.php');

	 $acc1 = $_POST['accion'].$_GET['action'];
	
	// DESACTIVAR
	if($_GET['action']=='desactivar'){
		$query=mysql_query("UPDATE seguros SET activo ='no' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	// ACTIVAR
	if($_GET['action']=='activar'){
		$query=mysql_query("UPDATE seguros SET activo ='si' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	

	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		
		$query=mysql_query("INSERT INTO `suplidores` (`id_dist`, `nombre`, `fecha`, `activo`) 
			VALUES
		( ".$_SESSION['user_id'].", '".$_POST['nombre']."',  '".date("Y-m-d H:i:s")."', 'si')");
		
		$_POST['id_suplid'] = $idsuplid;
		
		Insert_form('seguros');
		$id = mysql_insert_id();
		
		$query=mysql_query("INSERT INTO `seguro_costos` (`id_dist`, `id_seg`, `nombre`, `veh_tipo`, `3meses`, `6meses`, `12meses`, `dpa`, `rc`, `rc2`, `fj`, `registro`, `registro_update`, `activo`) VALUES
( 6, ".$id.", 'Automovil', 2, 695, 1215, 1875, 100000, '100000', '200000', 300000, '2013-09-09 15:12:52', '2017-08-11 22:13:19', 'si'),
( 6, ".$id.", 'Autobuses (De 16 a 60 Pasajeros)', 1, 2775, 4895, 6995, 300000, '300000', '600000', 500000, '2013-09-09 15:06:25', '2017-08-16 02:04:29', 'si'),
( 6, ".$id.", 'Camion', 3, 2925, 4975, 7275, 300000, '300000', '600000', 500000, '2013-09-09 15:13:22', '2017-08-11 22:13:25', 'si'),
( 6, ".$id.", 'Camion Cabezote', 4, 2925, 4975, 7275, 300000, '300000', '600000', 500000, '2013-09-09 15:13:43', '2017-08-11 00:17:17', 'si'),
( 6, ".$id.", 'Camion Volteo', 5, 2925, 4975, 7275, 300000, '300000', '600000', 500000, '2013-09-09 15:14:09', '2017-08-11 00:17:36', 'si'),
( 6, ".$id.", 'Camioneta', 6, 995, 1735, 2475, 100000, '100000', '200000', 300000, '2013-09-09 15:14:30', '2017-08-11 00:18:02', 'si'),
( 6, ".$id.", 'Four Wheel', 7, 125, 185, 195, 50000, '50000', '100000', 100000, '2013-09-09 15:14:49', '2017-08-11 00:18:35', 'si'),
( 6, ".$id.", 'Furgoneta', 8, 995, 1735, 2475, 100000, '100000', '200000', 300000, '2013-09-09 15:15:10', '2017-08-11 00:19:26', 'si'),
( 6, ".$id.", 'Grua', 9, 2715, 4375, 6775, 300000, '300000', '600000', 500000, '2013-09-09 15:17:02', '2017-08-11 00:20:39', 'si'),
( 6, ".$id.", 'Jeep', 10, 695, 1215, 1875, 100000, '100000', '200000', 300000, '2013-09-09 15:17:57', '2017-08-11 00:21:21', 'si'),
( 6, ".$id.", 'Jeepeta', 11, 695, 1215, 1875, 100000, '100000', '200000', 300000, '2013-09-09 15:20:23', '2017-08-11 00:21:38', 'si'),
( 6, ".$id.", 'Maquinaria Pesada', 12, 2715, 4375, 6775, 300000, '300000', '600000', 500000, '2013-09-09 15:21:50', '2017-08-11 00:21:59', 'si'),
( 6, ".$id.", 'Minivan (Hasta 15 Pasajeros)', 13, 1715, 2975, 4575, 100000, '100000', '200000', 300000, '2013-09-09 15:22:13', '2017-08-11 00:22:44', 'si'),
( 6, ".$id.", 'Motocicleta', 14, 125, 185, 275, 50000, '50000', '100000', 100000, '2013-09-09 15:22:32', '2017-08-11 00:23:17', 'si'),
(6, ".$id.", 'Motoneta', 15, 125, 185, 275, 50000, '50000', '100000', 100000, '2013-09-09 15:22:51', '2017-08-11 00:23:38', 'si'),
( 6, ".$id.", 'Station Wagon', 16, 695, 1215, 1875, 100000, '100000', '200000', 300000, '2013-09-09 15:23:08', '2017-08-11 00:24:05', 'si'),
(6, ".$id.", 'Trailer', 17, 2925, 4975, 7275, 300000, '300000', '600000', 500000, '2013-09-09 15:23:25', '2017-08-11 00:24:55', 'si'),
( 6, ".$id.", 'Van (Hasta 15 Pasajeros)', 18, 1715, 2975, 4575, 100000, '100000', '200000', 300000, '2013-09-09 15:23:48', '2017-08-11 00:25:41', 'si'),
(6, ".$id.", 'Minibus (De 16 a 60 Pasajeros)', 19, 2775, 4895, 6995, 100000, '100000', '200000', 300000, '2013-09-09 15:24:04', '2017-08-11 00:26:44', 'si'),
( 6, ".$id.", 'Remolque', 20, 2925, 4975, 7275, 300000, '300000', '600000', 500000, '2013-09-09 15:24:24', '2017-08-11 00:27:39', 'si')");
		
		//echo mysql_error();
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){
		EditarForm('seguros');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
?>

<div class="row" >
                <div class="col-lg-10" style="margin-top:-35px;">
                    <h3 class="page-header">Listados de Seguros</h3>
                </div>
                <div class="col-lg-2" style=" margin-top:10px;">
            <a onClick="CargarAjax2('Admin/Sist.Administrador/Seguros/List/listado.php','','GET','cargaajax');" class="btn btn-info">
             <i class="fa fa-list fa-lg"></i></a>
            <a  onClick="CargarAjax_win('Admin/Sist.Administrador/Seguros/Edit/editar-registar.php?accion=registrar','','GET','cargaajax');"  class="btn btn-primary">
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
                            <th>Update</th>
                            <th>Nombre</th>
                            <th>Prefijo</th>
                            <th>Estado</th>
                            <th style="width:172px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	
	
 $query=mysql_query("SELECT * FROM seguros order by id ASC");
  while($row=mysql_fetch_array($query)){ 

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=FechaList($row['fecha'])?></td>
    <td><?=FechaList($row['update'])?></td>
    <td><?=$row['nombre']?></td>
    <td><?=$row['prefijo']?></td>
    <td>
	<? if ($row['activo']=='si'){ 
		echo "<font color='#1D0CD6'><b>".$row['activo']."</b></font>";
	   }else{
		echo "<font color='#F6060A'><b>".$row['activo']."</b></font>";
	   }
	?>
    </td>
    <td>
     <!--tarifas -->
     <a href="javascript:" onclick="CargarAjax2('Admin/Sist.Administrador/Seguros/Tarifas/List/listado.php?aseguradora_id=<?=$row['id']; ?>','','GET','cargaajax');" data-title="Costos"  class="btn btn-success">
             <i class="fa fa-eye fa-lg" title="Tarifas"></i> 

            </a>
    <!--tarifas -->

     <!--editar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Seguros/Edit/editar-registar.php?id=<?=$row['id']; ?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg" title="Editar"></i> 

            </a>
    <!--editar -->
    
     <!--tarifas -->
            <a href="javascript:" onclick="CargarAjax2('Admin/Sist.Administrador/Seguros/Costos/List/listado.php?costo_id=<?=$row['id']; ?>','','GET','cargaajax');" data-title="Costos"  class="btn btn-success">
             <i class="fa fa-bitcoin fa-lg" title="Costos"></i> 

            </a>
    <!--tarifas -->
      
   
  <?
    if ($row['activo']=='si'){ ?>
	
		 <!--desactivar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Seguros/List/listado.php?action=desactivar&id=<?=$row['id']; ?>','','GET','cargaajax'); }" data-title="Desactivar"  class="btn btn-danger">
            
             <i class="fa fa-trash-o fa-lg" title="Desactivar"></i> 
            </a>
    <!--desactivar -->
    
	<?   }else{ ?>
		
         <!--activar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Seguros/List/listado.php?action=activar&id=<?=$row['id']; ?>','','GET','cargaajax'); }"  data-title="Activar"  class="btn btn-primary">
            
          <i class="fa fa-power-off fa-lg" title="Activar"></i> 
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