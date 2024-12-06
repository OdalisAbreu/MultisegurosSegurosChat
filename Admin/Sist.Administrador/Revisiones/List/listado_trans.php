<?
session_start();
ini_set('display_errors', 1);

include("../../../../incluidos/conexion_inc.php");
include("../../../../incluidos/nombres.func.php");
Conectarse();

// --------------------------------------------	
if ($_GET['cedula']) {
    $cedula = $_GET['cedula'];
} else {
    $cedula = "";
}






?>

<div class="row">
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Listados de venta de Seguros </h3>
    </div>
</div>





<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="filter-bar">

                <table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">

                    <tr>
                        <td>

                            <label>Dedula:</label>
                            <input type="text" name="cedula" id="cedula" class="input-mini" value="<?= $cedula ?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">

                            <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                                Actualizar
                            </button>

                        </td>

                    </tr>

                </table>

                <script type="text/javascript">
                    $('#bt_buscar').click(
                        function() {
                            var cedula = $('#cedula').val();

                            CargarAjax2('Admin/Sist.Administrador/Revisiones/List/listado_trans.php?cedula=' + cedula + '&consul=1', '', 'GET', 'cargaajax');
                            $(this).attr('disabled', true);
                        });
                </script>



            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cedula</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?

                            if ($_GET['consul'] == '1') {

                                $rs2 = mysql_query(
                                    "SELECT id,user,password FROM personal WHERE id = '" . $_SESSION['user_id'] . "' LIMIT 1"
                                );
                                $numU = mysql_fetch_array($rs2);

                                $getWS     = file_get_contents("https://127.0.0.1/ws_schat/GET_Cedula.php?cedula=" . trim($_GET['cedula']) . "&usuario=" . trim($numU['user']) . "&clave=" . trim($numU['password']) . "");
                                /*echo "http://127.0.0.1/ws_schat/GET_Cedula.php?cedula=".trim($_GET['cedula'])."&usuario=".trim($numU['user'])."&clave=".trim($numU['password'])."";*/
                                $num    = explode(';', $getWS);

                                print_r($num);
                                for ($i = 0; $i <= count($num); $i++) {
                                    echo $num[$i];
                                    $trans4    = explode('|', $num[$i]);
                            ?>
                                    <tr>
                                        <td>
                                            <a href="#" onclick="CargarAjax_win('Admin/Sist.Administrador/Revisiones/List/ticket.php?id=<?= $row['id'] ?>','','GET','cargaajax');">
                                                <?= $trans4[0] ?>
                                            </a>
                                        </td>
                                        <td><?= $trans4[0] ?></td>
                                        <td><?= $trans4[0] ?></td>
                                        <td><?= $trans4[0] ?></td>
                                        <td><?= $trans4[0] ?></td>
                                        <td><?= $trans4[0] ?></td>
                                    </tr>
                            <?
                                }
                            }
                            ?>


                            <!--  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>-->

                            <tr>
                                <td colspan="5" align="right"><strong>Total</strong></td>
                                <td><strong><?= "$" . FormatDinero($total) ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" align="right"><strong>Ganancia</strong></td>
                                <td><strong><?= "$" . FormatDinero($ganancia) ?></strong></td>
                            </tr>

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