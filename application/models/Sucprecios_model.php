<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucprecios_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "sucprecios";
		$this->PRI_INDEX = "id_precio";
	}

}

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */