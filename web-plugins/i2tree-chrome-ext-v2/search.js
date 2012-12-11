jQuery(function() {
	jQuery("#btn_search").button().click(function(){
		//chrome.browserAction.onClicked.addListener(function(tab) 
		{
			var url =  chrome.extension.getURL('search.html') + '#q=' + jQuery('#txt_keywords').val();
			var v = jQuery('#txt_keywords').val();
			chrome.tabs.create({'url': url}, function(tab) {
				
			});
		}
		//);
	});	
	
	if( location.hash != ''){
		var v = location.hash.substring(3);
		jQuery('#txt_keywords').val(v);
	}
});