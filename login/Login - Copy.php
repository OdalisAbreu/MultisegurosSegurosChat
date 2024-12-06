<?
session_start(); 
if($_SESSION['user_id']){
	$func2 = $_SESSION['user_funcion'];
	
if($func2 == '1'){
	$irUrl2 = "/SegurosChat/Inic.java?op=P/Administrador"; 
}elseif($func2 == '2'){
	$irUrl2 = "/SegurosChat/Inic.java?op=P/Distribuidor"; 
}elseif($func2 == '3'){
	$irUrl2 = "/SegurosChat/Inic.java?op=P/Sucursal"; 
}
/*
echo"<script>location.href='$irUrl2';</script>"; 
die();
*/
}

  if ($_POST){  
		include("../incluidos/conexion_inc.php"); 
		Conectarse(); 
		
$user222 = $_POST["usuario"]; if(!$user222) $user222 = '0000000000'; $user222 = str_replace('#','',$user222); $user222 = str_replace('WHERE','',$user222); $user222 = str_replace(' ','',$user222); 
$pass222 = $_POST["clave"]; if(!$pass222) $pass222 = '00.00.000000'; $pass222 = str_replace('#','',$pass222); $pass222 = str_replace('WHERE','',$pass222); $pass222 = str_replace(' ','',$pass222);  

$ssql = "select * from personal where (user = '".$user222."' or id='00".$user222."') and password='".$pass222."' "; 

$rs333 = mysql_query($ssql); 

if(mysql_num_rows($rs333)==1){ 
	while($datos_user = mysql_fetch_array($rs333)){ 
	
$_SESSION["user_id"] 			  	= $datos_user['id']; 
$_SESSION["funcion_id"]  			= $datos_user['funcion_id']; 
$_SESSION["nombre_conetado"]		= $datos_user['nombres'];
$_SESSION["autentificado"] 			= "SI"; 
$_SESSION["dist_id"] 				= $datos_user['id_dist'];
$_SESSION["tipo_conex"] 			= $datos_user['tipo_conex'];
$_SESSION["show_bl_princ"] 			= $datos_user['show_bl_princ'];
//echo "Logueado...";



//header ("Location: edit.php");  

if($datos_user['funcion_id'] == '1'){ 
	//$irUrl = "../Inic.php?op=P/Crucero";
	$irUrl = "../Inic.php?op=P/Administrador";
	$_SESSION['nivel'] = 'Administrador';
}elseif($datos_user['funcion_id'] == '2'){ 
	//$irUrl = "../Inic.php?op=P/Crucero";
	$irUrl = "../Inic.php?op=P/Distribuidor";
	$_SESSION['nivel'] = 'Distribuidor';
}elseif($datos_user['funcion_id'] == '3'){ 
	//$irUrl = "../Inic.php?op=P/Crucero";
	$irUrl = "../Inic.php?op=P/Sucursal";
	$_SESSION['nivel'] = 'Sucursal';
}

//include("../incluidos/javascript_func.php"); 
  
 }
 
 exit("<script>location.href='$irUrl';</script>");
}


}else{
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

    <title>Seguros101.net - Sistema de Administracion de seguros</title>

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

<body onLoad="document.forms[0].usuario.focus()">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="form_login" name="form_login" method="post" action="#">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="usuario" autocomplete="off" type="text" id="usuario"  autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="clave" type="password"  id="clave" autocomplete="off" value="">
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <!--<a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
                                <input name="acep" type="submit" id="acep" value="Entrar" class="btn btn-lg btn-success btn-block" />
                            </fieldset>
                        </form>
                    </div>
                    
                </div>
                
           <div class="row">
            <div class="col-md-12">
                <span class="alert alert-danger" style=" display:none; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="user">Usuario Vacio</span>
                <span class="alert alert-danger" style="display:none; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="pass">Password Vacio</span>
                <span class="alert alert-danger" style="display:none; margin-bottom:0px; margin-top:0px; margin-right:0px;" id="user_pass">Usuario y/o Password Vacios</span>
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

<? } ?>
