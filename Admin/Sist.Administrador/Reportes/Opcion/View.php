<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	
	$r2 = mysql_query("SELECT * from remesas WHERE id ='".$_GET['id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	//suplidores
	$r3 = mysql_query("SELECT * from suplidores WHERE id ='".$row['id_aseg']."' LIMIT 1");
    $row3 = mysql_fetch_array($r3);
	
	if($row['tipo_serv']=='prog'){
		$nombre = NombreProgS($row['id_aseg']);
	}else{
		$nombre = NombreSeguroS($row['id_aseg']);
	}
	
  if($row['tipo_serv'] =='prog'){
		$num = $row['year']."-".$row['num'];
	}else{
		$num = Sigla($row['id_aseg'])."-".$row['year']."-".$row['num'];
	} 
				
	
 ?>
 

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Visualizar Detalle de remesa <?=$num?></h4>
</div>

<div class="modal-body" style="margin-top: -10px;
    margin-bottom: -30px;">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información de la remesa
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane fade in active" id="info">
    <p>
    <div class="row">
          <div class="col-lg-4">
         	<label class="strong">Nombre</label>
          </div>
          
          <div class="col-lg-8">
             <div class="form-group "  style="color:#428bca">
				<b><?=$nombre?></b>
            </div>
          </div>
          
          
          <div class="col-lg-4">
         	<label class="strong">Monto a pagar</label>
          </div>
          
          <div class="col-lg-8">
             <div class="form-group" style="color:#428bca">
				<b>
				 <b><?="$".FormatDinero($row['monto'])?></b>
                </b>
            </div>
          </div>
        </div> 
         
        <div class="row">  
          
          <div class="col-lg-4">
         	<label class="strong">Fecha desde</label>
          </div>
          
           <div class="col-lg-8">
             <div class="form-group ">
             <?=$row['fecha_desde']?>
            </div>
          </div>
          
          <div class="col-lg-4">
         	<label class="strong">Fecha hasta</label>
          </div>
          
           <div class="col-lg-8">
             <div class="form-group ">
             <?=$row['fecha_hasta']?>
            </div>
          </div>
          
          <? if($row['pago']=='n'){?>
          	<div class="col-lg-12">
          		<label class="strong" style="color:#FC0000">PENDIENTE DE PAGO</label>
          </div>
          <? }else{ ?>
          
          <div class="col-lg-4">
          <label class="strong">Banco Empresa</label>
           
          </div>
          <div class="col-lg-8">
            <div class="form-group ">
               <?=NombreBancoRep($row['banc_emp'])?>  

            </div>
          </div>
          
          <div class="col-lg-4">
          <label class="strong">Banco Beneficiario</label>
          </div>
          
           <div class="col-lg-8">
            <div class="form-group ">
			  <?=NombreBancoSuplidoresRep($row['banc_benef'])?> 
            </div>
          </div>
          
          
           <div class="col-lg-4">
         <label class="strong">No. Transacci&oacute;n</label>
          </div>
          
           <div class="col-lg-8">
             <div class="form-group ">
                <?=$row['num_doc']?>
            </div>
          </div>
          
          
          <div class="col-lg-4">
         	<label class="strong">Descripcion</label>
          </div>
          
          
          <div class="col-lg-8">
             <div class="form-group ">
             <?=$row['descrip']?>
            </div>
          </div>
          
          <div class="col-lg-4">
         	<label class="strong">Emails enviados</label>
          </div>
          
           <div class="col-lg-8">
             <div class="form-group ">
             <?=$row3['email_finanzas']?>
            </div>
          </div>
          
          
          
    <? } ?>  
    
    
           
          
    <!--tabla para mostrar transacciones-->
    <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr style="font-size: 11px;">
                            <th>No. Poliza</th>
                            <th>Nombres</th>
                            <th>Fecha Emisi&oacute;n</th>
                            <th>Inicio Vigencia</th>
                            <th>Prima</th>
                            <th>Total a Remesar</th>
                          </tr>
                      </thead>
                      <tbody>
                      
   <tr>
    <td colspan="6">                   
                      
     <div style="width: 516px; height: 400px; overflow-y: scroll;">
     
   
     
     
   <table>  
     
                     
  <?  
 
	$wFecha 	= "fecha >= '".$row['fecha_desde']."' AND fecha <= '".$row['fecha_hasta']."'";
	
	if($row['tipo_serv'] !='prog'){
		$aseg = "AND id_aseg='".$row['id_aseg']."' ";
	}else{
		$aseg = "";
	}
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
		//$reversadas 	.= ",".$rev['id_trans'];
	 }
	 
$query=mysql_query("
   SELECT *  FROM seguro_transacciones 
   WHERE $wFecha $aseg order by id ASC"); 

  while($row=mysql_fetch_array($query)){
	
	if((substr_count($reversadas,"[".$row['id']."]")>0)){
		 //$Rtotal +=$row['totalpagar']; 
	  }else{  

	$pref = GetPrefijo($row['id_aseg']);
	$idseg = str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
	$prefi = $pref."-".$idseg;
	
	$cliente 	 =  explode("|", ClientesVerRemesa($row['id_cliente']));
	
	$remesar 	 = RepMontoCostoSeguro($row['id']);
	
	
	$ServCosto	 = RepMontoServCosto($row['id'],$row['serv_adc']);
	//echo "ID: ".$row['id']." ==> idserv: ".$row['serv_adc']." ==> Costo: ".$ServCosto."<br>";
	
	
	
	$ServMonto	 = RepMontoServ($row['id'],$row['serv_adc']);
	$monto 		 = RepMontoSeguro($row['id']);
	
	$montosum  = $monto + $ServMonto;
	$remesasum = $remesar + $ServCosto;

	$comision = $montosum - $remesasum;
	$tMonto += $remesasum;

?>
<tr style="font-size: 11px; color:#000000">
        <td><?=$prefi?></td>
        <td><?=$cliente[0]?> <?=$cliente[1]?></td>
        <td><?=Fecha($row['fecha'])?></td>
        <td><?=Fecha($row['fecha_inicio'])?><br><?=Fecha($row['fecha_fin'])?></td>
        <td>$<?=formatDinero($montosum)?></td>
		<td>$<?=formatDinero($remesasum)?></td>   
   </tr>
  <? 
 	 	} }
 	
?>
  
<tr>
	<td colspan="4" align="right"><strong>Total</strong></td>
    <td colspan="2"><strong>$<?=formatDinero($tMonto)?></strong><br>
    <?=$montosum?></td>
</tr>

</table>

</div> 

   </td>
</tr>

    </tbody>
</table>
 </div>
                            <!-- /.table-responsive -->
                        </div>
    <!--tabla para mostrar transacciones-->
          
  					</div>
                </div>
            </div>
          </div>
        </div>
      
    </div>
  </div>
 </div>

                
               
                
       </div>     
            
