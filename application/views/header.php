<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <meta name="robots" content="noindex, nofollow" />
    
    <link rel="shortcut icon" href="<?php echo base_url(); ?>source/images/favicon.png">
    
    <title><?php echo TITLE; ?></title>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>source/assets/css/style.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>source/assets/css/theme.css?ver=3.1.3">
    
    <script src="<?php echo base_url();?>source/js/bootsjs/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="<?php echo base_url();?>source/tinymce/js/tinymce/tinymce.css">
</head>

<?php
    if($this->session->userdata('panelLog') == ""){
        redirect('login');
    } else if($this->session->userdata('panelLog') == "FALSE"){
        redirect('confirmOTP');
    }
?>  

<?php
    $keyboardCategoryAlias = $this->DataModel->userPermissionData(KEYBOARD_CATEGORY_ALIAS);
    $keyboardDataAlias = $this->DataModel->userPermissionData(KEYBOARD_DATA_ALIAS);
    
    $chargingCategoryAlias = $this->DataModel->userPermissionData(CHARGING_CATEGORY_ALIAS);
    $chargingDataAlias = $this->DataModel->userPermissionData(CHARGING_DATA_ALIAS);
    $chargingSearchAlias = $this->DataModel->userPermissionData(CHARGING_SEARCH_ALIAS);
    
    $applockCategoryAlias = $this->DataModel->userPermissionData(APPLOCK_CATEGORY_ALIAS);
    $applockDataAlias = $this->DataModel->userPermissionData(APPLOCK_DATA_ALIAS);
    
    $aiGalleryCategoryAlias = $this->DataModel->userPermissionData(AI_GALLERY_CATEGORY_ALIAS);
    $aiGalleryDataAlias = $this->DataModel->userPermissionData(AI_GALLERY_DATA_ALIAS);
    $aiGalleryImageAlias = $this->DataModel->userPermissionData(AI_GALLERY_IMAGE_ALIAS);
    
    $aiChatLanguageAlias = $this->DataModel->userPermissionData(AI_CHAT_LANGUAGE_ALIAS);
    $aiChatModelAlias = $this->DataModel->userPermissionData(AI_CHAT_MODEL_ALIAS);
    $aiChatMainCategoryAlias = $this->DataModel->userPermissionData(AI_CHAT_MAIN_CATEGORY_ALIAS);
    $aiChatSubCategoryAlias = $this->DataModel->userPermissionData(AI_CHAT_SUB_CATEGORY_ALIAS);
    $aiChatDataAlias = $this->DataModel->userPermissionData(AI_CHAT_DATA_ALIAS);
    $aiChatPromptAlias = $this->DataModel->userPermissionData(AI_CHAT_PROMPT_ALIAS);
    $aiChatFeedbackAlias = $this->DataModel->userPermissionData(AI_CHAT_FEEDBACK_ALIAS);
    $aiChatPurchaseAlias = $this->DataModel->userPermissionData(AI_CHAT_PURCHASE_ALIAS);
    
    $privacyPolicyAlias = $this->DataModel->userPermissionData(PRIVACY_POLICY_ALIAS);
?>

