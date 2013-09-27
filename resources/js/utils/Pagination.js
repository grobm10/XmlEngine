/**
 * This class represents a pagination control
 */
var Pagination = function() {

	var _results;
	var _currentPage;
	var _numberOfPages;
	var _currentButton;
	
	/**
	 * Constructor.
	 */
	var _init = function(results) {
		_results = results;
		_currentButton = undefined;
		_calculateNumberOfPages();
		_currentPage = 1;
		_render();
	};
	
	/**
	 * Calculates the number of pages.
	 * 
	 * @return 		int
	 */
	var _calculateNumberOfPages = function(){
		var mod = Object.keys(_results).length % Pagination.GroupsPerPage;
		if(mod == 0){
			_numberOfPages = Object.keys(_results).length / Pagination.GroupsPerPage;
		} else {
			_numberOfPages = parseInt(Object.keys(_results).length / Pagination.GroupsPerPage) + 1;
		}
	};

	/**
	 * Generates a html paginator
	 * 
	 * @type private
	 */
	var _render = function() {
		if(_numberOfPages > 1){
			$('#pagination').remove();
			var paginationHtml = '<div id="pagination"></div>';
			paginationHtml += '<div class="clearfix"></div>';
			$('#results').before(paginationHtml);
			$('#pagination').css('position', 'relative')
				.css('float', 'right')
				.css('margin-top', '10px');
			var paginatorText = '';
			//Show the "prev page" button if correspond
			if (_currentPage > 1){
				paginatorText += '<div id="'+Pagination.ButtonPrefix+'Prev">PREV</div>';
			}
			//Show the "go to first page" button if correspond
			var areTherePagesOutOfTheShownRange = (_currentPage - 5) > 0;
			if (areTherePagesOutOfTheShownRange){
				paginatorText += '<div id="'+Pagination.ButtonPrefix+'First">...</div>';
			}
			for(var i=1; i <= _numberOfPages; i++){
				//Just the pages into the (-4;+4) range should be shown
				var isIntoTheShownRange = (i <= (_currentPage + 4)) && (i >= (_currentPage - 4));
				if (isIntoTheShownRange){
					if (i != _currentPage){
						paginatorText += '<div id="'+Pagination.ButtonPrefix+''+i+'" class="button">'+i+'</div>';
					} else {
						paginatorText += '<div id="'+Pagination.ButtonPrefix+''+i+'" class="button active">'+i+'</div>';
					}
				}
			}
			//Show the "go to last page" button if correspond
			areTherePagesOutOfTheShownRange = (_currentPage + 4) < _numberOfPages;
			if (areTherePagesOutOfTheShownRange){
				paginatorText += '<div id="'+Pagination.ButtonPrefix+'Last">...</div>';
			}
			//Show the "next page" button if correspond
			if (_currentPage < _numberOfPages){
				paginatorText += '<div id="'+Pagination.ButtonPrefix+'Next">NEXT</div>';
			}
			paginatorText += '<div class="clearfix"></div>';
			$('#pagination').append(paginatorText);
			//use jQuery UI buttons and adds set active feature
			$('#pagePrev, #pageFirst, #pageLast, #pageNext').button().click(function(){ _selectPageByControl(this); });
			$('#pagination div.button').button().click(function(){ _selectPage(this, true); });
			_selectPage($('#pagination div.active').button(), false);
		}
	};
	
	/**
	 * Sets the current page button as active and update results if needed
	 * 
	 * @param		jQuery-ui-Button		button
	 * @param		Boolean					mustRender
	 * @type		private
	 */
	var _selectPage = function (button, mustRender){
		//Showing clicked button as active
		if(_currentButton) {
			$(_currentButton).button('enable').removeClass('ui-state-active ui-state-hover'); 
		}    
		$(button).button('disable').addClass('ui-state-active').removeClass('ui-state-disabled');
		_currentButton = button;
		//rendering new page
		if(mustRender){
			_currentPage = parseInt($(_currentButton).attr('id').substr(Pagination.ButtonPrefix.length));
			_render();
			IndexView.RenderResults();
		}
	};
	
	/**
	 * Sets the proper button as active and update results
	 * 
	 * @param		jQuery-ui-Button		button
	 * @type		private
	 */
	var _selectPageByControl = function(button){
		var control = $(button).attr('id').substr(Pagination.ButtonPrefix.length);
		switch(control.toUpperCase()){
			case 'PREV':
				--_currentPage;
				break;
			case 'FIRST':
				_currentPage = 1;
				break;
			case 'LAST':
				_currentPage = _numberOfPages;
				break;
			case 'NEXT':
				++_currentPage;
				break;
			default:
				console.error('Unable to identify control button name. Pagination._selectPageByControl()');
		}
		_render();
		IndexView.RenderResults();
	};
	
	/**
	 * Removes result and pagination control
	 * 
	 * @type		private
	 */
	var _cleanUp = function(){
		_results = {};
		_currentButton = undefined;
		_numberOfPages = 1;
		_currentPage = 1;
		$('#pagination').remove();
	}
	
	/*
	 * Adds a combo box to select the number of groups to show per page
	 * 
	 * @type private
	 *
	var _addGroupsPerPageComboBox = function (){
		var gppCmbxText = "<div id='groupsPerPageSelectDiv'>";
		gppCmbxText += "<div class='dropControl'> Groups per page: ";
		gppCmbxText += "<select id='groupsPerPageSelect' name='groupsPerPageSelect'>";
		for(var i=1; i < 26; i++){
			gppCmbxText += "<option value='" + i + "'>" + i + "</option>";
		}
		gppCmbxText += "</select>";
		gppCmbxText += "</div>";
		gppCmbxText += "</div>";
		$('#pagination').append(gppCmbxText);
		$('#groupsPerPageSelect').val(Paginator.groupsPerPage);
	};
	*/
	
	/**
	 * Execute constructor.
	 */
	_init({});
	
	/**
	 * Return public properties and methods
	 */
	return{
		setResults:function(results) {
			_init(results);
		},
		
		getResults:function() {
			return _results;
		},
		
		getCurrentPage:function() {
			return _currentPage;
		},
		
		getFirstGroupInView:function() {
			//Calculates the number of the first group in the current view
			return (_currentPage - 1) * Pagination.GroupsPerPage;
		},
		
		getLastGroupInView:function() {
			//Calculates the number of the last group in the current view
			if(_currentPage == _numberOfPages){ 
				return Object.keys(_results).length;
			}
			return (_currentPage * Pagination.GroupsPerPage) - 1;
		},
		
		cleanUp:function() {
			_cleanUp();
		}
	}
}

Pagination.GroupsPerPage = 5;
Pagination.ButtonPrefix = 'page';