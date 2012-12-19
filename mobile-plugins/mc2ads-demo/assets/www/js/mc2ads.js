
function log(s) {
	$('#logs').html( $('#logs').html() + "<br>" + s);
}

function getLocation()
{
  	if (navigator.geolocation)   {
    	navigator.geolocation.getCurrentPosition(showPosition);
    } else{
 		 alert("Geolocation is not supported by this browser.");
 	}
}

function htmlEncode(value){
    if (value) {
        return jQuery('<div />').text(value).html();
    } else {
        return '';
    }
}
 
function htmlDecode(value) {
    if (value) {
        return $('<div />').html(value).text();
    } else {
        return '';
    }
}

function toDateString(time){
	var date = new Date(parseInt(time)*1000);
	return (date.getMonth().toString() + '/' + date.getDate().toString() + '/' +  date.getFullYear().toString());
}

function showPosition(position)
{
  	var ll = "Latitude: " + position.coords.latitude +  ", Longitude: " + position.coords.longitude;	
  	var msg = "just test ..." + ll;
	//FacebookUserUtil.postToMyWall(msg);
}

function showItem(id){
	if(items[id]){
		$.mobile.changePage("#detail_page", "slidedown");	
		$('#promotion_item_detail > *').remove();
		//items[id].description = htmlDecode( items[id].description );
		
		$('#promotion_item_detail').html( $( "#node_detail_tpl" ).render( items[id] ) );	
		$('#item_description').html(items[id].description);
		
		updateViewCount(id);
	}
}

function refreshData(msg){			
	alert(msg);
	cachedData = false; items = {};			
	getData();
}

function updateViewCount(id){
	var url = 'http://nguyentantrieu.info/i2tree/index.php/mc2ads/update_view_count_ads/'+id;
	$.get(url);
}

var cachedData = false, items = {};
function getData(){
	var url = 'http://nguyentantrieu.info/i2tree/index.php/mc2ads/get_top_ads?t=' + new Date().getTime();
	var params = {};
	$('#item_count_holder').hide();
	$('#items_loader').show();
	
	var handler =  function(rs){
		if(rs.status === 'ok'){
			cachedData = rs;
			var list = rs.data;
			var base_url = rs.base_url;
			var container = $('#promotion_items');
			var new_item_count = 0;
			container.find('li').remove();
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
				var itemNode = $('<li/>').html($( "#node_tpl" ).render( item ));
				container.append(itemNode);
				new_item_count++;
			}
			
			$('#item_count_holder').show();
			$('#new_item_count').html(new_item_count);
			container.listview("refresh");
			$('#items_loader').hide();
		}
		//log(rs.data[0].title);
	};
	if( ! cachedData ){
		$.get(url, params, handler);
	} else {
		handler(cachedData);
	}
}

var cachedData2 = false;
function getDataAdvertiser(){
	var url = 'http://nguyentantrieu.info/i2tree/index.php/mc2ads_advertiser/get_advertisers?t=' + new Date().getTime();
	var params = {};
	
	var handler =  function(rs){
		if(rs.status === 'ok'){
			cachedData2 = rs;
			var list = rs.data;
			var base_url = rs.base_url;
			var container = $('#advertiser_info');					
			container.html('');
			for(var i = 0; i< list.length; i++){
				
				var description = (list[i].description);						
				container.html( description);						
			}
		}
	};
	if( ! cachedData2 ){
		$.get(url, params, handler);
	} else {
		handler(cachedData2);
	}
}


	getData();
	getDataAdvertiser();

