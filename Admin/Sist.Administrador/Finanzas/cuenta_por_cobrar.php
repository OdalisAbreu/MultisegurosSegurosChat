<?
	session_start();
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	include("../../../incluidos/nombres.func.php");
	Conectarse();
?>

<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Cuenta por Cobrar</h3>
    </div>
</div>

    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
        <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                    	<td>
                        
                        <label>ID cliente:</label>
                        <input type="text" name="id_pers" id="id_pers" class="input-mini hasDatepicker" value="<?=$_GET['id_pers']?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar
                        </button>
                        </td>
                       
                      </tr>
                
               </table>
                    	
									
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var id_pers 	= $('#id_pers').val();

	CargarAjax2('Admin/Sist.Administrador/Finanzas/cuenta_por_cobrar.php?id_pers='+id_pers+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 
	
	  </script>

      
   
		
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Monto</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  
if($_GET['consul']=='1'){  
  	
	if($_GET['id_pers']){
		$req = "AND id = '".$_GET['id_pers']."' ";	
	}else{
		$req = "AND id != '' ";	
	}
	
$query=mysql_query("SELECT * FROM personal WHERE activo != 'no' AND id_dist ='".$_SESSION['user_id']."' $req order by id ASC");
  while($row=mysql_fetch_array($query)){
	if(CredActual($row['id'])>1){  

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['nombres']?></td>
    <td><?="$".FormatDinero(CredActual($row['id'])); $total += CredActual($row['id'])?></td>
</tr>
  <? 
  } 
 }
}
?>
  
  <!--<tr>
  	<td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>-->
  <tr>
  	<td></td>
    <td><strong>Total:</strong></td>
    <td>$<?=FormatDinero($total)?></td>
  </tr>
    </tbody>
</table>
 </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>