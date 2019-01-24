<form name="frmImportContact" id="frmImportContact" action="" method="post"
    enctype="multipart/form-data" role="form">
    <div id="modal-box"
        class="box-contain margin-zero-auto overflow-hide modal-bottom-radius">
        <div class="row">
            <div class="col">
                <div class="md-10">
                    <span>Download <a
                        href="<?php echo WORK_ROOT; ?>Template/Contact-Import-Template.csv"
                        class="help-txt">TEMPLATE FILE </a>and use it to
                        import.
                    </span>
                </div>
                <input name="fileToUpload" type="file"
                    class="form-control">
            </div>
        </div>
    </div>
    <div class="row form-btn">
        <span id="ImportBtn">
            <button class="btn-outline btn-save" id="importContactBtn"
                type="button" name="importContactBtn">
                <span>Import</span>
            </button>
        </span>
    </div>
    <?php require_once 'framework/form-footer.php';?>
</form>