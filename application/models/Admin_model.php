<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_model extends CI_Model {
	
	            public function Login()
                { 
                	$userName=$_POST['userName'];
                	$userPassword=$_POST['userPassword'];
                	$token=$_POST['token'];
                	$query=$this->db->get_where('adminlogin',array('userName'=>$userName,'userPassword'=>$userPassword));
                    if($query->num_rows()==1){
                    	foreach ($query->result_array() as $key) {
                    		  $adminId=$key['loginId'];
                    	}//foreach
                    	$this->db->where('loginId',$adminId);
                    	$data=array('token'=>$token);
                    	$this->db->update('adminlogin',$data);
                        return $query->result_array();
                    }else{
                    	return false;
                    }
                }//Login
                
                
               public function AddSupplier()
                { 
                    $supplierName = $_POST['supplierName'];
                    $supplierEmail = $_POST['supplierEmail'];
                    $supplierContact = $_POST['supplierContact'];
                    $supplierPassword = $_POST['supplierContact'];
                    $supplierAddress=$_POST['supplierAddress'];
                   
                    $checkemail=$this->checkAlreadyEmail($supplierEmail);

                if($checkemail==1){
                            return 'emailPresent';
                        }else{
                            $data=array(
                                        'userName'=> $supplierName,
                                        'userEmail'=> $supplierEmail,
                                        'userContact'=> $supplierContact,
                                        'userPassword'=> $supplierContact,
                                        'userAddress'=> $supplierAddress,
                                        'userType'=> '2',
                                        
                                       );
                                    
                                    $this->db->insert('user', $data);
                                    if($this->db->affected_rows() == 1){
                                        return $this->db->insert_id();
                                    }else{
                                        return false;
                                    }   
                        }
                }//AddSupplier


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
                
                
               public function AddChatId(){
                    $supplierId=$_POST['supplierId'];
                    $supplierChatId=$_POST['supplierChatId'];
                    $this->db->where('userId',$supplierId);
                    $data=array('chatId'=>$supplierChatId);
                    $this->db->update('user',$data);
                    return ($this->db->affected_rows() != 1) ? false : true;   
                }//AddChatId
                

                 public function AddPackage(){
                    $packageName=$_POST['packageName'];
                    $packageLimit=$_POST['packageLimit'];
                    $data=array('packageName'=>$packageName,'packageLimit'=>$packageLimit);
                    $this->db->insert('package',$data);
                    return ($this->db->affected_rows() != 1) ? false : true;   
                }//AddPackage
                
                
                 public function displayPackages(){
                    $query=$this->db->get('package');
                    return $query->result_array();   
                }//displayPackages
                
                public function updatePackage(){
                    $packageId=$_POST['packageId'];
                    $packageName=$_POST['packageName'];
                    $packageLimit=$_POST['packageLimit'];
                    $data=array('packageName'=>$packageName,'packageLimit'=>$packageLimit);
                    $this->db->where('packageId',$packageId);
                    $this->db->update('package',$data);
                    return ($this->db->affected_rows() != 1) ? false : true;  
                }//updatePackage
                
                public function supplierList(){
                    $userType=$_POST['userType'];
                    $packageId=$_POST['packageId'];
                    $packageLimit=$this->getPackageLimit($packageId);
                    $query=$this->db->get_where('displaysetsuppliers',array('userType'=>$userType,'packageId'=>$packageId));
                    if($query->num_rows()> 0){
                        foreach ($query->result_array() as $key) {
                              $allIds[]=$key['supplierId'];
                        }
                         $this->db->start_cache();
                        $this->db->select('*');
                        $this->db->from('user');
                        $this->db->where('userType',$userType);
                        $this->db->where_not_in('userId',$allIds);
                        $this->db->stop_cache();
                        if($this->db->get()->num_rows() >= $packageLimit){
                            return $this->db->get()->result_array();
                            $this->db->flush_cache();
                        }else{
                            $this->db->reset_query();
                            $this->db->where('packageId',$packageId);
                            $this->db->delete('displaysetsuppliers');
                            $query2=$this->db->get_where('user',array('userType'=>$userType));
                            return $query2->result_array();
                        }
                    }else{
                        $query3=$this->db->get_where('user',array('userType'=>$userType));
                        return $query3->result_array();
                    }
                    
                }//supplierList
                
                 public function getPackageLimit($packageId){
                $query=$this->db->get_where('package',array('packageId'=>$packageId));
                    foreach ($query->result_array() as $key) {
                        return $key['packageLimit'];
                     }
                }//getPackageLimit called from supplierList
                
                 public function userList(){
                    $this->db->select('u.*,p.packageName');
                    $this->db->from('user as u');
                    $this->db->join('package as p','p.packageId=u.packageId','left');
                    return $this->db->get()->result_array();
                }//userList

                
                public function attachPackage(){
                    $userId=$_POST['userId'];
                    $packageId=$_POST['packageId'];
                    $data=array('packageId'=>$packageId);
                    $this->db->where('userId',$userId);
                    $this->db->update('user',$data);
                    return ($this->db->affected_rows() != 1) ? false : true;
                }//attachPackage
                
                public function setSupplier(){
                    $packageId=$_POST['packageId'];
                    $supplierId=$_POST['supplierId'];
                    $supplierType=$_POST['userType'];
                    $packageIdarray=explode(",", $supplierId);
                    $this->db->where('packageId',$packageId);
                    //$this->db->delete('displaysetsuppliers');
                    foreach ($packageIdarray as $key => $value) {
                        $data=array('packageId'=>$packageId,
                                    'supplierId'=>$value,
                                    'userType'=>$supplierType);
                        $finalArray[]=$data;
                    }
                    $query=$this->db->insert_batch('displaysetsuppliers',$finalArray);
                     return ($this->db->affected_rows() >= 1) ? true : false;
                }//setSupplier
                
                
                public function addMachine(){
                    $machineTitle=$_POST['machineTitle'];
                    $machineDescription=$_POST['machineDescription'];
                    $machineContact=$_POST['machineContact'];
                    $machineCondition=$_POST['machineCondition'];
                    if(isset($_FILES['url1'])){

                        if(!empty($_FILES['url1'])){

                            $url1="url1";
                            $path1=$this->do_upload($url1); 
                             
                        }
                    }

                  if(isset($_FILES['url2'])){
                        if(!empty($_FILES['url2'])){
                            $url2="url2";
                            $path2=$this->do_upload($url2);   
                        }
                    }

                  if(isset($_FILES['url3'])){
                        if(!empty($_FILES['url3'])){
                            $url3="url3";
                            $path3=$this->do_upload($url3); 
                        }  
                    }   

                  if(isset($_FILES['url4'])){
                        if(!empty($_FILES['url4'])){
                            $url4="url4";
                            $path4=$this->do_upload($url4);
                        }   
                    }
            $data=array(
                            'machineTitle'=> $machineTitle,
                            'machineDescription'=>$machineDescription,
                            'machineContact'=> $machineContact,
                            'machineCondition'=> $machineCondition  
                        );

                    if(isset($path1)){
                        if($path1=='0'){return "uploadfail";}
                        else{$data['url1']=base_url("/machine_pic/$path1");}
                    }
                    if(isset($path2)){
                        if($path2=='0'){return "uploadfail";}
                        else{$data['url2']=base_url("/machine_pic/$path2");}
                    }
                    if(isset($path3)){
                        if($path3=='0'){return "uploadfail";}
                        else{$data['url3']=base_url("/machine_pic/$path3");}                   
                    }
                    if(isset($path4)){
                        if($path4=='0'){return "uploadfail";}
                        else{$data['url4']=base_url("/machine_pic/$path4");}
                    }   
                    $this->db->insert('machine', $data);

                     return ($this->db->affected_rows() >= 1) ? true : false;
                }//addMachine

          public function do_upload($url)
        {
                $config['upload_path']          = './machine_pic/';
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
        
      public function machineList(){
                           $this->db->order_by('machineId','DESC');
                    $query=$this->db->get('machine');
                    return $query->result_array();
                }//machineList
                
      public function machineRemove(){
                    $machineId=$_POST['machineId'];
                    $this->db->where('machineId',$machineId);
                    if($this->db->delete('machine')){
                        return true;
                    }else{
                        return false;
                    }
                }//machineRemove
                
                
                
     public function addBanner(){
                    $bannerLink=$_POST['bannerLink'];
                    $bannerType=$_POST['bannerType'];
                    if(isset($_FILES['url1'])){

                        if(!empty($_FILES['url1'])){

                            $url1="url1";
                            $path1=$this->do_upload($url1); 
                             
                        }
                    }

            $data=array('bannerLink'=> $bannerLink,'bannerType'=>$bannerType);

                    if(isset($path1)){
                        if($path1=='0'){return "uploadfail";}
                        else{$data['url1']=base_url("/machine_pic/$path1");}
                    }   
                    $this->db->insert('advertisement', $data);
                     return ($this->db->affected_rows() >= 1) ? true : false;
                }//addBanner
                
                
      public function adsShowGetSmallads(){
                           $this->db->limit('5');
                           $this->db->order_by('adId', 'RANDOM');
                    $query=$this->db->get_where('advertisement',array('bannerType'=>'1'));
                    return $query->result_array();
                }//adsShowGetSmallads

            public function adsShowGetBigads(){
                           $this->db->limit('1');
                           $this->db->order_by('adId', 'RANDOM');
                     $query=$this->db->get_where('advertisement',array('bannerType'=>'2'));
                    return $query->result_array();
                }//adsShowGetBigads
                
      public function adsRemove(){
                    $adId=$_POST['adId'];
                    $this->db->where('adId',$adId);
                    if($this->db->delete('advertisement')){
                        return true;
                    }else{
                        return false;
                    }
                }//adsRemove
                
                
        public function fetchSmallAds(){
                         
                    $query=$this->db->get_where('advertisement',array('bannerType'=>'1'));
                    return $query->result_array();
                }//fetchSmallAds


            public function fetchBigAds(){
                         
                    $query=$this->db->get_where('advertisement',array('bannerType'=>'2'));
                    return $query->result_array();
                }//fetchBigAds        
                
    // raw material
             public function addRawMaterial(){
                    $rawMaterialDescription=$_POST['rawMaterialDescription'];
                    if(isset($_FILES['url1'])){

                        if(!empty($_FILES['url1'])){

                            $url1="url1";
                            $path1=$this->do_upload($url1); 
                             
                        }
                    }

            $data=array('rawMaterialDescription'=>$rawMaterialDescription);

                    if(isset($path1)){
                        if($path1=='0'){return "uploadfail";}
                        else{$data['url1']=base_url("/machine_pic/$path1");}
                    }   
                    $this->db->insert('rawmaterial', $data);
                     return ($this->db->affected_rows() >= 1) ? true : false;
                }//addRawMaterial

            public function RawMaterialList(){
                           $this->db->order_by('rawMaterialId','DESC');
                    $query=$this->db->get('rawmaterial');
                    return $query->result_array();
                }//RawMaterialList

            public function RawMaterialRemove(){
                    $rawMaterialId=$_POST['rawMaterialId'];
                    $this->db->where('rawMaterialId',$rawMaterialId);
                    if($this->db->delete('rawmaterial')){
                        return true;
                    }else{
                        return false;
                    }
                }//RawMaterialRemove
                
           
           
        //offers

            public function addOffer(){
                    $offerDescription=$_POST['offerDescription'];
                    if(isset($_FILES['url1'])){

                        if(!empty($_FILES['url1'])){

                            $url1="url1";
                            $path1=$this->do_upload($url1); 
                             
                        }
                    }

            $data=array('offerDescription'=>$offerDescription);

                    if(isset($path1)){
                        if($path1=='0'){return "uploadfail";}
                        else{$data['url1']=base_url("/machine_pic/$path1");}
                    }   
                    $this->db->insert('offers', $data);
                     return ($this->db->affected_rows() >= 1) ? true : false;
                }//addOffer

            public function offerList(){
                           $this->db->order_by('offerId','DESC');
                    $query=$this->db->get('offers');
                    return $query->result_array();
                }//OfferList

            public function offerRemove(){
                    $offerId=$_POST['offerId'];
                    $this->db->where('offerId',$offerId);
                    if($this->db->delete('offers')){
                        return true;
                    }else{
                        return false;
                    }
                }//OfferRemove

                
}
?>