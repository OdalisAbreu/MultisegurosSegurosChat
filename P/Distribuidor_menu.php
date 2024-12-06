<? 
ini_set('display_errors',1);
ini_set('session.cache_expire','3000');


if($_SESSION["funcion_id"] =='2' && $_SESSION["tipo_conex"]=='http-request'){ ?>

<li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Inicio/inicio.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Dashboard</a></li>
<li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_trans.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Transacciones</a></li>

<li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Finanzas/recargados.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Reportes de balances </a></li>





<? }elseif($_SESSION["funcion_id"] =='2' && $_SESSION["tipo_conex"]=='WEB'){ ?>

<li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_trans.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Dashboard </a></li>

  <li>
      <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Finanzas<span class="fa arrow"></span></a>
      <ul class="nav nav-second-level">
        <!--<li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_trans.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Transacciones</a></li>-->

<li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Finanzas/recargados.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Recarga de Balances </a></li>
        <li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Finanzas/recargadosCliente.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Recarga X Representantes </a></li>
        <li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Bancos/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Cuentas para Depositos</a></li>
       <!-- <li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Bancos/List/listadoDist.php','','GET','cargaajax');">
        <i class="fa fa-tag fa-fw"></i> Cuentas de bancos</a></li>-->
        
          
      </ul>
  </li>

<li>
    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reportes<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
       <!-- <li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_trans.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Resumen de ventas</a></li>-->
<li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_trans.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Transacciones</a></li>

<li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Reportes/listado_agencia.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Ventas por agencia</a></li>


    </ul>
    <!-- /.nav-second-level -->
</li>



<li>
    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Dependientes<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
    	<li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Supervisor/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Supervisor</a></li>
        <li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Agencia/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Agencias </a></li>
        <li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Personal/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Representante</a></li>
        
         
    </ul>
    <!-- /.nav-second-level -->
</li>

<li>
    <a href="#"><i class="fa fa-wrench fa-fw"></i> Herramientas<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
    
    <li><a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Agencia/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Agencias </a></li>
    
    </ul>
</li>
<li>
    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Revisiones<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
      <li>
        <a href="#" onClick="CargarAjax2('Admin/Sist.Distribuidor/Revisiones/Ticket/listado.php','','GET','cargaajax');">Modificar Poliza</a>
      </li>
    </ul>
    <!-- /.nav-second-level -->
  </li>







<? } ?>