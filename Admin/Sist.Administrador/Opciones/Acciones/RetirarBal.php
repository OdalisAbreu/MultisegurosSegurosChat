<?
	session_start();
	//error_reporting(0);
	ini_set('display_errors',0);
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../../incluidos/Auditoria/RetiroBalance.php");

	$title 	= 'Retirar Balance:';
	
	$r2 = mysql_query("SELECT * from personal WHERE id ='".$_GET['id']."'");
    $row = mysql_fetch_array($r2);
	
	
	
	function RecargarCuentaDist(){
	global $sistema;
	
	// 1 - 	Consultamos balance del Dist.
	
	
	
	$idU 		= $_SESSION['user_id'];
	$bl_actual 	= BalanceCuenta($_POST['id_pers']);
	
	if($_POST['monto'] < $bl_actual){
	
	
	if($_SESSION['user_id'] && $_POST['id_pers']){
	// 2 - 	Verificamos que el Dist. tenga balance para esta transaccion.
	
		AudRetBal($_POST['id_pers'],$_SESSION['user_id'],$_POST['monto'],$bl_actual);
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				$balance_despues = $bl_actual - $_POST['monto'];
				
				// VERIFICAMOS EL MONTO DEL CREDITO ACTUAL 
			    $Ver_monto=mysql_query("SELECT id,id_pers,cred_actual  
				FROM recarga_retiro WHERE id_pers = '".$_POST['id_pers']."' ORDER BY id DESC LIMIT 1"); 
  			    $QVer_monto=mysql_fetch_array($Ver_monto);
			    $cred_actual = $QVer_monto['cred_actual'];
			    // VERIFICAMOS EL MONTO DEL CREDITO ACTUAL
				
				mysql_query("
				INSERT INTO recarga_retiro 
				(id_pers,monto,fecha,autorizada_por,balance_anterior,balance_despues,comentario,tipo,cred_actual)
				VALUES 
				('".$_POST['id_pers']."','".$_POST['monto']."','".date("Y-m-d H:i:s")."','".$_SESSION["user_id"]."','".$bl_actual."',
				'".$balance_despues."','".$_POST['comentario']."','Retiro','".$cred_actual."')"); 
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				
				
				
				mysql_query("
				UPDATE personal 
				SET balance =(balance -  ".$_POST['monto'].") 
				WHERE id='".$_POST['id_pers']."' LIMIT 1");
				
				
				
				echo '
				<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Balance Retirado!</h4>
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
	
	}else{
		echo "
		<div class='modal-header'>
		<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
		<h4>Error en el monto</h4>
	</div>
		<center><font style='font-size:16px; color:#F00;'><br>
		El monto es mayor a la cantidad que el cliente posee.
		</font></center>
		<br>
		<div class='modal-footer'>
		  <a href='#' class='btn btn-danger' id='Cerrar' data-dismiss='modal'>Cerrar</a>   
  </div>
		";
		AudRetBal($_POST['id_pers'],$_SESSION['user_id'],$_POST['monto'],$bl_actual);
			
	}
	
	
  }
  
	// ACCIONES PARA RECARGAR UN SUB-DISTRIBUIDOR
	if($_POST && $_POST['monto'] >0){
		RecargarCuentaDist($_POST);
	}
	  elseif($_POST && $_POST['monto'] <1){
		echo "<center><font size=3>Error en el monto digitado.</font></center><style>
		   .modal-footer{ display:none; }
		</style>";
	}else{
 ?>
<script language="JavaScript" type="text/javascript">
	// PARA VALIDAR K SOLO SEA NUMERO
	function ValidaSoloNumeros() {
		 if ((event.keyCode < 48) || (event.keyCode > 57)) 
		  event.returnValue = false;
		}
	
	
	
	
	
	function Recargar(){
		
		var x;
        var r=confirm("Realmente desea retirar balance de este cliente.\n\n Si esta de acuerdo haga click en Aceptar.");
		
	if (r==true){
	
		CargarAjax2_form('Admin/Sist.Administrador/Opciones/Acciones/RetirarBal.php','form_edit_prof','recargar_tele'); 
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
    <h4 class="modal-title" id="myModalLabel">Retirar balance dependiente</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información del cliente a retirar balance
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
          
          
            <!--tercera fila-->
          <div class="col-lg-3">
            <label class="strong">Teléfono</label>
          </div>
          <div class="col-lg-9">
            <div class="form-group "><?=DivTel($row['id']); ?></div>
          </div>
          <!--tercera fila-->
          
           <!--cuarta fila-->
          <div class="col-lg-3">
            <label class="strong">Balance Actual</label>
          </div>
          <div class="col-lg-9">
            <div class="form-group "><?="$".FormatDinero($row['balance']); ?></div>
          </div>
          <!--cuarta fila-->
        
          
           <!--sexta fila-->
          <div class="col-lg-3">
            <label class="strong">Monto</label>
          </div>
          <div class="col-lg-9">
          <div class="form-group input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" class="form-control" placeholder="Digitar cantidad" id="monto" name="monto">
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
                                            
                                            <input type="text" class="form-control" placeholder="Digitar comentario" id="comentario" name="comentario">
                                           
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
                <input name="id_pers" type="hidden" id="id_pers" value="<? echo $_GET['id'];?>" /> 
                
       </div>     
            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="Recargar();">Retirar</button>
                                            
                                        </div>
	</form>
    </div>
<? } ?>