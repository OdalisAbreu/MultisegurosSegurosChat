<?
	session_start();
	//error_reporting(-1);
	include("../../../incluidos/conexion_inc.php");
	//include("../../../incluidos/conexionServ2_inc.php");
	Conectarse();
	
	ini_set('display_errors',1);

	include("../../../incluidos/dinero.func.php");
	include("../../../incluidos/info.profesores.php");
	include("../../../incluidos/fechas.func.php");

	function InfoVentasCliente($conf){ 
		
		$wFecha = "fecha >= '".$conf['fecha']." 00:00:00' AND fecha < '".$conf['fecha']." 23:59:59'";
		$query	= mysql_query("
		#
		# REP. COMPARAR VENTAS.
		# Estadisticas/CompararVentas
	
		SELECT user_id,total,total_rev,total_rec,ventas_detalle,fecha
		FROM ventas_resumen_nivel2
		WHERE $wFecha AND (total >0) ");
		
		while($r=mysql_fetch_array($query)){
			$t['user_con_ventas'] .=",".$r['user_id'];
			$t[$r['user_id']]['totalGral'] += $r['total'];
			$t[$r['user_id']]['total_rev'] += $r['total_rev'];
			$t[$r['user_id']]['total_rec'] += $r['total_rec'];
			
			// div por company:
			$comp = explode('|',$r['ventas_detalle']);
			$t[$r['user_id']]['ventaC'] += $comp[0];
			$t[$r['user_id']]['ventaO'] += $comp[1];
			$t[$r['user_id']]['ventaV'] += $comp[2];
			$t[$r['user_id']]['ventaT'] += $comp[3];
			$t[$r['user_id']]['ventaD'] += $comp[4]; 
			$t[$r['user_id']]['ventaM'] += $comp[5];
			//echo $r['fecha']." ->".$r['total_rec']."<br>";
		}
		 
		return $t;
	}
	
	
	if(!$_GET['porciento']){
		$_GET['porciento'] =0;	
	}
?>

<style type="text/css">
  /* .box_div {
	border-left-width: 1px;
	border-left-style: solid;
	border-left-color: #CCCCCC;
}

.text_company {
	font:Verdana, Geneva, sans-serif;
	font-size:18px;
	font-weight:bold;
	background-color:#F6F6F6;
	border-bottom:solid 2px #EDEDED;
}

.text_titulo {
	font:Verdana, Geneva, sans-serif;
	font-size:24px;
	font-weight:bold;
	color:#FFF;
	border-bottom:solid 2px #036;
	padding:5px;
}

.text_montos {
	font:"Lucida Console", Monaco, monospace;
	font-size:20px;
	font-weight:bold;
	color:#390;
	background-color:#F6F6F6;
	border-bottom:solid 2px #EDEDED;
	padding:5px;
} */
</style>

<?
		
		// --------------------------------------------	
		if($_GET['fecha1']){
			$fecha2 = $_GET['fecha1'];
		}else{
			$fecha2 = fecha_despues(''.date('d/m/Y').'',-1);
		}
		// --------------------------------------------
		if($fecha2){
			$fecha1 = fecha_despues(''.$fecha2.'',-7);
		}
		// -------------------------------------------
		
		$fd1		= explode('/',$fecha1);
		$fh1		= explode('/',$fecha2);
		$fechaF1 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
		$fechaF2 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	
?>

<ul class="breadcrumb">
  <li>Tu estas Aqui</li>
  <li class="divider"></li>
  <li>CxC</li>
  <li class="divider"></li>
  <li>CxP General</li>

</ul>
<h2>Cuentas por Cobrar General</h2>


<div class="widget widget-heading-simple widget-body-white">

  <div class="well clearfix" style="padding-bottom:5px;">
    <div class="form-group col-md-3 clearfix " style="padding-right:0px; padding-left:0px; margin-left:0px; margin-right:0px;">
      <div class="col-md-9">
        <input name="fecha1" class="form-control fecha1" type="text" id="fecha1" style="font-size:12px; color:#F00;" value="<? echo $fecha2;?>" size="9" data-date-format="dd/mm/yyyy" />
      </div>
    </div>
    <div class="col-md-2" style="padding-right:0px; margin-right:0px;">
      <input name="bt_buscar" type="button" class="btn btn-info " id="bt_buscar" value="Actualizar" />
    </div>

    <script type="text/javascript">
      $('#bt_buscar').click(
        function() {
          var fecha1 = $('#fecha1').val();


          CargarAjax2(
            'Admin/Sist.PersonalRecargas/List/CompararVentas.php?fecha1=' + fecha1 + "&user_id=<? echo $_GET['user_id'];?>&b_nombre=<? echo $_GET['b_nombre'];?>",
            '', 'GET', 'cargaajax');
        }
      );

      // CODIGO PARA SACAR CALENDARIO
      // ****************************
      $(function() {
        $("#fecha1").datepicker({
          dateFormat: 'dd/mm/yy'
        });
        $("#fecha2").datepicker({
          dateFormat: 'dd/mm/yy'
        });
      });
    </script>

  </div>



  <table width="100%" border="0" cellpadding="4" cellspacing="2" bordercolor="#D6D6D6" class="table table-striped mb30">
    <tr>
      <td> ID:</td>
      <td class="box_div">Cliente: </td>
      <td align="center" class="box_div">Dia(1): <?= $fecha1 ?></td>
      <td align="center" class="box_div">Dia(2): <?= $fecha2 ?></td>
      <td align="center" class="box_div">&nbsp;</td>
    </tr>
    <? 
  	
	// ========================
	// BUSCAR LOS DEPENDIENTES
	// ========================
	/*
	$r2 = mysql_query("
	SELECT clientes FROM personal_benef WHERE id ='".$_GET['user_id']."'");
  	$dep = mysql_fetch_array($r2);
  */
  
  	$ventasDia1 = InfoVentasCliente($c=array('fecha'=>$fechaF1));
	$ventasDia2 = InfoVentasCliente($c=array('fecha'=>$fechaF2));
  	// $t['user_con_ventas']
  $query=mysql_query("SELECT id,nombres FROM personal WHERE nombres !='' AND funcion_id ='2'
	AND (id !='143' OR  id !='183')
	AND id IN(0".$ventasDia1['user_con_ventas'].")
	ORDER BY floor(balance) DESC
	");
  	
	while($row=mysql_fetch_array($query)){
		
		
		// RESUMEN GENERAL:
 		$ttalGeneral 	+= $ventasDia1[$row['id']]['totalGral'];
		$ttalGeneral2 	+= $ventasDia2[$row['id']]['totalGral'];
		// recargado
		$ttalRecargado 	+= $ventasDia1[$row['id']]['total_rec'];
		$ttalRecargado2 += $ventasDia2[$row['id']]['total_rec'];
?>
    <tr>

      <td bgcolor="#CCCCCC">
        <div align="center">
          <? echo $row['id']; ?>
        </div>
      </td>
      <td width="30%" height="30" bgcolor="#CCCCCC">
        <font size="4"><b>
            <? echo $row['nombres']; ?></b></font>



      </td>
      <td bgcolor="#DADADA" class="box_div">
        <center>
          <font size="3" color="#003399"><b>
              <?
		echo FormatDinero($ventasDia1[$row['id']]['totalGral']);
	?>
            </b></font>
        </center>
      </td>
      <td bgcolor="#CCCCCC" class="box_div">
        <center>
          <font size="3" color="#003333"><b>
              <?
		echo FormatDinero($ventasDia2[$row['id']]['totalGral']);
	?>
            </b></font>
        </center>
      </td>
      <td class="box_div">

        <?
		$restantes[$row['id']] = $ventasDia2[$row['id']]['totalGral'] - $ventasDia1[$row['id']]['totalGral'];
		
		if($ventasDia2[$row['id']]['totalGral']!=0){
			
			if($restantes[$row['id']]<0){
				echo '<font size="3" color="#FF0000"><b>'.FormatDinero($restantes[$row['id']]).'</b></font>';
				$restantesGral += abs($restantes[$row['id']]);
			}else{
				echo '<font size="3" color="#003399"><b>'.FormatDinero($restantes[$row['id']]).'</b></font>';
				$sumantesGral += $restantes[$row['id']];
			}
		}else{
			echo '<font size="3" color="#FF0000"><b>'
			.FormatDinero($ventasDia1[$row['id']]['totalGral'])
			.'</b></font>';	
		}
	?>
        </b>
        </font>

      </td>
    </tr>
    <tr class="listado">
      <td>&nbsp;</td>
      <td height="30" class="box_div">&nbsp;</td>
      <td height="30" class="box_div">C: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia1[$row['id']]['ventaC']) ?>
          </font>
        </b> <br />
        O: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia1[$row['id']]['ventaO']) ?>
          </font>
        </b> <br />
        V: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia1[$row['id']]['ventaV']) ?>
          </font>
        </b><br />
        T: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia1[$row['id']]['ventaT']) ?>
          </font>
        </b> <br />
        D: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia1[$row['id']]['ventaD']) ?>
          </font>
        </b> <br />
        M: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia1[$row['id']]['ventaM']) ?>
          </font>
        </b></td>
      <td height="30" class="box_div">C: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia2[$row['id']]['ventaC']) ?>
            <br />
          </font>
        </b>O: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia2[$row['id']]['ventaO']) ?>
          </font>
        </b> <br />
        V: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia2[$row['id']]['ventaV']) ?>
            <br />
          </font>
        </b>T: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia2[$row['id']]['ventaT']) ?>
          </font>
        </b> <br />
        D: <b>
          <font color="#006600">
            <?= FormatDinero($ventasDia2[$row['id']]['ventaD']) ?>
            <br />
          </font>
        </b>M:<b>
          <font color="#006600">
            <?= FormatDinero($ventasDia2[$row['id']]['ventaM']) ?>
          </font>
        </b></td>
      <td class="box_div">&nbsp;</td>
    </tr>
    <? } ?>
    <tr class="listado">
      <td>&nbsp;</td>
      <td height="30" class="box_div">&nbsp;</td>
      <td height="30" class="box_div">
        <font size="5"><b>
            <?
		echo FormatDinero($ttalGeneral);
	?>
          </b></font>

      </td>
      <td height="30" class="box_div">
        <font size="5"><b>
            <?
		echo FormatDinero($ttalGeneral2);
	?>
          </b></font>


      </td>
      <td class="box_div">&nbsp;</td>
    </tr>




    <tr>
      <td colspan="5">

        <br />

        <table width="98%" border="0" align="center" cellpadding="6" cellspacing="0" class="table table-striped mb30">
          <tr>
            <td bgcolor="#E7EBD4">&nbsp;</td>
            <td bgcolor="#EBF0D6">Total Positivos:</td>
            <td bgcolor="#E6E9D3">Total Negativos:</td>
          </tr>
          <tr>
            <td bgcolor="#E9EDC0">&nbsp;</td>
            <td bgcolor="#FFFFCC">
              <b>
                <font size="4" color="#003399">
                  <?= FormatDinero($sumantesGral) ?>
                </font>
              </b>
            </td>
            <td bgcolor="#EAEEC1">
              <b>
                <font size="4" color="#FF0000">
                  <?
		  
          echo FormatDinero($restantesGral);
		  
		  ?>
                </font>
              </b>

            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>




      </td>
    </tr>
  </table>
</div>