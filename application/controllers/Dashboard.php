<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index(){
		$isLogin = checkAuth();
        if($isLogin == "True"){
            $data['keyboardCategoryCount'] = $this->DataModel->countData(null, KEYBOARD_CATEGORY_TABLE);
            $data['keyboardCategoryPublishCount'] = $this->DataModel->countData('(category_status="publish")', KEYBOARD_CATEGORY_TABLE);
            $data['keyboardCategoryUnpublishCount'] = $this->DataModel->countData('(category_status="unpublish")', KEYBOARD_CATEGORY_TABLE);

            $data['keyboardDataCount'] = $this->DataModel->countData(null, KEYBOARD_DATA_TABLE);
            $data['keyboardDataPublishCount'] = $this->DataModel->countData('(keyboard_status="publish")', KEYBOARD_DATA_TABLE);
            $data['keyboardDataUnpublishCount'] = $this->DataModel->countData('(keyboard_status="unpublish")', KEYBOARD_DATA_TABLE);
            
            $data['chargingCategoryCount'] = $this->DataModel->countData(null, CHARGING_CATEGORY_TABLE);
            $data['chargingCategoryPublishCount'] = $this->DataModel->countData('(category_status="publish")', CHARGING_CATEGORY_TABLE);
            $data['chargingCategoryUnpublishCount'] = $this->DataModel->countData('(category_status="unpublish")', CHARGING_CATEGORY_TABLE);
            
            $data['chargingDataCount'] = $this->DataModel->countData(null, CHARGING_DATA_TABLE);
            $data['chargingDataPublishCount'] = $this->DataModel->countData('(charging_status="publish")', CHARGING_DATA_TABLE);
            $data['chargingDataUnpublishCount'] = $this->DataModel->countData('(charging_status="unpublish")', CHARGING_DATA_TABLE);
            
            $data['chargingSearchCount'] = $this->DataModel->countData(null, CHARGING_SEARCH_TABLE);
            $data['chargingSearchPublishCount'] = $this->DataModel->countData('(search_status="publish")', CHARGING_SEARCH_TABLE);
            $data['chargingSearchUnpublishCount'] = $this->DataModel->countData('(search_status="added")', CHARGING_SEARCH_TABLE);
            
            $data['applockCategoryCount'] = $this->DataModel->countData(null, APPLOCK_CATEGORY_TABLE);
            $data['applockCategoryPublishCount'] = $this->DataModel->countData('(category_status="publish")', APPLOCK_CATEGORY_TABLE);
            $data['applockCategoryUnpublishCount'] = $this->DataModel->countData('(category_status="unpublish")', APPLOCK_CATEGORY_TABLE);
            
            $data['applockDataCount'] = $this->DataModel->countData(null, APPLOCK_DATA_TABLE);
            $data['applockDataPublishCount'] = $this->DataModel->countData('(applock_status="publish")', APPLOCK_DATA_TABLE);
            $data['applockDataUnpublishCount'] = $this->DataModel->countData('(applock_status="unpublish")', APPLOCK_DATA_TABLE);
            
            $data['aiGalleryCategoryCount'] = $this->DataModel->countData(null, AI_GALLERY_CATEGORY_TABLE);
            $data['aiGalleryCategoryPublishCount'] = $this->DataModel->countData('(category_status="publish")', AI_GALLERY_CATEGORY_TABLE);
            $data['aiGalleryCategoryUnpublishCount'] = $this->DataModel->countData('(category_status="unpublish")', AI_GALLERY_CATEGORY_TABLE);
            
            $data['aiGalleryDataCount'] = $this->DataModel->countData(null, AI_GALLERY_DATA_TABLE);
            $data['aiGalleryDataPublishCount'] = $this->DataModel->countData('(image_status="publish")', AI_GALLERY_DATA_TABLE);
            $data['aiGalleryDataUnpublishCount'] = $this->DataModel->countData('(image_status="unpublish")', AI_GALLERY_DATA_TABLE);
            
            $data['aiGalleryImageCount'] = $this->DataModel->countData(null, AI_GALLERY_IMAGE_TABLE);
            $data['aiGalleryImagePublishCount'] = $this->DataModel->countData('(image_status="publish")', AI_GALLERY_IMAGE_TABLE);
            $data['aiGalleryImageUnpublishCount'] = $this->DataModel->countData('(image_status="unpublish")', AI_GALLERY_IMAGE_TABLE);
            
            $data['aiChatLanguageCount'] = $this->DataModel->countData(null, AI_CHAT_LANGUAGE_TABLE);
            $data['aiChatLanguagePublishCount'] = $this->DataModel->countData('(language_status="publish")', AI_CHAT_LANGUAGE_TABLE);
            $data['aiChatLanguageUnpublishCount'] = $this->DataModel->countData('(language_status="unpublish")', AI_CHAT_LANGUAGE_TABLE);
            
            $data['aiChatModelCount'] = $this->DataModel->countData(null, AI_CHAT_MODEL_TABLE);
            $data['aiChatModelPublishCount'] = $this->DataModel->countData('(model_status="publish")', AI_CHAT_MODEL_TABLE);
            $data['aiChatModelUnpublishCount'] = $this->DataModel->countData('(model_status="unpublish")', AI_CHAT_MODEL_TABLE);
            
            $data['aiChatMainCategoryCount'] = $this->DataModel->countData(null, AI_CHAT_MAIN_CATEGORY_TABLE);
            $data['aiChatMainCategoryPublishCount'] = $this->DataModel->countData('(main_category_status="publish")', AI_CHAT_MAIN_CATEGORY_TABLE);
            $data['aiChatMainCategoryUnpublishCount'] = $this->DataModel->countData('(main_category_status="unpublish")', AI_CHAT_MAIN_CATEGORY_TABLE);
            
            $data['aiChatSubCategoryCount'] = $this->DataModel->countData(null, AI_CHAT_SUB_CATEGORY_TABLE);
            $data['aiChatSubCategoryPublishCount'] = $this->DataModel->countData('(sub_category_status="publish")', AI_CHAT_SUB_CATEGORY_TABLE);
            $data['aiChatSubCategoryUnpublishCount'] = $this->DataModel->countData('(sub_category_status="unpublish")', AI_CHAT_SUB_CATEGORY_TABLE);
            
            $data['aiChatDataCount'] = $this->DataModel->countData(null, AI_CHAT_DATA_TABLE);
            $data['aiChatDataPublishCount'] = $this->DataModel->countData('(data_status="publish")', AI_CHAT_DATA_TABLE);
            $data['aiChatDataUnpublishCount'] = $this->DataModel->countData('(data_status="unpublish")', AI_CHAT_DATA_TABLE);
            
            $data['aiChatPromptCount'] = $this->DataModel->countData(null, AI_CHAT_PROMPT_TABLE);
            $data['aiChatPromptPublishCount'] = $this->DataModel->countData('(chat_status="publish")', AI_CHAT_PROMPT_TABLE);
            $data['aiChatPromptUnpublishCount'] = $this->DataModel->countData('(chat_status="unpublish")', AI_CHAT_PROMPT_TABLE);
            
            $data['aiChatFeedbackCount'] = $this->DataModel->countData(null, AI_CHAT_FEEDBACK_TABLE);
            $data['aiChatFeedbackPublishCount'] = $this->DataModel->countData('(feedback_status="publish")', AI_CHAT_FEEDBACK_TABLE);
            $data['aiChatFeedbackUnpublishCount'] = $this->DataModel->countData('(feedback_status="unpublish")', AI_CHAT_FEEDBACK_TABLE);
            
            $data['aiChatPurchaseCount'] = $this->DataModel->countData(null, AI_CHAT_PURCHASE_TABLE);
            $data['aiChatPurchaseTrueCount'] = $this->DataModel->countData('(purchase_acknowledged="true")', AI_CHAT_PURCHASE_TABLE);
            $data['aiChatPurchaseFalseCount'] = $this->DataModel->countData('(purchase_acknowledged="false")', AI_CHAT_PURCHASE_TABLE);
            
            $data['privacyPolicyCount'] = $this->DataModel->countData(null, PRIVACY_POLICY_TABLE);
            $data['privacyPolicyPublishCount'] = $this->DataModel->countData('(privacy_status="publish")', PRIVACY_POLICY_TABLE);
            $data['privacyPolicyUnpublishCount'] = $this->DataModel->countData('(privacy_status="unpublish")', PRIVACY_POLICY_TABLE);
             
            $data['viewActiveLogin'] = $this->DataModel->viewData(null, '(is_login="True")', MASTER_USER_TABLE);
			$this->load->view('header');
			$this->load->view('index', $data);
			$this->load->view('footer');
        } else {
            redirect('logout');
        }
	}
	
	public function theme(){
		$isLogin = checkAuth();
        if($isLogin == "True"){
            if($this->session->userdata['theme_mode'] == "light"){
               	$this->session->set_userdata('theme_mode', "dark");
            } else {
                $this->session->set_userdata('theme_mode', "light");
            }
			redirect('dashboard');
        } else {
            redirect('logout');
        }
	}
}
