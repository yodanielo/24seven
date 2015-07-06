<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/cpanel.css">
            <script>
                function permite_ext(formulario, archivo) {
                    extensiones_permitidas = new Array(".jpg");
                    mierror = "";
                    if (!archivo) {
                        mierror = "No has seleccionado ningún archivo";
                    }else{
                        extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
                        permitida = false;
                        for (var i = 0; i < extensiones_permitidas.length; i++) {
                            if (extensiones_permitidas[i] == extension) {
                                permitida = true;
                                break;
                            }
                        }
                        if (!permitida) {
                            mierror = "Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join();
                        }else{
                            formulario.submit();
                            return 1;
                        }
                    }
                    alert (mierror);
                    return 0;
                }
            </script>
    </head>
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <?php if (basename($_FILES['txt_archivo']['name'])=="") {
            ?>
        <form name="upload" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
            <table width="426" height="163" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="51" colspan="2" align="center" class="form_celda" valign="middle"><br /><strong>SUBIR IMAGEN<br /> </strong><br />Medidas sugeridas: 460px x 273px</td>
                </tr>
                <tr><td height="19" colspan="2"></td></tr>
                <tr>
                    <td width="157"  height="25" align="right"  class="form_celda">Seleccione el Archivo:</td>
                    <td width="269"  align="left" ><input class="form_input2" type="file" name="txt_archivo" id="txt_archivo" maxlength="50" width="200" ></td>
                </tr>
                <tr><td></td><td align="left" valign="top"><input type="button" value="Enviar" class="form_submit"  onclick="permite_ext(this.form, this.form.txt_archivo.value)" /></td></tr>
            </table>
        </form>
        <?
        }
        else {
            $narchivo= mktime().str_replace(" ","",basename($_FILES['txt_archivo']['name']));
            $ruta2 = "../images/galeriaplus/".$narchivo;
            $ruta1 = "../images/galeriaplus/g_".$narchivo;
            if ($_FILES['txt_archivo']['name']!='') {
                if (is_uploaded_file($_FILES['txt_archivo']['tmp_name'])) {
                    move_uploaded_file($_FILES['txt_archivo']['tmp_name'], $ruta1);
                    include_once("fimagenes.php");
                    ajuste_imgmax($ruta1, $ruta1, 460, 273);
                    clipImage($ruta1, $ruta2, 74, 74);
                    echo "<script> opener.agregargaleriaplusitem('".$narchivo."'); window.close();</script>";
                }
                else {
                    echo '<table width="451" height="161" border="0" cellpadding="0" cellspacing="0"><tr><td align=center class="form_celda">Problema subiendo el archivo: '. $_FILES['txt_archivo']['name'].'.</td></tr>';
                    echo '<tr><td align=center><input class="form_submit" type=button onclick="window.close();" value="Cerrar"></td></tr></table>';
                }
            }
        }

        ?>
    </body>
</html>
