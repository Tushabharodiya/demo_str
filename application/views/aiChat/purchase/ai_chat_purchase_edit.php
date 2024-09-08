<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Ai Chat Purchase</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Ai Chat Purchase</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-ai-chat-purchase" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="purchase_package">Purchase Package *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="purchase_package" value="<?php echo $aiChatPurchase['purchase_package']; ?>" placeholder="Enter purchase package" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="purchase_order_id">Purchase Order Id *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="purchase_order_id" value="<?php echo $aiChatPurchase['purchase_order_id']; ?>" placeholder="Enter purchase order id" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="purchase_product_id">Purchase Product Id *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="purchase_product_id" value="<?php echo $aiChatPurchase['purchase_product_id']; ?>" placeholder="Enter purchase product id" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="purchase_state">Purchase State *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="purchase_state" value="<?php echo $aiChatPurchase['purchase_state']; ?>" placeholder="Enter purchase state" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="purchase_acknowledged">Purchase Acknowledged *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="purchase_acknowledged" data-placeholder="Select a status" required>
                                        <option value="true"<?php if($aiChatPurchase['purchase_acknowledged'] =="true"){ echo "selected"; } else { echo ""; } ?>>True</option>
                                        <option value="false"<?php if($aiChatPurchase['purchase_acknowledged'] =="false"){ echo "selected"; } else { echo ""; } ?>>False</option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="submit" value="Update">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>