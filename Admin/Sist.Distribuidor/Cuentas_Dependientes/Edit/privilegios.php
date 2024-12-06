<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	$r2 = mysql_query("SELECT * from personal WHERE id ='".$_GET['idClient']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	$nombres = $row['nombres'];
	
	
	$r3 = mysql_query("SELECT * from privilegios WHERE id_pers ='".$_GET['idClient']."' LIMIT 1");
    $row3 = mysql_fetch_array($r3);
	
	//echo "id_pers: ".$_GET['idClient'];
	if(!$row3['id_pers']){
		//echo '<b>NO tiene privilegios asignados</b>';
	$r3 = mysql_query("INSERT INTO  privilegios (

dist_id ,
id_pers ,
privilegios ,
fecha
)
VALUES (
  '".$_SESSION['user_id']."',  '".$_GET['idClient']."',  '',  '".date('Y-m-d G:i:s')."'
);");	
		
		
		
	}else{
		//echo 'tiene privilegios asignados';
	}
	
	if($_GET['id']){
		$title 	= 'Editar Privilegio';
	}else{
		$title 	= 'Registrar Privilegio';
	}

	
	$acc 	= 'editarpriv';
	//echo $acc;
	
	
	
 ?>

 <script language="JavaScript" type="text/javascript">
	
function Guardar(){
	
	 
	  
	if (HayError == true){
		
		if($('#dist_id').val().length < 1){
			alert("el campo nombre esta vacio, por favor digitar nombre");
			var HayError = true;
		}else { 
			//$('#errornombre').fadeOut('3'); 
		}
	
	
	} else {
		
		
	
	  
	$('#acep').fadeOut(0);
	$('#cancel').fadeOut(0);
	$('#env').fadeIn(0);
	
	Dvf = document.getElementById("Dvf").value;
	
		if(Dvf =='p'){
			CargarAjax2_form('Admin/Sist.Administrador/Personal/List/listado.php?idClient=<?=$_GET['id']?>','form_priv','cargaajax');
		}else if(Dvf =='b'){
			CargarAjax2_form('Admin/Sist.Administrador/Beneficiario/List/listado.php?idClient=<?=$_GET['id']?>','form_priv','cargaajax');
		}else if(Dvf =='s'){
			CargarAjax2_form('Admin/Sist.Ingenieria/Auditoria/Datos_Clientes.php?func_id=<?=$_GET['func_id']?>&est_id=<?=$_GET['est_id']?>&consul=1&idClient=<?=$_GET['id']?>','form_priv','cargaajax');
		}
	}

}


</script>
<form action="" method="post" enctype="multipart/form-data" id="form_priv">
<!-- Modal heading -->
	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$title?> de <b style="color:#9F1518"><?=$nombres?></b></h4>
</div>
	<!-- // Modal heading END -->


    <!-- Modal body -->
	<div class="modal-body">
    <div class="wizard">
		<div class="widget widget-tabs widget-tabs-double" style="margin-bottom: -25px; margin-top:-10px">
			
			<div class="widget-body">
				<div class="tab-content">
				
					<!-- Step 1 -->
					<div class="tab-pane active" id="tab1-2">
						<div class="row-fluid">
                        
<div class="row-fluid">
   <div class="span12">

 <?
	$query=mysql_query("
	SELECT * FROM privilegios_funciones WHERE activo ='si' ORDER BY id ASC ");
	while($priv=mysql_fetch_array($query)){
?>

<div style="width:165px; float:left; border:solid 1px #E6E6E6; padding:5px;">
       
        <?
	 
	 echo '<input name="privilegio[]" type="checkbox" value="'.$priv['id'].'"  style="margin-bottom: 5px;
    margin-right: 5px;"';
	 
	     if(substr_count($row3['privilegios'],"[".$priv['id']."]")>0){
			 echo' checked="checked"';
	 	}
	 echo  '>'.$priv['descripcion'].'';
	?>
</div>

<? } ?>
    
       
   </div>
</div>

                                    </div>
					</div>
			</div>
		</div>
	</div>
  		<input name="accion" type="hidden" id="accion" value="<?=$acc?>">
	    <input name="id" type="hidden" id="id" value="<?=$row['id']?>" />
 <? if(!$_GET['id']){?>
         <input name="dist_id" type="hidden" id="dist_id" value="<?=$_SESSION['user_id']?>" />
        <input name="fecha" type="hidden" id="fecha" value="<?=date('Y-m-d G:i:s')?>" />
   <? } ?>	
    	<input name="Dvf" type="hidden" id="Dvf" value="<?=$_GET['list']?>" />
        <input name="id_pers" type="hidden" id="id_pers" value="<?=$_GET['idClient']?>" />
   
   </div>
	<!-- // Modal body END -->
</div>
<!-- // Modal END -->	
</form>

	<!-- Modal footer -->
    
	<div class="modal-footer">
		<a href="#" class="btn btn-danger" data-dismiss="modal" id="cancel">Cancelar</a>
		<a href="#" class="btn btn-primary" onClick="Guardar()" id="acep">Guardar</a>
        <font id="env" style="display:none; font-size:14px; margin-right:10px;"><strong>Enviando...</strong></font>
	</div>
	