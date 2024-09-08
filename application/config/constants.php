<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| Panel Setting
|--------------------------------------------------------------------------
*/

/* AWS Setting */
define("S3_REGION", "ap-south-1");
define("S3_SECRET", "135AegeYZSSn6kHOU0ospt8WdFCD6NIpzSubiIZD");

define("KEYBOARD_BUCKET_NAME", "dummy-datas-bucket");
define("CHARGING_BUCKET_NAME", "dummy-datas-bucket");
define("APPLOCK_BUCKET_NAME", "dummy-datas-bucket");
define("AI_BUCKET_NAME", "dummy-datas-bucket");

define("THUMBNAIL_PATH", "thumbnails/");
define("BUNDLE_PATH", "bundles/");
define("GALLERY_PATH", "image/");
define("ICON_PATH", "icon/");
define("LOCAL_PATH", "/home/syphnosys/public_html/ai_images/");

/* Common Setting */
define("URL", "https://syphnosys.com/store/");
define("COPYRIGHT", "Copyright © 2019-2025 Reserved By - Syphnosys Apps.");
define("TITLE", "Store Panel");
define("OTP", "admin");
define("AUTH_KEY", "5926478023654985");

/* Database Setting */
define("HOST", "localhost");
define("USER", "syphnosy_root");
define("PASS", 'SYS@dev#web#cloud#12');
define("DB", "syphnosys_store");

// ================================================
// =============== Permission Alias ===============
// ================================================
// Permission Alias Setting
define("KEYBOARD_CATEGORY_ALIAS", "keyboard_category_alias");
define("KEYBOARD_CATEGORY_TOTAL_ALIAS", "keyboard_category_total_alias");
define("KEYBOARD_CATEGORY_PUBLISH_ALIAS", "keyboard_category_publish_alias");
define("KEYBOARD_CATEGORY_UNPUBLISH_ALIAS", "keyboard_category_unpublish_alias");

define("KEYBOARD_DATA_ALIAS", "keyboard_data_alias");
define("KEYBOARD_DATA_PREMIUM_ALIAS", "keyboard_data_premium_alias");
define("KEYBOARD_DATA_FREE_ALIAS", "keyboard_data_free_alias");
define("KEYBOARD_DATA_TOTAL_ALIAS", "keyboard_data_total_alias");
define("KEYBOARD_DATA_PUBLISH_ALIAS", "keyboard_data_publish_alias");
define("KEYBOARD_DATA_UNPUBLISH_ALIAS", "keyboard_data_unpublish_alias");

define("CHARGING_CATEGORY_ALIAS", "charging_category_alias");
define("CHARGING_CATEGORY_TOTAL_ALIAS", "charging_category_total_alias");
define("CHARGING_CATEGORY_PUBLISH_ALIAS", "charging_category_publish_alias");
define("CHARGING_CATEGORY_UNPUBLISH_ALIAS", "charging_category_unpublish_alias");

define("CHARGING_DATA_ALIAS", "charging_data_alias");
define("CHARGING_DATA_PREMIUM_ALIAS", "charging_data_premium_alias");
define("CHARGING_DATA_FREE_ALIAS", "charging_data_free_alias");
define("CHARGING_DATA_TOTAL_ALIAS", "charging_data_total_alias");
define("CHARGING_DATA_PUBLISH_ALIAS", "charging_data_publish_alias");
define("CHARGING_DATA_UNPUBLISH_ALIAS", "charging_data_unpublish_alias");

define("CHARGING_SEARCH_ALIAS", "charging_search_alias");
define("CHARGING_SEARCH_PUBLISH_ALIAS", "charging_search_publish_alias");
define("CHARGING_SEARCH_ADDED_ALIAS", "charging_search_added_alias");

define("APPLOCK_CATEGORY_ALIAS", "applock_category_alias");
define("APPLOCK_CATEGORY_TOTAL_ALIAS", "applock_category_total_alias");
define("APPLOCK_CATEGORY_PUBLISH_ALIAS", "applock_category_publish_alias");
define("APPLOCK_CATEGORY_UNPUBLISH_ALIAS", "applock_category_unpublish_alias");

