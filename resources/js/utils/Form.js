/**
 * This class represents a html form
 */
var Form = function(selector) { 
	
	var action;
	var method;
	var fields;
	
	/**
	 * Constructor.
	 */
	var init = function() {
		action = location.pathname;
		method = "post";
		if(Validator.IsInstanceOf('string', selector)){
			fields = new Array();
		} else {
			throw 'The constructor method expects parameter "selector" to be string';			
		}
	};
	
	/**
	 * Adds a specific field to the form
	 * 
	 * @param	string type
	 * @param	string name
	 * @param	string value
	 * @param	string css
	 * @param	string label
	 * @type	private
	 */
	var addField = function(selector, type, name, label, value, css, validators){
		var field = {
				'selector':selector,
				'type':type,
				'name':'',
				'label':'',
				'value':'',
				'css':'',
				'validators':[],
				'errors':''
			};
		if (Validator.IsInstanceOf('string', name)){
			field.name = name;
		}
		if (Validator.IsInstanceOf('string', label)){
			field.label = label;
		}
		if (Validator.IsInstanceOf('string', value)){
			field.value = value;
		}
		if (Validator.IsInstanceOf('string', css)){
			field.css = css;
		}
		if (Validator.IsInstanceOf('array', validators)){
			field.validators = validators;
		}
		fields.push(field);
	}
	
	/**
	 * Generates a html form
	 * 
	 * @type 	private
	 */
	var render = function() {
		if(Validator.IsInstanceOf('Array', fields)){
			var fieldsetText = '<fieldset>';
			$.each(fields, function(index, field){
				fieldsetText += renderField(field);
			});
			fieldsetText += '</fieldset>';
			$(selector).append(fieldsetText);
			$(selector).attr('action', action);
			$(selector).attr('method', method);
		}
	}

	/**
	 * Generates a html form field
	 * 
	 * @param field
	 * @return string
	 * @type private
	 */
	var renderField = function(field) {
		var fieldText = '';
		switch (field.type.toUpperCase()) {
			case 'TEXT':
			case 'PASSWORD':
				fieldText += '<label for="' + field.name + '">' + field.label + '</label>';
				fieldText += '<input type="' + field.type + '" name="' + field.name + '" ';
				fieldText += 'value="' + field.value + '" class="' + field.css + '" />';
				if (Validator.IsInstanceOf('string', field.errors)){
					fieldText += '<ul class="formErrors">' + field.errors + '</ul>';
				}
				break;
			case 'TEXTAREA':
				fieldText += '<label for="' + field.name + '">' + field.label + '</label>';
				fieldText += '<textarea name="' + field.name + '" class="' + field.css + '">';
				fieldText += field.value + '</textarea>';
				if (Validator.IsInstanceOf('string', field.errors)){
					fieldText += '<ul class="formErrors">' + field.errors + '</ul>';
				}
				break;
			case 'HIDDEN':
				fieldText += '<input type="' + field.type + '" value="' + field.value + '" ';
				fieldText += ' name="' + field.name + '" />';
				break;
			case 'SUBMIT':
			case 'RESET':
				fieldText += '<input type="' + field.type + '" value="' + field.value + '" ';
				fieldText += ' class="' + field.css + '" />';
				break;
		}
		return fieldText;
	}
	
	/**
	 * Execute constructor.
	 */
	init();
	return{

		/**
		 * This is a public interface to set the private property action
		 *
		 * @type public
		 */
		setAction:function(formAction) {
			action = formAction;
		},

		/**
		 * This is a public interface to set the private property method to "get"
		 *
		 * @type public
		 */
		setMethodGet:function() {
			method = 'get';
		},

		/**
		 * This is a public interface to get the private property selector
		 *
		 * @type public
		 */
		getSelector:function() {
			return selector;
		},

		/**
		 * This is a public interface to get the private property fields
		 *
		 * @type public
		 */
		getFields:function() {
			return fields;
		},
		
		/**
		 * This method uses the addField method to add a text field to the form
		 *
		 * @param	string name
		 * @param	string label
		 * @param	string value
		 * @param	string css
		 * @type	public
		 */
		addTextField:function(name, label, value, css, validators){
			if (Validator.IsInstanceOf('string', name) && Validator.IsInstanceOf('string', label)){
				var selector = 'input[name="' + name + '"]';
				addField(selector, 'text', name, label, value, css, validators);
			}
		},
		
		/**
		 * This method uses the addField method to add a password field to the form
		 *
		 * @param	string name
		 * @param	string label
		 * @param	string value
		 * @param	string css
		 * @type	public
		 */
		addPasswordField:function(name, label, value, css, validators){
			if (Validator.IsInstanceOf('string', name) && Validator.IsInstanceOf('string', label)){
				var selector = 'input[name="' + name + '"]';
				addField(selector, 'password', name, label, value, css, validators);
			}
		},
		
		/**
		 * This method uses the addField method to add a textarea field to the form
		 *
		 * @param	string name
		 * @param	string label
		 * @param	string value
		 * @param	string css
		 * @type	public
		 */
		addTextAreaField:function(name, label, value, css, validators){
			if (Validator.IsInstanceOf('string', name) && Validator.IsInstanceOf('string', label)){
				var selector = 'textarea[name="' + name + '"]';
				addField(selector, 'textarea', name, label, value, css, validators);
			}
		},
		
		/**
		 * This method uses the addField method to add a hidden field to the form
		 *
		 * @param	string name
		 * @param	string value
		 * @type	public
		 */
		addHiddenField:function(name, value){
			if (Validator.IsInstanceOf('string', name) && Validator.IsInstanceOf('string', value)){
				var selector = 'input[type="reset"]';
				addField(selector,'hidden', name, null, value, null);
			}
		},
		
		/**
		 * This method uses the addField method to add a reset field to the form
		 *
		 * @param	string name
		 * @param	string value
		 * @param	string css
		 * @type	public
		 */
		addResetField:function(name, value, css){
			if (Validator.IsInstanceOf('string', value)){
				var selector = 'input[type="reset"]';
				addField(selector,'reset', name, null, value, css);
			}
		},
		
		/**
		 * This method uses the addField method to add a submit field to the form
		 *
		 * @param	string name
		 * @param	string value
		 * @param	string css
		 * @type	public
		 */
		addSubmitField:function(name, value, css){
			if (Validator.IsInstanceOf('string', value)){
				var selector = 'input[type="submit"]';
				addField(selector,'submit', name, null, value, css);
			}
		},
		
		/**
		 * This is a public interface to call the private method render
		 * 
		 * @type public
		 */
		render:function() {
			return render();
		},
		
		/**
		 * This is a public interface to reset the errors on each field of the form
		 * 
		 * @type public
		 */
		resetErrors:function() {
			$.each(fields, function(index, field){
				field.errors = '';
			});
		}
	}
}

/**
 * Remove the entire fieldset of the given form
 * 
 * @param	string selector
 * @type 	static
 */
Form.Clear = function (selector){
	$(selector + ' fieldset').remove();
}

/**
 * Activates the form events
 * 
 * @param	Object form
 * @type	static
 */
Form.StartListening = function(form) {
	//Activate click event for submit button to validate fields. 
	$(form.getSelector() + ' input[type="submit"]').live('click', function(event) {
		$('#form p.loginError').remove();
		var validator = new Validator(form);
		var success = validator.validateAll();
		if(!success){
			event.preventDefault();
		}
    });
}