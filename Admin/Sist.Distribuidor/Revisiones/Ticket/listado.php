<?
	session_start();
	ini_set('display_errors',1);
	
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	include('../../../../incluidos/bd_manejos.php');

	Conectarse();
	
	if($_GET['aseg']){
		$aseg = "id_aseg ='".$_GET['aseg']."' ";
	}
	
	if($_GET['poliza']){
		$poliza = "AND id_poliza ='".$_GET['poliza']."' ";
		$pol = $_GET['poliza'];
	}
	
	/*function FechaListPDFn($id){
	   $clear1 = explode(' ',$id);  
	   $fecha_vigente1 = explode('-',$clear1[0]); 
	   return  $fecha_vigente1[2].'-'.$fecha_vigente1[1].'-'.$fecha_vigente1[0];
}
*/

	// DETERMINAR SI ES GET O POST
	 $acc1 = $_POST['accion'].$_GET['action'];
	 
	 //print_r($_POST);
	 
	 if($acc1=='Editar_Vehiculo'){
		$query=mysql_query("UPDATE seguro_vehiculo SET veh_marca ='".$_POST['marca']."',veh_modelo ='".$_POST['modelo']."',veh_ano ='".$_POST['year']."',veh_chassis ='".$_POST['chassis']."',veh_matricula ='".$_POST['placa']."' WHERE id='".$_POST['id']."' LIMIT 1");
		
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
	
	if($acc1=='Editar_Cliente'){
		$query=mysql_query("UPDATE seguro_clientes SET asegurado_nombres ='".$_POST['nombre']."',asegurado_apellidos ='".$_POST['apellido']."',asegurado_cedula ='".$_POST['cedula']."',asegurado_direccion ='".$_POST['direccion']."',asegurado_telefono1 ='".$_POST['tel']."',asegurado_email ='".$_POST['email']."',ciudad ='".$_POST['ciudad']."' WHERE id='".$_POST['id']."' LIMIT 1");
		
		
		echo'<script>$("#myModal").modal("hide"); $("#actul").fadeIn(0); $("#actul").fadeOut(10000);</script> ';
	}
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Modificar poliza vendida </h3>
    </div>
</div>

		
    
    
    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
    <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                    	<td>
                         
                        <label>Aseguradora:</label>
                      
          <select  class="form-control" id="aseg" name="aseg" style="width: 180px; display: inline;">
  <? 
  
  ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT * from seguros  order by nombre ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$c2 = $cat2['nombre'];
			$c_id2 = $cat2['id'];
            
			if($_GET['aseg']==$c_id2){
				echo "<option value=\"$c_id2\" selected>$c2</option>"; 
			}else{
				echo "<option value=\"$c_id2\" >$c2</option>";
			}
        } ?> 
