<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index(){
	    $userID = $this->session->userdata['user_id'];
		$editUserMasterData = array(
		    'user_logout' => timeZone(),
    		'is_login' => 'False',
		);
		$editLoginData = array(
		    'user_logout' => timeZone(),
		);
		$editUserMasterDataEntry = $this->LoginModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editUserMasterData);
		$editLoginDataEntry = $this->LoginModel->editData('user_id = '.$userID, LOGIN_DATA_TABLE, $editLoginData);
	    $this->session->sess_destroy();
		redirect('login'); 
		
	}
	
	function logoutActivity(){
	    $this->session->sess_destroy();
		redirect('login'); 
		
	}
	
	public function userLogout($userID = 0){
	    $isLogin = checkAuth();
	    if($isLogin == "True"){
    	    if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){ 
            	    $userID = urlDecodes($userID);
            	    if(ctype_digit($userID)){
            			$editUserMasterData = array(
            			    'user_logout' => timeZone(),
                    		'is_login' => 'False',
            			);
            			$editLoginData = array(
            			    'user_logout' => timeZone(),
            			);
            			$editUserMasterDataEntry = $this->LoginModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editUserMasterData);
            			$editLoginDataEntry = $this->LoginModel->editData('user_id = '.$userID, LOGIN_DATA_TABLE, $editLoginData);
    					redirect('login');
            	    } else {
            			redirect('error');
            		}
                } else {
                    redirect('error');
                }
    	    } else {
    	        redirect('error');
    	    }
	    } else {
	        redirect('logout');
	    }
 	}
}
