<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from supervisor WHERE id ='".$_GET['id']."' AND user_id ='".$_SESSION['user_id']."'");
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



 <script language="JavaScript" type="text/javascript">
	
	function DivGuiones(key){
	
	v = $('#celular').val();
	if(v.length == '3' && key !='8'){
		$('#celular').val(v+'-');
	}
	
	if(v.length == '7' && key !='8'){
		$('#celular').val(v+'-');
	}
	

}
	
		$('#celular').keyup(function(event){
		key = event.which;
		DivGuiones(key);
	});
	
	
	
	
	



function Registrar() {
		
		
	// validar  nombre
	if($('#nombre').val().length < 3){
		$("#nombre").css("border","solid 1px #F00");
		var HayError = true;
	}else { 
		$("#nombre").css("border","solid 1px #ccc"); 
	}
	
	// validar  nombre
	/*if($('#nombre_ruta').val().length < 2){
		$("#nombre_ruta").css("border","solid 1px #F00");
		var HayError = true;
	}else { 
		$("#nombre_ruta").css("border","solid 1px #ccc"); 
	}*/
	
	
	if (HayError == true){
		//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
	} else {
	
	CargarAjax2_form('Admin/Sist.Distribuidor/Supervisor/List/listado.php','form_edit_perso','cargaajax');
	
	}
	
}


</script>

<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?>
    <span class="page-header">Supervisor</span></h4>
</div>

<div class="modal-body">



<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Información personal
                </div>

                <div class="panel-body">

<div class="tab-content">
    <div class="tab-pane fade in active" id="info">
    <p>
        <div class="row">
          <div class="col-lg-12">
         <label class="strong">Nombre</label> 
             <div class="form-group ">
                 <input type="text" class="form-control" placeholder="nombre" id="nombre" name="nombre" value="<?=$row['nombre']?>">
             </div>
          </div>
          <div class="col-lg-12">
          <label class="strong">Nombre de la ruta</label>
            <div class="form-group ">
              <input type="text" class="form-control" placeholder="Nombre de la ruta" id="nombre_ruta" name="nombre_ruta"  value="<?=$row['nombre_ruta']?>">
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
                <input name="user_id" type="hidden" id="user_id" value="<?=$_SESSION['user_id']?>" /> 
             <? if(!$_GET['id']){?>   
                <input name="fecha_reg" type="hidden" id="fecha_reg" value="<?=date('Y-m-d G:i:s')?>" />
                 <input name="activo" type="hidden" id="activo" value="si" />
              <? } ?>  
               
                
       </div>     
            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="Registrar();"><?=$acc_text?></button>
                                            
           <!--CargarAjax2_form('Admin/Sist.Administrador/Personal/List/listado.php','form_edit_perso','cargaajax');-->                             </div>
	</form>
    