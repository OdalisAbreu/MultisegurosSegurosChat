<?
	session_start();
	//error_reporting(0);
	ini_set('display_errors',0);
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../../incluidos/Auditoria/RecargaBalance.php");
	
	$title 	= 'Recargar Cuenta:';
	
	$r2 = mysql_query("SELECT * FROM personal WHERE id ='".$_GET['id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	
	
	function RecargarCuentaDist(){
	global $sistema;
	
	// 1 - 	Consultamos balance del Dist.
	
	
	
	$idU 		= $_SESSION['user_id'];
	$bl_actual 	= BalanceCuenta($_POST['id_pers']);
	$bl_actual1 = BalanceCuenta($idU);
	
	
	$_POST['id_pers'] =limpiarCadena($_POST['id_pers']);
	$_POST['monto'] =limpiarCadena($_POST['monto']);
	$_POST['comentario'] =limpiarCadena($_POST['comentario']);
	//echo "monto ".$_POST['monto']."<br>";
	//echo "tipo ".$_POST['tpago']."<br>";
	//echo "comentario ".$_POST['comentario']."<br>";
	//echo "autorizado ".$_SESSION['user_id']."<br>";
	//echo "cliente ".$_POST['id_pers']."<br>";
	
	
	if($_POST['monto'] <= $bl_actual1){
	// 2 - 	Verificamos que el Dist. tenga balance para esta transaccion.
	
	
			// PARA BLOQUEAR BALANCE RECARGADAS DUPLICADAS /////////////////////////////////////////////
			//$noDup = @file_get_contents(
			//"http://172.27.210.29/wsMemcache/NoDuplicarIfExisteBalanceRec.php"
			//."?user_id=".$_POST['id_pers']."&monto=".$_POST['monto']);
			
			//if($noDup =='duplicada'){
				//exit("<center>No se puede efectuar la recarga, porque ya se ha realizado previamente!</center><style>
				//.modal-footer{ display:none; }
				//</style>");
			//}
			
			// GUARDAR RECARGA EN CACHE:
			//@file_get_contents("http://172.27.210.29/wsMemcache/NoDuplicarBalanceRec.php"
			//."?user_id=".$_POST['id_pers']."&monto=".$_POST['monto']);
			// PARA BLOQUEAR BALANCE RECARGADAS DUPLICADAS 
			//////////////////////////////////////////////////////////////////////////////////////////
			AudRecBal($_POST['id_pers'],$_SESSION['user_id'],$_POST['monto'],$bl_actual);
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
			
			if($_POST['tipo'] =='Contado'){
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				$balance_despues = $bl_actual + $_POST['monto'];
				$balance_despues2 = $bl_actual1 - $_POST['monto'];
				
				// VERIFICAMOS EL MONTO DEL CREDITO ACTUAL 
			    $Ver_monto=mysql_query("SELECT id,id_pers,cred_actual  
				FROM recarga_retiro WHERE id_pers = '".$_POST['id_pers']."' ORDER BY id DESC LIMIT 1"); 
  			    $QVer_monto=mysql_fetch_array($Ver_monto);
			    $cred_actual = $QVer_monto['cred_actual'];
			    // VERIFICAMOS EL MONTO DEL CREDITO ACTUAL
				
				mysql_query("
				INSERT INTO recarga_retiro 
				(id_pers,monto,fecha,autorizada_por,balance_anterior,balance_despues,comentario,
				 bl_anterior_recargo, bl_actual_recargo,tipo,cred_actual)
				VALUES 
				('".$_POST['id_pers']."','".$_POST['monto']."','".date("Y-m-d H:i:s")."','".$_SESSION['user_id']."','".$bl_actual."',
				'".$balance_despues."','".$_POST['comentario']."','".$bl_actual1."','".$balance_despues2."','Contado','".$cred_actual."')"); 
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				
				
				
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
				
				mysql_query("
				UPDATE personal 
				SET balance =(balance +  ".$_POST['monto'].") 
				WHERE id='".$_POST['id_pers']."' LIMIT 1");
				
				//$bl_actual1 = $bl_actual1 - $_POST['monto'];
				mysql_query("
				UPDATE personal 
				SET balance =(balance -  ".$_POST['monto'].") 
				WHERE id='".$_SESSION['user_id']."' LIMIT 1");
	
				echo '
				<script>
				CargarAjax2("Admin/Sist.Distribuidor/Personal/List/listado.php","","GET","cargaajax");
				</script>';
	
	
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
				(id_pers,monto,fecha,autorizada_por,balance_anterior,balance_despues,comentario,
				 bl_anterior_recargo, bl_actual_recargo,tipo,cred_actual)
				VALUES 
				('".$_POST['id_pers']."','".$_POST['monto']."','".date("Y-m-d H:i:s")."','".$_SESSION['user_id']."','".$bl_actual."',
				'".$balance_despues."','".$_POST['comentario']."','".$bl_actual."','".$balance_despues."','Contado','".$cred_actual."')"); 
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				
				mysql_query("
				UPDATE personal SET balance =(balance +  ".$_POST['monto'].") WHERE id='".$_POST['id_pers']."'");
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
				CargarAjax2("Admin/Sist.Administrador/Personal/List/listado.php","","GET","cargaajax");
				</script>';
	
			}

	
	//$conf['realizada_por'] = $_SESSION['user_id'];
	
	   }
	
	}else{
		//die( "Error" );	
		
		echo '
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Error al recargar la cuenta</h4>
	</div>
		<center><font style="font-size:16px; color:#f00;"><br>
		No tienes balance para recargar, favor recargar tu cuenta.
		</font></center>
		<br>
		<div class="modal-footer">
		  <a href="#" class="btn btn-danger" id="Cerrar" data-dismiss="modal">Cerrar</a>   
 	 </div>
		';
		
		AudRecBal($_POST['id_pers'],$_SESSION['user_id'],$_POST['monto'],$bl_actual);
		exit();
	}
  }
  
	// ACCIONES PARA RECARGAR UN SUB-DISTRIBUIDOR
	if($_POST && $_POST['monto'] >0){
		RecargarCuentaDist($_POST);
	}
	  elseif($_POST && $_POST['monto'] <1){
		echo '<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Error al recargar la cuenta</h4>
	</div>
		<center><font style="font-size:16px; color:#f00;"><br>
		Por favor verificar sus datos.
		</font></center>
		<br>
		<div class="modal-footer">
		  <a href="#" class="btn btn-danger" id="Cerrar" data-dismiss="modal">Cerrar</a>   
  </div>';
  exit();
	}else{
 ?>
 <script src="incluidos/js/SoloNumeros.js"></script>
<script language="JavaScript" type="text/javascript">
	
	
	function Recargar(){
		
		var x;
        var r=confirm("Realmente desea recargar este cliente.\n\n Si esta de acuerdo haga click en Aceptar.");
		
	if (r==true){
	
		CargarAjax2_form('Admin/Sist.Distribuidor/Opciones/Acciones/Recargar.php','form_edit_prof','recargar_tele'); 
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
    <h4 class="modal-title" id="myModalLabel">Recargar dependiente</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12" style="margin-bottom: -30px;">
                    <div class="panel panel-default" style="margin-top: -11px;">
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
            <div class="form-group "><? echo $row['nombres']; ?></div>
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
                    <!--<option value="Credito">Credito</option>-->
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
          <div class="col-lg-9">
          <div class="form-group input-group">
           <textarea rows="2" cols="50" class="form-control" id="comentario" name="comentario"></textarea>
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

                <input name="accion" type="hidden" id="accion" value="<? echo $acc;?>">
                <input name="id" type="hidden" id="id" value="<? echo $row['id']; ?>" />
                <input name="id_dist" type="hidden" id="id_dist" value="<? echo $_SESSION['user_id']; ?>" /> 
                <input name="fecha" type="hidden" id="fecha" value="<? echo date ('Y-m-d G:i:s');?>" /> 
                <input name="id_pers" type="hidden" id="id_pers" value="<? echo $_GET['id'];?>" /> 
                
       </div>     
            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="Recargar();">Recargar</button>
                                            
                                        </div>
	</form>
    </div>
<? } ?>