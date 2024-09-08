<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    
    if ( ! function_exists('timeZone')){
        function timeZone(){
            date_default_timezone_set('Asia/Kolkata');
            $timestamp = date("d/m/Y h:i:s A");
            return $timestamp;
        }
    }
    
    if ( ! function_exists('checkAuth')){
        function checkAuth(){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
            if(!empty($ci->session->userdata['user_key'])) { 
                if($ci->session->userdata['auth_key'] == AUTH_KEY){
                    $userKey = $ci->session->userdata['user_key'];
                    $userRole = $ci->session->userdata['user_role'];
                    if($userRole == "Super"){
                        $userData = $ci->DataModel->getData('user_key = '.$userKey, SUPER_USER_TABLE);
                    } else {
                        $userData = $ci->DataModel->getData('user_key = '.$userKey, MASTER_USER_TABLE);
                    }
                    if($userData){
                        $isLogin = $userData['is_login'];
                    } else {
                        redirect('error');
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
            return $isLogin;
        }
    }
    
    if ( ! function_exists('urlEncodes')){
        function urlEncodes($dataID = 0){
            date_default_timezone_set("Asia/Kolkata");
            if($dataID != null){
                $uniqKey = 0710;
                $dateString = $uniqKey.''.date('iH').''.$dataID;
                $dataLength = strlen($dateString);
                $encodeArray = array();
                $arrayKey = array('0'=>'5846ca', '1'=>'c56da5', '2'=>'69adc4', '3'=>'a56f49', '4'=>'6adc26', '5'=>'5a89db', '6'=>'d5487c', '7'=>'ac56df', '8'=>'ac658c', '9'=>'75dca8');
                for($i = 0; $i < $dataLength; $i++){   
                    array_push($encodeArray, $arrayKey[$dateString[$i]]);
                }
                $encodeURL = implode("xe", $encodeArray); 
            } else {
                $encodeURL = null;
            }
            return $encodeURL;
        }
    }
    
    if ( ! function_exists('urlDecodes')){
        function urlDecodes($dataURL = 0){
            date_default_timezone_set("Asia/Kolkata");
            if($dataURL != null or !empty($dataURL)){
                $dataArray = explode("xe", $dataURL);
                $dataLength = count($dataArray);
                $decodeArray = array();
                $arrayKey = array('0'=>'5846ca', '1'=>'c56da5', '2'=>'69adc4', '3'=>'a56f49', '4'=>'6adc26', '5'=>'5a89db', '6'=>'d5487c', '7'=>'ac56df', '8'=>'ac658c', '9'=>'75dca8');
                for($i = 0; $i < $dataLength; $i++){   
                    $dataKey = array_search($dataArray[$i], $arrayKey);
                    array_push($decodeArray, $dataKey);
                }
                $decodeURL = substr(implode("", $decodeArray), 7);
            } else {
                $decodeURL = null;
            }
            return $decodeURL;
        }
    }
    
    if ( ! function_exists('checkPermission')){
        function checkPermission($dataAlias, $userRights){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
            $isLogin = checkAuth();
            if($isLogin == "True"){
                if($ci->session->userdata['user_role'] == "Super"){
                    $type = 1;
                } else {
                    $userData =  $ci->DataModel->getData('user_key = '.$ci->session->userdata['user_key'], MASTER_USER_TABLE);
                    $permissionData = $ci->DataModel->getPermissionData($userData['user_id'], $dataAlias, PERMISSION_USER_TABLE);
                    if($permissionData){
                        if($userRights == "can_add"){
                            $type = $permissionData['can_add'];
                        } else if($userRights == "can_view"){
                            $type = $permissionData['can_view'];
                        } else if($userRights == "can_edit"){
                            $type = $permissionData['can_edit'];
                        } else if($userRights == "can_delete"){
                            $type = $permissionData['can_delete'];
                        } else {
                            $type = 0;
                        }
                    } else {
                        $type = 0;
                    }
                }
                return $type;
            } else {
                redirect('logout');
            }
        }
    }
    
    if ( ! function_exists('getconfig')){
        function getconfig(){
            $s3Client = new S3Client([
                'version' => 'latest',
                'region'  => S3_REGION,
                'credentials' => [
                    'key'    => S3_KEY,
                    'secret' => S3_SECRET
                ]            
            ]);
            return $s3Client;
        }
    }

    if ( ! function_exists('uniqueKey')){
        function uniqueKey(){
            date_default_timezone_set("Asia/Kolkata");
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $uniqueKey =  $randomString.''.strtolower(date('dmYhis'));
            return $uniqueKey;
        }
    }
    
    if ( ! function_exists('newKeyboardBucketObject')){
        function newKeyboardBucketObject($objectName, $objectCode, $objectTemp, $objectPath){
            $ci =& get_instance();
            $ci->load->database();
            $isLogin = checkAuth();
            if($isLogin == "True"){ 
                date_default_timezone_set("Asia/Kolkata");
                $s3Client = getconfig();
                $extObject = explode(".", $objectName);
                $newObject = end($extObject);
                $objectName = $objectCode.'.'.$newObject;
                $result = $s3Client->putObject([
                    'Bucket' => KEYBOARD_BUCKET_NAME,
                    'Key'    => $objectPath.$objectName,
                    'SourceFile' => $objectTemp,
                    'ACL'    => 'public-read', 
                ]);
                return $result->get('ObjectURL');
            } else {
                redirect('logout');
            }
        }
    }
    
    if ( ! function_exists('newChargingBucketObject')){
        function newChargingBucketObject($objectName, $objectCode, $objectTemp, $objectPath){
            $ci =& get_instance();
            $ci->load->database();
            $isLogin = checkAuth();
            if($isLogin == "True"){
                date_default_timezone_set("Asia/Kolkata");
                $s3Client = getconfig();
                $extObject = explode(".", $objectName);
                $newObject = end($extObject);
                $objectName = $objectCode.'.'.$newObject;
                $result = $s3Client->putObject([
                    'Bucket' => CHARGING_BUCKET_NAME,
                    'Key'    => $objectPath.$objectName,
                    'SourceFile' => $objectTemp,
                    'ACL'    => 'public-read', 
                ]);
                return $result->get('ObjectURL');
            } else {
                redirect('logout');
            }
        }
    }
    
    if ( ! function_exists('newApplockBucketObject')){
        function newApplockBucketObject($objectName, $objectCode, $objectTemp, $objectPath){
            $ci =& get_instance();
            $ci->load->database();
            $isLogin = checkAuth();
            if($isLogin == "True"){
                date_default_timezone_set("Asia/Kolkata");
                $s3Client = getconfig();
                $extObject = explode(".", $objectName);
                $newObject = end($extObject);
                $objectName = $objectCode.'.'.$newObject;
                $result = $s3Client->putObject([
                    'Bucket' => APPLOCK_BUCKET_NAME,
                    'Key'    => $objectPath.$objectName,
                    'SourceFile' => $objectTemp,
                    'ACL'    => 'public-read', 
                ]);
                return $result->get('ObjectURL');
            } else {
                redirect('logout');
            }
        }
    }
    
    if ( ! function_exists('newGalleryBucketObject')){
        function newGalleryBucketObject($objectName, $objectTemp, $objectPath){
            $isLogin = checkAuth();
            if($isLogin == "True"){ 
        		date_default_timezone_set("Asia/Kolkata");
                $s3Client = getconfig();
                $result = $s3Client->putObject([
                    'Bucket' => AI_BUCKET_NAME,
                    'Key'    => $objectPath.$objectName,
                    'SourceFile' => $objectTemp,
                    'ACL'    => 'public-read', 
                ]);
                return $result->get('ObjectURL');
            } else {
                redirect('logout');
            }
        }
    }
    
    if ( ! function_exists('newAiBucketObject')){
        function newAiBucketObject($objectName, $objectCode, $objectTemp, $objectPath){
            $ci =& get_instance();
            $ci->load->database();
            $isLogin = checkAuth();
            if($isLogin == "True"){ 
                date_default_timezone_set("Asia/Kolkata");
                $s3Client = getconfig();
                $extObject = explode(".", $objectName);
                $newObject = end($extObject);
                $objectName = $objectCode.'.'.$newObject;
                $result = $s3Client->putObject([
                    'Bucket' => AI_BUCKET_NAME,
                    'Key'    => $objectPath.$objectName,
                    'SourceFile' => $objectTemp,
                    'ACL'    => 'public-read', 
                ]);
                return $result->get('ObjectURL');
            } else {
                redirect('logout');
            }
        }
    }
    
    if ( ! function_exists('getErrorCode')){
        function getErrorCode($errorCode){
            $isLogin = checkAuth();
            if($isLogin == "True"){ 
                if($errorCode == "invalid_prompts"){
                    $responseError = "Invalid prompts detected";
                } else if($errorCode == "unauthorized"){
                    $responseError = "Permission denied"; 
                } else if($errorCode == "not_found"){
                    $responseError = "Invalid engine detected"; 
                } else if($errorCode == "bad_request"){
                    $responseError = "Invalid request detected"; 
                } else if($errorCode == "invalid_height_or_width"){
                    $responseError = "Invalid height or width detected"; 
                } else if($errorCode == "invalid_sdxl_v1_dimensions"){
                    $responseError = "Invalid dimensions detected"; 
                } else if($errorCode == "invalid_base64"){
                    $responseError = "Invalid Image"; 
                } else if($errorCode == "invalid_pixel_count"){
                    $responseError = "Invalid pixel count"; 
                } else{
                    $responseError = "Permission denied"; 
                }
                
                return $responseError;
            } else {
                redirect('logout');
            }
        }
    }
    
    if ( ! function_exists('resizeImage')){
        function resizeImage($filePath, $newWidth, $newHeight){
            $ci =& get_instance();
            $ci->load->database();
            $isLogin = checkAuth();
            if($isLogin == "True"){ 
                $ci->load->library('image_lib');

                $config['image_library'] = 'gd2';
                $config['source_image'] = $filePath;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $newWidth;
                $config['height'] = $newHeight;
        
                $ci->image_lib->initialize($config);
        
                if (!$ci->image_lib->resize()) {
                    echo $ci->image_lib->display_errors();
                }
        
                return $ci->image_lib->clear();
                
            } else {
                redirect('logout');
            }
        }
    }
    
    if ( ! function_exists('translateText')){
        function translateText($text, $fromLanguage, $toLanguage) {
            $isLogin = checkAuth();
            if($isLogin == "True"){ 
                $curlSession = curl_init(); 
                curl_setopt($curlSession, CURLOPT_URL, 'https://translate.googleapis.com/translate_a/single?client=gtx&sl='.$fromLanguage.'&tl='.$toLanguage.'&dt=t&q='.urlencode($text));
                curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curlSession);
                $jsonData = json_decode($response, true);
                curl_close($curlSession);
                
                if(isset($jsonData[0][0][0])){
                    return $jsonData[0][0][0];
                } else {
                    return null; 
                }
            } else {
                redirect('logout');
            }
        }
    }




