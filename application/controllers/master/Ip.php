<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ip extends CI_Controller {
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
    
    public function ipNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $this->load->view('header');
                    $this->load->view('master/ip/ip_new');
                    $this->load->view('footer');
                    if($this->input->post('submit')){
                        $dataStartTime = $this->input->post('data_start_time');
                        $dataEndTime = $this->input->post('data_end_time');
                        $newData = array(
                            'data_name'=>$this->input->post('data_name'),
                            'data_ip'=>$this->input->post('data_ip'),
                            'data_email'=>$this->session->userdata['user_email'],
                            'data_time'=>timeZone(),
                            'data_start_time'=>date('H:i', strtotime($dataStartTime)),
                            'data_end_time'=>date('H:i', strtotime($dataEndTime)),
                            'data_status'=>'active'
                        );
                        $newDataEntry = $this->DataModel->insertData(IP_TABLE, $newData);
                        if($newDataEntry){
                          redirect('view-ip');  
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

    public function ipView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $data['viewIp'] = $this->DataModel->viewData(null, null, IP_TABLE);
                    $this->load->view('header');
                    $this->load->view('master/ip/ip_view', $data);
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
    
    public function ipEdit($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $dataID = urlDecodes($dataID);
                    if(ctype_digit($dataID)){
                        $data['ipData'] = $this->DataModel->getData('data_id = '.$dataID, IP_TABLE);
                        if(!empty($data['ipData'])){
                            $this->load->view('header');
                            $this->load->view('master/ip/ip_edit', $data);
                            $this->load->view('footer');
                        } else {
                            redirect('error');
                        }
                        if($this->input->post('submit')){
                            $dataStartTime = $this->input->post('data_start_time');
                            $dataEndTime = $this->input->post('data_end_time');
                            $editData = array(
                                'data_name'=>$this->input->post('data_name'),
                                'data_ip'=>$this->input->post('data_ip'),
                                'data_email'=>$this->session->userdata['user_email'],
                                'data_time'=>timeZone(),
                                'data_start_time'=>date('H:i', strtotime($dataStartTime)),
                                'data_end_time'=>date('H:i', strtotime($dataEndTime)),
                                'data_status'=>$this->input->post('data_status')
                            );
                            $editDataEntry = $this->DataModel->editData('data_id = '.$dataID, IP_TABLE, $editData);
            				if($editDataEntry){
            					redirect('view-ip');
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
    
    public function ipDelete($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $dataID = urlDecodes($dataID);
                    if(ctype_digit($dataID)){
                        $resultDataEntry = $this->DataModel->deleteData('data_id = '.$dataID, IP_TABLE);
                        if($resultDataEntry){
                            redirect('view-ip');
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