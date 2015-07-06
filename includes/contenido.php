<?php
ini_set('session.use_trans_sid', 0);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.gc_maxlifetime', 172800);
session_cache_limiter('private,must-revalidate');
session_start();
header("Cache-control: private");
if($_GET["lang"]) {
    if($_GET["lang"]=="en")
        $_SESSION["lang"]="en";
    else
        $_SESSION["lang"]="es";
}
else
if(!$_SESSION["lang"]) {
    $_SESSION["lang"]="es";//strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
}

$lg=$_SESSION["lang"];
if(mosgetparam($_POST,"content","")=="")
    $path="./";
else
    $path="../";
include ($path.'config.php');
$protects = array('_REQUEST', '_GET', '_POST', '_COOKIE', '_FILES', '_SERVER', '_ENV', 'GLOBALS', '_SESSION');
foreach ($protects as $protect) {
    if ( in_array($protect , array_keys($_REQUEST)) ||
            in_array($protect , array_keys($_GET)) ||
            in_array($protect , array_keys($_POST)) ||
            in_array($protect , array_keys($_COOKIE)) ||
            in_array($protect , array_keys($_FILES))) {
        die("Invalid Request.");
    }
}

/**
 * used to leave the input element without trim it
 */
define( "_MOS_NOTRIM", 0x0001 );
/**
 * used to leave the input element with all HTML tags
 */
define( "_MOS_ALLOWHTML", 0x0002 );
/**
 * used to leave the input element without convert it to numeric
 */
define( "_MOS_ALLOWRAW", 0x0004 );
/**
 * used to leave the input element without slashes
 */
define( "_MOS_NOMAGIC", 0x0008 );

function mosgetparam( &$arr, $name, $def=null, $mask=0 ) {
    if (isset( $arr[$name] )) {
        if (is_array($arr[$name])) foreach ($arr[$name] as $key=>$element) $result[$key] = mosGetParam ($arr[$name], $key, $def, $mask);
        else {
            $result = $arr[$name];
            if (!($mask&_MOS_NOTRIM)) $result = trim($result);
            if (!is_numeric( $result)) {
                if (!($mask&_MOS_ALLOWHTML)) $result = strip_tags($result);
                if (!($mask&_MOS_ALLOWRAW)) {
                    if (is_numeric($def)) $result = intval($result);
                }
            }
            if (!get_magic_quotes_gpc()) {
                $result = addslashes( $result );
            }
        }
        return $result;
    } else {
        return $def;
    }
}
require_once ($path.'includes/database.php');
require_once ($path.'includes/helpers.php');

$db=new database($config_host,$config_user,$config_password,$config_db,$config_dbprefix);
?>

<?php
/**
 * indica el formulario que se cargará
 */
$inicio="";
/**
 * @todo el que inicializa el ajax
 */
if($_POST["content"]) {
    $funcionesprimarias=array("displaypub","set_rate","share_email","carga_ampliar");
    if(in_array(mosgetparam($_POST,"content","noexiste"),$funcionesprimarias)) {
        $funcion=mosgetparam($_POST,"content","noexiste");
        if(function_exists($funcion)) {
            echo $funcion();
        }
    }
}
?>
<?php
/**
 * @TODO funciones de contenido
 */
