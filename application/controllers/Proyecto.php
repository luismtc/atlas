<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyecto extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('proyecto/cuerpo');
		$this->load->view('footer');
	}

	public function buscar()
	{
		$this->output
		->set_content_type("application/json")
		->set_output(json_encode([
			"productos" => $this->conf->getProducto($_GET)
		]));
	}

	public function guardar()
	{
		$data = ["exito" => 0];
		$pro = new Producto_model();

		$datos = (array)json_decode(file_get_contents('php://input'));

		if ($pro->guardarProducto(["datos" => $datos])) {
			$data["exito"] = 1;
			$data["producto"] = $pro->producto;
		}

		$this->output
			 ->set_content_type("application/json")
			 ->set_output(json_encode($data));
	}

	public function especifico()
	{
		$data = [];

		if ($this->input->get('producto')) {
			$pro = new Producto_model();
			$pro->setProducto($_GET["producto"], true);
			$data["especificos"] = $pro->getEspecificos();
			$data["fagregar"] = $pro->producto->responsable == $this->session->atlas_user["id"];
		}

		$this->output
			 ->set_content_type("application/json")
			 ->set_output(json_encode($data));
	}

	public function gespecifico($producto)
	{
		$data = ["exito" => 0];

		if ($this->input->post('descripcion')) {
			$esp = new Especifico_model();
			$esp->setProducto($producto, true);

			if ($esp->guardarEspecifico($_POST)) {
				$data["exito"] = 1;
			}
		}

		$this->output
			 ->set_content_type("application/json")
			 ->set_output(json_encode($data));
	}

	public function get_actividad($producto)
	{
		$pro = new Producto_model();
		$pro->setProducto($producto, true);

		$this->output
		->set_content_type("application/json")
		->set_output(json_encode($pro->getActividadesProducto($_GET)));
	}
}

/* End of file Proyecto.php */
/* Location: ./application/atlas/controllers/Proyecto.php */