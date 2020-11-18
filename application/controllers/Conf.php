<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conf extends CI_Controller {

	public function index()
	{
		echo FCPATH;
	}

	public function get_usuarios()
	{
		$this->output
		->set_content_type("application/json")
		->set_output(json_encode([
			"usuarios" => $this->conf->getUsuario(["activo" => 1])
		]));
	}

	public function get_catalogo()
	{
		$this->output
		->set_content_type("application/json")
		->set_output(json_encode([
			"usuarios" => $this->conf->getUsuario(["activo" => 1]),
			"acciones" => $this->conf->getAccion()
		]));
	}

}

/* End of file Conf.php */
/* Location: ./application/atlas/controllers/Conf.php */