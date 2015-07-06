<div id="pubclasic">
    <?php echo clasic() ?>
</div>
<div id="pubplus">
    <?php echo plus() ?>
</div>

<?php echo comentarios() ?>

<div id="barrabasic"></div>
<div id="pubbasic">
    <?php echo basic() ?>
</div>
<script type="text/javascript">
    <?php if($_GET["type"] && $_GET["id"])
        echo "displaypub('".$_GET["type"]."',".$_GET["id"].",'".$_GET["cat"]."');";
    ?>
    cargarcates();
</script>