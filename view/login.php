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
</style>
    <?php require_once 'favicon.php';?>
</head>
<body>
    <div id="foundation">
        <div id="entry-container">
            <form name="frmLogin" id="form-join" action="" method="post"
                enctype="multipart/form-data" role="form"
                onSubmit="return loginValidate();">
                <div class="form-row center login-header">
                    <h1 class="text-center clear-float"><?php echo APP_NAME; ?></h1>
                </div>
                <div class="form-row">
                    <div class="form-label">
                        Username: <span class="error"
                            id="member_name_info"></span>
                    </div>
                    <div id="login-div" class="form-element">
                        <input class="login-input" type="input"
                            name="login-username" id="login-username">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label">
                        Password: <span class="error" id="password_info">
                        </span>
                    </div>
                    <div id="login-div" class="form-element">
                        <input class="login-input" type="password"
                            name="login-password" id="login-password">
                    </div>
                    <a class="forgot-link"
                        href="<?php echo WORK_ROOT; ?>forgot/"
                        title="Forgot Password">Forgot Password?</a>
                </div>
                <div class="form-row">
                    <div class="form-element">
                        <div id="login">
                            <button class="btn btn-success login-btn"
                                name="login" value="LOGIN">
                                <span>Login</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php require_once 'framework/form-footer.php';?>
            </form>
        </div>
    </div>
    <script
        src="<?php echo WORK_ROOT; ?>vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo WORK_ROOT; ?>view/js/common.js"></script>
<?php if (isset($message_type) && $message_type== 'error') { ?>
<script>
displayMessage("login-error-message","<?php echo $message; ?>");
</script>
<?php } ?>
<script>
function loginValidate(workroot){
    var valid=true;
    var name = $('#login-username').val();
    var pwd = $('#login-password').val();
    $("#member_name_info").html("").hide();
    $("#password_info").html("").hide();
    if(name==""){
        $("#member_name_info").html("required.").addClass( "error-color" ).show();
        $("#login-username").addClass( "input-error" );
        valid=false;
    }
    if(pwd==""){
        $("#password_info").html("required.").addClass( "error-color" ).show();
        $("#login-password").addClass( "input-error" );
        valid=false;
    }
    return valid;
}
$(document).ready(function() {
    $("#login-username").focus();
});
</script>
</body>
</html>