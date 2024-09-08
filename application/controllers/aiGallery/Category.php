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
	
    public function aiGalleryCategoryNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_GALLERY_CATEGORY_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('aiGallery/category/ai_gallery_category_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $categoryName = $this->input->post('category_name');
                    $aiGalleryCategoryNameData = $this->DataModel->getData('category_name = "'.$categoryName.'"', AI_GALLERY_CATEGORY_TABLE);
                    
                    if($aiGalleryCategoryNameData !== null && isset($aiGalleryCategoryNameData['category_name']) && $aiGalleryCategoryNameData['category_name'] == $categoryName){
                        $this->session->set_userdata('session_ai_gallery_category_new_category_name', "Category name $categoryName is already exits in database!");
                        redirect('new-ai-gallery-category');
                    } else {
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
    
                        $iconName = $_FILES['category_icon']['name'];
                        $iconTemp = $_FILES['category_icon']['tmp_name'];
                        $iconPath = ICON_PATH;
                        $iconResponse = newAiBucketObject($iconName, $uniqueCode, $iconTemp, $iconPath);
                    
                        $newData = array(
                            'category_name'=>$this->input->post('category_name'),
                            'category_icon'=>$iconResponse,
                            'category_status'=>$this->input->post('category_status')
                        );
                        $lastInsertID = $this->DataModel->insertData(AI_GALLERY_CATEGORY_TABLE, $newData);
                        if($lastInsertID){
                            $editData = array(
                                'category_position'=>$lastInsertID
                            );
                            $editDataEntry = $this->DataModel->editData('category_id = '.$lastInsertID, AI_GALLERY_CATEGORY_TABLE, $editData);
                            if($editDataEntry){
                                redirect('view-ai-gallery-category');  
                            }
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
    
    public function aiGalleryCategoryView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_gallery_category');
            }
            if(isset($_POST['submit_search'])){
                $searchAiGalleryCategory = $this->input->post('search_ai_gallery_category');
                $this->session->set_userdata('session_ai_gallery_category', $searchAiGalleryCategory);
            }
            $sessionAiGalleryCategory = $this->session->userdata('session_ai_gallery_category');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_gallery_category_status');
                redirect('view-ai-gallery-category');
            }
            
            $searchAiGalleryCategoryStatus = $this->input->post('search_ai_gallery_category_status');
            if($searchAiGalleryCategoryStatus === 'publish' or $searchAiGalleryCategoryStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_gallery_category_status', $searchAiGalleryCategoryStatus);
            } else if($searchAiGalleryCategoryStatus === 'all'){
                $this->session->unset_userdata('session_ai_gallery_category_status');
            }
            $sessionAiGalleryCategoryStatus = $this->session->userdata('session_ai_gallery_category_status');
            
            $data = array();
            //get rows count
            $conditions['search_ai_gallery_category'] = $sessionAiGalleryCategory;
            $conditions['search_ai_gallery_category_status'] = $sessionAiGalleryCategoryStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiGalleryCategory($conditions, AI_GALLERY_CATEGORY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-gallery-category');
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
            
            $aiGalleryCategory = $this->DataModel->viewAiGalleryCategory($conditions, AI_GALLERY_CATEGORY_TABLE);
            $data['countAiGalleryCategory'] = $this->DataModel->countAiGalleryCategory($conditions, AI_GALLERY_CATEGORY_TABLE);
            
            $data['viewAiGalleryCategory'] = array();
            if(is_array($aiGalleryCategory) || is_object($aiGalleryCategory)){
                foreach($aiGalleryCategory as $Row){
                    $dataArray = array();
                    $dataArray['category_id'] = $Row['category_id'];
                    $dataArray['category_name'] = $Row['category_name'];
                    $dataArray['category_icon'] = $Row['category_icon'];
                    $dataArray['category_position'] = $Row['category_position'];
                    $dataArray['category_status'] = $Row['category_status'];
                    $dataArray['countAiGalleryImage'] = $this->DataModel->countData('category_id = '.$dataArray['category_id'], AI_GALLERY_IMAGE_TABLE);
                    array_push($data['viewAiGalleryCategory'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiGallery/category/ai_gallery_category_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }

    public function aiGalleryCategoryEdit($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_GALLERY_CATEGORY_ALIAS, "can_edit");
            if($isPermission){
                $categoryID = urlDecodes($categoryID);
                if(ctype_digit($categoryID)){
                    $data['aiGalleryCategoryData'] = $this->DataModel->getData('category_id = '.$categoryID, AI_GALLERY_CATEGORY_TABLE);
                    if(!empty($data['aiGalleryCategoryData'])){
                        $this->load->view('header');
                        $this->load->view('aiGallery/category/ai_gallery_category_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        if(empty($_FILES['category_icon']['name'])){
                            $editData = array(
                                'category_name'=>$this->input->post('category_name'),
                                'category_position'=>$this->input->post('category_position'),
                                'category_status'=>$this->input->post('category_status')
                            );
                        } else {
                            $s3Client = getconfig();
                            $uniqueCode = uniqueKey();
                        
                            $iconKey = $data['aiGalleryCategoryData']['category_icon'];
    	                    $newIconKey = basename($iconKey);
    	                
                            $deleteIcon = $s3Client->deleteObject([
    	                        'Bucket' => AI_BUCKET_NAME,
    	                        'Key'    => ICON_PATH.$newIconKey,
    	                    ]);

    	                    $iconName = $_FILES['category_icon']['name'];
    	            	    $iconTemp = $_FILES['category_icon']['tmp_name'];
    	            	    $iconPath = ICON_PATH;
    	                    $iconResponse = newAiBucketObject($iconName, $uniqueCode, $iconTemp, $iconPath);
                            
                            $editData = array(
                                'category_name'=>$this->input->post('category_name'),
                                'category_icon'=>$iconResponse,
                                'category_position'=>$this->input->post('category_position'),
                                'category_status'=>$this->input->post('category_status')
                            );
                        }
                        $editDataEntry = $this->DataModel->editData('category_id = '.$categoryID, AI_GALLERY_CATEGORY_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-ai-gallery-category');
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
    
    public function aiGalleryCategoryStatus($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_GALLERY_CATEGORY_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_GALLERY_CATEGORY_PUBLISH_ALIAS, "can_edit");
            $categoryID = urlDecodes($categoryID);
            if(ctype_digit($categoryID)){
                $aiGalleryCategoryData = $this->DataModel->getData('category_id = '.$categoryID, AI_GALLERY_CATEGORY_TABLE);
                if($aiGalleryCategoryData['category_status'] == "publish"){
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
    			$editDataEntry = $this->DataModel->editData('category_id = '.$categoryID, AI_GALLERY_CATEGORY_TABLE, $editData);
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
    
    public function aiGalleryCategoryDelete($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_GALLERY_CATEGORY_ALIAS, "can_delete");
            if($isPermission){ 
                $categoryID = urlDecodes($categoryID);
                if(ctype_digit($categoryID)){
                    $data['viewAiGalleryImageData'] = $this->DataModel->getData('category_id = '.$categoryID, AI_GALLERY_IMAGE_TABLE);
                    if(!empty($data['viewAiGalleryImageData'])){
                        $this->session->set_userdata('session_ai_gallery_category_delete', "You can't delete ai gallery category! Please delete ai gallery image before deleting ai gallery category");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {                            
                        $data['aiGalleryCategoryData'] = $this->DataModel->getData('category_id = '.$categoryID, AI_GALLERY_CATEGORY_TABLE);
                        $s3Client = getConfig();
                        
                        $iconKey = $data['aiGalleryCategoryData']['category_icon'];
    	                $newIconKey = basename($iconKey);
    	                
                        $deleteIcon = $s3Client->deleteObject([
                            'Bucket' => AI_BUCKET_NAME,
                            'Key'    => ICON_PATH.$newIconKey,
                        ]);
                       
                        $resultDataEntry = $this->DataModel->deleteData('category_id = '.$categoryID, AI_GALLERY_CATEGORY_TABLE);
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