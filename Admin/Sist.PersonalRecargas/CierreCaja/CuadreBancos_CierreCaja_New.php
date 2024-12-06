<?
	ini_set('display_errors', 1);
	session_start();
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
	include("../../../incluidos/fechas.func.php");
	
	// BUSCAMOS ULTIMO CUADRE:
	$UltCua=mysql_query("
	SELECT id,fecha
	FROM cierre_de_caja WHERE user_id ='".$_SESSION['user_id']."'
	GROUP BY fecha ORDER BY id DESC LIMIT 1");
	$UltimoCierre = mysql_fetch_array($UltCua);

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
	$wFecha2 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00'";
	
	$f_des2		= $fd1[2].$fd1[1].$fd1[0];
	$f_hast2	= $fh1[2].$fh1[1].$fh1[0];

 // Total Recargas:
  $query = mysql_query("
  SELECT monto,cuenta_banco,realizado_por FROM recarga_balance_cuenta WHERE
  realizado_por ='".$_SESSION['user_id']."' 
  $wFecha2
  ORDER BY id DESC");
  //echo mysql_num_rows($query);
  while($recarga = mysql_fetch_array($query)){
	  
	  $totalCuentaContado[$recarga['cuenta_banco']] += $recarga['monto'];
  }
 
  $query2 = mysql_query("
  SELECT monto,id_banco FROM retiro_balance_cuenta 
  WHERE autorizada_por2 ='".$_SESSION['user_id']."' $wFecha2 order by id DESC");
  while($retiro = mysql_fetch_array($query2)){
	  $totalRetiro[$retiro['id_banco']] += $retiro['monto'];	  
  }
  
   $query3 = mysql_query("
  SELECT monto,id_banco FROM credito2 
  WHERE realizado_por2 ='".$_SESSION['user_id']."' AND tipo ='abono_credito' $wFecha2 order by id DESC");
  while($ingreso = mysql_fetch_array($query3)){
	  $totalIngreso[$ingreso['id_banco']] += $ingreso['monto'];	  
  }

?>

</head>
<body>

<DIV ID="seleccion" style="padding:5px;">
    <form id="form_cuadre">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td bgcolor="#FFFFF2">
        <center>
          <b><font size="6">Cierre de Caja.</font></b><br>
    
            <font size="2">Ultimo Cierre de Caja :</font> 
            <font size="2" color="#FF0000"><b><?=$UltimoCierre['fecha']?></b></font>
          </center>
          </td>
      </tr>
    </table>
<!--bordercolor="#D6D6D6" style="border: solid 1px #CCCCCC;"-->
    <table width="100%" border="0" align="center" cellpadding="8" cellspacing="0">
      <!--<tr class="listados_enc">-->
        <!--<td width="0">No.</td>
        <td width="0">Banco / Cuenta:</td>-->
        <!--<td width="0">Total Recargado:</td>-->
        <!--<td width="0">Total en Cuenta:</td>-->
        <!--<td width="0">1</td>
        <td width="0">1</td>
        <td width="0">1</td>-->
      <!--</tr>-->
      <?
      // Seleccionando Cuentas Registradas:
      $query = mysql_query("
      SELECT * FROM cuentas_bancos WHERE
      cuenta_no !=0 
      ORDER BY cuenta_no ASC");
      while($cuenta = mysql_fetch_array($query)){
      
      ?>
      
      
      <tr class="listado" style="height:40px; border-bottom:solid 1px #D6D6D6">
        <!--<td>[ <? echo $cuenta['id'] ?> ]</td>-->
        <td><? echo $cuenta['nombre']; ?></b> (#</font><?=$cuenta['cuenta_no']?>)
          <? if($cuenta['a_nombre_de'] !=='') { ?> <br>A nombre de <b><? echo $cuenta['a_nombre_de']; }?></b>
        </td>
       <td class="box_div"><font size="5">
          <?
			$total_recargado += $totalCuentaContado[$cuenta['id']];
			$total_retirado	+= $totalRetiro[$cuenta['id']];
			$total_ingreso 	+= $totalIngreso[$cuenta['id']];
			
			$totalsuma[$cuenta['id']] = ($totalCuentaContado[$cuenta['id']] + $totalIngreso[$cuenta['id']]) - $totalRetiro[$cuenta['id']];
			
        echo "<font style='font-size:12px;'>Efectivo ".FormatDinero($totalCuentaContado[$cuenta['id']])."</font><br>";
        echo "<font style='font-size:12px;'>Retiros ".FormatDinero($totalRetiro[$cuenta['id']])."</font><br>";
		echo "<font style='font-size:12px;'>Ingreso ".FormatDinero($totalIngreso[$cuenta['id']])."</font><br>";
		 echo "<font style='font-size:12px;'><b>Total: </b> ".FormatDinero($totalsuma[$cuenta['id']])."</font><br>";
        ?>
        </font></td>
        
        <td><input name="total_cuenta<?=$cuenta['cuenta_no']?>" id="total_cuenta<?=$cuenta['cuenta_no']?>" type="text" style=" font-size:38px; padding:4px; height:70px" value="<?=$_POST["total_cuenta".$cuenta['cuenta_no'].""]?>" class="cuenta_montos" >
          
          <? if($cuenta['cuenta_no']==1){ ?>
          <!--<input name="mostrar_cuadre_efectivo" type="button">-->
          
         
          <? } ?>
           
          
        </td>
       <!-- <td>1</td>
        <td align="left">1</td>
        <td>1</td>-->
      </tr>
      
      
      <?
      }
      ?>
      
      <tr class="listados_enc" style="border-bottom:solid 1px #D6D6D6">
      <!--  <td width="0"></td>-->
      
        <!--<td width="0"><font size="5" >
          <?
        
            //echo FormatDinero($TOTALSUM);
        
        ?>
        </font></td>-->
        <td width="0" colspan="3" align="right"><font size="5" color="#000000">
          
		  <div id="total_cuenta_montos" style="padding-left:35px">Monto Total 
		  <?
        $totalEnCuentaGral = ($total_recargado + $total_ingreso)- $total_retirado;
            echo "$".FormatDinero($totalEnCuentaGral);
        
        ?>
        </div>
        </font></td>
        
      </tr>
        <tr>
          <td colspan="3">
            <center>
            <input name="cal_cuadre" type="button" value="Cerrar Caja" onClick="CargarAjax2_form('Admin/Sist.PersonalRecargas/CierreCaja/CuadreBancos_New.php','form_cuadre','cargaajax'); " class="btn btn-primary">
            </center>
          </td>
        </tr>
    </table>
    </form>
</div>
<script>
	$(document).ready(function(e) { $("#total_cuenta1").focus(function(e) { $("#div_arqueo_efectivo").fadeIn(0); });
	$("#total_cuenta1").focusout(function(e) { $("#div_arqueo_efectivo").fadeOut(0); }); });
	
	function SumarArqueo(){ var dosmil 		= $("#dosmil").val(); var mil 		= $("#mil").val(); var quinientos  = $("#quinientos").val(); var doscientos  = $("#doscientos").val(); var cien 		= $("#cien").val(); var cincuenta 	= $("#cincuenta").val(); var veintecinco	= $("#veintecinco").val(); var veinte		= $("#veinte").val(); var diez 		= $("#diez").val(); var cinco		= $("#cinco").val(); var uno			= $("#uno").val(); var dosmil2			= 2000 * dosmil; var mil2 			= 1000 * mil; var quinientos2 	= 500 * quinientos; var doscientos2 	= 200 * doscientos; var cien2 			= 100 * cien; var cincuenta2 		= 50 * cincuenta; var veintecinco2	= 25 * veintecinco; var veinte2			= 20 * veinte; var diez2			= 10 * diez; var cinco2			= 5 * cinco; var uno2			= 1 * uno; var TotalArq 	= dosmil2 + mil2 + quinientos2 + doscientos2 + cien2 + cincuenta2 + veintecinco2 + veinte2 + 
		diez2 + cinco2 + uno2;
		//var IniCaja = $('#inic_fondo').val();
		var total = parseInt(TotalArq);
		$('#total_cuenta1').val(total);
}
</script>