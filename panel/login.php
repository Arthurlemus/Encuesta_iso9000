<?php 
session_start();
session_destroy();

header('Expires: Tue, 03 Jul 2001 06:00:00 GMT');
header('Last-Modified:' .gmdate('D, d M Y H:i:s').'GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
$archivoActual = basename($_SERVER['PHP_SELF']);
clearstatcache(); 

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel =Login=</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!-- [if lt IE 9]> -->
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <!-- <![endif] -->

  <!-- =============================== -->
  <!-- Librerias Propias -->
  <!-- =============================== -->

  <script src="js/adminpanel.js"></script>
  <script src="js/js.cookie.js"></script>
  <!-- =============================== -->
 <script>
   verificarcookie('<?php echo $archivoActual; ?>');
 </script>

</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><img src="dist/img/logo.png" alt="" width="25%"></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body" style="border-radius: 10px">
      <p class="login-box-msg">Iniciar Sesion</p>

      <!-- <form action="#" method="post"> -->
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Usuario" id="usuario">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Clave" id="clave">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
         <!--  <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div> -->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="iniciarsession();" id="btn_acceder">Acceder</button>
        </div>
        <!-- /.col -->
      </div>
      <!-- </form> -->
<!-- 
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <a href="#">I forgot my password</a><br> -->
      <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 2.2.0 -->
  <script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    });

    



  </script>
</body>
</html>
