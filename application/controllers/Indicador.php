<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicador extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type("application/json");
	}

	public function index()
	{
		die("forbidden");
	}

	public function buscar()
	{
		$this->output->set_output(json_encode([
			"actividades" => $this->Abuscar_model->getActividad($_GET)
		]));
	}

}

/* End of file Indicador.php */
/* Location: ./application/atlas/controllers/Indicador.php */