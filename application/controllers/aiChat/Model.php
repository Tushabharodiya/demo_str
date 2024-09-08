<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Controller {
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
	
    public function aiChatModelNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_MODEL_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('aiChat/model/ai_chat_model_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $modelName = $this->input->post('model_name');
                    $aiChatModelNameData = $this->DataModel->getData('model_identifier_name = "'.$modelName.'"', AI_CHAT_MODEL_TABLE);

                    if($aiChatModelNameData !== null && isset($aiChatModelNameData['model_identifier_name']) && $aiChatModelNameData['model_identifier_name'] == $modelName){
                        $this->session->set_userdata('session_ai_chat_model_new_model_name', "Model name $modelName is already exits in database!");
                        redirect('new-ai-chat-model');
                    } else {
                        $s3Client = getconfig();
                        $uniqueCode = uniqueKey();
    
                        $iconName = $_FILES['model_icon']['name'];
                        $iconTemp = $_FILES['model_icon']['tmp_name'];
                        $iconPath = ICON_PATH;
                        $iconResponse = newAiBucketObject($iconName, $uniqueCode, $iconTemp, $iconPath);
                        
                        $modelName = $this->input->post('model_name');
                        $modelDescription = $this->input->post('model_description');
                    
                        $textDataArray = array(
                            'model_name'=>$modelName,
                            'model_description'=>$modelDescription
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
                                    'model_identifier_name'=>$modelName,
                                    'model_name'=>isset($translatedDataArray['model_name']) ? $translatedDataArray['model_name'] : $modelName,
                                    'model_description'=>isset($translatedDataArray['model_description']) ? $translatedDataArray['model_description'] : $modelDescription,
                                    'model_icon'=>$iconResponse,
                                    'model_alias'=>$this->input->post('model_alias'),
                                    'model_key'=>$this->input->post('model_key'),
                                    'model_premium'=>$this->input->post('model_premium'),
                                    'model_status'=>$this->input->post('model_status'),
                                );
                            
                                $lastInsertID = $this->DataModel->insertData(AI_CHAT_MODEL_TABLE, $newData);
                            
                                if($lastInsertID){
                                    $editData = array('model_position'=>$lastInsertID);
                                    $editDataEntry = $this->DataModel->editData('model_id = '.$lastInsertID, AI_CHAT_MODEL_TABLE, $editData);
                                }
                            }
                        } else {
                            $this->session->set_userdata('session_ai_chat_model_new', "You can't insert ai chat model! Please insert ai chat language before inserting ai chat model");
                        }
                        redirect('view-ai-chat-model');
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatModelView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_chat_model');
            }
            if(isset($_POST['submit_search'])){
                $searchAiChatModel = $this->input->post('search_ai_chat_model');
                $this->session->set_userdata('session_ai_chat_model', $searchAiChatModel);
            }
            $sessionAiChatModel = $this->session->userdata('session_ai_chat_model');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_chat_model_status');
                redirect('view-ai-chat-model');
            }
            
            $searchAiChatModelStatus = $this->input->post('search_ai_chat_model_status');
            if($searchAiChatModelStatus === 'publish' or $searchAiChatModelStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_chat_model_status', $searchAiChatModelStatus);
            } else if($searchAiChatModelStatus === 'all'){
                $this->session->unset_userdata('session_ai_chat_model_status');
            }
            $sessionAiChatModelStatus = $this->session->userdata('session_ai_chat_model_status');

            $data = array();
            //get rows count
            $conditions['search_ai_chat_model'] = $sessionAiChatModel;
            $conditions['search_ai_chat_model_status'] = $sessionAiChatModelStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiChatModel($conditions, AI_CHAT_MODEL_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-chat-model');
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
            
            $aiChatModel = $this->DataModel->viewAiChatModel($conditions, AI_CHAT_MODEL_TABLE);
            $data['countAiChatModel'] = $this->DataModel->countAiChatModel($conditions, AI_CHAT_MODEL_TABLE);
            
            $data['viewAiChatModel'] = array();
            if(is_array($aiChatModel) || is_object($aiChatModel)){
                foreach($aiChatModel as $Row){
                    $dataArray = array();
                    $dataArray['model_id'] = $Row['model_id'];
                    $dataArray['language_code'] = $Row['language_code'];
                    $dataArray['model_name'] = $Row['model_name'];
                    $dataArray['model_description'] = $Row['model_description'];
                    $dataArray['model_icon'] = $Row['model_icon'];
                    $dataArray['model_alias'] = $Row['model_alias'];
                    $dataArray['model_key'] = $Row['model_key'];
                    $dataArray['model_position'] = $Row['model_position'];
                    $dataArray['model_premium'] = $Row['model_premium'];
                    $dataArray['model_status'] = $Row['model_status'];
                    $dataArray['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$dataArray['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                    array_push($data['viewAiChatModel'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiChat/model/ai_chat_model_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatModelEdit($modelID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_MODEL_ALIAS, "can_edit");
            if($isPermission){
                $modelID = urlDecodes($modelID);
                if(ctype_digit($modelID)){
                    $data['aiChatModelData'] = $this->DataModel->getData('model_id = '.$modelID, AI_CHAT_MODEL_TABLE);
                    $data['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$data['aiChatModelData']['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                    if(!empty($data['aiChatModelData'])){
                        $this->load->view('header');
                        $this->load->view('aiChat/model/ai_chat_model_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        if(empty($_FILES['model_icon']['name'])){
                            $editData = array(
                                'model_name'=>$this->input->post('model_name'),
                                'model_description'=>$this->input->post('model_description'),
                                'model_alias'=>$this->input->post('model_alias'),
                                'model_key'=>$this->input->post('model_key'),
                                'model_position'=>$this->input->post('model_position'),
                                'model_premium'=>$this->input->post('model_premium'),
                                'model_status'=>$this->input->post('model_status'),
                            );
                        } else {
                            $s3Client = getconfig();
                            $uniqueCode = uniqueKey();
                        
                            $iconKey = $data['aiChatModel']['model_icon'];
    	                    $newIconKey = basename($iconKey);
    	                
                            $deleteIcon = $s3Client->deleteObject([
    	                        'Bucket' => AI_BUCKET_NAME,
    	                        'Key'    => ICON_PATH.$newIconKey,
    	                    ]);

    	                    $iconName = $_FILES['model_icon']['name'];
    	            	    $iconTemp = $_FILES['model_icon']['tmp_name'];
    	            	    $iconPath = ICON_PATH;
    	                    $iconResponse = newAiBucketObject($iconName, $uniqueCode, $iconTemp, $iconPath);
                            
                            $editData = array(
                                'model_name'=>$this->input->post('model_name'),
                                'model_description'=>$this->input->post('model_description'),
                                'model_icon'=>$iconResponse,
                                'model_alias'=>$this->input->post('model_alias'),
                                'model_key'=>$this->input->post('model_key'),
                                'model_position'=>$this->input->post('model_position'),
                                'model_premium'=>$this->input->post('model_premium'),
                                'model_status'=>$this->input->post('model_status'),
                            );
                        }
                        $editDataEntry = $this->DataModel->editData('model_id = '.$modelID, AI_CHAT_MODEL_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-ai-chat-model');
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
    
    public function aiChatModelStatus($modelID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_CHAT_MODEL_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_CHAT_MODEL_PUBLISH_ALIAS, "can_edit");
            $modelID = urlDecodes($modelID);
            if(ctype_digit($modelID)){
                $aiChatModel = $this->DataModel->getData('model_id = '.$modelID, AI_CHAT_MODEL_TABLE);
                if($aiChatModel['model_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'model_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'model_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('model_id = '.$modelID, AI_CHAT_MODEL_TABLE, $editData);
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
    
    public function aiChatModelDelete($modelID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_MODEL_ALIAS, "can_delete");
            if($isPermission){ 
                $modelID = urlDecodes($modelID);
                if(ctype_digit($modelID)){
                    $data['aiChatModelData'] = $this->DataModel->getData('model_id = '.$modelID, AI_CHAT_MODEL_TABLE);

                    $iconKey = $data['aiChatModelData']['model_icon'];
                
                    $newIconKey = basename($iconKey);
                
                    $existingRecords = $this->DataModel->getData("model_icon = '$iconKey' AND model_id != $modelID", AI_CHAT_MODEL_TABLE);
                
                    if(empty($existingRecords)){
                        $s3Client = getConfig();
                        $deleteIcon = $s3Client->deleteObject([
                            'Bucket' => AI_BUCKET_NAME,
                            'Key'    => ICON_PATH.$newIconKey,
                        ]);
                    } 
                    $resultDataEntry = $this->DataModel->deleteData('model_id = '.$modelID, AI_CHAT_MODEL_TABLE);
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
    
    public function allAiChatModelDelete($action = null){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if($action === 'delete'){
                $isPermission = checkPermission(AI_CHAT_MODEL_ALIAS, "can_delete");
                if($isPermission){ 
                    $selectedRecords = $this->input->post('model_id');
                        if(!empty($selectedRecords)){
                            $modelIds = array_map('intval', $selectedRecords);
                            foreach($modelIds as $modelID) {
                                $data['aiChatModelData'] = $this->DataModel->getData('model_id = '.$modelID, AI_CHAT_MODEL_TABLE);

                                $iconKey = $data['aiChatModelData']['model_icon'];
                            
                                $newIconKey = basename($iconKey);
                            
                                $existingRecords = $this->DataModel->getData("model_icon = '$iconKey' AND model_id != $modelID", AI_CHAT_MODEL_TABLE);
                            
                                if(empty($existingRecords)){
                                    $s3Client = getConfig();
                                    $deleteIcon = $s3Client->deleteObject([
                                        'Bucket' => AI_BUCKET_NAME,
                                        'Key'    => ICON_PATH.$newIconKey,
                                    ]);
                                } 
                                $resultDataEntry = $this->DataModel->deleteData('model_id = '.$modelID, AI_CHAT_MODEL_TABLE);
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