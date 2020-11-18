<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conf_model extends CI_Model {

	public function getProducto($args=[])
	{
		if (verDato($args, "titulo")) {
			$this->db->like('titulo', $args["titulo"]);
		}

		if (isset($args["pendientes"]) && $args["pendientes"] == 'true') {
			$this->db->where('a.avance < ', 100);
		}

		if (isset($args["producto"])) {
			$this->db->where("a.producto", $args["producto"]);
		}
		
		return $this->db
		->select("
			a.fecha, 
			a.titulo, 
			a.descripcion, 
			a.producto, 
			a.avance, 
			b.usuario as nresponsable, 
			c.usuario as npropietario")
		->from("atlas.producto a")
		->join("atlas.usuario b", "b.id = a.responsable")
		->join("atlas.usuario c", "c.id = a.propietario")
		->get()
		->result();
	}

	public function getUsuario($args = [])
	{
		if (isset($args["id"])) {
			$this->db->where("a.id", $args["id"]);
		}

		if (isset($args["usuario"])) {
			$this->db->where("a.usuario", $args["usuario"]);
		}

		if (isset($args["activo"])) {
			$this->db->where('a.activo', $args["activo"]);
		}

		if (isset($args["uno"])) {
			$this->db->limit(1);
		}

		$tmp = $this->db->get("atlas.usuario a");

		if (isset($args["uno"])) {
			return $tmp->row();
		} else {
			return $tmp->result();
		}
	}

	public function getAccion($args = [])
	{
		if (isset($args["id"])) {
			$this->db->where("a.id", $args["id"]);
		}

		$tmp = $this->db->get("atlas.accion a");

		if (isset($args["uno"])) {
			return $tmp->row();
		} else {
			return $tmp->result();
		}
	}

}

/* End of file Seguimiento_model.php */
/* Location: ./application/atlas/models/Seguimiento_model.php */