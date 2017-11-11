<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Verifymail extends CI_Controller {

	public function Verifyuser(){
		$last = $this->uri->total_segments();
		$record_num = $this->uri->segment($last);
		$userId=base64_decode(urldecode($record_num));
		$this->load->model('Verifymail_model');
		$data=$this->Verifymail_model->Verifyuser($userId);
		if($data){
			$this->load->view('thankyou');
		}else{
			$this->load->view('thankyou');
		}
	}//Verifyuser

public function Verifysupplier(){
		$last = $this->uri->total_segments();
		$record_num = $this->uri->segment($last);
		$userId=base64_decode(urldecode($record_num));
		$this->load->model('Verifymail_model');
		$data=$this->Verifymail_model->Verifysupplier($userId);
		if($data){
			$this->load->view('thankyou');
		}else{
			$this->load->view('thankyou');
		}
	}//Verifyuser

	

}