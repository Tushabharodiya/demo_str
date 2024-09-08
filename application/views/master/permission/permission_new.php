<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Permission</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Permission</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php echo base_url(); ?>view-permission" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form id="myForm" action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="alias_id">Alias Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="alias_id" data-placeholder="Select a alias" data-search="on" required>
                                        <?php if(!empty($aliasData)){ ?>
                                            <?php foreach($aliasData as $data){ ?>
                                                <option value="<?php echo $data['alias_id']; ?>"><?php echo $data['alias_name']; ?></option>
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
                                <label class="form-label" for="permission_name">Permission Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="permission_name" placeholder="Enter permission name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="permission_alias">Permission Alias *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="permission_alias" placeholder="Enter permission alias" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="permission_description">Permission Description *</label>
                                <div class="form-control-wrap">
                                    <textarea type="text" class="form-control" name="permission_description" placeholder="Enter permission description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="permission_status">Permission Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="permission_status" data-placeholder="Select a status" required>
                                        <option label="empty" value=""></option>
                                        <option value="true">True</option>
                                        <option value="false">False</option>
                                    </select>
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