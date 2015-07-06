<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    function __construct() {
        $this->ini_datos("sev_plus","id");
    }
    function lista() {
        $r = new MantixGrid();
        $sql="select *,if(posicion between 1 and 2,posicion,'') as pos2, ceil(rating/5) as sumarating from sev_plus";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"categoria, ubicacion, posicion","url_form"=>"plus.php","url"=>"plus.php");
        $r->columnas=array(
                array("titulo"=>"Título","campo"=>"titulo"),
                array("titulo"=>"Orden","campo"=>"pos2"),
                array("titulo"=>"Rating","campo"=>"sumarating"),
                array("titulo"=>"Categoría","campo"=>"categoria"),
                array("titulo"=>"Ubicación","campo"=>"ubicacion")
        );

        return $r->ver();
    }
    function get_ubicacion() {
        $r='';
        $r.='<option value="Izquierda">Izquierda</option>';
        $r.='<option value="Derecha">Derecha</option>';
        return $r;
    }
    function get_cats() {
        $r.='';
        //$r.='<option value="General">General</option>';
        $r.='<option value="Food">Food</option>';
        $r.='<option value="Bars">Bars</option>';
        $r.='<option value="NightLife">Nightlife</option>';
        $r.='<option value="Culture">Culture</option>';
        $r.='<option value="Shopping">Shopping</option>';
        $r.='<option value="Best of">Best of</option>';
        return $r;
    }
    function get_posicion() {
        $r="";
        $r.='<option value="3">Ninguno</option>';
        $r.='<option value="1">Primera</option>';
        $r.='<option value="2">Segunda</option>';
        return $r;
    }
    function get_decision() {
        $r='';
        $r.='<option value="0">NO</option>';
        $r.='<option value="1">Sí</option>';
        return $r;
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos=array("texto_submit"=>"Registro");
        $m_Form->datos=$this->datos;
        $m_Form->controles=array(
                array("label"=>"Título:","campo"=>"titulo","tipo"=>"text","obligatorio"=>"1"),
                array("label"=>"Categoría:","campo"=>"categoria","tipo"=>"select","opciones"=>$this->get_cats()),
                array("label"=>"Mapa:","campo"=>"mapa","tipo"=>"text","obligatorio"=>"1"),
                array("label"=>"Dirección:","campo"=>"direccion","tipo"=>"text"),
                array("label"=>"Precio Proximado:","campo"=>"precioaprox","tipo"=>"text"),
                array("label"=>"Tarjeta:","campo"=>"tarjeta","tipo"=>"select","opciones"=>$this->get_decision()),
                array("label"=>"Descuento:","campo"=>"descuento","tipo"=>"select","opciones"=>$this->get_decision()),
                array("label"=>"Publicidad:","campo"=>"publicidadplus","tipo"=>"archivo"),
                array("label"=>"Vídeo de ficha:","campo"=>"videofichaplus","tipo"=>"archivo"),
                array("label"=>"Ancho del vídeo:","campo"=>"wvideo","obligatorio"=>"1"),
                array("label"=>"Alto del vídeo:","campo"=>"hvideo","obligatorio"=>"1"),
                array("label"=>"Imagen del lugar:","campo"=>"imglugar","tipo"=>"archivo"),
                array("label"=>"Imagen para el mapa:","campo"=>"imgmapa","tipo"=>"archivo"),
                array("label"=>"Logotipo de ficha:","campo"=>"logofichaplus","tipo"=>"archivo"),
                array("label"=>"Descripción:","campo"=>"descripcion","tipo"=>"fck"),
                array("label"=>"Galería de imágenes:","campo"=>"galeriaplus","tipo"=>"selcadena"),
                array("label"=>"Ubicación:","campo"=>"ubicacion","tipo"=>"select","opciones"=>$this->get_ubicacion()),
                array("label"=>"Orden:","campo"=>"posicion"),
                array("label"=>"Estado del registro","campo"=>"estado","tipo"=>"checkbox")
        );
        return $m_Form->ver();
    }
    function pre_ins() {
        $this->datos->agregar("estado","1");
        $_POST["estado"]=1;
        $this->insertar_orden("posicion");
        if($_POST["scadenagaleriaplus"]!="")
            $this->datos->agregar("galeriaplus",implode(",",$_POST["scadenagaleriaplus"]));
    }
    function pre_upd() {
        if($_POST["scadenagaleriaplus"]!="")
            $this->datos->agregar("galeriaplus",implode(",",$_POST["scadenagaleriaplus"]));
        if($_POST["estado"]=="1") {
            $this->actual_orden("posicion");
        }
        else {
            $this->del_orden("posicion");
        }
    }
    function pre_del() {
        $campo="posicion";
        $id=$_POST["idobj"];
        $sql="select estado, posicion from sev_plus where id=".$id;
        $db2 = new MantixOaD();
        $res=$db2->ejecutar($sql);
        try{
            $r=mysql_fetch_array($res);
            if($r["estado"]=="1") {
                $sql="update sev_plus set posicion=posicion-1 where posicion>".(int)$r["posicion"]." and posicion>=1";
                $db2->ejecutar($sql);
            }
        }
        catch (Exception $e){
            //no s ehace nada
        }
    }
    function insertar_orden($campo) {
        $orden=$_POST[$campo];
        $d2=new MantixOaD();
        $r=1;
        $sql="select max(".$campo.") as conteo from sev_plus where ".$campo."<".$orden." and estado=1 and categoria='".$_POST["categoria"]."' and ubicacion='".$_POST["ubicacion"]."'";
        $r=$d2->get_simple($sql);
        $orden=(int)$r+1;
        $d2->ejecutar("update sev_plus set ".$campo."=".$campo."+1 where ".$campo.">=".$orden." and estado=1 and categoria='".$_POST["categoria"]."' and ubicacion='".$_POST["ubicacion"]."'");
        $this->datos->agregar($campo,$orden);
    }
    function actual_orden($campo) {
        $orden=$_POST[$campo];
        if($_POST[$campo]!=$_POST[$campo."_ant"] || (int)$orden<=0) {
            if((int)$orden<=0) {
                $orden=1;
            }
            $d2=new MantixOaD();
            if($_POST[$campo."_ant"]>=1) {
                $sql="update sev_plus set ".$campo."=".$campo."-1 where ".$campo.">=".$_POST[$campo."_ant"]." and estado=1 and categoria='".$_POST["categoria"]."' and ubicacion='".$_POST["ubicacion"]."'";
            }
            $d2->ejecutar($sql);
            $sql="select max(".$campo.") as conteo from sev_plus where ".$campo."<".$orden." and estado=1 and categoria='".$_POST["categoria"]."' and ubicacion='".$_POST["ubicacion"]."'";
            $r=$d2->get_simple($sql);
            $orden=(int)$r+1;
            if((int)$orden<=0) {
                $orden=1;
            }
            $d2->ejecutar("update sev_plus set ".$campo."=".$campo."+1 where ".$campo.">=".$orden." and estado=1 and categoria='".$_POST["categoria"]."' and ubicacion='".$_POST["ubicacion"]."'");
            $this->datos->agregar($campo,$orden);
        }
    }
    function del_orden($campo) {
        $d2=new MantixOaD();
        $orden=$_POST[$campo];
        //cojo el estado antes de actualizar
        $sql="select estado from sev_plus where id=".$_POST["idobj"];
        $estado_ant=$d2->get_simple($sql);
        if($estado_ant=="1") {

            $sql="update sev_plus set ".$campo."=".$campo."-1 where ".$campo.">=".$orden." and ".$campo.">0 and categoria='".$_POST["categoria"]."' and ubicacion='".$_POST["ubicacion"]."'";
            $d2->ejecutar($sql);
        }
    }
}
?>
