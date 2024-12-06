<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR UN NUEVO MODELO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../../incluidos/conexion_inc.php");
    include('../../../../../controller/VehiculoController.php');
	include('../../../../../incluidos/nombres.func.php');
	
    Conectarse();
    $vehiculo = new vehiculoController;
    $row = $vehiculo->getModelo($_GET['id']);
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
        <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Modelo de la marca <?=Marcas($_GET['idmarca'])?></h4>
    </div>

    <div class="modal-body">

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información del Modelo
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
                                            <label class="strong">Nombre <span class="label label-important"
                                                    id="Nombres" style="display:none">*</span></label>
                                            <div class="form-group ">

                                                <input type="text" class="form-control" placeholder="Descripcion"
                                                    id="descripcion" name="descripcion"
                                                    value="<?=$row['descripcion']?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="strong">Codigo <span class="label label-important"
                                                    id="Nombres" style="display:none">*</span></label>
                                            <div class="form-group ">

                                                <input type="text" class="form-control" placeholder="codigo"
                                                    id="cod_modelo" name="cod_modelo" value="<?=$row['cod_modelo']?>">
                                            </div>
                                        </div>
                                        <div id="row">
                                            <div class="col-lg-12">
                                                <label class="strong">Tipos de vehiculos</label>
                                                <div class="form-group ">
                                                    <? 

                                                     $modelId = $_GET['id'];
                                                     $rescat = mysql_query("SELECT id, nombre, veh_tipo from seguro_tarifas WHERE activo ='si' order by nombre");
                                                     $result = mysql_query("SELECT * FROM seguro_modelos where id = $modelId");
                                                      
                                                  while($modelType =  mysql_fetch_array($result)){
                                                      $tipos = $modelType['tipo'];
                                                    } 
                                                     while ($eq = mysql_fetch_array($rescat)) { 
                                                                
                                                                $nombre = ucfirst(strtolower($eq['nombre'])); 

                                                                echo '<div class="col-lg-6">
                                                                <input  name="tipo'.$eq['veh_tipo'].'" type="checkbox"  value="'.$eq['veh_tipo'].'" ';
                                                                          
                                                                if( $_GET['accion'] == 'registrar'){
                                                                    echo' checked=""';
                                                               }else{
                                                                   $value = intval($eq['veh_tipo']) + 100;
                                                                        if(substr_count($tipos,"".$value."-")>0){
                                                                       echo' checked="checked"';
                                                                   }
                                                               }

                                                                echo  ' /><font face="Georgia, Times New Roman, Times, serif" style="font-size: small;"> '.$nombre.'</font></div>';
                                                                
                                                            }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input name="accion" type="hidden" id="accion" value="<?=$acc?>">
                    <input name="id" type="hidden" id="id" value="<?=$row['ID']?>" />

                    <? if(!$_GET['id']){?>
                    <input name="id_dist" type="hidden" id="id_dist" value="<?=$_SESSION['user_id']?>" />
                    <input name="fecha" type="hidden" id="fecha" value="<?=date('Y-m-d G:i:s')?>" />
                    <input name="activo" type="hidden" id="activo" value="si" />
                    <input name="IDMARCA" type="hidden" id="IDMARCA" value="<?=$_GET['idmarca']?>" />
                    <? } ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button name="acep" type="button" id="acep" class="btn btn-success"
                        onClick="CargarAjax2_form('Admin/Sist.Administrador/Marcas/Modelos/List/listado.php?pagina=<?=$_GET['pagina']?>&idmarca=<?=$_GET['idmarca']?>','form_edit_perso','cargaajax');"><?=$acc_text?></button>

                </div>
</form>