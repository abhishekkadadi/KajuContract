<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 function success_login(){
	$status=1;
	return array('status'=>$status,'message'=>'Successful login');	
}

 function failed_login(){
	$status=0;
	return array('status'=>$status,'message'=>'Fail to login');	
}

function email_present(){
	$status=-1;
	return array('status'=>$status,'message'=>'Email already registered');	
}
function success_register(){
	$status=1;
	return array('status'=>$status,'message'=>'Registered successfully. Please check email');	
}

function failed(){
	$status=0;
	return array('status'=>$status,'message'=>'Oops! Something went wrong');	
}

function verify_needed(){
	$status=-1;
	return array('status'=>$status,'message'=>'Email not verified');	
}
function success_update(){
	$status=1;
	return array('status'=>$status,'message'=>'Successfully updated');
}

function rate_success_update(){
	$status=1;
	return array('status'=>$status,'message'=>'Rate updated successfully');
}

function success_insert(){
	$status=1;
	return array('status'=>$status,'message'=>'Data inserted');
}
function success_fetch(){
	$status=1;
	return array('status'=>$status,'message'=>'Data fetched');
}

function success_packageupdate(){
	$status=1;
	return array('status'=>$status,'message'=>'User package updated.');
}

function success_setsupplier(){
	$status=1;
	return array('status'=>$status,'message'=>'New suppliers list successfully set.');
}

function no_data(){
	$status=0;
	return array('status'=>$status,'message'=>'No data present.');
}

function delete(){
	$status=1;
	return array('status'=>$status,'message'=>'Data deleted successfully.');
}

function update(){
	$status=1;
	return array('status'=>$status,'message'=>'Data updated successfully.');
}


function passwordChanged(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Password Changed');
				return $message;
}

function mail_sent(){
	$status=1;
	return array('status'=>$status,'message'=>'Mail sent');
}

function mail_failed(){
	$status=0;
	return array('status'=>$status,'message'=>'Mail sending failed');
}

function passwordNotMatched(){
				$notverify=0;
				$message=array('status'=>$notverify,'message'=>'Password did not match');
				return $message;
}
?>