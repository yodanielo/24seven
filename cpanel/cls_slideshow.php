<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    function __construct() {
        if(!$_POST["accion"] || $_POST["accion"]!="2") {
                $_POST["accion"]="20";
                $_POST["idobj"]="1";
        }
        $this->ini_datos("sev_slideshow","id");
    }
    function lista() {
        $r = new MantixGrid();
        $sql="select sev_slideshow.*, sev_plus.titulo as publi1 from sev_slideshow inner join sev_plus on sev_slideshow.publicidad = sev_plus.id";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"id desc","url_form"=>"slideshow.php","url"=>"slideshow.php","ver_eliminar"=>"0","ver_estado"=>"0");
        $r->columnas=array(
                array("titulo"=>"Banner","campo"=>"banner"),
                array("titulo"=>"Publicidad para acceder","campo"=>"publi1"),
        );

        return $r->ver();
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos=array("texto_submit"=>"Registro");
        $m_Form->datos=$this->datos;
        $m_Form->controles=array(
                array("label"=>"Banner:","campo"=>"banner","tipo"=>"archivo"),
                array("label"=>"Publicidad para acceder:","campo"=>"publicidad","tipo"=>"select","tabla_asoc"=>"sev_plus","campo_asoc"=>titulo,"id_asoc"=>"id"),
                array("label"=>"Estado del registro:","campo"=>"estado","tipo"=>"select","opciones"=>$this->getdecision()),
        );
        return $m_Form->ver();
    }
    function getdecision(){
        return '<option value="1">Sí</option><option value="0">No</option>';
    }
}
?>
