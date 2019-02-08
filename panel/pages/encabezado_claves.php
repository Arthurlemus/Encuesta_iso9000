<?php  ?>
<!-- Content Header (Page header) -->
<section class="content-header row">
  <h1>
    Claves Activas
    <small>Control Panel </small>
  </h1>

  <div id="grafico-config">

   <div class="col-md-4" style="">
    <label for="fin">Encuesta:</label>
    <select name="cve_encuesta" id="cve_encuesta" class="form-control">
      <option value="-">-</option>
      <?php
        // ==================================
        // Muestra las Encuestas Activas
        // ==================================
        require_once("../script/conexion.php");
        $sqlenc = mysql_query("SELECT cve_encuesta,descripcion FROM encuesta WHERE activo=1",$conex);
       
        while($enc = mysql_fetch_assoc($sqlenc))
        {
          echo "<option value='".$enc['cve_encuesta']."'>".$enc['descripcion']."</option>";
        }
      ?>
    </select>
  </div>
  

  <div class="col-md-3" style="">
            <label for="suc">Sucursal</label>
            <select name="suc" id="suc" class="form-control">
              <option value="TODAS">Todas</option>
              
              <?php 
               // =========================================
               // Sucursales con Respuesta
               // =========================================
                $sqlsuc = mysql_query("SELECT sucursal FROM claves group by sucursal order by sucursal",$conex)or die(mysql_error());
                while ($s = mysql_fetch_assoc($sqlsuc))
                {
                  echo "<option value='".strtoupper(utf8_encode($s['sucursal']))."'>".ucwords(strtolower(utf8_encode($s['sucursal'])))."</option>";
                }
               // =========================================

              ?>

            </select>
          </div>



<div class="col-md-3" style="text-align: center;">
  <br/>
    <button class="btn btn-primary" onclick="lista_claves(false);" id="btn-generar"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Generar</button>
  </div>


  </div>

</section>

<!-- Main content -->
 <div class="row">
<section class="content" id="content">


</section>
</div>
<!-- <i class="fa fa-spinner fa-spin"></i>