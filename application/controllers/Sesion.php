<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesion extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	public function iniciar()
	{
		if ($_SERVER["REQUEST_METHOD"] === 'POST') {
			if ($this->input->post('password') && $this->input->post('username')) {
				$usr = $this->conf->getUsuario([
					"usuario" => $_POST["username"],
					"activo" => 1,
					"uno" => true
				]);

				if ($usr && password_verify($_POST["password"], $usr->clave)) {
					$this->session->set_userdata(["atlas_user" => [
						"id" => $usr->id,
						"nombre" => $usr->nombre,
						"correo" => $usr->correo,
						"usuario" => $usr->usuario,
						"apellidos" => $usr->nombre
					]]);

					redirect('proyecto');
				}
			}
		}

		$this->load->view('sesion/login');
	}

	public function salir()
	{
		session_destroy();
		redirect('sesion/iniciar');
	}

}

/* End of file Sesion.php */
/* Location: ./application/atlas/controllers/Sesion.php */