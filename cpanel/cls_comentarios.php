<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    function __construct() {
        $this->ini_datos("sev_comentarios","id");
    }
    function lista() {
        $r = new MantixGrid();
        $sql="
                select id,estado,usuario,tabpublicidad, (select titulo from sev_plus as sp where sp.id=idpublicidad) as titulopub from sev_comentarios where sev_comentarios.tabpublicidad='plus' union
                select id,estado,usuario,tabpublicidad, (select titulo from sev_clasic as sp where sp.id=idpublicidad) as titulopub from sev_comentarios where sev_comentarios.tabpublicidad='clasic' union
                select id,estado,usuario,tabpublicidad, (select titulo from sev_basic as sp where sp.id=idpublicidad) as titulopub from sev_comentarios where sev_comentarios.tabpublicidad='basic'";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"id","url_form"=>"comentarios.php","url"=>"comentarios.php","ver_modificar"=>"0");
        $r->columnas=array(
            array("titulo"=>"Usuario","campo"=>"usuario"),
            array("titulo"=>"Tipo de publicidad","campo"=>"tabpublicidad"),
            array("titulo"=>"Titulo","campo"=>"titulopub"),
        );

        return $r->ver();
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos=array("texto_submit"=>"Registro");
        $m_Form->datos=$this->datos;
        $m_Form->controles=array(
            array("label"=>"Título:","campo"=>"titulo","tipo"=>"text"),
            array("label"=>"Publicidad:","campo"=>"publicidadplus","tipo"=>"archivo"),
            array("label"=>"Video de ficha:","campo"=>"videofichaplus","tipo"=>"archivo"),
            array("label"=>"Logotipo de ficha:","campo"=>"logofichaplus","tipo"=>"archivo"),
            array("label"=>"Descripción:","campo"=>"descripcion","tipo"=>"fck"),
            array("label"=>"Galeria de imagenes:","campo"=>"galeriaplus","tipo"=>"selcadena"),
            array("label"=>"Estado del registro","campo"=>"estado","tipo"=>"checkbox")
        );
        return $m_Form->ver();
    }
}
?>
