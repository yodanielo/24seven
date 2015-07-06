<?php
$width=$r->wvideo;
$height=$r->hvideo;
$w=459;
$h=367;
$nw=$width;
$nh=$height;
if($width>$w) {
    $nw=459;
    $razon=$w/$width;
    $nh=$height*$razon;
}
?>
<script type="text/javascript">
    //function loadCSS(cssFile){
    var cssLink=document.createElement("link");
    cssLink.setAttribute("rel", "stylesheet");
    cssLink.setAttribute("type", "text/css");
    cssLink.setAttribute("href", "css/<?=$_REQUEST["cat"]?>.css");
    document.getElementsByTagName("head")[0].appendChild(cssLink);
    //}
</script>
<style type="text/javascript">
    .at300bs{
        visibility:hidden;
    }
    .jqmOverlay{
        background:#000;
    }
</style>
<div id="pubcerrar">
    <img alt="Cerrar" src="images/<?if(mosgetparam($_POST,"cat")!="") echo mosgetparam($_POST,"cat")."_";?>pubcerrar-24seven.gif" border="0" onclick="hidepub()" />
</div>
<div id="pubcol1">
    <div id="pubbarracompartir">
        <a class="sharelink" rel="cuadroshare" id="shareit">SHARE IT</a>
        <a class="sharelink" rel="cuadromail" id="sharemail">E-MAIL</a>
        <a class="sharelink" target="_blank" href="imprimir.php?tipo=plus&id=<?=$r->id ?>">PRINT IT</a>
        <a class="sharelink" target="_blank" href="<?= $r->mapa ?>">MAP</a>
    </div>
    <div class="compartir" id="cuadroshare">
        <?php
        $miurl=rawurlencode("http://www.mad24.es?cat=".$_REQUEST["cat"]."&type=plus&id=".$r->id);
        ?>
        <a onclick="cargafb(this)" href="#" rel="http://www.facebook.com/share.php?u=<?=$miurl?>"><img src="images/facebook-24seven.jpg" border="0"/>&nbsp;Facebook</a><br/>
        <a target="_blank" href="http://twitter.com/home?status=<?=$miurl?>"><img src="images/twitter-24seven.jpg" border="0"/>&nbsp;Twitter</a><br/>
        <a target="_blank" href="https://secure.delicious.com/login?v=5&partner=24seven&jump=<?=$miurl?>"><img src="images/delicious-24seven.jpg" border="0"/>&nbsp;Delicious</a><br/>
        <a target="_blank" href="https://secure.myspace.com/index.cfm?fuseaction=login.simpleform&featureName=postToV3&dest=<?=$miurl?>"><img src="images/myspace-24seven.jpg" border="0"/>&nbsp;My Space</a>
    </div>
    <div class="compartir" id="cuadromail">
        <form action="#" name="frmsharemail" id="frmsharemail">
            <div class="filamail">
                <span>From: (E-mail address)</span><br/>
                <input type="text" name="mtuemail" id="mtuemail" />
            </div>
            <div class="filamail">
                <span>To: (E-mail address)</span><br/>
                <input type="text" name="msuemail" id="msuemail" />
            </div>
            <div class="filamail">
                <input type="image" class="submitmail" src="images/botonsend-24seven.jpg" />
            </div>
        </form>
    </div>
    <div id="pubgaleriafotos">
        <?php
        $imgs=explode(",",$r->galeriaplus);
        if(count($imgs)>0) {
            $cimg=1;
            $csep=1;
            $cad1="";
            $cad2="";
            $mnitem=12;
            //$cimg=$mnitem;

            for($iimg=0;$iimg<count($imgs);$iimg++) {
                $img=$imgs[$iimg];

                $cad1.='<img src="images/galeriaplus/'.$img.'" class="pubgaleriaitem" id="pubgaleriaitem'.$iimg.'" border="0" />'."\n";
                $cad2.='<img src="images/galeriaplus/g_'.$img.'"/>';
                $cimg++;
            }
            echo $cad1;
            echo '<div style="display:none">'.$cad2.'</div>';
        }
        ?>
    </div>
    <?php if(count($imgs)>$mnitem) { ?>
    <div id="pubgaleriapag">
            <?php
            for($isep=1;$isep<=ceil(count($imgs)/$mnitem);$isep++)
                echo '<span>'.$isep.'</span>&nbsp;';
            ?>
    </div>
        <?php } ?>
    <div id="pubrateit">
        <span class="vovlervideo">&lt; Back to Video</span>
        Rate It!
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,29,0" id="myFlash" width="71" height="18">
            <param name="movie" value="flash/rating.swf?tipo=plus&id=<?=$r->id ?>"/>
            <param name="allowScriptAccess" value="undefined"/>
            <param name="quality" value="undefined"/>
            <param name="wmode" value="transparent"/>
            <embed src="flash/rating.swf?tipo=plus&id=<?=$r->id ?>" bgcolor="undefined" wmode="transparent" flashvars="undefined" menu="undefined" allowscriptaccess="undefined" quality="undefined" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" swliveconnect="true" name="undefined" width="71" height="18">
        </object>
    </div>
    <div id="pubcucomments">
        <div class="title">YOU'VE SAID...</div>
        <div id="pubcomments">
            <?php
            $mncom=4;
            if(count($res1)>0) {
                for($ires=0;$ires<count($res1);$ires++) {
                    $r1=$res1[$ires];
                    //foreach($res1 as $r1) {
                    ?>
            <div class="pubcommentitem" id="pubcommentitem<?=$ires?>">
                <img class="pubcomimage" src="images/comentarios/0_<?php echo $r1->imagen ?>" />
                <div class="pubcomtexto">
                    <span class="pubcomcolapsed">
                                <?php echo limitar_letras($r1->resumen,85); ?>
                    </span>
                    <span class="pubcomexpanded">
                                <?php echo $r1->resumen; ?>
                    </span>
                    <br/>
                            <?php 
                            echo "--".$r1->usuario.", ".$r1->ciudad.", ".$r1->pais.".";
                            if(strlen($r1->resumen)>85)
                                    echo '<br/><a href="#" class="pubbtnexpandir">Expand</a>';
                            ?>
                </div>
            </div>
                    <?php
                }
            }
            else {
                echo "There are no comments for this momment.";
            }
            ?>
        </div>
        <?php if(count($res1)>$mncom) { ?>
        <div id="pubcommentpag">
                <?php
                for($isep=1;$isep<=ceil(count($res1)/$mncom);$isep++)
                    echo '<span>'.$isep.'</span>&nbsp;';
                ?>
        </div>
            <?php } ?>

    </div>
