var  tabId = false;

var getSelectedHandler = function(response) {		
	var data = JSON.parse(response.data);
	var selectedHtml = data.html;	
	var title = data.title.trim();	
	var keywords = data.keywords;
	
	var viewTabUrl = [ chrome.extension.getURL('info-node-editor.html') ].join('');
	chrome.tabs.create({url : viewTabUrl }, function(tab2) {
		setTimeout(function(){
			chrome.tabs.sendRequest(tab2.id, {'html': selectedHtml, 'title': title, 'keywords' : keywords });
		}, 666);		
	});	
};
chrome.contextMenus.create(
{
	"title": "Add selected text", 
	"contexts" : [ "selection", "link", "image"],
	"onclick": function(info, tab) {
		//alert("item " + JSON.stringify(info) + " was clicked");
		chrome.tabs.getSelected(null, function(tab) {	
			tabId = tab.id;
			chrome.tabs.sendRequest(tab.id, {method : "getSelectedHtml"}, getSelectedHandler);
		});	
	}
});

var getSelectedImagesHandler = function(response) {		
	var data = JSON.parse(response.data);
	var selectedHtml = data.html;	
	var title = data.title.trim();	
	var keywords = data.keywords;
	
	var viewTabUrl = [ chrome.extension.getURL('image-node-editor.html') ].join('');
	chrome.tabs.create({url : viewTabUrl }, function(tab2) {
		setTimeout(function(){
			chrome.tabs.sendRequest(tab2.id, {'html': selectedHtml, 'title': title, 'keywords' : keywords });
		}, 666);		
	});	
};
chrome.contextMenus.create(
{
	"title": "Add selected image", 
	"contexts" : [ "image"],
	"onclick": function(info, tab) {
		//alert("item " + JSON.stringify(info) + " was clicked");
		chrome.tabs.getSelected(null, function(tab) {	
			tabId = tab.id;
			chrome.tabs.sendRequest(tab.id, {method : "getSelectedHtml"}, getSelectedImagesHandler);
		});	
	}
});