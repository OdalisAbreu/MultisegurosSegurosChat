<?
	//ini_set('session.cache_expire','3000');
	session_start();
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	include("../../../incluidos/nombres.func.php");
	include("../../../incluidos/fechas.func.php");
	Conectarse();

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
  
   <center>
  	<div id="div_ultimo_acc2" class="alert alert-success" style=" font-size:14px; width:95%; margin-top: 14px;" align="center" >
    	<strong>Detalle de la transaccion</strong>
	</div>
</center>
    	
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
        
            
            
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Comentario</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  
	
	if($_GET['tipo'] !=='99'){
		
		if($_GET['tipo']=='1')
		$t = "Contado";
		
		if($_GET['tipo']=='2')
		$t = "Credito";
		
		if($_GET['tipo']=='3')
		$t = "Retiro";
		
		if($_GET['tipo']=='4')
		$t = "Ingreso";
		
		if($_GET['tipo']=='5')
		$t = "NC";
			
		
		$tipo = "AND tipo ='".$t."' ";
	}
	
$query=mysql_query("
	SELECT id,fecha,id_pers,balance_anterior,balance_despues,monto,autorizada_por, tipo , comentario
       FROM recarga_retiro
        WHERE id_pers ='".$_SESSION['user_id']."' AND id = '".$_GET['id']."'
	  ORDER BY fecha DESC
		");
  
 
  while($row=mysql_fetch_array($query)){
	  
	  if($row['tipo']=='Deposito'){
	  	$TDep += $row['monto']; 
		$concepto = "<font color='#1327C8'>Contado</font>"; 
	  }
	  
	  if($row['tipo']=='Retiro'){
	  	$TRet += $row['monto']; 
		$concepto = "<font color='#FF0000'>Retiro</font>"; 
	  }
	  
	  if($row['tipo']=='Credito'){
	  	$TCred += $row['monto']; 
		$concepto = "<font color='#000000'>Credito</font>"; 
	  }
	  
	  if($row['tipo']=='Ingreso'){
	  	$TIng += $row['monto']; 
		$concepto = "<font color='#24A01A'>Ingreso</font>"; 
	  }
	  
	  if($row['tipo']=='NC'){
	  	$TNC += $row['monto']; 
		$concepto = "<font color='#058300'>Nota de Credito</font>"; 
	  }
	  
	  $Tnet = $TDep + $TCred + $TNC;
	  
?>
<tr>
    <td><?=$row['fecha']?></td>
    <td><?=$concepto?></td>
    <td>$<?=FormatDinero($row['monto'])?></td>
    <td><?=$row['comentario']?></td>
   
    
</tr>
  <? } ?>
  
  
  
    </tbody>
</table>
 </div>
                            <!-- /.table-responsive -->
          </div>
                      
                        <!-- /.panel-body -->
      </div>
                    <!-- /.panel -->
     </div>
</div>