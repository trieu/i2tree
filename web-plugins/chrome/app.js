
String.prototype.replaceAll = function(stringToFind, stringToReplace) {
	var temp = this;
	var index = temp.indexOf(stringToFind);
	while (index != -1) {
		temp = temp.replace(stringToFind, stringToReplace);
		index = temp.indexOf(stringToFind);
	}
	return temp;
};

var port = chrome.extension.connect();
var baseAgentUrl = 'http://localhost:10001';
var agentStatus = false;

var postDataLink = function(tags) {	
	var postUrl = baseAgentUrl + '/infocrawler/addNewEntryToDropbox/json?';
	var data = {'functors':{}};
	
	//alert(jQuery.data(document.body,"functors") );
	data.functors = JSON.parse(jQuery("body").attr('functors'));
	
	//pre-process here
	data.functors.F_Page.tags = tags.split(',');

	//now prepare for sending
	data.functors = JSON.stringify(data.functors);	

	jQuery.post(postUrl, data , function(response) {
		console.log(response);
		// chrome.extension.sendRequest({bg_method: "takeScreenshot"},
		// function(response) { console.log(response.message); });
	});
	return true;
};

chrome.extension.onRequest.addListener(function(request, sender, sendResponse) {
	// alert('method: '+request.method);
	var m = request.method;
	
	if(m === 'getSelectedHtml'){		
		var data = {};
		data.title = document.title.trim();		
		data.html = i2treeUtil.getSelectedHtml();
		data.name = data.title.replace(/[^a-z0-9]/gi, '_').toLowerCase();
		data.keywords = jQuery('meta[name="keywords"]').attr('content');	
		sendResponse({			
			'data' : JSON.stringify(data)
		});
	} else if (m === 'postDataLink') {
		if(postDataLink(request.tags)){
			sendResponse({href : location.href});
		}
		// Brain2.UI.popupCenter("http://google.com", 500, 450);		
	} else if (m === 'getCurrentUrl') {
		sendResponse({
			href : location.href
		});
	} else if (m === 'getAgentStatus') {
		sendResponse({
			agentStatus : agentStatus
		});	
	} else if (m === 'getPageMetaInfo') {
		sendResponse({
			pageMetaInfo : Brain2.analytics.pageMetaInfo()
		});	
	} else if (m === 'crawlingMyFacebook') {
		fetchFacebookDataFeed();
	} else {
		sendResponse({}); // snub them.
	}
});

// postMessage HTML5
window.addEventListener("message", function(event) {	
	if (event.origin !== baseAgentUrl )
		return;		
	// ...
}, false);

var postSaveDataByMethodPOST = function(tags) {
	var href = location.href;
	var postUrl = baseAgentUrl + '/linkmarking/save/html?';
	var metaInfo = Brain2.analytics.pageMetaInfo();

	/*
	 * // FB parser var text = ''; var collector = function(){ text +=
	 * (jQuery(this).text()); }; jQuery('span.messageBody').each(collector);
	 */

	var theIframeId = '__brain2_ext_handler';
	if (jQuery('#__brain2_ext_handler').length === 0) {
		var targetIframe = jQuery("<iframe/>").attr({
			'style' : 'display:none',
			'id' : theIframeId
		});
		jQuery('body').append(targetIframe);
	}

	var form = jQuery("<form/>").attr({
		'method' : 'POST',
		'action' : postUrl,
		'target' : theIframeId
	});

	var field;
	field = jQuery("<input/>").attr({
		'type' : 'hidden',
		'name' : 'href',
		'value' : encodeURIComponent(href)
	});
	form.append(field);

	field = jQuery("<input/>").attr({
		'type' : 'hidden',
		'name' : 'title',
		'value' : metaInfo['title']
	});
	form.append(field);

	field = jQuery("<input/>").attr({
		'type' : 'hidden',
		'name' : 'description',
		'value' : metaInfo['description']
	});
	form.append(field);

	field = jQuery("<input/>").attr({
		'type' : 'hidden',
		'name' : 'tags',
		'value' : tags
	});
	form.append(field);

	jQuery('body').append(form);
	form.submit();
};

var fetchFacebookDataFeed = function() {
	var feeds = jQuery('#profile_minifeed').find('> li');
	feeds.each(function() {
		var href = jQuery(this).find('a.external').attr('href');
		if (href) {
			console.log("-------------------------------");
			console.log(href);
			console.log(jQuery(this).find('div.uiAttachmentTitle a').text());
			console.log(jQuery(this).find('div.uiAttachmentDesc').text());

			var msg = jQuery(this).find('span.messageBody').text();
			console.log(msg);
		}
	});
	jQuery('#profile_pager').find('a.uiMorePagerPrimary').click();
};

var i2treeUtil = {selectedHtml : ''};
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

jQuery('img[src],a[href]').mousedown(i2treeUtil.selectedNodeHandler);
var imgs = jQuery('img:not([src^="http"])');
imgs.each(function(){
	var img = jQuery(this);
	var src = img.attr('src');
	if(src){
		src = src.trim();
		if(src.indexOf('data:image') != 0){
			var fullSrc = '';
			if(src.indexOf('//') === 0 ){
				fullSrc = location.protocol + src;
			} else if(src.indexOf('/') === 0 ){
				fullSrc = location.protocol + '//' +  location.host + src;
			} else {				
				var curUrl = location.href;
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
						fullSrc = curUrl.substring(0,b) + '/' + src;
					}					
				}	
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
		console.log(href + " " + href.indexOf(':'));
		if(href.indexOf(':') < 0 && href.indexOf('#') < 0 ){	
			var fullHref = '';
			if(href.indexOf('/') === 0 ){
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
			aNode.attr('href',fullHref);
		}
	}
	
});

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