<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Ai Chat Language</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Ai Chat Language</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-ai-chat-language" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="language_title">Language Title *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="language_title" value="<?php echo $aiChatLanguage['language_title']; ?>" placeholder="Enter language title" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="language_name">Language Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="language_name" value="<?php echo $aiChatLanguage['language_name']; ?>" placeholder="Enter language name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="language_code">Language Code *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="language_code" value="<?php echo $aiChatLanguage['language_code']; ?>" placeholder="Enter language code" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="language_status">Language Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="language_status" data-placeholder="Select a status" required>
                                        <option value="publish"<?php if($aiChatLanguage['language_status'] =="publish"){ echo "selected"; } else { echo ""; } ?>>Publish</option>
                                        <option value="unpublish"<?php if($aiChatLanguage['language_status'] =="unpublish"){ echo "selected"; } else { echo ""; } ?>>Unpublish</option> 
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