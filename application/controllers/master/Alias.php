<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Alias extends CI_Controller {
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
    
    public function aliasNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $this->load->view('header');
                    $this->load->view('master/alias/alias_new');
                    $this->load->view('footer');
                    if($this->input->post('submit')){
                        $newData = array(
                            'alias_name'=>$this->input->post('alias_name'),
                            'alias_status'=>$this->input->post('alias_status')
                        );
                        $lastInsertID = $this->DataModel->insertData(PERMISSION_ALIAS_TABLE, $newData);
                        if($lastInsertID){
                            $editData = array(
                                'alias_position'=>$lastInsertID
                            );
                            $editDataEntry = $this->DataModel->editData('alias_id = '.$lastInsertID, PERMISSION_ALIAS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('view-alias');  
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

    public function aliasView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $alias = $this->DataModel->viewData(null, null, PERMISSION_ALIAS_TABLE);
                    $data['viewAlias'] = array();
                    if(is_array($alias) || is_object($alias)){
                        foreach($alias as $Row){
                            $dataArray = array();
                            $dataArray['alias_id'] = $Row['alias_id'];
                            $dataArray['alias_name'] = $Row['alias_name'];
                            $dataArray['alias_position'] = $Row['alias_position'];
                            $dataArray['alias_status'] = $Row['alias_status'];
                            $dataArray['permissionCount'] = $this->DataModel->countData('alias_id = '.$dataArray['alias_id'], PERMISSION_MASTER_TABLE);
                            array_push($data['viewAlias'], $dataArray);
                        }
                    }
                    
                    $this->load->view('header');
                    $this->load->view('master/alias/alias_view', $data);
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

    public function aliasEdit($aliasID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $aliasID = urlDecodes($aliasID);
                    if(ctype_digit($aliasID)){
                        $data['aliasData'] = $this->DataModel->getData('alias_id = '.$aliasID, PERMISSION_ALIAS_TABLE);
                        
                        if(!empty($data['aliasData'])){
                            $this->load->view('header');
                            $this->load->view('master/alias/alias_edit', $data);
                            $this->load->view('footer');
                        } else {
                            redirect('error');
                        }
                        if($this->input->post('submit')){
                            $editData = array(
                                'alias_name'=>$this->input->post('alias_name'),
                                'alias_position'=>$this->input->post('alias_position'),
                                'alias_status'=>$this->input->post('alias_status')
                            );
                            $editDataEntry = $this->DataModel->editData('alias_id = '.$aliasID, PERMISSION_ALIAS_TABLE, $editData);
            				if($editDataEntry){
            					redirect('view-alias');
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
}
