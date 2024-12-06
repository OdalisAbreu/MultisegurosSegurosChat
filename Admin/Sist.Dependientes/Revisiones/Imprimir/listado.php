<?
	session_start();
	ini_set('display_errors',1);
	
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	
	// --------------------------------------------	
	if($_GET['cedula']){
		$cedula = $_GET['cedula'];
	}else{
		$cedula = "";
	}
	
	if($_GET['poliza']){
		$poliza = $_GET['poliza'];
	}else{
		$poliza = "";
	}
	
	if($_GET['tipo']=='1'){
	


?>

<script>

		$("#tabla1").css("display", "");  // cedula
		$("#tabla2").css("display", "none");  // no poliza
		$("#tabla3").css("display", "none");  // no poliza
		$("#tabla4").css("display", "none"); // no poliza
		$("#boton").css("display", "");  // boton
		
	

</script>

<? }

if($_GET['tipo']=='2'){
?>
<script>
		$("#tabla1").css("display", "none");  // cedula
		$("#tabla2").css("display", ""); // no poliza
		$("#tabla3").css("display", ""); // no poliza
		$("#tabla4").css("display", ""); // no poliza
		$("#boton").css("display", "");  // boton
</script>

<? } ?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Consultar Poliza </h3>
    </div>
</div>

		
    
    
    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
    <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                      <td style="width:130px">
      <label>Buscar por:</label><br>
      <select class="span12" style="font-size: 18px; height: 34px; color: #000;  width: 130px;" name="tipo" id="tipo">
<option value="0" <? if($_GET['tipo']=='0'){?> selected="selected" <? } ?> >Seleccionar</option>
<!--<option value="1" <? if($_GET['tipo']=='1'){?> selected="selected" <? } ?> >Cedula</option>-->
<option value="2" <? if($_GET['tipo']=='2'){?> selected="selected" <? } ?> >No. Poliza</option>
    </select>
                      </td>
                      
                      
<script>
		$("#tipo").change(
			function(){
				id = $(this).val();
				
				if(id=='0'){ // ninguno
					$("#tabla1").css("display", "none"); // cedula
					$("#tabla2").css("display", "none"); // no poliza
					$("#tabla3").css("display", "none"); // no poliza
					$("#tabla4").css("display", "none"); // no poliza
					$("#boton").css("display", "none"); // boton
					
				}						
				if(id=='1'){ // cedula
					$("#tabla1").css("display", "initial");  // cedula
					$("#tabla2").css("display", "none");  // no poliza
					$("#tabla3").css("display", "none");  // no poliza
					$("#tabla4").css("display", "none"); // no poliza
					$("#boton").css("display", "initial");  // boton
					
				}
				if(id=='2'){ // no poliza
					$("#tabla1").css("display", "none");  // cedula
					$("#tabla2").css("display", "initial"); // no poliza
					$("#tabla3").css("display", "initial"); // no poliza
					$("#tabla4").css("display", "initial"); // no poliza
					$("#boton").css("display", "initial");  // boton
				}
												
		}); 
</script>
                    	<td id="tr1" style="width: 100px !important;">
                        <div id="tabla1" style="display:none; ">
                        <label>Cedula:</label><br>
                        <input type="text" name="cedula" id="cedula" class="input-mini" value="<?=$cedula?>" style="width: 95px; height:30px; ">
                        
                       </div>
                       
                        </td>
                        
                        <td id="tr2">
                        <div id="tabla2"  style="display:none">
                        <label>Aseguradora:</label><br>
                        <select name="aseguradora" id="aseguradora" style="font-size: large; color: #09b6e7; display:inline; width:222px;" class="form-control">
                       <option selected="selected" value="0" tabindex="12">Seleccionar</option>
                        <? ///  SELECCION DEL TIPO .....................................
