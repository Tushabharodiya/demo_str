<?php
    $isAiChatPurchaseView = checkPermission(AI_CHAT_PURCHASE_ALIAS, "can_view");
    $isAiChatPurchaseEdit = checkPermission(AI_CHAT_PURCHASE_ALIAS, "can_edit");
    $isAiChatPurchaseDelete = checkPermission(AI_CHAT_PURCHASE_ALIAS, "can_delete");

    $sessionAiChatPurchase = $this->session->userdata('session_ai_chat_purchase');
    $sessionAiChatPurchaseAcknowledged = $this->session->userdata('session_ai_chat_purchase_acknowledged');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">AI Chat Purchase</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAiChatPurchaseView){ ?>
                            <p><?php echo "You have total $countAiChatPurchase ai chat purchases."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-ai-chat-purchase" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAiChatPurchaseView){ ?>
                                    <li>
                                        <div class="dropdown">
                                            <a href="<?php echo base_url(); ?>view-ai-chat-purchase" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Ai Chat Purchase</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-acknowledged" name="search_ai_chat_purchase_acknowledged" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatPurchaseAcknowledged == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatPurchaseAcknowledged == 'true')){
                                                                            $str.='selected';
                                                                    } ?> <option value="true"<?php echo $str; ?>>True</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAiChatPurchaseAcknowledged == 'false')){
                                                                            $str.='selected';
                                                                    } ?> <option value="false"<?php echo $str; ?>>False</option>
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
                                    <?php if($isAiChatPurchaseDelete){ ?>
                                        <li><a class="btn btn-white btn-outline-light submit-button" data-bs-toggle="modal" data-bs-target="#deleteModal"><span>Delete All</span></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAiChatPurchaseView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_ai_chat_purchase" value="<?php if(!empty($sessionAiChatPurchase)){ echo $sessionAiChatPurchase; } ?>" placeholder="Search..." autocomplete="off">
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
                                <h5 class="modal-title">Ai Chat Purchase</h5>
                                <a href="<?php echo base_url(); ?>view-ai-chat-purchase" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <span class="text-danger checked-count">0</span> ai chat purchases?</p>
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
                                            <th class="nk-tb-col" width="9%"><span>ID</span></th>
                                            <th class="nk-tb-col" width="22%"><span>Package</span></th>
                                            <th class="nk-tb-col" width="22%"><span>Order</span></th>
                                            <th class="nk-tb-col" width="17%"><span>Product</span></th>
                                            <th class="nk-tb-col" width="7%"><span>State</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Time</span></th>
                                            <th class="nk-tb-col text-end" width="13%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if($isAiChatPurchaseView){ ?>
                                        <?php if(!empty($viewAiChatPurchase)){ ?>
                                            <tbody>
                                                <?php foreach($viewAiChatPurchase as $data){ ?>
                                                <tr class="tb-tnx-item">
                                                    <td class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input toggle-checkbox checkbox" id="<?php echo $data['purchase_id']; ?>" name="purchase_id[]" value="<?php echo $data['purchase_id']; ?>">
                                                            <label class="custom-control-label" for="<?php echo $data['purchase_id']; ?>"></label>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['purchase_id']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['purchase_package']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['purchase_order_id']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['purchase_product_id']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['purchase_state']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['purchase_time']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <?php if($isAiChatPurchaseView){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#modalZoom<?php echo urlEncodes($data['purchase_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Quick View">
                                                                        <em class="icon ni ni-focus"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if($isAiChatPurchaseEdit){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a href="<?php echo base_url(); ?>edit-ai-chat-purchase/<?php echo urlEncodes($data['purchase_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                        <em class="icon ni ni-edit-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if($isAiChatPurchaseDelete){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['purchase_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <em class="icon ni ni-trash-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <div class="modal fade zoom" tabindex="-1" id="modalZoom<?php echo urlEncodes($data['purchase_id']);?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['purchase_id'];?></h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-purchase" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><b>Token : </b><?php echo $data['purchase_token'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['purchase_acknowledged'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['purchase_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ai Chat Purchase</h5>
                                                                <a href="<?php echo base_url(); ?>view-ai-chat-purchase" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this ai chat purchase?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>delete-ai-chat-purchase/<?php echo urlEncodes($data['purchase_id']); ?>" class="btn btn-sm btn-danger">Delete</a></span>
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
                                                        <span class="sub-text">You don't have permission to show the ai chat purchase's data</span>
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
                <?php if($isAiChatPurchaseView){ ?>
                    <ul class="pagination justify-content-center justify-content-md-center mt-3">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                <?php } ?>
            </form>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-acknowledged').addEventListener('change', function() {
        var selectedAcknowledged = this.value;
        $.ajax({
            url: '<?= base_url('view-ai-chat-purchase'); ?>',
            type: 'POST',
            data: { search_ai_chat_purchase_acknowledged: selectedAcknowledged },
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
        $('#myForm').attr('action', '<?= base_url('all-delete-ai-chat-purchase'); ?>/' + action);
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