<?php if($this->session->userdata['theme_mode'] == "dark"){ ?>
<body class="nk-body bg-white npc-default has-aside dark-mode">
<?php } else { ?>
<body class="nk-body bg-white npc-default has-aside">
<?php } ?>
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-lg wide-xxl">
                        <div class="nk-header-wrap">
                            <div class="nk-header-brand">
                                <a href="<?php echo base_url(); ?>" class="logo-link">
                                    <img class="logo-light logo-img" src="<?php echo base_url(); ?>source/images/logo.png" srcset="<?php echo base_url(); ?>source/images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="<?php echo base_url(); ?>source/images/logo-dark.png" srcset="<?php echo base_url(); ?>source/images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div>
                            <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                    <div class="nk-header-menu">
                                        <ul class="nk-menu nk-menu-main">
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>dashboard" class="nk-menu-link">
                                                    <span class="nk-menu-text">Overview</span>
                                                </a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>view-user" class="nk-menu-link">
                                                    <span class="nk-menu-text">All User</span>
                                                </a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>login-history" class="nk-menu-link">
                                                    <span class="nk-menu-text">Login History</span>
                                                </a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>view-ip" class="nk-menu-link">
                                                    <span class="nk-menu-text">Allowed IP</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="<?php echo base_url(); ?>#" class="dropdown-toggle me-lg-n1" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-block d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <span><?php echo get_first_letters($this->session->userdata['user_name']); ?></span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?php if($this->session->userdata != null){ ?> <?php echo $this->session->userdata['user_name']; ?> <?php } ?></span>
                                                        <span class="sub-text"><?php if($this->session->userdata != null){ ?> <?php echo $this->session->userdata['user_email']; ?> <?php } ?></span>
                                                    </div>
                                                    <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                                        <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                            <div class="user-action">
                                                                <a class="btn btn-icon me-n2" href="<?php echo base_url(); ?>view-permission"><em class="icon ni ni-setting"></em></a>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner user-account-info">
                                                <h6 class="overline-title-alt">Credits</h6>
                                                <?php 
                                                    $apiAUTH = "Bearer sk-9VSyxFUpVae2ArtFFVjd3Uvco3CLJIfmKOXIUucC3Cd11pvy";
                                                    $apiURL = "https://api.stability.ai/v1/user/balance";
                                            
                                                    $headers = array(
                                                        "Accept: application/json",
                                                        "Authorization: ".$apiAUTH
                                                    );
                                                    
                                                    $ch = curl_init($apiURL);
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                                    $response = curl_exec($ch);
                                                    
                                                    $jsonString = $response;
                                                    $data = json_decode($jsonString, true);
                                                    
                                                    if($data && isset($data['credits'])){
                                                        $creditsValue = $data['credits'];
                                                    } else {
                                                        $creditsValue = 0;
                                                    }

                                                    $formattedNumber = round($creditsValue, 2);

                                                    curl_close($ch);
                                                ?>
                                                <div class="user-balance-sub"><span><?php echo $formattedNumber; ?> <span class="currency currency-usd"></span></span></div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?php echo base_url(); ?>user-profile"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                                    <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                                        <?php if($this->session->userdata['user_role'] == "Super"){ ?> 
                                                            <li><a href="<?php echo base_url(); ?>view-user"><em class="icon ni ni-user-list"></em><span>All User</span></a></li>
                                                            <li><a href="<?php echo base_url(); ?>login-history"><em class="icon ni ni-activity-alt"></em><span>Login History</span></a></li>
                                                            <li><a href="<?php echo base_url(); ?>view-ip"><em class="icon ni ni-map-pin"></em><span>Allowed IP</span></a></li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if($this->session->userdata['theme_mode'] == "dark"){ ?>
                                                        <li><a href="<?php echo base_url(); ?>dashboard/theme"><em class="icon ni ni-sun"></em><span>Light Mode</span></a></li>
                                                    <?php } else { ?>
                                                        <li><a href="<?php echo base_url(); ?>dashboard/theme"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                                    <?php } ?>
                                                    <li><a href="<?php echo base_url(); ?>unset-session"><em class="icon ni ni-reload-alt"></em></em><span>Refresh</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?php echo base_url(); ?>logout"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-lg-none">
                                        <a href="<?php echo base_url(); ?>#" class="toggle nk-quick-nav-icon me-n1" data-target="sideNav"><em class="icon ni ni-menu"></em></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container wide-xxl">
                        <div class="nk-content-inner">
                            <div class="nk-aside" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">
                                <div class="nk-sidebar-menu" data-simplebar>
                                    <ul class="nk-menu">
                                    <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                        <?php if($this->session->userdata['user_role'] == "Super"){ ?>  
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Dashboards</h6>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>dashboard" class="nk-menu-link">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                                                    <span class="nk-menu-text">Dashboard</span>
                                                </a>
                                            </li>
                                           
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Keyboard</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-android"></em></span>
                                                    <span class="nk-menu-text">Keyboard</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-keyboard-category" class="nk-menu-link"><span class="nk-menu-text">Keyboard Category</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-keyboard-data" class="nk-menu-link"><span class="nk-menu-text">Keyboard Data</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Charging</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-spark"></em></span>
                                                    <span class="nk-menu-text">Charging</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-charging-category" class="nk-menu-link"><span class="nk-menu-text">Charging Category</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-charging-data" class="nk-menu-link"><span class="nk-menu-text">Charging Data</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-charging-search" class="nk-menu-link"><span class="nk-menu-text">Charging Search</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Applock</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-lock-alt"></em></span>
                                                    <span class="nk-menu-text">Applock</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-applock-category" class="nk-menu-link"><span class="nk-menu-text">Applock Category</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-applock-data" class="nk-menu-link"><span class="nk-menu-text">Applock Data</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">AI Gallery</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-img"></em></span>
                                                    <span class="nk-menu-text">AI Gallery</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-gallery-category" class="nk-menu-link"><span class="nk-menu-text">Gallery Category</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-gallery-image" class="nk-menu-link"><span class="nk-menu-text">Gallery Image</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="nk-menu-link"><span class="nk-menu-text">Gallery Data</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">AI Chat</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-chat"></em></span>
                                                    <span class="nk-menu-text">AI Chat</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-chat-language" class="nk-menu-link"><span class="nk-menu-text">Chat Language</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-chat-model" class="nk-menu-link"><span class="nk-menu-text">Chat Model</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="nk-menu-link"><span class="nk-menu-text">Chat Main Category</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-chat-sub-category" class="nk-menu-link"><span class="nk-menu-text">Chat Sub Category</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-chat-data" class="nk-menu-link"><span class="nk-menu-text">Chat Data</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-chat-prompt" class="nk-menu-link"><span class="nk-menu-text">Chat Prompt</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-chat-feedback" class="nk-menu-link"><span class="nk-menu-text">Chat Feedback</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-ai-chat-purchase" class="nk-menu-link"><span class="nk-menu-text">Chat Purchase</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Privacy Policy</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-policy"></em></span>
                                                    <span class="nk-menu-text">Privacy Policy</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-privacy-policy" class="nk-menu-link"><span class="nk-menu-text">Privacy Policy</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Master</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                                    <span class="nk-menu-text">Master Settings</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-user" class="nk-menu-link"><span class="nk-menu-text">User Master</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-department" class="nk-menu-link"><span class="nk-menu-text">Department Master</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-permission" class="nk-menu-link"><span class="nk-menu-text">Permission Master</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-alias" class="nk-menu-link"><span class="nk-menu-text">Permission Alias</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php } else { ?>
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Dashboards</h6>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>dashboard" class="nk-menu-link">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                                                    <span class="nk-menu-text">Dashboard</span>
                                                </a>
                                            </li>
                                            
                                            <?php if(!empty($keyboardCategoryAlias) or !empty($keyboardDataAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">Keyboard</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-android"></em></span>
                                                        <span class="nk-menu-text">Keyboard</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($keyboardCategoryAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-keyboard-category" class="nk-menu-link"><span class="nk-menu-text">Keyboard Category</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($keyboardDataAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-keyboard-data" class="nk-menu-link"><span class="nk-menu-text">Keyboard Data</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            
                                            <?php if(!empty($chargingCategoryAlias) or !empty($chargingDataAlias) or !empty($chargingSearchAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">Charging</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-spark"></em></span>
                                                        <span class="nk-menu-text">Charging</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($chargingCategoryAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-charging-category" class="nk-menu-link"><span class="nk-menu-text">Charging Category</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($chargingDataAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-charging-data" class="nk-menu-link"><span class="nk-menu-text">Charging Data</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($chargingSearchAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-charging-search" class="nk-menu-link"><span class="nk-menu-text">Charging Search</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                             <?php } ?>
                                            
                                            <?php if(!empty($applockCategoryAlias) or !empty($applockDataAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">Applock</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-lock-alt"></em></span>
                                                        <span class="nk-menu-text">Applock</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($applockCategoryAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-applock-category" class="nk-menu-link"><span class="nk-menu-text">Applock Category</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($applockDataAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-applock-data" class="nk-menu-link"><span class="nk-menu-text">Applock Data</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            
                                            <?php if(!empty($aiGalleryCategoryAlias) or !empty($aiGalleryDataAlias) or !empty($aiGalleryImageAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">AI Gallery</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-img"></em></span>
                                                        <span class="nk-menu-text">AI Gallery</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($aiGalleryCategoryAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-gallery-category" class="nk-menu-link"><span class="nk-menu-text">Gallery Category</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiGalleryImageAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-gallery-image" class="nk-menu-link"><span class="nk-menu-text">Gallery Image</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiGalleryDataAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="nk-menu-link"><span class="nk-menu-text">Gallery Data</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            
                                            <?php if(!empty($aiChatLanguageAlias) or !empty($aiChatModelAlias) or !empty($aiChatMainCategoryAlias) or !empty($aiChatSubCategoryAlias) or !empty($aiChatDataAlias) or !empty($aiChatPromptAlias) or !empty($aiChatFeedbackAlias) or !empty($aiChatPurchaseAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">AI Chat</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-chat"></em></span>
                                                        <span class="nk-menu-text">AI Chat</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($aiChatLanguageAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-language" class="nk-menu-link"><span class="nk-menu-text">Chat Language</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiChatModelAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-model" class="nk-menu-link"><span class="nk-menu-text">Chat Model</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiChatMainCategoryAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="nk-menu-link"><span class="nk-menu-text">Chat Main Category</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiChatSubCategoryAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-sub-category" class="nk-menu-link"><span class="nk-menu-text">Chat Sub Category</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiChatDataAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="nk-menu-link"><span class="nk-menu-text">Chat Data</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiChatPromptAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-prompt" class="nk-menu-link"><span class="nk-menu-text">Chat Prompt</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiChatFeedbackAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-feedback" class="nk-menu-link"><span class="nk-menu-text">Chat Feedback</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($aiChatPurchaseAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-purchase" class="nk-menu-link"><span class="nk-menu-text">Chat Purchase</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            
                                            <?php if(!empty($privacyPolicyAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">Privacy Policy</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-policy"></em></span>
                                                        <span class="nk-menu-text">Privacy Policy</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($privacyPolicyAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-privacy-policy" class="nk-menu-link"><span class="nk-menu-text">Privacy Policy</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    </ul>
                                </div>
                                <div class="nk-aside-close">
                                    <a href="<?php echo base_url(); ?>#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
                                </div>
                            </div>
                            <div class="nk-content-body">