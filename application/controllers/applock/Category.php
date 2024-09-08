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
	
    public function applockCategoryNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(APPLOCK_CATEGORY_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('applock/category/applock_category_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $categoryName = $this->input->post('category_name');
                    $applockCategoryNameData = $this->DataModel->getData('category_name = "'.$categoryName.'"', APPLOCK_CATEGORY_TABLE);
                    
                    if($applockCategoryNameData !== null && isset($applockCategoryNameData['category_name']) && $applockCategoryNameData['category_name'] == $categoryName){
                        $this->session->set_userdata('session_applock_category_new_category_name', "Category name $categoryName is already exits in database!");
                        redirect('new-applock-category');
                    } else {
                        $newData = array(
                            'category_name'=>$this->input->post('category_name'),
                            'category_status'=>$this->input->post('category_status')
                        );
                        $newDataEntry = $this->DataModel->insertData(APPLOCK_CATEGORY_TABLE, $newData);
                        if($newDataEntry){
                            redirect('view-applock-category');  
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
    
    public function applockCategoryView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_applock_category');
            }
            if(isset($_POST['submit_search'])){
                $searchApplockCategory = $this->input->post('search_applock_category');
                $this->session->set_userdata('session_applock_category', $searchApplockCategory);
            }
            $sessionApplockCategory = $this->session->userdata('session_applock_category');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_applock_category_status');
                redirect('view-applock-category');
            }
            
            $searchApplockCategoryStatus = $this->input->post('search_applock_category_status');
            if($searchApplockCategoryStatus === 'publish' or $searchApplockCategoryStatus == 'unpublish'){
                $this->session->set_userdata('session_applock_category_status', $searchApplockCategoryStatus);
            } else if($searchApplockCategoryStatus === 'all'){
                $this->session->unset_userdata('session_applock_category_status');
            }
            $sessionApplockCategoryStatus = $this->session->userdata('session_applock_category_status');
            
            $data = array();
            //get rows count
            $conditions['search_applock_category'] = $sessionApplockCategory;
            $conditions['search_applock_category_status'] = $sessionApplockCategoryStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewApplockCategory($conditions, APPLOCK_CATEGORY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-applock-category');
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
            
            $applockCategory = $this->DataModel->viewApplockCategory($conditions, APPLOCK_CATEGORY_TABLE);
            $data['countApplockCategory'] = $this->DataModel->countApplockCategory($conditions, APPLOCK_CATEGORY_TABLE);
            
            $data['viewApplockCategory'] = array();
            if(is_array($applockCategory) || is_object($applockCategory)){
                foreach($applockCategory as $Row){
                    $dataArray = array();
                    $dataArray['category_id'] = $Row['category_id'];
                    $dataArray['category_name'] = $Row['category_name'];
                    $dataArray['category_status'] = $Row['category_status'];
                    $dataArray['countApplockData'] = $this->DataModel->countData('category_id = '.$dataArray['category_id'], APPLOCK_DATA_TABLE);
                    array_push($data['viewApplockCategory'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('applock/category/applock_category_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }

    public function applockCategoryEdit($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(APPLOCK_CATEGORY_ALIAS, "can_edit");
            if($isPermission){
                $categoryID = urlDecodes($categoryID);
                if(ctype_digit($categoryID)){
                    $data['applockCategoryData'] = $this->DataModel->getData('category_id = '.$categoryID, APPLOCK_CATEGORY_TABLE);
                    if(!empty($data['applockCategoryData'])){
                        $this->load->view('header');
                        $this->load->view('applock/category/applock_category_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'category_name'=>$this->input->post('category_name'),
                            'category_status'=>$this->input->post('category_status')
                        );
                        $editDataEntry = $this->DataModel->editData('category_id = '.$categoryID, APPLOCK_CATEGORY_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-applock-category');
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
    
    public function applockCategoryStatus($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(APPLOCK_CATEGORY_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(APPLOCK_CATEGORY_PUBLISH_ALIAS, "can_edit");
            $categoryID = urlDecodes($categoryID);
            if(ctype_digit($categoryID)){
                $applockCategoryData = $this->DataModel->getData('category_id = '.$categoryID, APPLOCK_CATEGORY_TABLE);
                if($applockCategoryData['category_status'] == "publish"){
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
    			$editDataEntry = $this->DataModel->editData('category_id = '.$categoryID, APPLOCK_CATEGORY_TABLE, $editData);
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
    
    public function applockCategoryDelete($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(APPLOCK_CATEGORY_ALIAS, "can_delete");
            if($isPermission){
                $categoryID = urlDecodes($categoryID);
                if(ctype_digit($categoryID)){
                    $data['viewApplockData'] = $this->DataModel->getData('category_id = '.$categoryID, APPLOCK_DATA_TABLE);
                    if(!empty($data['viewApplockData'])){
                        $this->session->set_userdata('session_applock_category_delete', "You can't delete applock category! Please delete applock data before deleting applock category");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {                            
                        $resultDataEntry = $this->DataModel->deleteData('category_id = '.$categoryID, APPLOCK_CATEGORY_TABLE);
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