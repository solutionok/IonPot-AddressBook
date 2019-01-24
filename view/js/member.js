function resetPassword(workroot, dialog) {
	var valid = true;
	valid = passwordvalidate();
	if (valid == true) {
		$("#HideaddPassword").html(
				"<img class='loader' src='" + workroot
						+ "view/image/loading.gif' />");
		var formData = new FormData($("#frmAddContact")[0]);
		$.ajax({
			url : workroot + "contact/admin/edit/",
			type : 'POST',
			data : formData,
			contentType : false,
			cache : false,
			processData : false,
			success : function(data) {
				if (data != "") {
					displayMessage("success-message", "Profile updated.");
				} else {
					displayMessage("error-message",
							"Unable to update profile.");
				}
			},
			error : function() {
				displayMessage("error-message", "Unexpected error.");
			}
		});
		closeDialog(dialog);
	}
}

function passwordvalidate() {

	var valid = true;
	var username = $('#username').val();
	var email = $('#email').val();
	var pwd = $('#password').val();
	$("#reg_username_info").html("").hide();
	$("#reg_email_info").html("").hide();
	$("#reg_pwd_info").html("").hide();
	var pwdRegex = /^([a-zA-Z0-9_.+-])+$/;
	var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(trim(username) == ""){
		$("#reg_username_info").html("Required. ").addClass("error-color").show();
		$("#username").addClass("input-error");
		valid = false;
	} else if(trim(username).length > 15){
		$("#reg_username_info").html("Maximum 15 Characters.").addClass("error-color").show();
		$("#username").addClass("input-error");
		valid = false;
	}
	if (email == "") {
		$("#reg_email_info").html("Required. ").addClass("error-color").show();
		$("#email").addClass("input-error");
		valid = false;
	} else if (email != "") {
		if (!emailRegex.test(email)) {
		$("#reg_email_info").html("Invalid.").addClass("error-color").show();
		$("#user_email").addClass("input-error");
		valid = false;
		}
	}
	if(pwd != ""){
	if (!pwdRegex.test(pwd)) {
		$("#reg_pwd_info").html("Invalid.").addClass("error-color").show();
		$("#password").addClass("input-error");
		valid = false;
	} else if (pwd.length < 6) {
		$("#reg_pwd_info").html("Minimum 6 characters.").addClass("error-color").show();
		$("#password").addClass("input-error");
		valid = false;
	}
}
	return valid;
}

function trim(value) {
    return value.replace(/^\s+|\s+$/g,"");
}

function memberAdd(workroot,dialog,action,id='') {
	var ajaxURL;
	var successMessage;
	var errorMessage;
	if(action == 'add') {
		ajaxURL = workroot + "contact/member/add/";
		successMessage = "New record added.";
		errorMessage = "Unable to add new record.";
	} else if(action == 'edit') {
		ajaxURL = workroot + "contact/member/edit/" + id + "/";
		successMessage = "Record details updated.";
		errorMessage = "Record is not updated.";
	}
	var valid = true;
	valid = passwordvalidate();
	if (valid == true) {
		$("#HideaddContact").html(
				"<img class='loader' src='" + workroot
						+ "/view/image/loading.gif' />");
		var formData = new FormData($("#frmAddContact")[0]);
		$.ajax({
			url : ajaxURL,
			type : 'POST',
			data : formData,
			contentType : false,
			cache : false,
			processData : false,
			success : function(data) {
				if (data > 0) {
					displayMessage("success-message", successMessage);
					reloadMemberList(workroot);
				} else {
					displayMessage("error-message", errorMessage);
				}
			},
			error : function() {
				displayMessage("error-message", "Unexpected error.");
			}
		});
		closeDialog(dialog);
	}
}

function viewDelete(workroot, id, btn_delete_id) {
	var viewDeleteModal = '<div id="modal-box" class="box-contain margin-zero-auto"><span>Are you sure want to delete?</span></div><div class="row form-btn"><span id="HideButtondelete"><button class="btn-outline btn-delete cursor-pointer"  name="deleteMember" id="'+btn_delete_id+'" data-member-id="'+id+'" type="button"><span>Delete</span></button></span><button class="btn-outline btn-cancel cursor-pointer"  name="cancel" type="button"><span>Cancel</span></button></div>';
	openStaticDialog(workroot, viewDeleteModal, 'Delete','',false);
}

function deleteMember(workroot, id, dialog) {
	$("#HideButtondelete").html(
			"<img class='loader' src='" + workroot
					+ "view/image/loading.gif' />");
	var formData = new FormData($("#frmDelete")[0]);
	$.ajax({
		url : workroot + "member/delete/" + id + "/",
		type : 'POST',
        data : formData,
        contentType : false,
		cache : false,
		processData : false,
		success : function(data) {
			if (data == 1) {
				displayMessage("success-message", "Record deleted.");
				reloadMemberList(workroot);
			} else {
				displayMessage("error-message", "Unable to delete record.");
			}
			closeDialog(dialog);
		},
		error : function() {
			displayMessage("error-message", "Unexpected error.");
		}
	});
}

function reloadMemberList(workroot) {
	var queryString = "";
	var tag = "";
	if($("#queryString").length>0) {
		queryString = $("#queryString").val();
	}
	if($("#contact-list-tag").length>0) {
		tag = $("#contact-list-tag").val() + "/";
	}
	$.ajax({
		url : workroot + "member/ajax/" + tag + queryString,
		contentType : false,
		cache : false,
		processData : false,
		success : function(response) {
			$('#content').html(response);
		}
		
	});
}