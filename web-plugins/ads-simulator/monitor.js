
var detailsRequests = false;
chrome.webRequest.onCompleted.addListener(function(details) {
   // console.log("resource", details);
	detailsRequests = details;
},
// filters
{
urls: [
  "http://*/*","https://*/*"
]
},
[ "responseHeaders"]
);