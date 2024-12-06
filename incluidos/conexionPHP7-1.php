<?php ini_set("display_errors", 0);
date_default_timezone_set('America/Santo_Domingo');

function Conectarse()
{
	// $db_host = "multiseg.cyyrfieqmu0s.us-east-1.rds.amazonaws.com"; // Host al que conectar, habitualmente es el ‘localhost’
	// $db_nombre = "multiseg_2"; // Nombre de la Base de Datos que se desea utilizar
	// $db_user = "multiseguroscom"; // Nombre del usuario con permisos para acceder
	// $db_pass = "Hayunpaisenelmundo"; // Contraseña de dicho usu

	$db_host = "l72.167.221.234"; // Host al que conectar, habitualmente es el ‘localhost’
	$db_nombre = "multiseg_multiseguros"; // Nombre de la Base de Datos que se desea utilizar
	$db_user = "multiseg_chat"; // Nombre del usuario con permisos para acceder
	$db_pass = "Elleondedios05*"; // Contraseña de dicho usu

	// Ahora estamos realizando una conexión y la llamamos ‘$link’
	$link = new mysqli($db_host, $db_user, $db_pass);
	// Seleccionamos la base de datos que nos interesa
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	mysql_select_db($db_nombre, $link);
	//echo mysql_error();
}

function FormatDinero($precio)
{
	if (!$precio)
		$precio = 0;
	return number_format($precio, 2, '.', ',');
}

// FUNCIONES ANTI-INYECCION SQL
function LimpiarParametrosGETPOST()
{
	array_walk($_POST, 'limpiarCadena');
	array_walk($_GET, 'limpiarCadena');
}

function limpiarCadena($valor)
{
	$valor = str_ireplace("SELECT", "", $valor);
	$valor = str_ireplace("COPY", "", $valor);
	$valor = str_ireplace("DELETE", "", $valor);
	$valor = str_ireplace("DROP", "", $valor);
	$valor = str_ireplace("DUMP", "", $valor);
	$valor = str_ireplace(" AND ", "", $valor);
	$valor = str_ireplace(" OR ", "", $valor);
	$valor = str_ireplace("%", "", $valor);
	$valor = str_ireplace("LIKE", "", $valor);
	$valor = str_ireplace("RLIKE", "", $valor);
	$valor = str_ireplace("--", "", $valor);
	$valor = str_ireplace("^", "", $valor);
	$valor = str_ireplace("[", "", $valor);
	$valor = str_ireplace("]", "", $valor);
	$valor = str_ireplace("\\", "", $valor);
	$valor = str_ireplace("!", "", $valor);
	$valor = str_ireplace("¡", "", $valor);
	$valor = str_ireplace("?", "", $valor);
	$valor = str_ireplace("=", "", $valor);
	$valor = str_ireplace("&", "", $valor);
	$valor = str_ireplace("'", "", $valor);
	$valor = str_ireplace("#", "", $valor);
	return $valor;
}
//------------------------------
// FUNCION ANTI-INYECCION

if ($_GET or $_POST) {
	$input_arr = array();
	foreach ($_POST as $key => $input_arr) {
		$_POST[$key] = addslashes(limpiarCadena($input_arr));
	}

	$input_arr = array();
	foreach ($_GET as $key => $input_arr) {
		$_GET[$key] = addslashes(limpiarCadena($input_arr));
	}
}
