<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
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
    
    public function chargingSearchView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_charging_search');
            }
            if(isset($_POST['submit_search'])){
                $searchChargingSearch = $this->input->post('search_charging_search');
                $this->session->set_userdata('session_charging_search', $searchChargingSearch);
            }
            $sessionChargingSearch = $this->session->userdata('session_charging_search');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_charging_search_status');
                redirect('view-charging-search');
            }
            
            $searchChargingSearchStatus = $this->input->post('search_charging_search_status');
            if($searchChargingSearchStatus === 'publish' or $searchChargingSearchStatus == 'added'){
                $this->session->set_userdata('session_charging_search_status', $searchChargingSearchStatus);
            } else if($searchChargingSearchStatus === 'all'){
                $this->session->unset_userdata('session_charging_search_status');
            }
            $sessionChargingSearchStatus = $this->session->userdata('session_charging_search_status');
            
            $data = array();
            //get rows count
            $conditions['search_charging_search'] = $sessionChargingSearch;
            $conditions['search_charging_search_status'] = $sessionChargingSearchStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewChargingSearchData($conditions, CHARGING_SEARCH_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-charging-search');
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
            
            $chargingSearch = $this->DataModel->viewChargingSearchData($conditions, CHARGING_SEARCH_TABLE);
            $data['countChargingSearch'] = $this->DataModel->countChargingSearchData($conditions, CHARGING_SEARCH_TABLE);
            
            $data['viewChargingSearch'] = array();
            if(is_array($chargingSearch) || is_object($chargingSearch)){
                foreach($chargingSearch as $Row){
                    $dataArray = array();
                    $dataArray['search_id'] = $Row['search_id'];
                    $dataArray['search_query'] = $Row['search_query'];
                    $dataArray['search_date'] = $Row['search_date'];
                    $dataArray['search_status'] = $Row['search_status'];
                    array_push($data['viewChargingSearch'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('charging/search/charging_search_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }

    public function chargingSearchStatus($searchID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(CHARGING_SEARCH_ADDED_ALIAS, "can_edit");
            $isPermission2 = checkPermission(CHARGING_SEARCH_PUBLISH_ALIAS, "can_edit");
            $searchID = urlDecodes($searchID);
            if(ctype_digit($searchID)){
                $chargingSearchData = $this->DataModel->getData('search_id = '.$searchID, CHARGING_SEARCH_TABLE);
                if($chargingSearchData['search_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'search_status'=>"added",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array( 
                		    'search_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('search_id = '.$searchID, CHARGING_SEARCH_TABLE, $editData);
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

    public function chargingSearchDelete($searchID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(CHARGING_SEARCH_ALIAS, "can_delete");
            if($isPermission){ 
                $searchID = urlDecodes($searchID);
                if(ctype_digit($searchID)){
                    $resultDataEntry = $this->DataModel->deleteData('search_id = '.$searchID, CHARGING_SEARCH_TABLE);
                    if($resultDataEntry){
                        redirect($_SERVER['HTTP_REFERER']);
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
}