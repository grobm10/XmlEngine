/**
 * This class  performs server queries for Video
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var VideoModel = function(){ };

/**
 * Saves a Video in the server
 *
 * @param		Video			video
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
VideoModel.Save = function(video, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'video',
		action : 'save',
		params : video
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.VideoModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Video from the server and gives it to the callback function
 *
 * @param		int				videoId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
VideoModel.FindById = function(videoId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'video',
		action : 'FindById',
		params : videoId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Video(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.VideoModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Videos from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
VideoModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'video',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var videosArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					videosArray.push(new Video(genericObject));
				});
				uiFunction(videosArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.VideoModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Videos from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
VideoModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'video',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var videosArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					videosArray.push(new Video(genericObject));
				});
				uiFunction(videosArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.VideoModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Videos from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
VideoModel.FindByMetadataProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'video',
		action : 'FindByMetadataProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var videosArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					videosArray.push(new Video(genericObject));
				});
				uiFunction(videosArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.VideoModel.FindByMetadataProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Videos from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
VideoModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'video',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var videosArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					videosArray.push(new Video(genericObject));
				});
				uiFunction(videosArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.VideoModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Videos from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
VideoModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'video',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var videosArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					videosArray.push(new Video(genericObject));
				});
				uiFunction(videosArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.VideoModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Video stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
VideoModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'video',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var videoCount = parseInt(data.replace('"',''));
				uiFunction(videoCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.VideoModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};