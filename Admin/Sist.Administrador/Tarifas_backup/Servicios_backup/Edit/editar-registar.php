<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../../incluidos/conexion_inc.php");
	include('../../../../../incluidos/nombres.func.php');
	Conectarse();
	
	$r2 = mysql_query("SELECT * from servicios_backup WHERE id ='".$_GET['id']."' LIMIT 1");
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
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> servicio de la tarifa <?=NombreTarifasS($_GET['idtarif'])?> BACKUP</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información del servicio
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
          <label class="strong">Nombre <span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="Nombre" id="nombre	" name="nombre"  value="<?=$row['nombre']; ?>" >
                                        </div>
          </div>
          
          <div class="col-lg-6">
          <label class="strong">Descripci&oacute;n <span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="Descripcion" id="descripcion" name="descripcion"  value="<?=$row['descripcion']; ?>" >
                                        </div>
          </div>
          
           <div class="col-lg-4">
          <label class="strong">3 meses <span class="label label-important" id="3meses" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="precio 3 meses" id="3meses" name="3meses"  value="<? echo $row['3meses']; ?>" >
                                        </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">6 meses <span class="label label-important" id="6meses" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="precio 6 meses" id="6meses" name="6meses"  value="<? echo $row['6meses']; ?>" >
                                        </div>
          </div>
          
           <div class="col-lg-4">
          <label class="strong">12 meses <span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="precio 12 meses" id="12meses" name="12meses"  value="<? echo $row['12meses']; ?>" >
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

                <input name="accion" type="hidden" id="accion" value="<?=$acc?>">
                <input name="id" type="hidden" id="id" value="<?=$row['id']?>" />
                <input name="idtarif" type="hidden" id="idtarif" value="<?=$_GET['idtarif']?>" />
                <? if(!$_GET['id']){?>
                   <input name="id_dist" type="hidden" id="id_dist" value="<? echo $_SESSION['user_id']; ?>" /> 
                   <input name="fecha" type="hidden" id="fecha" value="<? echo date ('Y-m-d G:i:s');?>" />
                <? } ?> 
       </div>     
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Tarifas_backup/Servicios_backup/List/listado.php?idtarif=<?=$_GET['idtarif']?>','form_edit_perso','cargaajax');"><?=$acc_text?></button>
                                            
                                       </div>
	</form>