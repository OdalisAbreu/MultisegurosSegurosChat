<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from bancos_suplidores WHERE id ='".$_GET['id']."' 
	AND id_suplid='".$_GET['idsupli']."' LIMIT 1");
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
	if($('#nombres').val().length < 3){
	$("#nombres").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#nombres").css("border","solid 1px #ccc"); }


	// validar  id_pers
	if($('#num_cuenta').val().length < 4){
	$("#num_cuenta").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#num_cuenta").css("border","solid 1px #ccc"); }
		
		
	
	
	// si envia error
	// ..................
	if (HayError == true){
	
	//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
	} else {
	 $('#erroruser').fadeOut('3'); 
	CargarAjax2_form('Admin/Sist.Administrador/Suplidores/Bancos/List/listado.php?idsupli=<?=$_GET['idsupli']?>','form_edit_perso','cargaajax');
	
	
	
	}

}


</script>

<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Banco</h4>
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
<select  class="form-control" id="id_banc" name="id_banc">
  <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT * from bancos WHERE user_id ='".$_SESSION['user_id']."' 
order by nombre_banc ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$c2 = $cat2['nombre_banc'];
			$c_id2 = $cat2['id'];
            
			if($c_id2==$row['id_banc']){
				echo "<option value=\"$c_id2\" selected>$c2</option>"; 
			}else{
				echo "<option value=\"$c_id2\" >$c2</option>";
			}
        } ?> 
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
                
                <? if(!$_GET['id']){?>
                <input name="user_id" type="hidden" id="user_id" value="<? echo $_SESSION['user_id']; ?>" /> 
                <input name="fecha" type="hidden" id="fecha" value="<? echo date ('Y-m-d G:i:s');?>" />
                <input name="activo" type="hidden" id="activo" value="si">
                <input name="id_suplid" type="hidden" id="id_suplid" value="<?=$_GET['idsupli']?>">
                <? } ?>
                 
       </div>     
            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="validar_password();"><?=$acc_text?></button>
                         </div>
	</form>