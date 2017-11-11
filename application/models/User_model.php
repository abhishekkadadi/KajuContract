<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {

 public function userSignUp(){
 	 		$userName = $_POST['userName'];
		        $userEmail = $_POST['userEmail'];
		        $userContact = $_POST['userContact'];
		        $userPassword = $_POST['userPassword'];
                	$userType=$_POST['userType'];
               		$userCity=$_POST['userCity'];
               		$userAddress=$_POST['userAddress'];
               		$userTurnover=$_POST['userTurnover'];
               		$userTuroverMonth=$_POST['userTuroverMonth'];
               		
               		
		         
		        $checkemail=$this->checkAlreadyEmail($userEmail);

		        if($checkemail==1){
			        		return 'emailPresent';
			        	}else{
			        		$data=array(
							    		'userName'=> $userName,
							    		'userEmail'=> $userEmail,
							    		'userContact'=> $userContact,
							    		'userPassword'=> $userPassword,
							    		'userCity'=>$userCity,
							    		'userAddress'=>$userAddress,
							    		'userTurnover'=>$userTurnover,
							    		'userTuroverMonth'=>$userTuroverMonth,
							    		'userType'=>$userType
							    	
	                                   );
				        			
								    $this->db->insert('user', $data);
									if($this->db->affected_rows() == 1){
										return $this->db->insert_id();
									}else{
										return false;
									}	
			        	}

 }//userSignUp
 
 public function checkAlreadyEmail($email){
             		$this->db->where('userEmail',$email);
				    $query = $this->db->get('user');
				    if ($query->num_rows() > 0){
				        return true;
				    }
				    else{
				        return false;
				    }
 }//checkAlreadyEmail

 public function Login()
                { 
                	$userEmail=$_POST['userEmail'];
                	$userPassword=$_POST['userPassword'];
                	$token=$_POST['token'];
                	$query=$this->db->get_where('user',array('userEmail'=>$userEmail,'userPassword'=>$userPassword));
                    if($query->num_rows()==1){
                    	foreach ($query->result_array() as $key) {
                    		  $userId=$key['userId'];
                    		  $isVerified=$key['isVerified'];
                    	}//foreach
                    	if($isVerified==1){
                    	$this->db->where('userId',$userId);
                    	$data=array('token'=>$token);
                    	$this->db->update('user',$data);
                        return $query->result_array();
                    }else{
                    	return 'noverify';
                    }
                    }else{
                    	return false;
                    }
                  
                }//Login
    
    public function AddChatId(){
                    $userId=$_POST['userId'];
                    $chatId=$_POST['chatId'];
                    $this->db->where('userId',$userId);
                    $data=array('chatId'=>$chatId);
                    $this->db->update('user',$data);
                    return ($this->db->affected_rows() != 1) ? false : true;   
                }//AddChatId
                
                public function updateWeeklyRate(){                   
                    $rate=$_POST['rate'];
                    $this->db->where('id','1');
                    $data=array('rate'=>$rate);
                    $this->db->update('adminKajuRatetbl',$data);
                    return ($this->db->affected_rows() != 1) ? false : true;   
                }//updateWeeklyRate

    public function editUser(){
                    
                    $userId=$_POST['userId'];
                    
                        $data=array(
                                'userName'=>$_POST['userName'],
                                'userContact'=>$_POST['userContact'],
				'userAddress'=>$_POST['userAddress'],
				'userCity'=>$_POST['userCity'],
				'userTurnover'=>$_POST['userTurnover'],
				'userTuroverMonth'=>$_POST['userTuroverMonth']
                                );
                        
                          //  $data['userAddress']=$_POST['userAddress'];
                       
                        $this->db->where('userId',$userId);
                        $this->db->update('user',$data);
                   
                    return ($this->db->affected_rows() != 1) ? false : true;   
                }//editUser
                
                
               


     	public function displayContractors(){
                    $userId=$_POST['userId'];
                    $packageId=$this->getPackageId($userId);
                    $this->db->select('s.*');
                    $this->db->from('supplier as s');
                    $this->db->join('displaysetsuppliers as ds','ds.supplierId=s.supplierId');
                    $this->db->where('ds.packageId',$packageId);
                    return $this->db->get()->result_array();
                }//displayContractors
                

 	public function viewedSuppliers(){
 		    $userType=$_POST['userType'];
                    $userId=$_POST['userId'];
                    $supplierId=$_POST['supplierId'];
                    
                    $query=$this->db->get_where('viewedsuppliers',array('userId'=>$userId,'supplierId'=>$supplierId,'userType'=>$userType));
                    if($query->num_rows()==1){
                      return true;   
                    }else{
                      $data=array('userId'=>$userId,'supplierId'=>$supplierId,'userType'=>$userType);
                      $this->db->insert('viewedsuppliers',$data);
                      return ($this->db->affected_rows() != 1) ? false : true;   
                    }
                    
                    
                   
                }//viewedSuppliers

 	public function checkSuppliers(){
                    $userId=$_POST['userId'];
                    $userType=$_POST['userType'];
                    $packageId=$this->getPackageId($userId);
                    $data=$this->getViewedids($userId,$userType);
                    $this->db->select('s.*');
                    $this->db->from('user as s');
                    $this->db->join('displaysetsuppliers as ds','ds.supplierId=s.userId');
                    $this->db->where('ds.packageId',$packageId);
                    $this->db->where('ds.userType',$userType);
                    if(!empty($data)){
                    $this->db->where_not_in('ds.supplierId', $data);
                    }
                    return $this->db->get()->result_array();
                }//checkSuppliers

 	public function fetchViewedSupplier(){
                    $userId=$_POST['userId'];
                    $userType=$_POST['userType'];
                    $this->db->select('s.*');
                    $this->db->from('user as s');
                    $this->db->join('viewedsuppliers as vs','vs.supplierId=s.userId');
                    $this->db->where('vs.userId',$userId);
                    $this->db->where('vs.userType',$userType);
                    return $this->db->get()->result_array();
                }//fetchViewedSupplier

	public function getViewedids($userId,$userType){
       $query=$this->db->get_where('viewedsuppliers',array('userId'=>$userId,'userType'=>$userType));
       $data1=array();
        foreach($query->result_array() as $row)
       {
        $data1[] = $row['supplierId']; // add each user id to the array
       }
    return $data1;
}//getViewedids

	public function getPackageId($userId){
       $query=$this->db->get_where('user',array('userId'=>$userId));
       foreach ($query->result_array() as $key) {
               $packageId=$key['packageId'];
       }
       return $packageId;
}//getPackageId


	public function catlogAdd(){
                    $productName=$_POST['productName'];
                    $productAmount=$_POST['productAmount'];
                    $userId=$_POST['userId'];
                    if(isset($_FILES['url1'])){

                        if(!empty($_FILES['url1'])){

                            $url1="url1";
                            $path1=$this->do_upload($url1); 
                             
                        }
                    }

            $data=array(
                            'productName'=> $productName,
                            'productAmount'=>$productAmount,
                            'userId'=> $userId  
                        );

                    if(isset($path1)){
                        if($path1=='0'){return "uploadfail";}
                        else{$data['url1']=base_url("/catlog_pic/$path1");}
                    }   
                    $this->db->insert('catlog', $data);
                     return ($this->db->affected_rows() >= 1) ? true : false;
                }//catlogAdd

          public function do_upload($url)
        {
                $config['upload_path']          = './catlog_pic/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100000;
                $config['max_width']            = 2048;
                $config['max_height']           = 2048;
                $this->load->library('upload', $config);
                $new_name = uniqid().$_FILES[$url]['name'];
                $config['file_name'] = $new_name;
                if (!$this->upload->do_upload($url))
                {      

                        $error = array('error' => $this->upload->display_errors());
                        //print_r($error);
                        return '0';
                        //$this->load->view('upload_form', $error);
                }
                else
                {      
                        $data = array('upload_data' => $this->upload->data());
                        return $data['upload_data']['file_name'];
                       //print_r($data);
                }
               
        }//do_upload
        
       
      public function viewCatlog(){
                    $query=$this->db->get_where('catlog',array('userId'=>$_POST['userId'],'isApporov'=>'1'));
                    return $query->result_array();
                }//viewCatlog
                
      public function viewCatlogForAdmin(){
                    $query=$this->db->get_where('catlog',array('isApporov'=>'0'));
                    return $query->result_array();
                }//viewCatlogForAdmin
                
            public function getKajuRate(){
                    $query=$this->db->get_where('adminKajuRatetbl',array('id'=>'1'));
                    return $query->result_array();
                }//getKajuRate
                     
                public function viewuserTypeCount(){                    
                   $this->db->select('count(*) as one');
                   $this->db->from('user');
                   $this->db->where('userType','1');
                   $query = $this->db->get();
                   return $query->result_array();
                }//viewuserTypeCount
                
                public function viewuserTypeCountTwo(){                    
                   $this->db->select('count(*) as two');
                   $this->db->from('user');
                   $this->db->where('userType','2');
                   $query = $this->db->get();
                   return $query->result_array();
                }//viewuserTypeCountTwo
                
                public function viewuserTypeCountThree(){                    
                   $this->db->select('count(*) as three');
                   $this->db->from('user');
                   $this->db->where('userType','3');
                   $query = $this->db->get();
                   return $query->result_array();
                }//viewuserTypeCountThree
                
                
      
      public function catlogProductRemove(){
                    $productId=$_POST['productId'];
                    $this->db->where('productId',$productId);
                    if($this->db->delete('catlog')){
                        return true;
                    }else{
                        return false;
                    }
                }//catlogProductRemove
                
                public function catlogAdminProductApproveRemove(){
                    $productId=$_POST['productId'];
                    $Flag=$_POST['Flag'];
                    if($Flag == "2"){
	                    $this->db->where('productId',$productId);
	                    if($this->db->delete('catlog')){
	                        return "1";
	                    }else{
	                        return "2";
	                    }
                    }
                    if($Flag == "1"){
                        $this->isApporov= '1';
	                $this->db->where('productId', $productId);
	                $this->db->update('catlog', $this);
	                if($this->db->affected_rows()){
	                        return "3";
	                    }else{
	                        return "4";
	                    }	              
                    }
                }//catlogAdminProductApproveRemove
                
                
       public function check_old_password()
                {
                   
                   $query = $this->db->get_where('user',array('userId'=>$_POST['userId']));
                   return $query->result();
                }

                 public function change_password()
                {

                $this->userPassword = $_POST['password']; // please read the below note
                $this->db->where('userId', $_POST['userId']);
                $this->db->update('user', $this);
                return ($this->db->affected_rows() != 1) ? false : true;
                }
                
                public function GetPassword(){

                $userEmailNumber=$_POST['userEmail'];
            	$query = $this->db->get_where('user',array('userEmail'=>$userEmailNumber));
		return $query->result();
             	}//ForgotPassword


}//User_model

?>