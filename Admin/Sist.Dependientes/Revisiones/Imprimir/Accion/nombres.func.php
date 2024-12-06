<?

function ClientePers($id){
  $r2m = mysql_query("SELECT id,nombres FROM personal WHERE id='".$id."' LIMIT 1");
  while($row2m=mysql_fetch_array($r2m)){
	  $nombresm = $row2m['nombres'];
  }
	return $nombresm;	
		
}

function NombreSeguroS($id){
	$r5 = mysql_query("SELECT id, nombre FROM seguros WHERE id='".$id."' LIMIT 1");
    $row5=mysql_fetch_array($r5);
	return $row5['nombre'];
}


function TarifaVehiculo($id){
	
	$sxwTV=mysql_query("SELECT * FROM seguro_tarifas 
	WHERE veh_tipo ='".$id."' LIMIT 1");
    $RvcxTV=mysql_fetch_array($sxwTV);
	return $RvcxTV['dpa']."/".$RvcxTV['rc']."/".$RvcxTV['rc2']."/".$RvcxTV['ap']."/".$RvcxTV['fj'];
	 
}


function GetPrefijo($id){
	$queryp=mysql_query("SELECT * FROM  seguros WHERE id='".$id."' LIMIT 1");
	$rowp=mysql_fetch_array($queryp);
	return $rowp['prefijo'];
}

///-------------------------------------------------	
function CedulaPDF($id){
	$in 		= str_replace("-","",$id);
    $cedula = substr($in,0,3)."-".substr($in,3,-1)."-".substr($in,-1);
	return $cedula;	
}


///-------------------------------------------------	
function TelefonoPDF($id){
	  $in	= str_replace("-","",$id);
      $in2 	= substr($in,0,3)."-".substr($in,3,3)."-".substr($in,-4);
	return $in2;	 
}



function FechaListPDF($id){
	   $clear1 = explode(' ',$id);  
	   $f  = explode('-',$clear1[0]);
	   $fh = explode(':',$clear1[1]);
	   
	   if($fh[0] =='00'){ $hora ='12';}
	   if($fh[0] =='01'){ $hora ='1'; }
	   if($fh[0] =='02'){ $hora ='2'; }
	   if($fh[0] =='03'){ $hora ='3'; }
	   if($fh[0] =='04'){ $hora ='4'; }
	   if($fh[0] =='05'){ $hora ='5'; }
	   if($fh[0] =='06'){ $hora ='6'; }
	   if($fh[0] =='07'){ $hora ='7'; }
	   if($fh[0] =='08'){ $hora ='8'; }
	   if($fh[0] =='09'){ $hora ='9'; }
	   if($fh[0] =='10'){ $hora ='10'; }
	   if($fh[0] =='11'){ $hora ='11'; }
	   if($fh[0] =='12'){ $hora ='12'; }
	   if($fh[0] =='13'){ $hora ='1'; }
	   if($fh[0] =='14'){ $hora ='2'; }
	   if($fh[0] =='15'){ $hora ='3'; }
	   if($fh[0] =='16'){ $hora ='4'; }
	   if($fh[0] =='17'){ $hora ='5'; }
	   if($fh[0] =='18'){ $hora ='6'; }
	   if($fh[0] =='19'){ $hora ='7'; }
	   if($fh[0] =='20'){ $hora ='8'; }
	   if($fh[0] =='21'){ $hora ='9'; }
	   if($fh[0] =='22'){ $hora ='10'; }
	   if($fh[0] =='23'){ $hora ='11'; }
	   
	   return  $f[2].'-'.$f[1].'-'.$f[0]." (".$hora.":".$fh[1].":".$fh[2].")";
}


function FechaListPDFn($id){
	   $clear1 = explode(' ',$id);  
	   $fecha_vigente1 = explode('-',$clear1[0]); 
	   return  $fecha_vigente1[2].'-'.$fecha_vigente1[1].'-'.$fecha_vigente1[0];
}


function FechaListPDFin($id){
	   $clear1 = explode(' ',$id);  
	   $f  = explode('-',$clear1[0]);
	   $fh = explode(':',$clear1[1]);
	   
	   if($fh[0] =='00'){ $hora ='12';}
	   if($fh[0] =='01'){ $hora ='1'; }
	   if($fh[0] =='02'){ $hora ='2'; }
	   if($fh[0] =='03'){ $hora ='3'; }
	   if($fh[0] =='04'){ $hora ='4'; }
	   if($fh[0] =='05'){ $hora ='5'; }
	   if($fh[0] =='06'){ $hora ='6'; }
	   if($fh[0] =='07'){ $hora ='7'; }
	   if($fh[0] =='08'){ $hora ='8'; }
	   if($fh[0] =='09'){ $hora ='9'; }
	   if($fh[0] =='10'){ $hora ='10'; }
	   if($fh[0] =='11'){ $hora ='11'; }
	   if($fh[0] =='12'){ $hora ='12'; }
	   if($fh[0] =='13'){ $hora ='1'; }
	   if($fh[0] =='14'){ $hora ='2'; }
	   if($fh[0] =='15'){ $hora ='3'; }
	   if($fh[0] =='16'){ $hora ='4'; }
	   if($fh[0] =='17'){ $hora ='5'; }
	   if($fh[0] =='18'){ $hora ='6'; }
	   if($fh[0] =='19'){ $hora ='7'; }
	   if($fh[0] =='20'){ $hora ='8'; }
	   if($fh[0] =='21'){ $hora ='9'; }
	   if($fh[0] =='22'){ $hora ='10'; }
	   if($fh[0] =='23'){ $hora ='11'; }
	   
	   return  $f[2].'-'.$f[1].'-'.$f[0]." 12:00 PM";
}


function TipoVehiculo($id){
	
	$sxwTV=mysql_query("SELECT * FROM seguro_tarifas 
	WHERE veh_tipo ='".$id."' LIMIT 1");
    $RvcxTV=mysql_fetch_array($sxwTV);
	return $RvcxTV['nombre'];
	 
}

function VehiculoMarca($id){
	
	$sxwTVM=mysql_query("SELECT * FROM seguro_marcas 
	WHERE ID ='".$id."' LIMIT 1");
    $RvcxTVM=mysql_fetch_array($sxwTVM);
	return $RvcxTVM['DESCRIPCION'];
	  
}


function VehiculoModelos($id){ 
	
	$sxwTV=mysql_query("SELECT * FROM seguro_modelos 
	WHERE ID ='".$id."' LIMIT 1");
    $RvcxTV=mysql_fetch_array($sxwTV);
	return $RvcxTV['descripcion'];
	 
}


function ServAdicional($id,$vigencia){
	
	$sxwTVMa=mysql_query("SELECT id,nombre,3meses,6meses,12meses FROM servicios WHERE id ='".$id."' LIMIT 1");
    $RvcxTVMa=mysql_fetch_array($sxwTVMa);
	
	if($vigencia=='3'){  return $RvcxTVMa['nombre']."|".$RvcxTVMa['3meses'];  }
	if($vigencia=='6'){  return $RvcxTVMa['nombre']."|".$RvcxTVMa['6meses'];  }
	if($vigencia=='12'){ return $RvcxTVMa['nombre']."|".$RvcxTVMa['12meses']; }

}

function montoSeguro($vigencia_poliza,$veh_tipo){
	
	$sxwTVMa=mysql_query("SELECT veh_tipo,3meses,6meses,12meses FROM seguro_tarifas WHERE veh_tipo ='".$veh_tipo."' LIMIT 1");
    $RvcxTVMa=mysql_fetch_array($sxwTVMa);
	
	if($vigencia_poliza=='3'){  return $RvcxTVMa['3meses'];  }
	if($vigencia_poliza=='6'){  return $RvcxTVMa['6meses'];  }
	if($vigencia_poliza=='12'){ return $RvcxTVMa['12meses']; }

}


function AgenciaVia($id){
  
  $red  = mysql_query("SELECT * FROM agencia_via WHERE num_agencia='".$id."' LIMIT 1");
  $rred =mysql_fetch_array($red);
  
  if($rred['num_agencia']){
	  return $rred['razon_social']."/".$rred['ejecutivo'];
  }else{
	  return "VIA/----";
  }
  
	
		
}


function ServAdicHistory($id){
	$sxwTVMa=mysql_query("SELECT id,nombre FROM servicios WHERE id ='".$id."' LIMIT 1");
    $RvcxTVMa=mysql_fetch_array($sxwTVMa);
	return $RvcxTVMa['nombre'];
}


?>