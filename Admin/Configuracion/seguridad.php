<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	
	session_start();
	include("../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../incluidos/bd_manejos.php');
	
	//$_POST['accion'] = LimpiarCampos($_POST['accion']);
	$acc1 = $_POST['accion'].$_GET['action'];
		
	//print_r($acc1);
	
	//print_r($_POST);
	// EDITAR
	if($_POST['accion']=='editar'){
		$_POST['id'] = $_SESSION['idclient'];
		
		unset($_POST['user']);
		unset($_POST['password2']);
		
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
	$password 	= $row['password'];
	$_SESSION['idclient'] = $row['id'];
	
	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		$acc	= $_GET['accion'];
	}else{
		$acc 	= 'editar';
	}
 ?>

<script language="JavaScript" type="text/javascript">
	
	function validar_password() {

	//Validar clave actual
	password_princ = $('#password_princ').val();
	password_row = "<?=$password ?>";
	
	if(password_row != password_princ){
	$("#password_princ").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#password_princ").css("border","solid 1px #ccc"); }

	// validar contrasena
	if($('#password').val().length < 6){
	$("#password").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#password").css("border","solid 1px #ccc"); }
	
			
	// validar segunda contrasena
	if($('#password2').val() != $('#password').val()){
	$("#password2").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#password2").css("border","solid 1px #ccc"); }
	
	// si envia error
	// ..................
	if (HayError == true){
	
	//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
	} else {
	
	CargarAjax2_form('Admin/Configuracion/seguridad.php','form_edit_profd','cargaajax');
	
	}

}
</script>
 
   
   <div class="row" >
                <div class="col-lg-12" style="margin-top:-32px;">
                    <h3 class="page-header">Secci&oacute;n de seguridad </h3>
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
                                <li class=""><a href="javascript:#home-pills" onClick="CargarAjax2('Admin/Configuracion/datos_generales.php?accion=editar','','GET','cargaajax');" data-toggle="tab" aria-expanded="false">Información personal </a>
                                </li>
                                <li class="active"><a href="javascript:#profile-pills" onClick="CargarAjax2('Admin/Configuracion/seguridad.php?accion=editar','','GET','cargaajax');" data-toggle="tab" aria-expanded="true">Seguridad</a>
                                </li>
                                
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            
                                <div class="tab-pane fade active in" id="home-pills">
                                    <div class="row-fluid">
						  <div class="separator line bottom"></div>
							<!-- Column -->
							<div class="separator line bottom"></div>
 <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form_edit_profd" id="form_edit_profd">
                            <div class="row"  style="margin-top: 16px;">
          <div class="col-lg-6">
         <label class="strong">Usuario<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group " style="margin-left: -2px; margin-right: 2px;">
                                           <input name="user" type="text" class="form-control" value="<?=$row['email']?>" readonly />
                                            
                                        </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Contrase&ntilde;a actual<span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group" style="margin-left: -2px; margin-right: 2px;">
<input autocomplete="off" name="password_princ" type="password" id="password_princ"  placeholder="Dejar en blanco si no quiere cambiar"  class="form-control" />
        </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Nueva contraseña<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group " style="margin-left: -2px; margin-right: 2px;">
              <input type="password" name="password" id="password"  placeholder="Dejar en blanco si no quiere cambiar" class="form-control" />
                                        </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Repetir nueva contraseña<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group "  style="margin-left: -2px; margin-right: 2px;">
              <input type="password" name="password2" id="password2"  placeholder="Dejar en blanco si no quiere cambiar" class="form-control" />
                                        </div>
          </div>
          
        </div>
							
                            
                            <div class="separator line bottom"></div>
                          
						<input name="accion" type="hidden" id="accion" value="<?=$acc;?>">
						<!-- Form actions -->
						<div class="form-actions" style="margin: 0;"> 
							<button type="button" class="btn btn-icon btn-primary glyphicons circle_ok" onClick="validar_password()"><i></i>Guardar cambios</button>
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
                
