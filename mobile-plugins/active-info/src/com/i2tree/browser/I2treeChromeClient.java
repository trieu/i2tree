package com.i2tree.browser;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.webkit.GeolocationPermissions.Callback;
import android.webkit.ValueCallback;
import android.webkit.WebChromeClient;
import android.webkit.WebView;

public class I2treeChromeClient extends WebChromeClient implements Callback {
	
	I2treeMainView activity;
	public I2treeChromeClient(I2treeMainView activity) {
		this.activity = activity;
	}
	
	public boolean shouldOverrideUrlLoading(WebView view, String url){
        // do your handling codes here, which url is the requested url
        // probably you need to open that url rather than redirect:
        view.loadUrl(url);
        return false; // then it is not handled by default action
   }
	
	@Override
	public void onGeolocationPermissionsShowPrompt(String origin, Callback callback) {
		// TODO Auto-generated method stub
		super.onGeolocationPermissionsShowPrompt(origin, callback);
		callback.invoke(origin, true, false);
	}
	

	@Override
	public void onProgressChanged(WebView view, int progress) {
		// Return the app name after finish loading
		if (progress == 100) {
			String jsStr = "javascript:(function() { "
					+ " console.log('ok'); " + "})()";
			// mWebView.loadUrl(jsStr);
		}
	}

	@Override
	public boolean onJsAlert(WebView view, String url, String message,
			final android.webkit.JsResult result) {
		new AlertDialog.Builder(activity)
				.setTitle("Notification")
				.setMessage(message)
				.setPositiveButton(android.R.string.ok,
						new AlertDialog.OnClickListener() {
							public void onClick(DialogInterface dialog,
									int which) {
								result.confirm();
							}
						}).setCancelable(false).create().show();

		return true;
	};
	
	// For Android 3.0+
    public void openFileChooser( ValueCallback<Uri> uploadMsg, String acceptType ) 
    {  
    	activity.mUploadMessage = uploadMsg;  
        Intent i = new Intent(Intent.ACTION_GET_CONTENT);  
        i.addCategory(Intent.CATEGORY_OPENABLE);  
        i.setType("image/*");  
        activity.startActivityForResult( Intent.createChooser( i, "Image Browser" ), I2treeMainView.FILECHOOSER_RESULTCODE );  
    }

    // For Android < 3.0
    public void openFileChooser( ValueCallback<Uri> uploadMsg ) 
    {
        openFileChooser( uploadMsg, "" );
    }

	public void invoke(String arg0, boolean arg1, boolean arg2) {
		// TODO Auto-generated method stub
		
	}

}
