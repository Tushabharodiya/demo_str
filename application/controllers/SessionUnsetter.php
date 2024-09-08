<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SessionUnsetter extends CI_Controller {
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
	
	public function unsetSession(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $this->session->unset_userdata('session_keyboard_category');
            $this->session->unset_userdata('session_keyboard_category_status');
            
            $this->session->unset_userdata('session_keyboard_data');
            $this->session->unset_userdata('session_keyboard_data_premium');
            $this->session->unset_userdata('session_keyboard_data_status');
            $this->session->unset_userdata('session_keyboard_data_view');
            $this->session->unset_userdata('session_keyboard_data_download');
                
            $this->session->unset_userdata('session_keyboard_category_data');
            $this->session->unset_userdata('session_keyboard_category_data_premium');
            $this->session->unset_userdata('session_keyboard_category_data_status');
            $this->session->unset_userdata('session_keyboard_category_data_view');
            $this->session->unset_userdata('session_keyboard_category_data_download');
            
            $this->session->unset_userdata('session_charging_category');
            $this->session->unset_userdata('session_charging_category_status');
            
            $this->session->unset_userdata('session_charging_data');
            $this->session->unset_userdata('session_charging_data_type');
            $this->session->unset_userdata('session_charging_data_premium');
            $this->session->unset_userdata('session_charging_data_music');
            $this->session->unset_userdata('session_charging_data_status');
            $this->session->unset_userdata('session_charging_data_view');
            $this->session->unset_userdata('session_charging_data_download');
            $this->session->unset_userdata('session_charging_data_applied');
                
            $this->session->unset_userdata('session_charging_category_data');
            $this->session->unset_userdata('session_charging_category_data_type');
            $this->session->unset_userdata('session_charging_category_data_premium');
            $this->session->unset_userdata('session_charging_category_data_music');
            $this->session->unset_userdata('session_charging_category_data_status');
            $this->session->unset_userdata('session_charging_category_data_view');
            $this->session->unset_userdata('session_charging_category_data_download');
            $this->session->unset_userdata('session_charging_category_data_applied');
            
            $this->session->unset_userdata('session_charging_search');
            $this->session->unset_userdata('session_charging_search_status');
            
            $this->session->unset_userdata('session_applock_category');
            $this->session->unset_userdata('session_applock_category_status');
            
            $this->session->unset_userdata('session_applock_data');
            $this->session->unset_userdata('session_applock_data_type');
            $this->session->unset_userdata('session_applock_data_premium');
            $this->session->unset_userdata('session_applock_data_status');
            $this->session->unset_userdata('session_applock_data_view');
            $this->session->unset_userdata('session_applock_data_download');
            $this->session->unset_userdata('session_applock_data_applied');
                
            $this->session->unset_userdata('session_applock_category_data');
            $this->session->unset_userdata('session_applock_category_data_type');
            $this->session->unset_userdata('session_applock_category_data_premium');
            $this->session->unset_userdata('session_applock_category_data_status');
            $this->session->unset_userdata('session_applock_category_data_view');
            $this->session->unset_userdata('session_applock_category_data_download');
            $this->session->unset_userdata('session_applock_category_data_applied');
            
            $this->session->unset_userdata('session_ai_gallery_category');
            $this->session->unset_userdata('session_ai_gallery_category_status');
            
            $this->session->unset_userdata('session_ai_gallery_data');
            $this->session->unset_userdata('session_ai_gallery_data_style');
            $this->session->unset_userdata('session_ai_gallery_data_size');
            $this->session->unset_userdata('session_ai_gallery_data_show');
            $this->session->unset_userdata('session_ai_gallery_data_status');
            
            $this->session->unset_userdata('session_ai_gallery_image');
            $this->session->unset_userdata('session_ai_gallery_image_style');
            $this->session->unset_userdata('session_ai_gallery_image_size');
            $this->session->unset_userdata('session_ai_gallery_image_show');
            $this->session->unset_userdata('session_ai_gallery_image_status');
            
            $this->session->unset_userdata('session_ai_gallery_category_image');
            $this->session->unset_userdata('session_ai_gallery_category_image_style');
            $this->session->unset_userdata('session_ai_gallery_category_image_size');
            $this->session->unset_userdata('session_ai_gallery_category_image_show');
            $this->session->unset_userdata('session_ai_gallery_category_image_status');
            
            $this->session->unset_userdata('session_ai_chat_language');
            $this->session->unset_userdata('session_ai_chat_language_status');
                
            $this->session->unset_userdata('session_ai_chat_model');
            $this->session->unset_userdata('session_ai_chat_model_status');
                
            $this->session->unset_userdata('session_ai_chat_main_category');
            $this->session->unset_userdata('session_ai_chat_main_category_status');
            
            $this->session->unset_userdata('session_ai_chat_sub_category');
            $this->session->unset_userdata('session_ai_chat_sub_category_status');
            
            $this->session->unset_userdata('session_ai_chat_sub_categories');
            $this->session->unset_userdata('session_ai_chat_sub_categories_status');
            
            $this->session->unset_userdata('session_ai_chat_data');
            $this->session->unset_userdata('session_ai_chat_data_status');
            
            $this->session->unset_userdata('session_ai_chat_datas');
            $this->session->unset_userdata('session_ai_chat_datas_status');
            
            $this->session->unset_userdata('session_ai_chat_prompt');
            $this->session->unset_userdata('session_ai_chat_prompt_model');
            $this->session->unset_userdata('session_ai_chat_prompt_status');
            
            $this->session->unset_userdata('session_ai_chat_feedback');
            $this->session->unset_userdata('session_ai_chat_feedback_status');
            
            $this->session->unset_userdata('session_ai_chat_purchase');
            $this->session->unset_userdata('session_ai_chat_purchase_acknowledged');
            
            $this->session->unset_userdata('session_privacy_policy');
            $this->session->unset_userdata('session_privacy_policy_status');

            redirect('dashboard');
        } else {
            redirect('logout');
        }
    }
    
}