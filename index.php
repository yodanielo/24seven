<?php
include("includes/contenido.php")
        ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html charset=utf-8" />
        <title><?php echo $config_sitename ?></title>
        <meta name="Description" content="<?php echo $config_MetaDesc ?>" />
        <meta name="Keywords" content="<?php echo $config_MetaKeys ?>" />
        <meta name="author" content="<?php echo $config_author ?>" />
        <meta name="owner" content="<?php echo $config_sitename ?>" />
        <meta name="robots" content="index, follow" />
        <meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT"/>
        <meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"/>
        <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache"/>
        <link rel="stylesheet" type="text/css" href="css/jScrollPane.css" />
        <link rel="stylesheet" type="text/css" href="css/nav.css" />
        <?php
        if(!isset($_GET["cat"]))
            echo '<link rel="stylesheet" type="text/css" href="css/defecto.css" />'."\n";
        else
            echo '<link rel="stylesheet" type="text/css" href="css/'.mosgetparam($_GET,"cat").'.css" />'."\n";
        ?>
        <!--[if IE ]>
	<link rel="stylesheet" type="text/css" href="css/ie.css" />
        <![endif]-->
        <!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" href="css/ie7.css" />
        <![endif]-->
        <!--[if lte IE 6]>
	<link rel="stylesheet" type="text/css" href="css/ie6.css" />
        <![endif]-->
        <script type="text/javascript" src="js/runD.js"></script>
        <script type="text/javascript" src="js/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="js/jqModal.js"></script>
        <script type="text/javascript" src="js/jquery.cycle.all.2.72.js"></script>
        <script type="text/javascript" src="js/jScrollPane-1.2.3.min.js"></script>
        <script type="text/javascript" src="js/generales.js"></script>
    </head>
    <body>
        <?php
        if($_POST["pubtipo"]) {
            echo '<script type="text/javascript">Thanks for participating</script>';
        }
        ?>
        <div id="pagina">
            <div id="barraprincipal">
                <a id="logo" href="index.php"></a>
                <div id="barrahder">
                    <div id="madbcn">
                        <a href="#" id="mad_selected"></a>
                        <a href="#" id="bcn"></a>
                    </div>
                    <div id="searchseven">
                        <form name="searchseven" action="" method="get">
                            <div id="siguenos"></div>
                            <div id="cuadrosiguenos">
                                <a target="_blank" href="http://twitter.com/MAD24es"><img src="images/sig-twitter.jpg" border="0" /></a><br/>
                                <a target="_blank" href="http://www.facebook.com/pages/MAD24/108784392481622"><img src="images/sig-facebook.jpg" border="0" /></a><br/>
                                <a target="_blank" href="http://www.youtube.com/user/MAD24guide"><img src="images/sig-youtube.jpg" border="0" /></a><br/>
                                <a target="_blank" href="http://www.myspace.com/530139422"><img src="images/sig-myspace.jpg" border="0" /></a>
                            </div>
                            <input type="text" id="query" name="q" value="MAD24" />
                            <input type="hidden" name="opc" value="search" />
                        </form>
                    </div>
                    <div id="menuprincipal1">

                        <a id="directory<?=($_GET["opc"]=="directory"?'_selected':"")?>"  href="index.php?opc=directory"></a>
                        <a id="interactivemap<?=($_GET["opc"]=="interactive_map"?'_selected':"")?>"  href="index.php?opc=interactive_map"></a>
                        <a id="itineraries<?=($_GET["opc"]=="itineraries"?'_selected':"")?>"  href="index.php?opc=itineraries"></a>
                        <a id="tipsforyouvisit<?=($_GET["opc"]=="tips_for_you_visit"?'_selected':"")?>"  href="index.php?opc=tips_for_you_visit"></a>
                        <a id="yourrecomendations<?=($_GET["opc"]=="your_recomendations"?'_selected':"")?>"  href="index.php?opc=your_recomendations"></a>
                        <a id="wheretostay<?=($_GET["opc"]=="where_to_stay"?'_selected':"")?>"  href="index.php?opc=where_to_stay"></a>
                    </div>
                    <div id="menuprincipal2">
                        <a id="food<?=($cat=="food"?"_selected":"") ?>" href="index.php?cat=food"></a>
                        <a id="bars<?=($cat=="bars"?"_selected":"") ?>" href="index.php?cat=bars"></a>
                        <a id="nightlife<?=($cat=="nightlife"?"_selected":"") ?>" href="index.php?cat=nightlife"></a>
                        <a id="culture<?=($cat=="culture"?"_selected":"") ?>" href="index.php?cat=culture"></a>
                        <a id="shopping<?=($cat=="shopping"?"_selected":"") ?>" href="index.php?cat=shopping"></a>
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------------------->
            <!--fin del banner-->
            <!---------------------------------------------------------------------->
            <div id="content">
                <?php
                if(!isset($_GET["cat"]))
                    if(isset($_GET["opc"])) {
                        contenido();
                    }
                    else {
                        include("portada.php");
                    }
                else
                    include("cates.php");
                ?>
            </div>
            <div id="footer">
                <a class="linkfooter" id="foo1" href="#"></a>
                <a class="linkfooter" id="foo2" href="#"></a>
            </div>
        </div>
        <div id="dlgpub" class="jqmWindow">

        </div>
        <div id="dlgbanner" class="jqmWindow">
            <?php
            $ban=getbanner();
            echo '<img src="images/banner/'.$ban->banner.'" border="0" onclick="cerrarbanner('.$ban->publicidad.')">';
            ?>
        </div>
        <?php if(!$_GET["cat"] && !$_GET["gracias"] && !$_GET["opc"]) { ?>
        <script type="text/javascript">
            $(document).ready(function(){
    <?if($ban->banner!="" && $ban->banner!=null)
        echo 'cargarbanner();';
    ?>
            //window.status="Listo"
        });
        </script>
            <?php } ?>
        <script type="text/javascript">
            spclasic=4000;
            $('.linkclasic').each(function(){
                $(this).cycle({
                    fx: 'fade',
                    speed: 1000,//'velocidad de transicion'
                    timeout:spclasic//tiempo que permace estatico
                });
                spclasic+=1000;
            });
            spplus=4000;
            $('.linkplus').each(function(){
                $(this).cycle({
                    fx: 'fade',
                    speed: 1000,//'velocidad de transicion'
                    timeout:spplus//tiempo que permace estatico
                });
                spplus+=1000;
            });
            $('#comentariosconscroll').jScrollPane({
                scrollbarWidth: 14
            });


            $("#siguenos").hover(function(){
                $("#cuadrosiguenos").fadeIn(400,function(){
                    $(this).css("display","block");
                });
            },function(){});
            $("#cuadrosiguenos").hover(
            function(){},
            function(){
                $("#cuadrosiguenos").fadeOut(400,function(){});
            });
            $("#cuadrosiguenos").css("display","none");
        </script>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script> 
        <script type="text/javascript">
            try {
                var pageTracker = _gat._getTracker("UA-16081736-1");
                pageTracker._trackPageview();
            } catch(err) {}</script>
    </body>
</html>
