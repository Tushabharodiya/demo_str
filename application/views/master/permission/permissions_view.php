<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <?php $aliasID = $this->uri->segment(2); ?>
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-shield-half"></em> All Permission</h4>
                    <div class="nk-block-des text-soft">
                        <p>You can add and edit Permission as you want.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo base_url(); ?>view-permissions/<?php echo $aliasID; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-permission" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                </li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>view-alias" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                            <th class="nk-tb-col" width="35%"><span>Name</span></th>
                            <th class="nk-tb-col" width="35%"><span>Alias</span></th>
                            <th class="nk-tb-col" width="10%"><span>Status</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-end" width="10%"><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($viewPermission as $data){ ?>
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col">
                                <span><?php echo $data['permission_id']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['permission_name']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php echo $data['permission_alias']; ?></span>
                            </td>
                            <td class="nk-tb-col">
                                <span><?php 
                                    $permissionStatus = '';
                                    if($data['permission_status'] == 'true'){
                                        $permissionStatus.= '<span class="tb-status text-success">True</span>';
                                    } else if($data['permission_status'] == 'false'){
                                        $permissionStatus.= '<span class="tb-status text-danger">False</span>';
                                    }
                                    echo $permissionStatus; 
                                ?></span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li class="nk-tb-action">
                                        <a data-bs-toggle="modal" data-bs-target="#modalZoom" data-id="<?= $data['permission_id']; ?>" data-description="<?= $data['permission_description']; ?>" data-status="<?= $data['permission_status']; ?>" class="open-modal btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Quick View">
                                            <em class="icon ni ni-focus"></em>
                                        </a>
                                    </li>
                                    <li class="nk-tb-action">
                                        <a href="<?php echo base_url(); ?>edit-permission/<?php echo urlEncodes($data['permission_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
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

<div class="modal fade zoom" tabindex="-1" id="modalZoom">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Modal Title</h5>
                <a href="<?php echo base_url(); ?>view-permissions/<?php echo $aliasID; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <p id="modalContent">Modal Content</p>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text" id="modalFooter">Modal Footer Text</span>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.open-modal').click(function(){
            var permissionId = $(this).data('id');
            var permissionDescription = $(this).data('description');
            var permissionStatus = $(this).data('status');

            $('#modalTitle').text(permissionId);
            $('#modalContent').text(permissionDescription);
            $('#modalFooter').text(permissionStatus);

            $('#modalZoom').modal('show');
        });
    });
</script>