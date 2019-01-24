/**
 * show the success-message or error-message as fade-in fade-out
 */
function displayMessage(style, message)
{
    var $div = $('<div />').appendTo('body');
    // success-message is the class for success message
    $div.attr('class', 'message-container')
            .html("<span>" + message + "</span>");
    $div.addClass(style);
    var message_width = parseInt($('.message-container').width()) + 82;
    var message_margin_left = (message_width / 2);
    var message_position_top = parseInt($(window).scrollTop()) + 80;
    $('.message-container')
            .css("margin-left", "-" + message_margin_left + "px");
    $('.message-container').css("top", message_position_top + "px");
    $div.delay(2000).fadeOut(2000, function () {
        $(this).remove();
    });
}

$(document)
        .ready(
            function () {
                    $(document)
                            .click(
                                function (e) {
                                        var target = $(e.target);

                                    if (($('#search-myDropdown').is(
                                        ":visible"
                                    ) == true)
                                                && !(target
                                                        .is("#search-myDropdown"))
                                                && !(target.is("#filter-img"))
                                                && ($("#search-myDropdown")
                                                        .has(target).length == 0)) {
//                                        hideElement('search-myDropdown')
                                    }
                                    if (target.is("#filter-img")) {
//                                        toggleElement('search-myDropdown');
                                    }

                                    if (($('#right-myDropdown').is(
                                        ":visible"
                                    ) == true)
                                                && !(target.is("#menu"))) {
                                        hideElement('right-myDropdown')
                                    }
                                    if (target.is("#menu")) {
                                        toggleElement('right-myDropdown');
                                    }

                                }
                            );
            }
        );

function toggleElement(elementId)
{
    $("#" + elementId).toggle();
}

function hideElement(elementId)
{
    $("#" + elementId).hide();
}

function toggleFavorite(workroot, favorite, id)
{
    $("#favorite").html(
        "<img class='loader' src='" + workroot
                    + "/view/image/loading.gif' />"
    );
    $
            .ajax({
                url : workroot + "contact/favorite/" + favorite + "/" + id
                        + "/",
                type : 'POST',
                success : function (data) {
                    var favoriteIcon;
                    if (favorite == 1) {
                        favoriteIcon = "<img id='img-favorite' width='20' title='Remove from Favorite' src='"
                                + workroot
                                + "view/image/icon-favorited.png' onclick=\"toggleFavorite('"
                                + workroot + "',0, " + id + ");\" />";
                    } else {
                        favoriteIcon = "<img id='img-favorite' width='20' title='Add to Favorite' src='"
                                + workroot
                                + "view/image/icon-favorite.png' onclick=\"toggleFavorite('"
                                + workroot + "',1, " + id + ");\" />";
                    }
                    $("#favorite").html(favoriteIcon);
                },
        error : function () {
            displayMessage("error-message", "Unexpected error.");
        }
            });
}

function initTagsinput(workroot)
{
    var relationship = new Bloodhound({
        datumTokenizer : Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer : Bloodhound.tokenizers.whitespace,
        prefetch : {
            url : workroot + 'view/relationship.json',
            filter : function (list) {
                return $.map(list, function (name) {
                    return {
                        name : name
                    };
                });
            }
        }
    });

    relationship.initialize();
    $('#group').tagsinput({
        typeaheadjs : {
            name : 'relationship',
            displayKey : 'name',
            valueKey : 'name',
            source : relationship.ttAdapter()
        }
    });
}

function initDatepicker()
{
    $('input[data-toggle="datepicker"]').datepicker({
        autoHide : true,
        format : "dd-mm-yyyy"
    });
}

