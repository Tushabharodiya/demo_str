<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PrivacyPolicy extends CI_Controller {
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
	
    public function privacyPolicyNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(PRIVACY_POLICY_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('privacyPolicy/privacy_policy_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $appName = $this->input->post('app_name');
                    $privacyPolicyAppNameData = $this->DataModel->getData('app_name = "'.$appName.'"', PRIVACY_POLICY_TABLE);
                    
                    if($privacyPolicyAppNameData !== null && isset($privacyPolicyAppNameData['app_name']) && $privacyPolicyAppNameData['app_name'] == $appName){
                        $this->session->set_userdata('session_privacy_policy_new_app_name', "App name $appName is already exits in database!");
                        redirect('new-privacy-policy');
                    } else {
                        $newData = array(
                            'app_name'=>$this->input->post('app_name'),
                            'app_code'=>$this->input->post('app_code'),
                            'app_privacy_slug'=>$this->input->post('app_privacy_slug'),
                            'app_terms_slug'=>$this->input->post('app_terms_slug'),
                            'app_privacy'=>$this->input->post('app_privacy'),
                            'app_terms'=>$this->input->post('app_terms'),
                            'privacy_status'=>$this->input->post('privacy_status'),
                        );
                        $newDataEntry = $this->DataModel->insertData(PRIVACY_POLICY_TABLE, $newData);
                        if($newDataEntry){
                            redirect('view-privacy-policy');  
                        }
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function privacyPolicyView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_privacy_policy');
            }
            if(isset($_POST['submit_search'])){
                $searchPrivacyPolicy = $this->input->post('search_privacy_policy');
                $this->session->set_userdata('session_privacy_policy', $searchPrivacyPolicy);
            }
            $sessionPrivacyPolicy = $this->session->userdata('session_privacy_policy');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_privacy_policy_status');
                redirect('view-privacy-policy');
            }
                
            $searchPrivacyPolicyStatus = $this->input->post('search_privacy_policy_status');
            if($searchPrivacyPolicyStatus === 'publish' or $searchPrivacyPolicyStatus == 'unpublish'){
                $this->session->set_userdata('session_privacy_policy_status', $searchPrivacyPolicyStatus);
            } else if($searchPrivacyPolicyStatus === 'all'){
                $this->session->unset_userdata('session_privacy_policy_status');
            }
            $sessionPrivacyPolicyStatus = $this->session->userdata('session_privacy_policy_status');
            
            $data = array();
            //get rows count
            $conditions['search_privacy_policy'] = $sessionPrivacyPolicy;
            $conditions['search_privacy_policy_status'] = $sessionPrivacyPolicyStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewPrivacyPolicy($conditions, PRIVACY_POLICY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-privacy-policy');
            $config['uri_segment'] = 2;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 10;
            
            //styling
            $config['num_tag_open'] = '<li class="page-item page-link">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active page-item"><a href="javascript:void(0);" class="page-link" >';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_link'] = '&raquo';
            $config['prev_link'] = '&laquo';
            $config['next_tag_open'] = '<li class="pg-next page-item page-link">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="pg-prev page-item page-link">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item page-link">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item page-link">';
            $config['last_tag_close'] = '</li>';
            
            //initialize pagination library
            $this->pagination->initialize($config);
            
            //define offset
            $page = $this->uri->segment(2);
            $offset = !$page?0:$page;
            
            //get rows
            $conditions['returnType'] = '';
            $conditions['start'] = $offset;
            $conditions['limit'] = 10;
            
            $privacyPolicy = $this->DataModel->viewPrivacyPolicy($conditions, PRIVACY_POLICY_TABLE);
            $data['countPrivacyPolicy'] = $this->DataModel->countPrivacyPolicy($conditions, PRIVACY_POLICY_TABLE);
            
            $data['viewPrivacyPolicy'] = array();
            if(is_array($privacyPolicy) || is_object($privacyPolicy)){
                foreach($privacyPolicy as $Row){
                    $dataArray = array();
                    $dataArray['privacy_id'] = $Row['privacy_id'];
                    $dataArray['app_name'] = $Row['app_name'];
                    $dataArray['app_code'] = $Row['app_code'];
                    $dataArray['app_privacy_slug'] = $Row['app_privacy_slug'];
                    $dataArray['app_terms_slug'] = $Row['app_terms_slug'];
                    $dataArray['app_privacy'] = $Row['app_privacy'];
                    $dataArray['app_terms'] = $Row['app_terms'];
                    $dataArray['privacy_status'] = $Row['privacy_status'];
                    array_push($data['viewPrivacyPolicy'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('privacyPolicy/privacy_policy_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function privacyPolicyEdit($privacyID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(PRIVACY_POLICY_ALIAS, "can_edit");
            if($isPermission){
                $privacyID = urlDecodes($privacyID);
                if(ctype_digit($privacyID)){
                    $data['privacyPolicyData'] = $this->DataModel->getData('privacy_id = '.$privacyID, PRIVACY_POLICY_TABLE);
                    if(!empty($data['privacyPolicyData'])){
                        $this->load->view('header');
                        $this->load->view('privacyPolicy/privacy_policy_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'app_name'=>$this->input->post('app_name'),
                            'app_code'=>$this->input->post('app_code'),
                            'app_privacy_slug'=>$this->input->post('app_privacy_slug'),
                            'app_terms_slug'=>$this->input->post('app_terms_slug'),
                            'app_privacy'=>$this->input->post('app_privacy'),
                            'app_terms'=>$this->input->post('app_terms'),
                            'privacy_status'=>$this->input->post('privacy_status'),
                        );
                        $editDataEntry = $this->DataModel->editData('privacy_id = '.$privacyID, PRIVACY_POLICY_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-privacy-policy');
                        }
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function privacyPolicyStatus($privacyID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(PRIVACY_POLICY_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(PRIVACY_POLICY_PUBLISH_ALIAS, "can_edit");
            $privacyID = urlDecodes($privacyID);
            if(ctype_digit($privacyID)){
                $privacyPolicyData = $this->DataModel->getData('privacy_id = '.$privacyID, PRIVACY_POLICY_TABLE);
                if($privacyPolicyData['privacy_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'privacy_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'privacy_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('privacy_id = '.$privacyID, PRIVACY_POLICY_TABLE, $editData);
				if($editDataEntry){
					redirect($_SERVER['HTTP_REFERER']);
				}
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
}
