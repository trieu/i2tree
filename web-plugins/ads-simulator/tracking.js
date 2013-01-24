
shouldDoTracking = false;//TO TEST, COMMENT THIS LINE

if( shouldDoTracking ){
	setTimeout(function(){
		chrome.extension.sendRequest("getFospCookieData", function(response) {
			console.log("response:", response);
			if(response[0]){
				doTracking(response[0].value);	
			}			
		});
	}, 1000);
}

function getKeywords(){
	var meta = jQuery('meta[name="keywords"]');
	if(meta.length >0 )
		return meta.attr('content');
	return '';
};

function doTracking(fosp_aid){		
	var cates = '';
	jQuery('#menu_portal .active a:visible, ul.ulMenu li.liCurrent a:visible:first, ul.ulMenu li.liSecondActive a:visible').each(function(i,e){
		//for VNE only
		cates += (jQuery(e).text().trim() + ',');
	});
	console.log(cates);
	var params = {};
	params.fosp_aid = fosp_aid;
	params.url = location.href;
	params.title = document.title.trim();	
	params.keywords = getKeywords();
	params.categories = cates;
		
	var baseUrl = 'http://localhost:10001/log/track/html';
	jQuery.get(baseUrl,params,function(rs){});	
}