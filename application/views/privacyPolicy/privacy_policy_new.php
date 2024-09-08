<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Privacy Policy</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Privacy Policy</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-privacy-policy" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_name">App Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="app_name" placeholder="Enter app name" required>
                                    <span class="text-danger"><?php if(!empty($this->session->userdata('session_privacy_policy_new_app_name'))){ ?> <?php echo $this->session->userdata('session_privacy_policy_new_app_name'); ?> <?php echo $this->session->unset_userdata('session_privacy_policy_new_app_name'); ?> <?php } ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_code">App Code *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="app_code" placeholder="Enter app code" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_privacy_slug">App Privacy Slug *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="app_privacy_slug" placeholder="Enter app privacy slug" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_terms_slug">App Terms Slug *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="app_terms_slug" placeholder="Enter app terms slug" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_privacy">App Privacy *</label>
                                <div class="form-control-wrap">
                                    <textarea type="text" class="tinymce-default form-control" name="app_privacy" placeholder="Enter app privacy" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_terms">App Terms *</label>
                                <div class="form-control-wrap">
                                    <textarea type="text" class="tinymce-default form-control" name="app_terms" placeholder="Enter app terms" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="privacy_status">Privacy Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="privacy_status" data-placeholder="Select a status" required>
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