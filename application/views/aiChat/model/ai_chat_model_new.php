<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Ai Chat Model</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Ai Chat Model</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-ai-chat-model" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="model_name">Model Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="model_name" placeholder="Enter model name" required>
                                    <span class="text-danger"><?php if(!empty($this->session->userdata('session_ai_chat_model_new_model_name'))){ ?> <?php echo $this->session->userdata('session_ai_chat_model_new_model_name'); ?> <?php echo $this->session->unset_userdata('session_ai_chat_model_new_model_name'); ?> <?php } ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="model_description">Model Description *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="model_description" placeholder="Enter model description" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="model_icon">Model Icon *</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-control form-file-input" id="file-uploader" name="model_icon" required>
                                        <label class="form-file-label" for="model_icon">Choose file</label>
                                        <div id="feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="model_alias">Model Alias *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="model_alias" placeholder="Enter model alias" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="model_key">Model Key *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="model_key" placeholder="Enter model key" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="model_premium">Model Premium *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="model_premium" data-placeholder="Select a status" required>
                                        <option value="false">False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="model_status">Model Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="model_status" data-placeholder="Select a status" required>
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