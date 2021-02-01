<?php

/*Cambio el log de errores a error.log en la carpeta log*/
/*$ruta=__FILE__;
$ruta= str_replace("ini_set.php", "error.log", $ruta);
$ruta= str_replace("clases", "log", $ruta);*/
$ruta="/var/www/html/core/log/error.log";
ini_set("log_errors", 1);
ini_set ("error_log", $ruta);

error_log("Loading File: ".__FILE__);

ini_set('memory_limit','16M');
ini_set('max_execution_time', 300);

