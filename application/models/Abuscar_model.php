<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Abuscar_model extends CI_Model {

	public function getActividad($args=[])
	{
		if (isset($args["id"])) {
			$this->db->where("a.id", $args["id"]);
		}

		if (isset($args["especifico"])) {
			$this->db->where("a.especifico_id", $args["especifico"]);
		}

		if (isset($args["producto"])) {
			$this->db->where('b.producto_id', $args["producto"]);
		}

		if (isset($args["responsable"])) {
			$res = $args["responsable"];
			$this->db->where("(a.responsable is null or a.responsable = {$res} or c.responsable = {$res})");
		}

		if (isset($args["pendiente"])) {
			$this->db->where('a.entrega IS ', "NULL", false);
		}

		if (isset($args["ifdel"])) {
			$this->db->where('a.compromiso >= ', $args["ifdel"]);
		}

		if (isset($args["ifal"])) {
			$this->db->where('a.compromiso <= ', $args["ifal"]);
		}

		if (isset($args["uno"])) {
			$this->db->limit(1);
		}

		$tmp = $this->db
					->select("
						a.fecha, 
						a.descripcion, 
						a.compromiso,
						a.horas,
						a.entrega, 
						a.especifico_id,
						if(curdate() = a.compromiso, 1, if(a.compromiso < curdate(), 2, 3)) as cuando,
						if(date(a.entrega) <= a.compromiso, 1, 0) as cumple, 
						a.actividad,
						a.responsable,
						b.descripcion as nespecifico,
						b.especifico,
						c.titulo,
						c.producto,
						d.usuario as nresponsable,
						sum(if(e.actividad_id is null, 0, 1)) comentarios", false)
					->from("atlas.actividad a")
					->join("atlas.especifico b", "b.id = a.especifico_id")
					->join("atlas.producto c", "c.id = b.producto_id")
					->join("atlas.usuario d", "d.id = a.responsable", "left")
					->join("atlas.bitacora e", "e.actividad_id = a.id", "left")
					->order_by("a.compromiso", "ASC")
					->group_by("a.id")
					->get();
		
		if (isset($args["uno"])) {
			return $tmp->row();
		} else {
			return $tmp->result();
		}
	}

}

/* End of file Abuscar_model.php */
/* Location: ./application/atlas/models/Abuscar_model.php */