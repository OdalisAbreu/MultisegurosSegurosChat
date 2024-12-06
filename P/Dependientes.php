<? 
	if($_SESSION["funcion_id"] =='37'){
?>
<div class="innerLR">
  <div class="row-fluid">
      <div class="span8 tablet-column-reset">
          	<div id="cargaajax">
              <center>
                <br /><br /><br />
                <font size="4" ><b>Cargando...</b> </font>      
              </center>
            </div>
		  <script>
        CargarAjax2('Admin/Sist.Dependientes/Reportes/listado_trans.php','','GET','cargaajax');
        </script>
      </div>
  </div>
</div>
<? } ?>