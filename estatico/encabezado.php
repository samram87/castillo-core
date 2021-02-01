<?php
if (isset($_REQUEST["ajax"])) {
    if ($_REQUEST["ajax"] == 1) {
        $cargarParaAjax = true;
    }
}
include "core/clases/include.php";
//no esta tomando la etiqueta charset
header('Content-Type: text/html; charset=utf-8');

?>
<!doctype html>
<html>

    <head>
        <meta charset="UTF-8">
        <!--IE Compatibility modes-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--Mobile first-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo Config::getTituloPagina(); ?></title>

        <meta name="description" content="Aplicacion de Carlos Cienfuegos">
        <meta name="author" content="Carlos Cienfuegos">

        <meta name="msapplication-TileColor" content="#5bc0de" />
        <meta name="msapplication-TileImage" content="/core/assets/img/metis-tile.png" />

        <!-- Bootstrap -->
        <link rel="stylesheet" href="/core/assets/lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="/core/assets/lib/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="/core/assets/css/main.css">
        <link rel="stylesheet" href="/core/assets/lib/metismenu/metisMenu.css">
        <link rel="stylesheet" href="/core/assets/lib/onoffcanvas/onoffcanvas.css">
        <link rel="stylesheet" href="/core/assets/lib/animate.css/animate.css">
        

        <link rel="stylesheet" href="/core/assets/css/prism.min.css">
        
        
        <link rel="stylesheet" href="/core/assets/lib/inputlimiter/jquery.inputlimiter.css">
        <link rel="stylesheet" href="/core/assets/lib/bootstrap-daterangepicker/daterangepicker-bs3.css">
        <link rel="stylesheet" href="/core/assets/css/wygiwys.css">
        <link rel="stylesheet" href="/core/assets/css/extensions.css">
        
        <link rel="stylesheet" href="/core/assets/css/dataTablesExtensions.css">
        <link rel="stylesheet" href="/core/assets/css/bootstrap-select.min.css">
        
        <link rel="stylesheet" href="/core/assets/css/core.css">
        
         
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!--For Development Only. Not required -->
        <script>
            less = {
                env: "development",
                relativeUrls: false,
                rootpath: "//core/assets/"
            };
        </script>
        <link rel="stylesheet/less" type="text/css" href="/core/assets/less/theme.less">
        
        <script src="/core/assets/js/less.js"></script>
        <style>
            .profileSelect {
                display: block;
                width: 95%;
                height: 21px;
                font-size: 12px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 2px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                margin-right: 3px;
            }
            
        </style>
        <link  rel="new stylesheet" href="<?php echo Config::getRutaCss(); ?>"  type="text/css" title="compact">
        
    </head>

    <body class="menu-affix sidebar-left-mini">
        <div class="bg-dark dk" id="wrap">
            <div id="top">
                <!-- .navbar -->
                <nav class="navbar navbar-inverse navbar-fixed-top">
                    <div class="container-fluid">

                        <header class="navbar-header">

                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="#" class="navbar-brand"><img src="<?php echo Config::getImagenCompañia(); ?>" width="200" height="48" alt=""></a>

                        </header>



                        <div class="topnav">
                            <div class="btn-group">
                                <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip"
                                   class="btn btn-default btn-sm" id="toggleFullScreen">
                                    <i class="glyphicon glyphicon-fullscreen"></i>
                                </a>
                            </div>
                            <div class="btn-group">
                                <a data-placement="bottom" data-original-title="Alertas" href="#" data-toggle="tooltip"
                                   class="btn btn-default btn-sm">
                                    <i class="fa fa-comments"></i>
                                    <span class="label label-danger">4</span>
                                </a>
                                <a data-toggle="modal" data-original-title="Ayuda" data-placement="bottom"
                                   class="btn btn-default btn-sm"
                                   href="#helpModal" >
                                    <i class="fa fa-question"></i>
                                </a>
                            </div>
                            <div class="btn-group">
                                <a href="/core/utilidades/cerrarSesion.php" data-toggle="tooltip" data-original-title="Salir del Sistema" data-placement="bottom"
                                   class="btn btn-metis-1 btn-sm" onclick="return confirm('¿Esta seguro que desea salir del Sistema?')">
                                    <i class="fa fa-power-off"></i>
                                </a>
                            </div>
                            <div class="btn-group">
                                <a data-placement="bottom" data-original-title="Mostrar / Ocultar menu izquierdo" data-toggle="tooltip"
                                   class="btn btn-primary btn-sm toggle-left" id="menu-toggle">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </div>

                        </div>




                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <!-- .nav -->
                            <ul class="nav navbar-nav">
                                <li class='dropdown '>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        Administración <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/core/utilidades/cambiarPassword.php">Cambiar Contraseña</a></li>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- /.nav -->

                        </div>
                    </div>
                </nav>
                <!-- /.navbar -->
                <header class="head">
                    <div class="main-bar">
                        <h3>
                            <i class="fa fa-building"></i>&nbsp;
                            <?php echo Config::getNombreCliente(); ?>
                        </h3>
                    </div>
                    <!-- /.main-bar -->
                </header>
                <!-- /.head -->
            </div>
            <!-- /#top -->
            <div id="left">
                <div class="media user-media bg-dark dker">
                    <div class="user-media-toggleHover">
                        <span class="fa fa-user"></span>
                    </div>
                    <div class="user-wrapper bg-dark">
                        <a class="user-link" href="">
                            <img class="media-object img-thumbnail user-img" alt="User Picture" src="/core/assets/img/user.gif">
                            <!-- <span class="label label-danger user-label">16</span> -->
                        </a>

                        <div class="media-body">
                            <h5 class="media-heading" style="color:black;"><?php echo User::getNombreUsuario(); ?></h5>
                            <ul class="list-unstyled user-info">
                                <li id="selectorPerfil" style="display: none">
                                    <form method="post" action="/core/perfil.php">
                                    <select name="perfil" class="profileSelect" onchange="this.form.submit();">
                                        <option value="<?php echo User::getIdPerfil(); ?>"  selected="selected" >
                                            <?php echo User::getPerfil(); ?>
                                        </option>
                                        <?php 
                                            $q = "SELECT "
                                                    . " perfiles.nombrePerfil, "
                                                    . " perfiles.idPerfil"
                                                    . " from perfiles inner join"
                                                    . " usuariosporperfiles on"
                                                    . " usuariosporperfiles.idPerfil = perfiles.idPerfil"
                                                    . " where usuariosporperfiles.idUsuario={idUsuario} "
                                                    . " and perfiles.idPerfil<>{idPerfil}";
                                            $rs = new ResultSet($q);
                                            while($rs->next()){
                                                
                                        ?>
                                        <option value="<?php echo $rs->getString("idPerfil")?>" >
                                            <?php echo $rs->getString("nombrePerfil")?>
                                        </option>
                                        <?php } ?>
                                        
                                    </select>
                                    </form>
                                </li>
                                <li id="nombrePerfil"><a href="#" onclick="$('#nombrePerfil').hide();$('#selectorPerfil').show();"><?php echo User::getPerfil(); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #menu -->
                <ul id="menu" class="bg-dark dker">
                    <li class="nav-header">Menu</li>
                    <li class="nav-divider"></li>


                    <?php
                    $sqlQuery = "SELECT 
                            DISTINCT
                            m.idMenu AS IdMenu,
                            m.Titulo AS Titulo,
                            m.URL AS URL,
                            m.idMenuSuperior AS idMenuSuperior,
                            m.nivel AS NivelMenu,
                            m.nombreImagen AS NombreImagen 
                          FROM
                            menu m 
                            INNER JOIN menuporperfil mpp 
                              ON mpp.idMenu = m.idMenu 
                          WHERE mpp.idPerfil={idPerfil}  ORDER BY m.nivel, m.Titulo ";
                    $rs = new ResultSet($sqlQuery);

                    $menu = generarMenu($rs);
                    echo $menu;
                    ?>
                </ul>
                <!-- /#menu -->
            </div>
            <!-- /#left -->
            <div id="content">
                <div class="outer">
                    <div class="inner bg-light lter">
                        <!-- INICIO CONTENIDO -->