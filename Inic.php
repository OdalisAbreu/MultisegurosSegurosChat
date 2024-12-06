<? 
	session_start();
	if(!$_GET['op']){  
		header("Location: ?op=login/Login"); 
	}
	
	include("incluidos/conexion_inc.php");
	include("incluidos/nombres.func.php");
	conectarse();
	?>
<!--    http://startbootstrap.com/template-overviews/sb-admin-2/--><!DOCTYPE html>
<html lang="en"><head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    
    <!--ultimo contenido agregado-->
    <meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<!--ultimo contenido agregado-->


    <title>Sistema de administraci&oacute;n de Seguros</title>
	
      <link href="css/cargarajax.css" rel="stylesheet">
       <link href="css/theme.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/Error.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
     



   <!--para el despliegue de la fecha-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-2.1.4.min.js">
         jQuery.noConflict(); 
    </script>
    	
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
          
     <!-- para cargar la ventana -->
     <script src="incluidos/js/ventanas.js"></script>
     <script src="incluidos/js/funciones.js"></script>
     
     <!-- PARA EL CHART--> 
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


     <link href="incluidos/js/ventanas.css" rel="stylesheet">
     <!--  modificar funcion por la del modal en CargarAjax_win --> 
</head>

<body id="security">
<!--  para poder lanzar el modal -->
<a href="#myModal" data-toggle="modal" class="btn btn-primary" id="abrir_modal" style="display:none;">...<a> 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" id="contenedor_win">
                                        
                                       
                                        
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
 <!--  para poder lanzar el modal -->
 
 <!--  para poder lanzar el div cargando -->
<div id="apps_cargar_ajax" style="display:none">
Cargando <img src="images/ajax-loader.gif" width="220" height="19">
</div>
<!--  para poder lanzar el div cargando -->



    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <!--<span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
-->                </button>
                <script>
				function clicklogo(){
					Location: login/Login.php
				}
				</script>
                <a class="navbar-brand" href="#" onClick="clicklogo()">
                	<b><img src="images/sc_ic.png" height="45" alt="" style="padding-bottom: 0px;
    margin-top: -12px;"/></b>
                </a>
            </div>
         

            <ul class="nav navbar-top-links navbar-right">
            
            <? if($_SESSION['funcion_id'] !=='1' && $_SESSION['funcion_id'] !=='34'  && $_SESSION['funcion_id'] !=='37'  && $_SESSION['funcion_id'] !=='36'){?>    
               <!--para visualizar balance en el top-->
               <li class="balance open hidden-phone " onclick="CargarAjax2('incluidos/Balance/BalanceActual.php','','GET','bl_actual');">
<span id="bl_actual" style="float:left; margin-right:12px; cursor:default; padding-top:10px; padding-left:7px; padding-bottom:7px; padding-right:7px; margin-bottom:-14px; border:solid 1px #E7E7E7;" class="balance">$0.00</span> 
</li>
<script>$(document).ready(function(e) {CargarAjax2('incluidos/Balance/BalanceActual.php','','GET','bl_actual');});</script>
               <!--para visualizar balance en el top-->
               <? } ?>
               
                <li><strong>Hola! <?=Clientepers($_SESSION['user_id'])?></strong></li>
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> 
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                        	<b style="text-align: center !important; margin-left: 15px; font-size: 16px;"> <?=$_SESSION['nivel']?> </b>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#" onClick="CargarAjax2('Admin/Configuracion/datos_generales.php?accion=editar','','GET','cargaajax');"><i class="fa fa-gear fa-fw" style="color:#428BCA"></i> Configuracion</a>
                        </li>
                        
                        <li><a href="?op=login/Desconectar"><i class="fa fa-sign-out fa-fw" style="color:#428BCA"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
  
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <? include("P/".$_SESSION['nivel']."_menu.php");?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            
                        <a name="enfocar" id="enfocar"></a>
                          <? 
                      
                      if(!$_GET['op']){ }else{ 
                        
                        // ---------------- ANTI REMOTE INCLUDE ----------------
                        $slap 	= explode('/',$_GET['op']);
                        $n_slap = count($slap);
                        
                        if($n_slap >2){ }
                        
                        // ---------------- ANTI REMOTE INCLUDE ----------------
                        include($_GET['op'].".php"); 
                      }  ?> 
      </div>
    </div>
    <!-- /#wrapper -->
   <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <script src="js/sb-admin-2.js"></script>
</body>
</html>