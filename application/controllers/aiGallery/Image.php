<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {
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
    
    public function aiGalleryImageView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_gallery_image');
            }
            if(isset($_POST['submit_search'])){
                $searchAiGalleryImage = $this->input->post('search_ai_gallery_image');
                $this->session->set_userdata('session_ai_gallery_image', $searchAiGalleryImage);
            }
            $sessionAiGalleryImage = $this->session->userdata('session_ai_gallery_image');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_gallery_image_style');
                $this->session->unset_userdata('session_ai_gallery_image_size');
                $this->session->unset_userdata('session_ai_gallery_image_show');
                $this->session->unset_userdata('session_ai_gallery_image_status');
                redirect('view-ai-gallery-image');
            }
            
            $searchAiGalleryImageStyle = $this->input->post('search_ai_gallery_image_style');
            $allowedStyles = array('enhance', 'anime', 'photographic', 'digital-art', 'comic-book', 'fantasy-art', 'line-art', 'analog-film', 'neon-punk', 'isometric', 'low-poly', 'origami', 'modeling-compound', 'cinematic', '3d-model', 'pixel-art', 'tile-texture');
            if(in_array($searchAiGalleryImageStyle, $allowedStyles)){
                $this->session->set_userdata('session_ai_gallery_image_style', $searchAiGalleryImageStyle);
            } else if($searchAiGalleryImageStyle === 'all'){
                $this->session->unset_userdata('session_ai_gallery_image_style');
            }
            $sessionAiGalleryImageStyle = $this->session->userdata('session_ai_gallery_image_style');
            
            $searchAiGalleryImageSize = $this->input->post('search_ai_gallery_image_size');
            $allowedSizes = array('1024x1024', '2048x2048', '1152x896', '1216x832', '1344x768', '1536x640', '640x1536', '768x1344', '832x1216', '896x1152');
            if(in_array($searchAiGalleryImageSize, $allowedSizes)){
                $this->session->set_userdata('session_ai_gallery_image_size', $searchAiGalleryImageSize);
            } else if($searchAiGalleryImageSize === 'all'){
                $this->session->unset_userdata('session_ai_gallery_image_size');
            }
            $sessionAiGalleryImageSize = $this->session->userdata('session_ai_gallery_image_size');
            
            $searchAiGalleryImageShow = $this->input->post('search_ai_gallery_image_show');
            if($searchAiGalleryImageShow === 'public' or $searchAiGalleryImageShow == 'private'){
                $this->session->set_userdata('session_ai_gallery_image_show', $searchAiGalleryImageShow);
            } else if($searchAiGalleryImageShow === 'all'){
                $this->session->unset_userdata('session_ai_gallery_image_show');
            }
            $sessionAiGalleryImageShow = $this->session->userdata('session_ai_gallery_image_show');
            
            $searchAiGalleryImageStatus = $this->input->post('search_ai_gallery_image_status');
            if($searchAiGalleryImageStatus === 'publish' or $searchAiGalleryImageStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_gallery_image_status', $searchAiGalleryImageStatus);
            } else if($searchAiGalleryImageStatus === 'all'){
                $this->session->unset_userdata('session_ai_gallery_image_status');
            }
            $sessionAiGalleryImageStatus = $this->session->userdata('session_ai_gallery_image_status');
            
            $data = array();
            //get rows count
            $conditions['search_ai_gallery_image'] = $sessionAiGalleryImage;
            $conditions['search_ai_gallery_image_style'] = $sessionAiGalleryImageStyle;
            $conditions['search_ai_gallery_image_size'] = $sessionAiGalleryImageSize;
            $conditions['search_ai_gallery_image_show'] = $sessionAiGalleryImageShow;
            $conditions['search_ai_gallery_image_status'] = $sessionAiGalleryImageStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAiGalleryImage($conditions, AI_GALLERY_IMAGE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-ai-gallery-image');
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
            
            $aiGalleryImage = $this->DataModel->viewAiGalleryImage($conditions, AI_GALLERY_IMAGE_TABLE);
            $data['countAiGalleryImage'] = $this->DataModel->countAiGalleryImage($conditions, AI_GALLERY_IMAGE_TABLE);
            
            $data['viewAiGalleryImage'] = array();
            if(is_array($aiGalleryImage) || is_object($aiGalleryImage)){
                foreach($aiGalleryImage as $Row){
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
                    array_push($data['viewAiGalleryImage'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('aiGallery/image/ai_gallery_image_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function aiGalleryCategoryImageView($categoryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $categoryID = urlDecodes($categoryID);
            if(ctype_digit($categoryID)){
                if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_ai_gallery_category_image');
            }
            if(isset($_POST['submit_search'])){
                $searchAiGalleryCategoryImage = $this->input->post('search_ai_gallery_category_image');
                $this->session->set_userdata('session_ai_gallery_category_image', $searchAiGalleryCategoryImage);
            }
            $sessionAiGalleryCategoryImage = $this->session->userdata('session_ai_gallery_category_image');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_ai_gallery_category_image_style');
                $this->session->unset_userdata('session_ai_gallery_category_image_size');
                $this->session->unset_userdata('session_ai_gallery_category_image_show');
                $this->session->unset_userdata('session_ai_gallery_category_image_status');
                redirect('view-ai-gallery-category-image/'.urlEncodes($categoryID));
            }
            
            $searchAiGalleryCategoryImageStyle = $this->input->post('search_ai_gallery_category_image_style');
            $allowedStyles = array('enhance', 'anime', 'photographic', 'digital-art', 'comic-book', 'fantasy-art', 'line-art', 'analog-film', 'neon-punk', 'isometric', 'low-poly', 'origami', 'modeling-compound', 'cinematic', '3d-model', 'pixel-art', 'tile-texture');
            if(in_array($searchAiGalleryCategoryImageStyle, $allowedStyles)){
                $this->session->set_userdata('session_ai_gallery_category_image_style', $searchAiGalleryCategoryImageStyle);
            } else if($searchAiGalleryCategoryImageStyle === 'all'){
                $this->session->unset_userdata('session_ai_gallery_category_image_style');
            }
            $sessionAiGalleryCategoryImageStyle = $this->session->userdata('session_ai_gallery_category_image_style');
            
            $searchAiGalleryCategoryImageSize = $this->input->post('search_ai_gallery_category_image_size');
            $allowedSizes = array('1024x1024', '2048x2048', '1152x896', '1216x832', '1344x768', '1536x640', '640x1536', '768x1344', '832x1216', '896x1152');
            if(in_array($searchAiGalleryCategoryImageSize, $allowedSizes)){
                $this->session->set_userdata('session_ai_gallery_category_image_size', $searchAiGalleryCategoryImageSize);
            } else if($searchAiGalleryCategoryImageSize === 'all'){
                $this->session->unset_userdata('session_ai_gallery_category_image_size');
            }
            $sessionAiGalleryCategoryImageSize = $this->session->userdata('session_ai_gallery_category_image_size');
            
            $searchAiGalleryCategoryImageShow = $this->input->post('search_ai_gallery_category_image_show');
            if($searchAiGalleryCategoryImageShow === 'public' or $searchAiGalleryCategoryImageShow == 'private'){
                $this->session->set_userdata('session_ai_gallery_category_image_show', $searchAiGalleryCategoryImageShow);
            } else if($searchAiGalleryCategoryImageShow === 'all'){
                $this->session->unset_userdata('session_ai_gallery_category_image_show');
            }
            $sessionAiGalleryCategoryImageShow = $this->session->userdata('session_ai_gallery_category_image_show');
            
            $searchAiGalleryCategoryImageStatus = $this->input->post('search_ai_gallery_category_image_status');
            if($searchAiGalleryCategoryImageStatus === 'publish' or $searchAiGalleryCategoryImageStatus == 'unpublish'){
                $this->session->set_userdata('session_ai_gallery_category_image_status', $searchAiGalleryCategoryImageStatus);
            } else if($searchAiGalleryCategoryImageStatus === 'all'){
                $this->session->unset_userdata('session_ai_gallery_category_image_status');
            }
            $sessionAiGalleryCategoryImageStatus = $this->session->userdata('session_ai_gallery_category_image_status');
                
                $data = array();
                //get rows count
                $conditions['search_ai_gallery_category_image'] = $sessionAiGalleryCategoryImage;
                $conditions['search_ai_gallery_category_image_style'] = $sessionAiGalleryCategoryImageStyle;
                $conditions['search_ai_gallery_category_image_size'] = $sessionAiGalleryCategoryImageSize;
                $conditions['search_ai_gallery_category_image_show'] = $sessionAiGalleryCategoryImageShow;
                $conditions['search_ai_gallery_category_image_status'] = $sessionAiGalleryCategoryImageStatus;
                $conditions['returnType'] = 'count';
                
                $totalRec = $this->DataModel->viewAiGalleryCategoryImage($conditions, $categoryID, AI_GALLERY_IMAGE_TABLE);
        
                //pagination config
                $config['base_url']    = site_url('view-ai-gallery-category-image/'.urlEncodes($categoryID));
                $config['uri_segment'] = 3;
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
                $page = $this->uri->segment(3);
                $offset = !$page?0:$page;
                
                //get rows
                $conditions['returnType'] = '';
                $conditions['start'] = $offset;
                $conditions['limit'] = 20;
                
                $aiGalleryCategoryImage = $this->DataModel->viewAiGalleryCategoryImage($conditions, $categoryID, AI_GALLERY_IMAGE_TABLE);
                $data['countAiGalleryCategoryImage'] = $this->DataModel->countAiGalleryCategoryImage($conditions, $categoryID, AI_GALLERY_IMAGE_TABLE);
                
                $data['viewAiGalleryCategoryImage'] = array();
                if(is_array($aiGalleryCategoryImage) || is_object($aiGalleryCategoryImage)){
                    foreach($aiGalleryCategoryImage as $Row){
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
                        array_push($data['viewAiGalleryCategoryImage'], $dataArray);
                    }
                }
                $this->load->view('header');
                $this->load->view('aiGallery/image/ai_gallery_category_image_view', $data);
                $this->load->view('footer');
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function aiGalleryImageStatus($imageID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(AI_GALLERY_IMAGE_UNPUBLISH_ALIAS, "can_edit");
            $isPermission2 = checkPermission(AI_GALLERY_IMAGE_PUBLISH_ALIAS, "can_edit");
            $imageID = urlDecodes($imageID);
            if(ctype_digit($imageID)){
                $aiGalleryImage = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE);
                if($aiGalleryImage['image_status'] == "publish"){
                    if($isPermission1){
        	            $editData = array(
                		    'image_status'=>"unpublish",
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                if($aiGalleryImage['image_size'] == "1024x1024" && $aiGalleryImage['image_show'] == "public"){
    	                    $parsedUrl = parse_url($aiGalleryImage['image_thumbnail']);
    	                    if(isset($parsedUrl['scheme'])){
    	                        $editData = array(
                        		    'image_status'=>"publish",
                    		    );
    	                    } else {
    	                        $originalImageUrl = $aiGalleryImage['image_url'];
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
    	                    if($aiGalleryImage['image_size'] != "1024x1024" && $aiGalleryImage['image_show'] != "public"){
    	                        $imageStatusMsg = "You can't update! Because your image size not 1024x1024 & image not public";
    	                    } else if($aiGalleryImage['image_size'] != "1024x1024"){
    	                        $imageStatusMsg = "You can't update! Because your image size not 1024x1024";
    	                    } else if($aiGalleryImage['image_show'] != "public"){
    	                        $imageStatusMsg = "You can't update! Because your image not public";
    	                    } 
    	                    $this->session->set_userdata('session_ai_gallery_image_size_show', $imageStatusMsg);
                            redirect($_SERVER['HTTP_REFERER']);
    	                }
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE, $editData);
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
    
    public function aiGalleryImageDelete($imageID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(AI_GALLERY_IMAGE_ALIAS, "can_delete");
            if($isPermission){ 
                $imageID = urlDecodes($imageID);
                if(ctype_digit($imageID)){
                    
                    $data['aiGalleryImage'] = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE);
                    $s3Client = getConfig();
                    
                    $imageKey = $data['aiGalleryImage']['image_url'];
	                $newImageKey = basename($imageKey);

                    $deleteImage = $s3Client->deleteObject([
                        'Bucket' => AI_BUCKET_NAME,
                        'Key'    => GALLERY_PATH.$newImageKey,
                    ]);
                    
                    $thumbnailKey = $data['aiGalleryImage']['image_thumbnail'];
	                $newThumbnailKey = basename($thumbnailKey);

                    $deleteThumbnail = $s3Client->deleteObject([
                        'Bucket' => AI_BUCKET_NAME,
                        'Key'    => GALLERY_PATH.$newThumbnailKey,
                    ]);
                    
                    $resultDataEntry = $this->DataModel->deleteData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE);
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
    
    public function aiGalleryImageAll($action = null) {
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if($action === 'update'){
                $isPermission1 = checkPermission(AI_GALLERY_IMAGE_UNPUBLISH_ALIAS, "can_edit");
                $isPermission2 = checkPermission(AI_GALLERY_IMAGE_PUBLISH_ALIAS, "can_edit");
                $selectedRecords = $this->input->post('image_id');
                if(!empty($selectedRecords)){
                    $imageIds = array_map('intval', $selectedRecords);
                    foreach($imageIds as $imageID) {
                        $aiGalleryImage = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE);
                        if($aiGalleryImage['image_status'] == "publish"){
                            if($isPermission1){
                	            $editData = array(
                        		    'image_status'=>"unpublish",
                    		    );
                    		    $editDataEntry = $this->DataModel->editData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE, $editData);
                            } else {
                                redirect('permission-denied');
                            }
            	        } else {
            	            if($isPermission2){
            	                if($aiGalleryImage['image_size'] == "1024x1024" && $aiGalleryImage['image_show'] == "public"){
            	                    $parsedUrl = parse_url($aiGalleryImage['image_thumbnail']);
            	                    if(isset($parsedUrl['scheme'])){
            	                        $editData = array(
                                		    'image_status'=>"publish",
                            		    );
                            		    $editDataEntry = $this->DataModel->editData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE, $editData);
            	                    } else {
            	                        $originalImageUrl = $aiGalleryImage['image_url'];
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
                                            $editDataEntry = $this->DataModel->editData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE, $editData);
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
                $isPermission = checkPermission(AI_GALLERY_IMAGE_ALIAS, "can_delete");
                if($isPermission){ 
                    $selectedRecords = $this->input->post('image_id');
                    if(!empty($selectedRecords)){
                        $imageIds = array_map('intval', $selectedRecords);
                        foreach($imageIds as $imageID) {
                            $data['aiGalleryImage'] = $this->DataModel->getData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE);
                            $s3Client = getConfig();
                            
                            $imageKey = $data['aiGalleryImage']['image_url'];
        	                $newImageKey = basename($imageKey);
        
                            $deleteImage = $s3Client->deleteObject([
                                'Bucket' => AI_BUCKET_NAME,
                                'Key'    => GALLERY_PATH.$newImageKey,
                            ]);
                            $thumbnailKey = $data['aiGalleryImage']['image_thumbnail'];
        	                $newThumbnailKey = basename($thumbnailKey);
        
                            $deleteThumbnail = $s3Client->deleteObject([
                                'Bucket' => AI_BUCKET_NAME,
                                'Key'    => GALLERY_PATH.$newThumbnailKey,
                            ]);
                            $resultDataEntry = $this->DataModel->deleteData('image_id = '.$imageID, AI_GALLERY_IMAGE_TABLE);
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