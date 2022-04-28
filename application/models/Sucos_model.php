<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucos_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "sucos";
		$this->PRI_INDEX = "id_sucursal";
	}

}

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */