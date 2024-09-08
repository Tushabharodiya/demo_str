<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-users-fill"></em> Login History - With Action</h4>
                    <div class="nk-block-des text-soft">
                        <p>All Login Data</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="true">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                            <th class="nk-tb-col" width="10%"><span>ID</span></th>
                            <th class="nk-tb-col" width="22%"><span>Name</span></th>
                            <th class="nk-tb-col" width="23%"><span>Email</span></th>
                            <th class="nk-tb-col" width="20%"><span>Login</span></th>
                            <th class="nk-tb-col" width="20%"><span>Logout</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-end" width="5%"><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($viewLogin as $data){ ?>
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col">
                                <span><?php echo $data['unique_id']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['user_name']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['user_email']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['user_login']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['user_logout']; ?></span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>login-description/<?php echo urlEncodes($data['unique_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Details">
                                            <em class="icon ni ni-eye-fill"></em>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    
    </div>
</div>