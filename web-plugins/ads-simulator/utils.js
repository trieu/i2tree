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
	//mobile ads testing
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

function loadAdsFromTestServer(fosp_aid){
	var url = zones_url_mapper.zone1 + location.href;
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
			container.append(itemNode);
		}	
		containerAdMicro.html(jQuery('#ad_simulator_container1').clone(true));
		containerAdMicro.prepend('<h3 class="ads_header">eClick Ads</h3>');
		jQuery('#left_banner_ads').show();
	});	
	jQuery('#close_ads1').click(function(){
		jQuery('#left_banner_ads').hide();
	});
}

function loadAdsByContext(){
	var url = zones_url_mapper.zone1 + location.href;
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
			container.append(itemNode);
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
	var url = zones_url_mapper.zone2 + location.href;
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
			var itemNode = jQuery(tmpl( tplArticleItem, item ));
			container.append(itemNode);
		}	
		jQuery('#right_banner_ads').show();
	});	
	jQuery('#close_ads2').click(function(){
		jQuery('#right_banner_ads').hide();
	});
}


var items = {};
//for testing ads
var layout = '<div id="framecontent"><div class="innertube"><h1>eCLick Ads Simulator</h1><h3>ads text here</h3></div></div><div id="maincontent"></div>';

var initTestAds = function(fosp_aid){

		jQuery('body').append(leftBannerContainer);
		jQuery('body').append(rightBannerContainer);
		floatingMenu.add('left_banner_ads', { targetLeft: 0, targetTop: 25,  snap: true  });
		floatingMenu.add('right_banner_ads', { targetRight: 0, targetTop: 25,  snap: true  }); 
		//jQuery('#left_banner_ads, #right_banner_ads').hide();
		loadAdsFromTestServer(fosp_aid);
		//loadAdsByContextHMMLDA();

};

if( shouldShowAds ){
	//alert(zones_url_mapper.zone1);
	setTimeout(function(){
		chrome.extension.sendRequest("getFospCookieData", function(response) {
			console.log("response:", response);
			if(response[0]){
				var fosp_aid = response[0].value;
				initTestAds(fosp_aid);				
			}			
		});
	}, 100);	
}