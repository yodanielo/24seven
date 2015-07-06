<div id="titbusqueda"><?=($totalres>0?$totalres." RESULTS FOR ":"THERE ARE NO RESULTS FOR ").strip_tags($qq)?></div>
<?php
if(count($res)>0)
foreach($res as $r) {?>
<div class="itembusqueda">
    <img src="images/imglugar/<?=($r->imglugar!=""?$r->imglugar:"defecto_busqueda.gif")?>" width="97" height="97"/>
    <div class="ibustexto">
        <div class="ibustitle"><span class="ibusname"><?=$r->titulo?></span>&nbsp;// <?=$r->categoria.' // '.$r->direccion?></div>
        <div class="ibusdescription"><?=strip_tags($r->descripcion)?>&nbsp;<a class="ibusgoto" href="javascript:displaypub('<?=$r->cat?>',<?=$r->id?>,'<?=$r->categoria?>')">go to review</a></div>
    </div>
    <div class="ibusmeta">
        <div class="ibusmetarow">
            <div class="ibusopiniones"><?=$r->comentarios?> comentarios</div>
            <div class="ibusestrellas"><?php
                    $j=(int)$r->rating2;
                    for($i=0;$i<5;$i++) {
                        if($j>0)
                            echo '<img src="images/ib_estrella_1.gif"/>';
                        else
                            echo '<img src="images/ib_estrella_0.gif"/>';
                        $j--;
                    }
                    ?></div>
        </div>
        <div class="ibusmetarow">
                <?=($r->precioaprox!=""?"&euro;&euro;: ".$r->precioaprox:"")?>
        </div>
        <div class="ibusmetarow">
            <img src="images/creditcar_<?=($r->tarjeta)?>.gif" />
        </div>
        <div class="ibusmetarow">
            <img src="images/descuento_<?=($r->tarjeta)?>.gif" />
        </div>
    </div>
</div>
    <?php }
?>
<div id="buspaginacion">
    <?php
    if($numpags>1)
        for($i=1;$i<=$numpags;$i++) {
            if($i!=$pag_actual)
                echo '&nbsp;<a class="ibpag" href="?opc=search&pag='.$i.'&q='.rawurlencode(strip_tags($qq)).'">'.$i.'</a>';
            else
                echo '&nbsp;<a class="ibpag selected">'.$i.'</a>';
        }
    ?>
</div>