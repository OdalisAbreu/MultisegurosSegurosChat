<?php ini_set('display_errors', 1);
$login = '7bhoi';
include "../../../../incluidos/conexion_inc.php";
Conectarse();

$suplid_id2 = $_GET['suplid_id2'];

//VERIFICAR SI ES UN SERVICIO O UNA ASEGURADORA
$esc = mysql_query(
  "SELECT * from suplidores WHERE reporte ='si' 
	AND id_seguro ='" .
    $suplid_id2 .
    "' LIMIT 1"
);
$resc = mysql_fetch_array($esc);

if ($resc['tipo'] == "serv") {
  $consl = "AND id_seguro ='" . $suplid_id2 . "'";
  $none = 'style="display:none"';
} else {
  $consl = " AND tipo !='serv'";
  $none = 'style="display:block"';
}

echo '<select name="suplid_id2" id="suplid_id2" style="display:compact" class="form-control">
		<option value="t"  selected $none >-- Todos --</option>
		';

$rescats = mysql_query(
  "SELECT * from suplidores WHERE reporte ='si' $consl order by nombre ASC"
);
//echo "SELECT * from suplidores WHERE activo ='si' AND reporte ='si' $consl order by nombre ASC";

while ($cat = mysql_fetch_array($rescats)) {
  $nombre = $cat['nombre'];
  $c_id = $cat['id_seguro'];

  if ($_GET['suplid_id2'] == $c_id) { ?>
    <option value="<?= $c_id ?>" selected><?= $c_id ?> - <?= $nombre ?></option>
  <?php } else { ?>
    <option value="<?= $c_id ?>"><?= $c_id ?> - <?= $nombre ?></option>

<?php }
}

echo '</select>';
?>