<?php
function generarMenu(ResultSet $rs) {
        //Sacare los de nivel 1 en base a eso generare el menu.
        $padres=obtenerPrimerNivel($rs);
        $contPadres=count($padres);
        $menu="";
        for($i=0;$i<$contPadres;$i++) {
            $elemento=$padres[$i];
            $id=$elemento["IdMenu"];
            $hijos=obtenerHijos($rs, $id);

            $menu.="<li class=\"\"  >";

            $menu.='<a href="'.$elemento["URL"].'" >';
            $menu.="<i class=\"fa fa-".$elemento["NombreImagen"]."\"></i>&nbsp; ";
            $menu.='<span class="link-title">'.$elemento["Titulo"].'</span>';
            if(count($hijos)>0){
                $menu.='<span class="fa arrow"></span>';
            }
            $menu.='</a>';

            if(count($hijos)>0) {
                $menu.="<ul class='collapse' >
                    ";
                $menu.=imprimirHijos($hijos, 2,$rs);
                $menu.="
                    </ul>";
            }
            $menu.='</li>
                ';
    }
    return $menu;
}


function imprimirHijos($padres,$nivel,ResultSet $rs) {
    $contPadres=count($padres);
    $menu="";
    for($i=0;$i<$contPadres;$i++) {
        $elemento=$padres[$i];
        $id=$elemento["IdMenu"];
        $hijos=obtenerHijos($rs, $id);
        $menu.="<li class=\"\" >";
        $menu.='<a href="'.$elemento["URL"].'"  >';
        $menu.="<i class=\"fa fa-".$elemento["NombreImagen"]."\" ></i>&nbsp; ";
        $menu.=$elemento["Titulo"];
        if(count($hijos)>0){
            $menu.='<span class="fa arrow"></span>';
        }
        $menu.='</a>';

        if(count($hijos)>0) {
            //style=\"display: none;\"
            $menu.="<ul class='collapse'>
                ";
            //$menu.="<ul>";
            $menu.=imprimirHijos($hijos, $nivel+1,$rs);
            $menu.="</ul>
                ";
        }
        $menu.='</li>';
    }
    return $menu;
}


function obtenerPrimerNivel(ResultSet $rs) {
    $rs->beforeFirst();
    $padres=array();
    $contadorPadres=0;
    while($rs->next()) {
        if($rs->getInt("NivelMenu")==1) {
            $padre=array();
            $padre["IdMenu"]=$rs->getString("IdMenu");
            $padre["Titulo"]=$rs->getString("Titulo");
            $padre["URL"]=$rs->getString("URL");
            $padre["idMenuSuperior"]=$rs->getString("idMenuSuperior");
            $padre["NivelMenu"]=$rs->getString("NivelMenu");
            //$padre["Ayuda"]=$rs->getString("Ayuda");
            $padre["NombreImagen"]=$rs->getString("NombreImagen");
            $padres[$contadorPadres]=$padre;
            $contadorPadres++;
        }
    }
    return $padres;
}

function obtenerHijos(ResultSet $rs,$id) {
    $rs->beforeFirst();
    $hijos=array();
    $contadorHijos=0;
    while($rs->next()) {
        if($rs->getInt("idMenuSuperior")==$id) {
            if($rs->getInt("IdMenu")!=$id) {
                $hijo=array();
                $hijo["IdMenu"]=$rs->getString("IdMenu");
                $hijo["Titulo"]=$rs->getString("Titulo");
                $hijo["URL"]=$rs->getString("URL");
                $hijo["idMenuSuperior"]=$rs->getString("idMenuSuperior");
                //$hijo["sentenciaSQL"]=$rs->getString("sentenciaSQL");
                $hijo["NivelMenu"]=$rs->getString("NivelMenu");
                //$hijo["Ayuda"]=$rs->getString("Ayuda");
                $hijo["NombreImagen"]=$rs->getString("NombreImagen");
                $hijos[$contadorHijos]=$hijo;
                $contadorHijos++;
            }
        }
    }
    return $hijos;
}

function obtenerDescripcionMenu($menu){
        return $menu["Titulo"];;
}
?>