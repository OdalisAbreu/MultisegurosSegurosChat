<?
	session_start();
	//error_reporting(0);
	ini_set('display_errors',0);
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../../incluidos/Auditoria/RecargaBalance.php");
	
	$title 	= 'Recargar Cuenta:';
	$_POST['monto'] = str_replace("-", "", $_POST['monto']);
	$r2 = mysql_query("SELECT * from personal WHERE id ='".$_GET['id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	
	$bl_actual 	= BalanceCuenta($_POST['id_pers']);
	
	
	
	if($_SESSION['user_id'] && $_POST['id_pers']){
	
		if($_POST['monto']<10){
			echo '
				<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 style="color:#ff0000;">Error: Monto no permitido para recargar!</h4>
	</div>
		<center><font style="font-size:16px; color:#ff0000;"><br>
		La transaccion no se ha realizado, debe especificar un monto mayor....
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
	
	
		}else{
		
		
			AudRecBal($_POST['id_pers'],$_SESSION['user_id'],$_POST['monto'],$bl_actual);
			
			if($_POST['tipo'] =='Contado'){
				echo '
				<script>
				CargarAjax2("Admin/Sist.PersonalRecargas/List/Listado_Client.php","","GET","cargaajax");
				</script>';
				
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				$balance_despues = $bl_actual + $_POST['monto'];
				
				// VERIFICAMOS EL MONTO DEL CREDITO ACTUAL 
			    $Ver_monto=mysql_query("SELECT id,id_pers,cred_actual  
				FROM recarga_retiro WHERE id_pers = '".$_POST['id_pers']."' ORDER BY id DESC LIMIT 1"); 
  			    $QVer_monto=mysql_fetch_array($Ver_monto);
			    $cred_actual = $QVer_monto['cred_actual'];
			    // VERIFICAMOS EL MONTO DEL CREDITO ACTUAL
				
				mysql_query("
				INSERT INTO recarga_retiro 
				(id_pers,monto,fecha,autorizada_por,balance_anterior,balance_despues,comentario,rec_id,tipo,banco)
				VALUES 
				('".$_POST['id_pers']."','".$_POST['monto']."','".date("Y-m-d H:i:s")."','".$_SESSION["dist_id"]."','".$bl_actual."',
				'".$balance_despues."','".$_POST['comentario']."','".$_SESSION['user_id']."','Contado','".$_POST['banco']."')"); 
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				
				mysql_query("
				UPDATE personal 
				SET balance =(balance +  ".$_POST['monto'].") 
				WHERE id='".$_POST['id_pers']."' LIMIT 1");
				
				
				echo '
				<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Cuenta Recargada (Contado)!</h4>
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
	
				
	
	
			}
	
	//$user_func = $_SESSION['user_funcion'];
	
	
	if($_POST['tipo'] =='Credito'){
		
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				$balance_despues = $bl_actual + $_POST['monto'];
				
				// VERIFICAMOS EL MONTO DEL CREDITO ACTUAL 
			    $Ver_monto=mysql_query("SELECT id,id_pers,cred_actual  
				FROM recarga_retiro WHERE id_pers = '".$_POST['id_pers']."' ORDER BY id DESC LIMIT 1"); 
  			    $QVer_monto=mysql_fetch_array($Ver_monto);
			    $cred_actual = $QVer_monto['cred_actual'] + $_POST['monto'];
			    // VERIFICAMOS EL MONTO DEL CREDITO ACTUAL
				
				mysql_query("
				INSERT INTO recarga_retiro 
				(id_pers,monto,fecha,autorizada_por,balance_anterior,balance_despues,comentario,rec_id,tipo,banco,cred_actual)
				VALUES 
				('".$_POST['id_pers']."','".$_POST['monto']."','".date("Y-m-d H:i:s")."','".$_SESSION["dist_id"]."','".$bl_actual."',
				'".$balance_despues."','".$_POST['comentario']."','".$_SESSION['user_id']."','Credito','','".$cred_actual."')"); 
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				
				mysql_query("
				UPDATE personal 
				SET balance =(balance +  ".$_POST['monto'].") 
				WHERE id='".$_POST['id_pers']."' LIMIT 1");
				
				
				echo '<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Cuenta Recargada (Credito)!</h4>
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
	
			}

		}
	//$conf['realizada_por'] = $_SESSION['user_id'];
	
	
	
	}else{
 ?>
 
  <script src="incluidos/js/SoloNumeros.js"></script>

<script language="JavaScript" type="text/javascript">
	
 function Recargar(){
	var monto1 		= $('#monto').val();
	var banco 		= $("#banco").val();
	var comentario 	= $("#comentario").val();
	var tipo 		= $("#tipo").val();
	
	//validando la cuenta de banco si es Contado
	if(banco =='' && tipo=='Contado'){
		$("#comentario").css("border","solid 1px #F00");
		$("#banco").css("border","solid 1px #F00");
		
	var HayError = true;
	}else { 
			$("#comentario").css("border","solid 1px #CCC");
			$("#banco").css("border","solid 1px #CCC");
			 
		  }
	
	
	//validando el monto digitado
	if(monto1 ==''){
		$("#monto").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#monto").css("border","solid 1px #CCC"); }
	
	//validando la cuenta de banco si es Credito
	if(comentario =='' && tipo=='Credito'){
		$("#comentario").css("border","solid 1px #F00");
	var HayError = true;
	}else { $("#comentario").css("border","solid 1px #CCC"); }
		
	
	if (HayError == true){
		//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
	} else {
			
		var x;
        var r=confirm("Realmente desea realizar la accion.\n\n Si esta de acuerdo haga click en Aceptar.");
		
	if (r==true){
	
		CargarAjax2_form('Admin/Sist.PersonalRecargas/Opciones/Acciones/Recargar.php','form_edit_prof','recargar_tele'); 
		$(this).attr('disabled',true);
	    setTimeout("$('#recargar').fadeOut(0);  $('#cerrar').fadeOut(0);   $('#recargar2').fadeIn(0); ",0);
	
		}else{
	
	    }
 	}
	}
</script>
<div id="recargar_tele">
<form action="" method="post" enctype="multipart/form-data" id="form_edit_prof">

<div class="modal-header" style="    height: 50px;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Recargar dependiente</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default" style="margin-top: -10px;">
                        <div class="panel-heading">
                            Información del cliente a recargar
                        </div>
                     
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active">
                                <p>
                                    <div class="row">
          <!--primera fila-->                          
          <div class="col-lg-3">
            <label class="strong">ID</label>
          </div>
          <div class="col-lg-9">
            <div class="form-group "><?=$row['id'];?></div>
          </div>
          <!--primera fila-->
          
          
          <!--segunda fila-->
          <div class="col-lg-3">
            <label class="strong">Nombre</label>
          </div>
          <div class="col-lg-9">
            <div class="form-group "><?=$row['nombres']; ?></div>
          </div>
          <!--segunda fila-->
          
          
            
          
           <!--cuarta fila-->
          <div class="col-lg-3">
            <label class="strong">Balance Actual</label>
          </div>
          <div class="col-lg-9">
            <div class="form-group "><?="$".FormatDinero($row['balance']); ?></div>
          </div>
          <!--cuarta fila-->
        
          <!--quinta fila-->
          <div class="col-lg-3">
            <label class="strong">Condici&oacute;n</label>
          </div>
          <div class="col-lg-9">
            <div class="form-group ">
                <select class="form-control" name="tipo" id="tipo">
                    <option value="Contado">Contado</option>
                    <option value="Credito">Credito</option>
                </select>
            </div>
          </div>
          <script>
			$("#tipo").change(function(){
										  
			var id = $(this).val();
			
				if( id == "Contado" ){  
					$('#banco1').fadeIn('0');
					$('#banco2').fadeIn('0');
				}else { 
					$('#banco1').fadeOut('0');
					$('#banco2').fadeOut('0');
				}
				
				if( id == "Credito" ){  
					$('#banco1').fadeOut('0');
					$('#banco2').fadeOut('0');
				}else { 
					$('#banco1').fadeIn('0');
					$('#banco2').fadeIn('0');
				}
			 
			});
			
			$('#Contado').fadeIn('0');
		</script>
          <!--quinta fila-->
          
          <!--quinta fila-->
          <div class="col-lg-3" id="banco1">
            <label class="strong">Banco</label>
          </div>
          <div class="col-lg-9" id="banco2">
            <div class="form-group ">
                <select name="banco" id="banco" class="form-control" style="font-size:18px; width:100% !important; color:#900; font-weight:bold;">
              <option selected="selected" value="" style="color:#FFF; background-color:#4F4F4F;">Seleccionar:</option>
              <?
		$rutS = mysql_query("
		SELECT id, id_banc, num_cuenta FROM cuentas_de_banco WHERE user_id = '".$_SESSION["dist_id"]."' AND activo ='si' ORDER BY id ASC");
    	while ($cat = mysql_fetch_array($rutS)) {
			$banco 	= Bancos($cat['id_banc']); 
			$c_val 	= $cat['id'];
			
			echo "<option value=\"$c_val\" onclick=\"\">$banco (".$cat['num_cuenta'].")</option>"; 
			  
        } ?>
            </select>
            </div>
          </div>
          <!--quinta fila-->
          
           <!--sexta fila-->
          <div class="col-lg-3">
            <label class="strong">Monto</label>
          </div>
          <div class="col-lg-9">
          <div class="form-group input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" class="form-control" placeholder="Digitar cantidad" id="monto" name="monto" onKeyPress="return soloNumeros(event)">
                                            <span class="input-group-addon">.00</span>
                                        </div>
            
          </div>
          <!--sexta fila-->
          
          
          
          <!--septima fila-->
          <div class="col-lg-3">
            <label class="strong">Comentario</label>
          </div>
          <div class="form-group input-group">
           <textarea rows="2" cols="50" class="form-control" id="comentario" name="comentario"></textarea>
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
                <input name="fecha" type="hidden" id="fecha" value="<?=date ('Y-m-d G:i:s');?>" /> 
                <input name="id_pers" type="hidden" id="id_pers" value="<?=$_GET['id'];?>" /> 
                
       </div>     
            <div class="modal-footer" style="margin-top: -28px;">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="Recargar();">Recargar</button>
                                            
                                        </div>
	</form>
    </div>
<? } ?>