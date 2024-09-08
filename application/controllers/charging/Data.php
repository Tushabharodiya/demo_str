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
	
    public function chargingDataNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(CHARGING_DATA_ALIAS, "can_add");
            if($isPermission){
                $data['chargingCategoryData'] = $this->DataModel->viewData(null, null, CHARGING_CATEGORY_TABLE);
                $this->load->view('header');
                $this->load->view('charging/data/charging_data_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $chargingName = $this->input->post('charging_name');
                    $chargingNameData = $this->DataModel->getData('charging_name = "'.$chargingName.'"', CHARGING_DATA_TABLE);
                    
                    if($chargingNameData !== null && isset($chargingNameData['charging_name']) && $chargingNameData['charging_name'] == $chargingName){
                        $this->session->set_userdata('session_charging_data_new_charging_name', "Charging name $chargingName is already exits in database!");
                        redirect('new-charging-data');
                    } else {
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
                        
                        $thumbnailName = $_FILES['charging_thumbnail']['name'];
                        $thumbnailTemp = $_FILES['charging_thumbnail']['tmp_name'];
                        $thumbnailPath = THUMBNAIL_PATH;
                        $thumbnailResponse = newChargingBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
                        
                        $allowedThumbnailTypes = array('image/png','application/json');
                        $thumbnailType = $_FILES['charging_thumbnail']['type'];
    
                        if(in_array($thumbnailType, $allowedThumbnailTypes)){
                            $chargingThumbnail = $thumbnailResponse;
                        } else {
                            redirect('new-charging-data');
                        }
                        
                        $bundleName = $_FILES['charging_bundle']['name'];
                        $bundleTemp = $_FILES['charging_bundle']['tmp_name'];
                        $bundlePath = BUNDLE_PATH;
                        $bundleResponse = newChargingBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
                        
                        $allowedBundleTypes = array('application/x-zip-compressed');
                        $bundleType = $_FILES['charging_bundle']['type'];
    
                        if(in_array($bundleType, $allowedBundleTypes)){
                            $chargingBundle = $bundleResponse;
                        } else {
                            redirect('new-charging-data');
                        }
                        
                        $newData = array(
                            'category_id'=>$this->input->post('category_id'),
                            'charging_name'=>$this->input->post('charging_name'),
                            'charging_thumbnail'=>$chargingThumbnail,
                            'charging_bundle'=>$chargingBundle,
                            'charging_view'=>0,
                            'charging_download'=>0,
                            'charging_applied'=>0,
                            'charging_type'=>$this->input->post('charging_type'),
                            'thumbnail_type'=>$this->input->post('thumbnail_type'),
                            'is_premium'=>$this->input->post('is_premium'),
                            'is_music'=>$this->input->post('is_music'),
                            'created_date'=>timeZone(),
                            'charging_status'=>$this->input->post('charging_status')
                        );
                        $newDataEntry = $this->DataModel->insertData(CHARGING_DATA_TABLE, $newData);
                        if($newDataEntry){
                            redirect('view-charging-data');  
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
    
    public function chargingDataView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_charging_data');
            }
            if(isset($_POST['submit_search'])){
                $searchChargingData = $this->input->post('search_charging_data');
                $this->session->set_userdata('session_charging_data', $searchChargingData);
            }
            $sessionChargingData = $this->session->userdata('session_charging_data');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_charging_data_type');
                $this->session->unset_userdata('session_charging_data_premium');
                $this->session->unset_userdata('session_charging_data_music');
                $this->session->unset_userdata('session_charging_data_status');
                redirect('view-charging-data');
            }
            
            $searchChargingDataType = $this->input->post('search_charging_data_type');
            if($searchChargingDataType === 'animation' or $searchChargingDataType == 'video'){
                $this->session->set_userdata('session_charging_data_type', $searchChargingDataType);
            } else if($searchChargingDataType === 'all'){
                $this->session->unset_userdata('session_charging_data_type');
            }
            $sessionChargingDataType = $this->session->userdata('session_charging_data_type');

            $searchChargingDataPremium = $this->input->post('search_charging_data_premium');
            if($searchChargingDataPremium === 'true' or $searchChargingDataPremium == 'false'){
                $this->session->set_userdata('session_charging_data_premium', $searchChargingDataPremium);
            } else if($searchChargingDataPremium === 'all'){
                $this->session->unset_userdata('session_charging_data_premium');
            }
            $sessionChargingDataPremium = $this->session->userdata('session_charging_data_premium');
            
            $searchChargingDataMusic = $this->input->post('search_charging_data_music');
            if($searchChargingDataMusic === 'true' or $searchChargingDataMusic == 'false'){
                $this->session->set_userdata('session_charging_data_music', $searchChargingDataMusic);
            } else if($searchChargingDataMusic === 'all'){
                $this->session->unset_userdata('session_charging_data_music');
            }
            $sessionChargingDataMusic = $this->session->userdata('session_charging_data_music');
            
            $searchChargingDataStatus = $this->input->post('search_charging_data_status');
            if($searchChargingDataStatus === 'publish' or $searchChargingDataStatus == 'unpublish'){
                $this->session->set_userdata('session_charging_data_status', $searchChargingDataStatus);
            } else if($searchChargingDataStatus === 'all'){
                $this->session->unset_userdata('session_charging_data_status');
            }
            $sessionChargingDataStatus = $this->session->userdata('session_charging_data_status');

            if(isset($_POST['reset_order'])){
                $this->session->unset_userdata('session_charging_data_view');
                $this->session->unset_userdata('session_charging_data_download');
                $this->session->unset_userdata('session_charging_data_applied');
                redirect('view-charging-data');
            }
            
            $searchChargingDataView = $this->input->post('search_charging_data_view');
            if($searchChargingDataView === 'asc' or $searchChargingDataView == 'desc'){
                $this->session->set_userdata('session_charging_data_view', $searchChargingDataView);
            } else if($searchChargingDataView === 'all'){
                $this->session->unset_userdata('session_charging_data_view');
            }
            $sessionChargingDataView = $this->session->userdata('session_charging_data_view');
            
            $searchChargingDataDownload = $this->input->post('search_charging_data_download');
            if($searchChargingDataDownload === 'asc' or $searchChargingDataDownload == 'desc'){
                $this->session->set_userdata('session_charging_data_download', $searchChargingDataDownload);
            } else if($searchChargingDataDownload === 'all'){
                $this->session->unset_userdata('session_charging_data_download');
            }
            $sessionChargingDataDownload = $this->session->userdata('session_charging_data_download');
            
            $searchChargingDataApplied = $this->input->post('search_charging_data_applied');
            if($searchChargingDataApplied === 'asc' or $searchChargingDataApplied == 'desc'){
                $this->session->set_userdata('session_charging_data_applied', $searchChargingDataApplied);
            } else if($searchChargingDataApplied === 'all'){
                $this->session->unset_userdata('session_charging_data_applied');
            }
            $sessionChargingDataApplied = $this->session->userdata('session_charging_data_applied');

            $data = array();
            //get rows count
            $conditions['search_charging_data'] = $sessionChargingData;
            $conditions['search_charging_data_type'] = $sessionChargingDataType;
            $conditions['search_charging_data_premium'] = $sessionChargingDataPremium;
            $conditions['search_charging_data_music'] = $sessionChargingDataMusic;
            $conditions['search_charging_data_status'] = $sessionChargingDataStatus;
            $conditions['search_charging_data_view'] = $sessionChargingDataView;
            $conditions['search_charging_data_download'] = $sessionChargingDataDownload;
            $conditions['search_charging_data_applied'] = $sessionChargingDataApplied;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewChargingData($conditions, CHARGING_DATA_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-charging-data');
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
            
            $chargingData = $this->DataModel->viewChargingData($conditions, CHARGING_DATA_TABLE);
            $data['countChargingData'] = $this->DataModel->countChargingData($conditions, CHARGING_DATA_TABLE);
            
            $data['viewChargingData'] = array();
            if(is_array($chargingData) || is_object($chargingData)){
                foreach($chargingData as $Row){
                    $dataArray = array();
                    $dataArray['charging_id'] = $Row['charging_id'];
                    $dataArray['category_id'] = $Row['category_id'];
                    $dataArray['charging_name'] = $Row['charging_name'];
                    $dataArray['charging_thumbnail'] = $Row['charging_thumbnail'];
                    $dataArray['charging_bundle'] = $Row['charging_bundle'];
                    $dataArray['charging_view'] = $Row['charging_view'];
                    $dataArray['charging_download'] = $Row['charging_download'];
                    $dataArray['charging_applied'] = $Row['charging_applied'];
                    $dataArray['charging_type'] = $Row['charging_type'];
                    $dataArray['thumbnail_type'] = $Row['thumbnail_type'];
                    $dataArray['is_premium'] = $Row['is_premium'];
                    $dataArray['is_music'] = $Row['is_music'];
                    $dataArray['created_date'] = $Row['created_date'];
                    $dataArray['charging_status'] = $Row['charging_status'];
                    $dataArray['chargingCategoryData'] = $this->DataModel->getData('category_id = '.$dataArray['category_id'], CHARGING_CATEGORY_TABLE);
                    array_push($data['viewChargingData'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('charging/data/charging_data_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function chargingCategoryDataView($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $categoryID = urlDecodes($categoryID);
            if(ctype_digit($categoryID)){
                if(isset($_POST['reset_search'])){
                    $this->session->unset_userdata('session_charging_category_data');
                }
                if(isset($_POST['submit_search'])){
                    $searchChargingCategoryData = $this->input->post('search_charging_category_data');
                    $this->session->set_userdata('session_charging_category_data', $searchChargingCategoryData);
                }
                $sessionChargingCategoryData = $this->session->userdata('session_charging_category_data');
                
                if(isset($_POST['reset_filter'])){
                    $this->session->unset_userdata('session_charging_category_data_type');
                    $this->session->unset_userdata('session_charging_category_data_premium');
                    $this->session->unset_userdata('session_charging_category_data_music');
                    $this->session->unset_userdata('session_charging_category_data_status');
                    redirect('view-charging-category-data/'.urlEncodes($categoryID));
                }
            
                $searchChargingCategoryDataType = $this->input->post('search_charging_category_data_type');
                if($searchChargingCategoryDataType === 'animation' or $searchChargingCategoryDataType == 'video'){
                    $this->session->set_userdata('session_charging_category_data_type', $searchChargingCategoryDataType);
                } else if($searchChargingCategoryDataType === 'all'){
                    $this->session->unset_userdata('session_charging_category_data_type');
                }
                $sessionChargingCategoryDataType = $this->session->userdata('session_charging_category_data_type');
    
                $searchChargingCategoryDataPremium = $this->input->post('search_charging_category_data_premium');
                if($searchChargingCategoryDataPremium === 'true' or $searchChargingCategoryDataPremium == 'false'){
                    $this->session->set_userdata('session_charging_category_data_premium', $searchChargingCategoryDataPremium);
                } else if($searchChargingCategoryDataPremium === 'all'){
                    $this->session->unset_userdata('session_charging_category_data_premium');
                }
                $sessionChargingCategoryDataPremium = $this->session->userdata('session_charging_category_data_premium');
                
                $searchChargingCategoryDataMusic = $this->input->post('search_charging_category_data_music');
                if($searchChargingCategoryDataMusic === 'true' or $searchChargingCategoryDataMusic == 'false'){
                    $this->session->set_userdata('session_charging_category_data_music', $searchChargingCategoryDataMusic);
                } else if($searchChargingCategoryDataMusic === 'all'){
                    $this->session->unset_userdata('session_charging_category_data_music');
                }
                $sessionChargingCategoryDataMusic = $this->session->userdata('session_charging_category_data_music');
                
                $searchChargingCategoryDataStatus = $this->input->post('search_charging_category_data_status');
                if($searchChargingCategoryDataStatus === 'publish' or $searchChargingCategoryDataStatus == 'unpublish'){
                    $this->session->set_userdata('session_charging_category_data_status', $searchChargingCategoryDataStatus);
                } else if($searchChargingCategoryDataStatus === 'all'){
                    $this->session->unset_userdata('session_charging_category_data_status');
                }
                $sessionChargingCategoryDataStatus = $this->session->userdata('session_charging_category_data_status');
                
                if(isset($_POST['reset_order'])){
                    $this->session->unset_userdata('session_charging_category_data_view');
                    $this->session->unset_userdata('session_charging_category_data_download');
                    $this->session->unset_userdata('session_charging_category_data_applied');
                    redirect('view-charging-category-data/'.urlEncodes($categoryID));
                }
                
                $searchChargingCategoryDataView = $this->input->post('search_charging_category_data_view');
                if($searchChargingCategoryDataView === 'asc' or $searchChargingCategoryDataView == 'desc'){
                    $this->session->set_userdata('session_charging_category_data_view', $searchChargingCategoryDataView);
                } else if($searchChargingCategoryDataView === 'all'){
                    $this->session->unset_userdata('session_charging_category_data_view');
                }
                $sessionChargingCategoryDataView = $this->session->userdata('session_charging_category_data_view');
                
                $searchChargingCategoryDataDownload = $this->input->post('search_charging_category_data_download');
                if($searchChargingCategoryDataDownload === 'asc' or $searchChargingCategoryDataDownload == 'desc'){
                    $this->session->set_userdata('session_charging_category_data_download', $searchChargingCategoryDataDownload);
                } else if($searchChargingCategoryDataDownload === 'all'){
                    $this->session->unset_userdata('session_charging_category_data_download');
                }
                $sessionChargingCategoryDataDownload = $this->session->userdata('session_charging_category_data_download');
                
                $searchChargingCategoryDataApplied = $this->input->post('search_charging_category_data_applied');
                if($searchChargingCategoryDataApplied === 'asc' or $searchChargingCategoryDataApplied == 'desc'){
                    $this->session->set_userdata('session_charging_category_data_applied', $searchChargingCategoryDataApplied);
                } else if($searchChargingCategoryDataApplied === 'all'){
                    $this->session->unset_userdata('session_charging_category_data_applied');
                }
                $sessionChargingCategoryDataApplied = $this->session->userdata('session_charging_category_data_applied');
    
                $data = array();
                //get rows count
                $conditions['search_charging_category_data'] = $sessionChargingCategoryData;
                $conditions['search_charging_category_data_type'] = $sessionChargingCategoryDataType;
                $conditions['search_charging_category_data_premium'] = $sessionChargingCategoryDataPremium;
                $conditions['search_charging_category_data_music'] = $sessionChargingCategoryDataMusic;
                $conditions['search_charging_category_data_status'] = $sessionChargingCategoryDataStatus;
                $conditions['search_charging_category_data_view'] = $sessionChargingCategoryDataView;
                $conditions['search_charging_category_data_download'] = $sessionChargingCategoryDataDownload;
                $conditions['search_charging_category_data_applied'] = $sessionChargingCategoryDataApplied;
                $conditions['returnType'] = 'count';
                
                $totalRec = $this->DataModel->viewChargingCategoryData($conditions, $categoryID, CHARGING_DATA_TABLE);
        
                //pagination config
                $config['base_url']    = site_url('view-charging-category-data/'.urlEncodes($categoryID));
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
                
                $chargingCategoryData = $this->DataModel->viewChargingCategoryData($conditions, $categoryID, CHARGING_DATA_TABLE);
                $data['countChargingCategoryData'] = $this->DataModel->countChargingCategoryData($conditions, $categoryID, CHARGING_DATA_TABLE);
                
                $data['viewChargingCategoryData'] = array();
                if(is_array($chargingCategoryData) || is_object($chargingCategoryData)){
                    foreach($chargingCategoryData as $Row){
                        $dataArray = array();
                        $dataArray['charging_id'] = $Row['charging_id'];
                        $dataArray['category_id'] = $Row['category_id'];
                        $dataArray['charging_name'] = $Row['charging_name'];
                        $dataArray['charging_thumbnail'] = $Row['charging_thumbnail'];
                        $dataArray['charging_bundle'] = $Row['charging_bundle'];
                        $dataArray['charging_view'] = $Row['charging_view'];
                        $dataArray['charging_download'] = $Row['charging_download'];
                        $dataArray['charging_applied'] = $Row['charging_applied'];
                        $dataArray['charging_type'] = $Row['charging_type'];
                        $dataArray['thumbnail_type'] = $Row['thumbnail_type'];
                        $dataArray['is_premium'] = $Row['is_premium'];
                        $dataArray['is_music'] = $Row['is_music'];
                        $dataArray['created_date'] = $Row['created_date'];
                        $dataArray['charging_status'] = $Row['charging_status'];
                        $dataArray['chargingCategoryData'] = $this->DataModel->getData('category_id = '.$dataArray['category_id'], CHARGING_CATEGORY_TABLE);
                        array_push($data['viewChargingCategoryData'], $dataArray);
                    }
                }
                $this->load->view('header');
                $this->load->view('charging/data/charging_category_data_view', $data);
                $this->load->view('footer');
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }

    public function chargingDataEdit($chargingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(CHARGING_DATA_ALIAS, "can_edit");
            if($isPermission){
                $chargingID = urlDecodes($chargingID);
                if(ctype_digit($chargingID)){
                    $data['chargingData'] = $this->DataModel->getData('charging_id = '.$chargingID, CHARGING_DATA_TABLE);
                    $data['viewChargingCategory'] = $this->DataModel->viewData(null, null, CHARGING_CATEGORY_TABLE);
                    $categoryID = $data['chargingData']['category_id'];
                    $data['chargingCategoryData'] = $this->DataModel->getData('category_id = '.$categoryID, CHARGING_CATEGORY_TABLE);
                    if(!empty($data['chargingData'])){
                        $this->load->view('header');
                        $this->load->view('charging/data/charging_data_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
                        
                        $thumbnailKey = $data['chargingData']['charging_thumbnail'];
    	                $newThumbnailKey = basename($thumbnailKey);
    	                
    	                $bundleKey = $data['chargingData']['charging_bundle'];
    	                $newBundleKey = basename($bundleKey);
    
                        if(!empty($_FILES['charging_thumbnail']['name']) and !empty($_FILES['charging_bundle']['name'])){
                            $thumbnailName = $_FILES['charging_thumbnail']['name'];
                            $thumbnailTemp = $_FILES['charging_thumbnail']['tmp_name'];
                            $thumbnailPath = THUMBNAIL_PATH;
                            $thumbnailResponse = newChargingBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
                            
                            $allowedThumbnailTypes = array('image/png','application/json');
                            $thumbnailType = $_FILES['charging_thumbnail']['type'];
        
                            if(in_array($thumbnailType, $allowedThumbnailTypes)){
                                $chargingThumbnail = $thumbnailResponse;
                            } else {
                                redirect('edit-charging-data/'.urlEncodes($chargingID));
                            }
                            

                            $bundleName = $_FILES['charging_bundle']['name'];
                            $bundleTemp = $_FILES['charging_bundle']['tmp_name'];
                            $bundlePath = BUNDLE_PATH;
                            $bundleResponse = newChargingBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
                            
                            $allowedBundleTypes = array('application/x-zip-compressed');
                            $bundleType = $_FILES['charging_bundle']['type'];
        
                            if(in_array($bundleType, $allowedBundleTypes)){
                                $chargingBundle = $bundleResponse;
                            } else {
                                redirect('edit-charging-data/'.urlEncodes($chargingID));
                            }
                            
                            $deleteThumbnail = $s3Client->deleteObject([
    	                        'Bucket' => CHARGING_BUCKET_NAME,
    	                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
    	                    ]);
    	                    $deleteBundle = $s3Client->deleteObject([
    	                        'Bucket' => CHARGING_BUCKET_NAME,
    	                        'Key'    => BUNDLE_PATH.$newBundleKey,
    	                    ]);
    	                    
                            $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'charging_name'=>$this->input->post('charging_name'),
                                'charging_thumbnail'=>$chargingThumbnail,
                                'charging_bundle'=>$chargingBundle,
                                'charging_type'=>$this->input->post('charging_type'),
                                'thumbnail_type'=>$this->input->post('thumbnail_type'),
                                'is_premium'=>$this->input->post('is_premium'),
                                'is_music'=>$this->input->post('is_music'),
                                'charging_status'=>$this->input->post('charging_status')
                            );
                        } else if(!empty($_FILES['charging_thumbnail']['name'])){
                            $thumbnailName = $_FILES['charging_thumbnail']['name'];
                            $thumbnailTemp = $_FILES['charging_thumbnail']['tmp_name'];
                            $thumbnailPath = THUMBNAIL_PATH;
                            $thumbnailResponse = newChargingBucketObject($thumbnailName, $uniqueCode, $thumbnailTemp, $thumbnailPath);
                            
                            $allowedThumbnailTypes = array('image/png','application/json');
                            $thumbnailType = $_FILES['charging_thumbnail']['type'];
        
                            if(in_array($thumbnailType, $allowedThumbnailTypes)){
                                $chargingThumbnail = $thumbnailResponse;
                            } else {
                                redirect('edit-charging-data/'.urlEncodes($chargingID));
                            }

                            $deleteThumbnail = $s3Client->deleteObject([
    	                        'Bucket' => CHARGING_BUCKET_NAME,
    	                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
    	                    ]);
    	                    
    	                     $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'charging_name'=>$this->input->post('charging_name'),
                                'charging_thumbnail'=>$chargingThumbnail,
                                'charging_type'=>$this->input->post('charging_type'),
                                'thumbnail_type'=>$this->input->post('thumbnail_type'),
                                'is_premium'=>$this->input->post('is_premium'),
                                'is_music'=>$this->input->post('is_music'),
                                'charging_status'=>$this->input->post('charging_status')
                            );
                        } else if(!empty($_FILES['charging_bundle']['name'])){
                            $bundleName = $_FILES['charging_bundle']['name'];
                            $bundleTemp = $_FILES['charging_bundle']['tmp_name'];
                            $bundlePath = BUNDLE_PATH;
                            $bundleResponse = newChargingBucketObject($bundleName, $uniqueCode, $bundleTemp, $bundlePath);
                            
                            $allowedBundleTypes = array('application/x-zip-compressed');
                            $bundleType = $_FILES['charging_bundle']['type'];
        
                            if(in_array($bundleType, $allowedBundleTypes)){
                                $chargingBundle = $bundleResponse;
                            } else {
                                redirect('edit-charging-data/'.urlEncodes($chargingID));
                            }
                            
                            $deleteBundle = $s3Client->deleteObject([
    	                        'Bucket' => CHARGING_BUCKET_NAME,
    	                        'Key'    => BUNDLE_PATH.$newBundleKey,
    	                    ]);

    	                    $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'charging_name'=>$this->input->post('charging_name'),
                                'charging_bundle'=>$chargingBundle,
                                'charging_type'=>$this->input->post('charging_type'),
                                'thumbnail_type'=>$this->input->post('thumbnail_type'),
                                'is_premium'=>$this->input->post('is_premium'),
                                'is_music'=>$this->input->post('is_music'),
                                'charging_status'=>$this->input->post('charging_status')
                            );
                        } else {
                            $editData = array(
                                'category_id'=>$this->input->post('category_id'),
                                'charging_name'=>$this->input->post('charging_name'),
                                'charging_type'=>$this->input->post('charging_type'),
                                'thumbnail_type'=>$this->input->post('thumbnail_type'),
                                'is_premium'=>$this->input->post('is_premium'),
                                'is_music'=>$this->input->post('is_music'),
                                'charging_status'=>$this->input->post('charging_status')
                            );
                        }
                        $editDataEntry = $this->DataModel->editData('charging_id = '.$chargingID, CHARGING_DATA_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-charging-data');
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
    
    public function chargingDataPremium($chargingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(CHARGING_DATA_PREMIUM_ALIAS, "can_edit");
            $isPermission2 = checkPermission(CHARGING_DATA_FREE_ALIAS, "can_edit");
            $chargingID = urlDecodes($chargingID);
            if(ctype_digit($chargingID)){
                $chargingData = $this->DataModel->getData('charging_id = '.$chargingID, CHARGING_DATA_TABLE);
                if($chargingData['is_premium'] == "true"){
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
    			$editDataEntry = $this->DataModel->editData('charging_id = '.$chargingID, CHARGING_DATA_TABLE, $editData);
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
    
    public function chargingDataStatus($chargingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(CHARGING_DATA_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(CHARGING_DATA_PUBLISH_ALIAS, "can_edit");
            $chargingID = urlDecodes($chargingID);
            if(ctype_digit($chargingID)){
                $chargingData = $this->DataModel->getData('charging_id = '.$chargingID, CHARGING_DATA_TABLE);
                if($chargingData['charging_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'charging_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'charging_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('charging_id = '.$chargingID, CHARGING_DATA_TABLE, $editData);
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
    
    public function chargingDataDelete($chargingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(CHARGING_DATA_ALIAS, "can_delete");
            if($isPermission){ 
                $chargingID = urlDecodes($chargingID);
                if(ctype_digit($chargingID)){
                    
                    $data['chargingData'] = $this->DataModel->getData('charging_id = '.$chargingID, CHARGING_DATA_TABLE);
                    $s3Client = getConfig();
                    
                    $thumbnailKey = $data['chargingData']['charging_thumbnail'];
	                $newThumbnailKey = basename($thumbnailKey);
	                
	                $bundleKey = $data['chargingData']['charging_bundle'];
	                $newBundleKey = basename($bundleKey);
                    
                    $deleteThumbnail = $s3Client->deleteObject([
                        'Bucket' => CHARGING_BUCKET_NAME,
                        'Key'    => THUMBNAIL_PATH.$newThumbnailKey,
                    ]);
                    $deleteBundle = $s3Client->deleteObject([
                        'Bucket' => CHARGING_BUCKET_NAME,
                        'Key'    => BUNDLE_PATH.$newBundleKey,
                    ]);
                    
                    $resultDataEntry = $this->DataModel->deleteData('charging_id = '.$chargingID, CHARGING_DATA_TABLE);
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