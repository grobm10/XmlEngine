/**
 * This class  performs server queries for Language
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var LanguageModel = function(){ };

/**
 * Saves a Language in the server
 *
 * @param		Language			language
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LanguageModel.Save = function(language, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'language',
		action : 'save',
		params : language
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LanguageModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Language from the server and gives it to the callback function
 *
 * @param		int				languageId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LanguageModel.FindById = function(languageId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'language',
		action : 'FindById',
		params : languageId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Language(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LanguageModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Languages from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LanguageModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'language',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var languagesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					languagesArray.push(new Language(genericObject));
				});
				uiFunction(languagesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LanguageModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Languages from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LanguageModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'language',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var languagesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					languagesArray.push(new Language(genericObject));
				});
				uiFunction(languagesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LanguageModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Languages from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LanguageModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'language',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var languagesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					languagesArray.push(new Language(genericObject));
				});
				uiFunction(languagesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LanguageModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Languages from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LanguageModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'language',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var languagesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					languagesArray.push(new Language(genericObject));
				});
				uiFunction(languagesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LanguageModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Language stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LanguageModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'language',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var languageCount = parseInt(data.replace('"',''));
				uiFunction(languageCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LanguageModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};