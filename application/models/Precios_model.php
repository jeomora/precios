<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precios_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "precios";
		$this->PRI_INDEX = "id_precio";
	}

}

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */