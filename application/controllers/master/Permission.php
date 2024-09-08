<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {
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
    
    public function permissionNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $data['aliasData'] = $this->DataModel->viewData(null, null, PERMISSION_ALIAS_TABLE);
                    $this->load->view('header');
                    $this->load->view('master/permission/permission_new', $data);
                    $this->load->view('footer');
                    if($this->input->post('submit')){
                        $newData = array(
                            'alias_id'=>$this->input->post('alias_id'),
                            'permission_name'=>$this->input->post('permission_name'),
                            'permission_alias'=>$this->input->post('permission_alias'),
                            'permission_description'=>$this->input->post('permission_description'),
                            'can_add'=>'0',
                            'can_view'=>'0',
                            'can_edit'=>'0',
                            'can_delete'=>'0',
                            'permission_status'=>$this->input->post('permission_status')
                        );
                        $lastInsertID = $this->DataModel->insertData(PERMISSION_MASTER_TABLE, $newData);
                        if($lastInsertID){
                            $editData = array(
                                'permission_position'=>$lastInsertID
                            );
                            $editDataEntry = $this->DataModel->editData('permission_id = '.$lastInsertID, PERMISSION_MASTER_TABLE, $editData);
                            if($editDataEntry){
                                redirect('view-permission');  
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

    public function permissionView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $data['viewPermission'] = $this->DataModel->viewData(null, null, PERMISSION_MASTER_TABLE);
                    $this->load->view('header');
                    $this->load->view('master/permission/permission_view', $data);
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
    
    public function permissionsView($aliasID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $aliasID = urlDecodes($aliasID);
                    if(ctype_digit($aliasID)){
                        $data['viewPermission'] = $this->DataModel->viewData(null, 'alias_id = '.$aliasID, PERMISSION_MASTER_TABLE);
                        $this->load->view('header');
                        $this->load->view('master/permission/permissions_view', $data);
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
    
    public function permissionEdit($permissionID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $permissionID = urlDecodes($permissionID);
                    if(ctype_digit($permissionID)){
                        $permissionData = $this->DataModel->getData('permission_id = '.$permissionID, PERMISSION_MASTER_TABLE);
                        $data = array('permissionData'=>$permissionData);
                        $data['viewAlias'] = $this->DataModel->viewData(null, null, PERMISSION_ALIAS_TABLE);
                        $aliasID = $permissionData['alias_id'];
                        $data['aliasData'] = $this->DataModel->getData('alias_id = '.$aliasID, PERMISSION_ALIAS_TABLE);
                        if(!empty($permissionData)){
                            $this->load->view('header');
                            $this->load->view('master/permission/permission_edit', $data);
                            $this->load->view('footer');
                        } else {
                            redirect('error');
                        }
                        if($this->input->post('submit')){
                            $editMasterData = array(
                                'alias_id'=>$this->input->post('alias_id'),
                                'permission_name'=>$this->input->post('permission_name'),
                                'permission_alias'=>$this->input->post('permission_alias'),
                                'permission_description'=>$this->input->post('permission_description'),
                                'permission_position'=>$this->input->post('permission_position'),
                                'permission_status'=>$this->input->post('permission_status')
                            );
                            $editData = array(
                                'permission_name'=>$this->input->post('permission_name'),
                                'permission_alias'=>$this->input->post('permission_alias'),
                                'permission_status'=>$this->input->post('permission_status')
                            );
                            $editMasterDataEntry = $this->DataModel->editData('permission_id = '.$permissionID, PERMISSION_MASTER_TABLE, $editMasterData);
                            $editDepartmentDataEntry = $this->DataModel->editData('permission_id = '.$permissionID, PERMISSION_DEPARTMENT_TABLE, $editData);
                            $editUserDataEntry = $this->DataModel->editData('permission_id = '.$permissionID, PERMISSION_USER_TABLE, $editData);
                            redirect('view-permission');
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
    
    public function departmentRights($departmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){ 
                    $departmentID = urlDecodes($departmentID);
                    if(ctype_digit($departmentID)){
                        $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                        $data['departmentPermissionData'] = $this->DataModel->viewData(null, 'department_id = '.$departmentID, PERMISSION_DEPARTMENT_TABLE);
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
                        $this->load->view('master/permission/department_rights', $data);
                        $this->load->view('footer');
                        
                        if($this->input->post('submit')){
                            if($departmentID){
                                $deleteDataArray = array();
                                foreach($data['departmentPermissionData'] as $permissionData){
                                    foreach($_POST['department_permission'] as $permissionID){
                                        if($permissionData['permission_id'] == $permissionID){
                                            array_push($deleteDataArray, $permissionID);
                                        }
                                    }
                                }

                                $newDepartmentPermissionData = $this->DataModel->viewNotDepartmentData(null, $departmentID, $deleteDataArray, PERMISSION_DEPARTMENT_TABLE);
                                foreach($newDepartmentPermissionData as $newDepartmentPermissionRow){
                                    $deleteData = $this->DataModel->deleteData('rights_id = '.$newDepartmentPermissionRow['rights_id'], PERMISSION_DEPARTMENT_TABLE);
                                }

                                $newUserPermissionData = $this->DataModel->viewNotDepartmentData(null, $departmentID, $deleteDataArray, PERMISSION_USER_TABLE);
                                foreach($newUserPermissionData as $newUserPermissionRow){
                                    $deleteData = $this->DataModel->deleteUserData('department_id = '.$newUserPermissionRow['department_id'], 'permission_id = '.$newUserPermissionRow['permission_id'], PERMISSION_USER_TABLE);
                                }
                                if(isset($_POST['department_permission'])){
                                    foreach($_POST['department_permission'] as $permissionID){
                                        $departmentData = $this->DataModel->getDepartmentPermissionData(null, $departmentID, $permissionID,  PERMISSION_DEPARTMENT_TABLE);
                                        
                                        $permissionData = $this->DataModel->getData('permission_id = '.$permissionID, PERMISSION_MASTER_TABLE);
                                        
                                        $masterUserData = $this->DataModel->viewData(null, 'department_id = '.$departmentID, MASTER_USER_TABLE);
                                        
                                        if(!$departmentData){
                                            $newDepartmentData = array(
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
                                            $newDepartmentDataEntry = $this->DataModel->insertData(PERMISSION_DEPARTMENT_TABLE, $newDepartmentData);
    
                                            foreach($masterUserData as $userIDs){
                                                $newUserData = array(
                                                    'user_id'=>$userIDs['user_id'],
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
                                                $newUserDataEntry = $this->DataModel->insertData(PERMISSION_USER_TABLE, $newUserData);
                                            }
                                        }
                                    }
                                    redirect('view-department'); 
                                } else {
                                    redirect($_SERVER['HTTP_REFERER']);
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
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
	public function departmentPermission($departmentID = 0){
	    $departmentID = urlDecodes($departmentID);
	    if(ctype_digit($departmentID)){
            $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
    		$data['departmentPermissionData'] = $this->DataModel->viewData(null, 'department_id = '.$departmentID, PERMISSION_DEPARTMENT_TABLE);
    		
            $this->load->view('header');
            $this->load->view('master/permission/department_permission', $data);
            $this->load->view('footer');
    		if($this->input->post('submit')){
                $data['viewDepartment'] = array();
    			foreach($data['departmentPermissionData'] as $aliasRow){
    			    $dataArray = array();
    			    $rightsID = $aliasRow['rights_id'];
                    $departmentID = $aliasRow['department_id'];
    			    $permissionID = $aliasRow['permission_id'];
    				$permissionAlias = $aliasRow['rights_id'];
    				
    				if($rightsID == isset($_POST[$permissionAlias])){
    				    $editData = array(
                			'can_add'=>$_POST[$permissionAlias][0],
    			    		'can_view'=>$_POST[$permissionAlias][1],
    			    		'can_edit'=>$_POST[$permissionAlias][2],
    			    		'can_delete'=>$_POST[$permissionAlias][3]
            			);
    				} 
    				$editDataEntry = $this->DataModel->editData('rights_id = '.$rightsID, PERMISSION_DEPARTMENT_TABLE, $editData);
                    $masterUserData = $this->DataModel->viewData(null, 'department_id = '.$departmentID, MASTER_USER_TABLE);
                    foreach($masterUserData as $userIDs){
                        $userID = $userIDs['user_id'];
                        $editDataEntry = $this->DataModel->editUserData('user_id = '.$userID, 'department_id = '.$departmentID, 'permission_id = '.$permissionID, PERMISSION_USER_TABLE, $editData);
                    }
    		    }
    		    redirect('department-permission/'.urlEncodes($departmentID));
    		}
	    } else {
	        redirect('error');
	    }
	}

	public function userRights($userID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){ 
                    $userID = urlDecodes($userID);
                    if(ctype_digit($userID)){
                        $masterUserData = $this->DataModel->getData('user_id = '.$userID, MASTER_USER_TABLE);
                        $data = array('masterUserData'=>$masterUserData);
                        $departmentID = $masterUserData['department_id'];
                        $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                        $data['userPermissionData'] = $this->DataModel->viewData(null, 'user_id = '.$userID, PERMISSION_USER_TABLE);
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
                        $this->load->view('master/permission/user_rights', $data);
                        $this->load->view('footer');
                        
                        if($this->input->post('submit')){
                            if($userID){
                                $deleteDataArray = array();
                                foreach($data['userPermissionData'] as $permissionData){
                                    foreach($_POST['user_permission'] as $permissionID){
                                        if($permissionData['permission_id'] == $permissionID){
                                            array_push($deleteDataArray, $permissionID);
                                        }
                                    }
                                }

                                $newUserPermissionData = $this->DataModel->viewNotUserData(null, $userID, $deleteDataArray, PERMISSION_USER_TABLE);
                               
                                foreach($newUserPermissionData as $newUserPermissionRow){
                                    $deleteData = $this->DataModel->deleteData('rights_id = '.$newUserPermissionRow['rights_id'], PERMISSION_USER_TABLE);
                                }
                                if(isset($_POST['user_permission'])){
                                    foreach($_POST['user_permission'] as $permissionID){
                                        $userData = $this->DataModel->getUserPermissionData(null, $userID, $permissionID,  PERMISSION_USER_TABLE);
                                        
                                        $masterUserData = $this->DataModel->getData('user_id = '.$userID, MASTER_USER_TABLE);
                                        
                                        $permissionData = $this->DataModel->getData('permission_id = '.$permissionID, PERMISSION_MASTER_TABLE);
                                        
                                        if(!$userData){
                                            $newData = array(
                                                'user_id'=>$userID,
                                                'department_id'=>$masterUserData['department_id'],
                                                'permission_id'=>$permissionData['permission_id'],
                                                'permission_name'=>$permissionData['permission_name'],
                                                'permission_alias'=>$permissionData['permission_alias'],
                                                'can_add'=>$permissionData['can_add'],
                                                'can_view'=>$permissionData['can_view'],
                                                'can_edit'=>$permissionData['can_edit'],
                                                'can_delete'=>$permissionData['can_delete'],
                                                'permission_status'=>$permissionData['permission_status'],
                                            );
                                            $newDataEntry = $this->DataModel->insertData(PERMISSION_USER_TABLE, $newData);
                                        } 
                                    }
                                    redirect('view-user'); 
                                } else {
                                    redirect($_SERVER['HTTP_REFERER']);
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
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }

	public function userPermission($userID = 0){
	    $userID = urlDecodes($userID);
	    if(ctype_digit($userID)){
            $masterUserData = $this->DataModel->getData('user_id = '.$userID, MASTER_USER_TABLE);
            $data = array('masterUserData'=>$masterUserData);
            $departmentID = $masterUserData['department_id'];
            $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
    		$data['userPermissionData'] = $this->DataModel->viewData(null, 'user_id = '.$userID, PERMISSION_USER_TABLE);
    		
            $this->load->view('header');
            $this->load->view('master/permission/user_permission', $data);
            $this->load->view('footer');
    		if($this->input->post('submit')){
                $data['viewUser'] = array();
    			foreach ($data['userPermissionData'] as $aliasRow){
    			    $dataArray = array();
    			    $rightsID = $aliasRow['rights_id'];
    			    $departmentID = $aliasRow['department_id'];
    				$permissionAlias = $aliasRow['rights_id'];
    				
    				if($rightsID == isset($_POST[$permissionAlias])){
    				    $editData = array(
                			'can_add'=>$_POST[$permissionAlias][0],
    			    		'can_view'=>$_POST[$permissionAlias][1],
    			    		'can_edit'=>$_POST[$permissionAlias][2],
    			    		'can_delete'=>$_POST[$permissionAlias][3]
            			);
    				} 
    				$editDataEntry = $this->DataModel->editData('rights_id = '.$rightsID, PERMISSION_USER_TABLE, $editData);
    		    }
    		    redirect('user-permission/'.urlEncodes($userID));
    		}
	    } else {
	        redirect('error');
	    }
	}
}