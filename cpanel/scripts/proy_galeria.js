function cargar_negocio(salto){
    sector=$("#sector").attr("value");
    defecto=document.formulario.negocio_ant.value;
    $.ajax({
        type:'POST',
        url:'../includes/contenido_ajax.php?negocio='+defecto,
        data:'content=carga_negocio&sector='+sector+'&todo=true',
        success:function(data){
            $("#negocio").html(data);
            cargar_delegacion();
        }
    });
}

function cargar_delegacion(){
    sector=$("#sector").attr("value");
    negocio=$("#negocio").attr("value");
    defecto=document.formulario.delegacion_ant.value;
    $.ajax({
        type:'POST',
        url:'../includes/contenido_ajax.php?delegacion='+defecto,
        data:'content=carga_delegacion&sector='+sector+'&negocio='+negocio+'&todo=true',
        success:function(data){
            $("#delegacion").html(data);
        }
    });
}
function cargar_busnegocio(salto){
    sector=$("#bus_sector").attr("value");
    defecto=$("#bus_negocio").attr("value");
    if(sector!=""){
        $.ajax({
            type:'POST',
            url:'../includes/contenido_ajax.php',
            data:'content=carga_negocio&sector='+sector+'&todo=true',
            success:function(data){
                $("#bus_negocio").html(data);
                cargar_busdelegacion();
            }
        });
    }
    else{
        $("#bus_negocio").html('<option value=""> - Seleccione - </option>');
        $("#bus_delegacion").html('<option value=""> - Seleccione - </option>');
    }
}

function cargar_busdelegacion(){
    sector=$("#bus_sector").attr("value");
    negocio=$("#bus_negocio").attr("value");
    defecto=$("#bus_delegacion").attr("value");
    if(negocio!=""){
        $.ajax({
            type:'POST',
            url:'../includes/contenido_ajax.php',
            data:'content=carga_delegacion&sector='+sector+'&negocio='+negocio+'&todo=true',
            success:function(data){
                $("#bus_delegacion").html(data);
            }
        });
    }
    else{
        $("bus_delegacion").html('<option value=""> - Seleccione - </option>');
    }
}