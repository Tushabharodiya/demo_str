<?php
    $isAiGalleryDataNew = checkPermission(AI_GALLERY_DATA_ALIAS, "can_add");
    $isAiGalleryDataView = checkPermission(AI_GALLERY_DATA_ALIAS, "can_view");
    $isAiGalleryDataEdit = checkPermission(AI_GALLERY_DATA_ALIAS, "can_edit");
    $isAiGalleryDataDelete = checkPermission(AI_GALLERY_DATA_ALIAS, "can_delete");
    $isAiGalleryDataMoveDelete = checkPermission(AI_GALLERY_DATA_MOVE_ALIAS, "can_delete");
    $isAiGalleryDataPublishEdit = checkPermission(AI_GALLERY_DATA_PUBLISH_ALIAS, "can_edit");
    $isAiGalleryDataUnpublishEdit = checkPermission(AI_GALLERY_DATA_UNPUBLISH_ALIAS, "can_edit");
    
    $sessionAiGalleryData = $this->session->userdata('session_ai_gallery_data');
    $sessionAiGalleryDataStyle = $this->session->userdata('session_ai_gallery_data_style');
    $sessionAiGalleryDataSize = $this->session->userdata('session_ai_gallery_data_size');
    $sessionAiGalleryDataShow = $this->session->userdata('session_ai_gallery_data_show');
    $sessionAiGalleryDataStatus = $this->session->userdata('session_ai_gallery_data_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">AI Gallery Data</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAiGalleryDataView){ ?>
                            <p><?php echo "You have total $countAiGalleryData ai images."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAiGalleryDataView){ ?>
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Ai Gallery Data</span>
                                                </div>
                                                <?php if($isAiGalleryDataEdit or $isAiGalleryDataDelete){ ?>
                                                    <div class="dropdown-foot between">
                                                        <?php if($isAiGalleryDataEdit or $isAiGalleryDataDelete){ ?>
                                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input toggle-checkbox" id="select_all">
                                                                <label class="custom-control-label" for="select_all"> Select All</label>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if($isAiGalleryDataEdit){ ?> 
                                                            <a class="text-primary submit-button" data-bs-toggle="modal" data-bs-target="#updateModal">Update All</a>
                                                        <?php } ?>
                                                        <?php if($isAiGalleryDataDelete){ ?>
                                                            <a class="text-danger submit-button" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete All</a>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Style</label>
                                                                <select class="form-control form-select" id="search-style" name="search_ai_gallery_data_style" data-placeholder="Select a style">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'enhance')){
                                                                            $str.='selected';
                                                                    } ?> <option value="enhance"<?php echo $str; ?>>Enhance</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'anime')){
                                                                            $str.='selected';
                                                                    } ?> <option value="anime"<?php echo $str; ?>>Anime</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'photographic')){
                                                                            $str.='selected';
                                                                    } ?> <option value="photographic"<?php echo $str; ?>>Photographic</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'digital-art')){
                                                                            $str.='selected';
                                                                    } ?> <option value="digital-art"<?php echo $str; ?>>Digital Art</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'comic-book')){
                                                                            $str.='selected';
                                                                    } ?> <option value="comic-book"<?php echo $str; ?>>Comic Book</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'fantasy-art')){
                                                                            $str.='selected';
                                                                    } ?> <option value="fantasy-art"<?php echo $str; ?>>Fantasy Art</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'line-art')){
                                                                            $str.='selected';
                                                                    } ?> <option value="line-art"<?php echo $str; ?>>Line Art</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'analog-film')){
                                                                            $str.='selected';
                                                                    } ?> <option value="analog-film"<?php echo $str; ?>>Analog Film</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'neon-punk')){
                                                                            $str.='selected';
                                                                    } ?> <option value="neon-punk"<?php echo $str; ?>>Neon Punk</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'isometric')){
                                                                            $str.='selected';
                                                                    } ?> <option value="isometric"<?php echo $str; ?>>Isometric</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'low-poly')){
                                                                            $str.='selected';
                                                                    } ?> <option value="low-poly"<?php echo $str; ?>>Low Poly</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'origami')){
                                                                            $str.='selected';
                                                                    } ?> <option value="origami"<?php echo $str; ?>>Origami</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'modeling-compound')){
                                                                            $str.='selected';
                                                                    } ?> <option value="modeling-compound"<?php echo $str; ?>>Modeling</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'cinematic')){
                                                                            $str.='selected';
                                                                    } ?> <option value="cinematic"<?php echo $str; ?>>Cinematic</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == '3d-model')){
                                                                            $str.='selected';
                                                                    } ?> <option value="3d-model"<?php echo $str; ?>>3d Model</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'pixel-art')){
                                                                            $str.='selected';
                                                                    } ?> <option value="pixel-art"<?php echo $str; ?>>Pixel Art</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStyle == 'tile-texture')){
                                                                            $str.='selected';
                                                                    } ?> <option value="tile-texture"<?php echo $str; ?>>Tile Texture</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Size</label>
                                                                <select class="form-control form-select" id="search-size" name="search_ai_gallery_data_size" data-placeholder="Select a size">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '1024x1024')){
                                                                            $str.='selected';
                                                                    } ?> <option value="1024x1024"<?php echo $str; ?>>1024x1024</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '2048x2048')){
                                                                            $str.='selected';
                                                                    } ?> <option value="2048x2048"<?php echo $str; ?>>2048x2048</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '1152x896')){
                                                                            $str.='selected';
                                                                    } ?> <option value="1152x896"<?php echo $str; ?>>1152x896</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '1216x832')){
                                                                            $str.='selected';
                                                                    } ?> <option value="1216x832"<?php echo $str; ?>>1216x832</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '1344x768')){
                                                                            $str.='selected';
                                                                    } ?> <option value="1344x768"<?php echo $str; ?>>1344x768</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '1536x640')){
                                                                            $str.='selected';
                                                                    } ?> <option value="1536x640"<?php echo $str; ?>>1536x640</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '640x1536')){
                                                                            $str.='selected';
                                                                    } ?> <option value="640x1536"<?php echo $str; ?>>640x1536</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '768x1344')){
                                                                            $str.='selected';
                                                                    } ?> <option value="768x1344"<?php echo $str; ?>>768x1344</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '832x1216')){
                                                                            $str.='selected';
                                                                    } ?> <option value="832x1216"<?php echo $str; ?>>832x1216</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataSize == '896x1152')){
                                                                            $str.='selected';
                                                                    } ?> <option value="896x1152"<?php echo $str; ?>>896x1152</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Show</label>
                                                                <select class="form-control form-select" id="search-show" name="search_ai_gallery_data_show" data-placeholder="Select a show">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataShow == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataShow == 'public')){
                                                                            $str.='selected';
                                                                    } ?> <option value="public"<?php echo $str; ?>>Public</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataShow == 'private')){
                                                                            $str.='selected';
                                                                    } ?> <option value="private"<?php echo $str; ?>>Private</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_ai_gallery_data_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStatus == 'publish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="publish"<?php echo $str; ?>>Publish</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryDataStatus == 'unpublish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="unpublish"<?php echo $str; ?>>Unpublish</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                    <div class="dropdown-foot between">
                                                        <input type="submit" class="btn btn-sm btn-dim btn-secondary" name="reset_filter" value="Reset Filter">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                                <?php if($isAiGalleryDataNew){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-ai-gallery-data" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAiGalleryDataView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_ai_gallery_data" value="<?php if(!empty($sessionAiGalleryData)){ echo $sessionAiGalleryData; } ?>" placeholder="Search..." autocomplete="off">
                            <div class="form-icon form-icon-right">
                                <em class="icon ni ni-search"></em>
                            </div>
                            <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                            <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_ai_gallery_data_size_show'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_ai_gallery_data_size_show');?> <?php echo $this->session->unset_userdata('session_ai_gallery_data_size_show');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_ai_gallery_data_move_size_show'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_ai_gallery_data_move_size_show');?> <?php echo $this->session->unset_userdata('session_ai_gallery_data_move_size_show');?>
            </div>
        <?php } ?>
                            
        <div class="nk-block">
            <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                <div class="modal fade" tabindex="-1" id="updateModal">
                    <div class="modal-dialog modal-dialog-top" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ai Images</h5>
                                <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to update <span class="text-primary checked-count">0</span> ai images?</p>
                            </div>
                            <div class="modal-footer bg-light">
                                <span class="sub-text"><input type="submit" class="btn btn-sm btn-primary" id="submit" name="submit" value="Update All" onclick="submitForm('update')"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" id="deleteModal">
                    <div class="modal-dialog modal-dialog-top" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ai Images</h5>
                                <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <span class="text-danger checked-count">0</span> ai images?</p>
                            </div>
                            <div class="modal-footer bg-light">
                                <span class="sub-text"><input type="submit" class="btn btn-sm btn-danger" id="submit" name="submit" value="Delete All" onclick="submitForm('delete')"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-gs">
                    <?php if($isAiGalleryDataView){ ?>
                        <?php if(!empty($viewAiGalleryData)){ ?>
                            <?php foreach($viewAiGalleryData as $data){ ?>
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    <div class="card card-bordered pricing">
                                        <div class="pricing-head">
                                            <div class="pricing-title">
                                                <?php if($isAiGalleryDataEdit or $isAiGalleryDataDelete){ ?>
                                                    <div class="custom-control custom-checkbox image-control">
                                                        <input type="checkbox" class="custom-control-input toggle-checkbox checkbox" id="<?php echo $data['image_id']; ?>" name="image_id[]" value="<?php echo $data['image_id']; ?>">
                                                        <label class="custom-control-label" for="<?php echo $data['image_id']; ?>">
                                                            <a class="gallery-image popup-image" href="<?php echo $data['image_url']; ?>">
                                                                <img src="<?php echo $data['image_url']; ?>" alt="" width="200" height="200">
                                                            </a>
                                                        </label>
                                                    </div>
                                                <?php } else { ?>
                                                    <a class="gallery-image popup-image" href="<?php echo $data['image_url']; ?>">
                                                        <img src="<?php echo $data['image_url']; ?>" alt="" width="200" height="200">
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <div class="card-text">
                                                <?php $parsedUrl = parse_url($data['image_thumbnail']); ?>
                                                <h6 class="card-title title"><?php if(isset($parsedUrl['scheme'])){ ?><span class="text-primary"><?php echo $data['image_id']; ?></span><?php } else { ?><?php echo $data['image_id']; ?><?php } ?> - <?php echo $data['image_style']; ?></h6>
                                                <span class="sub-text"><?php echo $data['image_type']; ?></span>
                                            </div>
                                        </div>
                                        <div class="pricing-body">
                                            <ul class="pricing-features">
                                                <li><span class="w-50">Size</span> - <span class="ms-auto"><?php echo $data['image_size']; ?></span></li>
                                                <li><span class="w-50">Show</span> - <span class="ms-auto"><?php 
                                                    $imageShow = '';
                                                    if($data['image_show'] == 'public'){
                                                        $imageShow.= '<span class="tb-status text-primary">Public</span>';
                                                    } else if($data['image_show'] == 'private'){
                                                        $imageShow.= '<span class="tb-status text-info">Private</span>';
                                                    } 
                                                    echo $imageShow; 
                                                ?></span></li>
                                                <li><span class="w-50">Status</span> - <span class="ms-auto"><?php 
                                                    $imageStatus = '';
                                                    if($data['image_status'] == 'publish'){
                                                        $imageStatus.= '<span class="tb-status text-success">Publish</span>';
                                                    } else if($data['image_status'] == 'unpublish'){
                                                        $imageStatus.= '<span class="tb-status text-danger">Unpublish</span>';
                                                    } 
                                                    echo $imageStatus; 
                                                ?></span></li>
                                                <li><span class="w-50">Scale</span> - <span class="ms-auto"><?php echo $data['image_scale']; ?></span></li>
                                                <li><span class="w-50">Step</span> - <span class="ms-auto"><?php echo $data['image_steps']; ?></span></li>
                                            </ul>
                                            <div class="pricing-action">
                                                <div class="team-view">
                                                    <?php if($data['image_status'] == "publish"){ ?>
                                                        <?php if($isAiGalleryDataUnpublishEdit){ ?>
                                                            <li class="nk-tb-action">
                                                                <a data-bs-toggle="modal" data-bs-target="#unpublishModal<?php echo urlEncodes($data['image_id']);?>" class="btn btn-sm btn-outline-danger ms-1" data-toggle="tooltip" data-placement="top" title="Unpublish">
                                                                    <em class="icon ni ni-cross-round-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if($isAiGalleryDataPublishEdit){ ?>
                                                            <li class="nk-tb-action">
                                                                <a data-bs-toggle="modal" data-bs-target="#publishModal<?php echo urlEncodes($data['image_id']);?>" class="btn btn-sm btn-outline-success ms-1" data-toggle="tooltip" data-placement="top" title="Publish">
                                                                    <em class="icon ni ni-check-round-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if($isAiGalleryDataView){ ?>    
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#modalZoom<?php echo $data['image_id'];?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="View">
                                                                <em class="icon ni ni-eye-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($isAiGalleryDataDelete){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['image_id']);?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                <em class="icon ni ni-trash-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($isAiGalleryDataMoveDelete){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#moveModal<?php echo urlEncodes($data['image_id']);?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="Move">
                                                                <em class="icon ni ni-move"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade zoom" tabindex="-1" id="modalZoom<?php echo $data['image_id'];?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?php echo $data['image_id'];?></h5>
                                                <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>Prompt : <?php echo $data['image_prompt'];?></p>
                                                <p>Date : <?php echo $data['image_date'];?></p>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <span class="sub-text"><?php echo $data['image_status'];?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" id="unpublishModal<?php echo urlEncodes($data['image_id']);?>">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ai Data</h5>
                                                <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to unpublish this ai data?</p>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <span class="sub-text"><a href="<?php echo base_url(); ?>ai-gallery-data-status/<?php echo urlEncodes($data['image_id']); ?>" class="btn btn-sm btn-danger">Unpublish</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" id="publishModal<?php echo urlEncodes($data['image_id']);?>">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ai Data</h5>
                                                <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to publish this ai data?</p>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <span class="sub-text"><a href="<?php echo base_url(); ?>ai-gallery-data-status/<?php echo urlEncodes($data['image_id']); ?>" class="btn btn-sm btn-success">Publish</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['image_id']);?>">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ai Image</h5>
                                                <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this ai image?</p>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <span class="sub-text"><a href="<?php echo base_url(); ?>delete-ai-gallery-data/<?php echo urlEncodes($data['image_id']); ?>" class="btn btn-sm btn-danger">Delete</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="col-md-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="nk-block-content nk-error-ld text-center">
                                            <div class="gm-err-content">
                                                <div class="gm-err-icon"><img src="<?php echo base_url();?>source/images/nodata.webp" alt="error" height="200" width="200"></div>
                                                <div class="gm-err-title">No data available in table</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="col-md-12">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="nk-block-content text-center p-3">
                                        <div class="gm-err-content">
                                            <div class="gm-err-icon"><img src="https://maps.gstatic.com/mapfiles/api-3/images/icon_error.png" alt="" draggable="false" style="user-select: none;"></div>
                                            <div class="gm-err-title">You don't have permission to show the ai gallery data's data.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php if($isAiGalleryDataView){ ?>
                    <ul class="pagination justify-content-center justify-content-md-center mt-3">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                <?php } ?>
            </form>
            <?php foreach($viewAiGalleryData as $data){ ?>
                <form action="<?php echo base_url(); ?>move-ai-gallery-data/<?php echo urlEncodes($data['image_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="modal fade" tabindex="-1" id="moveModal<?php echo urlEncodes($data['image_id']);?>">
                        <div class="modal-dialog modal-dialog-top" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ai Image</h5>
                                    <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <em class="icon ni ni-cross"></em>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-gs">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="category_id">Category Name *</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control form-select js-select2" name="category_id" data-placeholder="Select a category" required>
                                                        <option label="empty" value=""></option>
                                                        <?php if(!empty($aiGalleryCategoryData)){ ?>
                                                            <?php foreach($aiGalleryCategoryData as $data){ ?>
                                                                <option value="<?php echo $data['category_id']; ?>"><?php echo $data['category_name']; ?></option>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <option value="">Empty</option>
                                                        <?php }  ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <span class="sub-text"><input type="submit" class="btn btn-sm btn-primary" value="Move"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div> 
  
    </div>
</div>

<script type="application/javascript">
    $(window).bind("load", function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 2000);
    });
</script>

<script>
    document.getElementById('search-style').addEventListener('change', function() {
        var selectedStyle = this.value;
        $.ajax({
            url: '<?= base_url('view-ai-gallery-data'); ?>',
            type: 'POST',
            data: { search_ai_gallery_data_style: selectedStyle },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-size').addEventListener('change', function() {
        var selectedSize = this.value;
        $.ajax({
            url: '<?= base_url('view-ai-gallery-data'); ?>',
            type: 'POST',
            data: { search_ai_gallery_data_size: selectedSize },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-show').addEventListener('change', function() {
        var selectedShow = this.value;
        $.ajax({
            url: '<?= base_url('view-ai-gallery-data'); ?>',
            type: 'POST',
            data: { search_ai_gallery_data_show: selectedShow },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-ai-gallery-data'); ?>',
            type: 'POST',
            data: { search_ai_gallery_data_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.toggle-checkbox').change(function() {
            $('.submit-button').toggle($('.toggle-checkbox:checked').length > 0);
        });
        
        function updateCheckedCount() {
            var checkedCount = $('.checkbox:checked').length;
            $('.modal .checked-count').text(checkedCount);
        }

        $('.checkbox').on('click', function() {
            updateCheckedCount();
        });

        $('#select_all').on('click', function() {
            $('.checkbox').prop('checked', this.checked);
            updateCheckedCount();
        });

        updateCheckedCount();
    });
    
    function submitForm(action) {
        $('#myForm').attr('action', '<?= base_url('all-ai-gallery-data'); ?>/' + action);
        $('#myForm').submit();
    }
    
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        } else {
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        } else {
            $('#select_all').prop('checked',false);
        }
    });
</script>