<?php
    $isAiGalleryCategoryAdd = checkPermission(AI_GALLERY_CATEGORY_ALIAS, "can_add");
    $isAiGalleryCategoryView = checkPermission(AI_GALLERY_CATEGORY_ALIAS, "can_view");
    $isAiGalleryCategoryEdit = checkPermission(AI_GALLERY_CATEGORY_ALIAS, "can_edit");
    $isAiGalleryCategoryDelete = checkPermission(AI_GALLERY_CATEGORY_ALIAS, "can_delete");
    $isAiGalleryCategoryPublishEdit = checkPermission(AI_GALLERY_CATEGORY_PUBLISH_ALIAS, "can_edit");
    $isAiGalleryCategoryUnpublishEdit = checkPermission(AI_GALLERY_CATEGORY_UNPUBLISH_ALIAS, "can_edit");
    $isAiGalleryImageView = checkPermission(AI_GALLERY_IMAGE_ALIAS, "can_view");
    
    $sessionAiGalleryCategory = $this->session->userdata('session_ai_gallery_category');
    $sessionAiGalleryCategoryStatus = $this->session->userdata('session_ai_gallery_category_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">AI Gallery Category</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAiGalleryCategoryView){ ?>
                            <p><?php echo "You have total $countAiGalleryCategory ai gallery categories."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-ai-gallery-category" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAiGalleryCategoryView){ ?>
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-ai-gallery-category" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Ai Category</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_ai_gallery_category_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryCategoryStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryCategoryStatus == 'publish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="publish"<?php echo $str; ?>>Publish</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiGalleryCategoryStatus == 'unpublish')){
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
                                <?php if($isAiGalleryCategoryAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-ai-gallery-category" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAiGalleryCategoryView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_ai_gallery_category" value="<?php if(!empty($sessionAiGalleryCategory)){ echo $sessionAiGalleryCategory; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_ai_gallery_category_delete'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_ai_gallery_category_delete');?> <a href="<?php echo base_url('view-ai-gallery-image');?>" class="alert-link">Ai Gallery Image</a> <?php echo $this->session->unset_userdata('session_ai_gallery_category_delete');?>
            </div>
        <?php } ?>
        
        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table table-tranx">
                                <thead>
                                    <tr class="tb-tnx-head">
                                        <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Icon</span></th>
                                        <th class="nk-tb-col" width="35%"><span>Name</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Position</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Image</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="15%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if($isAiGalleryCategoryView){ ?>
                                    <?php if(!empty($viewAiGalleryCategory)){ ?>
                                        <tbody>
                                            <?php foreach($viewAiGalleryCategory as $data){ ?>
                                            <tr class="tb-tnx-item">
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['category_id']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><a class="gallery-image popup-image" href="<?php echo $data['category_icon']; ?>">
                                                        <img src="<?php echo $data['category_icon']; ?>" alt="" width="60" height="60">
                                                    </a></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['category_name']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['category_position']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['countAiGalleryImage']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                   <span><?php 
                                                        $categoryStatus = '';
                                                        if($data['category_status'] == 'publish'){
                                                            $categoryStatus.= '<span class="tb-status text-success">Publish</span>';
                                                        } else if($data['category_status'] == 'unpublish'){
                                                            $categoryStatus.= '<span class="tb-status text-danger">Unpublish</span>';
                                                        } 
                                                        echo $categoryStatus; 
                                                    ?></span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <?php if($data['category_status'] == "publish"){ ?>
                                                            <?php if($isAiGalleryCategoryUnpublishEdit){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#unpublishModal<?php echo urlEncodes($data['category_id']);?>" class="btn btn-trigger btn-icon text-danger" data-toggle="tooltip" data-placement="top" title="Unpublish">
                                                                        <em class="icon ni ni-cross-round-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <?php if($isAiGalleryCategoryPublishEdit){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#publishModal<?php echo urlEncodes($data['category_id']);?>" class="btn btn-trigger btn-icon text-success" data-toggle="tooltip" data-placement="top" title="Publish">
                                                                        <em class="icon ni ni-check-round-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php if($isAiGalleryImageView){ ?>
                                                            <li class="nk-tb-action">
                                                                <a href="<?php echo base_url(); ?>view-ai-gallery-category-image/<?php echo urlEncodes($data['category_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                    <em class="icon ni ni-eye-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if($isAiGalleryCategoryEdit){ ?>
                                                            <li class="nk-tb-action">
                                                                <a href="<?php echo base_url(); ?>edit-ai-gallery-category/<?php echo urlEncodes($data['category_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                    <em class="icon ni ni-edit-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if($isAiGalleryCategoryDelete){ ?>
                                                            <li class="nk-tb-action">
                                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['category_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                    <em class="icon ni ni-trash-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <div class="modal fade" tabindex="-1" id="unpublishModal<?php echo urlEncodes($data['category_id']);?>">
                                                <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ai Gallery Category</h5>
                                                            <a href="<?php echo base_url(); ?>view-ai-gallery-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to unpublish <?php echo $data['category_name'];?>?</p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><a href="<?php echo base_url(); ?>ai-gallery-category-status/<?php echo urlEncodes($data['category_id']); ?>" class="btn btn-sm btn-danger">Unpublish</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" tabindex="-1" id="publishModal<?php echo urlEncodes($data['category_id']);?>">
                                                <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ai Gallery Category</h5>
                                                            <a href="<?php echo base_url(); ?>view-ai-gallery-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to publish <?php echo $data['category_name'];?>?</p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><a href="<?php echo base_url(); ?>ai-gallery-category-status/<?php echo urlEncodes($data['category_id']); ?>" class="btn btn-sm btn-success">Publish</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['category_id']);?>">
                                                <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ai Gallery Category</h5>
                                                            <a href="<?php echo base_url(); ?>view-ai-gallery-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete <?php echo $data['category_name'];?>?</p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><a href="<?php echo base_url(); ?>delete-ai-gallery-category/<?php echo urlEncodes($data['category_id']); ?>" class="btn btn-sm btn-danger">Delete</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </tbody>
                                    <?php } else { ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">No data available in table</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <div class="nk-block-content text-center p-3">
                                                    <span class="sub-text">You don't have permission to show the ai gallery category's data</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($isAiGalleryCategoryView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
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
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-ai-gallery-category'); ?>',
            type: 'POST',
            data: { search_ai_gallery_category_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>