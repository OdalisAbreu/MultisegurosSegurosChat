<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	//$_GET['id'] =LimpiarCampos($_GET['id']);
	$r2 = mysql_query("SELECT * from  seguro_vehiculo WHERE id ='".$_GET['id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		
		$acc	= $_GET['accion'];
		$acc_text = 'Registrar';
		
	}else{
		
		$acc 	= 'Editar_Vehiculo';
		$acc_text 	= 'Editar';
	
	}
	
	
 
 ?>

 


<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?>
     datos del vehiculo #<?=$_GET['id']?></h4>
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
         <label class="strong">Marca</label>
             <div class="form-group ">
                                           
                                            <select name="marca" id="marca" style="display:compact" class="form-control">
                        <? ///  SELECCION DEL TIPO .....................................
$rescat = mysql_query("SELECT ID, DESCRIPCION from seguro_marcas order by DESCRIPCION ASC");
    while ($cat = mysql_fetch_array($rescat)) {
			$c = $cat['DESCRIPCION'];
			$c_id = $cat['ID'];
            if($row['veh_marca'] == $c_id){
			echo "<option value=\"$c_id\"  selected>$c</option>";
			}else{
			echo "<option value=\"$c_id\" >$c</option>"; }
        } ?> 
                        </select>
                                        </div>
          </div>
          
          <script>
    $("#marca").change(
    
        function(){
            id = $(this).val();
            CargarAjax2('Admin/Sist.Sucursal/Seguro/Vehiculos/AJAX/Modelos.php?marca_id='+id+'','','GET','modelo');
        }); 
              
    </script>
          <div class="col-lg-6">
          <label class="strong">Modelo </label>
            <div class="form-group ">
                  <? if($row['veh_modelo']){
												echo"
												<script>
												CargarAjax2('Admin/Sist.Sucursal/Seguro/Vehiculos/AJAX/Modelos.php?marca_id=".$row['veh_marca']."&selec=".$row['veh_modelo']."','','GET','modelo');
												
												</script>
												";
										}?>
                                        
                      <div id="modelo" disabled="disabled"  style="margin-left:-15px;"> 
                        <select name="modelo" id="modelo" style="display:compact" disabled="disabled" class="form-control">
                          
                        </select>
            </div>                          
            </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Año </label>
            <div class="form-group ">
                  <select name="year" id="year" class="form-control">
<? 
	$yaerAct  = date('Y');  //2016
	$year 	= '50';		 //100
	$Total 	= $yaerAct - $year; // 2016 - 100 = 1916
	for ( $i = $yaerAct ; $i >= $Total ; $i --) {
		
		if($row['veh_ano']==$i){
?>
    <option value="<?=$i?>" selected="selected" ><?=$i?></option>
<? }else{ ?>
 <option value="<?=$i?>"><?=$i?></option>
        <? } } ?>                  
</select>               
             </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Chassis </label>
            <div class="form-group ">
               <input name="chassis" type="text" class="form-control" id="chassis" placeholder="Chassis"  value="<?=$row['veh_chassis']?>">
            </div>
          </div>
          <div class="col-lg-6">
          <label class="strong">Placa </label>
            <div class="form-group ">
              <input name="placa" type="text" class="form-control" id="placa" placeholder="Placa"  value="<?=$row['veh_matricula']?>">
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
   