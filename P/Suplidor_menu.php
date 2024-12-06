<? 
ini_set('display_errors',1);
ini_set('session.cache_expire','3000');

if($_SESSION["funcion_id"] =='36'){ ?>

<li>
	<a href="#" onClick="CargarAjax2('Admin/Sist.Suplidor/Inicio/inicio.php','','GET','cargaajax');">
    	<i class="fa fa-tag fa-fw"></i> Dashboard 
    </a>
</li>

 <li>
 	<a href="#" onClick="CargarAjax2('Admin/Sist.Suplidor/Reportes/listado_trans_aseg.php','','GET','cargaajax');">
    <i class="fa fa-tag fa-fw"></i> Transacciones
    </a>
 </li>

  



<? } ?>