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
        <div id="entry-container">
            <form name="frmLogin" id="form-join" action="" method="post"
                enctype="multipart/form-data" role="form"
                onSubmit="return validate();">
                <div class="form-row center login-header">
                    <h1 class="text-center clear-float">Forgot Password</h1>
                </div>
                <div class="er-message" id="txt-message">&nbsp;<?php
                if (isset($message)) {
                    echo $message;
                }
                ?></div>
<?php if (!isset($emailsent)) { ?>
<div class="form-row">
                    <div class="form-label">
                        Email: <span class="error" id="email_info"></span>
                    </div>
                    <div id="login-div" class="form-element">
                        <input type="text" name="email" id="email">
                    </div>
                </div>
                <a class="forgot-link"
                    href="<?php echo WORK_ROOT; ?>login/"
                    title="Forgot Password">Login</a>
                <div class="form-row">
                    <div class="form-element">
                        <div id="Submit">
                            <input class="btn btn-success login-btn"
                                name="submit" value="SUBMIT"
                                type="submit">
                        </div>
                    </div>
                </div>
<?php } elseif (isset($emailsent) && $emailsent == true) { ?>
<div class="reset-alert">
                    <div class="form-row">
                        <div class="form-label">
                            <strong>Account recovery email sent to <?php $u->xecho($_POST["email"]); ?></strong>
                        </div>
                    </div>
                </div>
    <?php
}
if (isset($emailsent) && $emailsent == false) { // failure to send email
    ?>
    <div class="reset-alert">
                    <div class="form-row">
                        <div class="form-label">
                            <strong>Failed to send account recovery email to <?php $u->xecho($_POST["email"]); ?>.
                            Try again later.</strong>
                        </div>
                    </div>
                </div>
    <?php
}
?>
<?php require_once 'framework/form-footer.php';?>
</form>
        </div>
    </div>
    <script
        src="<?php echo WORK_ROOT; ?>vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo WORK_ROOT; ?>view/js/common.js"></script>
    <script>
function validate(){
    var valid=true;
    var email = $('#email').val();
    $("#email_info").html("").hide();
    var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(email==""){
        $("#email_info").html("required.").addClass( "error-color" ).show();
        $("#email").addClass( "input-error" );
        valid=false;
    } else if(!emailRegex.test(email)) {
        $("#email_info").html("Invalid Email.").addClass( "error-color" ).show();
        $("#email").addClass( "input-error" );
        valid = false;
    }
    return valid;
}
</script>
</body>
</html>