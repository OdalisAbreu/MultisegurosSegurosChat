<?php ///-------------------------------------------------
/*function CredActual($id){
	$query=mysql_query("SELECT * FROM credito 
	WHERE id_pers ='".$id."' order by id DESC LIMIT 1");
    $row=mysql_fetch_array($query);
	return $row['cred_actual'];
}*/

function Bancos($id)
{
  $querbancy = mysql_query(
    "SELECT * FROM bancos 
	WHERE id ='" .
      $id .
      "' LIMIT 1"
  );
  $ssd = mysql_fetch_array($querbancy);
  return $ssd['nombre_banc'];
}

///-------------------------------------------------
function NombreBanco($id)
{
  $querbancy = mysql_query(
    "SELECT * FROM cuentas_de_banco 
	WHERE id ='" .
      $id .
      "' LIMIT 1"
  );
  $ssd = mysql_fetch_array($querbancy);
  return Bancos($ssd['id_banc']) .
    "<br>(<font style='font-size: 13px; color: #2196F3;'>#" .
    $ssd['num_cuenta'] .
    "</font>)";
}

///-------------------------------------------------
function Cliente($id)
{
  $r2 = mysql_query(
    "SELECT id,asegurado_nombres,asegurado_apellidos,asegurado_telefono1,asegurado_cedula FROM seguro_clientes WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  while ($row2 = mysql_fetch_array($r2)) {
    $nombres =
      $row2['asegurado_nombres'] .
      "|" .
      $row2['asegurado_apellidos'] .
      "|" .
      $row2['asegurado_telefono1'] .
      "|" .
      $row2['asegurado_cedula'];
  }
  return $nombres;
}

