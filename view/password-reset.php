<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - <?php echo APP_NAME; ?></title>
<link href="<?php echo WORK_ROOT; ?>view/css/style.css" rel="stylesheet"
    type="text/css" />
<style>
    body {
    background: #f7f7f7;
}

#entry-container {
   background-color: #fff;
}

#txt-message {
   color: #d96557;
}
</style>
</head>
<body>
    <div id="foundation">
        <div id="entry-container"
            style="padding: 50px 100px 30px 100px;">
            <form name="frmReset" action="" method="post"
                enctype="multipart/form-data" role="form"
                onSubmit="return validate();">
                <div class="form-row center login-header">
                    <h1 class="text-center clear-float">Password Reset</h1>
                </div>
                <div class="er-message" id="txt-message">&nbsp;
                <?php
                if (isset($message)) {
                    echo $message;;
                }
                ?></div>
                <?php
                if (isset($isValidToken) and $isValidToken == 1) {
                    $createdAt = strtotime($memberForgotResult[0]['create_at']);
                    $currentTime = time();
                    if (($currentTime - $createdAt) > 86400) {
                        ?>
                            <div class="reset-alert">
                    <div class="form-row">
                        <div class="form-label">
                            <strong>Your link is expired. You need to <a
                                href="<?php echo WORK_ROOT; ?>forgot/">initiate
                                    a new password recovery email</a></strong>
                        </div>
                    </div>
                </div>
                    <?php } else { ?>
                <div class="form-row">
                    <div class="form-label">
                        Password: <span class="error" id="pwd_info"></span>
                    </div>
                    <div id="login-div" class="form-element">
                        <input type="password" name="password"
                            id="password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label">
                        Confirm Password: <span class="error"
                            id="con_pwd_info"></span>
                    </div>
                    <div id="login-div" class="form-element">
                        <input type="password" name="confirm_password"
                            id="confirm_password">
                    </div>
                </div>
                <a class="forgot-link"
                    href="<?php echo WORK_ROOT; ?>login/" title="Login">Login</a>
                <div class="form-row">
                    <div class="form-element">
                        <div>
                            <input class="btn btn-success login-btn"
                                name="submit" value="SUBMIT"
                                type="submit">
                        </div>
                    </div>
                </div>
                    <?php } ?>
                <?php } elseif ($isValidToken == 2) { ?>
        <!--success sending recover email-->
                <div class="token-message">
                    <div class="reset-alert">
                        <div class="form-row">
                            <div class="form-label">
                                <strong>Password reset successfully. You
                                    can use your new password and <a
                                    href="<?php echo WORK_ROOT; ?>login/">login</a>.
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } elseif ($isValidToken == 0) { ?>
        <!--failure to send email-->
                <div class="token-message">
                    <div class="reset-alert">
                        <div class="form-row">
                            <div class="form-label">
                                <strong>Invalid token. You need to <a
                                    href="<?php echo WORK_ROOT; ?>forgot/">initiate
                                        a new password recovery email</a>.
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php require_once 'framework/form-footer.php';?>
        </form>
        </div>
    </div>
    <script
        src="<?php echo WORK_ROOT; ?>vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo WORK_ROOT; ?>view/js/common.js"></script>
    <script>
        function validate() {
            var valid=true;
            var password = $('#password').val();
            var con_password = $('#confirm_password').val();
            $("#pwd_info").html("").hide();
            $("#con_pwd_info").html("").hide();
            if(password == ""){
                $("#pwd_info").html("required.").addClass( "error-color" ).show();
                $("#password").addClass( "input-error" );
                valid=false;
            } else if(password!=con_password){
                $("#con_pwd_info").html("Not same as above.").addClass( "error-color" ).show();
                $("#password").addClass( "input-error" );
                $("#confirm_password").addClass( "input-error" );
                valid=false;
            }
            return valid;
        }
    </script>
</body>
</html>