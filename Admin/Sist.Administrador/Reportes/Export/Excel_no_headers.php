<?php
ini_set('display_errors', 1);
set_time_limit(0);
session_start();
include "../../../../incluidos/conexion_inc.php";
include "../../../../../lib/Reports/Emisiones/Emisiones.php";
Conectarse();

$id_aseg = $_GET["id_aseg"];
$fechaDesde = date_format(date_create_from_format("d/m/Y H:i:s", $_GET["fechaDesde"] . " 00:00:00"), "Y-m-d H:i:s");
$fechaHasta = date_format(date_create_from_format("d/m/Y H:i:s", $_GET["fechaHasta"] . " 23:59:59"), "Y-m-d H:i:s");

$data = getDataEmisiones($id_aseg, $fechaDesde, $fechaHasta);

$requestData = transformDataToObjectArrayWithHeaders($data);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => json_encode($requestData)
    )
);

$outputFileName = "MS_EM_" .  str_replace('/', '-', $_GET["fechaDesde"]) . "-" .  str_replace('/', '-', $_GET["fechaHasta"]);

$url = "http://localhost:8081/api/excel_no_template?fileName=$outputFileName&folder=$id_aseg";
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if (!$result == false) {
    $file = "/home/multiseguroscom/public_html/excelFiles/$id_aseg/$outputFileName.xlsx";
    if (file_exists($file)) {

        echo "<script>
                window.location = 'https://multiseguros.com.do/excelFiles/$id_aseg/$outputFileName.xlsx';
              </script>";
    } else {
        echo "wrong file";
    }
}
