<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "inventario";
		$this->PRI_INDEX = "id_inventario";
	}
}