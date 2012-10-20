jQuery.extend({
  getUrlVars: function(){
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++)
	{
	  hash = hashes[i].split('=');
	  vars.push(hash[0]);
	  vars[hash[0]] = decodeURIComponent(hash[1]);
	}
	return vars;
  },
  getUrlVar: function(name){
	return jQuery.getUrlVars()[name];
  }
});

var check_status = false;
var statusUrl = 'http://nguyentantrieu.info/i2tree/index.php/cloud_storage/check_status';		

function checkLogin(){
	jQuery.get(statusUrl,{},function(rs) {			
		if(rs === 'false'){
			check_status = false;
		} else {
			check_status = true;
			if(autoPost){
				addInfoNode();
			}
		}
	} );
}
checkLogin();


chrome.extension.onRequest.addListener(
	function(request, sender, sendResponse) {		
		{
			jQuery('#selected_html').html(request.html);
			jQuery('#name').html(safeStringForName(request.title));
			jQuery('#title').html(request.title);
			document.title += request.title;
			jQuery('#keywords').html(request.keywords);
		}
	}
);

function popupCenter(pageURL, w, h, top, left, nofocus) {
	if(typeof left === 'undefined' )
		left = (screen.width/2)-(w/2);
	if(typeof top === 'undefined' )
		top = (screen.height/2)-(h/2);
	if(top > 120 ) top -= 70;
	var params = 'menubar=0,resizable=1,toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,'; 
	params = params + ('width='+w+', height='+h+', top='+top+', left='+left);
	var win = window.open (pageURL, "_blank", params);
	if(typeof win.focus === 'function' && !nofocus) {
		win.focus();           
	}
	return win;
}

var autoPost = false;
function addInfoNode(){
	if( ! check_status ) {
		var myWindow = popupCenter(statusUrl + '?web_login=true',960,600,50);	
		var timer = setInterval(function(){
			if(myWindow.closed){
				checkLogin();
				clearInterval(timer);
			}
		}, 500);
		autoPost = true;
		myWindow.focus();
		return;
	}
	jQuery('#ajax_loader').show();
	var f = function(rs){
		jQuery('#ajax_loader').hide();
		if( rs.indexOf('http') >= 0 ){
			jQuery('#published_url').attr('href', rs).text( jQuery('#title').text() );		
			window.location = rs;
		}
	};
	
	var data = {};
	data.html = jQuery('#selected_html').html();
	data.name = jQuery('#name').text();
	data.title = jQuery('#title').text();			
	data.keywords = jQuery('#keywords').text();
	jQuery.post('http://nguyentantrieu.info/i2tree/index.php/cloud_storage/add_info_node',data, f);
}

//vietnamese dumb
var vietnameseSigns = [
	["a","A","e","E","o","O","u","U","i","I","d","D","y","Y"],
	["á","à","?","?","ã","â","?","?","?","?","?","a","?","?","?","?","?"],
	["Á","À","?","?","Ã","Â","?","?","?","?","?","A","?","?","?","?","?"],
	["é","è","?","?","?","ê","?","?","?","?","?"],
	["É","È","?","?","?","Ê","?","?","?","?","?"],
	["ó","ò","?","?","õ","ô","?","?","?","?","?","o","?","?","?","?","?"],
	["Ó","Ò","?","?","Õ","Ô","?","?","?","?","?","O","?","?","?","?","?"],
	["ú","ù","?","?","u","u","?","?","?","?","?"],
	["Ú","Ù","?","?","U","U","?","?","?","?","?"],
	["í","ì","?","?","i"],
	["Í","Ì","?","?","I"],
	["d"],
	["Ð"],
	["ý","?","?","?","?"],
	["Ý","?","?","?","?"]
];

var removeSign = function(str) {
	//Ti?n hành thay th? , l?c b? d?u cho chu?i
	for (var i = 1; i < vietnameseSigns.length; i++) {
		for (var j = 0; j < vietnameseSigns[i].length; j++){						
			str = str.replace( vietnameseSigns[i][j], vietnameseSigns[0][i - 1]);						
		}
	}
	return str;
};		
String.prototype.allTrim = String.prototype.allTrim || function(){
	return this.split(/\-+/).join('-');
};
var safeStringForName = function(str){			
	return removeSign(str).replace(/[^a-z0-9]/gi, '-').allTrim().toLowerCase();
};

jQuery(function() {
	jQuery("#btn_save2dropbox").button().click(addInfoNode);	
});