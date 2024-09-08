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
	
    public function keyboardCategoryNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(KEYBOARD_CATEGORY_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('keyboard/category/keyboard_category_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $categoryName = $this->input->post('category_name');
                    $keyboardCategoryNameData = $this->DataModel->getData('category_name = "'.$categoryName.'"', KEYBOARD_CATEGORY_TABLE);
                    
                    if($keyboardCategoryNameData !== null && isset($keyboardCategoryNameData['category_name']) && $keyboardCategoryNameData['category_name'] == $categoryName){
                        $this->session->set_userdata('session_keyboard_category_new_category_name', "Category name $categoryName is already exits in database!");
                        redirect('new-keyboard-category');
                    } else {
                        $newData = array(
                            'category_name'=>$this->input->post('category_name'),
                            'category_status'=>$this->input->post('category_status')
                        );
                        $newDataEntry = $this->DataModel->insertData(KEYBOARD_CATEGORY_TABLE, $newData);
                        if($newDataEntry){
                            redirect('view-keyboard-category');  
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
    
    public function keyboardCategoryView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_keyboard_category');
            }
            if(isset($_POST['submit_search'])){
                $searchKeyboardCategory = $this->input->post('search_keyboard_category');
                $this->session->set_userdata('session_keyboard_category', $searchKeyboardCategory);
            }
            $sessionKeyboardCategory = $this->session->userdata('session_keyboard_category');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_keyboard_category_status');
                redirect('view-keyboard-category');
            }
                
            $searchKeyboardCategoryStatus = $this->input->post('search_keyboard_category_status');
            if($searchKeyboardCategoryStatus === 'publish' or $searchKeyboardCategoryStatus == 'unpublish'){
                $this->session->set_userdata('session_keyboard_category_status', $searchKeyboardCategoryStatus);
            } else if($searchKeyboardCategoryStatus === 'all'){
                $this->session->unset_userdata('session_keyboard_category_status');
            }
            $sessionKeyboardCategoryStatus = $this->session->userdata('session_keyboard_category_status');
            
            $data = array();
            //get rows count
            $conditions['search_keyboard_category'] = $sessionKeyboardCategory;
            $conditions['search_keyboard_category_status'] = $sessionKeyboardCategoryStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewKeyboardCategory($conditions, KEYBOARD_CATEGORY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-keyboard-category');
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
            
            $keyboardCategory = $this->DataModel->viewKeyboardCategory($conditions, KEYBOARD_CATEGORY_TABLE);
            $data['countKeyboardCategory'] = $this->DataModel->countKeyboardCategory($conditions, KEYBOARD_CATEGORY_TABLE);
            
            $data['viewKeyboardCategory'] = array();
            if(is_array($keyboardCategory) || is_object($keyboardCategory)){
                foreach($keyboardCategory as $Row){
                    $dataArray = array();
                    $dataArray['category_id'] = $Row['category_id'];
                    $dataArray['category_name'] = $Row['category_name'];
                    $dataArray['category_status'] = $Row['category_status'];
                    $dataArray['countKeyboardData'] = $this->DataModel->countData('category_id = '.$dataArray['category_id'], KEYBOARD_DATA_TABLE);
                    array_push($data['viewKeyboardCategory'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('keyboard/category/keyboard_category_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function keyboardCategoryEdit($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(KEYBOARD_CATEGORY_ALIAS, "can_edit");
            if($isPermission){
                $categoryID = urlDecodes($categoryID);
                if(ctype_digit($categoryID)){
                    $data['keyboardCategoryData'] = $this->DataModel->getData('category_id = '.$categoryID, KEYBOARD_CATEGORY_TABLE);
                    if(!empty($data['keyboardCategoryData'])){
                        $this->load->view('header');
                        $this->load->view('keyboard/category/keyboard_category_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'category_name'=>$this->input->post('category_name'),
                            'category_status'=>$this->input->post('category_status')
                        );
                        $editDataEntry = $this->DataModel->editData('category_id = '.$categoryID, KEYBOARD_CATEGORY_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-keyboard-category');
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
    
    public function keyboardCategoryStatus($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(KEYBOARD_CATEGORY_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(KEYBOARD_CATEGORY_PUBLISH_ALIAS, "can_edit");
            $categoryID = urlDecodes($categoryID);
            if(ctype_digit($categoryID)){
                $keyboardCategoryData = $this->DataModel->getData('category_id = '.$categoryID, KEYBOARD_CATEGORY_TABLE);
                if($keyboardCategoryData['category_status'] == "publish"){
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
    			$editDataEntry = $this->DataModel->editData('category_id = '.$categoryID, KEYBOARD_CATEGORY_TABLE, $editData);
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
    
    public function keyboardCategoryDelete($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(KEYBOARD_CATEGORY_ALIAS, "can_delete");
            if($isPermission){
                $categoryID = urlDecodes($categoryID);
                if(ctype_digit($categoryID)){
                    $data['viewKeyboardData'] = $this->DataModel->getData('category_id = '.$categoryID, KEYBOARD_DATA_TABLE);
                    if(!empty($data['viewKeyboardData'])){
                        $this->session->set_userdata('session_keyboard_category_delete', "You can't delete keyboard category! Please delete keyboard data before deleting keyboard category");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {                            
                        $resultDataEntry = $this->DataModel->deleteData('category_id = '.$categoryID, KEYBOARD_CATEGORY_TABLE);
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
