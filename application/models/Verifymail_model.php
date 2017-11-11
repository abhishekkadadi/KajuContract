<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Verifymail_model extends CI_Model {

	public function Verifyuser($userId){

		$data=array('isVerified'=>1);
		$this->db->where('userId',$userId);
		$this->db->update('user',$data);
		return ($this->db->affected_rows() != 1) ? false : true;  
	}//Verifyuser

	public function Verifysupplier($userId){

		$data=array('isVerified'=>1);
		$this->db->where('supplierId',$userId);
		$this->db->update('supplier',$data);
		return ($this->db->affected_rows() != 1) ? false : true;  
	}//Verifyuser


}

?>