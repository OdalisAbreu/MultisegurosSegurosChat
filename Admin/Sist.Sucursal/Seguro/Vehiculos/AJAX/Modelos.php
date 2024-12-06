<?
	ini_set('display_errors',1);
	$login ='7bhoi';
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	 
	
		$marca_id 	= $_GET['marca_id'];
		if($_GET['tipo']){
				$tipo = $_GET['tipo'];
				echo' <select name="modelo" id="modelo" style="display:compact" class="form-control">
						<option value="0">- Seleccionar - </option>';

				$rescat = mysql_query("SELECT DISTINCT descripcion, ID, IDMARCA, tipo FROM seguro_modelos WHERE IDMARCA = '$marca_id' order by ID");
				
				while ($cat = mysql_fetch_array($rescat)) {
					if($cat['tipo']){
						
						if(substr_count($cat['tipo'],"".$tipo."-")>0){
							$c = $cat['descripcion'];
							$c_id = $cat['ID'];
							if($_GET['selec'] == $c_id){
							echo "<option value=\"$c_id\" selected>$c</option>"; 
							}else{
							echo "<option value=\"$c_id\" >$c</option>"; }	
						}else{
							echo "<option value=\"$c_id\" >$c</option>"; }						
					
					}else{
						$c = $cat['descripcion'];
						$c_id = $cat['ID'];
						if($_GET['selec'] == $c_id){
						echo "<option value=\"$c_id\" selected>$c</option>"; 
						}else{
						echo "<option value=\"$c_id\" >$c</option>"; }
					}
					
				}

			echo '</select>';		
		}else{
			echo'<select name="modelo" id="modelo" style="display:compact" class="form-control">
			<option value="0">- Seleccionar - </option>
			';
	  
		$rescat = mysql_query("SELECT DISTINCT descripcion, ID, IDMARCA FROM seguro_modelos WHERE IDMARCA = '$marca_id' order by ID");
		while ($cat = mysql_fetch_array($rescat)) {
				$c = $cat['descripcion'];
				$c_id = $cat['ID'];
				if($_GET['selec'] == $c_id){
				echo "<option value=\"$c_id\" selected>$c</option>"; 
				}else{
				echo "<option value=\"$c_id\" >$c</option>"; }
			}
	
		echo '</select>';
		} 
				

?>