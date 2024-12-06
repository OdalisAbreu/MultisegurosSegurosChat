<?
	// FUNCIONES DE AUDITORIAS
	
	function AudRetBal($id_pers,$user_id,$monto,$bl_actual){
	
	$r2 = mysql_query("
	INSERT INTO auditoria_retiro_balance (user_id,id_dist,monto,blactual,fecha) VALUES
	('$id_pers','$user_id','$monto','$bl_actual','".date('Y/m/d H:i:s')."')");

	}
	


?>