<?
	//PARA CAMBIAR LOS PRECIOS DE LOS PRODUCTOS HAY QUE IR A LA RUTA:
	$servicios = $_POST['servicios'];
	session_start();
	ini_set('display_errors',1);
	include("../../../incluidos/conexion_inc.php");
	include("../../../incluidos/fechas.func.php");
	include("../../../incluidos/nombres.func.php");
	Conectarse(); 
	//include("../../inc/loteprint.func.php");
	
	$fecha1 = fecha_despues(''.date('d/m/Y').'',1);
	//$fech_Calc = fecha_despues(''.date('d/m/Y').'',-30);
	$fecha_vigente = fecha_despues(''.date('d/m/Y').'',1);
	//$fecha_vigente3 = fecha_despues(''.date('d/m/Y').'',1);
	
	  
if($_POST){
	 
   if($_POST['asegurado_nombres'] && $_SESSION['user_id']){
	
	  $_POST['producto'] ='2';
	  
	  $_POST['servicios'] = $servicios;
	
	  for($i =0; $i < count($_POST['servicios']); $i++){
				$_POST['serv'] .= "".$_POST['servicios'][$i]."-";
				$MontoServicio += MontoServicio($_POST['servicios'][$i],$_POST['vigencia_poliza']);
		}
		
		//echo "Servicios elegidos ".$_POST['serv']."<br>";
	  unset($_POST['servicios']);
	  
	  $sql 	= mysql_query(
	  "SELECT user,password FROM personal WHERE id='".$_SESSION['user_id']."' LIMIT 1");
	  $user 	= mysql_fetch_array($sql);
						
	    // para verificar seguro					
	    $xID 	= "WEB-".$_SESSION['user_id'].date('Ymdhis');
		$url ="http://multiseguros.com.do/~multiseguroscom/ws2/Seguros/GET_Poliza.php".
		"?parametros=xID=$xID&usuario=".trim($user['user']).
		"&clave=".trim($user['password']).
		"&asegurado_nombres=".str_replace(' ','+',$_POST['asegurado_nombres']).
		"&asegurado_apellidos=".str_replace(' ','+',$_POST['asegurado_apellidos']).
		"&asegurado_cedula=".$_POST['asegurado_cedula'].
		"&asegurado_direccion=".$_POST['asegurado_direccion'].
		"&asegurado_telefono1=".$_POST['asegurado_telefono1'].
		"&asegurado_email=".$_POST['asegurado_email'].
		"&ciudad=".$_POST['ciudad'].
		
		"&veh_tipo=".$_POST['veh_tipo'].
		"&veh_year=".$_POST['veh_year'].
		"&veh_marca=".$_POST['veh_marca'].
		"&veh_modelo=".$_POST['veh_modelo'].
		"&veh_chassis=".$_POST['veh_chassis'].
		
		"&veh_matricula=".$_POST['veh_matricula'].
		"&vigencia_poliza=".$_POST['vigencia_poliza'].
		"&serv_adc=".$_POST['serv'].
		"&serv_monto=".$MontoServicio.
		"&prod=".$_POST['producto']."";

		$url = str_replace(" ","+",$url);
		
		$getWS 	= file_get_contents($url);
		$respuesta = explode("/",$getWS);
		// para verificar seguro	
	
	echo '<div style="padding:30px;">';
		if($respuesta[0] =='00'){
			echo '
				<center>
					<img src="images/check.png" width="128" height="128" /><br>
					 <font size="4" color="#0066CC">   
						'.$respuesta[1].'
					  </font>
						<br>
					  <font size="2">Cliente:&nbsp;&nbsp;<b>'.$_POST['asegurado_nombres'].' '.$_POST['asegurado_apellidos'].'</b>
					  </font><br>
					  <font size="2">Transaccion no.: '.$respuesta[2].'<br></font><b>
			    </center>
				<script >
				setTimeout ("ImprimirTicket('.$respuesta[2].')", 3000);
				</script>
				';?>
				
		<?  }
		elseif($respuesta[0] =='13'){
			echo '
			<center>
				<font size="5" color="#FF0000">Error: <b>'.$respuesta[0].'</b></font>
				<br><font size="3">'.$respuesta[1].'</font>
			</center>';
		}
		
		elseif($respuesta[0] =='12'){
			echo '
			<center>
				<font size="5" color="#FF0000">Error: <b>'.$respuesta[0].'</b></font>
				<br><font size="3">'.$respuesta[1].'</font>
			</center>';
		}

		elseif($respuesta[0] !=='00'){
			echo '
			<center>
				<font size="5" color="#FF0000">Error: <b>'.$respuesta[0].'</b></font>
				<br><font size="3">Por favor, comuniquese con su proveedor.</font>
			</center> ';
		}
		
		echo '</div>';
		exit;	
	
	}
}
?>

<script>

function ImprimirTicket(nombre){
	  var ficha = document.getElementById(nombre); 
	  var ventimp = window.open(' ', 'popimpr');
	  ventimp.document.write( ficha.innerHTML );
	  ventimp.document.close();
	  ventimp.print( );
	  ventimp.close();
  }
  
