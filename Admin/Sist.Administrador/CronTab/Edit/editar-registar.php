<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from crontab WHERE id ='".$_GET['id']."' LIMIT 1");
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
                            Información de la configuraci&oacute;n del servicio automatizado
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="info">
                                <p>
                                    <div class="row">
          <div class="col-lg-12">
         <label class="strong">Nombre del servicio</label>
             <div class="form-group ">
              <input type="text" class="form-control" placeholder="nombre" id="nombre" name="nombre" value="<?=$row['nombre']?>">
              </div>
          </div>
          
          <div class="col-lg-12">
         <label class="strong">Peticion del servicio</label>
             <div class="form-group ">
              <input type="text" class="form-control" placeholder="Peticion" id="peticion" name="peticion" value="<?=$row['peticion']?>">
              </div>
          </div>
          
          
          <div class="col-lg-6">
              <label class="strong">Dia</label>
                <div class="form-group">
                    <select name="dia" id="dia" style="display:compact" class="form-control">
                       <option value="Daily" <? if($row['dia']=='Daily'){?>selected <? } ?>>Diario</option> 
                       <option value="Monday" <? if($row['dia']=='Monday'){?>selected <? } ?>>Lunes</option>
                       <option value="Tuesday" <? if($row['dia']=='Tuesday'){?>selected <? } ?>>Marte</option> 
                       <option value="Wednesday" <? if($row['dia']=='Wednesday'){?>selected <? } ?>>Miercoles</option>
                       <option value="Thursday" <? if($row['dia']=='Thursday'){?>selected <? } ?>>Jueves</option> 
                       <option value="Friday" <? if($row['dia']=='Friday'){?>selected <? } ?>>Viernes</option>
                       <option value="Saturday" <? if($row['dia']=='Saturday'){?>selected <? } ?>>Sabado</option> 
                       <option value="Sunday" <? if($row['dia']=='Sunday'){?>selected <? } ?>>Domingo</option>
                     </select>
                </div>
          </div>
          
          <div class="col-lg-6">
              <label class="strong">Hora</label>
                <div class="form-group">
                   <input type="text" class="form-control" placeholder="Hora" id="hora" name="hora" value="<?=$row['hora']?>">
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
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="	CargarAjax2_form('Admin/Sist.Administrador/CronTab/List/listado.php','form_edit_perso','cargaajax');
"><?=$acc_text?></button>
                         </div>
	</form>