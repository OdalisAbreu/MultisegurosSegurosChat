<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../../incluidos/conexion_inc.php");
	include('../../../../../incluidos/nombres.func.php');
	Conectarse();
	
	$r2 = mysql_query("SELECT * from seguro_costos WHERE id ='".$_GET['id']."' AND id_dist='".$_SESSION['user_id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		$acc	= $_GET['accion'];
		$acc_text = 'Registrar Costo';
	}else{
		$acc 	= 'Editar';
		$acc_text 	= 'Editar Costo';
	}
	
 ?>
 
<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> de <b><?=NombreSeguroS($_GET['costo_id'])?></b></h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información del costo del seguro de <b><?=NombreSeguroS($_GET['costo_id'])?></b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="info">
                                <p>
                                    <div class="row">
          <!--<div class="col-lg-12">
         <label class="strong">Nombre<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group ">
                                           
                                            <input type="text" class="form-control" placeholder="nombre" id="nombre" name="nombre" value="<? echo $row['nombre']; ?>">
                                        </div>
          </div>-->
          
          
          <div class="col-lg-4">
          <label class="strong">Costo (3 Meses)</label>
            <div class="form-group ">
               <input name="3meses" type="text" class="form-control" id="3meses" placeholder="precio a 3 meses" onKeyPress="ValidaSoloNumeros()" value="<?=$row['3meses']; ?>">
            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">Costo (6 Meses)</label>
            <div class="form-group ">
               <input name="6meses" type="text" class="form-control" id="6meses" placeholder="precio a 6 meses" onKeyPress="ValidaSoloNumeros()" value="<?=$row['6meses']; ?>">
            </div>
          </div>
          
           <div class="col-lg-4">
          <label class="strong">Costo (12 Meses)</label>
            <div class="form-group ">
               <input name="12meses" type="text" class="form-control" id="12meses" placeholder="precio a 12 meses" onKeyPress="ValidaSoloNumeros()" value="<?=$row['12meses']; ?>">
            </div>
          </div>
          
          
         <!-- <div class="col-lg-4">
          <label class="strong">DPA</label>
            <div class="form-group ">
               <input name="dpa" type="text" class="form-control" id="dpa" placeholder="dpa" onKeyPress="ValidaSoloNumeros()" value="<?=$row['dpa']; ?>">
            </div>
          </div>
          
           <div class="col-lg-4">
          <label class="strong">RC</label>
            <div class="form-group ">
               <input name="rc" type="text" class="form-control" id="rc" placeholder="rc" onKeyPress="ValidaSoloNumeros()" value="<?=$row['rc']; ?>">
            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">RC2</label>
            <div class="form-group ">
               <input name="rc2" type="text" class="form-control" id="rc2" placeholder="rc2" onKeyPress="ValidaSoloNumeros()" value="<?=$row['rc2']; ?>">
            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">FJ</label>
            <div class="form-group ">
               <input name="fj" type="text" class="form-control" id="fj" placeholder="fj" onKeyPress="ValidaSoloNumeros()" value="<?=$row['fj']; ?>">
            </div>
          </div>-->
          
          
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
                <input name="id_dist" type="hidden" id="id_dist" value="<? echo $_SESSION['user_id']; ?>" /> 
                
                <? if(!$_GET['id']){?>
                	<input name="registro" type="hidden" id="registro" value="<? echo date ('Y-m-d G:i:s');?>" /> 
                <? } ?>
                
       </div>     
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Seguros/Costos/List/listado.php?costo_id=<?=$_GET['costo_id']?>','form_edit_perso','cargaajax');"><?=$acc_text?></button>
                                            
                                       </div>
	</form>