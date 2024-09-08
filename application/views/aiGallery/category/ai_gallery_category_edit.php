 <div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Ai Gallery Category</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Ai Gallery Category</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-ai-gallery-category" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="category_name">Category Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="category_name" value="<?php echo $aiGalleryCategoryData['category_name']; ?>" placeholder="Enter category name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="category_icon">Category Icon *</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-control form-file-input" id="file-uploader" name="category_icon" value="<?php echo $aiGalleryCategoryData['category_icon']; ?>">
                                        <label class="form-file-label" for="category_icon">Choose file</label>
                                        <div id="feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="category_position">Category Position *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="category_position" value="<?php echo $aiGalleryCategoryData['category_position']; ?>" placeholder="Enter category position" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="category_status">Category Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="category_status" data-placeholder="Select a status" required>
                                        <option value="publish"<?php if($aiGalleryCategoryData['category_status'] =="publish"){ echo "selected"; } else { echo ""; } ?>>Publish</option>
                                        <option value="unpublish"<?php if($aiGalleryCategoryData['category_status'] =="unpublish"){ echo "selected"; } else { echo ""; } ?>>Unpublish</option> 
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
    const fileUploader = document.getElementById('file-uploader');
    const feedback = document.getElementById('feedback');
    const submitButton = document.getElementById('submit-button');

    fileUploader.addEventListener('change', (event) => {
        const file = event.target.files[0];

        if (file) {
            const img = new Image();
            img.src = URL.createObjectURL(file);

            img.onload = function () {
                const width = this.width;
                const height = this.height;

                let msg = '';

                if (width === 128 && height === 128) {
                    msg = `<span style="color:green;">The image size is 128x128. </span>`;
                    submitButton.style.display = 'block'; 
                } else {
                    msg = `<span style="color:red;">The image size should be 128x128. Actual size is ${width}x${height}. </span>`;
                    submitButton.style.display = 'none'; 
                }

                feedback.innerHTML = msg;
            };
        }
    });
</script>