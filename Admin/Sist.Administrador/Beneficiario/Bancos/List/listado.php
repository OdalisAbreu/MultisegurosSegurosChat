<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../../../../incluidos/bd_manejos.php');
	include('../../../../../incluidos/nombres.func.php');

	// DETERMINAR SI ES GET O POST
	 $acc1 = $_POST['accion'].$_GET['action'];
	 
	 //print_r($_POST);
	// DESACTIVAR
	if($_GET['action']=='desactivar'){
		$query=mysql_query("UPDATE comisiones_bancos SET activo ='no' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}
	
	if($_GET['action']=='activar'){
		$query=mysql_query("UPDATE comisiones_bancos SET activo ='si' WHERE id='".$_GET['id']."' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}

	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		Insert_form('comisiones_bancos');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	// EDITAR
	if($acc1=='Editar'){
		EditarForm('comisiones_bancos');
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
?>

<div class="row" >
                <div class="col-lg-10" style="margin-top:-25px;">
                    <h3 class="page-header">Listados de bancos del Beneficiarios 
					<font color="#428bca"><?=ClientePers($_GET['idc'])?></font></h3>
                </div>
                <div class="col-lg-2" style=" margin-top:10px;">
            <a onClick="CargarAjax2('Admin/Sist.Administrador/Beneficiario/Bancos/List/listado.php?idc=<?=$_GET['idc']?>','','GET','cargaajax');" class="btn btn-info"><i class="fa fa-list fa-lg"></i></a>
            
            <a onClick="CargarAjax_win('Admin/Sist.Administrador/Beneficiario/Bancos/Edit/editar-registar.php?accion=registrar&idc=<?=$_GET['idc']?>','','GET','cargaajax');" class="btn btn-primary"> <i class="fa fa-plus fa-lg"></i></a>
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
                            <th>Cuenta</th>
                            <th>Estado</th>
                            <th style="width:172px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	

 
 	//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio = ""; 
$txt_criterio = ""; 
if ($_GET["criterio"] !=""){ 
   $txt_criterio = $_GET["criterio"]; 
   $criterio = " where user_id = '".$_SESSION['user_id']."' AND id_benef='".$_GET['idc']."' "; 
}else{
   $criterio = " where user_id = '".$_SESSION['user_id']."' AND id_benef='".$_GET['idc']."' "; 
}


 $sql="SELECT * FROM comisiones_bancos ".$criterio."";
//echo "SELECT * FROM agencia_vehiculos ".$criterio.""; 
$res=mysql_query($sql); 
$numeroRegistros=mysql_num_rows($res); 
if($numeroRegistros<=0) 
{ 
  
}else{ 
   	//////////elementos para el orden 
   	if(!isset($orden)) 
   	{ 
      	$orden="id DESC"; 
   	} 
   	//////////fin elementos de orden 

   	//////////calculo de elementos necesarios para paginacion 
   	//tamaño de la pagina 
   	$tamPag=10; 

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

 $sql="SELECT * FROM comisiones_bancos ".$criterio."  ORDER BY ".$orden." LIMIT ".$limitInf.",".$tamPag;  
	$res=mysql_query($sql); 
	while($row=mysql_fetch_array($res)){ 
			


?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=FechaList($row['fecha'])?></td>
    <td><?=$row['nombre_banc']?></td>
    <td><?=$row['cuenta_no']?></td>
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
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Beneficiario/Bancos/Edit/editar-registar.php?id=<?=$row['id'];?>&idc=<?=$_GET['idc'];?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg"></i> 
            </a>
    <!--editar -->
         
    <?
    if ($row['activo']=='si'){ ?>
		 <!--desactivar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Beneficiario/Bancos/List/listado.php?action=desactivar&id=<?=$row['id']; ?>&idc=<?=$_GET['idc'];?>','','GET','cargaajax'); }" data-title="Desactivar"  class="btn btn-danger">
             <i class="fa fa-trash-o fa-lg"></i> 
            </a>
    <!--desactivar -->
    
	<?   }else{ ?>
		
         <!--activar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Beneficiario/Bancos/List/listado.php?action=activar&id=<?=$row['id']; ?>&idc=<?=$_GET['idc'];?>','','GET','cargaajax'); }"  data-title="Activar"  class="btn btn-primary">
          <i class="fa fa-power-off fa-lg"></i> 
            </a>
    <!--activar -->
    
	<?   } ?>
      
      
      
    
      
    </td>
  </tr>
  <? }  }?>
  
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