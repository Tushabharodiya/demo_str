<?php defined('BASEPATH') OR exit('No direct script access allowed');

// ------ Keyboard ------ //
// Keyboard Category Functions
$route['new-keyboard-category'] = 'keyboard/category/keyboardCategoryNew';
$route['view-keyboard-category'] = 'keyboard/category/keyboardCategoryView';
$route['view-keyboard-category'.'/(:num)'] = 'keyboard/category/keyboardCategoryView/$1';
$route['edit-keyboard-category'.'/(:any)'] = 'keyboard/category/keyboardCategoryEdit/$1';
$route['keyboard-category-status'.'/(:any)'] = 'keyboard/category/keyboardCategoryStatus/$1';
$route['delete-keyboard-category'.'/(:any)'] = 'keyboard/category/keyboardCategoryDelete/$1';

// Keyboard Data Functions
$route['new-keyboard-data'] = 'keyboard/data/keyboardDataNew';
$route['view-keyboard-data'] = 'keyboard/data/keyboardDataView';
$route['view-keyboard-data'.'/(:num)'] = 'keyboard/data/keyboardDataView/$1';
$route['view-keyboard-category-data'.'/(:any)'] = 'keyboard/data/keyboardCategoryDataView/$1';
$route['view-keyboard-category-data'.'/(:any)'.'/(:num)'] = 'keyboard/data/keyboardCategoryDataView/$1/$2';
$route['edit-keyboard-data'.'/(:any)'] = 'keyboard/data/keyboardDataEdit/$1';
$route['keyboard-data-premium'.'/(:any)'] = 'keyboard/data/keyboardDataPremium/$1';
$route['keyboard-data-status'.'/(:any)'] = 'keyboard/data/keyboardDataStatus/$1';
$route['delete-keyboard-data'.'/(:any)'] = 'keyboard/data/keyboardDataDelete/$1';

// ------ Charging ------ //
// Charging Category Functions
$route['new-charging-category'] = 'charging/category/chargingCategoryNew';
$route['view-charging-category'] = 'charging/category/chargingCategoryView';
$route['view-charging-category'.'/(:num)'] = 'charging/category/chargingCategoryView/$1';
$route['edit-charging-category'.'/(:any)'] = 'charging/category/chargingCategoryEdit/$1';
$route['charging-category-status'.'/(:any)'] = 'charging/category/chargingCategoryStatus/$1';
$route['delete-charging-category'.'/(:any)'] = 'charging/category/chargingCategoryDelete/$1';

// Charging Data Functions
$route['new-charging-data'] = 'charging/data/chargingDataNew';
$route['view-charging-data'] = 'charging/data/chargingDataView';
$route['view-charging-data'.'/(:num)'] = 'charging/data/chargingDataView/$1';
$route['view-charging-category-data'.'/(:any)'] = 'charging/data/chargingCategoryDataView/$1';
$route['view-charging-category-data'.'/(:any)'.'/(:num)'] = 'charging/data/chargingCategoryDataView/$1/$2';
$route['edit-charging-data'.'/(:any)'] = 'charging/data/chargingDataEdit/$1';
$route['charging-data-premium'.'/(:any)'] = 'charging/data/chargingDataPremium/$1';
$route['charging-data-status'.'/(:any)'] = 'charging/data/chargingDataStatus/$1';
$route['delete-charging-data'.'/(:any)'] = 'charging/data/chargingDataDelete/$1';

//Charging Search Functions
$route['view-charging-search'] = 'charging/search/chargingSearchView';
$route['view-charging-search'.'/(:num)'] = 'charging/search/chargingSearchView/$1';
$route['charging-search-status'.'/(:any)'] = 'charging/search/chargingSearchStatus/$1';
$route['delete-charging-search'.'/(:any)'] = 'charging/search/chargingSearchDelete/$1';

// ------ Applock ------ //
// Applock Category Functions
$route['new-applock-category'] = 'applock/category/applockCategoryNew';
$route['view-applock-category'] = 'applock/category/applockCategoryView';
$route['view-applock-category'.'/(:num)'] = 'applock/category/applockCategoryView/$1';
$route['edit-applock-category'.'/(:any)'] = 'applock/category/applockCategoryEdit/$1';
$route['applock-category-status'.'/(:any)'] = 'applock/category/applockCategoryStatus/$1';
$route['delete-applock-category'.'/(:any)'] = 'applock/category/applockCategoryDelete/$1';

