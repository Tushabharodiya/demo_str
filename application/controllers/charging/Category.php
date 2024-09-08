<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
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
	
    public function chargingCategoryNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(CHARGING_CATEGORY_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('charging/category/charging_category_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $categoryName = $this->input->post('category_name');
                    $chargingCategoryNameData = $this->DataModel->getData('category_name = "'.$categoryName.'"', CHARGING_CATEGORY_TABLE);
                    
                    if($chargingCategoryNameData !== null && isset($chargingCategoryNameData['category_name']) && $chargingCategoryNameData['category_name'] == $categoryName){
                        $this->session->set_userdata('session_charging_category_new_category_name', "Category name $categoryName is already exits in database!");
                        redirect('new-charging-category');
                    } else {
                        $newData = array(
                            'category_name'=>$this->input->post('category_name'),
                            'category_status'=>$this->input->post('category_status')
                        );
                        $newDataEntry = $this->DataModel->insertData(CHARGING_CATEGORY_TABLE, $newData);
                        if($newDataEntry){
                            redirect('view-charging-category');  
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

    public function chargingCategoryView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_charging_category');
            }
            if(isset($_POST['submit_search'])){
                $searchChargingCategory = $this->input->post('search_charging_category');
                $this->session->set_userdata('session_charging_category', $searchChargingCategory);
            }
            $sessionChargingCategory = $this->session->userdata('session_charging_category');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_charging_category_status');
                redirect('view-charging-category');
            }
            
            $searchChargingCategoryStatus = $this->input->post('search_charging_category_status');
            if($searchChargingCategoryStatus === 'publish' or $searchChargingCategoryStatus == 'unpublish'){
                $this->session->set_userdata('session_charging_category_status', $searchChargingCategoryStatus);
            } else if($searchChargingCategoryStatus === 'all'){
                $this->session->unset_userdata('session_charging_category_status');
            }
            $sessionChargingCategoryStatus = $this->session->userdata('session_charging_category_status');
            
            $data = array();
            //get rows count
            $conditions['search_charging_category'] = $sessionChargingCategory;
            $conditions['search_charging_category_status'] = $sessionChargingCategoryStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewChargingCategory($conditions, CHARGING_CATEGORY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-charging-category');
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
            
            $chargingCategory = $this->DataModel->viewChargingCategory($conditions, CHARGING_CATEGORY_TABLE);
            $data['countChargingCategory'] = $this->DataModel->countChargingCategory($conditions, CHARGING_CATEGORY_TABLE);
            
            $data['viewChargingCategory'] = array();
            if(is_array($chargingCategory) || is_object($chargingCategory)){
                foreach($chargingCategory as $Row){
                    $dataArray = array();
                    $dataArray['category_id'] = $Row['category_id'];
                    $dataArray['category_name'] = $Row['category_name'];
                    $dataArray['category_status'] = $Row['category_status'];
                    $dataArray['countChargingData'] = $this->DataModel->countData('category_id = '.$dataArray['category_id'], CHARGING_DATA_TABLE);
                    array_push($data['viewChargingCategory'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('charging/category/charging_category_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }

    public function chargingCategoryEdit($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(CHARGING_CATEGORY_ALIAS, "can_edit");
            if($isPermission){
                $categoryID = urlDecodes($categoryID);
                if(ctype_digit($categoryID)){
                    $data['chargingCategoryData'] = $this->DataModel->getData('category_id = '.$categoryID, CHARGING_CATEGORY_TABLE);
                    if(!empty($data['chargingCategoryData'])){
                        $this->load->view('header');
                        $this->load->view('charging/category/charging_category_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'category_name'=>$this->input->post('category_name'),
                            'category_status'=>$this->input->post('category_status')
                        );
                        $editDataEntry = $this->DataModel->editData('category_id = '.$categoryID, CHARGING_CATEGORY_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-charging-category');
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
    
    public function chargingCategoryStatus($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(CHARGING_CATEGORY_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(CHARGING_CATEGORY_PUBLISH_ALIAS, "can_edit");
            $categoryID = urlDecodes($categoryID);
            if(ctype_digit($categoryID)){
                $chargingCategoryData = $this->DataModel->getData('category_id = '.$categoryID, CHARGING_CATEGORY_TABLE);
                if($chargingCategoryData['category_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'category_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'category_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('category_id = '.$categoryID, CHARGING_CATEGORY_TABLE, $editData);
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
    
    public function chargingCategoryDelete($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(CHARGING_CATEGORY_ALIAS, "can_delete");
            if($isPermission){
                $categoryID = urlDecodes($categoryID);
                if(ctype_digit($categoryID)){
                    $data['viewChargingData'] = $this->DataModel->getData('category_id = '.$categoryID, CHARGING_DATA_TABLE);
                    if(!empty($data['viewChargingData'])){
                        $this->session->set_userdata('session_charging_category_delete', "You can't delete charging category! Please delete charging data before deleting charging category");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {                            
                        $resultDataEntry = $this->DataModel->deleteData('category_id = '.$categoryID, CHARGING_CATEGORY_TABLE);
                        if($resultDataEntry){
                            redirect($_SERVER['HTTP_REFERER']);
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
}