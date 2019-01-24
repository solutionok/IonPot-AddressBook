<form name="frmAdd" id="frmAddContact" action="" method="post"
    enctype="multipart/form-data" role="form">
    <div id="modal-box"
        class="box-contain margin-zero-auto overflow-hide">
        <div class="row">
            <div class="col">
                <div class="label ">
                    Username<span class="required"
                        id="reg_username_info"></span>
                </div>
                <div class="field">
                    <input type="text" name="username" id="username">
                </div>
            </div>
            <div class="col float-right">
                <div class="label ">
                    Email<span class="required" id="reg_email_info"></span>
                </div>
                <div class="field">
                    <input type="text" name="email" id="email">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="label ">
                    Password<span class="required" id="reg_pwd_info"></span>
                </div>
                <div class="field">
                    <input type="password" name="password" id="password">
                </div>
            </div>
            <div class="col float-right">
                <div class="label ">Role</div>
                <div class="field">
                    <select name="role" class="input-width">
                        <option value="Member">Member</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- modal-box -->
    <div class="row form-btn">
        <span id="HideaddPassword">
            <button class="btn-outline btn-save" name="add-member"
                id="add-member" type="button">
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