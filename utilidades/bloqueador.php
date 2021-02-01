<?php
$noMayusculas=true;
$trabajandoEnFrame=true;
 include 'core/clases/include.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
        if(!isset($_POST['password'])){
            echo '<meta http-equiv="refresh" content="300">';
        }
        ?>
        <?php include '../estatico/estilo.html';?>
        <?php include '../estatico/scripts.html' ?>
        <style>
            body{
                background-color: white;
                min-width: 150px !important;
            }
        </style>
    </head>
    <body>
        <?php
        if(!isset($_POST['password'])){

        Campos::inicioCentrado();
        if(!estaVacio(isset($_GET['error']))){
            Campos::mensajeError("La contraseña no es correcta.");
        }
        Campos::inicioFormulario("bloqueador.php","POST","","onsubmit='return validarFormulario(this);'");
        Campos::inicioTabla();
        Campos::inicioFila();
        Campos::columna("<center>Digite su contraseña para continuar.</center>","colspan=2");
        Campos::finFila();

        Campos::inicioFila();
        Campos::columna("Contraseña");
        Campos::inicioColumna();
        Campos::password("password");
        Campos::finColumna();
        Campos::finFila();

        Campos::inicioFila();
        Campos::inicioColumna("colspan=2 align=center aling=center ");
        Campos::submit("submit", "Desbloquear");
        Campos::finColumna();
        Campos::finFila();
        Campos::finTabla();
        Campos::finalCentrado();
        }else{
            $passAnt=$_POST['password'];
            $rs=new ResultSet("select count(*) as contador from usuario where idUsuario=$idUsuario and Password=MD5('$passAnt') ");
            $rs->next();
            $cont=$rs->getInt("contador");
            if($cont==0){
                ?>
                <script>
                window.location='bloqueador.php?error=1';
        </script>
        <?php
            }else{
        ?>
        <script>
            $(function(){
                parent.cerrar=true;
                parent.$("#sesionBloqueada").dialog("close");
                parent.cerrar=false;
            });
        </script>
        <?php
        }
        }
        ?>
    </body>
</html>