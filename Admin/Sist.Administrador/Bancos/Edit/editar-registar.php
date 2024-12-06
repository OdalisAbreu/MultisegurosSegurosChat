<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from cuentas_de_banco WHERE id ='".$_GET['id']."'  LIMIT 1");
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
	
	function ValcuentaBanc() {
	
		// validar  nombre
		if($('#a_nombre_de').val().length < 4){ 
			$("#a_nombre_de").css("border","solid 1px #F00");
			var HayError = true;
		}else { 
			$("#a_nombre_de").css("border","solid 1px #ccc"); 
		}
	
		// validar  id_pers
		if($('#num_cuenta').val().length < 4){
			$("#num_cuenta").css("border","solid 1px #F00");
			var HayError = true;
		}else { 
			$("#num_cuenta").css("border","solid 1px #ccc");
	   }
			
	// si envia error
	if (HayError == true){
	} else {
	 	$('#erroruser').fadeOut('3'); 
		CargarAjax2_form('Admin/Sist.Administrador/Bancos/List/listado.php','form_edit_perso','cargaajax');
	}

}


</script>

<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Cuenta de banco</h4>
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
         <label class="strong">Nombre</label>
             <div class="form-group ">
              <input type="text" class="form-control" placeholder="nombre" id="a_nombre_de" name="a_nombre_de" value="<?=$row['a_nombre_de']?>">
              </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Banco</label>
            <div class="form-group">
<select name="id_banc" id="id_banc" style="display:compact" class="form-control">
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
         <label class="strong">No. Cuenta</label>
             <div class="form-group ">
              <input type="text" class="form-control" placeholder="No. de cuenta" id="num_cuenta" name="num_cuenta" value="<?=$row['num_cuenta']?>">
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
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="ValcuentaBanc();"><?=$acc_text?></button>
                         </div>
	</form>