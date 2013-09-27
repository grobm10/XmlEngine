(function($) {
	$.fn.error = function() {
		this.notify(UI.State.Error, UI.Icon.Alert);
	}
	
	$.fn.warning = function() {
		this.notify(UI.State.Highlight, UI.Icon.Info);
	}
	
	$.fn.notify = function(state, icon) {
		this.replaceWith(function(i,html){
			var styledError = '<div class="' + state + ' ui-corner-all">';
			styledError += '<p class="' + state + '-text">';
			styledError += '<span class="ui-icon ' + icon + '"></span>';
			styledError += html;
			styledError += '</p></div>';
			return styledError;
		});
	}
})(jQuery);

UI = {};
UI.State = {};
UI.State.Default = 'ui-state-default';
UI.State.Hover = 'ui-state-hover';
UI.State.Active = 'ui-state-active';
UI.State.Error = 'ui-state-error';
UI.State.Highlight = 'ui-state-highlight';
UI.Icon = {};
UI.Icon.Alert = 'ui-icon-alert';
UI.Icon.Info = 'ui-icon-info';