<?php
$_REQUEST["idMenuSeleccionado"]=0;
include 'core/estatico/encabezado.php';

Campos::inicioFormulario("cambioDePassword.php",'POST','','onsubmit="return validarFormulario();"');
Campos::inicioCentrado();
if(!estaVacio(isset($_GET['error']))){
    Campos::mensajeError("La contraseña actual no es correcta.");
}
if(!estaVacio(isset($_GET['mensaje']))){
    Campos::mensaje($_GET['mensaje']);
}

C::filaGrid();

c::columnaGrid(12);
c::subTitulo("Cambio de Contraseña");
c::finColumnaGrid();
c::finFilaGrid();


c::filaGrid();
c::columnaGrid();
c::finColumnaGrid();
Campos::columnaGridOffset(3,3);
echo "<strong>Contraseña Actual</strong>";
Campos::finColumnaGrid();

Campos::columnaGrid(3);
Campos::password("passAnterior",'',15);
Campos::finColumnaGrid();
C::finFilaGrid();C::saltoDeLinea(1);


c::filaGrid();
c::columnaGrid();
c::finColumnaGrid();
Campos::columnaGridOffset(3,3);
echo "<strong>Nueva Contraseña</strong>";
Campos::finColumnaGrid();

Campos::columnaGrid(3);
Campos::password("passNuevo",'',15);
Campos::finColumnaGrid();
C::finFilaGrid();C::saltoDeLinea(1);


c::filaGrid();
c::columnaGrid();
c::finColumnaGrid();
Campos::columnaGridOffset(3,3);
echo "<strong>Repita Contraseña</strong>";
Campos::finColumnaGrid();

Campos::columnaGrid(3);
Campos::password("passNuevoRepetido",'',15);
Campos::finColumnaGrid();
C::finFilaGrid();C::saltoDeLinea(1);



c::filaGrid();

Campos::columnaGridOffset(12);
echo '<center>';
Campos::submit("Cambiar", "Cambiar Contraseña");
echo '</*center>';
Campos::finColumnaGrid();
C::finFilaGrid();C::saltoDeLinea(2);

Campos::finFomulario();



Campos::focoPrimerElemento();
?>
<script>
function validarFormulario(){
    if($("#passAnterior").val()==''){
        alertaFoco('Debe digitar la contraseña actual',$("#passAnterior"));
        return false;
    }
    if($("#passNuevo").val()==''){
        alertaFoco('Debe digitar la contraseña nueva',$("#passNuevo"));
        return false;
    }
    if($("#passNuevoRepetido").val()!=$("#passNuevo").val()){
        alertaFoco('Las contraseñas no coinciden.',$("#passNuevoRepetido"));
        return false;
    } v
    return true;
}
$(function(){quitarSeleccionMenu();});
</script>
<?php
include 'core/estatico/pie.php';
?>