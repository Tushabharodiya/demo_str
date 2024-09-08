<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Ai Chat Data</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Ai Chat Data - <?php echo $aiChatLanguageData['language_name']; ?></p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-ai-chat-data" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="sub_category_id">Sub Category Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="sub_category_id" data-placeholder="Select a category" data-search="on" required>
                                        <?php foreach($viewAiChatSubCategory as $data){
                                            $selected = $data['sub_category_id'] == $aiChatSubCategoryData['sub_category_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['sub_category_id'].'" '.$selected.'>'.$data['sub_category_name'].' - '.$data['language_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_title">Data Title *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data_title" value="<?php echo $aiChatData['data_title']; ?>" placeholder="Enter data title" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_prompt">Data Prompt *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data_prompt" value="<?php echo $aiChatData['data_prompt']; ?>" placeholder="Enter data prompt" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_note">Data Note *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data_note" value="<?php echo $aiChatData['data_note']; ?>" placeholder="Enter data note" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_position">Data Position *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="data_position" value="<?php echo $aiChatData['data_position']; ?>" placeholder="Enter data position" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_status">Data Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="data_status" data-placeholder="Select a status" required>
                                        <option value="publish"<?php if($aiChatData['data_status'] =="publish"){ echo "selected"; } else { echo ""; } ?>>Publish</option>
                                        <option value="unpublish"<?php if($aiChatData['data_status'] =="unpublish"){ echo "selected"; } else { echo ""; } ?>>Unpublish</option> 
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