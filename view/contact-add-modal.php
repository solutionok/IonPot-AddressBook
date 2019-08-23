
<form name="frmAdd" id="frmAddContact" action="" method="post"
    enctype="multipart/form-data" role="form">
    <div id="modal-box" class="box-contain margin-zero-auto">
        <div class="row">
            <div class="col">
                <div class="label ">
                    Name: <span class="required" id="reg_name_info"></span>
                </div>
                <div class="field">
                    <input type="text" name="name" id="name">
                </div>
            </div>
            <div class="col">
                <div class="label">
                    Email: <span id="reg_email_info"></span>
                    <!--Nick Name:-->
                </div>
                <div class="field">
                    <input type="text" name="user_email" id="user_email" style="width: 175px;">
                    &nbsp;&nbsp;@xlri.ac.in
                    <input type="text" name="nick_name" id="nick_name" style="display: none;">
                </div>
            </div>
            <div class="col" style="margin-right:12px;">
                <div class="label">Mobile:</div>
                <div class="field">
                    <input type="text" name="user_mobile_no" id="user_mobile_no">
                </div>
            </div>
            <div class="col">
                <div class="label">Office:</div>
                <div class="field">
                    <input type="text" name="user_office_no"
                        id="user_office_no">
                </div>
            </div>
            <div class="col">
                <div class="label">Residential:</div>
                <div class="field">
                    <input type="text" name="user_residential_no"
                        id="user_residential_no">
                </div>
            </div>
            <div class="col">
                <div class="label">Employ Type:</div>
                <div class="field">
                    <input type="text" name="relationship" id="relationship">
                </div>
            </div>
            <div class="col">
                <div class="label">Department:</div>
                <div class="field">
                    <input type="text" name="destination" id="destination">
                </div>
            </div>
            <div class="col">
                <div class="label">Designation:</div>
                <div class="field">
                    <input type="text" name="company" id="company">
                </div>
            </div>
        </div>
        <div class="row" style="display: none;">
            <div class="col float-right">
                <div class="label">Job Title:</div>
                <div class="field">
                    <input type="text" name="job_title" id="job_title">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col" style="display: none;">
                <div class="label">Landline:</div>
                <div class="field">
                    <input type="text" name="user_landline_no"
                        id="user_landline_no">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="label">Address:</div>
            <div class="field">
                <textarea name="user_address" id="user_address" rows="3"
                    cols="78"></textarea>
            </div>
        </div>
        <div class="row" style="display: none;">
            <div class="col">
                <div class="label">City:</div>
                <div class="field">
                    <input type="text" name="user_city" id="user_city">
                </div>
            </div>
            <div class="col float-right">
                <div class="label">State:</div>
                <div class="field">
                    <input type="text" name="user_state" id="user_state">
                </div>
            </div>
        </div>
        <div class="row" style="display: none;">
            <div class="col">
                <div class="label">Website:</div>
                <div class="field">
                    <input type="text" name="website" id="website">
                </div>
            </div>
            <div class="col float-right">
                <div class="label">IM:</div>
                <div class="field">
                    <input type="text" name="im" id="im">
                </div>
            </div>
        </div>
        <div class="row" style="display: none;">
            <div class="col">
                <div class="label">Birthday:</div>
                <div class="field">
                    <input data-toggle="datepicker" name="date_of_birth"
                        id="date_of_birth" placeholder="Select DOB">
                </div>
            </div>
            <div class="col float-right">
                <div class="label">GEO (latitude, longitude):</div>
                <div class="field">
                    <input type="text" name="geo" id="geo">
                </div>
            </div>
        </div>
        <div class="row" style="display: none;">
            <div class="label">
                Employ Type: <img class="icon-info"
                    src="<?php echo WORK_ROOT; ?>view/image/i.png"
                    title="Enter to confirm the department input" />
            </div>
            <div class="field">
                <input class="full-width" type="text" name="group"
                    id="group" data-role="tagsinput" />
            </div>
        </div>
        <div class="row">
            <div class="label">Photo:</div>
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
                <textarea name="notes" id="notes" rows="5" cols="78"></textarea>
            </div>
        </div>
        <!-- row close -->
        <div id="accordion">
            <h4 class="cursor-pointer">Custom Fields</h4>
            <div>
                <div id="custom_addmore">
                    <div class="custom-row" name="row[]" id="row">
                        <div class="col margin-delete">
                            <img
                                class="custom-row-delete cursor-pointer"
                                src="<?php echo WORK_ROOT;?>view/image/trash.gif"
                                title="Delete" id="test-del-id">
                        </div>
                        <div class="col">
                            <div class="label">Label:</div>
                            <div class="field">
                                <input type="text" name="label[]"
                                    class="input-label">
                            </div>
                        </div>
                        <div class="col float-right">
                            <div class="label">
                                Value: <span
                                    class="reg_customvalue_info"></span>
                            </div>
                            <div class="field">
                                <input type="text" name="value[]"
                                    class="input-value">
                            </div>
                        </div>
                    </div>
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
        <!-- hidden -->
    </div>
    <!-- modal-box -->
    <div class="row form-btn">
        <span id="HideaddContact">
            <button class="btn-outline btn-save cursor-pointer"
                name="addContact" id="addContact" type="button">
                <span>Save</span>
            </button>
        </span>
        <button class="btn-outline btn-cancel cursor-pointer"
            name="cancel" type="button">
            <span>Cancel</span>
        </button>
    </div>
    <?php require_once 'framework/form-footer.php';?>
</form>
<style>
    .col {margin-right: 15px!important;margin-bottom: 10px!important;}
</style>