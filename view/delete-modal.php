
<form name="frmDelete" id="frmDelete" action="" method="post"
    enctype="multipart/form-data" role="form">
    <div id="modal-box" class="box-contain margin-zero-auto">
        <span>Are you sure want to delete?</span>
    </div>
    <div class="row form-btn">
        <span id="HideButtondelete"><button
                class="btn-outline btn-delete cursor-pointer" id="delete-<?php $u->xecho($mudule_name); ?>"
                data-<?php $u->xecho($mudule_name); ?>-id="<?php $u->xecho($result[0]["id"]); ?>" type="button">
                <span>Delete</span>
            </button></span>
        <button class="btn-outline btn-cancel cursor-pointer"
            name="cancel" type="button">
            <span>Cancel</span>
            <!-- <span>Cancel</span> -->
        </button>
    </div>
    <?php require_once 'framework/form-footer.php';?>
</form>