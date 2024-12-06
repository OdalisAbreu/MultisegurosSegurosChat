<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	$r2 = mysql_query("SELECT * from servicios WHERE id ='".$_GET['id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	$res = mysql_query("SELECT * from seguro_tarifas");
    $eqres = mysql_fetch_array($res);
	
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
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?> Servicio</h4>
</div>


	<div class="panel-body"> 
    <div class="row" style="margin-top: -5px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información del servicio adicional
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            

<!-- Tab panes -->
<div class="tab-content"  style="overflow-y: scroll; height:350px">
    <div class="tab-pane fade in active" id="info">
    <p>
        <div class="row">
          <div class="col-lg-6">
         <label class="strong">Nombre<span class="label label-important" id="Nombres" style="display:none">*</span></label>
             <div class="form-group ">
                                           
                                            <input type="text" class="form-control" placeholder="nombre" id="nombre" name="nombre" value="<? echo $row['nombre']; ?>">
                                        </div>
          </div>
          <div class="col-lg-6">
         <label class="strong">Suplidor</label>
             <div class="form-group">
                                        
   <select name="id_suplid" id="id_suplid" style="display:compact" class="form-control">
                        <option value="" selected>Seleccionar suplidor</option>
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
          <div class="col-lg-4">
          <label class="strong">Precio (3 Meses)</label>
            <div class="form-group ">
               <input name="3meses" type="text" class="form-control" id="3meses" placeholder="precio a 3 meses" value="<?=$row['3meses']; ?>">
            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">Precio (6 Meses)</label>
            <div class="form-group ">
               <input name="6meses" type="text" class="form-control" id="6meses" placeholder="precio a 6 meses"  value="<?=$row['6meses']; ?>">
            </div>
          </div>
          
           <div class="col-lg-4">
          <label class="strong">Precio (12 Meses)</label>
            <div class="form-group ">
               <input name="12meses" type="text" class="form-control" id="12meses" placeholder="precio a 12 meses" value="<?=$row['12meses']; ?>">
            </div>
          </div>
          
          
</div>


<!--COSTOS-->
<div class="row">
          <div class="col-lg-4">
          <label class="strong">Costos (3 Meses)</label>
            <div class="form-group ">
               <input name="3meses_costos" type="text" class="form-control" id="3meses_costos" placeholder="costos a 3 meses"  value="<?=$row['3meses_costos']; ?>">
            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">Costos (6 Meses)</label>
            <div class="form-group ">
               <input name="6meses_costos" type="text" class="form-control" id="6meses_costos" placeholder="costos a 6 meses"  value="<?=$row['6meses_costos']; ?>">
            </div>
          </div>
          
           <div class="col-lg-4">
          <label class="strong">Costos (12 Meses)</label>
            <div class="form-group ">
               <input name="12meses_costos" type="text" class="form-control" id="12meses_costos" placeholder="costos a 12 meses"  value="<?=$row['12meses_costos']; ?>">
            </div>
          </div>
          
          
</div>
<!--COSTOS-->


<hr>
<div class="row">
        
        <div class="col-lg-6">
         <label class="strong">Aumentar prima (s/n)</label>
            
<div class="form-group">
               <select name="sumar" id="sumar" style="display:compact" class="form-control">
                 <option value="n" <? if($row['sumar']=='n'){?>selected <? } ?>>NO</option>
			     <option value="s" <? if($row['sumar']=='s'){?>selected <? } ?>>SI</option>
			   </select>
			</div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Cobertura (s/n)</label>
            
<div class="form-group">
               <select name="cambiar" id="cambiar" style="display:compact" class="form-control">
                 <option value="n" <? if($row['cambiar']=='n'){?>selected <? } ?>>NO</option>
			     <option value="s" <? if($row['cambiar']=='s'){?>selected <? } ?>>SI</option>
			   </select>
			</div>
          </div>
        </div>
        
        <!--mostrar las coberturas o no-->
    <div class="row" id="coberturas" style="background-color: aliceblue;
    padding-top: 7px; margin-bottom: -15px; ">
          <div class="col-lg-4">
          <label class="strong">DPA</label>
            <div class="form-group ">
               <input name="dpa" type="text" class="form-control" id="dpa" placeholder="DPA" onKeyPress="ValidaSoloNumeros()" value="<?=$row['dpa']?>">
            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">RC</label>
            <div class="form-group ">
               <input name="rc" type="text" class="form-control" id="rc" placeholder="RC" onKeyPress="ValidaSoloNumeros()" value="<?=$row['rc']?>">
            </div>
          </div>
          
           <div class="col-lg-4">
          <label class="strong">RC2</label>
            <div class="form-group ">
               <input name="rc2" type="text" class="form-control" id="rc2" placeholder="RC2" onKeyPress="ValidaSoloNumeros()" value="<?=$row['rc2']?>">
            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">AP</label>
            <div class="form-group ">
               <input name="ap" type="text" class="form-control" id="ap" placeholder="AP" onKeyPress="ValidaSoloNumeros()" value="<?=$row['ap']?>">
            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">FJ</label>
            <div class="form-group ">
               <input name="fj" type="text" class="form-control" id="fj" placeholder="FJ" onKeyPress="ValidaSoloNumeros()" value="<?=$row['fj']?>">
            </div>
          </div>
          
</div>  

<hr>

	<div class="row">
          <div class="col-lg-12">
         <label class="strong">Prefijo</label>
            
<div class="form-group">
               <select name="mod_pref" id="mod_pref" style="display:compact" class="form-control">
                 <option value="n" <? if($row['mod_pref']=='n'){?>selected <? } ?>>NO</option>
			     <option value="s" <? if($row['mod_pref']=='s'){?>selected <? } ?>>SI</option>
			   </select>
			</div>
           
           
            
  <div class="col-lg-12" id="listaprefijo">
  <!--aqui va el desglose de las aseguradoras -->         
     
     
     <div class="row">
       
        <? ///  SELECCION DEL TIPO .....................................
$seg2 = mysql_query("SELECT id, nombre from seguros WHERE activo ='si' order by nombre ASC");
    while ($seg = mysql_fetch_array($seg2)) {?>
        
        <div class="col-lg-6">
		   <div class="form-group">
               <label class="strong"><?=$seg['id']?> - <?=$seg['nombre']?></label>
			</div>
          </div>
          
          <div class="col-lg-6">
		   <div class="form-group">
               <input type="text" class="form-control" placeholder="prefijo" id="prefijo<?=$seg['id']?>" name="prefijo<?=$seg['id']?>" value="<?=$row['prefijo'.$seg['id'].'']?>">
			</div>
          </div>
        <? } ?>  
          
          
   </div>        
         
   </div>         
            
  <!--aqui va el desglose de las aseguradoras -->          
  </div>
        
   </div>

<hr>


<script>
 $("#cambiar").change(function(){ 
	var id = $(this).val();
	
	if(id =='n'){
		$("#coberturas").fadeOut(0);
	}
	
	else if(id =='s'){
	$("#coberturas").fadeIn(0);
	}
	
	
});
 
 
 $("#mod_pref").change(function(){ 
	var id = $(this).val();
	
	if(id =='n'){
		$("#listaprefijo").fadeOut(0);
	}
	
	else if(id =='s'){
	$("#listaprefijo").fadeIn(0);
	}
	
	
});
 
 <? if($row['cambiar']=='n'){?>
	$("#coberturas").fadeOut(0);
<? }?>

 <? if($row['cambiar']=='s'){?>
	$("#coberturas").fadeIn(0);
<? }?>


 <? if($row['mod_pref']=='n'){?>
	$("#listaprefijo").fadeOut(0);
<? }?>

 <? if($row['mod_pref']=='s'){?>
	$("#listaprefijo").fadeIn(0);
<? }?>
 </script>              
   <!--mostrar las coberturas o no--> 
   
   
   
   <!--mostrar las tarifas-->
   <div id="row">
   <div class="col-lg-12">
          <label class="strong">Tipos de vehiculos</label>
            <div class="form-group ">
   <? 

	$rescat = mysql_query("SELECT id, nombre, id_serv from seguro_tarifas WHERE activo ='si' order by nombre");
    while ($eq = mysql_fetch_array($rescat)) { 
	
	$nombre = ucfirst(strtolower($eq['nombre'])); 
	
 	if($num_colum == 0) {}
	 if($b==0){
	}
	 
	 echo '<div class="col-lg-6">
	 <input  name="equipamientos[]" type="checkbox"  value="'.$eq['id'].'" ';
	 
	 if( $_GET['accion'] == 'registrar'){
	 	 echo' checked="checked"';
	 }else{
			  if(substr_count($eq['id_serv'],"".$row['id']."-")>0){
			 echo' checked="checked"';
	 	}
	 }
	 echo  ' /><font face="Georgia, Times New Roman, Times, serif" style="font-size: small;"> '.$nombre.'</font></div>';
	 
     if($b==1){  
	 	$b=0; 
	}else{ 
		$b = $b+1; 
	} 
}
	?>
           
   </div> 
   <!--mostrar las tarifas-->  
   
                
                </div>
            </div>
          </div>
        </div>
       <div id="erroruser" style="font-size:12px; color:#F00; display:none;">-Error: este usuario ya existe en nuestra base de datos.</div>
    </div>
  </div>
 </div>

                <input name="accion" type="hidden" id="accion" value="<? echo $acc;?>">
                <input name="id" type="hidden" id="id" value="<? echo $row['id']; ?>" />
               
                <input name="fecha" type="hidden" id="fecha" value="<? echo date ('Y-m-d G:i:s');?>" /> 
               <input name="id_dist" type="hidden" id="id_dist" value="<? echo $_SESSION['user_id']; ?>" /> 
               <input name="activo" type="hidden" id="activo" value="si" /> 
       </div>     
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Servicios/List/listado.php','form_edit_perso','cargaajax');"><?=$acc_text?></button>
                                            
                                       </div>
                                       </div>
	</form>