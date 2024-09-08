<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {
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
    
    public function aiChatPurchaseView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_chat_purchase');
            }
            if(isset($_POST['submit_search'])){
                $searchAiChatPurchase = $this->input->post('search_ai_chat_purchase');
                $this->session->set_userdata('session_ai_chat_purchase', $searchAiChatPurchase);
            }
            $sessionAiChatPurchase = $this->session->userdata('session_ai_chat_purchase');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_chat_purchase_acknowledged');
                redirect('view-ai-chat-purchase');
            }
            
            $searchAiChatPurchaseAcknowledged = $this->input->post('search_ai_chat_purchase_acknowledged');
            if($searchAiChatPurchaseAcknowledged === 'true' or $searchAiChatPurchaseAcknowledged == 'false'){
                $this->session->set_userdata('session_ai_chat_purchase_acknowledged', $searchAiChatPurchaseAcknowledged);
            } else if($searchAiChatPurchaseAcknowledged === 'all'){
                $this->session->unset_userdata('session_ai_chat_purchase_acknowledged');
            }
            $sessionAiChatPurchaseAcknowledged = $this->session->userdata('session_ai_chat_purchase_acknowledged');
            
            $data = array();
            //get rows count
            $conditions['search_ai_chat_purchase'] = $sessionAiChatPurchase;
            $conditions['search_ai_chat_purchase_acknowledged'] = $sessionAiChatPurchaseAcknowledged;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiChatPurchase($conditions, AI_CHAT_PURCHASE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-chat-purchase');
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
            
            $aiChatPurchase  = $this->DataModel->viewAiChatPurchase($conditions, AI_CHAT_PURCHASE_TABLE);
            $data['countAiChatPurchase'] = $this->DataModel->countAiChatPurchase($conditions, AI_CHAT_PURCHASE_TABLE);
            
            $data['viewAiChatPurchase'] = array();
            if(is_array($aiChatPurchase) || is_object($aiChatPurchase)){
                foreach($aiChatPurchase as $Row){
                    $dataArray = array();
                    $dataArray['purchase_id'] = $Row['purchase_id'];
                    $dataArray['purchase_package'] = $Row['purchase_package'];
                    $dataArray['purchase_order_id'] = $Row['purchase_order_id'];
                    $dataArray['purchase_product_id'] = $Row['purchase_product_id'];
                    $dataArray['purchase_state'] = $Row['purchase_state'];
                    $dataArray['purchase_token'] = $Row['purchase_token'];
                    $dataArray['purchase_time'] = $Row['purchase_time'];
                    $dataArray['purchase_acknowledged'] = $Row['purchase_acknowledged'];
                    array_push($data['viewAiChatPurchase'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiChat/purchase/ai_chat_purchase_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiChatPurchaseEdit($purchaseID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_PURCHASE_ALIAS, "can_edit");
            if($isPermission){
                $purchaseID = urlDecodes($purchaseID);
                if(ctype_digit($purchaseID)){
                    $data['aiChatPurchase'] = $this->DataModel->getData('purchase_id = '.$purchaseID, AI_CHAT_PURCHASE_TABLE);
                    
                    if(!empty($data['aiChatPurchase'])){
                        $this->load->view('header');
                        $this->load->view('aiChat/purchase/ai_chat_purchase_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'purchase_package'=>$this->input->post('purchase_package'),
                            'purchase_order_id'=>$this->input->post('purchase_order_id'),
                            'purchase_product_id'=>$this->input->post('purchase_product_id'),
                            'purchase_state'=>$this->input->post('purchase_state'),
                            'purchase_acknowledged'=>$this->input->post('purchase_acknowledged'),
                        );
                        $editDataEntry = $this->DataModel->editData('purchase_id = '.$purchaseID, AI_CHAT_PURCHASE_TABLE, $editData);
                        if($editDataEntry){
                            redirect('view-ai-chat-purchase');
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
    
    public function aiChatPurchaseDelete($purchaseID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_CHAT_PURCHASE_ALIAS, "can_delete");
            if($isPermission){ 
                $purchaseID = urlDecodes($purchaseID);
                if(ctype_digit($purchaseID)){
                    $resultDataEntry = $this->DataModel->deleteData('purchase_id = '.$purchaseID, AI_CHAT_PURCHASE_TABLE);
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
    
    public function allAiChatPurchaseDelete($action = null){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if($action === 'delete'){
                $isPermission = checkPermission(AI_CHAT_PURCHASE_ALIAS, "can_delete");
                if($isPermission){ 
                    $selectedRecords = $this->input->post('purchase_id');
                        if(!empty($selectedRecords)){
                            $purchaseIds = array_map('intval', $selectedRecords);
                            foreach($purchaseIds as $purchaseID) {
                                $resultDataEntry = $this->DataModel->deleteData('purchase_id = '.$purchaseID, AI_CHAT_PURCHASE_TABLE);
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