<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {
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
	
 	public function departmentNew(){
		$isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $data['permissionData'] = $this->DataModel->viewData(null, null, PERMISSION_MASTER_TABLE);
                    
                    $permissionAliasData = $this->DataModel->viewData('alias_id '.'ASC', null, PERMISSION_ALIAS_TABLE);
                        
                    $data['viewPermissionAlias'] = array();
                    if (is_array($permissionAliasData) || is_object($permissionAliasData)){
                        foreach($permissionAliasData as $Row){
                            $dataArray = array();
                            $dataArray['alias_id'] = $Row['alias_id'];
                            $dataArray['alias_name'] = $Row['alias_name'];
                            $dataArray['alias_status'] = $Row['alias_status'];
                            $dataArray['permissionData'] = $this->DataModel->viewData(null, 'alias_id = '.$dataArray['alias_id'], PERMISSION_MASTER_TABLE);
                            array_push($data['viewPermissionAlias'], $dataArray);
                        }
                    }

		    	    $this->load->view('header');
		    		$this->load->view('master/department/department_new', $data);
		    		$this->load->view('footer');
				    if($this->input->post('submit')){
						$newData = array(
				    		'department_name'=>$this->input->post('department_name'),
				    	    'department_status'=>"Publish"
						);
		    		    $departmentID = $this->DataModel->insertData(DEPARTMENT_TABLE, $newData);
	        		    if($departmentID){
	        		        if(isset($_POST['department_permission'])){
    	        		        foreach($_POST['department_permission'] as $permissionID){
    				                $permissionData = $this->DataModel->getData('permission_id = '.$permissionID, PERMISSION_MASTER_TABLE);
    				                $newData = array(
    				                    'department_id'=>$departmentID,
                                        'permission_id'=>$permissionData['permission_id'],
            				    		'permission_name'=>$permissionData['permission_name'],
            				    		'permission_alias'=>$permissionData['permission_alias'],
            				    	    'can_add'=>$permissionData['can_add'],
            				    	    'can_view'=>$permissionData['can_view'],
            				    	    'can_edit'=>$permissionData['can_edit'],
            				    	    'can_delete'=>$permissionData['can_delete'],
            				    	    'permission_status'=>$permissionData['permission_status'],
            						);
    				                $newDataEntry = $this->DataModel->insertData(PERMISSION_DEPARTMENT_TABLE, $newData);
    				                if($newDataEntry){
        			                    redirect('view-department'); 
        			                }
    				            }
	        		        }
		    		    }
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

    public function departmentView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $data['viewDepartment'] = $this->DataModel->viewData(null, null, DEPARTMENT_TABLE);
                    $this->load->view('header');
                    $this->load->view('master/department/department_view', $data);
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

    public function departmentEdit($departmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $departmentID = urlDecodes($departmentID);
                    if(ctype_digit($departmentID)){
                        $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);

                        if(!empty($data['departmentData'])){
                            $this->load->view('header');
                            $this->load->view('master/department/department_edit', $data);
                            $this->load->view('footer');
                        } else {
                            redirect('error');
                        }
                        if($this->input->post('submit')){
                            $editData = array(
                                'department_name'=>$this->input->post('department_name'),
                                'department_status'=>$this->input->post('department_status')
                            );
                            $editDataEntry = $this->DataModel->editData('department_id = '.$departmentID, DEPARTMENT_TABLE, $editData);
                            if($editDataEntry){
                                redirect('view-department');
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

    public function usersView($departmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $departmentID = urlDecodes($departmentID);
                    $data['viewUsers'] = $this->DataModel->viewData(null, 'department_id = '.$departmentID, MASTER_USER_TABLE);
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                    $this->load->view('header');
                    $this->load->view('master/department/users_view', $data);
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
}
