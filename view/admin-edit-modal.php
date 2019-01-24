<form name="frmAdd" id="frmAddContact" action="" method="post"
    enctype="multipart/form-data" role="form">
    <div id="modal-box"
        class="box-contain margin-zero-auto overflow-hide">
        <div class="row">
            <div class="col">
                <div class="label ">
                    Email<span class="required" id="reg_email_info"></span>
                </div>
                <div class="field">
                    <input type="text" name="email" id="email"
                        value="<?php $u->xecho($result[0]["email"]); ?>">
                </div>
            </div>
            <div class="col float-right">
                <div class="label ">
                    Password<span id="reg_pwd_info"></span>
                </div>
                <div class="field">
                    <input type="password" name="password" id="password">
                    <input type="hidden" id="username" name="username"
                        value="<?php $u->xecho($result[0]["username"]);?>">
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- modal-box -->
    <div class="row form-btn">
        <span id="HideaddPassword">
            <button class="btn-outline btn-save" name="addPassword"
                id="changePassword" type="button">
                <span>Save</span>
            </button>
        </span>
        <button class="btn-outline btn-cancel" name="cancel"
            type="button">
            <span>Cancel</span>
        </button>
    </div>
    <?php require_once 'framework/form-footer.php';?>
</form>