<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Privacy Policy</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Privacy Policy</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-privacy-policy" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_name">App Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="app_name" value="<?php echo $privacyPolicyData['app_name']; ?>" placeholder="Enter app name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_code">App Code *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="app_code" value="<?php echo $privacyPolicyData['app_code']; ?>" placeholder="Enter app code" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_privacy_slug">App Privacy Slug *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="app_privacy_slug" value="<?php echo $privacyPolicyData['app_privacy_slug']; ?>" placeholder="Enter app privacy slug" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_terms_slug">App Terms Slug *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="app_terms_slug" value="<?php echo $privacyPolicyData['app_terms_slug']; ?>" placeholder="Enter app code" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_privacy">App Privacy *</label>
                                <div class="form-control-wrap">
                                    <textarea type="text" class="tinymce-default form-control" name="app_privacy" placeholder="Enter app privacy" required><?php echo $privacyPolicyData['app_privacy']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="app_terms">App Terms *</label>
                                <div class="form-control-wrap">
                                    <textarea type="text" class="tinymce-default form-control" name="app_terms" placeholder="Enter app terms" required><?php echo $privacyPolicyData['app_terms']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="privacy_status">Privacy Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="privacy_status" data-placeholder="Select a status" required>
                                        <option value="publish"<?php if($privacyPolicyData['privacy_status'] =="publish"){ echo "selected"; } else { echo ""; } ?>>Publish</option> 
                                        <option value="unpublish"<?php if($privacyPolicyData['privacy_status'] =="unpublish"){ echo "selected"; } else { echo ""; } ?>>Unpublish</option>
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