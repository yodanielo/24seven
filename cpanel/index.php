<?php
include("cls_MantixError20.php");
include("cls_usuarios.php");
if ($_POST["txt_user"]!="") {
	$w_Error= new MantixError();
	$adm_usuario= new Usuarios();
	$adm_usuario->usuario = $_POST["txt_user"];
	$adm_usuario->password =$_POST["txt_pass"];
	$res=$adm_usuario->ingresar();
	if($res=="0") {  header("location:usuarios.php"); }
	else {
	 $w_Error->ok($res);
	 }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/login.css">

<SCRIPT language="JavaScript">
self.moveTo(0,0);self.resizeTo(screen.availWidth,screen.availHeight);
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="login_center">
<form name="form1" method="post" action="index.php">
<div id="contenido">
<div id="cont_img"></div>
<br clear="all">
<br><br>
<div id="cont">
<span class="login_label">Usuario:&nbsp;</span>
<div><input name="txt_user" type="text" class="login_input"></div>
<br />
<span class="login_label" >Contrase&ntilde;a:&nbsp;</span>
<div><input name="txt_pass" type="password" class="login_input"></div>
<div style="margin-top:20px" align="center"><input name="Submit" type="submit" class="login_submit" value="Iniciar Sesión"></div>
</div>
</div>
</form>
</div>
</BODY>
</html>