$R2 = mysql_query("SELECT id, nombre, activo from seguros order by nombre ASC");
    while ($C2 = mysql_fetch_array($R2)) {
			$c_nombre = $C2['nombre'];
			$c_id = $C2['id'];
			
			if($_GET['aseguradora'] == $c_id){
				echo "<option value=\"$c_id\" selected>$c_nombre</option>";
			}else{
				echo "<option value=\"$c_id\" >$c_nombre</option>"; 
			}
			
        } ?> 
                        </select>
                       
              <? if($_GET['aseguradora']){
				echo"
				<script>
				CargarAjax2('Admin/Sist.Administrador/Revisiones/Imprimir/AJAX/Modelos.php?idseg=".$_GET['aseguradora']."','','GET','prefijo');
				</script>
				";
		}?>      
  
  <script>
    $("#aseguradora").change(
    
        function(){
            id = $(this).val();
            CargarAjax2('Admin/Sist.Administrador/Revisiones/Imprimir/AJAX/Modelos.php?idseg='+id+'','','GET','prefijo');
        }); 
              
    </script>
   
                       </div>
                       
                       
    
                        </td>
                        
                        <td>
                        <div id="tabla3" style="display:none">
          <label>Prefijo:</label><br>           
      <div id="prefijo" disabled="disabled" class="col-md-12" style="margin-left:-15px;"> 
        <select name="modelo" id="modelo" style="display:compact" disabled="disabled" class="form-control">
        </select>
      </div>
                       
    </div>
                        </td>
                        
                        <td  style="width: 100px !important;">
                        <div id="tabla4" style="display:none; ">
                        <label>No. Poliza:</label><br>
                        <input type="text" name="poliza" id="poliza" class="input-mini" value="<?=$poliza?>" style="width: 95px; height:30px; ">
                        
                       </div>
                       
                        </td>
                        
                        <td>
                        <div id="boton"  style="display:none">
                         <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
                        </div>
                        </td>
                       
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var tipo 	= $('#tipo').val();
	var cedula 	= $('#cedula').val();
	var aseguradora 	= $('#aseguradora').val();
	var poliza 	= $('#poliza').val();
	
	CargarAjax2('Admin/Sist.Dependientes/Revisiones/Imprimir/listado.php?tipo='+tipo+'&cedula='+cedula+'&aseguradora='+aseguradora+'&poliza='+poliza+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
}); 

	  </script>
			</div>
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cedula</th>
                            <th>Direccion</th>
                            <th></th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  
  if($_GET['consul']=='1'){
	
	
	//echo "tipo ".$_GET['tipo']."<br>";
	//echo "cedula ".$_GET['cedula']."<br>";
	//echo "aseguradora ".$_GET['aseguradora']."<br>";
	//echo "poliza ".$_GET['poliza']."<br>";
	//echo "poliza ".substr($_GET['poliza'], -3, 3); // devuelve "d"
	
	
	if($_GET['tipo']=='1'){
		
	}
	
	if($_GET['tipo']=='2'){
		
		//$poliza = substr($_GET['poliza'], -4, 4);
		$poliza = $_GET['poliza'];
		
		$rs2 = mysql_query(
   "SELECT * FROM seguro_transacciones WHERE id_aseg = '".$_GET['aseguradora']."' AND id_poliza = '".$poliza."' LIMIT 1");
   
   
	
	}
	
	
	$numU = mysql_fetch_array($rs2);
	
	
	$rcliente = mysql_query(
   "SELECT * FROM seguro_clientes WHERE id = '".$numU['id_cliente']."' LIMIT 1");
   $nrcliente = mysql_fetch_array($rcliente);
   		
?>
<tr>
    <td><?=$numU['id']?></td>
    <td><?=$nrcliente['asegurado_nombres']?></td>
    <td><?=$nrcliente['asegurado_apellidos']?></td>
    <td><?=$nrcliente['asegurado_cedula']?></td>
    <td><?=$nrcliente['asegurado_direccion']?></td>
    <td>
    
    <!--<a href="#" onclick="CargarAjax_win('Admin/Sist.Sucursal/Seguro/ticket.php?id=<?=$numU['id']?>','','GET','cargaajax');">Imprimir ticket</a><br>
    
    
    <a href="#" onclick="CargarAjax_win('Admin/Sist.Administrador/Revisiones/Imprimir/Accion/poliza.php?id_trans=<?=$numU['id']?>','','GET','cargaajax');">Imprimir poliza</a>-->
    
    <a href="#" onclick=" CargarAjax_win('Admin/Sist.Dependientes/Revisiones/Imprimir/Accion/polizaVia.php?id_trans=<?=$numU['id']?>','','GET','cargaajax'); " data-title="Visualizar"  class="btn btn-danger">
             <i class="fa fa-eye fa-lg"></i> 
            </a>
    
    </td>
</tr>
  <?
  	  
  	}
  ?>

    </tbody>
</table>
 </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>