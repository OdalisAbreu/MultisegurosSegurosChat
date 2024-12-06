<?
	session_start();
	ini_set('display_errors',1);
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
?>

<div class="row" >
    <div class="col-lg-10">
        <h3 class="page-header">Listados de Cuentas de bancos </h3>
    </div>
</div>

    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
                
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Banco</th>
                            <th>No. cuenta</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  	
	
	
 $query=mysql_query("SELECT * FROM cuentas_de_banco
 WHERE activo = 'si' AND user_id ='".$_SESSION['dist_id']."' order by id ASC");
  while($row=mysql_fetch_array($query)){ 

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['a_nombre_de']?></td>
     <td><?=$row['nombre_banc']?></td>
    <td><?=$row['num_cuenta']?></td>
  </tr>
  <? } ?>
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