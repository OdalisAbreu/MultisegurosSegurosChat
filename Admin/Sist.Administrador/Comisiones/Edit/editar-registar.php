<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from comisiones_pers WHERE id ='".$_GET['id']."' 
	AND user_id ='".$_SESSION['user_id']."' LIMIT 1");
    $rowP = mysql_fetch_array($r2);
	
	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		$acc		= $_GET['accion'];
		$acc_text 	= 'Registrar';
	}else{
		$acc 		= 'Editar';
		$acc_text 	= 'Editar';
	}
 ?>
 

<form action="" method="post" enctype="multipart/form-data" id="form_comision">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Comision</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información personal
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="info">
                                <p>
                                    <div class="row">
         <div class="col-lg-6">
         
         <label class="strong">Cliente<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group ">
              <select name="cliente_id" id="cliente_id" style="display:compact" class="form-control">
                <option value="">- Seleccionar - </option>
                        <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT id,nombres from personal WHERE id_dist='".$_SESSION['user_id']."' AND funcion_id IN(2,5,7) AND activo ='si' order by nombres ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$idC = $cat2['id'];
			$nombre = $cat2['nombres'];
            
			if($rowP['cliente_id']==$idC){
				echo "<option value=\"$idC\" selected>$nombre</option>";
			}else{
				echo "<option value=\"$idC\" >$nombre</option>";
			}
        } ?> 
                        </select>
                                        </div>
          </div>
          <div class="col-lg-6">
         <label class="strong">Promotor<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group ">
              <select name="promotor_id" id="promotor_id" style="display:compact" class="form-control">
                <option value="">- Seleccionar - </option>
                        <? ///  SELECCION DEL TIPO .....................................
$Rsc = mysql_query("SELECT id,nombres from personal WHERE funcion_id ='35' AND activo ='si' order by nombres ASC");
    while ($cde = mysql_fetch_array($Rsc)) {
			$idC = $cde['id'];
			$nombre = $cde['nombres'];
            
			if($rowP['promotor_id']==$cde['id']){
				echo "<option value=\"$idC\" selected>$nombre</option>";
			}else{
				echo "<option value=\"$idC\" >$nombre</option>";
			}
        } ?> 
                        </select>
     	</div>
          </div>
          
          <div class="col-lg-6">
          <label class="strong">Comision <span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input name="porciento" type="text" class="form-control" id="porciento" placeholder="Porciento" value="<?=$rowP['porciento']; ?>" maxlength="4">
                                        </div>
          </div>
          
          <div class="col-lg-6">
          <label class="strong">Variables <span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input name="consul" type="text" class="form-control" id="Url" placeholder="consul" value="<?=$rowP['consul']; ?>" maxlength="300">
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
 
                <input name="accion" type="hidden" id="accion" value="<?=$acc;?>">
                <input name="id" type="hidden" id="id" value="<?=$rowP['id']?>" />
               <? if(!$_GET['id']){?>
                <input name="fecha" type="hidden" id="fecha" value="<?=date('Y-m-d G:i:s');?>" /> 
                 <input name="activo" type="hidden" id="activo" value="si" />
				<? } ?>
       </div>     
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Comisiones/List/listado.php','form_comision','cargaajax');"><?=$acc_text?></button>
                                            
           </div>
	</form>
    