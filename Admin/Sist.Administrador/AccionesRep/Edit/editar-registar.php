<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from acciones_rep WHERE id ='".$_GET['id']."' LIMIT 1");
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


<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Configuraci&oacute;n</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información de la configuraci&oacute;n
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="info">
                                <p>
                                    <div class="row">
          <div class="col-lg-12">
         <label class="strong">Suplidores</label>
             <div class="form-group ">
              <select name="aseg_id" id="aseg_id" style="display:compact" class="form-control">
              <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT * from suplidores WHERE id_dist ='".$_SESSION['user_id']."' AND sigla !='' AND activo ='si' order by nombre ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$c2 = $cat2['nombre'];
			$c_id2 = $cat2['id_seguro'];
            
			if($c_id2==$row['id_seguro']){
				echo "<option value=\"$c_id2\" selected>$c2</option>"; 
			}else{
				echo "<option value=\"$c_id2\" >$c2</option>";
			}
        } ?> 
        	</select>
              </div>
          </div>
          <div class="col-lg-6">
              <label class="strong">Excel</label>
                <div class="form-group">
                    <select name="excel" id="excel" style="display:compact" class="form-control">
                       <option value="si" <? if($row['excel']=='si'){?>selected <? } ?>>Si</option> 
                       <option value="no" <? if($row['excel']=='no'){?>selected <? } ?>>No</option>
                     </select>
                </div>
          </div>
          
          <div class="col-lg-6">
              <label class="strong">PDF</label>
                <div class="form-group">
                    <select name="pdf" id="pdf" style="display:compact" class="form-control">
                       <option value="si" <? if($row['pdf']=='si'){?>selected <? } ?>>Si</option> 
                       <option value="no" <? if($row['pdf']=='no'){?>selected <? } ?>>No</option>
                     </select>
                </div>
          </div>
          
          <div class="col-lg-6">
              <label class="strong">TXT</label>
                <div class="form-group">
                    <select name="txt" id="txt" style="display:compact" class="form-control">
                       <option value="si" <? if($row['txt']=='si'){?>selected <? } ?>>Si</option> 
                       <option value="no" <? if($row['txt']=='no'){?>selected <? } ?>>No</option>
                     </select>
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
                <input name="fecha_reg" type="hidden" id="fecha_reg" value="<? echo date ('Y-m-d G:i:s');?>" />
                <input name="activo" type="hidden" id="activo" value="si" /> 
             <? } ?>   
       </div>     
            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="	CargarAjax2_form('Admin/Sist.Administrador/AccionesRep/List/listado.php','form_edit_perso','cargaajax');
"><?=$acc_text?></button>
                         </div>
	</form>