<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidades_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "unidades";
		$this->PRI_INDEX = "id_unidad";
	} 
}