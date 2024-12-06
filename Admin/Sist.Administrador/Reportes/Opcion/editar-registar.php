<?
	// ESTE ARCHIVO LO USAMOS TANTO PARA EDITAR COMO PARA REGISTRAR NUEVO
	ini_set('display_errors', 1);
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../../incluidos/fechas.func.php");
	
	$fecha_pago = fecha_despues(''.date('d/m/Y').'',-0);
	
	$r2 = mysql_query("SELECT * from remesas WHERE id ='".$_GET['id']."' LIMIT 1");
    $row = mysql_fetch_array($r2);
	
	//suplidores
	$r3 = mysql_query("SELECT * from suplidores WHERE id ='".$row['id_aseg']."' LIMIT 1");
    $row3 = mysql_fetch_array($r3);
	
	if($row['tipo_serv']=='prog'){
		$nombre = NombreProgS($row['id_aseg']);
	}else{
		$nombre = NombreSeguroS($row['id_aseg']);
	}
	
	
	// ACTIONES PARA TOMAR ....
	if($_GET['accion']){
		$acc	= $_GET['accion'];
		$acc_text = 'Registrar';
	}else{
		$acc 	= 'Editar';
		$acc_text 	= 'Pagar Remesa';
	}
	
 ?>
 <script language="JavaScript" type="text/javascript">
	

 
	function Validar() {
		
		// validar  nombre
		if($('#num_doc').val().length < 4){
			$("#num_doc").css("border","solid 1px #F00");
			var HayError = true;
		}else { 
			$("#num_doc").css("border","solid 1px #ccc"); 
		}
	
	// validar  nombre
		if($('#fecha_pago').val().length < 4){
			$("#fecha_pago").css("border","solid 1px #F00");
			var HayError = true;
		}else { 
			$("#fecha_pago").css("border","solid 1px #ccc"); 
		}
			
		if (HayError == true){
			//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
		} else {
		
		CargarAjax2_form('Admin/Sist.Administrador/Reportes/remesas.php?consul=1','form_edit_perso','cargaajax');
		
		}
	
}


</script>
<form action="" method="post" enctype="multipart/form-data" id="form_edit_perso">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?=$acc_text?></h4>
</div>

<div class="modal-body" style="margin-top: -10px;
    margin-bottom: -30px;">



	<div class="panel-body">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Información de la remesa
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="info">
                                <p>
                                    <div class="row">
          <div class="col-lg-2">
         	<label class="strong">Nombre</label>
          </div>
          
          <div class="col-lg-10">
             <div class="form-group "  style="color:#428bca">
				<b><?=$nombre?></b>
            </div>
          </div>
          
          
          
        </div>  
        <div class="row"> 
        
        <div class="col-lg-3">
         	<label class="strong">Remesa #</label>
          </div>
          
          <div class="col-lg-3">
             <div class="form-group" style="color:#428bca">
				<b>
				 <?  if($row['tipo_serv'] =='prog'){
						echo $row['year']."-".$row['num'];
					}else{
						echo Sigla($row['id_aseg'])."-".$row['year']."-".$row['num'];
					} 
				?>
                </b>
            </div>
          </div>
        
         
          <div class="col-lg-3">
         	<label class="strong">Monto</label>
          </div>
          
          <div class="col-lg-3">
             <div class="form-group "  style="color:#428bca">
				<b><?="$".FormatDinero($row['monto'])?></b>
            </div>
          </div>
          
          
          
          
          <div class="col-lg-12">
          <label class="strong">Banco Empresa</label>
            <div class="form-group ">
               <select  class="form-control" id="banc_emp" name="banc_emp">
  <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT * from cuentas_de_banco WHERE user_id ='".$_SESSION['user_id']."' ");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$c2 = Bancos($cat2['id_banc']);
			$num = $cat2['num_cuenta'];
			$a_nombre_de = $cat2['a_nombre_de'];
			$c_id2 = $cat2['id'];
            
			if($c_id2==$row['id_banc']){
				echo "<option value=\"$c_id2\" selected>$c2 #$num > $a_nombre_de</option>"; 
			}else{
				echo "<option value=\"$c_id2\" >$c2 #$num > $a_nombre_de</option>";
			}
        } ?> 
</select> 
            </div>
          </div>
          
          <div class="col-lg-12">
          <label class="strong">Banco Beneficiario</label>
            <div class="form-group ">
               <select  class="form-control" id="banc_benef" name="banc_benef">
  <? ///  SELECCION DEL TIPO .....................................
$rescat3 = mysql_query("SELECT * from bancos_suplidores WHERE id_seguro ='".$row['id_aseg']."' 
order by nombres ASC");
    while ($cat3 = mysql_fetch_array($rescat3)) {
			$c3 = BancoNomNew($cat3['id_banc']);
			$num = $cat3['num_cuenta'];
			$c_id3 = $cat3['id'];
            
			if($c_id2==$row['id_banc']){
				echo "<option value=\"$c_id3\" selected>$c3 #$num</option>"; 
			}else{
				echo "<option value=\"$c_id3\" >$c3 #$num</option>";
			}
        } ?> 
</select>
            </div>
          </div>
          
          
           <div class="col-lg-6">
         <label class="strong">No. Transacci&oacute;n</label>
             <div class="form-group ">
                <input type="text" class="form-control" placeholder="No. Documentos" id="num_doc" name="num_doc" value="<?=$row['num_doc']?>" >
            </div>
          </div>
          
          <div class="col-lg-6">
         <label class="strong">Fecha de pago</label>
             <div class="form-group ">
                <input type="text" class="form-control" id="fecha_pago" name="fecha_pago" value="<?=$fecha_pago?>" >
            </div>
          </div>
          
          
          <div class="col-lg-12">
         <label class="strong">Descripcion</label>
             <div class="form-group ">
                <input type="text" class="form-control" placeholder="descripcion" id="descrip" name="descrip" value="<?=$row['descrip']?>">
            </div>
          </div>
          
          <div class="col-lg-12">
         <label class="strong">Emails a enviar</label>
             <div class="form-group ">
                <input type="text" class="form-control" placeholder="Emails" id="email" name="email" value="<?=$row3['email_finanzas']?>">
            </div>
          </div>
          
          
          
  					</div>
                </div>
            </div>
          </div>
        </div>
      
    </div>
  </div>
 </div>

                <input name="accion" type="hidden" id="accion" value="<?=$acc?>">
                <input name="id" type="hidden" id="id" value="<?=$row['id']?>" />
                
				<input name="pago" type="hidden" id="pago" value="s" />
               
                
       </div>     
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               <button name="acep" type="button" id="acep" class="btn btn-success" onClick="Validar()"><?=$acc_text?></button>
                                            
                                       </div>
	</form>
    
    <script>
	$(function() {
			$("#fecha_pago").datepicker({dateFormat:'dd/mm/yy'});
		});
	</script>