<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    function __construct() {
		parent::__construct();

		if ($this->session->userdata('auth_key') != AUTH_KEY){ 
            redirect('login');
        }
	}
	
	public function index(){
        $this->load->view('header');
        $this->load->view('error');
        $this->load->view('footer');
    }
	
	public function userNew(){
	    $isLogin = checkAuth();
	    if($isLogin == "True"){
    	    if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){ 
        			$data['departmentData'] = $this->DataModel->viewData('department_id '.'DESC', null, DEPARTMENT_TABLE);
        			$this->load->view('header');
        			$this->load->view('master/user/user_new', $data);  
        			$this->load->view('footer');
            		if($this->input->post('submit')){
                        $departmentID = $this->input->post('department_permission');
                        $userRole = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                		$newData = array(
                			'department_id'=>$departmentID,
                    		'user_name'=>$this->input->post('user_name'),
                    		'user_email'=>$this->input->post('user_email'),
                    	    'user_password'=>md5($this->input->post('user_password')),
                    	    'user_role'=>$userRole['department_name'],
                    	    'user_key'=>uniqueKey(),
                    	    'user_status'=>$this->input->post('user_status'),
                    	    'is_login'=>'-',
                		);
	                	$newUserID = $this->DataModel->insertData(MASTER_USER_TABLE, $newData);
	                	
                        $departmentPermission = $this->DataModel->viewData(null, 'department_id = '.$departmentID, PERMISSION_DEPARTMENT_TABLE);
                        foreach($departmentPermission as $permissionRow){
                            $newData = array(
                                'user_id'=>$newUserID,
                                'department_id'=>$departmentID,
                                'permission_id'=>$permissionRow['permission_id'],
                                'permission_name'=>$permissionRow['permission_name'],
                                'permission_alias'=>$permissionRow['permission_alias'],
                                'can_add'=>$permissionRow['can_add'],
                                'can_view'=>$permissionRow['can_view'],
                                'can_edit'=>$permissionRow['can_edit'],
                                'can_delete'=>$permissionRow['can_delete'],
                                'permission_status'=>$permissionRow['permission_status']
                            );
                            $newDataEntry = $this->DataModel->insertData(PERMISSION_USER_TABLE, $newData);
                        }
            			redirect('view-user');
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
	
	public function userView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $userMaster = $this->DataModel->viewData(null, null, MASTER_USER_TABLE);
                    $data['viewUserMaster'] = array();
                    if(is_array($userMaster) || is_object($userMaster)){
                        foreach($userMaster as $Row){
                            $dataArray = array();
                            $dataArray['user_id'] = $Row['user_id'];
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['user_name'] = $Row['user_name'];
                            $dataArray['user_email'] = $Row['user_email'];
                            $dataArray['user_role'] = $Row['user_role'];
                            $dataArray['is_login'] = $Row['is_login'];
                            $dataArray['user_status'] = $Row['user_status'];
                            $departmentData = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                            if($departmentData){
                                $dataArray['departmentName'] = $departmentData['department_name'];
                            } else {
                                $dataArray['departmentName'] = "-";
                            }
                            array_push($data['viewUserMaster'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/user/user_view', $data);
                    $this->load->view('footer');
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

	public function userEdit($userID = 0){
	    $isLogin = checkAuth();
	    if($isLogin == "True"){
    	    if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){ 
            	    $userID = urlDecodes($userID);
            	    if(ctype_digit($userID)){
                		$userMasterData = $this->DataModel->getData('user_id = '.$userID, MASTER_USER_TABLE);
                		$data = array('userMasterData'=>$userMasterData);
                		$data['viewDepartment'] = $this->DataModel->viewData('department_id '.'DESC', null, DEPARTMENT_TABLE);
                        $departmentID = $userMasterData['department_id'];
                        $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
            			if($data['userMasterData'] != null){
            			    $this->load->view('header');
                    		$this->load->view('master/user/user_edit', $data);
                    		$this->load->view('footer');
            			} else {
            				redirect('error');
            			}
                		if($this->input->post('submit')){
                			if($this->input->post('user_password') == ""){
                		        $userPassword = $userMasterData['user_password'];
                		    } else {
                		        $userPassword = md5($this->input->post('user_password'));
                		    }
                			$departmentID = $this->input->post('department_id');
                        	$userRole = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                		    $editData = array(
                        		'department_id'=>$departmentID,
                        		'user_name'=>$this->input->post('user_name'),
                        		'user_email'=>$this->input->post('user_email'),
                        		'user_password'=>$userPassword,
                        	    'user_role'=>$userRole['department_name'],
                        	    'user_status'=>$this->input->post('user_status')
                			);
                			$editDataEntry = $this->DataModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editData);
            				if($editDataEntry){
            					redirect('view-user');
            				}
                		}
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

    public function userProfile(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $this->load->view('header');
            $this->load->view('master/user/user_profile');
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function loginHistory(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $data['viewLogin'] = $this->DataModel->viewData(null, null, LOGIN_DATA_TABLE);
                    $this->load->view('header');
                    $this->load->view('master/user/login_history', $data);
                    $this->load->view('footer');
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
    
    public function loginDescription($uniqueID = 0){
 	    $isLogin = checkAuth();
	    if($isLogin == "True"){
	        if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
             	    $uniqueID = urlDecodes($uniqueID);
            	    if(ctype_digit($uniqueID)){
            	        $data['loginDescription'] = $this->DataModel->getData('unique_id = '.$uniqueID, LOGIN_DATA_TABLE);
            	        if($data['loginDescription'] != null){
                	        $this->load->view('header');
                    		$this->load->view('master/user/login_description', $data);
                    		$this->load->view('footer');
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
                redirect('error');
            }
	    } else {
	        redirect('logout');
	    }
	}
	
	public function loginActivity($userID = 0){
 	    $isLogin = checkAuth();
	    if($isLogin == "True"){
	        if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
             	    $userID = urlDecodes($userID);
            	    if(ctype_digit($userID)){
            	        $data['loginActivity'] = $this->DataModel->viewLoginActivityData('user_id = '.$userID, LOGIN_DATA_TABLE);
            	        $this->load->view('header');
                		$this->load->view('master/user/login_activity', $data);
                		$this->load->view('footer');
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