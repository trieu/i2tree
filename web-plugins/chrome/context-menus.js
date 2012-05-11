function genericOnClick(info, tab) {
  //alert("item " + JSON.stringify(info) + " was clicked");
	chrome.tabs.getSelected(null, function(tab) {			
		chrome.tabs.sendRequest(tab.id, {
			method : "getSelectedHtml"				
		}, function(response) {		
			var data = JSON.parse(response.data);
			var selectedHtml = data.html;
			var name = data.name;
			var viewTabUrl = [ chrome.extension.getURL('knowledge-tree.html') ].join('');
			chrome.tabs.create({url : viewTabUrl }, function(tab2) {					
				chrome.tabs.sendRequest(tab2.id, {'html': selectedHtml, 'name' : name});
			});	
		});
	});	
}
chrome.contextMenus.create({"title": "Add to my tree", "contexts":["selection"],"onclick": genericOnClick});