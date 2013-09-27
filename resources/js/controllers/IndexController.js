/**
 * @author		David Curras
 * @version		Feb 15 2012
 * 
 * This class handles the public page.
 */
var IndexController = {};

IndexController.Filters = {};
IndexController.VideosCount = 0;
IndexController.SearchWait = 1200; //Milliseconds to wait before perform a search
IndexController.KeyPressedAt = 0; //System time when the last key was pressed
IndexController.KeyPressed = false;
IndexController.SearchDefaultText = 'Search for series, season, episode, genre or network';
IndexController.Loop = null;
IndexController.Results = {};

/**
 * Triggers initial processes
 */
IndexController.Load = function() {
	ajaxController.addProcess(new Array(PartnerModel.FetchAll, {}, IndexController.AddFilters, 'partner'));
	ajaxController.addProcess(new Array(RegionModel.FetchAll, {}, IndexController.AddFilters, 'region'));
	ajaxController.addProcess(new Array(LanguageModel.FetchAll, {}, IndexController.AddFilters, 'language'));
	var typeModelCallback = function(data){
			IndexController.AddFilters(data, 'process');
			IndexView.RenderFilters(); 
			IndexController.ListenSelects();
		};
	ajaxController.addProcess(new Array(TypeModel.FetchAll, {}, typeModelCallback));
	ajaxController.addProcess(new Array(ProcessModel.GetCount, {}, IndexController.GetCount));
	ajaxController.addProcess(new Array(ProcessModel.FindBy, {'where':'bundleId IS NOT NULL', 'orderBy':['processDate DESC']}, IndexController.ParseResults));
	IndexController.ListenKeyboard();
	IndexController.Loop = setInterval(function(){IndexController.ListenSearchs()}, 500);
};

/**
 * Handles the ajax results for filters
 *
 * @param		object		data
 * @param		String		filter
 */
IndexController.AddFilters = function(data, filter) {
	IndexController.Filters[filter] = data;
};

/**
 * Handles the inputs from the keypress event
 */
IndexController.GetCount = function(count) {
	IndexController.VideosCount = count;
	console.log("There are "+IndexController.VideosCount+" processes in the Database");
};
	
/**
 * Handles the inputs from the keypress event
 */
IndexController.ListenSelects = function() {
	$('#filters div.comboBox select').change(function(event) {
		IndexView.HideSearchBox();
		var partner = $('#filters select[name="partner"]').val();
		var region = $('#filters select[name="region"]').val();
		var language = $('#filters select[name="language"]').val();
		var queryParams = {where:{}, orderBy:['processes.processDate DESC']};
		if(!Validator.IsEmpty(partner) && (partner != 0)){
			queryParams.where.partnerId = partner;
		}
		if(!Validator.IsEmpty(region) && (region != 0)){
			queryParams.where.regionCode = region;
		}
		if(!Validator.IsEmpty(language) && (language != 0)){
			queryParams.where.languageCode = language;
		}
		//if no filters applied just fetch all
		if(!Validator.IsEmpty(queryParams.where)){
			ajaxController.addProcess(new Array(ProcessModel.FindByBundleProperties, queryParams, IndexController.ParseResults));
		} else {
			ajaxController.addProcess(new Array(ProcessModel.FindBy, {'where':'bundleId IS NOT NULL', 'orderBy':['processDate DESC']}, IndexController.ParseResults));
		}
	});
};

/**
 * Group episodes by region, language, serie and season number. 
 * Then calls the IndexView.Render function
 */
IndexController.ParseResults = function(data) {
	IndexController.CleanUp();
	var processType = $('#filters select[name="process"]').val();
	for(var index in data){
		var process = data[index];
		IndexController.Results['p'+process.getId()] = process;
	}
	var count = 0;
	var results = IndexController.GetResultsToShow(processType);
	for(var i in results){
		for(var j in results[i]){
			if(j != 'type' && j != 'partner' && j != 'region' && j != 'language' && j != 'serie' && j != 'season'){
				count++;
			}
		}
	}
	console.log('There are '+count+' episodes shown');
	paginateControl.setResults(results);
	IndexView.RenderResults();
};

/**
 * Removes the current result and pagination control
 */
IndexController.CleanUp = function() {
	IndexController.Results = {};
	IndexView.CleanUp();
	paginateControl.cleanUp();
}

/**
 * Group episodes by region, language, serie and season number for the given process type.
 */
