<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MainCategory extends CI_Controller {
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
	
    public function aiChatMainCategoryNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_MAIN_CATEGORY_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('aiChat/mainCategory/ai_chat_main_category_new');
                $this->load->view('footer'); 
                if($this->input->post('submit')){
                    $mainCategoryName = $this->input->post('main_category_name');
                    $aiChatMainCategoryNameData = $this->DataModel->getData('main_category_identifier_name = "'.$mainCategoryName.'"', AI_CHAT_MAIN_CATEGORY_TABLE);
                    
                    if($aiChatMainCategoryNameData !== null && isset($aiChatMainCategoryNameData['main_category_identifier_name']) && $aiChatMainCategoryNameData['main_category_identifier_name'] == $mainCategoryName){
                        $this->session->set_userdata('session_ai_chat_main_category_new_main_category_name', "Mian Category name $mainCategoryName is already exits in database!");
                        redirect('new-ai-chat-main-category');  
                    } else {
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
    
                        $iconName = $_FILES['main_category_icon']['name'];
                        $iconTemp = $_FILES['main_category_icon']['tmp_name'];
                        $iconPath = ICON_PATH;
                        $iconResponse = newAiBucketObject($iconName, $uniqueCode, $iconTemp, $iconPath);
                        
                        $mainCategoryName = $this->input->post('main_category_name');
                        $mainCategoryTitle = $this->input->post('main_category_title');
                        $mainCategoryDescription = $this->input->post('main_category_description');
                    
                        $textDataArray = array(
                            'main_category_name'=>$mainCategoryName,
                            'main_category_title'=>$mainCategoryTitle,
                            'main_category_description'=>$mainCategoryDescription,
                        );
                        
                        $fromLanguage = 'en';
                        
                        $aiChatLanguageData = $this->DataModel->viewData(null, null, AI_CHAT_LANGUAGE_TABLE);
                        if(!empty($aiChatLanguageData)){
                            $languages = array();
                            
                            foreach($aiChatLanguageData as $language){
                                $languages[] = $language['language_code'];
                            }
                            
                            foreach($languages as $languageName => $toLanguage){
                                $translatedDataArray = array();
                            
                                foreach($textDataArray as $fieldName => $textData){
                                    $translatedText = translateText($textData, $fromLanguage, $toLanguage);
                                    
                                    $translatedDataArray[$fieldName] = $translatedText;
                                }
                            
                                $newData = array(
                                    'language_code'=>$toLanguage,
                                    'main_category_identifier_name'=>$mainCategoryName,
                                    'main_category_name'=>isset($translatedDataArray['main_category_name']) ? $translatedDataArray['main_category_name'] : $mainCategoryName,
                                    'main_category_icon'=>$iconResponse,
                                    'main_category_title'=>isset($translatedDataArray['main_category_title']) ? $translatedDataArray['main_category_title'] : $mainCategoryTitle,
                                    'main_category_description'=>isset($translatedDataArray['main_category_description']) ? $translatedDataArray['main_category_description'] : $mainCategoryDescription,
                                    'main_category_date'=>timeZone(),
                                    'main_category_status'=>$this->input->post('main_category_status'),
                                );
                            
                                $newDataEntry = $this->DataModel->insertData(AI_CHAT_MAIN_CATEGORY_TABLE, $newData);
                            }
                        } else {
                            $this->session->set_userdata('session_ai_chat_main_category_new', "You can't insert ai chat main category! Please insert ai chat language before inserting ai chat main category");
                        }
                        redirect('view-ai-chat-main-category');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatMainCategoryView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_chat_main_category');
            }
            if(isset($_POST['submit_search'])){
                $searchAiChatMainCategory = $this->input->post('search_ai_chat_main_category');
                $this->session->set_userdata('session_ai_chat_main_category', $searchAiChatMainCategory);
            }
            $sessionAiChatMainCategory = $this->session->userdata('session_ai_chat_main_category');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_chat_main_category_status');
                redirect('view-ai-chat-main-category');
            }
            
            $searchAiChatMainCategoryStatus = $this->input->post('search_ai_chat_main_category_status');
            if($searchAiChatMainCategoryStatus === 'publish' or $searchAiChatMainCategoryStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_chat_main_category_status', $searchAiChatMainCategoryStatus);
            } else if($searchAiChatMainCategoryStatus === 'all'){
                $this->session->unset_userdata('session_ai_chat_main_category_status');
            }
            $sessionAiChatMainCategoryStatus = $this->session->userdata('session_ai_chat_main_category_status');
            
            $data = array();
            //get rows count
            $conditions['search_ai_chat_main_category'] = $sessionAiChatMainCategory;
            $conditions['search_ai_chat_main_category_status'] = $sessionAiChatMainCategoryStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiChatMainCategory($conditions, AI_CHAT_MAIN_CATEGORY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-chat-main-category');
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
            
            $aiChatMainCategory = $this->DataModel->viewAiChatMainCategory($conditions, AI_CHAT_MAIN_CATEGORY_TABLE);
            $data['countAiChatMainCategory'] = $this->DataModel->countAiChatMainCategory($conditions, AI_CHAT_MAIN_CATEGORY_TABLE);
            
            $data['viewAiChatMainCategory'] = array();
            if(is_array($aiChatMainCategory) || is_object($aiChatMainCategory)){
                foreach($aiChatMainCategory as $Row){
                    $dataArray = array();
                    $dataArray['main_category_id'] = $Row['main_category_id'];
                    $dataArray['language_code'] = $Row['language_code'];
                    $dataArray['main_category_identifier_name'] = $Row['main_category_identifier_name'];
                    $dataArray['main_category_name'] = $Row['main_category_name'];
                    $dataArray['main_category_icon'] = $Row['main_category_icon'];
                    $dataArray['main_category_title'] = $Row['main_category_title'];
                    $dataArray['main_category_description'] = $Row['main_category_description'];
                    $dataArray['main_category_date'] = $Row['main_category_date'];
                    $dataArray['main_category_status'] = $Row['main_category_status'];
                    $dataArray['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$dataArray['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                    $dataArray['countAiChatSubCategory'] = $this->DataModel->countData('main_category_id = '.$dataArray['main_category_id'], AI_CHAT_SUB_CATEGORY_TABLE);
                    array_push($data['viewAiChatMainCategory'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiChat/mainCategory/ai_chat_main_category_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }

    public function aiChatMainCategoryEdit($mainCategoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_MAIN_CATEGORY_ALIAS, "can_edit");
            if($isPermission){
                $mainCategoryID = urlDecodes($mainCategoryID);
                if(ctype_digit($mainCategoryID)){
                    $data['aiChatMainCategoryData'] = $this->DataModel->getData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE);
                    $data['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$data['aiChatMainCategoryData']['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                    if(!empty($data['aiChatMainCategoryData'])){
                        $this->load->view('header');
                        $this->load->view('aiChat/mainCategory/ai_chat_main_category_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        if(empty($_FILES['main_category_icon']['name'])){
                            $editData = array(
                                'main_category_name'=>$this->input->post('main_category_name'),
                                'main_category_title'=>$this->input->post('main_category_title'),
                                'main_category_description'=>$this->input->post('main_category_description'),
                                'main_category_date'=>timeZone(),
                                'main_category_status'=>$this->input->post('main_category_status'),
                            );
                        } else {
                            $s3Client = getconfig();
                            $uniqueCode = uniqueKey();
                        
                            $iconKey = $data['aiChatMainCategoryData']['main_category_icon'];
    	                    $newIconKey = basename($iconKey);
    	                
                            $deleteIcon = $s3Client->deleteObject([
    	                        'Bucket' => AI_BUCKET_NAME,
    	                        'Key'    => ICON_PATH.$newIconKey,
    	                    ]);

    	                    $iconName = $_FILES['main_category_icon']['name'];
    	            	    $iconTemp = $_FILES['main_category_icon']['tmp_name'];
    	            	    $iconPath = ICON_PATH;
    	                    $iconResponse = newAiBucketObject($iconName, $uniqueCode, $iconTemp, $iconPath);
                            
                            $editData = array(
                                'main_category_name'=>$this->input->post('main_category_name'),
                                'main_category_icon'=>$iconResponse,
                                'main_category_title'=>$this->input->post('main_category_title'),
                                'main_category_description'=>$this->input->post('main_category_description'),
                                'main_category_date'=>timeZone(),
                                'main_category_status'=>$this->input->post('main_category_status'),
                            );
                        }
                        $editDataEntry = $this->DataModel->editData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-ai-chat-main-category');
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
    
    public function aiChatMainCategoryStatus($mainCategoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_CHAT_MAIN_CATEGORY_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_CHAT_MAIN_CATEGORY_PUBLISH_ALIAS, "can_edit");
            $mainCategoryID = urlDecodes($mainCategoryID);
            if(ctype_digit($mainCategoryID)){
                $aiChatMainCategoryData = $this->DataModel->getData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE);
                if($aiChatMainCategoryData['main_category_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'main_category_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'main_category_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE, $editData);
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
    
    public function aiChatMainCategoryDelete($mainCategoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_MAIN_CATEGORY_ALIAS, "can_delete");
            if($isPermission){ 
                $mainCategoryID = urlDecodes($mainCategoryID);
                if(ctype_digit($mainCategoryID)){
                    $data['viewAiChatSubCategoryData'] = $this->DataModel->getData('main_category_id = '.$mainCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
                    if(!empty($data['viewAiChatSubCategoryData'])){
                        $this->session->set_userdata('session_ai_chat_main_category_delete', "You can't delete ai chat main category! Please delete ai chat sub category before deleting ai chat main category");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {                            
                        $data['aiChatMainCategoryData'] = $this->DataModel->getData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE);

                        $iconKey = $data['aiChatMainCategoryData']['main_category_icon'];
                    
                        $newIconKey = basename($iconKey);
                    
                        $existingRecords = $this->DataModel->getData("main_category_icon = '$iconKey' AND main_category_id != $mainCategoryID", AI_CHAT_MAIN_CATEGORY_TABLE);
                    
                        if(empty($existingRecords)){
                            $s3Client = getConfig();
                            $deleteIcon = $s3Client->deleteObject([
                                'Bucket' => AI_BUCKET_NAME,
                                'Key'    => ICON_PATH.$newIconKey,
                            ]);
                        } 
                        $resultDataEntry = $this->DataModel->deleteData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE);
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
    
    public function allAiChatMainCategoryDelete($action = null){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if($action === 'delete'){
                $isPermission = checkPermission(AI_CHAT_MAIN_CATEGORY_ALIAS, "can_delete");
                if($isPermission){ 
                    $selectedRecords = $this->input->post('main_category_id');
                        if(!empty($selectedRecords)){
                            $mainCategoryIds = array_map('intval', $selectedRecords);
                            foreach($mainCategoryIds as $mainCategoryID) {
                                $data['viewAiChatSubCategoryData'] = $this->DataModel->getData('main_category_id = '.$mainCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
                                if(!empty($data['viewAiChatSubCategoryData'])){
                                    $this->session->set_userdata('session_all_ai_chat_main_category_delete', "You can't delete ai chat main category! Please delete ai chat sub category before deleting ai chat main category");
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {                            
                                    $data['aiChatMainCategoryData'] = $this->DataModel->getData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE);
            
                                    $iconKey = $data['aiChatMainCategoryData']['main_category_icon'];
                                
                                    $newIconKey = basename($iconKey);
                                
                                    $existingRecords = $this->DataModel->getData("main_category_icon = '$iconKey' AND main_category_id != $mainCategoryID", AI_CHAT_MAIN_CATEGORY_TABLE);
                                
                                    if(empty($existingRecords)){
                                        $s3Client = getConfig();
                                        $deleteIcon = $s3Client->deleteObject([
                                            'Bucket' => AI_BUCKET_NAME,
                                            'Key'    => ICON_PATH.$newIconKey,
                                        ]);
                                    } 
                                    $resultDataEntry = $this->DataModel->deleteData('main_category_id = '.$mainCategoryID, AI_CHAT_MAIN_CATEGORY_TABLE);
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