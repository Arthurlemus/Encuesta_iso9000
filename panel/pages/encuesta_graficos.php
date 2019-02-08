<div class="alert alert-primary text-center" style="margin-bottom:0">
	Resumen de Encuestas
</div>

<!-- ========================================= -->
<!-- Parte Superior , Dos columnas de arriba -->
<!-- ========================================= -->
<div class="mdl-grid mdl-js-grid">
	<!-- ==================================== -->
	<!-- Columnas Superior IZquierda -->
	<!-- ==================================== -->
	<div class="mdl-cell mdl-cell--12-col" style="background: lightgray;border-radius:10px;margin:0;padding: 0;height: auto;">
		<span style="display: block;background: #133a7d;color: white;text-transform: uppercase;" class="text-center">Opciones de busqueda</span>
		<div class="mdl-grid mdl-js-grid">

			<div class="mdl-cell mdl-cell--5-col" >
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text" id="labelfecha">De:</span>
					</div>
					<input type="date" class="form-control" aria-describedby="labelfecha" id="inicio" value="<?php echo date("Y-m-d"); ?>" min="2018-02-01" >
				</div>
			</div>


			<div class="mdl-cell mdl-cell--5-col" >
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text" id="labelfecha2">Hasta:</span>
					</div>
					<input type="date" class="form-control" aria-describedby="labelfecha2" id="fin" value="<?php echo date("Y-m-d"); ?>" min="2018-02-01">
				</div>
			</div>


			<div class="mdl-cell mdl-cell--2-col mdl-cell mdl-cell--4-col-phone">
				<button id="btn_buscar" class="btn btn-success btn-block ripple-effect" onclick="bus_encuesta();">Buscar</button>
			</div>


		</div>
	</div>
</div>

<!--- PANEL DE RESULTADO DE LAS CONSULTAS -->
	
<div class="mdl-cell-mdl-cell--12-col" id="div_bus_entregas">
<!--  COTENIDO -->
</div>
