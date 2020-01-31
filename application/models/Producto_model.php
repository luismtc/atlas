<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {
	public $producto = null;
	private $tabla = "atlas.producto";

	public function __construct($id = "")
	{
		parent::__construct();

		if (!empty($id)) {
			$this->setProducto($id);
		}
	}

	public function setProducto($valor, $codigo=false)
	{
		if ($codigo) {
			$this->db->where('producto', $valor);
		} else {
			$this->db->where('id', $valor);
		}
		
		$this->producto = $this->db
						  	   ->get($this->tabla)
						  	   ->row();
	}

	public function guardarProducto($args=array())
	{
		if ($this->producto === null) {
			$this->db
				 ->set("usuario", $this->session->atlas_user["id"])
				 ->set("producto", "uuid_short()", false)
				 ->insert($this->tabla, $args["datos"]);

			if ($this->db->affected_rows() > 0) {
				$this->setProducto($this->db->insert_id());
				return true;
			}
		} else {
			$this->db
				 ->where("id", $this->producto->id)
				 ->update($this->tabla, $args["datos"]);

			if ($this->db->affected_rows() > 0) {
				$this->setProducto($this->producto->id);
				return true;
			}
		}

		return false;
	}

	public function getData($tabla, $args=[])
	{
		$data = [];

		foreach ($args as $key => $value) {
			if ($this->db->field_exists($key, $tabla))
			{
				$data[$key] = $value;
			}
		}

		return $data;
	}

	public function getEspecificos()
	{
		return $this->db
		->select("producto_id, descripcion, completo, especifico, avance")
		->where("producto_id", $this->producto->id)
		->get("atlas.especifico")
		->result();
	}

	public function getActividadesProducto($args=[])
	{
		$args["producto"] = $this->producto->id;
		return $this->Abuscar_model->getActividad($args);
	}

	public function avanceProducto()
	{
		$this->guardarProducto(["datos" => ["avance" => $this->getAvance()]]);
	}

	public function getAvance($args=[])
	{
		$actividades = $this->getActividadesProducto($args);
		$cantidad = count($actividades);

		if ($cantidad > 0) {
			$pendientes = 0;

			foreach ($actividades as $row) {
				if (empty($row->entrega)) {
					$pendientes++;
				}
			}

			return (($cantidad-$pendientes)/$cantidad)*100;
		} else {
			return 0;
		}
	}

	public function getProductoResponsable()
	{
		return $this->conf->get_usuario([
			"uno" => true,
			"usuario" => $this->producto->responsable
		]);
	}
}

/* End of file Proyecto_model.php */
/* Location: ./application/atlas/models/Proyecto_model.php */