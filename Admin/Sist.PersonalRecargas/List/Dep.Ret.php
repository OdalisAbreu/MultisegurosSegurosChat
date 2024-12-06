<?
	session_start();
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	include("../../../incluidos/nombres.func.php");
	Conectarse();
	include('../../../incluidos/bd_manejos.php');
	

	// DETERMINAR SI ES GET O POST
	//$actual = $_POST['actual'].$_GET['actual'];
	 $acc1 = $_POST['accion'].$_GET['action'];
	// DESACTIVAR
	if($_GET['action']=='eliminar'){
		//unset($_POST['actual']);
		$id=$_GET['id'];
		$query=mysql_query("UPDATE personal SET activo ='no' WHERE id='$id' LIMIT 1");
		echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
	}

	// REGISTRAR NUEVO
	if($acc1=='registrar'){
		//unset($_POST['actual']);
		Insert_form('personal');
		echo mysql_error();
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
                <div class="col-lg-12" style="margin-top: -34px;">
                    <h3 class="page-header">Listados de Clientes </h3>
                </div>
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
                            <th>Nivel</th>
                            <th>Acciones</th>
                            <th style="width:172px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	
	
if(!$_GET['estado']){
	 $estado = "AND activo !='' ";
 }else if($_GET['estado'] =='si'){
	 $estado = "AND activo = 'si' ";
 }else if($_GET['estado'] =='no'){
	 $estado = "AND activo = 'no' ";
 }
 
 	//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio = ""; 
$txt_criterio = ""; 
if ($_GET["criterio"] !=""){ 
   $txt_criterio = $_GET["criterio"]; 
   $criterio = " where funcion_id !='34' "; 
}else{
   $criterio = " where funcion_id !='34' "; 
}


$sql="SELECT * FROM personal ".$criterio."";
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

	$sql="SELECT * FROM personal ".$criterio."  ORDER BY ".$orden." LIMIT ".$limitInf.",".$tamPag; 
	$res=mysql_query($sql); 
	while($row=mysql_fetch_array($res)){

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=FechaList($row['fecha'])?></td>
    <td><?=$row['nombres']?></td>
    <td>$<?=FormatDinero($row['balance'])?></td>
    <td><?
    if($row['funcion_id']=='3'){
		$pv = '<b>Representante</b>';
	}else if($row['funcion_id']=='2'){
		$pv = '<b>Distribuidor</b>';
	}
	
	echo $pv;
	?></td>
    <td>
    <div class="input-append">
    <div class="btn-group dropdown">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Seleccionar <span class="caret"></span>
</button>
        <ul class="dropdown-menu pull-right">
            <!--<li><a href="javascript:" onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/itinerario/List/listado.php?id_crucero=<? echo $row['id']; ?>','','GET','cargaajax');">Itinerarios</a></li>-->
            <!--<li><a href="#">Transacciones</a></li>-->
            <li><a href="#" onclick="CargarAjax2('Admin/Sist.Distribuidor/Opciones/recargados.php?id=<? echo $row['id']; ?>','','GET','cargaajax');">Saldos Recargados</a></li>
            <li><a href="#" onclick="CargarAjax2('Admin/Sist.Distribuidor/Opciones/retirados.php?id=<? echo $row['id']; ?>','','GET','cargaajax');">Saldos Retirados</a></li>
            <li><a href="#">Resumen de ventas</a></li> 
        </ul>
  </div>
</div>
    </td>
    <td>
    
      
    <!--recargar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/Opciones/Acciones/Recargar.php?id=<?=$row['id']; ?>','','GET','cargaajax'); " data-title="Recargar"  class="btn btn-info">
             <i class="fa fa-usd fa-lg" title="Recargar Cuenta"></i> 
            </a>
    <!--recargar -->
    
      
       <!--retirar balance -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/Opciones/Acciones/RetirarBal.php?id=<?=$row['id']; ?>','','GET','cargaajax'); " data-title="Retirar Balance"  class="btn btn-info">
             <i class="fa fa-ban fa-lg" title="Retirar Efectivo"></i> 
            </a>
    <!--retirar balance -->
      
    </td>
  </tr>
  <? }  }?>
  
  <tr>
	<td colspan="7">
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
      	<a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?pagina=<?=($pagina-1)?>&orden=<?=$orden?>&criterio=<?=$txt_criterio?>','','GET','cargaajax');" >Anterior</a>  
		<?
   	} 

   	for($i=$inicio;$i<=$final;$i++) 
   	{ 
      	if($i==$pagina) 
      	{ ?>
         	<a class="rcorners2" href="#"><b><?=$i?></b></a>
      	<? }else{ ?>
        
         	<a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?pagina=<?=$i?>&orden=<?=$orden?>&criterio=<?=$txt_criterio?>','','GET','cargaajax');" ><?=$i?></a>
            
     <? 	} 
   	} 
   	if($pagina<$numPags) 
   { 
      	?>
        <a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?pagina=<?=($pagina+1)?>&orden=<?=$orden?>&criterio=<?=$txt_criterio?>','','GET','cargaajax');" >Siguiente</a>
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