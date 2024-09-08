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
	
    public function applockDataNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(APPLOCK_DATA_ALIAS, "can_add");
            if($isPermission){
                $data['applockCategoryData'] = $this->DataModel->viewData(null, null, APPLOCK_CATEGORY_TABLE);
                $this->load->view('header');
                $this->load->view('applock/data/applock_data_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $applockName = $this->input->post('applock_name');
                    $applockNameData = $this->DataModel->getData('applock_name = "'.$applockName.'"', APPLOCK_DATA_TABLE);
                    
                    if($applockNameData !== null && isset($applockNameData['applock_name']) && $applockNameData['applock_name'] == $applockName){
                        $this->session->set_userdata('session_applock_data_new_applock_name', "Applock name $applockName is already exits in database!");
                        redirect('new-applock-data');
                    } else {
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
                        
                        $thumbnailName = $_FILES['applock_thumbnail']['name'];
                        $thumbnailTemp = $_FILES['applock_thumbnail']['tmp_name'];
                        $thumbnailPath = THUMBNAIL_PATH;
                        $thumbnailResponse = newApplockBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
                        
                        $allowedThumbnailTypes = array('image/png');
                        $thumbnailType = $_FILES['applock_thumbnail']['type'];
    
                        if(in_array($thumbnailType, $allowedThumbnailTypes)){
                            $applockThumbnail = $thumbnailResponse;
                        } else {
                            redirect('new-applock-data');
                        }
                        
                        $bundleName = $_FILES['applock_bundle']['name'];
                        $bundleTemp = $_FILES['applock_bundle']['tmp_name'];
                        $bundlePath = BUNDLE_PATH;
                        $bundleResponse = newApplockBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
                        
                        $allowedBundleTypes = array('application/x-zip-compressed');
                        $bundleType = $_FILES['applock_bundle']['type'];
    
                        if(in_array($bundleType, $allowedBundleTypes)){
                            $applockBundle = $bundleResponse;
                        } else {
                            redirect('new-applock-data');
                        }
    
                        $newData = array(
                            'category_id'=>$this->input->post('category_id'),
                            'applock_name'=>$this->input->post('applock_name'),
                            'applock_thumbnail'=>$applockThumbnail,
                            'applock_bundle'=>$applockBundle,
                            'applock_view'=>0,
                            'applock_download'=>0,
                            'applock_applied'=>0,
                            'applock_type'=>$this->input->post('applock_type'),
                            'is_premium'=>$this->input->post('is_premium'),
                            'created_date'=>timeZone(),
                            'applock_status'=>$this->input->post('applock_status')
                        );
                        $newDataEntry = $this->DataModel->insertData(APPLOCK_DATA_TABLE, $newData);
                        if($newDataEntry){
                            redirect('view-applock-data');  
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
    
    public function applockDataView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_applock_data');
            }
            if(isset($_POST['submit_search'])){
                $searchApplockData = $this->input->post('search_applock_data');
                $this->session->set_userdata('session_applock_data', $searchApplockData);
            }
            $sessionApplockData = $this->session->userdata('session_applock_data');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_applock_data_type');
                $this->session->unset_userdata('session_applock_data_premium');
                $this->session->unset_userdata('session_applock_data_status');
                redirect('view-applock-data');
            }
            
            $searchApplockDataType = $this->input->post('search_applock_data_type');
            if($searchApplockDataType === 'pin' or $searchApplockDataType == 'pattern'){
                $this->session->set_userdata('session_applock_data_type', $searchApplockDataType);
            } else if($searchApplockDataType === 'all'){
                $this->session->unset_userdata('session_applock_data_type');
            }
            $sessionApplockDataType = $this->session->userdata('session_applock_data_type');
            
            $searchApplockDataPremium = $this->input->post('search_applock_data_premium');
            if($searchApplockDataPremium === 'true' or $searchApplockDataPremium == 'false'){
                $this->session->set_userdata('session_applock_data_premium', $searchApplockDataPremium);
            } else if($searchApplockDataPremium === 'all'){
                $this->session->unset_userdata('session_applock_data_premium');
            }
            $sessionApplockDataPremium = $this->session->userdata('session_applock_data_premium');
            
            $searchApplockDataStatus = $this->input->post('search_applock_data_status');
            if($searchApplockDataStatus === 'publish' or $searchApplockDataStatus == 'unpublish'){
                $this->session->set_userdata('session_applock_data_status', $searchApplockDataStatus);
            } else if($searchApplockDataStatus === 'all'){
                $this->session->unset_userdata('session_applock_data_status');
            }
            $sessionApplockDataStatus = $this->session->userdata('session_applock_data_status');
            
            if(isset($_POST['reset_order'])){
                $this->session->unset_userdata('session_applock_data_view');
                $this->session->unset_userdata('session_applock_data_download');
                $this->session->unset_userdata('session_applock_data_applied');
                redirect('view-applock-data');
            }
            
            $searchApplockDataView = $this->input->post('search_applock_data_view');
            if($searchApplockDataView === 'asc' or $searchApplockDataView == 'desc'){
                $this->session->set_userdata('session_applock_data_view', $searchApplockDataView);
            } else if($searchApplockDataView === 'all'){
                $this->session->unset_userdata('session_applock_data_view');
            }
            $sessionApplockDataView = $this->session->userdata('session_applock_data_view');
            
            $searchApplockDataDownload = $this->input->post('search_applock_data_download');
            if($searchApplockDataDownload === 'asc' or $searchApplockDataDownload == 'desc'){
                $this->session->set_userdata('session_applock_data_download', $searchApplockDataDownload);
            } else if($searchApplockDataDownload === 'all'){
                $this->session->unset_userdata('session_applock_data_download');
            }
            $sessionApplockDataDownload = $this->session->userdata('session_applock_data_download');
            
            $searchApplockDataApplied = $this->input->post('search_applock_data_applied');
            if($searchApplockDataApplied === 'asc' or $searchApplockDataApplied == 'desc'){
                $this->session->set_userdata('session_applock_data_applied', $searchApplockDataApplied);
            } else if($searchApplockDataApplied === 'all'){
                $this->session->unset_userdata('session_applock_data_applied');
            }
            $sessionApplockDataApplied = $this->session->userdata('session_applock_data_applied');
            
            $data = array();
            //get rows count
            $conditions['search_applock_data'] = $sessionApplockData;
            $conditions['search_applock_data_type'] = $sessionApplockDataType;
            $conditions['search_applock_data_premium'] = $sessionApplockDataPremium;
            $conditions['search_applock_data_status'] = $sessionApplockDataStatus;
            $conditions['search_applock_data_view'] = $sessionApplockDataView;
            $conditions['search_applock_data_download'] = $sessionApplockDataDownload;
            $conditions['search_applock_data_applied'] = $sessionApplockDataApplied;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewApplockData($conditions, APPLOCK_DATA_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-applock-data');
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
            
            $applockData = $this->DataModel->viewApplockData($conditions, APPLOCK_DATA_TABLE);
            $data['countApplockData'] = $this->DataModel->countApplockData($conditions, APPLOCK_DATA_TABLE);
            
            $data['viewApplockData'] = array();
            if(is_array($applockData) || is_object($applockData)){
                foreach($applockData as $Row){
                    $dataArray = array();
                    $dataArray['applock_id'] = $Row['applock_id'];
                    $dataArray['category_id'] = $Row['category_id'];
                    $dataArray['applock_name'] = $Row['applock_name'];
                    $dataArray['applock_thumbnail'] = $Row['applock_thumbnail'];
                    $dataArray['applock_bundle'] = $Row['applock_bundle'];
                    $dataArray['applock_view'] = $Row['applock_view'];
                    $dataArray['applock_download'] = $Row['applock_download'];
                    $dataArray['applock_applied'] = $Row['applock_applied'];
                    $dataArray['applock_type'] = $Row['applock_type'];
                    $dataArray['is_premium'] = $Row['is_premium'];
                    $dataArray['created_date'] = $Row['created_date'];
                    $dataArray['applock_status'] = $Row['applock_status'];
                    $dataArray['applockCategoryData'] = $this->DataModel->getData('category_id = '.$dataArray['category_id'], APPLOCK_CATEGORY_TABLE);
                    array_push($data['viewApplockData'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('applock/data/applock_data_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function applockCategoryDataView($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $categoryID = urlDecodes($categoryID);
            if(ctype_digit($categoryID)){
                if(isset($_POST['reset_search'])){
                    $this->session->unset_userdata('session_applock_category_data');
                }
                if(isset($_POST['submit_search'])){
                    $searchApplockCategoryData = $this->input->post('search_applock_category_data');
                    $this->session->set_userdata('session_applock_category_data', $searchApplockCategoryData);
                }
                $sessionApplockCategoryData = $this->session->userdata('session_applock_category_data');
                
                if(isset($_POST['reset_filter'])){
                    $this->session->unset_userdata('session_applock_category_data_type');
                    $this->session->unset_userdata('session_applock_category_data_premium');
                    $this->session->unset_userdata('session_applock_category_data_status');
                    redirect('view-applock-category-data/'.urlEncodes($categoryID));
                }
            
                $searchApplockCategoryDataType = $this->input->post('search_applock_category_data_type');
                if($searchApplockCategoryDataType === 'pin' or $searchApplockCategoryDataType == 'pattern'){
                    $this->session->set_userdata('session_applock_category_data_type', $searchApplockCategoryDataType);
                } else if($searchApplockCategoryDataType === 'all'){
                    $this->session->unset_userdata('session_applock_category_data_type');
                }
                $sessionApplockCategoryDataType = $this->session->userdata('session_applock_category_data_type');
                
                $searchApplockCategoryDataPremium = $this->input->post('search_applock_category_data_premium');
                if($searchApplockCategoryDataPremium === 'true' or $searchApplockCategoryDataPremium == 'false'){
                    $this->session->set_userdata('session_applock_category_data_premium', $searchApplockCategoryDataPremium);
                } else if($searchApplockCategoryDataPremium === 'all'){
                    $this->session->unset_userdata('session_applock_category_data_premium');
                }
                $sessionApplockCategoryDataPremium = $this->session->userdata('session_applock_category_data_premium');
                
                $searchApplockCategoryDataStatus = $this->input->post('search_applock_category_data_status');
                if($searchApplockCategoryDataStatus === 'publish' or $searchApplockCategoryDataStatus == 'unpublish'){
                    $this->session->set_userdata('session_applock_category_data_status', $searchApplockCategoryDataStatus);
                } else if($searchApplockCategoryDataStatus === 'all'){
                    $this->session->unset_userdata('session_applock_category_data_status');
                }
                $sessionApplockCategoryDataStatus = $this->session->userdata('session_applock_category_data_status');
                
                if(isset($_POST['reset_order'])){
                    $this->session->unset_userdata('session_applock_category_data_view');
                    $this->session->unset_userdata('session_applock_category_data_download');
                    $this->session->unset_userdata('session_applock_category_data_applied');
                    redirect('view-applock-category-data/'.urlEncodes($categoryID));
                }
                
                $searchApplockCategoryDataView = $this->input->post('search_applock_category_data_view');
                if($searchApplockCategoryDataView === 'asc' or $searchApplockCategoryDataView == 'desc'){
                    $this->session->set_userdata('session_applock_category_data_view', $searchApplockCategoryDataView);
                } else if($searchApplockCategoryDataView === 'all'){
                    $this->session->unset_userdata('session_applock_category_data_view');
                }
                $sessionApplockCategoryDataView = $this->session->userdata('session_applock_category_data_view');
                
                $searchApplockCategoryDataDownload = $this->input->post('search_applock_category_data_download');
                if($searchApplockCategoryDataDownload === 'asc' or $searchApplockCategoryDataDownload == 'desc'){
                    $this->session->set_userdata('session_applock_category_data_download', $searchApplockCategoryDataDownload);
                } else if($searchApplockCategoryDataDownload === 'all'){
                    $this->session->unset_userdata('session_applock_category_data_download');
                }
                $sessionApplockCategoryDataDownload = $this->session->userdata('session_applock_category_data_download');
                
                $searchApplockCategoryDataApplied = $this->input->post('search_applock_category_data_applied');
                if($searchApplockCategoryDataApplied === 'asc' or $searchApplockCategoryDataApplied == 'desc'){
                    $this->session->set_userdata('session_applock_category_data_applied', $searchApplockCategoryDataApplied);
                } else if($searchApplockCategoryDataApplied === 'all'){
                    $this->session->unset_userdata('session_applock_category_data_applied');
                }
                $sessionApplockCategoryDataApplied = $this->session->userdata('session_applock_category_data_applied');
                
                $data = array();
                //get rows count
                $conditions['search_applock_category_data'] = $sessionApplockCategoryData;
                $conditions['search_applock_category_data_type'] = $sessionApplockCategoryDataType;
                $conditions['search_applock_category_data_premium'] = $sessionApplockCategoryDataPremium;
                $conditions['search_applock_category_data_status'] = $sessionApplockCategoryDataStatus;
                $conditions['search_applock_category_data_view'] = $sessionApplockCategoryDataView;
                $conditions['search_applock_category_data_download'] = $sessionApplockCategoryDataDownload;
                $conditions['search_applock_category_data_applied'] = $sessionApplockCategoryDataApplied;
                $conditions['returnType'] = 'count';
                
                $totalRec = $this->DataModel->viewApplockCategoryData($conditions, $categoryID, APPLOCK_DATA_TABLE);
        
                //pagination config
                $config['base_url']    = site_url('view-applock-category-data/'.urlEncodes($categoryID));
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
                
                $applockCategoryData = $this->DataModel->viewApplockCategoryData($conditions, $categoryID, APPLOCK_DATA_TABLE);
                $data['countApplockCategoryData'] = $this->DataModel->countApplockCategoryData($conditions, $categoryID, APPLOCK_DATA_TABLE);
                
                $data['viewApplockCategoryData'] = array();
                if(is_array($applockCategoryData) || is_object($applockCategoryData)){
                    foreach($applockCategoryData as $Row){
                        $dataArray = array();
                        $dataArray['applock_id'] = $Row['applock_id'];
                        $dataArray['category_id'] = $Row['category_id'];
                        $dataArray['applock_name'] = $Row['applock_name'];
                        $dataArray['applock_thumbnail'] = $Row['applock_thumbnail'];
                        $dataArray['applock_bundle'] = $Row['applock_bundle'];
                        $dataArray['applock_view'] = $Row['applock_view'];
                        $dataArray['applock_download'] = $Row['applock_download'];
                        $dataArray['applock_applied'] = $Row['applock_applied'];
                        $dataArray['applock_type'] = $Row['applock_type'];
                        $dataArray['is_premium'] = $Row['is_premium'];
                        $dataArray['created_date'] = $Row['created_date'];
                        $dataArray['applock_status'] = $Row['applock_status'];
                        $dataArray['applockCategoryData'] = $this->DataModel->getData('category_id = '.$dataArray['category_id'], APPLOCK_CATEGORY_TABLE);
                        array_push($data['viewApplockCategoryData'], $dataArray);
                    }
                }
                $this->load->view('header');
                $this->load->view('applock/data/applock_category_data_view', $data);
                $this->load->view('footer');
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function applockDataEdit($applockID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(APPLOCK_DATA_ALIAS, "can_edit");
            if($isPermission){
                $applockID = urlDecodes($applockID);
                if(ctype_digit($applockID)){
                    $data['applockData'] = $this->DataModel->getData('applock_id = '.$applockID, APPLOCK_DATA_TABLE);
                    $data['viewApplockCategory'] = $this->DataModel->viewData(null, null, APPLOCK_CATEGORY_TABLE);
                    $categoryID = $data['applockData']['category_id'];
                    $data['applockCategoryData'] = $this->DataModel->getData('category_id = '.$categoryID, APPLOCK_CATEGORY_TABLE);
                    if(!empty($data['applockData'])){
                        $this->load->view('header');
                        $this->load->view('applock/data/applock_data_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
                        
                        $thumbnailKey = $data['applockData']['applock_thumbnail'];
    	                $newThumbnailKey = basename($thumbnailKey);
    	                
    	                $bundleKey = $data['applockData']['applock_bundle'];
    	                $newBundleKey = basename($bundleKey);
    
                        if(!empty($_FILES['applock_thumbnail']['name']) and !empty($_FILES['applock_bundle']['name'])){
                            $thumbnailName = $_FILES['applock_thumbnail']['name'];
                            $thumbnailTemp = $_FILES['applock_thumbnail']['tmp_name'];
                            $thumbnailPath = THUMBNAIL_PATH;
                            $thumbnailResponse = newApplockBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
                            
                            $allowedThumbnailTypes = array('image/png');
                            $thumbnailType = $_FILES['applock_thumbnail']['type'];
        
                            if(in_array($thumbnailType, $allowedThumbnailTypes)){
                                $applockThumbnail = $thumbnailResponse;
                            } else {
                                redirect('edit-applock-data/'.urlEncodes($applockID));
                            }
                            
                            $bundleName = $_FILES['applock_bundle']['name'];
                            $bundleTemp = $_FILES['applock_bundle']['tmp_name'];
                            $bundlePath = BUNDLE_PATH;
                            $bundleResponse = newApplockBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
                            
                            $allowedBundleTypes = array('application/x-zip-compressed');
                            $bundleType = $_FILES['applock_bundle']['type'];
        
                            if(in_array($bundleType, $allowedBundleTypes)){
                                $applockBundle = $bundleResponse;
                            } else {
                                redirect('edit-applock-data/'.urlEncodes($applockID));
                            }
    	                    
    	                    $deleteThumbnail = $s3Client->deleteObject([
    	                        'Bucket' => APPLOCK_BUCKET_NAME,
    	                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
    	                    ]);
    	                    $deleteBundle = $s3Client->deleteObject([
    	                        'Bucket' => APPLOCK_BUCKET_NAME,
    	                        'Key'    => BUNDLE_PATH.$newBundleKey,
    	                    ]);
    	                    
                            $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'applock_name'=>$this->input->post('applock_name'),
                                'applock_thumbnail'=>$applockThumbnail,
                                'applock_bundle'=>$applockBundle,
                                'applock_type'=>$this->input->post('applock_type'),
                                'is_premium'=>$this->input->post('is_premium'),
                                'applock_status'=>$this->input->post('applock_status')
                            );
                        } else if(!empty($_FILES['applock_thumbnail']['name'])){
                            $thumbnailName = $_FILES['applock_thumbnail']['name'];
                            $thumbnailTemp = $_FILES['applock_thumbnail']['tmp_name'];
                            $thumbnailPath = THUMBNAIL_PATH;
                            $thumbnailResponse = newApplockBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
                            
                            $allowedThumbnailTypes = array('image/png');
                            $thumbnailType = $_FILES['applock_thumbnail']['type'];
        
                            if(in_array($thumbnailType, $allowedThumbnailTypes)){
                                $applockThumbnail = $thumbnailResponse;
                            } else {
                                redirect('edit-applock-data/'.urlEncodes($applockID));
                            }

    	                    $deleteThumbnail = $s3Client->deleteObject([
    	                        'Bucket' => APPLOCK_BUCKET_NAME,
    	                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
    	                    ]);
    	                    
    	                    $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'applock_name'=>$this->input->post('applock_name'),
                                'applock_thumbnail'=>$applockThumbnail,
                                'applock_type'=>$this->input->post('applock_type'),
                                'is_premium'=>$this->input->post('is_premium'),
                                'applock_status'=>$this->input->post('applock_status')
                            );
                        } else if(!empty($_FILES['applock_bundle']['name'])){
    	                    $bundleName = $_FILES['applock_bundle']['name'];
                            $bundleTemp = $_FILES['applock_bundle']['tmp_name'];
                            $bundlePath = BUNDLE_PATH;
                            $bundleResponse = newApplockBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
                            
                            $allowedBundleTypes = array('application/x-zip-compressed');
                            $bundleType = $_FILES['applock_bundle']['type'];
        
                            if(in_array($bundleType, $allowedBundleTypes)){
                                $applockBundle = $bundleResponse;
                            } else {
                                redirect('edit-applock-data/'.urlEncodes($applockID));
                            }
    	                    
    	                    $deleteBundle = $s3Client->deleteObject([
    	                        'Bucket' => APPLOCK_BUCKET_NAME,
    	                        'Key'    => BUNDLE_PATH.$newBundleKey,
    	                    ]);
    	                    
    	                    $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'applock_name'=>$this->input->post('applock_name'),
                                'applock_bundle'=>$applockBundle,
                                'applock_type'=>$this->input->post('applock_type'),
                                'is_premium'=>$this->input->post('is_premium'),
                                'applock_status'=>$this->input->post('applock_status')
                            );
                        } else {
                            $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'applock_name'=>$this->input->post('applock_name'),
                                'applock_type'=>$this->input->post('applock_type'),
                                'is_premium'=>$this->input->post('is_premium'),
                                'applock_status'=>$this->input->post('applock_status')
                            );
                        }
                        $editDataEntry = $this->DataModel->editData('applock_id = '.$applockID, APPLOCK_DATA_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-applock-data');
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
    
    public function applockDataPremium($applockID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(APPLOCK_DATA_PREMIUM_ALIAS, "can_edit");
            $isPermission2 = checkPermission(APPLOCK_DATA_FREE_ALIAS, "can_edit");
            $applockID = urlDecodes($applockID);
            if(ctype_digit($applockID)){
                $applockData = $this->DataModel->getData('applock_id = '.$applockID, APPLOCK_DATA_TABLE);
                if($applockData['is_premium'] == "true"){
                    if($isPermission1){
        	            $editData = array(
                		    'is_premium'=>"false",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'is_premium'=>"true",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('applock_id = '.$applockID, APPLOCK_DATA_TABLE, $editData);
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
    
    public function applockDataStatus($applockID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(APPLOCK_DATA_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(APPLOCK_DATA_PUBLISH_ALIAS, "can_edit");
            $applockID = urlDecodes($applockID);
            if(ctype_digit($applockID)){
                $applockData = $this->DataModel->getData('applock_id = '.$applockID, APPLOCK_DATA_TABLE);
                if($applockData['applock_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'applock_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'applock_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('applock_id = '.$applockID, APPLOCK_DATA_TABLE, $editData);
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
    
    public function applockDataDelete($applockID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(APPLOCK_DATA_ALIAS, "can_delete");
            if($isPermission){ 
                $applockID = urlDecodes($applockID);
                if(ctype_digit($applockID)){
                    
                    $data['applockData'] = $this->DataModel->getData('applock_id = '.$applockID, APPLOCK_DATA_TABLE);
                    $s3Client = getConfig();
                    
                    $thumbnailKey = $data['applockData']['applock_thumbnail'];
	                $newThumbnailKey = basename($thumbnailKey);
	                
	                $bundleKey = $data['applockData']['applock_bundle'];
	                $newBundleKey = basename($bundleKey);
                    
                    $deleteThumbnail = $s3Client->deleteObject([
                        'Bucket' => APPLOCK_BUCKET_NAME,
                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
                    ]);
                    
                    $deleteBundle = $s3Client->deleteObject([
                        'Bucket' => APPLOCK_BUCKET_NAME,
                        'Key'    => BUNDLE_PATH.$newBundleKey,
                    ]);
                    
                    $resultDataEntry = $this->DataModel->deleteData('applock_id = '.$applockID, APPLOCK_DATA_TABLE);
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