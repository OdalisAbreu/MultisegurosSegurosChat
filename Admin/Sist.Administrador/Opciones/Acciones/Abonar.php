<?
	session_start();
	//error_reporting(0);
	ini_set('display_errors',0);
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../../incluidos/Auditoria/RecargaBalance.php");
	
	$title 	= 'Recargar Cuenta:';
	
	$r2 = mysql_query("SELECT * from personal WHERE id ='".$_GET['id']."'");
    $row = mysql_fetch_array($r2);
	
	$r3 = mysql_query("SELECT * from credito WHERE id_pers ='".$_GET['id']."' ORDER BY id DESC");
    $row3 = mysql_fetch_array($r3);
	
	
	function RecargarCuentaDist(){
	//global $sistema;
	
	
	if($_SESSION['user_id'] && $_POST['id_pers']){
	
				//print_r($_POST);
				// VERIFICAMOS EL MONTO DEL CREDITO ACTUAL 
			    $Ver_monto=mysql_query("SELECT id,id_pers,cred_actual  
				FROM credito WHERE id_pers = '".$_POST['id_pers']."' ORDER BY id DESC LIMIT 1"); 
  			    $QVer_monto=mysql_fetch_array($Ver_monto);
			    $cred_actual = $QVer_monto['cred_actual'] - $_POST['monto'];
			    // VERIFICAMOS EL MONTO DEL CREDITO ACTUAL
			
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				$r2ss = mysql_query("SELECT * from personal WHERE id ='".$_POST['id_pers']."'");
    			$rowss = mysql_fetch_array($r2ss);
				$balance_despues = $rowss['balance'];
				
				mysql_query("
				INSERT INTO credito 
				(id_pers,monto,fecha,realizada_por,balance_anterior,balance_despues,comentario,cred_actual,tipo,id_banco)
				VALUES 
				('".$_POST['id_pers']."','".$_POST['monto']."',now(),'".$_SESSION['user_id']."','".$balance_despues."',
				'".$balance_despues."','".$_POST['comentario']."','".$cred_actual."','".$_POST['tpago']."','".$_POST['banco']."')"); 
				//// MARCAMOS PARA AUDITORIA DE MONTOS AL RECARGADO
				
				
				echo '<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Pago Efectuado con Exito!</h4>
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
				CargarAjax2("Admin/Sist.Administrador/CxC/listado.php?id='.$_POST['id_pers'].'","","GET","cargaajax");
				</script>';
	
			

	
	//$conf['realizada_por'] = $_SESSION['user_id'];
	

	
	}else{
		die( "Error" );	
		AudRecBal($_POST['id_pers'],$_SESSION['user_id'],$_POST['monto'],$bl_actual);
	}
  }
  
	// ACCIONES PARA RECARGAR UN SUB-DISTRIBUIDOR
	if($_POST && $_POST['monto'] >0){
		RecargarCuentaDist($_POST);
	}
	  elseif($_POST && $_POST['monto'] <1){
		echo '<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Error al registrar Pago</h4>
	</div>
		<center><font style="font-size:16px; color:#f00;"><br>
		Por favor verificar sus datos.
		</font></center>
		<br>
		<div class="modal-footer">
		  <a href="#" class="btn btn-danger" id="Cerrar" data-dismiss="modal">Cerrar</a>   
  </div>';
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
        var r=confirm("Realmente desea seguir.\n\n Si esta de acuerdo haga click en Aceptar.");
		
	if (r==true){
	
		CargarAjax2_form('Admin/Sist.Administrador/Opciones/Acciones/Abonar.php','form_edit_prof','recargar_tele'); 
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
    <h4 class="modal-title" id="myModalLabel">Abona cuenta  del dependiente</h4>
</div>

<div class="modal-body">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información de la cuenta del cliente </div>
                     
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active">
                                <p>
                                    <div class="row">
        
          
          
          <!--segunda fila-->
          <div class="col-lg-3">
            <label class="strong">Nombre</label>
          </div>
          <div class="col-lg-3">
            <div class="form-group "><? echo $row['nombres']; ?></div>
          </div>
          <!--segunda fila-->
          
          
           
          
           <!--cuarta fila-->
          <div class="col-lg-3">
            <label class="strong">Balance Actual</label>
          </div>
          <div class="col-lg-3">
            <div class="form-group " style="color:#F00; font-weight:bold;"><?="$".FormatDinero($row3['cred_actual']); ?></div>
          </div>
          <!--cuarta fila-->
        
          <!--quinta fila-->
          <div class="col-lg-3">
            <label class="strong">Banco</label>
          </div>
          <div class="col-lg-9">
            <div class="form-group ">
                <select class="form-control" name="banco" id="banco">
                <?
    $querybanc=mysql_query("
      SELECT * FROM cuentas_de_banco
      WHERE user_id ='".$_SESSION['user_id']."' AND activo ='si'
	  ORDER BY id DESC
		
		");
    
  while($rwebac=mysql_fetch_array($querybanc)){
				?>
                    <option value="<?=$rwebac['id']?>"><?=NombreBanco($rwebac['banco'])." - ".$rwebac['num_cuenta']?></option>
                    <? } ?>
                    
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
                <input name="id_dist" type="hidden" id="id_dist" value="<? echo $_SESSION['user_id']; ?>" /> 
                <input name="fecha" type="hidden" id="fecha" value="<? echo date ('Y-m-d G:i:s');?>" /> 
                <input name="id_pers" type="hidden" id="id_pers" value="<? echo $_GET['id'];?>" /> 
                <input name="tpago" type="hidden" id="tpago" value="Abono" /> 
       </div>     
            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button name="acep" type="button" id="acep" class="btn btn-success" onClick="Recargar();">Abonar</button>
                                            
                                        </div>
	</form>
    </div>
<? } ?>