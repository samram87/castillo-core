<?php
$noMayusculas=true;
include 'core/clases/include.php';
$idUsuario=$_SESSION['idUsuario'];
if((!estaVacio($_POST['passAnterior']))&&(!estaVacio($_POST['passNuevo']))){
    $passAnt=$_POST['passAnterior'];
    $passNue=$_POST['passNuevo'];

    $rs=new ResultSet("select count(*) as contador from usuario where idUsuario=$idUsuario and Password=MD5('$passAnt') ");
    //echo "select count(*) from usuario where idUsuario=$idUsuario and Password=MD5('$passAnt')";
    $rs->next();
    $cont=$rs->getInt("contador");
    if($cont==0){
        header('Location: /core/utilidades/cambiarPassword.php?error=1');
        die;
    }
    if($conexion->ejecutar("update usuario set password=MD5('$passNue') where idUsuario=$idUsuario")){
        header('Location: /core/utilidades/cambiarPassword.php?mensaje=Su contraseña ha sido actualizada correctamente');
        die;
    }
}else{
    header('Location: /core/utilidades/cambiarPassword.php?mensaje=Digite la contraseña actual');
    die;
}


?>