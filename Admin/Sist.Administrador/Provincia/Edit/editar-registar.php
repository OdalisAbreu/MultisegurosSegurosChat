<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	$r2 = mysql_query("SELECT * from provincia 
	WHERE id ='".$_GET['id']."' AND id_dist = '".$_SESSION['user_id']."' LIMIT 1");
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
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Provincia</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información de la Provincia
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="info">
                                <p>
          <div class="row">
        
          <div class="col-lg-6">
          <label class="strong">Nombre</label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="Descripcion" id="descrip" name="descrip"  value="<?=$row['descrip']?>" >
                                        </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Codigo</label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="Descripcion" id="cod" name="cod"  value="<?=$row['cod']?>" >
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
                <input name="id" type="hidden" id="id" value="<?=$row['id']; ?>" />
                <? if(!$_GET['id']){?>
                   <input name="id_dist" type="hidden" id="id_dist" value="<?=$_SESSION['user_id']; ?>" /> 
                   <input name="fecha" type="hidden" id="fecha" value="<?=date('Y-m-d G:i:s');?>" />
                   <input name="activo" type="hidden" id="activo" value="si" />
                <? } ?> 
                
       </div>     
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Provincia/List/listado.php','form_edit_perso','cargaajax');"><?=$acc_text?></button>
                                            
                                       </div>
	</form>