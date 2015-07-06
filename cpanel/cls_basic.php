<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    function __construct() {
        $this->ini_datos("sev_basic","id");
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

    function lista() {
        $r = new MantixGrid();
        $sql="select *, ceil(rating/5) as sumarating from sev_basic";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"id desc","url_form"=>"basic.php","url"=>"basic.php");
        $r->columnas=array(
            array("titulo"=>"Título","campo"=>"titulo"),
            array("titulo"=>"Rating","campo"=>"sumarating"),
            array("titulo"=>"Categoría","campo"=>"categoria"),
        );

        return $r->ver();
    }
    function get_decision(){
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
            array("label"=>"Título:","campo"=>"titulo","tipo"=>"text"),
            array("label"=>"Categoría:","campo"=>"categoria","tipo"=>"select","opciones"=>$this->get_cats()),
            array("label"=>"Mapa:","campo"=>"mapa","tipo"=>"text"),
            array("label"=>"Dirección:","campo"=>"direccion","tipo"=>"text"),
            array("label"=>"Precio Proximado:","campo"=>"precioaprox","tipo"=>"text"),
            array("label"=>"Tarjeta:","campo"=>"tarjeta","tipo"=>"select","opciones"=>$this->get_decision()),
            array("label"=>"Descuento:","campo"=>"descuento","tipo"=>"select","opciones"=>$this->get_decision()),
            array("label"=>"Resumen:","campo"=>"publicidadbasic","tipo"=>"area"),
            array("label"=>"Imagen de ficha:","campo"=>"videofichabasic","tipo"=>"archivo"),
            array("label"=>"Imagen para el mapa:","campo"=>"imgmapa","tipo"=>"archivo"),
            array("label"=>"Logotipo de ficha:","campo"=>"logofichabasic","tipo"=>"archivo"),
            array("label"=>"Descripción:","campo"=>"descripcion","tipo"=>"fck"),
            array("label"=>"Estado del registro","campo"=>"estado","tipo"=>"checkbox")
        );
        return $m_Form->ver();
    }
    function pre_ins() {
        $this->datos->agregar("estado","1");
    }
}
?>
