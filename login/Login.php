<?
ini_set("display_errors", 1);
session_start();
if ($_SESSION['user_id']) {
    $func2 = $_SESSION['user_funcion'];
    if ($func2 == '1') {
        $irUrl2 = "/SegurosChat/Inic.java?op=P/Administrador";
    } elseif ($func2 == '2') {
        $irUrl2 = "/SegurosChat/Inic.java?op=P/Distribuidor";
    } elseif ($func2 == '3') {
        $irUrl2 = "/SegurosChat/Inic.java?op=P/Sucursal";
    } elseif ($func2 == '34') {
        $irUrl2 = "/SegurosChat/Inic.java?op=P/Recargadores";
    } elseif ($func2 == '35') {
        $irUrl2 = "/SegurosChat/Inic.java?op=P/Promotor";
    } elseif ($func2 == '36') {
        $irUrl2 = "/SegurosChat/Inic.java?op=P/Suplidor";
    } elseif ($func2 == '37') {
        $irUrl2 = "/SegurosChat/Inic.java?op=P/Dependientes";
    }
    /*
echo"<script>location.href='$irUrl2';</script>"; 
die();
*/
}

if ($_POST) {

    $login = '7bhoi';

    include("../incluidos/conexion_inc.php");
    Conectarse();

    $_POST["clave"] = limpiarCadena($_POST["clave"]);
    $_POST["usuario"] = limpiarCadena($_POST["usuario"]);

    $sql = mysql_query("select * from personal 
	where email = '" . $_POST["usuario"] . "' and password='" . $_POST["clave"] . "' AND activo ='si'  LIMIT 1");
    $datos_user = mysql_fetch_array($sql);

    $sql2 = mysql_query("select * from suplidores 
	where id='" . $datos_user['id_suplid'] . "' LIMIT 1");

    $datos = mysql_fetch_array($sql2);


    if ($datos_user['id'] > 0) {

        $_SESSION["user_id"]                   = $datos_user['id'];
        $_SESSION["funcion_id"]              = $datos_user['funcion_id'];
        $_SESSION["nombre_conetado"]            = $datos_user['nombres'];
        $_SESSION["autentificado"]             = "SI";
        $_SESSION["dist_id"]                 = $datos_user['id_dist'];
        $_SESSION["tipo_conex"]                 = $datos_user['tipo_conex'];
        $_SESSION["show_bl_princ"]             = $datos_user['show_bl_princ'];
        $_SESSION["id_suplid"]                 = $datos['id_seguro'];
        //echo "Logueado...";

        if ($datos_user['funcion_id'] == '1') {
            $irUrl = "../Inic.php?op=P/Administrador";
            $_SESSION['nivel'] = 'Administrador';
        } elseif ($datos_user['funcion_id'] == '2') {
            $irUrl = "../Inic.php?op=P/Distribuidor";
            $_SESSION['nivel'] = 'Distribuidor';
        } elseif ($datos_user['funcion_id'] == '3') {
            $irUrl = "../Inic.php?op=P/Sucursal";
            $_SESSION['nivel'] = 'Sucursal';
        } elseif ($datos_user['funcion_id'] == '34') {
            $irUrl = "../Inic.php?op=P/Recargadores";
            $_SESSION['nivel'] = 'Recargadores';
        } elseif ($datos_user['funcion_id'] == '35') {
            $irUrl = "../Inic.php?op=P/Promotor";
            $_SESSION['nivel'] = 'Promotores';
        } elseif ($datos_user['funcion_id'] == '36') {
            $irUrl = "../Inic.php?op=P/Suplidor";
            $_SESSION['nivel'] = 'Suplidor';
        } elseif ($datos_user['funcion_id'] == '37') {
            $irUrl = "../Inic.php?op=P/Dependientes";
            $_SESSION['nivel'] = 'Dependientes';
        }

        $Login = "Autentificacion Autentica.";

?>
        <script LANGUAGE="JavaScript">
            function redireccionar() {
                location.href = "<?= $irUrl; ?>"
            }
            setTimeout("redireccionar()", 1000);
        </script>
<?
    } else {
        $errLogin = "Autentificacion Fallida.";
    }
} else {

    session_destroy();
}

?>



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>





<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MultiSeguros - Sistema de Administracion de seguros</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<style>
    img {
        width: 100%;
        max-width: 400px;
    }
</style>

<body onLoad="document.forms[0].usuario.focus()">

    <div class="container">
        <div class="row">
            <div align="center" style="margin-bottom: -3%; margin-top: 4%;">
                <img src="https://multiseguros.com.do/SegurosChat/images/sc_ic.png" alt="" />
            </div>
            <div class="col-md-4 col-md-offset-4">

                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="form_login" name="form_login" method="post" action="#">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" name="usuario" autocomplete="off" type="text" id="usuario" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="clave" type="password" id="clave" autocomplete="off" value="">
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                <!--<a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
                                <input name="acep" type="submit" id="acep" value="Entrar" class="btn btn-lg btn-primary btn-block" />
                            </fieldset>
                        </form>
                    </div>

                </div>

                <div class="row" align="center">
                    <div class="col-md-12">
                        <span class="alert alert-danger" style=" display:none; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="user">Usuario Vacio</span>

                        <? if ($Login) { ?>
                            <span class="alert alert-success" style="display:none; margin-bottom:0px; margin-top:0px; margin-right:0px;"><b>Succes!</b> <?= $Login ?></span>
                        <? } ?>

                        <? if ($errLogin) { ?>
                            <span class="alert alert-danger" style="margin-bottom:0px; margin-top:0px; margin-right:0px;"><b>Error!</b> <?= $errLogin ?></span>
                        <? } ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <script src="../js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>

</body>

</html>