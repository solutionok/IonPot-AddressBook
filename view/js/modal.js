function getModalWidth() {
	if($(window).width() > 660) {
		viewportWidth = 625;
	} else {
		viewportWidth = $(window).width()-100;
	}
	return viewportWidth;
}

function getModalContentHeight(height) {
	if(height != '') {		
		viewportHeight = height;
	} else {
		viewportHeight = $(window).height() - 30;
	}
	return viewportHeight;
}

function getLoaderHTML(work_root) {
	var loaderHTML = '<div id="modal-box"'
	+ ' class="box-contain margin-zero-auto box-contain modal-bottom-radius">'
	+ '<div class="modal-loader">' + '<img src="' + work_root
	+ '/view/image/loader.gif" width=64px height=64px />' + '</div>'
	+ '</div>';
	return loaderHTML;
}

function initDialog(target,loader,title,width) {
	var dialog = $(target).html(loader).dialog({
		title: title,
		width: width,
		height: 'auto',
		autoOpen: false,
	    modal: true,
	    resizable: true,
        draggable: false, 
	    position: {
		    my: "center top",
		    at: "center top",
		    of: window,
		    collision: "none"
	    }, 
	    create: function (event, ui) {
	    	// Customise close icon
		    var widget = $(this).dialog("widget");
	        $(".ui-dialog-titlebar-close span", widget).removeClass("ui-icon-closethick").addClass("ui-icon-custom-close");	
	        
	    },
	     beforeClose: function(event, ui) {
    	  $("body").css({ overflow: 'inherit' });
    	  $(dialog).dialog('widget').find('.ui-widget-header').show();
    	 }
	    
	});
	return dialog;
}

function openDialog(work_root, url, title,height='',form=false,plugins=false) {
	$("body").css({ overflow: 'hidden' })
	var viewportWidth = getModalWidth();
	var viewportHeight = getModalContentHeight(height);	
	var loaderContent = getLoaderHTML(work_root);	
	var dialog = initDialog($('#show-modal-content'),loaderContent,title,viewportWidth);
	$(dialog).load(work_root + url, function(){
		// Set modal inner content height
		if(height == '') {
			var modalTop = 0;
			if($(".ui-widget-content").length>0) {
				modalTop = parseInt($(".ui-widget-content").css("top"));
			}
			var modalHeaderHeight = 0;
			if($(".ui-dialog-titlebar").length>0) {
				modalHeaderHeight = parseInt($(".ui-dialog-titlebar").outerHeight());
			}
			var modalbtnContainder = 0;
			if($(".form-btn").length>0) {
				modalbtnContainder = parseInt($(".form-btn").outerHeight());
			}
			viewportHeight = viewportHeight - modalTop - modalHeaderHeight - modalbtnContainder;
		}
		$(this).dialog('widget').find('#modal-box').css("height",viewportHeight+"px");
		
		if(plugins) {
			initAllPlugins(work_root);
		}
		if(form) {
			if(title=="Delete") {
	    		$(dialog).dialog('widget').find('.ui-widget-header').hide();
	    		bindFormBtnAction(work_root,dialog);
	    	} else {
	    		bindFormBtnAction(work_root,dialog);
	    	}
	    }
		
	}).dialog('open');
	$('.ui-widget-overlay').bind( 'click', function() {
		closeDialog(dialog);
        $('.ui-widget-overlay').unbind();
    } );
}

function openStaticDialog(work_root, content, title,height='',form=false) {
	$("body").css({ overflow: 'hidden' })
	var viewportWidth = getModalWidth();
	var viewportHeight = getModalContentHeight(height);	
	var dialog = initDialog($('#show-modal-content'),content,title,viewportWidth);
	if(title=="Delete") {
		$(dialog).dialog('widget').find('.ui-widget-header').hide();
		bindFormBtnAction(work_root,dialog);
	}
	$(dialog).dialog('open');
	$('.ui-widget-overlay').bind( 'click', function() {
		closeDialog(dialog);
        $('.ui-widget-overlay').unbind();
    } );
}

function closeDialog(dialog) {
	$(dialog).dialog('close');
}