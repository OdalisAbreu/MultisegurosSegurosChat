<?
	session_start();
	//error_reporting(0);
	ini_set('display_errors',0);
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../../incluidos/Auditoria/RecargaBalance.php");
	
	$title 	= 'Realizar Ingreso:';
	$_POST['monto'] = str_replace("-", "", $_POST['monto']);
	
	
	$r2 = mysql_query("SELECT * from personal WHERE id ='".$_GET['id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	$r3 = mysql_query("SELECT * from recarga_retiro WHERE 
	id_pers ='".$_GET['id']."' ORDER BY id DESC LIMIT 1");
    $row3 = mysql_fetch_array($r3);
	
	
	//$bl_actual 	= BalanceCuenta($_POST['id_pers']);
	
	
	if($_SESSION['user_id'] && $_POST['id_pers']){
	  
	  if($_POST['monto'] > 0){
		  
		  print_r($_POST);
	
			AudRecBal($_POST['id_pers'],$_SESSION['user_id'],$_POST['monto'],$bl_actual);
			
				//VERIFICAR EL BALANCE ACTUAL 
				$r2d = mysql_query("SELECT * from personal WHERE id ='".$_POST['id_pers']."' LIMIT 1");
    			$rowd = mysql_fetch_array($r2d);
	
				// VERIFICAMOS EL MONTO DEL CREDITO ACTUAL 
			    $Ver_monto=mysql_query("SELECT id,id_pers,cred_actual  
				FROM recarga_retiro WHERE id_pers = '".$_POST['id_pers']."' ORDER BY id DESC LIMIT 1"); 
  			    $QVer_monto=mysql_fetch_array($Ver_monto);
			    $cred_act = $QVer_monto['cred_actual'];
			    // VERIFICAMOS EL MONTO DEL CREDITO ACTUAL
				
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				$cred_actual = $cred_act - $_POST['monto'];
				
				mysql_query("
				INSERT INTO recarga_retiro 
				(id_pers,monto,fecha,autorizada_por,balance_anterior,balance_despues,comentario,rec_id,tipo,cred_actual,banco)
				VALUES 
				('".$_POST['id_pers']."','".$_POST['monto']."','".date("Y-m-d H:i:s")."','".$_SESSION["dist_id"]."','".$rowd['balance']."',
				'".$rowd['balance']."','".$_POST['comentario']."','".$_SESSION['user_id']."','Ingreso','".$cred_actual."','".$_POST['banco']."')"); 
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				
				
				echo '
				<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Registro de Ingreso!</h4>
	</div>
		<center><font style="font-size:16px; color:#063;"><br>
		La transaccion fue efectuada con exito....
		</font></center>
		<br>
		<div class="modal-footer">
		  <a href="#" class="btn btn-danger" id="Cerrar" data-dismiss="modal">Cerrar</a>   
  </div>
  
  
				<script>
				$("#recargar").fadeOut(0);
				$("#recargar2").fadeOut(0);
				$("#cerrar").fadeIn(0);
				</script>
				
				';
	
				echo '
				<script>
				CargarAjax2("Admin/Sist.PersonalRecargas/List/Listado_Client.php","","GET","cargaajax");
				</script>';
	
	
			
	  }else{
		  
	echo '
				<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 style="color:#ff0000;">Error al registrar ingreso!</h4>
	</div>
		<center><font style="font-size:16px; color:#ff0000;"><br>
		La transaccion no se ha realizado....
		</font></center>
		<br>
		<div class="modal-footer">
		  <a href="#" class="btn btn-danger" id="Cerrar" data-dismiss="modal">Cerrar</a>   
  </div>
  
  
				<script>
				$("#recargar").fadeOut(0);
				$("#recargar2").fadeOut(0);
				$("#cerrar").fadeIn(0);
				</script>
				
				';
	
	
	}

	
	
	
	}else{
 ?>
 
  <script src="incluidos/js/SoloNumeros.js"></script>

<script language="JavaScript" type="text/javascript">
	
	
	function Recargar(){
		
		var x;
        var r=confirm("Realmente desea realizar la accion.\n\n Si esta de acuerdo haga click en Aceptar.");
		
	if (r==true){
	
		CargarAjax2_form('Admin/Sist.PersonalRecargas/Opciones/Acciones/Abonar.php','form_edit_prof','recargar_tele'); 
		$(this).attr('disabled',true);
	    setTimeout("$('#recargar').fadeOut(0);  $('#cerrar').fadeOut(0);   $('#recargar2').fadeIn(0); ",0);
	
		}else{
	
	    }
 	}
	
</script>
<div id="recargar_tele">
<form action="" method="post" enctype="multipart/form-data" id="form_edit_prof">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Abono cuenta  del dependiente</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default" style="margin-top: -10px;">
                        <div class="panel-heading">
                        Información de la cuenta del cliente</div>
                     
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active">
                                <p>
                                    <div class="row">
         
          
         
          
          <!--segunda fila-->
          <div class="col-lg-8">
            <label class="strong">Nombre</label>
            <div class="form-group "><?=$row['nombres']; ?></div>
          </div>
         
          <!--segunda fila-->
          
          
            
          
           <!--cuarta fila-->
          <div class="col-lg-4">
            <label class="strong">Balance Actual</label>
            <div class="form-group" style="color:#F4070B"><b><?="$".FormatDinero($row3['cred_actual']); ?></b></div>
          </div>
         
          <!--cuarta fila-->
        
         
         <div class="col-lg-12">
            <label class="strong">Banco</label>
            <div class="form-group ">
                <select class="form-control" name="banco" id="banco">
                <?
    $querybanc=mysql_query("
      SELECT * FROM cuentas_de_banco
      WHERE user_id ='".$_SESSION['dist_id']."' AND activo ='si'
	  ORDER BY id DESC
		
		");
		
    
  while($rwebac=mysql_fetch_array($querybanc)){
				?>
                    <option value="<?=$rwebac['id']?>"><?=$rwebac['nombre_banc']." - ".$rwebac['num_cuenta']?></option>
                    <? } ?>
                    
                </select>
            </div>
          </div>
          
           <!--sexta fila-->
          <div class="col-lg-12">
            <label class="strong">Monto</label>
            <div class="form-group input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" class="form-control" placeholder="Digitar cantidad" id="monto" name="monto" onKeyPress="return soloNumeros(event)">
                                            <span class="input-group-addon">.00</span>
                                        </div>
          </div>
         
          <!--sexta fila-->
          
          
          
          <!--septima fila-->
          <div class="col-lg-12">
            <label class="strong">Comentario</label>
            <div class="form-group input-group">
                                            
                                          
                                            
                                            <textarea rows="4" cols="80" class="form-control" id="comentario" name="comentario">

</textarea>
                                           
                                        </div>
          </div>
        
          <!--septima fila-->
          
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
                <input name="id" type="hidden" id="id" value="<?=$row['id']; ?>" />
                <input name="id_pers" type="hidden" id="id_pers" value="<?=$_GET['id'];?>" /> 
                
       </div>     
            <div class="modal-footer" style="margin-top: -25px;">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="Recargar();">Aceptar</button>
                                            
                                        </div>
	</form>
    </div>
<? } ?>