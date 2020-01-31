<?php

/**
 * 
 */
class Inicio 
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function verificarSesion() {
		$tmp = explode("/", $_SERVER["REQUEST_URI"]);

		if (isset($tmp[3]) && $tmp[3] === "sesion") {
			return TRUE;
		} else {
			if ($this->CI->session->has_userdata('atlas_user')) {
				return TRUE;
			} else {
				redirect('sesion/iniciar');
			}
		}
	}
}