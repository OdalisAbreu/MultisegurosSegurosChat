<?
ini_set('session.cache_expire', '3000');
if ($_SESSION["funcion_id"] == '1') { ?>


  <!--<li><a href="#" onClick="CargarAjax2('Admin/SubirArchivos/List.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Subir Agencias</a></li>-->
  <li>
    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reportes<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">

      <!-- <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Resumen de ventas</a></li>-->



      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans_aseg.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Trans. Aseguradoras</a></li>

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans_suplidor.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Trans. Suplidores</a></li>


      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/listado_trans_anuladas.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Polizas Anuladas</a></li>

      <!-- <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Grupos/Reportes/ventas_por_grupos_V2.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Ventas por grupo</a></li>-->

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/ventas_por_distribuidor.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Ventas por Distribuidor</a></li>


      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/ventas_por_serv_opcional2.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Ventas por Serv. Opc.</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/ventas_por_serv_opcional.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Ventas por Serv. Opc. y Distribuidor</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/remesas.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Reporte de remesas</a></li>


      <!--<li><a href="#" onClick="CargarAjax2('prueba/listado_trans.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Prueba</a></li>-->

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/listado.polizs.remitidas.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Rep. Polizas remitidas</a>
      </li>




    </ul>
    <!-- /.nav-second-level -->
  </li>






  <li>
    <a href="#"><i class="fa fa-database fa-fw"></i> Finanzas<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Finanzas/cuenta_por_cobrar.php','','GET','cargaajax');">
          <i class="fa fa-tag fa-fw"></i> Cuentas por Cobrar</a></li>

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Finanzas/recargados.php','','GET','cargaajax');">
          <i class="fa fa-tag fa-fw"></i> Recargas / Retiros </a></li>


      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Bancos/List/listado.php','','GET','cargaajax');">
          <i class="fa fa-tag fa-fw"></i> Cuentas de bancos</a></li>

    </ul>
    <!-- /.nav-second-level -->
  </li>



  <li>
    <a href="#"><i class="fa fa-group fa-fw"></i> Dependientes<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">

      <!--<li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Suplidores/Cuentas/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Suplidor</a></li>
       -->
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Personal/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Distribuidor</a></li>
      <!--/*representante*/-->


      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Promotores/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Promotor</a></li>


      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Beneficiario/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Beneficiario</a></li>


      <!--       
<li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Grupos/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Grupos</a></li>-->

    </ul>
    <!-- /.nav-second-level -->
  </li>

  <li>
    <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Recargadores/List/listado.php','','GET','cargaajax');"><i class="fa fa-user fa-fw"></i> Recargadores</a>
  </li>

  <li>
    <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Comisiones/List/listado.php','','GET','cargaajax');"><i class="fa fa-btc fa-fw"></i> Comisiones</a>
  </li>

  <li>
    <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Opciones/Anular.php','','GET','cargaajax');"><i class="fa fa-ban fa-fw"></i> Anular Seguro</a>
  </li>


  <li>
    <a href="#"><i class="fa fa-wrench fa-fw"></i> Herramientas<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Marcas/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Marcas</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Provincia/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Provincia</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Tarifas/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Tarifas</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Tarifas_backup/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Tarifas backup</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Tarifas_backup/List/Costolistado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Costos backup</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Suplidores/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Suplidores</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Seguros/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Aseguradoras</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Servicios/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Servicios</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Servicios_backup/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Servicios backup</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Privilegios/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Privilegios</a></li>
      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Validadores/Placas/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Validar Placas</a></li>


    </ul>
    <!-- /.nav-second-level -->
  </li>


  <li>
    <a href="#"><i class="fa fa-wrench fa-fw"></i> Acciones<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/AccionesRep/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Listado </a></li>

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/Form.Gen.Remesas.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Generar Remesas </a></li>

      <li><a href="#" onClick="CargarAjax2('../ws_schat/Seguros/UpdateHistorial.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Act. Hist. Vent. </a></li>


      <li><a href="#" onClick="CargarAjax2('../ws_schat/Seguros/UpdateHistorialServicios.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> Act. Hist. Serv. </a></li>

      <li><a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/CronTab/List/listado.php','','GET','cargaajax');"><i class="fa fa-tag fa-fw"></i> CronTab </a></li>



    </ul>
    <!-- /.nav-second-level -->
  </li>


  <li>
    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Revisiones<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
      <li>
        <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Revisiones/List/board.php','','GET','cargaajax');">Board</a>
      </li>
      <li>
        <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Revisiones/List/listado_trans.php','','GET','cargaajax');">Cedula</a>
      </li>
      <li>
        <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Revisiones/Ticket/listado.php','','GET','cargaajax');">Modificar Ventas</a>
      </li>
      <li>
        <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Revisiones/Imprimir/listado.php','','GET','cargaajax');">Consulta poliza</a>
      </li>

      <li>
        <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Revisiones/Bal/listado.php','','GET','cargaajax');">Validar Balance</a>
      </li>
      <li>
        <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Revisiones/Ventas/VentDiarias.php','','GET','cargaajax');">Verificar ventas diarias</a>
      </li>

      <li>
        <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Revisiones/Poliza/VerificarPolizaPersonal.php','','GET','cargaajax');">Verificar Poliza Personal</a>
      </li>

    </ul>
    <!-- /.nav-second-level -->
  </li>

  <li>
    <a href="#"><i class="fa fa-cloud-download fa-fw"></i> Descargas<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">


      <li>
        <a href="Admin/Sist.Administrador/Marcas/Export/marcas.php">Marcas</a>
      </li>
      <li>
        <a href="Admin/Sist.Administrador/Marcas/Export/modelos.php">Modelos</a>
      </li>

    </ul>
    <!-- /.nav-second-level -->
  </li>

  <a href="https://multiseguros.com.do/Seg_V2/Inic.php?op=P/Administrador" name="bt_buscar" class="btn btn-danger" style="margin-left:55px; margin-top: 50px;">
    Ir a Multiseguros
  </a>


<? } ?>