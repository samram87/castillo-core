<?php
session_start();
$redirigirBusqueda=false;
if(!isset($_SESSION['idUsuario'])){
    //Se ha cerrado la sesion del usuario es necesario avisar
    //al usuario redirigiendo a otra pagina. Solamente si este
    //no esta en el index.
    $pos = strpos($_SERVER["REQUEST_URI"], "core/index.php");
    if($pos===false){
        $pos = strpos($_SERVER["REQUEST_URI"], "inicio.php");
        if($pos===false){
            if($_SERVER["REQUEST_URI"]!='/core/'){
                $pos = strpos($_SERVER["REQUEST_URI"], "/core/buscadores/");
                if($pos===false) {
                    if(isset($_REQUEST["ajax"])) {
                        if($_REQUEST["ajax"]==1) {
                            echo "<script>
                        window.location='/core/index.php?sesionCerrada';
                        </script>";
                        }
                    }
                    if(isset($trabajandoEnFrame)){
                        echo "<script>
                        parent.location='/core/index.php?sesionCerrada';
                        </script>";
                    }else{
                        header('Location: /core/index.php?sesionCerrada');
                    }
                    die();
                }else{
                    echo "<script>
                        parent.location=parent.location;
                        </script>";
                    die();
                }
            }
        }
    }
}else{
$idUsuario=$_SESSION['idUsuario'];
}
?>