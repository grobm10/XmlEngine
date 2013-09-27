/**
 * @author		David Curras
 * @version		Feb 15 2012
 * 
 * This class handles the public page.
 */
var AdminController = {};

AdminController.Results = {};

/**
 * Triggers initial processes
 */
AdminController.Load = function() {
	AdminView.RenderMenu();
	ajaxController.addProcess(new Array(ProcessModel.FetchAll, {'orderBy':['processDate DESC']}, AdminController.ParseResults));
};
/**
 * Group episodes by region, language, serie and season number. 
 * Then calls the AdminView.Render function
 */
AdminController.ParseResults = function(data) {
	for(index in data){
		var process = data[index];
		AdminController.Results['p'+process.getId()] = process;
	}
	AdminView.Load(0);
};

/**
 * Group episodes by region, language, serie and season number for the given process type.
 */
AdminController.GetResultsToShow = function(processType) {
	var results = {};
	for(index in AdminController.Results){
		var process = AdminController.Results[index];
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
	for(index in AdminController.Results){
		var process = AdminController.Results[index];
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
AdminController.ListenDetails = function() {
	$('#results div.ui-accordion-content td.info img.processDetails').click(function(event) {
		var processId = parseInt($(event.target.parentElement).parent().attr('title').split(" ")[1]);
		if(processId < 1){
			console.error("Unable to get Process Id from row. AdminController.ListenDetails().");
		}
		var process = AdminView.Results['p'+processId];
		AdminView.ShowDetails(process);
	});
};