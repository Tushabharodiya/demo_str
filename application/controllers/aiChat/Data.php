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
	
    public function aiChatDataNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_DATA_ALIAS, "can_add");
            if($isPermission){
                $data['aiChatSubCategoryData'] = $this->DataModel->viewAiChatSubCategoryData(null, null, AI_CHAT_SUB_CATEGORY_TABLE);
                $this->load->view('header');
                $this->load->view('aiChat/data/ai_chat_data_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $dataTitle = $this->input->post('data_title');
                    $dataPrompt = $this->input->post('data_prompt');
                    $dataNote = $this->input->post('data_note');
                    
                    $aiChatDataTitleData = $this->DataModel->getData('data_identifier_name = "'.$dataTitle.'"', AI_CHAT_DATA_TABLE);
                    
                    if($aiChatDataTitleData !== null && isset($aiChatDataTitleData['data_identifier_name']) && $aiChatDataTitleData['data_identifier_name'] == $dataTitle){
                        $this->session->set_userdata('session_ai_chat_data_new_data_title', "Data title $dataTitle is already exits in database!");
                        redirect('new-ai-chat-data');
                    } else {
                        $textDataArray = array(
                            'data_title'=>$dataTitle,
                            'data_prompt'=>$dataPrompt,
                            'data_note'=>$dataNote,
                        );
                        
                        $fromLanguage = 'en';
                        
                        $aiChatSubCategory = $this->DataModel->viewData(null, 'sub_category_identifier_name = "'.$this->input->post('sub_category_id').'"', AI_CHAT_SUB_CATEGORY_TABLE);
                        $languages = array();
                        
                        foreach($aiChatSubCategory as $language){
                            $languages[] = $language['language_code'];
                        }
                        
                        foreach($languages as $languageName => $toLanguage){
                            $translatedDataArray = array();
                        
                            foreach($textDataArray as $fieldName => $textData){
                                $translatedText = translateText($textData, $fromLanguage, $toLanguage);
                                
                                $translatedDataArray[$fieldName] = $translatedText;
                            }
                            $aiChatSubCategoryData = $this->DataModel->getData('language_code = "'.$toLanguage.'" AND sub_category_identifier_name = "'.$this->input->post('sub_category_id').'"', AI_CHAT_SUB_CATEGORY_TABLE);
                            $newData = array(
                                'sub_category_id'=>$aiChatSubCategoryData['sub_category_id'],
                                'language_code'=>$toLanguage,
                                'data_identifier_name'=>$dataTitle,
                                'data_title'=>isset($translatedDataArray['data_title']) ? $translatedDataArray['data_title'] : $dataTitle,
                                'data_prompt'=>isset($translatedDataArray['data_prompt']) ? $translatedDataArray['data_prompt'] : $dataPrompt,
                                'data_note'=>isset($translatedDataArray['data_note']) ? $translatedDataArray['data_note'] : $dataNote,
                                'data_status'=>$this->input->post('data_status'),
                            );
                        
                            $lastInsertID = $this->DataModel->insertData(AI_CHAT_DATA_TABLE, $newData);
                            if($lastInsertID){
                                $editData = array('data_position'=>$lastInsertID);
                                $editDataEntry = $this->DataModel->editData('data_id = '.$lastInsertID, AI_CHAT_DATA_TABLE, $editData);
                            }
                        }
                        redirect('view-ai-chat-data');
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatDataView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_chat_data');
            }
            if(isset($_POST['submit_search'])){
                $searchAiChatData = $this->input->post('search_ai_chat_data');
                $this->session->set_userdata('session_ai_chat_data', $searchAiChatData);
            }
            $sessionAiChatData = $this->session->userdata('session_ai_chat_data');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_chat_data_status');
                redirect('view-ai-chat-data');
            }
            
            $searchAiChatDataStatus = $this->input->post('search_ai_chat_data_status');
            if($searchAiChatDataStatus === 'publish' or $searchAiChatDataStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_chat_data_status', $searchAiChatDataStatus);
            } else if($searchAiChatDataStatus === 'all'){
                $this->session->unset_userdata('session_ai_chat_data_status');
            }
            $sessionAiChatDataStatus = $this->session->userdata('session_ai_chat_data_status');

            $data = array();
            //get rows count
            $conditions['search_ai_chat_data'] = $sessionAiChatData;
            $conditions['search_ai_chat_data_status'] = $sessionAiChatDataStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiChatData($conditions, AI_CHAT_DATA_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-chat-data');
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
            
            $aiChatData = $this->DataModel->viewAiChatData($conditions, AI_CHAT_DATA_TABLE);
            $data['countAiChatData'] = $this->DataModel->countAiChatData($conditions, AI_CHAT_DATA_TABLE);
            
            $data['viewAiChatData'] = array();
            if(is_array($aiChatData) || is_object($aiChatData)){
                foreach($aiChatData as $Row){
                    $dataArray = array();
                    $dataArray['data_id'] = $Row['data_id'];
                    $dataArray['sub_category_id'] = $Row['sub_category_id'];
                    $dataArray['language_code'] = $Row['language_code'];
                    $dataArray['data_title'] = $Row['data_title'];
                    $dataArray['data_prompt'] = $Row['data_prompt'];
                    $dataArray['data_note'] = $Row['data_note'];
                    $dataArray['data_position'] = $Row['data_position'];
                    $dataArray['data_status'] = $Row['data_status'];
                    $dataArray['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$dataArray['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                    $dataArray['aiChatSubCategoryData'] = $this->DataModel->getData('sub_category_id = '.$dataArray['sub_category_id'], AI_CHAT_SUB_CATEGORY_TABLE);
                    array_push($data['viewAiChatData'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiChat/data/ai_chat_data_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatDatasView($subCategoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $subCategoryID = urlDecodes($subCategoryID);
            if(ctype_digit($subCategoryID)){
                if(isset($_POST['reset_search'])){
                    $this->session->unset_userdata('session_ai_chat_datas');
                }
                if(isset($_POST['submit_search'])){
                    $searchAiChatDatas = $this->input->post('search_ai_chat_datas');
                    $this->session->set_userdata('session_ai_chat_datas', $searchAiChatDatas);
                }
                $sessionAiChatDatas = $this->session->userdata('session_ai_chat_datas');
                
                if(isset($_POST['reset_filter'])){
                    $this->session->unset_userdata('session_ai_chat_datas_status');
                    redirect('view-ai-chat-datas/'.urlEncodes($subCategoryID));
                }
                
                $searchAiChatDatasStatus = $this->input->post('search_ai_chat_datas_status');
                if($searchAiChatDatasStatus === 'publish' or $searchAiChatDatasStatus == 'unpublish'){
                    $this->session->set_userdata('session_ai_chat_datas_status', $searchAiChatDatasStatus);
                } else if($searchAiChatDatasStatus === 'all'){
                    $this->session->unset_userdata('session_ai_chat_datas_status');
                }
                $sessionAiChatDatasStatus = $this->session->userdata('session_ai_chat_datas_status');
    
                $data = array();
                //get rows count
                $conditions['search_ai_chat_datas'] = $sessionAiChatDatas;
                $conditions['search_ai_chat_datas_status'] = $sessionAiChatDatasStatus;
                $conditions['returnType'] = 'count';
                
                $totalRec = $this->DataModel->viewAiChatDatas($conditions, $subCategoryID, AI_CHAT_DATA_TABLE);
        
                //pagination config
                $config['base_url']    = site_url('view-ai-chat-datas/'.urlEncodes($subCategoryID));
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
                
                $aiChatDatas = $this->DataModel->viewAiChatDatas($conditions, $subCategoryID, AI_CHAT_DATA_TABLE);
                $data['countAiChatDatas'] = $this->DataModel->countAiChatDatas($conditions, $subCategoryID, AI_CHAT_DATA_TABLE);
                
                $data['viewAiChatDatas'] = array();
                if(is_array($aiChatDatas) || is_object($aiChatDatas)){
                    foreach($aiChatDatas as $Row){
                        $dataArray = array();
                        $dataArray['data_id'] = $Row['data_id'];
                        $dataArray['sub_category_id'] = $Row['sub_category_id'];
                        $dataArray['language_code'] = $Row['language_code'];
                        $dataArray['data_title'] = $Row['data_title'];
                        $dataArray['data_prompt'] = $Row['data_prompt'];
                        $dataArray['data_note'] = $Row['data_note'];
                        $dataArray['data_position'] = $Row['data_position'];
                        $dataArray['data_status'] = $Row['data_status'];
                        $dataArray['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$dataArray['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                        $dataArray['aiChatSubCategoryData'] = $this->DataModel->getData('sub_category_id = '.$dataArray['sub_category_id'], AI_CHAT_SUB_CATEGORY_TABLE);
                        array_push($data['viewAiChatDatas'], $dataArray);
                    }
                }
                $this->load->view('header');
                $this->load->view('aiChat/data/ai_chat_datas_view', $data);
                $this->load->view('footer');
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatDataEdit($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_DATA_ALIAS, "can_edit");
            if($isPermission){
                $dataID = urlDecodes($dataID);
                if(ctype_digit($dataID)){
                    $data['aiChatData'] = $this->DataModel->getData('data_id = '.$dataID, AI_CHAT_DATA_TABLE);
                    
                    $data['aiChatLanguageData'] = $this->DataModel->getData('language_code = "'.$data['aiChatData']['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                    
                    $data['viewAiChatSubCategory'] = $this->DataModel->viewData(null, null, AI_CHAT_SUB_CATEGORY_TABLE);
                    $subCategoryID = $data['aiChatData']['sub_category_id'];
                    $data['aiChatSubCategoryData'] = $this->DataModel->getData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
                    
                    foreach($data['viewAiChatSubCategory'] as $key => $subCategory){
                        $languageData = $this->DataModel->getData('language_code = "'.$subCategory['language_code'].'"', AI_CHAT_LANGUAGE_TABLE);
                        $data['viewAiChatSubCategory'][$key]['language_name'] = $languageData['language_name'];
                    }
                    
                    if(!empty($data['aiChatData'])){
                        $this->load->view('header');
                        $this->load->view('aiChat/data/ai_chat_data_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'sub_category_id'=>$this->input->post('sub_category_id'),
                            'data_title'=>$this->input->post('data_title'),
                            'data_prompt'=>$this->input->post('data_prompt'),
                            'data_note'=>$this->input->post('data_note'),
                            'data_position'=>$this->input->post('data_position'),
                            'data_status'=>$this->input->post('data_status')
                        );
                        $editDataEntry = $this->DataModel->editData('data_id = '.$dataID, AI_CHAT_DATA_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-ai-chat-data');
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
    
    public function aiChatDataStatus($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_CHAT_DATA_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_CHAT_DATA_PUBLISH_ALIAS, "can_edit");
            $dataID = urlDecodes($dataID);
            if(ctype_digit($dataID)){
                $aiChatData = $this->DataModel->getData('data_id = '.$dataID, AI_CHAT_DATA_TABLE);
                if($aiChatData['data_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'data_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'data_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('data_id = '.$dataID, AI_CHAT_DATA_TABLE, $editData);
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
    
    public function aiChatDataDelete($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_DATA_ALIAS, "can_delete");
            if($isPermission){ 
                $dataID = urlDecodes($dataID);
                if(ctype_digit($dataID)){
                    $resultDataEntry = $this->DataModel->deleteData('data_id = '.$dataID, AI_CHAT_DATA_TABLE);
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
    
    public function allAiChatDataDelete($action = null){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if($action === 'delete'){
                $isPermission = checkPermission(AI_CHAT_DATA_ALIAS, "can_delete");
                if($isPermission){ 
                    $selectedRecords = $this->input->post('data_id');
                        if(!empty($selectedRecords)){
                            $dataIds = array_map('intval', $selectedRecords);
                            foreach($dataIds as $dataID) {
                                $resultDataEntry = $this->DataModel->deleteData('data_id = '.$dataID, AI_CHAT_DATA_TABLE);
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