<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	
	session_start();
	include("../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../incluidos/bd_manejos.php');
	
	//$_POST['accion'] = LimpiarCampos($_POST['accion']);
	$acc1 = $_POST['accion'].$_GET['action'];
	
	// EDITAR
	if($_POST['accion']=='editar'){
		$_POST['id'] = $_SESSION['idclient'];
		EditarForm('personal');
		echo'
		<script>
			$("#modal-simple").modal("hide");
			alert("Datos Modificados");
		</script>
		';
		 
	}
		
	$r2 = mysql_query("SELECT * FROM personal WHERE id ='".$_SESSION['user_id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	$_SESSION['idclient'] = $row['id'];

	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		$acc	= $_GET['accion'];
	}else{
		$acc 	= 'editar';
	}
 ?>

   <div class="row" >
                <div class="col-lg-12" style="margin-top:-32px;">
                    <h3 class="page-header">Información personal </h3>
                </div>
                
            
                <!-- /.col-lg-12 -->
            </div>
            
            
 <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Configuraci&oacute;n
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active"><a href="javascript:#home-pills" onClick="CargarAjax2('Admin/Configuracion/datos_generales.php?accion=editar','','GET','cargaajax');" data-toggle="tab" aria-expanded="true">Información personal </a>
                                </li>
                                <li class=""><a href="javascript:#profile-pills" onClick="CargarAjax2('Admin/Configuracion/seguridad.php?accion=editar','','GET','cargaajax');" data-toggle="tab" aria-expanded="false">Seguridad</a>
                                </li>
                                
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            
                                <div class="tab-pane fade active in" id="home-pills">
                                    <div class="row-fluid">
						  <div class="separator line bottom"></div>
							<!-- Column -->
							<div class="separator line bottom"></div>
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form_edit_datos" id="form_edit_datos">
                            <div class="row" style="margin-top: 16px;">
          <div class="col-lg-6">
         <label class="strong">Nombre</label>
             <div class="form-group " style="margin-left: -2px; margin-right: 2px;">
              <input type="text" class="form-control" value="<?=$row['nombres']; ?>" readonly />
            </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Cedula</label>
            <div class="form-group" style="margin-left: -2px; margin-right: 2px;">
			  <input type="text" class="form-control" value="<?=$row['cedula']; ?>"   readonly/>
        </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Direccion<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group " style="margin-left: -2px; margin-right: 2px;">
              <input type="text" name="direccion"  placeholder="Escribir direccion" class="form-control" value="<?=$row['direccion']; ?>" autocomplete="off"/>
             </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Telefono<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group "  style="margin-left: -2px; margin-right: 2px;">
              <input type="text" name="celular" id="celular"  placeholder="Escribir telefono" class="form-control" value="<?=$row['celular']; ?>" autocomplete="off"/>
                                        </div>
          </div>
          
          
          
        </div>
							
                            
                            <div class="separator line bottom"></div>
                          
						<input name="accion" type="hidden" id="accion" value="<?=$acc;?>">
						<!-- Form actions -->
						<div class="form-actions" style="margin: 0;"> 
							<button type="button" class="btn btn-icon btn-primary glyphicons circle_ok" onClick="CargarAjax2_form('Admin/Configuracion/datos_generales.php','form_edit_datos','cargaajax');"><i></i>Guardar cambios</button>
							<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="CargarAjax2('Admin/Configuracion/seguridad.php?accion=editar','','GET','cargaajax');" ><i></i>Cancelar</button>
						</div>
						<!-- // Form actions END -->
                         </form>    <!-- // Column END -->
						</div>
                                </div>
                                
                                
                               
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                
