<?php
require_once "Common/SessionValidate.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php

require_once 'favicon.php';
?>
<script src="<?php

echo WORK_ROOT;
?>vendor/jquery/jquery-3.2.1.min.js"
    type="text/javascript"></script>
<script src="<?php

echo WORK_ROOT;
?>vendor/datepicker/datepicker.js"></script>

<script
    src="<?php

    echo WORK_ROOT;
    ?>vendor/tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?php

echo WORK_ROOT;
?>vendor/typeahead/typeahead.js"></script>
<link href="<?php

echo WORK_ROOT;
?>vendor/datepicker/datepicker.css"
    rel="stylesheet">
<link href="<?php

echo WORK_ROOT;
?>vendor/typeahead/typeahead.css"
    rel="stylesheet" />
<link
    href="<?php

    echo WORK_ROOT;
    ?>vendor/tagsinput/dist/bootstrap-tagsinput.css"
    rel="stylesheet">
<link
    href="<?php

    echo WORK_ROOT;
    ?>vendor/fine-uploader/fine-uploader-gallery.css"
    rel="stylesheet">

<script
    src="<?php

    echo WORK_ROOT;
    ?>vendor/fine-uploader/fine-uploader.js"></script>
<!-- Accordion definitions -->
<link
    href="<?php

    echo WORK_ROOT;
    ?>vendor/jquery-ui-1.12.1.custom/jquery-ui.css"
    rel="stylesheet">
<script
    src="<?php

    echo WORK_ROOT;
    ?>vendor/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

    <?php

    require_once "vendor/fine-uploader/templates/gallery.html";
?>
<script src="<?php

echo WORK_ROOT;
?>view/js/common.js?190121"></script>
<script src="<?php

echo WORK_ROOT;
?>view/js/contact.js?190121"></script>
<script src="<?php

echo WORK_ROOT;
?>view/js/modal.js"></script>
<title>List - <?php

echo APP_NAME;
?></title>
<link href="<?php

echo WORK_ROOT;
?>view/css/style.css"
    rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="wrapper">
    <?php
    require_once "view/admin-header.php";
    require_once "view/contact-list-filter.php";
    if ((! empty($result)) || (empty($result))) {
        ?>
        <div id="content"
            class="content-width  res-content-width margin-zero-auto">
        <?php
        require_once "view/contact-list-ajax.php";
        ?>
        </div>
        <!-- content-div-ends -->
    <?php
    } // if-result-ends ?>
</div>
    <!-- wrapper -->
    <div id="show-modal-content"></div>
    <script>
    initDatepicker();
    </script>
</body>
</html>