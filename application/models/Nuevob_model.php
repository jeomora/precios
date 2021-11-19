<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nuevob_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "nuevo_b";
		$this->PRI_INDEX = "id_nuevo";
	}

}

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */