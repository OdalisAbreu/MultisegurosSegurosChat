<?php session_start();
ini_set('display_errors', 1);
$equip = $_POST['privilegio'];

include "../../../../incluidos/conexion_inc.php";
Conectarse();
include '../../../../incluidos/bd_manejos.php';
include '../../../../incluidos/nombres.func.php';

// DETERMINAR SI ES GET O POST
$acc1 = $_POST['accion'] . $_GET['action'];

//print_r($_POST);
// DESACTIVAR
if ($_GET['action'] == 'desactivar') {
  $query = mysql_query(
    "UPDATE personal SET activo ='no' WHERE id='" . $_GET['id'] . "' LIMIT 1"
  );
  echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
}

if ($_GET['action'] == 'activar') {
  $query = mysql_query(
    "UPDATE personal SET activo ='si' WHERE id='" . $_GET['id'] . "' LIMIT 1"
  );
  echo '<script> $("#actul").fadeIn(0); $("#actul").fadeOut(10000); </script> ';
}

// REGISTRAR NUEVO
if ($acc1 == 'registrar') {
  Insert_form('personal');
  echo '<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
}

// EDITAR
if ($acc1 == 'Editar') {
  EditarForm('personal');
  echo '<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
}

// EDITAR PRIVILEGIO
if ($_POST['accion'] == 'editarpriv') {
  $_POST['privilegio'] = $equip;

  for ($i = 0; $i < count($_POST['privilegio']); $i++) {
    if ($_POST['privilegio'] > 1) {
      $_POST['privilegios'] .= "[" . $_POST['privilegio'][$i] . "]";
    }
  }
  unset($_POST['privilegio']);

  $query = mysql_query(
    "UPDATE privilegios SET
		 privilegios = '" .
      $_POST['privilegios'] .
      "'
		 WHERE id_pers = '" .
      $_POST['id_pers'] .
      "' AND dist_id  = '" .
      $_SESSION['user_id'] .
      "' LIMIT 1"
  );

  echo '<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
}

//echo $_SESSION['user_id'];
?>

<div class="row" >
                <div class="col-lg-10" style="margin-top:-35px;">
                    <h3 class="page-header">Listados de Distribuidores </h3>
                </div>
                <div class="col-lg-2" style=" margin-top:10px;">
            <a onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php','','GET','cargaajax');" class="btn btn-info"><i class="fa fa-list fa-lg"></i></a>
           
            <a onClick="CargarAjax_win('Admin/Sist.Administrador/Personal/Edit/editar-registar.php?accion=registrar','','GET','cargaajax');" class="btn btn-primary"> <i class="fa fa-plus fa-lg"></i></a>
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
                            <!--<th>Fecha</th>-->
                            <th>nombre</th>
                            <th>Balance</th>
                            <th>CxC</th>
                            <th>Conexion</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                            <th style="width:205px;">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
  <?php
  if (!$_GET['estado']) {
    $estado = "AND activo !='' ";
  } elseif ($_GET['estado'] == 'si') {
    $estado = "AND activo = 'si' ";
  } elseif ($_GET['estado'] == 'no') {
    $estado = "AND activo = 'no' ";
  }

  //inicializo el criterio y recibo cualquier cadena que se desee buscar
  $criterio = "";
  $txt_criterio = "";
  if ($_GET["criterio"] != "") {
    $txt_criterio = $_GET["criterio"];
    $criterio =
      " where id_dist = '" . $_SESSION['user_id'] . "' AND funcion_id ='2' ";
  } else {
    $criterio =
      " where id_dist = '" . $_SESSION['user_id'] . "' AND funcion_id ='2' ";
  }

  $sql = "SELECT * FROM personal " . $criterio . "";
  //echo "SELECT * FROM agencia_vehiculos ".$criterio."";
  $res = mysql_query($sql);
  $numeroRegistros = mysql_num_rows($res);
  if ($numeroRegistros <= 0) {
  } else {
    //////////elementos para el orden
    if (!isset($orden)) {
      $orden = "id DESC";
    }
    //////////fin elementos de orden

    //////////calculo de elementos necesarios para paginacion
    //tamaño de la pagina
    $tamPag = 10;

    //pagina actual si no esta definida y limites
    if (!isset($_GET["pagina"])) {
      $pagina = 1;
      $inicio = 1;
      $final = $tamPag;
    } else {
      $pagina = $_GET["pagina"];
    }
    //calculo del limite inferior
    $limitInf = ($pagina - 1) * $tamPag;

    //calculo del numero de paginas
    $numPags = ceil($numeroRegistros / $tamPag);
    if (!isset($pagina)) {
      $pagina = 1;
      $inicio = 1;
      $final = $tamPag;
    } else {
      $seccionActual = intval(($pagina - 1) / $tamPag);
      $inicio = $seccionActual * $tamPag + 1;

      if ($pagina < $numPags) {
        $final = $inicio + $tamPag - 1;
      } else {
        $final = $numPags;
      }

      if ($final > $numPags) {
        $final = $numPags;
      }
    }

    //////////fin de dicho calculo

    $sql =
      "SELECT * FROM personal " .
      $criterio .
      "  ORDER BY " .
      $orden .
      " LIMIT " .
      $limitInf .
      "," .
      $tamPag;
    $res = mysql_query($sql);
    while ($row = mysql_fetch_array($res)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <!--<td><?= FechaList($row['fecha_registro']) ?></td>-->
    <td onclick="CargarAjax_win('Admin/Sist.Administrador/Personal/List/sub-clientes.php?id=<?= $row[
      'id'
    ] ?>','','GET','cargaajax');"><?= $row['nombres'] ?></td>
    <td>$<?= FormatDinero($row['balance']) ?></td>
    <td>
   
    
    <div class="balance open hidden-phone " onclick="CargarAjax2('incluidos/Balance/BalanceActualCred.php?id=<?= $row[
      'id'
    ] ?>','','GET','bl_cred<?= $row['id'] ?>');">
