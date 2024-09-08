<?php
    $isChargingDataAdd = checkPermission(CHARGING_DATA_ALIAS, "can_add");
    $isChargingDataView = checkPermission(CHARGING_DATA_ALIAS, "can_view");
    $isChargingDataEdit = checkPermission(CHARGING_DATA_ALIAS, "can_edit");
    $isChargingDataDelete = checkPermission(CHARGING_DATA_ALIAS, "can_delete");
    $isChargingDataPremiumEdit = checkPermission(CHARGING_DATA_PREMIUM_ALIAS, "can_edit");
    $isChargingDataFreeEdit = checkPermission(CHARGING_DATA_FREE_ALIAS, "can_edit");
    $isChargingDataPublishEdit = checkPermission(CHARGING_DATA_PUBLISH_ALIAS, "can_edit");
    $isChargingDataUnpublishEdit = checkPermission(CHARGING_DATA_UNPUBLISH_ALIAS, "can_edit");
    
    $sessionChargingData = $this->session->userdata('session_charging_data');
    $sessionChargingDataType = $this->session->userdata('session_charging_data_type');
    $sessionChargingDataPremium = $this->session->userdata('session_charging_data_premium');
    $sessionChargingDataMusic = $this->session->userdata('session_charging_data_music');
    $sessionChargingDataStatus = $this->session->userdata('session_charging_data_status');
    $sessionChargingDataView = $this->session->userdata('session_charging_data_view');
    $sessionChargingDataDownload = $this->session->userdata('session_charging_data_download');
    $sessionChargingDataApplied = $this->session->userdata('session_charging_data_applied');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Charging Data</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isChargingDataView){ ?>
                            <p><?php echo "You have total $countChargingData charging datas."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-charging-data" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isChargingDataView){ ?>
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-charging-data" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Charging Data</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Type</label>
                                                                <select class="form-control form-select" id="search-type" name="search_charging_data_type" data-placeholder="Select a type">
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataType == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataType == 'animation')){
                                                                            $str.='selected';
                                                                    } ?> <option value="animation"<?php echo $str; ?>>Animation</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataType == 'video')){
                                                                            $str.='selected';
                                                                    } ?> <option value="video"<?php echo $str; ?>>Video</option>
                                                                </select>   
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Premium</label>
                                                                <select class="form-control form-select" id="search-premium" name="search_charging_data_premium" data-placeholder="Select a premium">
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataPremium == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataPremium == 'true')){
                                                                            $str.='selected';
                                                                    } ?> <option value="true"<?php echo $str; ?>>True</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataPremium == 'false')){
                                                                            $str.='selected';
                                                                    } ?> <option value="false"<?php echo $str; ?>>False</option>
                                                                </select>  
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Music</label>
                                                                <select class="form-control form-select" id="search-music" name="search_charging_data_music" data-placeholder="Select a music">
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataMusic == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataMusic == 'true')){
                                                                            $str.='selected';
                                                                    } ?> <option value="true"<?php echo $str; ?>>True</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataMusic == 'false')){
                                                                            $str.='selected';
                                                                    } ?> <option value="false"<?php echo $str; ?>>False</option>
                                                                </select>   
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_charging_data_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataStatus == 'publish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="publish"<?php echo $str; ?>>Publish</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataStatus == 'unpublish')){
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
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-charging-data" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-setting"></em><span>Order By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Order Charging Data</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">View</label>
                                                                <select class="form-control form-select" id="search-view" name="search_charging_data_view" data-placeholder="Select a view">
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataView == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataView == 'asc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="asc"<?php echo $str; ?>>ASC</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataView == 'desc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="desc"<?php echo $str; ?>>DESC</option>
                                                                </select>   
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Download</label>
                                                                <select class="form-control form-select" id="search-download" name="search_charging_data_download" data-placeholder="Select a download">
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataDownload == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataDownload == 'asc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="asc"<?php echo $str; ?>>ASC</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataDownload == 'desc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="desc"<?php echo $str; ?>>DESC</option>
                                                                </select>  
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Applied</label>
                                                                <select class="form-control form-select" id="search-applied" name="search_charging_data_applied" data-placeholder="Select a applied">
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataApplied == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataApplied == 'asc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="asc"<?php echo $str; ?>>ASC</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionChargingDataApplied == 'desc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="desc"<?php echo $str; ?>>DESC</option>
                                                                </select>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                    <div class="dropdown-foot between">
                                                        <input type="submit" class="btn btn-sm btn-dim btn-secondary" name="reset_order" value="Reset Order">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                                <?php if($isChargingDataAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-charging-data" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isChargingDataView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_charging_data" value="<?php if(!empty($sessionChargingData)){ echo $sessionChargingData; } ?>" placeholder="Search..." autocomplete="off">
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

        <div class="nk-block">
            <div class="row g-gs">
                <?php if($isChargingDataView){ ?>
                    <?php if(!empty($viewChargingData)){ ?>
                        <?php foreach($viewChargingData as $data){ ?>
                            <div class="col-sm-6 col-md-4 col-xl-3">
                                <div class="card card-bordered pricing">
                                    <div class="pricing-head">
                                        <div class="pricing-title">
                                            <?php if($data['thumbnail_type'] == 'png'){ ?>
                                                <a class="gallery-image popup-image" href="<?php echo $data['charging_thumbnail']; ?>">
                                                    <img src="<?php echo $data['charging_thumbnail']; ?>" alt="" width="120" height="213">
                                                </a>
                                            <?php } else { ?>
                                                <a class="gallery-image popup-image" href="<?php echo base_url(); ?>source/images/json.png">
                                                    <img src="<?php echo base_url(); ?>source/images/json.png" alt="" width="120" height="213">
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="card-text">
                                            <h6 class="card-title title"><?php echo $data['charging_id']; ?> - <?php echo $data['chargingCategoryData']['category_name']; ?></h6>
                                            <p class="sub-text"><?php echo $data['charging_name']; ?></p>
                                        </div>
                                    </div>
                                    <div class="pricing-body">
                                        <ul class="pricing-features">
                                            <li><span class="w-50">Type</span> - <span class="ms-auto"><?php 
                                                $chargingType = '';
                                                if($data['charging_type'] == 'animation'){
                                                    $chargingType.= '<span class="tb-status text-primary">Animation</span>';
                                                } else if($data['charging_type'] == 'video'){
                                                    $chargingType.= '<span class="tb-status text-secondary">Video</span>';
                                                }
                                                echo $chargingType; 
                                            ?></span></li>
                                            <li><span class="w-50">Premium</span> - <span class="ms-auto"><?php 
                                                $isPremium = '';
                                                if($data['is_premium'] == 'true'){
                                                    $isPremium.= '<span class="tb-status text-success">True</span>';
                                                } else if($data['is_premium'] == 'false'){
                                                    $isPremium.= '<span class="tb-status text-danger">False</span>';
                                                }
                                                echo $isPremium; 
                                            ?></span></li>
                                            <li><span class="w-50">Music</span> - <span class="ms-auto"><?php 
                                                $isMusic = '';
                                                if($data['is_music'] == 'true'){
                                                    $isMusic.= '<span class="tb-status text-success">True</span>';
                                                } else if($data['is_music'] == 'false'){
                                                    $isMusic.= '<span class="tb-status text-danger">False</span>';
                                                }
                                                echo $isMusic; 
                                            ?></span></li>
                                            <li><span class="w-50">Status</span> - <span class="ms-auto"><?php 
                                                $chargingStatus = '';
                                                if($data['charging_status'] == 'publish'){
                                                    $chargingStatus.= '<span class="tb-status text-success">Publish</span>';
                                                } else if($data['charging_status'] == 'unpublish'){
                                                    $chargingStatus.= '<span class="tb-status text-danger">Unpublish</span>';
                                                }
                                                echo $chargingStatus; 
                                            ?></span></li>
                                            <li><span class="w-50">View</span> - <span class="ms-auto"><?php echo $data['charging_view']; ?></span></li>
                                            <li><span class="w-50">Download</span> - <span class="ms-auto"><?php echo $data['charging_download']; ?></span></li>
                                            <li><span class="w-50">Applied</span> - <span class="ms-auto"><?php echo $data['charging_applied']; ?></span></li>
                                        </ul>
                                        <div class="pricing-action">
                                            <div class="team-view">
                                                <?php if($data['is_premium'] == "true"){ ?>
                                                    <?php if($isChargingDataFreeEdit){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#freeModal<?php echo urlEncodes($data['charging_id']);?>" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Free">
                                                                <em class="icon ni ni-cross-round-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if($isChargingDataPremiumEdit){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#premiumModal<?php echo urlEncodes($data['charging_id']);?>" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Premium">
                                                                <em class="icon ni ni-check-round-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if($data['charging_status'] == "publish"){ ?>
                                                    <?php if($isChargingDataUnpublishEdit){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#unpublishModal<?php echo urlEncodes($data['charging_id']);?>" class="btn btn-sm btn-outline-danger ms-1" data-toggle="tooltip" data-placement="top" title="Unpublish">
                                                                <em class="icon ni ni-cross-round-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if($isChargingDataPublishEdit){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#publishModal<?php echo urlEncodes($data['charging_id']);?>" class="btn btn-sm btn-outline-success ms-1" data-toggle="tooltip" data-placement="top" title="Publish">
                                                                <em class="icon ni ni-check-round-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if($isChargingDataView){ ?>    
                                                    <a data-bs-toggle="modal" data-bs-target="#modalZoom<?php echo $data['charging_id'];?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="View"><em class="icon ni ni-eye-fill"></em></a>
                                                <?php } ?>
                                                <?php if($isChargingDataEdit){ ?>
                                                    <a href="<?php echo base_url(); ?>edit-charging-data/<?php echo urlEncodes($data['charging_id']); ?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="Edit"><em class="icon ni ni-edit-fill"></em></a>
                                                <?php } ?>
                                                <?php if($isChargingDataDelete){ ?>
                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['charging_id']);?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="Delete"><em class="icon ni ni-trash-fill"></em></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade zoom" tabindex="-1" id="modalZoom<?php echo $data['charging_id'];?>">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?php echo $data['charging_id'];?></h5>
                                            <a href="<?php echo base_url(); ?>view-charging-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p><b>Date: </b><?php echo $data['created_date'];?></p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><?php echo $data['charging_status'];?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="freeModal<?php echo urlEncodes($data['charging_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Charging Data</h5>
                                            <a href="<?php echo base_url(); ?>view-charging-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to free <?php echo $data['charging_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>charging-data-premium/<?php echo urlEncodes($data['charging_id']); ?>" class="btn btn-sm btn-danger">Free</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="premiumModal<?php echo urlEncodes($data['charging_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Charging Data</h5>
                                            <a href="<?php echo base_url(); ?>view-charging-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to premium <?php echo $data['charging_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>charging-data-premium/<?php echo urlEncodes($data['charging_id']); ?>" class="btn btn-sm btn-success">Premium</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="unpublishModal<?php echo urlEncodes($data['charging_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Charging Data</h5>
                                            <a href="<?php echo base_url(); ?>view-charging-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to unpublish <?php echo $data['charging_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>charging-data-status/<?php echo urlEncodes($data['charging_id']); ?>" class="btn btn-sm btn-danger">Unpublish</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="publishModal<?php echo urlEncodes($data['charging_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Charging Data</h5>
                                            <a href="<?php echo base_url(); ?>view-charging-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to publish <?php echo $data['charging_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>charging-data-status/<?php echo urlEncodes($data['charging_id']); ?>" class="btn btn-sm btn-success">Publish</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['charging_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Charging Data</h5>
                                            <a href="<?php echo base_url(); ?>view-charging-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete <?php echo $data['charging_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>delete-charging-data/<?php echo urlEncodes($data['charging_id']); ?>" class="btn btn-sm btn-danger">Delete</a></span>
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
                                        <div class="gm-err-title">You don't have permission to show the charging data's data.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php if($isChargingDataView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div> 
  
    </div>
</div>

<script>
    document.getElementById('search-type').addEventListener('change', function() {
        var selectedType = this.value;
        $.ajax({
            url: '<?= base_url('view-charging-data'); ?>',
            type: 'POST',
            data: { search_charging_data_type: selectedType },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-premium').addEventListener('change', function() {
        var selectedPremium = this.value;
        $.ajax({
            url: '<?= base_url('view-charging-data'); ?>',
            type: 'POST',
            data: { search_charging_data_premium: selectedPremium },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-music').addEventListener('change', function() {
        var selectedMusic = this.value;
        $.ajax({
            url: '<?= base_url('view-charging-data'); ?>',
            type: 'POST',
            data: { search_charging_data_music: selectedMusic },
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
            url: '<?= base_url('view-charging-data'); ?>',
            type: 'POST',
            data: { search_charging_data_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    document.getElementById('search-view').addEventListener('change', function() {
        var selectedView = this.value;
        $.ajax({
            url: '<?= base_url('view-charging-data'); ?>',
            type: 'POST',
            data: { search_charging_data_view: selectedView },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-download').addEventListener('change', function() {
        var selectedDownload = this.value;
        $.ajax({
            url: '<?= base_url('view-charging-data'); ?>',
            type: 'POST',
            data: { search_charging_data_download: selectedDownload },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-applied').addEventListener('change', function() {
        var selectedApplied = this.value;
        $.ajax({
            url: '<?= base_url('view-charging-data'); ?>',
            type: 'POST',
            data: { search_charging_data_applied: selectedApplied },
            success: function() {
                location.reload();
            }
        });
    });
</script>