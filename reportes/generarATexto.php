<?php
    include_once 'core/clases/include.php';
    include_once 'core/lib/writeExcel/Worksheet.php';
    include_once 'core/lib/writeExcel/Workbook.php';

    //Estableciendo los Headers
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=reporte.xls" );
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");
    $idReporte=$_REQUEST["idReporte"];
    $rsQuery=new ResultSet("select reportes.sqlReporteSencillo from reportes where idReporte='$idReporte'");
    $rsQuery->next();

    $query=$rsQuery->getString(0);
    

    $conexionReporte=$conexion;
    $rsCon=new ResultSet("SELECT reportes.idReporte ,
                conexiones.servidor ,
                conexiones.usuario ,
                conexiones.password,
                reportes.sqlReporteSencillo
                FROM reportes
                INNER JOIN conexiones
            ON (reportes.idConexion = conexiones.idConexion)
            WHERE (reportes.idReporte ='$idReporte') ");
    if($rsCon->next()){
        $servidor=$rsCon->getString("servidor");
        $usuario=$rsCon->getString("usuario");
        $pass=$rsCon->getString("password");
        $conexionReporte=new Conexion(true);
        $conexionReporte->setPassword($pass);
        $conexionReporte->setServer($servidor);
        $conexionReporte->setUsername($usuario);
        $conexionReporte->setBaseDeDatosPorDefecto("");
        $conexionReporte->reconectar();
    }


    $arr=array_keys($_REQUEST);
    for($i=0;$i<count($arr);$i++){
            $key=$arr[$i];
            $query=str_replace("{".$key."}", $_REQUEST[$key], $query);
            $query=str_replace("{".strtolower($key)."}", $_REQUEST[$key], $query);
            $query=str_replace("{".strtoupper($key)."}", $_REQUEST[$key], $query);
    }
//    echo $query;
//    die();
    $rs=new ResultSet($query,$conexionReporte);
    //echo print_r($rs);
    //die();
    $libro = new Workbook("-");

    $fTitulo =& $libro->add_format();
    $fTitulo->set_size(10);
    $fTitulo->set_align('center');
    $fTitulo->set_pattern();
    $fTitulo->set_bold();
    $fTitulo->set_border(2);
    $fTitulo->fg_color=44.1;

    $fFila =& $libro->add_format();
    $fFila->set_size(10);
    $fFila->set_border(1);
    $hoja =& $libro->add_worksheet("Resultado");
    $rsMd=$rs->getMetadata();
    $i=0;

    foreach($rsMd as $val) {
        $hoja->set_column(0, $i, 27);
        //$tituloCampo=$detalle->getNombreCampo();
        $tituloCampo=utf8_decode($val->name);
        $hoja->write_string(0,$i,$tituloCampo,$fTitulo);
        $i++;
    }
    
    //$hoja->write_string(0,$i,$query);
   $col=$rs->getCantidadDeColumnas();
   $contador=1;
    while($rs->next()){
        for($i=0;$i<$col;$i++){
            $hoja->write_string($contador,$i,utf8_decode($rs->getString($i)),$fFila);
        }
        $contador++;
    }
    $libro->close();
?>
