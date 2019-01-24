<?php

function getResetPasswordBody($username, $resetHash)
{
    ob_start();
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Reset Mail</title>
</head>

<body itemscope itemtype='http://schema.org/EmailMessage'
    style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 13px; color: #616161; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f0f0f0;">
    <div
        style='width: 100%; clear: both; color: #999; padding: 20px 0 0 0;'>
        <table width='100%'>
            <tr>
            </tr>
        </table>
    </div>
    <table
        style='vertical-align: top; background-color: #f0f0f0; width: 100%;'>
        <tr>
            <td style='vertical-align: top;'></td>
            <td width='600'
                style='vertical-align: top; padding: 0 !important; width: 100% !important;'>
                <div
                    style='max-width: 600px; margin: 0 auto; display: block; padding: 20px;'>
                    <table width='100%' cellpadding='0' cellspacing='0'
                        itemprop='action' itemscope
                        itemtype='http://schema.org/ConfirmAction'
                        style='background-color: #fff; border-radius: 2px;'>
                        <tr>
                            <td style='padding: 20px;'>
                                <meta itemprop='name'
                                    content='Confirm Email' />
                                <table width='100%' cellpadding='0'
                                    cellspacing='0'>
                                    <tr>
                                        <td style='padding: 0 0 20px;'>
We received an account recovery request on
<?php
    echo APP_NAME . " for " . $username;
    ?>
</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 0 0 20px;'>If
                                            you initiated this request,
                                            click the below button and
                                            recover your account.</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 0 0 20px;'>If
                                            you did not initiate this
                                            account recovery request,
                                            just ignore this email.
                                            We'll keep your account
                                            safe.</td>
                                    </tr>
                                    <tr>
                                        <td itemprop='handler' itemscope
                                            itemtype='http://schema.org/HttpActionHandler'
                                            style='padding: 0 0 20px;'><a
                                            href="
    <?php
    echo APP_ROOT;
    echo WORK_ROOT;
    ?>account/recover?recoveryToken=<?php

    echo $resetHash;
    ?>"
                                            class='btn-primary'
                                            itemprop='url'
                                            style='text-align: center; cursor: pointer; display: inline-block; background-color: #00C7A0; padding: 12px 50px; border-radius: 4px; color: #fff; text-decoration: none; border: 1px solid; border-color: #00DCB1 #00B995 #01AF8D; text-transform: capitalize; font-weight: bold;'>Reset
                                                Password</a></td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 0 0 20px;'>&mdash;
                                            Team</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div
                        style='width: 100%; clear: both; color: #999; padding: 20px;'>
                        <table width='100%'>
                            <tr>
                                <td
                                    style='text-align: center; padding: 0 0 20px; color: #999; font-size: 12px;'>Need
                                    help? Email <a href='mailto:'>joe@ionpot.com</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
</body>

</html>
<?php

    return ob_get_clean();
}
?>