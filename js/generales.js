function apareceseguir(){
    
}
function apareceseguir(){
    
}
function cargarcates(){
    $(".comentario").click(function(){
        displaypub($(this).attr("tabpub"),$(this).attr("idpub"),$(this).attr("catpub"));
    }).css("cursor", "pointer");
}
function cargafb(a){
    window.open(a.getAttribute("rel"),'mywindow','width=600,height=300,toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,copyhistory=yes,resizable=yes');
    return false;
}
function displaypub(tipo,id,cat){
    $.ajax({
        type:"POST",
        url:"includes/contenido.php",
        data:"content=displaypub&tipo="+tipo+"&id="+id+"&cat="+cat,
        success:function(data){
            $('#dlgpub').html(data);
            $('#dlgpub').jqm();
            $('#dlgpub').jqmShow();
            $(".jqmOverlay").height($(document).height());
            $(".jqmOverlay").width("100%");
            $(".jqmOverlay").css("padding-bottom",72);
            $(".jqmOverlay").css("display","inline");
            if($.browser.msie ){
                $(".jqmOverlay").width($(document).width()-22);
                if($.browser.version=="6.0"){
                    $(".jqmOverlay").css("padding-bottom",36);
                    $(".jqmOverlay").height("100%");
                }
            }
        } 
    });
}
function cargarbanner(){
    $("#dlgbanner").jqm();
    $("#dlgbanner").jqmShow();
    $(".jqmOverlay").height($(document).height());
    $(".jqmOverlay").width("100%");
    if($.browser.msie){
        $(".jqmOverlay").width($(document).width()-22);
    }
}
function cerrarbanner(u){
    $("#dlgbanner").jqmHide();
    displaypub("plus",u,"");
}
function hidepub(){
    $('#dlgpub').jqmHide(); 
}
function set_rate(tipo, id, rating){
    $.ajax({
        type:"POST",
        url:"includes/contenido.php",
        data:"content=set_rate&tipo="+tipo+"&id="+id+"&rating="+rating,
        success:function(data){
        //alert(data);
        }
    });
}
function validacomentario(){
    f=document.frmcomentario;
    if(f.pubnombre.value==""){
        alert("Your Name is required.");
        f.pubnombre.focus();
        return false;
    }
    else{
        if(f.pubemail.value=="" || f.pubemail.value.indexOf("@")==-1 || f.pubemail.value.indexOf(".")==-1){
            alert("Your E-mail is required or is not valid.");
            f.pubemail.focus();
            return false;
        }
        else{
            if(f.pubcomentario.value==""){
                alert("Your comment is required.");
                f.pubcomentario.focus();
                return false;
            }
            else{
                if(f.pubpais.value==""){
                    alert("Your country is required.");
                    f.pubpais.focus();
                    return false;
                }
                else{
                    if(f.pubciudad.value=="" || f.pubciudad.value=='Your city...'){
                        alert("Your city is required.")
                        f.pubciudad.focus();
                        return false;
                    }
                    else{
                        if(f.pubfoto.value!="" && f.pubfoto.value.indexOf(".jpg")==-1){
                            alert("Your foto is required or is no valid.")
                            f.pubfoto.focus();
                            return false;
                        }
                        alert("Thanks for participating.");
                        return true;
                    }
                }
            }
        }
    }
}