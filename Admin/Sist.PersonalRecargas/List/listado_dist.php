<?

	session_start();
	set_time_limit(0);
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
	//include('../../incluidos/db_datos.func.php');
	include('../../../incluidos/bd_manejos.php');
	include('../../../incluidos/auditoria.func.php');
	include('../../../incluidos/credito.func.php');
	//include('Func/Email.php'); 
	//include('../../incluidos/ventas.func.php');
	$r2 = mysql_query("SELECT * from personal WHERE id ='".$_POST['id']."'");
    $row_dep = mysql_fetch_array($r2);
	$claro 		= $row_dep['desc1'];
	$orange 	= $row_dep['desc2'];
	$viva 		= $row_dep['desc3'];
	$tricom		= $row_dep['desc4'];
	$digicel 	= $row_dep['desc5'];
	$moun 		= $row_dep['desc6'];
	$natcom 	= $row_dep['desc7'];
	$seguro_porc1 		= $row_dep['seguro_porc1'];
	$seguro_porc2 		= $row_dep['seguro_porc2'];
	
	

	function enviarEmailSuperAdmin()
	{
		require_once('../../incluidos/Email/class.phpmailer.php');
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		try {
		  $correo_emisor	="info@multirecargas.com.do"; 
		  $nombre_emisor	="Info Multirecargas";
		  $contrasena		="admin1234"; 
		  $mail->SMTPDebug  = false;                    
		  $mail->SMTPAuth   = true;
		  $mail->SMTPSecure = "ssl";
		  $mail->Host       = "smtpout.secureserver.net";
		  $mail->Port       = 465;   
		  $mail->Username   = $correo_emisor;  // Usuario Gmail
		  $mail->Password   = $contrasena;     // Contraseña Gmail
		  $mail->AddReplyTo($correo_emisor, $nombre_emisor);
		  $mail->AddAddress("jnconil@hotmail.com", $nombre_destino);
		  /*$mail->AddAddress("multirecargas.ing2@gmail.com", $nombre_destino);*/
		  $mail->AddAddress("multirecargas.ing@gmail.com", $nombre_destino);
		  $mail->AddAddress("elizabetho@multirecargas.com.do", $nombre_destino);
	
		  $mail->SetFrom($correo_emisor, $nombre_emisor);
		  $mail->Subject = 'Notificacion: Registro de usuario!';
		  $mail->AltBody = 'para ver el mensaje necesita HTML.';
		  
		  // consultar nombre dist.:
		   $query1=mysql_query("
			SELECT id,nombres
			FROM personal WHERE id ='".$_SESSION['user_id']."' LIMIT 1");
			$p0=mysql_fetch_array($query1);
			$nombre_registro = $p0['nombres'];
		  //....
		  
			
			$mail->MsgHTML(
			"<br><br>
		
	<table width='450' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px #CCCCCC;' align='center'>
	  <tbody>
		<tr>
		  <td>
		  <table border='0' cellspacing='0' cellpadding='0' width='450'>
			<tbody>
			  <tr>
				<td align='center' bgcolor='#E8E8E8' height='40' valign='middle' style='color:#666666'>
				NOTIFICACION DE REGISTRO
				<br>MULTIPLESRECARGAS.COM
				
				</td>
			  </tr>
			</tbody>
		  </table>
			<table width='450' border='0' align='center' cellpadding='3' cellspacing='0'>
			  <tbody>
				<tr>
				  <td align='left'>&nbsp;</td>
				</tr>
				<tr>
				  <td align='left'><font style='font-size:18px;'>Datos del contacto</font>				    <hr style='padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;'></td>
				</tr>
				<tr>
				  <td align='left'>Nombre: ".$_POST['nombres']."</td>
			    </tr>
				<tr>
				  <td width='406' align='left'>Direccion: ".$_POST['direccion']."</td>
			    </tr>
				
				<tr>
				  <td align='left'>Email: ".$_POST['email']."</td>
				  </tr>
				<tr>
				  <td align='left'>Telefono: ".$_POST['celular']."</td>
				  </tr>
				<tr>
				  <td align='left'><strong>Nivel: Distribuidor </strong></td>
			    </tr>
				<tr>
				  <td align='left'>
				  
				  <strong>Registrado por: 
				  <font color='#0066CC'>
				  ".$nombre_registro."</font> (".$_SESSION['user_id'].")
				  </b></strong>
				  
				  </td> 
			    </tr>
				
				<tr>
				  <td align='left'>&nbsp;</td>
				  </tr>
				<tr>
				  <td align='left'><font style='font-size:18px;'>Porcientos de compañias</font>
				    <hr style='padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;'></td>
				  </tr>
				<tr>
				  <td align='left'>Claro: ".$_POST['desc1']."</td>
				  </tr>
				<tr>
				  <td align='left'>Orange: ".$_POST['desc2']."</td>
				  </tr>
				<tr>
				  <td align='left'>Viva: ".$_POST['desc3']."</td>
				  </tr>
				<tr>
				  <td align='left'>Tricom: ".$_POST['desc4']."</td>
				  </tr>
				<tr>
				  <td align='left'>Digicel: ".$_POST['desc5']."</td>
				  </tr>
				<tr>
				  <td align='left'>Moun: ".$_POST['desc6']."</td>
				  </tr>
				<tr>
				  <td align='left'>Seguro de vida: ".$_POST['seguro_porc1']."</td>
				  </tr>
				<tr>
				  <td align='left'>Seguro de vehiculo: ".$_POST['seguro_porc2']."</td>
				  </tr>
				<tr>
				  <td align='left'>&nbsp;</td>
				  </tr>
				<tr>
				  <td align='left'><font style='font-size:18px;'>Datos de Acceso</font><hr style='padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;'></td>
				  </tr>
				<tr>
				  <td align='left'>ID: ".IDCLIENTE."</td>
			    </tr>
				<tr>
				  <td align='left'>Usuario: ".$_POST['user']."</td>
			    </tr>
				<tr>
				  <td align='left'>Clave: * * * * * * *</td>
			    </tr>
				<tr>
				  <td align='left'>&nbsp;</td>
			    </tr>
				
			  </tbody>
			</table>
		  </td>
		</tr>
	  </tbody>
	</table>
");
			
			$mail->Send();
			//echo "<br><center>Notificado a: <b>".$_POST['email']."</b></center>";
		} catch (phpmailerException $e) {
		  echo $e->errorMessage();
		  //echo " ".$_POST['email'];
		} catch (Exception $e) {
		  echo $e->getMessage(); 
		  //echo " ".$_POST['email'];
		}
	}

	function enviarEmailCliente()
	{
		require_once('../../incluidos/Email/class.phpmailer.php');
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		try {
		  $correo_emisor	="info@multirecargas.com.do"; 
		  $nombre_emisor	="Info Multirecargas";
		  $contrasena		="admin1234"; 
		  $mail->SMTPDebug  = false;                    
		  $mail->SMTPAuth   = true;
		  $mail->SMTPSecure = "ssl";
		  $mail->Host       = "smtpout.secureserver.net";
		  $mail->Port       = 465;   
		  $mail->Username   = $correo_emisor;  // Usuario Gmail
		  $mail->Password   = $contrasena;     // Contraseña Gmail
		  $mail->AddReplyTo($correo_emisor, $nombre_emisor);
		  $mail->AddAddress($_POST['email'], $nombre_destino);
	//emailadmin
		  $mail->SetFrom($correo_emisor, $nombre_emisor);
		  $mail->Subject = 'Notificacion: Registro de usuario!';
		  $mail->AltBody = 'para ver el mensaje necesita HTML.';
			
			$mail->MsgHTML(
			"<br><br>
		<table width='450' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px #CCCCCC;' align='center'>
	  	<tbody>
		<tr>
		  <td>
		  <table border='0' cellspacing='0' cellpadding='0' width='450'>
			<tbody>
			  <tr>
				<td align='center' bgcolor='#E8E8E8' height='40' valign='middle' style='color:#666666'>CONFIRMACION DE REGISTRO<br>
			    MULTIPLESRECARGAS.COM</td>
			  </tr>
			</tbody>
		  </table>
			<table width='450' border='0' align='center' cellpadding='3' cellspacing='0'>
			  <tbody>
				<tr>
				  <td align='left'>&nbsp;</td>
				</tr>
				<tr>
				  <td align='left'><font style='font-size:18px;'>Datos del contacto</font><hr style='padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;'></td>
				</tr>
				<tr>
				  <td align='left'>Nombre: ".$_POST['nombres']."</td>
			    </tr>
				<tr>
				  <td width='406' align='left'>Direccion: ".$_POST['direccion']."</td>
			    </tr>
				
				<tr>
				  <td align='left'>Email: ".$_POST['email']."</td>
				  </tr>
				<tr>
				  <td align='left'>Telefono: ".$_POST['celular']."</td>
				  </tr>
				
				<tr>
				  <td align='left'>&nbsp;</td>
				  </tr>
				<tr>
				  <td align='left'><font style='font-size:18px;'>Porcientos de compañias</font>
				    <hr style='padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;'></td>
				  </tr>
				<tr>
				  <td align='left'>Claro: ".$_POST['desc1']."</td>
				  </tr>
				<tr>
				  <td align='left'>Orange: ".$_POST['desc2']."</td>
				  </tr>
				<tr>
				  <td align='left'>Viva: ".$_POST['desc3']."</td>
				  </tr>
				<tr>
				  <td align='left'>Tricom: ".$_POST['desc4']."</td>
				  </tr>
				<tr>
				  <td align='left'>Digicel: ".$_POST['desc5']."</td>
				  </tr>
				<tr>
				  <td align='left'>Moun: ".$_POST['desc6']."</td>
				  </tr>
				<tr>
				  <td align='left'>Seguro de vida: ".$_POST['seguro_porc1']."</td>
				  </tr>
				<tr>
				  <td align='left'>Seguro de vehiculo: ".$_POST['seguro_porc2']."</td>
				  </tr>
				<tr>
				  <td align='left'>&nbsp;</td>
				  </tr>
				<tr>
				  <td align='left'><font style='font-size:18px;'>Datos de Acceso</font><hr style='padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;'></td>
				  </tr>
				<tr>
				  <td align='left'>ID: ".IDCLIENTE."</td>
			    </tr>
				<tr>
				  <td align='left'>Usuario: ".$_POST['user']."</td>
			    </tr>
				<tr>
				  <td align='left'>Clave: ".$_POST['password']."</td>
			    </tr>
				<tr>
				  <td align='left'>&nbsp;</td>
			    </tr>
				
			  </tbody>
			</table>
		  </td>
		</tr>
	  </tbody>
	</table>
");
			
			$mail->Send();
			//echo "<br><center>Notificado a: <b>".$_POST['email']."</b></center>";
		} catch (phpmailerException $e) {
		  echo $e->errorMessage();
		  //echo " ".$_POST['email'];
		} catch (Exception $e) {
		  echo $e->getMessage(); 
		  //echo " ".$_POST['email'];
		}
	}
	
	
	function enviarEmailClienteModPorcientos()
	{
	
		
		require_once('../../incluidos/Email/class.phpmailer.php');
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		try {
		  $correo_emisor	="info@multirecargas.com.do"; 
		  $nombre_emisor	="Info Multirecargas";
		  $contrasena		="admin1234"; 
		  $mail->SMTPDebug  = false;                    
		  $mail->SMTPAuth   = true;
		  $mail->SMTPSecure = "ssl";
		  $mail->Host       = "smtpout.secureserver.net";
		  $mail->Port       = 465;   
		  $mail->Username   = $correo_emisor;  // Usuario Gmail
		  $mail->Password   = $contrasena;     // Contraseña Gmail
		  $mail->AddReplyTo($correo_emisor, $nombre_emisor);
		  $mail->AddAddress($_POST['email'], $nombre_destino);
		  $mail->AddAddress("jnconil@hotmail.com", $nombre_destino);
	//emailadmin
		  $mail->SetFrom($correo_emisor, $nombre_emisor);
		  $mail->Subject = 'Notificacion: Cambio de margenes!';
		  $mail->AltBody = 'para ver el mensaje necesita HTML.';
			
			$mail->MsgHTML(
			"<br><br>
			
			
	
        
        
	<table width='100%' border='0' cellpadding='3' cellspacing='0' style='border:solid 1px #CCCCCC;' align='center'>
			  <tbody>
              
              
				<tr>
				<td align='center' bgcolor='#E8E8E8' height='40' valign='middle' style='color:#666666' colspan='2'>MODIFICACION DE PORCIENTOS<br>
			    </td>
			 
			    </tr>
                
                <tr>
				  <td colspan='2' align='left'>&nbsp;</td>
			    </tr>
                <tr>
				  <td colspan='2' align='left'>Se&ntilde;or(a):  ".$_POST['nombres']."</td>
			    </tr>

				<tr>
				  <td colspan='2' align='left'>&nbsp;</td>
			    </tr>
				<tr>
    <td style='text-align:justify' colspan='2'>Por este medio les comunicamos que en vista a las pol&iacute;ticas de las prestadoras de servicios de telecomunicaciones,  sobre el margen de comercialización de las recargas, que es un margen regulado,  a partir de la fecha nos veremos en la obligaci&oacute;n irrevocable  de realizar una peque&ntilde;a disminuci&oacute;n en  los % de ganancias que hoy reciben.</td>
  </tr>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr><tr>
    <td colspan='2'>A partir de la fecha su comisi&oacute;n sera de:</td>
  </tr>
				<tr>
				  <td colspan='2' align='left'>&nbsp;</td>
			    </tr>
				<tr>
				  <td width='147' align='left'><strong>Claro:</strong></td>
				  <td width='173' align='left'>".$_POST['desc1']."</td>
			    </tr>
				<tr>
				  <td align='left'><strong>Orange: </strong></td>
				  <td align='left'>".$_POST['desc2']."</td>
			    </tr>
				<tr>
				  <td align='left'><strong>Viva: </strong></td>
				  <td align='left'>".$_POST['desc3']."</td>
			    </tr>
				<tr>
				  <td align='left'><strong>Tricom: </strong></td>
				  <td align='left'>".$_POST['desc4']."</td>
			    </tr>
				<tr>
				  <td align='left'><strong>Digicel: </strong></td>
				  <td align='left'>".$_POST['desc5']."</td>
			    </tr>
				<tr>
				  <td align='left'><strong>Moun: </strong></td>
				  <td align='left'>".$_POST['desc6']."</td>
			    </tr>
				<tr>
				  <td align='left'><strong>Natcom:</strong></td>
				  <td align='left'>".$_POST['desc7']."</td>
			    </tr>
				<tr>
				  <td align='left'>&nbsp;</td>
				  
				  <td align='left'>&nbsp;</td>
			    </tr>
				<tr>
				  <td colspan='2' align='left'><font style='font-size:18px;'>Porcientos de seguros</font>
				    <hr style='padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;'></td>
			    </tr>
				
				<tr>
				  <td align='left'>&nbsp;</td>
				  
				  <td align='left'>&nbsp;</td>
			    </tr>
				<tr>
				  <td align='left'><strong>Seguro de vida: </strong></td>
				  <td align='left'>".$_POST['seguro_porc1']."</td>
			    </tr>
				<tr>
				  <td align='left'><strong>Seguro de vehiculo: </strong></td>
				 
				  <td align='left'>".$_POST['seguro_porc2']."</td>
			    </tr>
				
			  <tbody>
			  <tr>
				<td align='center' bgcolor='#E8E8E8' height='40' valign='middle' style='color:#666666' colspan='2'><br>
			    Gracias por confiar en nosotros <br>Equipo Múltiples Recargas. <br>
Esperamos poder seguir sirviendoles en el uso de nuestra plataforma.<br>


809-824-8087 - Equipo Multirecargas</td>
			  </tr>
			</tbody>
			</table>
		
		
			
			
			");
			
			$mail->Send();
			//echo "<br><center>Notificado a: <b>".$_POST['email']."</b></center>";
		} catch (phpmailerException $e) {
		  echo $e->errorMessage();
		  //echo " ".$_POST['email'];
		} catch (Exception $e) {
		  echo $e->getMessage(); 
		  //echo " ".$_POST['email'];
		}
	}
	
	$acc1 = $_POST['accion'].$_GET['action'];
	
	//echo $_POST['id'];
	if($acc1=='eliminar'){
		
		$id=$_GET['id'];
		$query=mysql_query("UPDATE personal SET activo ='no' WHERE id='$id'");
		
		// MARCAMOS PARA AUDITORIA
		Auditoria($_SESSION['user_id'],$id,'desact_distribuidor','Se desactivo este Distribuidor.',$campus_id);
		// MARCAMOS PARA AUDITORIA
	
	echo '<script> AlertRespuestaOK("Deshabilitado!"); </script>';
	}

	// EDITAR
	if($acc1=='editar'){
		
		// MARCAMOS PARA AUDITORIA
		Auditoria($_SESSION['user_id'],$_POST['id'],'actualizacion_distribuidor','Se actualizo este Distribuidor.',$campus_id);
		// MARCAMOS PARA AUDITORIA
		
	//if($_POST['id'] ='4341'){
		if($claro != $_POST['desc1']){
			enviarEmailClienteModPorcientos();
		}elseif($orange != $_POST['desc2']){
			enviarEmailClienteModPorcientos();
		}elseif($tricom != $_POST['desc4']){
			enviarEmailClienteModPorcientos();
		}elseif($viva != $_POST['desc3']){
			enviarEmailClienteModPorcientos();
		}elseif($digicel != $_POST['desc5']){
			enviarEmailClienteModPorcientos();
		}elseif($moun != $_POST['desc6']){
			enviarEmailClienteModPorcientos();
		}elseif($natcom != $_POST['desc7']){
			enviarEmailClienteModPorcientos();
		}elseif($seguro_porc1 != $_POST['seguro_porc1']){
			enviarEmailClienteModPorcientos();
		}elseif($seguro_porc2 != $_POST['seguro_porc2']){
			enviarEmailClienteModPorcientos();
		}
	//}
		
		EditarForm('personal');
		
		echo'
		<script>
			$.prompt.close();
			AlertRespuestaOK("Datos Modificados!");
		</script>
		';
		
		
		
	}
	
	// REGISTRAR NUEVO
	if($acc1=='registrar'){
	
		Insert_form('personal');
		define("IDCLIENTE",mysql_insert_id());
		
		// MARCAMOS PARA AUDITORIA
		Auditoria($_SESSION['user_id'],$id,'registro_distribuidor','Se registro este Distribuidor.',$campus_id);
		// MARCAMOS PARA AUDITORIA

		echo'
		<script>
		$.prompt.close();
		AlertRespuestaOK("'.$_POST['nombres'].' fue Registrado!");
		</script>
		';
		
		enviarEmailCliente();
		enviarEmailSuperAdmin();
		
	}
	
	// ORDENAR POR
	
	if(!$_GET['ordenar']){
		$ordenar = 'nombres ASC';
	}else{
		$ordenar = $_GET['ordenar'];
	}
	
    
	?>

<ul class="breadcrumb">
	<li>Tu estas Aqui</li>
	<li class="divider"></li>
	<li>Listados de clientes</li>
</ul>
<div class="row-fluid">
	<div class="span10"><h2>Listados de clientes</h2></div>
    <div class="span2" style="background-color:#FFFFCC; font-size:14px; color:#FF6600; padding-top:3px; padding-left:3px;"> 
    
		<? if(!$_GET['show_cred']){ $est = 1;	}else{ $est = ''; }?>
        <input name="show_cred" value="1" type="checkbox" <? if($_GET['show_cred']){?>checked <? }?> 
        onchange="CargarAjax2('Admin/Sist.PersonalRecargas/List/listado_dist.php?show_cred=<?=$est?>&actual=<?=$_GET['actual']?>&busq=<?=$_GET['busq']?>','','GET','cargaajax');"/><b>Mostrar Creditos</b>
    </div>
</div>


			<? if($acc1=='eliminar'){?>
           <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este punto de venta se ha desabilitado correctamente</span>
             <? }else if($acc1=='editar'){?>
               <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este punto de venta se ha editado correctamente</span>
             <? }else if($acc1=='registrar'){?>
               <span class="label label-success" style="display:none; margin-left:15px; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="actul">Este punto de venta se ha registrado correctamente</span>
             <? } ?>
	<!-- Widget -->
  <div class="innerLR">
	<div class="widget widget-heading-simple widget-body-gray">
		<div class="widget-body">
		
			<!-- Table -->
<table class="dynamicTable tableTools table-hover table table-striped table-bordered table-primary table-white">
<thead>
  <tr>
    <th>ID/No.</th>
    <th>Cliente: </th>
    <th>Balance:</th>
    <th>Nivel:</th>
    <!--<th>CxP:</th>-->
    <th>CxC:</th>
   
    <th colspan="6" >Acciones:</th>
    </tr>
    </thead>
    </tr>
  <? 
  	
	// BUSCAR
	if($_GET['busq']){
		$where = "AND (nombres LIKE '%".$_GET['busq']."%' OR id='".$_GET['busq']."')";
	}else{
		$where = " AND id_dist !=''";
	}
	
  
 	// PAGINACION DE RESULTADOS
	$conf['limit'] = 50;
	$total = mysql_num_rows(mysql_query("
	SELECT id FROM personal WHERE nombres !='' AND funcion_id NOT IN (1,34) AND activo !='no' $where"));
   $actual = $_GET['actual'];
   if(empty($actual)){ $actual = 0; }
  
   if($actual == 0){
   	$desde = $actual; }
   else{
   	$desde = $actual * $conf['limit'];
   }
   $totalpaginas1 = $total / $conf['limit']; 
   $totalpaginas = round($totalpaginas1); // Total de paginas Redondeada...
   //$totalpaginas = $totalpaginas + 1;
   $paginar = "LIMIT $desde,".$conf['limit'].""; // variable ya definida para paginar...



	// ORDENAR POR
	
	if(!$_GET['ordenar']){
		$ordenar = ' floor(balance) DESC';
	}else{
		$ordenar = $_GET['ordenar'];
	}

	// ************************
	
  $query=mysql_query("
  	SELECT * FROM personal 
  	WHERE nombres !='' AND funcion_id NOT IN (1,34) 
  		#AND (id_dist = '6' OR id_dist='3462' OR id_dist='7195' OR id_dist='2468' OR id_dist='645') 
		AND activo !='no' $where  
	ORDER BY $ordenar $paginar "); 
  while($row=mysql_fetch_array($query))
  {
	  
	  $celular = str_replace("-", "", $row['celular']);
	 $in = $celular;
     $in_cel =  "(".substr($in,0,3).") ".substr($in,3,-4)."-".substr($in,-4);
    
	  $cco++; 
		if(($cco%2)==0){ 
		$color = '#FFFFFF'; 
		}else{ 
		$color = '#E6E6E6'; 
		}
?>
  
  <tr>
  
  <td bgcolor="<?php echo $color; ?>"><? echo $row['id'];?></td>
  <td bgcolor="<?php echo $color; ?>"><? echo $row['nombres']." <br>".$in_cel;?></td>
  <td bgcolor="<?php echo $color; ?>">
  
  <? 
     if($row['balance']==''){ echo "$0.00"; 
	 	}elseif($row['balance'] <= $row['alert_balance']){ 
			echo '<font style="font-size:18px;">'.FormatDinero($row['balance']);  $balance += $row['balance']
			.'</font> <span class="label label-danger"> Alert!</span>';
		}else{  
			echo "<font style='font-size:23px;'>".FormatDinero($row['balance'])."</font>";  $balance += $row['balance']; 
		} 
	
	
	
   ?>
    </td>
  <td width="10%"  bgcolor="<?php echo $color; ?>">
	  <? 
	  if($row['funcion_id'] ==2) echo "Nivel <b>2</b>"; 
	  else if($row['funcion_id'] ==5) echo "Nivel <b>5</b>";
	  else if($row['funcion_id'] ==3) echo "Nivel <b>3</b>";
	  ?> 
  </td>

  <td bgcolor="<?php echo $color; ?>">
  <a href="#" onclick="CargarAjax2('Admin/Sist.PersonalRecargas/Dep/Depositos_Cuenta_Dist.php?dist_id=<? echo $row['id']; ?>&amp;Vnombres=<? echo $row['nombres']; ?>','','GET','cargaajax');">

	<?=ACredActual($row['id'])?>
</a>

</td>
   
    
    <td bgcolor="<?php echo $color; ?>">
      
      <a href="#" class="btn btn-default" onclick="CargarAjax2('Admin/Sist.PersonalRecargas/Dep/Depositos_Cuenta_Dist.php?dist_id=<? echo $row['id']; ?>&amp;Vnombres=<? echo $row['nombres']; ?>','','GET','cargaajax');">Transf.</a>
    
    
     
       <a href="#" class="btn btn-default" onclick="CargarAjax2('Admin/Sist.PersonalRecargas/CxC/listado.php?id=<?=$row['id']; ?>','','GET','cargaajax');">CxC</a>
      
      <? 
	    /* if($row['id_dist']=='6'    || $row['id_dist'] == '6'  || $row['id_dist']=='3462' || 
	     $row['id_dist']=='7195' || $row['id_dist']=='2468' || $row['id_dist']=='645'){ */
		 
		 
	  ?>
      
      <a href="#" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/Opciones/RecargarCliente_v3.php?id=<? echo $row['id']; ?>','form_edit_prof','cargaajax')" data-toggle="tooltip" data-title="Recargar" data-placement="bottom" class="btn-action glyphicons usd btn-default" 
    style=" background-color:#FFF !important;"><i></i></a>
     
      
     <!-- <a href="#" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/Opciones/Recargar.php?dist_id=<? echo $row['id']; ?>','form_edit_prof','cargaajax')" data-toggle="tooltip" data-title="Recargar" data-placement="bottom" class="btn-action glyphicons usd btn-default" ><i></i></a>-->
      <?
	  
	   if($_SESSION['user_id']=='8485'){?> 
    <!--  <a href="#" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/Opciones/Recargar.php?dist_id=<?=$row['id']?>','form_edit_prof','cargaajax')" data-toggle="tooltip" data-title="Recargar" data-placement="bottom" class="btn-action glyphicons usd btn-default" ><i style="color:#06C;"></i>.</a>-->
      
      <? } ?>
      
      
      <a href="#" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/Opciones/RetiroRecargaCliente_v3.php?id=<? echo $row['id']; ?>','form_edit_prof','cargaajax')" data-toggle="tooltip" data-title="Retirar Deposito/Recarga" data-placement="bottom" class="btn-action glyphicons ban btn-default" ><i></i></a>
      
      
      <a href="#" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/Opciones/AsignarCuentaSinc_v2.php?id=<? echo $row['id']; ?>','form_edit_prof','cargaajax')" data-toggle="tooltip" data-title="Modificar Datos de Automatizacion" data-placement="bottom" class="btn btn-default" >C</a>
      
      <a href="#" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/List/Depositos_Cuenta_v2.php?user_id=<? echo $row['id']; ?>','form_edit_prof','cargaajax')" data-toggle="tooltip" data-title="Depositos Detallados" data-placement="bottom" class="btn btn-default" >D</a>
      
      <!--<a href="#" onclick="CargarAjax_win('Admin/Sist.PersonalRecargas/Opciones/Retirar_balance.php?dist_id=<? echo $row['id']; ?>','form_edit_prof','cargaajax')" data-toggle="tooltip" data-title="Retirar saldo" data-placement="bottom" class="btn-action glyphicons ban btn-default"><i></i></a>-->
      
     </td>
  </tr> 
  <? } ?>
  
     <td colspan="8">
     <table width="100%" border="0" cellpadding="2" cellspacing="0" id="listas-paginacion">
      <tr>
        <td width="30%">
<? // ANTERIOR.....
   $ordenactual = $_GET['ordenar'];
   
   if($actual >= 1){
	   $ant_url = "$actual" - 1;
	   echo"<a href='javascript:'  onclick=\"CargarAjax2('Admin/Sist.PersonalRecargas/listado_dist.php?actual=$sig_url','','GET','cargaajax');\"><strong>< Anterior</strong></a>";
   }
   ?></td>
        <td><center><em><font color="#999999">Pagina:</font></em><strong>
  <?
   $pag_actual = "$actual" + 1;
   echo"$pag_actual";
   ?>
  </strong> <em>de </em><strong>
  <? echo"$totalpaginas "; ?>
  </strong>
        </center>        </td>
        <td width="30%">
<? // SIGUIENTE.....
   // si es menol lo muestra....
   if ($pag_actual >= $totalpaginas){
    echo"";
   }
   else {
	   $sig_url = "$actual" + 1;
	   echo"<a href='javascript:' onclick=\"CargarAjax2('Admin/Sist.PersonalRecargas/listado_dist.php?actual=$sig_url','','GET','cargaajax');\"><strong> Siguiente ></strong></a>";
   }
   // si es Igual no muestra...
   ?></td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
