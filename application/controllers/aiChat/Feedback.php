<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {
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
    
    public function aiChatFeedbackView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_chat_feedback');
            }
            if(isset($_POST['submit_search'])){
                $searchAiChatFeedback = $this->input->post('search_ai_chat_feedback');
                $this->session->set_userdata('session_ai_chat_feedback', $searchAiChatFeedback);
            }
            $sessionAiChatFeedback = $this->session->userdata('session_ai_chat_feedback');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_chat_feedback_status');
                redirect('view-ai-chat-feedback');
            }
            
            $searchAiChatFeedbackStatus = $this->input->post('search_ai_chat_feedback_status');
            if($searchAiChatFeedbackStatus === 'publish' or $searchAiChatFeedbackStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_chat_feedback_status', $searchAiChatFeedbackStatus);
            } else if($searchAiChatFeedbackStatus === 'all'){
                $this->session->unset_userdata('session_ai_chat_feedback_status');
            }
            $sessionAiChatFeedbackStatus = $this->session->userdata('session_ai_chat_feedback_status');
            
            $data = array();
            //get rows count
            $conditions['search_ai_chat_feedback'] = $sessionAiChatFeedback;
            $conditions['search_ai_chat_feedback_status'] = $sessionAiChatFeedbackStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiChatFeedback($conditions, AI_CHAT_FEEDBACK_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-chat-feedback');
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
            
            $aiChatFeedback = $this->DataModel->viewAiChatFeedback($conditions, AI_CHAT_FEEDBACK_TABLE);
            $data['countAiChatFeedback'] = $this->DataModel->countAiChatFeedback($conditions, AI_CHAT_FEEDBACK_TABLE);
            
            $data['viewAiChatFeedback'] = array();
            if(is_array($aiChatFeedback) || is_object($aiChatFeedback)){
                foreach($aiChatFeedback as $Row){
                    $dataArray = array();
                    $dataArray['feedback_id'] = $Row['feedback_id'];
                    $dataArray['feedback_message'] = $Row['feedback_message'];
                    $dataArray['feedback_language'] = $Row['feedback_language'];
                    $dataArray['feedback_date'] = $Row['feedback_date'];
                    $dataArray['feedback_status'] = $Row['feedback_status'];
                    array_push($data['viewAiChatFeedback'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiChat/feedback/ai_chat_feedback_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatFeedbackStatus($feedbackID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_CHAT_FEEDBACK_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_CHAT_FEEDBACK_PUBLISH_ALIAS, "can_edit");
            $feedbackID = urlDecodes($feedbackID);
            if(ctype_digit($feedbackID)){
                $aiChatFeedbackData = $this->DataModel->getData('feedback_id = '.$feedbackID, AI_CHAT_FEEDBACK_TABLE);
                if($aiChatFeedbackData['feedback_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'feedback_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'feedback_status'=>"publish",
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('feedback_id = '.$feedbackID, AI_CHAT_FEEDBACK_TABLE, $editData);
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
    
    public function aiChatFeedbackDelete($feedbackID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_FEEDBACK_ALIAS, "can_delete");
            if($isPermission){ 
                $feedbackID = urlDecodes($feedbackID);
                if(ctype_digit($feedbackID)){
                    $resultDataEntry = $this->DataModel->deleteData('feedback_id = '.$feedbackID, AI_CHAT_FEEDBACK_TABLE);
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