<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {

	public function userSignUp(){
		$userName = $_POST['userName'];
		$userEmail = $_POST['userEmail'];
		$this->load->model('User_model');
		$data=$this->User_model->userSignUp();
		 if($data === 'emailPresent')
          {
             $userdata['status']=email_present();
             $this->output->set_content_type('application/json')->set_output(json_encode($userdata));  
          }else if($data){
                $userId=urlencode(base64_encode($data));
                $result['sitelink']= site_url("Verifymail/Verifyuser/$userId");
                $result['email']=$userEmail;
                $result['name']=$userName;
                $template='userverify';          
                //$send_mail=sendMail($result,$template); 
                $userdata['status']=success_register();
                $userdata['data']=array('userId'=>$data);
             $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
          }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               }

	}//AduserSignUpdUser

 Public function UserLogin(){
      
	   	$this->load->model('User_model');
	   	$data=$this->User_model->Login();
	   	if($data==='noverify'){
	   			$userdata['status']=verify_needed();
	   			$this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	   	}else if($data){
	   			  
	              $userdata['status']=success_login();
                foreach ($data as $key) {
                  $userId=$key['userId'];
                  $userName=$key['userName'];
                  $userEmail=$key['userEmail'];
                  $userContact=$key['userContact'];
                  $token=$key['token'];
                  $chatId=$key['chatId'];
                  $timeStamp=$key['timeStamp'];
                  $packageId=$key['packageId'];
                  $isVerified=$key['isVerified'];
                  $userType=$key['userType'];
                  $userCity=$key['userCity'];
                  $userTurnover=$key['userTurnover'];
                  $userTuroverMonth=$key['userTuroverMonth'];
                  $userAddress=$key['userAddress'];
                  

                  $userdata['data']=array('userId'=>$userId,'userName'=>$userName,'userEmail'=>$userEmail,'userContact'=>$userContact,'token'=>$token,'chatId'=>$chatId,'timeStamp'=>$timeStamp,'packageId'=>$packageId,'isVerified'=>$isVerified,'userType'=>$userType,'userCity'=>$userCity,'userTurnover'=>$userTurnover,'userAddress'=>$userAddress,'userTuroverMonth'=>$userTuroverMonth);
                }
              
	              
            //print_r($data);  
		 		  $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	   	}else{

		 		 $userdata['status']=failed_login();
		 		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	   	}
   }//UserLogin


   public function AddChatId(){
    $this->load->model('User_model');
    $data=$this->User_model->AddChatId();
    if($data){
               $final_data['status']=success_update();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
              $final_data['status']=failed();
              $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
   }//AddChatId

   public function editUser(){
    $this->load->model('User_model');
    $data=$this->User_model->editUser();
    if($data){
               $final_data['status']=success_update();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
              $final_data['status']=failed();
              $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
   }//editUser

   
   public function displayContractors(){
    $this->load->model('User_model');
    $data=$this->User_model->fetchViewedSupplier();
    $data2=$this->User_model->checkSuppliers();   
    if(!empty($data2) || !empty($data)){
             $final_data['status']=success_fetch();
             unset($data2[0]['supplierPassword']);
             unset($data[0]['supplierPassword']);
             $final_data['notviewed']=$data2;
             $final_data['viewed']=$data;
             $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
              $final_data['status']=no_data();
              $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
    
   }//displayContractors

  public function viewedSuppliers(){
    $this->load->model('User_model');
    $data=$this->User_model->viewedSuppliers();
    if($data){
               $final_data['status']=success_insert();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
              $final_data['status']=failed();
              $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
   }//viewedSuppliers

  
   public function catlogAdd(){
    $this->load->model('User_model');
    $data=$this->User_model->catlogAdd();
    
  if($data==='uploadfail'){

       $final_data['status']=failed();
       $this->output->set_content_type('application/json')->set_output(json_encode($final_data));  
    }else if($data){
               $final_data['status']=success_insert();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
              $final_data['status']=failed();
              $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
  }//catlogAdd

 public function viewCatlog(){
    $this->load->model('User_model');
    $data=$this->User_model->viewCatlog();
    if($data){
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//viewCatlog


 public function viewCatlogForAdmin(){
    $this->load->model('User_model');
    $data=$this->User_model->viewCatlogForAdmin();
    if($data){
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//viewCatlog


 public function updateWeeklyRate(){
    $this->load->model('User_model');
    $data=$this->User_model->updateWeeklyRate();
    if($data){
               $final_data['status']=rate_success_update();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//viewCatlog


public function userTypeCount(){
    $this->load->model('User_model');
    $userTypeOne=$this->User_model->viewuserTypeCount();
    $userTypetwo=$this->User_model->viewuserTypeCountTwo();
    $userTypethree=$this->User_model->viewuserTypeCountThree();
    $getKajuRate=$this->User_model->getKajuRate();
    //$data=$this->User_model->viewuserTypeCount();
    if($userTypeOne){
               $final_data['status']=success_fetch();
               $final_data['userTypeOne']=$userTypeOne;
                $final_data['userTypetwo']=$userTypetwo;
                 $final_data['userTypethree']=$userTypethree;
                 $final_data['getKajuRate']=$getKajuRate;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//userTypeCount

 public function catlogProductRemove(){
    $this->load->model('User_model');
    $data=$this->User_model->catlogProductRemove();
    if($data){
               $final_data['status']=delete();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//catlogProductRemove


public function catlogAdminProductApproveRemove(){
    $this->load->model('User_model');
    $data=$this->User_model->catlogAdminProductApproveRemove();
    if($data =="1"){
               $final_data['status']=delete();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
    if($data =="2"){
                $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
    if($data =="3"){
               $final_data['status']=update();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
     if($data =="4"){
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
   
}//catlogAdminProductApproveRemove


public function changePassword() {
          $this->load->model('User_model');
          $result=$this->User_model->check_old_password();
        foreach ($result as $row){
        $old_pass=$row->userPassword;
        }
       
        $old_pass_check=$_POST['old_password'];
        if($old_pass_check==$old_pass){
          $result=$this->User_model->change_password();
          $final_data['status']=passwordChanged();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
      }else{
        $final_data['status']=passwordNotMatched();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
      }
     
  }//change_password
  
  
  public function ForgotPassword(){
    $this->load->model('User_model');
    $data=$this->User_model->GetPassword();
    if($data){
              foreach ($data as $key) {
                $userName=$key->userName;
                $userPassword=$key->userPassword;
                $userEmail=$key->userEmail;
                $result['userPassword']=$userPassword;
                $result['name']=$userName;
              }
                $html=$this->load->view('forgotpassword', $result, true);

                $this->load->library('email');
               /* $this->email->initialize(array(
                                                 'protocol' => 'smtp',
                                                'smtp_host' => 'smtp.sendgrid.net',
                                                'smtp_user' => 'akadadi',
                                                  'smtp_pass' => 'danger44',
                                                'smtp_port' => 587,
                                                'crlf' => "\r\n",
                                                'newline' => "\r\n"
                                              ));*/
              $this->email->set_mailtype("html");
              $this->email->from('info@whitecode.co.in', 'CashewIndia');
              $this->email->to($userEmail);
              $this->email->subject('Cashew India App Password Request');
              $this->email->message($html);
               if($this->email->send()){
                $final_data['status']=mail_sent();
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               
              }else{
                $final_data['status']=mail_failed();
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               
              }
              
    }else{
            $final_data['status']=nodata_fetch();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
  }//ForgotPassword
}//User
?>