<?
  	//error_reporting(0);
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
	
	$wFecha = "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 23:59:59'";
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
	$reversadas .= "0";
	while($rev=mysql_fetch_array($qR)){ 
	    //$reversadas .= "[".$rev['id_trans']."]";
		$reversadas 	.= ",".$rev['id_trans'];
	 }
	 
	// CONSULTANDO VENTAS:
	$queryV=mysql_query("
		SELECT user_id, SUM(monto) AS total, SUM(ganancia1) AS gantotal,fecha,fecharep
		FROM seguro_transacciones WHERE id_aseg='".$_SESSION["id_suplid"]."' $wFecha  AND id NOT IN($reversadas)
		GROUP BY fecharep
	");
	  while($venta=mysql_fetch_array($queryV)){
		
		  //echo $venta['id'];
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
		
		$fechX 				= $dia."-".$mes."-".$year;
		$venta['total'] 		=  (int) $venta['total'];
		$venta['gantotal'] 	=  (int) $venta['gantotal']; 
								
		$data_ventas1 	   .="['".$fechX."', ".$venta['total'].", ".$venta['gantotal']."], ";
		//$data_gananc1 	   .='{"elapsed": "'.$fechX.'", "Ganancia": '.$venta['gantotal'].' }, ';
		
		   //['2004',  1000,      400],
	  } 
	
	$data_ventas = substr($data_ventas1, 0, -1);
	
		?>
 		 
 
   
   <!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'x');
        data.addColumn('number', 'Venta');
        data.addColumn({id:'i0', type:'number', role:'interval'});
        
      
  
        data.addRows([
           [1, 1000, 190],
            [2, 3200, 450],
            [3, 1900, 275],
            ]);
  
        // The intervals data as narrow lines (useful for showing raw source data)
        var options_lines = {
            title: 'Line intervals, default',
            curveType: 'function',
            lineWidth: 4,
            intervals: { 'style':'line' },
            legend: 'none'
        };
  
        var chart_lines = new google.visualization.LineChart(document.getElementById('chart_lines'));
        chart_lines.draw(data, options_lines);
      }
</script>


       <div id="chart_lines" style="width: 900px; height: 500px;"></div>-->
       
      
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
  
  