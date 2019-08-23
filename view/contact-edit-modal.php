<form name="frmAdd" id="frmAddContact" action="" method="post"
    enctype="multipart/form-data" role="form">
    <div id="modal-box" class="box-contain margin-zero-auto">
        <div class="row">
            <div class="col">
                <div class="label">
                    Name: <span class="required" id="reg_name_info"></span>
                </div>
                <div class="field">
                    <input type="text" name="name" id="name" value="<?php $u->xecho($result[0]["name"]);?>">
                </div>
            </div>
            <div class="col">
                <div class="label">Email:</div>
                <div class="field">
                    
                    <input type="text" name="user_email" id="user_email"style="width: 175px;"
                        value="<?php $u->xecho($result[0]["user_email"]);?>">&nbsp;&nbsp;@xlri.ac.in
                    <input type="text" name="nick_name" id="nick_name" value="<?php $u->xecho($result[0]["nick_name"]);?>" style="display:none;">
                </div>
            </div>
            <div class="col">
                <div class="label">Phone:</div>
                <div class="field">
                    <input type="text" name="user_mobile_no"
                        id="user_mobile_no"
                        value="<?php $u->xecho($result[0]["user_mobile_no"]);?>">
                </div>
            </div>
            <div class="col">
                <div class="label">Office:</div>
                <div class="field">
                    <input type="text" name="user_office_no"
                        id="user_office_no"
                        value="<?php $u->xecho($result[0]["user_office_no"]);?>">
                </div>
            </div>
            <div class="col">
                <div class="label">Residential:</div>
                <div class="field">
                    <input type="text" name="user_residential_no"
                        id="user_residential_no"
                        value="<?php $u->xecho($result[0]["user_residential_no"]);?>">
                </div>
            </div>
            <div class="col" style="display:none;">
                <div class="label">Landline:</div>
                <div class="field">
                    <input type="text" name="user_landline_no"
                        id="user_landline_no"
                        value="<?php $u->xecho($result[0]["user_landline_no"]);?>">
                </div>
            </div>
            <div class="col">
                <div class="label">Employ Type:</div>
                <div class="field">
                    <input type="text"
                        name="relationship" id="relationship"
                        value="<?php $u->xecho($result[0]["relationship"]);?>">
                </div>
            </div>
            <div class="col" >
                <div class="label">Department:</div>
                <div class="field">
                    <input name="destination" id="destination" value="<?php $u->xecho($result[0]["destination"]);?>">
                </div>
            </div>
            <div class="col">
                <div class="label">Designatioin:</div>
                <div class="field">
                    <input type="text" name="company" id="company"
                        value="<?php $u->xecho($result[0]["company"]);?>">
                </div>
            </div>
        </div>
        <div class="row" style="display:none;">
            <div class="col">
                <div class="label">Job Title:</div>
                <div class="field">
                    <input type="text" name="job_title" id="job_title"
                        value="<?php $u->xecho($result[0]["job_title"]);?>">
                </div>
            </div>
        </div>
        <div class="row">
            
        </div>
        
        <div class="row" >
            <div class="label">Address:</div>
            <div class="field">
                <textarea name="user_address" id="user_address" rows="5"
                    cols="78"><?php $u->xecho($result[0]["user_address"]);?></textarea>
            </div>
        </div>
        <div class="row" style="display:none;">
            <div class="col">
                <div class="label">City:</div>
                <div class="field">
                    <input type="text" name="user_city" id="user_city"
                        value="<?php $u->xecho($result[0]["user_city"]);?>">
                </div>
            </div>
            <div class="col">
                <div class="label">State:</div>
                <div class="field">
                    <input type="text" name="user_state" id="user_state"
                        value="<?php $u->xecho($result[0]["user_state"]);?>">
                </div>
            </div>
        </div>
        <div class="row" style="display:none;">
            <div class="col">
                <div class="label">Website:</div>
                <div class="field">
                    <input type="text" name="website" id="website"
                        value="<?php $u->xecho($result[0]["website"]);?>">
                </div>
            </div>
            <div class="col">
                <div class="label">IM:</div>
                <div class="field">
                    <input type="text" name="im" id="im"
                        value="<?php $u->xecho($result[0]["im"]);?>">
                </div>
            </div>
        </div>
        <div class="row" style="display:none;">
            <div class="col">
                <div class="label">Birthday:</div>
                <div class="field">
                    <input data-toggle="datepicker" name="date_of_birth"
                        id="date_of_birth" placeholder="Select DOB"
                        value="<?php
                        if ($result[0]["birth_dt"] != null) {
                            $u->xecho(date("d-m-Y", strtotime($result[0]["birth_dt"])));
                        }
                        ?>">
                </div>
            </div>
            <div class="col">
                <div class="label">GEO (latitude, longitude):</div>
                <div class="field">
                    <input type="text" name="geo" id="geo"
                        value="<?php $u->xecho($result[0]["geo"]); ?>">
                </div>
            </div>
        </div>
        <?php if (!empty($groupresult)) { ?>
        <div class="row" style="display:none;">
            <div class="label">
                Department: <img class="icon-info"
                    src="<?php echo WORK_ROOT; ?>view/image/i.png"
                    title="Enter to confirm the department input" />
            </div>
            <div class="field">
                            <?php
                            foreach ($groupresult as $k => $v) {
                                $selectedgroup[] = $groupresult[$k]['group_name'];
                            }
                            $data = "";
                            if (! empty($selectedgroup)) {
                                $data = implode(',', $selectedgroup);
                            }
                            ?>
                            <input type="text"
                    name="group" id="group" value="<?php echo $data;?>">
            </div>
        </div>
        <?php } else {  ?>
        <div class="row" style="display:none;">
            <div class="label">Department:</div>
            <div class="field">
                <input type="text" name="group"
                    id="group" data-role="tagsinput" />
            </div>
        </div>
        <?php }  ?>
        <?php if (!empty($result[0]["user_photo"])) { ?>
        <div class="row" name="delete"
            id="row<?php $u->xecho($result[0]["id"]);?>">
            <div class="label">Existing Photo:</div>
            <div class="row">
                <a
                    onClick="deleteEntry('<?php echo WORK_ROOT; ?>', <?php $u->xecho($result[0]["id"])?>);"
                    title="Delete"><img
                    src="<?php echo WORK_ROOT;?>view/image/trash.gif"
                    style="margin-right: 4px;"></a>
            </div>
            <div class="field">
                <img id="user_photo" class="existing-photo"
                    src="<?php echo WORK_ROOT; ?>data/<?php $u->xecho($result[0]["user_photo"]); ?>">
            </div>
        </div>
        <!-- row close -->
                        <?php } ?>
                        <div class="row">
            <div class="label">Add New Photo:</div>
            <!-- Fine Uploader DOM Element
                        ====================================================================== -->
            <div id="featured_image_url"></div>
            <div id="single-fine-uploader"></div>
            <!-- Your code to create an instance of Fine Uploader and bind to the DOM/template
                        ====================================================================== -->
        </div>
        <!-- row close -->
        <div class="row">
            <div class="label">Notes:</div>
            <div class="field">
                <textarea name="notes" id="notes" rows="5" cols="78"><?php $u->xecho($result[0]["notes"])?></textarea>
            </div>
        </div>
        <!-- row close -->

        <div id="accordion">
            <h4 class="cursor-pointer">Custom Fields</h4>
            <div>
                <div id="custom_addmore">
                    <!--custom row start -->
                                    <?php

                                    if (! empty($customresult)) {
                                        foreach ($customresult as $k => $v) {
                                            ?>
                                    <div class="custom-row row"
                        name="row[]"
                        id="row<?php $u->xecho($customresult[$k]["id"]); ?>">
                        <div class="col margin-delete">
                            <span
                                onClick="openDialog('<?php echo WORK_ROOT; ?>','contact/custom/delete/<?php $u->xecho($customresult[$k]["id"]); ?>/','Delete','auto',true,false)""><img
                                class="cursor-pointer"
                                src="<?php echo WORK_ROOT;?>view/image/trash.gif"
                                title="Delete"></span>
                        </div>
                        <div class="col">
                            <div class="label">Label:</div>
                            <div class="field">
                                <input type="text" name="label[]"
                                    class="input-label"
                                    value="<?php $u->xecho($customresult[$k]["label"]);?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="label">
                                Value: <span
                                    class="reg_customvalue_info"></span>
                            </div>
                            <div class="field">
                                <input type="text" name="value[]"
                                    class="input-value"
                                    value="<?php $u->xecho($customresult[$k]["value"]);?>">
                            </div>
                        </div>

                    </div>
                    <!--row end -->
                                    <?php
                                        }
                                    } else {
                                        ?>
                                    <div class="custom-row" name="row[]"
                        id="row">
                        <div class="col margin-delete">
                            <img
                                class="custom-row-delete cursor-pointer"
                                src="<?php echo WORK_ROOT;?>view/image/trash.gif"
                                title="Delete" id="test-del-id">
                        </div>
                        <div class="col">
                            <div class="label">Label</div>
                            <div class="field">
                                <input type="text" name="label[]"
                                    class="input-label">
                            </div>
                        </div>
                        <div class="col">
                            <div class="label">
                                Value <span class="reg_customvalue_info"></span>
                            </div>
                            <div class="field">
                                <input type="text" name="value[]"
                                    class="input-value">
                            </div>
                        </div>

                    </div>
                                    <?php } ?>
                                    <!--custom row end -->
                </div>
                <div class="row add_more">
                    <div class="col">
                        <label class="label"><p
                                onClick="appendMore('<?php echo WORK_ROOT;?>');"
                                class="cursor-pointer" title="Add">
                                (<img
                                    src="<?php echo WORK_ROOT;?>view/image/plus.png"
                                    class="plus-size"> add more)
                            </p></label>
                    </div>
                </div>
                <!--row end -->
            </div>
        </div>
    </div>
    <div class="row form-btn">
        <button class="btn-outline btn-save" name="editContact"
            id="editContact"
            data-contact-id="<?php $u->xecho($result[0]["id"]);?>"
            type="button">
            <span>Save</span>
        </button>
        <button class="btn-outline btn-cancel" name="cancel"
            type="button">
            <span>Cancel</span>
        </button>
    </div>
    <?php require_once 'framework/form-footer.php';?>
</form>
<style>
    .col {margin-right: 15px!important;margin-bottom: 10px!important;}
</style>