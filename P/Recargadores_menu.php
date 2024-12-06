<? 
ini_set('session.cache_expire','3000'); 
if($_SESSION["funcion_id"] =='34'){ ?>

<li>
    <a class="glyphicons ban" onClick="CargarAjax2('Admin/Sist.PersonalRecargas/List/Listado_Client.php','','GET','cargaajax');">
    <i class="fa fa-user fa-fw"></i> Clientes</a>
</li>
 
 <li>
    <a class="glyphicons ban" onClick="CargarAjax2('Admin/Sist.PersonalRecargas/Opciones/recargados.php','','GET','cargaajax');">
    <i class="fa fa-user fa-fw"></i> Depositos / Retiros</a>
</li>

 <li>
    <a class="glyphicons ban" onClick="CargarAjax2('Admin/Sist.PersonalRecargas/CierreCaja/CuadreBancos_CierreCaja_New.php','','GET','cargaajax');">
    <i class="fa fa-bar-chart-o fa-fw"></i> Cierres de Caja<span class="fa arrow"></span></a>
</li>                       
                        
<li>
    <a class="glyphicons ban" onClick="CargarAjax2('Admin/Sist.PersonalRecargas/List/Listado_Cuadres.php','','GET','cargaajax');">
    <i class="fa fa-bar-chart-o fa-fw"></i> Listados de Cierres<span class="fa arrow"></span></a>
</li> 

<? } ?>