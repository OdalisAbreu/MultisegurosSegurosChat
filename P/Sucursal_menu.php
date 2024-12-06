<? 
ini_set('display_errors',1);
ini_set('session.cache_expire','3000');
if($_SESSION["funcion_id"] =='3' && $_SESSION["tipo_conex"]=='WEB'){ ?>

<li><a href="#" onClick="CargarAjax2('Admin/Sist.Sucursal/Inicio/inicio.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Dashboard </a></li>
<li><a href="#" onClick="CargarAjax_win('Admin/Sist.Sucursal/Seguro/seguroV2.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Vender Seguro </a></li> 

<? if($_SESSION['user_id']=='17'){?>
	<li><a href="#" onClick="CargarAjax_win('Admin/Sist.Sucursal/Seguro/seguroV3.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Vender Seguro nuevo </a></li> 
<? } ?>

   <li>
      <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Finanzas<span class="fa arrow"></span></a>
      <ul class="nav nav-second-level">
        <li><a href="#" onClick="CargarAjax2('Admin/Sist.Sucursal/Finanzas/recargados.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Recargado / Retirado</a></li>
       
        <li><a href="#" onClick="CargarAjax2('Admin/Sist.Sucursal/Bancos/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Cuentas para depositos</a></li>
      </ul>
  </li>

<li>
    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reportes<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        
<li><a href="#" onClick="CargarAjax2('Admin/Sist.Sucursal/Reportes/listado_trans.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Transacciones</a></li>
    </ul>
    <!-- /.nav-second-level -->
</li>


<? } ?>