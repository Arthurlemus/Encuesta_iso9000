    
    <section class="content-header row">
      <h1>
        Graficos
        <small>Control panel</small>
      </h1>

      <div id="grafico-config">
  
            <div class="col-md-3" style="">
            <label for="inicio">De:</label>
            <input type="date" value="<?php echo date('Y-m-d'); ?>" min="2016-04-20" id="inicio" class="form-control"/>
            </div>

            <div class="col-md-3" style="">
            <label for="fin">Hasta:</label>
            <input type="date" value="<?php echo date('Y-m-d'); ?>" min="2016-04-20" id="fin" class="form-control"/>
          </div>

            
            <div class="col-md-3" style="">
            <label for="suc">Empresa</label>
            <select name="suc" id="suc" class="form-control">
              <option value="TODAS">Todas</option>
              
              <?php 
              
                require_once("../script/conexion.php");
               // =========================================
               // Sucursales con Respuesta
               // =========================================
                $sqlsuc = mysql_query("SELECT empresa FROM respuestas group by empresa order by empresa",$conex)or die(mysql_error());
                while ($s = mysql_fetch_assoc($sqlsuc))
                {
                  echo "<option value='".strtoupper($s['empresa'])."'>".ucwords(strtolower($s['empresa']))."</option>";
                }
               // =========================================

              ?>

            </select>
          </div>
          
          <div class="col-md-3" style="text-align: center;">
           <br/>
           
            <button class="btn btn-primary" onclick="page_graficos(false);" id="btn-generar"><span class="glyphicon glyphicon-tasks" aria-hidden="true"  style="margin: 0 auto"></span> Generar</button>
          </div>
   
      </div>

    </section>

    <!-- Main content -->
    <div class="row">
    <section class="content" id="content">
  


    </section>
    </div>
    <!-- /.content -->