<div class="nk-content-wrap">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="nk-block-content nk-error-ld text-center">
                <h1 class="nk-error-head">404</h1>
                <?php if($msg['data_title'] != null){ ?>
                    <h3 class="nk-error-title"><?php echo $msg['data_title']; ?></h3>
                <?php } ?>
                <?php if($msg['data_description'] != null){ ?>
                    <p class="nk-error-text"><?php echo $msg['data_description']; ?>.</p>
                <?php } ?>
                <?php if($msg['button_text'] != null){ ?>
                    <a href="<?php echo base_url(); ?><?php echo $msg['button_link']; ?>" class="btn btn-lg btn-primary mt-2"><?php echo $msg['button_text']; ?></a>
                <?php } ?> 
            </div>
        </div>
    </div>
</div>