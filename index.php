<?php
include 'clases/conexion.php';
include 'clases/resultset.php';
include 'config/config.php';
Config::init();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>
    
    <meta name="description" content="Login Page">
    <meta name="author" content="">
    
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png" />
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/lib/font-awesome/css/font-awesome.css">
    
    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="assets/css/main.css">
    
    <!-- metisMenu stylesheet -->
    <link rel="stylesheet" href="assets/lib/metismenu/metisMenu.css">
    
    <!-- onoffcanvas stylesheet -->
    <link rel="stylesheet" href="assets/lib/onoffcanvas/onoffcanvas.css">
    
    <!-- animate.css stylesheet -->
    <link rel="stylesheet" href="assets/lib/animate.css/animate.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="login">

      <div class="form-signin">
    <div class="text-center">
         <img src="<?php echo Config::getImagenCompañia(); ?>" width="200" height="50" alt="">
    </div>
    <hr>
    <div class="tab-content">
        <div id="login" class="tab-pane active">
            <?php if(isset($_REQUEST["error"])){?>
            <div class="alert alert-info">
                <strong>El usuario y contraseña no coinciden</strong> .
              </div>
            <?php }?>
            <?php if(isset($_REQUEST["activo"])){?>
            <div class="alert alert-warning">
                <strong>Atencion</strong> El usuario no esta activo.
              </div>
            <?php }?>
            <form action="inicio.php" method="post">
                <p class="text-muted text-center">
                    Ingrese su Usuario y Contraseña
                </p>
                <input type="text" name="user" placeholder="Usuario" class="form-control top">
                <input type="password" name="password" placeholder="Contraseña" class="form-control bottom">
                <div class="checkbox" STYLE="display: none">
		  <label>
		    <input type="checkbox"> Remember Me
		  </label>
		</div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
            </form>
        </div>
    </div>
    <hr>
  </div>


    <!--jQuery -->
    <script src="assets/lib/jquery/jquery.js"></script>

    <!--Bootstrap -->
    <script src="assets/lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
    $(function({
        if(inIframe()){
            window.top.location=window.location;
        }
    }));
    function inIframe () {
        try {
            return window.self !== window.top;
        } catch (e) {
            return true;
        }
    }
    </script>
</body>

</html>