// Applock Data Functions
$route['new-applock-data'] = 'applock/data/applockDataNew';
$route['view-applock-data'] = 'applock/data/applockDataView';
$route['view-applock-data'.'/(:num)'] = 'applock/data/applockDataView/$1';
$route['view-applock-category-data'.'/(:any)'] = 'applock/data/applockCategoryDataView/$1';
$route['view-applock-category-data'.'/(:any)'.'/(:num)'] = 'applock/data/applockCategoryDataView/$1/$2';
$route['edit-applock-data'.'/(:any)'] = 'applock/data/applockDataEdit/$1';
$route['applock-data-premium'.'/(:any)'] = 'applock/data/applockDataPremium/$1';
$route['applock-data-status'.'/(:any)'] = 'applock/data/applockDataStatus/$1';
$route['delete-applock-data'.'/(:any)'] = 'applock/data/applockDataDelete/$1';

// ------ AI Gallery ------ //
// AI Gallery Category Functions
$route['new-ai-gallery-category'] = 'aiGallery/category/aiGalleryCategoryNew';
$route['view-ai-gallery-category'] = 'aiGallery/category/aiGalleryCategoryView';
$route['view-ai-gallery-category'.'/(:num)'] = 'aiGallery/category/aiGalleryCategoryView/$1';
$route['edit-ai-gallery-category'.'/(:any)'] = 'aiGallery/category/aiGalleryCategoryEdit/$1';
$route['ai-gallery-category-status'.'/(:any)'] = 'aiGallery/category/aiGalleryCategoryStatus/$1';
$route['delete-ai-gallery-category'.'/(:any)'] = 'aiGallery/category/aiGalleryCategoryDelete/$1';

// AI Gallery Data Functions
$route['new-ai-gallery-data'] = 'aiGallery/data/aiGalleryDataNew';
$route['view-ai-gallery-data'] = 'aiGallery/data/aiGalleryDataView';
$route['view-ai-gallery-data'.'/(:num)'] = 'aiGallery/data/aiGalleryDataView/$1';
$route['ai-gallery-data-status'.'/(:any)'] = 'aiGallery/data/aiGalleryDataStatus/$1';
$route['delete-ai-gallery-data'.'/(:any)'] = 'aiGallery/data/aiGalleryDataDelete/$1';
$route['all-ai-gallery-data'.'/(:any)'] = 'aiGallery/data/aiGalleryDataAll/$1';
$route['move-ai-gallery-data'.'/(:any)'] = 'aiGallery/data/aiGalleryDataMove/$1';

// AI Gallery Image Functions
$route['view-ai-gallery-image'] = 'aiGallery/image/aiGalleryImageView';
$route['view-ai-gallery-image'.'/(:num)'] = 'aiGallery/image/aiGalleryImageView/$1';
$route['view-ai-gallery-category-image'.'/(:any)'] = 'aiGallery/image/aiGalleryCategoryImageView/$1';
$route['view-ai-gallery-category-image'.'/(:any)'.'/(:num)'] = 'aiGallery/image/aiGalleryCategoryImageView/$1/$2';
$route['ai-gallery-image-status'.'/(:any)'] = 'aiGallery/image/aiGalleryImageStatus/$1';
$route['delete-ai-gallery-image'.'/(:any)'] = 'aiGallery/image/aiGalleryImageDelete/$1';
$route['all-ai-gallery-image'.'/(:any)'] = 'aiGallery/image/aiGalleryImageAll/$1';

// ------ AI Chat ------ //
// AI Chat Language Functions
$route['new-ai-chat-language'] = 'aiChat/language/aiChatLanguageNew';
$route['view-ai-chat-language'] = 'aiChat/language/aiChatLanguageView';
$route['view-ai-chat-language'.'/(:num)'] = 'aiChat/language/aiChatLanguageView/$1';
$route['edit-ai-chat-language'.'/(:any)'] = 'aiChat/language/aiChatLanguageEdit/$1';
$route['delete-ai-chat-language'.'/(:any)'] = 'aiChat/language/aiChatLanguageDelete/$1';

