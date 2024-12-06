<?
  	error_reporting(0);
	 session_start();
	ini_set('display_errors',0);
	include('../../../../incluidos/fechas.func.php');
	include('../../../../incluidos/conexion_inc.php');
	Conectarse();


			if($_GET['fecha1']){
				$fecha1 	= $_GET['fecha1'];
			}else{
				$fecha1 	= fecha_despues(''.date('d/m/Y').'',-7);
			}
			// --------------------------------------------
			if($_GET['fecha2']){
				$fecha2 	= $_GET['fecha2'];
			}else{
				$fecha2 	= fecha_despues(''.date('d/m/Y').'',0);
			}
			// -------------------------------------------
			
			$fd1		= explode('/',$fecha1);
			$fh1		= explode('/',$fecha2);
			$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
			$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
			
			$wFecha = "AND fecha >= '$fDesde' AND fecha < '$fHasta 23:59:59'";
	
	
			$w_user = "(
			user_id='".$_SESSION['user_id']."'";
			
			// PUNTOS DE VENTAS
			$quer1 = mysql_query("
			SELECT id FROM personal WHERE id_dist ='".$_SESSION['user_id']."'");
			while($u=mysql_fetch_array($quer1)){
			
			$w_user .= " OR user_id='".$u['id']."'";
			
			$quer2 = mysql_query("
			SELECT id FROM personal WHERE id_dist ='".$u['id']."'"); 
			while($u2=mysql_fetch_array($quer2)){
			$w_user .= " OR user_id='".$u2['id']."'";	
			}
			
		}
			$w_user .= " )";
	
			  
	
			// ----------------------------
			// CONSULTANDO VENTAS:
			$queryV=mysql_query("
				SELECT user_id, SUM(monto) AS total,SUM(ganancia1) AS gantotal,fecha,fecharep
				FROM seguro_transacciones WHERE $w_user $wFecha 
				GROUP BY fecharep
			");


			  while($venta=mysql_fetch_array($queryV)){
				  
				  
				 //$fechX	= str_replace("-","",$venta['fecharep']);
				 $fp1 = explode("-", $venta['fecharep']);
				 
				$dia  = $fp1[2];
				$year = substr($fp1[0], 2, 2);
				
				if($fp1[1]=='1'){ $mes = "Ene"; }
				if($fp1[1]=='2'){ $mes = "Feb"; }
				if($fp1[1]=='3'){ $mes = "Mar"; }
				if($fp1[1]=='4'){ $mes = "Abr"; }
				if($fp1[1]=='5'){ $mes = "May"; }
				if($fp1[1]=='6'){ $mes = "Jun"; }
				if($fp1[1]=='7'){ $mes = "Jul"; }
				if($fp1[1]=='8'){ $mes = "Agos"; }
				if($fp1[1]=='9'){ $mes = "Sept"; }
				if($fp1[1]=='10'){ $mes = "Oct"; }
				if($fp1[1]=='11'){ $mes = "Nov"; }
				if($fp1[1]=='12'){ $mes = "Dic"; }
				
				$fechX = $dia."-".$mes."-".$year;
				  //$venta['total'] 	=  (int) $venta['total'];
				  						//{"elapsed": "I", "Valor": 54}
										
				  //$data_ventas1 		.='{"elapsed": "'.$fechX.'", "Valor": '.$venta['total'].' }, ';
				  //$data_neto		.="[".$fechX.", ".$venta['ganacia2']." ], ";
				$venta['total'] 		=  (int) $venta['total'];
				$venta['gantotal'] 	=  (int) $venta['gantotal']; 
				$data_ventas1 	   .="['".$fechX."', ".$venta['total'].", ".$venta['gantotal']."], ";
			  }
			
			//$data_ventas = substr($data_ventas1, 0, -1);
			$data_ventas = substr($data_ventas1, 0, -1);
			//echo $data_ventas;
		?>
        
          
 
 <!-- <script src="Admin/Sist.Distribuidor/Inicio/chart/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
  <script src="Admin/Sist.Distribuidor/Inicio/chart/morris.js"></script>
  <script src="Admin/Sist.Distribuidor/Inicio/chart/ajax/libs/prettify/r224/prettify.min.js"></script>
  <script src="Admin/Sist.Distribuidor/Inicio/chart/lib/example.js"></script>
  <link rel="stylesheet" href="Admin/Sist.Distribuidor/Inicio/chart/morris.css">


<div id="graph"></div>
<div id="code" class="prettyprint " style="display:none">
var day_data = [

<?=$data_ventas?>  
 {"elapsed": "0", "Valor": 0 }
];
Morris.Line({
  element: 'graph',
  data: day_data,
  xkey: 'elapsed',
  ykeys: ['Valor'],
  labels: ['Valor'],
  parseTime: false
});
</div>-->


  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia', 'Ventas', 'Ganancias'],
		  <?=$data_ventas?>]);

        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
 
 
    <div id="curve_chart" style="width: 900px; height: 500px; margin-top: -19px;"></div>