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
                    <input type="text" name="username" id="username"
                        value="<?php
                        $u->xecho($result[0]["username"]);
                        ?>">
                </div>
            </div>

            <div class="col float-right">
                <div class="label ">
                    Email<span class="required" id="reg_email_info"></span>
                </div>
                <div class="field">
                    <input type="text" name="email" id="email"
                        value="<?php
                        $u->xecho($result[0]["email"]);
                        ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="label ">
                    Password<span id="reg_pwd_info"></span>
                </div>
                <div class="field">
                    <input type="password" name="password" id="password">
                </div>
            </div>
            <div class="col float-right">
                <div class="label ">Role</div>
                <div class="field">
                    <select name="role" class="input-width">
                        <option value="Member"
                            <?php
                            if ($result[0]["role"] == "Member") {
                                print("selected");
                            }
                            ?>>Member</option>
                        <option value="Admin"
                            <?php
                            if ($result[0]["role"] == "Admin") {
                                print("selected");
                            }
                            ?>>Admin</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- modal-box -->
    <div class="row">
        <div class="row form-btn">
            <button class="btn-outline btn-save" name="editMember"
                id="editMember"
                data-member-id="<?php

                $u->xecho($result[0]["id"]);
                ?>"
                type="button">
                <span>Save</span>
            </button>
            <button class="btn-outline btn-cancel" name="cancel"
                type="button">
                <span>Cancel</span>
            </button>
        </div>
    </div>
    <?php require_once 'framework/form-footer.php';?>
</form>