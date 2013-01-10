
var theHandler = function(response) {		
	var data = JSON.parse(response.data);
	var status = data.status;
	var text = data.text;	
	jQuery("#btn_ad_controler").html(text);
	
};



jQuery("#btn_ad_controler").click(function(){	
	chrome.tabs.getSelected(null, function(tab) {
        chrome.tabs.sendRequest(tab.id, {method : "btn_ad_controler_clicked"}, theHandler);		
    });	
});	


