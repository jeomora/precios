<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagenes extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Grupos_model", "grupo_md");
		$this->load->model("Avatars_model", "ava_md");
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("Productos_model", "prod_md");
		$this->load->model("Cajas_model", "caja_md");
		$this->load->model("Lineas_model", "ln_md");
		$this->load->model("Nuevos_model", "new_md");
		$this->load->model("Imagenes_model", "img_md");
		$this->load->model("Ofertas_model", "ofe_md");
		$this->load->library("form_validation");
	}

	public function index(){
		$data['scripts'] = [
			'/scripts/Imagenes/index',
		];
		$data["ofertones"] = $this->ofe_md->getActivas(NULL);
		$this->estructura("Imagenes/index", $data);
	}

	public function altaImagen(){
		$values = $this->input->post("values");
		$busca = json_decode($values);
		$new_vela=[
					"imagen"	 	=>	$busca->imagen,
					"id_producto"	=>	$busca->id_producto
				];
		$resu = $this->img_md->get(NULL,["id_producto"=>$busca->id_producto])[0];
		if ($resu) {
			$facturas = $this->img_md->update($new_vela,["id_producto"=>$resu->id_image]);
		} else {
			$facturas = $this->img_md->insert($new_vela);
		}
		
		$this->jsonResponse($busca);
	}

	public function resizeImage($filename){
		$source_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/uploads/productos/' . $filename;
		$target_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/uploads/productos/';
		list($width, $height, $type, $attr) = getimagesize($source_path);
		if ($width > $height) {
			$config_manip = array(
		      'image_library' => 'gd2',
		      'source_image' => $source_path,
		      'new_image' => $target_path,
		      'create_thumb' => TRUE,
		      'maintain_ratio' => TRUE,
		      'width' => 550,
		  );
		}else{
			$config_manip = array(
		      'image_library' => 'gd2',
		      'source_image' => $source_path,
		      'new_image' => $target_path,
		      'create_thumb' => TRUE,
		      'maintain_ratio' => TRUE,
		      'height' => 550,
		  );
		}


		$this->load->library('image_lib', $config_manip);
		if (!$this->image_lib->resize()) {
		  echo $this->image_lib->display_errors();
		}

		$this->image_lib->clear();
   }

   	public function subirImg($id_pro){
		ini_set("memory_limit", -1);
		$prod = $this->prod_md->get(NULL,["id_producto"=>$id_pro]);
		$filen = date("dmyHis");
		$tags = "";
		$prodo = "";
		if($prod){
			$filen = $id_pro."_".$prod[0]->codigo."_".date("dmyHis");
			$prods = str_replace("?", "", $prod[0]->nombre);
			$prods = str_replace("  ", "", $prods);
			$prods = str_replace(".", "", $prods);
			$tags = $this->setTags($prods,$prod[0]->linea);
			$prodo = "".$prod[0]->nombre;
		}
		$filen = date("dmyHis");
		$config['upload_path']          = './assets/uploads/productos/';
        $config['allowed_types']        = 'jpg|jpeg|png|jfif|JPG|JPEG|PNG|JFIF';
        $config['max_size']             = 100000;
        $config['max_width']            = 100204;
        $config['max_height']           = 100204;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file_imagen',$filen);
        $path_parts = pathinfo($_FILES["file_imagen"]["name"]);
		$extension = $path_parts['extension'];
        $new_imagen = [
			"nombre"	=>	$prodo,
			"url"		=>	$filen.".".$extension,
			"tags"		=>	$tags
		];
        $imanew = $this->img_md->insert($new_imagen);
        $this->prod_md->update(["imagen"=>$imanew],["id_producto"=>$id_pro]);
        $filen2 = $filen."_thumb";
		if ($this->upload->do_upload('file_imagen',$filen2)){
			$uploadedImage = $this->upload->data();
        	$this->resizeImage($uploadedImage['file_name']);
		}
		
		$this->jsonResponse($filen.".".$extension);
	}

	public function setTags($stris,$id_pro){
		$str = explode(" ", $stris);
		$linea = $this->ln_md->get(NULL,["id_linea"=>$id_pro])[0];
		$lines = explode(" ",$linea->nombre);
		$tags = "";
		foreach ($str as $key => $value) {
			if (strlen($value) > 3) {
				$tags.=$value.",";
			}
		}
		foreach ($lines as $key => $value) {
			if (strlen($value) > 3) {
				$tags.=$value.",";
			}
		}
		$tags.="".$linea->ides;
		return $tags;
	}

	public function getProd($valo){
		$prod = $this->img_md->getImagen(NULL,$valo)[0];
		$this->jsonResponse($prod);
	}

	public function getImagesB(){
		$valo = $this->input->post("values");
		$prod = $this->img_md->getImagesB(NULL,$valo);
		$this->jsonResponse($prod);
	}


	public function saveImagen($v1,$v2){
		$prod = $this->prod_md->update(["imagen"=>$v1],["id_producto"=>$v2]);
		$this->jsonResponse($prod);
	}

	public function buscaProducto(){
		$value = $this->input->post("values");
		$prodos = $this->img_md->buscaProducto(NULL,$value);
		$this->jsonResponse($prodos);
	}
}