</div>
<div id="pubcol2">
    <div id="pubvideoimagen">
        <div id="flashplus">
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,29,0" width="<?=$nw?>" height="<?=$nh?>">
                <param name="movie" value="flash/player2.swf?file=<?=rawurlencode("../images/videoplus/".$r->videofichaplus); ?>"/>
                <param name="quality" value="undefined"/>
                <param name="bgcolor" value="undefined"/>
                <param name="menu" value="undefined"/>
                <param name="wmode" value="transparent"/>
                <param name="scale" value="default"/>
                <embed src="flash/player2.swf?file=<?=rawurlencode("../images/videoplus/".$r->videofichaplus); ?>" bgcolor="undefined" wmode="transparent" flashvars="undefined" menu="undefined" allowscriptaccess="undefined" quality="undefined" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" swliveconnect="true" name="undefined" width="<?=$nw?>" height="<?=$nh?>"/>
            </object>
        </div>
        <img id="pubimgdelante" src="" border="0" style="display:none;" />
        <img id="pubimgatras"   src="" border="0" style="display:none"  />
    </div>
    <div id="publogo">
        <?php echo '<img src="images/logoplus/'.$r->logofichaplus.'" border="0" />' ?>
    </div>
    <div id="pubdescripcion">
        <?php echo $r->descripcion ?>
    </div>
    <div id="pubcucomentario">
        <div class="title">Tell us how you liked it!</div>
        <form id="frmcomentario" name="frmcomentario" onsubmit="return validacomentario()" method="post" enctype="multipart/form-data">
            <div id="pubfornombre">
                <label>Name*</label><br/>
                <input type="text" value="" name="pubnombre" /><br/>
            </div>
            <div id="pubforemail">
                <label>E-Mail*</label><br/>
                <input type="text" value="" name="pubemail" /><br/>
            </div>
            <div id="pubforcomment">
                <label>Comment:</label><br/>
                <textarea name="pubcomentario" id="pubcomentario"></textarea><br/>
            </div>
            <div id="pubforlocation">
                <label>Where are you from...?</label><br/>
                <input type="text" value="Your city..." name="pubciudad" />
                <select name="pubpais">
                    <option value="AF">Afganistán</option>
                    <option value="AL">Albania</option>
                    <option value="DE">Alemania</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguila</option>
                    <option value="AQ">Antártida</option>
                    <option value="AG">Antigua y Barbuda</option>
                    <option value="AN">Antillas holandesas</option><option value="SA">Arabia Saudí</option><option value="DZ">Argelia</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="PS">Autoridad Palestina</option><option value="AZ">Azerbaiyán</option><option value="BH">Bahrein</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BE">Bélgica</option><option value="BZ">Belice</option><option value="BJ">Benín</option><option value="BM">Bermudas</option><option value="BT">Bhután</option><option value="BY">Bielorrusia</option><option value="MM">Birmania</option><option value="BO">Bolivia</option><option value="BA">Bosnia y Herzegovina</option><option value="BW">Botsuana</option><option value="BR">Brasil</option><option value="BN">Brunéi</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="CV">Cabo Verde</option><option value="KH">Camboya</option><option value="CM">Camerún</option><option value="CA">Canadá</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CY">Chipre</option><option value="VA">Ciudad estado del Vaticano (Santa Sede)</option><option value="CO">Colombia</option><option value="KM">Comores</option><option value="CG">Congo</option><option value="CD">Congo (RDC)</option><option value="KR">Corea</option><option value="KP">Corea del Norte</option><option value="CI">Costa del Marfíl</option><option value="CR">Costa Rica</option><option value="HR">Croacia (Hrvatska)</option><option value="CU">Cuba</option><option value="DK">Dinamarca</option><option value="DJ">Djibouri</option><option value="DM">Dominica</option><option value="EC">Ecuador</option><option value="EG">Egipto</option><option value="SV">El Salvador</option><option value="AE">Emiratos Árabes Unidos</option><option value="ER">Eritrea</option><option value="SK">Eslovaquia</option><option value="SI">Eslovenia</option><option value="ES" selected="yes">España</option><option value="US">Estados Unidos</option><option value="EE">Estonia</option><option value="ET">Etiopía</option><option value="MK">Ex-República Yugoslava de Macedonia</option><option value="PH">Filipinas</option><option value="FI">Finlandia</option><option value="FR">Francia</option><option value="GA">Gabón</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GD">Granada</option><option value="GR">Grecia</option><option value="GL">Groenlandia</option><option value="GP">Guadalupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GY">Guayana</option><option value="GF">Guayana Francesa</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GQ">Guinea Ecuatorial</option><option value="GW">Guinea-Bissau</option><option value="HT">Haití</option><option value="HN">Honduras</option><option value="HK">Hong Kong, ZAE</option><option value="HU">Hungría</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IQ">Irak</option><option value="IR">Irán</option><option value="IE">Irlanda</option><option value="BV">Isla Bouvet</option><option value="CX">Isla Christmas</option><option value="IM">Isla de Man</option><option value="NF">Isla Norfolk</option><option value="IS">Islandia</option><option value="KY">Islas Caimán</option><option value="CC">Islas Cocos</option><option value="CK">Islas Cook</option><option value="FO">Islas Feroe</option><option value="FJ">Islas Fiji</option><option value="GS">Islas Georgias del Sur y Sandwich del Sur</option><option value="HM">Islas Heard y McDonald</option><option value="FK">Islas Malvinas (Falkland Islands)</option><option value="MP">Islas Marianas del Norte</option><option value="MH">Islas Marshall</option><option value="UM">Islas periféricas menores de los Estados Unidos</option><option value="PN">Islas Pitcairn</option><option value="SB">Islas Salomón</option><option value="SJ">Islas Svalbard y Jan Mayen</option><option value="TC">Islas Turks y Caicos</option><option value="VG">Islas Vírgenes Británicas</option><option value="VI">Islas Vírgenes, EE.UU.</option><option value="WF">Islas Wallis y Futuna</option><option value="IL">Israel</option><option value="IT">Italia</option><option value="JM">Jamaica</option><option value="JP">Japón</option><option value="JE">Jersey</option><option value="JO">Jordania</option><option value="KZ">Kazajstán</option><option value="KE">Kenia</option><option value="KG">Kirguizistán</option><option value="KI">Kiribati</option><option value="KW">Kuwait</option><option value="LA">Laos</option><option value="BS">Las Bahamas</option><option value="LS">Lesoto</option><option value="LV">Letonia</option><option value="LB">Líbano</option><option value="LR">Liberia</option><option value="LY">Libia</option><option value="LI">Liechtenstein</option><option value="LT">Lituania</option><option value="LU">Luxemburgo</option><option value="MO">Macao, ZAE</option><option value="MG">Madagascar</option><option value="MY">Malaisia</option><option value="MW">Malawi</option><option value="MV">Maldivas</option><option value="ML">Malí</option><option value="MT">Malta</option><option value="MA">Marruecos</option><option value="MQ">Martinica</option><option value="MU">Mauricio</option><option value="MR">Mauritania</option><option value="YT">Mayotte</option><option value="MX">México</option><option value="FM">Micronesia</option><option value="MD">Moldavia</option><option value="MC">Mónaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MZ">Mozambique</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NI">Nicaragua</option><option value="NE">Níger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NO">Noruega</option><option value="NC">Nueva Caledonia</option><option value="NZ">Nueva Zelanda</option><option value="OM">Omán</option><option value="NL">Países Bajos</option><option value="PK">Pakistán</option><option value="PW">Palaos</option><option value="PA">Panamá</option><option value="PG">Papúa-Nueva Guinea</option><option value="PY">Paraguay</option><option value="PE">Perú</option><option value="PF">Polinesia Francesa</option><option value="PL">Polonia</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="UK">Reino Unido</option><option value="CF">República Centroafricana</option><option value="CZ">República Checa</option><option value="ZA">República de Sudáfrica</option><option value="DO">República Dominicana</option><option value="RE">Reunión</option><option value="RW">Ruanda</option><option value="RO">Rumanía</option><option value="RU">Rusia</option><option value="KN">Saint Kitts y Nevis</option><option value="WS">Samoa</option><option value="AS">Samoa Americana</option><option value="SM">San Marino</option><option value="PM">San Pedro y Miquelón</option><option value="VC">San Vicente y las Granadinas</option><option value="SH">Santa Elena</option><option value="LC">Santa Lucía</option><option value="ST">Santo Tomé y Príncipe</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leona</option><option value="SG">Singapur</option><option value="SY">Siria</option><option value="SO">Somalia</option><option value="LK">Sri Lanka</option><option value="SZ">Suazilandia</option><option value="SD">Sudán</option><option value="SE">Suecia</option><option value="CH">Suiza</option><option value="SR">Surinam</option><option value="TH">Tailandia</option><option value="TW">Taiwán</option><option value="TZ">Tanzania</option><option value="TJ">Tayikistán</option><option value="IO">Territorio Británico del Océano Índico</option><option value="TF">Tierras Australes y Antárticas Francesas</option><option value="TP">Timor Oriental</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad y Tobago</option><option value="TN">Túnez</option><option value="TM">Turkmenistán</option><option value="TR">Turquía</option><option value="TV">Tuvalu</option><option value="UA">Ucrania</option><option value="UG">Uganda</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistán</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabue</option>
                </select>
                <div id="imgcombo"></div>
                <div id="attachpic"></div>
                <input type="file" size="1" name="pubfoto" id="pubfoto" value="" />
            </div>
            <div id="pubforsubmit">
                <input type="image" name="pubcomsubmit" src="images/<?if(mosgetparam($_POST,"cat")!="") echo mosgetparam($_POST,"cat")."_";?>botonsend-24seven.jpg" />
            </div>
            <input type="hidden" name="pubtipo" value="plus" />
            <input type="hidden" name="pubnum" value="<?= $r->id ?>" />

        </form>
    </div>
