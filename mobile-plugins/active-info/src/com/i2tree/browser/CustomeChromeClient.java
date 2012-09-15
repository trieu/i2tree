package com.i2tree.browser;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.webkit.WebChromeClient;
import android.webkit.WebView;

public class CustomeChromeClient extends WebChromeClient {
	
	Activity activity;
	public CustomeChromeClient(Activity activity) {
		this.activity = activity;
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

}
