<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from  seguro_clientes WHERE id ='".$_GET['id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		
		$acc	= $_GET['accion'];
		$acc_text = 'Registrar';
		
	}else{
		
		$acc 	= 'Editar_Cliente';
		$acc_text 	= 'Editar';
	
	}
	
	
 
 ?>

 


<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?>
     datos del cliente #<?=$_GET['id']?></h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content">
                                <div class="tab-pane fade in active">
                                <p>
                                    <div class="row">
          <div class="col-lg-6">
         <label class="strong">Nombre</label>
             <div class="form-group ">
             	<input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre"  value="<?=$row['asegurado_nombres']?>">
             </div>
          </div>
          
         
          <div class="col-lg-6">
          <label class="strong">Apellidos </label>
            <div class="form-group ">
                  <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Apellidos"  value="<?=$row['asegurado_apellidos']?>">                         
            </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Cedula </label>
            <div class="form-group ">
                   <input name="cedula" type="text" class="form-control" id="cedula" placeholder="Cedula"  value="<?=$row['asegurado_cedula']?>"> 
             </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Direcci&oacute;n </label>
            <div class="form-group ">
               <input name="direccion" type="text" class="form-control" id="direccion" placeholder="Direccion"  value="<?=$row['asegurado_direccion']?>">
            </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Telefono </label>
            <div class="form-group ">
              <input name="tel" type="text" class="form-control" id="tel" placeholder="Telefono"  value="<?=$row['asegurado_telefono1']?>">
            </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Email </label>
            <div class="form-group ">
              <input name="email" type="text" class="form-control" id="email" placeholder="Email"  value="<?=$row['asegurado_email']?>">
            </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Ciudad </label>
            <div class="form-group ">
              <select name="ciudad" id="ciudad" class="form-control" style="display:compact">
                    <? ///  SELECCION DEL TIPO 
                    $resprov3 = mysql_query("
                        SELECT id, descrip, activo from ciudad WHERE activo ='si' order by descrip ASC");
                        while ($prov = mysql_fetch_array($resprov3)) {
                        $c 		= $prov['descrip'];
                        $c_id 	= $prov['id'];
                        if($c_id == $row['ciudad']){
                        echo "<option value=\"$c_id\" selected=\"selected\">$c
                        </option>"; 
                        }else{
                        echo "<option value=\"$c_id\" >$c</option>"; }
                } ?>
           </select>
            </div>
          </div>
        </div>
                                </div>
                                
                                
                                
                               
                            </div>
                   
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
              
                <!-- /.col-lg-6 -->
            </div>
        
    </div>

      <input name="accion" type="hidden" id="accion" value="<?=$acc;?>">
      <input name="id" type="hidden" id="id" value="<?=$row['id']; ?>" />
       </div>     
            <div class="modal-footer">
                <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Revisiones/Ticket/listado.php?aseg=<?=$_GET['aseg']?>&poliza=<?=$_GET['poliza']?>&consul=1','form_edit_perso','cargaajax');"><?=$acc_text?></button>
                                            
           <!--CargarAjax2_form('Admin/Sist.Administrador/Personal/List/listado.php','form_edit_perso','cargaajax');-->                             </div>
	</form>
   