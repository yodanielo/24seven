<?php
//echo $sql."<br/>".count($res);
if($r->imgmapa==""){
    $r->imgmapa="defecto_mapa.gif";
}
?>
<div id="ampliar_container">
<img src="images/imgmapa/<?=$r->imgmapa?>"/>
<div id="texto_ampliar">
<span id="ampliar_title"><?=$r->titulo?></span><br/>
<p>
    <?=limitar_letras(strip_tags($r->descripcion),200)?>
</p>
</div>
<div id="ampliar_links">
    <div id="idnumampliar"></div>
    <a target="_blank" href="imprimir.php?tipo=<?=$_GET["tipo"]?>&id=<?=$r->id?>">PRINT &gt;</a>&nbsp;
    <a href="javascript:displaypub('<?=$_GET["tipo"]?>',<?=$r->id?>,'<?=$r->categoria?>')">GO TO REVIEW &gt;</a>
</div>
</div>