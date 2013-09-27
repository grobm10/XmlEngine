/**
 * This class renders the components in the public page
 *
 * @author		David Curras
 * @version		May 16, 2012
 */
var AdminView = function(){ };

AdminView.RenderMenu = function() {
	var menuHtml = '<div id="menu">';
	menuHtml += '	<ul>';
	menuHtml += '		<li><a href="#Merge">Merge</a></li>';
	menuHtml += '		<li><a href="#Conversion">Conversion</a></li>';
	menuHtml += '		<li><a href="#Transportation">Transportation</a></li>';
	menuHtml += '		<li><a href="#Importation">Importation</a></li>';
	menuHtml += '		<li><a href="#Triggers">Triggers</a></li>';
	menuHtml += '		<li><a href="#Help">Help</a></li>';
	menuHtml += '	</ul>';
	menuHtml += '	<div id="Merge">';
	menuHtml += '		<form action="../Triggers/MergeProcess.php" method="post" enctype="multipart/form-data">';
	menuHtml += '			<fieldset class="ui-corner-all ui-widget-overlay">';
	menuHtml += '				<legend class="ui-corner-all ui-state-default">Select a partner:</legend>';
	menuHtml += '				<div class="radio">';
	menuHtml += '					<input type="radio" id="radioMerge1" name="partner" value="itunes" checked="checked" /><label for="radioMerge1">iTunes</label>';
	menuHtml += '					<input type="radio" id="radioMerge2" name="partner" value="sony" /><label for="radioMerge2">Sony</label>';
	menuHtml += '					<input type="radio" id="radioMerge3" name="partner" value="xbox" /><label for="radioMerge3">Xbox</label>';
	menuHtml += '				</div>';
	menuHtml += '				<div class="clearfix"></div>';
	menuHtml += '				<button>Run Merge</button>';
	menuHtml += '			</fieldset>';
	menuHtml += '		</form>';
	menuHtml += '	</div>';
	menuHtml += '	<div id="Conversion">';
	menuHtml += '		<form action="#" method="post" enctype="multipart/form-data">';
	menuHtml += '			<fieldset class="ui-corner-all ui-widget-overlay">';
	menuHtml += '				<legend class="ui-corner-all ui-state-default">Select a partner:</legend>';
	menuHtml += '				<div class="radio">';
	menuHtml += '					<input type="radio" id="radioConv1" name="partner" value="itunes" checked="checked" /><label for="radioConv1">iTunes</label>';
	menuHtml += '					<input type="radio" id="radioConv2" name="partner" value="sony" /><label for="radioConv2">Sony</label>';
	menuHtml += '					<input type="radio" id="radioConv3" name="partner" value="xbox" /><label for="radioConv3">Xbox</label>';
	menuHtml += '				</div>';
	menuHtml += '				<div class="clearfix"></div>';
	menuHtml += '				<button>Run Conversion</button>';
	menuHtml += '			</fieldset>';
	menuHtml += '		</form>';
	menuHtml += '	</div>';
	menuHtml += '	<div id="Transportation">';
	menuHtml += '		<form action="#" method="post" enctype="multipart/form-data">';
	menuHtml += '			<fieldset class="ui-corner-all ui-widget-overlay">';
	menuHtml += '				<legend class="ui-corner-all ui-state-default">Select a partner:</legend>';
	menuHtml += '				<div class="radio">';
	menuHtml += '					<input type="radio" id="radioTran1" name="partner" value="itunes" checked="checked" /><label for="radioTran1">iTunes</label>';
	menuHtml += '					<input type="radio" id="radioTran2" name="partner" value="sony" /><label for="radioTran2">Sony</label>';
	menuHtml += '					<input type="radio" id="radioTran3" name="partner" value="xbox" /><label for="radioTran3">Xbox</label>';
	menuHtml += '				</div>';
	menuHtml += '				<div class="clearfix"></div>';
	menuHtml += '				<button>Run Transportation</button>';
	menuHtml += '			</fieldset>';
	menuHtml += '		</form>';
	menuHtml += '	</div>';
	menuHtml += '	<div id="Importation">';
	menuHtml += '		<form action="#" method="post" enctype="multipart/form-data">';
	menuHtml += '			<fieldset class="ui-corner-all ui-widget-overlay">';
	menuHtml += '				<legend class="ui-corner-all ui-state-default">Select a file to import:</legend>';
	menuHtml += '				<div class="radio">';
	menuHtml += '					<input type="radio" id="radioImpo1" name="partner" value="itunes" /><label for="radioImpo1">iTunes</label>';
	menuHtml += '					<input type="radio" id="radioImpo2" name="partner" value="sony" /><label for="radioImpo2">Sony</label>';
	menuHtml += '					<input type="radio" id="radioImpo3" name="partner" value="xbox" checked="checked" /><label for="radioImpo3">Xbox</label>';
	menuHtml += '				</div>';
	menuHtml += '				<input type="file" name="file" id="file" />';
	menuHtml += '				<div class="clearfix"></div>';
	menuHtml += '				<input type="submit" name="submit" value="Submit" />';
	menuHtml += '			</fieldset>';
	menuHtml += '		</form>';
	menuHtml += '	</div>';
	menuHtml += '	<div id="Triggers"></div>';
	menuHtml += '	<div id="Help"></div>';
	menuHtml += '</div>';
	menuHtml += '<div id="details-wrapper"></div>';
	$('#wrapper').prepend(menuHtml);
	$('#menu').tabs({
			selected:0,
			select: function(event, ui) {
				var selected = ui.index;
				AdminView.Load(selected);
			}
		});
	$('#menu form div.radio').buttonset();
	$('#menu form button').click(function(event) {
			event.preventDefault();
		});
	$('#menu').append('<div id="logout"><a href="logout.php" title="Logout"><img src="../resources/img/logout.png" alt="Logout" /></a></div>');
	$('#Merge form button').click(function() {window.open('../Triggers/MergeProcess.php');});
	$('#Conversion form button').click(function() {window.open('../Triggers/ConversionProcess.php');});
	$('#Transportation form button').click(function() {window.open('../Triggers/TransportationProcess.php');});
}

