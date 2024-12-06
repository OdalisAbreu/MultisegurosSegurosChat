<?
$email = 'linksdominicana@gmail.com';
$email2 = 'grullon.jose@gmail.com';
require_once('class.phpmailer.php');
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		try {
		  $correo_emisor	="afiliaciones@multiseguros.com.do"; 
		  $nombre_emisor	="Info Multiseguros";
		  $contrasena		="v2anyp"; 
		  $mail->SMTPDebug  = false;                    
		  $mail->SMTPAuth   = true;
		  $mail->SMTPSecure = "ssl";
		  $mail->Host       = "sunday.segurosrd.com";
		  $mail->Port       = 465;   
		  $mail->Username   = $correo_emisor;  // Usuario Gmail
		  $mail->Password   = $contrasena;     // Contraseña Gmail
		  $mail->AddReplyTo($correo_emisor, $nombre_emisor);
		  $mail->AddAddress($email, 'ing willy');
		  $mail->AddReplyTo($email2, 'Jose Grullon');
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
			echo "<br><center>Notificado a: <b>".$email."</b></center>";
		} catch (phpmailerException $e) {
		  echo $e->errorMessage();
		  echo " ".$email;
		} catch (Exception $e) {
		  echo $e->getMessage(); 
		  echo " ".$email;
		}
?>