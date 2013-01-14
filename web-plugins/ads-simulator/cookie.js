chrome.extension.onRequest.addListener(function(request, sender, sendResponse) {
    if(request === "getFospCookieData") {
       // sendResponse(localStorage["data"]);
		chrome.cookies.getAll({domain :"l.d.eclick.vn", name:"fosp_aid"}, function(cookies){
			console.log(cookies);
			sendResponse(cookies);
		});
    }
});