/**
 * Load the intial data on the requested tab
 * 
 * @param		int			selected
 * @type		static
 */
AdminView.Load = function(selected) {
	switch(selected){
		case 0:
		case "Merge":
			$('#results').remove();
			$('#Merge').append('<div id="results"></div>');
			var results = AdminController.GetResultsToShow(1);
			paginateControl.setResults(results);
			AdminView.RenderResults();
			break;
		case 1:
		case "Conversion":
			$('#results').remove();
			$('#Conversion').append('<div id="results"></div>');
			var results = AdminController.GetResultsToShow(2);
			paginateControl.setResults(results);
			AdminView.RenderResults();
			break;
		case 2:
		case "Transportation":
			$('#results').remove();
			$('#Transportation').append('<div id="results"></div>');
			var results = AdminController.GetResultsToShow(3);
			paginateControl.setResults(results);
			AdminView.RenderResults();
			break;
		case 3:
		case "Importation":
			$('#results').remove();
			$('#Importation').append('<div id="results"></div>');
			var results = AdminController.GetResultsToShow(4);
			paginateControl.setResults(results);
			AdminView.RenderResults();
			break;
		case 4:
		case "Triggers":
			//var triggers = new TriggersController();
			break;
		case 5:
		case "Help":
		    window.open('https://docs.google.com/document/d/1HEsq0zn-yJOYx8Ubkft3LNCUcaAVShuPD0XEXs6urZQ/edit');
			break;
		default:
			console.error('Unable to identify selected tabs. AdminView.Load()');
			break;
	}
}


