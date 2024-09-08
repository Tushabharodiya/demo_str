<?php
    $isKeyboardCategoryDataAdd = checkPermission(KEYBOARD_DATA_ALIAS, "can_add");
    $isKeyboardCategoryDataView = checkPermission(KEYBOARD_DATA_ALIAS, "can_view");
    $isKeyboardCategoryDataEdit = checkPermission(KEYBOARD_DATA_ALIAS, "can_edit");
    $isKeyboardCategoryDataDelete = checkPermission(KEYBOARD_DATA_ALIAS, "can_delete");
    $isKeyboardCategoryDataPremiumEdit = checkPermission(KEYBOARD_DATA_PREMIUM_ALIAS, "can_edit");
    $isKeyboardCategoryDataFreeEdit = checkPermission(KEYBOARD_DATA_FREE_ALIAS, "can_edit");
    $isKeyboardCategoryDataPublishEdit = checkPermission(KEYBOARD_DATA_PUBLISH_ALIAS, "can_edit");
    $isKeyboardCategoryDataUnpublishEdit = checkPermission(KEYBOARD_DATA_UNPUBLISH_ALIAS, "can_edit");
    
    $sessionKeyboardCategoryData = $this->session->userdata('session_keyboard_category_data');
    $sessionKeyboardCategoryDataPremium = $this->session->userdata('session_keyboard_category_data_premium');
    $sessionKeyboardCategoryDataStatus = $this->session->userdata('session_keyboard_category_data_status');
    $sessionKeyboardCategoryDataView = $this->session->userdata('session_keyboard_category_data_view');
    $sessionKeyboardCategoryDataDownload = $this->session->userdata('session_keyboard_category_data_download');
    
    $categoryID = $this->uri->segment(2);
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Keyboard Category Data</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isKeyboardCategoryDataView){ ?>
                            <p><?php echo "You have total $countKeyboardCategoryData keyboard category datas."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isKeyboardCategoryDataView){ ?>
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Keyboard Category Data</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Premium</label>
                                                                <select class="form-control form-select" id="search-premium" name="search_keyboard_category_data_premium" data-id="<?php echo $categoryID; ?>" data-placeholder="Select a premium">
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataPremium == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataPremium == 'true')){
                                                                            $str.='selected';
                                                                    } ?> <option value="true"<?php echo $str; ?>>True</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataPremium == 'false')){
                                                                            $str.='selected';
                                                                    } ?> <option value="false"<?php echo $str; ?>>False</option>
                                                                </select>   
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_keyboard_category_data_status" data-id="<?php echo $categoryID; ?>" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataStatus == 'publish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="publish"<?php echo $str; ?>>Publish</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataStatus == 'unpublish')){
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
                                            <a href="<?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-setting"></em><span>Order By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Order Keyboard Category Data</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">View</label>
                                                                <select class="form-control form-select" id="search-view" name="search_keyboard_category_data_view" data-id="<?php echo $categoryID; ?>" data-placeholder="Select a view">
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataView == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataView == 'asc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="asc"<?php echo $str; ?>>ASC</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataView == 'desc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="desc"<?php echo $str; ?>>DESC</option>
                                                                </select>   
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Download</label>
                                                                <select class="form-control form-select" id="search-download" name="search_keyboard_category_data_download" data-id="<?php echo $categoryID; ?>" data-placeholder="Select a download">
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataDownload == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataDownload == 'asc')){
                                                                            $str.='selected';
                                                                    } ?> <option value="asc"<?php echo $str; ?>>ASC</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionKeyboardCategoryDataDownload == 'desc')){
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
                                <?php if($isKeyboardCategoryDataAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-keyboard-data" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>view-keyboard-category" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isKeyboardCategoryDataView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_keyboard_category_data" value="<?php if(!empty($sessionKeyboardCategoryData)){ echo $sessionKeyboardCategoryData; } ?>" placeholder="Search..." autocomplete="off">
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
                <?php if($isKeyboardCategoryDataView){ ?>
                    <?php if(!empty($viewKeyboardCategoryData)){ ?>
                        <?php foreach($viewKeyboardCategoryData as $data){ ?>
                            <div class="col-sm-6 col-md-4 col-xl-3">
                                <div class="card card-bordered pricing">
                                    <div class="pricing-head">
                                        <div class="pricing-title">
                                            <a class="gallery-image popup-image" href="<?php echo $data['keyboard_thumbnail']; ?>">
                                                <img src="<?php echo $data['keyboard_thumbnail']; ?>" alt="" width="180" height="113">
                                            </a>
                                        </div>
                                        <div class="card-text">
                                            <h6 class="card-title title"><?php echo $data['keyboard_id']; ?> - <?php echo $data['keyboardCategoryData']['category_name']; ?></h6>
                                            <p class="sub-text"><?php echo $data['keyboard_name']; ?></p>
                                        </div>
                                    </div>
                                    <div class="pricing-body">
                                        <ul class="pricing-features">
                                            <li><span class="w-50">Premium</span> - <span class="ms-auto"><?php 
                                              $keyboardPremium = '';
                                              if($data['keyboard_premium'] == 'true'){
                                                $keyboardPremium.= '<span class="tb-status text-success">True</span>';
                                              } else if($data['keyboard_premium'] == 'false'){
                                                $keyboardPremium.= '<span class="tb-status text-danger">False</span>';
                                              }
                                              echo $keyboardPremium; 
                                            ?></span></li>
                                            <li><span class="w-50">Status</span> - <span class="ms-auto"><?php 
                                              $keyboardStatus = '';
                                              if($data['keyboard_status'] == 'publish'){
                                                $keyboardStatus.= '<span class="tb-status text-success">Publish</span>';
                                              } else if($data['keyboard_status'] == 'unpublish'){
                                                $keyboardStatus.= '<span class="tb-status text-danger">Unpublish</span>';
                                              }
                                              echo $keyboardStatus; 
                                            ?></span></li>
                                            <li><span class="w-50">View</span> - <span class="ms-auto"><?php echo $data['keyboard_view']; ?></span></li>
                                            <li><span class="w-50">Download</span> - <span class="ms-auto"><?php echo $data['keyboard_download']; ?></span></li>
                                        </ul>
                                        <div class="pricing-action">
                                            <div class="team-view">
                                                <?php if($data['keyboard_premium'] == "true"){ ?>
                                                    <?php if($isKeyboardCategoryDataFreeEdit){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#freeModal<?php echo urlEncodes($data['keyboard_id']);?>" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Free">
                                                                <em class="icon ni ni-cross-round-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if($isKeyboardCategoryDataPremiumEdit){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#premiumModal<?php echo urlEncodes($data['keyboard_id']);?>" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Premium">
                                                                <em class="icon ni ni-check-round-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if($data['keyboard_status'] == "publish"){ ?>
                                                    <?php if($isKeyboardCategoryDataUnpublishEdit){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#unpublishModal<?php echo urlEncodes($data['keyboard_id']);?>" class="btn btn-sm btn-outline-danger ms-1" data-toggle="tooltip" data-placement="top" title="Unpublish">
                                                                <em class="icon ni ni-cross-round-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if($isKeyboardCategoryDataPublishEdit){ ?>
                                                        <li class="nk-tb-action">
                                                            <a data-bs-toggle="modal" data-bs-target="#publishModal<?php echo urlEncodes($data['keyboard_id']);?>" class="btn btn-sm btn-outline-success ms-1" data-toggle="tooltip" data-placement="top" title="Publish">
                                                                <em class="icon ni ni-check-round-fill"></em>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if($isKeyboardCategoryDataView){ ?>    
                                                    <a data-bs-toggle="modal" data-bs-target="#modalZoom<?php echo $data['keyboard_id'];?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="View"><em class="icon ni ni-eye-fill"></em></a>
                                                <?php } ?>
                                                <?php if($isKeyboardCategoryDataEdit){ ?>
                                                    <a href="<?php echo base_url(); ?>edit-keyboard-data/<?php echo urlEncodes($data['keyboard_id']); ?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="Edit"><em class="icon ni ni-edit-fill"></em></a>
                                                <?php } ?>
                                                <?php if($isKeyboardCategoryDataDelete){ ?>
                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['keyboard_id']);?>" class="btn btn-sm btn-outline-light ms-1" data-toggle="tooltip" data-placement="top" title="Delete"><em class="icon ni ni-trash-fill"></em></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade zoom" tabindex="-1" id="modalZoom<?php echo $data['keyboard_id'];?>">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?php echo $data['keyboard_id'];?></h5>
                                            <a href="<?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p><b>Date: </b><?php echo $data['created_date'];?></p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><?php echo $data['keyboard_status'];?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="freeModal<?php echo urlEncodes($data['keyboard_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Keyboard Category Data</h5>
                                            <a href="<?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to free <?php echo $data['keyboard_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>keyboard-data-premium/<?php echo urlEncodes($data['keyboard_id']); ?>" class="btn btn-sm btn-danger">Free</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="premiumModal<?php echo urlEncodes($data['keyboard_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Keyboard Category Data</h5>
                                            <a href="<?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to premium <?php echo $data['keyboard_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>keyboard-data-premium/<?php echo urlEncodes($data['keyboard_id']); ?>" class="btn btn-sm btn-success">Premium</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="unpublishModal<?php echo urlEncodes($data['keyboard_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Keyboard Category Data</h5>
                                            <a href="<?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to unpublish <?php echo $data['keyboard_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>keyboard-data-status/<?php echo urlEncodes($data['keyboard_id']); ?>" class="btn btn-sm btn-danger">Unpublish</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="publishModal<?php echo urlEncodes($data['keyboard_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Keyboard Category Data</h5>
                                            <a href="<?php echo base_url(); ?><?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to publish <?php echo $data['keyboard_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>keyboard-data-status/<?php echo urlEncodes($data['keyboard_id']); ?>" class="btn btn-sm btn-success">Publish</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['keyboard_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Keyboard Category Data</h5>
                                            <a href="<?php echo base_url(); ?>view-keyboard-category-data/<?php echo $categoryID; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete <?php echo $data['keyboard_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>delete-keyboard-data/<?php echo urlEncodes($data['keyboard_id']); ?>" class="btn btn-sm btn-danger">Delete</a></span>
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
                                        <div class="gm-err-title">You don't have permission to show the keyboard category data's data.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php if($isKeyboardCategoryDataView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div> 
  
    </div>
</div>

<script>
    document.getElementById('search-premium').addEventListener('change', function() {
        var selectedPremium = this.value;
        var categoryID = $(this).data('id');
        $.ajax({
            url: '<?= base_url('view-keyboard-category-data'); ?>/' + categoryID,
            type: 'POST',
            data: { search_keyboard_category_data_premium: selectedPremium },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        var categoryID = $(this).data('id');
        $.ajax({
            url: '<?= base_url('view-keyboard-category-data'); ?>/' + categoryID,
            type: 'POST',
            data: { search_keyboard_category_data_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    document.getElementById('search-view').addEventListener('change', function() {
        var selectedView = this.value;
        var categoryID = $(this).data('id');
        $.ajax({
            url: '<?= base_url('view-keyboard-category-data'); ?>/' + categoryID,
            type: 'POST',
            data: { search_keyboard_category_data_view: selectedView },
            success: function() {
                location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('search-download').addEventListener('change', function() {
        var selectedDownload = this.value;
        var categoryID = $(this).data('id');
        $.ajax({
            url: '<?= base_url('view-keyboard-category-data'); ?>/' + categoryID,
            type: 'POST',
            data: { search_keyboard_category_data_download: selectedDownload },
            success: function() {
                location.reload();
            }
        });
    });
</script>