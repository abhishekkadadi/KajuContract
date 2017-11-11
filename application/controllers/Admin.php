<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
   
   Public function AdminLogin(){
   	$this->load->model('Admin_model');
   	$data=$this->Admin_model->Login();
   	$adminData=array();
   	if($data){
   			  foreach ($data as $key) {
                    		  $loginId=$key['loginId'];
                    		  $name=$key['name'];
                    		  $userName=$key['userName'];
                    	}//foreach
              $userdata['status']=success_login();
              $userdata['data']=array('loginId'=>$loginId,'name'=>$name,'userName'=>$userName);
	 		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
   	}else{

	 		 $userdata['status']=failed_login();
	 		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
   	}
   }//adminlogin
   
    public function AddSupplier(){
    $supplierName = $_POST['supplierName'];
    $supplierEmail = $_POST['supplierEmail'];
    $this->load->model('Admin_model');
    $data=$this->Admin_model->AddSupplier();

    if($data === 'emailPresent')
          {
             $userdata['status']=email_present();
             $this->output->set_content_type('application/json')->set_output(json_encode($userdata));  
          }else if($data){
                $userId=urlencode(base64_encode($data));
                $result['sitelink']= site_url("Verifymail/Verifysupplier/$userId");
                $result['email']=$supplierEmail;
                $result['name']=$supplierName;
                $template='userverify';          
                $send_mail=sendMail($result,$template); 
                $userdata['status']=success_register();
                $userdata['data']=array('supplierId'=>$data);
                $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
          }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               }

   }//AddSupplier
   
 public function AddChatId(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->AddChatId();
    if($data){
               $final_data['status']=success_update();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
              $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }

   }//AddChatId
   
   
 public function AddPackage(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->AddPackage();
    if($data){
               $final_data['status']=success_insert();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
  }//AddPackage
  
 public function displayPackages(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->displayPackages();
    if($data){
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
  }//displayPackages
  
 public function updatePackage(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->updatePackage();
    if($data){
               $final_data['status']=success_update();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
  }//updatePackage
  
  
  public function supplierList(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->supplierList();
    if($data){
               unset($data[0]['userPassword']);
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
  }//supplierList
  
  
  public function userList(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->userList();
    if($data){
               unset($data[0]['userPassword']);
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
  }//userList
  
  
  public function attachPackage(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->attachPackage();
    if($data){
            
               $final_data['status']=success_packageupdate();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
  }//attachPackage
  
  public function setSupplier(){
  $this->load->model('Admin_model');
  $data=$this->Admin_model->setSupplier();
  if($data){
               $final_data['status']=success_setsupplier();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));   
  }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data)); 
  }
 }//setSupplier
 
public function addMachine(){
  $this->load->model('Admin_model');
  $data=$this->Admin_model->addMachine();

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

}//addMachine

public function machineList(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->machineList();
    if($data){
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }

}//machineList

public function machineRemove(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->machineRemove();
    if($data){
               $final_data['status']=delete();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//machineRemove

public function addBanner(){
  $this->load->model('Admin_model');
  $data=$this->Admin_model->addBanner();

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

}//addBanner


public function adsShow(){
    $this->load->model('Admin_model');
    $data1=$this->Admin_model->adsShowGetSmallads();
    $data2=$this->Admin_model->adsShowGetBigads();
  
               $final_data['status']=success_fetch();
               $final_data['smallads']=$data1;
               $final_data['bigads']=$data2;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    
}//adsShow

public function adsRemove(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->adsRemove();
    if($data){
               $final_data['status']=delete();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//adsRemove

public function fetchSmallAds(){
   $this->load->model('Admin_model');
    $data=$this->Admin_model->fetchSmallAds();
    if($data){
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//fetchSmallAds


public function fetchBigAds(){
   $this->load->model('Admin_model');
    $data=$this->Admin_model->fetchBigAds();
    if($data){
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//fetchSmallAds


//raw materialsssssssssssssssssssssssssssssssssssssss

public function addRawMaterial(){
  $this->load->model('Admin_model');
  $data=$this->Admin_model->addRawMaterial();

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

}//addRawMaterial

public function RawMaterialList(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->RawMaterialList();
    if($data){
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//RawMaterialList

public function RawMaterialRemove(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->RawMaterialRemove();
    if($data){
               $final_data['status']=delete();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//RawMaterialRemove


//offerss

public function addOffer(){
  $this->load->model('Admin_model');
  $data=$this->Admin_model->addOffer();

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

}//addOffer

public function offerList(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->offerList();
    if($data){
               $final_data['status']=success_fetch();
               $final_data['data']=$data;
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//OfferList

public function offerRemove(){
    $this->load->model('Admin_model');
    $data=$this->Admin_model->offerRemove();
    if($data){
               $final_data['status']=delete();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
               $final_data['status']=failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }
}//OfferRemove

 
}
?>