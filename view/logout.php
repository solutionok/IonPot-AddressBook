<?php
unset($_SESSION['username']);
unset($_SESSION['id']);
// We don't need this anymore
session_destroy();
header("Location:" . WORK_ROOT . "contact/login/");
