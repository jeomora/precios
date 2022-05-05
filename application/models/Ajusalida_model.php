<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajusalida_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "ajusalida";
		$this->PRI_INDEX = "id_ajuste";
	}

}

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */