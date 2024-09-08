<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-users-fill"></em> All Users</h4>
                    <div class="nk-block-des text-soft">
                        <p>You can add, edit, rights and permission User as you want.</p>
                    </div>
                </div>
                
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-user" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-user" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                </li>
                            </ul>
                        </div>
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
                            <th class="nk-tb-col" width="20%"><span>Name</span></th>
                            <th class="nk-tb-col" width="20%"><span>Email</span></th>
                            <th class="nk-tb-col" width="10%"><span>Department</span></th>
                            <th class="nk-tb-col" width="12%"><span>Is Login</span></th>
                            <th class="nk-tb-col" width="17%"><span>Status</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-end" width="10%"><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($viewUserMaster as $data){ ?>
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col">
                                <span><?php echo $data['user_id']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <a href="<?php echo base_url(); ?>login-activity/<?php echo urlEncodes($data['user_id']); ?>"><span><?php echo $data['user_name']; ?></span></a>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['user_email']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['departmentName']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php 
                                    $isLogin = '';
                                    if($data['is_login'] == 'True'){
                                        $isLogin.= '<span class="tb-status text-success">True</span>';
                                    }else if ($data['is_login'] == 'False'){
                                        $isLogin.= '<span class="tb-status text-danger">False</span>';
                                    }else{
                                        $isLogin .= '-';
                                    }
                                    echo $isLogin; 
                                ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php 
                                    $userStatus = '';
                                    if($data['user_status'] == 'active'){
                                        $userStatus.= '<span class="tb-status text-success">Active</span>';
                                    } else if($data['user_status'] == 'blocked'){
                                        $userStatus.= '<span class="tb-status text-danger">Blocked</span>';
                                    }
                                    echo $userStatus; 
                                ?></span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>user-rights/<?php echo urlEncodes($data['user_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="User Rights">
                                            <em class="icon ni ni-shield-half"></em>
                                        </a>
                                    </li>
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>user-permission/<?php echo urlEncodes($data['user_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="User Permission">
                                            <em class="icon ni ni-send"></em>
                                        </a>
                                    </li>
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>edit-user/<?php echo urlEncodes($data['user_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <em class="icon ni ni-edit-fill"></em>
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