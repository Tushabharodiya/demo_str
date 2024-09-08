<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
      
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-user-fill-c"></em> All Department</h4>
                    <div class="nk-block-des text-soft">
                        <p>You can add, edit, rights and permission Department as you want.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-department" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-department" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
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
                            <th class="nk-tb-col" width="50%"><span>Name</span></th>
                            <th class="nk-tb-col" width="20%"><span>Status</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-end" width="20%"><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($viewDepartment as $data){ ?>
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col">
                                <span><?php echo $data['department_id']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['department_name']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php 
                                    $departmentStatus = '';
                                    if($data['department_status'] == 'publish'){
                                        $departmentStatus.= '<span class="tb-status text-success">Publish</span>';
                                    } else if($data['department_status'] == 'unpublish'){
                                        $departmentStatus.= '<span class="tb-status text-danger">Unpublish</span>';
                                    }
                                    echo $departmentStatus; 
                                ?></span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>department-rights/<?php echo urlEncodes($data['department_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Department Rights">
                                            <em class="icon ni ni-shield-half"></em>
                                        </a>
                                    </li>
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>department-permission/<?php echo urlEncodes($data['department_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Department Permission">
                                            <em class="icon ni ni-send"></em>
                                        </a>
                                    </li>
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>view-users/<?php echo urlEncodes($data['department_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="User List">
                                            <em class="icon ni ni-user-list-fill"></em>
                                        </a>
                                    </li>
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>edit-department/<?php echo urlEncodes($data['department_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
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