function IrPaso1(){
	$("#tab1").fadeIn(0);
	$("#tab2").fadeOut(0);
	$("#tab3").fadeOut(0);
	$("#tab4").fadeOut(0);
}
	
	function IrPaso2(){
		
		var veh_tipo = $("#veh_tipo").val();
		var veh_marca = $("#veh_marca").val();
		var veh_year = $("#veh_year").val();
		// validar veh_chassis
	if(veh_tipo ==""){
		$("#veh_tipo").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#veh_tipo").css("border","solid 1px #CCC");
	 }
	 
	if(veh_marca ==""){
		$("#veh_marca").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#veh_marca").css("border","solid 1px #CCC");
	 }
	 
	 if(veh_year ==""){
		$("#veh_year").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#veh_year").css("border","solid 1px #CCC");
	 }
	 
	if($('#veh_chassis').val().length < 6){
		$("#veh_chassis").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#veh_chassis").css("border","solid 1px #CCC"); }
	
	if($('#veh_matricula').val().length < 7){
		$("#veh_matricula").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#veh_matricula").css("border","solid 1px #CCC"); }
	
	if (HayError == true){
			//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
		} else {
			//alert("ya no hay error");	
			$("#tab1").fadeOut(0);
			$("#tab2").fadeIn(0);
			$("#tab3").fadeOut(0);
	}
}
	
	
	
	function IrPaso3(){
			var asegurado_nombres2 		= $("#asegurado_nombres").val();
			var asegurado_apellidos2 	= $("#asegurado_apellidos").val();
			var asegurado_cedula2 		= $("#asegurado_cedula").val();
			var asegurado_direccion2	= $("#asegurado_direccion").val();
			var asegurado_telefono12 	= $("#asegurado_telefono1").val();
			var ciudad2				 	= $("#ciudad").val();
			
		// validar asegurado_nombres ------------------------------------------------	
	  if(asegurado_nombres2 ==""){
		$("#asegurado_nombres").css("border","solid 1px #F00");
		 var HayError = true;
	  }else{ $("#asegurado_nombres").css("border","solid 1px #CCC"); 
	  }
	 
	 if($('#asegurado_nombres').val().length < 2){
		$("#asegurado_nombres").css("border","solid 1px #F00");
		var HayError = true;
	  }else { $("#asegurado_nombres").css("border","solid 1px #CCC");}
		// validar asegurado_nombres ------------------------------------------------
		
	   // validar apellidos ---------------------------------------------------------
	 if(asegurado_apellidos2 ==""){
			$("#asegurado_apellidos").css("border","solid 1px #F00");
			 var HayError = true;
		  }else{ $("#asegurado_apellidos").css("border","solid 1px #CCC"); }
		  
	if($('#asegurado_apellidos').val().length < 2){
		$("#asegurado_apellidos").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#asegurado_apellidos").css("border","solid 1px #ccc"); }
	  // validar apellidos ---------------------------------------------------------
	  
	// validar cedula --------------------------------------------------------------
	if(asegurado_cedula2 ==""){
		$("#asegurado_cedula").css("border","solid 1px #F00");
		 var HayError = true;
	  }else{ $("#asegurado_cedula").css("border","solid 1px #CCC"); }
	  
	if($('#asegurado_cedula').val().length < 13){
		$("#asegurado_cedula").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#asegurado_cedula").css("border","solid 1px #ccc"); }
	// validar cedula --------------------------------------------------------------
	
	// validar direccion -----------------------------------------------------------
	if(asegurado_direccion2 ==""){
		$("#asegurado_direccion").css("border","solid 1px #F00");
		 var HayError = true;
	  }else{ $("#asegurado_direccion").css("border","solid 1px #CCC"); }
	  
	if($('#asegurado_direccion').val().length < 3){
		$("#asegurado_direccion").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#asegurado_direccion").css("border","solid 1px #ccc"); }
	// validar direccion -----------------------------------------------------------
	
	// validar telefono -----------------------------------------------------------
	if(asegurado_telefono12 ==""){
		$("#asegurado_telefono1").css("border","solid 1px #F00");
		 var HayError = true;
	  }else{ $("#asegurado_telefono1").css("border","solid 1px #CCC"); }
	  
	if($('#asegurado_telefono1').val().length < 12){
		$("#asegurado_telefono1").css("border","solid 1px #F00");
		var HayError = true;
	}else { $("#asegurado_telefono1").css("border","solid 1px #ccc"); }
	// validar telefono -----------------------------------------------------------
	
	// validar ciudad -------------------------------------------------------------
	if(ciudad2 ==""){
		$("#ciudad").css("border","solid 1px #F00");
		 var HayError = true;
	  }else{ $("#ciudad").css("border","solid 1px #CCC"); }
	// validar ciudad -------------------------------------------------------------
	
		
		if (HayError == true){
				//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
			} else {
				//alert("ya no hay error");	
				$("#tab3").fadeIn(0);
				$("#tab2").fadeOut(0);
				$("#tab4").fadeOut(0);		
		}
	}
	
	function IrPaso4(){
		
		$("#tab4").fadeIn(0);
		$("#tab1").fadeOut(0);
		$("#tab2").fadeOut(0);
		$("#tab3").fadeOut(0);
		
		var nombres = $("#asegurado_nombres").val();
		$("#label_nombres").text(nombres);
		
		var apellidos = $("#asegurado_apellidos").val();
		$("#label_apellidos").text(apellidos);
		
		var cedula = $("#asegurado_cedula").val();
		$("#label_cedula").text(cedula);
		
		var telefono1 = $("#asegurado_telefono1").val();
		$("#label_telefono1").text(telefono1);
		
		var telefono2 = $("#asegurado_telefono2").val();
		$("#label_telefono2").text(telefono2);
		
		var direccion = $("#asegurado_direccion").val();
		$("#label_direccion").text(direccion);
		
		var veh_tipo = $("#veh_tipo").val();
		
		var veh_marca = $("#veh_marca :selected").text();
		$("#label_veh_marca").text(veh_marca);
		
		var veh_modelo = $("#veh_modelo :selected").text();
		$("#label_veh_modelo").text(veh_modelo);
		
		var veh_ano = $("#veh_ano").val();
		$("#label_veh_ano").text(veh_ano);
		
		var veh_chassis = $("#veh_chassis").val();
		$("#label_veh_chassis").text(veh_chassis);

		var veh_matricula = $("#veh_matricula").val();
		$("#label_veh_matricula").text(veh_matricula);
		
	}
	
	 function ImprimirTicket(id){
		  CargarAjax2('Admin/Sist.Sucursal/Seguro/ticket.php?id='+id+'','','GET','formprinc');
	  }
	  
 function EnviarSeguro(){
			// validar FECHAS
			HayError = false;
			var fecha1 	= $('#fecha_inicio3').val();
			var fechaD	= ""+fecha1+"".split("/");
			var fechaF	= parseInt(fechaD[2]+""+fechaD[0]+""+fechaD[1]);
			var fechaH	= parseInt(<?=date("Ymd");?>);
			
			if(fechaF <= fechaH){
				$('#error_fecha_ini').fadeIn('9');
				HayError2 = true;
			}else { 
				$('#error_fecha_ini').fadeOut('3'); 
			}
	
			// si envia error
			if (HayError == true){
				//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
			} else {
				 if(confirm('Realmente deseas comprar este seguro?')){ 
				 	CargarAjax2_form('Admin/Sist.Sucursal/Seguro/seguroV2.php','form_edit_prof','formprinc'); 
				 	$(this).attr('disabled',true); 
				 } 
			}
	}
	
	
	
	// PARA VALIDAR K SOLO SEA NUMERO
	var nav4 = window.Event ? true : false;
	function acceptNum(evt){   
	var key = nav4 ? evt.which : evt.keyCode;   
	return (key <= 13 || (key>= 48 && key <= 57));
	}
	
	function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = [8,37,39,46];

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
	
	<!---------------para la cedula---------------->
	function DivGuionesCed(key){
		v = $('#asegurado_cedula').val();
		if(v.length == '3' && key !='9'){
		$('#asegurado_cedula').val(v+'-');
		}
		if(v.length == '11' && key !='9'){
		$('#asegurado_cedula').val(v+'-');
		}
	}
	
	$('#asegurado_cedula').keyup(function(event){
	key = event.which;
	DivGuionesCed(key);
	});
	<!---------------para la cedula---------------->
	
	<!---------------para asegurado_telefono1---------------->
	function DivGuionesTel1(key){
		  v = $('#asegurado_telefono1').val();
		  if(v.length == '3' && key !='8'){
		  $('#asegurado_telefono1').val(v+'-');
		  }
		  if(v.length == '7' && key !='8'){
		  $('#asegurado_telefono1').val(v+'-');
		  }
	  }
	
	  $('#asegurado_telefono1').keyup(function(event){
	  key = event.which;
	  DivGuionesTel1(key);
	  });
	<!---------------para asegurado_telefono1---------------->
	
	<!---------------para asegurado_telefono2---------------->
	function DivGuionesTel2(key){
		  v = $('#asegurado_telefono2').val();
		  if(v.length == '3' && key !='8'){
		  $('#asegurado_telefono2').val(v+'-');
		  }
		  if(v.length == '7' && key !='8'){
		  $('#asegurado_telefono2').val(v+'-');
		  }
	  }
	
	  $('#asegurado_telefono2').keyup(function(event){
	  key = event.which;
	  DivGuionesTel2(key);
	  });
	
	
	var f1 		= '<?=$fecha1?>';
	var aFecha1 = f1.split('/'); 
	var fFecha1 = aFecha1[0]; 

	//alert(f1);
$('#InpFech input').datepicker({
	
	//minDate: '-20D',
	language: "es",
	format: "dd/mm/yyyy", 
	daysOfWeekHighlighted: "0,1,2,3,4,5,6",
	orientation: "bottom left",
    autoclose: true,
    todayHighlight: true,
    toggleActive: true
}); 


var TaKmj = '<?=$fecha_vigente?>';
var TaKmjT = TaKmj.split('/'); 
var Tdia = TaKmjT[0]+'-'+TaKmjT[1]+'-'+TaKmjT[2];
$("#verfechaDV").html(Tdia);


$("#fecha_vigente3").change(
	function(){
		var Kmj = $('#fecha_vigente3').val();
		//alert(Kmj);	
		var aKmj = Kmj.split('/');
		
		
		/*if(aKmj[0]=='1'){
			var anombr = 'Enero';
		}else if(aKmj[0]=='2'){
			var anombr = 'Febrero';
		}else if(aKmj[0]=='3'){
			var anombr = 'Marzo';
		}else if(aKmj[0]=='4'){
			var anombr = 'Abril';
		}else if(aKmj[0]=='5'){
			var anombr = 'Mayo';
		}else if(aKmj[0]=='6'){
			var anombr = 'Junio';
		}else if(aKmj[0]=='7'){
			var anombr = 'Julio';
		}else if(aKmj[0]=='8'){
			var anombr = 'Agosto';
		}else if(aKmj[0]=='9'){
			var anombr = 'Septiembre';
		}else if(aKmj[0]=='10'){
			var anombr = 'Octubre';
		}else if(aKmj[0]=='11'){
			var anombr = 'Noviembre';
		}else if(aKmj[0]=='12'){
			var anombr = 'Diciembre';
		}*/
		
		
		//var dia = aKmj[1]+'-'+anombr+'-'+aKmj[2];
		
		var dia = aKmj[1]+'-'+aKmj[0]+'-'+aKmj[2];
		
		$("#verfechaDV").html(dia);
		
	}); 
  
//var aFecha1 = Kmj.split('/');
 
 
</script>

<form action="" method="post" enctype="multipart/form-data" id="form_edit_prof">
	<div id="formprinc">
 
	<!-- Modal heading -->
	<div class="modal-header" style="margin-top: -18px; margin-bottom: -5px; padding-bottom: 0px;">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Vender seguro de vehículo de motor </h3>
	</div>
	<!-- // Modal heading END -->
	
	<!-- Modal body -->
	<div class="modal-body">
	<!-- Form Wizard / Arrow navigation & Progress bar -->
	<div id="rootwizard" class="wizard">
		
		<div class="widget">
			
			<div class="widget-body">
				<div class="tab-content">
				
					<!-- Step 1 -->
<style>
	.Menu1C{
	  margin-top: -17px;
	  margin-bottom: 15px; 
	  background-color: #F0F0F0; 
	  padding-bottom: 31px; 
	  padding-top: 10px; 
	  margin-left: -3px; 
	  margin-right: 1px; 
	  border.radius: 5px 5px 5px 5px; 
	  -moz-border-radius:5px 5px 5px 5px;
	  -webkit-border-radius:5px 5px 5px 5px;
	  border-style: solid; border-width: 1px; border-color:#DFDFDF;	
	}
	.Menu2Actual1{
	  background-color: #23CDFD; 	
	  border-radius: 5px 1px 1px 5px;
	  padding-bottom: 12px;
	  padding-top: 11px;
	  margin-top: -11px;
	  padding-left: 42px;
	  color: #FFF;
	}
	.Menu2Actual2{
	  background-color: #23CDFD;
	  border-radius: 1px 1px 1px 1px;
	  padding-bottom: 12px;
	  padding-top: 11px;
	  margin-top: -11px;
	  padding-left: 42px;
	  color: #FFF;	
	}
	.Menu2Actual3{
	  background-color: #23CDFD;
	  border-radius: 1px 5px 5px 1px;
	  padding-bottom: 11px;
	  padding-top: 12px;
	  margin-top: -11px;
	  padding-left: 42px;
	  color: #FFF;	
	}
</style>    
                    
					<div class="tab-pane active" id="tab1">
                      
                      <div class="Menu1C" >
                        <div class="col-md-3 Menu2Actual1">Vehiculo</div>  
                        <div class="col-md-3">Propietario</div>
                        <div class="col-md-3">Vigencia</div>
                        <div class="col-md-3">Confirmar</div>
                        
                      </div>
                    
						<div class="row">
						
							                        		 <!-- Group -->
								<div class="col-md-4 control-group">
                                
									<label class="control-label">Tipo *</label>
								  <div class="controls">
                                        
                            
                     
                            <select name="veh_tipo" id="veh_tipo" style="display:compact" class="form-control">
                        <option value="">- Seleccionar - </option>
                        <? ///  SELECCION DEL TIPO .....................................
$rescat2 = mysql_query("SELECT id, nombre, veh_tipo from seguro_tarifas order by nombre ASC");
    while ($cat2 = mysql_fetch_array($rescat2)) {
			$c2 = $cat2['nombre'];
			$c_id2 = $cat2['veh_tipo'];
            
			
			echo "<option value=\"$c_id2\" >$c2</option>"; 
        } ?> 
                        </select>

								  </div>
                      
								<!-- // Group END -->
                                <p class="error help-block" id="errorveh_tipo" style="display:none"><span class="label label-important">Por favor seleccione tipo</span></p>
                              
                              
                              
                               <script>
								$("#veh_tipo").change(
									function(){
										id = $(this).val();
										CargarAjax2('Admin/Sist.Sucursal/Seguro/AJAX/Tipo.php?tipo_id='+id+'','','GET','veh_tipo_desc');
										
										
									}); 
									
$("#veh_tipo").change(
	function(){
		id = $(this).val();
		if(id=='1'){ // Autobus
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='2'){ //Automovil
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "block"); // asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='3'){ // Camion
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='4'){ // Camion Cabezote
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='5'){ // Camion Volteo
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "none"); //  asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='6'){ // Camioneta
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "block"); //  asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='7'){ // Four Wheel
			$("#tabla1").css("display", "none");  // casa del conductor
			$("#tabla2").css("display", "none"); //  asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "none");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='8'){ // Furgoneta
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "block"); // asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='9'){ // Grua
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='10'){ // jeep
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "block"); // asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='11'){ // jeepeta
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "block"); // asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='12'){ // maquinaria pesada
			$("#tabla1").css("display", "none");  // casa del conductor
			$("#tabla2").css("display", "block"); // asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "none");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='13'){  // miniban
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "block"); // asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='14'){ // motocicleta
			$("#tabla1").css("display", "none");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "none");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='15'){ // motoneta
			$("#tabla1").css("display", "none");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "none");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='16'){ //  station wagon
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "block"); // asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='17'){ // trailer 
			$("#tabla1").css("display", "none");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "none");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='18'){ // van
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "block"); // asistencia vial
			$("#tabla3").css("display", "block"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "block");
			$("#HR3").css("display", "block");
		}
		if(id=='19'){ // minubus
			$("#tabla1").css("display", "block");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "block");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
		if(id=='20'){ // remolque
			$("#tabla1").css("display", "none");  // casa del conductor
			$("#tabla2").css("display", "none"); // asistencia vial
			$("#tabla3").css("display", "none"); // aumento de fianza
			$("#HR1").css("display", "none");
			$("#HR2").css("display", "none");
			$("#HR3").css("display", "none");
		}
	}); 	
