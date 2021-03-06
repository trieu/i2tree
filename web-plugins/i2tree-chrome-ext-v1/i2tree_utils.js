﻿String.prototype.replaceAll = function(stringToFind, stringToReplace) {
	var temp = this;
	var index = temp.indexOf(stringToFind);
	while (index != -1) {
		temp = temp.replace(stringToFind, stringToReplace);
		index = temp.indexOf(stringToFind);
	}
	return temp;
};

// postMessage HTML5
window.addEventListener("message", function(event) {	
	// ...
}, false);


var i2treeLoadScript = function(path, callback) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = path;   
    if (callback instanceof Function) {       
        script.onload = function(){
			callback.apply({}, []);
			console.log(path + ' loaded');			
		};
    }	
	document.getElementsByTagName('head')[0].appendChild(script);    	
};

var i2treeUtil = {selectedHtml : ''};

i2treeUtil.cookie = function(key, value, options) {
	if (arguments.length > 1 && String(value) !== "[object Object]") {
		options = (typeof options === 'object') ? options : {};
		if (value === null || value === undefined) {
			options.expires = -1;
		}
		if (typeof options.expires === 'number') {
			var days = options.expires, t = options.expires = new Date();
			t.setDate(t.getDate() + days);
		}
		value = String(value);
		return (document.cookie = [encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value),
			options.expires ? '; expires=' + options.expires.toUTCString() : '',
			options.path ? '; path=' + options.path : '', options.domain ? '; domain=' + options.domain : '',
			options.secure ? '; secure' : ''].join(''));
	}
	options = value || {};
	var result, decode = options.raw ? function(s) {
		return s;
	} : decodeURIComponent;
	return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};

i2treeUtil.getSelectedHtml = function() {
	var html = "";
	
	if (typeof window.getSelection != "undefined") {
		var sel = window.getSelection();
		if (sel.rangeCount) {
			var container = document.createElement("div");
			for (var i = 0, len = sel.rangeCount; i < len; ++i) {
				container.appendChild(sel.getRangeAt(i).cloneContents());
			}
			html = container.innerHTML;
		}
	} else if (typeof document.selection != "undefined") {
		if (document.selection.type == "Text") {
			html = document.selection.createRange().htmlText;
		}
	}
	if(html == "" && i2treeUtil.selectedHtml != ""){
		return i2treeUtil.selectedHtml;
	}
	return html;
};

i2treeUtil.selectedNodeHandler = function(e) {
	if (e.which === 3) {
		i2treeUtil.selectedHtml = jQuery("<p>").append(jQuery(this).eq(0).clone()).html();
		if( jQuery(this).get(0).nodeName === 'IMG' ){
			//TODO
		} else if( jQuery(this).get(0).nodeName === 'A' ){
			//TODO
		}
	}
};

i2treeUtil.getKeywords = function(){
	var meta = jQuery('meta[name="keywords"]');
	if(meta.length === 1 )
		return meta.attr('content');
	return '';
};

if(location.href.indexOf('http') ===  0){
	jQuery('img[src],a[href]').mousedown(i2treeUtil.selectedNodeHandler);
	var imgs = jQuery('img:not([src^="http"])');
	imgs.each(function(){
		var img = jQuery(this);
		var src = img.attr('src');
		var curUrl = location.href;
		var useBase = false;
		if(jQuery('base').length == 1){
			var baseHref = jQuery('base').attr('href'); 
			var i = baseHref.indexOf('://');
			var protocol = baseHref.substring(0,i);
			var temp = baseHref.substring(i+3);
			if(src.indexOf('/') === 0 ) {
				curUrl = protocol + '://' + temp.substring(0,temp.indexOf('/'));
			} else {
				curUrl = protocol + '://' + temp.substring(0,temp.lastIndexOf('/'));
			}
			//console.log('curUrl ' + curUrl);
			useBase = true;
		}
		if(src){
			src = src.trim();
			if(src.indexOf('data:image') != 0){
				var fullSrc = '';
				if(src.indexOf('//') === 0 ){
					fullSrc = location.protocol + src;
				} else if(src.indexOf('/') === 0 ){
					if(useBase){
						fullSrc = curUrl + src;
					} else {
						fullSrc = location.protocol + '//' +  location.host + src;
					}
				} else {				
					
					var a = curUrl.lastIndexOf('://');
					var b = curUrl.lastIndexOf('/');
					if(a > b){
						//no slash e.g: http://a.com
						fullSrc = curUrl + '/' + src;
					} else {
						//exist slash in URL e.g: http://a.com/a/
						if(b + 1 === curUrl.length){
							//e.g: http://a.com/a/
							fullSrc = curUrl + src;
						} else {
							//e.g: http://a.com/a/b.php							
							if(useBase){
								fullSrc = curUrl + '/' + src;
							} else {
								fullSrc = curUrl.substring(0,b) + '/' + src;
							}							
						}					
					}	
					//console.log('curUrl ' + curUrl);
					//console.log('src ' + src);
					//console.log('fullSrc ' + fullSrc);
				}		
				img.attr('src',fullSrc);
			}
		}
	});	

	var aNodes = jQuery('a:not([href^="http"])');
	aNodes.each(function(){
		var aNode = jQuery(this);
		var href = aNode.attr('href');
		if(href){
			href = href.trim();
						
			//console.log(href + " " + href.indexOf(':'));
			if(href.indexOf(':') < 0 && href.indexOf('#') < 0 ){	
				var fullHref = '';
				if(jQuery('base').length == 1){
					var baseHref = jQuery('base').attr('href'); 
					if(href.indexOf('/') >= 0 ){
						fullHref = baseHref + href;
					} else {
						fullHref = baseHref + '/' + href;
					}					
				} else {
					if(href.indexOf('//') === 0 ){
						fullHref = location.protocol + href;
					}else if(href.indexOf('/') === 0 ){
						fullHref = location.protocol + '//' +  location.host + href;
					} else {
						var curUrl = location.href;
						var a = curUrl.lastIndexOf('://');
						var b = curUrl.lastIndexOf('/');
						if(a > b){
							//no slash e.g: http://a.com
							fullHref = curUrl + '/' + href;
						} else {
							//exist slash in URL e.g: http://a.com/a/
							if(b + 1 === curUrl.length){
								//e.g: http://a.com/a/
								fullHref = curUrl + href;
							} else {
								//e.g: http://a.com/a/b.php
								fullHref = curUrl.substring(0,b) + '/' + href;
							}					
						}				
					}	
				}				
				aNode.attr('href',fullHref);
			}
		}		
	});
}

chrome.extension.onRequest.addListener(function(request, sender, sendResponse) {
	// alert('method: '+request.method);
	var m = request.method;	
	if(m === 'getSelectedHtml'){		
		var data = {};
		data.title = document.title.trim();		
		data.html = i2treeUtil.getSelectedHtml();		
		data.keywords = i2treeUtil.getKeywords();	
		console.log(data);
		sendResponse({			
			'data' : JSON.stringify(data)
		});
	} else if (m === 'getCurrentUrl') {
		sendResponse({
			href : location.href
		});
	}  else {
		sendResponse({}); // snub them.
	}
});