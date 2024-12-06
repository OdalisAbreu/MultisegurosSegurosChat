<?
	
	$irUrl = 'login/Login.php';
	// REGISTRAMOS ACCESO
	//include("incluidos/Func_Accesos/Registro.php");
	//RegAcceso_Salida();  
	session_destroy();
?>






<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

               <div class="row">
                <div class="col-lg-4">
                    
                </div>
                 <div class="col-lg-4">
                    <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Desconectando</h3>
                    </div>
                       <div class="panel-body">
                                <div class="form-group">
                                    <font style="font-size:16px; color:#000;"><b>Por favor espere <img src="images/ajax-loader.gif" width="220" height="19"></b></font>
                                </div>
                       </div>
                </div>
                </div>
                </div>
</html>




<script LANGUAGE="JavaScript">
	$(".nav navbar-top-links navbar-right").fadeOut(0);
	$(".navbar-default sidebar").fadeOut(0);
	$(".sidebar-nav navbar-collapse").fadeOut(0);
	$("#side-menu").fadeOut(0);
	
	
	function redireccionar() {
	    location.href="<? echo $irUrl;?>" 
	}
	
	setTimeout ("redireccionar()", 1000);
		
</script> 


