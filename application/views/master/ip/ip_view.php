<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
            
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-shield-half"></em>Allowed Ip</h4>
                    <div class="nk-block-des text-soft">
                        <p>You can add and remove IP Addresses as you want.</p>
                    </div>
                </div>
                
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-ip" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-ip" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
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
                            <th class="nk-tb-col" width="5%"><span>ID</span></th>
                            <th class="nk-tb-col" width="15%"><span>Name</span></th>
                            <th class="nk-tb-col" width="15%"><span>Ip</span></th>
                            <th class="nk-tb-col" width="15%"><span>Email</span></th>
                            <th class="nk-tb-col" width="15%"><span>Time</span></th>
                            <th class="nk-tb-col" width="10%"><span>Start Time</span></th>
                            <th class="nk-tb-col" width="10%"><span>End Time</span></th>
                            <th class="nk-tb-col" width="10%"><span>Status</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-end" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($viewIp as $data){ ?>
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col">
                                <span ><?php echo $data['data_id']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['data_name']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['data_ip']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['data_email']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['data_time']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['data_start_time']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['data_end_time']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <?php 
                                    $dataStatus = '';
                                    if($data['data_status'] == 'active'){
                                        $dataStatus.= '<span class="tb-status text-success">Active</span>';
                                    } else if($data['data_status'] == 'blocked'){
                                        $dataStatus.= '<span class="tb-status text-danger">Blocked</span>';
                                    }
                                    echo $dataStatus; 
                                ?>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>edit-ip/<?php echo urlEncodes($data['data_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <em class="icon ni ni-edit-fill"></em>
                                        </a>
                                    </li>
                                    <li class="nk-tb-action">
                                        <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['data_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <em class="icon ni ni-trash-fill"></em>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['data_id']);?>">
                            <div class="modal-dialog modal-dialog-top" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Allowed IP?</h5>
                                        <a href="<?php echo base_url(); ?>view-ip" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <em class="icon ni ni-cross"></em>
                                        </a>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this allowed ip?</p>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <span class="sub-text"><a href="<?php echo base_url(); ?>delete-ip/<?php echo urlEncodes($data['data_id']); ?>">Delete</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
            
    </div>
</div>