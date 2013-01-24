var currentUrl = location.href;

//------------------ configs for contextual ads ---------------------------
var baseGetAdsUrl = '';
var zones_url_mapper = 
{
	zone1: baseGetAdsUrl + "/AdvertisingHandlerServlet?now=true&demo=true&ts=ads&number=7&ws=json&url=",
	zone2: baseGetAdsUrl + "/AdvertisingHandlerServlet?now=true&demo=true&ts=articles-hmmlda&number=6&ws=json&url=",
	zone3: "",
	zone4: "",
};

//skip domains , not show ads 
var skipDomains = ['twitter.com','facebook.com','google.com'];
var shouldShowAds = jQuery('meta').length > 0;
for(var i in skipDomains){
	if( currentUrl.indexOf(skipDomains[i])>0){
		shouldShowAds = false;
	}
}

//templates for ads banner
var leftBannerContainer = '<div id="left_banner_ads" style="position:absolute; width:150px;height:100%;top:25px;left:2px;padding:5px;background:#FFFFFF; border:2px solid #2266AA; z-index:1000000; color: #666;"><div><span class="ads_header">eClick</span><a href="javascript:void(0)" id="close_ads1">Hide</a></div><div id="ad_simulator_container1" class="ads_container" ></div></div>';
var rightBannerContainer = '<div id="right_banner_ads" style="position:absolute; width:150px;height:100%;top:25px;right:2px;padding:5px;background:#FFFFFF; border:2px solid #2266AA; z-index:1000000; color: #666;"><div><span class="ads_header">eClick(HMM)</span><a href="javascript:void(0)" id="close_ads2">Hide</a><br></div><div id="ad_simulator_container2" class="ads_container" ></div></div>';
var tplAdItem = '<div class="ad_item"><b><a href="<%=link%>" title="<%=content%>" target="_blank" style="text-decoration: underline;color:blue; !important" ><img src="<%=image%>" /><br><%=title%></a></b></div>';
var tplArticleItem = '<div class="article_item"><b><a href="<%=share_url%>" title="<%=title%>" target="_blank" style="text-decoration: underline;color:blue; !important" ><br><%=title%></a> <br> <%=lead%></b></div>';


//------------------ configs for real-time tracking and suggesting ads, behavioural targeting (dev: Trieu) ---------------------------
var shouldDoTracking = false;
var trackedDomains = ['vnexpress.net','thanhnien.com.vn','tuoitre.vn','dantri.com.vn','nguyentantrieu.info','blogspot.com'];
for(var i in trackedDomains){
	if( currentUrl.indexOf(trackedDomains[i])>0){
		shouldDoTracking = true;
	}
}