</script>
                                
                           
                                
                                
                                </div> 
                                
                                <!-- Group -->
								<div class="col-md-4 control-group">
									<label class="control-label">Marca *</label>
									<div class="controls">
										<select name="veh_marca" id="veh_marca" style="display:compact" class="form-control">
                        <option value="">- Seleccionar - </option>
                        <? ///  SELECCION DEL TIPO .....................................
$rescat = mysql_query("SELECT ID, DESCRIPCION from seguro_marcas order by DESCRIPCION ASC");
    while ($cat = mysql_fetch_array($rescat)) {
			$c = $cat['DESCRIPCION'];
			$c_id = $cat['ID'];
            if($v['veh_marca'] == $c_id){
			echo "<option value=\"$c_id\"  selected>$c</option>";
			}else{
			echo "<option value=\"$c_id\" >$c</option>"; }
        } ?> 
                        </select>
                        
                        
	<script>
    $("#veh_marca").change(
    
        function(){
            id = $(this).val();
            CargarAjax2('Admin/Sist.Sucursal/Seguro/Vehiculos/AJAX/Modelos.php?marca_id='+id+'','','GET','veh_modelo');
        }); 
              
    </script>
									</div>
                                     <p class="error help-block" id="errorveh_marca" style="display:none"><span class="label label-important">Por favor seleccione marca</span></p>
								</div>
								<!-- // Group END -->
                                <!-- Group -->
								<div class="col-md-4 control-group">
									<label class="control-label">Modelo</label>
									<div class="controls">
										
										<? if($v['veh_modelo']){
												echo"
												<script>
												CargarAjax2('Admin/Sist.Sucursal/Seguro/Vehiculos/AJAX/Modelos.php?marca_id=".$v['veh_marca']."&selec=".$v['veh_modelo']."','','GET','veh_modelo');
												
												</script>
												";
										}?>
                                        
                      <div id="veh_modelo" disabled="disabled" class="col-md-12" style="margin-left:-15px;"> 
                        <select name="veh_modelo" id="veh_modelo" style="display:compact" disabled="disabled" class="form-control">
                          <option selected="selected" value="0" tabindex="12">Seleccione la marca...</option>
                        </select>
            </div>
									<p class="error help-block" id="errorveh_modelo" style="display:none"><span class="label label-important">Por favor seleccione modelo</span></p>
                                    </div>
                                    
								</div>
								<!-- // Group END -->
                      </div>
                                <div class="row">
                                <!-- Group -->
								<div class="col-md-4 control-group">
									<label class="control-label">Año *</label>
									<div class="controls">
