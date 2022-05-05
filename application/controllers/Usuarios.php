<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("Grupos_model", "group_md");
		$this->load->library("form_validation");
	}

	public function index(){
		$data['scripts'] = [
			'/scripts/Usuarios/index'
		];
		$data["usuarios"] = $this->user_md->showUsers(NULL);
		$data["cuantos"] = $this->user_md->getCount(NULL)[0];
		$data["grupos"] = $this->group_md->get(NULL);
		$this->estructura("Usuarios/index", $data);
	}

	public function update_pass(){
		$user = $this->session->userdata();
		$antes = $this->user_md->get(NULL, ['id_usuario'=>$user["id_usuario"]])[0];
		$usuario = [
			"password"	=>	$this->encryptPassword($this->input->post('password')),
			];

		$data ['id_usuario'] = $this->user_md->update($usuario, $user["id_usuario"]);
		$cambios = [
				"id_usuario" => $user["id_usuario"],
				"fecha_cambio" => date('Y-m-d H:i:s'),
				"antes" => "Usuario cambia su contraseña ",
				"accion" => date('Y-m-d H:i:s'),
				"despues" => ""];
		$data['cambios'] = $this->cambio_md->insert($cambios);
		$mensaje = ["id" 	=> 'Éxito',
					"desc"	=> 'contraseña actualizada correctamente',
					"type"	=> 'success'];
		$this->jsonResponse($mensaje);
	}

	public function update_user33($marcoed){
		$user = $this->session->userdata();
		$usuario = [
			"imagen"	=>	$marcoed,
		];
		$avas = $this->ava_md->get(NULL,["id_avatar"=>$marcoed])[0];
		$this->session->set_userdata("imagen", $avas->nombre);
		$data ['id_usuario'] = $this->user_md->update($usuario, $user["id_usuario"]);
		$mensaje = ["id" 	=> 'Éxito',
					"desc"	=> 'Usuario actualizado correctamente',
					"type"	=> 'success'];
		$this->jsonResponse($mensaje);
	}

	public function getUsuarios(){
		$data = $this->user_md->getUsuarios(NULL);
		$this->jsonResponse($data);
	}
	public function getPassos( $cual ){
		$data = $this->user_md->get(NULL,["id_usuario"=>$cual])[0];
		$this->jsonResponse( $this->showPassword($data->password) );
	}
	public function getUser($id_usuario){
		$usuario = $this->user_md->get(NULL,["id_usuario"=>$id_usuario])[0];
		$this->jsonResponse($usuario);
	}	

	public function showpass($id_usuario){
		$usuario = $this->user_md->get(NULL,["id_usuario"=>$id_usuario])[0];
		$this->jsonResponse($this->showPassword($usuario->password));
	}
	public function delete_user(){
		$user = $this->session->userdata();
		$data ['id_usuario'] = $this->user_md->update(["estatus" => 0], $this->input->post('id_usuario'));
		$mensaje = ["id" 	=> 'Éxito',
					"desc"	=> 'Usuario eliminado correctamente',
					"type"	=> 'success'];
		$this->jsonResponse($mensaje);
	}

	public function update_user(){
		$user = $this->session->userdata();
		$antes = $this->user_md->get(NULL, ['id_usuario'=>$this->input->post('id_usuarios')])[0];
		$gr = $this->input->post('id_grupo');
		$usuario = [
			"nombre"	=>	strtoupper($this->input->post('nombre')),
			"apellido"	=>	strtoupper($this->input->post('apellido')),
			"telefono"	=>	$this->input->post('telefono'),
			"email"		=>	$this->input->post('correo'),
			"password"	=>	$this->encryptPassword($this->input->post('password')),
			"id_grupo"	=>	$this->input->post('id_grupo'),
			"id_sucursal"	=>	$this->input->post('id_sucuss'),
			"cargo"		=>	""
		];

		$data ['id_usuario'] = $this->user_md->update($usuario, $this->input->post('id_usuarios'));
		$mensaje = ["id" 	=> 'Éxito',
					"desc"	=> 'Usuario actualizado correctamente',
					"type"	=> 'success'];
		$this->jsonResponse($mensaje);
	}

	public function save_user(){
		$gr = $this->input->post('id_grupos');
		$usuario = [
			"nombre"	=>	strtoupper($this->input->post('nombres')),
			"apellido"	=>	strtoupper($this->input->post('apellidos')),
			"telefono"	=>	$this->input->post('telefonos'),
			"email"		=>	$this->input->post('correos'),
			"password"	=>	$this->encryptPassword($this->input->post('passwords')),
			"id_grupo"	=>	$this->input->post('id_grupos'),
			"id_sucursal"	=>	$this->input->post('id_sucu'),
			"cargo"		=>	""
		];

		$getUsuario = $this->user_md->get(NULL, ['email'=>$usuario['email']])[0];

		if(!$getUsuario){
			$data ['id_usuario'] = $this->user_md->insert($usuario);
			$mensaje = ["id" 	=> 'Éxito',
						"desc"	=> 'Usuario registrado correctamente',
						"type"	=> 'success'];
			$user = $this->session->userdata();
		}else{
			$mensaje = [
				"id" 	=> 'Error',
				"desc"	=> 'El correo ['.$usuario['email'].'] está registrado en el Sistema',
				"type"	=> 'error'
			];
		}
		$this->jsonResponse($mensaje);
	}
}
