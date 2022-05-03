<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EntTxt_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "entTxt";
		$this->PRI_INDEX = "id_entrada";
	}
}