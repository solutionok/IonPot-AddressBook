<div id="modal-box"
    class="box-contain margin-zero-auto modal-bottom-radius">
    <div class="row">
        <div class="col">
        <?php if (!empty($result[0]["user_photo"])) { ?>
            <span><img class="existing-photo user-image"
                src="<?php echo WORK_ROOT."/"."data/".$result[0]["user_photo"]; ?>"
                alt="Photo"> </span>
        <?php } else {?>
            <span><img class="user-image"
                src="<?php echo WORK_ROOT;?>view/image/avatar.png"
                alt="Photo"> </span>
        <?php } ?>
        </div>

        <div class="row float-right">
            <div class="col">
                <div class="text-decoration">
                    <a
                        href="<?php echo WORK_ROOT; ?>contact/vcard/export/<?php $u->xecho($result[0]["id"]); ?>/"><img
                        width="20" title="Export as vCard"
                        src="<?php echo WORK_ROOT;?>view/image/vcard.png"></a>
                </div>
            </div>
            <div class="col">
                <div class="icon-left-padding text-decoration">
                    <img width="20" title="Edit"
                        src="<?php echo WORK_ROOT;?>view/image/icon-edit.png"
                        onclick="openDialog('<?php echo WORK_ROOT; ?>'
                        ,'contact/edit/<?php $u->xecho($result[0]['id']); ?>/','Edit Contact','',true,true);" />
                </div>
            </div>
            <div class="col">
                <div class="icon-left-padding text-decoration">
                    <img
                        src="<?php echo WORK_ROOT;?>view/image/icon-delete.png"
                        width="20" title="Delete"
                        onclick="openDialog('<?php echo WORK_ROOT; ?>','contact/delete/<?php $u->xecho($result[0]["id"]); ?>/','Delete','auto',true,false)">
                </div>
            </div>
        </div>
    </div>
    <!-- row close -->

    <?php if ((!empty($result[0]["destination"])) || (!empty($result[0]["relationship"]))) { ?>
     <div class="border-contain margin-bottom">
        <h4></h4>

        <div class="row">
            <?php if (!empty($result[0]["relationship"])) {  ?>
                <span class="label">Employee Type: </span> <span><?php $u->xecho($result[0]["relationship"]); ?></span>
            <?php } ?>
        </div>
        <div class="row">
            <?php if (!empty($result[0]["destination"])) {  ?>
                <span class="label">Department: </span> <span><?php $u->xecho($result[0]["destination"]); ?></span>
            <?php } ?>
        </div>

    </div>
    <!-- box close -->
        <?php } ?>

    <?php

    if ((! empty($result[0]["user_email"])) || (! empty($result[0]["user_mobile_no"])) || (! empty($result[0]["user_residential_no"])) || (! empty($result[0]["user_office_no"]))) {
        ?>
    <div class="border-contain margin-bottom">
        <h4>Contact</h4>
        <div class="row">
            <?php if (!empty($result[0]["user_email"])) {  ?>
            <span class="label">Email: </span> <a href="mailto:<?php $u->xecho($result[0]["user_email"]); ?>@xlri.ac.in"><?php $u->xecho($result[0]["user_email"]); ?>@xlri.ac.in</a>
            <?php } ?>
        </div>
        <div class="row">
            <?php if (!empty($result[0]["user_mobile_no"])) {  ?>
                <span class="label">Mobile: </span> <a href="tel:<?php $u->xecho($result[0]["user_mobile_no"]); ?>"><?php  $u->xecho($result[0]["user_mobile_no"]); ?></a>
            <?php } ?>
        </div>
        <div class="row">
            <?php if (!empty($result[0]["user_office_no"])) {  ?>
                <span class="label">Office: </span> <a href="tel:<?php $u->xecho($result[0]["user_office_no"]); ?>"><?php  $u->xecho($result[0]["user_office_no"]); ?></a>
            <?php } ?>
        </div>
        <div class="row" style="display: none;">
            <?php if (!empty($result[0]["user_landline_no"])) {  ?>
                <span class="label">Landline: </span> <a href="tel:<?php $u->xecho($result[0]["user_landline_no"]); ?>"><?php  $u->xecho($result[0]["user_landline_no"]); ?></a>
            <?php } ?>
        </div>
        <div class="row">
            <?php if (!empty($result[0]["user_residential_no"])) {  ?>
                <span class="label">Residential: </span> <a href="tel:<?php $u->xecho($result[0]["user_residential_no"]); ?>"><?php  $u->xecho($result[0]["user_residential_no"]); ?></a>
            <?php } ?>
        </div>

        <div class="row">
            <?php if (!empty($result[0]["website"])) {  ?>
                <span class="label">Website: </span> <span><?php $u->xecho($result[0]["website"]);?></span>
            <?php } ?>
        </div>
        <div class="row">
            <?php if (!empty($result[0]["im"])) {  ?>
                <span class="label">Im: </span> <span><?php $u->xecho($result[0]["im"]);?></span>
            <?php } ?>
        </div>
    </div>
    <!-- box close -->
    <?php } ?>



        <?php if ((!empty($result[0]["company"])) || (!empty($result[0]["job_title"]))) { ?>
     <div class="border-contain margin-bottom">
        <h4>Company</h4>

        <div class="row">
            <?php if (!empty($result[0]["company"])) {  ?>
                <span class="label">Company: </span> <span><?php $u->xecho($result[0]["company"]); ?></span>
            <?php } ?>
        </div>

        <div class="row">
            <?php if (!empty($result[0]["job_title"])) {  ?>
                <span class="label">Job Title: </span> <span><?php $u->xecho($result[0]["job_title"]); ?></span>
            <?php } ?>
        </div>
    </div>
    <!-- box close -->
        <?php } ?>


        <?php

        if ((! empty($result[0]["user_address"])) || (! empty($result[0]["user_city"])) || (! empty($result[0]["user_state"]))) {
            ?>
    <div class="border-contain margin-bottom">
        <h4>Address</h4>

        <div class="row">
            <?php if (!empty($result[0]["user_address"])) {  ?>
                <span class="label">Street: </span> <span
                class="delspace"><?php nl2br($u->xecho($result[0]["user_address"])); ?></span></span>
            <?php } ?>
        </div>

        <div class="row">
            <?php if (!empty($result[0]["user_city"])) {  ?>
                <span class="label">City: </span> <span><?php  $u->xecho($result[0]["user_city"]); ?></span>
            <?php } ?>
        </div>

        <div class="row">
            <?php if (!empty($result[0]["user_state"])) {  ?>
                <span class="label">State: </span> <span><?php $u->xecho($result[0]["user_state"]);?></span>
            <?php } ?>
        </div>
    </div>
    <!-- box close -->
        <?php } ?>



<?php if (!empty($customresult)) { ?>
<div class="border-contain margin-bottom">
        <h4>Custom Fields</h4>
        <?php foreach ($customresult as $k => $v) { ?>
        <div class="row">
            <div class="col">
                <div>
                    <span class="label"><?php $u->xecho($customresult[$k]["label"]); ?>
                    : </span><span><?php $u->xecho($customresult[$k]["value"]); ?></span>
                </div>
            </div>
        </div>
        <!-- row close -->
        <?php } ?>
</div>
    <!-- box close -->
<?php } ?>

<?php if (!empty($result[0]["notes"])) {  ?>
<div class="border-contain margin-bottom">
        <h4>Notes</h4>
        <div class="row">
            <div class="delspace"><?php nl2br($u->xecho($result[0]["notes"]));?></div>
        </div>
        <!-- row close -->
    </div>
    <!-- box close -->
<?php } ?>

</div>
<!-- model box close -->
<script type="text/javascript">
//    if (!jQuery.browser.mobile) {
//        jQuery('body').on('click', 'a[href^="tel:"]', function() {
//            jQuery(this).attr('href', 
//            jQuery(this).attr('href').replace(/^tel:/, 'callto:'));
//        });
//    }

</script>