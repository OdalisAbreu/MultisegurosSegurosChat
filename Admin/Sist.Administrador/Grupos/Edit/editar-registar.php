<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from grupos WHERE id ='".$_GET['id']."'");
    $row = mysql_fetch_array($r2);
	
	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
	$acc	= $_GET['accion'];
	$acc_text = 'Registrar';
	
	}else{
	$acc 	= 'Editar';
	$acc_text 	= 'Editar';
	}
	

 ?>
 <script language="JavaScript" type="text/javascript">
	
	function validar_password() {
	
	
	
	// validar  nombre
	if($('#nombres').val().length < 6){
	$("#nombres").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#nombres").css("border","solid 1px #ccc"); }


	// validar  id_pers
	if($('#id_pers').val().length < 1){
	$("#id_pers").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#id_pers").css("border","solid 1px #ccc"); }
		
		
	
	
	// si envia error
	// ..................
	if (HayError == true){
	
	//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
	} else {
	 $('#erroruser').fadeOut('3'); 
	CargarAjax2_form('Admin/Sist.Administrador/Grupos/List/listado.php','form_edit_perso','cargaajax');
	
	
	
	}

}


</script>

<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Cliente</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información del Grupo
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="info">
                                <p>
                                    <div class="row">
          <div class="col-lg-6">
         <label class="strong">Nombre<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group ">
                                           
                                            <input type="text" class="form-control" placeholder="nombre" id="nombres" name="nombres" value="<? echo $row['nombres']; ?>">
                                        </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Cliente ID <span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="Cliente ID" id="id_pers" name="id_pers"  value="<? echo $row['id_pers']; ?>" >
                                        </div>
          </div>
          
          
          
        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
                <input name="accion" type="hidden" id="accion" value="<? echo $acc;?>">
                <input name="id" type="hidden" id="id" value="<? echo $row['id']; ?>" />
                <input name="id_dist" type="hidden" id="id_dist" value="<? echo $_SESSION['user_id']; ?>" /> 
                <input name="fecha" type="hidden" id="fecha" value="<? echo date ('Y-m-d G:i:s');?>" /> 
       </div>     
            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="validar_password();"><?=$acc_text?></button>
                         </div>
	</form>