function ClienteRepS($id)
{
  $r2 = mysql_query(
    "SELECT id,asegurado_nombres,asegurado_apellidos FROM seguro_clientes WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  $row2 = mysql_fetch_array($r2);
  return $row2['asegurado_nombres'];
}

///-------------------------------------------------
function Cedula($id)
{
  $r2ced = mysql_query(
    "SELECT id,asegurado_cedula FROM seguro_clientes WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  while ($row2ced = mysql_fetch_array($r2ced)) {
    $cedula = str_replace("-", "", $row2ced['asegurado_cedula']);

    $in = $cedula;
    $cedula =
      substr($in, 0, 3) . "-" . substr($in, 3, -1) . "-" . substr($in, -1);
  }
  return $cedula;
}

///-------------------------------------------------
function Telefono($id)
{
  $r2tel = mysql_query(
    "SELECT id,asegurado_telefono1 FROM seguro_clientes WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  while ($row2tel = mysql_fetch_array($r2tel)) {
    $telefono = str_replace("-", "", $row2tel['asegurado_telefono1']);

    $in = $telefono;
    $telefono =
      substr($in, 0, 3) . "-" . substr($in, 3, 3) . "-" . substr($in, -4);
  }
  return $telefono;
}

///-------------------------------------------------
function Direccion($id)
{
  $r2dir = mysql_query(
    "SELECT id,asegurado_direccion FROM seguro_clientes WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  while ($row2dir = mysql_fetch_array($r2dir)) {
    $direccion = $row2dir['asegurado_direccion'];
  }
  return $direccion;
}

///-------------------------------------------------
function Ciudad($id)
{
  $r2id = mysql_query(
    "SELECT id,ciudad FROM seguro_clientes WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row2id = mysql_fetch_array($r2id)) {
    //array para buscar el nombre de la ciudad
    $r2ciu = mysql_query(
      "SELECT id,descrip FROM ciudad WHERE id='" .
        $row2id['ciudad'] .
        "' LIMIT 1"
    );
    while ($row2ciu = mysql_fetch_array($r2ciu)) {
      return $row2ciu['descrip'];
    }
  }
}

//Agregar Ciudad desde AgenciaVia
function CiudadVia($id)
{
  $r2id = mysql_query(
    "SELECT id,x_id FROM seguro_transacciones WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row2id = mysql_fetch_array($r2id)) {
    //array para buscar el nombre de la ciudad
    $agenciCode = substr($row2id['x_id'], 0, 6);
    $r2ciu = mysql_query(
      "SELECT num_agencia,ciudad FROM agencia_via WHERE num_agencia='" . $agenciCode . "' LIMIT 1"
    );
    while ($row2ciu = mysql_fetch_array($r2ciu)) {
      return $row2ciu['ciudad'];
    }
  }
}


///-------------------------------------------------
function ClientePers($id)
{
  $r2m = mysql_query(
    "SELECT id,nombres FROM personal WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row2m = mysql_fetch_array($r2m)) {
    $nombresm = $row2m['nombres'];
  }
  return $nombresm;
}

///-------------------------------------------------
function ClientePersID($id)
{
  $r2m = mysql_query(
    "SELECT id,nombres,id_dist FROM personal WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row2m = mysql_fetch_array($r2m)) {
    $nombresm =
      $row2m['nombres'] .
      "<font color='#1D0CD6'> [ <b>" .
      $row2m['id_dist'] .
      "</b> ]</font>";
  }
  return $nombresm;
}

///-------------------------------------------------
function BalanceCuenta($id)
{
  $q = mysql_query("SELECT balance FROM personal WHERE id='$id' LIMIT 1");
  $bl = mysql_fetch_array($q);
  return $bl['balance'];
}

///-------------------------------------------------
function InfoDistribuidor2($id)
{
  $q = mysql_query("SELECT balance FROM personal WHERE id='$id' LIMIT 1");
  $bl = mysql_fetch_array($q);
  return $bl['balance'];
}

///-------------------------------------------------
function DivTel($id)
{
  $r2 = mysql_query(
    "SELECT celular FROM personal WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row2 = mysql_fetch_array($r2)) {
    $row2['celular'] = str_replace("-", "", $row2['celular']);

    $in = $row2['celular'];
    $celular =
      substr($in, 0, 3) . "-" . substr($in, 3, -4) . "-" . substr($in, -4);
  }
  return $celular;
}

///-------------------------------------------------
function Fecha($id)
{
  $clear1 = explode(' ', $id);
  $fecha_vigente1 = explode('-', $clear1[0]);

  if ($fecha_vigente1[1] == '01') {
    $mes = ' Enero';
  }
  if ($fecha_vigente1[1] == '02') {
    $mes = ' Febrero';
  }
  if ($fecha_vigente1[1] == '03') {
    $mes = ' Marzo';
  }
  if ($fecha_vigente1[1] == '04') {
    $mes = ' Abril';
  }
  if ($fecha_vigente1[1] == '05') {
    $mes = ' Mayo';
  }
  if ($fecha_vigente1[1] == '06') {
    $mes = ' Junio';
  }
  if ($fecha_vigente1[1] == '07') {
    $mes = ' Julio';
  }
  if ($fecha_vigente1[1] == '08') {
    $mes = ' Agosto';
  }
  if ($fecha_vigente1[1] == '09') {
    $mes = ' Septiembre';
  }
  if ($fecha_vigente1[1] == '10') {
    $mes = ' Octubre';
  }
  if ($fecha_vigente1[1] == '11') {
    $mes = ' Noviembre';
  }
  if ($fecha_vigente1[1] == '12') {
    $mes = ' Diciembre';
  }
  return $Vard =
    $fecha_vigente1[2] . ' de ' . $mes . ' del ' . $fecha_vigente1[0];
}

///-------------------------------------------------
function FechaList($id)
{
  $clear1 = explode(' ', $id);
  $fecha_vigente1 = explode('-', $clear1[0]);
  return $fecha_vigente1[2] .
    '-' .
    $fecha_vigente1[1] .
    '-' .
    $fecha_vigente1[0];
}

function HoraList($id)
{
  $fech1 = explode(" ", $id);
  $fech = explode("-", $fech1[0]);
  $hora = explode(":", $fech1[1]);

  if ($hora[0] == '00') {
    $Hor1 = "12";
    $tmip = "AM";
  }
  if ($hora[0] == '01') {
    $Hor1 = "1";
    $tmip = "AM";
  }
  if ($hora[0] == '02') {
    $Hor1 = "2";
    $tmip = "AM";
  }
  if ($hora[0] == '03') {
    $Hor1 = "3";
    $tmip = "AM";
  }
  if ($hora[0] == '04') {
    $Hor1 = "4";
    $tmip = "AM";
  }
  if ($hora[0] == '05') {
    $Hor1 = "5";
    $tmip = "AM";
  }
  if ($hora[0] == '06') {
    $Hor1 = "6";
    $tmip = "AM";
  }
  if ($hora[0] == '07') {
    $Hor1 = "7";
    $tmip = "AM";
  }
  if ($hora[0] == '08') {
    $Hor1 = "8";
    $tmip = "AM";
  }
  if ($hora[0] == '09') {
    $Hor1 = "9";
    $tmip = "AM";
  }
  if ($hora[0] == '10') {
    $Hor1 = "10";
    $tmip = "AM";
  }
  if ($hora[0] == '11') {
    $Hor1 = "11";
    $tmip = "AM";
  }
  if ($hora[0] == '12') {
    $Hor1 = "12";
    $tmip = "PM";
  }
  if ($hora[0] == '13') {
    $Hor1 = "1";
    $tmip = "PM";
  }
  if ($hora[0] == '14') {
    $Hor1 = "2";
    $tmip = "PM";
  }
  if ($hora[0] == '15') {
    $Hor1 = "3";
    $tmip = "PM";
  }
  if ($hora[0] == '16') {
    $Hor1 = "4";
    $tmip = "PM";
  }
  if ($hora[0] == '17') {
    $Hor1 = "5";
    $tmip = "PM";
  }
  if ($hora[0] == '18') {
    $Hor1 = "6";
    $tmip = "PM";
  }
  if ($hora[0] == '19') {
    $Hor1 = "7";
    $tmip = "PM";
  }
  if ($hora[0] == '20') {
    $Hor1 = "8";
    $tmip = "PM";
  }
  if ($hora[0] == '21') {
    $Hor1 = "9";
    $tmip = "PM";
  }
  if ($hora[0] == '22') {
    $Hor1 = "10";
    $tmip = "PM";
  }
  if ($hora[0] == '23') {
    $Hor1 = "11";
    $tmip = "PM";
  }

  if ($fech[1] == '01') {
    $mes = "Ene";
  }
  if ($fech[1] == '02') {
    $mes = "Feb";
  }
  if ($fech[1] == '03') {
    $mes = "Mar";
  }
  if ($fech[1] == '04') {
    $mes = "Abr";
  }
  if ($fech[1] == '05') {
    $mes = "May";
  }
  if ($fech[1] == '06') {
    $mes = "Jun";
  }
  if ($fech[1] == '07') {
    $mes = "Jul";
  }
  if ($fech[1] == '08') {
    $mes = "Ago";
  }
  if ($fech[1] == '09') {
    $mes = "Sep";
  }
  if ($fech[1] == '10') {
    $mes = "Oct";
  }
  if ($fech[1] == '11') {
    $mes = "Nov";
  }
  if ($fech[1] == '12') {
    $mes = "Dic";
  }
  //May 23, 2014 11:47:56 PM

  return $Hor1 . ":" . $hora[1] . ":" . $hora[2] . $tmip;
}

///-------------------------------------------------
function Nivel($id)
{
  if ($id = '2') {
    echo 'Distribuidor';
  } elseif ($id = '1') {
    echo 'Administrador';
  }
}

///-------------------------------------------------
function Vigencia($id)
{
  if ($id == '3') {
    $text = '3 Meses';
  } elseif ($id == '6') {
    $text = '6 Meses';
  } elseif ($id == '12') {
    $text = '1 A&ntilde;o';
  }

  return $text;
}

///-------------------------------------------------
function Vehiculo($id)
{
  $r2 = mysql_query(
    "SELECT id,veh_marca,veh_modelo,veh_chassis,veh_ano,veh_tipo FROM seguro_vehiculo WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  $row2 = mysql_fetch_array($r2);
  $marca = $row2['veh_marca'];
  $modelo = $row2['veh_modelo'];
  $tipo = $row2['veh_tipo'];

  //return $marca." ".$modelo;
  $r39 = mysql_query(
    "SELECT veh_tipo,nombre FROM seguro_tarifas WHERE veh_tipo='" .
      $tipo .
      "' LIMIT 1"
  );
  $row39 = mysql_fetch_array($r39);
  $tipo_nom = $row39['nombre'];

  //return $marca." ".$modelo;
  $r3 = mysql_query(
    "SELECT ID, DESCRIPCION FROM seguro_marcas WHERE ID='" .
      $marca .
      "' LIMIT 1"
  );
  while ($row3 = mysql_fetch_array($r3)) {
    $marca_nom = $row3['DESCRIPCION'];
  }
  $r4 = mysql_query(
    "SELECT ID, descripcion FROM seguro_modelos WHERE ID='" .
      $modelo .
      "' LIMIT 1"
  );
  while ($row4 = mysql_fetch_array($r4)) {
    $modelo_nom = $row4['descripcion'];
  }
  return "<b>" . $tipo_nom . "</b><br>" . $marca_nom . " " . $modelo_nom;
}

///-------------------------------------------------
function VehiculoExport($id)
{
  $r2 = mysql_query(
    "SELECT id,veh_marca,veh_modelo,veh_chassis,veh_ano,veh_matricula FROM seguro_vehiculo WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  $row2 = mysql_fetch_array($r2);

  $marca = $row2['veh_marca'];
  $modelo = $row2['veh_modelo'];
  $year = $row2['veh_ano'];
  $chassis = $row2['veh_chassis'];
  $placa = $row2['veh_matricula'];

  /*$r3 = mysql_query("SELECT ID, DESCRIPCION FROM seguro_marcas WHERE ID='".$marca."' LIMIT 1");
  $row3=mysql_fetch_array($r3);
  $marca_nom = $row3['DESCRIPCION'];
  
  $r4 = mysql_query("SELECT ID, descripcion FROM seguro_modelos WHERE ID='".$modelo."' LIMIT 1");
  $row4=mysql_fetch_array($r4);
  $modelo_nom = $row4['descripcion'];*/

  return $marca .
    "/" .
    $modelo .
    "" .
    "/" .
    $year .
    "" .
    "/" .
    $chassis .
    "" .
    "/" .
    $placa .
    "";
}

///-------------------------------------------------
function Tipo($id)
{
  $vehtipo = mysql_query(
    "SELECT id,veh_tipo FROM seguro_vehiculo WHERE id='" . $id . "' LIMIT 1"
  );
  while ($rowvehtipo = mysql_fetch_array($vehtipo)) {
    //ARRAY PARA SACAR EL TIPO DEL HEVICULO
    $vehtipos = mysql_query(
      "SELECT id,veh_tipo,nombre,dpa,rc,rc2,fj,id_general_seguro FROM seguro_tarifas WHERE veh_tipo='" .
        $rowvehtipo['veh_tipo'] .
        "' LIMIT 1"
    );
    while ($rowvehtipos = mysql_fetch_array($vehtipos)) {
      return $rowvehtipos['nombre'] .
        "/" .
        $rowvehtipos['dpa'] .
        "/" .
        $rowvehtipos['rc'] .
        "/" .
        $rowvehtipos['rc2'] .
        "/" .
        $rowvehtipos['fj'] .
        "/" .
        $rowvehtipo['veh_tipo'] .
        "/" .
        $rowvehtipos['id_general_seguro'] .
        "";
    }
  }
}

function Marcas($id)
{
  $r4 = mysql_query(
    "SELECT ID, descripcion FROM seguro_marcas WHERE ID='" . $id . "' LIMIT 1"
  );
  while ($row4 = mysql_fetch_array($r4)) {
    return $row4['descripcion'];
  }
}

function NombreSeguroS($id)
{
  $r5 = mysql_query(
    "SELECT id, nombre FROM seguros WHERE id='" . $id . "' LIMIT 1"
  );
  $row5 = mysql_fetch_array($r5);
  return $row5['nombre'];
}

function NombreProgS($id)
{
  $r51 = mysql_query(
    "SELECT id, nombre FROM suplidores WHERE id='" . $id . "' LIMIT 1"
  );
  $row51 = mysql_fetch_array($r51);
  return $row51['nombre'];
}

function ExportNombreProgS($id)
{
  $r51 = mysql_query(
    "SELECT id, nombre FROM suplidores WHERE id_seguro='" . $id . "' LIMIT 1"
  );
  $row51 = mysql_fetch_array($r51);
  return $row51['nombre'];
}

function CostoSuplid($idSuplid, $vigencia)
{
  $r512 = mysql_query(
    "SELECT * FROM servicios WHERE id='" . $idSuplid . "' LIMIT 1"
  );
  while ($row512 = mysql_fetch_array($r512)) {
    if ($vigencia == '3') {
      return $row512['3meses_costos'];
    }
    if ($vigencia == '6') {
      return $row512['6meses_costos'];
    }
    if ($vigencia == '12') {
      return $row512['12meses_costos'];
    }
  }
}

function MontoServicio($id, $vigencia)
{
  $r6 = mysql_query(
    "SELECT id, 3meses, 6meses, 12meses FROM servicios WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  while ($row6 = mysql_fetch_array($r6)) {
    if ($vigencia == 3) {
      return $row6['3meses'];
    }
    if ($vigencia == 6) {
      return $row6['6meses'];
    }
    if ($vigencia == 12) {
      return $row6['12meses'];
    }
  }
}

function NombreTarifasS($id)
{
  $r66 = mysql_query(
    "SELECT id, nombre FROM seguro_tarifas WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row66 = mysql_fetch_array($r66)) {
    return $row66['nombre'];
  }
}

function Provincia($id)
{
  $r4 = mysql_query(
    "SELECT id, descrip FROM provincia WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row4 = mysql_fetch_array($r4)) {
    return $row4['descrip'];
  }
}

function Municipio($id)
{
  $r4 = mysql_query(
    "SELECT id, descrip FROM municipio WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row4 = mysql_fetch_array($r4)) {
    return $row4['descrip'];
  }
}

function Suplidor($id)
{
  $r5 = mysql_query(
    "SELECT id, nombre FROM suplidores WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row5 = mysql_fetch_array($r5)) {
    return $row5['nombre'];
  }
}

function BancoNomNew($id)
{
  $r6 = mysql_query(
    "SELECT id, nombre_banc FROM bancos WHERE id='" . $id . "' LIMIT 1"
  );
  while ($row6 = mysql_fetch_array($r6)) {
    return $row6['nombre_banc'];
  }
}

function NombreBancoRep($id)
{
  $querbancy = mysql_query(
    "SELECT * FROM cuentas_de_banco 
	WHERE id ='" .
      $id .
      "' LIMIT 1"
  );
  $ssd = mysql_fetch_array($querbancy);
  return $ssd['nombre_banc'] .
    " (<font style='font-size: 13px; color: #2196F3;'>No. Cta. " .
    $ssd['num_cuenta'] .
    "</font>)";
}

function NombreBancoSuplidoresRep($id)
{
  $querbancy = mysql_query(
    "SELECT * FROM bancos_suplidores 
	WHERE id ='" .
      $id .
      "' LIMIT 1"
  );
  $ssd = mysql_fetch_array($querbancy);

  return BancoNomNew($ssd['id_banc']) .
    " (<font style='font-size: 13px; color: #2196F3;'>No. Cta. " .
    $ssd['num_cuenta'] .
    "</font>)";
}

function NombreSuplidoresRep($id)
{
  $querbancy1 = mysql_query(
    "SELECT * FROM bancos_suplidores 
	WHERE id ='" .
      $id .
      "' LIMIT 1"
  );
  $ssd1 = mysql_fetch_array($querbancy1);
  return $ssd1['nombres'];
}

function Sigla($id)
{
  $Sigla = mysql_query(
    "SELECT * from suplidores WHERE id_seguro ='" . $id . "' LIMIT 1"
  );
  $rSigla = mysql_fetch_array($Sigla);
  return $rSigla['sigla'];
}

function PrecioVerRemesa($idaseg, $tipo, $vigencia)
{
  $qprec = mysql_query(
    "SELECT veh_tipo, 3meses, 6meses, 12meses FROM  seguro_costos 
	WHERE veh_tipo='" .
      $tipo .
      "' AND id_seg='" .
      $idaseg .
      "' LIMIT 1"
  );

  //echo "<br><b>CONSULTA PRECIO:</b>SELECT veh_tipo, 3meses, 6meses, 12meses FROM  seguro_costos
  //WHERE veh_tipo='".$tipo."' AND id_seg='".$idaseg."' LIMIT 1<br>";
  while ($rprec = mysql_fetch_array($qprec)) {
    if ($vigencia == '3') {
      return $rprec['3meses'];
    }
    if ($vigencia == '6') {
      return $rprec['6meses'];
    }
    if ($vigencia == '12') {
      return $rprec['12meses'];
    }
  }
}

function VehiculoVerRemesa($id)
{
  $query = mysql_query(
    "
	SELECT id,veh_tipo FROM  seguro_vehiculo
	WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  $row = mysql_fetch_array($query);
  return $row['veh_tipo'];
}

function ClientesVerRemesa($id)
{
  $query = mysql_query(
    "
	SELECT * FROM  seguro_clientes
	WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  $row = mysql_fetch_array($query);
  return $row['asegurado_nombres'] .
    "|" .
    $row['asegurado_apellidos'] .
    "|" .
    $row['asegurado_cedula'];
}

function GetPrefijo($id)
{
  $queryp = mysql_query(
    "SELECT * FROM  seguros WHERE id='" . $id . "' LIMIT 1"
  );
  $rowp = mysql_fetch_array($queryp);
  return $rowp['prefijo'];
}

function MontoSeguroRemesas($id_veh, $vigencia)
{
  $q1s = mysql_query(
    "SELECT * FROM seguro_vehiculo 
	WHERE id ='" .
      $id_veh .
      "' LIMIT 1"
  );
  $sxc = mysql_fetch_array($q1s);

  $sxw = mysql_query(
    "SELECT * FROM seguro_tarifas 
	WHERE veh_tipo ='" .
      $sxc['veh_tipo'] .
      "' LIMIT 1"
  );
  $vcx = mysql_fetch_array($sxw);

  if ($vigencia == '3') {
    return $vcx['3meses'];
  }
  if ($vigencia == '6') {
    return $vcx['6meses'];
  }
  if ($vigencia == '12') {
    return $vcx['12meses'];
  }
}

function FechaReporte($id)
{
  $clear1 = explode(' ', $id);

  $fecha_vigente1 = explode('-', $clear1[0]);

  if ($fecha_vigente1[1] == '01') {
    $mes = 'Ene';
  }
  if ($fecha_vigente1[1] == '02') {
    $mes = 'Feb';
  }
  if ($fecha_vigente1[1] == '03') {
    $mes = 'Mar';
  }
  if ($fecha_vigente1[1] == '04') {
    $mes = 'Abr';
  }
  if ($fecha_vigente1[1] == '05') {
    $mes = 'May';
  }
  if ($fecha_vigente1[1] == '06') {
    $mes = 'Jun';
  }
  if ($fecha_vigente1[1] == '07') {
    $mes = 'Jul';
  }
  if ($fecha_vigente1[1] == '08') {
    $mes = 'Ago';
  }
  if ($fecha_vigente1[1] == '09') {
    $mes = 'Sep';
  }
  if ($fecha_vigente1[1] == '10') {
    $mes = 'Oct';
  }
  if ($fecha_vigente1[1] == '11') {
    $mes = 'Nov';
  }
  if ($fecha_vigente1[1] == '12') {
    $mes = 'Dic';
  }

  return $fecha_vigente1[2] .
    '-' .
    $fecha_vigente1[1] .
    '-' .
    $fecha_vigente1[0];
  //return $fecha_vigente1[2].'-'.$mes.'-'.substr($fecha_vigente1[0],-2);
}
function FechaReporteGeneral($id)
{
  $clear1 = explode(' ', $id);

  $fecha_vigente1 = explode('-', $clear1[0]);

  if ($fecha_vigente1[1] == '01') {
    $mes = 'Ene';
  }
  if ($fecha_vigente1[1] == '02') {
    $mes = 'Feb';
  }
  if ($fecha_vigente1[1] == '03') {
    $mes = 'Mar';
  }
  if ($fecha_vigente1[1] == '04') {
    $mes = 'Abr';
  }
  if ($fecha_vigente1[1] == '05') {
    $mes = 'May';
  }
  if ($fecha_vigente1[1] == '06') {
    $mes = 'Jun';
  }
  if ($fecha_vigente1[1] == '07') {
    $mes = 'Jul';
  }
  if ($fecha_vigente1[1] == '08') {
    $mes = 'Ago';
  }
  if ($fecha_vigente1[1] == '09') {
    $mes = 'Sep';
  }
  if ($fecha_vigente1[1] == '10') {
    $mes = 'Oct';
  }
  if ($fecha_vigente1[1] == '11') {
    $mes = 'Nov';
  }
  if ($fecha_vigente1[1] == '12') {
    $mes = 'Dic';
  }

  return $fecha_vigente1[2] . '' . $fecha_vigente1[1] . '' . $fecha_vigente1[0];
  //return $fecha_vigente1[2].'-'.$mes.'-'.substr($fecha_vigente1[0],-2);
}

function VehiculoMarca($id)
{
  $sxwTVM = mysql_query(
    "SELECT * FROM seguro_marcas 
	WHERE ID ='" .
      $id .
      "' LIMIT 1"
  );
  $RvcxTVM = mysql_fetch_array($sxwTVM);
  return $RvcxTVM['DESCRIPCION'];
}

function VehiculoModelos($id)
{
  $sxwTV = mysql_query(
    "SELECT * FROM seguro_modelos 
	WHERE ID ='" .
      $id .
      "' LIMIT 1"
  );
  $RvcxTV = mysql_fetch_array($sxwTV);
  return $RvcxTV['descripcion'];
}

function TipoVehiculo($id)
{
  $sxwTV = mysql_query(
    "SELECT * FROM seguro_tarifas 
	WHERE veh_tipo ='" .
      $id .
      "' LIMIT 1"
  );
  $RvcxTV = mysql_fetch_array($sxwTV);
  return $RvcxTV['nombre'];
}

function TelefonoPDF($id)
{
  $in = str_replace("-", "", $id);
  $in2 = substr($in, 0, 3) . "-" . substr($in, 3, 3) . "-" . substr($in, -4);
  return $in2;
}

function CedulaPDF($id)
{
  $in = str_replace("-", "", $id);
  $cedula =
    substr($in, 0, 3) . "-" . substr($in, 3, -1) . "-" . substr($in, -1);
  return $cedula;
}

function PlanGeneral($id)
{
  if ($id == '1') {
    return "6";
  } //Autobuses (De 16 a 60 Pasajeros)', 1,  ------
  if ($id == '2') {
    return "2";
  } //Automovil', 2, 						------
  if ($id == '3') {
    return "7";
  } //Camion', 3, 							------
  if ($id == '4') {
    return "7";
  } //Camion Cabezote', 4, 					------
  if ($id == '5') {
    return "7";
  } //Camion Volteo', 5,						------
  if ($id == '6') {
    return "3";
  } //Camioneta', 6,   						------
  if ($id == '7') {
    return "1";
  } //Four Wheel', 7, 						------
  if ($id == '8') {
    return "3";
  } //Furgoneta', 8,							------
  if ($id == '9') {
    return "5";
  } //Grua', 9, 								------
  if ($id == '10') {
    return "2";
  } //Jeep', 10,  							------
  if ($id == '11') {
    return "2";
  } //Jeepeta', 11, 						------
  if ($id == '12') {
    return "5";
  } //Maquinaria Pesada', 12,				------
  if ($id == '13') {
    return "4";
  } //Minivan (Hasta 15 Pasajeros)', 13, 	------
  if ($id == '14') {
    return "1";
  } //Motocicleta', 14, 					------
  if ($id == '15') {
    return "1";
  } //Motoneta', 15, 						------
  if ($id == '16') {
    return "2";
  } //Station Wagon', 16, 					------
  if ($id == '17') {
    return "7";
  } //Trailer', 17,							------
  if ($id == '18') {
    return "4";
  } //Van (Hasta 15 Pasajeros)', 18,		------
  if ($id == '19') {
    return "6";
  } //Minibus (De 16 a 60 Pasajeros)', 19,  ------
  if ($id == '20') {
    return "7";
  } //Remolque', 20, 						------

  //Motocicletas, Motonetas y FourWheels (plan 1)
  // Automoviles y Jeeps  (plan 2)
  // CAMIONETAS (plan 3)
  // VANS, MINIVANS - Hasta 15 pasajeros (plan 4)
  //GRUAS y Maquinas Pesadas (plan 5)
  // Ambulancias, Veh. Especiales y Autobus (plan 6)
  // Camiones, Patanas y Trailers (plan 7)
}

function FechaHora($id)
{
  $HoraFunc = explode(' ', $id);

  $hora2 = explode(':', $HoraFunc[1]);
  if ($hora2[0] == '00') {
    $hora22 = '12';
  }
  if ($hora2[0] == '01') {
    $hora22 = '01';
  }
  if ($hora2[0] == '02') {
    $hora22 = '02';
  }
  if ($hora2[0] == '03') {
    $hora22 = '03';
  }
  if ($hora2[0] == '04') {
    $hora22 = '04';
  }
  if ($hora2[0] == '05') {
    $hora22 = '05';
  }
  if ($hora2[0] == '06') {
    $hora22 = '06';
  }
  if ($hora2[0] == '07') {
    $hora22 = '07';
  }
  if ($hora2[0] == '08') {
    $hora22 = '08';
  }
  if ($hora2[0] == '09') {
    $hora22 = '09';
  }
  if ($hora2[0] == '10') {
    $hora22 = '10';
  }
  if ($hora2[0] == '11') {
    $hora22 = '11';
  }
  if ($hora2[0] == '12') {
    $hora22 = '12';
  }
  if ($hora2[0] == '13') {
    $hora22 = '01';
  }
  if ($hora2[0] == '14') {
    $hora22 = '02';
  }
  if ($hora2[0] == '15') {
    $hora22 = '03';
  }
  if ($hora2[0] == '16') {
    $hora22 = '04';
  }
  if ($hora2[0] == '17') {
    $hora22 = '05';
  }
  if ($hora2[0] == '18') {
    $hora22 = '06';
  }
  if ($hora2[0] == '19') {
    $hora22 = '07';
  }
  if ($hora2[0] == '20') {
    $hora22 = '08';
  }
  if ($hora2[0] == '21') {
    $hora22 = '09';
  }
  if ($hora2[0] == '22') {
    $hora22 = '10';
  }
  if ($hora2[0] == '23') {
    $hora22 = '11';
  }

  return $hora22 . ":" . $hora2['1'] . ":" . $hora2['2'];
}

function NombreTipoGeneral($id)
{
  $r66 = mysql_query(
    "SELECT veh_tipo, nombre FROM seguro_tarifas WHERE veh_tipo='" .
      $id .
      "' LIMIT 1"
  );
  while ($row66 = mysql_fetch_array($r66)) {
    return $row66['nombre'];
  }
}

function CedulaExport($id)
{
  $cedula = str_replace("-", "", $id);
  $in = $cedula;
  $ced = substr($in, 0, 3) . "-" . substr($in, 3, -1) . "-" . substr($in, -1);

  return $ced;
}

function TarifaVehiculo($id)
{
  $sxwTV = mysql_query(
    "SELECT * FROM seguro_tarifas 
	WHERE veh_tipo ='" .
      $id .
      "' LIMIT 1"
  );
  $RvcxTV = mysql_fetch_array($sxwTV);
  return $RvcxTV['dpa'] .
    "/" .
    $RvcxTV['rc'] .
    "/" .
    $RvcxTV['rc2'] .
    "/" .
    $RvcxTV['ap'] .
    "/" .
    $RvcxTV['fj'];
}

function montoSeguro($vigencia_poliza, $veh_tipo)
{
  $sxwTVMa = mysql_query(
    "SELECT veh_tipo,3meses,6meses,12meses FROM seguro_tarifas WHERE veh_tipo ='" .
      $veh_tipo .
      "' LIMIT 1"
  );
  $RvcxTVMa = mysql_fetch_array($sxwTVMa);

  if ($vigencia_poliza == '3') {
    return $RvcxTVMa['3meses'];
  }
  if ($vigencia_poliza == '6') {
    return $RvcxTVMa['6meses'];
  }
  if ($vigencia_poliza == '12') {
    return $RvcxTVMa['12meses'];
  }
}

function FechaListPDF($id)
{
  $clear1 = explode(' ', $id);
  $f = explode('-', $clear1[0]);
  $fh = explode(':', $clear1[1]);

  if ($fh[0] == '00') {
    $hora = '12';
  }
  if ($fh[0] == '01') {
    $hora = '1';
  }
  if ($fh[0] == '02') {
    $hora = '2';
  }
  if ($fh[0] == '03') {
    $hora = '3';
  }
  if ($fh[0] == '04') {
    $hora = '4';
  }
  if ($fh[0] == '05') {
    $hora = '5';
  }
  if ($fh[0] == '06') {
    $hora = '6';
  }
  if ($fh[0] == '07') {
    $hora = '7';
  }
  if ($fh[0] == '08') {
    $hora = '8';
  }
  if ($fh[0] == '09') {
    $hora = '9';
  }
  if ($fh[0] == '10') {
    $hora = '10';
  }
  if ($fh[0] == '11') {
    $hora = '11';
  }
  if ($fh[0] == '12') {
    $hora = '12';
  }
  if ($fh[0] == '13') {
    $hora = '1';
  }
  if ($fh[0] == '14') {
    $hora = '2';
  }
  if ($fh[0] == '15') {
    $hora = '3';
  }
  if ($fh[0] == '16') {
    $hora = '4';
  }
  if ($fh[0] == '17') {
    $hora = '5';
  }
  if ($fh[0] == '18') {
    $hora = '6';
  }
  if ($fh[0] == '19') {
    $hora = '7';
  }
  if ($fh[0] == '20') {
    $hora = '8';
  }
  if ($fh[0] == '21') {
    $hora = '9';
  }
  if ($fh[0] == '22') {
    $hora = '10';
  }
  if ($fh[0] == '23') {
    $hora = '11';
  }

  return $f[2] .
    '-' .
    $f[1] .
    '-' .
    $f[0] .
    " (" .
    $hora .
    ":" .
    $fh[1] .
    ":" .
    $fh[2] .
    " " .
    $T .
    ")";
}

function FechaListPDFn($id)
{
  $clear1 = explode(' ', $id);
  $fecha_vigente1 = explode('-', $clear1[0]);
  return $fecha_vigente1[2] .
    '-' .
    $fecha_vigente1[1] .
    '-' .
    $fecha_vigente1[0];
}

function FechaListPDFin($id)
{
  $clear1 = explode(' ', $id);
  $f = explode('-', $clear1[0]);
  $fh = explode(':', $clear1[1]);

  if ($fh[0] == '00') {
    $hora = '12';
  }
  if ($fh[0] == '01') {
    $hora = '1';
  }
  if ($fh[0] == '02') {
    $hora = '2';
  }
  if ($fh[0] == '03') {
    $hora = '3';
  }
  if ($fh[0] == '04') {
    $hora = '4';
  }
  if ($fh[0] == '05') {
    $hora = '5';
  }
  if ($fh[0] == '06') {
    $hora = '6';
  }
  if ($fh[0] == '07') {
    $hora = '7';
  }
  if ($fh[0] == '08') {
    $hora = '8';
  }
  if ($fh[0] == '09') {
    $hora = '9';
  }
  if ($fh[0] == '10') {
    $hora = '10';
  }
  if ($fh[0] == '11') {
    $hora = '11';
  }
  if ($fh[0] == '12') {
    $hora = '12';
  }
  if ($fh[0] == '13') {
    $hora = '1';
  }
  if ($fh[0] == '14') {
    $hora = '2';
  }
  if ($fh[0] == '15') {
    $hora = '3';
  }
  if ($fh[0] == '16') {
    $hora = '4';
  }
  if ($fh[0] == '17') {
    $hora = '5';
  }
  if ($fh[0] == '18') {
    $hora = '6';
  }
  if ($fh[0] == '19') {
    $hora = '7';
  }
  if ($fh[0] == '20') {
    $hora = '8';
  }
  if ($fh[0] == '21') {
    $hora = '9';
  }
  if ($fh[0] == '22') {
    $hora = '10';
  }
  if ($fh[0] == '23') {
    $hora = '11';
  }

  return $f[2] . '-' . $f[1] . '-' . $f[0] . " 12:00 PM";
}

function ServAdicional($id, $vigencia)
{
  $sxwTVMa = mysql_query(
    "SELECT id,nombre,3meses,6meses,12meses FROM servicios WHERE id ='" .
      $id .
      "' LIMIT 1"
  );
  $RvcxTVMa = mysql_fetch_array($sxwTVMa);

  if ($vigencia == '3') {
    return $RvcxTVMa['nombre'] . "|" . $RvcxTVMa['3meses'];
  }
  if ($vigencia == '6') {
    return $RvcxTVMa['nombre'] . "|" . $RvcxTVMa['6meses'];
  }
  if ($vigencia == '12') {
    return $RvcxTVMa['nombre'] . "|" . $RvcxTVMa['12meses'];
  }
}

function ValidarServicioOpcional($id_suplidores, $id_servicios)
{
  $rServs = mysql_query(
    "SELECT id,id_suplid FROM servicios WHERE id_suplid='" .
      $id_suplidores .
      "'
		AND id = '" .
      $id_servicios .
      "'"
  );
  //echo "<b>SELECT * FROM servicios WHERE id_suplid='".$id_suplidores."'
  //AND id = '".$id_servicios."'</b><br>";
  $rowServ1s = mysql_fetch_array($rServs);

  if ($rowServ1s['id'] > 0) {
    return $rowServ1s['id'];
  }
}

function MontoServicioOpcional($id_servicio, $vigencia)
{
  if ($id_servicio > 0) {
    $r6 = mysql_query(
      "SELECT " .
        $vigencia .
        "meses FROM servicios WHERE id='" .
        $id_servicio .
        "' "
    );
    //echo "<br>SELECT ".$vigencia."meses FROM servicios WHERE id='".$id_servicio."' <br>";
    $row6 = mysql_fetch_array($r6);
    return $row6['' . $vigencia . 'meses'];
  }
}

function MontoCostoServicioOpcional($id_servicio, $vigencia)
{
  if ($id_servicio > 0) {
    $r6 = mysql_query(
      "SELECT " .
        $vigencia .
        "meses_costos FROM servicios WHERE id='" .
        $id_servicio .
        "' "
    );
    //echo "<br>SELECT ".$vigencia."meses FROM servicios WHERE id='".$id_servicio."' <br>";
    $row6 = mysql_fetch_array($r6);
    return $row6['' . $vigencia . 'meses_costos'];
  }
}

function Supervisor($id)
{
  $sRs = mysql_query(
    "SELECT * FROM supervisor 
	WHERE id ='" .
      $id .
      "' LIMIT 1"
  );
  $Rs = mysql_fetch_array($sRs);
  return $Rs['nombre'];
}

function ClienteRepDependientes($id)
{
  $r2 = mysql_query(
    "SELECT id,asegurado_nombres,asegurado_apellidos FROM seguro_clientes WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  $row2 = mysql_fetch_array($r2);
  return $row2['asegurado_nombres'] . "/" . $row2['asegurado_apellidos'];
}

function getAgencia($idTrans)
{
  $query = sprintf(
    "SELECT 
			 IF(agencia_via.razon_social IS NULL,
        IF(vendedor_multiseguros.nombres IS NULL,
            vendedor_pagosmultiples.nombres,
            vendedor_multiseguros.nombres),
        CONCAT(agencia_via.num_agencia,
                ' - ',
                agencia_via.razon_social)) Vendedor,
			IF(distribuidor_via.nombres IS NULL,
				IF(distribuidor_multiseguros.nombres IS NULL,
					vendedor_pagosmultiples.nombres,
					distribuidor_multiseguros.nombres),
				distribuidor_via.nombres) Distribuidor
		FROM
			seguro_transacciones trans
				LEFT JOIN
			agencia_via ON agencia_via.num_agencia = SUBSTRING_INDEX(trans.x_id, '-', 1)
				AND SUBSTRING_INDEX(trans.x_id, '-', 1) != 'WEB'
				LEFT JOIN
			personal distribuidor_via ON agencia_via.user_id = distribuidor_via.id
				LEFT JOIN
			personal vendedor_multiseguros ON vendedor_multiseguros.id = trans.user_id
				AND SUBSTRING_INDEX(trans.x_id, '-', 1) = 'WEB'
				LEFT JOIN
			personal distribuidor_multiseguros ON distribuidor_multiseguros.funcion_id = 2
				AND vendedor_multiseguros.id_dist = distribuidor_multiseguros.id
				LEFT JOIN
			personal vendedor_pagosmultiples ON vendedor_pagosmultiples.id = trans.user_id
				AND SUBSTRING_INDEX(trans.x_id, '-', 1) = '86'
		WHERE
			trans.id = %d
		",
    $idTrans
  );

  $result = mysql_query($query);
  $data = mysql_fetch_array($result);

  $agencia = array(
    'vendedor' => $data["Vendedor"],
    'distribuidor' => $data["Distribuidor"]
  );
  return $agencia;
}

function AgenciaVia($id)
{
  $red = mysql_query(
    "SELECT * FROM agencia_via WHERE num_agencia='" . $id . "' LIMIT 1"
  );
  $rred = mysql_fetch_array($red);

  if ($rred['num_agencia']) {
    return $rred['razon_social'] . "/" . $rred['ejecutivo'];
  } else {
    return "VIA/";
  }
}

function Remplazar($text)
{
  $text2 = str_replace("Ñ", 'N', $text);
  $text2 = str_replace("ñ", 'n', $text);
  $text2 = str_replace("ā", 'a', $text);
  $text2 = str_replace("Ā", 'A', $text);
  $text2 = str_replace("É", 'E', $text);
  $text2 = str_replace("é", 'e', $text);
  $text2 = str_replace("í", 'i', $text);
  $text2 = str_replace("Í", 'I', $text);
  $text2 = str_replace("ú", 'u', $text);
  $text2 = str_replace("Ú", 'U', $text);
  $text2 = str_replace("Ó", 'O', $text);
  $text2 = str_replace("ó", 'o', $text);
  return $text2;
}

function ServAdicHistory($id)
{
  $sxwTVMa = mysql_query(
    "SELECT id,nombre FROM servicios WHERE id ='" . $id . "' LIMIT 1"
  );
  $RvcxTVMa = mysql_fetch_array($sxwTVMa);
  return $RvcxTVMa['nombre'];
}

function ServMontoHistory($idtrans, $idserv)
{
  $sxwTVMa1 = mysql_query(
    "SELECT * FROM `seguro_trans_history` WHERE `id_trans` = " .
      $idtrans .
      " AND `id_serv_adc` = " .
      $idserv .
      " "
  );

  $SCD = mysql_fetch_array($sxwTVMa1);
  return $SCD['monto'];
}

function NombreServicio($id)
{
  $r512c = mysql_query(
    "SELECT id,nombre FROM servicios WHERE id='" . $id . "' LIMIT 1"
  );
  $row512c = mysql_fetch_array($r512c);
  return $row512c['nombre'];
}

//PARA REPORTES DE LAS ASEGURADORAS

function RepMontoSeguro($idtrans)
{
  $qprec2c = mysql_query(
    "SELECT * FROM seguro_trans_history WHERE id_trans='" .
      $idtrans .
      "' 
	AND tipo='seg' LIMIT 1"
  );
  $rprec2c = mysql_fetch_array($qprec2c);
  return $rprec2c['monto'];
}

function RepMontoCostoSeguro($idtrans)
{
  $qprec2 = mysql_query(
    "SELECT * FROM seguro_trans_history WHERE id_trans='" .
      $idtrans .
      "' 
	AND tipo='seg' LIMIT 1"
  );
  $rprec2 = mysql_fetch_array($qprec2);
  return $rprec2['costo'];
}

function RepCostoServ($idtrans, $id_serv_adc)
{
  $qprec2 = mysql_query(
    "SELECT * FROM seguro_trans_history WHERE id_trans='" .
      $idtrans .
      "' 
	AND id_serv_adc = '" .
      $id_serv_adc .
      "' LIMIT 1"
  );
  $rprec2 = mysql_fetch_array($qprec2);
  return $rprec2['costo'];
}

function RepTipo($id)
{
  $queryt = mysql_query(
    "SELECT * FROM  seguro_tarifas WHERE veh_tipo='" . $id . "' LIMIT 1"
  );
  $rowt = mysql_fetch_array($queryt);
  return $rowt['nombre'] .
    "|" .
    $rowt['dpa'] .
    "|" .
    $rowt['ap'] .
    "|" .
    $rowt['rc'] .
    "|" .
    $rowt['rc2'] .
    "|" .
    $rowt['fj'] .
    "|" .
    $rowt['id_serv_rep'];
}

function Validar($id)
{
  $r512c2 = mysql_query(
    "SELECT * FROM servicios 
	WHERE id='" .
      $id .
      "' AND cambiar ='s' LIMIT 1"
  );
  $row512cx = mysql_fetch_array($r512c2);
  return $row512cx['dpa'] .
    "|" .
    $row512cx['ap'] .
    "|" .
    $row512cx['rc'] .
    "|" .
    $row512cx['rc2'] .
    "|" .
    $row512cx['fj'];
}

function Clientes($id)
{
  $query = mysql_query(
    "
	SELECT * FROM  seguro_clientes
	WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  $row = mysql_fetch_array($query);
  return $row['asegurado_nombres'] .
    "|" .
    $row['asegurado_apellidos'] .
    "|" .
    $row['asegurado_cedula'] .
    "|" .
    $row['asegurado_direccion'] .
    "|" .
    $row['ciudad'] .
    "|" .
    $row['asegurado_telefono1'] .
    "|" .
    $row['asegurado_pasaporte'];
}

function RepMontoServ($id, $serv_adc)
{
  $ServOpcional = explode("-", $serv_adc);
  for ($i = 0; $i < count($ServOpcional); $i++) {
    if ($ServOpcional[$i] > 0) {
      //BUSCAR SI SE SUMA O NO
      $qprec2 = mysql_query(
        "SELECT id,sumar FROM servicios WHERE id='" .
          $ServOpcional[$i] .
          "' LIMIT 1"
      );
      //echo "SELECT id,sumar FROM servicios WHERE id='".$ServOpcional[$i]."' LIMIT 1";
      $rprec2 = mysql_fetch_array($qprec2);
      if ($rprec2['sumar'] == 's') {
        //$MontoServiciosCde += RepMontoServicio($id,$ServOpcional[$i]);
        $MontoServiciosCde += RepMontoServiciodos($id, $rprec2['id']);
      }
    }
  }
  return $MontoServiciosCde;
}

function RepMontoServiciodos($id, $serv_adc)
{
  $qprec22 = mysql_query(
    "SELECT id_trans, id_serv_adc, monto FROM seguro_trans_history 
	WHERE id_trans ='" .
      $id .
      "' AND id_serv_adc = '" .
      $serv_adc .
      "' AND tipo='serv' LIMIT 1"
  );

  $rprec22 = mysql_fetch_array($qprec22);
  return $rprec22['monto'];
}

function RepMontoServCosto($id, $serv_adc)
{
  $ServOpcional = explode("-", $serv_adc);
  for ($i = 0; $i < count($ServOpcional); $i++) {
    if ($ServOpcional[$i] > 0) {
      //BUSCAR SI SE SUMA O NO
      $qprec2 = mysql_query(
        "SELECT id,sumar FROM servicios WHERE id='" .
          $ServOpcional[$i] .
          "' LIMIT 1"
      );
      //echo "SELECT id,sumar FROM servicios WHERE id='".$ServOpcional[$i]."' LIMIT 1";
      $rprec2 = mysql_fetch_array($qprec2);
      if ($rprec2['sumar'] == 's') {
        $MontoServiciosCde1 += RepMontoServiciodosCosto($id, $rprec2['id']);
      }
    }
  }
  return $MontoServiciosCde1;
}

function RepMontoServiciodosCosto($id, $serv_adc2)
{
  $qprec22 = mysql_query(
    "SELECT id_trans, id_serv_adc, monto, costo FROM seguro_trans_history 
	WHERE id_trans ='" .
      $id .
      "' AND id_serv_adc = '" .
      $serv_adc2 .
      "' AND tipo='serv' LIMIT 1"
  );

  $rprec22 = mysql_fetch_array($qprec22);
  return $rprec22['costo'];
}

/* function RepMontoServRemesa($id,$serv_adc){
	
$ServOpcional =  explode("-", $serv_adc);
		for($i =0; $i < count($ServOpcional); $i++){
		  if($ServOpcional[$i]>0){	
			//BUSCAR SI SE SUMA O NO
			$qprec2=mysql_query("SELECT id,sumar FROM servicios WHERE id='".$ServOpcional[$i]."' LIMIT 1");
			//echo "SELECT id,sumar FROM servicios WHERE id='".$ServOpcional[$i]."' LIMIT 1";
			$rprec2=mysql_fetch_array($qprec2);
				if($rprec2['sumar']=='s'){
					//$MontoServiciosCde += RepMontoServicio($id,$ServOpcional[$i]);
					$MontoServiciosCde += RepMontoServiciodosRemesa($id,$rprec2['id']);
				}
		}
			
		}
		return $MontoServiciosCde;
 }
 
 
 function RepMontoServiciodosRemesa($id,$serv_adc){

	$qprec22=mysql_query("SELECT id_trans, id_serv_adc, monto FROM seguro_trans_history 
	WHERE id_trans ='".$id."' AND id_serv_adc = '".$serv_adc."' AND tipo='serv' LIMIT 1");
	
	$rprec22 = mysql_fetch_array($qprec22);
		return $rprec22['monto'];
 }*/

function CrearCedula($id)
{
  $cedula = str_replace("-", "", $id);
  $in = $cedula;
  return substr($in, 0, 3) . "-" . substr($in, 3, -1) . "-" . substr($in, -1);
}

function CrearTelefono($id)
{
  $telefono = str_replace("-", "", $id);
  $in = $telefono;
  return substr($in, 0, 3) . "-" . substr($in, 3, 3) . "-" . substr($in, -4);
}

function CrearVehiculo($id)
{
  $query = mysql_query(
    "
	SELECT * FROM  seguro_vehiculo
	WHERE id='" .
      $id .
      "' LIMIT 1"
  );
  $row = mysql_fetch_array($query);
  return $row['veh_tipo'] .
    "|" .
    $row['veh_marca'] .
    "|" .
    $row['veh_modelo'] .
    "|" .
    $row['veh_ano'] .
    "|" .
    $row['veh_matricula'] .
    "|" .
    $row['veh_chassis'];
}

function ValidarAgencia($id)
{
  $query = mysql_query(
    "SELECT num_agencia FROM  agencia_via WHERE num_agencia='" .
      $id .
      "' AND user_id = '" .
      $_SESSION['user_id'] .
      "' LIMIT 1"
  );

  $row = mysql_fetch_array($query);
  if ($row['num_agencia']) {
    return "1";
  } else {
    return "2";
  }
}

function DatosTrans($id)
{
  $query = mysql_query(
    "
	SELECT * FROM  seguro_transacciones
	WHERE id = '" .
      $id .
      "' LIMIT 1"
  );
  $row = mysql_fetch_array($query);
  return $row['x_id'] .
    "|" .
    $row['id_poliza'] .
    "|" .
    $row['id_vehiculo'] .
    "|" .
    $row['vigencia_poliza'] .
    "|" .
    $row['id_cliente'] .
    "|" .
    $row['fecha_inicio'] .
    "|" .
    $row['fecha_fin'];
}

function ServOpc($seguro, $id)
{
  $qRz = mysql_query("SELECT * FROM servicios WHERE  id=" . $id . " ");
  //echo "SELECT * FROM servicios WHERE  id=".$id." <br>";
  $revz = mysql_fetch_array($qRz);
  return $revz['mod_pref'] . "|" . $revz['prefijo' . $seguro . ''];
}

function Valtrans($id)
{
  $query = mysql_query(
    "SELECT * FROM seguro_transacciones WHERE id ='" . $id . "' "
  );
  $row = mysql_fetch_array($query);

  if ($row['serv_adc'] == '') {
    return 2;
  } else {
    return 1;
  }
}

function ValServ($id)
{
  $query = mysql_query(
    "SELECT * FROM servicios WHERE id ='" . $id . "' LIMIT 1"
  );
  $row = mysql_fetch_array($query);

  if ($row['mod_pref'] == 's') {
    return 2;
  } else {
    return 1;
  }
}

function NombreSuplidor($id)
{
  $r51 = mysql_query(
    "SELECT id, nombre FROM suplidores WHERE id='" . $id . "' LIMIT 1"
  );
  $row51 = mysql_fetch_array($r51);
  if ($row51['id'] > 0) {
    return "00|" . $row51['nombre'];
  } else {
    return "15|15";
  }
}

function TipoSuplidor($id)
{
  $r51 = mysql_query(
    "SELECT id, nombre, tipo, id_seguro FROM suplidores WHERE id_seguro = '" .
      $id .
      "' LIMIT 1"
  );
  $row51 = mysql_fetch_array($r51);

  if ($row51['tipo'] == "serv") {
    $nombre = ServAdicHistory($row51['id_seguro']);
  } else {
    $nombre = NombreSeguroS($row51['id_seguro']);
  }
  return $nombre;
}

function sanear_string($string)
{
  $string = trim($string);

  $string = str_replace(
    array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
    array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
    $string
  );

  $string = str_replace(
    array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
    array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
    $string
  );

  $string = str_replace(
    array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
    array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
    $string
  );

  $string = str_replace(
    array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
    array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
    $string
  );

  $string = str_replace(
    array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
    array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
    $string
  );

  $string = str_replace(
    array('ñ', 'Ñ', 'ç', 'Ç'),
    array('n', 'N', 'c', 'C'),
    $string
  );

  //Esta parte se encarga de eliminar cualquier caracter extraño
  $string = str_replace(
    array(
      "¨",
      "º",
      "-",
      "~",
      "#",
      "@",
      "|",
      "!",
      '"',
      "'",
      "¡",
      "¿",
      "[",
      "^",
      "<code>",
      "]",
      "+",
      "}",
      "{",
      "¨",
      "´",
      ">",
      "< ",
      ";",
      ",",
      ":",
      "."
    ),
    '',
    $string
  );

  return $string;
}

function FechaHoraSubidaExcel($id)
{
  $clear1 = explode(' ', $id);
  $f = explode('-', $clear1[0]);
  $fh = explode(':', $clear1[1]);

  if ($fh[0] == '00') {
    $hora = '12';
    $d = "AM";
  }
  if ($fh[0] == '01') {
    $hora = '1';
    $d = "AM";
  }
  if ($fh[0] == '02') {
    $hora = '2';
    $d = "AM";
  }
  if ($fh[0] == '03') {
    $hora = '3';
    $d = "AM";
  }
  if ($fh[0] == '04') {
    $hora = '4';
    $d = "AM";
  }
  if ($fh[0] == '05') {
    $hora = '5';
    $d = "AM";
  }
  if ($fh[0] == '06') {
    $hora = '6';
    $d = "AM";
  }
  if ($fh[0] == '07') {
    $hora = '7';
    $d = "AM";
  }
  if ($fh[0] == '08') {
    $hora = '8';
    $d = "AM";
  }
  if ($fh[0] == '09') {
    $hora = '9';
    $d = "AM";
  }
  if ($fh[0] == '10') {
    $hora = '10';
    $d = "AM";
  }
  if ($fh[0] == '11') {
    $hora = '11';
    $d = "AM";
  }
  if ($fh[0] == '12') {
    $hora = '12';
    $d = "PM";
  }
  if ($fh[0] == '13') {
    $hora = '1';
    $d = "PM";
  }
  if ($fh[0] == '14') {
    $hora = '2';
    $d = "PM";
  }
  if ($fh[0] == '15') {
    $hora = '3';
    $d = "PM";
  }
  if ($fh[0] == '16') {
    $hora = '4';
    $d = "PM";
  }
  if ($fh[0] == '17') {
    $hora = '5';
    $d = "PM";
  }
  if ($fh[0] == '18') {
    $hora = '6';
    $d = "PM";
  }
  if ($fh[0] == '19') {
    $hora = '7';
    $d = "PM";
  }
  if ($fh[0] == '20') {
    $hora = '8';
    $d = "PM";
  }
  if ($fh[0] == '21') {
    $hora = '9';
    $d = "PM";
  }
  if ($fh[0] == '22') {
    $hora = '10';
    $d = "PM";
  }
  if ($fh[0] == '23') {
    $hora = '11';
    $d = "PM";
  }

  return $f[2] .
    '/' .
    $f[1] .
    '/' .
    $f[0] .
    " <br>" .
    $hora .
    ":" .
    $fh[1] .
    ":" .
    $d .
    "";
}

//PARA VALIDAR SI EL SERVICIO OPCIONAL SE CAMBIA O NO
function VerVariable($id)
{
  $SerOpcioal = explode("-", $id);
  for ($i = 0; $i < count($SerOpcioal); $i++) {
    //echo "ID SERV A REVISAR".$SerOpcioal[$i]."<br>";
    if ($SerOpcioal[$i] > 0) {
      $val = explode("|", Validar($SerOpcioal[$i]));
    }
    $dpa_1 = $val[0];
    $ap_1 = $val[1];
    $rc_1 = $val[2];
    $rc2_1 = $val[3];
    $fj_1 = $val[4];
  }

  return $dpa_1 . "|" . $ap_1 . "|" . $rc_1 . "|" . $rc2_1 . "|" . $fj_1;
}