$cat=mosgetparam($_GET,"cat","General");
function validacomentario() {
    global $db;
    if($_POST["pubtipo"]) {
        $tipo=mosgetparam($_POST,"pubtipo","plus");
        //guardando la foto
        include("cpanel/fimagenes.php");
        $narchivo= mktime().str_replace(" ","",basename($_FILES['pubfoto']['name']));
        $ruta1 = "images/comentarios/0_".$narchivo;
        $ruta2 = "images/comentarios/1_".$narchivo;
        if (is_uploaded_file($_FILES['pubfoto']['tmp_name'])) {
            move_uploaded_file($_FILES['pubfoto']['tmp_name'], $ruta1);
            clipImage($ruta1, $ruta1, 75, 71);
            clipImage($ruta1, $ruta2, 65, 65);
        }
        else {
            $narchivo="predeterminado.jpg";
        }
        if(in_array($tipo,array("plus","clasic","basic"))) {
            $sql="insert into sev_comentarios values(null,'".mosgetparam($_POST,"pubnombre","")."','".mosgetparam($_POST,"pubpais","")."','".$narchivo."','','".mosgetparam($_POST,"pubcomentario","")."','".mosgetparam($_POST,"pubciudad","")."',".mosgetparam($_POST,"pubnum","").",'".mosgetparam($_POST,"pubtipo","")."',now(),null,29,null,1)";
            $db->setQuery($sql);
            $db->query();
        }
    }
}
function contenido() {
    $funciones=array("portada","where_to_stay","you_recomendations","tips_for_you_visit","itineraries","interactive_map","directory","search");
    if(in_array(mosgetparam($_GET,"opc","portada"),$funciones)) {
        if(function_exists(mosgetparam($_GET,"opc","inicio"))) {
            $funcion=mosgetparam($_GET,"opc","inicio");
            echo $funcion();
        }
        else {
            portada();
        }
    }
    else {
        portada();
    }
}
function search() {
    global $db;
    $qq=trim(mosgetparam($_GET, "q",""));
    if($qq=="")
        portada();
    else {
        $sql="
        select id, titulo ,IFNULL(round(rating/trate,0),'1') as rating2, precioaprox, tarjeta, descuento, (select count(*) from sev_comentarios as cm where cm.idpublicidad=sev_plus.id and cm.tabpublicidad='plus') as comentarios, imglugar, categoria, direccion, rating, precioaprox , ifnull(tarjeta,0) as tarjeta , ifnull(descuento,0) as descuento , descripcion, 'plus' as cat from sev_plus where titulo like '%".$qq."%' or descripcion like '%".$qq."%' union
        select id, titulo ,IFNULL(round(rating/trate,0),'1') as rating2, precioaprox, tarjeta, descuento, (select count(*) from sev_comentarios as cm where cm.idpublicidad=sev_clasic.id and cm.tabpublicidad='clasic') as comentarios, imglugar, categoria, direccion, rating, precioaprox , ifnull(tarjeta,0) as tarjeta , ifnull(descuento,0) as descuento , descripcion, 'clasic' as cat from sev_clasic where titulo like '%".$qq."%' or descripcion like '%".$qq."%' union
        select id, titulo ,IFNULL(round(rating/trate,0),'1') as rating2, precioaprox, tarjeta, descuento, (select count(*) from sev_comentarios as cm where cm.idpublicidad=sev_basic.id and cm.tabpublicidad='basic') as comentarios, imglugar, categoria, direccion, rating, precioaprox , ifnull(tarjeta,0) as tarjeta , ifnull(descuento,0) as descuento , descripcion, 'basic' as cat from sev_basic where titulo like '%".$qq."%' or descripcion like '%".$qq."%'
        ";
        $pag_actual=mosgetparam($_GET, "pag",1);
        $res=sacar_paginacion($db, $sql, 10, $pag_actual, $numpags,$totalres);
        include("pags/busqueda.php");
    }
}
function interactive_map() {
    include("pags/interactivemap.php");
}
function directory() {
    include("pags/directory.php");
}
function where_to_stay() {
    include("pags/where.php");
}
function itineraries() {
    include("pags/iti.php");
}
function tips_for_you_visit() {
    include("pags/tips.php");
}
function portada() {
    include("portada.php");
}
function clasic() {
    global $db,$cat;
    $res=$db->loadObjectList();
    $cad="";
    $mostrar="";
    $nomostrar="";
    clasic_aux("select id,titulo,publicidadclasic from sev_clasic where estado=1 and ubicacion='Primera' and categoria='".$cat."' order by posicion",$mostrar,$nomostrar);
    clasic_aux("select id,titulo,publicidadclasic from sev_clasic where estado=1 and ubicacion='Segunda' and categoria='".$cat."' order by posicion",$mostrar,$nomostrar);
    clasic_aux("select id,titulo,publicidadclasic from sev_clasic where estado=1 and ubicacion='Tercera' and categoria='".$cat."' order by posicion",$mostrar,$nomostrar);
    clasic_aux("select id,titulo,publicidadclasic from sev_clasic where estado=1 and ubicacion='Cuarta' and categoria='".$cat."' order by posicion",$mostrar,$nomostrar);
    if($mostrar!="")
        $cad=$mostrar.'<div class="nomostrar">$nomostrar</div>';
    else
        $cad="There are not announcements to show";
    return $cad;
}
function clasic_aux($sql,&$cad1,&$cad2) {
    global $db;
    $p=true;
    $cadaux='';
    $db->setQuery($sql);
    $res=$db->loadObjectList();
    if(count($res)>0)
        foreach($res as $r) {
            $cadaux.='<a onclick="displaypub(\'clasic\','.$r->id.',\''.mosgetparam($_GET,"cat","").'\')"><img src="images/plus/'.$r->publicidadclasic.'" border="0" /></a>';
        }
    if($cadaux=='')
        $cad1.='<div class="linkclasic"><img src="images/publicidad-classic.gif" border="0" /></div>';
    else
        $cad1.='<div class="linkclasic">'.$cadaux.'</div>';
}
function plus() {
    global $db,$inicio,$cat;
    $mostrar="";
    $nomostrar="";
    $cad="";
    aux_plus("select id,titulo,publicidadplus from sev_plus where estado=1 and ubicacion='Izquierda' and categoria='".$cat."' order by posicion",$mostrar,$nomostrar,"left");
    aux_plus("select id,titulo,publicidadplus from sev_plus where estado=1 and ubicacion='Derecha' and categoria='".$cat."' order by posicion",$mostrar,$nomostrar,"right");
    if($mostrar!="")
        $cad=$mostrar.'<div class="nomostrar">$nomostrar</div>';
    else
        $cad="There are not announcements to show";
    return $cad;
}
function aux_plus($sql,&$cad1,&$cad2,$flotar) {
    global $db;
    $p=true;
    $cadaux="";
    $db->setQuery($sql);
    $res=$db->loadObjectList();
    if(count($res)>0)
        foreach($res as $r) {
            $cadaux.='<a onclick="displaypub(\'plus\','.$r->id.',\''.mosgetparam($_GET,"cat","").'\')"><img src="images/plus/'.$r->publicidadplus.'" border="0" /></a>';
        }
    if($cadaux=='')
        $cad1.='<div class="linkplus" style="float:'.$flotar.'"><img src="images/publicidad-plus.gif" border="0" /></div>';
    else
        $cad1.='<div class="linkplus" style="float:'.$flotar.'">'.$cadaux.'</div>';
}
function basic() {
    global $db,$cat;
    $db->setQuery("select * from sev_basic where estado=1 and categoria='".$cat."'");
    $res=$db->loadObjectList();
    $cad="";
    $f=4;
    if(count($res)>0)
        foreach($res as $r) {
            if($f%4==0)
                $cad.='<a onclick="displaypub(\'basic\','.$r->id.',\''.mosgetparam($_GET,"cat","").'\')" class="linkbasic atras10"><strong>'.$r->titulo.'</strong>&nbsp;'.limitar_letras($r->publicidadbasic,144-strlen($r->titulo)).'</a>';
            else
                $cad.='<a onclick="displaypub(\'basic\','.$r->id.',\''.mosgetparam($_GET,"cat","").'\')" class="linkbasic"><strong>'.$r->titulo.'</strong>&nbsp;'.limitar_letras($r->publicidadbasic,144-strlen($r->titulo)).'</a>';
            $f++;
        }
    if($cad=="")
        $cad='<div class="basicnohay">There are not registries to show</div>';
    return $cad;

}
/*retorna los comentarios generales*/
function comentarios() {
    global $db;
    validacomentario();
    $micat=mosgetparam($_GET, "cat", "");
    $sql="select b.id as idpub, b.categoria,a.* from sev_comentarios as a inner join sev_plus as b
        on a.idpublicidad=b.id and a.tabpublicidad='plus' where b.categoria like '".$micat."' union
        select b.id as idpub, b.categoria,a.* from sev_comentarios as a inner join sev_basic as b
        on a.idpublicidad=b.id and a.tabpublicidad='basic' where b.categoria like '".$micat."' union
        select b.id as idpub, b.categoria,a.* from sev_comentarios as a inner join sev_clasic as b
        on a.idpublicidad=b.id and a.tabpublicidad='clasic' where b.categoria like '".$micat."' limit 0,10";
    $db->setQuery($sql);
    $res=$db->loadObjectList();
    if(count($res)>0) {
        $cad2="";
        $cad='<div id="comentarios'.(count($res)>4?'conscroll':'sinscroll').'">';
        foreach($res as $r) {
            $cad.= '<div class="comentario" tabpub="'.$r->tabpublicidad.'" idpub="'.$r->idpub.'" catpub="'.$r->categoria.'" >'."\n";
            $cad.= '    <img src="images/comentarios/1_'.$r->imagen.'" border="0" />'."\n";
            $cad.= '    <div class="textocom" >'."\n";
            $cad.= '        '.limitar_letras($r->resumen, 108)."<br/>\n";
            $cad.= '        --'.$r->usuario.". ".$r->ciudad.". ".$r->pais."\n";
            $cad.= ''."\n";
            $cad.= '    </div>'."\n";
            $cad.= '</div>'."\n";
            //$cad2.="<br/><br/><br/><br/><br/><br/><br/><br/>";
        }
        //$cad.='<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
        $cad.=$cad2;
        $cad.='</div>';
        return $cad;
    }
    else {
        return "there are no comments for the momment.";
    }
}
function displaypub() {
    global $db, $path;
    if(in_array($_REQUEST["tipo"],array("plus","basic","clasic"))) {
        $sql="select * from sev_".$_REQUEST["tipo"]." where estado=1 and id=".mosgetparam($_REQUEST,"id");
        $db->setQuery($sql);
        $res=$db->loadObjectList();
        if(count($res)==1) {
            $r=$res[0];
            $sql1="select * from sev_comentarios where idpublicidad=".$r->id." and tabpublicidad='".$_REQUEST["tipo"]."' and estado=1 order by id desc limit 0,8";
            $db->setQuery($sql1);
            $res1=$db->loadObjectList();
            include($path."ajax/".$_REQUEST["tipo"].".php");
        }
        else {
            echo "";
        }
    }else {
        return "mala opción";
    }
}
function set_rate() {
    global $db;
    if(in_array($_POST["tipo"],array("plus","basic","clasic"))) {
        $sql="update sev_".$_POST["tipo"]." set rating=rating+".mosgetparam($_POST,"rating","0").", trate=trate+1 where id=".mosgetparam($_POST,"id","0");
        $db->setQuery($sql);
        $db->query();
        echo $db->getErrorMsg()."_W";
    }
}
function getbanner() {
    global $db;
    $sql="select * from sev_slideshow where estado=1";
    $db->setQuery($sql);
    $res=$db->loadObjectList();
    $r=$res[0];
    return $r;
}
function share_email() {
    global $db;
    $from=$_POST["from"];
    $to=$_POST["to"];
    $url=$_POST["url"];
    $eol="\r\n";
    $now = mktime().".".md5(rand(1000,9999));
    $headers = "From:".$from.$eol."To:".$to.$eol;
    $headers .= 'Return-Path: '.$to.'<'.$to.'>'.$eol;
    $headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
    $headers .= "X-Mailer: PHP v".phpversion().$eol;
    $headers .= "Content-Type: text/html; charset=utf-8".$eol;

    $mensaje = "<style type=\"text/css\">.titulo { font-family: Verdana, arial, sanserif; font-size:16px; font-weight:bold; color:#0097C9 } \n .label { font-family: tahoma, arial, sanserif; font-size:12px; color:#0097C9 } \n .datos { font-family: tahoma, arial, sanserif; font-size:12px; color:#000000; background-color:#F4F3F0; }</style>";
    $mensaje .= 'Hola, '.utf8_encode($from).' desea compartir contigo &eacute;sta direcci&oacute;n:<br/>';
    $mensaje .= '<a href="'.$url.'">'.$url.'</a><br/>';
    $mensaje .= 'Para ingresar haz click en la direcci&oacute;n o pegala en la barra de direccionaes de tu navegador.<br/>';
    $mensaje .= '<br/>';
    $mensaje .= 'El equipo de Mad24';

    $resultado=mail($to, "Mad24", $mensaje, $headers);

}
function carga_ampliar(){
    global $db;
    $sql='select id,titulo,descripcion,imgmapa,categoria from sev_'.$_GET["tipo"].' where id='.$_POST["id"].'';
    $db->setQuery($sql);
    $res=$db->loadObjectList();
    $r=$res[0];
    include("../ajax/mapa_ampliar.php");
}
?>
