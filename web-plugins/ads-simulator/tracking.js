
var trackedDomains = ['vnexpress.net','thanhnien.com.vn','tuoitre.vn','dantri.com.vn','nguyentantrieu.info','blogspot.com'];
var shouldDoTracking = false;
for(var i in trackedDomains){
	if( currentUrl.indexOf(trackedDomains[i])>0){
		shouldDoTracking = true;
	}
}
if( shouldDoTracking ){
	setTimeout(function(){
		chrome.extension.sendRequest("getFospCookieData", function(response) {
			console.log("response:", response);
			doTracking(response[0].value);
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
	jQuery.post(baseUrl,params,function(rs){});	
}