define("APPLOCK_DATA_ALIAS", "applock_data_alias");
define("APPLOCK_DATA_PREMIUM_ALIAS", "applock_data_premium_alias");
define("APPLOCK_DATA_FREE_ALIAS", "applock_data_free_alias");
define("APPLOCK_DATA_TOTAL_ALIAS", "applock_data_total_alias");
define("APPLOCK_DATA_PUBLISH_ALIAS", "applock_data_publish_alias");
define("APPLOCK_DATA_UNPUBLISH_ALIAS", "applock_data_unpublish_alias");

define("AI_GALLERY_CATEGORY_ALIAS", "ai_gallery_category_alias");
define("AI_GALLERY_CATEGORY_TOTAL_ALIAS", "ai_gallery_category_total_alias");
define("AI_GALLERY_CATEGORY_PUBLISH_ALIAS", "ai_gallery_category_publish_alias");
define("AI_GALLERY_CATEGORY_UNPUBLISH_ALIAS", "ai_gallery_category_unpublish_alias");

define("AI_GALLERY_DATA_ALIAS", "ai_gallery_data_alias");
define("AI_GALLERY_DATA_TOTAL_ALIAS", "ai_gallery_data_total_alias");
define("AI_GALLERY_DATA_PUBLISH_ALIAS", "ai_gallery_data_publish_alias");
define("AI_GALLERY_DATA_UNPUBLISH_ALIAS", "ai_gallery_data_unpublish_alias");
define("AI_GALLERY_DATA_MOVE_ALIAS", "ai_gallery_data_move_alias");

define("AI_GALLERY_IMAGE_ALIAS", "ai_gallery_image_alias");
define("AI_GALLERY_IMAGE_TOTAL_ALIAS", "ai_gallery_image_total_alias");
define("AI_GALLERY_IMAGE_PUBLISH_ALIAS", "ai_gallery_image_publish_alias");
define("AI_GALLERY_IMAGE_UNPUBLISH_ALIAS", "ai_gallery_image_unpublish_alias");

define("AI_CHAT_LANGUAGE_ALIAS", "ai_chat_language_alias");
define("AI_CHAT_LANGUAGE_TOTAL_ALIAS", "ai_chat_language_total_alias");
define("AI_CHAT_LANGUAGE_PUBLISH_ALIAS", "ai_chat_language_publish_alias");
define("AI_CHAT_LANGUAGE_UNPUBLISH_ALIAS", "ai_chat_language_unpublish_alias");

define("AI_CHAT_MODEL_ALIAS", "ai_chat_model_alias");
define("AI_CHAT_MODEL_TOTAL_ALIAS", "ai_chat_model_total_alias");
define("AI_CHAT_MODEL_PUBLISH_ALIAS", "ai_chat_model_publish_alias");
define("AI_CHAT_MODEL_UNPUBLISH_ALIAS", "ai_chat_model_unpublish_alias");

define("AI_CHAT_MAIN_CATEGORY_ALIAS", "ai_chat_main_category_alias");
define("AI_CHAT_MAIN_CATEGORY_TOTAL_ALIAS", "ai_chat_main_category_total_alias");
define("AI_CHAT_MAIN_CATEGORY_PUBLISH_ALIAS", "ai_chat_main_category_publish_alias");
define("AI_CHAT_MAIN_CATEGORY_UNPUBLISH_ALIAS", "ai_chat_main_category_unpublish_alias");

define("AI_CHAT_SUB_CATEGORY_ALIAS", "ai_chat_sub_category_alias");
define("AI_CHAT_SUB_CATEGORY_TOTAL_ALIAS", "ai_chat_sub_category_total_alias");
define("AI_CHAT_SUB_CATEGORY_PUBLISH_ALIAS", "ai_chat_sub_category_publish_alias");
define("AI_CHAT_SUB_CATEGORY_UNPUBLISH_ALIAS", "ai_chat_sub_category_unpublish_alias");