IndexController.GetResultsToShow = function(processType) {
	var results = {};
	for(index in IndexController.Results){
		var process = IndexController.Results[index];
		if(processType == '0' || process.getType().getId() == processType){
			if(parseInt(process.getState().getId()) > 1){
				var groupId = 'p'+process.getType().getName();
				groupId += '_'+process.getBundle().getPartner().getName();
				groupId += '_'+process.getBundle().getLanguage().getCode();
				groupId += '_'+process.getBundle().getVideo().getMetadata().getDTOSeasonID();
				results[groupId] = {
						"type":process.getType().getName(),
						"partner":process.getBundle().getPartner().getName(),
						"region":process.getBundle().getRegion().getCode(),
						"language":process.getBundle().getLanguage().getCode(),
						"serie":process.getBundle().getVideo().getMetadata().getSeriesName(),
						"season":process.getBundle().getVideo().getMetadata().getSeasonNumber()
					};
			}
		}
	}
	for(index in IndexController.Results){
		var process = IndexController.Results[index];
		if(processType == '0' || process.getType().getId() == processType){
			if(parseInt(process.getState().getId()) > 1){
				var groupId = 'p'+process.getType().getName();
				groupId += '_'+process.getBundle().getPartner().getName();
				groupId += '_'+process.getBundle().getLanguage().getCode();
				groupId += '_'+process.getBundle().getVideo().getMetadata().getDTOSeasonID();
				var episodeNumber = process.getBundle().getVideo().getMetadata().getEpisodeNumber();
				results[groupId]['e'+episodeNumber] = process;
			}
		}
	}
	return results;
};

/**
 * Handles the "Show details" click event for results
 */
IndexController.ListenDetails = function() {
	$('img.processDetails').click(function(event) {
		var processId = parseInt($(event.target.parentElement).parent().attr('title').split(" ")[1]);
		if(processId < 1){
			console.error("Unable to get Process Id from row. IndexController.ListenDetails().");
		}
		var process = IndexController.Results['p'+processId];
		IndexView.ShowDetails(process);
	});
};

/**
 * Handles the inputs from the keypress event
 */
IndexController.ListenKeyboard = function() {
	$("body").keypress(function(event) {
		if($('#searchInput').is(':focus')){
			IndexController.KeyPressedAt = new Date().getTime();
			IndexController.KeyPressed = true;
		}
	});
};

/**
 * 
 */
IndexController.ListenSearchButton = function() {
	$('#search').click(function(event) {
		if($('#searchBox').is(":hidden")){
			IndexView.ShowSearchBox();
		} else {
			IndexView.HideSearchBox();
		}
	});
	$('#searchInput').val(IndexController.SearchDefaultText );
	$('#searchInput').focus(function(){
		if($(this).val() == IndexController.SearchDefaultText ){
			$(this).addClass('focused');
			$(this).val('');
		}
	});
	$('#searchInput').blur(function(){
		if($(this).val() == ''){
			IndexView.HideSearchBox();
		}
	});
};

/**
 * Listen for searchs
 */
IndexController.ListenSearchs = function() {
	var elapsedTime = new Date().getTime() - IndexController.KeyPressedAt;
	if(IndexController.KeyPressed && ($('#searchInput').val().length > 1) && ($('#searchInput').val() != IndexController.SearchDefaultText) && (elapsedTime > IndexController.SearchWait)){
		var queryParams = {
			procedure: 'SearchMetadata',
			args: ['%'+$('#searchInput').val()+'%']
		};
		//queryParams.text = $('#searchInput').val();
		//queryParams.fields = ['seriesName','seasonName','episodeName','genre','dTOSeasonName','dTOEpisodeName','dTOGenre'];
		ajaxController.addProcess(new Array(IndexController.Search, queryParams, IndexController.ParseResults));
		IndexController.KeyPressed = false;
	}
};

/**
 * Retrieves all Processs from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
IndexController.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'abstract',
		action : 'Call',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var processsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					processsArray.push(new Process(genericObject));
				});
				uiFunction(processsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response. IndexController.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * 
 */
IndexController.ListenXlsButton = function() {
	$('#excel').click(function(event) {
		IndexView.ShowXlsOptions();
	});
};

/**
 * 
 */
IndexController.ListenXlsExport = function() {
	$('#xlsOptions div.xlsButton').click(function(event) {
		var type = $('#xlsOptions input:radio[name=xlsType]:checked').val();
		var style = $(event.target).attr('title').toLowerCase();
		if(style.indexOf("grey") >= 0){
			style = 1;
		} else if(style.indexOf("green") >= 0){
			style = 2;
		} else if(style.indexOf("blue") >= 0){
			style = 3;
		} else {
			style = 0;
		}
		var partner = $('#filters select[name="partner"]').val();
		var region = $('#filters select[name="region"]').val();
		var language = $('#filters select[name="language"]').val();
		var queryParams = '';
		if(!Validator.IsEmpty(partner) && (partner != 0)){
			queryParams += '&params[where][partnerId]='+partner;
		}
		if(!Validator.IsEmpty(region) && (region != 0)){
			queryParams += '&params[where][regionCode]='+region;
		}
		if(!Validator.IsEmpty(language) && (language != 0)){
			queryParams += '&params[where][languageCode]='+language;
		}
		//if no filters applied just fetch all
		if(queryParams != ''){
			window.open('../Triggers/CvsExporter.php?type='+type+'&style='+style+'&action=FindByBundleProperties'+queryParams);
		} else {
			window.open('../Triggers/CvsExporter.php?type='+type+'&style='+style+'&action=FetchAll');
		}
	});
};