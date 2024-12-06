<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../../../incluidos/conexion_inc.php");
	include('../../../../../../incluidos/bd_manejos.php');
	include('../../../../../../incluidos/nombres.func.php');
	Conectarse();
	
	
	// DETERMINAR SI ES GET O POST
	 $acc1 = $_POST['accion'].$_GET['action'];
	
	// DESACTIVAR
	if($_GET['action']=='desactivar'){
		$query=mysql_query("UPDATE ciudad SET activo ='no' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	// ACTIVAR
	if($_GET['action']=='activar'){
		$query=mysql_query("UPDATE ciudad SET activo ='si' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		Insert_form('ciudad');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){
		EditarForm('ciudad');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
?>

<div class="row" >
                <div class="col-lg-10" style="margin-top:-35px;">
                    <h3 class="page-header">Listados de 
                    
                    
                     
                     <a  onClick="CargarAjax2('Admin/Sist.Administrador/Provincia/Municipio/List/listado.php?idprov=<?=$_GET['idprov']?>','','GET','cargaajax');" >
             ciudades
             </a> 
                    
                    
                    del municipio <a href="javascript:" onclick="CargarAjax2('Admin/Sist.Administrador/Provincia/Municipio/Ciudad/List/listado.php?idmuni=<?=$_GET['idmuni']?>&idprov=<?=$_GET['idprov']?>','','GET','cargaajax');" data-toggle="tooltip" data-title="Editar" data-placement="bottom" ><?=Municipio($_GET['idmuni'])?></a></h3>
                </div>
              
              <div class="col-lg-2" style=" margin-top:10px;">
            <a onClick="CargarAjax2('Admin/Sist.Administrador/Provincia/Municipio/Ciudad/List/listado.php?idmuni=<?=$_GET['idmuni']?>','','GET','cargaajax');" class="btn btn-info">
             <i class="fa fa-list fa-lg"></i></a>
            <a  onClick="CargarAjax_win('Admin/Sist.Administrador/Provincia/Municipio/Ciudad/Edit/editar-registar.php?accion=registrar&idmuni=<?=$_GET['idmuni']?>&idprov=<?=$_GET['idprov']?>','','GET','cargaajax');"  class="btn btn-primary">
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
                            <th>Codigo</th>
                            <th>Estado</th>
                            <th style="width:172px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
  $sqls="SELECT * FROM ciudad WHERE id_dist ='".$_SESSION['user_id']."' AND id_muni ='".$_GET['idmuni']."' ";
$res=mysql_query($sqls); 
$numeroRegistros=mysql_num_rows($res); 
if($numeroRegistros<=0) 
{  }else{ 
   	//////////elementos para el orden 
   	if(!isset($orden)) 
   	{ 
      	$orden="id DESC"; 
   	} 
   	//////////fin elementos de orden 

   	//////////calculo de elementos necesarios para paginacion 
   	//tamaño de la pagina 
   	$tamPag=12; 

   	//pagina actual si no esta definida y limites 
   	if(!isset($_GET["pagina"])) 
   	{ 
      	$pagina=1; 
      	$inicio=1; 
      	$final=$tamPag; 
   	}else{ 
      	$pagina = $_GET["pagina"]; 
   	} 
   	//calculo del limite inferior 
   	$limitInf=($pagina-1)*$tamPag; 

   	//calculo del numero de paginas 
   	$numPags=ceil($numeroRegistros/$tamPag); 
   	if(!isset($pagina)) 
   	{ 
      	$pagina=1; 
      	$inicio=1; 
      	$final=$tamPag; 
   	}else{ 
      	$seccionActual=intval(($pagina-1)/$tamPag); 
      	$inicio=($seccionActual*$tamPag)+1; 

      	if($pagina<$numPags) 
      	{ 
         	$final=$inicio+$tamPag-1; 
      	}else{ 
         	$final=$numPags; 
      	} 

       if ($final>$numPags){ 
          $final=$numPags; 
      	} 
   	} 
 
//////////fin de dicho calculo 
	
   $sql2="SELECT * FROM ciudad WHERE id_dist ='".$_SESSION['user_id']."' AND id_muni ='".$_GET['idmuni']."'  ORDER BY id DESC";
 
 
 
 $res2=mysql_query($sql2); 
  while($row=mysql_fetch_array($res2)){ 

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=FechaList($row['fecha'])?></td>
    <td><?=$row['descrip']?></td>
    <td><?=$row['cod']?></td>
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
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Provincia/Municipio/Ciudad/Edit/editar-registar.php?id=<?=$row['id']; ?>&pagina=<?=$pagina?>&idmuni=<?=$_GET['idmuni']?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg"></i> 
            </a>
    <!--editar -->
    
    
   
   
      
       <?
    if ($row['activo']=='si'){ ?>
		 <!--desactivar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Provincia/Municipio/Ciudad/List/listado.php?action=desactivar&id=<?=$row['id']?>&idmuni=<?=$_GET['idmuni']?>','','GET','cargaajax'); }" data-title="Desactivar"  class="btn btn-danger">
             <i class="fa fa-trash-o fa-lg"></i> 
            </a>
    <!--desactivar -->
    
	<?   }else{ ?>
		
         <!--activar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Provincia/Municipio/Ciudad/List/listado.php?action=activar&id=<?=$row['id']?>&idmuni=<?=$_GET['idmuni']?>','','GET','cargaajax'); }"  data-title="Activar"  class="btn btn-primary">
          <i class="fa fa-power-off fa-lg"></i> 
            </a>
    <!--activar -->
    
	<?   } ?>
    </td>
  </tr>
  <? } 
  
}?>

<tr>
	<td colspan="6">
<style>
  
  .rcorners1 {
    border-radius: 50px;
    background: #5BC0DE;
    padding: 5px; 
    width: 70px;
    height: 30px;
	color:#FFF;
	 
 }
 
 .rcorners2 {
    border-radius: 50px;
    background: #428BCA;
    padding: 7px; 
    width: 70px;
    height: 30px; 
	color:#FFF;
 }
</style>
    
    <? 
   	if($pagina>1) 
   	{ ?>
      	<a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Provincia/Municipio/List/listado.php?pagina=<?=($pagina-1)?>&orden=<?=$orden?>&criterio=<?=$txt_criterio?>&idmuni=<?=$_GET['idmuni']?>','','GET','cargaajax');" >Anterior</a>  
		<?
   	} 

   	for($i=$inicio;$i<=$final;$i++) 
   	{ 
      	if($i==$pagina) 
      	{ ?>
         	<a class="rcorners2" href="#"><b><?=$i?></b></a>
      	<? }else{ ?>
        
         	<a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Provincia/Municipio/List/listado.php?pagina=<?=$i?>&orden=<?=$orden?>&criterio=<?=$txt_criterio?>&idmuni=<?=$_GET['idmuni']?>','','GET','cargaajax');" ><?=$i?></a>
            
     <? 	} 
   	} 
   	if($pagina<$numPags) 
   { 
      	?>
        <a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Provincia/Municipio/List/listado.php?pagina=<?=($pagina+1)?>&orden=<?=$orden?>&criterio=<?=$txt_criterio?>&idmuni=<?=$_GET['idmuni']?>','','GET','cargaajax');" >Siguiente</a>
<?   } 
//////////fin de la paginacion 
?> 
    </td>
</tr>

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