</select>
             
             
                        <label>No. poliza:</label>
                        <input type="text" name="poliza" id="poliza" class="input-mini" value="<?=$pol?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
                       
                        </td>
                       
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var poliza 	= $('#poliza').val();
	var aseg 	= $('#aseg').val();
	
	CargarAjax2('Admin/Sist.Distribuidor/Revisiones/Ticket/listado.php?poliza='+poliza+'&aseg='+aseg+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
}); 

	  </script>

      
   
			</div>
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      
                      
  <? 
  
  if($_GET['consul']=='1'){
	
	
	
	$rs2 = mysql_query("SELECT * FROM seguro_transacciones WHERE $aseg $poliza LIMIT 1");
	$row = mysql_fetch_array($rs2);
	
	//BUSCAR DATOS DEL CLIENTE
    $QClient=mysql_query("select * from seguro_clientes WHERE id ='".$row['id_cliente']."' LIMIT 1");
    $RQClient=mysql_fetch_array($QClient);
	
	//BUSCAR DATOS DEL VEHICULO
    $QVeh=mysql_query("select * from seguro_vehiculo WHERE id ='".$row['id_vehiculo']."' LIMIT 1");
    $RQVehi=mysql_fetch_array($QVeh);
	
			
?>


      <b> ID TRANS: </b> <?=$row['id']?> <br> 
      <b> ID CLIENTE: </b> <?=ClientePers($row['user_id'])?> <br>  <br>  
            
<h5 class="heading strong text-uppercase" style="    margin-bottom: -8px;">Vehiculo <b>(<?=$RQVehi['id']?>)</b></h5>
<table class="table table-striped table-bordered table-condensed table-white dataTable" >			
    <tbody role="alert" aria-live="polite" aria-relevant="all">
    		<tr class="gradeA odd">
                <td class=" sorting_1"><?=TipoVehiculo($RQVehi['veh_tipo'])?> </td>
                <td class="sorting_1">A&ntilde;o: <?=$RQVehi['veh_ano']?></td>
            </tr><tr class="sorting_1">
                <td class=" sorting_1">Marca: <?=VehiculoMarca($RQVehi['veh_marca'])?></td>
                <td class="sorting_1 ">Chasis: <?=$RQVehi['veh_chassis']?></td>
            </tr><tr class="sorting_1">
                <td class=" sorting_1">Modelos: <?=VehiculoModelos($RQVehi['veh_modelo'])?></td>
                <td class="sorting_1 ">Placa: <?=$RQVehi['veh_matricula']?></td>
            </tr> 
    </tbody> 
    <tr>
    	<td colspan="2" style="background-color:#FFF; text-align:right">
        <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Distribuidor/Revisiones/Ticket/Edit/editar-vehiculo.php?id=<?=$RQVehi['id']?>&poliza=<?=$_GET['poliza']?>&aseg=<?=$_GET['aseg']?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
            Editar datos del vehiculo 
            </a>        
            
                        </td>
    </tr>
</table>     
               
<h5 class="heading strong text-uppercase">Propietario <b>(<?=$RQClient['id']?>)</b></h5>
<table class="table table-striped table-bordered table-condensed table-white dataTable" >			
    <tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="gradeA odd">
                <td class=" sorting_1">Nombres: <?=$RQClient['asegurado_nombres']?> </td>
                <td class="sorting_1">Teléfono: <?=TelefonoPDF($RQClient['asegurado_telefono1'])?></td>
            </tr><tr class="sorting_1">
                <td class=" sorting_1">Apellidos: <?=$RQClient['asegurado_apellidos']?></td>
                <td class="sorting_1">Cédula: <?=CedulaPDF($RQClient['asegurado_cedula'])?></td>
            </tr>
            <tr class="sorting_1">
                <td class="sorting_1" colspan="2">Dirección: <?=$RQClient['asegurado_direccion']?></td>
            </tr>
    </tbody>
    <tr>
    	<td colspan="2" style="background-color:#FFF; text-align:right">
                        
            <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Distribuidor/Revisiones/Ticket/Edit/editar-cliente.php?id=<?=$RQClient['id']?>&poliza=<?=$_GET['poliza']?>&aseg=<?=$_GET['aseg']?>','','GET','cargaajax');" data-title="Editar"  class="btn btn-info">
            Editar datos del cliente 
            </a>
            
                        </td>
    </tr>
</table> 
                   
<h5 class="heading strong text-uppercase">Vigencia</h5>
 <table class="table table-striped table-bordered table-condensed table-white dataTable" >			
    <tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="gradeA odd">
                <td class=" sorting_1">
                <? if($row['vigencia_poliza'] <='11'){
                		echo $row['vigencia_poliza']." Meses";
                 }else{
                		echo " 1 A&ntilde;o";
                 } ?>
                </td>
                <td class="sorting_1">Vigente desde el <b><?=FechaListPDFn($row['fecha_inicio'])?></b></td>
            </tr>
    </tbody>
</table>  

                   
  <?
  	 } 
  
  ?>

</table>
 </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>