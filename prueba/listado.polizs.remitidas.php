<?
	//ini_set("session.cookie_lifetime","7200");
	//ini_set("session.gc_maxlifetime","7200");
	//ini_set('session.cache_expire','3000'); 
	session_start();
	ini_set('display_errors',1);
	
	include("../incluidos/conexion_inc.php");
	include("../incluidos/nombres.func.php");
	Conectarse();
	include("../incluidos/fechas.func.php");
	
	// --------------------------------------------	
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
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Reporte de polizas remitidas</h3>
    </div>
</div>

		
    
    
    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
    <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                    	<td>
                        
                        <label>Desde:</label>
                        <input type="text" name="fecha1" id="fecha1" class="input-mini" value="<?=$fecha1?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <label style="margin-left:5px;">Hasta:</label>
                        <input type="text" name="fecha2" id="fecha2" class="input-mini" value="<?=$fecha2?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
                        
                        <? if($_GET['consul']=='1'){?> 
                       <a href="Admin/Sist.Administrador/Reportes/Export/listado_trans.php?fecha1=<?=$fecha1;?>&fecha2=<?=$fecha2;?>">
                        <button type="button" data-toggle="button-loading pdf" data-target="#pdfTarget" class="btn btn-primary btn-icon glyphicons download_alt hidden-print" id="descargar"><i></i> Export</button>
                        
                        </a> 
                        <? } ?> 
                        </td>
                       
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();

	
	CargarAjax2('prueba/listado.polizs.remitidas.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 

		$(function() {
			$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
			$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
		});
	  </script>

      
   
			</div>
            numero de póliza, nombre del cliente, nombre de la ruta, numero de la agencia
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>Poliza</th>
                            <th>Fecha de Emisión</th>
                            <th>Nombre</th>
                            <th>Agencia</th>
                            <th>Ruta</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  
  if($_GET['consul']=='1'){
	  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 23:59:59'";


$qR=mysql_query("SELECT * FROM agencia_via WHERE  user_id ='20'  order by ejecutivo ASC ");
	$num_agencia .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $num_agencia .= "[".$rev['num_agencia']."]";
		//$reversadas 	.= ",".$rev['id_trans'];
	 }
	

   
  
   
   
  $query=mysql_query("SELECT * FROM seguro_transacciones 
  WHERE user_id ='20' $wFecha order by id DESC LIMIT 10"); 
  while($row=mysql_fetch_array($query)){
	  
	  $client = explode("|", ClientesVerRemesa($row['id_cliente']) );
	  $Agent = explode("-", $row['x_id']);
	  $Agencia = explode("/", AgenciaVia($Agent[0]));
?>
<tr>
    <td><?=GetPrefijo($row['id_aseg'])."-".str_pad($row['id_poliza'],6, "0", STR_PAD_LEFT);?></td>
    <td><?=FechaListPDF($row['fecha'])?></td>
    <td><?=$client[0]." ".$client[1]?></td>
    <td><?=$Agent[0]." - ".strtoupper($Agencia[0])?></td>
    <td><?=strtoupper($Agencia[1])?></td>
</tr>
  <?
   } 
  	}
	
	 
	/* $query=mysql_query("
   SELECT * FROM seguro_transacciones 
   WHERE user_id ='20' $wFecha order by id DESC LIMIT 10"); 
 
  while($row=mysql_fetch_array($query)){
	  $xid	= explode('-',$row['x_id']);
	  
	  echo "<b>XID explode:</b>".$xid[0]."<br>";
	  
	   if((substr_count($num_agencia,"[".$xid[0]."]")>0)){
		 echo "<b>HAY ID:</b> ".$row['id']."<br>"; 
		 echo "<b>X_ID:</b> ".$row['x_id']."<br>";  
	  }else{
		 echo "<b>NO ID:</b> ".$row['id']."<br>"; 
		 echo "<b>X_ID:</b> ".$row['x_id']."<br><br>";  
	  }
	  
	  
  }*/
  ?>
                     </tbody>
                  </table>
               </div>
            </div>
        </div>
    </div>
</div>