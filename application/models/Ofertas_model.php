<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ofertas_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "ofertas";
		$this->PRI_INDEX = "id_oferta";
	}

}

/* End of file Ofertas_model.php */
/* Location: ./application/models/Grupos_model.php */