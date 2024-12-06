<?
	session_start();
	ini_set('display_errors',1);
	$equip = $_POST['privilegio'];
	
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	include('../../../../incluidos/nombres.func.php');
?>

<div class="row"> 
<div class="col-lg-12">
    <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Listados de Clientes de
<?=ClientePers($_GET['id'])?> 
      </strong></div>
        <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                      <tr>
                        <th>#</th>
                        <th>nombre</th>
                        <th>Balance</th>
                        <th>Conexion</th>
                        <th>Estado</th>
                      </tr>
                  </thead>
                  <tbody>
  <? 

	$sql= mysql_query("SELECT * FROM personal where id_dist = '".$_GET['id']."'   ORDER BY nombres ASC "); 
	while($row=mysql_fetch_array($sql)){
		$total += $row['balance'];
?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['nombres']?></td>
    <td>$<?=FormatDinero($row['balance'])?></td> 
    <td><?=$row['tipo_conex']?></td>
    <td>
	<? if ($row['activo']=='si'){ 
		echo "<font color='#1D0CD6'><b>Activo</b></font>";
	   }else{
		echo "<font color='#F6060A'><b>Inactivo</b></font>";
	   }
	?>
    </td>
  </tr>
  <?   }?>
    </tbody>
    
    <tr>
    	<td colspan="4" style="text-align: right;"><strong> Total: </strong></td>
        <td><strong>$
          <?=FormatDinero($total)?>
        </strong></td>
    </tr>
</table>
 </div>
                            <!-- /.table-responsive -->
      </div>
                        <!-- /.panel-body -->
    </div>
                    <!-- /.panel -->
                </div>
            </div>