<span id="bl_cred<?= $row[
  'id'
] ?>" style="cursor:default; color:#F00;" class="balance">$0.00</span> 
</div>


    </td>
    <td><?= $row['tipo_conex'] ?></td>
    <td>
	<?php if ($row['activo'] == 'si') {
   echo "<font color='#1D0CD6'><b>Activo</b></font>";
 } else {
   echo "<font color='#F6060A'><b>Inactivo</b></font>";
 } ?>
    </td>
    <td>
    <div class="input-append">
    <div class="btn-group dropdown">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Seleccionar <span class="caret"></span>
</button>
        <ul class="dropdown-menu pull-right">
            <li><a href="#" onclick="CargarAjax2('Admin/Sist.Administrador/Opciones/recargados.php?id=<?= $row[
              'id'
            ] ?>','','GET','cargaajax');">Saldos Recargados</a></li>
            
            <li><a href="#" onclick="CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans_Dist.php?dist_id=<?= $row[
              'id'
            ] ?>','','GET','cargaajax');">Ventas Realizadas</a></li>
           
           <!--<li><a href="#" onclick="CargarAjax2('Admin/Sist.Administrador/Reportes/ImpSeg.php?dist_id=<?= $row[
             'id'
           ] ?>','','GET','cargaajax');">Impresion de Seguros</a></li>--> 
            
        </ul>
  </div>
</div>
    </td>
    <td>
    
      
    
   
    
     <!--editar -->
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Personal/Edit/editar-registar.php?id=<?php echo $row[
              'id'
            ]; ?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
             <i class="fa fa-pencil fa-lg"></i> 
            </a>
    <!--editar -->
        
    <?php if ($row['activo'] == 'si') { ?>
		 <!--desactivar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?action=desactivar&id=<?= $row[
              'id'
            ] ?>','','GET','cargaajax'); }" data-title="Desactivar"  class="btn btn-danger">
             <i class="fa fa-trash-o fa-lg"></i> 
            </a>
    <!--desactivar -->
    
	<?php } else { ?>
		
         <!--activar -->
            <a href="javascript:Elim();" onclick="if(confirm('Deshabilitar \n &iquest; Esta seguro de seguir ?')){ CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?action=activar&id=<?= $row[
              'id'
            ] ?>','','GET','cargaajax'); }"  data-title="Activar"  class="btn btn-primary">
          <i class="fa fa-power-off fa-lg"></i> 
            </a>
    <!--activar -->
    
	<?php } ?>
      
     <!--generar privilegio usuario-->
            <a href="javascript:" onClick="CargarAjax_win('Admin/Sist.Administrador/Personal/Edit/privilegios.php?idClient=<?= $row[
              'id'
            ] ?>&list=p','','GET','cargaajax');"   data-toggle="tooltip" data-title="Privilegios"  class="btn btn-primary"><i class="fa fa-key fa-lg"></i> </a>    
            <!--generar privilegio usuario--> 
       
   
   <?php if ($row['tipo_conex'] == 'http-request') { ?>    
       <a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Cuentas_Dependientes/List/listado.php?id_depe=<?= $row[
         'id'
       ] ?>','','GET','cargaajax');"  data-title="Cuentas"  class="btn btn-primary">
          <i class="fa fa-users fa-lg"></i>  
            </a>
            
    <?php } ?>        
                
       <!--recargar usuario-->
            <!--<a href="#" onclick="CargarAjax_win('Admin/Sist.Administrador/Opciones/Acciones/Recargar.php?id=<?= $row[
              'id'
            ] ?>','','GET','cargaajax'); " data-toggle="tooltip" data-title="Recargar Saldo" data-placement="bottom" >
            <span class="fa-stack fa-lg" style="float:left;">
  <i class="fa fa-square-o fa-stack-2x"></i>
  <i class="fa fa-usd fa-stack-1x"></i>
</span></a>-->
    <!--recargar usuario-->
    
    
    
    <!--recargar usuario-->
            <!--<a href="#" onclick="CargarAjax_win('Admin/Sist.Administrador/Opciones/Acciones/RetirarBal.php?id=<?= $row[
              'id'
            ] ?>','','GET','cargaajax'); " data-toggle="tooltip" data-title="Retirar Saldo" data-placement="bottom" >
            <span class="fa-stack fa-lg" style="float:left;">
  <i class="fa fa-square-o fa-stack-2x"></i>
  <i class="fa fa-ban fa-stack-1x"></i>
</span></a>-->
    <!--recargar usuario-->
    
      
    </td>
  </tr>
  <?php }
  }
  ?>
  <tr>
	<td colspan="8">
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
    
    <?php
    if ($pagina > 1) { ?>
      	<a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?pagina=<?= $pagina -
         1 ?>&orden=<?= $orden ?>&criterio=<?= $txt_criterio ?>','','GET','cargaajax');" >Anterior</a>  
		<?php }

    for ($i = $inicio; $i <= $final; $i++) {
      if ($i == $pagina) { ?>
         	<a class="rcorners2" href="#"><b><?= $i ?></b></a>
      	<?php } else { ?>
        
         	<a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?pagina=<?= $i ?>&orden=<?= $orden ?>&criterio=<?= $txt_criterio ?>','','GET','cargaajax');" ><?= $i ?></a>
            
     <?php }
    }
    if ($pagina < $numPags) { ?>
        <a class="rcorners1" href="javascript:"  onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php?pagina=<?= $pagina +
          1 ?>&orden=<?= $orden ?>&criterio=<?= $txt_criterio ?>','','GET','cargaajax');" >Siguiente</a>
<?php }

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