<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">AI Gallery Data</h4>
                    <div class="nk-block-des text-soft">
                        <p>New AI Gallery Data</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-ai-gallery-data" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <?php if(!empty($this->session->userdata('session_ai_gallery_data_response'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_ai_gallery_data_response');?> <?php echo $this->session->unset_userdata('session_ai_gallery_data_response');?>
            </div>
        <?php } ?>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="ai_prompt">Ai Prompt *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="ai_prompt" placeholder="Enter ai prompt" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="ai_style">Ai Style</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" name="ai_style" data-placeholder="Select a style" data-search="on" required>
                                        <option value="enhance">Enhance</option>
                                        <option value="anime">Anime</option>
                                        <option value="photographic">Photographic</option>
                                        <option value="digital-art">Digital Art</option>
                                        <option value="comic-book">Comic Book</option>
                                        <option value="fantasy-art">Fantasy Art</option>
                                        <option value="line-art">Line Art</option>
                                        <option value="analog-film">Analog Film</option>
                                        <option value="neon-punk">Neon Punk</option>
                                        <option value="isometric">Isometric</option>
                                        <option value="low-poly">Low Poly</option>
                                        <option value="origami">Origami</option>
                                        <option value="modeling-compound">Modeling Compound</option>
                                        <option value="cinematic">Cinematic</option>
                                        <option value="3d-model">3d Model</option>
                                        <option value="pixel-art">Pixel Art</option>
                                        <option value="tile-texture">Tile Texture</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="ai_size">Ai Size</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" name="ai_size" data-placeholder="Select a size" data-search="on" required>
                                        <option value="1024x1024">1024x1024</option>
                                        <option value="2048x2048">2048x2048</option>
                                        <option value="1152x896">1152x896</option>
                                        <option value="1216x832">1216x832</option>
                                        <option value="1344x768">1344x768</option>
                                        <option value="1536x640">1536x640</option>
                                        <option value="640x1536">640x1536</option>
                                        <option value="768x1344">768x1344</option>
                                        <option value="832x1216">832x1216</option>
                                        <option value="896x1152">896x1152</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="ai_scale">Ai Scale *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="ai_scale" value="30" min="7" max="35" placeholder="Enter ai scale" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="ai_steps">Ai Steps *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="ai_steps" value="40" min="30" max="50" placeholder="Enter ai steps" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="ai_type">Ai Type *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="ai_type" value="generate" placeholder="Enter ai type" required>
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

<script type="application/javascript">
    $(window).bind("load", function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 2000);
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