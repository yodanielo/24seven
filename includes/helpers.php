<?php 
function esp_char($cadena){
    $traducciones=array(
        "Á"=>"Aacute;",
        "É"=>"Eacute;",
        "Í"=>"Iacute;",
        "Ó"=>"Oacute;",
        "Ú"=>"Uacute;",
        "á"=>"aacute;",
        "é"=>"eacute;",
        "í"=>"iacute;",
        "ó"=>"oacute;",
        "ú"=>"uacute;",
        "Ñ"=>"&Ntilde;",
        "ñ"=>"&ntilde;",
        "¡"=>"&iexcl;",
        "¿"=>"&iquest;",
    );
    strtr($cadena,$traducciones);
}
function contar_palabras($str,$conetiquetas=0){
	if(conetiquetas==1)
		$str=strip_tags($str);
	$reemplazar=array(",",".","-","+","(",")","{","}","_",";",":","  ");
	foreach ($reemplazar as $rr){
		$str=str_replace($rr,"",$str);
	}
	return sizeof(explode(" ", $str));
}

function limitar_palabras($str, $limit = 100, $end_char = '&#8230;')
{

	if (trim($str) == '')
	{
		return $str;
	}

	preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);
		
	if (strlen($str) == strlen($matches[0]))
	{
		$end_char = '';
	}
	
	return rtrim($matches[0]).$end_char;
}

function limitar_letras($str, $n = 500, $end_char = '&#8230;')
{
	if (strlen($str) < $n)
	{
		return $str;
	}
	
	$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

	if (strlen($str) <= $n)
	{
		return $str;
	}

	$out = "";
	foreach (explode(' ', trim($str)) as $val)
	{
		$out .= $val.' ';
		
		if (strlen($out) >= $n)
		{
			$out = trim($out);
			return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
		}		
	}
}
/**
 * hace la paginacion de una consulta
 * @param Database $db la conexion a ala base de datos
 * @param <type> $sql la sentenia sql a la cual paginar
 * @param <type> $numresults numero de resultados por pagina
 * @param <type> $pag_atual ingresa y devuelve la pagina de la cual retornar los resultados
 * @param <type> $numpags devuelve el numero de paginas en la paginacion
 * @param <type> $totalres devuelve el numero de resultados de la consulta
 * @return <type> retorna la paginacion
 */
function sacar_paginacion(Database $db,$sql,$numresults,&$pag_actual,&$numpags,&$totalres=null){
    //saco el numero de resultados total
    $db->setQuery($sql);
    $totalres=count($db->loadObjectList());
    $numpags=ceil($totalres/$numresults);
    if($pag_actual>=$numpags)
        $pag_actual=$numpags;
    $lmin=($pag_actual-1)*$numresults;
    $lmax=$numresults;
    //saco los resultados de la paginacion
    $db->setQuery($sql." limit ".$lmin.",".$lmax);
    return $db->loadObjectList();
}
?>
