<?php
session_start();
$_SESSION['pin'] = 0000;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Encuesta LDN Satisfacción</title>
  <link rel="shortcut icon" type="imagen/x-icon" href="css/favicon.ico"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.css">

<!-- jQuery 2.2.0 -->
<script src="js/jquery-2.1.4.js"></script>
<!-- <script src="../../plugins/jQuery/jQuery-2.2.0.min.js"></script> -->
<!-- Bootstrap 3.3.6 -->
<script src="js/bootstrap.js"></script>
  <!-- ============================== -->
  <!-- Script Propios -->
  <!-- ============================== -->
  <script src="css/encuesta.css"></script>
  <script src="js/encuesta.js"></script>
  <!-- ============================== -->

<?php
//if(isset($_SESSION['pin']))
//{
  //echo "<script>
   // iniciar_session('".$_SESSION['pin']."');
  //</script>";
//}

?>
<script>
    brincarclave();
</script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->

<div class="lockscreen-wrapper" id="main-content" > <!-- Cuadro Principal -->

  <div class="lockscreen-logo">
    <a href="#"><b>Bienvenid@</b></a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">Grupo Aceros Ocotlan</div>

 
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="css/img/logo.png" alt="User Image">
    </div>

    <form class="lockscreen-credentials" id="formulario">
      <div class="input-group">
        <input type="password" class="form-control" placeholder="password" name="clave" id="clave" value="" />

        <div class="input-group-btn">
          <button type="button" class="btn" onclick="iniciar_session();"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>

  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Use su clave para acceder a la encuesta
  </div>
  <div class="text-center">
    <br/>
    <!-- <a href="login.html">Or sign in as a different user</a> -->
  </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2018-2020 <b><a href="http://acerosocotlan.mx" class="text-black">Aceros Ocotlan</a></b><br>
    All rights reserved
  </div>


</div>



<!-- /.center -->

</body>
</html>
