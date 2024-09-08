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
    
    public function aiGalleryDataNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_GALLERY_DATA_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('aiGallery/data/ai_gallery_data_new');
                $this->load->view('footer');
                
                if($this->input->post('submit')){
                    $apiAUTH = "Bearer sk-9VSyxFUpVae2ArtFFVjd3Uvco3CLJIfmKOXIUucC3Cd11pvy";
                    $apiURL = "https://api.stability.ai/v1/generation/stable-diffusion-xl-1024-v1-0/text-to-image";
                    
                    $aiPrompt = $this->input->post('ai_prompt');
                    $aiStyle = $this->input->post('ai_style');
                    $aiSize = $this->input->post('ai_size');
                    $aiScale = $this->input->post('ai_scale');
                    $aiSteps = $this->input->post('ai_steps');
                    $aiType = $this->input->post('ai_type');
                    
                    $explode = explode("x", $aiSize);
                    $aiWidth = $explode[0];
                    $aiHeight = $explode[1];
                    
                    $jsonArray = array(
                        array("text" => "$aiPrompt", "weight" => 1),
                        array("text" => "blurry, bad", "weight" => -1)
                    );
            
                    $jsonString = json_encode($jsonArray);
                    
                    $header = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        'Authorization: ' .$apiAUTH,
                    ];

                    $options = [
                        CURLOPT_URL            => $apiURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST           => true,
                        CURLOPT_HTTPHEADER     => $header,
                        CURLOPT_POSTFIELDS     => '{
                            "text_prompts": [
                                {
                                    "text": "'.$aiPrompt.'"
                                }
                            ],
                            "cfg_scale": '.$aiScale.',
                            "height": '.$aiHeight.',
                            "width": '.$aiWidth.',
                            "samples": 1,
                            "steps": '.$aiSteps.'
                        }',
                        CURLOPT_FOLLOWLOCATION => true,
                    ];
                   
                    $ch = curl_init();
                    curl_setopt_array($ch, $options);
                    $response = curl_exec($ch);
                     
                    if(!empty($response)){
                        $data = json_decode($response, true);
                       
                        if(array_key_exists('artifacts', $data)){
                            foreach ($data["artifacts"] as $i => $image) {
                                $objectName = uniqueKey().".png";
                        	    $objectTemp = LOCAL_PATH . $objectName;
                        	    $objectPath = GALLERY_PATH;

                                $decodedImage = base64_decode($image["base64"]);
                                $saved = file_put_contents($objectTemp, $decodedImage);
                                if($saved !== false){
                                    $aiImage = newGalleryBucketObject($objectName, $objectTemp, $objectPath);
                                    unlink($objectTemp);
                                    $newData = array(
                                        'image_prompt' => $jsonString,
                                        'image_url' => $aiImage,
                                        'image_thumbnail' => '-',
                                        'image_style' => $aiStyle,
                                        'image_size' => $aiSize,
                                        'image_scale' => $aiScale,
                                        'image_steps' => $aiSteps,
                                        'image_show' => "public",
                                        'image_date' => timeZone(),
                                        'image_type' => $aiType,
                                        'image_status' => "unpublish",
                                    );
                                    $newDataEntry = $this->DataModel->insertData(AI_GALLERY_DATA_TABLE, $newData);
                                    if($newDataEntry){
                                        redirect('view-ai-gallery-data');  
                                    } else {
                                        $responseMessage = getErrorCode("error");
                                        $this->session->set_userdata('session_ai_gallery_data_response', $responseMessage);
                                        redirect('new-ai-gallery-data');
                                    }
                                    
                                } else {
                                    $responseMessage = getErrorCode("error");
                                    $this->session->set_userdata('session_ai_gallery_data_response', $responseMessage);
                                    redirect('new-ai-gallery-data');
                                }
                            }
 
                        } else if(array_key_exists('name', $data)) {
                            $responseMessage = getErrorCode($data["name"]);
                            $this->session->set_userdata('session_ai_gallery_data_response', $responseMessage);
                            redirect('new-ai-gallery-data');
                        } else {
                            $responseMessage = getErrorCode("error");
                            $this->session->set_userdata('session_ai_gallery_data_response', $responseMessage);
                            redirect('new-ai-gallery-data');
                        }
                    } else {
                        $responseMessage = getErrorCode("error");
                        $this->session->set_userdata('session_ai_gallery_data_response', $responseMessage);
                        redirect('new-ai-gallery-data');
                    }
                    curl_close($ch);
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function aiGalleryDataView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_gallery_data');
            }
            if(isset($_POST['submit_search'])){
                $searchAiGalleryData = $this->input->post('search_ai_gallery_data');
                $this->session->set_userdata('session_ai_gallery_data', $searchAiGalleryData);
            }
            $sessionAiGalleryData = $this->session->userdata('session_ai_gallery_data');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_gallery_data_style');
                $this->session->unset_userdata('session_ai_gallery_data_size');
                $this->session->unset_userdata('session_ai_gallery_data_show');
                $this->session->unset_userdata('session_ai_gallery_data_status');
                redirect('view-ai-gallery-data');
            }
            
            $searchAiGalleryDataStyle = $this->input->post('search_ai_gallery_data_style');
            $allowedStyles = array('enhance', 'anime', 'photographic', 'digital-art', 'comic-book', 'fantasy-art', 'line-art', 'analog-film', 'neon-punk', 'isometric', 'low-poly', 'origami', 'modeling-compound', 'cinematic', '3d-model', 'pixel-art', 'tile-texture');
            if(in_array($searchAiGalleryDataStyle, $allowedStyles)){
                $this->session->set_userdata('session_ai_gallery_data_style', $searchAiGalleryDataStyle);
            } else if($searchAiGalleryDataStyle === 'all'){
                $this->session->unset_userdata('session_ai_gallery_data_style');
            }
            $sessionAiGalleryDataStyle = $this->session->userdata('session_ai_gallery_data_style');
            
            $searchAiGalleryDataSize = $this->input->post('search_ai_gallery_data_size');
            $allowedSizes = array('1024x1024', '2048x2048', '1152x896', '1216x832', '1344x768', '1536x640', '640x1536', '768x1344', '832x1216', '896x1152');
            if(in_array($searchAiGalleryDataSize, $allowedSizes)){
                $this->session->set_userdata('session_ai_gallery_data_size', $searchAiGalleryDataSize);
            } else if($searchAiGalleryDataSize === 'all'){
                $this->session->unset_userdata('session_ai_gallery_data_size');
            }
            $sessionAiGalleryDataSize = $this->session->userdata('session_ai_gallery_data_size');
            
            $searchAiGalleryDataShow = $this->input->post('search_ai_gallery_data_show');
            if($searchAiGalleryDataShow === 'public' or $searchAiGalleryDataShow == 'private'){
                $this->session->set_userdata('session_ai_gallery_data_show', $searchAiGalleryDataShow);
            } else if($searchAiGalleryDataShow === 'all'){
                $this->session->unset_userdata('session_ai_gallery_data_show');
            }
            $sessionAiGalleryDataShow = $this->session->userdata('session_ai_gallery_data_show');
            
            $searchAiGalleryDataStatus = $this->input->post('search_ai_gallery_data_status');
            if($searchAiGalleryDataStatus === 'publish' or $searchAiGalleryDataStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_gallery_data_status', $searchAiGalleryDataStatus);
            } else if($searchAiGalleryDataStatus === 'all'){
                $this->session->unset_userdata('session_ai_gallery_data_status');
            }
            $sessionAiGalleryDataStatus = $this->session->userdata('session_ai_gallery_data_status');
            
            $data = array();
            //get rows count
            $conditions['search_ai_gallery_data'] = $sessionAiGalleryData;
            $conditions['search_ai_gallery_data_style'] = $sessionAiGalleryDataStyle;
            $conditions['search_ai_gallery_data_size'] = $sessionAiGalleryDataSize;
            $conditions['search_ai_gallery_data_show'] = $sessionAiGalleryDataShow;
            $conditions['search_ai_gallery_data_status'] = $sessionAiGalleryDataStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiGalleryData($conditions, AI_GALLERY_DATA_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-gallery-data');
            $config['uri_segment'] = 2;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 20;
            
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
            $conditions['limit'] = 20;
            
            $aiGalleryData = $this->DataModel->viewAiGalleryData($conditions, AI_GALLERY_DATA_TABLE);
            $data['countAiGalleryData'] = $this->DataModel->countAiGalleryData($conditions, AI_GALLERY_DATA_TABLE);
            $data['aiGalleryCategoryData'] = $this->DataModel->viewData(null, null, AI_GALLERY_CATEGORY_TABLE);
            
            $data['viewAiGalleryData'] = array();
            if(is_array($aiGalleryData) || is_object($aiGalleryData)){
                foreach($aiGalleryData as $Row){
                    $dataArray = array();
                    $dataArray['image_id'] = $Row['image_id'];
                    $dataArray['image_prompt'] = $Row['image_prompt'];
                    $dataArray['image_url'] = $Row['image_url'];
                    $dataArray['image_thumbnail'] = $Row['image_thumbnail'];
                    $dataArray['image_style'] = $Row['image_style'];
                    $dataArray['image_size'] = $Row['image_size'];
                    $dataArray['image_scale'] = $Row['image_scale'];
                    $dataArray['image_steps'] = $Row['image_steps'];
                    $dataArray['image_date'] = $Row['image_date'];
                    $dataArray['image_type'] = $Row['image_type'];
                    $dataArray['image_show'] = $Row['image_show'];
                    $dataArray['image_status'] = $Row['image_status'];
                    array_push($data['viewAiGalleryData'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiGallery/data/ai_gallery_data_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiGalleryDataStatus($imageID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_GALLERY_DATA_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_GALLERY_DATA_PUBLISH_ALIAS, "can_edit");
            $imageID = urlDecodes($imageID);
            if(ctype_digit($imageID)){
                $aiGalleryData = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE);
                if($aiGalleryData['image_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'image_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                if($aiGalleryData['image_size'] == "1024x1024" && $aiGalleryData['image_show'] == "public"){
    	                    $parsedUrl = parse_url($aiGalleryData['image_thumbnail']);
    	                    if(isset($parsedUrl['scheme'])){
    	                        $editData = array(
                        		    'image_status'=>"publish",
                    		    );
    	                    } else {
    	                        $originalImageUrl = $aiGalleryData['image_url'];
                                $ch = curl_init($originalImageUrl);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $imageContent = curl_exec($ch);
                                curl_close($ch);
                                
                                $newImageName = 'thumb_'.basename($originalImageUrl);
                                $localPath = LOCAL_PATH . $newImageName;
                                $bucketPath = GALLERY_PATH;
                                $saved = file_put_contents($localPath, $imageContent);
                                
                                if($saved !== false){
                                    resizeImage($localPath, 360, 360);
                                    $aiImage = newGalleryBucketObject($newImageName, $localPath, $bucketPath);
                                    unlink($localPath);
                                    $editData = array(
                                        'image_thumbnail'=>$aiImage,
                                        'image_status'=>"publish",
                                    );
                                }
    	                    }
    	                } else {
    	                    if($aiGalleryData['image_size'] != "1024x1024" && $aiGalleryData['image_show'] != "public"){
    	                        $imageStatusMsg = "You can't update! Because your image size not 1024x1024 & image not public";
    	                    } else if($aiGalleryData['image_size'] != "1024x1024"){
    	                        $imageStatusMsg = "You can't update! Because your image size not 1024x1024";
    	                    } else if($aiGalleryData['image_show'] != "public"){
    	                        $imageStatusMsg = "You can't update! Because your image not public";
    	                    } 
    	                    $this->session->set_userdata('session_ai_gallery_data_size_show', $imageStatusMsg);
                            redirect($_SERVER['HTTP_REFERER']);
    	                }
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE, $editData);
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
    
    public function aiGalleryDataDelete($imageID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_GALLERY_DATA_ALIAS, "can_delete");
            if($isPermission){ 
                $imageID = urlDecodes($imageID);
                if(ctype_digit($imageID)){
                    
                    $data['aiGalleryData'] = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE);
                    $s3Client = getConfig();
                    
                    $imageKey = $data['aiGalleryData']['image_url'];
	                $newImageKey = basename($imageKey);

                    $deleteImage = $s3Client->deleteObject([
                        'Bucket' => AI_BUCKET_NAME,
                        'Key'    => GALLERY_PATH.$newImageKey,
                    ]);
                    
                    $thumbnailKey = $data['aiGalleryData']['image_thumbnail'];
	                $newThumbnailKey = basename($thumbnailKey);

                    $deleteThumbnail = $s3Client->deleteObject([
                        'Bucket' => AI_BUCKET_NAME,
                        'Key'    => GALLERY_PATH.$newThumbnailKey,
                    ]);
                    
                    $resultDataEntry = $this->DataModel->deleteData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE);
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
    
    public function aiGalleryDataAll($action = null) {
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if($action === 'update'){
                $isPermission1 = checkPermission(AI_GALLERY_DATA_UNPUBLISH_ALIAS, "can_edit");
                $isPermission2 = checkPermission(AI_GALLERY_DATA_PUBLISH_ALIAS, "can_edit");
                $selectedRecords = $this->input->post('image_id');
                if(!empty($selectedRecords)){
                    $imageIds = array_map('intval', $selectedRecords);
                    foreach($imageIds as $imageID) {
                        $aiGalleryData = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE);
                        if($aiGalleryData['image_status'] == "publish"){
                            if($isPermission1){
                	            $editData = array(
                        		    'image_status'=>"unpublish",
                    		    );
                    		    $editDataEntry = $this->DataModel->editData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE, $editData);
                            } else {
                                redirect('permission-denied');
                            }
            	        } else {
            	            if($isPermission2){
            	                if($aiGalleryData['image_size'] == "1024x1024" && $aiGalleryData['image_show'] == "public"){
            	                    $parsedUrl = parse_url($aiGalleryData['image_thumbnail']);
            	                    if(isset($parsedUrl['scheme'])){
            	                        $editData = array(
                                		    'image_status'=>"publish",
                            		    );
                            		    $editDataEntry = $this->DataModel->editData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE, $editData);
            	                    } else {
            	                        $originalImageUrl = $aiGalleryData['image_url'];
                                        $ch = curl_init($originalImageUrl);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        $imageContent = curl_exec($ch);
                                        curl_close($ch);
                                        
                                        $newImageName = 'thumb_'.basename($originalImageUrl);
                                        $localPath = LOCAL_PATH . $newImageName;
                                        $bucketPath = GALLERY_PATH;
                                        $saved = file_put_contents($localPath, $imageContent);
                                        if($saved !== false){
                                            resizeImage($localPath, 360, 360);
                                            $aiImage = newGalleryBucketObject($newImageName, $localPath, $bucketPath);
                                            unlink($localPath);
                                            $editData = array(
                                                'image_thumbnail'=>$aiImage,
                                                'image_status'=>"publish",
                                            );
                                            $editDataEntry = $this->DataModel->editData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE, $editData);
                                        }
            	                    }
            	                } 
            	            } else {
                                redirect('permission-denied');
                            }
            	        }
                    }
    				redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect('error');
                }
            } else if($action === 'delete'){
                $isPermission = checkPermission(AI_GALLERY_DATA_ALIAS, "can_delete");
                if($isPermission){ 
                    $selectedRecords = $this->input->post('image_id');
                    if(!empty($selectedRecords)){
                        $imageIds = array_map('intval', $selectedRecords);
                        foreach($imageIds as $imageID) {
                            $data['aiGalleryData'] = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE);
                            $s3Client = getConfig();
                            
                            $imageKey = $data['aiGalleryData']['image_url'];
        	                $newImageKey = basename($imageKey);
        
                            $deleteImage = $s3Client->deleteObject([
                                'Bucket' => AI_BUCKET_NAME,
                                'Key'    => GALLERY_PATH.$newImageKey,
                            ]);
                            $thumbnailKey = $data['aiGalleryData']['image_thumbnail'];
        	                $newThumbnailKey = basename($thumbnailKey);
        
                            $deleteThumbnail = $s3Client->deleteObject([
                                'Bucket' => AI_BUCKET_NAME,
                                'Key'    => GALLERY_PATH.$newThumbnailKey,
                            ]);
                            $resultDataEntry = $this->DataModel->deleteData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE);
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
    
    public function aiGalleryDataMove($imageID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_GALLERY_DATA_MOVE_ALIAS, "can_delete");
            if($isPermission){ 
                $imageID = urlDecodes($imageID);
                if(ctype_digit($imageID)){
                    $aiGalleryData = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE);
                    if($aiGalleryData['image_size'] == "1024x1024" && $aiGalleryData['image_show'] == "public"){
                        $newData = array(
                            'category_id'=>$this->input->post('category_id'),
                            'image_prompt'=>$aiGalleryData['image_prompt'],
                            'image_url'=>$aiGalleryData['image_url'],
                            'image_thumbnail'=>$aiGalleryData['image_thumbnail'],
                            'image_style'=>$aiGalleryData['image_style'],
                            'image_size'=>$aiGalleryData['image_size'],
                            'image_scale'=>$aiGalleryData['image_scale'],
                            'image_steps'=>$aiGalleryData['image_steps'],
                            'image_date'=>$aiGalleryData['image_date'],
                            'image_type'=>$aiGalleryData['image_type'],
                            'image_show'=>$aiGalleryData['image_show'],
                            'image_status'=>'unpublish'
                        );
                        $newDataEntry = $this->DataModel->insertData(AI_GALLERY_IMAGE_TABLE, $newData);
                        if($newDataEntry){
                            $resultDataEntry = $this->DataModel->deleteData('image_id = '.$imageID, AI_GALLERY_DATA_TABLE);
                            if($resultDataEntry){
                                redirect($_SERVER['HTTP_REFERER']);
                            }
                        }
                    } else {
	                    if($aiGalleryData['image_size'] != "1024x1024" && $aiGalleryData['image_show'] != "public"){
	                        $imageStatusMsg = "You can't move! Because your image size not 1024x1024 & image not public";
	                    } else if($aiGalleryData['image_size'] != "1024x1024"){
	                        $imageStatusMsg = "You can't move! Because your image size not 1024x1024";
	                    } else if($aiGalleryData['image_show'] != "public"){
	                        $imageStatusMsg = "You can't move! Because your image not public";
	                    } 
	                    $this->session->set_userdata('session_ai_gallery_data_move_size_show', $imageStatusMsg);
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