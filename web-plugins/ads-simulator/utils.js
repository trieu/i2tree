String.prototype.replaceAll = function(stringToFind, stringToReplace) {
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


i2treeUtil.getKeywords = function(){
	var meta = jQuery('meta[name="keywords"]');
	if(meta.length >0 )
		return meta.attr('content');
	return '';
};

i2treeUtil.toAbsoluteHref = function(link, host) {
	var lparts = link.split('/');
	if (/http:|https:|ftp:/.test(lparts[0])) {
		// already abs, return
		return link;
	}

	var i, hparts = host.split('/');
		if (hparts.length > 3) {
		hparts.pop(); // strip trailing thingie, either scriptname or blank 
	}

	if (lparts[0] === '') { // like "/here/dude.png"
		host = hparts[0] + '//' + hparts[2];
		hparts = host.split('/'); // re-split host parts from scheme and domain only
		delete lparts[0];
	}

	for(i = 0; i < lparts.length; i++) {
		if (lparts[i] === '..') {
		  // remove the previous dir level, if exists
		  if (typeof lparts[i - 1] !== 'undefined') { 
			delete lparts[i - 1];
		  } else if (hparts.length > 3) { // at least leave scheme and domain
			hparts.pop(); // stip one dir off the host for each /../
		  }
		  delete lparts[i];
		}
		if(lparts[i] === '.') {
			delete lparts[i];
		}
	}

	// remove deleted
	var newlinkparts = [];
	for (i = 0; i < lparts.length; i++) {
		if (typeof lparts[i] !== 'undefined') {
		  newlinkparts[newlinkparts.length] = lparts[i];
		}
	}

	return hparts.join('/') + '/' + newlinkparts.join('/');

}

if(location.href.indexOf('http') ===  0){
	var baseURL = location.href;
	if(jQuery('base').length == 1){
		baseURL = jQuery('base').attr('href'); 						
	}

	jQuery('img[src],a[href]').mousedown(i2treeUtil.selectedNodeHandler);
	var imgs = jQuery('img:not([src^="http"])');
	imgs.each(function(){
		var img = jQuery(this);
		var src = img.attr('src');

		if(src){
			src = src.trim();
			if( src.indexOf('#') < 0 && src.indexOf(':') < 0 && src.indexOf('//') != 0){
				var fullSrc = i2treeUtil.toAbsoluteHref(src, baseURL);
				img.attr('src',fullSrc);
			} else if(src.indexOf('//') == 0 ){
				var fullSrc = location.protocol + src;
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
			if( href.indexOf('#') < 0 && href.indexOf(':') < 0 && href.indexOf('//') != 0){
				var fullHref = i2treeUtil.toAbsoluteHref(href.trim(), baseURL);
				aNode.attr('href',fullHref);
			} else if(href.indexOf('//') == 0 ){
				var fullHref = location.protocol + href;
				aNode.attr('href',fullHref);
			}
		}		
	});
}

chrome.extension.onRequest.addListener(function(request, sender, sendResponse) {
	//alert('method: '+request.method);
	var m = request.method;	
	if(m === 'btn_ad_controler_clicked'){	
		var node = jQuery('#left_banner_ads, #right_banner_ads');		
		if(node.is(":visible")){
			data.status = 'off';		
			data.text = 'Turn On Ad';
			node.hide();
			localStorage.setItem('btn_ad_controler_clicked', 'off');
		} else {
			data.status = 'on';		
			data.text = 'Turn Off Ad';
			node.show();
			localStorage.setItem('btn_ad_controler_clicked', 'on');
		}		
		sendResponse({'data' : JSON.stringify(data)});
	} else if(m === 'btn_ad_controler_check'){
		var btn_ad_controler_clicked = localStorage.getItem('btn_ad_controler_clicked');		
		var data = {};
		if(btn_ad_controler_clicked === 'off' || btn_ad_controler_clicked == null){
			data.status = 'off';		
			data.text = 'Turn Off Ad';
		}else {
			data.status = 'on';		
			data.text = 'Turn On Ad';
		}	
		sendResponse({'data' : JSON.stringify(data)});
	}else {
		sendResponse({}); // snub them.
	}
});

function htmlEncode(value){
    if (value) {
        return jQuery('<div />').text(value).html();
    } else {
        return '';
    }
}
 
function htmlDecode(value) {
    if (value) {
        return jQuery('<div />').html(value).text();
    } else {
        return '';
    }
}

function toDateString(time){
	var date = new Date(parseInt(time)*1000);
	return (date.getMonth().toString() + '/' + date.getDate().toString() + '/' +  date.getFullYear().toString());
}

(function(){
  var cache = {};
  
  this.tmpl = function tmpl(str, data){
    // Figure out if we're getting a template, or if we need to
    // load the template - and be sure to cache the result.
    var fn = !/\W/.test(str) ?
      cache[str] = cache[str] ||
        tmpl(document.getElementById(str).innerHTML) :
      
      // Generate a reusable function that will serve as a template
      // generator (and which will be cached).
      new Function("obj",
        "var p=[],print=function(){p.push.apply(p,arguments);};" +
        
        // Introduce the data as local variables using with(){}
        "with(obj){p.push('" +
        
        // Convert the template into pure JavaScript
        str
          .replace(/[\r\t\n]/g, " ")
          .split("<%").join("\t")
          .replace(/((^|%>)[^\t]*)'/g, "$1\r")
          .replace(/\t=(.*?)%>/g, "',$1,'")
          .split("\t").join("');")
          .split("%>").join("p.push('")
          .split("\r").join("\\'")
      + "');}return p.join('');");
    
    // Provide some basic currying to the user
    return data ? fn( data ) : fn;
  };
})();

function loadMc2AdsToContainer(){	
	var url = 'http://nguyentantrieu.info/i2tree/index.php/mc2ads/get_top_ads';	
	var container = jQuery('#ad_simulator_container1');
	jQuery.getJSON(url,{},function(rs){
		//alert(data.base_url);
		var list = rs.data;
		var base_url = rs.base_url;

		var c = 0;
		for(var i = 0; i< list.length; i++){
			var item = {};
			item.id = list[i].id;
			item.title = list[i].title ;
			item.image_url = base_url + list[i].image_url.substring(2);
			item.thumbnail_url = base_url + list[i].image_url.substring(2).replace('.','_thumb.');
			
			item.short_description = htmlDecode( list[i].description.substring(0,60) );
			item.description = list[i].description;			
			item.date = toDateString(list[i].creation_time);
			items[item.id] = item;
			var itemNode = tmpl( tplItem, item );
			container.append(itemNode);
			if(++c > 2) break;				
		}			
	});	
}

function loadAdsByContext(){
	var url = baseGetAdsUrl + '/AdvertisingHandlerServlet?demo=true&ts=ads&number=7&ws=json&url=' + location.href;
	var container = [];//jQuery('#content div.right, #content .content-left, #col_right');
	jQuery('#advZoneSticky').before('<div id="ads_micro_hack" style="margin: 10px 0" ></div>');
	var containerAdMicro = jQuery('#ads_micro_hack');
	
	if(container.length === 0 ){
		container = jQuery('#ad_simulator_container1');
	} else {
		jQuery('#left_banner_ads').hide();
	}	
	container.prepend('<a style="text-decoration: underline;color:blue; !important" target="_blank" href="'+url+'" ><b>DEBUG ADS JSON URL</b></a>');
		
	jQuery.getJSON(url,{},function(list){		
		for(var i = 0; i< list.length; i++){
			var item = list[i];	
			if(item.image == null || item.image == ""){
				item.image = 'http://st.eclick.vn/d3/intro/images/graphics/logo_eclick.png';
			}
			var itemNode = jQuery(tmpl( tplAdItem, item ));
			container.prepend(itemNode);
		}	
		containerAdMicro.html(jQuery('#ad_simulator_container1').clone(true));
		containerAdMicro.prepend('<h3 class="ads_header">eClick Ads</h3>');
		jQuery('#left_banner_ads').show();
	});	
	jQuery('#close_ads1').click(function(){
		jQuery('#left_banner_ads').hide();
	});
}

function loadAdsByContextHMMLDA(){
	var url = baseGetAdsUrl + '/AdvertisingHandlerServlet?demo=true&ts=hmmlda&number=6&ws=json&url=' + location.href;
	var container = [];
	
	if(container.length === 0 ){
		container = jQuery('#ad_simulator_container2');
	} else {
		jQuery('#right_banner_ads').hide();
	}	
	container.prepend('<a style="text-decoration: underline;color:blue; !important" target="_blank" href="'+url+'" ><b>DEBUG ADS JSON URL</b></a>');
		
	jQuery.getJSON(url,{},function(list){		
		for(var i = 0; i< list.length; i++){
			var item = list[i];	
			if(item.image == null || item.image == ""){
				item.image = 'http://st.eclick.vn/d3/intro/images/graphics/logo_eclick.png';
			}
			var itemNode = jQuery(tmpl( tplAdItem, item ));
			container.prepend(itemNode);
		}	
		jQuery('#right_banner_ads').show();
	});	
	jQuery('#close_ads2').click(function(){
		jQuery('#right_banner_ads').hide();
	});
}

function doTracking(){
	var fosp_aid = '';
	jQuery(document.cookie.split(';')).each(function(i,e){ 
		var j = e.trim().indexOf('fosp_aid='); 
		if(j>=0) { 
			fosp_aid = e.trim().substring(j+9); 
		}
	});
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
	params.keywords = i2treeUtil.getKeywords();
	params.categories = cates;
		
	var baseUrl = 'http://localhost:10001/log/track/html';
	jQuery.post(baseUrl,params,function(rs){});	
}

var currentUrl = location.href;
var items = {};
var tplItem = '<div style="border-bottom:1px solid;margin: 5px;"><a href="#"><img src="<%=thumbnail_url%>" /><h3><%=title%></h3><p><%=date%></p><p><%=short_description%></p></a></div>';
var ads_html = '<div id="promotion_items" style=";clear:both:padding: 5px;"><a href="http://nguyentantrieu.info/blog/category/mc2ads/" target="_blank"><img src="http://dl.dropbox.com/u/4074962/mc2ads/resources/images/your-ad-here.jpg" /></a></div>';
var ads_container = '<div style="text-align:center;clear:both:padding: 5px;" id="promotion_items"></div>';

//for testing ads
var baseGetAdsUrl = '';
var layout = '<div id="framecontent"><div class="innertube"><h1>eCLick Ads Simulator</h1><h3>ads text here</h3></div></div><div id="maincontent"></div>';
var leftBannerContainer = '<div id="left_banner_ads" style="position:absolute; width:150px;height:100%;top:25px;left:2px;padding:5px;background:#FFFFFF; border:2px solid #2266AA; z-index:1000000; color: #666;"><div><span class="ads_header">eClick</span><a href="javascript:void(0)" id="close_ads1">Hide</a></div><div id="ad_simulator_container1" class="ads_container" ></div></div>';
var rightBannerContainer = '<div id="right_banner_ads" style="position:absolute; width:150px;height:100%;top:25px;right:2px;padding:5px;background:#FFFFFF; border:2px solid #2266AA; z-index:1000000; color: #666;"><div><span class="ads_header">eClick(HMM)</span><a href="javascript:void(0)" id="close_ads2">Hide</a><br></div><div id="ad_simulator_container2" class="ads_container" ></div></div>';
var tplAdItem = '<div class="ad_item"><b><a href="<%=link%>" title="<%=content%>" target="_blank" style="text-decoration: underline;color:blue; !important" ><img src="<%=image%>" /><br><%=title%></a></b></div>';

var initTestAds = (function(){

		jQuery('body').append(leftBannerContainer);
		jQuery('body').append(rightBannerContainer);
		floatingMenu.add('left_banner_ads', { targetLeft: 0, targetTop: 25,  snap: true  });
		floatingMenu.add('right_banner_ads', { targetRight: 0, targetTop: 25,  snap: true  }); 
		jQuery('#left_banner_ads, #right_banner_ads').hide();
		loadAdsByContext();
		loadAdsByContextHMMLDA();
	

	//alert(fosp_aid+' '+url);
});

var skipDomains = ['twitter.com','facebook.com','google.com'];
var shouldShowAds = jQuery('meta').length > 0;
for(var i in skipDomains){
	if( currentUrl.indexOf(skipDomains[i])>0){
		shouldShowAds = false;
	}
}
if( shouldShowAds ){
	initTestAds();
}


var trackedDomains = ['vnexpress.net','thanhnien.com.vn','tuoitre.vn','dantri.com.vn'];
var shouldDoTracking = false;
for(var i in trackedDomains){
	if( currentUrl.indexOf(trackedDomains[i])>0){
		shouldDoTracking = true;
	}
}
if( shouldDoTracking ){
	setTimeout(doTracking, 1000);
}



 

