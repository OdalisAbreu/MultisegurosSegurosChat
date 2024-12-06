<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	$r2 = mysql_query("SELECT * from seguros WHERE id ='".$_GET['id']."' LIMIT 1");
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
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Seguro</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información del Seguro adicional
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
         <label class="strong">Nombre<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group ">
               <input type="text" class="form-control" placeholder="nombre" id="nombre" name="nombre" value="<?=$row['nombre']; ?>">
              </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Prefijo<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group ">
               <input type="text" class="form-control" placeholder="Prefijo" id="prefijo" name="prefijo" value="<?=$row['prefijo']; ?>">
              </div>
          </div>
          
          
          
  					</div>
                    
                    
                    <div class="row">
          <div class="col-lg-12">
         <label class="strong">Suplidor</label>
             <div class="form-group">
                                        
                            
                     
                            <select name="id_suplid" id="id_suplid" style="display:compact" class="form-control">
                        
                        <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT id, nombre from suplidores WHERE activo ='si' order by nombre ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$c2 = $cat2['nombre'];
			$c_id2 = $cat2['id'];
            
			if($row['id_suplid']==$c_id2){
				echo "<option value=\"$c_id2\" selected>$c_id2 - $c2</option>";
			}else{
				echo "<option value=\"$c_id2\" >$c_id2 - $c2</option>";
			}
        } 
		?> 
                        </select>

								  </div>
          </div>
          
          
          
  					</div>
                    <div class="row">
          <div class="col-lg-6">
         <label class="strong">Logo a Color</label>
             <div class="form-group ">
               <input type="text" class="form-control" placeholder="Logo Color" id="logo_color" name="logo_color" value="<?=$row['logo_color']; ?>">
              </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Logo Monocolor</label>
             <div class="form-group ">
               <input type="text" class="form-control" placeholder="Logo Monocolor" id="logo_mono" name="logo_mono" value="<?=$row['logo_mono']; ?>">
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
                <input name="id_dist" type="hidden" id="id_dist" value="<?=$_SESSION['user_id']?>" /> 
                <input name="fecha" type="hidden" id="fecha" value="<?=date('Y-m-d G:i:s')?>" />
				<input name="activo" type="hidden" id="activo" value="si" />
                <? } ?>                
       </div>     
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Seguros/List/listado.php','form_edit_perso','cargaajax');"><?=$acc_text?></button>
                                            
                                       </div>
	</form>