AdminView.RenderResults = function() {
	var results = paginateControl.getResults();
	var html = '';
	if(!Validator.IsEmpty(results)){
		var i = 0;
		$.each(results, function(groupId, episodes){
			if(i < paginateControl.getFirstGroupInView()){
				++i;
				return true; //it is a continue sentence
			}
			if(i >  paginateControl.getLastGroupInView()){
				return false; //it is a break sentence
			}
			++i;
			var episodesTable = '<div>';
			episodesTable += '	<table>';
			episodesTable += '		<thead>';
			episodesTable += '			<tr class="first">';
			episodesTable += '				<th class="info"> </th>';
			episodesTable += '				<th>File Name</th>';
			episodesTable += '				<th>Episode</th>';
			episodesTable += '				<th>Process</th>';
			episodesTable += '				<th>Date</th>';
			episodesTable += '				<th class="info"> </th>';
			episodesTable += '			</tr>';
			episodesTable += '		</thead>';
			episodesTable += '		<tbody>';
			var objLength = Object.keys(episodes).length;
			var allSuccess = true;
			var allFailed = true;
			var j = 0;
			$.each(episodes, function(episode, process){
				if(episode != 'type' && episode != 'partner' && episode != 'region' && episode != 'language' && episode != 'serie' && episode != 'season'){
					if((objLength-j) > 1){
						episodesTable += '			<tr title="Process '+process.getId()+'">';
					} else {
						episodesTable += '			<tr class="last" title="Process '+process.getId()+'">';
					}
					episodesTable += '				<td class="info"><img src="../resources/img/search.png" alt="Details" title="See details" class="processDetails" /></td>';
					episodesTable += '				<td>'+process.getBundle().getVideo().getFileName()+'</td>';
					episodesTable += '				<td>'+process.getBundle().getVideo().getMetadata().getEpisodeNumber()+' - '+process.getBundle().getVideo().getMetadata().getDTOEpisodeName()+'</td>';
					episodesTable += '				<td>'+process.getType().getName().toLowerCase().ucfirst()+'</td>';
					episodesTable += '				<td>'+process.getProcessDate()+'</td>';
					switch(process.getState().getName().toUpperCase()){
						case 'NONSTARTED':
							episodesTable += '				<td class="info"><img src="../resources/img/error.png" alt="Non Started" title="Non Started" /></td>';
							break;
						case 'STARTED':
							episodesTable += '				<td class="info"><img src="../resources/img/start.png" alt="Started" title="Started" /></td>';
							break;
						case 'INCOMPLETE':
							episodesTable += '				<td class="info"><img src="../resources/img/warning.png" alt="Incomplete" title="Incomplete" /></td>';
							break;
						case 'SUCCESS':
							episodesTable += '				<td class="info"><img src="../resources/img/accept.png" alt="Success" title="Success" /></td>';
							break;
						case 'FAILED':
							episodesTable += '				<td class="info"><img src="../resources/img/error.png" alt="Failed" title="Failed" /></td>';
							break;
						default:
							episodesTable += '				<td class="info"><img src="../resources/img/question.png" alt="?" title="?" /></td>';
							console.error('Unable to process state');
					}
					episodesTable += '			</tr>';
					allSuccess = allSuccess && (process.getState().getName().toUpperCase() == 'SUCCESS');
					allFailed = allFailed && (process.getState().getName().toUpperCase() == 'FAILED');
				}
				++j;
			});
			episodesTable += '		</tbody>';
			episodesTable += '	</table>';
			episodesTable += '</div>';
			html += '<h2>';
			html += '	<a href="#">';
			html += '		Process: <span class="value">'+episodes.type+'</span>';
			html += '		Partner: <span class="value">'+episodes.partner+'</span>';
			html += '		Region: <span class="value">'+episodes.region.toUpperCase()+'</span>';
			html += '		Show: <span class="value">'+episodes.serie+'</span>';
			html += '		Season: <span class="value">'+episodes.season+'</span>';
			if(allSuccess && !allFailed){
				html += '		<span class="icon"><img src="../resources/img/accept.png" alt="Success" title="Success" /></span>';
			} else if(!allSuccess && allFailed){
				html += '		<span class="icon"><img src="../resources/img/error.png" alt="Failed" title="Failed" /></span>';
			} else if(!allSuccess && !allFailed){
				html += '		<span class="icon"><img src="../resources/img/warning.png" alt="Incomplete" title="Incomplete" /></span>';
			} else {
				html += '		<span class="icon"><img src="../resources/img/question.png" alt="?" title="?" /></span>';
			}
			html += '	</a>';
			html += '</h2>';
			html += episodesTable;
		});
	} else {
		html += '<h2>';
		html += '	<a href="#">No results...</a>';
		html += '</h2>';
		html += '<div></div>';
	}
	$('.ui-accordion').accordion("destroy");
	$('#results').html(html);
	AdminController.ListenDetails();
	$('#results').accordion({active:false, autoHeight:false, collapsible:true});
}

AdminView.ShowDetails = function(process) {
	var language = process.getBundle().getLanguage().convertToArray();
	var video = process.getBundle().getVideo().convertToArray();
	var metadata = process.getBundle().getVideo().getMetadata().convertToArray();
	var html = '<table class="details">';
	html += '	<tr class="header">';
	html += '		<td colspan="2">Process</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">Id</td>';
	html += '		<td>'+process.getId()+'</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">Date</td>';
	html += '		<td>'+process.getProcessDate()+'</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">Type</td>';
	html += '		<td>'+process.getType().getName()+'</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">State</td>';
	html += '		<td>'+process.getState().getName()+'</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">Entity Id</td>';
	html += '		<td>'+process.getBundle().getEntityId()+'</td>';
	html += '	</tr>';
	html += '	<tr class="header">';
	html += '		<td colspan="2">Partner</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">Id</td>';
	html += '		<td>'+process.getBundle().getPartner().getId()+'</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">Name</td>';
	html += '		<td>'+process.getBundle().getPartner().getName()+'</td>';
	html += '	</tr>';
	html += '	<tr class="header">';
	html += '		<td colspan="2">Region</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">Code</td>';
	html += '		<td>'+process.getBundle().getRegion().getCode()+'</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left">Country</td>';
	html += '		<td>'+process.getBundle().getRegion().getCountry()+'</td>';
	html += '	</tr>';
	html += '	<tr class="header">';
	html += '		<td colspan="2">Language</td>';
	html += '	</tr>';
	$.each(language, function(key,value){
		html += '	<tr>';
		html += '		<td class="left">'+key.ucfirst()+'</td>';
		html += '		<td>'+value+'</td>';
		html += '	</tr>';
	});
	html += '	<tr class="header">';
	html += '		<td colspan="2">Video</td>';
	html += '	</tr>';
	$.each(video, function(key,value){
		if(key.toLowerCase() != 'metadata' && value != ''){
			html += '	<tr>';
			html += '		<td class="left">'+key.ucfirst()+'</td>';
			html += '		<td>'+value+'</td>';
			html += '	</tr>';
		}
	});
	html += '	<tr class="header">';
	html += '		<td colspan="2">Metadata</td>';
	html += '	</tr>';
	$.each(metadata, function(key,value){
		if(value != ''){
			html += '	<tr>';
			html += '		<td class="left">'+key.ucfirst()+'</td>';
			html += '		<td>'+value+'</td>';
			html += '	</tr>';
		}
	});
	html += '<table>';
	Messages.RenderModalDialog(null, video.fileName, html, {closeText:'hide', draggable:true});
}