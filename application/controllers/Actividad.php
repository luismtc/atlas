<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actividad extends CI_Controller {

	public function index()
	{
		$act = new Actividad_model();
		$act->setActividad(167);
		$this->load->view('actividad/notificar', ["act" => $act]);
	}

	public function guardar($especifico, $codigo = '')
	{
		$datos = json_decode(file_get_contents('php://input'));

		$data = ["exito" => 0];
		$act = new Actividad_model();

		if (empty($codigo)) {
			$act->setEspecifico($especifico, true);
		} else {
			$act->setActividad($codigo, true);
		}

		#if ($act->producto->usuario == $this->session->atlas_user["id"]) {
			if ($act->guardarActividad($datos)) {
				$data["exito"] = 1;
				$data["actividad"] = $act->getActividad();
			} else {
				$data["mensaje"] = "Error.";
			}
		/*} else {
			$data["mensaje"] = "¿Qué hacés?";
		}*/	

		$this->output
			 ->set_content_type("application/json")
			 ->set_output(json_encode($data));
	}

	public function pendiente()
	{
		$_GET["responsable"] = $this->session->atlas_user["id"];

		$pendiente = $this->Abuscar_model->getActividad($_GET);

		$this->output
		->set_content_type("application/json")
		->set_output(json_encode($pendiente));
	}

	public function set_bitacora($actividad)
	{
		$res = ["exito" => 0];

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$datos = json_decode(file_get_contents('php://input'));

			if (isset($datos->accion)) {
				$act = new Actividad_model();
				$act->setActividad($actividad, true);

				if ($datos->accion == 2 && !in_array($this->session->atlas_user["id"], [$act->producto->responsable, $act->actividad->responsable])) {
					$res["mensaje"] = "No tiene permisos para realizar esta acción.";
				} else {
					$data = [];

					switch ($datos->accion) {
						case '2':
							$data["entrega"] = date('Y-m-d H:i:s');
							break;
						case '3':
							$data["retorno"] = 1;

							$tmp = new stdClass();
							$tmp->subtitulo = 'RETORNO: ' . $act->actividad->subtitulo;
							$tmp->responsable = $act->actividad->responsable;
							$tmp->compromiso = date('Y-m-d');
							$tmp->descripcion = $datos->comentario;

							$tmpActividad = new Actividad_model();
							$tmpActividad->setEspecifico($act->especifico->id);
							$tmpActividad->guardarActividad($tmp);

							break;
						case '4':
							$data["cerrada"] = 1;
							break;
						
						default:
							# code...
							break;
					}

					if (count($data) > 0) {
						if ($act->guardarActividad($data)) {
							$res["entrega"] = $act->actividad->entrega;
							$res["cumple"] = $act->actividad->cumple;
							$res["retorno"] = $act->actividad->retorno;
							$res["cerrada"] = $act->actividad->cerrada;
							
							$res["exito"] = 1;
						} else {
							$res["mensaje"] = "Error al guardar.";
						}
					}

					$dbit = [
						"comentario" => $datos->comentario,
						"accion_id" => $datos->accion
					];

					if (isset($datos->responde)) {
						$dbit["responde"] = $datos->responde;
					}

					if ($act->setBitacora(["datos" => $dbit])) {
						$res["bitacora"] = $act->getBitacora();
						$res["exito"] = 1;
					} else {
						$res["mensaje"] = "Error, intente nuevamente.";
					}
				}
			} else {
				$res["mensaje"] = "Acción inválida.";
			}
		} else {
			$res["mensaje"] = "Error en petición.";
		}

		$this->output
			 ->set_content_type("application/json")
			 ->set_output(json_encode($res));		
	}

	public function get_bitacora($actividad)
	{
		$act = new Actividad_model();
		$act->setActividad($actividad, true);

		$this->output
			 ->set_content_type("application/json")
			 ->set_output(json_encode($act->getBitacora()));
	}

}

/* End of file Actividad.php */
/* Location: ./application/atlas/controllers/Actividad.php */