<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Keyboard Data</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Keyboard Data</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-keyboard-data" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="category_id">Category Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="category_id" data-placeholder="Select a category" data-search="on" required>
                                        <option label="empty" value=""></option>
                                        <?php if(!empty($keyboardCategoryData)){ ?>
                                            <?php foreach($keyboardCategoryData as $data){ ?>
                                                <option value="<?php echo $data['category_id']; ?>"><?php echo $data['category_name']; ?></option>
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
                                <label class="form-label" for="keyboard_name">Keyboard Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="keyboard_name" placeholder="Enter keyboard name" required>
                                    <span class="text-danger"><?php if(!empty($this->session->userdata('session_keyboard_data_new_keyboard_name'))){ ?> <?php echo $this->session->userdata('session_keyboard_data_new_keyboard_name'); ?> <?php echo $this->session->unset_userdata('session_keyboard_data_new_keyboard_name'); ?> <?php } ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="keyboard_thumbnail">Keyboard Thumbnail *</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-control form-file-input" id="file-uploader-thumbnail" name="keyboard_thumbnail" required>
                                        <label class="form-file-label" for="keyboard_thumbnail">Choose files</label>
                                        <div id="feedback-thumbnail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="keyboard_bundle">Keyboard Bundle *</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-control form-file-input" id="file-uploader-bundle" name="keyboard_bundle" required>
                                        <label class="form-file-label" for="keyboard_bundle">Choose files</label>
                                        <div id="feedback-bundle"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="keyboard_premium">Keyboard Premium *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="keyboard_premium" data-placeholder="Select a premium" required>
                                        <option label="empty" value=""></option>
                                        <option value="true">True</option>
                                        <option value="false">False</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="keyboard_status">Keyboard Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="keyboard_status" data-placeholder="Select a status" required>
                                        <option value="unpublish">Unpublish</option>
                                        <option value="publish">Publish</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary submitButton" id="submit-button" name="submit" value="Save Informations">
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
    
                if (width === 320 && height === 200) {
                    msg = `<span style="color:green;">The image size is 320x200. </span>`;
                    submitButton.style.display = 'block';
                } else {
                    msg = `<span style="color:red;">The image size should be 320x200. Actual size is ${width}x${height}. </span>`;
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