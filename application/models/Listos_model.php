<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listos_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "listos";
		$this->PRI_INDEX = "id_listo";
	}

}