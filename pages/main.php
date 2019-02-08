  <?php
   session_start(); 
   $_SESSION['siguiente']=0;
   $_SESSION['sucursal'] = 'LAMINAS DEL NORTE';

   ?>

<div class="row">
  <div class="col-xs-6">
    <!-- <label for="">Factura</label> -->
    <input type="hidden" id="factura" class="form-control" value="-" />
  </div>
  <div class="col-xs-6">
    <!-- <label for="">Sucursal</label> -->
    <?php
    echo "<input type='hidden' id='sucursal' class='form-control' value='".$_SESSION['sucursal']."' disabled='true'/>";
    ?>
  </div>
</div>

<div class="login-logo">
    <a href="#"><img src="css/img/logoLDN.png" alt=""></a>
</div>


  <div class="login-box-body" style="width: 100%;display: block;margin: 0 auto;" id="principal">
   <!-- <div class="alert alert-danger text-center"><strong>NOTA: Para Poder Avanzar a la siguiente pregunta es necesario contestar todas las opciones</strong></div> -->
   <div class="row">
     <div class="col-xs-12">
       <!-- <img src="css/img/welcome.png" alt="" style="display: block;margin:0 auto;width:70%;cursor: pointer" class="img-responsive" onclick="instrucciones();" id="img_main"> -->
      <span class="well" style="width:100%;display:block;font-size:16px">
           Para Laminas del Norte S.A. de C.V. es de gran importancia que nuestros clientes nos comuniquen cuan satisfechos se encuentran en aras de ofrecerles productos y servicios que excedan sus expectativas y lograr ser siempre su primera opción de compra.
      </span>
       <img src="css/img/btnencuesta.jpg" alt="" style="display: block;margin:0 auto;width:20%;cursor: pointer" class="img-responsive" onclick="instrucciones();" id="img_main">
       <span style='float:right;margin:0:padding:0'>FO-VE-03 Rev.0</span>
     </div>
   </div>  

  </div>
   <div class="lockscreen-footer text-center">
    Copyright &copy; 2018-2020 <b><a href="http://acerosocotlan.mx" class="text-black">Grupo Aceros Ocotlán</a></b><br>
    All rights reserved
  </div>

<style>
  #img_main:hover
  {
    /*transform: scale(1.1);*/
    background: white;
    /*background: lightgray;*/
    border-radius:200px;
  }
</style>