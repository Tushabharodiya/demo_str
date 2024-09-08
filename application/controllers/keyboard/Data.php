<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
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
	
    public function keyboardDataNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(KEYBOARD_DATA_ALIAS, "can_add");
            if($isPermission){
                $data['keyboardCategoryData'] = $this->DataModel->viewData(null, null, KEYBOARD_CATEGORY_TABLE);
                $this->load->view('header');
                $this->load->view('keyboard/data/keyboard_data_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $keyboardName = $this->input->post('keyboard_name');
                    $keyboardNameData = $this->DataModel->getData('keyboard_name = "'.$keyboardName.'"', KEYBOARD_DATA_TABLE);
                    
                    if($keyboardNameData !== null && isset($keyboardNameData['keyboard_name']) && $keyboardNameData['keyboard_name'] == $keyboardName){
                        $this->session->set_userdata('session_keyboard_data_new_keyboard_name', "Keyboard name $keyboardName is already exits in database!");
                        redirect('new-keyboard-data');
                    } else {
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
    
                        $thumbnailName = $_FILES['keyboard_thumbnail']['name'];
                        $thumbnailTemp = $_FILES['keyboard_thumbnail']['tmp_name'];
                        $thumbnailPath = THUMBNAIL_PATH;
                        $thumbnailResponse = newKeyboardBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
                        
                        $allowedThumbnailTypes = array('image/png');
                        $thumbnailType = $_FILES['keyboard_thumbnail']['type'];
    
                        if(in_array($thumbnailType, $allowedThumbnailTypes)){
                            $keyboardThumbnail = $thumbnailResponse;
                        } else {
                            redirect('new-keyboard-data');
                        }
                        
                        $bundleName = $_FILES['keyboard_bundle']['name'];
                        $bundleTemp = $_FILES['keyboard_bundle']['tmp_name'];
                        $bundlePath = BUNDLE_PATH;
                        $bundleResponse = newKeyboardBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
                        
                        $allowedBundleTypes = array('application/x-zip-compressed');
                        $bundleType = $_FILES['keyboard_bundle']['type'];
    
                        if(in_array($bundleType, $allowedBundleTypes)){
                            $keyboardBundle = $bundleResponse;
                        } else {
                            redirect('new-keyboard-data');
                        }
                        
                        $newData = array(
                            'category_id'=>$this->input->post('category_id'),
                            'keyboard_name'=>$this->input->post('keyboard_name'),
                            'keyboard_thumbnail'=>$keyboardThumbnail,
                            'keyboard_bundle'=>$keyboardBundle,
                            'keyboard_view'=>0,
                            'keyboard_download'=>0,
                            'keyboard_premium'=>$this->input->post('keyboard_premium'),
                            'created_date'=>timeZone(),
                            'keyboard_status'=>$this->input->post('keyboard_status')
                        );
                        $newDataEntry = $this->DataModel->insertData(KEYBOARD_DATA_TABLE, $newData);
                        if($newDataEntry){
                            redirect('view-keyboard-data');  
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
    
    public function keyboardDataView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_keyboard_data');
            }
            if(isset($_POST['submit_search'])){
                $searchKeyboardData = $this->input->post('search_keyboard_data');
                $this->session->set_userdata('session_keyboard_data', $searchKeyboardData);
            }
            $sessionKeyboardData = $this->session->userdata('session_keyboard_data');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_keyboard_data_premium');
                $this->session->unset_userdata('session_keyboard_data_status');
                redirect('view-keyboard-data');
            }
            
            $searchKeyboardDataPremium = $this->input->post('search_keyboard_data_premium');
            if($searchKeyboardDataPremium === 'true' or $searchKeyboardDataPremium == 'false'){
                $this->session->set_userdata('session_keyboard_data_premium', $searchKeyboardDataPremium);
            } else if($searchKeyboardDataPremium === 'all'){
                $this->session->unset_userdata('session_keyboard_data_premium');
            }
            $sessionKeyboardDataPremium = $this->session->userdata('session_keyboard_data_premium');
            
            $searchKeyboardDataStatus = $this->input->post('search_keyboard_data_status');
            if($searchKeyboardDataStatus === 'publish' or $searchKeyboardDataStatus == 'unpublish'){
                $this->session->set_userdata('session_keyboard_data_status', $searchKeyboardDataStatus);
            } else if($searchKeyboardDataStatus === 'all'){
                $this->session->unset_userdata('session_keyboard_data_status');
            }
            $sessionKeyboardDataStatus = $this->session->userdata('session_keyboard_data_status');
            
            if(isset($_POST['reset_order'])){
                $this->session->unset_userdata('session_keyboard_data_view');
                $this->session->unset_userdata('session_keyboard_data_download');
                redirect('view-keyboard-data');
            }
            
            $searchKeyboardDataView = $this->input->post('search_keyboard_data_view');
            if($searchKeyboardDataView === 'asc' or $searchKeyboardDataView == 'desc'){
                $this->session->set_userdata('session_keyboard_data_view', $searchKeyboardDataView);
            } else if($searchKeyboardDataView === 'all'){
                $this->session->unset_userdata('session_keyboard_data_view');
            }
            $sessionKeyboardDataView = $this->session->userdata('session_keyboard_data_view');
            
            $searchKeyboardDataDownload = $this->input->post('search_keyboard_data_download');
            if($searchKeyboardDataDownload === 'asc' or $searchKeyboardDataDownload == 'desc'){
                $this->session->set_userdata('session_keyboard_data_download', $searchKeyboardDataDownload);
            } else if($searchKeyboardDataDownload === 'all'){
                $this->session->unset_userdata('session_keyboard_data_download');
            }
            $sessionKeyboardDataDownload = $this->session->userdata('session_keyboard_data_download');

            $data = array();
            //get rows count
            $conditions['search_keyboard_data'] = $sessionKeyboardData;
            $conditions['search_keyboard_data_premium'] = $sessionKeyboardDataPremium;
            $conditions['search_keyboard_data_status'] = $sessionKeyboardDataStatus;
            $conditions['search_keyboard_data_view'] = $sessionKeyboardDataView;
            $conditions['search_keyboard_data_download'] = $sessionKeyboardDataDownload;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewKeyboardData($conditions, KEYBOARD_DATA_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-keyboard-data');
            $config['uri_segment'] = 2;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 20;
            
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
            $conditions['limit'] = 20;
            
            $keyboardData = $this->DataModel->viewKeyboardData($conditions, KEYBOARD_DATA_TABLE);
            $data['countKeyboardData'] = $this->DataModel->countKeyboardData($conditions, KEYBOARD_DATA_TABLE);
            
            $data['viewKeyboardData'] = array();
            if(is_array($keyboardData) || is_object($keyboardData)){
                foreach($keyboardData as $Row){
                    $dataArray = array();
                    $dataArray['keyboard_id'] = $Row['keyboard_id'];
                    $dataArray['category_id'] = $Row['category_id'];
                    $dataArray['keyboard_name'] = $Row['keyboard_name'];
                    $dataArray['keyboard_thumbnail'] = $Row['keyboard_thumbnail'];
                    $dataArray['keyboard_bundle'] = $Row['keyboard_bundle'];
                    $dataArray['keyboard_view'] = $Row['keyboard_view'];
                    $dataArray['keyboard_download'] = $Row['keyboard_download'];
                    $dataArray['keyboard_premium'] = $Row['keyboard_premium'];
                    $dataArray['created_date'] = $Row['created_date'];
                    $dataArray['keyboard_status'] = $Row['keyboard_status'];
                    $dataArray['keyboardCategoryData'] = $this->DataModel->getData('category_id = '.$dataArray['category_id'], KEYBOARD_CATEGORY_TABLE);
                    array_push($data['viewKeyboardData'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('keyboard/data/keyboard_data_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function keyboardCategoryDataView($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $categoryID = urlDecodes($categoryID);
            if(ctype_digit($categoryID)){
                if(isset($_POST['reset_search'])){
                    $this->session->unset_userdata('session_keyboard_category_data');
                }
                if(isset($_POST['submit_search'])){
                    $searchKeyboardCategoryData = $this->input->post('search_keyboard_category_data');
                    $this->session->set_userdata('session_keyboard_category_data', $searchKeyboardCategoryData);
                }
                $sessionKeyboardCategoryData = $this->session->userdata('session_keyboard_category_data');
                
                if(isset($_POST['reset_filter'])){
                    $this->session->unset_userdata('session_keyboard_category_data_premium');
                    $this->session->unset_userdata('session_keyboard_category_data_status');
                    redirect('view-keyboard-category-data/'.urlEncodes($categoryID));
                }
                
                $searchKeyboardCategoryDataPremium = $this->input->post('search_keyboard_category_data_premium');
                if($searchKeyboardCategoryDataPremium === 'true' or $searchKeyboardCategoryDataPremium == 'false'){
                    $this->session->set_userdata('session_keyboard_category_data_premium', $searchKeyboardCategoryDataPremium);
                } else if($searchKeyboardCategoryDataPremium === 'all'){
                    $this->session->unset_userdata('session_keyboard_category_data_premium');
                }
                $sessionKeyboardCategoryDataPremium = $this->session->userdata('session_keyboard_category_data_premium');
                
                $searchKeyboardCategoryDataStatus = $this->input->post('search_keyboard_category_data_status');
                if($searchKeyboardCategoryDataStatus === 'publish' or $searchKeyboardCategoryDataStatus == 'unpublish'){
                    $this->session->set_userdata('session_keyboard_category_data_status', $searchKeyboardCategoryDataStatus);
                } else if($searchKeyboardCategoryDataStatus === 'all'){
                    $this->session->unset_userdata('session_keyboard_category_data_status');
                }
                $sessionKeyboardCategoryDataStatus = $this->session->userdata('session_keyboard_category_data_status');
                
                if(isset($_POST['reset_order'])){
                    $this->session->unset_userdata('session_keyboard_category_data_view');
                    $this->session->unset_userdata('session_keyboard_category_data_download');
                    redirect('view-keyboard-category-data/'.urlEncodes($categoryID));
                }
                
                $searchKeyboardCategoryDataView = $this->input->post('search_keyboard_category_data_view');
                if($searchKeyboardCategoryDataView === 'asc' or $searchKeyboardCategoryDataView == 'desc'){
                    $this->session->set_userdata('session_keyboard_category_data_view', $searchKeyboardCategoryDataView);
                } else if($searchKeyboardCategoryDataView === 'all'){
                    $this->session->unset_userdata('session_keyboard_category_data_view');
                }
                $sessionKeyboardCategoryDataView = $this->session->userdata('session_keyboard_category_data_view');
                
                $searchKeyboardCategoryDataDownload = $this->input->post('search_keyboard_category_data_download');
                if($searchKeyboardCategoryDataDownload === 'asc' or $searchKeyboardCategoryDataDownload == 'desc'){
                    $this->session->set_userdata('session_keyboard_category_data_download', $searchKeyboardCategoryDataDownload);
                } else if($searchKeyboardCategoryDataDownload === 'all'){
                    $this->session->unset_userdata('session_keyboard_category_data_download');
                }
                $sessionKeyboardCategoryDataDownload = $this->session->userdata('session_keyboard_category_data_download');
                
                $data = array();
                //get rows count
                $conditions['search_keyboard_category_data'] = $sessionKeyboardCategoryData;
                $conditions['search_keyboard_category_data_premium'] = $sessionKeyboardCategoryDataPremium;
                $conditions['search_keyboard_category_data_status'] = $sessionKeyboardCategoryDataStatus;
                $conditions['search_keyboard_category_data_view'] = $sessionKeyboardCategoryDataView;
                $conditions['search_keyboard_category_data_download'] = $sessionKeyboardCategoryDataDownload;
                $conditions['returnType'] = 'count';
                
                $totalRec = $this->DataModel->viewKeyboardCategoryData($conditions, $categoryID, KEYBOARD_DATA_TABLE);
        
                //pagination config
                $config['base_url']    = site_url('view-keyboard-category-data/'.urlEncodes($categoryID));
                $config['uri_segment'] = 3;
                $config['total_rows']  = $totalRec;
                $config['per_page']    = 20;
                
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
                $page = $this->uri->segment(3);
                $offset = !$page?0:$page;
                
                //get rows
                $conditions['returnType'] = '';
                $conditions['start'] = $offset;
                $conditions['limit'] = 20;
                
                $keyboardCategoryData = $this->DataModel->viewKeyboardCategoryData($conditions, $categoryID, KEYBOARD_DATA_TABLE);
                $data['countKeyboardCategoryData'] = $this->DataModel->countKeyboardCategoryData($conditions, $categoryID, KEYBOARD_DATA_TABLE);
                
                $data['viewKeyboardCategoryData'] = array();
                if(is_array($keyboardCategoryData) || is_object($keyboardCategoryData)){
                    foreach($keyboardCategoryData as $Row){
                        $dataArray = array();
                        $dataArray['keyboard_id'] = $Row['keyboard_id'];
                        $dataArray['category_id'] = $Row['category_id'];
                        $dataArray['keyboard_name'] = $Row['keyboard_name'];
                        $dataArray['keyboard_thumbnail'] = $Row['keyboard_thumbnail'];
                        $dataArray['keyboard_bundle'] = $Row['keyboard_bundle'];
                        $dataArray['keyboard_view'] = $Row['keyboard_view'];
                        $dataArray['keyboard_download'] = $Row['keyboard_download'];
                        $dataArray['keyboard_premium'] = $Row['keyboard_premium'];
                        $dataArray['created_date'] = $Row['created_date'];
                        $dataArray['keyboard_status'] = $Row['keyboard_status'];
                        $dataArray['keyboardCategoryData'] = $this->DataModel->getData('category_id = '.$dataArray['category_id'], KEYBOARD_CATEGORY_TABLE);
                        array_push($data['viewKeyboardCategoryData'], $dataArray);
                    }
                }
                $this->load->view('header');
                $this->load->view('keyboard/data/keyboard_category_data_view', $data);
                $this->load->view('footer');
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }

    public function keyboardDataEdit($keyboardID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(KEYBOARD_DATA_ALIAS, "can_edit");
            if($isPermission){
                $keyboardID = urlDecodes($keyboardID);
                if(ctype_digit($keyboardID)){
                    $data['keyboardData'] = $this->DataModel->getData('keyboard_id = '.$keyboardID, KEYBOARD_DATA_TABLE);
                    $data['viewKeyboardCategory'] = $this->DataModel->viewData(null, null, KEYBOARD_CATEGORY_TABLE);
                    $categoryID = $data['keyboardData']['category_id'];
                    $data['keyboardCategoryData'] = $this->DataModel->getData('category_id = '.$categoryID, KEYBOARD_CATEGORY_TABLE);
                    if(!empty($data['keyboardData'])){
                        $this->load->view('header');
                        $this->load->view('keyboard/data/keyboard_data_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
                        
                        $thumbnailKey = $data['keyboardData']['keyboard_thumbnail'];
    	                $newThumbnailKey = basename($thumbnailKey);
    	                
    	                $bundleKey = $data['keyboardData']['keyboard_bundle'];
    	                $newBundleKey = basename($bundleKey);
    
                        if (!empty($_FILES['keyboard_thumbnail']['name']) and !empty($_FILES['keyboard_bundle']['name'])){
                            $thumbnailName = $_FILES['keyboard_thumbnail']['name'];
    	            	    $thumbnailTemp = $_FILES['keyboard_thumbnail']['tmp_name'];
    	            	    $thumbnailPath = THUMBNAIL_PATH;
    	                    $thumbnailResponse = newKeyboardBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
    	                    
    	                    $allowedThumbnailTypes = array('image/png');
                            $thumbnailType = $_FILES['keyboard_thumbnail']['type'];
        
                            if(in_array($thumbnailType, $allowedThumbnailTypes)){
                                $keyboardThumbnail = $thumbnailResponse;
                            } else {
                                redirect('edit-keyboard-data/'.urlEncodes($keyboardID));
                            }
                            
                            $bundleName = $_FILES['keyboard_bundle']['name'];
    	            	    $bundleTemp = $_FILES['keyboard_bundle']['tmp_name'];
    	            	    $bundlePath = BUNDLE_PATH;
    	                    $bundleResponse = newKeyboardBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
    	                    
    	                    $allowedBundleTypes = array('application/x-zip-compressed');
                            $bundleType = $_FILES['keyboard_bundle']['type'];
        
                            if(in_array($bundleType, $allowedBundleTypes)){
                                $keyboardBundle = $bundleResponse;
                            } else {
                                redirect('edit-keyboard-data/'.urlEncodes($keyboardID));
                            }

                            $deleteThumbnail = $s3Client->deleteObject([
    	                        'Bucket' => KEYBOARD_BUCKET_NAME,
    	                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
    	                    ]);
    	                    $deleteBundle = $s3Client->deleteObject([
    	                        'Bucket' => KEYBOARD_BUCKET_NAME,
    	                        'Key'    => BUNDLE_PATH.$newBundleKey,
    	                    ]);
    	                    
                            $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'keyboard_name'=>$this->input->post('keyboard_name'),
                                'keyboard_thumbnail'=>$keyboardThumbnail,
                                'keyboard_bundle'=>$keyboardBundle,
                                'keyboard_premium'=>$this->input->post('keyboard_premium'),
                                'keyboard_status'=>$this->input->post('keyboard_status')
                            );
                        } else if(!empty($_FILES['keyboard_thumbnail']['name'])){
    	                    $thumbnailName = $_FILES['keyboard_thumbnail']['name'];
    	            	    $thumbnailTemp = $_FILES['keyboard_thumbnail']['tmp_name'];
    	            	    $thumbnailPath = THUMBNAIL_PATH;
    	                    $thumbnailResponse = newKeyboardBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
    	                    
    	                    $allowedThumbnailTypes = array('image/png');
                            $thumbnailType = $_FILES['keyboard_thumbnail']['type'];
        
                            if(in_array($thumbnailType, $allowedThumbnailTypes)){
                                $keyboardThumbnail = $thumbnailResponse;
                            } else {
                                redirect('edit-keyboard-data/'.urlEncodes($keyboardID));
                            }
                            
                            $deleteThumbnail = $s3Client->deleteObject([
    	                        'Bucket' => KEYBOARD_BUCKET_NAME,
    	                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
    	                    ]);
    	                    
    	                     $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'keyboard_name'=>$this->input->post('keyboard_name'),
                                'keyboard_thumbnail'=>$keyboardThumbnail,
                                'keyboard_premium'=>$this->input->post('keyboard_premium'),
                                'keyboard_status'=>$this->input->post('keyboard_status')
                            );
                        } else if(!empty($_FILES['keyboard_bundle']['name'])){
    	                    $bundleName = $_FILES['keyboard_bundle']['name'];
    	            	    $bundleTemp = $_FILES['keyboard_bundle']['tmp_name'];
    	            	    $bundlePath = BUNDLE_PATH;
    	                    $bundleResponse = newKeyboardBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
    	                    
    	                    $allowedBundleTypes = array('application/x-zip-compressed');
                            $bundleType = $_FILES['keyboard_bundle']['type'];
        
                            if(in_array($bundleType, $allowedBundleTypes)){
                                $keyboardBundle = $bundleResponse;
                            } else {
                                redirect('edit-keyboard-data/'.urlEncodes($keyboardID));
                            }
                            
                            $deleteBundle = $s3Client->deleteObject([
    	                        'Bucket' => KEYBOARD_BUCKET_NAME,
    	                        'Key'    => BUNDLE_PATH.$newBundleKey,
    	                    ]);
    	                    
    	                     $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'keyboard_name'=>$this->input->post('keyboard_name'),
                                'keyboard_bundle'=>$keyboardBundle,
                                'keyboard_premium'=>$this->input->post('keyboard_premium'),
                                'keyboard_status'=>$this->input->post('keyboard_status')
                            );
                        } else {
                            $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'keyboard_name'=>$this->input->post('keyboard_name'),
                                'keyboard_premium'=>$this->input->post('keyboard_premium'),
                                'keyboard_status'=>$this->input->post('keyboard_status')
                            );
                        }
                        $editDataEntry = $this->DataModel->editData('keyboard_id = '.$keyboardID, KEYBOARD_DATA_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-keyboard-data');
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
    
    public function keyboardDataPremium($keyboardID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(KEYBOARD_DATA_PREMIUM_ALIAS, "can_edit");
            $isPermission2 = checkPermission(KEYBOARD_DATA_FREE_ALIAS, "can_edit");
            $keyboardID = urlDecodes($keyboardID);
            if(ctype_digit($keyboardID)){
                $keyboardData = $this->DataModel->getData('keyboard_id = '.$keyboardID, KEYBOARD_DATA_TABLE);
                if($keyboardData['keyboard_premium'] == "true"){
                    if($isPermission1){
        	            $editData = array(
                		    'keyboard_premium'=>"false",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'keyboard_premium'=>"true",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('keyboard_id = '.$keyboardID, KEYBOARD_DATA_TABLE, $editData);
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
    
    public function keyboardDataStatus($keyboardID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(KEYBOARD_DATA_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(KEYBOARD_DATA_PUBLISH_ALIAS, "can_edit");
            $keyboardID = urlDecodes($keyboardID);
            if(ctype_digit($keyboardID)){
                $keyboardData = $this->DataModel->getData('keyboard_id = '.$keyboardID, KEYBOARD_DATA_TABLE);
                if($keyboardData['keyboard_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'keyboard_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'keyboard_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('keyboard_id = '.$keyboardID, KEYBOARD_DATA_TABLE, $editData);
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
    
    public function keyboardDataDelete($keyboardID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(KEYBOARD_DATA_ALIAS, "can_delete");
            if($isPermission){ 
                $keyboardID = urlDecodes($keyboardID);
                if(ctype_digit($keyboardID)){
                    
                    $data['keyboardData'] = $this->DataModel->getData('keyboard_id = '.$keyboardID, KEYBOARD_DATA_TABLE);
                    $s3Client = getConfig();
                    
                    $thumbnailKey = $data['keyboardData']['keyboard_thumbnail'];
	                $newThumbnailKey = basename($thumbnailKey);
	                
	                $bundleKey = $data['keyboardData']['keyboard_bundle'];
	                $newBundleKey = basename($bundleKey);
                    
                    $deleteThumbnail = $s3Client->deleteObject([
                        'Bucket' => KEYBOARD_BUCKET_NAME,
                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
                    ]);
                    $deleteBundle = $s3Client->deleteObject([
                        'Bucket' => KEYBOARD_BUCKET_NAME,
                        'Key'    => BUNDLE_PATH.$newBundleKey,
                    ]);
                    
                    $resultDataEntry = $this->DataModel->deleteData('keyboard_id = '.$keyboardID, KEYBOARD_DATA_TABLE);
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