define("AI_CHAT_DATA_ALIAS", "ai_chat_data_alias");
define("AI_CHAT_DATA_TOTAL_ALIAS", "ai_chat_data_total_alias");
define("AI_CHAT_DATA_PUBLISH_ALIAS", "ai_chat_data_publish_alias");
define("AI_CHAT_DATA_UNPUBLISH_ALIAS", "ai_chat_data_unpublish_alias");

define("AI_CHAT_PROMPT_ALIAS", "ai_chat_prompt_alias");
define("AI_CHAT_PROMPT_TOTAL_ALIAS", "ai_chat_prompt_total_alias");
define("AI_CHAT_PROMPT_PUBLISH_ALIAS", "ai_chat_prompt_publish_alias");
define("AI_CHAT_PROMPT_UNPUBLISH_ALIAS", "ai_chat_prompt_unpublish_alias");

define("AI_CHAT_FEEDBACK_ALIAS", "ai_chat_feedback_alias");
define("AI_CHAT_FEEDBACK_TOTAL_ALIAS", "ai_chat_feedback_total_alias");
define("AI_CHAT_FEEDBACK_PUBLISH_ALIAS", "ai_chat_feedback_publish_alias");
define("AI_CHAT_FEEDBACK_UNPUBLISH_ALIAS", "ai_chat_feedback_unpublish_alias");

define("AI_CHAT_PURCHASE_ALIAS", "ai_chat_purchase_alias");

define("PRIVACY_POLICY_ALIAS", "privacy_policy_alias");
define("PRIVACY_POLICY_TOTAL_ALIAS", "privacy_policy_total_alias");
define("PRIVACY_POLICY_PUBLISH_ALIAS", "privacy_policy_publish_alias");
define("PRIVACY_POLICY_UNPUBLISH_ALIAS", "privacy_policy_unpublish_alias");

// =====================================
// =============== Table ===============
// =====================================
// Keyboard Table
define("KEYBOARD_CATEGORY_TABLE", "keyboard_category");
define("KEYBOARD_DATA_TABLE", "keyboard_data");

// Charging Table
define("CHARGING_CATEGORY_TABLE", "charging_category");
define("CHARGING_DATA_TABLE", "charging_data");
define("CHARGING_SEARCH_TABLE", "charging_search");

// Applock Table
define("APPLOCK_CATEGORY_TABLE", "applock_category");
define("APPLOCK_DATA_TABLE", "applock_data");

// AI Table
define("AI_GALLERY_CATEGORY_TABLE", "ai_gallery_category");
define("AI_GALLERY_DATA_TABLE", "ai_gallery_data");
define("AI_GALLERY_IMAGE_TABLE", "ai_gallery_image");

define("AI_CHAT_LANGUAGE_TABLE", "ai_chat_language");
define("AI_CHAT_MODEL_TABLE", "ai_chat_model");
define("AI_CHAT_MAIN_CATEGORY_TABLE", "ai_chat_main_category");
define("AI_CHAT_SUB_CATEGORY_TABLE", "ai_chat_sub_category");
define("AI_CHAT_DATA_TABLE", "ai_chat_data");
define("AI_CHAT_PROMPT_TABLE", "ai_chat_prompt");
define("AI_CHAT_FEEDBACK_TABLE", "ai_chat_feedback");
define("AI_CHAT_PURCHASE_TABLE", "ai_chat_purchase");

define("PRIVACY_POLICY_TABLE", "privacy_policy");

// Master Table
define("SUPER_USER_TABLE", "sys_zuser_super");
define("MASTER_USER_TABLE", "sys_zuser_master");
define("PERMISSION_USER_TABLE", "sys_permission_user");
define("PERMISSION_DEPARTMENT_TABLE", "sys_permission_department");
define("PERMISSION_MASTER_TABLE", "sys_permission_master");
define("PERMISSION_ALIAS_TABLE", "sys_permission_alias");
define("DEPARTMENT_TABLE", "sys_department");
define("IP_TABLE", "sys_allowed_ip");
define("LOGIN_DATA_TABLE", "sys_login_data");
