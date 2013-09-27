/**
 * This class has features to validate form fields.
 */
var Validator = function(currentForm) { 
	
	var success;
	
	/**
	 * Constructor.
	 */
	var init = function() {
		if(Validator.IsInstanceOf('object', currentForm)){
			success = true;
		} else {
			throw 'The constructor method expects parameter "currentForm" to be an object';			
		}
	};
	
	/**
	 * Validates all fields in currentForm
	 * 
	 * @type	private
	 */
	var validateAll = function(){
		var formFields = currentForm.getFields();
		currentForm.resetErrors();
		$.each(formFields, function(index, field){
			validateField(field);
		});
		if(success != true){
			Form.clear(currentForm.getSelector());
			currentForm.render();
		}
		return success;
	}

	/**
	 * Validates a specific field
	 * 
	 * @params	Object field
	 * @type	private
	 */
	var validateField = function(field){
		if (Validator.IsInstanceOf('Array', field.validators)){
			$.each(field.validators, function(index, validatorType){
				field.value = $(currentForm.getSelector() + ' ' + field.selector).val();
				var errorMesagge = performSpecificValidator(field.value, validatorType);
				if(Validator.IsInstanceOf('string', errorMesagge)){
					field.errors += '<li>' + errorMesagge + '</li>';
					success = false;
				}
			});
		}
	}
	
	/**
	 * Validates the fields value against a validator type
	 * 
	 * @params	string value
	 * @params	string validatorType
	 * @return	string
	 * @type	private
	 */
	var performSpecificValidator = function(value, validatorType){
		var errorMessage = null;
		switch (validatorType.toUpperCase()) {
			case 'NOTEMPTY':
				if(!Validator.IsInstanceOf('string', value)){
					errorMessage = 'This field can not be empty';
				}
				break;
			case 'ALPHA':
				var arraySpelled = value.split();
				$.each(arraySpelled, function(index, character){
					if(parseInt(character) != 'NaN'){
						errorMessage = 'This field just allow alpha chars';
						return false; //to break the $.each loop
					}
				});
				break;
			case 'NUMBER':
				var arraySpelled = value.split();
				$.each(arraySpelled, function(index, character){
					if(parseInt(character) == 'NaN'){
						errorMessage = 'This field just allow digits';
						return false; //to break the $.each loop
					}
				});
				break;
			case 'MAIL':
				var atPos = value.indexOf("@");
				var dotPos= value.lastIndexOf(".");
				if (atPos < 1 || dotPos < atPos+2 || dotPos+2 >= value.length){
					errorMessage = 'Please insert a valid mail';
				}
			default:
				console.error('Unable to recognize field validator type');
				break;
		}
		return errorMessage;
	}
	
	/**
	 * Execute constructor.
	 */
	init();
	return{
	
		/**
		 * This is a public interface to the private method validateAll
		 *
		 * @type public
		 */
		validateAll:function() {
			return validateAll();
		}
	}
}

/**
 * Enumerations for validator types
 */
Validator.NotEmpty = 'NotEmpty';
Validator.Alpha = 'Alpha';
Validator.Number = 'Number';
Validator.Mail = 'Mail';