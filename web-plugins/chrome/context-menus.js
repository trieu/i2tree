
var getSelectedHandler = function(response) {		
	var data = JSON.parse(response.data);
	var selectedHtml = data.html;	
	var title = data.title;
	var keywords = data.keywords;
	var viewTabUrl = [ chrome.extension.getURL('knowledge-tree.html') ].join('');
	chrome.tabs.create({url : viewTabUrl }, function(tab2) {					
		chrome.tabs.sendRequest(tab2.id, {'html': selectedHtml, 'title': title, 'keywords' : keywords });
	});	
};

function genericOnClick(info, tab) {
  //alert("item " + JSON.stringify(info) + " was clicked");
	chrome.tabs.getSelected(null, function(tab) {			
		chrome.tabs.sendRequest(tab.id, {
			method : "getSelectedHtml"				
		}, getSelectedHandler);
	});	
}
var contexts = [ "selection", "link", "image"];
//var contexts = [ "selection" ];
chrome.contextMenus.create({"title": "Add to my tree", "contexts" : contexts,"onclick": genericOnClick});