/**
 * This class  performs server queries for Bundle
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var BundleModel = function(){ };

/**
 * Saves a Bundle in the server
 *
 * @param		Bundle			bundle
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.Save = function(bundle, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'save',
		params : bundle
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Bundle from the server and gives it to the callback function
 *
 * @param		int				bundleId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.FindById = function(bundleId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'FindById',
		params : bundleId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Bundle(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Bundles from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var bundlesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					bundlesArray.push(new Bundle(genericObject));
				});
				uiFunction(bundlesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Bundles from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var bundlesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					bundlesArray.push(new Bundle(genericObject));
				});
				uiFunction(bundlesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Bundles from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.FindByVideoProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'FindByVideoProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var bundlesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					bundlesArray.push(new Bundle(genericObject));
				});
				uiFunction(bundlesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.FindByVideoProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Bundles from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.FindByLanguageProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'FindByLanguageProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var bundlesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					bundlesArray.push(new Bundle(genericObject));
				});
				uiFunction(bundlesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.FindByLanguageProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Bundles from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.FindByRegionProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'FindByRegionProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var bundlesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					bundlesArray.push(new Bundle(genericObject));
				});
				uiFunction(bundlesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.FindByRegionProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Bundles from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.FindByPartnerProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'FindByPartnerProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var bundlesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					bundlesArray.push(new Bundle(genericObject));
				});
				uiFunction(bundlesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.FindByPartnerProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Bundles from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var bundlesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					bundlesArray.push(new Bundle(genericObject));
				});
				uiFunction(bundlesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Bundles from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var bundlesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					bundlesArray.push(new Bundle(genericObject));
				});
				uiFunction(bundlesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Bundle stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
BundleModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'bundle',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var bundleCount = parseInt(data.replace('"',''));
				uiFunction(bundleCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.BundleModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};