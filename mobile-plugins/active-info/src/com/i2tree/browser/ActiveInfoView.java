package com.i2tree.browser;

import java.io.IOException;
import java.io.InputStream;
import java.util.Random;

import android.app.Activity;
import android.content.Context;
import android.content.res.AssetManager;
import android.view.Display;
import android.view.WindowManager;
import android.webkit.WebView;

public class ActiveInfoView {
	final String mimeType = "text/html";
	final String encoding = "utf-8";
	
	AssetManager assetManager;
	WebView mWebView;
	Activity activity;

	
//	Random ran = new Random();
//	int r = ran.nextInt(loLPhotosManager.getPhotoNumber()) + 1;
//	loadGaLleryView(r, 6);
	
	public ActiveInfoView(Activity activity, WebView mWebView) {
		this.activity = activity;
		this.assetManager = activity.getAssets();
		this.mWebView = mWebView;
	}
	
	public void callJsFunction(String js){
		this.mWebView.loadUrl("javascript:" + js);
	}

	public void loadHTML() {


		InputStream input;
		String html = "";
		try {
			input = assetManager.open("www/active-info-main.html");
			int size = input.available();
			byte[] buffer = new byte[size];
			input.read(buffer);
			input.close();

			// byte buffer into a string
			html = new String(buffer);
		} catch (IOException e) {
			e.printStackTrace();
		}
		
		mWebView.loadDataWithBaseURL("file:///android_asset/www/", html, mimeType, encoding, "");
	}
	
}
