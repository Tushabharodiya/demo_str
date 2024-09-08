<?php
    $isAiChatMainCategoryAdd = checkPermission(AI_CHAT_MAIN_CATEGORY_ALIAS, "can_add");
    $isAiChatMainCategoryView = checkPermission(AI_CHAT_MAIN_CATEGORY_ALIAS, "can_view");
    $isAiChatMainCategoryEdit = checkPermission(AI_CHAT_MAIN_CATEGORY_ALIAS, "can_edit");
    $isAiChatMainCategoryDelete = checkPermission(AI_CHAT_MAIN_CATEGORY_ALIAS, "can_delete");
    $isAiChatMainCategoryPublishEdit = checkPermission(AI_CHAT_MAIN_CATEGORY_PUBLISH_ALIAS, "can_edit");
    $isAiChatMainCategoryUnpublishEdit = checkPermission(AI_CHAT_MAIN_CATEGORY_UNPUBLISH_ALIAS, "can_edit");
    $isAiChatSubCategoryView = checkPermission(AI_CHAT_SUB_CATEGORY_ALIAS, "can_view");
    
    $sessionAiChatMainCategory = $this->session->userdata('session_ai_chat_main_category');
    $sessionAiChatMainCategoryStatus = $this->session->userdata('session_ai_chat_main_category_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">AI Chat Main Category</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAiChatMainCategoryView){ ?>
                            <p><?php echo "You have total $countAiChatMainCategory ai chat main categories."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAiChatMainCategoryView){ ?>
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Ai Chat Main Category</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_ai_chat_main_category_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatMainCategoryStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatMainCategoryStatus == 'publish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="publish"<?php echo $str; ?>>Publish</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatMainCategoryStatus == 'unpublish')){
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
                                <?php if($isAiChatMainCategoryAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-ai-chat-main-category" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                                <?php if($isAiChatMainCategoryDelete){ ?>
                                    <li><a class="btn btn-white btn-outline-light submit-button" data-bs-toggle="modal" data-bs-target="#deleteModal"><span>Delete All</span></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAiChatMainCategoryView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_ai_chat_main_category" value="<?php if(!empty($sessionAiChatMainCategory)){ echo $sessionAiChatMainCategory; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_ai_chat_main_category_delete'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_ai_chat_main_category_delete');?> <a href="<?php echo base_url('view-ai-chat-sub-category');?>" class="alert-link">Ai Chat Sub Category</a> <?php echo $this->session->unset_userdata('session_ai_chat_main_category_delete');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_all_ai_chat_main_category_delete'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_all_ai_chat_main_category_delete');?> <a href="<?php echo base_url('view-ai-chat-sub-category');?>" class="alert-link">Ai Chat Sub Category</a> <?php echo $this->session->unset_userdata('session_all_ai_chat_main_category_delete');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_ai_chat_main_category_new'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_ai_chat_main_category_new');?> <a href="<?php echo base_url('view-ai-chat-language');?>" class="alert-link">Ai chat Language</a> <?php echo $this->session->unset_userdata('session_ai_chat_main_category_new');?>
            </div>
        <?php } ?>
        
        <div class="nk-block">
            <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                <div class="modal fade" tabindex="-1" id="deleteModal">
                    <div class="modal-dialog modal-dialog-top" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ai Chat Main Category</h5>
                                <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <span class="text-danger checked-count">0</span> ai chat main categories?</p>
                            </div>
                            <div class="modal-footer bg-light">
                                <span class="sub-text"><input type="submit" class="btn btn-sm btn-danger" id="submit" name="submit" value="Delete All" onclick="submitForm('delete')"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-bordered card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner p-0">
                            <div class="table-responsive">
                                <table class="table table-tranx">
                                    <thead>
                                        <tr class="tb-tnx-head">
                                            <th class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input toggle-checkbox" id="select_all">
                                                    <label class="custom-control-label" for="select_all"></label>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Icon</span></th>
                                            <th class="nk-tb-col" width="15%"><span>Name</span></th>
                                            <th class="nk-tb-col" width="15%"><span>Title</span></th>
                                            <th class="nk-tb-col" width="20%"><span>Description</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Language</span></th>
                                            <th class="nk-tb-col" width="5%"><span>Category</span></th>
                                            <th class="nk-tb-col text-end" width="15%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if($isAiChatMainCategoryView){ ?>
                                        <?php if(!empty($viewAiChatMainCategory)){ ?>
                                            <tbody>
                                                <?php foreach($viewAiChatMainCategory as $data){ ?>
                                                <tr class="tb-tnx-item">
                                                    <td class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input toggle-checkbox checkbox" id="<?php echo $data['main_category_id']; ?>" name="main_category_id[]" value="<?php echo $data['main_category_id']; ?>">
                                                            <label class="custom-control-label" for="<?php echo $data['main_category_id']; ?>"></label>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['main_category_id']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><a class="gallery-image popup-image" href="<?php echo $data['main_category_icon']; ?>">
                                                            <img src="<?php echo $data['main_category_icon']; ?>" alt="" width="60" height="60">
                                                        </a></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php 
                                                            $mainCategoryName = $data['main_category_name'];
                                                            if(strlen($mainCategoryName) > 20){
                                                                echo substr($mainCategoryName, 0, 20);
                                                            } else {
                                                                echo $mainCategoryName;
                                                            }
                                                        ?></span>
                                                        <?php if(strlen($mainCategoryName) > 20){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#modalNameZoom<?php echo $data['main_category_id'];?>" class="sub-text text-primary">Read More</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php 
                                                            $mainCategoryTitle = $data['main_category_title'];
                                                            if(strlen($mainCategoryTitle) > 20){
                                                                echo substr($mainCategoryTitle, 0, 20);
                                                            } else {
                                                                echo $mainCategoryTitle;
                                                            }
                                                        ?></span>
                                                        <?php if(strlen($mainCategoryTitle) > 20){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#modalTitleZoom<?php echo $data['main_category_id'];?>" class="sub-text text-primary">Read More</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php 
                                                            $mainCategoryDescription = $data['main_category_description'];
                                                            if(strlen($mainCategoryDescription) > 20){
                                                                echo substr($mainCategoryDescription, 0, 20);
                                                            } else {
                                                                echo $mainCategoryDescription;
                                                            }
                                                        ?></span>
                                                        <?php if(strlen($mainCategoryDescription) > 20){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#modalDescriptionZoom<?php echo $data['main_category_id'];?>" class="sub-text text-primary">Read More</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['aiChatLanguageData']['language_name']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['countAiChatSubCategory']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <?php if($data['main_category_status'] == "publish"){ ?>
                                                                <?php if($isAiChatMainCategoryUnpublishEdit){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#unpublishModal<?php echo urlEncodes($data['main_category_id']);?>" class="btn btn-trigger btn-icon text-danger" data-toggle="tooltip" data-placement="top" title="Unpublish">
                                                                            <em class="icon ni ni-cross-round-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <?php if($isAiChatMainCategoryPublishEdit){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#publishModal<?php echo urlEncodes($data['main_category_id']);?>" class="btn btn-trigger btn-icon text-success" data-toggle="tooltip" data-placement="top" title="Publish">
                                                                            <em class="icon ni ni-check-round-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <?php if($isAiChatSubCategoryView){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a href="<?php echo base_url(); ?>view-ai-chat-sub-categories/<?php echo urlEncodes($data['main_category_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                        <em class="icon ni ni-eye-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if($isAiChatMainCategoryEdit){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a href="<?php echo base_url(); ?>edit-ai-chat-main-category/<?php echo urlEncodes($data['main_category_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                        <em class="icon ni ni-edit-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if($isAiChatMainCategoryDelete){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['main_category_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <em class="icon ni ni-trash-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <div class="modal fade zoom" tabindex="-1" id="modalNameZoom<?php echo $data['main_category_id'];?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['main_category_id'];?></h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $data['main_category_name'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['main_category_status'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade zoom" tabindex="-1" id="modalTitleZoom<?php echo $data['main_category_id'];?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['main_category_id'];?></h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $data['main_category_title'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['main_category_status'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade zoom" tabindex="-1" id="modalDescriptionZoom<?php echo $data['main_category_id'];?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['main_category_id'];?></h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $data['main_category_description'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['main_category_status'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="unpublishModal<?php echo urlEncodes($data['main_category_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ai Chat Main Category</h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to unpublish <?php echo $data['main_category_name'];?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>ai-chat-main-category-status/<?php echo urlEncodes($data['main_category_id']); ?>" class="btn btn-sm btn-danger">Unpublish</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="publishModal<?php echo urlEncodes($data['main_category_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ai Chat Main Category</h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to publish <?php echo $data['main_category_name'];?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>ai-chat-main-category-status/<?php echo urlEncodes($data['main_category_id']); ?>" class="btn btn-sm btn-success">Publish</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['main_category_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ai Chat Main Category</h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-main-category" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete <?php echo $data['main_category_name'];?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>delete-ai-chat-main-category/<?php echo urlEncodes($data['main_category_id']); ?>" class="btn btn-sm btn-danger">Delete</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </tbody>
                                        <?php } else { ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="9">
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
                                                <td colspan="9">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">You don't have permission to show the ai chat main category's data</span>
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
                <?php if($isAiChatMainCategoryView){ ?>
                    <ul class="pagination justify-content-center justify-content-md-center mt-3">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                <?php } ?>
            </form>
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
            url: '<?= base_url('view-ai-chat-main-category'); ?>',
            type: 'POST',
            data: { search_ai_chat_main_category_status: selectedStatus },
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
        $('#myForm').attr('action', '<?= base_url('all-delete-ai-chat-main-category'); ?>/' + action);
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