<?
	ini_set('display_errors', 1);
	session_start();
	include("../../../incluidos/conexion_inc.php");
	Conectarse();
	include("../../../incluidos/fechas.func.php");
?>
<? if(!$_GET['impr']){?>
<ul class="breadcrumb">
	<li>Tu estas Aqui</li>
	<li class="divider"></li>
	<li>Listados de Cierres</li>
	<li class="divider"></li>
	<li>Detalle del Cuadre</li>
	
</ul>
<? } ?>
<center>


<div class="row-fluid">
        <div class="span6 hidden-print">
			  <h2>Detalle Cuadre <b>#<?=$_GET['id']?></b> <? $hora = explode(' ',$_GET['fecha']); $orden  = explode('-',$hora[0]);  echo $orden[2]."-".$orden[1]."-".$orden[0];?></h2>	
			</div>
		
			<div class="span3 offset3">
				<? if(!$_GET['impr']){?> 
        <button name="impr" type="button" id="impr"  class="btn btn-success" style="margin-left:5px;"> 
            Imprimir Reporte 
         </button>
	<script type="text/javascript">
	$('#impr').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();
	
	var url = 'Admin/Sist.PersonalRecargas/List/CuadreBancos_Detalle.php?id=<? echo $_GET['id'];?>&fecha=<?=$_GET['fecha']?>&impr=1';
	var ops = "status=yes,scrollbars=yes,width=830,height=650,top=" + (screen.height / 2 - 130) + ",left=" + (screen.width / 2 - 430);

    window.open(url, "", ops);
	});
	 
</script>
<? } ?>
    
			</div>
			
		</div>


    
    
</center>
	<!-- Widget -->
  <div class="innerLR">
	<div class="widget widget-heading-simple widget-body-gray">
		<div class="widget-body">
  <!-- Table -->
<table class="dynamicTable tableTools table-hover table table-striped table-bordered table-primary table-white" >
   <thead>  
      <tr>
        <th width="0">Banco / Cuenta:</th>
        <th width="0">Recargado:</th>
        <th width="0">En Cuenta:</th>
        <th width="0">Diferencia:</th>
      </tr>
   </thead>
      <?
      // Seleccionando Cuentas Registradas:
      $query = mysql_query("
      SELECT * FROM cuentas_bancos WHERE
      cuenta_no !=0 
      ORDER BY cuenta_no ASC");
      while($cuenta = mysql_fetch_array($query)){
			 
			 // SELECCIONAR DETALLE DE CUEADRE:
			 $qC = mysql_query("
			 SELECT * FROM cierre_de_caja WHERE  fecha = '".$_GET['fecha']."' AND id_cuenta ='".$cuenta['id']."'");
			 $cierre = mysql_fetch_array($qC);
      ?>
      <tr>
        <td>
          <!--[ <? echo $cuenta['id']?> ] --><b><? echo $cuenta['nombre']; ?></b> (#<?=$cuenta['cuenta_no']?>)
          <br>
          A nombre de <b><? echo $cuenta['a_nombre_de'];?></b>
        </td>
        <td>
        <?
			$total_recargado 	+= $cierre['total_recargado'];
			$total_ingreso 	 	+= $cierre['total_ingreso'];
			$total_retirado 	+= $cierre['total_retirado'];
        	$totall = ($cierre['total_recargado'] + $cierre['total_ingreso']) - $cierre['total_retirado'];
			echo FormatDinero($totall);
        ?>
        </td>
        <td> <? $total_en_caja += $cierre['total_en_caja']; echo FormatDinero($cierre['total_en_caja']); ?> </td>
        <td>
          <?
			$totalDiferencia[$cuenta['id']] = $cierre['diferencia'];
			if($totalDiferencia[$cuenta['id']] <0){
				echo '<font color="#FF0000">'.FormatDinero($totalDiferencia[$cuenta['id']]).'</font>';
			}else{
				echo '<font color="#0033CC">'.FormatDinero($totalDiferencia[$cuenta['id']]).'</font>';
			}
           $diferenciaG += $cierre['diferencia']; 
        ?>
        </td>
      </tr>
      <?  } ?>
    </table>
     <? if($_GET['impr']){?>
     <br /><br />
     <? } ?>
    <div class="row-fluid">
    <!-- Column -->
    <div class="span5 hidden-print"></div>
    <!-- Column END -->
    <!-- Column -->
    <div class="span4 box-generic offset3">
      <table class=" table table-primary table-white">
        <tbody>
          <tr>
            <td class="right">Total Rec:</td>
            <td class="right strong">$ <? echo FormatDinero(($total_recargado + $total_ingreso) - $total_retirado); ?></td>
          </tr>
          <tr>
            <td class="right">Total en Cuent:</td>
            <td class="right strong">$ <? echo FormatDinero($total_en_caja); ?></td>
          </tr>
          <tr>
            <td class="right">Diferencia:</td>
            <td class="right strong"><? if($diferenciaG <0){ echo "<font color='#FF0000'>$ ".FormatDinero($diferenciaG)."</font>";}else{ echo "$ ".FormatDinero($diferenciaG); } ?></td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>