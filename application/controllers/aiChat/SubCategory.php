<?php defined('BASEPATH') OR exit('No direct script access allowed');

class subCategory extends CI_Controller {
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
	
    public function aiChatSubCategoryNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_SUB_CATEGORY_ALIAS, "can_add");
            if($isPermission){
                $data['aiChatMainCategoryData'] = $this->DataModel->viewAiChatMainCategoryData(null, null, AI_CHAT_MAIN_CATEGORY_TABLE);
                $this->load->view('header');
                $this->load->view('aiChat/subCategory/ai_chat_sub_category_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $subCategoryName = $this->input->post('sub_category_name');
                    $aiChatSubCategoryNameData = $this->DataModel->getData('sub_category_identifier_name = "'.$subCategoryName.'"', AI_CHAT_SUB_CATEGORY_TABLE);
                    
                    if($aiChatSubCategoryNameData !== null && isset($aiChatSubCategoryNameData['sub_category_identifier_name']) && $aiChatSubCategoryNameData['sub_category_identifier_name'] == $subCategoryName){
                        $this->session->set_userdata('session_ai_chat_sub_category_new_sub_category_name', "Sub Category name $subCategoryName is already exits in database!");
                        redirect('new-ai-chat-sub-category'); 
                    } else {
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
    
                        $iconName = $_FILES['sub_category_icon']['name'];
                        $iconTemp = $_FILES['sub_category_icon']['tmp_name'];
                        $iconPath = ICON_PATH;
                        $iconResponse = newAiBucketObject($iconName, $uniqueCode, $iconTemp, $iconPath);
                        
                        $subCategoryName = $this->input->post('sub_category_name');
                        $subCategoryDescription = $this->input->post('sub_category_description');
                    
                        $textDataArray = array(
                            'sub_category_name'=>$subCategoryName,
                            'sub_category_description'=>$subCategoryDescription,
                        );
                        
                        $fromLanguage = 'en';
                        
                        $aiChatMainCategory = $this->DataModel->viewData(null, 'main_category_identifier_name = "'.$this->input->post('main_category_id').'"', AI_CHAT_MAIN_CATEGORY_TABLE);
                        $languages = array();
                        
                        foreach($aiChatMainCategory as $language){
                            $languages[] = $language['language_code'];
                        }
                        
                        foreach($languages as $languageName => $toLanguage){
                            $translatedDataArray = array();
                        
                            foreach($textDataArray as $fieldName => $textData){
                                $translatedText = translateText($textData, $fromLanguage, $toLanguage);
                                
                                $translatedDataArray[$fieldName] = $translatedText;
                            }
                            $aiChatMainCategoryData = $this->DataModel->getData('language_code = "'.$toLanguage.'" AND main_category_identifier_name = "'.$this->input->post('main_category_id').'"', AI_CHAT_MAIN_CATEGORY_TABLE);
                            $newData = array(
                                'main_category_id'=>$aiChatMainCategoryData['main_category_id'],
                                'language_code'=>$toLanguage,
                                'sub_category_identifier_name'=>$subCategoryName,
                                'sub_category_name'=>isset($translatedDataArray['sub_category_name']) ? $translatedDataArray['sub_category_name'] : $subCategoryName,
                                'sub_category_description'=>isset($translatedDataArray['sub_category_description']) ? $translatedDataArray['sub_category_description'] : $subCategoryDescription,
                                'sub_category_icon'=>$iconResponse,
                                'sub_category_view'=>0,
                                'sub_category_status'=>$this->input->post('sub_category_status'),
                            );
                        
                            $lastInsertID = $this->DataModel->insertData(AI_CHAT_SUB_CATEGORY_TABLE, $newData);
                            if($lastInsertID){
                                $editData = array('sub_category_position'=>$lastInsertID);
                                $editDataEntry = $this->DataModel->editData('sub_category_id = '.$lastInsertID, AI_CHAT_SUB_CATEGORY_TABLE, $editData);
                            }
                        }
                        redirect('view-ai-chat-sub-category'); 
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatSubCategoryView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_chat_sub_category');
            }
            if(isset($_POST['submit_search'])){
                $searchAiChatSubCategory = $this->input->post('search_ai_chat_sub_category');
                $this->session->set_userdata('session_ai_chat_sub_category', $searchAiChatSubCategory);
            }
            $sessionAiChatSubCategory = $this->session->userdata('session_ai_chat_sub_category');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_chat_sub_category_status');
                redirect('view-ai-chat-sub-category');
            }
            
            $searchAiChatSubCategoryStatus = $this->input->post('search_ai_chat_sub_category_status');
            if($searchAiChatSubCategoryStatus === 'publish' or $searchAiChatSubCategoryStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_chat_sub_category_status', $searchAiChatSubCategoryStatus);
            } else if($searchAiChatSubCategoryStatus === 'all'){
                $this->session->unset_userdata('session_ai_chat_sub_category_status');
            }
            $sessionAiChatSubCategoryStatus = $this->session->userdata('session_ai_chat_sub_category_status');
            
            $data = array();
            //get rows count
            $conditions['search_ai_chat_sub_category'] = $sessionAiChatSubCategory;
            $conditions['search_ai_chat_sub_category_status'] = $sessionAiChatSubCategoryStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiChatSubCategory($conditions, AI_CHAT_SUB_CATEGORY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-chat-sub-category');
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
            
            $aiChatSubCategory = $this->DataModel->viewAiChatSubCategory($conditions, AI_CHAT_SUB_CATEGORY_TABLE);
            $data['countAiChatSubCategory'] = $this->DataModel->countAiChatSubCategory($conditions, AI_CHAT_SUB_CATEGORY_TABLE);
            
            $data['viewAiChatSubCategory'] = array();
            if(is_array($aiChatSubCategory) || is_object($aiChatSubCategory)){
                foreach($aiChatSubCategory as $Row){
                    $dataArray = array();
                    $dataArray['sub_category_id'] = $Row['sub_category_id'];
                    $dataArray['main_category_id'] = $Row['main_category_id'];
                    $dataArray['language_code'] = $Row['language_code'];
                    $dataArray['sub_category_identifier_name'] = $Row['sub_category_identifier_name'];
                    $dataArray['sub_category_name'] = $Row['sub_category_name'];
                    $dataArray['sub_category_description'] = $Row['sub_category_description'];
                    $dataArray['sub_category_icon'] = $Row['sub_category_icon'];
                    $dataArray['sub_category_position'] = $Row['sub_category_position'];
                    $dataArray['sub_category_view'] = $Row['sub_category_view'];
                    $dataArray['sub_category_status'] = $Row['sub_category_status'];
                    $dataArray['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$dataArray['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                    $dataArray['aiChatMainCategoryData'] = $this->DataModel->getData('main_category_id = '.$dataArray['main_category_id'], AI_CHAT_MAIN_CATEGORY_TABLE);
                    $dataArray['countAiChatData'] = $this->DataModel->countData('sub_category_id = '.$dataArray['sub_category_id'], AI_CHAT_DATA_TABLE);
                    array_push($data['viewAiChatSubCategory'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiChat/subCategory/ai_chat_sub_category_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatSubCategoriesView($mainCategoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $mainCategoryID = urlDecodes($mainCategoryID);
            if(ctype_digit($mainCategoryID)){
                if(isset($_POST['reset_search'])){
                    $this->session->unset_userdata('session_ai_chat_sub_categories');
                }
                if(isset($_POST['submit_search'])){
                    $searchAiChatSubCategories = $this->input->post('search_ai_chat_sub_categories');
                    $this->session->set_userdata('session_ai_chat_sub_categories', $searchAiChatSubCategories);
                }
                $sessionAiChatSubCategories = $this->session->userdata('session_ai_chat_sub_categories');
                
                if(isset($_POST['reset_filter'])){
                    $this->session->unset_userdata('session_ai_chat_sub_categories_status');
                    redirect('view-ai-chat-sub-categories/'.urlEncodes($mainCategoryID));
                }
                
                $searchAiChatSubCategoriesStatus = $this->input->post('search_ai_chat_sub_categories_status');
                if($searchAiChatSubCategoriesStatus === 'publish' or $searchAiChatSubCategoriesStatus == 'unpublish'){
                    $this->session->set_userdata('session_ai_chat_sub_categories_status', $searchAiChatSubCategoriesStatus);
                } else if($searchAiChatSubCategoriesStatus === 'all'){
                    $this->session->unset_userdata('session_ai_chat_sub_categories_status');
                }
                $sessionAiChatSubCategoriesStatus = $this->session->userdata('session_ai_chat_sub_categories_status');
                
                $data = array();
                //get rows count
                $conditions['search_ai_chat_sub_categories'] = $sessionAiChatSubCategories;
                $conditions['search_ai_chat_sub_categories_status'] = $sessionAiChatSubCategoriesStatus;
                $conditions['returnType'] = 'count';
                
                $totalRec = $this->DataModel->viewAiChatSubCategories($conditions, $mainCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
        
                //pagination config
                $config['base_url']    = site_url('view-ai-chat-sub-categories/'.urlEncodes($mainCategoryID));
                $config['uri_segment'] = 3;
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
                $page = $this->uri->segment(3);
                $offset = !$page?0:$page;
                
                //get rows
                $conditions['returnType'] = '';
                $conditions['start'] = $offset;
                $conditions['limit'] = 10;
                
                $aiChatSubCategories = $this->DataModel->viewAiChatSubCategories($conditions, $mainCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
                $data['countAiChatSubCategories'] = $this->DataModel->countAiChatSubCategories($conditions, $mainCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
                
                $data['viewAiChatSubCategories'] = array();
                if(is_array($aiChatSubCategories) || is_object($aiChatSubCategories)){
                    foreach($aiChatSubCategories as $Row){
                        $dataArray = array();
                        $dataArray['sub_category_id'] = $Row['sub_category_id'];
                        $dataArray['main_category_id'] = $Row['main_category_id'];
                        $dataArray['language_code'] = $Row['language_code'];
                        $dataArray['sub_category_identifier_name'] = $Row['sub_category_identifier_name'];
                        $dataArray['sub_category_name'] = $Row['sub_category_name'];
                        $dataArray['sub_category_description'] = $Row['sub_category_description'];
                        $dataArray['sub_category_icon'] = $Row['sub_category_icon'];
                        $dataArray['sub_category_position'] = $Row['sub_category_position'];
                        $dataArray['sub_category_view'] = $Row['sub_category_view'];
                        $dataArray['sub_category_status'] = $Row['sub_category_status'];
                        $dataArray['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$dataArray['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                        $dataArray['aiChatMainCategoryData'] = $this->DataModel->getData('main_category_id = '.$dataArray['main_category_id'], AI_CHAT_MAIN_CATEGORY_TABLE);
                        $dataArray['countAiChatData'] = $this->DataModel->countData('sub_category_id = '.$dataArray['sub_category_id'], AI_CHAT_DATA_TABLE);
                        array_push($data['viewAiChatSubCategories'], $dataArray);
                    }
                }
                $this->load->view('header');
                $this->load->view('aiChat/subCategory/ai_chat_sub_categories_view', $data);
                $this->load->view('footer');
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }

    public function aiChatSubCategoryEdit($subCategoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_SUB_CATEGORY_ALIAS, "can_edit");
            if($isPermission){
                $subCategoryID = urlDecodes($subCategoryID);
                if(ctype_digit($subCategoryID)){
                    $data['aiChatSubCategoryData'] = $this->DataModel->getData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
                    
                    $data['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$data['aiChatSubCategoryData']['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                    
                    $data['viewAiChatMainCategory'] = $this->DataModel->viewData(null, null, AI_CHAT_MAIN_CATEGORY_TABLE);
                    $mainCategoryID = $data['aiChatSubCategoryData']['main_category_id'];
                    $data['aiChatMainCategoryData'] = $this->DataModel->getData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE);
                    
                    foreach($data['viewAiChatMainCategory'] as $key => $mainCategory){
                        $languageData = $this->DataModel->getData('language_code = "'.$mainCategory['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                        $data['viewAiChatMainCategory'][$key]['language_name'] = $languageData['language_name'];
                    }
                    
                    if(!empty($data['aiChatSubCategoryData'])){
                        $this->load->view('header');
                        $this->load->view('aiChat/subCategory/ai_chat_sub_category_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        if(empty($_FILES['sub_category_icon']['name'])){
                            $editData = array(
                                'main_category_id'=>$this->input->post('main_category_id'),
                                'sub_category_name'=>$this->input->post('sub_category_name'),
                                'sub_category_description'=>$this->input->post('sub_category_description'),
                                'sub_category_position'=>$this->input->post('sub_category_position'),
                                'sub_category_status'=>$this->input->post('sub_category_status')
                            );
                        } else {
                            $s3Client = getconfig();
                            $uniqueCode = uniqueKey();
                        
                            $iconKey = $data['aiChatSubCategoryData']['sub_category_icon'];
    	                    $newIconKey = basename($iconKey);
    	                
                            $deleteIcon = $s3Client->deleteObject([
    	                        'Bucket' => AI_BUCKET_NAME,
    	                        'Key'    => ICON_PATH.$newIconKey,
    	                    ]);

    	                    $iconName = $_FILES['sub_category_icon']['name'];
    	            	    $iconTemp = $_FILES['sub_category_icon']['tmp_name'];
    	            	    $iconPath = ICON_PATH;
    	                    $iconResponse = newAiBucketObject($iconName, $uniqueCode, $iconTemp, $iconPath);
                            
                            $editData = array(
                                'main_category_id'=>$this->input->post('main_category_id'),
                                'sub_category_name'=>$this->input->post('sub_category_name'),
                                'sub_category_description'=>$this->input->post('sub_category_description'),
                                'sub_category_icon'=>$iconResponse,
                                'sub_category_position'=>$this->input->post('sub_category_position'),
                                'sub_category_status'=>$this->input->post('sub_category_status')
                            );
                        }
                        $editDataEntry = $this->DataModel->editData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-ai-chat-sub-category');
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
    
    public function aiChatSubCategoryStatus($subCategoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_CHAT_SUB_CATEGORY_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_CHAT_SUB_CATEGORY_PUBLISH_ALIAS, "can_edit");
            $subCategoryID = urlDecodes($subCategoryID);
            if(ctype_digit($subCategoryID)){
                $aiChatSubCategoryData = $this->DataModel->getData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
                if($aiChatSubCategoryData['sub_category_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'sub_category_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'sub_category_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE, $editData);
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
    
    public function aiChatSubCategoryDelete($subCategoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_SUB_CATEGORY_ALIAS, "can_delete");
            if($isPermission){ 
                $subCategoryID = urlDecodes($subCategoryID);
                if(ctype_digit($subCategoryID)){
                    $data['viewAiChatData'] = $this->DataModel->getData('sub_category_id = '.$subCategoryID, AI_CHAT_DATA_TABLE);
                    if(!empty($data['viewAiChatData'])){
                        $this->session->set_userdata('session_ai_chat_sub_category_delete', "You can't delete ai chat sub category! Please delete ai chat data before deleting ai chat sub category");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {               
                        $data['aiChatSubCategoryData'] = $this->DataModel->getData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);

                        $iconKey = $data['aiChatSubCategoryData']['sub_category_icon'];
                    
                        $newIconKey = basename($iconKey);
                    
                        $existingRecords = $this->DataModel->getData("sub_category_icon = '$iconKey' AND sub_category_id != $subCategoryID", AI_CHAT_SUB_CATEGORY_TABLE);

                        if(empty($existingRecords)){
                            $s3Client = getConfig();
                            $deleteIcon = $s3Client->deleteObject([
                                'Bucket' => AI_BUCKET_NAME,
                                'Key'    => ICON_PATH.$newIconKey,
                            ]);
                        }
                        $resultDataEntry = $this->DataModel->deleteData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
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
    
    public function allAiChatSubCategoryDelete($action = null){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if($action === 'delete'){
                $isPermission = checkPermission(AI_CHAT_SUB_CATEGORY_ALIAS, "can_delete");
                if($isPermission){ 
                    $selectedRecords = $this->input->post('sub_category_id');
                        if(!empty($selectedRecords)){
                            $subCategoryIds = array_map('intval', $selectedRecords);
                            foreach($subCategoryIds as $subCategoryID) {
                                $data['viewAiChatData'] = $this->DataModel->getData('sub_category_id = '.$subCategoryID, AI_CHAT_DATA_TABLE);
                                if(!empty($data['viewAiChatData'])){
                                    $this->session->set_userdata('session_all_ai_chat_sub_category_delete', "You can't delete ai chat sub category! Please delete ai chat data before deleting ai chat sub category");
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {               
                                    $data['aiChatSubCategoryData'] = $this->DataModel->getData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
            
                                    $iconKey = $data['aiChatSubCategoryData']['sub_category_icon'];
                                
                                    $newIconKey = basename($iconKey);
                                
                                    $existingRecords = $this->DataModel->getData("sub_category_icon = '$iconKey' AND sub_category_id != $subCategoryID", AI_CHAT_SUB_CATEGORY_TABLE);
            
                                    if(empty($existingRecords)){
                                        $s3Client = getConfig();
                                        $deleteIcon = $s3Client->deleteObject([
                                            'Bucket' => AI_BUCKET_NAME,
                                            'Key'    => ICON_PATH.$newIconKey,
                                        ]);
                                    }
                                    $resultDataEntry = $this->DataModel->deleteData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
                                }
                            }
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
                echo 'Invalid action!';
            }
        } else {
            redirect('logout');
        }
    }
}