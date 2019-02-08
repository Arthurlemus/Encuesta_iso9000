<div class='row'>
	<div class='col-xs-12'>
		<h4 class='well'><center><b style="text-align: center;">DATOS GENERALES</b></center></h4>
	</div>

  <?php
   session_start(); 
   $_SESSION['siguiente']=0;
   $_SESSION['conencuesta']=0;

   require("../script/conexion.php"); 

   $enc = mysql_query("SELECT cve_encuesta FROM encuesta where activo=1");
   $encname = mysql_fetch_assoc($enc);

   if($encname!=""){
	   $_SESSION['cve_encuesta'] = $encname['cve_encuesta'];
   }else{
	   $_SESSION['cve_encuesta'] = "SinEncuesta";
   }


   ?>

	<div class='col-xs-12'>

		<div class='col-md-12' style='padding:0;border-radius:0 0 7px 7px;'>

			<span for='respuesta' style='background:#0F3A7A;color:white;display:block;width:100%;text-align:center;font-size:20px'><b>Tu información es confidencial y anonima</b>
			</span>
				<div class="row">
					<div class="col-xs-4">
						<label for="company">Empresa / Cliente:</label>
  						<input type="text" class="form-control"  id="company"  placeholder='Campo obligatorio'>
					</div>

					<div class="col-xs-4">
						<label for="who">Nombre de contacto:</label>
  						<input type="text" class="form-control" id="who"  placeholder='Campo obligatorio'>
					</div>

					<div class="col-xs-4">
						<label for="email">Correo:</label>
  					   <input type="email" class="form-control" id="email"  placeholder='Campo obligatorio'>
					</div>

				</div>

				<div class="row" style="margin-top:2%">
					<div class="col-xs-4">
						<label for="telephone">Telefono:</label>
  						<input type="tel" class="form-control"  id="telephone">
					</div>

				</div>
		
		</div>

	</div>

	<!-- // ============================ -->
	<!-- // Mini Loading por pregunta -->
	<!-- // ============================ -->
	<div class='overlay' style='text-align:center;position:absolute;left:47%;top:45%;' id='mini_loading'>
		<i class='fa fa-refresh fa-spin' style='font-size: 50px;'></i>
	</div>
	<!-- // ============================ -->


	<!-- // ============================ -->
	<!-- // Boton de Siguiente -->
	<!-- // ============================ -->
	<div class='col-xs-12' style='margin-top:4%;text-align:center' id='btn_siguiente' >
		<button class='btn btn-success btn-lg' onclick='iniciar_encuesta();'>Siguiente</button>
		<span style='float:right;margin:0:padding:0'>FO-VE-03 Rev.0</span>
	</div>
	<!-- // ============================ -->
</div>


