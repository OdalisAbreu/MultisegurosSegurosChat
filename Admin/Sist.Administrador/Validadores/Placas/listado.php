<?php
include_once '../../../../controller/ValidadorController.php';
session_start();
ini_set('display_errors', 1);
include("../../../../incluidos/conexion_inc.php");
Conectarse();

if($_GET['id']){
    echo $_GET['active'];
    echo $_GET['id'];
    $active = $_GET['active'];
    $id =  $_GET['id'];
    $sql = "UPDATE `char_plates` SET `status`= '$active' WHERE `id`= $id";
    mysql_query($sql) or die(mysql_error());
}

if ($_POST) {
    //Valida si existe el Char
    $query = mysql_query('SELECT * FROM `char_plates` WHERE `char` = "' . $_POST['char'] . '"');
    $quanty = mysql_num_rows($query);
    if ($quanty > 0) {
        $value = mysql_fetch_object($query);
        $char_id = $value->id;
        $query = "DELETE FROM char_type WHERE char_plates_id =". $value->id; //Insertar relacion
        if (mysql_query($query)) {
        } else {
            die(mysql_error());
        }
        for ($i = 1; $i <= 25; $i++) {
            if ($_POST['select' . $i]) {
                $query = "INSERT INTO `multiseg_2`.`char_type` (`char_plates_id`, `type_id`) VALUES ('" . $value->id . "', '" . $_POST['select' . $i] . "');"; //Insertar relacion
                if (mysql_query($query)) {
                } else {
                    die(mysql_error());
                }
            }
        }  
    } else {
        $query = "INSERT INTO `char_plates` (`char`, `created_at`) VALUES ('" . $_POST['char'] . "', '" . date('Y-m-d H:i:s') . "')"; //Insertar Char
        if (mysql_query($query)) {
            $query = mysql_query('SELECT * FROM `char_plates` WHERE `char` = "' . $_POST['char'] . '"');
            $value = mysql_fetch_object($query);
            for ($i = 1; $i <= 25; $i++) {
                if ($_POST['select' . $i]) {
                    $query = "INSERT INTO `multiseg_2`.`char_type` (`char_plates_id`, `type_id`) VALUES ('" . $value->id . "', '" . $_POST['select' . $i] . "');"; //Insertar relacion
                    if (mysql_query($query)) {
                    } else {
                        die(mysql_error());
                    }
                }
            }
        } else {
            die(mysql_error());
        }
    }
    }
    $query_plate = mysql_query("SELECT * FROM char_plates");
/*while ($char = mysql_fetch_array($query_plate)) {
    echo 'Entro';
}*/
?>

<div class="row">
    <div class="col-lg-10" style="margin-top:-35px;">
        <h3 class="page-header">Listados de Placas </h3>
    </div>
    <div class="col-lg-2" style=" margin-top:10px;">
        <a onClick="CargarAjax_win('Admin/Sist.Administrador/Validadores/Placas/add.php?accion=add','','GET','cargaajax');" class="btn btn-primary">
            <i class="fa fa-plus fa-lg"></i>
        </a>

    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Placas registradas
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Letra</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? while ($char = mysql_fetch_array($query_plate)) { ?>
                                <tr class="gradeX">
                                    <td><?= $char['id']; ?></td>
                                    <td><?= $char['char']; ?></td>
                                    <td>
                                        <!--editar -->
                                        <a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Validadores/Placas/edit.php?id=<?= $char['id']; ?>&char=<?= $char['char']; ?>','','GET','cargaajax');" data-title="Editar" class="btn btn-info">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>
                                        <!--editar -->
                                        <?if($char['status'] == 1){?>
                                            <!--active -->
                                            <a href="javascript:" onclick="CargarAjax2('Admin/Sist.Administrador/Validadores/Placas/listado.php?active=0&id=<?= $char['id']; ?>','','GET','cargaajax');" data-title="Editar" class="btn btn-success">
                                                <i class="fa fa-check fa-lg"></i>
                                            </a>
                                            <!--active -->
                                        <?}else{?>
                                            <!--desactivar -->
                                            <a href="javascript:" onclick="CargarAjax2('Admin/Sist.Administrador/Validadores/Placas/listado.php?active=1&id=<?= $char['id']; ?>','','GET','cargaajax');" data-title="Editar" class="btn btn-danger">
                                                <i class="fa fa-trash-o fa-lg"></i>
                                            </a>
                                            <!--desactivar -->
                                        <?}?>
                                    </td>
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