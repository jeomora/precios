<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalTxt_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "salTxt";
		$this->PRI_INDEX = "id_salida";
	}
}