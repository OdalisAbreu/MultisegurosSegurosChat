<!--<html>
<head>
    <script language="JavaScript">
 
    /* Determinamos el tiempo total en segundos */
    var totalTiempo=60;
    /* Determinamos la url del archivo o del boton de descarga,(en ejemplo descarga de freebsd */
    var url="http://ftp.freebsd.org/pub/FreeBSD/releases/ISO-IMAGES/10.0/CHECKSUM.MD5-10.0-RELEASE-amd64";
 
    function updateReloj()
    {
        document.getElementById('CuentaAtras').innerHTML = "Por favor, espera "+totalTiempo+" segundos";
 
        if(totalTiempo==0)
        {
            window.location=url;
        }else{
            /* Restamos un segundo al tiempo restante */
            totalTiempo-=1;
            /* Ejecutamos nuevamente la función al pasar 1000 milisegundos (1 segundo) */
            setTimeout("updateReloj()",1000);
        }
    }
 
    window.onload=updateReloj;
 
    </script>
</head>
 
<body>
 
<h1>Preparando la descarga</h1>
<h2 id='CuentaAtras'></h2>
 
</body>
</html>-->

<font style="font-weight:bold; text-align:center; margin-bottom:10px; margin-top:15px;">
    <h2>GENERANDO DOCUMENTO</h2>

</font>

<div id="manejo" style="width: 175px;
    margin-left: 38%;
    margin-right: 50%;
    margin-bottom: 33px;">
    <h4 id="espere">Por favor, espere...</h4>
</div>

<?

$dir         = $_SERVER['DOCUMENT_ROOT'] . "/ws_schat/TareasProg/PDF/CLIENTES/" . $_GET['user_id'] . "/" . $_GET['fecha1'] . ".pdf";

if (file_exists($dir)) {
?>

    <a href="javascript:void(0)" class="btn btn-success" onclick="location.replace('../../../../ws_schat/TareasProg/Descargar.php?fecha=<?= $Fech_reg ?>&user_id=<?= $_GET['user_id'] ?>');"><b>Descargar Poliza</b></a>
<?
} else {
?>

    <script>
        $(document).ready(function() {
            CargarAjax2('../ws_schat/TareasProg/GenerarReporteAseguradoraPdf_Global_VIA.php?fecha1=<?= trim($_GET['fecha1']) ?>&fecha2=<?= trim($_GET['fecha2']) ?>&user_id=<?= trim($_GET['user_id']) ?>', '', 'GET', 'manejo');

        });
    </script>

<? } ?>