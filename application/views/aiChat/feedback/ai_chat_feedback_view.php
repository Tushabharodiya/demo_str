<?php
    $isAiChatFeedbackView = checkPermission(AI_CHAT_FEEDBACK_ALIAS, "can_view");
    $isAiChatFeedbackDelete = checkPermission(AI_CHAT_FEEDBACK_ALIAS, "can_delete");
    $isAiChatFeedbackPublishEdit = checkPermission(AI_CHAT_FEEDBACK_PUBLISH_ALIAS, "can_edit");
    $isAiChatFeedbackUnpublishEdit = checkPermission(AI_CHAT_FEEDBACK_UNPUBLISH_ALIAS, "can_edit");
    
    $sessionAiChatFeedback = $this->session->userdata('session_ai_chat_feedback');
    $sessionAiChatFeedbackStatus = $this->session->userdata('session_ai_chat_feedback_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">AI Chat Feedback</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAiChatFeedbackView){ ?>
                            <p><?php echo "You have total $countAiChatFeedback ai chat feedbacks."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-ai-chat-feedback" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAiChatFeedbackView){ ?>
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-ai-chat-feedback" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Ai Chat Feedback</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_ai_chat_feedback_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatFeedbackStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatFeedbackStatus == 'publish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="publish"<?php echo $str; ?>>Publish</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatFeedbackStatus == 'unpublish')){
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
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAiChatFeedbackView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_ai_chat_feedback" value="<?php if(!empty($sessionAiChatFeedback)){ echo $sessionAiChatFeedback; } ?>" placeholder="Search..." autocomplete="off">
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
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table table-tranx">
                                <thead>
                                    <tr class="tb-tnx-head">
                                        <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                        <th class="nk-tb-col" width="45%"><span>Message</span></th>
                                        <th class="nk-tb-col" width="15%"><span>Language</span></th>
                                        <th class="nk-tb-col" width="20%"><span>Date</span></th>
                                        <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if($isAiChatFeedbackView){ ?>
                                    <?php if(!empty($viewAiChatFeedback)){ ?>
                                        <tbody>
                                            <?php foreach($viewAiChatFeedback as $data){ ?>
                                            <tr class="tb-tnx-item">
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['feedback_id']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php 
                                                        $feedbackMessage = $data['feedback_message'];
                                                        if(strlen($feedbackMessage) > 70){
                                                            echo substr($feedbackMessage, 0, 70);
                                                        } else {
                                                            echo $feedbackMessage;
                                                        }
                                                    ?></span>
                                                    <?php if(strlen($feedbackMessage) > 70){ ?>
                                                        <a data-bs-toggle="modal" data-bs-target="#modalFeedbackZoom<?php echo $data['feedback_id'];?>" class="sub-text text-primary">Read More</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="title"><?php echo $data['feedback_language']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['feedback_date']; ?></span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <?php if($data['feedback_status'] == "publish"){ ?>
                                                            <?php if($isAiChatFeedbackUnpublishEdit){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#unpublishModal<?php echo urlEncodes($data['feedback_id']);?>" class="btn btn-trigger btn-icon text-danger" data-toggle="tooltip" data-placement="top" title="Unpublish">
                                                                        <em class="icon ni ni-cross-round-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <?php if($isAiChatFeedbackPublishEdit){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#publishModal<?php echo urlEncodes($data['feedback_id']);?>" class="btn btn-trigger btn-icon text-success" data-toggle="tooltip" data-placement="top" title="Publish">
                                                                        <em class="icon ni ni-check-round-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php if($isAiChatFeedbackDelete){ ?>
                                                            <li class="nk-tb-action">
                                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['feedback_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                    <em class="icon ni ni-trash-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <div class="modal fade zoom" tabindex="-1" id="modalFeedbackZoom<?php echo $data['feedback_id'];?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $data['feedback_id'];?></h5>
                                                            <a href="<?php echo base_url(); ?>view-ai-chat-feedback" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><?php echo $data['feedback_message'];?></p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><?php echo $data['feedback_status'];?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" tabindex="-1" id="unpublishModal<?php echo urlEncodes($data['feedback_id']);?>">
                                                <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ai Chat Feedback</h5>
                                                            <a href="<?php echo base_url(); ?>view-ai-chat-feedback" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to unpublish this ai chat feedback?</p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><a href="<?php echo base_url(); ?>ai-chat-feedback-status/<?php echo urlEncodes($data['feedback_id']); ?>" class="btn btn-sm btn-danger">Unpublish</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" tabindex="-1" id="publishModal<?php echo urlEncodes($data['feedback_id']);?>">
                                                <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ai Chat Feedback</h5>
                                                            <a href="<?php echo base_url(); ?>view-ai-chat-feedback" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to publish this ai chat feedback?</p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><a href="<?php echo base_url(); ?>ai-chat-feedback-status/<?php echo urlEncodes($data['feedback_id']); ?>" class="btn btn-sm btn-success">Publish</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['feedback_id']);?>">
                                                <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ai Chat Feedback</h5>
                                                            <a href="<?php echo base_url(); ?>view-ai-chat-feedback" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this ai chat feedback?</p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><a href="<?php echo base_url(); ?>delete-ai-chat-feedback/<?php echo urlEncodes($data['feedback_id']); ?>" class="btn btn-sm btn-danger">Delete</a></span>
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
                                                    <span class="sub-text">You don't have permission to show the ai chat feedback's data</span>
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
            <?php if($isAiChatFeedbackView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-ai-chat-feedback'); ?>',
            type: 'POST',
            data: { search_ai_chat_feedback_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>