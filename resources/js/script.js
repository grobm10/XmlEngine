var ajaxController;
var paginateControl;
var mouseX = 0;
var mouseY = 0;

$(document).ready(function() {
	ajaxController = new Ajax();
	if(!Validator.IsOldBrowser()){
		$('#js-error').remove();
		Tooltip.Render();
		var pageId = $('#page').attr('title');
		switch(pageId.toUpperCase()){
			case 'INDEX':
				paginateControl = new Pagination();
				IndexView.RenderDevelopmentDialog();
				IndexController.Load();
				break;
			case 'LOGIN':
				//controller = new LoginController();
				break;
			case 'ADMIN':
				paginateControl = new Pagination();
				IndexView.RenderDevelopmentDialog();
				AdminController.Load();
				break;
			case 'CMD':
				break;
			case '403':
			case '404':
			case '500':
				break;
			default:
				console.error('Unable to recognize page id');
		}
	} else {
		var errorHtml = '<span class="ui-icon ui-icon-alert"></span>Internet Explorer 6 ? ';
		errorHtml += '<span class="thin">Your version of Internet Explorer is far too old. Please upgrade your browser.</span>';
		$('#js-error p').html(errorHtml);
	}
});

/**
 * Extends the String class adding the ucfirst method
 */
String.prototype.ucfirst = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}
