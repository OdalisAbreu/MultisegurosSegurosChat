<?php
    // include_once '../../../../controller/ValidadorController.php';
    ini_set('display_errors', 1);
    session_start();
    if ($_GET['accion'] == 'add') {
        $accion = 'Añadir';
    }
    include('../../../../incluidos/conexion_inc.php');
    Conectarse();
?>

<div class="container">
    <div class="col-6">
        <h1><?php echo $accion; ?>Editar Regla <?= $_GET['char']?></h1>
    </div>
    <form action="" class="form-group" method="post" enctype="multipart/form-data" id="form_insert_rule" style="width: 50%;">
        <div class="row">
            <div class="col-md-2">
                <input type="hidden" class="form-control" name="char" value="<?= $_GET['char']?>">
            </div>
        </div>
        <div class="row">
            <? $seg2 = mysql_query("SELECT id, nombre, veh_tipo FROM seguro_tarifas");
            while ($seg = mysql_fetch_array($seg2)) { ?>
                <? $query = mysql_query("SELECT * FROM char_type WHERE char_plates_id = ".$_GET['id']." AND type_id = ".$seg['veh_tipo']);
                $quanty = mysql_num_rows($query);
                if ($quanty > 0) {?>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input id="<?= $seg['id'] ?>" class="form-check-input" type="checkbox" name="select<?= $seg['veh_tipo'] ?>" value="<?= $seg['veh_tipo'] ?>" checked>
                            <label for="my-input" class="form-check-label"><?= $seg['nombre'] ?></label>
                        </div>
                    </div>
                <?}else{?>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input id="<?= $seg['id'] ?>" class="form-check-input" type="checkbox" name="select<?= $seg['veh_tipo'] ?>" value="<?= $seg['veh_tipo'] ?>">
                            <label for="my-input" class="form-check-label"><?= $seg['nombre'] ?></label>
                        </div>
                    </div>
                <?}?>

            <? } ?>
        </div>
        <div class="row">
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button name="acep" type="button" id="acep" class="btn btn-success" onClick="CargarAjax2_form('Admin/Sist.Administrador/Validadores/Placas/listado.php','form_insert_rule','cargaajax');" data-dismiss="modal">Editar</button>

            </div>
        </div>
    </form>

</div>