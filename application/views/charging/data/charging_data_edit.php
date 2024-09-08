<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Charging Data</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Charging Data</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-charging-data" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                                        <?php foreach($viewChargingCategory as $data){
                                            $selected = $data['category_id'] == $chargingCategoryData['category_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['category_id'].'" '.$selected.'>'.$data['category_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="charging_name">Charging Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="charging_name" value="<?php echo $chargingData['charging_name']; ?>" placeholder="Enter charging name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="charging_thumbnail">Charging Thumbnail *</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-control form-file-input" id="file-uploader-thumbnail" name="charging_thumbnail" value="<?php echo $chargingData['charging_thumbnail']; ?>">
                                        <label class="form-file-label" for="charging_thumbnail">Choose file</label>
                                        <div id="feedback-thumbnail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="charging_bundle">Charging Bundle *</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-control form-file-input" id="file-uploader-bundle" name="charging_bundle" value="<?php echo $chargingData['charging_bundle']; ?>">
                                        <label class="form-file-label" for="charging_bundle">Choose file</label>
                                        <div id="feedback-bundle"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="charging_type">Charging Type *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="charging_type" data-placeholder="Select a type" required>
                                        <option value="animation"<?php if($chargingData['charging_type'] =="animation"){ echo "selected"; } else { echo ""; } ?>>Animation</option> 
                                        <option value="video"<?php if($chargingData['charging_type'] =="video"){ echo "selected"; } else { echo ""; } ?>>Video</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="thumbnail_type">Thumbnail Type *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="thumbnail_type" data-placeholder="Select a type" required>
                                        <option value="png"<?php if($chargingData['thumbnail_type'] =="png"){ echo "selected"; } else { echo ""; } ?>>Png</option> 
                                        <option value="json"<?php if($chargingData['thumbnail_type'] =="json"){ echo "selected"; } else { echo ""; } ?>>Json</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="is_premium">Is Premium *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="is_premium" data-placeholder="Select a premium" required>
                                        <option value="true"<?php if($chargingData['is_premium'] =="true"){ echo "selected"; } else { echo ""; } ?>>True</option> 
                                        <option value="false"<?php if($chargingData['is_premium'] =="false"){ echo "selected"; } else { echo ""; } ?>>False</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label class="form-label" for="is_music">Is Music *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="is_music" data-placeholder="Select a music" required>
                                        <option value="true"<?php if($chargingData['is_music'] =="true"){ echo "selected"; } else { echo ""; } ?>>True</option> 
                                        <option value="false"<?php if($chargingData['is_music'] =="false"){ echo "selected"; } else { echo ""; } ?>>False</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="charging_status">Charging Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="charging_status" data-placeholder="Select a status" required>
                                        <option value="publish"<?php if($chargingData['charging_status'] =="publish"){ echo "selected"; } else { echo ""; } ?>>Publish</option> 
                                        <option value="unpublish"<?php if($chargingData['charging_status'] =="unpublish"){ echo "selected"; } else { echo ""; } ?>>Unpublish</option>
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
        
        const allowedImageTypes = ['image/png', 'application/json']; 
        
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackThumbnail.innerHTML = `<span style="color:red;">Please upload a PNG or JSON image. </span>`;
                return;
            } else if (file.type == 'application/json') {
                feedbackThumbnail.innerHTML = `<span style="color:green;">The file is a JSON file. </span>`;
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