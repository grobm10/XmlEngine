/**
 * This class  performs server queries for Region
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var RegionModel = function(){ };

/**
 * Saves a Region in the server
 *
 * @param		Region			region
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RegionModel.Save = function(region, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'region',
		action : 'save',
		params : region
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RegionModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Region from the server and gives it to the callback function
 *
 * @param		int				regionId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RegionModel.FindById = function(regionId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'region',
		action : 'FindById',
		params : regionId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Region(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RegionModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Regions from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RegionModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'region',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var regionsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					regionsArray.push(new Region(genericObject));
				});
				uiFunction(regionsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RegionModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Regions from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RegionModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'region',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var regionsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					regionsArray.push(new Region(genericObject));
				});
				uiFunction(regionsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RegionModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Regions from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RegionModel.FindByLanguageProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'region',
		action : 'FindByLanguageProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var regionsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					regionsArray.push(new Region(genericObject));
				});
				uiFunction(regionsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RegionModel.FindByLanguageProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Regions from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RegionModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'region',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var regionsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					regionsArray.push(new Region(genericObject));
				});
				uiFunction(regionsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RegionModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Regions from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RegionModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'region',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var regionsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					regionsArray.push(new Region(genericObject));
				});
				uiFunction(regionsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RegionModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Region stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RegionModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'region',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var regionCount = parseInt(data.replace('"',''));
				uiFunction(regionCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RegionModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};