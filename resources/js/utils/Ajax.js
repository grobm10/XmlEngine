/**
 * @author David Curras
 * @version		June 10 2012
 * 
 * This class handle ajax request with jQuery.
 */ 
var Ajax = function() { 

	var _stack;
	var _isProcessing;
	var _loadingDialog;
	var _isDialogOpen;
	var _loop;
	var _loopCount;
	
	/**
	 * Constructor
	 */
	var _init = function(){
		_stack = [];
		_isProcessing = false;
		_loadingDialog = null;
		_isDialogOpen = false;
		_loop = setInterval( function(){ _checkProcesses(); }, Ajax.LoopInterval);
		_loopCount = 0;
	};
	
	/**
	 * Checks if there are processes in the stack and triggers those processes when is needed
	 */
	var _checkProcesses = function(){
		++_loopCount;
		if(_stack.length > 0){
			if(!_isProcessing){
				_executeProcess(_stack[0]);
				_isProcessing = true;
				if(!_isDialogOpen){
					_renderLoadingMessage();
					_isDialogOpen = true;
				}
			}
			var loadingDots = Array((_loopCount%4)+1).join('.');
			$("#ui-dialog-title-loading-message").html('Loading'+loadingDots);
		} else {
			if(_isDialogOpen){
				_removeLoadingMessage();
			}
		}
	};
	
	/**
	 * Executes a process based in the number of elements of the process array
	 *
	 * @param		Array		process
	 */
	var _executeProcess = function(process){
		switch(process.length){
			case 1:
				process[0]();
				break;
			case 2:
				process[0](process[1]);
				break;
			case 3:
				process[0](process[1], process[2]);
				break;
			case 4:
				process[0](process[1], process[2], process[3]);
				break;
			case 5:
				process[0](process[1], process[2], process[3], process[4]);
				break;
			case 6:
				process[0](process[1], process[2], process[3], process[4], process[5]);
				break;
			default:
				console.error('Unsopported param number. ProcessController._execiteProcess()');
		}
	};
	
	/**
	 * Adds the process at the end of the stack
	 *
	 * @param		function		process
	 */
	var _addProcess = function(process){
		_stack.push(process);
		$('#loading-message img').attr('title', 'Processes in queue: '+_stack.length);
	};
	
	/**
	 * Remove the first process in the stack
	 */
	var _removeProcess = function(){
		if(_stack.length > 0){
			_stack.shift();
		} else {
			console.error('No more processes in the stack. ProcessController._removeProcess()');
		}
		$('#loading-message img').attr('title', 'Processes in queue: '+_stack.length);
		_isProcessing = false;
	};
	
	/**
	 * Shows a modal dialog with the "Data loading" message.
	 * @type static
	 */
	var _renderLoadingMessage = function (){
		var dialogHtml = '<div id="loading-message">';
		dialogHtml += '	<img src="../resources/img/loading.gif" alt="Loading..." title="Processes in queue: 0" width="100" />';
		dialogHtml += '</div>';
		$('#wrapper:ui-dialog').dialog('destroy');
		$('#loading-message').remove();
		$('#wrapper').append(dialogHtml);
		_loadingDialog = $("#loading-message").dialog({
			dialogClass: 'loading',
			closeText:'close',
			width: 130,
			closeOnEscape:false,
			draggable:false,
			title:'Loading...',
			resizable:false,
			modal: true
		});
		$("#loading-message").css('text-align', 'center');
		$("div.loading a.ui-dialog-titlebar-close").remove();
	};

	/**
	 * Destroy the "Data loading" modal dialog
	 * @type static
	 */
	var _removeLoadingMessage = function (){
		$(_loadingDialog).dialog('close');
		_isDialogOpen = false;
		$('#wrapper:ui-dialog').dialog('destroy');
		$('#loading-message').remove();
	};
	
	/**
	 * Executes constructor
	 */
	_init();

	/**
	 * Returns public functions
	 */
	return {
		
		'addProcess': function(process){
			_addProcess(process);
		},
		
		'removeProcess': function(){
			_removeProcess();
		}
	};
};
Ajax.LoopInterval = 500;

/**
 * URL of server ajax listener
 */
Ajax.Url = "../Utils/Server/Ajax.php";

/**
 * Http GET method identifier
 */
Ajax.HttpGet = "GET";

/**
 * Http POST method identifier
 */
Ajax.HttpPost = "POST";

/**
 * Performs an ajax request, with given params.
 * 
 * @param	mixed 		params
 * @param	function	callbackFunction
 * @param	mixed		callbackExtraParams
 * @param	string 		url
 * @param	string		method
 * @type	static
 */
Ajax.Perform = function (params, callbackFunction, callbackExtraParams, url, method) {
	if(url == undefined){
		url = Ajax.Url;
	}
	if(method == undefined){
		method = Ajax.HttpPost;
	}
	try {
		if(method == Ajax.HttpPost){					
			$.post(url, params, function(data, textStatus, jqXHR){
				//console.log(textStatus);
				//console.log(jqXHR);
				if(data == 'false'){
					console.error('Exception throwed, please read the log file.');
				}
				if(callbackExtraParams == undefined){
					callbackFunction(data);
				} else {
					callbackFunction(data, callbackExtraParams);
				}
				ajaxController.removeProcess();
				//TODO: remove one process or free the stack
			});
		} else {				
			$.get(url, params, function(data, textStatus, jqXHR){
				//console.log(textStatus);
				//console.log(jqXHR);
				if(data == 'false'){
					console.error('Exception throwed, please read the log file.');
				}
				if(callbackExtraParams == undefined){
					callbackFunction(data);
				} else {
					callbackFunction(data, callbackExtraParams);
				}
				ajaxController.removeProcess();
			});
		}
	} catch (e) {
		ajaxController.removeProcess();
		console.error('Exception at Ajax.Perform');
		console.error(e);
	}
};