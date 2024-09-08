<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {
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
	
    public function aiChatLanguageNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_LANGUAGE_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('aiChat/language/ai_chat_language_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $languageName = $this->input->post('language_name');
                    $aiChatLanguageNameData = $this->DataModel->getData('language_name = "'.$languageName.'"', AI_CHAT_LANGUAGE_TABLE);
                    
                    if($aiChatLanguageNameData !== null && isset($aiChatLanguageNameData['language_name']) && $aiChatLanguageNameData['language_name'] == $languageName){
                        $this->session->set_userdata('session_ai_chat_language_new_language_name', "Language name $languageName is already exits in database!");
                        redirect('new-ai-chat-language');
                    } else {
                        $newData = array( 
                            'language_title'=>$this->input->post('language_title'),
                            'language_name'=>$this->input->post('language_name'),
                            'language_code'=>$this->input->post('language_code'),
                            'language_status'=>$this->input->post('language_status'),
                        );
                        $lastInsertID = $this->DataModel->insertData(AI_CHAT_LANGUAGE_TABLE, $newData);
                        if($lastInsertID){
                            $aiChatLanguageData = $this->DataModel->getData('language_id = '.$lastInsertID, AI_CHAT_LANGUAGE_TABLE);
                            $toLanguage = $aiChatLanguageData['language_code'];
                            
                            $aiChatModelData = $this->DataModel->viewGroupData('model_id '.'ASC', null, 'model_identifier_name', AI_CHAT_MODEL_TABLE);
                            if(!empty($aiChatModelData)){
                                foreach($aiChatModelData as $modelRow){
                                    $modelName = $modelRow['model_name'];
                                    $modelDescription = $modelRow['model_description'];
                                    
                                    $modelTextDataArray = array(
                                        'model_name'=>$modelName,
                                        'model_description'=>$modelDescription
                                    );
                                
                                    $modelFromLanguage = $modelRow['language_code'];
                                    
                                    $modelTranslatedDataArray = array();
                                    foreach($modelTextDataArray as $modelFieldName => $modelTextData){
                                        $modelTranslatedText = translateText($modelTextData, $modelFromLanguage, $toLanguage);
                                        
                                        $modelTranslatedDataArray[$modelFieldName] = $modelTranslatedText;
                                    }
                                            
                                    $modelNewData = array(
                                        'language_code'=>$toLanguage,
                                        'model_identifier_name'=>$modelRow['model_identifier_name'],
                                        'model_name'=>isset($modelTranslatedDataArray['model_name']) ? $modelTranslatedDataArray['model_name'] : $modelName,
                                        'model_description'=>isset($modelTranslatedDataArray['model_description']) ? $modelTranslatedDataArray['model_description'] : $modelDescription,
                                        'model_icon'=>$modelRow['model_icon'],
                                        'model_alias'=>$modelRow['model_alias'],
                                        'model_key'=>$modelRow['model_key'],
                                        'model_premium'=>$modelRow['model_premium'],
                                        'model_status'=>$modelRow['model_status'],
                                    );
                                
                                    $modelLastInsertID = $this->DataModel->insertData(AI_CHAT_MODEL_TABLE, $modelNewData);
                                    if($modelLastInsertID){
                                        $modelEditData = array('model_position'=>$modelLastInsertID);
                                        $modelEditDataEntry = $this->DataModel->editData('model_id = '.$modelLastInsertID, AI_CHAT_MODEL_TABLE, $modelEditData);
                                    }
                                }
                            }
                            
                            $aiChatMainCategoryData = $this->DataModel->viewGroupData('main_category_id '.'ASC', null, 'main_category_identifier_name', AI_CHAT_MAIN_CATEGORY_TABLE);
                            if(!empty($aiChatMainCategoryData)){
                                foreach($aiChatMainCategoryData as $mainCategoryRow){
                                    $mainCategoryName = $mainCategoryRow['main_category_name'];
                                    $mainCategoryTitle = $mainCategoryRow['main_category_title'];
                                    $mainCategoryDescription = $mainCategoryRow['main_category_description'];
                                    
                                    $mainCategoryTextDataArray = array(
                                        'main_category_name'=>$mainCategoryName,
                                        'main_category_title'=>$mainCategoryTitle,
                                        'main_category_description'=>$mainCategoryDescription,
                                    );
                                
                                    $mainCategoryFromLanguage = $mainCategoryRow['language_code'];
                                    
                                    $mainCategoryTranslatedDataArray = array();
                                    foreach($mainCategoryTextDataArray as $mainCategoryFieldName => $mainCategoryTextData){
                                        $mainCategoryTranslatedText = translateText($mainCategoryTextData, $mainCategoryFromLanguage, $toLanguage);
                                        
                                        $mainCategoryTranslatedDataArray[$mainCategoryFieldName] = $mainCategoryTranslatedText;
                                    }
                                            
                                    $mainCategoryNewData = array(
                                        'language_code'=>$toLanguage,
                                        'main_category_identifier_name'=>$mainCategoryRow['main_category_identifier_name'],
                                        'main_category_name'=>isset($mainCategoryTranslatedDataArray['main_category_name']) ? $mainCategoryTranslatedDataArray['main_category_name'] : $mainCategoryName,
                                        'main_category_icon'=>$mainCategoryRow['main_category_icon'],
                                        'main_category_title'=>isset($mainCategoryTranslatedDataArray['main_category_title']) ? $mainCategoryTranslatedDataArray['main_category_title'] : $mainCategoryTitle,
                                        'main_category_description'=>isset($mainCategoryTranslatedDataArray['main_category_description']) ? $mainCategoryTranslatedDataArray['main_category_description'] : $mainCategoryDescription,
                                        'main_category_date'=>timeZone(),
                                        'main_category_status'=>$mainCategoryRow['main_category_status'],
                                    );
                                
                                    $mainCategoryNewDataEntry = $this->DataModel->insertData(AI_CHAT_MAIN_CATEGORY_TABLE, $mainCategoryNewData);
                                }
                            }
                            
                            $aiChatSubCategoryData = $this->DataModel->viewGroupData('sub_category_id '.'ASC', null, 'sub_category_identifier_name', AI_CHAT_SUB_CATEGORY_TABLE);
                            if(!empty($aiChatSubCategoryData)){
                                foreach($aiChatSubCategoryData as $subCategoryRow){
                                    $subCategoryName = $subCategoryRow['sub_category_name'];
                                    $subCategoryDescription = $subCategoryRow['sub_category_description'];
    
                                    $subCategoryTextDataArray = array(
                                        'sub_category_name'=>$subCategoryName,
                                        'sub_category_description'=>$subCategoryDescription,
                                    );
                                
                                    $subCategoryFromLanguage = $subCategoryRow['language_code'];
                                    
                                    $subCategoryTranslatedDataArray = array();
                                    foreach($subCategoryTextDataArray as $subCategoryFieldName => $subCategoryTextData){
                                        $subCategoryTranslatedText = translateText($subCategoryTextData, $subCategoryFromLanguage, $toLanguage);
                                        
                                        $subCategoryTranslatedDataArray[$subCategoryFieldName] = $subCategoryTranslatedText;
                                    }
                                    $aiChatMainCategoryIdData = $this->DataModel->getData('main_category_id = "'.$subCategoryRow['main_category_id'].'"', AI_CHAT_MAIN_CATEGORY_TABLE);
                                    $mainCategoryIdentifierName = $aiChatMainCategoryIdData['main_category_identifier_name'];
                                    $aiChatMainCategoryIdentifierData = $this->DataModel->getData('language_code = "'.$toLanguage.'" AND main_category_identifier_name = "'.$mainCategoryIdentifierName.'"', AI_CHAT_MAIN_CATEGORY_TABLE);
                                    $subCategoryNewData = array(
                                        'main_category_id'=>$aiChatMainCategoryIdentifierData['main_category_id'],
                                        'language_code'=>$toLanguage,
                                        'sub_category_identifier_name'=>$subCategoryRow['sub_category_identifier_name'],
                                        'sub_category_name'=>isset($subCategoryTranslatedDataArray['sub_category_name']) ? $subCategoryTranslatedDataArray['sub_category_name'] : $subCategoryName,
                                        'sub_category_description'=>isset($subCategoryTranslatedDataArray['sub_category_description']) ? $subCategoryTranslatedDataArray['sub_category_description'] : $subCategoryDescription,
                                        'sub_category_icon'=>$subCategoryRow['sub_category_icon'],
                                        'sub_category_view'=>$subCategoryRow['sub_category_view'],
                                        'sub_category_status'=>$subCategoryRow['sub_category_status'],
                                    );
                                
                                    $subCategoryLastInsertID = $this->DataModel->insertData(AI_CHAT_SUB_CATEGORY_TABLE, $subCategoryNewData);
                                    if($subCategoryLastInsertID){
                                        $subCategoryEditData = array('sub_category_position'=>$subCategoryLastInsertID);
                                        $subCategoryEditDataEntry = $this->DataModel->editData('sub_category_id = '.$subCategoryLastInsertID, AI_CHAT_SUB_CATEGORY_TABLE, $subCategoryEditData);
                                    }
                                }
                            }
                            
                            $aiChatData = $this->DataModel->viewGroupData('data_id '.'ASC', null, 'data_identifier_name', AI_CHAT_DATA_TABLE);
                            if(!empty($aiChatData)){
                                foreach($aiChatData as $dataRow){
                                    $dataTitle = $dataRow['data_title'];
                                    $dataPrompt = $dataRow['data_prompt'];
                                    $dataNote = $dataRow['data_note'];
    
                                    $dataTextDataArray = array(
                                        'data_title'=>$dataTitle,
                                        'data_prompt'=>$dataPrompt,
                                        'data_note'=>$dataNote,
                                    );
                                
                                    $dataFromLanguage = $dataRow['language_code'];
                                    
                                    $dataTranslatedDataArray = array();
                                    foreach($dataTextDataArray as $dataFieldName => $dataTextData){
                                        $dataTranslatedText = translateText($dataTextData, $dataFromLanguage, $toLanguage);
                                        
                                        $dataTranslatedDataArray[$dataFieldName] = $dataTranslatedText;
                                    }
                                     
                                    $aiChatSubCategoryIdData = $this->DataModel->getData('sub_category_id = "'.$dataRow['sub_category_id'].'"', AI_CHAT_SUB_CATEGORY_TABLE);
                                    $subCategoryIdentifierName = $aiChatSubCategoryIdData['sub_category_identifier_name'];
                                    $aiChatSubCategoryIdentifierData = $this->DataModel->getData('language_code = "'.$toLanguage.'" AND sub_category_identifier_name = "'.$subCategoryIdentifierName.'"', AI_CHAT_SUB_CATEGORY_TABLE);      
                                    $dataNewData = array(
                                        'sub_category_id'=>$aiChatSubCategoryIdentifierData['sub_category_id'],
                                        'language_code'=>$toLanguage,
                                        'data_identifier_name'=>$dataRow['data_identifier_name'],
                                        'data_title'=>isset($dataTranslatedDataArray['data_title']) ? $dataTranslatedDataArray['data_title'] : $dataTitle,
                                        'data_prompt'=>isset($dataTranslatedDataArray['data_prompt']) ? $dataTranslatedDataArray['data_prompt'] : $dataPrompt,
                                        'data_note'=>isset($dataTranslatedDataArray['data_note']) ? $dataTranslatedDataArray['data_note'] : $dataNote,
                                        'data_status'=>$dataRow['data_status'],
                                    );
                                
                                    $dataLastInsertID = $this->DataModel->insertData(AI_CHAT_DATA_TABLE, $dataNewData);
                                    if($dataLastInsertID){
                                        $dataEditData = array('data_position'=>$dataLastInsertID);
                                        $dataEditDataEntry = $this->DataModel->editData('data_id = '.$dataLastInsertID, AI_CHAT_DATA_TABLE, $dataEditData);
                                    }
                                }
                            }
                            redirect('view-ai-chat-language');  
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
    
    public function aiChatLanguageView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_chat_language');
            }
            if(isset($_POST['submit_search'])){
                $searchAiChatLanguage = $this->input->post('search_ai_chat_language');
                $this->session->set_userdata('session_ai_chat_language', $searchAiChatLanguage);
            }
            $sessionAiChatLanguage = $this->session->userdata('session_ai_chat_language');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_chat_language_status');
                redirect('view-ai-chat-language');
            }
            
            $searchAiChatLanguageStatus = $this->input->post('search_ai_chat_language_status');
            if($searchAiChatLanguageStatus === 'publish' or $searchAiChatLanguageStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_chat_language_status', $searchAiChatLanguageStatus);
            } else if($searchAiChatLanguageStatus === 'all'){
                $this->session->unset_userdata('session_ai_chat_language_status');
            }
            $sessionAiChatLanguageStatus = $this->session->userdata('session_ai_chat_language_status');

            $data = array();
            //get rows count
            $conditions['search_ai_chat_language'] = $sessionAiChatLanguage;
            $conditions['search_ai_chat_language_status'] = $sessionAiChatLanguageStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiChatLanguage($conditions, AI_CHAT_LANGUAGE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-chat-language');
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
            
            $aiChatLanguage = $this->DataModel->viewAiChatLanguage($conditions, AI_CHAT_LANGUAGE_TABLE);
            $data['countAiChatLanguage'] = $this->DataModel->countAiChatLanguage($conditions, AI_CHAT_LANGUAGE_TABLE);
            
            $data['viewAiChatLanguage'] = array();
            if(is_array($aiChatLanguage) || is_object($aiChatLanguage)){
                foreach($aiChatLanguage as $Row){
                    $dataArray = array();
                    $dataArray['language_id'] = $Row['language_id'];
                    $dataArray['language_title'] = $Row['language_title'];
                    $dataArray['language_name'] = $Row['language_name'];
                    $dataArray['language_code'] = $Row['language_code'];
                    $dataArray['language_status'] = $Row['language_status'];
                    array_push($data['viewAiChatLanguage'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiChat/language/ai_chat_language_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatLanguageEdit($languageID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_LANGUAGE_ALIAS, "can_edit");
            if($isPermission){
                $languageID = urlDecodes($languageID);
                if(ctype_digit($languageID)){
                    $data['aiChatLanguage'] = $this->DataModel->getData('language_id = '.$languageID, AI_CHAT_LANGUAGE_TABLE);
                    
                    if(!empty($data['aiChatLanguage'])){
                        $this->load->view('header');
                        $this->load->view('aiChat/language/ai_chat_language_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'language_title'=>$this->input->post('language_title'),
                            'language_name'=>$this->input->post('language_name'),
                            'language_status'=>$this->input->post('language_status'),
                            'language_code'=>$this->input->post('language_code'),
                        );
                        $editDataEntry = $this->DataModel->editData('language_id = '.$languageID, AI_CHAT_LANGUAGE_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-ai-chat-language');
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
    
    public function aiChatLanguageDelete($languageID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_LANGUAGE_ALIAS, "can_delete");
            if($isPermission){ 
                $languageID = urlDecodes($languageID);
                if(ctype_digit($languageID)){
                    $aiChatLanguageData = $this->DataModel->getData('language_id = '.$languageID, AI_CHAT_LANGUAGE_TABLE);
                    $languageCode = $aiChatLanguageData['language_code'];
                    
                    $aiChatModelData = $this->DataModel->getData('language_code = "'.$languageCode.'"', AI_CHAT_MODEL_TABLE);
                    $aiChatMainCategoryData = $this->DataModel->getData('language_code = "'.$languageCode.'"', AI_CHAT_MAIN_CATEGORY_TABLE);
                    $aiChatSubCategoryData = $this->DataModel->getData('language_code = "'.$languageCode.'"', AI_CHAT_SUB_CATEGORY_TABLE);
                    $aiChatData = $this->DataModel->getData('language_code = "'.$languageCode.'"', AI_CHAT_DATA_TABLE);
                    
                    if(!empty($aiChatModelData)){
                        $this->session->set_userdata('session_ai_chat_language_delete_ai_chat_model', "You can't delete ai chat language! Please delete ai chat model before deleting ai chat language");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else if(!empty($aiChatMainCategoryData)){
                        $this->session->set_userdata('session_ai_chat_language_delete_ai_chat_main_category', "You can't delete ai chat language! Please delete ai chat main category before deleting ai chat language");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else if(!empty($aiChatSubCategoryData)){
                        $this->session->set_userdata('session_ai_chat_language_delete_ai_chat_sub_category', "You can't delete ai chat language! Please delete ai chat sub category before deleting ai chat language");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else if(!empty($aiChatData)){
                        $this->session->set_userdata('session_ai_chat_language_delete_ai_chat_data', "You can't delete ai chat language! Please delete ai chat data before deleting ai chat language");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $resultDataEntry = $this->DataModel->deleteData('language_id = '.$languageID, AI_CHAT_LANGUAGE_TABLE);
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