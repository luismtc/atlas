<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Especifico_model extends Producto_model {
	public $especifico = null;
	private $tabla = "atlas.especifico";

	public function __construct($id = "")
	{
		parent::__construct();

		if (!empty($id)) {
			$this->setEspecifico($id);
		}
	}

	public function setEspecifico($valor, $codigo=false)
	{
		if ($codigo) {
			$this->db->where('especifico', $valor);
		} else {
			$this->db->where('id', $valor);
		}
		
		$this->especifico = $this->db
						  	     ->get($this->tabla)
						  	     ->row();

		$this->setProducto($this->especifico->producto_id);
	}

	public function guardarEspecifico($args=array())
	{
		$data = $this->getData($this->tabla, $args);

		if (isset($data["especifico"])) {
			unset($data["especifico"]);
		}

		if (isset($data["id"])) {
			unset($data["id"]);
		}

		if ($this->especifico === null) {
			$this->db
				 ->set("usuario", $this->session->atlas_user["id"])
				 ->set("especifico", "uuid_short()", false)
				 ->set("producto_id", $this->producto->id)
				 ->insert($this->tabla, $data);

			if ($this->db->affected_rows() > 0) {
				$this->setEspecifico($this->db->insert_id());
				return true;
			}
		} else {
			$this->db
				 ->where("id", $this->especifico->id)
				 ->where("producto_id", $this->producto->id)
				 ->update($this->tabla, $data);

			if ($this->db->affected_rows() > 0) {
				$this->setEspecifico($this->especifico->id);
				return true;
			}
		}

		return false;
	}

	public function getActividades()
	{
		return $this->getActividadesProducto(["especifico" => $this->especifico->id]);
	}

	public function avanceEspecifico()
	{

		$this->guardarEspecifico([
			"avance" => $this->getAvance(["especifico" => $this->especifico->id])
		]);

		$this->avanceProducto();
	}
}

/* End of file Especifico_model.php */
/* Location: ./application/atlas/models/Especifico_model.php */