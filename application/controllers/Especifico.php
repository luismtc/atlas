<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Especifico extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type("application/json");
	}

	public function index()
	{
		
	}

	public function get_actividad($esp)
	{
		$data = [];

		$pro = new Especifico_model();
		$pro->setEspecifico($esp, true);
		$data["actividades"] = $pro->getActividades();

		$this->output
		->set_output(json_encode($data));
	}

}

/* End of file Especifico.php */
/* Location: ./application/atlas/controllers/Especifico.php */