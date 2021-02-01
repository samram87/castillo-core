<?php include "core/estatico/encabezado.php";

$sqlQuery = "SELECT 
        DISTINCT
        m.idMenu AS IdMenu,
        m.Titulo AS Titulo,
        m.URL AS URL,
        m.idMenuSuperior AS idMenuSuperior,
        m.nivel AS NivelMenu,
        m.nombreImagen AS NombreImagen, 
        m.orden
        FROM
        menu m 
        INNER JOIN menuporperfil mpp 
            ON mpp.idMenu = m.idMenu 
        WHERE mpp.idPerfil={idPerfil}  ORDER BY m.nivel, m.orden, m.Titulo ";
$rs = new ResultSet($sqlQuery);
$menu = generarMenuDashboard($rs);

//C::importarCss("/core/inventario/inventario.css");
C::filaGrid();
c::columnaGrid(12);
C::boton("<- Regresar", "<- Regresar","onclick='cargarContenido(\"/core/inventario/dashboard.php\")'");
C::finColumnaGrid();
c::finFilaGrid();
c::filaGrid();
C::columnaGrid(6);
echo $menu;
C::finColumnaGrid();
c::columnaGrid(6);
echo "<hr/>";
C::finFilaGrid();







function generarMenuDashboard(ResultSet $rs) {
    //Sacare los de nivel 1 en base a eso generare el menu.
    $padres=obtenerPrimerNivel($rs);
    $contPadres=count($padres);
    $menu="";
    for($i=0;$i<$contPadres;$i++) {
        $elemento=$padres[$i];
        $id=$elemento["IdMenu"];
        $hijos=obtenerHijos($rs, $id);
        if(count($hijos)>0) {
            $menu.="<hr/><div>";
            $menu.="<h3><i class=\"fa fa-".$elemento["NombreImagen"]."\"></i>&nbsp;".$elemento["Titulo"]."</h3>";
            $menu.=imprimirHijosDashboard($hijos, 2,$rs);
            $menu.="</div>";
        }
    }
return $menu;
}
                
                
function imprimirHijosDashboard($padres,$nivel,ResultSet $rs) {
    $contPadres=count($padres);
    $menu="";
    for($i=0;$i<$contPadres;$i++) {
        $elemento=$padres[$i];
        $id=$elemento["IdMenu"];
        $menu.='<a class="quick-btn" href="'.$elemento["URL"].'">
        <i class="fa fa-'.$elemento["NombreImagen"].' fa-2x"></i>
        <span style="font-size:0.8em">'.$elemento["Titulo"].'</span>
        </a>';
    }
    return $menu;
}

include "core/estatico/pie.php";