</div>
<script type="text/javascript">
    $("#pubvideoimagen").width(<?=$nw?>);
    $("#pubvideoimagen").height(<?=$nh?>);
    $("#attachpic").css("background","url(images/<?if(mosgetparam($_POST,"cat")!="") echo mosgetparam($_POST,"cat")."_";?>attachpic-24seven.jpg) no-repeat");
    $(".sharelink").hover(function(){
        $(".compartir").css("display","none");
        cuadro=$(this).attr("rel");
        $("#"+cuadro).css("display","inline");
        //        l=$(this).offset().left;
        //        t=$(this).offset().top;
        //        $("#"+cuadro).css({
        //            "left":l,
        //            "top":t
        //        });
    }, function(){});
    $(".compartir").hover(function(){}, function(){
        $(".compartir").css("display", "none");
    });
    $("#frmsharemail").submit(function(){
        frm=document.frmsharemail;
        if(frm.mtuemail.value.indexOf("@")==-1 || frm.mtuemail.value.indexOf(".")==-1){
            alert("Your e-mail is required.")
            frm.mtuemail.focus();
        }
        else{
            if(frm.msuemail.value.indexOf("@")==-1 || frm.msuemail.value.indexOf(".")==-1){
                alert("Her e-mail is required.");
                frm.msuemail.focus();
            }
            else{
                $.ajax({
                    type:"POST",
                    url:"includes/contenido.php",
                    data:"content=share_email&from="+frm.mtuemail.value+"&to="+frm.msuemail.value+"&url=<?=$miurl?>",
                    success:function(data){
                        alert("Shared!")
                        $("#cuadromail").css("display","none");
                        frm.mtuemail.value="";
                        frm.msuemail.value="";
                    }
                });
            }
        }
        return false;
    });
    function imprimir(){
        window.print();
    }
    $(".pubgaleriaitem").click(function(){
        src=$(this).attr("src");
        $("#flashplus ").css({"display":"none"});
        if($("#pubimgdelante").attr("src")==""){
            $("#pubimgatras").attr("src",src.split("images/galeriaplus/").join("images/galeriaplus/g_"));
        }
        $("#pubimgatras").attr("src",$("#pubimgdelante").attr("src"));
        $("#pubimgatras").css({
            "display":"block",
            "opacity":1
        }).animate({"opacity":0},400,"linear",function(){});
        $("#pubimgdelante").attr("src",src.split("images/galeriaplus/").join("images/galeriaplus/g_"));
        $("#pubimgdelante").css({
            "display":"block",
            "opacity":0
        }).animate({"opacity":1},400,"linear",function(){
            if($("#pubimgdelante").attr("width")<=50 || $("#pubimgdelante").attr("height")<=50){
                if($("#pubimgatras").attr("width")<=50 || $("#pubimgatra").attr("height")<=50){
                    $("#pubvideoimagen").css("width",<?=$w?>);
                    $("#pubvideoimagen").css("height",<?=$h?>);
                }else{
                    $("#pubvideoimagen").css("width",$("#pubimgatras").attr("width"));
                    $("#pubvideoimagen").css("height",$("#pubimgatras").attr("height"));
                }
            }
            else{
                $("#pubvideoimagen").css("width",$("#pubimgdelante").attr("width"));
                $("#pubvideoimagen").css("height",$("#pubimgdelante").attr("height"));
            }
        });
        $(".vovlervideo").css("display","inline");

    });
    $(".vovlervideo").click(function(){
        $(this).css("display","none");
        $("#flashplus").css("display","block");
        $("#pubimgdelante").css("display","none");
        $("#pubimgatras").css("display","none");
        $("#pubvideoimagen").css({"width":<?=$nw?>,"height":<?=$nh?>});
    });
    $("#pubgaleriapag span").click(function(){
        $(".pubgaleriaitem").css("display","none");
        pag=$(this).html();
        totresults=<?=$mnitem?>;
        i=(pag-1)*totresults;
        while(i<pag*totresults){
            $("#pubgaleriaitem"+i).css("display","inline");
            i++;
        }
        $("#pubgaleriapag span").css("color","#fff");
        $(this).css("color","#0173BC");
    })
    $("#pubcommentpag span").click(function(){
        $(".pubcommentitem").css("display","none");
        pag=$(this).html();
        totresults=<?=$mncom?>;
        i=(pag-1)*totresults;
        while(i<pag*totresults){
            $("#pubcommentitem"+i).css("display","inline");
            i++;
        }
        $("#pubcommentpag span").css("color","#fff");
        $(this).css("color","#0173BC");
    })
    $("#pubcommentpag span:first").click();
    $("#pubgaleriapag span:first").click();
    $(".pubbtnexpandir").click(function(){
        if($(this).html()=="Expand"){
            $(this).html("Colapse");
            $(this).parent().find(".pubcomcolapsed").hide();
            $(this).parent().find(".pubcomexpanded").show();
        }
        else{
            $(this).html("Expand");
            $(this).parent().find(".pubcomcolapsed").show();
            $(this).parent().find(".pubcomexpanded").hide();
        }
        return false;
    });
</script>