function initFineUploader(workroot)
{
    var allowedExtensions = [ 'jpg', 'png', 'jpeg', 'gif', 'bmp', 'bpg' ];
    var uploader = new qq.FineUploader(
        {
            debug : true,
            element : document.getElementById('single-fine-uploader'),
            template : 'qq-template',
            request : {
                endpoint : workroot + "view/fine-uploader/endpoint.php",
                accessKey : "AKIAJB6BSMFWTAXC5M2Q"
            },
            signature : {
                endpoint : workroot
                        + "view/fine-uploader/endpoint-cors.php"
            },
            uploadSuccess : {
                endpoint : workroot
                        + "view/fine-uploader/endpoint-cors.php?success",
                params : {
                    isBrowserPreviewCapable : qq.supportedFeatures.imagePreviews
                }
            },
            iframeSupport : {
                localBlankPagePath : ""// "/server/success.html"
            },
            cors : {
                expected : true
            },
            chunking : {
                enabled : false
            },
            resume : {
                enabled : true
            },
            deleteFile : {
                enabled : true,
                method : "POST",
                endpoint : workroot
                        + "view/fine-uploader/endpoint-cors.php"
            },
            validation : {
                allowedExtensions : allowedExtensions,
                itemLimit : 1,
                sizeLimit : 2048000
            },
            thumbnails : {
                placeholders : {
                    notAvailablePath : workroot
                            + "vendor/fine-uploader/placeholders/not_available-generic.png",
                    waitingPath : workroot
                            + "vendor/fine-uploader/placeholders/waiting-generic.png"
                }
            },
            callbacks : {
                onComplete : function (id, name, response) {
                    var previewLink = qq(this.getItemByFileId(id))
                            .getByClass('preview-link')[0];

                    if (response.success) {
                        // previewLink.setAttribute("href",
                        // response.tempLink)
                        var singleimgURL = response.uuid + '/' + response.uploadName;
                        $("#featured_image_url").append(
                            "<input type='hidden' name='image_url' value='"
                                        + singleimgURL + "' />"
                        );
                    }
                }
            }
            }
    );
}

function initCollapse()
{
    $(function () {
        $("#accordion").accordion({
            collapsible : true,
            active : false,
            heightStyle : "content"
        });
    });
}

function initAllPlugins(work_root)
{
    initDatepicker();
    initTagsinput(work_root);
    initFineUploader(work_root);
    initCollapse();
}

function bindFormBtnAction(work_root, dialog)
{
    $('.btn-save').bind('click', function () {
        var btnId = $(this).attr('id');
        if (btnId == "addContact") {
            saveContact(work_root, dialog, 'add');
        } else if (btnId == "editContact") {
            var contactId = $(this).data("contact-id");
            saveContact(work_root, dialog, 'edit', contactId);
        } else if (btnId == "changePassword") {
            resetPassword(work_root, dialog);
        } else if (btnId == "add-member") {
            memberAdd(work_root, dialog, 'add');
        } else if (btnId == "editMember") {
            var memberId = $(this).data("member-id");
            memberAdd(work_root, dialog, 'edit', memberId);
        } else if(btnId == "importContactBtn") {
        	contactImport(work_root, dialog);
        }
    });
    $('.btn-delete').bind('click', function () {
        var btnId = $(this).attr('id');
        if (btnId == "delete-contact") {
            var contactId = $(this).data("contact-id");
            deleteContact(work_root, contactId, dialog);
        } else if (btnId == "delete-custom") {
            var contactCustomId = $(this).data("custom-id");
            deleteCustom(work_root, contactCustomId, dialog);
        }
        if (btnId == "delete-member") {
            var contactId = $(this).data("member-id");
            deleteMember(work_root, contactId, dialog);
        }
    });
    // Bind Cancel button click event to close dialog
    $('.btn-cancel').bind('click', function () {
        closeDialog(dialog);
    });
}

function mouseHoverHighlight(list)
{
    $('#' + list + ' tbody')
            .on(
                'mouseover',
                'tr',
                function () {
                        $(this).css("background-color", "#F0F0F0");
                    if ($(this).children("td").last().children('.action').length > 0) {
                        $(this).children("td").last().children('.action')
                                .removeClass("hide-action");
                        $(this).children("td").last().children('.action')
                                .addClass("show-action");
                    } else {
                        var actionIconHTML = $(this).children("td").first()
                                .children('.icon-html').html();
                        $(this).children("td").last().append(
                            '<span class="action show-action float-right">'
                                        + actionIconHTML + '<span>'
                        );
                    }

                }
            );
    $('#' + list + ' tbody').on(
        'mouseout',
        'tr',
        function () {
                $(this).css("background-color", "#FFF");
                $(this).children("td").last().children('.action').removeClass(
                    "show-action"
                );
                $(this).children("td").last().children('.action').addClass(
                    "hide-action"
                );
        }
    );
}
