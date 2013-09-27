/**
 * This class renders the components in the public page
 *
 * @author		David Curras
 * @version		May 16, 2012
 */
var IndexView = function(){ };

IndexView.RenderDevelopmentDialog = function() {
	var dialogText = '<p>This product is in active development, and may changed at any time.';
	dialogText += ' Please be patient while we roll out features and fix bugs in this preview stage.</p>';
	dialogText += '<p class="highlight">Comments or problems? <a href="mailto:David.Curras@mtvnmix.com">Email</a></p>';
	var options = {
			height:'150',
			draggable:true,
			position:[30, 150],
			width:'300'
		};
	Messages.RenderStandardDialog('notice', 'Active development', dialogText, options);
};

IndexView.RenderFilters = function(data) {
	var html = '<div id="filters" class="ui-widget ui-widget-content ui-corner-all">';
	html += '	<div id="logo"><img src="../resources/img/mtv1.png" width="32px" alt="MTV Logo" /></div>';
	$.each(IndexController.Filters, function(filter, optionObjects){
		html += '	<div class="comboBox">';
		html += '		<label for="'+filter+'">'+filter.ucfirst()+':</label>';
		html += '		<select name="'+filter+'" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icons">';
		html += '			<option value="0">Choose...</option>';
		if(filter.toLowerCase() == 'language'){
			$.each(optionObjects, function(index, optionObj){
				html += '			<option value="'+optionObj.getCode()+'">'+optionObj.getName()+'</option>';
			});
		} else if(filter.toLowerCase() == 'region'){
			$.each(optionObjects, function(index, optionObj){
				html += '			<option value="'+optionObj.getCode()+'">'+optionObj.getCountry()+'</option>';
			});
		} else {
			$.each(optionObjects, function(index, optionObj){
				html += '			<option value="'+optionObj.getId()+'">'+optionObj.getName()+'</option>';
			});
		}
		html += '		</select>';
		html += '	</div>';
	});
	/*
	html += '	<div class="comboBox">';
	html += '		<label for="sort">Sort:</label>';
	html += '		<select name="sort" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icons">';
	html += '			<option value="0">Choose...</option>';
	html += '			<option value="1">Partner</option>';
	html += '			<option value="2">Region</option>';
	html += '			<option value="3">Language</option>';
	html += '		</select>';
	html += '	</div>';
	*/
	html += '	<div class="clearfix"></div>';
	html += '	<div id="search"><img src="../resources/img/search.png" alt="Manual Search" /></div>';
	html += '	<div id="login"><a href="login.php" title="Login"><img src="../resources/img/user.png" alt="Login" /></a></div>';
	html += '</div>';
	html += '<div id="searchBox" class="ui-widget ui-widget-content ui-corner-all">';
	html += '	<input type="text" value="" id="searchInput" name="searchInput" />';
	html += '</div>';
	html += '<div id="results"></div>';
	html += '<div id="details-wrapper"></div>';
	$('#wrapper').append(html);
	IndexController.ListenSearchButton();
	IndexController.ListenXlsButton();
};

IndexView.RenderResults = function() {
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
							//TODO: Make this for all partners
							if(episodes.partner.toUpperCase() == 'ITUNES' && episodes.type.toUpperCase() == 'TRANSPORTATION'){
								var genericFileName = process.getBundle().getVideo().getFileName().substring(0, process.getBundle().getVideo().getFileName().lastIndexOf("."));
								var failCell = '<a href="inbox/transportation/itunesdto/'+genericFileName+'.xml" target="_blank" title="See XmlEngine proposed xml file"><img src="../resources/img/success-page.png" alt="Xml Proposed File" /></a>';
								failCell += '<a href="inbox/transportation/itunesdto/'+genericFileName+'.itmsp/metadata.xml" target="_blank" title="See original xml file"><img src="../resources/img/fail-page.png" alt="Xml Original File" /></a>';
								failCell += '<img src="../resources/img/error.png" alt="Failed" title="'+process.getIssues()+'" />';
							} else {
								var failCell = '<img src="../resources/img/error.png" alt="Failed" title="'+process.getIssues()+'" />';
							}
							episodesTable += '				<td class="info">'+failCell+'</td>';
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
	IndexController.ListenDetails();
	$('#results').accordion({active:false, autoHeight:false, collapsible:true});
	//TODO: improve the xls button adding
	$('#excel').remove();
	$('#login').before('<div id="excel" title="Export to xls"><img src="../resources/img/excel.png" alt="Export to xls" /></div>');
	IndexController.ListenXlsButton();
};

IndexView.ShowDetails = function(process) {
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
	html += '	<tr>';
	html += '		<td class="left">Issues</td>';
	html += '		<td>'+process.getIssues()+'</td>';
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
};

IndexView.ShowSearchBox = function() {
	$('#searchInput').val(IndexController.SearchDefaultText);
	$('#searchBox').slideDown();
};

IndexView.HideSearchBox = function() {
	$('#searchBox').slideUp();
	$('#searchInput').removeClass('focused');
	$('#searchInput').val('');
};

IndexView.ShowXlsOptions = function() {
	var html = '<div id="xlsOptions">';
	html += '	<input type="radio" name="xlsType" value="csvSummary" checked="checked" /> Basic';
	html += '	<input type="radio" name="xlsType" value="csvDetailed" /> Detailed';
	html += '	<div class="clearfix"></div>';
	html += '	<div class="xlsButton"><img src="../resources/img/table-grey.png" alt="Export Grey Xls Table" title="Grey Style" /></div>';
	html += '	<div class="xlsButton"><img src="../resources/img/table-green.png" alt="Export Green Xls Table" title="Green Style" /></div>';
	html += '	<div class="xlsButton"><img src="../resources/img/table-blue.png" alt="Export Blue Xls Table" title="Blue Style" /></div>';
	html += '	<div class="xlsButton"><img src="../resources/img/table-white.png" alt="Export White Xls Table" title="White Style" /></div>';
	html += '	<div class="clearfix"></div>';
	html += '</div>';
	Messages.RenderModalDialog(null, 'Export to xls', html, {closeText:'hide', draggable:false});
	IndexController.ListenXlsExport();
};

IndexView.CleanUp = function() {
	$('#results').html('');
	$('#excel').remove();
};