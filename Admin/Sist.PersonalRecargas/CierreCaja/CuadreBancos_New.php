<?
	ini_set('display_errors', 1);
	session_start();
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
	//include("../../incluidos/info.profesores.php"); 
	include("../../../incluidos/fechas.func.php");
	//include("../../incluidos/ventas.func.php");
	
	// BUSCAMOS ULTIMO CUADRE:
	$UltCua=mysql_query("
	SELECT id,fecha
	FROM cierre_de_caja WHERE user_id ='".$_SESSION['user_id']."'
	GROUP BY fecha ORDER BY id DESC LIMIT 1");
	$UltimoCierre = mysql_fetch_array($UltCua);

	// --------------------------------------------	
	
	//$_GET['fecha1'] = $UltimoCierre['fecha'];
		
	if($_POST['fecha2'])
		$_GET['fecha2'] = $_POST['fecha2'];
		
		
	if($_GET['fecha1']){
		$fecha1 = $_GET['fecha1'];
	}else{
		$fecha1 = fecha_despues(''.date('d/m/Y').'',-0);
	}
	// --------------------------------------------
	if($_GET['fecha2']){
		$fecha2 = $_GET['fecha2'];
	}else{
		$fecha2 = fecha_despues(''.date('d/m/Y').'',0);
	}
	// -------------------------------------------
	
   	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $UltimoCierre['fecha'];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	if(!$fDesde)
		$fDesde 	= $fHasta;
		
	$wFecha 	= "AND fecha_sock >= '$fDesde 00:00:00' AND fecha_sock < '$fHasta 24:00:00'";
	$wFecha2 	= "AND fecha >= '$fDesde' AND fecha < '$fHasta 24:00:00'";
	
	$f_des2		= $fd1[2].$fd1[1].$fd1[0];
	$f_hast2	= $fh1[2].$fh1[1].$fh1[0];

  // Total Recargas:
  $query = mysql_query("
  SELECT * FROM recarga_balance_cuenta WHERE
  realizado_por ='".$_SESSION['user_id']."' 
  $wFecha2
  ORDER BY id DESC");
  while($recarga = mysql_fetch_array($query)){
	  $totalCuentaContado[$recarga['cuenta_banco']] += $recarga['monto'];
  }
  
  // Total Retiros:
  $query2 = mysql_query("
  SELECT * FROM retiro_balance_cuenta 
  WHERE autorizada_por2 ='".$_SESSION['user_id']."' 
  $wFecha2 
  order by id DESC");
   while($retiro = mysql_fetch_array($query2)){
	  $totalRetiro[$retiro['id_banco']] += $retiro['monto'];	  
  } 
	
	
  // Total PAGOS REALIZADOS:
  $query3 = mysql_query("
  SELECT monto,id_banco FROM credito2 WHERE
  tipo = 'abono_credito' AND realizado_por2 ='".$_SESSION['user_id']."'
  $wFecha2 ORDER BY id DESC");
  while($pagos = mysql_fetch_array($query3)){
	$totalIngreso[$pagos['id_banco']] += $pagos['monto'];
  }
	


      // Seleccionando Cuentas Registradas:
      $query = mysql_query("
      SELECT * FROM cuentas_bancos WHERE
      cuenta_no !=0 
      ORDER BY cuenta_no ASC");
      while($cuenta = mysql_fetch_array($query)){
		  
		  $total_recargado[$cuenta['id']] += $totalCuentaContado[$cuenta['id']];
		  $total_retirado[$cuenta['id']] += $totalRetiro[$cuenta['id']];
		  $total_ingreso[$cuenta['id']] += $totalIngreso[$cuenta['id']];
			
		  $TOTALSUM[$cuenta['id']] = ($total_recargado[$cuenta['id']] + $total_ingreso[$cuenta['id']]) - $total_retirado[$cuenta['id']];
		 
		$totalEnCuentaGral[$cuenta['id']] = $_POST["total_cuenta".$cuenta['cuenta_no'].""];
		$totalDiferencia[$cuenta['id']] = $_POST["total_cuenta".$cuenta['cuenta_no'].""] - $TOTALSUM[$cuenta['id']];
        $totalDiferenciaGral[$cuenta['id']] = $totalDiferencia[$cuenta['id']];
		//$totalDiferenciaGral += $totalDiferencia[$cuenta['id']]; asi estaba antes
			
		if(mysql_query(
		  "INSERT INTO cierre_de_caja 
		  (user_id,id_cuenta,total_recargado,total_en_caja,diferencia,fecha_ult_cierre,total_retirado,total_ingreso)
		  VALUES
		  ('".$_SESSION['user_id']."','".$cuenta['id']."','".$total_recargado[$cuenta['id']]."',
		  '".$totalEnCuentaGral[$cuenta['id']]."','".$totalDiferenciaGral[$cuenta['id']]."','".$UltimoCierre['fecha']."','".$total_retirado[$cuenta['id']]."','".$total_ingreso[$cuenta['id']]."')"
		))
		{
				
		}
		
		echo mysql_error();
      
     } 
	 
	 
	 exit(
	 '
	 <center>
	 <P><P>
		 <HR>
			 <font size="7">OK</font><br>
			 <font size="6"> CIERRE COMPLETADO! </font><br>
		 <HR>
	 </center>
	 '
	 );

?>
      