// AI Chat Model Functions
$route['new-ai-chat-model'] = 'aiChat/model/aiChatModelNew';
$route['view-ai-chat-model'] = 'aiChat/model/aiChatModelView';
$route['view-ai-chat-model'.'/(:num)'] = 'aiChat/model/aiChatModelView/$1';
$route['edit-ai-chat-model'.'/(:any)'] = 'aiChat/model/aiChatModelEdit/$1';
$route['ai-chat-model-status'.'/(:any)'] = 'aiChat/model/aiChatModelStatus/$1';
$route['delete-ai-chat-model'.'/(:any)'] = 'aiChat/model/aiChatModelDelete/$1';
$route['all-delete-ai-chat-model'.'/(:any)'] = 'aiChat/model/allAiChatModelDelete/$1';

// AI Chat Main Category Functions
$route['new-ai-chat-main-category'] = 'aiChat/mainCategory/aiChatMainCategoryNew';
$route['view-ai-chat-main-category'] = 'aiChat/mainCategory/aiChatMainCategoryView';
$route['view-ai-chat-main-category'.'/(:num)'] = 'aiChat/mainCategory/aiChatMainCategoryView/$1';
$route['edit-ai-chat-main-category'.'/(:any)'] = 'aiChat/mainCategory/aiChatMainCategoryEdit/$1';
$route['ai-chat-main-category-status'.'/(:any)'] = 'aiChat/mainCategory/aiChatMainCategoryStatus/$1';
$route['delete-ai-chat-main-category'.'/(:any)'] = 'aiChat/mainCategory/aiChatMainCategoryDelete/$1';
$route['all-delete-ai-chat-main-category'.'/(:any)'] = 'aiChat/mainCategory/allAiChatMainCategoryDelete/$1';

// AI Chat Sub Category Functions
$route['new-ai-chat-sub-category'] = 'aiChat/subCategory/aiChatSubCategoryNew';
$route['view-ai-chat-sub-category'] = 'aiChat/subCategory/aiChatSubCategoryView';
$route['view-ai-chat-sub-category'.'/(:num)'] = 'aiChat/subCategory/aiChatSubCategoryView/$1';
$route['view-ai-chat-sub-categories'.'/(:any)'] = 'aiChat/subCategory/aiChatSubCategoriesView/$1';
$route['view-ai-chat-sub-categories'.'/(:any)'.'/(:num)'] = 'aiChat/subCategory/aiChatSubCategoriesView/$1/$2';
$route['edit-ai-chat-sub-category'.'/(:any)'] = 'aiChat/subCategory/aiChatSubCategoryEdit/$1';
$route['ai-chat-sub-category-status'.'/(:any)'] = 'aiChat/subCategory/aiChatSubCategoryStatus/$1';
$route['delete-ai-chat-sub-category'.'/(:any)'] = 'aiChat/subCategory/aiChatSubCategoryDelete/$1';
$route['all-delete-ai-chat-sub-category'.'/(:any)'] = 'aiChat/subCategory/allAiChatSubCategoryDelete/$1';

// AI Chat Data Functions
$route['new-ai-chat-data'] = 'aiChat/data/aiChatDataNew';
$route['view-ai-chat-data'] = 'aiChat/data/aiChatDataView';
$route['view-ai-chat-data'.'/(:num)'] = 'aiChat/data/aiChatDataView/$1';
$route['view-ai-chat-datas'.'/(:any)'] = 'aiChat/data/aiChatDatasView/$1';
$route['view-ai-chat-datas'.'/(:any)'.'/(:num)'] = 'aiChat/data/aiChatDatasView/$1/$2';
$route['edit-ai-chat-data'.'/(:any)'] = 'aiChat/data/aiChatDataEdit/$1';
$route['ai-chat-data-status'.'/(:any)'] = 'aiChat/data/aiChatDataStatus/$1';
$route['delete-ai-chat-data'.'/(:any)'] = 'aiChat/data/aiChatDataDelete/$1';
$route['all-delete-ai-chat-data'.'/(:any)'] = 'aiChat/data/allAiChatDataDelete/$1';

// AI Chat Prompt Functions
$route['view-ai-chat-prompt'] = 'aiChat/prompt/aiChatPromptView';
$route['view-ai-chat-prompt'.'/(:num)'] = 'aiChat/prompt/aiChatPromptView/$1';
$route['ai-chat-prompt-status'.'/(:any)'] = 'aiChat/prompt/aiChatPromptStatus/$1';
$route['delete-ai-chat-prompt'.'/(:any)'] = 'aiChat/prompt/aiChatPromptDelete/$1';