<select name="veh_year" id="veh_year" class="form-control">
      <option value="" >- Seleccionar -</option>
<? 
	$yaerAct  = date('Y');  //2016
	$year 	= '50';		 //100
	$Total 	= $yaerAct - $year; // 2016 - 100 = 1916
	for ( $i = $yaerAct ; $i >= $Total ; $i --) {
?>
    <option value="<?=$i?>" <? if($v['veh_year'] =='$i'){?> selected="selected"<? }?>><?=$i?></option>
<? } ?>
                          
</select>
									</div>
                                    <p class="error help-block" id="errorveh_ano" style="display:none"><span class="label label-important">Por favor seleccione año</span></p>
								</div>
								<!-- // Group END -->
							
								<!-- Group -->
								<div class="col-md-4 control-group">
									<label class="control-label">Chasis *</label>
									<div class="controls" id="chasis">
										<input name="veh_chassis" type="text"  class="form-control" id="veh_chassis" value="<? echo $v['veh_chassis']; ?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" maxlength="17"/>
                                        
									</div>
                                    <p class="error help-block" id="errorveh_chassis" style="display:none"><span class="label label-important">Digitar chasis</span></p>
								</div>
								<!-- // Group END -->
																<!-- Group -->
								<div class="col-md-4 control-group">
									<label class="control-label">Placa *</label>
									<div class="controls">
										<input type="text" name="veh_matricula" id="veh_matricula" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();" maxlength="10"/>
									</div>
                                    	<p class="error help-block" id="errorveh_matricula" style="display:none"><span class="label label-important">Digitar placa</span></p>
								</div>
								<!-- // Group END -->

						</div>
                        <div class="pagination margin-bottom-none">
					<ul>
						<input name="acep"  type="button" id="acep" value="Siguiente" class="btn btn-primary" onClick="IrPaso2();" tabindex="8"/>
					</ul>
				</div>
					</div>
                    
            
					<!-- // Step 1 END -->
					
					<!-- Step 2 -->
					<div class="tab-pane" id="tab2" style="display:none">
                      <div class="Menu1C" >
                        <div class="col-md-3">Vehiculo</div>
                        <div class="col-md-3 Menu2Actual2" >Propietario</div>
                        <div class="col-md-3">Vigencia</div>
                        <div class="col-md-3">Confirmar</div>
                      </div>
                      
						<div class="row">
                            <!-- Group -->
                            <div class="col-md-6 control-group">
                                <label class="control-label">Nombres *</label>
                            <div class="controls">
                                    <input type="text"  class="form-control" name="asegurado_nombres"  id="asegurado_nombres" value="<?=$row['asegurado_nombres']; ?>" onKeyPress="return soloLetras(event)"  autocomplete="off" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
                              </div><p class="error help-block" id="errornombres" style="display:none"><span class="label label-important">Digitar nombre</span></p>
                            </div>
                            <!-- // Group END -->
                            <!-- Group -->
                            <div class="col-md-6 control-group">
                                <label class="control-label">Apellidos *</label>
                                <div class="controls">
                                    <input type="text"  class="form-control" name="asegurado_apellidos" id="asegurado_apellidos"  value="<? echo $row['asegurado_apellidos']; ?>" onKeyPress="return soloLetras(event)"  autocomplete="off" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
                                </div>
                                <p class="error help-block" id="errorapellido" style="display:none"><span class="label label-important">Digitar apellido</span></p>
                            </div>
                            <!-- // Group END -->
						</div>
                        <div class="row">
                        <!-- Group -->
                      <div class="col-md-3 control-group">
                            <label class="control-label">Cédula *</label>
                            <div class="controls">
                                <input type="text"  class="form-control" name="asegurado_cedula" id="asegurado_cedula" value="<? echo $row['asegurado_cedula']; ?>" onKeyPress="return acceptNum(event)" maxlength="13"/>
                            </div>
                            <p class="error help-block" id="errorcedula" style="display:none"><span class="label label-important">Digitar cedula</span></p>
                        </div>
                        <!-- // Group END -->
                        <!-- Group -->
                        <div class="col-md-3 control-group">
                            <label class="control-label">Celular *</label>
                            <div class="controls">
                                <input type="text"  class="form-control" name="asegurado_telefono1" id="asegurado_telefono1" value="<? echo $row['asegurado_telefono1']; ?>" onKeyPress="return acceptNum(event)" maxlength="12"/>
                            </div>
                             <p class="error help-block" id="errortelefono" style="display:none"><span class="label label-important">Digitar telefono</span></p>
                        </div>
                        <!-- // Group END -->
                                                <!-- Group -->
                        <div class="col-md-6 control-group">
                            <label class="control-label">Email </label>
                            <div class="controls">
                                <input type="text"  class="form-control" name="asegurado_email" id="asegurado_email" value="<? echo $row['asegurado_email']; ?>"/>
                            </div>
                        </div>
                        <!-- // Group END -->

                    </div>
                    <div class="row">
                        <!-- Group -->
                        <div class="col-md-8 control-group">
                            <label class="control-label">Dirección *</label>
                            <div class="controls">
                                <input type="text"  class="form-control" name="asegurado_direccion"  id="asegurado_direccion" value="<? echo $row['asegurado_direccion']; ?>"/>
                            </div>
                            <p class="error help-block" id="errordireccion" style="display:none"><span class="label label-important">Digitar direccion</span></p>
                        </div>
                        <!-- // Group END -->
                        							                        		 <!-- Group -->
								<div class="col-md-4 control-group">
									<label class="control-label">Ciudad *</label>
									<div class="controls">
                                        
                           <select name="ciudad" id="ciudad" class="form-control" style="display:compact">
                                <option value="" >- Seleccionar -</option>
                                    <? ///  SELECCION DEL TIPO 
                                    $resprov3 = mysql_query("
										SELECT id, nombre from ciudad order by nombre ASC");
										while ($prov = mysql_fetch_array($resprov3)) {
										$c 		= $prov['nombre'];
										$c_id 	= $prov['id'];
										if($c_id == $row['ciudad']){
										echo "<option value=\"$c_id\" selected=\"selected\">$c
										</option>"; 
										}else{
										echo "<option value=\"$c_id\" >$c</option>"; }
                                } ?>
                           </select>

									</div>
								<!-- // Group END -->
                                <p class="error help-block" id="errorciudad" style="display:none"><span class="label label-important">Por favor seleccione ciudad</span></p>
                               
                                </div>
                                
                                <!-- Group -->

                    </div>	

<div class="pagination margin-bottom-none">
					<ul>
                    <input name="acep"  type="button" id="acep" value="Atras" class="btn btn-primary" onClick="IrPaso1();" tabindex="8"/>
						<input name="acep"  type="button" id="acep" value="Siguiente" class="btn btn-primary" onClick="IrPaso3();" tabindex="8"/>
						<!--<li class="primary previous"><a href="javascript:;" onclick="IrPaso1();">Atras</a></li>					  	
                        <li class="next primary"><a href="javascript:;" onclick="IrPaso3();">Siguiente</a></li>
				-->
					</ul>
				</div>
					</div>
					<!-- // Step 2 END -->
                    
                    <script> 
						$("#elegir1").click(function(){
							$(this).addClass("btn-success");
							$("#elegir2").addClass("btn-default").removeClass("btn-success");
							$("#elegir3").addClass("btn-default").removeClass("btn-success");
							$("#vigencia_poliza").val(3);
							$("#vigencia_poliza").html('3');
							
							$("#M11").css("display", "block");
							$("#M21").css("display", "none");
							$("#M31").css("display", "none");
							
							$("#M12").css("display", "block");
							$("#M22").css("display", "none");
							$("#M32").css("display", "none");
							
							$("#M13").css("display", "block");
							$("#M23").css("display", "none");
							$("#M33").css("display", "none");
						});
						
						$("#elegir2").click(function(){
							$(this).addClass("btn-success");
							$("#elegir1").addClass("btn-default").removeClass("btn-success");
							$("#elegir3").addClass("btn-default").removeClass("btn-success");
							$("#vigencia_poliza").val(6);
							$("#vigencia_poliza").html('6');
							
							$("#M11").css("display", "none");
							$("#M21").css("display", "block");
							$("#M31").css("display", "none");
							
							$("#M12").css("display", "none");
							$("#M22").css("display", "block");
							$("#M32").css("display", "none");
							
							$("#M13").css("display", "none");
							$("#M23").css("display", "block");
							$("#M33").css("display", "none");
						});
						
						$("#elegir3").click(function(){
							$(this).addClass("btn-success");
							$("#elegir1").addClass("btn-default").removeClass("btn-success");
							$("#elegir2").addClass("btn-default").removeClass("btn-success");
							$("#vigencia_poliza").val(12);
							$("#vigencia_poliza").html('12');
							
							$("#M11").css("display", "none");
							$("#M21").css("display", "none");
							$("#M31").css("display", "block");
							
							$("#M12").css("display", "none");
							$("#M22").css("display", "none");
							$("#M32").css("display", "block");
							
							$("#M13").css("display", "none");
							$("#M23").css("display", "none");
							$("#M33").css("display", "block");
						});
					
			 
	</script>
					
					
                   
                    <!-- Step 3 -->
					<div class="tab-pane" id="tab3" style="display:none">
                    <div class="Menu1C" >
                        <div class="col-md-3">Vehiculo</div>
                        <div class="col-md-3">Propietario</div>
                        <div class="col-md-3 Menu2Actual2">Vigencia</div>
                        <div class="col-md-3">Confirmar</div>
                      </div>
                    <div class="row" style="width: 100%;padding-left: 24px;">
                    	<!-- 3 Meses -->
                        <div class="col-md-4 widget widget-heading-simple widget-body-gray" margin-left: 5px;>
                            <div class="center widget-body" style="    border: solid 1px #ccc;
    background-color: #F5F5F5; color:#000000; width: 128px; height: 103px; padding-top: 0px;">
                            <h4>3 Meses</h4>
                            <h5 class="label label-important" id="label_vigencia3" style="color:#000000; font-size:14px;">RD$0</h5>   
                            <div class="separator bottom"></div>
                             <button type="button" class="btn-default btn-default"  id="elegir1">Elegir</button>
                                                                           
                        </div>
                      </div>
                        <!-- 3 Meses END-->
                        <!-- 6 Meses -->
                        <div class="col-md-4 widget widget-heading-simple widget-body-gray">
                            <div class="center widget-body" style="    border: solid 1px #ccc;
    background-color: #F5F5F5; color:#000000; width: 128px; height: 103px; padding-top: 0px;">
                            <h4>6 Meses</h4>
                            <h5 class="label label-important" id="label_vigencia6" style="color:#000000; font-size:14px;">RD$0</h5>   
                                <div class="separator bottom"></div>
                                <button type="button" class="btn-default btn-default"  id="elegir2">Elegir</button>

                            </div>
                        </div>
                        <!-- 6 Meses END--> 
                        <!-- 12 Meses -->
                        <div class="col-md-4 widget widget-heading-simple widget-body-gray">
                            <div class="center widget-body" style="    border: solid 1px #ccc;
    background-color: #F5F5F5; color:#000000; width: 128px; height: 103px; padding-top: 0px;">
                            <h4>12 Meses</h4>
                            <h5 class="label label-important" id="label_vigencia12" style="color:#000000; font-size:14px;">RD$0</h5>    
                                <div class="separator bottom"></div>
                                <button type="button" class="btn-default btn-success"  id="elegir3">Elegir</button>

                            </div>
                        </div>
                        <!-- 12 Meses END-->
                    
                    </div>
                        <!-- Row END-->
                        <!-- Row--> 
  <style>
  hr.style14 { 
  border: 0; 
  height: 1px; 
  background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); 
  margin-bottom: 8px;
  margin-top: 5px;
}
  </style>                      
              <div class="row" style="width: 100%;padding-left: 24px;">
                 <div class="col-md-12" style="margin-top: -21px;">
                 	<h3>Servicios Adicionales</h3>
                 </div>
              </div>

 <?  $query=mysql_query("
	SELECT * FROM servicios 
	WHERE activo ='si'
	ORDER BY id DESC ");
  $numDisp ='0';
  while($nominadep=mysql_fetch_array($query)){
	  $numDisp ++;
	  ?>                        
  

 <div class="row" id="tabla<?=$nominadep['id']?>"> 
   <div class="col-md-12">

<div class="row">
  <div class="col-md-9"><b><?=$numDisp." - ".$nominadep['nombre']?></b>  </div> 
  <div class="col-md-2" id="M1<?=$nominadep['id']?>" style="display:none"> <?=FormatDinero($nominadep['3meses'])?> </div>
  <div class="col-md-2" id="M2<?=$nominadep['id']?>" style="display:none"> <?=FormatDinero($nominadep['6meses'])?> </div>
  <div class="col-md-2" id="M3<?=$nominadep['id']?>"> <?=FormatDinero($nominadep['12meses'])?> </div>
  <div class="col-md-1"> <input name="servicios[]" type="checkbox" value="<?=$nominadep['id']?>" 
    style="width: 19px; height: 16px;"/></div>
    </div>
  </div>
</div>
<hr class="style14" id="HR<?=$nominadep['id']?>"> 
  <? } ?>

                        <div class="row" style="width: 100%; padding-left: 24px; margin-top: -33px;"> 
                        <!-- Inicio de vigencia -->
                        <div class="col-md-12 widget widget-heading-simple widget-body-gray">
                            <div class="center widget-body">
                            <h4 class="span5" style="margin-bottom: -2px;">Inicio de vigencia</h4>
                            <!-- Group -->
                            <div class="controls">
                                <!--<div class="input-append">-->
                     
                     <div id="InpFech"> <input type="text" class="form-control" value="<?=$fecha1?>" name="fecha_vigente3" id="fecha_vigente3"></div>
                      <span id="error_fecha_ini" class="span_error_fecha" style="width:100px; display:none;"><b>Fecha Invalida!</b></span> 
                            </div>                            
                            <!-- // Group END -->
                            </div>
                        </div>
                        <!-- Inicio de vigencia END-->    
                        </div>
                        <!-- Row END-->
                        
                        <div class="pagination margin-bottom-none" style="margin-top: -15px;">
					      <ul>
                          <input name="acep"  type="button" id="acep" value="Atras" class="btn btn-primary" onClick="IrPaso2();" tabindex="8"/>
                          <input name="acep"  type="button" id="acep" value="Siguiente" class="btn btn-primary" onClick="IrPaso4();" tabindex="8"/>
						    <!-- <li class="primary previous"><a href="javascript:;" onclick="IrPaso2();">Atras</a></li>					  	
                             <li class="next primary"><a href="javascript:;" onclick="IrPaso4();">Siguiente</a></li>-->
					     </ul>
				       </div>
                       
					</div>
					<!-- // Step 3 END -->
					
					<!-- Step 4 -->
					<div class="tab-pane" id="tab4" style="display:none">
                    <div class="Menu1C" >
                        <div class="col-md-3">Vehiculo</div>
                        <div class="col-md-3">Propietario</div>
                        <div class="col-md-3">Vigencia</div>
                        <div class="col-md-3 Menu2Actual3">Confirmar</div>
                     </div>
                    <img src="images/Logo-Dominicana-de-Seguros.jpg" width="360" height="102"> 
                    <h3>Esta a punto de vender un seguro de ley</h3>
                    <i> Por favor verifique los datos antes de proceder a realizar la venta</i>
                     <div class="separator bottom"></div>
                    <h5 class="heading strong text-uppercase">Vehiculo</h5>
                    <table class="table table-striped table-bordered table-condensed table-white dataTable" >			
                        <tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="gradeA odd">
                                    <td class=" sorting_1"><div id="label_veh_tipo"></div></td>
                                    <td class="sorting_1"><div id="label_veh_ano"></div></td>
                                </tr><tr class="sorting_1">
                                    <td class=" sorting_1"><span id="label_veh_marca"></span></td>
                                    <td class="sorting_1 ">Chasis: <span id="label_veh_chassis"></span></td>
                                </tr><tr class="sorting_1">
                                    <td class=" sorting_1"><div id="label_veh_modelo"></div></td>
                                    <td class="sorting_1 ">Placa: <span id="label_veh_matricula"></sapn></td>
                                </tr> 
                        </tbody> 
                    </table>                    
                    <h5 class="heading strong text-uppercase">Propietario</h5>
                    <table class="table table-striped table-bordered table-condensed table-white dataTable" >			
                        <tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="gradeA odd">
                                    <td class=" sorting_1">Nombres: <span id="label_nombres"> </span></td>
                                    <td class="sorting_1">Teléfono: <span id="label_telefono1"></span></td>
                                </tr><tr class="sorting_1">
                                    <td class=" sorting_1">Apellidos: <span id="label_apellidos"></span></td>
                                    <td class="sorting_1">Cédula: <span id="label_cedula"></span></td>
                                </tr>
                                <tr class="sorting_1">
                                    <td class="sorting_1" colspan="2">Dirección: <span id="label_direccion"></span></td>
                                </tr>
                        </tbody>
                    </table> 
                                       
                    <h5 class="heading strong text-uppercase">Vigencia</h5>
                     <table class="table table-striped table-bordered table-condensed table-white dataTable" >			
                        <tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="gradeA odd">
                                    <td class=" sorting_1"><span id="vigencia_poliza"></span> Meses</td>
                                    <td class="sorting_1">Vigente desde el <b><div id="verfechaDV"></div></b></td>
                                </tr>
                        </tbody>
                    </table>  

					 <h5 class="heading strong text-uppercase">Cobertura</h5>
                     <table class="table table-striped table-bordered table-condensed table-white dataTable" >			
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        	<tr class="gradeA odd">
                                    <td class=" sorting_1"><span id="label_vigencia_poliza"></span> Da&ntilde;o a la propoiedad ajena</td>
                                    <td class="sorting_1"><span id="DPA"> </span></td>
                                </tr>
                                <tr class="gradeA odd">
                                    <td class=" sorting_1"><span id="label_vigencia_poliza"></span> Responsabilidad civil<br />
Muerte accidental de 1 persona</td>
                                    <td class="sorting_1"><span id="RCA"> </span></td>
                                </tr>
                                <tr class="gradeA odd">
                                    <td class=" sorting_1"><span id="label_vigencia_poliza"></span> Responsabilidad civil<br />
Muerte accidental mas de 1 persona</td>
                                    <td class="sorting_1"><span id="RCA2"> </span></td>
                                </tr>
                                <tr class="gradeA odd">
                                    <td class=" sorting_1"><span id="label_vigencia_poliza"></span> Fianza judicial</td>
                                    <td class="sorting_1"><span id="FJ"> </span></td>
                                </tr>
                        </tbody>
                    </table>  


                    <div class="pagination margin-bottom-none">
                      <ul>
                      
                      <input name="acep"  type="button" id="acep" value="Inicio" class="btn btn-primary" onClick="IrPaso1();" tabindex="8"/>
                      
                      <input name="acep"  type="button" id="acep" value="Atras" class="btn btn-primary" onClick="IrPaso3();" tabindex="8"/>
                      
                      <input name="acep"  type="button" id="acep" value="Realizar Venta" class="btn btn-primary" onClick="EnviarSeguro();" tabindex="8"/>
                          <!--<li class="primary previous first"><a href="javascript:;" onclick="IrPaso1();">Inicio</a></li>
                          <li class="primary previous"><a href="javascript:;"  onclick="IrPaso3();">Atras</a></li>					  	
                          <li class="primary previous"><a href="javascript:;" onClick="EnviarSeguro();" >Realizar venta</a></li>-->
                      </ul>
                  </div>

                    </div>
                    
					
					
				</div>
				
				<!-- Wizard pagination controls -->
				
				<!-- // Wizard pagination controls END -->
      <input name="vigencia_poliza" id="vigencia_poliza" type="hidden" value="12" />
      <input name="id_cliente" type="hidden" id="id_cliente" value="<? echo $id_cliente ?>" />
      <input name="id_vehiculo" type="hidden" id="id_vehiculo" value="<? echo $id_vehiculo ?>" />
      <input name="producto" type="hidden" id="producto" value="2" /> 
      <input name="monto" type="text" id="monto" value="0" style="display:none" >
      <input name="veh_registro_update" type="hidden" id="veh_registro_update" value="<?=date ('Y-m-d G:i:s');?>" />
      <input name="cliente_registro_update" type="hidden" id="cliente_registro_update" value="<?=date('Y-m-d G:i:s');?>" />
                
				
			</div>
		</div>
	</div>
	<!-- // Form Wizard / Arrow navigation & Progress bar END -->
	</div>
	<!-- // Modal body END -->
	
	<!-- Modal footer -->
	<!--<div class="modal-footer">
	</div>-->
	<!-- // Modal footer END -->
    
     <!-- Bootstrap Form Wizard Plugin -->
     
 <div style="display:none" id="veh_tipo_desc"></div>
     </div>
     </form>
   	

	<!--<script src="js/bootstrap.min.js"></script>-->
	<script src="js/jquery.bootstrap.wizard.js"></script>
    <!--<script src="http://multiplesrecargas.com/recharge_Mod_New/common/bootstrap/extend/twitter-bootstrap-wizard/jquery.bootstrap.wizard.js"></script>-->
    <script src="js/form-wizards.init.js"></script>

