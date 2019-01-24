/*
 * Save Contact into the database via AJAX 
 * Params: workroot, dialog, add/edit action, contact id if exists
 * Call php to execute insert / update query based on action
 * display ACK message and close modal
 */
function saveContact(workroot,dialog,action,id='')
{
    var ajaxURL;
    var successMessage;
    var errorMessage;
    if (action == 'add') {
        ajaxURL = workroot + "contact/add/";
        successMessage = "New record added.";
        errorMessage = "Unable to add new record.";
    } else if (action == 'edit') {
        ajaxURL = workroot + "contact/edit/" + id + "/";
        successMessage = "Record details updated.";
        errorMessage = "Unable to update details.";
    }
    var valid = true;
    valid = validate();
    if (valid == true) {
        $("#HideaddContact").html(
            "<img class='loader' src='" + workroot
                        + "/view/image/loading.gif' />"
        );
        var formData = new FormData($("#frmAddContact")[0]);
        $.ajax({
            url : ajaxURL,
            type : 'POST',
            data : formData,
            contentType : false,
            cache : false,
            processData : false,
            success : function (data) {
                if (data > 0) {
                    displayMessage("success-message", successMessage);
                    reloadContactList(workroot);
                } else {
                    displayMessage("error-message", errorMessage);
                }
            },
            error : function () {
                displayMessage("error-message", "Unexpected error.");
            }
        });
        closeDialog(dialog);
    }
}

