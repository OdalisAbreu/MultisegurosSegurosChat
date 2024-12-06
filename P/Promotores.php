<? 
	ini_set('display_errors',1);
	ini_set('session.cache_expire','3000');  
	if($_SESSION["funcion_id"] =='35'){ 
?>

<!-- Inner -->
<div class="innerLR">
  <div class="row-fluid">
      <div class="span8 tablet-column-reset">
          	<div id="cargaajax">
              <center>
                <br />
                <br />
                <br />
                <font size="4" ><b>Cargando...</b> </font>      
              </center>
            </div>
	
		  <script>
        CargarAjax2('Admin/Sist.Distribuidor/Inicio/inicio.php','','GET','cargaajax');
        </script>
      </div>
  </div>
</div>

<? } ?>