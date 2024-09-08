<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Prompt extends CI_Controller {
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
    
    public function aiChatPromptView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_chat_prompt');
            }
            if(isset($_POST['submit_search'])){
                $searchAiChatPrompt = $this->input->post('search_ai_chat_prompt');
                $this->session->set_userdata('session_ai_chat_prompt', $searchAiChatPrompt);
            }
            $sessionAiChatPrompt = $this->session->userdata('session_ai_chat_prompt');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_chat_prompt_model');
                $this->session->unset_userdata('session_ai_chat_prompt_status');
                redirect('view-ai-chat-prompt');
            }
            
            $searchAiChatPromptModel = $this->input->post('search_ai_chat_prompt_model');
            if($searchAiChatPromptModel === 'gpt-3.5-turbo-0613' or $searchAiChatPromptModel == 'gpt-4-0613' or $searchAiChatPromptModel == 'mistral-tiny' or $searchAiChatPromptModel == 'claude-3-haiku' or $searchAiChatPromptModel == 'gemini-pro'){
                $this->session->set_userdata('session_ai_chat_prompt_model', $searchAiChatPromptModel);
            } else if($searchAiChatPromptModel === 'all'){
                $this->session->unset_userdata('session_ai_chat_prompt_model');
            }
            $sessionAiChatPromptModel = $this->session->userdata('session_ai_chat_prompt_model');
            
            $searchAiChatPromptStatus = $this->input->post('search_ai_chat_prompt_status');
            if($searchAiChatPromptStatus === 'publish' or $searchAiChatPromptStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_chat_prompt_status', $searchAiChatPromptStatus);
            } else if($searchAiChatPromptStatus === 'all'){
                $this->session->unset_userdata('session_ai_chat_prompt_status');
            }
            $sessionAiChatPromptStatus = $this->session->userdata('session_ai_chat_prompt_status');
            
            $data = array();
            //get rows count
            $conditions['search_ai_chat_prompt'] = $sessionAiChatPrompt;
            $conditions['search_ai_chat_prompt_model'] = $sessionAiChatPromptModel;
            $conditions['search_ai_chat_prompt_status'] = $sessionAiChatPromptStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiChatPrompt($conditions, AI_CHAT_PROMPT_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-chat-prompt');
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
            
            $aiChatPrompt = $this->DataModel->viewAiChatPrompt($conditions, AI_CHAT_PROMPT_TABLE);
            $data['countAiChatPrompt'] = $this->DataModel->countAiChatPrompt($conditions, AI_CHAT_PROMPT_TABLE);
            
            $data['viewAiChatPrompt'] = array();
            if(is_array($aiChatPrompt) || is_object($aiChatPrompt)){
                foreach($aiChatPrompt as $Row){
                    $dataArray = array();
                    $dataArray['chat_id'] = $Row['chat_id'];
                    $dataArray['chat_prompt'] = $Row['chat_prompt'];
                    $dataArray['chat_model'] = $Row['chat_model'];
                    $dataArray['chat_address'] = $Row['chat_address'];
                    $dataArray['chat_agent'] = $Row['chat_agent'];
                    $dataArray['chat_endpoint'] = $Row['chat_endpoint'];
                    $dataArray['chat_version'] = $Row['chat_version'];
                    $dataArray['chat_date'] = $Row['chat_date'];
                    $dataArray['chat_status'] = $Row['chat_status'];
                    array_push($data['viewAiChatPrompt'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiChat/prompt/ai_chat_prompt_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatPromptStatus($chatID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_CHAT_PROMPT_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_CHAT_PROMPT_PUBLISH_ALIAS, "can_edit");
            $chatID = urlDecodes($chatID);
            if(ctype_digit($chatID)){
                $aiChatPromptData = $this->DataModel->getData('chat_id = '.$chatID, AI_CHAT_PROMPT_TABLE);
                if($aiChatPromptData['chat_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'chat_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'chat_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('chat_id = '.$chatID, AI_CHAT_PROMPT_TABLE, $editData);
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
    
    public function aiChatPromptDelete($chatID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_PROMPT_ALIAS, "can_delete");
            if($isPermission){ 
                $chatID = urlDecodes($chatID);
                if(ctype_digit($chatID)){
                    $resultDataEntry = $this->DataModel->deleteData('chat_id = '.$chatID, AI_CHAT_PROMPT_TABLE);
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