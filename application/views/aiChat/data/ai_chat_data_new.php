<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Ai Chat Data</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Ai Chat Data</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-ai-chat-data" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="sub_category_id">Sub Category Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="sub_category_id" data-placeholder="Select a category" data-search="on" required>
                                        <option label="empty" value=""></option>
                                        <?php if(!empty($aiChatSubCategoryData)){ ?>
                                            <?php foreach($aiChatSubCategoryData as $data){ ?>
                                                <option value="<?php echo $data['sub_category_identifier_name']; ?>"><?php echo $data['sub_category_identifier_name']; ?></option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Empty</option>
                                        <?php }  ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_title">Data Title *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data_title" placeholder="Enter data title" required>
                                    <span class="text-danger"><?php if(!empty($this->session->userdata('session_ai_chat_data_new_data_title'))){ ?> <?php echo $this->session->userdata('session_ai_chat_data_new_data_title'); ?> <?php echo $this->session->unset_userdata('session_ai_chat_data_new_data_title'); ?> <?php } ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_prompt">Data Prompt *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data_prompt" placeholder="Enter data prompt" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_note">Data Note *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data_note" placeholder="Enter data note" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_status">Data Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="data_status" data-placeholder="Select a status" required>
                                        <option value="unpublish">Unpublish</option>
                                        <option value="publish">Publish</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary submitButton" name="submit" value="Save Informations">
                                <div class="loadingButton">
                                    <button class="btn btn-primary" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span>Save Informations</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<script>
	setTimeout(function() {
	    $('.text-danger').fadeOut('fast');
	}, 2000); 
</script>

<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        const form = this;
        if (form.checkValidity()) {
            document.querySelector('.submitButton').style.display = 'none';
            document.querySelector('.loadingButton').style.display = 'block';
        } else {
            event.preventDefault();
        }
    });
</script>