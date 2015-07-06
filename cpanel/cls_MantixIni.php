<?php
include("cls_MantixMenu.php");
$menu =new MantixMenu();
$menu->opciones = array(
	array("titulo"=>"Administradores" ,"url"=>"usuarios.php","id"=>"usuarios"),
        array("titulo"=>"Publicidad", "url"=>"plus.php","id"=>"configuracion",
            "sub"=>array(
                array("titulo"=>"Plus" ,"url"=>"plus.php","id"=>"sectores"),
                array("titulo"=>"Classic" ,"url"=>"clasic.php","id"=>"negocios",),
                array("titulo"=>"Basic", "url"=>"basic.php","id"=>"delegaciones",),
            ),
        ),
        array("titulo"=>"Comentarios" ,"url"=>"comentarios.php","id"=>"usuarios"),
        array("titulo"=>"Slideshow" ,"url"=>"slideshow.php","id"=>"usuarios"),
);
$img_top="bg-top.jpg";
$usuario="";
?>