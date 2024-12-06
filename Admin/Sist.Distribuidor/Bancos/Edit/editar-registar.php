<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from cuentas_de_banco WHERE id ='".$_GET['id']."' AND user_id = '".$_SESSION['user_id']."' LIMIT 1");
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
	
	function validar_passwords() {

	/// validar  seguro 
	a_nombre_de = $('#a_nombre_de').val();
	
	if(a_nombre_de.length < 3){ 
		$("#a_nombre_de").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#a_nombre_de").css("border","solid 1px #ccc"); }
	
	
	/// validar  cuenta 
	num_cuenta = $('#num_cuenta').val();
	
	if(num_cuenta.length < 3){ 
		$("#num_cuenta").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#num_cuenta").css("border","solid 1px #ccc"); }
	
	
	// si envia error
	// ..................
	if (HayError == true){
	//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
	} else {
	CargarAjax2_form('Admin/Sist.Distribuidor/Bancos/List/listado.php','form_edit_perso','cargaajax');
	
	
	
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
                            Información de la cuenta del banco
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
          <label class="strong">Banco<span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group">
<select  class="form-control" id="banco" name="banco">
  <option value="Banco BHD-Leon" <? if($row['banco']=='Banco BHD-Leon'){?>selected="selected"<? }?>>Banco BHD-Leon</option>
  <option value="Banco Popular" <? if($row['banco']=='Banco Popular'){?>selected="selected"<? }?>>Banco Popular</option>
  
 <option value="Banco del Progreso" <? if($row['banco']=='Banco del Progreso'){?>selected="selected"<? }?>>Banco del Progreso</option>
 <option value="Banco Reservas" <? if($row['banco']=='Banco Reservas'){?>selected="selected"<? }?>>Banco Reservas</option>
 
 
 
</select>
        </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">No. Cuenta<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group ">
                                           
                                            <input type="text" class="form-control" placeholder="No. de cuenta" id="num_cuenta" name="num_cuenta" value="<? echo $row['num_cuenta']; ?>">
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
                <input name="user_id" type="hidden" id="user_id" value="<? echo $_SESSION['user_id']; ?>" /> 
                <input name="fecha_registro" type="hidden" id="fecha_registro" value="<? echo date ('Y-m-d G:i:s');?>" /> 
       </div>     
            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="validar_passwords();"><?=$acc_text?></button>
                         </div>
	</form>