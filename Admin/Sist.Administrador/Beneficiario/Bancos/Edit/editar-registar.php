<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from comisiones_bancos WHERE id ='".$_GET['id']."' AND id_benef ='".$_GET['idc']."' LIMIT 1");
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
 <script src="incluidos/js/AdmitirLetras.js"></script>
 <script src="incluidos/js/SoloNumeros.js"></script>


<form action="" method="post" enctype="multipart/form-data" id="form_edit_banc">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?>
     Vendedor</h4>
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
                        <div class="tab-content" style="padding-left: 10px;
    padding-right: 10px;">
                                <div class="tab-pane fade in active" id="info">
                                <p>
                                    <div class="row">
          <div class="col-lg-6">
         <label class="strong">Nombre Banco</label>
             <div class="form-group ">
                                           
                                            <input type="text" class="form-control" placeholder="nombre" id="nombre_banc" name="nombre_banc" value="<?=$row['nombre_banc']; ?>" onKeyPress="txNombres()">
                                        </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">No. <span class="label label-important" id="Nombres" style="display:none">*</span></label>
            <div class="form-group ">
                                            
                                            <input type="text" class="form-control" placeholder="No. Cuenta" id="cuenta_no" name="cuenta_no"  value="<?=$row['cuenta_no']; ?>" maxlength="13" onKeyPress="return soloNumeros(event)">
                                        </div>
          </div>
          
          
          
        </div>
                                </div>
                                
                                
                                
                               
                            </div>
                        <!-- /.panel-body -->
                    </div>
                   
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
              
                <!-- /.col-lg-6 -->
            </div>
        
    </div>

                <input name="accion" type="hidden" id="accion" value="<?=$acc;?>">
                <input name="id" type="hidden" id="id" value="<?=$row['id'];?>" />
                <input name="user_id" type="hidden" id="user_id" value="<?=$_SESSION['user_id']; ?>" />
             <? if(!$_GET['id']){?>
                <input name="fecha" type="hidden" id="fecha" value="<?=date('Y-m-d G:i:s');?>" /> 
                <input name="activo" type="hidden" id="activo" value="si" />
			<? } ?>
                
       </div>     
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Beneficiario/Bancos/List/listado.php?idc=<?=$_GET['idc']; ?>','form_edit_banc','cargaajax');"><?=$acc_text?></button>
                                            
           <!--CargarAjax2_form('Admin/Sist.Administrador/Personal/List/listado.php','form_edit_bene','cargaajax');-->                             </div>
	</form>
   