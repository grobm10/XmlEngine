/**
 * This class  performs server queries for Partner
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var PartnerModel = function(){ };

/**
 * Saves a Partner in the server
 *
 * @param		Partner			partner
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
PartnerModel.Save = function(partner, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'partner',
		action : 'save',
		params : partner
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.PartnerModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Partner from the server and gives it to the callback function
 *
 * @param		int				partnerId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
PartnerModel.FindById = function(partnerId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'partner',
		action : 'FindById',
		params : partnerId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Partner(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.PartnerModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Partners from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
PartnerModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'partner',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var partnersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					partnersArray.push(new Partner(genericObject));
				});
				uiFunction(partnersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.PartnerModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Partners from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
PartnerModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'partner',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var partnersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					partnersArray.push(new Partner(genericObject));
				});
				uiFunction(partnersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.PartnerModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Partners from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
PartnerModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'partner',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var partnersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					partnersArray.push(new Partner(genericObject));
				});
				uiFunction(partnersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.PartnerModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Partners from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
PartnerModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'partner',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var partnersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					partnersArray.push(new Partner(genericObject));
				});
				uiFunction(partnersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.PartnerModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Partner stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
PartnerModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'partner',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var partnerCount = parseInt(data.replace('"',''));
				uiFunction(partnerCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.PartnerModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};