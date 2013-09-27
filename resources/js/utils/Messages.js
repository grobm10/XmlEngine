/**
 * @author David Curras
 * @version		June 15 2012
 * 
 * This class represents a html message
 */
var Messages = function() { };

/**
 * Shows a confirm message
 * 
 * @todo Improve with jquery
 */
Messages.Confirm = function(message){
	//Code to make 
}

/**
 * Creates a jQuery UI stantard dialog. The divId param is optional.
 * 
 * @param	String		divId
 * @param	String		title
 * @param	String		message
 * @param	Object		options
 * @return	jQueryDialog
 * @type	static
 */
Messages.RenderStandardDialog = function(divId, title, message, options){
	if(!Validator.IsInstanceOf('Object', options)){
		options = {};
	}
	options.modal = false;
	return Messages.RenderDialog(divId, title, message, options);
};

/**
 * Creates a jQuery UI modal dialog. The divId param is optional.
 * 
 * @param	String		divId
 * @param	String		title
 * @param	String		message
 * @param	Object		options
 * @return	jQueryDialog
 * @type	static
 */
Messages.RenderModalDialog = function(divId, title, message, options){
	//TODO: remove the next line and improve this feature
	$('div.ui-dialog').remove();
	if(!Validator.IsInstanceOf('Object', options)){
		options = {};
	}
	options.modal = true;
	return Messages.RenderDialog(divId, title, message, options);
};

/**
 * Creates a jQuery UI dialog. The divId param is optional.
 * 
 * @param	String		divId
 * @param	String		title
 * @param	String		message
 * @param	Object		options
 * @return	jQueryDialog
 * @type	static
 */
Messages.RenderDialog = function(divId, title, message, options){
	if(!Validator.IsInstanceOf('String', divId)){
		divId = 'dialog' + Messages.DialogCount;
	}
	if(!Validator.IsInstanceOf('String', title)){
		title = 'Notice';
	} else {
		options.title = title;
	}
	if(!Validator.IsInstanceOf('String', message)){
		console.error("Can't generate a model dialog with an empty message.");
		return;
	}
	var dialogHtml = '<div id="'+divId+'" class="dialog" title="'+title+'">'+message+'</div>';
	$('body').append(dialogHtml);
	if(options.height == null || isNaN(parseInt(options.height))){
		options.height = 'auto';
	}
	if(options.draggable == null){
		options.draggable = false;
	}
	if(options.modal == null){
		options.modal = false;
	}
	if(options.position == null){
		options.position = 'center';
	}
	if(options.resizable == null){
		options.resizable = false;
	}
	if(options.width == null || isNaN(parseInt(options.width))){
		options.width = 'auto';
	}
	return Messages.ShowDialog('#'+divId, options);
};

/**
 * This function creates a jQuery UI dialog. Params should be in expected form.
 * 
 * @param	String		selector
 * @param	Object		options
 * @return	jQueryDialog
 * @see		http://jqueryui.com/demos/dialog/
 * @type	static
 */
Messages.ShowDialog = function(selector, options){
	if(!Validator.IsInstanceOf('Object', options)){
		console.error('Messages.ShowDialog() expects parameter options to be an Object');
		return false;
	}
	var dialog = $(selector).dialog({
		autoOpen: true,
		closeOnEscape: true,
		draggable: options.draggable,
		height: options.height,
		hide: 'fade',
		modal: options.modal,
		position: options.position,
		resizable: options.resizable,
		show: 'fade',
		title: options.title,
		width: options.width,
		close: function(event, ui) {
			$(this).dialog('destroy');
			$(this).remove();
		}
	});
	if(options.closeText != null){
		$(selector).dialog('option', 'closeText', options.closeText);
	}
	++Messages.DialogCount;
	return dialog;
};

/**
 * The number of generated dialogs
 */
Messages.DialogCount = 0;