<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from agencia_via WHERE id ='".$_GET['id']."'");
    $row = mysql_fetch_array($r2);
	
	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		$acc	= $_GET['accion'];
		$acc_text = 'Registrar';
	}else{
		$acc 	= 'Editar';
		$acc_text 	= 'Editar';
	}
	
	
	
 //echo $_POST['seguro_porc2'];
 ?>
 

 <script language="JavaScript" type="text/javascript">
	
	

	function validar_password() {
		
		// validar  nombre
		if($('#razon_social').val().length < 6){
			$("#razon_social").css("border","solid 1px #F00");
			var HayError = true;
		}else { 
			$("#razon_social").css("border","solid 1px #ccc"); 
		}
	
		if (HayError == true){
			//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
		} else {
		
		CargarAjax2_form('Admin/Sist.Distribuidor/Agencia/List/listado.php','form_edit_perso','cargaajax');
		
		}
	
}


</script>

<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?>
    <span class="page-header">Agencia</span></h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información de la agencia
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
         <label class="strong">Codigo Interno</label> 
             <div class="form-group ">
              <input type="text" class="form-control" placeholder="Codigo Interno" id="num_agencia" name="num_agencia" value="<?=$row['num_agencia']?>">
              </div>
          </div>
          <div class="col-lg-6">
         <label class="strong">Supervisor</label> 
             <div class="form-group ">
              <select name="id_supervisor" id="id_supervisor" style="display:compact" class="form-control">
                        <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT * from supervisor WHERE user_id='".$_SESSION['user_id']."' order by nombre ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$c2 = $cat2['nombre'];
			$c_id = $cat2['id'];
			
            
			if($row['id_supervisor'] == $c_id){
			echo "<option value=\"$c_id\"  selected>$c2</option>";
			}else{
			echo "<option value=\"$c_id\" >$c2</option>"; }
			 
        } ?> 
                        </select>
              </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Nombre</label> 
             <div class="form-group ">
              <input type="text" class="form-control" placeholder="nombre" id="razon_social" name="razon_social" value="<?=$row['razon_social']?>">
              </div>
          </div>
          <!--<div class="col-lg-6">
          <label class="strong">Ruta </label>
            <div class="form-group ">
              <input type="text" class="form-control" placeholder="ruta" id="ejecutivo" name="ejecutivo"  value="<?=$row['ejecutivo']?>" >
                                        </div>
          </div>-->
          <div class="col-lg-6">
          <label class="strong">Direcci&oacute;n</label>
            <div class="form-group ">
             <input name="calle" type="text" class="form-control" id="calle" placeholder="Direccion" value="<?=$row['calle']?>" >
                                        </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Telefono</label>
            <div class="form-group ">
             <input name="telefono" type="text" class="form-control" id="telefono" placeholder="Telefono" value="<?=$row['telefono']?>" >
                                        </div>
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
                <input name="id" type="hidden" id="id" value="<?=$row['id']?>" />
               
             <? if(!$_GET['id']){?>   
                <input name="fecha" type="hidden" id="fecha" value="<?=date('Y-m-d G:i:s')?>" /> 
                <input name="activo" type="hidden" id="activo" value="si" />
                 <input name="user_id" type="hidden" id="user_id" value="<?=$_SESSION['user_id']?>" /> 
              <? } ?>  
               
                
       </div>     
            <div class="modal-footer">
             <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
             <button name="acep" type="button" id="acep" class="btn btn-success" onClick="validar_password();"><?=$acc_text?></button>
                                            
           <!--CargarAjax2_form('Admin/Sist.Administrador/Personal/List/listado.php','form_edit_perso','cargaajax');-->                             </div>
	</form>
    