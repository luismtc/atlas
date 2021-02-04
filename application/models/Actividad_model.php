<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actividad_model extends Especifico_model {
	public $actividad = null;
	private $tabla = "atlas.actividad";

	public function setActividad($valor, $codigo=false)
	{
		if ($codigo) {
			$this->db->where('actividad', $valor);
		} else {
			$this->db->where('id', $valor);
		}
		
		$this->actividad = $this->db
		->select("*, if(date(entrega) <= compromiso, 1, 0) as cumple", false)
		->get($this->tabla)
		->row();

		$this->setEspecifico($this->actividad->especifico_id);
	}

	public function guardarActividad($args=array())
	{
		$data = $this->getData($this->tabla, $args);

		if (isset($data->actividad)) {
			unset($data->actividad);
		}

		if (isset($data->id)) {
			unset($data->id);
		}

		if ($this->actividad === null) {
			$this->db
				 ->set("usuario", $this->session->atlas_user["id"])
				 ->set("actividad", "uuid_short()", false)
				 ->set("especifico_id", $this->especifico->id)
				 ->insert($this->tabla, $data);

			if ($this->db->affected_rows() > 0) {
				$this->setActividad($this->db->insert_id());
				$this->avanceEspecifico();

				$usu = $this->conf->getUsuario([
					"uno" => true,
					"usuario" => $this->session->atlas_user["id"]
				]);

				/* if ($args->notificar) {
					gcorreo([
						"token" => $usu->google_token,
						"para" => $this->getActividadResponsable()->correo,
						"asunto" => "Asignación de actividad # {$this->producto->titulo}",
						"cuerpo" => $this->load->view('atlas/actividad/notificar', ["act" => $this], true)
					]);
				}*/

				return true;
			}
		} else {
			$this->db
				 ->where("id", $this->actividad->id)
				 ->where("especifico_id", $this->especifico->id)
				 ->update($this->tabla, $data);

			if ($this->db->affected_rows() > 0) {
				$this->setActividad($this->actividad->id);
				$this->avanceEspecifico();
				return true;
			}
		}

		return false;
	}

	public function getActividadResponsable()
	{
		return $this->conf->get_usuario([
			"uno" => true,
			"usuario" => $this->actividad->responsable
		]);
	}

	public function setBitacora($args = [])
	{
		$this->db
			 ->set("usuario", $this->session->atlas_user["id"])
			 ->set("actividad_id", $this->actividad->id)
			 ->insert("atlas.bitacora", $args["datos"]);

		$tmp = $this->db->affected_rows() > 0;

		if ($tmp && $args["datos"]["accion_id"] < 4 && !empty($this->producto->chat_webhook)) {
			$usu = $this->conf->getUsuario([
				"uno" => true,
				"id" => $this->session->atlas_user["id"]
			]);

			$txt = ["text" => "{$usu->nombre} ha comentado: {$this->producto->titulo} > {$this->especifico->descripcion} > {$this->actividad->subtitulo}:\n" . $args["datos"]["comentario"]];
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->producto->chat_webhook);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($txt)); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain')); 
			curl_exec($ch);
			curl_close($ch);
		}

		return $tmp;
	}

	public function getBitacora($args=array())
	{
		return $this->db
					->select("
						a.id,
						a.fecha, 
						a.comentario,
						a.user_picture,
						a.responde,
						b.descripcion as naccion, 
						c.nombre,
						c.apellidos,
						c.usuario as nalias")
					->from("atlas.bitacora a")
					->join("atlas.accion b", "b.id = a.accion_id")
					->join("atlas.usuario c", "c.id = a.usuario")
					->where("a.actividad_id", $this->actividad->id)
					->get()
					->result();
	}

	public function getActividad()
	{
		return $this->Abuscar_model->getActividad([
			"id" => $this->actividad->id,
			"uno" => true
		]);
	}

}

/* End of file Actividad_model.php */
/* Location: ./application/atlas/models/Actividad_model.php */