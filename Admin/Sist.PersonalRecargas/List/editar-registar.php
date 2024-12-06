<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	// V 1.0
	ini_set('display_errors', 1);
	session_start();
	set_time_limit(0);
	include("../../../incluidos/conexion_inc.php");
	include("../../../incluidos/Func/NombreCliente.php");
	Conectarse();
	
	
	$r2 = mysql_query("SELECT * from recarga_balance_cuenta WHERE id ='".$_GET['id']."'");
    $row = mysql_fetch_array($r2);
	
	 

	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		$acc	= $_GET['accion'];
	}else{
		$acc 	= 'editar';
	}
 ?>
<script>
function Editar_Cuenta(){
      setTimeout("$('#recargar2').fadeIn(3); $('#recargar').fadeOut(0); $('#cerrar').fadeOut(0);",0);
	   if(confirm('Realmente desea realizar esta Accion?\n\n Si esta de acuerdo haga click en Aceptar.')){ 
		  $(this).attr('disabled',true);	
			CargarAjax2_form('Admin/Sist.PersonalRecargas/List/Listado_recargas_trans.php','form_edit_perso','cargaajax');
	    }
	  }
</script>
<!-- Modal heading -->
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Retirar saldo</h3>
	</div>
	<!-- // Modal heading END -->
<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">
  <div class="modal-body">
        <div id="recargar_tele">
        
 
          <table class="table table-bordered table-white span5">
                <!-- Table body -->
                <tbody>
	
                    <!-- Table row -->
                    <tr>
                        <td>ID</td>
                        <td><b><?=$row['id']?></b></td>
                    </tr>
                    <!-- // Table row END -->
                    
                     <!-- Table row -->
                    <tr>
                        <td>Nombre</td>
                        <td><?=NombreCliente($row['id_pers'])?></td>
                    </tr>
                    <!-- // Table row END -->
                    
                     <!-- Table row -->
                    <tr>
                        <td>Monto</td>
                        <td><?=FormatDinero($row['monto'])?></td>
                    </tr>
                    <!-- // Table row END -->
            
                    <!-- Table row -->
                    <tr>
                        <td>Seleccione la cuenta a modificar</td>
                        <td><select name="cuenta_banco" id="cuenta_banco" style="font-size:16px;">
             
              <?
		$rutS = mysql_query("
		SELECT id, nombre, cuenta_no FROM cuentas_bancos ORDER BY id ASC");
    	while ($cat = mysql_fetch_array($rutS)) {
			$c 		= $cat['nombre']; 
			$c_val 	= $cat['id'];
			
			if($row['cuenta_banco'] == $c_val){ 
				echo "<option value=\"$c_val\" onclick=\"\"  selected>".$cat['id']." - $c (".$cat['cuenta_no'].")</option>"; 
			}else{
				echo "<option value=\"$c_val\" onclick=\"\">".$cat['id']." - $c (".$cat['cuenta_no'].")</option>"; 
			}   
        } ?>
            </select></td>
                    </tr>
                    <!-- // Table row END -->
            
                  
          
                </tbody>
                <!-- // Table body END -->
            
            </table>
            <!-- // Table END -->
     	</div>  
	</div>
    
    <div class="modal-footer" style="margin-bottom:-23px;">
		<a href="#" class="btn btn-danger" data-dismiss="modal" id="cerrar">Cerrar</a>
      
		<a href="#" class="btn btn-primary" id="recargar" onClick="Editar_Cuenta();">Actualizar</a>
        
         <div id="recargar2" style="display:none;"> Cargando&nbsp;&nbsp;<img src="images/iconos/ajax-loader.gif" width="32" height="32" /></div>
	</div>
    
    <input name="accion" type="hidden" id="accion" value="<? echo $acc;?>">
	<input name="id" type="hidden" id="id" value="<? echo $row['id']; ?>" />
  
  </form>