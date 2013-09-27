/**
 * @author		David Curras
 * @version		Feb 15 2012
 * 
 * This class handles the public page.
 */
var LoginController = function() {

	/**
	 * Constructor.
	 */
	var init = function() {
		$('#wrapper').append('<form action="#"></form>');
		var loginForm = new Form('#wrapper form');
		var fieldCssClasses = 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only';
		loginForm.addTextField('id', 'User', null, fieldCssClasses, [Validator.NotEmpty]);
		loginForm.addPasswordField('password', 'Password', null, fieldCssClasses, [Validator.NotEmpty]);
		loginForm.addSubmitField('submit', 'Login');
		loginForm.render();
		var urlParams = Common.GetUrlParams(location.href);
		if(urlParams.failed != undefined){
			if(urlParams.failed == '1'){
				$('#wrapper form').after('<p class="success">Not sended</p>');
			}
		}
		Form.startListening(currentForm);
	}

	/**
	 * Handles the submits
	 */
	var listenSubmits = function() {
		$('#filters').delegate('div.comboBox select', 'change', function(event) {
			IndexView.RenderResults();
		});
	}
	
	/**
	 * Execute constructor.
	 */
	init();
	
	return {};
}