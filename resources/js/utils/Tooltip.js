/**
 * This class represents a Tooltip
 *
 * @author		David Curras
 * @version		October 10, 2012
 */
var Tooltip = function(_cssSelector, _text) {
	
	var _isVisible;
	
	/**
	 * Constructor
	 */
	var _init = function(){
		$('#tooltip').html(_text);
		_isVisible = false;
		//TODO: test scroll function
		//TODO: improve for handle bubble
		$(_cssSelector).mouseenter(function() {
			if(!_isVisible){
				console.log('mouseenter');
				$('#tooltip').css('display', 'block');
				_isVisible = true;
			}
		});
		$(_cssSelector).mouseleave(function(){
			if(_isVisible){
				console.log('mouseleave');
				$('#tooltip').css('display', 'none');
				_isVisible = false;
			}
		});
	};
	
	/**
	 * Executes constructor
	 */
	_init();

	/**
	 * Returns public functions
	 */
	return { 
		'setText': function(text){
			_text = text;
			$('#tooltip').html(_text);
		}
	};
};

/**
 * Listen mouse move to get position
 */
Tooltip.Render = function(){
	$('body').append('<div id="tooltip"></div>');
	$('#tooltip').css('position', 'absolute')
		.css('display', 'none')
		.css('top', '0')
		.css('left', '0')
		.css('padding', '5px')
		.css('border', '#000 solid 1px')
		.css('color', '#000')
		.css('font-size', '12px')
		.css('font-family', 'verdana')
		.css('background-color', '#fff')
		.css('z-index', '3000');
	Tooltip.Listen();
}


/**
 * Listen mouse move to get position
 */
Tooltip.Listen = function(){
	$(document).mousemove(function(event){
		$('#tooltip').css('top', event.pageY+'px')
			.css('left', event.pageX+'px');
	});
};