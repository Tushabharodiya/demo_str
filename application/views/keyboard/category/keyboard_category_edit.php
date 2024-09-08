<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Keyboard Category</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Keyboard Category</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-keyboard-category" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                                    <input type="text" class="form-control" name="category_name" value="<?php echo $keyboardCategoryData['category_name']; ?>" placeholder="Enter category name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="category_status">Category Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="category_status" data-placeholder="Select a status" required>
                                        <option value="publish"<?php if($keyboardCategoryData['category_status'] =="publish"){ echo "selected"; } else { echo ""; } ?>>Publish</option> 
                                        <option value="unpublish"<?php if($keyboardCategoryData['category_status'] =="unpublish"){ echo "selected"; } else { echo ""; } ?>>Unpublish</option>
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