function reloadContactList(workroot)
{
    var queryString = "";
    var tag = "";
    if ($("#queryString").length>0) {
        queryString = $("#queryString").val();
    }
    if ($("#contact-list-tag").length>0) {
        tag = $("#contact-list-tag").val() + "/";
    }
    $.ajax({
        url : workroot + "contact/ajax/" + tag + queryString,
        contentType : false,
        cache : false,
        processData : false,
        success : function (response) {
            $('#content').html(response);
        }
        
    });
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
/*
 * Validate Contact add / edit form Initialize Bool valid=true If valid=false
 * displays error message Returns bool
 */
function validate()
{
    var valid = true;
    var person_name = $('#name').val();
    $("#reg_email_info,#reg_name_info,#reg_customlabel_info,#reg_customvalue_info").html("").hide();
    
    if(!$('#name').val()){
        $("#name").addClass("error-color").show().focus();
        return false;
    }
    if(!validateEmail($('#user_email').val()+'@xlri.ac.in')){
        $("#user_email").addClass("error-color").show().focus();
        return false;
    }
    var els = ['user_mobile_no','user_landline_no','user_residential_no','user_office_no']; 
        
    for(var i=0; i<els.length; i++){
        if(/\D/.test($('#'+els[i]).val())){
            $("#"+els[i]).addClass("error-color").show();
            return false;
        }
    }

    if (trim(person_name) == "") {
        $("#reg_name_info").html("required.").addClass("error-color").show();
        $("#name").addClass("input-error");
        valid = false;
    }
    $(".custom-row").each(function () {
        var rowLabel = $(this).find(".input-label");
        var rowValue = $(this).find(".input-value");
        var errorMessageElemet = $(this).find(".reg_customvalue_info");
        if ($.trim(rowLabel.val()) != ""
                && $.trim(rowValue.val()) == "") {
            errorMessageElemet.html("required.")
                    .addClass("error-color").show();
            rowValue.addClass("input-error");
            valid = false;
        }
    });
    return valid;
}

function trim(value)
{
    return value.replace(/^\s+|\s+$/g,"");
}

/*
 * To append more custom row in add / edit Params: workroot to be prefixed
 * before file source
 */
function appendMore(workroot)
{
    var newCustomRecord = '<div class="custom-row row" name="row[]" id="row"><div class="col margin"><img class="custom-row-delete cursor-pointer" src="'
            + workroot
            + 'view/image/trash.gif" title="Delete" id="test-del-id" onClick="removeCustomRowHTML(this);"></div><div class="col"><div class="label">Label</div><div class="field"><input type="text" name="label[]" class="input-label"></div></div><div class="col float-right"><div class="label">Value <span class="reg_customvalue_info"></span></div><div class="field"><input type="text" name="value[]" class="input-value"></div></div></div>'
    $("#custom_addmore").append(newCustomRecord);
}

/*
 * To remove custom row HTML in add / edit Params: Delte element object
 */
function removeCustomRowHTML(obj)
{
    $(obj).parents('.custom-row').remove();
}

/*
 * To view delete confirmation box Params: id (Contact id / Custom id) Param:
 * btn_delete_id Delete button id btn_delete_id is to trigger delete action on
 * appropriate module
 */
function viewDelete(workroot, id, btn_delete_id)
{
    var viewDeleteModal = '<div id="modal-box" class="box-contain margin-zero-auto"><span>Are you sure want to delete?</span></div><div class="row form-btn"><span id="HideButtondelete"><button class="btn-outline btn-delete cursor-pointer"  name="deleteContact" id="'+btn_delete_id+'" data-contact-id="'+id+'" type="button"><span>Delete</span></button></span><button class="btn-outline btn-cancel cursor-pointer"  name="cancel" type="button"><span>Cancel</span></button></div>';
    openStaticDialog(workroot, viewDeleteModal, 'Delete','',false);
}

/*
 * To delete Contact via AJAX Param: workroot Param: id is the contact id Param:
 * dialog is the delete confirmation dialoag
 */
function deleteContact(workroot, id, dialog)
{
    $("#HideButtondelete").html(
        "<img class='loader' src='" + workroot
                    + "view/image/loading.gif' />"
    );
    var formData = new FormData($("#frmDelete")[0]);
    $.ajax({
        url : workroot + "contact/delete/" + id + "/",
        type : 'POST',
        data : formData,
        contentType : false,
        cache : false,
        processData : false,
        success : function (data) {
            if (data == 1) {
                displayMessage("success-message", "Record deleted.");
                reloadContactList(workroot);
            } else {
                displayMessage("error-message", "Unable to delete record.");
            }
            closeDialog(dialog);

        },
        error : function () {
            displayMessage("error-message", "Unexpected error.");
        }
    });
}


/*
 * To delete Custom Contact via AJAX Param: workroot Param: id is the custom id
 * Param: dialog is the delete confirmation dialoag
 */
function deleteCustom(workroot, id,dialog)
{
    $("#HideButtondelete").html(
        "<img class='loader' src='" + workroot
                    + "view/image/loading.gif' />"
    );
    var formData = new FormData($("#frmDelete")[0]);
    $.ajax({
        url : workroot + "contact/custom/delete/" + id + "/",
        type : 'POST',
        data : formData,
        contentType : false,
        cache : false,
        processData : false,
        success : function (data) {
            closeDialog(dialog);
            if (data == 1) {
                $('#row' + id).remove();
            } else {
                $('#row').html(data).show();
            }
        },
        error : function () {
            displayMessage("error-message", "Unexpected error.");
        }
    });
}

/*
 * To delete Contact photo via AJAX Param: workroot Param: id is the contact id
 * Param: dialog is the delete confirmation dialoag
 */
function deleteEntry(workroot, id)
{
    $.ajax({
        url : workroot + "contact/edit/photo/delete/" + id + "/",
        contentType : false,
        cache : false,
        processData : false,
        success : function (data) {
            // closeDialog(dialog);
            if (data == 1) {
                $('#row' + id).remove();
            } else {
                $('#row').html(data).show();
            }
        },
        error : function () {
            displayMessage("error-message", "Unexpected error.");
        }
    });
}

/*
 * To Favorite list via AJAX
 * 
 */
function favoriteList(workroot)
{
    $.ajax({
        url : workroot + "contact/favorite-list/",
        contentType : false,
        cache : false,
        processData : false,
        success : function (response) {
            $('#content').html(response);
        }
    });
}

function filterByDate(workroot)
{
    formData = new FormData($("#frmFilter")[0]);
    
    $.ajax({
        url : workroot + "contact/filter/",
        type : 'POST',
        contentType : false,
        cache : false,
        processData : false,
        data : formData,
        success : function (response) {
            $('#content').html(response);
        }
    });
}

function commonSearch(workroot,e)
{
    e.preventDefault();
    $.ajax({
        url : workroot + "contact/common-search/",
        type : 'POST',
        processData : false,
        data : 'search_keyword='+ $("#search_keyword").val(),
        success : function (response) {
            $('#content').html(response);
        }
    });
}
function contactImport(workRoot, dialog)
{
	var formData = new FormData($("#frmImportContact")[0]);
	$.ajax({
		url : workRoot + "contact/import/",
		type : 'POST',
		dataType: "JSON",
        data : formData,
        contentType : false,
        processData : false,
        success : function (response) {
	        if(response.Type == "Success") {
	            displayMessage("success-message", response.Message);
	            reloadContactList(workRoot);
	        } else {
	            displayMessage("error-message", response.Message);
	        }
        },
        error : function () {
            displayMessage("error-message", "Unexpected error.");
        }
	});
	closeDialog(dialog);
}

