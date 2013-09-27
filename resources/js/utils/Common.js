/**
 * @author David Curras
 * @version		June 15 2012
 * 
 * This class has static methods with general features
 */
var Common = function() { };

/**
 * Get the type for an element parsing the contructor funtion
 * 
 * @param		mixed		element
 * @returns		string
 * @type		static
 */
Common.GetType = function (element){
    var constructFunction = element.constructor.toString();
    var type = constructFunction.split('(')[0].substring(9);
    return $.trim(type);
};

/**
 * Get all the span.mail-address elements in the doc 
 * and converts to <a> mailto elements
 * 
 * @param		string		alt
 * @returns		string
 * @type		static
 * @see			http://www.html-advisor.com/javascript/hide-email-with-javascript-jquery/
 */
Common.GenerateMails = function(title){
	if(title == undefined){
		title = 'Send an email';
	}
	var spt = $('span.mail-address');
	var at = ' at ';
	var dot = ' dot ';
	var addr = $(spt).text().replace(at,"@").replace(dot,".");
	$(spt).after('<a href="mailto:'+addr+'" title="' + title + '">'+ addr +'</a>').hover(function(){window.status=title;}, function(){window.status="";});
	$(spt).remove();
}

/**
 * Get all params from an entire url
 * 
 * @param 		String		url
 * @returns 	Object
 * @type 		static
 */
Common.GetUrlParams = function (url){
	if(Validator.IsInstanceOf('string', url)){
		var arrayUrl = url.split('?');
		if(arrayUrl.length > 1){
			var arrayParams = url.split('?')[1].split('&');
		} else {
			var arrayParams = new Array();
		}
		var arrayTemp = new Array();
		if(arrayParams.length > 0){
			$.each(arrayParams, function(index, param){
				var paramText = '"' + param.split('=')[0] + '":"' + param.split('=')[1] + '"';
				arrayTemp.push(paramText);
			});
		}
		var paramObjectText = '{' + arrayTemp.join(',') + '}';
		return JSON.parse(Common.UrlCharsDecode(paramObjectText));
	} else {
		console.error('Common.GetUrlParams expects parameter "url" to be string');
		return {};
	}
};

/**
 * Get all characters from the string and decodes with utf-8
 * 
 * @param 		String		str
 * @returns 	String
 * @type 		static
 * @see			http://www.w3schools.com/jsref/jsref_replace.asp
 * @see			http://stuffofinterest.com/misc/utf8.php?s=128
 * @see			http://www.w3schools.com/tags/ref_urlencode.asp
 */
Common.UrlCharsDecode = function (str){
	if(Validator.IsInstanceOf('string', str)){
		//old browsers
		str = str.replace(/%C3%81/g,'Á');
		str = str.replace(/%C3%89/g,'É');
		str = str.replace(/%C3%8D/g,'Í');
		str = str.replace(/%C3%93/g,'Ó');
		str = str.replace(/%C3%9A/g,'Ú');
		str = str.replace(/%C3%91/g,'Ñ');
		str = str.replace(/%C3%9C/g,'Ü');
		str = str.replace(/%C3%A1/g,'á');
		str = str.replace(/%C3%A9/g,'é');
		str = str.replace(/%C3%AD/g,'í');
		str = str.replace(/%C3%B3/g,'ó');
		str = str.replace(/%C3%BA/g,'ú');
		str = str.replace(/%C3%B1/g,'ñ');
		str = str.replace(/%C3%BC/g,'ü');
		//new browsers
		str = str.replace(/%20/g,' ');
		str = str.replace(/%C1/g,'Á');
		str = str.replace(/%C9/g,'É');
		str = str.replace(/%CD/g,'Í');
		str = str.replace(/%D3/g,'Ó');
		str = str.replace(/%DA/g,'Ú');
		str = str.replace(/%D1/g,'Ñ');
		str = str.replace(/%DC/g,'Ü');
		str = str.replace(/%E1/g,'á');
		str = str.replace(/%E9/g,'é');
		str = str.replace(/%ED/g,'í');
		str = str.replace(/%F3/g,'ó');
		str = str.replace(/%FA/g,'ú');
		str = str.replace(/%F1/g,'ñ');
		return str.replace(/%FC/g,'ü');
	} else {
		console.error('Common.UrlCharsDecode expects parameter "str" to be string');
		return '';
	}
};