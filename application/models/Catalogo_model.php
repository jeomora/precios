<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "catalogo";
		$this->PRI_INDEX = "id_catalogo";
	}
}