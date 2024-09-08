<?php
    $isAiChatDataAdd = checkPermission(AI_CHAT_DATA_ALIAS, "can_add");
    $isAiChatDataView = checkPermission(AI_CHAT_DATA_ALIAS, "can_view");
    $isAiChatDataEdit = checkPermission(AI_CHAT_DATA_ALIAS, "can_edit");
    $isAiChatDataDelete = checkPermission(AI_CHAT_DATA_ALIAS, "can_delete");
    $isAiChatDataPublishEdit = checkPermission(AI_CHAT_DATA_PUBLISH_ALIAS, "can_edit");
    $isAiChatDataUnpublishEdit = checkPermission(AI_CHAT_DATA_UNPUBLISH_ALIAS, "can_edit");
    
    $sessionAiChatData = $this->session->userdata('session_ai_chat_data');
    $sessionAiChatDataStatus = $this->session->userdata('session_ai_chat_data_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">AI Chat Data</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAiChatDataView){ ?>
                            <p><?php echo "You have total $countAiChatData ai chat datas."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-ai-chat-data" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAiChatDataView){ ?>
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-ai-chat-data" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Ai Chat Data</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_ai_chat_data_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatDataStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatDataStatus == 'publish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="publish"<?php echo $str; ?>>Publish</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatDataStatus == 'unpublish')){
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
                                <?php if($isAiChatDataAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-ai-chat-data" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                                <?php if($isAiChatDataDelete){ ?>
                                    <li><a class="btn btn-white btn-outline-light submit-button" data-bs-toggle="modal" data-bs-target="#deleteModal"><span>Delete All</span></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAiChatDataView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_ai_chat_data" value="<?php if(!empty($sessionAiChatData)){ echo $sessionAiChatData; } ?>" placeholder="Search..." autocomplete="off">
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
            <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                <div class="modal fade" tabindex="-1" id="deleteModal">
                    <div class="modal-dialog modal-dialog-top" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ai Chat Data</h5>
                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <span class="text-danger checked-count">0</span> ai chat datas?</p>
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
                                            <th class="nk-tb-col" width="13%"><span>Category</span></th>
                                            <th class="nk-tb-col" width="13%"><span>Title</span></th>
                                            <th class="nk-tb-col" width="13%"><span>Prompt</span></th>
                                            <th class="nk-tb-col" width="13%"><span>Note</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Language</span></th>
                                            <th class="nk-tb-col" width="8%"><span>Position</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                            <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if($isAiChatDataView){ ?>
                                        <?php if(!empty($viewAiChatData)){ ?>
                                            <tbody>
                                                <?php foreach($viewAiChatData as $data){ ?>
                                                <tr class="tb-tnx-item">
                                                    <td class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input toggle-checkbox checkbox" id="<?php echo $data['data_id']; ?>" name="data_id[]" value="<?php echo $data['data_id']; ?>">
                                                            <label class="custom-control-label" for="<?php echo $data['data_id']; ?>"></label>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['data_id']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php 
                                                            $subCategoryName = $data['aiChatSubCategoryData']['sub_category_name'];
                                                            if(strlen($subCategoryName) > 13){
                                                                echo substr($subCategoryName, 0, 13);
                                                            } else {
                                                                echo $subCategoryName;
                                                            }
                                                        ?></span>
                                                        <?php if(strlen($subCategoryName) > 13){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#modalSubNameZoom<?php echo $data['data_id'];?>" class="sub-text text-primary">Read More</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php 
                                                            $dataTitle = $data['data_title'];
                                                            if(strlen($dataTitle) > 13){
                                                                echo substr($dataTitle, 0, 13);
                                                            } else {
                                                                echo $dataTitle;
                                                            }
                                                        ?></span>
                                                        <?php if(strlen($dataTitle) > 13){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#modalTitleZoom<?php echo $data['data_id'];?>" class="sub-text text-primary">Read More</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php 
                                                            $dataPrompt = $data['data_prompt'];
                                                            if(strlen($dataPrompt) > 13){
                                                                echo substr($dataPrompt, 0, 13);
                                                            } else {
                                                                echo $dataPrompt;
                                                            }
                                                        ?></span>
                                                        <?php if(strlen($dataPrompt) > 13){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#modalPromptZoom<?php echo $data['data_id'];?>" class="sub-text text-primary">Read More</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php 
                                                            $dataNote = $data['data_note'];
                                                            if(strlen($dataNote) > 13){
                                                                echo substr($dataNote, 0, 13);
                                                            } else {
                                                                echo $dataNote;
                                                            }
                                                        ?></span>
                                                        <?php if(strlen($dataNote) > 13){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#modalNoteZoom<?php echo $data['data_id'];?>" class="sub-text text-primary">Read More</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['aiChatLanguageData']['language_name']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['data_position']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                       <span><?php 
                                                            $dataStatus = '';
                                                            if($data['data_status'] == 'publish'){
                                                                $dataStatus.= '<span class="tb-status text-success">Publish</span>';
                                                            } else if($data['data_status'] == 'unpublish'){
                                                                $dataStatus.= '<span class="tb-status text-danger">Unpublish</span>';
                                                            } 
                                                            echo $dataStatus; 
                                                        ?></span>
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <?php if($data['data_status'] == "publish"){ ?>
                                                                <?php if($isAiChatDataPublishEdit){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#unpublishModal<?php echo urlEncodes($data['data_id']);?>" class="btn btn-trigger btn-icon text-danger" data-toggle="tooltip" data-placement="top" title="Unpublish">
                                                                            <em class="icon ni ni-cross-round-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <?php if($isAiChatDataUnpublishEdit){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#publishModal<?php echo urlEncodes($data['data_id']);?>" class="btn btn-trigger btn-icon text-success" data-toggle="tooltip" data-placement="top" title="Publish">
                                                                            <em class="icon ni ni-check-round-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <?php if($isAiChatDataEdit){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a href="<?php echo base_url(); ?>edit-ai-chat-data/<?php echo urlEncodes($data['data_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                        <em class="icon ni ni-edit-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if($isAiChatDataDelete){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['data_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <em class="icon ni ni-trash-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <div class="modal fade zoom" tabindex="-1" id="modalSubNameZoom<?php echo $data['data_id'];?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['data_id'];?></h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $data['aiChatSubCategoryData']['sub_category_name'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['data_status'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade zoom" tabindex="-1" id="modalTitleZoom<?php echo $data['data_id'];?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['data_id'];?></h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $data['data_title'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['data_status'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade zoom" tabindex="-1" id="modalPromptZoom<?php echo $data['data_id'];?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['data_id'];?></h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $data['data_prompt'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['data_status'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade zoom" tabindex="-1" id="modalNoteZoom<?php echo $data['data_id'];?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['data_id'];?></h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $data['data_note'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['data_status'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="unpublishModal<?php echo urlEncodes($data['data_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ai Chat Data</h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to unpublish this ai chat data?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>ai-chat-data-status/<?php echo urlEncodes($data['data_id']); ?>" class="btn btn-sm btn-danger">Unpublish</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="publishModal<?php echo urlEncodes($data['data_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ai Chat Data</h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to publish this ai chat data?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>ai-chat-data-status/<?php echo urlEncodes($data['data_id']); ?>" class="btn btn-sm btn-success">Publish</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['data_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ai Chat Data</h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-data" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this ai chat data?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>delete-ai-chat-data/<?php echo urlEncodes($data['data_id']); ?>" class="btn btn-sm btn-danger">Delete</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </tbody>
                                        <?php } else { ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="10">
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
                                                <td colspan="10">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">You don't have permission to show the ai chat data's data</span>
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
                <?php if($isAiChatDataView){ ?>
                    <ul class="pagination justify-content-center justify-content-md-center mt-3">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                <?php } ?>
            </form>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-ai-chat-data'); ?>',
            type: 'POST',
            data: { search_ai_chat_data_status: selectedStatus },
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
        $('#myForm').attr('action', '<?= base_url('all-delete-ai-chat-data'); ?>/' + action);
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