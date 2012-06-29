
var DropboxPlugin = function() {}

DropboxPlugin.prototype.listFolder = function(directory, successCallback, failureCallback) {
	return PhoneGap.exec(successCallback, failureCallback, 'DropboxPlugin', 'listFolder',[ directory ]); 
};

DropboxPlugin.prototype.logIn = function(successCallback,failureCallback) {
	return PhoneGap.exec(successCallback,failureCallback,'DropboxPlugin','logIn',[]);
};

PhoneGap.addConstructor(function() {
	// Register the javascript plugin with PhoneGap
	PhoneGap.addPlugin('dropboxplugin', new DropboxPlugin());

});