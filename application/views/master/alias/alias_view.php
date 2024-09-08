<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
            
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-shield-half"></em> All Alias</h4>
                    <div class="nk-block-des text-soft">
                        <p>You can add and edit Alias as you want.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-alias" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-alias" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
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
                            <th class="nk-tb-col" width="15%"><span>Position</span></th>
                            <th class="nk-tb-col" width="55%"><span>Name</span></th>
                            <th class="nk-tb-col" width="10%"><span>Count</span></th>
                            <th class="nk-tb-col" width="10%"><span>Status</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-end" width="10%"><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($viewAlias as $data){ ?>
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col">
                                <span><?php echo $data['alias_position']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['alias_name']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['permissionCount']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php 
                                    $aliasStatus = '';
                                    if($data['alias_status'] == 'true'){
                                        $aliasStatus.= '<span class="tb-status text-success">True</span>';
                                    } else if($data['alias_status'] == 'false'){
                                        $aliasStatus.= '<span class="tb-status text-danger">False</span>';
                                    }
                                    echo $aliasStatus; 
                                ?></span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>view-permissions/<?php echo urlEncodes($data['alias_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="View Permission">
                                            <em class="icon ni ni-eye-fill"></em>
                                        </a>
                                    </li>
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>edit-alias/<?php echo urlEncodes($data['alias_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
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