// AI Chat Feedback Functions
$route['view-ai-chat-feedback'] = 'aiChat/feedback/aiChatFeedbackView';
$route['view-ai-chat-feedback'.'/(:num)'] = 'aiChat/feedback/aiChatFeedbackView/$1';
$route['ai-chat-feedback-status'.'/(:any)'] = 'aiChat/feedback/aiChatFeedbackStatus/$1';
$route['delete-ai-chat-feedback'.'/(:any)'] = 'aiChat/feedback/aiChatFeedbackDelete/$1';

// AI Chat Purchase Functions
$route['view-ai-chat-purchase'] = 'aiChat/purchase/aiChatPurchaseView';
$route['view-ai-chat-purchase'.'/(:num)'] = 'aiChat/purchase/aiChatPurchaseView/$1';
$route['edit-ai-chat-purchase'.'/(:any)'] = 'aiChat/purchase/aiChatPurchaseEdit/$1';
$route['delete-ai-chat-purchase'.'/(:any)'] = 'aiChat/purchase/aiChatPurchaseDelete/$1';
$route['all-delete-ai-chat-purchase'.'/(:any)'] = 'aiChat/purchase/allAiChatPurchaseDelete/$1';

// ------ Privacy Policy ------ //
// Privacy Policy Functions
$route['new-privacy-policy'] = 'privacyPolicy/privacyPolicy/privacyPolicyNew';
$route['view-privacy-policy'] = 'privacyPolicy/privacyPolicy/privacyPolicyView';
$route['view-privacy-policy'.'/(:num)'] = 'privacyPolicy/privacyPolicy/privacyPolicyView/$1';
$route['edit-privacy-policy'.'/(:any)'] = 'privacyPolicy/privacyPolicy/privacyPolicyEdit/$1';
$route['privacy-policy-status'.'/(:any)'] = 'privacyPolicy/privacyPolicy/privacyPolicyStatus/$1';

// ------ Master ------ //
// User Functions
$route['new-user'] = 'master/user/userNew';
$route['view-user'] = 'master/user/userView';
$route['edit-user'.'/(:any)'] = 'master/user/userEdit/$1';
$route['user-profile'] = 'master/user/userProfile';

// Department Functions
$route['new-department'] = 'master/department/departmentNew';
$route['view-department'] = 'master/department/departmentView';
$route['edit-department'.'/(:any)'] = 'master/department/departmentEdit/$1';
$route['view-users'.'/(:any)'] = 'master/department/usersView/$1';

// Permission Functions
$route['new-permission'] = 'master/permission/permissionNew';
$route['view-permission'] = 'master/permission/permissionView';
$route['view-permissions'.'/(:any)'] = 'master/permission/permissionsView/$1';
$route['edit-permission'.'/(:any)'] = 'master/permission/permissionEdit/$1';
$route['department-rights'.'/(:any)'] = 'master/permission/departmentRights/$1';
$route['department-permission'.'/(:any)'] = 'master/permission/departmentPermission/$1';
$route['user-rights'.'/(:any)'] = 'master/permission/userRights/$1';
$route['user-permission'.'/(:any)'] = 'master/permission/userPermission/$1';

// Alias Functions
$route['new-alias'] = 'master/alias/aliasNew';
$route['view-alias'] = 'master/alias/aliasView';
$route['edit-alias'.'/(:any)'] = 'master/alias/aliasEdit/$1';

// Login Functions
$route['login-history'] = 'master/user/loginHistory';
$route['login-description'.'/(:any)'] = 'master/user/loginDescription/$1';
$route['login-activity'.'/(:any)'] = 'master/user/loginActivity/$1';

// Ip Functions
$route['new-ip'] = 'master/ip/ipNew';
$route['view-ip'] = 'master/ip/ipView';
$route['edit-ip'.'/(:any)'] = 'master/ip/ipEdit/$1';
$route['delete-ip'.'/(:any)'] = 'master/ip/ipDelete/$1';

// Logout Functions
$route['user-logout'.'/(:any)'] = 'logout/userLogout/$1';
$route['logout-activity'] = 'logout/logoutActivity';

// Session Functions 
$route['unset-session'] = 'SessionUnsetter/unsetSession';

// Common Settings
$route['default_controller'] = 'dashboard';
$route['404_override'] = 'error404';
$route['permission-denied'] = 'error404/permissionDenied';
$route['ip-denied'] = 'error404/ipDenied';
$route['time-denied'] = 'error404/timeDenied';
$route['translate_uri_dashes'] = FALSE;