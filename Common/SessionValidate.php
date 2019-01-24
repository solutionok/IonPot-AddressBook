<?php
if (! (isset($_SESSION['member_id']) && $_SESSION['member_id'] != '')) {
    header("Location:" . WORK_ROOT . "login/");
    exit();
}
