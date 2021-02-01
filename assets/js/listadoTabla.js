$(function(){
    
    var table = $('#ListadoDeTabla').DataTable();
 
    table.on( 'select', function ( e, dt, type, indexes ) {
            cambiarLlaves();
    } );
    
    table.on( 'deselect', function ( e, dt, type, indexes ) {
            cambiarLlaves();
    } );
    
    function cambiarLlaves(){
        var val='';
        $('#ListadoDeTabla').find('.selected').each(function(i,l){
            if(val!==''){val+=',';}    
            var aux =$(this).attr('id');
            val+=aux;
         });
        $("#ids").val(val); 
        //Ahora modifico los botones primero los deshabilito
        $("#Auditoria").prop("disabled",true);
        $("#Modificar").prop("disabled",true);
        $("#Eliminar").prop("disabled",true);
        if(table.rows( { selected: true } ).count()>0){
            $("#Eliminar").prop("disabled",false);
            if(table.rows( { selected: true } ).count()===1){
                $("#Auditoria").prop("disabled",false);
                $("#Modificar").prop("disabled",false);
            }
        }
    }
    
    //fa-square-o fa-check-square-o
    
    
    //Comienzo con el boton de eliminar
    $("#Eliminar").click(function(){
        var num=$("#ids").val().split(",").length;
        if(confirm("Esta seguro que desea eliminar los "+num+" registros seleccionados\nEsta operacion no se puede deshacer.")){
            $("#accionMantenimiento").prop("action","delete.php");
            $("#accionMantenimiento").submit();
        }
    });
    
    $("#Modificar").click(function(){
        $("#key").val($("#ids").val());
        $("#accionMantenimiento").prop("action","actualizacionDeTabla.php");
        $("#accionMantenimiento").submit();
    });
    
    
});


function seleccionarFilas(sender){
        var table = $('#ListadoDeTabla').DataTable();
        if(table.rows( { selected: true } ).count()===table.rows().count()){
            //Estan todas seleccionadas debo deseleccionar todas 
            table.rows( { selected: true } ).deselect();
            $(sender).find("i").removeClass("fa-check-square-o");
            $(sender).find("i").addClass("fa-square-o");
        }else{
            table.rows().select();
            $(sender).find("i").removeClass("fa-square-o");
            $(sender).find("i").addClass("fa-check-square-o");
        }
    };