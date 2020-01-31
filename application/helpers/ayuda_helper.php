<?php

if ( ! function_exists('login_url'))
{
	function login_url()
	{
		return "http://" . $_SERVER['SERVER_NAME'];
	}
}

if ( ! function_exists('login_empresa')) {
	function login_empresa($vinculo = TRUE) {
		if (isset($_SESSION['EmpresaID']) && !empty($_SESSION['EmpresaID'])) {
			return true;
		} else {
			if ($vinculo) {
				$_SESSION['vinculo'] = uri_string();
			}
			
			return false;
		}
	}
}

if ( ! function_exists('sys_url'))
{
	function sys_url($url = '')
	{
		return "http://" . $_SERVER['SERVER_NAME'] . "/grupo_c807/" . $url;
	}
}

if ( ! function_exists(('sys_base'))) {
	# Devuelve la ruta de un archivo o carpeta en disco. Ej.: /home/usuer/documentos/archivo.pdf
	# El parémetro a recibir es igual al formato de base_url
	function sys_base($dir = '') {
		return dirname(dirname(dirname(__FILE__))) . "/{$dir}";
	}
}

if ( ! function_exists('formatoFecha')) {
	function formatoFecha($fecha = '', $tipo='') {
		
		if (empty($fecha)) {
			return $fecha;
		}

		try {
			$date    = new DateTime($fecha);
			$formato = '';

			switch ($tipo) {
				case 1:
					$formato = "d/m/Y H:i";
					break;
				case 2:
					$formato = 'd/m/Y';
					break;
				case 3: # Devuelve el día
					$formato = 'd';
					break;
				case 4: # Devuelve mes
					$formato = 'm';
					break;
				case 5: # Devuelve año
					$formato = 'Y';
					break;
				case 6: # Devuelve año
					$formato = 'H:i:s';
					break;
				default:
					$formato = "d/m/Y H:i";
					break;
			}
			
			return $date->format($formato);

		} catch (Exception $e) {
		    return $fecha;
		}
	}
}

if ( ! function_exists('dosNombres')) {
	function dosNombres($nombre = '') {
		if (!empty($nombre)) {
			$arr = explode(" ", $nombre);
			return $arr[0] . " " . $arr[1];
		}
		return $nombre;
	}
}

if ( ! function_exists('Hoy')) {
	function Hoy($tipo = '') {
		switch ($tipo) {
			case 1:
				return date('d/m/Y');
			case 2:
				return date('d/m/Y H:i:s');
			case 3:
				return date('Y-m-d H:i:s');
			case 4:
				return date('H:i:s');
			case 5:
				return date('H:i');
			case 6:
				return date('d');
			case 7:
				return date('m');
			case 8:
				return date('Y');
			default:
				return date('Y-m-d');
		}
	}
}

if ( ! function_exists('primerDia')) {
	function primerDia($tipo = '') {
		return date('Y-m') . "-01";
	}
}

if ( ! function_exists('verDato') ) {
	/* Verifica que un índice se encuentre dentro de un arreglo. */
	function verDato($arr, $dato, $return=FALSE) {
		if (is_array($arr) && array_key_exists($dato, $arr) && !empty($arr[$dato])) {
			return $arr[$dato];
		}
		
		return $return;
	}
}


if ( ! function_exists('verDatoCero') ) {
	/* Verifica que un índice se encuentre dentro de un arreglo. */
	function verDatoCero($arr, $dato) {
		if (isset($arr[$dato]) && (!empty($arr[$dato]) || ($arr[$dato]==0)) ) {
		
			return true;
		}
		return false;
	}
}


if ( ! function_exists('depurar')) {
	function depurar($var) {
	    highlight_string("<?php\n\$depurar =\n" . var_export($var, true) . ";\n?>");
	}
}

if ( ! function_exists('verLimite')) {
	function verLimite() {
		return 30;
	}
}

if ( ! function_exists('verDatosNavegacion')) {
	function verDatosNavegacion() {
		$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
		$os=array("WIN","MAC","LINUX");
	 
		# definimos unos valores por defecto para el navegador y el sistema operativo
		$info['browser'] = "OTHER";
		$info['os'] = "OTHER";
	 
		# buscamos el navegador con su sistema operativo
		foreach($browser as $parent)
		{
			$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
			$f = $s + strlen($parent);
			$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
			$version = preg_replace('/[^0-9,.]/','',$version);
			if ($s)
			{
				$info['browser'] = $parent;
				$info['version'] = $version;
			}
		}
	 
		# obtenemos el sistema operativo
		foreach($os as $val)
		{
			if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
				$info['os'] = $val;
		}

		$ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	    
	    $info['usuario_ip'] = $ipaddress;
	 
		# devolvemos el array de valores
		return json_encode($info);
	}
}

// Funcion para verificar si un numero esta dentro un rango 
if( ! function_exists('between_numero')){
	function between_numero($numero,$rango_ini,$rango_fin){
		if($rango_ini<=$numero && $numero<=$rango_fin){
			return true;
		};
		return false;
	}
}

if( ! function_exists('suma_field')){
	function suma_field($datos,$campo,$filtro = ''){
		$suma_campo = 0;

		if(!empty($filtro)) {
			foreach ($datos as $row) {
				$suma_campo += $row->$campo;
			}
		}else{
			foreach ($datos as $row) {
				$suma_campo += $row->$campo;
			}
		}
		
		return round($suma_campo,2);
	}
}

