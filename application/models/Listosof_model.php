<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listosof_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "listosOf";
		$this->PRI_INDEX = "id_listo";
	}

}