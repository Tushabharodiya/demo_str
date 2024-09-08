<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Applock Data</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Applock Data</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-applock-data" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="category_id">Category Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="category_id" data-placeholder="Select a category" data-search="on" required>
                                        <?php foreach($viewApplockCategory as $data){
                                            $selected = $data['category_id'] == $applockCategoryData['category_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['category_id'].'" '.$selected.'>'.$data['category_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="applock_name">Applock Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="applock_name" value="<?php echo $applockData['applock_name']; ?>" placeholder="Enter applock name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="applock_thumbnail">Applock Thumbnail *</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-control form-file-input" id="file-uploader-thumbnail" name="applock_thumbnail" value="<?php echo $applockData['applock_thumbnail']; ?>">
                                        <label class="form-file-label" for="applock_thumbnail">Choose file</label>
                                        <div id="feedback-thumbnail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="applock_bundle">Applock Bundle *</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-control form-file-input" id="file-uploader-bundle" name="applock_bundle" value="<?php echo $applockData['applock_bundle']; ?>">
                                        <label class="form-file-label" for="applock_bundle">Choose file</label>
                                        <div id="feedback-bundle"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="applock_type">Applock Type *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="applock_type" data-placeholder="Select a type" required>
                                        <option value="pin"<?php if($applockData['applock_type'] =="pin"){ echo "selected"; } else { echo ""; } ?>>Pin</option> 
                                        <option value="pattern"<?php if($applockData['applock_type'] =="pattern"){ echo "selected"; } else { echo ""; } ?>>Pattern</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="is_premium">Is Premium *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="is_premium" data-placeholder="Select a premium" required>
                                        <option value="true"<?php if($applockData['is_premium'] =="true"){ echo "selected"; } else { echo ""; } ?>>True</option>
                                        <option value="false"<?php if($applockData['is_premium'] =="false"){ echo "selected"; } else { echo ""; } ?>>False</option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="applock_status">Applock Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="applock_status" data-placeholder="Select a status" required>
                                        <option value="publish"<?php if($applockData['applock_status'] =="publish"){ echo "selected"; } else { echo ""; } ?>>Publish</option>
                                        <option value="unpublish"<?php if($applockData['applock_status'] =="unpublish"){ echo "selected"; } else { echo ""; } ?>>Unpublish</option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" id="submit-button" name="submit" value="Update">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<script>
    const fileUploaderThumbnail = document.getElementById('file-uploader-thumbnail');
    const feedbackThumbnail = document.getElementById('feedback-thumbnail');
    const submitButton = document.getElementById('submit-button');

    fileUploaderThumbnail.addEventListener('change', (event) => {
        const file = event.target.files[0];
    
        if (file) {
            
            if (file.type !== 'image/png') {
                feedbackThumbnail.innerHTML = `<span style="color:red;">Please upload a PNG image. </span>`;
                return;
            }
            
            const img = new Image();
            img.src = URL.createObjectURL(file);
    
            img.onload = function () {
                const width = this.width;
                const height = this.height;
    
                let msg = '';
    
                if (width === 360 && height === 640) {
                    msg = `<span style="color:green;">The image size is 360x640. </span>`;
                    submitButton.style.display = 'block';
                } else {
                    msg = `<span style="color:red;">The image size should be 360x640. Actual size is ${width}x${height}. </span>`;
                    submitButton.style.display = 'none';
                }
    
                feedbackThumbnail.innerHTML = msg;
            };
        }
    });
</script>

<script>
    const fileUploaderBundle = document.getElementById('file-uploader-bundle');
    const feedbackBundle = document.getElementById('feedback-bundle');

    fileUploaderBundle.addEventListener('change', (event) => {
        const file = event.target.files[0];
    
        if (file) {
            
            if (file.type !== 'application/x-zip-compressed') {
                feedbackBundle.innerHTML = `<span style="color:red;">Please upload a Zip file. </span>`;
                return;
            } else {
                feedbackBundle.innerHTML = `<span style="color:green;">The file is a Zip file. </span>`;
                return;
            }
        }
    });
</script>