if ( ! function_exists('truncarNumero')) {
	function truncarNumero($number, $digitos)
	{
	    $raiz = 10;
	    $multiplicador = pow ($raiz,$digitos);
	    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
	    return (float)number_format($resultado, $digitos);
	 
	}
}



function numeroAlfabeto($numero = '') {
    $letras = range('a', 'z');

	return $letras[$numero];
}

if ( ! function_exists('cargarLibreria'))
{
	function cargarLibreria($ubicacion)
	{
		include getcwd() . "/application/libraries/" . $ubicacion . ".php";
	}
}

if ( ! function_exists('limpiarString'))
{
	function limpiarString($cadena)
	{
		$cadena = str_replace(' ', '', $cadena);
		$cadena = str_replace('-', '', $cadena);
		$cadena = str_replace('/', '', $cadena);
		$cadena = str_replace('.', '', $cadena);
		$cadena = str_replace('*', '', $cadena);
		$cadena = str_replace('#', '', $cadena);
		$cadena = str_replace('$', '', $cadena);
		$cadena = str_replace('&', '', $cadena);
		$cadena = str_replace('"', '', $cadena);
		$cadena = str_replace('\'', '', $cadena);

		return $cadena;
	}
}

if ( ! function_exists('descripcionManualFiles')) {
	function descripcionManualFiles(Array $datos)
	{
		$tmp = array();

		foreach ($datos as $row) {
			$dt = explode("&&", $row);

			$tmp[] = array(
				'descripcion' => $dt[1], 
				'dlote'       => explode(",", $dt[0]) 
			);
		}

		return $tmp;
	}
}

if ( ! function_exists('opcionesSelect')) {
	function opcionesSelect($datos, $indice, $campo, $valor = array())
	{
		$arreglo = array('' => '------');

		foreach ($datos as $row) {
			if (empty($valor)) {
				$arreglo[$row->$indice] = $row->$campo;
			} else {
				if (is_array($valor) && in_array($row->$indice, $valor)) {
					$arreglo[$row->$indice] = $row->$campo;
				}
			}
		}

		return $arreglo;
	}
}

if ( ! function_exists('get_version')) {
	function get_version() {
		return 2.1;
	}
}

if ( ! function_exists('buscar_en')) {
	/**
	 * Buscar dentro de un arreglo un dato que recibo como parámentro
	 * @param  Array   $arreglo Arreglo de datos dónde buscar
	 * @param  [type]  $dato    dato a buscar
	 * @param  integer $indice  (Opcional, si es mayor a cero, buscará en las posiciones que sean mayor o igual al enviado)
	 * @return [key] posición dentro del arreglo
	 */
	function buscar_en(Array $arreglo, $dato, $indice = 0) {
		if (in_array($dato, $arreglo)) {
			if ($indice == 0) {
				return array_search($dato, $arreglo);
			} else {
				foreach ($arreglo as $key => $value) {
					if ($key >= $indice && $value == $dato) {
						return $key;
					}
				}
			}
		}

		return FALSE;
	}
}

if ( ! function_exists('redondear')) {
	function redondear($numero, $decimales = 2)
	{
		$ci =& get_instance();

		$numero = ($numero) ? $numero : 0;

		return $ci->db
				  ->query("SELECT round({$numero}, {$decimales}) AS numero")
				  ->row()
				  ->numero;
	}
}

if ( ! function_exists("result_array")) {
	function result_array($result, $campo)
	{
		$datos = array();

		foreach ($result as $row) {
			$datos[] = $row->$campo;
		}

		return $datos;
	}
}

if ( ! function_exists('url_infile')) {
	function url_infile($cae)
	{
		return "https://www.ingface.net/Ingfacereport/dtefactura.jsp?cae={$cae}";
	}
}

if ( ! function_exists('enviarJson'))
{
	/**
	 * Recibe un arreglo de datos y devuelve un archivo de cabecera json, 
	 * ideal para retornar en peticiones ajax
	 * @param  array $args arreglo de datos
	 * @return json
	 */
	function enviarJson($datos)
	{
		header('Content-type: application/json');
		echo json_encode($datos);
	}
}

if ( ! function_exists('link_script'))
{
	/**
	 * Link
	 *
	 * Generates link to a CSS file
	 *
	 * @param	mixed	stylesheet srcs or an array
	 * @param	string	type
	 * @param	string	title
	 * @param	string	media
	 * @param	bool	should index_page be added to the css path
	 * @return	string
	 */
	# function link_script($src = '', $type = 'text/javascript', $index_page = FALSE)
	function link_script($src, $print = FALSE)
	{
		if ( $print ) {
			$link = "<script type='text/javascript'>\n" . file_get_contents(FCPATH . $src) . "\n</script>\n";
		} else {
			$CI =& get_instance();
			$link = '<script type="text/javascript" ';

			if (preg_match('#^([a-z]+:)?//#i', $src))
			{
				$link .= 'src="'.$src.'" ';
			}
			else
			{
				$link .= 'src="'.$CI->config->slash_item('base_url').$src.'" ';
			}

			$link .= "></script>\n";
		}

		return $link;
	}
}

if ( ! function_exists('url_assets')) {
	function url_assets($ruta)
	{
		return base_url('/assets/' . basename($_SERVER['SCRIPT_NAME'], '.php') . '/' . $ruta);
	}
}

if (!function_exists('verPropiedad')) {
	function verPropiedad($clase, $propiedad, $return=false)
	{
		if (property_exists($clase, $propiedad) && 
			!empty($clase->$propiedad)) {
			
			return $clase->$propiedad;
		}

		return $return;
	}
}